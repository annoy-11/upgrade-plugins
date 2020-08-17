<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesinterest',
      //'sku' => 'sesinterest',
      'version' => '4.10.5',
	  'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
      'path' => 'application/modules/Sesinterest',
      'title' => 'SES - Interests Plugin',
      'description' => 'SES - Interests Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesinterest/settings/install.php',
          'class' => 'Sesinterest_Installer',
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
          0 => 'application/modules/Sesinterest',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sesinterest.csv',
      ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesinterest_interest','sesinterest_userinterest'
  ),
);
