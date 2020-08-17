<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Theme
 * @package    Responsive Sportz Theme
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
  'package' => array(
    'type' => 'theme',
    'name' => 'SES - Responsive Sportz Theme',
    'version' => '4.10.5',
    'path' => 'application/themes/sessportz',
    'repository' => 'socialnetworking.solutions',
    'title' => '<span style="color:#DDDDDD">SES - Responsive Sportz Theme</span>',
    'thumb' => 'theme.jpg',
    'author' => '<a href="https://socialnetworking.solutions" target="_blank" title="Visit our website!">SocialNetworking.Solutions</a>',
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
        'application/themes/sessportz',
    ),
  ),
  'files' => array(
    'theme.css',
    'constants.css',
    'media-queries.css',
    'sessportz-custom.css'
  ),
);
?>
