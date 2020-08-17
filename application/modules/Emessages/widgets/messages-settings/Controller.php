<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_Widget_MessagesSettingsController extends Engine_Content_Widget_Abstract
{

	public function indexAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		if (!$viewer->getIdentity())
		{
			return $this->_forward('requireauth', 'error', 'core');
		}
		$this->view->form= $form=new Emessages_Form_Usersettings();
		$user_message=Engine_Api::_()->getItem('emessages_usersetting',$viewer->getIdentity());
		if(isset($_POST['receivemessage']))
		{
			if(!isset($user_message) || empty($user_message))
			{
				$user_message=Engine_Api::_()->getDbtable('usersettings', 'emessages')->createRow();
				$user_message->user_id=$viewer->getIdentity();
			}
		  $user_message->receivemessage=trim($_POST['receivemessage']);
			if(isset($_POST['onlinestatus']))
			{
				$user_message->onlinestatus=trim($_POST['onlinestatus']);
			}
			if(isset($_POST['otherlastseen']))
			{
				$user_message->otherlastseen=trim($_POST['otherlastseen']);
			}
			$user_message->save();
		}
		if(isset($user_message) && !empty($user_message))
		{
			$form->populate(array(
				'otherlastseen' => $user_message->otherlastseen,
				'onlinestatus' => $user_message->onlinestatus,
				'receivemessage' => $user_message->receivemessage,
			));
		}
	}
}
