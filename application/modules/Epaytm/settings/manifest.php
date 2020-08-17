<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epaytm
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manifest.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'epaytm',
    'version' => '4.10.5',
    'dependencies' => array(
      array(
        'type' => 'module',
        'name' => 'core',
        'minVersion' => '4.10.5',
      ),
    ),
    'path' => 'application/modules/Epaytm',
    'title' => 'Paytm Payment Gateway',
    'description' => 'Paytm Payment Gateway',
    'author' => '<a href="http://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => 
    array (
      'path' => 'application/modules/Epaytm/settings/install.php',
      'class' => 'Epaytm_Installer',
    ),
    'actions' => 
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
    ),
    'directories' => 
    array (
      0 => 'application/modules/Epaytm',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/epaytm.csv',
    ),
  ),
  'routes' => array(
    'epaytm_payment' => array(
      'route' => 'paytm/payment/:action/*',
      'defaults' => array(
          'module' => 'epaytm',
          'controller' => 'payment',
          'action' => 'index',
      ),
    ),
  )
);
