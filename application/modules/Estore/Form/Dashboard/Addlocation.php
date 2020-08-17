<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Addlocation.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Dashboard_Addlocation extends Engine_Form {

  public function init() {

    $this->setTitle('Add New Location')
            ->setAttrib('id', 'estore_add_location')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST")
            ->setAttrib('class', 'global_form estore_smoothbox_create');

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $actionName = $request->getActionName();
    if ($actionName == 'edit-location') {
      $location = Engine_Api::_()->getItem('estore_location', $request->getParam('location_id'));
    }

    $locale = Zend_Registry::get('Zend_Translate')->getLocale();
    $territories = Zend_Locale::getTranslationList('territory', $locale, 2);
    asort($territories);
    $countrySelect = '';
    $countrySelected = '';
    if (count($territories)) {
      $countrySelect = '<option value="">Choose Country</option>';
      if (isset($location)) {
        $store = $location;
        $itemlocation = Engine_Api::_()->getDbTable('locations', 'estore')->getLocationData(array('location_id' => $location->location_id));
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
    $this->addElement('dummy', 'store_location', array(
        'decorators' => array(array('ViewScript', array(
                    'viewScript' => 'application/modules/Estore/views/scripts/_location.tpl',
                    'class' => 'form element',
                    'store' => isset($store) ? $store : '',
                    'countrySelect' => $countrySelect,
                    'itemlocation' => isset($itemlocation) ? $itemlocation : '',
                )))
    ));
    if (!isset($location) || (isset($location) && !$location->is_default)) {
      $this->addElement('Checkbox', 'is_default', array(
          'label' => 'Yes, Make this location as Primary .'
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
