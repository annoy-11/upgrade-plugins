<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_IndexController extends Core_Controller_Action_Standard {

  public function inboxAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('messages_conversation')->getInboxPaginator($viewer);
    $paginator->setCurrentPageNumber($this->_getParam('page'));
    Engine_Api::_()->getApi('message', 'sessocialtube')->setUnreadMessage($viewer);
  }

  public function newFriendRequestsAction() {

    $this->view->requestCount = Engine_Api::_()->getDbtable('notifications', 'sessocialtube')->hasNotifications(Engine_Api::_()->user()->getViewer(), 'friend');
  }

  public function newMessagesAction() {
    $this->view->messageCount = Engine_Api::_()->getApi('message', 'sessocialtube')->getMessagesUnreadCount(Engine_Api::_()->user()->getViewer());
  }
  
  public function newUpdatesAction() {
    $this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'sessocialtube')->hasNotifications(Engine_Api::_()->user()->getViewer());
  }

  public function deleteMessageAction() {

    $message_id = $this->getRequest()->getParam('id');
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

    $db = Engine_Api::_()->getDbtable('messages', 'messages')->getAdapter();
    $db->beginTransaction();
    try {
      $recipients = Engine_Api::_()->getItem('messages_conversation', $message_id)->getRecipientsInfo();
      foreach ($recipients as $recipient) {
        if ($viewer_id == $recipient->user_id) {
          $this->view->deleted_conversation_ids[] = $recipient->conversation_id;
          $recipient->inbox_deleted = true;
          $recipient->outbox_deleted = true;
          $recipient->save();
        }
      }
      $db->commit();
    } catch (Exception $e) {
      $db->rollback();
      throw $e;
    }
  }
  
  public function friendshipRequestsAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->friendRequests = $newFriendRequests = Engine_Api::_()->getDbtable('notifications', 'sessocialtube')->getFriendrequestPaginator($viewer);
    $newFriendRequests->setCurrentPageNumber($this->_getParam('page'));
    Engine_Api::_()->getApi('message', 'sessocialtube')->setUnreadFriendRequest($viewer);
  }
  
  public function searchAction() {

    $text = $this->_getParam('text', null);
    if (isset($_COOKIE['sessocialtube_commonsearch']))
      $type = $_COOKIE['sessocialtube_commonsearch'];
    else
      $type = '';

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
  
  public function generalSettingAction() {
    $this->view->settingNavigation = $navigations = Engine_Api::_()->getApi('menus', 'core')->getNavigation('user_settings', array());
    $user = Engine_Api::_()->user()->getViewer();
    if ($user && $user->getIdentity()) {
      if (1 === count(Engine_Api::_()->user()->getSuperAdmins()) && 1 === $user->level_id) {
        foreach ($navigations as $navigation) {
          if ($navigation instanceof Zend_Navigation_Page_Mvc && $navigation->getAction() == 'delete') {
            $navigations->removePage($navigation);
          }
        }
      }
    }
  }

}
