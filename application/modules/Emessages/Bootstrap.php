<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Bootstrap.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  public function __construct($application) {
		parent::__construct($application);
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Emessages_Plugin_Core);
	}

  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Emessages/controllers/Checklicense.php';
  }
}
