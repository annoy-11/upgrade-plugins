<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddExperience.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_AddExperience extends Engine_Form
{
  public $_error = array();

  public function init()
  {
    $this->setTitle('Add experience')
      ->setDescription('')
      ->setAttrib('name', 'sesprofilefield_addexperience')
      ->setAttrib('class', 'sesprofilefield_formcheck global_form');

    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'placeholder' => "Title (ex: Manager)",
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Text', 'company', array(
      'label' => 'Company',
      'placeholder' => "Company Name (ex: Apple)",
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Text', 'location', array(
      'label' => 'Location',
      'placeholder' => "Region (ex: London)",
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
		$this->addDisplayGroup(array('frommonth', 'fromyear'), 'fromyearmonth', array('legend' => "From", 'disableLoadDefaultDecorators' => true));
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
		$this->addDisplayGroup(array('tomonth', 'toyear'), 'toyearmonth', array('legend' => "To", 'disableLoadDefaultDecorators' => true));
		$this->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));

    $this->addElement('dummy', 'present', array(
      'content' => '- Present',
    ));


    $this->addElement('Checkbox', 'currentlywork', array(
      'label' => 'I currently work here',
      'onclick' => 'hideToDateExp()',
    ));

    $this->addElement('Textarea', 'description', array(
      'label' => 'Description',
      'allowEmpty' => true,
      'required' => false,
    ));

    $this->addElement('File', 'file', array(
      'label' => 'Upload only PDF or Word Document Only.',
      'allowEmpty' => true,
      'required' => false,
      'validators' => array(
        array('Extension', false, 'pdf,doc, ppt'),
      ),
      'accept'=>".pdf,.doc,.docx,.ppt",
      //'accept' => "application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf",
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
