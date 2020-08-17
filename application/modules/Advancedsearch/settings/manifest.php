<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'advancedsearch',
    //'sku' => 'advancedsearch',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Advancedsearch',
    'title' => 'SES - Professional Search Plugin',
    'description' => 'SES - Professional Search Plugin',
     'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' =>
          array (
              'path' => 'application/modules/Advancedsearch/settings/install.php',
              'class' => 'Advancedsearch_Installer',
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
      0 => 'application/modules/Advancedsearch',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/advancedsearch.csv',
    ),
  ),
    'items'=>array('advancedsearch_modules'),
    'hooks' => array(

        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Advancedsearch_Plugin_Core'
        ),
        array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Advancedsearch_Plugin_Core'
        ),
        array(
            'event' => 'onRenderLayoutMobileDefault',
            'resource' => 'Advancedsearch_Plugin_Core'
        ),
        array(
            'event' => 'onRenderLayoutMobileDefaultSimple',
            'resource' => 'Advancedsearch_Plugin_Core'
        ),
    ),
    'routes' => array(

    ),
);
