<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Errors.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_Controller_Action_Helper_Errors extends Zend_Controller_Action_Helper_Abstract {

  function postDispatch() {

    $front = Zend_Controller_Front::getInstance();

    $module = $front->getRequest()->getModuleName();
    $action = $front->getRequest()->getActionName();
    $controller = $front->getRequest()->getControllerName();
    $request = $this->getActionController()->getRequest();

    $getParamrequest = $request->getParams();
    $getModuleName = @$getParamrequest['module'];

    $pagenotfound301redirect = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.pagenotfound301redirect', 0);
    if($pagenotfound301redirect && empty($_SERVER['HTTP_REFERER']) && $module == 'core' && $controller == 'error' && $action == 'notfound') {
      header("HTTP/1.1 301 Moved Permanently");
      $base_url = ( _ENGINE_SSL ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . Zend_Registry::get('Zend_View')->baseUrl();
      $url = $base_url;
      header("Location:" . $url);
      exit();
    }

    //Here, we can make a condition for private page and page not found page.
    $privateenable = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.privateenable', 1);
    $pagenotfoundenable = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.pagenotfoundenable', 1);
    if ($module == 'core' && $controller == 'error' && $action == 'requireauth' && !empty($privateenable)) {
      $request->setModuleName('seserror');
      $request->setControllerName('error');
      $request->setActionName('index');
      $request->setParams(array('error' => 'requireauth', 'modulename' => $getModuleName));
    } elseif ($module == 'core' && $controller == 'error' && $action ==  'requiresubject' && !empty($privateenable)) {
      $request->setModuleName('seserror');
      $request->setControllerName('error');
      $request->setActionName('index');
      $request->setParams(array('error' => 'requireauth', 'modulename' => $getModuleName));
    } elseif ($module == 'core' && $controller == 'error' && $action == 'notfound' && !empty($pagenotfoundenable)) {
      $request->setModuleName('seserror');
      $request->setControllerName('error');
      $request->setActionName('view');
      //$request->setParams(array('error' => 'notfound', 'modulename' => $getModuleName));
    }
  }

}
