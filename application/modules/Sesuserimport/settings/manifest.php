<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesuserimport
 * @package    Sesuserimport
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesuserimport',
        //'sku' => 'sesuserimport',
        'version' => '4.10.5',
		'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesuserimport',
        'title' => 'SES - Administration Tool: Bulk Importing, Creating New / Dummy Users Plugin',
        'description' => 'SES - Administration Tool: Bulk Importing, Creating New / Dummy Users Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesuserimport/settings/install.php',
            'class' => 'Sesuserimport_Installer',
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
            0 => 'application/modules/Sesuserimport',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sesuserimport.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(

    )
);
