<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Newmemberadd.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_Form_Newmemberadd extends Engine_Form
{
	public function init()
	{
		$this->setTitle('Add New Member');
		$this->setAction('javascript:void(0);');
		$this->setAttrib('id', 'addnewmemberform');

		// init to
		$this->addElement('Text', 'to', array(
			'label'=>'Select Memeber',
			'placeholder'=>'Select Memeber',
			'order' => 0,
			'autocomplete'=>'off'));
		Engine_Form::addDefaultDecorators($this->to);
		// Init to Values
		$this->addElement('Hidden', 'toValues', array(
			//'label' => 'Send To',
			'required' => true,
			'allowEmpty' => false,
			'order' =>1,
			'validators' => array(
				'NotEmpty'
			),
			'filters' => array(
				'HtmlEntities'
			),
		));
		Engine_Form::addDefaultDecorators($this->toValues);
		$this->addElement('hidden', 'groupid', array());

		$this->addElement('Button', 'submit', array(
			'label' => 'Submit',
			'type' => 'submit',
			'order' => 13,
			'ignore' => true,
			'decorators' => array('ViewHelper')
		));

		$this->addElement('Cancel', 'cancel', array(
			'label' => 'cancel',
			'link' => true,
			'prependText' => ' or ',
			'href' => '',
			'order' => 14,
			'onclick' => 'parent.Smoothbox.close();',
			'decorators' => array(
				'ViewHelper'
			)
		));
		$this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
		$button_group = $this->getDisplayGroup('buttons');
	}
}

