<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Elivestreaming
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manifest.php 2019-10-01 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

 return array(
  'package' =>
  array(
    'type' => 'module',
    'name' => 'elivestreaming',
    'version' => '4.10.5',
    'dependencies' => array(
      array(
        'type' => 'module',
        'name' => 'core',
        'minVersion' => '4.10.5',
      ),
    ),
    //'sku' => 'elivestreaming',
    'path' => 'application/modules/Elivestreaming',
    'title' => 'SNS - Live Streaming - Android Mobile Apps',
    'description' => 'SNS - Live Streaming - Android Mobile Apps',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' =>
    array(
      'class' => 'Engine_Package_Installer_Module',
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
      0 => 'application/modules/Elivestreaming',
    ),
    'files' =>
    array(
      0 => 'application/languages/en/elivestreaming.csv',
    ),
  ),
     'composer' => array(
         'elivestreaming' => array(
             'script' => array('_composeStreaming.tpl', 'elivestreaming'),
             'auth' => array('elivehost', 'create'),
         ),
     ),
  'items' =>
  array(
    'elivehost',
    'elivestreaming_notificationreceiver'
  ),
     // Hooks ---------------------------------------------------------------------
     'hooks' => array(

         array(
             'event' => 'onRenderLayoutDefault',
             'resource' => 'Elivestreaming_Plugin_Core'
         ),
         array(
             'event' => 'onRenderLayoutDefaultSimple',
             'resource' => 'Elivestreaming_Plugin_Core'
         ),
         array(
             'event' => 'onRenderLayoutMobileDefault',
             'resource' => 'Elivestreaming_Plugin_Core'
         ),
         array(
             'event' => 'onRenderLayoutMobileDefaultSimple',
             'resource' => 'Elivestreaming_Plugin_Core'
         )
     ),
);
