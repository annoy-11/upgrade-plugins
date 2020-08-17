<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesdbslide
 * @package Sesdbslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: manifest.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */

return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesdbslide',
      //'sku' => 'sesdbslide',
      'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
      'path' => 'application/modules/Sesdbslide',
      'title' => 'SES - Double Banner Slideshow Plugin',
      'description' => 'SES - Double Banner Slideshow Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesdbslide/settings/install.php',
          'class' => 'Sesdbslide_Installer',
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
          0 => 'application/modules/Sesdbslide',
      ),

      'files' =>
      array(
          0 => 'application/languages/en/sesdbslide.csv',
      ),
  ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesdbslide_gallery',
        'sesdbslide_slide',
    ),
);
