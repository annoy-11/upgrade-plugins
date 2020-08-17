<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Theme
 * @package    Responsive Modern Theme Theme
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2014-09-30 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
return array (
  'package' => 
  array (
    'type' => 'theme',
    'name' => 'sesmodern',
    'version' => '4.8.6p2',
    'path' => 'application/themes/sesmodern',
    'repository' => 'socialenginesolutions.com',
    'title' => '<span style="color:#DDDDDD">Responsive Modern Theme</span>',
    'thumb' => 'sesmodern_theme.jpg',
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
      0 => 'application/themes/sesmodern',
    ),
    'description' => '',
  ),
  'files' => array(
    'theme.css',
    'constants.css',
  )
); 
