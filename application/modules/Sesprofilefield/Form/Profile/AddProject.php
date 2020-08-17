<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddProject.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_AddProject extends Engine_Form
{
  public $_error = array();

  public function init()
  {
    $this->setTitle('Add project')
      ->setDescription('')
      ->setAttrib('name', 'sesprofilefield_addproject')
      ->setAttrib('class', 'sesprofilefield_formcheck global_form');

    $this->addElement('Text', 'title', array(
      'label' => 'Name',
      'allowEmpty' => false,
      'required' => true,
    ));

    $month_array = array('' => 'Month','January' => 'January','February' => 'February','March' => 'March','April' => 'April','May' => 'May','June' => 'June','July' => 'July','August' => 'August','September' => 'September','October' => 'October','November' => 'November','December' => 'December');

    $startYear = date('Y', strtotime('+0 year'));
    $endYear = date('Y', strtotime('-100 year'));
    $year[] = 'Year';
    for($startYear; $startYear >= $endYear; $startYear--) {
        $year[$startYear] .= $startYear;
    }

    $tostartYear = date('Y', strtotime('+10 year'));
    $toendYear = date('Y', strtotime('-100 year'));
    $toyear[] = 'Year';
    for($tostartYear; $tostartYear >= $toendYear; $tostartYear--) {
        $toyear[$tostartYear] .= $tostartYear;
    }

    $this->addElement('Select', 'frommonth', array(
      'multiOptions' => $month_array,
      'allowEmpty' => false,
      'required' => true,
    ));
    $this->addElement('Select', 'fromyear', array(
      'multiOptions' => $year,
      'allowEmpty' => false,
      'required' => true,
    ));
    $this->addDisplayGroup(array('frommonth', 'fromyear'), 'fromyearmonth', array('legend' => "Start Date", 'disableLoadDefaultDecorators' => true));
    $this->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));


    $this->addElement('Select', 'tomonth', array(
      'multiOptions' => $month_array,
      'allowEmpty' => false,
      'required' => true,
    ));
    $this->addElement('Select', 'toyear', array(
      'multiOptions' => $toyear,
      'allowEmpty' => false,
      'required' => true,
    ));
		$this->addDisplayGroup(array('tomonth', 'toyear'), 'toyearmonth', array('legend' => "End Date", 'disableLoadDefaultDecorators' => true));
		$this->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));

    $this->addElement('dummy', 'present', array(
      'content' => '- Present',
    ));


    $this->addElement('Checkbox', 'currentlywork', array(
      'label' => 'Project ongoing',
      'onclick' => 'hideToDateExp()',
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

    $this->addElement('Text', 'project_url', array(
      'label' => 'Project URL',
      'allowEmpty' => true,
      'required' => false,
    ));

    $this->addElement('Textarea', 'description', array(
      'label' => 'Description',
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
