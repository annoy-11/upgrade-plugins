<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$reviewsRoute = "businessreviews";
$reviewRoute = "businessreview";
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
  $reviewsRoute = $setting->getSetting('sesbusinessreview.plural.manifest', 'businessreviews');
  $reviewRoute = $setting->getSetting('sesbusinessreview.singular.manifest', 'businessreview');
}

return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesbusinessreview',
        'version' => '4.10.3',
        'path' => 'application/modules/Sesbusinessreview',
        'title' => 'SES - Business Directories - Reviews & Ratings Extension',
        'description' => 'SES - Business Directories - Reviews & Ratings Extension',
        'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesbusinessreview/settings/install.php',
            'class' => 'Sesbusinessreview_Installer',
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
            0 => 'application/modules/Sesbusinessreview',
        ),
        'files' => array(
            'application/languages/en/sesbusinessreview.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'businessreview',
        'sesbusinessreview_parameter'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sesbusinessreview_view' => array(
            'route' => $reviewRoute . '/:action/:review_id/:slug',
            'defaults' => array(
                'module' => 'sesbusinessreview',
                'controller' => 'review',
                'action' => 'view',
                'slug' => ''
            ),
            'reqs' => array(
                'action' => '(edit|view|delete|edit-review)',
                'review_id' => '\d+'
            )
        ),
        'sesbusinessreview_review' => array(
            'route' => $reviewsRoute . '/:action/*',
            'defaults' => array(
                'module' => 'sesbusinessreview',
                'controller' => 'review',
                'action' => 'browse'
            ),
            'reqs' => array(
                'action' => '(browse|home)',
            ),
        ),
    ),
);
