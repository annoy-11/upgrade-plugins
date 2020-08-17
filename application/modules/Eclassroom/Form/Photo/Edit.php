<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Edit.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Form_Photo_Edit extends Engine_Form {
  public function init() {
    $this->setTitle('Edit Classroom Photo');
    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'filters' => array(
          new Engine_Filter_Censor(),
      ),
    ));
    $this->addElement('Textarea', 'description', array(
      'label' => 'Description',
    ));
    $this->addElement('Button', 'submit', array(
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper'),
      'label' => 'Save Changes',
    ));
    $this->addElement('Cancel', 'cancel', array(
      'prependText' => ' or ',
      'label' => 'cancel',
      'link' => true,
      'href' => '',
      'onclick' => 'parent.Smoothbox.close();',
      'decorators' => array(
          'ViewHelper'
      ),
    ));
    $this->addDisplayGroup(array(
        'submit',
        'cancel'
    ), 'buttons');
  }
}
