<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Edeletedmember
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manifest.php 2019-11-04 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'edeletedmember',
    //'sku' => 'edeletedmember',
    'version' => '4.10.5',
    'dependencies' => array(
      array(
        'type' => 'module',
        'name' => 'core',
        'minVersion' => '4.10.5',
      ),
    ),
    'path' => 'application/modules/Edeletedmember',
    'title' => 'SNS - Deleted Members Plugin',
    'description' => 'SNS - Deleted Members Plugin',
     'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' =>
          array (
              'path' => 'application/modules/Edeletedmember/settings/install.php',
              'class' => 'Edeletedmember_Installer',
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
      0 => 'application/modules/Edeletedmember',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/edeletedmember.csv',
    ),
  ),
  'items' => array(
  
  ),
  
  'hooks' => array(
    array(
      'event' => 'onUserDeleteBefore',
      'resource' => 'Edeletedmember_Plugin_Core',
    ),
  ),
  'routes' => array(

  ),
);
