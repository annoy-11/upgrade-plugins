<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sespagebuilder',
        //'sku' => 'sespagebuilder',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sespagebuilder',
        'title' => 'SES - Page Builder and Shortcodes Plugin',
        'description' => 'SES - Page Builder and Shortcodes Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sespagebuilder/settings/install.php',
            'class' => 'Sespagebuilder_Installer',
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
            0 => 'application/modules/Sespagebuilder',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sespagebuilder.csv',
        ),
    ),
    'items' => array('sespagebuilder_pricingtables',
        'sespagebuilder_pagebuilder', 'sespagebuilder_tab', 'sespagebuilder_content', 'sespagebuilder_photo', 'sespagebuilder_accordions', 'sespagebuilder_progressbar', 'sespagebuilder_progressbarcontent','sespagebuilder_popup'
    ),
);
?>
