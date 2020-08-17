<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Addlocation.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Form_Dashboard_Addlocation extends Engine_Form {

  public function init() {

    $this->setTitle('Add New Location')
            ->setAttrib('id', 'classroom_add_location')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST")
            ->setAttrib('class', 'global_form eclassroom_smoothbox_create');

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $actionName = $request->getActionName();
    if ($actionName == 'edit-location') {
      $location = Engine_Api::_()->getItem('eclassroom_location', $request->getParam('location_id'));
    }
    $translate = Zend_Registry::get('Zend_Translate');
    $locale = $translate->getLocale();
    $territories = Zend_Locale::getTranslationList('territory', $locale, 2);
    asort($territories);
    $countrySelect = '';
    $countrySelected = '';
    if (count($territories)) {
      $countrySelect = '<option value="'.$translate->translate('Choose Country').'"></option>';
      if (isset($location)) {
        $classroom = $location;
        $itemlocation = Engine_Api::_()->getDbTable('locations', 'eclassroom')->getLocationData(array('location_id' => $location->location_id));
        if ($itemlocation)
          $countrySelected = $itemlocation->country;
      }
      foreach ($territories as $key => $valCon) {
        if ($valCon == $countrySelected)
          $countrySelect .= '<option value="' . $valCon . '" selected >' . $valCon . '</option>';
        else
          $countrySelect .= '<option value="' . $valCon . '" >' . $valCon . '</option>';
      }
    }
    $this->addElement('Text', 'title', array(
        'label' => 'Location Title',
        'allowEmpty' => true,
        'required' => false,
        'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 64)),
        ),
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
        ),
    ));
    $this->addElement('dummy', 'classroom_location', array(
        'decorators' => array(array('ViewScript', array(
                    'viewScript' => 'application/modules/Eclassroom/views/scripts/_location.tpl',
                    'class' => 'form element',
                    'classroom' => isset($classroom) ? $classroom : '',
                    'countrySelect' => $countrySelect,
                    'itemlocation' => isset($itemlocation) ? $itemlocation : '',
                )))
    ));
    if (!isset($location) || (isset($location) && !$location->is_default)) {
      $this->addElement('Checkbox', 'is_default', array(
          'label' => 'Yes, Make this location as Primary.'
      ));
    }
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Add',
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
