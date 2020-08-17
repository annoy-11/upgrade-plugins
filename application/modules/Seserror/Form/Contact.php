<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Contact.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_Form_Contact extends Engine_Form
{
  public function init()
  {
    $this->setTitle('Contact Us')
      ->setDescription('_CORE_CONTACT_DESCRIPTION')
      #->setDescription('Thank you for trying out the SE4 Preview! We are using this live demonstration to find and resolve bugs more quickly as we continue to develop SE4. Please note that much of the functionality and front-end layout is still rough. The basic skin you see here will be one of several default skin choices available with SE4 when the final version is released. Our team sincerely appreciates your participation and feedback. Your message will be entered into our internal bug tracking system, so please do not expect a direct reply - although we may contact you with further questions if necessary. Once again, thanks!')
      ->setAction($_SERVER['REQUEST_URI'])
      ;
    
    $this->addElement('Text', 'name', array(
      'label' => 'Name',
      'required' => true,
      'notEmpty' => true,
    ));
    
    $this->addElement('Text', 'email', array(
      'label' => 'Email Address',
      'required' => true,
      'notEmpty' => true,
      'validators' => array(
        'EmailAddress'
      )
    ));
    $this->email->getValidator('EmailAddress')->getHostnameValidator()->setValidateTld(false);
    
    $this->addElement('Textarea', 'body', array(
      'label' => 'Message',
      'required' => true,
      'notEmpty' => true,
    ));

//     $show_captcha = Engine_Api::_()->getApi('settings', 'core')->core_spam_contact;
//     if( $show_captcha && ($show_captcha > 1 || !Engine_Api::_()->user()->getViewer()->getIdentity() ) ) {
//       $this->addElement('captcha', 'captcha', Engine_Api::_()->core()->getCaptchaOptions());
//     }

    $this->addElement('Button', 'submit', array(
      'label' => 'Send Message',
      'type' => 'submit',
      'ignore' => true,
	  'decorators' => array(
      'ViewHelper',
      ),
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'onclick' => 'javascript:parent.Smoothbox.close()',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}