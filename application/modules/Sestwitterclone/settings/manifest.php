<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sestwitterclone',
        //'sku' => 'sestwitterclone',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sestwitterclone',
        'title' => 'SES - Professional Twitter Clone Theme',
        'description' => 'SES - Professional Twitter Clone Theme',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sestwitterclone/settings/install.php',
            'class' => 'Sestwitterclone_Installer',
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
            0 => 'application/modules/Sestwitterclone',
            1 => 'application/themes/sestwitterclone',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sestwitterclone.csv',
        ),
    ),
    'items' => array(
        'sestwitterclone_customthemes',
        'sestwitterclone_managesearchoptions',
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sestwitterclone_Plugin_Core'
        )
    ),
);
