<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
    'package' =>
    array (
        'type' => 'module',
        'name' => 'sespopupbuilder',
        //'sku' => 'sespopupbuilder',
        'version' => '4.10.5',
		'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sespopupbuilder',
        'title' => 'SES - Popup Builder Plugin',
        'description' => 'SES - Popup Builder Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
                'path' => 'application/modules/Sespopupbuilder/settings/install.php',
                'class' => 'Sespopupbuilder_Installer',
            ),
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
            0 => 'application/modules/Sespopupbuilder',
        ),
        'files' =>
        array (
            0 => 'application/languages/en/sespopupbuilder.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sespopupbuilder_popup',
        'sespopupbuilder_country',
				'sespopupbuilder_visit',
    ),
);
