<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessegpay_Plugin_Core extends Zend_Controller_Plugin_Abstract {
  public function routeShutdown(Zend_Controller_Request_Abstract $request) {
  
    $module = $request->getModuleName();
    $controller = $request->getControllerName();
    $action = $request->getActionName();
    if($module == "payment" && $controller == "subscription" && $action == "gateway" && Engine_Api::_()->getApi('settings', 'core')->getSetting('sessegpay_enable',1)){
      $request->setModuleName('sessegpay');
      $request->setControllerName('subscription');
      $request->setActionName('gateway');
    }
    if($module == "payment" && $controller == "admin-package" && $action == "index" && Engine_Api::_()->getApi('settings', 'core')->getSetting('sessegpay_enable',1)){
      $request->setModuleName('sessegpay');
      $request->setActionName('core');
    }
    if($module == "payment" && $controller == "subscription" && $action == "choose" && Engine_Api::_()->getApi('settings', 'core')->getSetting('sessegpay_enable',1)){
     // $request->setModuleName('sessegpay');
     // $request->setActionName('choose');
    
    }
    
  }
	public function onRenderLayoutMobileDefault($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutMobileDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutDefault($event,$mode=null){
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();		
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();
	}
  
}
