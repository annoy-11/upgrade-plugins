<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sessportz',
        //'sku' => 'sessportz',
        'version' => '4.10.5',
		'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sessportz',
        'title' => 'SES - Responsive Sportz Theme',
        'description' => 'SES - Responsive Sportz Theme',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sessportz/settings/install.php',
            'class' => 'Sessportz_Installer',
        ),
        'directories' =>
        array(
            'application/modules/Sessportz',
            'application/themes/sessportz',
            
        ),
        'files' => array(
            'application/languages/en/sessportz.csv',
	    'public/admin/blank.png',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sessportz_socialicons', 'sessportz_footerlinks', 'sessportz_slideimage', 'sessportz_slide',
        'sessportz_gallery', 'sessportz_managesearchoptions','sessportz_headerphoto','sessportz_teams', 'sessportz_newsletteremail'
    ),
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sessportz_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sessportz_Plugin_Core'
        ),
    ),
);
?>
