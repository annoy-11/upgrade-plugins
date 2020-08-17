<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Contactinformation.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sescrowdfunding_Form_Dashboard_Contactinformation extends Engine_Form {

  public function init() {
  
    $this->setTitle('Crowdfunding Contact Information')
        //->setAttrib('id', 'sescrowdfunding_ajax_form_submit')
        ->setMethod("POST")
        ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
        
    // Name
    $this->addElement('Text', 'crowdfunding_contact_name', array(
      'label' => 'Name',
      'allowEmpty' => false,
      'required' => true,
      'validators' => array(
        array('NotEmpty', true),
        array('StringLength', false, array(1, 64)),
      ),
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
      ),
    ));
    
    // Email
    $this->addElement('Text', 'crowdfunding_contact_email', array(
      'label' => 'Email',
      'allowEmpty' => false,
      'required' => true,
    ));
    
    $this->addElement('Text', 'crowdfunding_contact_country', array(
      'label' => 'Country',
    ));
    
    $this->addElement('Text', 'crowdfunding_contact_state', array(
      'label' => 'State',
    ));
    
    $this->addElement('Text', 'crowdfunding_contact_city', array(
      'label' => 'City',
    ));
    
    $this->addElement('Text', 'crowdfunding_contact_street', array(
      'label' => 'Street',
    ));
    
    // Phone
    $this->addElement('Text', 'crowdfunding_contact_phone', array(
      'label' => 'Phone',
    ));
    
    // Website
    $this->addElement('Text', 'crowdfunding_contact_website', array(
      'label' => 'Website',
    ));
    
    // Facebook
    $this->addElement('Text', 'crowdfunding_contact_facebook', array(
      'label' => 'Facebook',
    ));

    $this->addElement('Text', 'crowdfunding_contact_twitter', array(
      'label' => 'Twitter',
    ));
   
    // Description
    $this->addElement('Textarea', 'crowdfunding_contact_aboutme', array(
      'label' => 'About Me',
      'maxlength' => '2000',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
        new Engine_Filter_EnableLinks(),
        new Engine_Filter_StringLength(array('max' => 2000)),
      ),
    ));
    
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Contact Information',
      'type' => 'submit',
      'ignore' => true,
    ));
  }
}