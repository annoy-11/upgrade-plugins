<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesserverwp
 * @package    Sesserverwp
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesserverwp_Plugin_Core extends Core_Plugin_Abstract{
	public function onUserLoginAfter($event){
    $user = $event->getPayload();
    Engine_Api::_()->sesserverwp()->login($user); 
  }
  public function onUserSignupAfter($event){
      $user = $event->getPayload();
      Engine_Api::_()->sesserverwp()->signup($user); 
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
        $_SESSION['sesserverwp'] = $_SESSION['User_Plugin_Signup_Account']['data']['password'];  
      }
      if(!empty($_SESSION['Sessociallogin_Plugin_Signup_Account']['data'])){
        $_SESSION['sesserverwp'] = $_SESSION['Sessociallogin_Plugin_Signup_Account']['data']['password'];  
      }
    }
  }
}
?>