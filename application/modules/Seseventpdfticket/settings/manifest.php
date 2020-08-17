<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventpdfticket
 * @package    Seseventpdfticket
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'seseventpdfticket',
    'version' => '4.9.4',
    'path' => 'application/modules/Seseventpdfticket',
    'title' => 'SES - Advanced Events - PDF Email Attachment for Tickets',
    'description' => 'SES - Advanced Events - PDF Email Attachment for Tickets',
    'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'callback' => 
    array (
      'path' => 'application/modules/Seseventpdfticket/settings/install.php',
	    'class' => 'Seseventpdfticket_Installer',
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
      0 => 'application/modules/Seseventpdfticket',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/seseventpdfticket.csv',
    ),
  ),
);