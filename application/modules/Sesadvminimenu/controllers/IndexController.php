<?php

class Sesadvminimenu_IndexController extends Core_Controller_Action_Standard
{
  
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

  public function friendshipRequestsAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->friendRequests = $newFriendRequests = Engine_Api::_()->getDbtable('notifications', 'sesadvminimenu')->getFriendrequestPaginator($viewer);
    $newFriendRequests->setCurrentPageNumber($this->_getParam('page'));
    Engine_Api::_()->getApi('message', 'sesadvminimenu')->setUnreadFriendRequest($viewer);
  }
  

  public function inboxAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('messages_conversation')->getInboxPaginator($viewer);
    $paginator->setCurrentPageNumber($this->_getParam('page'));
    Engine_Api::_()->getApi('message', 'sesadvminimenu')->setUnreadMessage($viewer);
  }

  public function newFriendRequestsAction() {

    $this->view->requestCount = Engine_Api::_()->getDbtable('notifications', 'sesadvminimenu')->hasNotifications(Engine_Api::_()->user()->getViewer(), 'friend');
  }

  public function newMessagesAction() {
    $this->view->messageCount = Engine_Api::_()->getApi('message', 'sesadvminimenu')->getMessagesUnreadCount(Engine_Api::_()->user()->getViewer());
  }
  
  public function newUpdatesAction() {
    $this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'sesadvminimenu')->hasNotifications(Engine_Api::_()->user()->getViewer());
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
}
