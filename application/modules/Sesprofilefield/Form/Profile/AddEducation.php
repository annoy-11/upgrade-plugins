<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddEducation.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_AddEducation extends Engine_Form
{
  public $_error = array();

  public function init()
  {
    $this->setTitle('Add Education')
      ->setDescription('')
      ->setAttrib('name', 'sesprofilefield_addeducation')
      ->setAttrib('class', 'sesprofilefield_formcheck global_form');

    $this->addElement('Text', 'school', array(
      'label' => 'School',
      'placeholder' => 'School Name (ex: Boston University)',
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Text', 'degree', array(
      'label' => 'Degree',
      'placeholder' => 'Degree (ex: Bachelor\'s)',
      'allowEmpty' => true,
      'required' => false,
    ));

    $this->addElement('Text', 'field_of_study', array(
      'label' => 'Field of study',
      'placeholder' => 'Field of study (ex: Business)',
      'allowEmpty' => true,
      'required' => false,
    ));

    $this->addElement('Text', 'grade', array(
      'label' => 'Grade',
      'allowEmpty' => true,
      'required' => false,
    ));

    $this->addElement('Textarea', 'activities', array(
      'label' => 'Activities and societies',
      'allowEmpty' => true,
      'required' => false,
    ));

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
    $this->addElement('Select', 'fromyear', array(
      'label' => 'From Year',
      'multiOptions' => $year,
    ));
    $this->addElement('Select', 'toyear', array(
      'label' => 'To Year (or expected)',
      'multiOptions' => $toyear,
      'onchange' => "checkEndDate(this.value)",
    ));

    $this->addElement('Textarea', 'description', array(
      'label' => 'Description',
      'allowEmpty' => true,
      'required' => false,
    ));

    $this->addElement('Dummy', 'uploadaddmore', array(
      'content' => '<a class="sesprofilefield_popup_addmore_btn" id="addmoreEducation" href="javascript:void(0);" data-rel="2" onclick="addmoreEducation()"><i class="fa fa-plus"></i><span>Add More</span></a>',
    ));

    $this->addElement('File', 'upload_1', array(
      'label' => 'Upload only PDF or Word Document Only.',
      'allowEmpty' => true,
      'required' => false,
      'validators' => array(
        array('Extension', false, 'pdf,doc'),
      ),
      'accept'=>".pdf,.doc,.docx,.ppt",
    ));

    $this->addElement('File', 'upload_2', array(
      'label' => 'Upload only PDF or Word Document Only.',
      'allowEmpty' => true,
      'required' => false,
      'validators' => array(
        array('Extension', false, 'pdf,doc'),
      ),
      'accept'=>".pdf,.doc,.docx,.ppt",
    ));

    $this->addElement('File', 'upload_3', array(
      'label' => 'Upload only PDF or Word Document Only.',
      'allowEmpty' => true,
      'required' => false,
      'validators' => array(
        array('Extension', false, 'pdf,doc, ppt'),
      ),
      'accept'=>".pdf,.doc,.docx,.ppt",
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
