<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
    public function __construct($application) {
      parent::__construct($application);
      $this->initViewHelperPath();
        if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
        $baseURL = Zend_Registry::get('StaticBaseUrl');
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $this->initViewHelperPath();
        $headScript = new Zend_View_Helper_HeadScript();
        $headScript->appendFile($baseURL . 'application/modules/Sesqa/externals/scripts/core.js');
      }
    }

    protected function _initFrontController() {

        include APPLICATION_PATH . '/application/modules/Sesqa/controllers/Checklicense.php';
    }
}
