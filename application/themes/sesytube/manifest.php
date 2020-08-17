<?php

/**
 * SocialEngine
 *
 * @category   Application_Theme
 * @package    UTube Clone Theme
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-11-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array (
    'type' => 'theme',
    'name' => 'UTube Clone Theme',
    'version' => '4.10.5',
    'path' => 'application/themes/sesytube',
    'repository' => 'socialnetworking.solutions',
    'title' => '<span style="color:#DDDDDD">UTube Clone Theme</span>',
    'thumb' => 'ytube_theme.jpg',
    'author' => '<a href="https://socialnetworking.solutions" target="_blank" title="Visit our website!">SocialNetworking.Solutions</a>',
    'actions' =>
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'remove',
    ),
    'callback' =>
    array (
      'class' => 'Engine_Package_Installer_Theme',
    ),
    'directories' =>
    array (
      0 => 'application/themes/sesytube',
    ),
    'description' => '',
  ),
  'files' =>
  array (
    0 => 'theme.css',
    1 => 'constants.css',
		2 => 'media-queries.css',
		3 => 'landingpage.css',
    4 => 'sesytube-custom.css'
  )
);
