<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesuserdocverification',
      //'sku' => 'sesuserdocverification',
      'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
      'path' => 'application/modules/Sesuserdocverification',
      'title' => 'SES - Member Verification via KYC Documents Plugin',
      'description' => 'SES - Member Verification via KYC Documents Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesuserdocverification/settings/install.php',
          'class' => 'Sesuserdocverification_Installer',
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
          0 => 'application/modules/Sesuserdocverification',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sesuserdocverification.csv',
      ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesuserdocverification_document', 'sesuserdocverification_documenttype',
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    // User - General
    'sesuserdocverification_extended' => array(
      'route' => 'userdocuments/:controller/:action/*',
      'defaults' => array(
        'module' => 'sesuserdocverification',
        'controller' => 'settings',
        'action' => 'manage'
      ),
    ),
  ),
);
