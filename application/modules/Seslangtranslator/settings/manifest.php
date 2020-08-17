<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslangtranslator
 * @package    Seslangtranslator
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2017-08-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
    'type' => 'module',
    'name' => 'seslangtranslator',
    //'sku' => 'seslangtranslator',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Seslangtranslator',
    'title' => 'SES - Multiple Language Translator Plugin',
    'description' => 'SES - Multiple Language Translator Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
      'path' => 'application/modules/Seslangtranslator/settings/install.php',
      'class' => 'Seslangtranslator_Installer',
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
      0 => 'application/modules/Seslangtranslator',
    ),
    'files' =>
    array(
      0 => 'application/languages/en/seslangtranslator.csv',
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Seslangtranslator_Plugin_Core',
		),
  ),
);
