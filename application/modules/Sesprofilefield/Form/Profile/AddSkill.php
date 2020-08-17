<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddSkill.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_AddSkill extends Engine_Form {

  public function init() {
  
	  $this->setTitle("Add Skills")
        ->setAttrib('name', 'sesprofilefield_addskill')
        ->setAttrib('id', 'sesprofilefield_addskill');

    $this->addElement('Text', 'skillname', array(
      'placeholder' => 'Enter in your skills',
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Dummy', 'custom_add_skills', array(
			'content' => '<p class="addskills_popup_list_head sesbasic_sesbasic_clearfix"><span class="addskills_popup_list_head_left">Skill</span></p>',
		));
  
		$this->addElement('Dummy', 'custom_add_skill', array(
			'content' => '',
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