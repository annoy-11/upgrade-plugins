<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$notesRoute = "pagenotes";
$noteRoute = "pagenote";
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
  $notesRoute = $setting->getSetting('sespagenote.notes.manifest', 'pagenotes');
  $noteRoute = $setting->getSetting('sespagenote.note.manifest', 'pagenote');
}
return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sespagenote',
        //'sku' => 'sespagenote',
        'version' => '4.10.5',
        'path' => 'application/modules/Sespagenote',
        'title' => 'SES - Page Notes Extension',
        'description' => 'SES - Page Notes Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sespagenote/settings/install.php',
            'class' => 'Sespagenote_Installer',
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
            0 => 'application/modules/Sespagenote',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sespagenote.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'pagenote',
    ),
    'routes' => array(
        'sespagenote_general' => array(
            'route' => $notesRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sespagenote',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(home|create|share|tags|edit|delete|browse)',
            )
        ),
        'sespagenote_view' => array(
            'route' => $noteRoute.'/:pagenote_id/:slug/*',
            'defaults' => array(
                'module' => 'sespagenote',
                'controller' => 'index',
                'action' => 'view',
                'slug' => '',
            ),
        ),
    ),
);
