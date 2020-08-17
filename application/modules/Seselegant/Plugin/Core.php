<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seselegant_Plugin_Core extends Zend_Controller_Plugin_Abstract
{
  public function routeShutdown(Zend_Controller_Request_Abstract $request) {
  
    if (substr($request->getPathInfo(), 1, 5) == "admin") {
      $params = $request->getParams();
      if($params['module'] == 'seselegant' &&  $params['controller'] == "admin-menu") {
        $request->setModuleName('sesbasic');
        $request->setControllerName('admin-menu');
        $request->setActionName($params['action']);
        $request->setParam('moduleName', 'seselegant');
        
      }
    }
    
  }
   
	public function onRenderLayoutDefault(){
	
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
}