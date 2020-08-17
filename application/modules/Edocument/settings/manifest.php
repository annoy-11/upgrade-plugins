<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$documentsRoute = "documents";
$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !((strpos($_SERVER['REQUEST_URI'],'/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $documentsRoute = $setting->getSetting('edocument.documents.manifest', 'documents');
  $documentRoute = $setting->getSetting('edocument.document.manifest', 'document');
}

return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'edocument',
        'sku' => 'edocument',
        'version' => '4.10.3p5',
        'path' => 'application/modules/Edocument',
        'title' => 'SES - Documents Sharing Plugin',
        'description' => 'SES - Documents Sharing Plugin',
        'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
        'callback' => array(
            'path' => 'application/modules/Edocument/settings/install.php',
            'class' => 'Edocument_Installer',
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
            0 => 'application/modules/Edocument',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/edocument.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Edocument_Plugin_Core',
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Edocument_Plugin_Core',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'edocument_category',
        'edocument',
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'edocument_specific' => array(
            'route' => $documentsRoute.'/:action/:edocument_id/*',
            'defaults' => array(
                'module' => 'edocument',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'edocument_id' => '\d+',
                'action' => '(delete|edit)',
            ),
        ),
        'edocument_general' => array(
            'route' => $documentsRoute.'/:action/*',
            'defaults' => array(
                'module' => 'edocument',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(home|index|browse|create|manage|tag|tags)',
            ),
        ),
        'edocument_category' => array(
            'route' => $documentsRoute . '/categories/:action/*',
            'defaults' => array(
                'module' => 'edocument',
                'controller' => 'category',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse)',
            )
        ),
        'edocument_dashboard' => array(
            'route' => $documentsRoute.'/dashboard/:action/:edocument_id/*',
            'defaults' => array(
                'module' => 'edocument',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
            'reqs' => array(
                'action' => '(edit|edit-photo|remove-photo|fields|seo|email)',
            )
        ),
		'edocument_category_view' => array(
		    'route' => $documentsRoute.'/category/:category_id/*',
		    'defaults' => array(
		        'module' => 'edocument',
		        'controller' => 'category',
		        'action' => 'index',
		    )
		),
        'edocument_entry_view' => array(
            'route' => $documentRoute.'/:edocument_id/*',
            'defaults' => array(
                'module' => 'edocument',
                'controller' => 'index',
                'action' => 'view',
            ),
        ),
    ),
);
