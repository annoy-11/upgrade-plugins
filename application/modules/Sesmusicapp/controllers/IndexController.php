<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmusicapp_IndexController extends Core_Controller_Action_Standard {

	public function homeAction() {
		 // Render
		$this->_helper->content->setEnabled();
	}
	public function welcomeAction() {
		 // Render
		$this->_helper->content->setEnabled();
	}
}
