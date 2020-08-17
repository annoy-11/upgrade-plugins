<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestwitterclone_Plugin_Core extends Zend_Controller_Plugin_Abstract {

    public function routeShutdown(Zend_Controller_Request_Abstract $request) {

        if (substr($request->getPathInfo(), 1, 5) == "admin") {
            $params = $request->getParams();
            if($params['module'] == 'sestwitterclone' &&  $params['controller'] == "admin-menu") {
                $request->setModuleName('sesbasic');
                $request->setControllerName('admin-menu');
                $request->setActionName($params['action']);
                $request->setParam('moduleName', 'sestwitterclone');
            }
        }
    }

	public function onRenderLayoutDefault() {

        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $view->headLink()->appendStylesheet($view->layout()->staticBaseUrl.'application/modules/Sesbasic/externals/styles/customscrollbar.css');
        $view->headScript()->appendFile(Zend_Registry::get('StaticBaseUrl').'application/modules/Sesbasic/externals/scripts/jquery.min.js');
        $view->headScript()->appendFile(Zend_Registry::get('StaticBaseUrl').'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js');

        //Google Font Work
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $usegoogleFont = $settings->getSetting('sestwitterclone.googlefonts', 0);
        if(!empty($usegoogleFont)) {
            $string = 'https://fonts.googleapis.com/css?family=';

            $bodyFontFamily = Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_body_fontfamily');
            $string .= str_replace('"', '', $bodyFontFamily);

            $headingFontFamily = Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_heading_fontfamily');
            $string .= '|'.str_replace('"', '', $headingFontFamily);

            $mainmenuFontFamily = Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_mainmenu_fontfamily');
            $string .= '|'.str_replace('"', '', $mainmenuFontFamily);

            $tabFontFamily = Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_tab_fontfamily');
            $string .= '|'.str_replace('"', '', $tabFontFamily);;

            $view->headLink()->appendStylesheet($string);

        }
	}
}
