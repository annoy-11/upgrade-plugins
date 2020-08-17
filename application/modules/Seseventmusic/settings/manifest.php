<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'seseventmusic',
        'version' => '4.8.9',
        'path' => 'application/modules/Seseventmusic',
        'title' => 'SES - Advanced Events - Music Extension',
        'description' => 'SES - Advanced Events - Music Extension',
        'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Seseventmusic/settings/install.php',
            'class' => 'Seseventmusic_Installer',
        ),
        'directories' => array(
            'application/modules/Seseventmusic',
        ),
        'files' => array(
            'application/languages/en/seseventmusic.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Seseventmusic_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutMobileDefault',
            'resource' => 'Seseventmusic_Plugin_Core',
        ),
    ),
    // Compose -------------------------------------------------------------------
    'compose' => array(
        array('_composeMusic.tpl', 'seseventmusic'),
    ),
    'composer' => array(
        'seseventmusic' => array(
            'script' => array('_composeMusic.tpl', 'seseventmusic'),
            'plugin' => 'Seseventmusic_Plugin_Composer',
            'auth' => array('seseventmusic_album', 'create'),
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
      'seseventmusic_albums', 'seseventmusic_albumsongs', 'seseventmusic_album', 'seseventmusic_albumsong', 'seseventmusic_favourites'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'seseventmusic_extended' => array(
            'route' => 'eventmusics/:controller/:action/*',
            'defaults' => array(
                'module' => 'seseventmusic',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            ),
        ),
        'seseventmusic_songs' => array(
            'route' => 'eventmusic/songs/:action/*',
            'defaults' => array(
                'module' => 'seseventmusic',
                'controller' => 'song',
                'action' => 'lyrics',
            ),
            'reqs' => array(
                'action' => '(lyrics|browse)',
            ),
        ),
        'seseventmusic_general' => array(
            'route' => 'eventmusic/album/:action/*',
            'defaults' => array(
                'module' => 'seseventmusic',
                'controller' => 'index',
                'action' => 'home',
            ),
            'reqs' => array(
                'action' => '(index|create|delete|home|browse)',
            ),
        ),
        'seseventmusic_album_view' => array(
            'route' => 'eventmusic/album/:album_id/:slug/*',
            'defaults' => array(
                'module' => 'seseventmusic',
                'controller' => 'album',
                'action' => 'view',
                'slug' => '',
            ),
            'reqs' => array(
                'album_id' => '\d+'
            )
        ),
        'seseventmusic_albumsong_view' => array(
            'route' => 'eventmusic/song/:albumsong_id/:slug/*',
            'defaults' => array(
                'module' => 'seseventmusic',
                'controller' => 'song',
                'action' => 'view',
                'slug' => '',
            ),
            'reqs' => array(
                'albumsong_id' => '\d+'
            )
        ),
        'seseventmusic_album_specific' => array(
            'route' => 'eventmusic/album/:album_id/:slug/:action/*',
            'defaults' => array(
                'module' => 'seseventmusic',
                'controller' => 'album',
                'action' => 'view',
            ),
            'reqs' => array(
                'album_id' => '\d+',
                'action' => '(view|edit|delete|sort|set-profile|add-song|download-zip)',
            ),
        ),
        'seseventmusic_albumsong_specific' => array(
            'route' => 'eventmusic/song/:albumsong_id/:action/*',
            'defaults' => array(
                'module' => 'seseventmusic',
                'controller' => 'song',
                'action' => 'view',
            ),
            'reqs' => array(
                'albumsong_id' => '\d+',
                'action' => '(view|delete|rename|tally|upload|download-song|edit|print)',
            ),
        ),
    ),
);
?>