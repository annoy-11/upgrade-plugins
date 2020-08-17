<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: ContactOwner.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Form_ContactOwner extends Engine_Form {

  public function init() {

    //get current logged in user
    $this->setTitle('Send Message to Course Owner')
            ->setAttrib('id', 'courses_contact_owner')
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
    $this->addElement('hidden', 'classroom_owner_id', array('value' => ''));
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
