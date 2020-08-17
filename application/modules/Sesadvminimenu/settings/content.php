<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvminimenu
 * @package    Sesadvminimenu
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'SES - Advanced Mini Navigation Menu - Mini Menu',
    'description' => 'Shows the site-wide mini menu. You can edit its contents in your menu editor.',
    'category' => 'SES - Advanced Mini Navigation Menu',
    'type' => 'widget',
    'name' => 'sesadvminimenu.menu-mini',
    'requirements' => array(
      'header-footer',
    ),
    'adminForm' => 'Sesadvminimenu_Form_Admin_MiniMenu',
  ),
);