<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$offersRoute = "businessoffers";
$offerRoute = "businessoffer";
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
  $offersRoute = $setting->getSetting('sesbusinessoffer.offers.manifest', 'businessoffers');
  $offerRoute = $setting->getSetting('sesbusinessoffer.offer.manifest', 'businessoffer');
}
return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesbusinessoffer',
        'version' => '4.10.5',
        'path' => 'application/modules/Sesbusinessoffer',
        'title' => 'SES - Business Offers Extension',
        'description' => 'SES - Business Offers Extension',
        'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesbusinessoffer/settings/install.php',
            'class' => 'Sesbusinessoffer_Installer',
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
            0 => 'application/modules/Sesbusinessoffer',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sesbusinessoffer.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'businessoffer','sesbusinessoffer_claim',
    ),
    'routes' => array(
        'sesbusinessoffer_general' => array(
            'route' => $offersRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sesbusinessoffer',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(home|create|share|edit|delete|browse|getoffer)',
            )
        ),
        'sesbusinessoffer_view' => array(
            'route' => $offerRoute.'/:businessoffer_id/:slug/*',
            'defaults' => array(
                'module' => 'sesbusinessoffer',
                'controller' => 'index',
                'action' => 'view',
                'slug' => '',
            ),
        ),
    ),
);
