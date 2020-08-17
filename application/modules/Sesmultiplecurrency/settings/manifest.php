<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmultiplecurrency
 * @package    Sesmultiplecurrency
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-09-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sesmultiplecurrency',
    //'sku' => 'sesmultiplecurrency',
    'version' => '4.10.5p1',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesmultiplecurrency',
    'title' => 'SES - Multiple Currencies - Exchange & Switcher Plugin',
    'description' => 'SES - Multiple Currencies - Exchange & Switcher Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
      'path' => 'application/modules/Sesmultiplecurrency/settings/install.php',
      'class' => 'Sesmultiplecurrency_Installer',
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
      0 => 'application/modules/Sesmultiplecurrency',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/sesmultiplecurrency.csv',
    ),
  ),
  'hooks' => array(
    array(
        'event' => 'onRenderLayoutMobileDefault',
        'resource' => 'Sesmultiplecurrency_Plugin_Core',
    ),
     array(
        'event' => 'onRenderLayoutMobileDefaultSimple',
        'resource' => 'Sesmultiplecurrency_Plugin_Core',
    ),
     array(
        'event' => 'onRenderLayoutDefault',
        'resource' => 'Sesmultiplecurrency_Plugin_Core',
    ),
    array(
        'event' => 'onRenderLayoutDefaultSimple',
        'resource' => 'Sesmultiplecurrency_Plugin_Core'
    ),
  ),
);
