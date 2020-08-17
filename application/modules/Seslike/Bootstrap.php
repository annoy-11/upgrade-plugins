<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_Bootstrap extends Engine_Application_Bootstrap_Abstract {

    protected function _initFrontController() {

        $this->initActionHelperPath();
        Zend_Controller_Action_HelperBroker::addHelper(new Seslike_Controller_Action_Helper_Corelikes());
    }

    public function __construct($application) {

        parent::__construct($application);
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
            $headScript = new Zend_View_Helper_HeadScript();
            $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Seslike/externals/scripts/core.js');
        }
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Seslike_Plugin_Core);
    }
}
