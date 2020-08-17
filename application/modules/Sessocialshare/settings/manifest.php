<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
    'type' => 'module',
    'name' => 'sessocialshare',
    //'sku' => 'sessocialshare',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sessocialshare',
    'title' => 'SES - Professional Share Plugin',
    'description' => 'SES - Professional Share Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' => array(
        'path' => 'application/modules/Sessocialshare/settings/install.php',
        'class' => 'Sessocialshare_Installer',
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
        0 => 'application/modules/Sessocialshare',
    ),
    'files' =>
    array(
        0 => 'application/languages/en/sessocialshare.csv',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sessocialshare_socialicons',
    'sessocialshare_linksave'
  ),
);
