<?php

class Eocsso_Plugin_Core extends Core_Plugin_Abstract
{

  public function onUserLoginAfter($event)
  {
    $user = $event->getPayload();
    Engine_Api::_()->eocsso()->login($user);
  }

  public function onUserSignupAfter($event)
  {
    $user = $event->getPayload();
    Engine_Api::_()->eocsso()->signup($user);
  }

  public function onUserLogoutAfter($event)
  {
    Engine_Api::_()->eocsso()->logout();
  }

  public function onRenderLayoutDefault($event, $mode = null)
  {
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
    $actionName = $request->getActionName();
    $controllerName = $request->getControllerName();
    if ($moduleName == "user" && $controllerName == "signup" && $actionName == "index") {
      if (!empty($_SESSION['User_Plugin_Signup_Account']['data'])) {
        $_SESSION['eocsso'] = $_SESSION['User_Plugin_Signup_Account']['data']['password'];
      }
      if (!empty($_SESSION['Sessociallogin_Plugin_Signup_Account']['data'])) {
        $_SESSION['eocsso'] = $_SESSION['Sessociallogin_Plugin_Signup_Account']['data']['password'];
      }
    }
  }
}
