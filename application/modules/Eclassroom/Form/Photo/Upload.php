<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Upload.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Form_Photo_Upload extends Engine_Form {

  public function init() {

    // Init form
    $this->setTitle('Add New Photos')
        ->setDescription('Choose photos on your computer to add to this album. (2MB maximum)')
        ->setAttrib('id', 'form-upload')
        ->setAttrib('class', 'global_form eclassroom_form_upload')
        ->setAttrib('name', 'albums_create')
        ->setAttrib('enctype', 'multipart/form-data')
        ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $this->addElement('FancyUpload', 'file');

    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Photos',
      'type' => 'submit',
    ));
  }
}
