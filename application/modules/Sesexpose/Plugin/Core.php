<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesexpose_Plugin_Core extends Zend_Controller_Plugin_Abstract {

   public function routeShutdown(Zend_Controller_Request_Abstract $request) {

        if (substr($request->getPathInfo(), 1, 5) == "admin") {
            $params = $request->getParams();
            if($params['module'] == 'sesexpose' &&  $params['controller'] == "admin-menu") {
                $request->setModuleName('sesbasic');
                $request->setControllerName('admin-menu');
                $request->setActionName($params['action']);
                $request->setParam('moduleName', 'sesexpose');

            }
        }
   }

	public function onRenderLayoutDefault(){


    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    //Theme Responsive Layout work
    $theme_name = $view->layout()->themes[0];
    $enable_responseive_leyout = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesexpose.responsive.layout', 1);
    if ($theme_name == 'sesexpose' && $enable_responseive_leyout == '1') {
      include APPLICATION_PATH . '/application/modules/Sesexpose/views/scripts/responsive_layout.tpl';
    }

    $headScript = new Zend_View_Helper_HeadScript();

    //Google Font Work
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $usegoogleFont = $settings->getSetting('sesexpose.googlefonts', 0);
    if(!empty($usegoogleFont)) {
      $string = 'https://fonts.googleapis.com/css?family=';

      $bodyFontFamily = Engine_Api::_()->sesexpose()->getContantValueXML('exp_body_fontfamily');
      $string .= str_replace('"', '', $bodyFontFamily);

      $headingFontFamily = Engine_Api::_()->sesexpose()->getContantValueXML('exp_heading_fontfamily');
      $string .= '|'.str_replace('"', '', $headingFontFamily);

      $mainmenuFontFamily = Engine_Api::_()->sesexpose()->getContantValueXML('exp_mainmenu_fontfamily');
      $string .= '|'.str_replace('"', '', $mainmenuFontFamily);

      $tabFontFamily = Engine_Api::_()->sesexpose()->getContantValueXML('exp_tab_fontfamily');
      $string .= '|'.str_replace('"', '', $tabFontFamily);;

      $view->headLink()->appendStylesheet($string);
    }

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$setting = Engine_Api::_()->getApi('settings', 'core');
		$script = '
			sesJqueryObject(window).ready(function(e){
			var height = sesJqueryObject(".layout_page_header").height();
				if($("global_wrapper")) {
					$("global_wrapper").setStyle("margin-top", height+"px");
				}
			});';
		$view->headScript()->appendScript($script);

	}

  public function onRenderLayoutDefaultSimple($event)
  {
    // Forward
    return $this->onRenderLayoutDefault($event, 'simple');
  }
}
