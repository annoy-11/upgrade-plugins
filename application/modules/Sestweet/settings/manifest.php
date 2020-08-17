<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestweet
 * @package    Sestweet
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2017-05-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  'package' => array(
    'type' => 'module',
    'name' => 'sestweet',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sestweet',
    'title' => 'SES - Click To Tweet Plugin',
    'description' => 'SES - Click To Tweet Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
      'install',
      'upgrade',
      'refresh',
      'enable',
      'disable',
    ),
    'callback' => array(
      'path' => 'application/modules/Sestweet/settings/install.php',
      'class' => 'Sestweet_Installer',
    ),
    'directories' => array(
      'application/modules/Sestweet',
      'externals/tinymce/plugins/tweet',
    ),
    'files' => array(
      'application/libraries/Engine/View/Helper/TinyMce.php',
      'application/languages/en/sestweet.csv',
    ),
  ),
	// Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sestweet_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sestweet_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutMobileDefault',
            'resource' => 'Sestweet_Plugin_Core'
        ),
				array(
            'event' => 'onRenderLayoutMobileDefaultSimple',
            'resource' => 'Sestweet_Plugin_Core'
        )

    ),
);
