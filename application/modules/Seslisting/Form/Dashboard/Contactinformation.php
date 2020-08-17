<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Contactinformation.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Form_Dashboard_Contactinformation extends Engine_Form {

  public function init() {

    $this->setTitle('Listing Contact Information')
    ->setAttrib('id', 'seslisting_ajax_form_submit')
    ->setMethod("POST")
    ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    // Name
    $this->addElement('Text', 'listing_contact_name', array(
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
    $this->addElement('Text', 'listing_contact_email', array(
      'label' => 'Email',
      'allowEmpty' => false,
      'required' => true,
    ));
    // Phone
    $this->addElement('Text', 'listing_contact_phone', array(
      'label' => 'Phone',
    ));
    // Facebook
    $this->addElement('Text', 'listing_contact_facebook', array(
      'label' => 'Facebook',
    ));
    // Website
    $this->addElement('Text', 'listing_contact_website', array(
      'label' => 'Website',
    ));
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Contact Information',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array(
	'ViewHelper',
      ),
    ));
//    $this->addDisplayGroup(array('submit'), 'buttons', array(
//      'decorators' => array(
//	'FormElements',
//	'DivDivDivWrapper',
//      ),
//    ));
  }
}
