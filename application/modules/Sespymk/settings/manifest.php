<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespymk
 * @package    Sespymk
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2017-03-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sespymk',
      //'sku' => 'sespymk',
      'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
      'path' => 'application/modules/Sespymk',
      'title' => 'SES - People You May Know Plugin',
      'description' => 'SES - People You May Know Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sespymk/settings/install.php',
          'class' => 'Sespymk_Installer',
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
          0 => 'application/modules/Sespymk',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sespymk.csv',
      ),
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
      'sespymk_general' => array(
          'route' => 'findfriends/:action/*',
          'defaults' => array(
              'module' => 'sespymk',
              'controller' => 'index',
              'action' => 'requests'
          ),
          'reqs' => array(
              'action' => '(requests)',
          )
      ),
      'sespymk_general1' => array(
          'route' => 'friends/requests/:action/*',
          'defaults' => array(
              'module' => 'sespymk',
              'controller' => 'index',
              'action' => 'friendrequestssent'
          ),
          'reqs' => array(
              'action' => '(friendrequestssent)',
          )
      ),
  )
);
