<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Billing.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Form_Billing extends Engine_Form {

  public function init() {
    $counties = Engine_Api::_()->getDbTable('countries','courses')->getCountries();
     foreach($counties as $country){
        $country_id = $country['country_id'];
        $countiesMutiOpt[$country_id] = $country['name'];
    }
    $this->addElement('Text', 'first_name', array(
        'label' => 'First Name',
        'description' => 'Enter the first name.',
        'required' => true,
    ));
    $this->addElement('Text', 'last_name', array(
        'label' => 'Last Name',
        'description' => 'Enter the last name.',
    ));
    $this->addElement('Text', 'email', array(
        'label' => 'Enter Email',
        'description' => 'Please provide valid email address.',
        'required' => true,
    ));
    $this->addElement('Text', 'phone_number', array(
        'label' => 'Phone Number',
        'description' => 'Please enter your contact number. ',
        'required' => false,
        'validators' => array(
            array('Int', true),
        ),
    ));
    $this->addElement('Select', 'country', array(
        'label' => 'Select Country',
         'multiOptions' => $countiesMutiOpt,
         'onchange'=>"getStates(this.value,'state')",
    ));
    $this->addElement('Select', 'state', array(
        'label' => 'State',
        'id'=>'state',
        'multiOptions'=>array('0' => ''),
    ));


     $this->addElement('Text', 'city', array(
        'label' => 'City',
    ));

    $this->addElement('Text', 'address', array(
        'label' => 'Address',
    ));

    $this->addElement('Text', 'zip_code', array(
        'label' => 'ZIP/PIN Code',
        'required' => true,
    ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
    }
}
