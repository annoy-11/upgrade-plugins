<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddAward.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_AddAward extends Engine_Form
{
  public $_error = array();

  public function init()
  {   
    $this->setTitle('Add honors & awards')
      ->setDescription('')
      ->setAttrib('name', 'sesprofilefield_addaward');

    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'allowEmpty' => false,
      'required' => true,
    ));
    
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $companies = $educations = $associatewithArray = array();
    $getAllExperiences = Engine_Api::_()->getDbTable('experiences', 'sesprofilefield')->getAllExperiences($viewer_id);
    if(count($getAllExperiences) > 0) {
      foreach($getAllExperiences as $getAllExperience) {
        $companies[$getAllExperience->company] = $getAllExperience->company;
      }
    }
    
//     $getAllEducations = Engine_Api::_()->getDbTable('educations', 'sesprofilefield')->getAllEducations($viewer_id);
//     if(count($getAllEducations) > 0) {
//       foreach($getAllEducations as $getAllEducation) {
//         $educations[$getAllEducation->school] = $getAllEducation->school;
//       }
//     }
    
    $associatewithArray = array_merge($educations, $companies);

    if($associatewithArray) {
      $associate_with = array_merge(array('' => "Associate With"), $associatewithArray);
      $this->addElement('Select', 'associate_with', array(
        'multiOptions' => $associate_with
      ));
    }
    
    $this->addElement('Text', 'issuer', array(
      'label' => 'Issuer',
      'allowEmpty' => true,
      'required' => false,
    ));

    $month_array = array('' => 'Month','January' => 'January','February' => 'February','March' => 'March','April' => 'April','May' => 'May','June' => 'June','July' => 'July','August' => 'August','September' => 'September','October' => 'October','November' => 'November','December' => 'December');
    
		$startYear = date('Y', strtotime('+0 year')); 
		$endYear = date('Y', strtotime('-100 year'));
		$year[] = 'Year';
		for($startYear; $startYear >= $endYear; $startYear--) {
			$year[$startYear] .= $startYear;
		}
    $this->addElement('Select', 'frommonth', array(
      'multiOptions' => $month_array,
    ));
    $this->addElement('Select', 'fromyear', array(
      'multiOptions' => $year
    ));

		$this->addDisplayGroup(array('frommonth', 'fromyear'), 'fromyearmonth', array('disableLoadDefaultDecorators' => true)); 
		$this->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));

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