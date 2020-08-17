<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

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
  $faqsRoute = $setting->getSetting('sesfaq.faqs.manifest', 'faqs');
  $faqRoute = $setting->getSetting('sesfaq.faq.manifest', 'faq');
}
return array(
  'package' => array(
    'type' => 'module',
    'name' => 'sesfaq',
    //'sku' => 'sesfaq',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesfaq',
    'title' => 'SES - Multi - Use FAQs Plugin',
    'description' => 'SES - Multi - Use FAQs Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
        'path' => 'application/modules/Sesfaq/settings/install.php',
        'class' => 'Sesfaq_Installer',
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
      'application/modules/Sesfaq',
      'externals/ses-scripts/jscolor',
    ),
    'files' =>
    array(
      'application/languages/en/sesfaq.csv',
      'externals/ses-scripts/jquery.min.js',
      'externals/ses-scripts/odering.js',
      'externals/ses-scripts/jquery.tagcanvas.min.js',
      'externals/ses-scripts/PeriodicalExecuter.js',
      'externals/ses-scripts/Carousel.js',
      'externals/ses-scripts/Carousel.Extra.js',
      'externals/ses-scripts/sesJquery.js',
      'public/admin/search-banner.jpg',
      'public/admin/faq-category-banner.jpg',
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
        'event' => 'onUserDeleteAfter',
        'resource' => 'Sesfaq_Plugin_Core'
    ),
    array(
        'event' => 'onRenderLayoutDefault',
        'resource' => 'Sesfaq_Plugin_Core'
    ),
    array(
        'event' => 'onRenderLayoutDefaultSimple',
        'resource' => 'Sesfaq_Plugin_Core'
    ),
    array(
        'event' => 'onRenderLayoutMobileDefault',
        'resource' => 'Sesfaq_Plugin_Core'
    ),
    array(
        'event' => 'onRenderLayoutMobileDefaultSimple',
        'resource' => 'Sesfaq_Plugin_Core'
    )
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesfaq_category','sesfaq_faq', 'sesfaq_faqs', 'sesfaq_askquestion'
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'sesfaq_category' => array(
      'route' => $faqsRoute . '/categories/:action/*',
      'defaults' => array(
          'module' => 'sesfaq',
          'controller' => 'category',
          'action' => 'browse',
      ),
      'reqs' => array(
          'action' => '(index|browse)',
      )
    ),
    'sesfaq_general' => array(
      'route' => $faqsRoute . '/:action/*',
      'defaults' => array(
        'module' => 'sesfaq',
        'controller' => 'index',
        'action' => 'home',
      ),
      'reqs' => array(
          'action' => '(home|browse|view|tags|askquestion)',
      ),
    ),
    'sesfaq_category_view' => array(
      'route' => $faqsRoute.'/category/:category_id/*',
      'defaults' => array(
          'module' => 'sesfaq',
          'controller' => 'category',
          'action' => 'index',
      )
    ),
    'sesfaq_profile' => array(
      'route' => $faqRoute.'/:faq_id/:slug/*',
      'defaults' => array(
          'module' => 'sesfaq',
          'controller' => 'index',
          'action' => 'view',
      ),
    ),
  ),
);
