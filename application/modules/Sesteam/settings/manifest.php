<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sesteam',
        //'sku' => 'sesteam',
        'version' => '5.2.1',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '5.0.0',
            ),
        ),
        'path' => 'application/modules/Sesteam',
        'title' => 'SES - Team Showcase & Multi-Use Team Plugin',
        'description' => 'SES - Team Showcase & Multi-Use Team Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sesteam/settings/install.php',
            'class' => 'Sesteam_Installer',
        ),
        'directories' => array(
            'application/modules/Sesteam',
        ),
        'files' => array(
            'application/languages/en/sesteam.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesteam_teams',
        'sesteam_designations'
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesteam_Plugin_Core',
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sesteam_Plugin_Core',
        ),
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sesteam_general' => array(
            'route' => 'members/:action/*',
            'defaults' => array(
                'module' => 'sesteam',
                'controller' => 'index',
                'action' => 'browse-members'
            ),
            'reqs' => array(
                'action' => '(browse-members)',
            )
        ),
    )
);
?>
