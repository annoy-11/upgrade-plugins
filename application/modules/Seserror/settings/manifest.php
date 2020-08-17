<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  'package' =>
  array(
      'type' => 'module',
      'name' => 'seserror',
      //'sku' => 'seserror',
      'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
      'path' => 'application/modules/Seserror',
      'title' => 'SES - Advanced Error Pages Plugin',
      'description' => 'SES - Advanced Error Pages Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Seserror/settings/install.php',
          'class' => 'Seserror_Installer',
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
          0 => 'application/modules/Seserror',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/seserror.csv',
      ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onRenderLayoutDefault',
      'resource' => 'Seserror_Plugin_Core',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
      'seserror_errors'
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'seserror_comingsoon' => array(
      'route' => 'comingsoon/:controller/:action/*',
      'defaults' => array(
        'module' => 'seserror',
        'controller' => 'error',
        'action' => 'comingsoon'
      ),
    ),
  ),
);
