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
class Otpsms_Form_Signup_Otpsms extends Engine_Form
{
  public function init()
  {
    parent::init();
      $this->setAttrib('id', 'otpsms_signup_verify')
        ->setTitle('Validate OTP (One Time Password)');

      //set timer for login otp
      $expiretime = Engine_Api::_()->getApi('settings', 'core')->getSetting("otpsms.duration",600);

      $endtime = date('Y-m-d H:i:s',strtotime('+'.Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.duration',600).' seconds'));


      $time = Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.duration',600);
      $minutes = floor($time / 60);
      $time -= $minutes * 60;

      $seconds = floor($time);
      $time -= $seconds;

      $endtimeMin = ($minutes < 10 ? "0".$minutes : $minutes).':'.($seconds < 10 ? "0".$seconds : $seconds);

      $html = "Expire in <span class='otpsms_timer_class' data-time='".$expiretime."' data-endtime='".$endtime."' data-created=''>".$endtimeMin."</span>";
      $this ->setDescription($html);
      $this->loadDefaultDecorators();
      $this->getDecorator('Description')->setOption('escape', false);

      // init password
      $this->addElement('Text', 'code', array(
        'label' => 'OTP',
				'placeholder' => 'OTP',
        'required' => true,
        'allowEmpty' => false,
        'validators' => array(
          array('NotEmpty', true),
        ),
        'tabindex' => 1,
      ));
  
      // Init submit
      $this->addElement('Button', 'submit', array(
        'label' => 'Verify',
        'type' => 'submit',
        'ignore' => true,
        'tabindex' => 3,
        'decorators' => array(
          'ViewHelper',
        ),
      ));
      
      $this->addElement('Hidden','email_data',array('order'=>'888'));
      
      $this->addElement('Button', 'resend', array(
        'label' => 'Resend',
        'onClick' => 'resendOtpCode(this);',
        'prependText' => Zend_Registry::get('Zend_Translate')->_(' or '),
        'decorators' => array(
          'ViewHelper',
        ),
      ));
  
      $this->addDisplayGroup(array(
        'submit',
        'resend'
        ), 'buttons', array(
        'decorators' => array(
          'FormElements',
          'DivDivDivWrapper',
        ),
      ));
  }

}
