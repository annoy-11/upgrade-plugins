<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Advancedsearch_Bootstrap extends Engine_Application_Bootstrap_Abstract {

    public function __construct($application) {
        parent::__construct($application);
        define('sesadvancedsearch', 1);
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Advancedsearch_Plugin_Core);
    }

    protected function _initFrontController() {
        include APPLICATION_PATH . '/application/modules/Advancedsearch/controllers/Checklicense.php';
    }
}
