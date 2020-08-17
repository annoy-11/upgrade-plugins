<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$qandasRoute = "questions";
$qandaRoute = "question";
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
  $qandasRoute = $setting->getSetting('qanda.qandas.manifest', 'questions');
  $videoRoute = $setting->getSetting('qanda.qanda.manifest', 'question');
}

return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sesqa',
    //'sku' => 'sesqa',
    'version' => '5.1.0p1',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '5.0.0',
        ),
    ),
    'path' => 'application/modules/Sesqa',
    'title' => 'SES - Questions & Answers Plugin',
    'description' => 'SES - Questions & Answers Plugin',
     'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' =>
      array (
        0 => 'install',
        1 => 'upgrade',
        2 => 'refresh',
        3 => 'enable',
        4 => 'disable',
      ),
    'callback' =>
    array (
      'path' => 'application/modules/Sesqa/settings/install.php',
      'class' => 'Sesqa_Installer',
    ),

    'directories' =>
    array (
        'application/modules/Sesqa',
    ),
    'files' =>
    array (
        'application/languages/en/sesqa.csv',
        'public/admin/bg-qa.jpg',
        'externals/ses-scripts/jscolor/jscolor.js',
        'externals/ses-scripts/jquery.min.js',
        'externals/ses-scripts/odering.js',
    ),
  ),
  // Compose
    /*'composer' => array(
        'sesqa' => array(
            'script' => array('_composeQa.tpl', 'sesqa'),
            'plugin' => 'Sesqa_Plugin_Composer',
            'auth' => array('sesqa', 'create'),
        ),
    ),*/
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesqa_category','sesqa_question','sesqa_answer',
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onStatistics',
            'resource' => 'Sesqa_Plugin_Core'
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sesqa_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesqa_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sesqa_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutMobileDefault',
            'resource' => 'Sesqa_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutMobileDefaultSimple',
            'resource' => 'Sesqa_Plugin_Core'
        )
    ),
     // Routes --------------------------------------------------------------------
    'routes' => array(
         'sesqa_general' => array(
            'route' => $qandasRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sesqa',
                'controller' => 'index',
                'action' => 'browse',
            ),
        ),
        'sesqa_view' => array(
            'route' => $qandaRoute.'/:question_id/:slug/*',
            'defaults' => array(
                'module' => 'sesqa',
                'controller' => 'index',
                'action' => 'view',
                'slug' => '',
            ),
            'reqs' => array(
                'question_id' => '\d+'
            )
        ),
        'sesqa_category' => array(
            'route' => $qandasRoute . '/categories/:action/*',
            'defaults' => array(
                'module' => 'sesqa',
                'controller' => 'category',
                'action' => 'browse',
            ),
        ),
        'sesqa_category_view' => array(
            'route' => $qandasRoute . '/category/:category_id/*',
            'defaults' => array(
                'module' => 'sesqa',
                'controller' => 'category',
                'action' => 'index',
            )
        ),
        'sesqa_dashboard' => array(
            'route' => $qandasRoute.'/dashboard/:action/:question_id/*',
            'defaults' => array(
                'module' => 'sesqa',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
            'reqs' => array(
                'action' => '(edit|edit-media|edit-location)',
            )
        ),
    ),
);
