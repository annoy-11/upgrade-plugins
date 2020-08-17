<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array(
      'type' => 'module',
      'name' => 'sesemoji',
      //'sku' => 'sesemoji',
      'version' => '4.10.5',
	  'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
      'path' => 'application/modules/Sesemoji',
      'title' => 'SES - iOS, Android and Browsers Unicode Emojis Plugin',
      'description' => 'SES - iOS, Android and Browsers Unicode Emojis Plugin',
      'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
      'callback' => array(
          'path' => 'application/modules/Sesemoji/settings/install.php',
          'class' => 'Sesemoji_Installer',
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
          0 => 'application/modules/Sesemoji',
      ),
      'files' =>
      array(
          0 => 'application/languages/en/sesemoji.csv',
      ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesemoji_emoji',
    'sesemoji_emojiicon',
  ),
);
