<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ContactOwner.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespage_Form_ContactOwner extends Engine_Form {

  public function init() {

    //get current logged in user
    $this->setTitle('Send Message to Page Owner')
            ->setAttrib('id', 'sespage_contact_owner')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST");
    $this->addElement('Text', 'title', array(
        'label' => 'Title',
        'allowEmpty' => false,
        'required' => true,
    ));
    $this->addElement('Textarea', 'body', array(
        'label' => 'Message',
        'allowEmpty' => false,
        'required' => true,
    ));
    $this->addElement('hidden', 'page_owner_id', array('value' => ''));
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Send',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'href' => '',
        'prependText' => ' or ',
        'onclick' => 'sessmoothboxclose();',
        'decorators' => array(
            'ViewHelper'
        )
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }

}
