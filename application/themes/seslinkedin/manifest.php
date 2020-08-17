<?php

/**
 * SocialEngine
 *
 * @category   Application_Theme
 * @package    Linkedin Style Theme
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array (
    'type' => 'theme',
    'name' => 'Linkedin Style Theme',
    'version' => '4.10.5',
    //'sku' => 'seslinkedin',
    'path' => 'application/themes/seslinkedin',
    'repository' => 'socialnetworking.solutions',
    'title' => '<span style="color:#DDDDDD">Linkedin Style Theme</span>',
    'thumb' => 'theme.jpg',
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
      0 => 'application/themes/seslinkedin',
    ),
    'description' => '',
  ),
  'files' =>
  array (
    0 => 'theme.css',
    1 => 'constants.css',
		2 => 'media-queries.css',
		3 => 'seslinkedin-custom.css'
  ),
);
