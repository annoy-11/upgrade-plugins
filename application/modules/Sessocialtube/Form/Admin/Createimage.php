<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Createimage.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_Form_Admin_Createimage extends Engine_Form {
  public function init() {
    $this->setTitle('Upload New Image')
	  ->setDescription("Below, upload new image.")
	  ->setAttrib('id', 'form-create-slide')
	  ->setAttrib('name', 'sessocialtube_create_image')
	  ->setAttrib('enctype', 'multipart/form-data')
	  ->setAttrib('onsubmit', 'return checkValidation();')
	  ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    $this->setMethod('post');
  
    $image_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('headerphoto_id', 0);
    if (!$image_id) {
      $required = false;
      $allowEmpty = true;
    } else {
      $required = false;
      $allowEmpty = true;
    }
		
    $this->addElement('File', 'file', array(
        'allowEmpty' => $allowEmpty,
        'required' => $required,
        'label' => 'Upload Image',
        'description' => 'Upload an image. [Note: Supported extensions are .jpg, .png and .jpeg only.]',
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'manage-photos'), 'admin_default', true),
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}