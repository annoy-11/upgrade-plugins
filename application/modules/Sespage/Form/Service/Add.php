<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Form_Service_Add extends Engine_Form {

  public function init() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    $service_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('service_id');
    
    $page_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('page_id');
    
    $this->setMethod('POST')
          ->setAttrib('name', 'sespageservice_addservice')
          ->setAttrib('class', 'sespageservice_formcheck global_form');

    $this->addElement('File', 'photo_id', array(
        'label' => 'Add Photo',
        'placeholder' => "Add a photo for the service.",
    ));
    $this->photo_id->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');
    $service_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('service_id', null);
    $service = Engine_Api::_()->getItem('sespage_service', $service_id);
    $photo_id = 0;
    if (isset($service->photo_id))
      $photo_id = $service->photo_id;
    if ($photo_id && $service) {
      $path = Engine_Api::_()->storage()->get($photo_id, '')->getPhotoUrl();
      if (!empty($path)) {
        $this->addElement('Image', 'profile_photo_preview', array(
            'label' => 'Service Photo Preview',
            'src' => $path,
            'width' => 100,
            'height' => 100,
        ));
      }
    }
    if ($photo_id) {
      $this->addElement('Checkbox', 'remove_profilecover', array(
          'label' => 'Yes, remove service photo.'
      ));
    }
    
    $this->addElement('Text', "title", array(
      'label' => 'Service Name',
      'placeholder' => "Choose a name for your service",
      'allowEmpty' => false,
      'required' => true,
    ));
    
    $this->addElement('Text', "price", array(
      'label' => 'Price (Optional)',
      'placeholder' => "Add a price",
      'allowEmpty' => true,
      'required' => false,
    ));

    $this->addElement('Textarea', "description", array(
      'label' => 'Description',
      'placeholder' => "Tell people what's included",
      'maxlength' => '500',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
          'StripTags',
          new Engine_Filter_Censor(),
          new Engine_Filter_StringLength(array('max' => '500')),
          new Engine_Filter_EnableLinks(),
      ),
    ));
    
    
    $this->addElement('Text', "duration", array(
      'label' => 'Duration (Optional)',
      'allowEmpty' => true,
      'required' => false,
    ));
    $this->addElement('Select', 'duration_type', array(
      'multiOptions' => array(
        'minutes' => "Minutes",
        'hours' => "Hours",
      ),
      'value' => 'minutes',
    ));

    
    
    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Save',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'Cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'javascript:sessmoothboxclose();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
