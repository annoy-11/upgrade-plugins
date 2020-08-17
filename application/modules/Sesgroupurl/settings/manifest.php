<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupurl
 * @package    Sesgroupurl
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesgroupurl',
        'version' => '4.10.5',
        'path' => 'application/modules/Sesgroupurl',
        'title' => 'SES - Group Short URL Extension',
        'description' => 'SES - Group Short URL Extension',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesgroupurl/settings/install.php',
            'class' => 'Sesgroupurl_Installer',
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
            0 => 'application/modules/Sesgroupurl',
        ),
        'files' => array(
            'application/languages/en/sesgroupurl.csv',
        ),
    ),
);
?>
