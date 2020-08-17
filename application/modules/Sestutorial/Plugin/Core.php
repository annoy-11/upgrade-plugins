<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestutorial
 * @package    Sestutorial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2015-06-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestutorial_Plugin_Core
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
  
	public function onRenderLayoutDefault($event,$mode=null) {
	
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		
		$viewer = Engine_Api::_()->user()->getViewer();
		
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();
		
		$menuredirection = Engine_Api::_()->getApi('settings', 'core')->getSetting('sestutorial.menuredirection',3);
		
		if($menuredirection == 2 && $actionName == 'home' && $controllerName == 'index' && $moduleName == 'sestutorial'){
		  $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
		  $redirector->gotoRoute(array('module' => 'sestutorial', 'controller' => 'index', 'action' => 'browse'), 'sestutorial_general', false);
		}
		$headScript = new Zend_View_Helper_HeadScript();
		$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'externals/ses-scripts/sesJquery.js');
		$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sestutorial/externals/scripts/core.js');
		
	}

  public function onUserDeleteAfter($event) {
  
    $payload = $event->getPayload();
    $user_id = $payload['identity'];
    $table   = Engine_Api::_()->getDbTable('tutorials', 'sestutorial');
    $select = $table->select()->where('user_id = ?', $user_id);
    $rows = $table->fetchAll($select);
    foreach ($rows as $row) {
      $row->delete();
    }
  }
}