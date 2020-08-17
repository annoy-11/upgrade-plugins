<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$offersRoute = "pageoffers";
$offerRoute = "pageoffer";
$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !($module1 == 'default' && (strpos($_SERVER['REQUEST_URI'],'/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $offersRoute = $setting->getSetting('sespageoffer.offers.manifest', 'pageoffers');
  $offerRoute = $setting->getSetting('sespageoffer.offer.manifest', 'pageoffer');
}
return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sespageoffer',
        'version' => '4.10.5',
        'path' => 'application/modules/Sespageoffer',
        'title' => 'SES - Page Offers Extension',
        'description' => 'SES - Page Offers Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sespageoffer/settings/install.php',
            'class' => 'Sespageoffer_Installer',
        ),
        'actions' =>
        array(
            0 => 'install',
            1 => 'upgrade',
            2 => 'refresh',
            3 => 'enable',
            4 => 'disable',
        ),
        'directories' =>
        array(
            0 => 'application/modules/Sespageoffer',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sespageoffer.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'pageoffer','sespageoffer_claim',
    ),
    'routes' => array(
        'sespageoffer_general' => array(
            'route' => $offersRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sespageoffer',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(home|create|share|edit|delete|browse|getoffer)',
            )
        ),
        'sespageoffer_view' => array(
            'route' => $offerRoute.'/:pageoffer_id/:slug/*',
            'defaults' => array(
                'module' => 'sespageoffer',
                'controller' => 'index',
                'action' => 'view',
                'slug' => '',
            ),
        ),
    ),
);
