<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddSpecialty.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_AddSpecialty extends Engine_Form {

  public $_error = array();

  public function init() { 
  
//     $specialty_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('specialty_id', 0);
//     
//     if($specialty_id) {
//       $specialty = Engine_Api::_()->getItem('sesprofilefield_specialty', $specialty_id);
//       
//     }
  
    $this->setTitle('Add Specialty')
        ->setDescription('')
        ->setAttrib('name', 'sesprofilefield_addspecialty')
        ->setAttrib('class', 'sesprofilefield_formcheck global_form');
      
    $this->addElement('Radio', 'athletic', array(
      'label' => 'Athletic',
      'multiOptions' => array(
        1 => 'Yes',
        0 => 'No',
      ),
      'value' => 1,
      'allowEmpty' => false,
      'required' => true,
      'onclick' => 'athleticHideShow(this.value);',
    ));
    
    $athletics = Engine_Api::_()->getDbTable('adminspecialties', 'sesprofilefield')->getSpecialtyAssoc(array('type' => 'athletic'));
    
    $this->addElement('MultiCheckbox', 'athletic_specialties', array(
      'label' => 'Choose Athletic Specialty',
      'multiOptions' => $athletics,
      'class' => 'athletic_specialties',
    ));
    
    $this->addElement('Radio', 'professional', array(
      'label' => 'Professional',
      'multiOptions' => array(
        1 => 'Yes',
        0 => 'No',
      ),
      'value' => 0,
      'onclick' => 'professionalHideShow(this.value);',
    ));

    $professional = Engine_Api::_()->getDbTable('adminspecialties', 'sesprofilefield')->getSpecialtyAssoc(array('type' => 'professional'));
    
    $this->addElement('MultiCheckbox', 'professional_specialties', array(
      'label' => 'Choose Professional Specialty',
      'multiOptions' => $professional,
      'class' => 'professional_specialties',
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
    $button_group = $this->getDisplayGroup('buttons');
  }
}