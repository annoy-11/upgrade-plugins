<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesadvancedbanner
 * @package Sesadvancedbanner
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: manifest.php 2018-07-26 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sesadvancedbanner',
    //'sku' => 'sesadvancedbanner',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesadvancedbanner',
    'title' => 'SES - Advanced Banner Plugin',
    'description' => 'SES - Advanced Banner Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
			'path' => 'application/modules/Sesadvancedbanner/settings/install.php',
			'class' => 'Sesadvancedbanner_Installer',
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
      'application/modules/Sesadvancedbanner',
      'externals/ses-scripts/jscolor',
    ),
    'files' =>
    array (
      'application/languages/en/sesadvancedbanner.csv',
      'externals/ses-scripts/jquery.min.js',
    ),
  ),
  'items' => array(
    'sesadvancedbanner_slide','sesadvancedbanner_banner'
  ),
);
