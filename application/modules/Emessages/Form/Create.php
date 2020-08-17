<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Create.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_Form_Create extends Engine_Form
{
	public function init()
	{
		$this->setTitle('Edit Group Info');
		$this->setAction('javascript:void(0);');
		$this->setAttrib('id', 'changegroupnameform');

		$this->addElement('text', 'grouptitle', array(
			'label' => 'Group Title',
			'required' => true,
			'maxlength' => 63,
		));
		$this->addElement('hidden', 'groupid', array());

		$this->addElement('file', 'groupimage', array(
			'label' => 'Group Image',
		));

		$this->addElement('Button', 'submit', array(
			'label' => 'Submit',
			'type' => 'submit',
			'ignore' => true,
			'decorators' => array(
				'ViewHelper'
			)
		));
		$this->addElement('Cancel', 'cancel', array(
			'label' => 'cancel',
			'link' => true,
			'prependText' => ' or ',
			'href' => '',
			'order' => 14,
			'onclick' => 'sessmoothboxclose();return false;',
			'decorators' => array(
				'ViewHelper'
			)
		));
		$this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
		$button_group = $this->getDisplayGroup('buttons');
	}
}

