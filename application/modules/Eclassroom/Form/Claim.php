<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Claim.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Claim extends Engine_Form
{

  public function init() {

    $this->setTitle('Claim For Classroom')
      ->setDescription('')
      ->setAttrib('name', 'eclassroom_calim')
      ->setAttrib('id', 'eclassroom_claim_create');
    $viewer = Engine_Api::_()->user()->getViewer();
    $translate = Zend_Registry::get('Zend_Translate');
    $this->addElement('Text', 'title', array(
      'label' => $translate->translate('Title'),
      'placeholder' => $translate->translate('Enter Classroom Title'),
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '63'))
      ),
      'autofocus' => 'autofocus',
    ));
    $this->addElement('Hidden', 'classroom_id', array());

		$this->addElement('Text', 'user_name', array(
			'label' => $translate->translate('Your Name'),
			'allowEmpty' => false,
			'required' => true,
			'filters' => array(
				new Engine_Filter_Censor(),
				new Engine_Filter_HtmlSpecialChars(),
			),
			'value'=>$viewer->displayname,
		));
		$this->addElement('Text', 'user_email', array(
			'label' => $translate->translate('Your Email'),
			'required' => true,
			'allowEmpty' => false,
			'validators' => array(
				'EmailAddress'
			),
			'filters' => array(
				new Engine_Filter_Censor(),
				new Engine_Filter_HtmlSpecialChars(),
			),
			'value'=>$viewer->email,
		));

		$this->addElement('Text', 'contact_number', array(
      'label' => $translate->translate('Contact Number'),
    ));

    $this->addElement('textarea', 'description', array(
      'label' => $translate->translate('Reason For Claim'),
      'required' => true,
			'allowEmpty' => false,
    ));

    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => $translate->translate('Claim Request'),
      'type' => 'submit',
    ));
  }
}
