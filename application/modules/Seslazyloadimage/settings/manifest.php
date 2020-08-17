<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslazyloadimage
 * @package    Seslazyloadimage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-02-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
    'package' =>
    array(
        'type' => 'module',
        'name' => 'seslazyloadimage',
        //'sku' => 'seslazyloadimage',
        'version' => '4.10.3p6',
        'path' => 'application/modules/Seslazyloadimage',
        'title' => 'SES - Lazy Image Loading Plugin',
        'description' => 'SES - Lazy Image Loading Plugin',
        'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
        'callback' => array(
            'path' => 'application/modules/Seslazyloadimage/settings/install.php',
            'class' => 'Seslazyloadimage_Installer',
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
            0 => 'application/modules/Seslazyloadimage',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/seslazyloadimage.csv',
        ),
    ),
);
