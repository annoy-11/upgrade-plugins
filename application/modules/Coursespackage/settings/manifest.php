<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursespackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Icon.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

 return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'coursespackage',
    'version' => '4.10.5',
    'path' => 'application/modules/Coursespackage',
    'title' => 'Course package',
    'description' => '',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => 
    array (
      'class' => 'Engine_Package_Installer_Module',
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
      0 => 'application/modules/Coursespackage',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/coursespackage.csv',
    ),
  ),
   // Items ---------------------------------------------------------------------
    'items' => array(
        'coursespackage_package',
        'coursespackage_orderspackage',
        'coursespackage_gateway',
        'coursespackage_transaction'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'coursespackage_general' => array(
            'route' => 'coursepackage/:action/*',
            'defaults' => array(
                'module' => 'coursespackage',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(classroom|confirm-upgrade|cancel)',
            )
        ),
        'coursespackage_payment' => array(
            'route' => 'coursepayment/:action/*',
            'defaults' => array(
                'module' => 'coursespackage',
                'controller' => 'payment',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(index|process|return|finish|fill-details)',
            )
        )
    ),
); ?>
