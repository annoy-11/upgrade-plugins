<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Upload.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Form_Photo_Upload extends Engine_Form {

  public function init() {
  
    // Init form
    $this->setTitle('Add New Photos')
        ->setDescription('Choose photos on your computer to add to this album. (2MB maximum)')
        ->setAttrib('id', 'form-upload')
        ->setAttrib('class', 'global_form sespage_form_upload')
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