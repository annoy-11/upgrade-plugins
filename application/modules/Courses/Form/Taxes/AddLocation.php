<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AddLocation.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Taxes_AddLocation extends Engine_Form {

  public function init() {
      $this->setTitle('Add Location')
            ->setMethod('post')
            ->setAttrib('class', 'global_form_box global_form');
      $this->addElement('Select', 'country_id', array(
          'label' => 'Country',
          'required' => true,
          'validators' => array(
              array('NotEmpty', true),
          ),
      ));
     $this->addElement('Radio', 'location_type', array(
          'label' => 'Enable Tax For All Locations',
          'multiOptions' => array("1" => "Yes", "0" => "No"),
          'value' => '0',
      ));

      $this->addElement('Multiselect', 'state_id', array(
          //'allowEmpty' => true,
          //'required' => false,
          'label' => 'States',
          'description' => '',
          'RegisterInArrayValidator' => false,
      ));

      $this->addElement('Select', 'tax_type', array(
          'label' => 'Tax Type',
          'multiOptions' => array("0" => "Fixed", "1" => "Percent"),
      ));
      $locale = Zend_Registry::get('Locale');
      $currencyName = Zend_Locale_Data::getContent($locale, 'nametocurrency', Engine_Api::_()->courses()->defaultCurrency());
      $this->addElement('Text', 'fixed_price', array(
          'label' => sprintf(Zend_Registry::get('Zend_Translate')->_('Price (%s)'), $currencyName),
          'allowEmpty' => false,
          'value' => '0',
          'filters' => array(
              'StripTags',
              new Engine_Filter_Censor(),
          ),
      ));
      $this->addElement('Text', 'percentage_price', array(
          'label' => 'Price (%)',
          'allowEmpty' => false,
          'value' => '0',
          'filters' => array(
              'StripTags',
              new Engine_Filter_Censor(),
          ),
      ));


    $this->addElement('Radio', 'status', array(
          'label' => 'Status',
          'multiOptions' => array('1'=>'Yes','0'=>'No'),
          'value'=>1,
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Add Location',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
