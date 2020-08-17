<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagethm_Plugin_Core extends Zend_Controller_Plugin_Abstract{

   public function routeShutdown(Zend_Controller_Request_Abstract $request) {

    if (substr($request->getPathInfo(), 1, 5) == "admin") {
      $params = $request->getParams();
      if($params['module'] == 'sespagethm' &&  $params['controller'] == "admin-menu") {
        $request->setModuleName('sesbasic');
        $request->setControllerName('admin-menu');
        $request->setActionName($params['action']);
        $request->setParam('moduleName', 'sespagethm');

      }
    }
   }

  public function onRenderLayoutDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }

  public function onRenderLayoutDefault($event) {

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    $headScript = new Zend_View_Helper_HeadScript();

    //Google Font Work
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $usegoogleFont = $settings->getSetting('sespagethm.googlefonts', 0);
    if(!empty($usegoogleFont)) {
      $string = 'https://fonts.googleapis.com/css?family=';

      $bodyFontFamily = Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_body_fontfamily');
      $string .= str_replace('"', '', $bodyFontFamily);

      $headingFontFamily = Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_heading_fontfamily');
      $string .= '|'.str_replace('"', '', $headingFontFamily);

      $mainmenuFontFamily = Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_mainmenu_fontfamily');
      $string .= '|'.str_replace('"', '', $mainmenuFontFamily);

      $tabFontFamily = Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_tab_fontfamily');
      $string .= '|'.str_replace('"', '', $tabFontFamily);;

      $view->headLink()->appendStylesheet($string);

    }

    //Theme Responsive Layout work
    $theme_name = $view->layout()->themes[0];
    $enable_responseive_leyout = Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_responsive_layout');
    if ($theme_name == 'sespagethm' && $enable_responseive_leyout == '1') {
      include APPLICATION_PATH . '/application/modules/Sespagethm/views/scripts/responsive_layout.tpl';

    }

    $base_url = Zend_Registry::get('StaticBaseUrl');
    $headScript->appendFile($base_url . 'externals/autocompleter/Observer.js')->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');

    $script = '';
    $script .= <<<EOF
  //Cookie get and set function
  function setCookieSpectromedia(cname, cvalue, exdays, ddd) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires+"; path=/";
  }

  function getCookieSpectromedia(cname) {
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
