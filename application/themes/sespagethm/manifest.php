<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Theme
 * @package    Page Theme
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
  'package' => array(
    'type' => 'theme',
    'name' => 'SES - Page Theme',
    'version' => '4.10.3',
    'path' => 'application/themes/sespagethm',
    'repository' => 'socialenginesolutions.com',
    'title' => '<span style="color:#DDDDDD">SES - Page Theme</span>',
    'thumb' => 'theme.jpg',
    'author' => '<a href="http://socialenginesolutions.com/" target="_blank" title="Visit our website!">SocialEngineSolutions</a>',
    'actions' => array(
        'install',
        'upgrade',
        'refresh',
        'remove',
    ),
    'callback' => array(
        'class' => 'Engine_Package_Installer_Theme',
    ),
    'directories' => array(
        'application/themes/sespagethm',
    ),
  ),
  'files' => array(
    'theme.css',
    'constants.css',
    'media-queries.css',
    'sespagethm-custom.css'
  ),
);
?>
