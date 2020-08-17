<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$quotesRoute = "quotes";
$quoteRoute = 'quote';
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
  $quotesRoute = $setting->getSetting('sesquote.quotes.manifest', 'quotes');
  $quoteRoute = $setting->getSetting('sesquote.quote.manifest', 'quote');
}
return array (
  'package' => array(
    'type' => 'module',
    'name' => 'sesquote',
    //'sku' => 'sesquote',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesquote',
    'title' => 'SES - Quotes Plugin',
    'description' => 'SES - Quotes Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
        'install',
        'upgrade',
        'refresh',
        'enable',
        'disable',
    ),
    'callback' => array(
        'path' => 'application/modules/Sesquote/settings/install.php',
        'class' => 'Sesquote_Installer',
    ),
    'directories' => array(
        'application/modules/Sesquote',
    ),
    'files' => array(
        'application/languages/en/sesquote.csv',
    ),
  ),
  'items' => array(
    'sesquote_quote', 'sesquote_category',
  ),
  // Compose -------------------------------------------------------------------
  'composer' => array(
    'quote' => array(
      'script' => array('_composequote.tpl', 'sesquote'),
      'plugin' => 'Sesquote_Plugin_QuoteComposer',
    ),
  ),
  //Hooks
  'hooks' => array(
    array(
      'event' => 'onRenderLayoutDefault',
      'resource' => 'Sesquote_Plugin_Core'
    ),
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'sesquote_category' => array(
      'route' => $quotesRoute.'/categories/:action/*',
      'defaults' => array(
        'module' => 'sesquote',
        'controller' => 'category',
        'action' => 'browse',
      ),
    ),
    'sesquote_specific' => array(
      'route' => $quotesRoute.'/:action/:quote_id/*',
      'defaults' => array(
        'module' => 'sesquote',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'quote_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'sesquote_entry_view' => array(
      'route' => $quotesRoute.'/:user_id/:quote_id/:slug',
      'defaults' => array(
        'module' => 'sesquote',
        'controller' => 'index',
        'action' => 'view',
        'slug' => '',
      ),
      'reqs' => array(
        'user_id' => '\d+',
        'quote_id' => '\d+'
      ),
    ),
    'sesquote_general' => array(
      'route' => $quotesRoute.'/:action/*',
      'defaults' => array(
        'module' => 'sesquote',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'action' => '(index|create|manage)',
      ),
    ),
  ),
);
