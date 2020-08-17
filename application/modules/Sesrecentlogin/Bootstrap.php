<?php

class Sesrecentlogin_Bootstrap extends Engine_Application_Bootstrap_Abstract {

	public function __construct($application) {

        parent::__construct($application);
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Sesrecentlogin_Plugin_Core);
	}

    protected function _initFrontController() {
        include APPLICATION_PATH . '/application/modules/Sesrecentlogin/controllers/Checklicense.php';
    }
}
