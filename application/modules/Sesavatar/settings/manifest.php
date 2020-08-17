<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'sesavatar',
    //'sku' => 'sesavatar',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesavatar',
    'title' => 'SES - Custom Avatar Plugin',
    'description' => 'SES - Custom Avatar Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
       'install',
       'upgrade',
       'refresh',
       'enable',
       'disable',
     ),
    'callback' => array(
      'path' => 'application/modules/Sesavatar/settings/install.php',
      'class' => 'Sesavatar_Installer',
    ),
    'directories' => array(
      'application/modules/Sesavatar',
    ),
    'files' => array(
      'application/languages/en/sesavatar.csv',
    ),
  ),
  //Items
  'items' => array(
    'sesavatar_image', 'sesavatar_avatar'
  ),
);
