<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sesmenu',
    //'sku' => 'sesmenu',
    'version' => '4.10.5p1',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sesmenu',
    'title' => 'SES - Ultimate Menus Plugin',
    'description' => 'SES - Ultimate Menus Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' =>
          array (
              'path' => 'application/modules/Sesmenu/settings/install.php',
              'class' => 'Sesmenu_Installer',
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
      0 => 'application/modules/Sesmenu',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/sesmenu.csv',
    ),
  ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'getAdminNotifications',
            'resource' => 'Sesmenu_Plugin_Core',
        ),
    ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesmenu_menuitem',
	'sesmenu_item',
	'sesmenu_itemlinks',
  ),
);
