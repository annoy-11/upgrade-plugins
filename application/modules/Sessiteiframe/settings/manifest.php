<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessiteiframe
 * @package    Sessiteiframe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: menifest.php  2017-10-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'sessiteiframe',
    'version' => '4.10.3',
    'path' => 'application/modules/Sessiteiframe',
    'title' => 'SES - Embed Site in iFrame for Continuous Music',
    'description' => 'SES - Embed Site in iFrame for Continuous Music',
    'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'callback' => array(
			'path' => 'application/modules/Sessiteiframe/settings/install.php',
			'class' => 'Sessiteiframe_Installer',
    ),
    'actions' =>
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'enable',
      4 => 'disable',
    ),
    'directories' =>
    array (
      0 => 'application/modules/Sessiteiframe',
    ),
    'files' =>
    array (
      'externals/ses-scripts/sesJquery.js',
      'application/languages/en/sessiteiframe.csv',
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(),
  // Routes --------------------------------------------------------------------
  'routes' => array(

  ),
);
