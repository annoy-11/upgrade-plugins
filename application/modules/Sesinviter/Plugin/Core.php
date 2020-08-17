<?php

class Sesinviter_Plugin_Core extends Zend_Controller_Plugin_Abstract {


  public function routeShutdown(Zend_Controller_Request_Abstract $request) {

    $module = $request->getModuleName();
    $controller = $request->getControllerName();
    $action = $request->getActionName();

    if ($module == "invite" && $controller == "index" && $action == "index") {
      $request->setModuleName('sesinviter');
      $request->setControllerName('index');
      $request->setActionName('invite');
    }

  }

  public function onUserCreateAfter($event) {

    $user = $event->getPayload();

    $getAlreadyEmail = Engine_Api::_()->getDbtable('invites', 'sesinviter')->getInvitationEmail($user->email);

    if(!empty($getAlreadyEmail)) {

        //referrers work
        $session = new Zend_Session_Namespace('sesinviter_affiliate_signup');
        if (isset($session->user_id) && !empty($session->user_id)) {
            $userId = $session->user_id;
            $invite_id = Engine_Api::_()->getDbtable('invites', 'sesinviter')->getAlreadyEmail($userId, $user->email);
            if(!empty($invite_id)) {
                $invite = Engine_Api::_()->getItem('sesinviter_invite', $invite_id);
                $invite->new_user_id = $user->user_id;
                $invite->save();
                unset($session->user_id);
            }
        } else {
            $table = Engine_Api::_()->getDbtable('invites', 'sesinviter');
            $table->update(array('new_user_id' => $user->user_id), array('recipient_email = ?' => $user->email));
        }

      $viewer = Engine_Api::_()->getItem('user', $getAlreadyEmail);
      // Process
      $db = Engine_Api::_()->getDbtable('membership', 'user')->getAdapter();
      $db->beginTransaction();

      try {

        // send request
        $user->membership()->addMember($viewer)->setUserApproved($viewer);

        if( !$viewer->membership()->isUserApprovalRequired() && !$viewer->membership()->isReciprocal() ) {
          // if one way friendship and verification not required

          // Add activity
          Engine_Api::_()->getDbtable('actions', 'activity')
              ->addActivity($viewer, $user, 'friends_follow', '{item:$subject} is now following {item:$object}.');

          // Add notification
          Engine_Api::_()->getDbtable('notifications', 'activity')
              ->addNotification($user, $viewer, $viewer, 'friend_follow');

          $message = Zend_Registry::get('Zend_Translate')->_("You are now following this member.");

        } else if( !$viewer->membership()->isUserApprovalRequired() && $viewer->membership()->isReciprocal() ){
          // if two way friendship and verification not required

          // Add activity
          Engine_Api::_()->getDbtable('actions', 'activity')
              ->addActivity($user, $viewer, 'friends', '{item:$object} is now friends with {item:$subject}.');
          Engine_Api::_()->getDbtable('actions', 'activity')
              ->addActivity($viewer, $user, 'friends', '{item:$object} is now friends with {item:$subject}.');

          // Add notification
          Engine_Api::_()->getDbtable('notifications', 'activity')
              ->addNotification($user, $viewer, $user, 'friend_accepted');

          $message = Zend_Registry::get('Zend_Translate')->_("You are now friends with this member.");

        } else if( !$user->membership()->isReciprocal() ) {
          // if one way friendship and verification required

          // Add notification
          Engine_Api::_()->getDbtable('notifications', 'activity')
              ->addNotification($user, $viewer, $user, 'friend_follow_request');

          $message = Zend_Registry::get('Zend_Translate')->_("Your friend request has been sent.");

        } else if( $user->membership()->isReciprocal() ) {
          // if two way friendship and verification required

          // Add notification
          Engine_Api::_()->getDbtable('notifications', 'activity')
              ->addNotification($user, $viewer, $user, 'friend_request');

          $message = Zend_Registry::get('Zend_Translate')->_("Your friend request has been sent.");
        }
        $db->commit();
      } catch( Exception $e ) {
  //       $db->rollBack();
  //
  //       $this->view->status = false;
  //       $this->view->error = Zend_Registry::get('Zend_Translate')->_('An error has occurred.');
  //       $this->view->exception = $e->__toString();
  //       return;
      }
    }
  }
}
