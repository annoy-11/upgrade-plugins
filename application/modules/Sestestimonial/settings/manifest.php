<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$testimonialsRoute = "testimonials";
$testimonialRoute = 'testimonial';
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
  $testimonialsRoute = $setting->getSetting('sestestimonial.testimonials.manifest', 'testimonials');
  $testimonialRoute = $setting->getSetting('sestestimonial.testimonial.manifest', 'testimonial');
}

return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sestestimonial',
      //'sku' => 'sestestimonial',
      'version' => '4.10.5',
	  'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
      'path' => 'application/modules/Sestestimonial',
      'title' => 'SES - Testimonial Showcase Plugin',
      'description' => 'SES - Testimonial Showcase Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sestestimonial/settings/install.php',
          'class' => 'Sestestimonial_Installer',
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
          0 => 'application/modules/Sestestimonial',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sestestimonial.csv',
      ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'testimonial'
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    // Public
    'sestestimonial_specific' => array(
      'route' => $testimonialRoute.'/:action/:testimonial_id/*',
      'defaults' => array(
        'module' => 'sestestimonial',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'testimonial_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'sestestimonial_entry_view' => array(
      'route' => $testimonialsRoute.'/:testimonial_id/:slug',
      'defaults' => array(
        'module' => 'sestestimonial',
        'controller' => 'index',
        'action' => 'view',
        'slug' => '',
      ),
    ),
    'sestestimonial_general' => array(
      'route' => $testimonialsRoute.'/:action/*',
      'defaults' => array(
        'module' => 'sestestimonial',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'action' => '(index|create|manage)',
      ),
    ),
  ),
);
