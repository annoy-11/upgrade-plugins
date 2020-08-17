<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddCourse.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_AddCourse extends Engine_Form
{
  public $_error = array();

  public function init()
  {
    $this->setTitle('Add Courses')
      ->setDescription('')
      ->setAttrib('name', 'sesprofilefield_addcourse');

    $this->addElement('Text', 'title', array(
      'label' => 'Course name',
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Text', 'number', array(
      'label' => 'Number',
      'allowEmpty' => true,
      'required' => false,
    ));

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $companies = $educations = $associatewithArray = array();
    $getAllExperiences = Engine_Api::_()->getDbTable('educations', 'sesprofilefield')->getAllEducations($viewer_id);
    if(count($getAllExperiences) > 0) {
      foreach($getAllExperiences as $getAllExperience) {
        $companies[$getAllExperience->school] = $getAllExperience->school;
      }
    }

    $associatewithArray = array_merge($educations, $companies);

    if($associatewithArray) {
      $associate_with = array_merge(array('' => "Associate With"), $associatewithArray);
      $this->addElement('Select', 'associate_with', array(
        'label' => 'Associated with',
        'multiOptions' => $associate_with
      ));
    }

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
