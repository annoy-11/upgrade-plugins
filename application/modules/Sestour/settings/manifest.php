<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sestour',
        //'sku' => 'sestour',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sestour',
        'title' => 'SES - Step by Step Webpage Introduction Tour Plugin',
        'description' => 'SES - Step by Step Webpage Introduction Tour Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sestour/settings/install.php',
            'class' => 'Sestour_Installer',
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
            0 => 'application/modules/Sestour',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sestour.csv',
      ),
    ),
    // Items
    'items' => array(
        'sestour_tour', 'sestour_content'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
  )
);
