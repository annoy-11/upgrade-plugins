<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sesmaterial',
        //'sku' => 'sesmaterial',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesmaterial',
        'title' => 'SES - Responsive Material Theme',
        'description' => 'SES - Responsive Material Theme',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sesmaterial/settings/install.php',
            'class' => 'Sesmaterial_Installer',
        ),
        'directories' =>
        array(
            0 => 'application/modules/Sesmaterial',
            1 => 'application/themes/sesmaterial',
            2 => 'public/admin'
        ),
        'files' => array(
            'application/languages/en/sesmaterial.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesmaterial_socialicons', 'sesmaterial_footerlinks', 'sesmaterial_slideimage', 'sesmaterial_slide',
        'sesmaterial_gallery', 'sesmaterial_managesearchoptions','sesmaterial_headerphoto','sesmaterial_dashboardlinks',
    ),
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesmaterial_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sesmaterial_Plugin_Core'
        ),
    ),
);
