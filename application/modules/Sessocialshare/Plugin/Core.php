<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Plugin.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialshare_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function routeShutdown(Zend_Controller_Request_Abstract $request) {
    
    $front = Zend_Controller_Front::getInstance();

    $module = $request->getModuleName();
    $controller = $request->getControllerName();
    $action = $request->getActionName();

    if (($module == "sesadvancedactivity" || $module == "activity" || $module == 'sesvideo' || $module == 'sesalbum' || $module == 'sesblog') && $controller == "index" && $action == "share") {
      $getParams =  $front->getRequest()->getParams();
      $request->setModuleName('sessocialshare');
      $request->setControllerName('index');
      $request->setActionName('share');
      if($module == 'sesalbum') {
        $request->setParams(array('type' => $getParams['type'], 'id' => $getParams['photo_id']));
      } else {
        $request->setParams(array('type' => $getParams['type'], 'id' => $getParams['id']));
      }
    }
  }
}