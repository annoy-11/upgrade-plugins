<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Add.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Form_Service_Add extends Engine_Form {

  public function init() {
    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    $service_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('service_id');
    $classroom_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('classroom_id');
    $this->setMethod('POST')
          ->setAttrib('name', 'classroomservice_addservice')
          ->setAttrib('class', 'classroomservice_formcheck global_form');
    $translate = Zend_Registry::get('Zend_Translate');
    $this->addElement('File', 'photo_id', array(
        'label' => $translate->translate('Add Photo'),
        'placeholder' => $translate->translate('Add a photo for the service.'),
    ));
    $this->photo_id->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');
    $service_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('service_id', null);
    $service = Engine_Api::_()->getItem('eclassroom_service', $service_id);
    $photo_id = 0;
    if (isset($service->photo_id))
      $photo_id = $service->photo_id;
    if ($photo_id && $service) {
      $path = Engine_Api::_()->storage()->get($photo_id, '')->getPhotoUrl();
      if (!empty($path)) {
        $this->addElement('Image', 'profile_photo_preview', array(
            'label' => $translate->translate('Service Photo Preview'),
            'src' => $path,
            'width' => 100,
            'height' => 100,
        ));
      }
    }
    if ($photo_id) {
      $this->addElement('Checkbox', 'remove_profilecover', array(
          'label' => $translate->translate('Yes, remove service photo.')
      ));
    }

    $this->addElement('Text', "title", array(
      'label' => $translate->translate('Service Name'),
      'placeholder' => $translate->translate('Choose a name for your service'),
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Text', "price", array(
      'label' => $translate->translate('Price (Optional)'),
      'placeholder' => $translate->translate('Add a price'),
      'allowEmpty' => true,
      'required' => false,
    ));

    $this->addElement('Textarea', "description", array(
      'label' => $translate->translate('Description'),
      'placeholder' => $translate->translate('Tell people what\'s included'),
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
      'label' => $translate->translate('Duration (Optional)'),
      'allowEmpty' => true,
      'required' => false,
    ));
    $this->addElement('Select', 'duration_type', array(
      'multiOptions' => array(
        'minutes' => $translate->translate('Minutes'),
        'hours' => $translate->translate('Hours'),
      ),
      'value' => 'minutes',
    ));
    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => $translate->translate('Save'),
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));
    $this->addElement('Cancel', 'cancel', array(
      'label' => $translate->translate('Cancel'),
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
