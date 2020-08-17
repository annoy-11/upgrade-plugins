<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$default_constants = array(
    'sesmaterial_theme_color' => '#4267B2',
	'sesmaterial_theme_secondary_color' => '#2B2D2E',
	'sesmaterial_main_width' => '1200px',
	'sesmaterial_left_columns_width' => '240px',
	'sesmaterial_right_columns_width' => '240px',
	'sesmaterial_header_fixed_layout' => '2',
	'sesmaterial_responsive_layout' => '1',
	'sesmaterial_header_design' => '4',
	'sesmaterial_user_photo_round' => '2',
	'sesmaterial_body_background_image' => 'public/admin/blank.png',
	'sesmaterial_body_background_color' => '#e5eaef',
	'sesmaterial_font_color' => '#555',
	'sesmaterial_font_color_light' => '#888',
	'sesmaterial_heading_color' => '#555555',
	'sesmaterial_link_color' => '#4267B2',
	'sesmaterial_link_color_hover' => '#4267B2',
	'sesmaterial_content_heading_background_color' => '#f1f1f1',
	'sesmaterial_content_background_color' => '#fff',
	'sesmaterial_content_border_color' => '#DFDFDF',
	'sesmaterial_content_border_color_dark' => '#ddd',
	'sesmaterial_input_background_color' => '#fff',
	'sesmaterial_input_font_color' => '#000',
	'sesmaterial_input_border_color' => '#c8c8c8',
	'sesmaterial_button_background_color' => '#4267B2',
	'sesmaterial_button_background_color_hover' => '#4267B2',
	'sesmaterial_button_background_color_active' => '#4267B2',
	'sesmaterial_button_font_color' => '#fff',
	'sesmaterial_header_background_color' => '#fff',
	'sesmaterial_header_border_color' => '#fff',
	'sesmaterial_menu_logo_top_space' => '10px',
	'sesmaterial_mainmenu_background_color' => '#4267B2',
	'sesmaterial_mainmenu_background_color_hover' => '#4267B2',
	'sesmaterial_mainmenu_link_color' => '#bbd8f3',
	'sesmaterial_mainmenu_link_color_hover' => '#fff',
	'sesmaterial_mainmenu_border_color' => '#e3e3e3',
	'sesmaterial_minimenu_link_color' => '#555555',
	'sesmaterial_minimenu_link_color_hover' => '#4267B2',
	'sesmaterial_minimenu_border_color' => '#e3e3e3',
	'sesmaterial_minimenu_icon' => 'minimenu-icons-white.png',
	'sesmaterial_header_searchbox_background_color' => '#f8f8f8',
	'sesmaterial_header_searchbox_text_color' => '#C8C8C8',
	'sesmaterial_header_searchbox_border_color' => '#C8C8C8',
	'sesmaterial_footer_background_image' => 'public/admin/blank.png',
	'sesmaterial_footer_design' => '3',
	'sesmaterial_footer_background_color' => '#090D25',
	'sesmaterial_footer_border_color' => '#dcdcdc',
	'sesmaterial_footer_text_color' => '#B7B7B7',
	'sesmaterial_footer_link_color' => '#B7B7B7',
	'sesmaterial_footer_link_hover_color' => '#FFFFFF',
	'sesmaterial_popup_design' => '2',
	'sesmaterial_body_fontfamily' => 'Arial, Helvetica, sans-serif',
	'sesmaterial_body_fontsize'  =>  '13px',
	'sesmaterial_heading_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sesmaterial_heading_fontsize' =>  '17px',
	'sesmaterial_mainmenu_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sesmaterial_mainmenu_fontsize' =>  '13px',
	'sesmaterial_tab_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sesmaterial_tab_fontsize' =>  '15px',
);
Engine_Api::_()->sesmaterial()->readWriteXML('', '', $default_constants);

//Search Work
$availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
if( is_array($availableTypes) && count($availableTypes) > 0 ) {
  $options = array();
  foreach( $availableTypes as $index => $type ) {
    $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
    $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'sesmaterial')->hasType(array('type' => $type));
    if(!$hasType) {
      $db->query("INSERT IGNORE INTO `engine4_sesmaterial_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
    }
  }
}

$db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
("sm.header.loggedin.options.0", "search"),
("sm.header.loggedin.options.1", "miniMenu"),
("sm.header.loggedin.options.2", "mainMenu"),
("sm.header.loggedin.options.3", "logo");');

$db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
("sm.header.nonloggedin.options.0", "search"),
("sm.header.nonloggedin.options.1", "miniMenu"),
("sm.header.nonloggedin.options.2", "mainMenu"),
("sm.header.nonloggedin.options.3", "logo");');

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesmaterial_admin_main_customcss", "sesmaterial", "Custom CSS", "", \'{"route":"admin_default","module":"sesmaterial","controller":"custom-theme", "action":"index"}\', "sesmaterial_admin_main", "", 54);');

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesmaterial_admin_main_typography", "sesmaterial", "Manage Fonts", "", \'{"route":"admin_default","module":"sesmaterial","controller":"settings", "action":"typography"}\', "sesmaterial_admin_main", "", 50);');


$db->query("UPDATE `engine4_core_settings` SET `name` = 'sesmaterial.footertext.en' WHERE `engine4_core_settings`.`name` = 'sesmaterial.footertext';");

$db->query("UPDATE `engine4_core_settings` SET `name` = 'sesmaterial.landinapagetext.en' WHERE `engine4_core_settings`.`name` = 'sesmaterial.landinapagetext';");

$table_footerLinks = $db->query('SHOW TABLES LIKE \'engine4_sesmaterial_footerlinks\'')->fetch();
if (!empty($table_footerLinks)) {
    $columnfooterlink_exist = $db->query("SHOW COLUMNS FROM engine4_sesmaterial_footerlinks LIKE 'nonloginenabled'")->fetch();
    if (empty($columnfooterlink_exist)) {
        $db->query("ALTER TABLE `engine4_sesmaterial_footerlinks` ADD `nonloginenabled` TINYINT(1) NOT NULL DEFAULT '1'");
    }

    $columnnonlogintarget_exist = $db->query("SHOW COLUMNS FROM engine4_sesmaterial_footerlinks LIKE 'nonlogintarget'")->fetch();
    if (empty($columnnonlogintarget_exist)) {
        $db->query("ALTER TABLE `engine4_sesmaterial_footerlinks` ADD `nonlogintarget` TINYINT(1) NOT NULL DEFAULT '1';");
    }

    $columnnonloginurl_exist = $db->query("SHOW COLUMNS FROM engine4_sesmaterial_footerlinks LIKE 'loginurl'")->fetch();
    if (empty($columnnonloginurl_exist)) {
        $db->query("ALTER TABLE `engine4_sesmaterial_footerlinks` ADD `loginurl` VARCHAR(255) NOT NULL");
    }

    $columnnonloginenabled_exist = $db->query("SHOW COLUMNS FROM engine4_sesmaterial_footerlinks LIKE 'loginenabled'")->fetch();
    if (empty($columnnonloginenabled_exist)) {
        $db->query("ALTER TABLE `engine4_sesmaterial_footerlinks` ADD `loginenabled` TINYINT(1) NOT NULL DEFAULT '1'");
    }

    $columnnonlogintarget_exist = $db->query("SHOW COLUMNS FROM engine4_sesmaterial_footerlinks LIKE 'logintarget'")->fetch();
    if (empty($columnnonlogintarget_exist)) {
        $db->query("ALTER TABLE `engine4_sesmaterial_footerlinks` ADD `logintarget` TINYINT(1) NOT NULL DEFAULT '1'");
    }
}
