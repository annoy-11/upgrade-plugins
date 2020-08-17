<?php

/**
 * SocialEngine
 *
 * @category   Application_Theme
 * @package    Responsive Expose Theme
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2014-08-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array (
    'type' => 'theme',
    'name' => 'Professional Insta Clone Theme',
    'version' => '5.2.1',
    'sku' => 'einstaclone',
    'path' => 'application/themes/einstaclone',
    'repository' => 'socialenginesolutions.com',
    'title' => '<span style="color:#DDDDDD">Professional Insta Clone Theme</span>',
    'thumb' => 'theme.jpg',
    'author' => '<a href="http://socialenginesolutions.com/" target="_blank" title="Visit our website!">SocialEngineSolutions</a>',
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
      0 => 'application/themes/einstaclone',
    ),
    'description' => '',
  ),
  'files' =>
  array (
    0 => 'theme.css',
    1 => 'constants.css',
    2 => 'media-queries.css',
    3 => 'einstaclone-custom.css'
  ),
);
