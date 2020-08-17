<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescusdash
 * @package    Sescusdash
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sescusdash',
      //'sku' => 'sescusdash',
      'version' => '4.10.5',
	  'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
      'path' => 'application/modules/Sescusdash',
      'title' => 'SES - Custom Dashboard Plugin',
      'description' => 'SES - Custom Dashboard Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sescusdash/settings/install.php',
          'class' => 'Sescusdash_Installer',
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
          0 => 'application/modules/Sescusdash',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sescusdash.csv',
      ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sescusdash_dashboard', 'sescusdash_dashboardlinks'
  ),
);
