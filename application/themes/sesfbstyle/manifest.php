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
    'name' => 'FB Style Theme',
    'version' => '4.10.5',
    'sku' => 'sesfbstyle',
    'path' => 'application/themes/sesfbstyle',
    'repository' => 'socialnetworking.solutions',
    'title' => '<span style="color:#DDDDDD">Facebook Style Theme</span>',
    'thumb' => 'theme.jpg',
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
      0 => 'application/themes/sesfbstyle',
    ),
    'description' => '',
  ),
  'files' => 
  array (
    0 => 'theme.css',
    1 => 'constants.css',
		2 => 'media-queries.css',
		3 => 'sesfbstyle-custom.css'
  ),  
); 