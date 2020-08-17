<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onRenderLayoutDefault($event, $mode = null) {

    $view = $event->getPayload();
    $front = Zend_Controller_Front::getInstance();
    $module = $front->getRequest()->getModuleName();
    $controller = $front->getRequest()->getControllerName();
    $action = $front->getRequest()->getActionName();

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    if (!($view instanceof Zend_View_Interface)) {
      return;
    }

    $base_url = ( _ENGINE_SSL ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . Zend_Registry::get('Zend_View')->baseUrl();
    $final_lock_url = $base_url . '/sesprofilelock/index';

    if (isset($_SESSION['sesuserlocked']) && $module == 'core' && $controller == 'index' && $action == 'index') {
      unset($_SESSION['sesuserlocked']);
    }

    if (isset($_SESSION['sesuserlocked']) && $_SESSION['sesuserlocked']) {
      header("Location: $final_lock_url");
    }

    if ($viewer_id && $viewer->password) {
      $script = <<<EOF
  window.addEventListener('keydown', function(event) { 
    if (event.altKey && event.keyCode == 76) { 
      var url = en4.core.baseUrl + 'sesprofilelock/index/locked';
      window.location = url;
    }
  });
EOF;
      $view->headScript()->appendScript($script);
    }
  }
}