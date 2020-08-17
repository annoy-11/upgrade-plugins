<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-01-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesfmm',
        //'sku' => 'sesfmm',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesfmm',
        'title' => 'SES - Professional File & Media Manager Plugin',
        'description' => 'SES - Professional File & Media Manager Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesfmm/settings/install.php',
            'class' => 'Sesfmm_Installer',
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
            0 => 'application/modules/Sesfmm',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sesfmm.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(

    ),
);
