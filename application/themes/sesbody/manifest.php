<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Theme
 * @package    Spectro Media
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' => array(
        'type' => 'theme',
        'name' => 'Spectro Media',
        'version' => '4.10.5',
        'path' => 'application/themes/sesbody',
        'repository' => 'socialnetworking.solutions',
        'title' => '<span style="color:#DDDDDD">Responsive Body Theme</span>',
        'thumb' => 'theme.jpg',
        'author' => '<a href="https://socialnetworking.solutions/" target="_blank" title="Visit our website!">SocialNetworking.Solutions</a>',
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
            'application/themes/sesbody',
        ),
    ),
    'files' => array(
        'theme.css',
        'constants.css',
				'media-queries.css',
				'sesbody-custom.css'
    ),
);
?>
