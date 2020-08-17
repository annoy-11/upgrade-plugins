<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoserver
 * @package    Sesssoserver
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesssoserver_Plugin_Core {
  public function onUserLoginAfter($event){
     $user = $event->getPayload();
     Engine_Api::_()->sesssoserver()->login($user); 
  }
  public function onUserSignupAfter($event){
      $user = $event->getPayload();
      Engine_Api::_()->sesssoserver()->signup($user); 
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
    if($moduleName == "user" && $controllerName == "signup" && $actionName == "index"){
      if(!empty($_SESSION['User_Plugin_Signup_Account']['data'])){
        $_SESSION['sesssopassword'] = $_SESSION['User_Plugin_Signup_Account']['data']['password'];  
      }
      if(!empty($_SESSION['Sessociallogin_Plugin_Signup_Account']['data'])){
        $_SESSION['sesssopassword'] = $_SESSION['Sessociallogin_Plugin_Signup_Account']['data']['password'];  
      }
    }
  }
}