<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesautoaction',
      //'sku' => 'sesautoaction',
      'version' => '4.10.5',
	  'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
      'path' => 'application/modules/Sesautoaction',
      'title' => 'SES - Auto Bot Actions Plugin - Auto Follow / Join / Like / Comment / Auto Friend Request',
      'description' => 'SES - Auto Bot Actions Plugin - Auto Follow / Join / Like / Comment / Auto Friend Request',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesautoaction/settings/install.php',
          'class' => 'Sesautoaction_Installer',
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
          0 => 'application/modules/Sesautoaction',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sesautoaction.csv',
      ),
  ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onUserCreateAfter',
            'resource' => 'Sesautoaction_Plugin_Core',
        ),
        array(
            'event' => 'onItemCreateAfter',
            'resource' => 'Sesautoaction_Plugin_Core',
        ),
//         array(
//             'event' => 'onUserDeleteBefore',
//             'resource' => 'Sesautoaction_Plugin_Core',
//         ),
    ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesautoaction_action', 'sesautoaction_user', 'sesautoaction_botaction', 'sesautoaction_integrateothersmodule',
    'sesautoaction_friend', 'sesautoaction_comment'
  ),
);
