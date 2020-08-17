<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

 return array (
 	'package' => array(
        'type' => 'module',
        'name' => 'emailtemplates',
        //'sku' => 'emailtemplates',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Emailtemplates',
        'title' => 'SES - Ultimate Email Templates Plugin',
        'description' => 'SES - Ultimate Email Templates Plugin',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' => array(
                'install',
                'upgrade',
                'refresh',
                'enable',
                'disable',
        ),
        'callback' => array(
                'path' => 'application/modules/Emailtemplates/settings/install.php',
                'class' => 'Emailtemplates_Installer',
        ),
        'directories' =>
        array(
            'application/modules/Emailtemplates',
        ),
        'files' => array(
            'application/languages/en/emailtemplates.csv',
        ),
	),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'emailtemplates_template',
        'emailtemplates_selecttemplate',
    ),
);
