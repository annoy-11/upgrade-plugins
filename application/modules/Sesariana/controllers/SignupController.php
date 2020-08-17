<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SignupController.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_SignupController extends Core_Controller_Action_Standard {

  public function indexAction() {

		$settings = Engine_Api::_()->getApi('settings', 'core');
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