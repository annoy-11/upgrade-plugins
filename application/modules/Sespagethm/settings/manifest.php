<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' => array(
        'type' => 'module',
        'name' => 'sespagethm',
        'version' => '4.10.3',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.9.4p3',
            ),
        ),
        'path' => 'application/modules/Sespagethm',
        'title' => 'SES - Page Theme',
        'description' => 'SES - Page Theme',
        'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sespagethm/settings/install.php',
            'class' => 'Sespagethm_Installer',
        ),
        'directories' =>
        array(
            0 => 'application/modules/Sespagethm',
            1 => 'application/themes/sespagethm',
            2 => 'public/admin'
        ),
        'files' => array(
            'application/languages/en/sespagethm.csv',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sespagethm_socialicons', 'sespagethm_footerlinks', 'sespagethm_slideimage', 'sespagethm_slide',
        'sespagethm_gallery', 'sespagethm_managesearchoptions','sespagethm_headerphoto','sespagethm_dashboardlinks',
    ),
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sespagethm_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sespagethm_Plugin_Core'
        ),
    ),
);
