<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespoke_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  protected function _initRouter() {

    $router = Zend_Controller_Front::getInstance()->getRouter();
    $setting = Engine_Api::_()->getApi('settings', 'core');

    if ($setting->getSetting('sespoke.pluginactivated')) {

      $pokeRoute = $setting->getSetting('sespoke.urlmanifest', 'pokes');
      $routes = array();
      $router->addRoute("sespoke_pokepage", new Zend_Controller_Router_Route($pokeRoute . '/:action/*', array('module' => 'sespoke', "controller" => "index", "action" => "index"), array('reqs' => '(index)')));
    }
  }

}
