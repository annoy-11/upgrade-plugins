<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesuserexport
 * @package    Sesuserexport
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesuserexport',
        'version' => '4.10.3p6',
        'path' => 'application/modules/Sesuserexport',
        'title' => 'SES - User Export Information Plugin',
        'description' => 'SES - User Export Information Plugin',
        'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesuserexport/settings/install.php',
            'class' => 'Sesuserexport_Installer',
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
            0 => 'application/modules/Sesuserexport',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sesuserexport.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(

    )
);
