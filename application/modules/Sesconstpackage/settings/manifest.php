<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesconstpackage
 * @package    Sesconstpackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-09-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesconstpackage',
      'sku' => 'sesconstpackage',
      'version' => '4.10.3p3',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.9.4p3',
            ),
        ),
      'path' => 'application/modules/Sesconstpackage',
      'title' => 'SES - Advanced Contests Package',
      'description' => 'SES - Advanced Contests Package',
      'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesconstpackage/settings/install.php',
          'class' => 'Sesconstpackage_Installer',
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
          0 => 'application/modules/Sesconstpackage',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sesconstpackage.csv',
      ),
  ),
);
