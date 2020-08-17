<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Sendmail.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Form_Dashboard_Sendmail extends Engine_Form {

  public function init() {

    $translate = Zend_Registry::get('Zend_Translate');

    $this->setTitle('Send Email')->setDescription("Here, you can send message to applicant.");

    $this->addElement('Textarea', 'description', array(
        'label' => 'Message',
        'allowEmpty' => false,
        'required' => true,
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Send',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }
}
