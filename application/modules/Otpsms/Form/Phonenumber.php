<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Phonenumber.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_Form_Phonenumber extends Engine_Form
{
  public function init()
  {
    $this->setAttrib('id', 'add_number_otpsms');
    $this->setTitle( 'Add Phone Number')
        ->setDescription('');
    // init email
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $countries = Engine_Api::_()->otpsms()->getCountryCodes();
    $allowedCountries = $settings->getSetting('otpsms_allowed_countries');
    $countriesArray = array();
    $defaultCountry = $settings->getSetting('otpsms.default.countries','US');
    foreach ($countries as $code => $country) {
      $countryName = ucwords(strtolower($country["name"]));
      if($code == $defaultCountry)
        $defaultCountry = $country['code'];
      if(count($allowedCountries) && !in_array($code,$allowedCountries))
        continue;
      $countriesArray[$country["code"]] = "+".$country["code"];
    }
   
    $this->addElement('Select', 'country_code', array(
                'label' => 'Country',
                'description' => 'Please select your country.',
                'multiOptions' => $countriesArray, 
                'value' => $defaultCountry,  
    ));
    $this->country_code->getDecorator('Description')->setOptions(array('placement' => 'APPEND', 'escape' => false));
    $this->addElement('Text', 'phone_number', array(
      'description' => 'Please enter your phone number.',
      'label' => 'Phone Number',  
      'required' => true,
      'allowEmpty' => false,
      'validators' => array(
                array('NotEmpty',true),
                array('Regex', true, array("/^[1-9][0-9]{4,15}$/")),
                ),
      'tabindex' => 1,
    ));

    $this->phone_number->getValidator('Regex')->setMessage('Please enter a valid phone number.', 'regexNotMatch');
    $this->phone_number->getDecorator('Description')->setOptions(array('placement' => 'APPEND', 'escape' => false));
    
    $this->addElement('Checkbox','enable',array(
      'label' => 'Enable Two Step Verification on login'
    ));
    
    $this->addElement('Checkbox','remove',array(
      'label' => 'Remove Phone Number'
    ));

    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save',
      'type' => 'submit',
      'ignore' => true,
      'tabindex' => 2,
      'decorators' => array(
        'ViewHelper',
      ),
    ));

  }
}