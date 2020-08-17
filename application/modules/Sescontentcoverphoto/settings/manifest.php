<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sescontentcoverphoto',
    //'sku' => 'sescontentcoverphoto',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sescontentcoverphoto',
    'title' => 'SES - Content Profiles Cover Photo Plugin',
    'description' => 'SES - Content Profiles Cover Photo Plugin',
     'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
			'path' => 'application/modules/Sescontentcoverphoto/settings/install.php',
			'class' => 'Sescontentcoverphoto_Installer',
    ),
    'actions' =>
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'enable',
      4 => 'disable',
    ),
    'directories' =>
    array (
      0 => 'application/modules/Sescontentcoverphoto',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/sescontentcoverphoto.csv',
    ),
  ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sescontentcoverphoto_contentinfo',
    ),
);
