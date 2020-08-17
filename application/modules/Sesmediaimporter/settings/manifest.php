<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
    'type' => 'module',
    'name' => 'sesmediaimporter',
    //'sku' => 'sesmediaimporter',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesmediaimporter',
    'title' => 'SES - Social Photo Media Importer Plugin',
    'description' => 'SES - Social Photo Media Importer Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
        'path' => 'application/modules/Sesmediaimporter/settings/install.php',
        'class' => 'Sesmediaimporter_Installer',
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
        0 => 'application/modules/Sesmediaimporter',
    ),
    'files' =>
    array(
        0 => 'application/languages/en/sesmediaimporter.csv',
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onUserLogoutAfter',
      'resource' => 'Sesmediaimporter_Plugin_Core',
    ),
  ),
  'routes' => array(
    'sesmediaimporter_general' => array(
      'route' =>  'media-importer/:action/*',
      'defaults' => array(
          'module' => 'sesmediaimporter',
          'controller' => 'index',
          'action' => 'index',
      ),
      'reqs' => array(
          'action' => '(index|service|fb-logout|google-logout|px500-logout|flickr-logout|instagram-logout|load-fb-gallery)',
      )
    ),
  )
);
