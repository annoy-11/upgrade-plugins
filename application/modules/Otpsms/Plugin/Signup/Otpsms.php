<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Otpsms.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Otpsms_Plugin_Signup_Otpsms extends Core_Plugin_FormSequence_Abstract
{

  protected $_name = 'otpsms';
  protected $_formClass = 'Otpsms_Form_Signup_Otpsms';
  protected $_script = array('signup/form/otpsms.tpl', 'otpsms');
  protected $_adminFormClass = 'Otpsms_Form_Admin_Signup_Otpsms';
  protected $_adminScript = array('admin-signup/otpsms.tpl', 'otpsms');
  public $email = null;

  public function init()
  {
    $accountSession = new Zend_Session_Namespace('User_Plugin_Signup_Account');
    $active = true;
    if( $accountSession->active ) {
      $request = Zend_Controller_Front::getInstance()->getRequest();
      $active = $request->isPost() && $request->getParam("phone_number");
      $this->setActive($active);
    }
  }

  public function onView()
  {
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null; 
    $canSkip = new Zend_Session_Namespace('Otpsms_SkipEnable');
    $canSkip->skip = false;
    $otpsmsSession = new Zend_Session_Namespace('Otpsms_Verification');
    $this->view->phone_number = $phone_number = $otpsmsSession->phone_number;
    $settings = Engine_Api::_()->getApi('settings', 'core');
     $suration = $settings->getSetting("otpsms.duration",600);
    $timestring = Engine_Api::_()->otpsms()->secondsToTime($suration);
    $this->getForm()->setDescription($view->translate('Enter the verification code you have received on %s.<br> <b>Note:</b> OTP Code is valid for %s.',$this->view->phone_number,$timestring));
    $this->getForm()->loadDefaultDecorators();
    $this->getForm()->getDecorator('Description')->setOption('escape', false);
    
    if( empty($phone_number) ) {
      //return empty form
      $canSkip->skip = true;
      $this->getForm()->setTitle('')->setDescription('');
      $this->getForm()->removeElement('code');
      $this->getForm()->removeElement('submit');
      $this->getForm()->removeElement('resend');
      return;
    }

    if( empty($otpsmsSession->code)){
      //generate code
      $code = Engine_Api::_()->otpsms()->generateCode();
      $otpsmsSession->code = $code;
      $otpsmsSession->creation_time = time();
      //send code to mobile

      Engine_Api::_()->otpsms()->sendMessage($phone_number, $code,$type = "signup_template");
    }
  }

  public function onSubmit(Zend_Controller_Request_Abstract $request)
  {
    $canSkip = new Zend_Session_Namespace('Otpsms_SkipEnable');
    if($canSkip->skip){
      $this->setActive(false);
      $this->onSubmitIsValid();
      $canSkip->skip = false;
    }else{
      $inputcode = $request->getParam("code");
      if($this->getForm()->isValid($request->getPost())){
        $otpsmsSession = new Zend_Session_Namespace('Otpsms_Verification');
        $code = $otpsmsSession->code;
        $expiretime = Engine_Api::_()->getApi('settings', 'core')->getSetting("otpsms.duration",600);
        $codeexpirytime = time() - $expiretime;
        if($code != $inputcode){
          $this->getForm()->addError("The OTP code you entered is invalid. Please enter the correct OTP code.");
          $this->getSession()->active = true;
        }else if($otpsmsSession->creation_time < $codeexpirytime){
          $this->getForm()->addError("The OTP code you entered has expired. Please click on'RESEND' button to get new OTP code.");
          $this->getSession()->active = true;
        }else{
          $this->setActive(false);
          $this->onSubmitIsValid();
          //clear session
          $otpsmsSession->unsetAll();
        }
      }
    }
  }

  public function onAdminProcess($form)
  {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $values = $form->getValues();
    $settings->user_signup = $values;
    $step_table = Engine_Api::_()->getDbtable('signup', 'user');
    $step_row = $step_table->fetchRow($step_table->select()->where('class = ?', 'Otpsms_Plugin_Signup_Otpsms'));
    $step_row->enable = $values['enable'] ? 1 : 0;
    $step_row->save();
    $form->addNotice('Your changes have been saved.');
  }

}
