<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sessocialtube',
        'version' => '4.8.10',
        'path' => 'application/modules/Sessocialtube',
        'title' => 'Responsive SocialTube Theme',
        'description' => 'Responsive SocialTube Theme',
        'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sessocialtube/settings/install.php',
            'class' => 'Sessocialtube_Installer',
        ),
        'directories' =>
        array(
            0 => 'application/modules/Sessocialtube',
            1 => 'application/themes/sessocialtube',
            2 => 'public/admin'
        ),
        'files' => array(
            'application/languages/en/sessocialtube.csv', 'externals/smoothbox/smoothbox4.js',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sessocialtube_socialicons', 'sessocialtube_footerlinks', 'sessocialtube_slideimage', 'sessocialtube_slide',
        'sessocialtube_gallery', 'sessocialtube_managesearchoptions','sessocialtube_headerphoto',
    ),
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sessocialtube_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sessocialtube_Plugin_Core'
        ),
    ),
);
?>