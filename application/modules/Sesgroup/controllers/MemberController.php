<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: MemberController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_MemberController extends Core_Controller_Action_Standard {

  public function init() {
    if (0 !== ($group_id = (int) $this->_getParam('group_id')) &&
            null !== ($group = Engine_Api::_()->getItem('sesgroup_group', $group_id))) {
      Engine_Api::_()->core()->setSubject($group);
    }
    $this->_helper->requireUser();
    $this->_helper->requireSubject('sesgroup_group');
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
        // has requested an invite; show cancel invite group
        return $this->_helper->redirector->gotoRoute(array('action' => 'cancel', 'format' => 'smoothbox'));
      }
    }

    // Make form
    $this->view->form = $form = new Sesgroup_Form_Member_Join();

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
        
        if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$subject->getIdentity(), 'type'=>'notification_type','role'=>'new_joinee','notification_type'=>'site_notification', 'user_id' => $owner->getIdentity()))) {
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, 'sesgroup_group_join');
        }
        
        if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$subject->getIdentity(), 'type'=>'notification_type','role'=>'new_joinee','notification_type'=>'email_notification', 'user_id' => $owner->getIdentity()))) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesgroup_group_groupjoined', array('group_title' => $subject->getTitle(), 'sender_title' => $viewer->getOwner()->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }
        
        // Group admin notifications and email work
        $getAllGroupAdmins = Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->getAllGroupAdmins(array('group_id' => $subject->getIdentity(), 'user_id' => $subject->owner_id));
        foreach($getAllGroupAdmins as $getAllGroupAdmin) {
          $groupadmin = Engine_Api::_()->getItem('user', $getAllGroupAdmin->user_id);
          if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$subject->getIdentity(), 'type'=>'notification_type','role'=>'new_joinee','notification_type'=>'site_notification', 'user_id' => $groupadmin->getIdentity()))) {
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, 'sesgroup_group_join');
          }
          if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$subject->getIdentity(), 'type'=>'notification_type','role'=>'new_joinee','notification_type'=>'email_notification', 'user_id' => $groupadmin->getIdentity()))) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesgroup_group_groupjoined', array('group_title' => $subject->getTitle(), 'sender_title' => $viewer->getOwner()->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }

        //Send to all joined members
        $joinedMembers = Engine_Api::_()->sesgroup()->getallJoinedMembers($subject);
        foreach($joinedMembers as $joinedMember) {
          if($joinedMember->user_id == $subject->owner_id) continue;
          $joinedMember = Engine_Api::_()->getItem('user', $joinedMember->user_id);
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, $viewer, $subject, 'sesgroup_gpsijoinedjoin');
          
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesgroup_group_joingroupjoined', array('group_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }
        
        $followerMembers = Engine_Api::_()->getDbTable('followers', 'sesgroup')->getFollowers($subject->getIdentity());
        foreach($followerMembers as $followerMember) {
          if($followerMember->owner_id == $subject->owner_id) continue;
          $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($followerMember, $viewer, $subject, 'sesgroup_gpsifollowedjoin');
          
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesgroup_group_joinedgroupfollowed', array('group_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }

        // Add activity if membership status was not valid from before
        if (!$membership_status) {
          $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
          $action = $activityApi->addActivity($viewer, $subject, 'sesgroup_group_join');
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
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Group joined')),
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
    $this->view->form = $form = new Sesgroup_Form_Member_Request();

    // Process form
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $db = $subject->membership()->getReceiver()->getTable()->getAdapter();
      $db->beginTransaction();

      try {
        $subject->membership()->addMember($viewer)->setUserApproved($viewer);
        $row = Engine_Api::_()->getDbTable('membership','sesgroup')->getRequestInfo(array('resource_id' => $subject->group_id,'user_id' => $viewer->getIdentity()));
        $row->answerques1 = $_POST['answerques1'];
        $row->answerques2 = $_POST['answerques2'];
        $row->answerques3 = $_POST['answerques3'];
        $row->answerques4 = $_POST['answerques4'];
        $row->answerques5 = $_POST['answerques5'];
        $row->save();        
        
        // Add notification
        $notifyApi = Engine_Api::_()->getDbTable('notifications', 'activity');
        $notifyApi->addNotification($subject->getOwner(), $viewer, $subject, 'sesgroup_approve');

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
    $this->view->form = $form = new Sesgroup_Form_Member_Cancel();

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

      $subject = Engine_Api::_()->core()->getSubject('sesgroup_group');
      $db = $subject->membership()->getReceiver()->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $subject->membership()->removeMember($user);

        // Remove the notification?
        $notification = Engine_Api::_()->getDbTable('notifications', 'activity')->getNotificationByObjectAndType(
                $subject->getOwner(), $subject, 'sesgroup_approve');
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
    $this->view->form = $form = new Sesgroup_Form_Member_Leave();

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
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Group left')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function acceptAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject('sesgroup_group')->isValid())
      return;

    // Make form
    $this->view->form = $form = new Sesgroup_Form_Member_Join();

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
        $action = $activityApi->addActivity($viewer, $subject, 'sesgroup_group_join');
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
      //for auto approve group
      Engine_Api::_()->sesgroup()->approveGroup($subject);
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->error = false;
    $message = Zend_Registry::get('Zend_Translate')->_('You have accepted the invite to the group %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;

    if ($this->_helper->contextSwitch->getCurrentContext() == "smoothbox") {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Group invite accepted')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function rejectAction() {
  
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
      
    if (!$this->_helper->requireSubject('sesgroup_group')->isValid())
      return;

    // Make form
    $this->view->form = $form = new Sesgroup_Form_Member_Reject();

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

      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $subject, 'sesgroup_reject');
      
      // Set the request as handled
      $notification = Engine_Api::_()->getDbTable('notifications', 'activity')->getNotificationByObjectAndType(
              $viewer, $subject, 'sesgroup_invite');
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
    $message = Zend_Registry::get('Zend_Translate')->_('You have ignored the invite to the group %s');
    $message = sprintf($message, $subject->__toString());
    $this->view->message = $message;

    if ($this->_helper->contextSwitch->getCurrentContext() == "smoothbox") {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Group invite rejected')),
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

    $group = Engine_Api::_()->core()->getSubject();

    if (!$group->membership()->isMember($user)) {
      throw new Sesgroup_Model_Exception('Cannot remove a non-member');
    }

    // Make form
    $this->view->form = $form = new Sesgroup_Form_Member_Remove();

    // Process form
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $db = $group->membership()->getReceiver()->getTable()->getAdapter();
      $db->beginTransaction();

      try {
        // Remove membership
        $group->membership()->removeMember($user);

        // Remove the notification?
        $notification = Engine_Api::_()->getDbTable('notifications', 'activity')->getNotificationByObjectAndType(
                $group->getOwner(), $group, 'sesgroup_approve');
        if ($notification) {
          $notification->delete();
        }

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //for auto approve group
      Engine_Api::_()->sesgroup()->approveGroup($group);
      
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Group member removed.')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function approveAction() {
    // Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject('sesgroup_group')->isValid())
      return;

    // Get user
    if (0 === ($user_id = (int) $this->_getParam('user_id')) ||
            null === ($user = Engine_Api::_()->getItem('user', $user_id))) {
      return $this->_helper->requireSubject->forward();
    }

    // Make form
    $this->view->form = $form = new Sesgroup_Form_Member_Approve();

    // Process form
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $viewer = Engine_Api::_()->user()->getViewer();
      $subject = Engine_Api::_()->core()->getSubject();
      $db = $subject->membership()->getReceiver()->getTable()->getAdapter();
      $db->beginTransaction();

      try {
        $subject->membership()->setResourceApproved($user);

        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $subject, 'sesgroup_accepted');

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
       //for auto approve group
      Engine_Api::_()->sesgroup()->approveGroup($subject);
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Group joining request approved')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function inviteAction() {
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireSubject('sesgroup_group')->isValid())
      return;
    // @todo auth
    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->group = $group = Engine_Api::_()->core()->getSubject();
    $this->view->viewmore = $isAjax = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $sesgroupMemberTable = Engine_Api::_()->getDbTable('membership', 'sesgroup');
    $selectMember = $sesgroupMemberTable->select()
            ->from($sesgroupMemberTable, 'user_id')
            ->where('user_id != ?', $viewer->getIdentity())
            ->where('resource_id = ?', $group->group_id);
    // Prepare friends
    $friendsTable = Engine_Api::_()->getDbTable('membership', 'user');
    $select = $friendsTable->select()
            ->from($friendsTable, 'user_id')
            ->where('resource_id = ?', $viewer->getIdentity())
            ->where('user_id NOT IN (?)',$selectMember)
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
    $table = $group->getTable();
    $db = $table->getAdapter();
    $db->beginTransaction();

    try {
      $notifyApi = Engine_Api::_()->getDbTable('notifications', 'activity');
      foreach ($_POST['user_id'] as $friend) {
        $friend = Engine_Api::_()->getItem('user',$friend);
        $group->membership()->addMember($friend)->setResourceApproved($friend);
        $db->commit();
        Engine_Db_Table::getDefaultAdapter()->query("UPDATE engine4_sesgroup_membership SET user_approved = 1, resource_approved = 1, active = 1 where resource_id = ".$group->group_id." and user_id = ".$friend->user_id.";");
        $group->member_count++;
        $group->save();
        $notifyApi->addNotification($friend, $viewer, $group, 'sesgroup_invite');
        $groupTitle = '<a href="'.$group->getHref().'">'.$group->getTitle().'</a>';
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($friend, 'notify_sesgroup_group_invite', array('group_name' =>$groupTitle, 'sender_title' => $viewer->getOwner()->getTitle(), 'object_link' => $group->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      }
      echo json_encode(array('status' => 'true'));die;
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  } 
  public function getUserAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $group = Engine_Api::_()->core()->getSubject();
    $text = $this->_getParam('text', null);
    $sesgroupMemberTable = Engine_Api::_()->getDbTable('membership', 'sesgroup');
    $selectMember = $sesgroupMemberTable->select()
            ->from($sesgroupMemberTable, 'user_id')
            ->where('user_id != ?', $viewer->getIdentity())
            ->where('resource_id = ?', $group->group_id);
    // Prepare friends
    $friendsTable = Engine_Api::_()->getDbTable('membership', 'user');
    $select = $friendsTable->select()
            ->from($friendsTable, 'user_id')
            ->where('resource_id = ?', $viewer->getIdentity())
            ->where('user_id NOT IN (?)',$selectMember)
            ->where('active = ?', true);
    $userTable = Engine_Api::_()->getItemTable('user');
    $selectUser = $userTable->select()->where('user_id IN(?)',new Zend_Db_Expr($select))
                  ->where('displayname  LIKE ? ', '%' .$text. '%');
    $members = $userTable->fetchAll($selectUser);
		foreach ($members as $member) {
			$member_icon_photo = $this->view->htmlLink($member->getHref(), $this->view->itemPhoto($member, 'thumb.icon'), array('title' => $member->getTitle(), 'target' => '_parent'));
			$sesdata[] = array(
			'id' => $member->user_id,
			'label' => $member->getTitle(),
			'image' => $member_icon_photo,
			'photo' => $this->view->itemPhoto($member, 'thumb.icon'),
			'title'=>$this->view->htmlLink($member->getHref(), $member->getTitle(), array('title' => $member->getTitle(), 'target' => '_parent'))
			);
		}
		return $this->_helper->json($sesdata);
  }
}
