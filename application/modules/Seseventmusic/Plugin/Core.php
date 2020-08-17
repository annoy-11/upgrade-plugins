<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onRenderLayoutDefault($event, $mode = null) {

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
    $viewer = Engine_Api::_()->user()->getViewer();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $view->headScript()->appendFile($view->layout()->staticBaseUrl . 'externals/soundmanager/script/soundmanager2' . (APPLICATION_ENV == 'production' ? '-nodebug-jsmin' : '' ) . '.js');
    $view->headScript()->appendFile($view->layout()->staticBaseUrl . 'application/modules/Seseventmusic/externals/scripts/core.js');
    $view->headScript()->appendFile($view->layout()->staticBaseUrl . 'application/modules/Seseventmusic/externals/scripts/player.js');
    $view->headLink()->appendStylesheet($view->layout()->staticBaseUrl . 'application/modules/Seseventmusic/externals/styles/player.css');

    $script = <<<EOF
  //Cookie get and set function
  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires+"; path=/"; 
  } 

  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
    }
    return "";
  }
EOF;

    $view->headScript()->appendScript($script);
  }

  public function onRenderLayoutMobileDefault($event) {
    return $this->onRenderLayoutDefault($event);
  }

}
