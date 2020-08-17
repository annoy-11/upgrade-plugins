<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  public function __construct($application) {
    parent::__construct($application);
    $this->initViewHelperPath();
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesteam_Plugin_Core);
  }

  protected function _initRouter() {

    $router = Zend_Controller_Front::getInstance()->getRouter();
    $setting = Engine_Api::_()->getApi('settings', 'core');

    if ($setting->getSetting('sesteam.pluginactivated')) {

      $teamRoute = $setting->getSetting('sesteam.urlmanifest', 'team');
      $routes = array();
      $router->addRoute("sesteam_teampage", new Zend_Controller_Router_Route($teamRoute . '/:action/*', array('module' => 'sesteam', "controller" => "index", "action" => "team"), array('reqs' => '(team|nonsiteteam|browse|browsenonsiteteam)')));

      $router->addRoute("sesteam_nonsiteteam", new Zend_Controller_Router_Route($teamRoute . '/:team_id/:slug/*', array('module' => 'sesteam', "controller" => "index", "action" => "view", 'slug' => ''), array('team_id' => '\d+')));
    }
  }

}