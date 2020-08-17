<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tellafriend.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Form_Tellafriend extends Engine_Form {

  public function init() {
  
    $this->setTitle('Tell a friend')
        ->setDescription('Please fill the form given below and send it to your friends. Through this you can let them know about this Crowdfunding.')
        ->setAttrib('class', 'global_form')
        ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
            

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_name = "";
    $viewer_email = "";
    if (!empty($viewer->getIdentity())) {
      $viewer_email = $viewer->email;
      $viewer_name = $viewer->getTitle();
    }

    $this->addElement('Text', 'sescrowdfunding_sender_name', array(
      'label' => 'Your Name',
      'allowEmpty' => false,
      'required' => true,
      'value' => $viewer_name,
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
        new Engine_Filter_StringLength(array('max' => '64')),
      )
    ));

    $this->addElement('Text', 'sescrowdfunding_sender_email', array(
      'label' => 'Your Email',
      'allowEmpty' => false,
      'required' => true,
      'value' => $viewer_email,
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
        new Engine_Filter_StringLength(array('max' => '64')),
      )
    ));

    $this->addElement('Text', 'sescrowdfunding_receiverEmails', array(
      'label' => 'To',
      'allowEmpty' => false,
      'required' => true,
      'description' => 'Separate multiple addresses with commas.',
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
      ),
    ));
    $this->sescrowdfunding_receiverEmails->getDecorator("Description")->setOption("placement", "append");
    
    $text_value = Zend_Registry::get('Zend_Translate')->_('Thought you would be interested in this.');
    $this->addElement('textarea', 'sescrowdfunding_message', array(
      'label' => 'Message',
      'required' => true,
      'allowEmpty' => false,
      'value' => $text_value,
      'description' => 'You can send a personal message in the mail.',
      'filters' => array(
          'StripTags',
          new Engine_Filter_HtmlSpecialChars(),
          new Engine_Filter_EnableLinks(),
          new Engine_Filter_Censor(),
      ),
    ));
    $this->sescrowdfunding_message->getDecorator("Description")->setOption("placement", "append");
    
    $this->addElement('Checkbox', 'sescrowdfunding_sendMe', array(
      'label' => "Send a copy to my email address.",
    ));
    
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($viewer_id)) {
      $this->addElement('captcha', 'captcha', array(
        'description' => 'Please type the characters you see in the image.',
        'captcha' => 'image',
        'required' => true,
        'captchaOptions' => array(
          'wordLen' => 6,
          'fontSize' => '30',
          'timeout' => 300,
          'imgDir' => APPLICATION_PATH . '/public/temporary/',
          'imgUrl' => $this->getView()->baseUrl() . '/public/temporary',
          'font' => APPLICATION_PATH . '/application/modules/Core/externals/fonts/arial.ttf'
        )
      ));
      $this->captcha->getDecorator("Description")->setOption("placement", "append");
    }

    $this->addElement('Button', 'send', array(
      'label' => 'Tell a friend',
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
      'onClick' => 'javascript:parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper',
      ),
    ));

    $this->addDisplayGroup(array('send', 'cancel'), 'buttons', array('decorators' => array('FormElements', 'DivDivDivWrapper')));
  }
}