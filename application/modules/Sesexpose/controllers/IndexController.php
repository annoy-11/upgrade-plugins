<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesexpose_IndexController extends Core_Controller_Action_Standard {

  public function inboxAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('messages_conversation')->getInboxPaginator($viewer);
    $paginator->setCurrentPageNumber($this->_getParam('page'));
    Engine_Api::_()->getApi('message', 'sesexpose')->setUnreadMessage($viewer);
  }

  public function generalSettingAction() {

    //Get user setting navigation menu
    $this->view->settingNavigation = $settingsNavigation = Engine_Api::_()
            ->getApi('menus', 'core')
            ->getNavigation('user_settings', array());

    $user = Engine_Api::_()->user()->getViewer();
    if ($user && $user->getIdentity()) {
      if (1 === count(Engine_Api::_()->user()->getSuperAdmins()) && 1 === $user->level_id) {
        foreach ($settingsNavigation as $page) {
          if ($page instanceof Zend_Navigation_Page_Mvc &&
                  $page->getAction() == 'delete') {
            $settingsNavigation->removePage($page);
          }
        }
      }
    }
  }


  public function friendshipRequestsAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->friendRequests = $newFriendRequests = Engine_Api::_()->getDbtable('notifications', 'sesexpose')->getFriendrequestPaginator($viewer);
    $newFriendRequests->setCurrentPageNumber($this->_getParam('page'));
    Engine_Api::_()->getApi('message', 'sesexpose')->setUnreadFriendRequest($viewer);

    //People You May Know work
    $userIDS = $viewer->membership()->getMembershipsOfIds();
    $userMembershipTable = Engine_Api::_()->getDbtable('membership', 'user');
    $userMembershipTableName = $userMembershipTable->info('name');
    $select_membership = $userMembershipTable->select()
            ->where('resource_id = ?', $viewer->getIdentity());
    $member_results = $userMembershipTable->fetchAll($select_membership);
    foreach($member_results as $member_result) {
      $membershipIDS[] = $member_result->user_id;
    }
    if($membershipIDS) {
    $userTable = Engine_Api::_()->getDbtable('users', 'user');
    $userTableName = $userTable->info('name');
    $select = $userTable->select()
            ->where('user_id <> ?', $viewer->getIdentity())
            ->where('user_id NOT IN (?)', $membershipIDS)
            ->order('user_id DESC');
    $this->view->peopleyoumayknow = $peopleyoumayknow = Zend_Paginator::factory($select);
    $peopleyoumayknow->setCurrentPageNumber($this->_getParam('page'));
    } else {
      $this->view->peopleyoumayknow = 0;
    }
    //People You may know work

  }

  public function newUpdatesAction() {

    $viewer = Engine_Api::_()->user()->getViewer();

    $this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer);
  }

  public function newFriendRequestsAction() {

    $viewer = Engine_Api::_()->user()->getViewer();

    $this->view->requestCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer, 'friend');
  }

  public function newMessagesAction() {
    $this->view->messageCount = Engine_Api::_()->getApi('message', 'sesexpose')->getMessagesUnreadCount(Engine_Api::_()->user()->getViewer());
  }

  public function markallmessageAction() {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    Engine_Api::_()->getDbtable('recipients', 'messages')->update(array('ariana_read' => 1,  'inbox_read' => 1), array('`user_id` = ?' => $viewer_id));

  }

  public function deleteMessageAction() {

    $message_id = $this->getRequest()->getParam('id');
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

    $db = Engine_Api::_()->getDbtable('messages', 'messages')->getAdapter();
    $db->beginTransaction();
    try {
      $recipients = Engine_Api::_()->getItem('messages_conversation', $message_id)->getRecipientsInfo();
      foreach ($recipients as $r) {
        if ($viewer_id == $r->user_id) {
          $this->view->deleted_conversation_ids[] = $r->conversation_id;
          $r->inbox_deleted = true;
          $r->outbox_deleted = true;
          $r->save();
        }
      }

      $db->commit();
    } catch (Exception $e) {
      $db->rollback();
      throw $e;
    }
  }

  public function searchAction() {

    $text = $this->_getParam('text', null);

    $type = $this->_getParam('type', '');

    $table = Engine_Api::_()->getDbtable('search', 'core');
    $select = $table->select()->where('title LIKE ? OR description LIKE ? OR keywords LIKE ? OR hidden LIKE ?', '%' . $text . '%')->order('id DESC');
    if ($type != 'Everywhere' && $type != '')
      $select->where('type =?', $type);
    $select->limit('10');

    $results = Zend_Paginator::factory($select);
    foreach ($results as $result) {
      $itemType = $result->type;
      if (Engine_Api::_()->hasItemType($itemType)) {
        if ($itemType == 'sesblog')
          continue;
        $item = Engine_Api::_()->getItem($itemType, $result->id);
        $item_type = ucfirst($item->getShortType());
        $photo_icon_photo = $this->view->itemPhoto($item, 'thumb.icon');
        $data[] = array(
            'id' => $result->id,
            'label' => $item->getTitle(),
            'photo' => $photo_icon_photo,
            'url' => $item->getHref(),
            'resource_type' => $item_type,
        );
      }
    }
    $data[] = array(
        'id' => 'show_all',
        'label' => $text,
        'url' => 'all',
        'resource_type' => '',
    );
    return $this->_helper->json($data);
  }
}
