<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$default_constants = array(
    'theme_color' => '1',
    'sm_theme_color' => '#e82f34',
	'sm_theme_secondary_color' => '#222',
	'sm_main_width' => '1200px',
	'sm_left_columns_width' => '240px',
	'sm_right_columns_width' => '240px',
	'sm_header_fixed_layout' => '2',
	'sm_responsive_layout' => '1',
	'sm_header_design' => '1',
	'sm_user_photo_round' => '2',
	'sm_body_background_image' => 'public/admin/blank.png',
	'sm_body_background_color' => '#f7f8fa',
	'sm_font_color' => '#555',
	'sm_font_color_light' => '#888',
	'sm_heading_color' => '#555',
	'sm_link_color' => '#222',
	'sm_link_color_hover' => '#e82f34',
	'sm_content_heading_background_color' => '#f1f1f1',
	'sm_content_background_color' => '#fff',
	'sm_content_border_color' => '#eee',
	'sm_content_border_color_dark' => '#ddd',
	'sm_input_background_color' => '#fff',
	'sm_input_font_color' => '#000',
	'sm_input_border_color' => '#dce0e3',
	'sm_button_background_color' => '#e82f34',
	'sm_button_background_color_hover' => '#2d2d2d',
	'sm_button_background_color_active' => '#e82f34',
	'sm_button_font_color' => '#fff',
	'sm_header_background_color' => '#222222',
	'sm_header_border_color' => '#000',
	'sm_menu_logo_top_space' => '10px',
	'sm_mainmenu_background_color' => '#515151',
	'sm_mainmenu_background_color_hover' => '#363636',
	'sm_mainmenu_link_color' => '#ddd',
	'sm_mainmenu_link_color_hover' => '#fff',
	'sm_mainmenu_border_color' => '#666',
	'sm_minimenu_link_color' => '#ddd',
	'sm_minimenu_link_color_hover' => '#fff',
	'sm_minimenu_border_color' => '#aaa',
	'sm_minimenu_icon' => 'minimenu-icons-white.png',
	'sm_header_searchbox_background_color' => '#222222',
	'sm_header_searchbox_text_color' => '#ddd',
	'sm_header_searchbox_border_color' => '#666',
	'sm_footer_background_image' => 'public/admin/blank.png',
	'sm_footer_design' => '1',
	'sm_footer_background_color' => '#2D2D2D',
	'sm_footer_border_color' => '#e82f34',
	'sm_footer_text_color' => '#fff',
	'sm_footer_link_color' => '#fff',
	'sm_footer_link_hover_color' => '#e82f34',
	'sm_popup_design' => '2',

	'sm_body_fontfamily' => 'Arial, Helvetica, sans-serif',
	'sm_body_fontsize'  =>  '13px',
	'sm_heading_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sm_heading_fontsize' =>  '17px',
	'sm_mainmenu_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sm_mainmenu_fontsize' =>  '13px',
	'sm_tab_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sm_tab_fontsize' =>  '15px',
);
Engine_Api::_()->sesspectromedia()->readWriteXML('', '', $default_constants);

//Search Work
$availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
if( is_array($availableTypes) && count($availableTypes) > 0 ) {
  $options = array();
  foreach( $availableTypes as $index => $type ) {
    $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
    $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'sesspectromedia')->hasType(array('type' => $type));
    if(!$hasType) {
      $db->query("INSERT IGNORE INTO `engine4_sesspectromedia_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
    }
  }
}

// $table_exist_recipients = $db->query('SHOW TABLES LIKE \'engine4_messages_recipients\'')->fetch();
// if (!empty($table_exist_recipients)) {
// 	$sm_read = $db->query('SHOW COLUMNS FROM engine4_messages_recipients LIKE \'sm_read\'')->fetch();
// 	if (empty($sm_read)) {
// 		$db->query('ALTER TABLE `engine4_messages_recipients` ADD `sm_read` TINYINT(1) NOT NULL DEFAULT "0";');
// 	}
// }
//
// $table_exist_notifications = $db->query('SHOW TABLES LIKE \'engine4_activity_notifications\'')->fetch();
// if (!empty($table_exist_notifications)) {
// 	$sm_read = $db->query('SHOW COLUMNS FROM engine4_activity_notifications LIKE \'sm_read\'')->fetch();
// 	if (empty($sm_read)) {
// 		$db->query('ALTER TABLE `engine4_activity_notifications` ADD `sm_read` TINYINT(1) NOT NULL DEFAULT "0";');
// 	}
// }

// $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
// ("core_mini_notification", "user", "Notifications", "", \'{"route":"default","module":"sesspectromedia","controller":"notifications","action":"pulldown"}\', "core_mini", "", 999),
// ("core_mini_friends", "user", "Friend Requests", "", \'{"route":"default","module":"sesspectromedia","controller":"index","action":"friend-request"}\', "core_mini", "", 999);');
