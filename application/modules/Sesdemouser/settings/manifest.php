<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sesdemouser',
        //'sku' => 'sesdemouser',
        'version' => '5.2.1',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '5.0.0',
            ),
        ),
        'path' => 'application/modules/Sesdemouser',
        'title' => 'SES - Site Tour by Auto Logging With Test User Plugin',
        'description' => 'SES - Site Tour by Auto Logging With Test User Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sesdemouser/settings/install.php',
            'class' => 'Sesdemouser_Installer',
        ),
        'directories' => array(
            'application/modules/Sesdemouser',
        ),
        'files' => array(
            'application/languages/en/sesdemouser.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
      array(
          'event' => 'onRenderLayoutDefault',
          'resource' => 'Sesdemouser_Plugin_Core'
      ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesdemouser_demousers',
    ),
);
?>
