<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessurl
 * @package    Sesbusinessurl
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesbusinessurl',
        'version' => '4.10.5',
        'path' => 'application/modules/Sesbusinessurl',
        'title' => 'SES - Business Short URL Extension',
        'description' => 'SES - Business Short URL Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesbusinessurl/settings/install.php',
            'class' => 'Sesbusinessurl_Installer',
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
            0 => 'application/modules/Sesbusinessurl',
        ),
        'files' => array(
            'application/languages/en/sesbusinessurl.csv',
        ),
    ),
);
