<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sesspectromedia',
        //'sku' => 'sesspectromedia',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesspectromedia',
        'title' => 'SES - Responsive SpectroMedia Theme',
        'description' => 'SES - Responsive SpectroMedia Theme',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sesspectromedia/settings/install.php',
            'class' => 'Sesspectromedia_Installer',
        ),
        'directories' =>
        array(
            0 => 'application/modules/Sesspectromedia',
            1 => 'application/themes/sesspectromedia',
            2 => 'public/admin'
        ),
        'files' => array(
            'application/languages/en/sesspectromedia.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesspectromedia_socialicons', 'sesspectromedia_footerlinks', 'sesspectromedia_slideimage', 'sesspectromedia_slide',
        'sesspectromedia_gallery', 'sesspectromedia_managesearchoptions','sesspectromedia_headerphoto',
    ),
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesspectromedia_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sesspectromedia_Plugin_Core'
        ),
    ),
);
