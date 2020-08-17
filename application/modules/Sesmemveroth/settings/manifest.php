<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesmemveroth',
      //'sku' => 'sesmemveroth',
      'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
      'path' => 'application/modules/Sesmemveroth',
      'title' => 'SES - Members Verification by Other Members Plugin',
      'description' => 'SES - Members Verification by Other Members Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesmemveroth/settings/install.php',
          'class' => 'Sesmemveroth_Installer',
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
          0 => 'application/modules/Sesmemveroth',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sesmemveroth.csv',
      ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesmemveroth_verification'
  ),
);
