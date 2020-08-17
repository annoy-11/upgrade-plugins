<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershorturl
 * @package    Sesmembershorturl
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2015-06-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmembershorturl_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function routeShutdown(Zend_Controller_Request_Abstract $request) {
  
    if (substr($request->getPathInfo(), 1, 5) == "admin") {
      //return;
    }
    $router = Zend_Controller_Front::getInstance()->getRouter();    
    $customurltext = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershorturl.customurltext', 'profile');
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershorturl.enablecustomurl', 1)) {
      if(empty(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershorturl.enableglobalurl', 0))) {
        $router->addRoute('user_profile', new Zend_Controller_Router_Route(':id/*', array('module' => 'user', 'controller' => 'profile', 'action' => 'index')));
      } else {  
        $customurltext = $customurltext.'/:id/*';
        $router->addRoute('user_profile', new Zend_Controller_Router_Route($customurltext, array('module' => 'user', 'controller' => 'profile', 'action' => 'index')));
      }
    }
    $params = $request->getParams();

    if($params['module'] == 'core' && ($params['action'] == 'index' || $params['action'] == "action_id") && ($params['controller'] != "index")) {
      $getUserName = Engine_Api::_()->sesmembershorturl()->getUserName($params['controller']);
      if($getUserName) {
        $user = Engine_Api::_()->getItem('user', $getUserName);
        if($params['action']  == "action_id")
          $action_id = end(explode('/',$request->getPathInfo()));
        else
          $action_id = 0;
        if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmember')) {
          $checkLevelId = Engine_Api::_()->getDbtable('homepages', 'sesmember')->checkLevelId($user->level_id, '0', 'profile');
          if($checkLevelId) {
            $request->setModuleName('sesmember');
            $request->setControllerName('profile');
            $request->setActionName('index');
            $request->setParam('action', 'index');
            $request->setParam('module', 'user');
            $request->setParam('controller', 'profile');
            $request->setParams(array('id' => $getUserName,'action_id'=>$action_id));
          } else {
            $request->setModuleName('user');
            $request->setControllerName('profile');
            $request->setActionName('index');
            $request->setParam('action', 'index');
            $request->setParam('module', 'user');
            $request->setParam('controller', 'profile');
            $request->setParams(array('id' => $getUserName,'action_id'=>$action_id));
          }
        } else {
          $request->setModuleName('user');
          $request->setControllerName('profile');
          $request->setActionName('index');
          $request->setParam('action', 'index');
          $request->setParam('module', 'user');
          $request->setParam('controller', 'profile');
          $request->setParams(array('id' => $getUserName,'action_id'=>$action_id));
        }
      }
    }
  }
}