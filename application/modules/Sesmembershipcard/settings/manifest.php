<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershipcard
 * @package    Sesmembershipcard
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-02-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sesmembershipcard',
    //'sku' => 'sesmembershipcard',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sesmembershipcard',
    'title' => 'SES - Membership Cards Plugin',
    'description' => 'SES - Membership Cards Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' =>
    array (
      'class' => 'Sesmembershipcard_Installer',
      'path' => 'application/modules/Sesmembershipcard/settings/install.php',
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
      0 => 'application/modules/Sesmembershipcard',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/sesmembershipcard.csv',
    ),
  ),
); ?>
