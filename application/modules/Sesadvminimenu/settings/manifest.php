<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvminimenu
 * @package    Sesadvminimenu
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesadvminimenu',
      'version' => '4.10.3',
      'path' => 'application/modules/Sesadvminimenu',
      'title' => 'SES - Advanced Mini Navigation Menu Plugin',
      'description' => 'SES - Advanced Mini Navigation Menu Plugin',
      'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesadvminimenu/settings/install.php',
          'class' => 'Sesadvminimenu_Installer',
      ),
      'actions' =>
      array(
          0 => 'install',
          1 => 'upgrade',
          2 => 'refresh',
          3 => 'enable',
          4 => 'disable',
      ),
      'directories' =>
      array(
          0 => 'application/modules/Sesadvminimenu',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sesadvminimenu.csv',
      ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(

  ),
);