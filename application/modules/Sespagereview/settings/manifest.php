<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$reviewsRoute = "pagereviews";
$reviewRoute = "pagereview";
$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !($module1 == 'default' && (strpos($_SERVER['REQUEST_URI'], '/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $reviewsRoute = $setting->getSetting('sespagereview.plural.manifest', 'pagereviews');
  $reviewRoute = $setting->getSetting('sespagereview.singular.manifest', 'pagereview');
}

return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sespagereview',
        'version' => '4.10.5',
        'path' => 'application/modules/Sespagereview',
        'title' => 'SES - Page Directories - Reviews & Ratings Extension',
        'description' => 'SES - Page Directories - Reviews & Ratings Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sespagereview/settings/install.php',
            'class' => 'Sespagereview_Installer',
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
            0 => 'application/modules/Sespagereview',
        ),
        'files' => array(
            'application/languages/en/sespagereview.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'pagereview',
        'sespagereview_parameter'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sespagereview_view' => array(
            'route' => $reviewRoute . '/:action/:review_id/:slug',
            'defaults' => array(
                'module' => 'sespagereview',
                'controller' => 'review',
                'action' => 'view',
                'slug' => ''
            ),
            'reqs' => array(
                'action' => '(edit|view|delete|edit-review)',
                'review_id' => '\d+'
            )
        ),
        'sespagereview_review' => array(
            'route' => $reviewsRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sespagereview',
                'controller' => 'review',
                'action' => 'browse'
            ),
            'reqs' => array(
                'action' => '(browse|home)',
            ),
        ),
    ),
);
