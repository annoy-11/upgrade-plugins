<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Forgot.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Otpsms_Form_Forgot extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Lost Password')
      ->setDescription('If you cannot login because you have forgotten your password, please enter your email address / phone number in the field below.')
      ->setAttrib('id', 'user_form_auth_forgot')
      ;

    // init email
    $this->addElement('Text', 'email', array(
      'label' => 'Email Address / Phone Number',
      'required' => true,
      'allowEmpty' => false,
      'tabindex' => 1,
    ));
    
    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Send OTP',
      'type' => 'submit',
      'ignore' => true,
      'tabindex' => 2,
      'decorators' => array(
        'ViewHelper',
      ),
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => Zend_Registry::get('Zend_Translate')->_(' or '),
      'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'default', true),
      'decorators' => array(
        'ViewHelper',
      ),
    ));
    
    $this->addDisplayGroup(array(
      'submit',
      'cancel'
    ), 'buttons', array(
      'decorators' => array(
        'FormElements',
        'DivDivDivWrapper',
      ),
    ));
  }
}