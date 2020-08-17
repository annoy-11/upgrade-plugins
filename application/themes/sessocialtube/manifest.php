<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Theme
 * @package    SocialTube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' => array(
        'type' => 'theme',
        'name' => 'SocialTube',
        'version' => '4.8.9',
        'path' => 'application/themes/sessocialtube',
        'repository' => 'socialenginesolutions.com',
        'title' => '<span style="color:#DDDDDD">SocialTube</span>',
        'thumb' => 'theme.jpg',
        'author' => '<a href="http://socialenginesolutions.com/" target="_blank" title="Visit our website!">SocialEngineSolutions</a>',
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
            'application/themes/sessocialtube',
        ),
    ),
    'files' => array(
        'theme.css',
        'constants.css',
				'media-queries.css',
    ),
);
?>
