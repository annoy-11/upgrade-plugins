<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesmusicapp',
      //'sku' => 'sesmusicapp',
      'version' => '4.10.5',
      'path' => 'application/modules/Sesmusicapp',
      'title' => 'SES - Custom Music for Mobile Apps Extension',
      'description' => 'SES - Custom Music for Mobile Apps Extension',
      'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesmusicapp/settings/install.php',
          'class' => 'Sesmusicapp_Installer',
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
          0 => 'application/modules/Sesmusicapp',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sesmusicapp.csv',
      ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
  ),
);
