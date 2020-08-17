<?php

/**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesqa
 * @copyright  Copyright 2014-2020 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Locationedit.php 2016-07-23 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
class Sesqa_Form_Locationedit extends Engine_Form {

  public function init() {
    $action = Zend_Controller_Front::getInstance()->getRequest()->getParams();
      $this->setTitle('Edit Location')->setDescription('Choose the location.');
    
       if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_enable_location', 1)) {
    
      $optionsenableglotion = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('optionsenableglotion','a:6:{i:0;s:7:"country";i:1;s:5:"state";i:2;s:4:"city";i:3;s:3:"zip";i:4;s:3:"lat";i:5;s:3:"lng";}'));
      
      $locationEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_location_mandatory','1');
      if($locationEnable == 1){
        $required = true; 
        $allowEmpty = false;
      }else{
        $required = false;  
        $allowEmpty = true; 
      }
      
      $this->addElement('Text', 'location', array(
          'label' => 'Location',
          'id' =>'locationSesList',
          'required'=>$required,
          'allowEmpty'=>$allowEmpty,
          'filters' => array(
              new Engine_Filter_Censor(),
              new Engine_Filter_HtmlSpecialChars(),
          ),
      ));

      if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) {
        if(in_array('country', $optionsenableglotion)) {
          $this->addElement('Text', 'country', array(
            'label' => 'Country',
          ));
        }
        if(in_array('state', $optionsenableglotion)) {
          $this->addElement('Text', 'state', array(
            'label' => 'State',
          ));
        }
        if(in_array('city', $optionsenableglotion)) {
          $this->addElement('Text', 'city', array(
            'label' => 'City',
          ));
        }
        if(in_array('zip', $optionsenableglotion)) {
          $this->addElement('Text', 'zip', array(
            'label' => 'Zip',
          ));
        }
      }
      $this->addElement('Text', 'lat', array(
        'label' => 'Latitude',
        'id' => 'latSesList',
      ));
      $this->addElement('Text', 'lng', array(
        'label' => 'Longitude',
        'id' => 'lngSesList',
      ));

      $this->addElement('dummy', 'map-canvas', array());
      $this->addElement('dummy', 'ses_location', array('content'));
    }
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Location',
        'type' => 'submit',
        'ignore' => true,
    ));
  }

}
