<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array (
  'package' =>
  array(
    'type' => 'module',
    'name' => 'sesseo',
    //'sku' => 'sesseo',
    'version' => '4.10.5p1',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesseo',
    'title' => 'SES - Advanced SEO & Sitemaps Plugin',
    'description' => 'SES - Advanced SEO & Sitemaps Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
        'path' => 'application/modules/Sesseo/settings/install.php',
        'class' => 'Sesseo_Installer',
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
        0 => 'application/modules/Sesseo',
    ),
    'files' =>
    array(
      0 => 'application/languages/en/sesseo.csv',
      1 => 'public/admin/social_share.jpg',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesseo_managemetatag', 'sesseo_content',
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onRenderLayoutDefault',
      'resource' => 'Sesseo_Plugin_Core'
    ),
  ),
);
