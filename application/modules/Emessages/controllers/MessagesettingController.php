<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: MessagesettingController.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_MessagesettingController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
	  $viewer = Engine_Api::_()->user()->getViewer();
	  if ($viewer->getIdentity()) {
		  $this->_helper->content->setEnabled();
	  } else {
		  return $this->_forward('requireauth', 'error', 'core');
		  //throw new Exception('Page not found.');
	  }
  }
}
