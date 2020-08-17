<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sespoke',
        'sku' => 'sespoke',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sespoke',
        'title' => 'SES - Advanced Poke, Wink, Slap, etc & Gifts Plugin',
        'description' => 'SES - Advanced Poke, Wink, Slap, etc & Gifts Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sespoke/settings/install.php',
            'class' => 'Sespoke_Installer',
        ),
        'dependencies' => array(
          array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.9.4p3',
          ),
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
            0 => 'application/modules/Sespoke',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sespoke.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sespoke_Plugin_Core',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sespoke_poke', 'sespoke_manageaction', 'sespoke_userinfo'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sespoke_page' => array(
            'route' => 'poke/:controller/:action/*',
            'defaults' => array(
                'module' => 'sespoke',
                'controller' => 'index',
                'action' => 'poke'
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            )
        ),
    )
);
?>
