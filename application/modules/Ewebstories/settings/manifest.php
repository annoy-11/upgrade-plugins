<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ewebstories
 * @copyright  Copyright 2014-2020 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manifest.php 2020-03-20 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'ewebstories',
    'version' => '5.2.1',
    'dependencies' => array(
      array(
        'type' => 'module',
        'name' => 'core',
        'minVersion' => '5.0.0',
      ),
    ),
    'path' => 'application/modules/Ewebstories',
    'title' => 'SNS - Stories Feature in Website',
    'description' => 'SNS - Stories Feature in Website',
     'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' =>
    array (
        'path' => 'application/modules/Ewebstories/settings/install.php',
        'class' => 'Ewebstories_Installer',
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
      'application/modules/Ewebstories',
      'application/modules/Sesstories',
    ),
    'files' =>
    array (
      'application/languages/en/ewebstories.csv',
      'application/languages/en/sesstories.csv',
    ),
  ),
);
