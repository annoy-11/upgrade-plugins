<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesultimateslide
 * @package Sesultimateslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: manifest.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */

return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesultimateslide',
      'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
      'path' => 'application/modules/Sesultimateslide',
      'title' => 'SES - Ultimate Banner Slideshow Plugin',
      'description' => 'SES - Ultimate Banner Slideshow Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesultimateslide/settings/install.php',
          'class' => 'Sesultimateslide_Installer',
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
          0 => 'application/modules/Sesultimateslide',
      ),

      'files' =>
      array(
          0 => 'application/languages/en/sesultimateslide.csv',
      ),
  ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesultimateslide_gallery',
        'sesultimateslide_slide',
    ),
);
