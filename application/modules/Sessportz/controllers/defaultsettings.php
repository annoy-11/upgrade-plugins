<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$default_constants = array(


    "sessportz_theme_color" => "#00AEFF",
    "sessportz_theme_secondary_color" => "#A5BAD5",
    "sessportz_main_width" => "1200px",
    "sessportz_left_columns_width" => "240px",
    "sessportz_right_columns_width" => "240px",
    "sessportz_header_fixed_layout" => "2",
    "sessportz_responsive_layout" => "1",
    "sessportz_header_design" => "4",
    "sessportz_user_photo_round" => "2",
    "sessportz_body_background_image" => "public/admin/blank.png",
    "sessportz_body_background_color" => "#1E364D",
    "sessportz_font_color" => "#A5BAD5",
    "sessportz_font_color_light" => "#A5BAD5",
    "sessportz_heading_color" => "#00AEFF",
    "sessportz_link_color" => "#FFFFFF",
    "sessportz_link_color_hover" => "#00AEFF",
    "sessportz_content_heading_background_color" => "#F1F1F1",
    "sessportz_content_background_color" => "#1E364D",
    "sessportz_content_border_color" => "#244565",
    "sessportz_content_border_color_dark" => "#244565",
    "sessportz_input_background_color" => "#1E364D",
    "sessportz_input_font_color" => "#A5BAD5",
    "sessportz_input_border_color" => "#244565",
    "sessportz_button_background_color" => "#00AEFF",
    "sessportz_button_background_color_hover" => "#2F5B85",
    "sessportz_button_background_color_active" => "#00AEFF",
    "sessportz_button_font_color" => "#FFFFFF",
    "sessportz_header_background_color" => "#192C3E",
    "sessportz_header_border_color" => "#244565",
    "sessportz_menu_logo_top_space" => "10px",
    "sessportz_mainmenu_background_color" => "#285183",
    "sessportz_mainmenu_background_color_hover" => "#00AEFF",
    "sessportz_mainmenu_link_color" => "#00AEFF",
    "sessportz_mainmenu_link_color_hover" => "#FFFFFF",
    "sessportz_mainmenu_border_color" => "#222222",
    "sessportz_minimenu_link_color" => "#A5BAD5",
    "sessportz_minimenu_link_color_hover" => "#00AEFF",
    "sessportz_minimenu_border_color" => "#AAAAAA",
    "sessportz_minimenu_icon" => "minimenu-icons-white.png",
    "sessportz_header_searchbox_background_color" => "#192C3E",
    "sessportz_header_searchbox_text_color" => "#A5BAD5",
    "sessportz_header_searchbox_border_color" => "#244565",
    "sessportz_footer_background_image" => "public/admin/blank.png",
    "sessportz_footer_design" => "3",
    "sessportz_footer_background_color" => "#14212F",
    "sessportz_footer_border_color" => "#1B2D40",
    "sessportz_footer_text_color" => "#FFFFFF",
    "sessportz_footer_link_color" => "#929599",
    "sessportz_footer_link_hover_color" => "#00AEFF",
    "sessportz_popup_design" => "2",
    "sessportz_body_fontfamily" => "Arial, Helvetica, sans-serif",
    "sessportz_body_fontsize" => "13px",
    "sessportz_heading_fontfamily" => "Arial, Helvetica, sans-serif",
    "sessportz_heading_fontsize" => "17px",
    "sessportz_mainmenu_fontfamily" => "Arial, Helvetica, sans-serif",
    "sessportz_mainmenu_fontsize" => "13px",
    "sessportz_tab_fontfamily" => "Arial, Helvetica, sans-serif",
    "sessportz_tab_fontsize" => "15px",
);
Engine_Api::_()->sessportz()->readWriteXML('', '', $default_constants);

//Search Work
$availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
if( is_array($availableTypes) && count($availableTypes) > 0 ) {
  $options = array();
  foreach( $availableTypes as $index => $type ) {
    $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
    $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'sessportz')->hasType(array('type' => $type));
    if(!$hasType) {
      $db->query("INSERT IGNORE INTO `engine4_sessportz_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
    }
  }
}

$db->query('INSERT IGNORE INTO `engine4_sessportz_footerlinks` (`name`, `url`, `enabled`, `sublink`) VALUES ("Footer Column 4", "", 1, 0);');

$db->query('ALTER TABLE `engine4_sessportz_footerlinks` ADD `nonloginenabled` TINYINT(1) NOT NULL DEFAULT "1";');
$db->query('ALTER TABLE `engine4_sessportz_footerlinks` ADD `nonlogintarget` TINYINT(1) NOT NULL DEFAULT "0";');
$db->query('ALTER TABLE `engine4_sessportz_footerlinks` ADD `loginurl` VARCHAR(255) NOT NULL;');
$db->query('ALTER TABLE `engine4_sessportz_footerlinks` ADD `loginenabled` TINYINT(1) NOT NULL DEFAULT "1";');
$db->query('ALTER TABLE `engine4_sessportz_footerlinks` ADD `logintarget` TINYINT(1) NOT NULL DEFAULT "0";');

$db->query('DROP TABLE IF EXISTS `engine4_sessportz_headerphotos`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_sessportz_headerphotos` (
  `headerphoto_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT "0",
  `order` tinyint(10) NOT NULL DEFAULT "0",
  `enabled` tinyint(1) DEFAULT "1",
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`headerphoto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');

// $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
// ("core_mini_notification", "user", "Notifications", "", \'{"route":"default","module":"sessportz","controller":"notifications","action":"pulldown"}\', "core_mini", "", 999),
// ("core_mini_friends", "user", "Friend Requests", "", \'{"route":"default","module":"sessportz","controller":"index","action":"friend-request"}\', "core_mini", "", 999);');

$db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
("sessportz.header.loggedin.options.0", "search"),
("sessportz.header.loggedin.options.1", "miniMenu"),
("sessportz.header.loggedin.options.2", "mainMenu"),
("sessportz.header.loggedin.options.3", "logo");');

$db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
("sessportz.header.nonloggedin.options.0", "search"),
("sessportz.header.nonloggedin.options.1", "miniMenu"),
("sessportz.header.nonloggedin.options.2", "mainMenu"),
("sessportz.header.nonloggedin.options.3", "logo");');

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sessportz_admin_main_customcss", "sessportz", "Custom CSS", "", \'{"route":"admin_default","module":"sessportz","controller":"custom-theme", "action":"index"}\', "sessportz_admin_main", "", 54);');

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sessportz_admin_main_typography", "sessportz", "Manage Fonts", "", \'{"route":"admin_default","module":"sessportz","controller":"settings", "action":"typography"}\', "sessportz_admin_main", "", 50);');
