<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesbrowserpush',
      //'sku' => 'sesbrowserpush',
      'version' => '5.2.1',
      'dependencies' => array(
        array(
          'type' => 'module',
          'name' => 'core',
          'minVersion' => '5.0.0',
        ),
      ),
      'path' => 'application/modules/Sesbrowserpush',
      'title' => 'SES - Web & Mobile Browser Push Notifications Plugin',
      'description' => 'SES - Web & Mobile Browser Push Notifications Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesbrowserpush/settings/install.php',
          'class' => 'Sesbrowserpush_Installer',
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
          0 => 'application/modules/Sesbrowserpush',
      ),
      'files' =>
      array(
        'externals/ses-scripts/sesJquery.js',
        'application/languages/en/sesbrowserpush.csv',
        'firebase-messaging-sw.js',
        'manifest.json',
      ),
  ),
  // Items --------------------------------------------------------------------
  'items' => array(
    'sesbrowserpush_scheduled', 'sesbrowserpush_token'
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
     array(
      'event' => 'onActivityNotificationCreateAfter',
      'resource' => 'Sesbrowserpush_Plugin_Core',
     ),


  ),
);
