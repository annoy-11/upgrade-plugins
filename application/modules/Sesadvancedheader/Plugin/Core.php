<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_Plugin_Core extends Zend_Controller_Plugin_Abstract{
    public function routeShutdown(Zend_Controller_Request_Abstract $request) {

        if (substr($request->getPathInfo(), 1, 5) == "admin") {
            $params = $request->getParams();
            if($params['module'] == 'sesadvancedheader' &&  $params['controller'] == "admin-menu") {
                $request->setModuleName('sesbasic');
                $request->setControllerName('admin-menu');
                $request->setActionName($params['action']);
                $request->setParam('moduleName', 'sesadvancedheader');
            }
        }
    }
	public function onRenderLayoutDefault() {

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$view->headScript()->appendFile(Zend_Registry::get('StaticBaseUrl').'application/modules/Sesbasic/externals/scripts/jquery.min.js');

		$settings = Engine_Api::_()->getApi('settings', 'core');

    //Google Font Work
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $usegoogleFont = $settings->getSetting('sesadvancedheader.googlefonts', 0);
    if(!empty($usegoogleFont)) {
      $string = 'https://fonts.googleapis.com/css?family=';
      $mainmenuFontFamily = Engine_Api::_()->sesadvancedheader()->getContantValueXML('sesadvheader_mainmenu_fontfamily');
      $string .= str_replace('"', '', $mainmenuFontFamily);
      $view->headLink()->appendStylesheet($string);
    }

	  if($settings->getSetting('sesadvancedheader.header.design') == 2) {
      $view->headLink()->appendStylesheet($view->layout()->staticBaseUrl.'application/modules/Sesbasic/externals/styles/customscrollbar.css');
      $view->headScript()->appendFile(Zend_Registry::get('StaticBaseUrl').'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js');
    }
	}
}
