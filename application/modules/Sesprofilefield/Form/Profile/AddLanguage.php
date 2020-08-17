<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddLanguage.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_AddLanguage extends Engine_Form {

  public $_error = array();

  public function init() {


    $this->setTitle('Add Language')
        ->setDescription('')
        ->setAttrib('name', 'sesprofilefield_addlanguage')
        ->setAttrib('class', 'sesprofilefield_formcheck global_form');

    $this->addElement('Text', 'languagename', array(
      'label' => 'Language',
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Select', 'proficiency', array(
      'label' => 'Proficiency',
      'multiOptions' => array(
        '' => '',
        1 => 'Elementary proficiency',
        2 => 'Limited working proficiency',
        3 => 'Professional working proficiency',
        4 => 'Full professional proficiency',
        5 => 'Native or bilingual proficiency',
      ),
      'allowEmpty' => true,
      'required' => false,
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
