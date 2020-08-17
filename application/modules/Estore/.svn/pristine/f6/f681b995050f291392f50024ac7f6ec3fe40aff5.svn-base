<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: MemberController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_MemberController extends Core_Controller_Action_Standard {

  public function init() {
    if (0 !== ($store_id = (int) $this->_getParam('store_id')) &&
            null !== ($store = Engine_Api::_()->getItem('stores', $store_id))) {
      Engine_Api::_()->core()->setSubject($store);
    }
    $this->_helper->requireUser();
    $this->_helper->requireSubject('stores');
  }

  public function joinAction() {
    // Check resource approval
    $viewer = $this->view->viewer();
    $this->_helper->layout->setLayout('default-simple');
    $subject = Engine_Api::_()->core()->getSubject();
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject()->isValid())
      return;
    if (!$this->_helper->requireAuth()->setAuthParams($subject, $viewer, 'view')->isValid())
      return;

    if ($subject->membership()->isResourceApprovalRequired()) {
      $row = $subject->membership()->getReceiver()
              ->select()
              ->where('resource_id = ?', $subject->getIdentity())
              ->where('user_id = ?', $viewer->getIdentity())
              ->query()
              ->fetch(Zend_Db::FETCH_ASSOC, 0);
      ;

      $dbObj = Engine_Db_Table::getDefaultAdapter();
      $members = $subject>membership()->getMembers();
           $viewer = $this->view->viewer();
              foreach($members as $user){
                if(! $viewer->isSelf($user) ) {
                  if(! $user->membership()->isMember($viewer) ) {
                    if(! $viewer->isBlocked($user) ) {
                      $dbObj->query("INSERT INTO `engine4_user_membership`(`resource_id`, `user_id`, `active`, `resource_approved`, `user_approved`) VALUES (".$viewer->getIdentity().",".$user->getIdentity().",1,1,1)");
                      $dbObj->query("INSERT INTO `engine4_user_membership`( `user_id`,`resource_id`, `active`, `resource_approved`, `user_approved`) VALUES (".$viewer->getIdentity().",".$user->getIdentity().",1,1,1)");
                    }
                  }
                }
              }


      if (empty($row)) {
        // has not yet requested an invite
        return $this->_helper->redirector->gotoRoute(array('action' => 'request', 'format' => 'smoothbox'));
      } elseif ($row['user_approved'] && !$row['resource_approved']) {
        // has requested an invite; show cancel invite store
        return $this->_helper->redirector->gotoRoute(array('action' => 'cancel', 'format' => 'smoothbox'));
      }
    }

    // Make form
    $this->view->form = $form = new Estore_Form_Member_Join();

    // Process form
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $viewer = Engine_Api::_()->user()->getViewer();
      $subject = Engine_Api::_()->core()->getSubject();
      $db = $subject->membership()->getReceiver()->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $membership_status = $subject->membership()->getRow($viewer)->active;
        $subject->membership()->addMember($viewer)->setUserApproved($viewer);
        $row = $subject->membership()->getRow($viewer);
        $row->save();

        $owner = $subject->getOwner();

        if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$subject->getIdentity(), 'type'=>'notification_type','role'=>'new_joinee','notification_type'=>'site_notification', 'user_id' => $owner->getIdentity()))) {
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, 'estore_store_join');
        }

        if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$subject->getIdentity(), 'type'=>'notification_type','role'=>'new_joinee','notification_type'=>'email_notification', 'user_id' => $owner->getIdentity()))) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_estore_store_storejoined', array('store_title' => $subject->getTitle(), 'sender_title' => $viewer->getOwner()->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }

        // Store admin notifications and email work
        $getAllStoreAdmins = Engine_Api::_()->getDbTable('storeroles', 'estore')->getAllStoreAdmins(array('store_id' => $subject->getIdentity(), 'user_id' => $subject->owner_id));
        foreach($getAllStoreAdmins as $getAllStoreAdmin) {
          $storeadmin = Engine_Api::_()->getItem('user', $getAllStoreAdmin->user_id);
          if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$subject->getIdentity(), 'type'=>'notification_type','role'=>'new_joinee','notification_type'=>'site_notification', 'user_id' => $storeadmin->getIdentity()))) {
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, 'estore_store_join');
          }
          if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$subject->getIdentity(), 'type'=>'notification_type','role'=>'new_joinee','notification_type'=>'email_notification', 'user_id' => $storeadmin->getIdentity()))) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_estore_store_storejoined', array('store_title' => $subject->getTitle(), 'sender_title' => $viewer->getOwner()->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }

        //Send to all joined members
        $joinedMembers = Engine_Api::_()->estore()->getallJoinedMembers($subject);
        foreach($joinedMembers as $joinedMember) {
          if($joinedMember->user_id == $subject->owner_id) continue;
          $joinedMember = Engine_Api::_()->getItem('user', $joinedMember->user_id);
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, $viewer, $subject, 'estore_store_bsjoined');

          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_estore_store_joinstorejoined', array('store_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }

        $followerMembers = Engine_Api::_()->getDbTable('followers', 'estore')->getFollowers($subject->getIdentity());
        foreach($followerMembers as $followerMember) {
          if($followerMember->owner_id == $subject->owner_id) continue;
          $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($followerMember, $viewer, $subject, 'estore_store_bsfollwjoin');

          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_estore_store_joinedstorefollowed', array('store_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }

        // Add activity if membership status was not valid from before
        if (!$membership_status) {
          $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
          $action = $activityApi->addActivity($viewer, $subject, 'estore_store_join');
          if ($action) {
            $activityApi->attachActivity($action, $subject);
          }
        }

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Store joined')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function requestAction() {
    // Check resource approval
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();

    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject()->isValid())
      return;
    if (!$this->_helper->requireAuth()->setAuthParams($subject, $viewer, 'view')->isValid())
      return;

    // Make form
    $this->view->form = $form = new Estore_Form_Member_Request();

    // Process form
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $db = $subject->membership()->getReceiver()->getTable()->getAdapter();
      $db->beginTransaction();

      try {
        $subject->membership()->addMember($viewer)->setUserApproved($viewer);

        // Add notification
        $notifyApi = Engine_Api::_()->getDbTable('notifications', 'activity');
        $notifyApi->addNotification($subject->getOwner(), $viewer, $subject, 'estore_approve');

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your invite request has been sent.')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function cancelAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject()->isValid())
      return;

    // Make form
    $this->view->form = $form = new Estore_Form_Member_Cancel();

    // Process form
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $user_id = $this->_getParam('user_id');
      $viewer = Engine_Api::_()->user()->getViewer();
      $subject = Engine_Api::_()->core()->getSubject();
      if (!$subject->authorization()->isAllowed($viewer, 'invite') &&
              $user_id != $viewer->getIdentity() &&
              $user_id) {
        return;
      }

      if ($user_id) {
        $user = Engine_Api::_()->getItem('user', $user_id);
        if (!$user) {
          return;
        }
      } else {
        $user = $viewer;
      }

      $subject = Engine_Api::_()->core()->getSubject('stores');
      $db = $subject->membership()->getReceiver()->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $subject->membership()->removeMember($user);

        // Remove the notification?
        $notification = Engine_Api::_()->getDbTable('notifications', 'activity')->getNotificationByObjectAndType(
                $subject->getOwner(), $subject, 'estore_approve');
        if ($notification) {
          $notification->delete();
        }

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your invite request has been cancelled.')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function leaveAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject()->isValid())
      return;
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();

    if ($subject->isOwner($viewer))
      return;

    // Make form
    $this->view->form = $form = new Estore_Form_Member_Leave();

    // Process form
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $db = $subject->membership()->getReceiver()->getTable()->getAdapter();
      $db->beginTransaction();

      try {
        $subject->membership()->removeMember($viewer);
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Store left')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function acceptAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject('stores')->isValid())
      return;

    // Make form
    $this->view->form = $form = new Estore_Form_Member_Join();

    // Process form
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Method');
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Data');
      return;
    }

    // Process form
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    $db = $subject->membership()->getReceiver()->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $membership_status = $subject->membership()->getRow($viewer)->active;
      $subject->membership()->setUserApproved($viewer);
      $row = $subject->membership()->getRow($viewer);
      $row->save();
      // Add activity
      if (!$membership_status) {
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        $action = $activityApi->addActivity($viewer, $subject, 'estore_store_join');
      }
      $db->commit();

      $dbObj = Engine_Db_Table::getDefaultAdapter();
      $members = $subject>membership()->getMembers();
           $viewer = $this->view->viewer();
              foreach($members as $user){
                if(! $viewer->isSelf($user) ) {
                  if(! $user->membership()->isMember($viewer) ) {
                    if(! $viewer->isBlocked($user) ) {
                      $dbObj->query("INSERT INTO `engine4_user_membership`(`resource_id`, `user_id`, `active`, `resource_approved`, `user_approved`) VALUES (".$viewer->getIdentity().",".$user->getIdentity().",1,1,1)");
                      $dbObj->query("INSERT INTO `engine4_user_membership`( `user_id`,`resource_id`, `active`, `resource_approved`, `user_approved`) VALUES (".$viewer->getIdentity().",".$user->getIdentity().",1,1,1)");
                    }
                  }
                }
              }

    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->error = false;
    $message = Zend_Registry::get('Zend_Translate')->_('You have accepted the invite to the store %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;

    if ($this->_helper->contextSwitch->getCurrentContext() == "smoothbox") {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Store invite accepted')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function rejectAction() {

    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;

    if (!$this->_helper->requireSubject('stores')->isValid())
      return;

    // Make form
    $this->view->form = $form = new Estore_Form_Member_Reject();

    // Process form
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Method');
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      $this->view->status = false;
      $this->view->error = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Invalid Data');
      return;
    }

    // Process form
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    $db = $subject->membership()->getReceiver()->getTable()->getAdapter();
    $db->beginTransaction();

    try {

      $user = Engine_Api::_()->getItem('user', (int) $this->_getParam('user_id'));

      $subject->membership()->removeMember($user);

      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $subject, 'estore_reject');

      // Set the request as handled
      $notification = Engine_Api::_()->getDbTable('notifications', 'activity')->getNotificationByObjectAndType(
              $viewer, $subject, 'estore_invite');
      if ($notification) {
        $notification->mitigated = true;
        $notification->save();
      }

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->error = false;
    $message = Zend_Registry::get('Zend_Translate')->_('You have ignored the invite to the store %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;

    if ($this->_helper->contextSwitch->getCurrentContext() == "smoothbox") {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Store invite rejected')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function removeAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject()->isValid())
      return;

    // Get user
    if (0 === ($user_id = (int) $this->_getParam('user_id')) ||
            null === ($user = Engine_Api::_()->getItem('user', $user_id))) {
      return $this->_helper->requireSubject->forward();
    }

    $store = Engine_Api::_()->core()->getSubject();

    if (!$store->membership()->isMember($user)) {
      throw new Estore_Model_Exception('Cannot remove a non-member');
    }

    // Make form
    $this->view->form = $form = new Estore_Form_Member_Remove();

    // Process form
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $db = $store->membership()->getReceiver()->getTable()->getAdapter();
      $db->beginTransaction();

      try {
        // Remove membership
        $store->membership()->removeMember($user);

        // Remove the notification?
        $notification = Engine_Api::_()->getDbTable('notifications', 'activity')->getNotificationByObjectAndType(
                $store->getOwner(), $store, 'estore_approve');
        if ($notification) {
          $notification->delete();
        }

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Store member removed.')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function approveAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject('stores')->isValid())
      return;

    // Get user
    if (0 === ($user_id = (int) $this->_getParam('user_id')) ||
            null === ($user = Engine_Api::_()->getItem('user', $user_id))) {
      return $this->_helper->requireSubject->forward();
    }

    // Make form
    $this->view->form = $form = new Estore_Form_Member_Approve();

    // Process form
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $viewer = Engine_Api::_()->user()->getViewer();
      $subject = Engine_Api::_()->core()->getSubject();
      $db = $subject->membership()->getReceiver()->getTable()->getAdapter();
      $db->beginTransaction();

      try {
        $subject->membership()->setResourceApproved($user);

        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $subject, 'estore_accepted');

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Store request approved')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function inviteAction() {
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject('stores')->isValid())
      return;
    // @todo auth
    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $this->view->viewmore = $isAjax = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    // Prepare friends
    $friendsTable = Engine_Api::_()->getDbTable('membership', 'user');
    $select = $friendsTable->select()
            ->from($friendsTable, 'user_id')
            ->where('resource_id = ?', $viewer->getIdentity())
            ->where('active = ?', true);
    $userTable = Engine_Api::_()->getItemTable('user');
    $selectUser = $userTable->select()->where('user_id IN(?)',new Zend_Db_Expr($select));
    $this->view->paginator = $paginator = Zend_Paginator::factory($selectUser);
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber(isset($_POST['page']) ? $_POST['page'] : 1);

    // Not posting
    if (!$this->getRequest()->isPost() || $isAjax) {
      return;
    }
    // Process
    try {
      $notifyApi = Engine_Api::_()->getDbTable('notifications', 'activity');
      foreach ($_POST['user_id'] as $friend) {
        $friend = Engine_Api::_()->getItem('user',$friend);
        $notifyApi->addNotification($friend, $viewer, $store, 'estore_invite');
      }
      echo json_encode(array('status' => 'true'));die;
    } catch (Exception $e) {
      throw $e;
    }
  }

}
