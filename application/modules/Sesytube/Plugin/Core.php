<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Plugin_Core extends Zend_Controller_Plugin_Abstract{
   public function routeShutdown(Zend_Controller_Request_Abstract $request) {

    if (substr($request->getPathInfo(), 1, 5) == "admin") {
      $params = $request->getParams();
      if($params['module'] == 'sesytube' &&  $params['controller'] == "admin-menu") {
        $request->setModuleName('sesbasic');
        $request->setControllerName('admin-menu');
        $request->setActionName($params['action']);
        $request->setParam('moduleName', 'sesytube');

      }
    }

   }

	public function onRenderLayoutDefault() {

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    //Google Font Work
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $usegoogleFont = $settings->getSetting('sesytube.googlefonts', 0);
    if(!empty($usegoogleFont)) {
      $string = 'https://fonts.googleapis.com/css?family=';

      $bodyFontFamily = Engine_Api::_()->sesytube()->getContantValueXML('sesytube_body_fontfamily');
      $string .= str_replace('"', '', $bodyFontFamily);

      $headingFontFamily = Engine_Api::_()->sesytube()->getContantValueXML('sesytube_heading_fontfamily');
      $string .= '|'.str_replace('"', '', $headingFontFamily);

      $mainmenuFontFamily = Engine_Api::_()->sesytube()->getContantValueXML('sesytube_mainmenu_fontfamily');
      $string .= '|'.str_replace('"', '', $mainmenuFontFamily);

      $tabFontFamily = Engine_Api::_()->sesytube()->getContantValueXML('sesytube_tab_fontfamily');
      $string .= '|'.str_replace('"', '', $tabFontFamily);;

      $view->headLink()->appendStylesheet($string);

    }

		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();

		$setting = Engine_Api::_()->getApi('settings', 'core');
		$script = '
			sesJqueryObject(window).ready(function(e){
        var height = sesJqueryObject(".layout_page_header").height();
				if($("global_wrapper")) {
					$("global_wrapper").setStyle("margin-top", height+"px");
				}
			});';
    $view->headScript()->appendScript($script);


	  //if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.header.design', 2) == 2){
      $view->headLink()->appendStylesheet($view->layout()->staticBaseUrl.'application/modules/Sesbasic/externals/styles/customscrollbar.css');
      $view->headScript()->appendFile(Zend_Registry::get('StaticBaseUrl').'application/modules/Sesbasic/externals/scripts/jquery.min.js');
      $view->headScript()->appendFile(Zend_Registry::get('StaticBaseUrl').'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js');
    //}
	}
}
