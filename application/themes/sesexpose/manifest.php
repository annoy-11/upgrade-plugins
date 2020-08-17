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
    'name' => 'Responsive Expose Theme',
    'version' => '4.10.5',
    'path' => 'application/themes/sesexpose',
    'repository' => 'socialnetworking.solutions',
    'title' => '<span style="color:#DDDDDD">Responsive Expose Theme</span>',
    'thumb' => 'expose_theme.jpg',
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
      0 => 'application/themes/sesexpose',
    ),
    'description' => '',
  ),
  'files' =>
  array (
    0 => 'theme.css',
    1 => 'constants.css',
		2 => 'media-queries.css',
		3 => 'sesexpose-custom.css',
  ),
	'nophoto' => array(
    'user' => array(
      'thumb_icon' => 'application/themes/sesexpose/images/nophoto_user_thumb_icon.png',
      'thumb_profile' => 'application/themes/sesexpose/images/nophoto_user_thumb_profile.png',
    )
	)
);
