<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesletteravatar
 * @package    Sesletteravatar
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2017-12-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
        'type' => 'module',
        'name' => 'sesletteravatar',
        'sku' => 'sesletteravatar',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesletteravatar',
        'title' => 'SES - Letter Avatar of Member Name Plugin',
        'description' => 'SES - Letter Avatar of Member Name Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesletteravatar/settings/install.php',
            'class' => 'Sesletteravatar_Installer',
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
            0 => 'application/modules/Sesletteravatar',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sesletteravatar.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
      array(
        'event' => 'onUserCreateAfter',
        'resource' => 'Sesletteravatar_Plugin_Core',
      ),
      array(
        'event' => 'onUserUpdateAfter',
        'resource' => 'Sesletteravatar_Plugin_Core',
      ),
    ),
  // Items ---------------------------------------------------------------------
  'items' => array(
  ),
);
