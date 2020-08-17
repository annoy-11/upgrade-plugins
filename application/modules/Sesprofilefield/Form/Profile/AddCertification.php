<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddCertification.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_AddCertification extends Engine_Form
{
  public $_error = array();

  public function init()
  {
    $this->setTitle('Add Certification')
      ->setDescription('')
      ->setAttrib('name', 'sesprofilefield_addcertification')
      ->setAttrib('class', 'sesprofilefield_formcheck global_form');

    $this->addElement('Text', 'name', array(
      'label' => 'Certification name',
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Text', 'authority', array(
      'label' => 'Certification authority',
      'placeholder' => "Search Authority",
      'allowEmpty' => true,
      'required' => false,
    ));

    $this->addElement('Text', 'license_number', array(
      'label' => 'License number',
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
    $this->addElement('Dummy', 'timeperiod', array(
      'label' => "Time period",
    ));

    $this->addElement('Select', 'fromyear', array(
      'multiOptions' => $year
    ));
    $this->addElement('Select', 'frommonth', array(
      'multiOptions' => $month_array,
    ));
		$this->addDisplayGroup(array('fromyear','frommonth'), 'fromyearmonth', array('disableLoadDefaultDecorators' => true,'legend' => 'From'));
		$this->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));


    $this->addElement('Select', 'toyear', array(
      'multiOptions' => $toyear,
    ));
    $this->addElement('Select', 'tomonth', array(
      'multiOptions' => $month_array
    ));
		$this->addDisplayGroup(array('toyear','tomonth'), 'toyearmonth', array('disableLoadDefaultDecorators' => true,'legend' => 'To'));
		$this->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));


    $this->addElement('dummy', 'present', array(
      'content' => '- Present',
    ));

    $this->addElement('Checkbox', 'notexpire', array(
      'label' => 'This certification does not expire',
      'onclick' => 'hideToDate()',
    ));


    $this->addElement('Text', 'url', array(
      'label' => 'Certification URL',
      'allowEmpty' => true,
      'required' => false,
      //'onblur' => "checkURL(this.value)",
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
