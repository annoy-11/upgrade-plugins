<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
    'package' => array(
        'type' => 'module',
        'name' => 'seselegant',
        //'sku' => 'seselegant',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Seselegant',
        'title' => 'SES - Responsive Elegant Theme',
        'description' => 'SES - Responsive Elegant Theme',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
                'install',
                'upgrade',
                'refresh',
                'enable',
                'disable',
        ),
        'callback' => array(
                'path' => 'application/modules/Seselegant/settings/install.php',
                'class' => 'Seselegant_Installer',
        ),
        'directories' =>
        array(
                0 => 'application/modules/Seselegant',
                1 => 'application/themes/elegant',
        ),
        'files' => array(
                'application/languages/en/seselegant.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Seselegant_Plugin_Core'
        )
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'seselegant_slideimage', 'seselegant_slide', 'seselegant_banner',
    ),
);
