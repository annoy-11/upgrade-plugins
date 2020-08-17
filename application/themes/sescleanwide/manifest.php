<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Theme
 * @package    Responsive Clean Wide Theme
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2015-03-30 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' => array(
        'type' => 'theme',
        'name' => 'Responsive Clean Wide Theme',
        'version' => '4.10.3',
        'sku' => 'sescleanwide',
        'path' => 'application/themes/sescleanwide',
        'repository' => 'socialnetworking.solutions',
        'title' => '<span style="color:#DDDDDD">Responsive Clean Wide Theme</span>',
        'thumb' => 'theme.jpg',
        'author' => '<a href="http://socialnetworking.solutions/" target="_blank" title="Visit our website!">socialnetworking.solutions</a>',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.9.4p2',
            ),
        ),
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'remove',
        ),
        'callback' => array(
            'class' => 'Engine_Package_Installer_Theme',
        ),
        'directories' => array(
            'application/themes/sescleanwide',
        ),
    ),
    'files' => array(
        'theme.css',
        'constants.css',
				'media-queries.css',
    ),
);
