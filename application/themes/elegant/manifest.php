<?php

/**
 * SocialEngine
 *
 * @category   Application_Theme
 * @package    Simplex Theme
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2014-08-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array (
    'type' => 'theme',
    'name' => 'Elegant',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.9.4p3',
        ),
    ),
    'path' => 'application/themes/elegant',
    'repository' => 'socialnetworking.solutions',
    'title' => '<span style="color:#DDDDDD">Elegant Theme</span>',
    'thumb' => 'elegant_theme.jpg',
    'author' => '<a href="https://socialnetworking.solutions/" target="_blank" title="Visit our website!">SocialNetworking.Solutions</a>',
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
      0 => 'application/themes/elegant',
    ),
    'description' => '',
  ),
  'files' =>
  array (
    0 => 'theme.css',
    1 => 'constants.css',
		2 => 'media-queries.css'
  )
);
