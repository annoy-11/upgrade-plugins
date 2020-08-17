<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
        'type' => 'module',
        'name' => 'sesshoutbox',
        //'sku' => 'sesshoutbox',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesshoutbox',
        'title' => 'SES - Shoutbox Plugin',
        'description' => 'SES - Shoutbox Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesshoutbox/settings/install.php',
            'class' => 'Sesshoutbox_Installer',
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
            0 => 'application/modules/Sesshoutbox',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sesshoutbox.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sesshoutbox_Plugin_Core',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesshoutbox_shoutbox', 'sesshoutbox_content'
    ),
);
