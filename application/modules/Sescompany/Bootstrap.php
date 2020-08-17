<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescompany
 * @package    Sescompany
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescompany_Bootstrap extends Engine_Application_Bootstrap_Abstract {

	public function __construct($application) {

        parent::__construct($application);

        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Sescompany_Plugin_Core);
	}

    protected function _initFrontController() {

        $this->initActionHelperPath();
        Zend_Controller_Action_HelperBroker::addHelper(new Sescompany_Controller_Action_Helper_LoginError());
    }
}
