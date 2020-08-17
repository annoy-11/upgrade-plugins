<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesminify
 * @package    Sesminify
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2017-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sesminify',
    //'sku' => 'sesminify',
    'version' => '5.2.1',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '5.0.0',
        ),
    ),
    'path' => 'application/modules/Sesminify',
    'title' => 'SES - JS & CSS Minify Plugin',
    'description' => 'SES - JS & CSS Minify Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
      'path' => 'application/modules/Sesminify/settings/install.php',
      'class' => 'Sesminify_Installer',
    ),
    'actions' =>
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'enable',
      4 => 'disable',
    ),
    'directories' =>
    array (
      'application/modules/Sesminify',
      'sesminify',
    ),
    'files' =>
    array (
      'application/languages/en/sesminify.csv',
      'externals/ses-scripts/sesJquery.js',
    ),
  ),
);
