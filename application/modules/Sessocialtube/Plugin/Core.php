<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_Plugin_Core {
	
	public function onRenderLayoutDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	
  public function onRenderLayoutDefault($event) {
  
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    
    $headScript = new Zend_View_Helper_HeadScript();
    
    //Theme Responsive Layout work
    $theme_name = $view->layout()->themes[0];
    $enable_responseive_leyout = Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_responsive_layout');
    if ($theme_name == 'sessocialtube' && $enable_responseive_leyout == '1') {
      include APPLICATION_PATH . '/application/modules/Sessocialtube/views/scripts/responsive_layout.tpl';
    }
    
    $request = Zend_Controller_Front::getInstance()->getRequest();
		$module = $request->getModuleName();
    $controller = $request->getControllerName();
    $action = $request->getActionName(); 
    if($action == 'login' || $controller == 'signup' || $action == 'requireuser') {
      $view->headLink()->appendStylesheet(Zend_Registry::get('StaticBaseUrl').'application/modules/Sessocialtube/externals/styles/login-signup.css');
    }
    
    $base_url = Zend_Registry::get('StaticBaseUrl');
    $headScript->appendFile($base_url . 'externals/autocompleter/Observer.js')->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');

    $script = '';
    $script .= <<<EOF
  //Cookie get and set function
  function setCookieSessocialtube(cname, cvalue, exdays, ddd) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires+"; path=/"; 
  } 

  function getCookieSessocialtube(cname) {
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

}
