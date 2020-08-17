<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-01-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfmm_Bootstrap extends Engine_Application_Bootstrap_Abstract {

	public function __construct($application) {
        parent::__construct($application);
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Sesfmm_Plugin_Core);
	}

  protected function _initFrontController() {
    include APPLICATION_PATH . '/application/modules/Sesfmm/controllers/Checklicense.php';
  }
}
