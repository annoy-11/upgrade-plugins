<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessreview_Bootstrap extends Engine_Application_Bootstrap_Abstract {

    public function __construct($application) {
        parent::__construct($application);
        $baseURL = Zend_Registry::get('StaticBaseUrl');
        $this->initViewHelperPath();
        $headScript = new Zend_View_Helper_HeadScript();
        if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '',    $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
            $headScript = new Zend_View_Helper_HeadScript();
            $headScript->appendFile($baseURL . 'application/modules/Sesbusinessreview/externals/scripts/core.js');
        }
    }

    protected function _initFrontController() {
        include APPLICATION_PATH . '/application/modules/Sesbusinessreview/controllers/Checklicense.php';
    }
}
