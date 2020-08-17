<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manifest.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

return array (
  'package' =>
  array(
    'type' => 'module',
    'name' => 'einstaclone',
    //'sku' => 'einstaclone',
    'version' => '5.2.1',
    'dependencies' => array(
      array(
        'type' => 'module',
        'name' => 'core',
        'minVersion' => '5.0.0',
      ),
    ),
    'path' => 'application/modules/Einstaclone',
    'title' => 'SNS - Insta Clone Theme',
    'description' => 'SNS - Insta Clone Theme',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
        'path' => 'application/modules/Einstaclone/settings/install.php',
        'class' => 'Einstaclone_Installer',
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
        0 => 'application/modules/Einstaclone',
        1 => 'application/themes/einstaclone',
    ),
    'files' =>
    array(
        0 => 'application/languages/en/einstaclone.csv',
    ),
  ),
  'items' => array(
    'einstaclone_customthemes',
    'einstaclone_managesearchoptions',
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'einstaclone_default' => array(
      'route' => 'explore/*',
      'defaults' => array(
        'module' => 'einstaclone',
        'controller' => 'index',
        'action' => 'explore'
      )
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onRenderLayoutDefault',
      'resource' => 'Einstaclone_Plugin_Core'
    )
  ),
);
