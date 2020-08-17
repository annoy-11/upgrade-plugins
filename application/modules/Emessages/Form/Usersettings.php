<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Usersettings.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_Form_Usersettings extends Engine_Form
{
	public function init()
	{
		$this->setTitle('Messages Page settings');
		$user_level = Engine_Api::_()->user()->getViewer()->level_id;

		//$this->setAttribute('action', array('route' => 'emessages_setting','modules'=>'emessages','controller'=>'messagesetting', 'action' => 'update'));


		if(Engine_Api::_()->authorization()->getPermission($user_level, 'emessages', 'lastseen'))
		{
			$this->addElement('Radio', 'otherlastseen', array(
				'label' => 'Last Seen',
				'description' => 'Do you want to enable other members to see your last seen time in the messages?',
				'multiOptions' => array(
					1 => 'Yes',
					0 => 'No',
				),
				'value' => 1,
			));
		}

		if(Engine_Api::_()->authorization()->getPermission($user_level, 'emessages', 'online'))
		{
			$this->addElement('Radio', 'onlinestatus', array(
				'label' => 'Online Status',
				'description' => 'Do you want to display your online status in the messages?',
				'multiOptions' => array(
					1 => 'Yes',
					0 => 'No',
				),
				'value' => 1,
			));
		}

			$this->addElement('Radio', 'receivemessage', array(
				'label' => 'Allow to Receive Messages?',
				'description' => ' Do you want to allow users to search and message you.',
				'multiOptions' => array(
					1 => 'Yes',
					0 => 'No'
				),
				'value' => 1,
			));

		$this->addElement('Button', 'submit', array(
			'label' => 'Save Changes',
			'type' => 'submit',
			'ignore' => true
		));
	}
}

