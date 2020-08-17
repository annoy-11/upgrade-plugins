<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemailverification_IndexController extends Core_Controller_Action_Standard
{
  public function resendAction()
  {

    $token = $this->_getParam('token');

    $userId = Engine_Api::_()->user()->getUserIdFromToken($token);

    $viewer = Engine_Api::_()->user()->getViewer();
//     if( $viewer->getIdentity() || !$userId ) {
//       return $this->_helper->redirector->gotoRoute(array(), 'default', true);
//     }

    $userTable = Engine_Api::_()->getDbtable('users', 'user');
    $user = $userTable->fetchRow($userTable->select()->where('user_id = ?', $userId));

//     if( !$user ) {
//       $this->view->error = 'That email was not found in our records.';
//       return;
//     }
//     if( $user->verified ) {
//       $this->view->error = 'That email has already been verified. You may now login.';
//       return;
//     }

    // resend verify email
    $verifyTable = Engine_Api::_()->getDbtable('verify', 'sesemailverification');
    $verifyRow = $verifyTable->fetchRow($verifyTable->select()->where('user_id = ?', $user->user_id)->limit(1));

    if( !$verifyRow ) {
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $verifyRow = $verifyTable->createRow();
      $verifyRow->user_id = $user->getIdentity();
      $verifyRow->code = md5($user->email
          . $user->creation_date
          . $settings->getSetting('core.secret', 'staticSalt')
          . (string) rand(1000000, 9999999));
      $verifyRow->date = $user->creation_date;
      $verifyRow->save();
    }

    $mailParams = array(
      'host' => $_SERVER['HTTP_HOST'],
      'email' => $user->email,
      'date' => time(),
      'recipient_title' => $user->getTitle(),
      'recipient_link' => $user->getHref(),
      'recipient_photo' => $user->getPhotoUrl('thumb.icon'),
      'queue' => false,
    );

    $mailParams['object_link'] = Zend_Controller_Front::getInstance()->getRouter()->assemble(array(
          'module' => 'sesemailverification',
          'controller' => 'index',
          'action' => 'verify',
        ), 'default', true)
      . '?'
      . http_build_query(array('token' => $token, 'verify' => $verifyRow->code))
      ;

    Engine_Api::_()->getApi('mail', 'core')->sendSystem(
      $user,
      'core_verification',
      $mailParams
    );
    $base_url = ( _ENGINE_SSL ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . Zend_Registry::get('Zend_View')->baseUrl();
    header("Location: ".$base_url);
  }

  public function verifyAction()
  {
    $verify = $this->_getParam('verify');
    $token = $this->_getParam('token');
    $settings = Engine_Api::_()->getApi('settings', 'core');

    // No code or token
    if( !$verify || !$token ) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('The email or verification code was not valid.');
      return;
    }

    // Get verify user
    $userId = Engine_Api::_()->user()->getUserIdFromToken($token);

    $userTable = Engine_Api::_()->getDbtable('users', 'user');
    $user = $userTable->fetchRow($userTable->select()->where('user_id = ?', $userId));

    if( !$user || !$user->getIdentity() ) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('The email does not match an existing user.');
      return;
    }

    $rowExists = Engine_Api::_()->getDbTable('verifications', 'sesemailverification')->rowExists($user->getIdentity());

    $verificationsObj = Engine_Api::_()->getItem('sesemailverification_verification', $rowExists);

    // If the user is already verified, just redirect
    if(!empty($rowExists)) {
      $this->view->status = true;
      return;
    }

    // Get verify row
    $verifyTable = Engine_Api::_()->getDbtable('verify', 'sesemailverification');
    $verifyRow = $verifyTable->fetchRow($verifyTable->select()->where('user_id = ?', $user->getIdentity()));

    if( !$verifyRow || $verifyRow->code != $verify ) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('There is no verification info for that user.');
      return;
    }

    // Process
    $db = $verifyTable->getAdapter();
    $db->beginTransaction();

    try {

      $verifyRow->delete();

      Engine_Api::_()->getDbTable('verifications', 'sesemailverification')->isRowExists($user->getIdentity());

      if( $user->enabled ) {
        Engine_Hooks_Dispatcher::getInstance()->callEvent('onUserEnable', array('user' => $user, 'shouldSendEmail' => false));
      }

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
  }
}
