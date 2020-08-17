<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SignupController.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestwitterclone_SignupController extends Core_Controller_Action_Standard {

	public function indexAction() {

		// If the user is logged in, they ct
		$formSequenceHelper = $this->_helper->formSequence;
		foreach (Engine_Api::_()->getDbtable('signup', 'user')->fetchAll() as $row) {
			if ($row->enable == 1) {
				$class = $row->class;
				$formSequenceHelper->setPlugin(new $class, $row->order);
			}
		}
		//This will handle everything until done, where it will return true
		if (!$this->_helper->formSequence())
			return;
	}
}
