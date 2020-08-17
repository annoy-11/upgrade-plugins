<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2015-03-10 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onRenderLayoutDefault($event, $mode = null) {

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$script='';
    if ($moduleName == 'sesteam') {
      $script .= "
        window.addEvent('domready', function() {
         $$('.custom_492').getParent().addClass('active');
        });";
        $view->headScript()->appendScript($script);
    }
    
  }

  public function routeShutdown(Zend_Controller_Request_Abstract $request) {

    if (substr($request->getPathInfo(), 1, 5) == "admin") {
      return;
    }
    $eneblebrowse = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesteam.eneblebrowse.members', 0);
    $module = $request->getModuleName();
    $controller = $request->getControllerName();
    $action = $request->getActionName();
    if (!empty($eneblebrowse) && $module == "user") {
      if ($controller == "index" && $action == "browse") {
        $request->setModuleName('sesteam');
        $request->setControllerName('index');
        $request->setActionName('browse-members');
        $request->setParam('module', 'sesteam');
        $request->setParam('controller', 'index');
        $request->setParam('action', 'browse-members');
      }
    }
  }

  public function onUserDeleteBefore($event) {
    $payload = $event->getPayload();
    if ($payload instanceof User_Model_User) {
      Engine_Api::_()->getDbtable('teams', 'sesteam')->delete(array('user_id = ?' => $payload->getIdentity()));
    }
  }

}
