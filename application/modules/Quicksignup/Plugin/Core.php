<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Quicksignup_Plugin_Core extends Zend_Controller_Plugin_Abstract {
  public function routeShutdown(Zend_Controller_Request_Abstract $request) {
    $params = $request->getParams();
      $enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('quicksignup.enable', 1);
      if($enable){
          include_once APPLICATION_PATH . '/application/modules/Quicksignup/Form/Signup/Fields.php';
      }
      if (substr($request->getPathInfo(), 1, 5) == "admin" && $enable) {
          if($params['module'] == 'user' && ($params['controller'] == 'admin-signup')) {
              $request->setModuleName('quicksignup');
              $request->setControllerName('admin-settings');
              $request->setActionName('index');
          }
      }else{
          if (substr($request->getPathInfo(), 1, 5) != "admin" && $enable) {
              include_once APPLICATION_PATH . '/application/modules/Quicksignup/Form/Signup.php';
              if($params['module'] == 'user' && ($params['action'] == 'index') && ($params['controller'] == "signup")) {
                  $request->setModuleName('quicksignup');
                  $request->setControllerName('signup');
                  $request->setActionName('index');

              }
          }
      }
  }
	public function onRenderLayoutDefaultSimple($event) {
        return $this->onRenderLayoutDefault($event,'simple');
    }
	public function onRenderLayoutMobileDefault($event) {
        return $this->onRenderLayoutDefault($event,'simple');
    }
	public function onRenderLayoutMobileDefaultSimple($event) {
        return $this->onRenderLayoutDefault($event,'simple');
    }
	public function onRenderLayoutDefault($event) {
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();
        $headScript = new Zend_View_Helper_HeadScript();
        $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
      					 .'application/modules/Quicksignup/externals/scripts/core.js');

    }
}