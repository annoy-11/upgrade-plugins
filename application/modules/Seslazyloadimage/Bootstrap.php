<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslazyloadimage
 * @package    Seslazyloadimage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-02-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslazyloadimage_Bootstrap extends Engine_Application_Bootstrap_Abstract {

    public function __construct($application) {
        parent::__construct($application);
        if(Engine_Api::_()->getApi('settings', 'core')->getSetting('seslazyloadimage.enable', 1)) {
            $baseUrl = Zend_Registry::get('StaticBaseUrl');
            $headScript = new Zend_View_Helper_HeadScript();
            if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
                $headScript->appendFile($baseUrl . 'application/modules/Seslazyloadimage/externals/scripts/lazyload.min.js');
                $headScript->appendFile($baseUrl . 'application/modules/Seslazyloadimage/externals/scripts/core.js');
            }
        }
    }

    protected function _initView() {
        if(Engine_Api::_()->getApi('settings', 'core')->getSetting('seslazyloadimage.enable', 1)) {
            //$view = new Zend_View();
            // Setup and register viewRenderer
            // @todo we may not need to override zend's
            $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
            $view = $viewRenderer->view;

            $path = APPLICATION_PATH . '/application/modules/Seslazyloadimage/View/Helper/';
            $prefix = 'Seslazyloadimage_View_Helper_';
            // Add default helper paths
            $view->addHelperPath($path, $prefix);
            $view->registerHelper((new Seslazyloadimage_View_Helper_ItemPhoto), 'itemPhoto');
            $view->registerHelper((new Seslazyloadimage_View_Helper_ItemBackgroundPhoto), 'itemBackgroundPhoto');
            return $view;
        }
    }
}
