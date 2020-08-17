<?php

class Seslocation_Plugin_Core
{
  
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
		
		
    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
								 .'application/modules/Seslocation/externals/scripts/core.js');

	}
   public function onUserDeleteBefore($event)
  {
    $payload = $event->getPayload();
    if ($payload instanceof User_Model_User) {
      $user_id = $payload->getIdentity();
    }
  }
  public function onUserDeleteAfter($event)
  {
    $payload = $event->getPayload();
    if ($payload instanceof User_Model_User) {
      $user_id = $payload->getIdentity();
    }
  }
}
