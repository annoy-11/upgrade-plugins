<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Editmessage.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_Form_Editmessage extends Engine_Form
{
	public function init()
	{
		$this->setTitle('Edit Message');
		$this->setAction('javascript:void(0);');
		$this->setAttrib('id', 'editmessageform');

		$this->addElement('textarea', 'message_text', array(
			'label' => 'Message',
			'required' => true,
			'rows' => '3',
		));
		$this->addElement('hidden', 'message_id', array());


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

