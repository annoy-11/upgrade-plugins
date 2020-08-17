<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$default_constants = array(
  'socialtube_theme_color' => '#e82f34',
	'socialtube_theme_secondary_color' => '#222',
	'socialtube_main_width' => '1200px',
	'socialtube_left_columns_width' => '240px',
	'socialtube_right_columns_width' => '240px',
	'socialtube_header_fixed_layout' => '2',
	'socialtube_responsive_layout' => '1',
	'socialtube_header_design' => '6',
	'socialtube_user_photo_round' => '2',
	'socialtube_body_background_image' => 'public/admin/blank.png',
	'socialtube_popup_heading_background_image' => 'public/admin/blank.png',
	'socialtube_popup_heading_color' => '#fff',
	'socialtube_body_background_color' => '#f7f8fa',
	'socialtube_font_color' => '#555',
	'socialtube_font_color_light' => '#888',
	'socialtube_heading_color' => '#555',
	'socialtube_link_color' => '#222',
	'socialtube_link_color_hover' => '#e82f34',	
	'socialtube_content_heading_background_color' => '#f1f1f1',
	'socialtube_content_background_color' => '#fff',
	'socialtube_content_border_color' => '#eee',
	'socialtube_content_border_color_dark' => '#ddd',
	'socialtube_input_background_color' => '#fff',
	'socialtube_input_font_color' => '#000',
	'socialtube_input_border_color' => '#dce0e3',
	'socialtube_button_background_color' => '#e82f34',
	'socialtube_button_background_color_hover' => '#2d2d2d',
	'socialtube_button_background_color_active' => '#e82f34',
	'socialtube_button_font_color' => '#fff',
	'socialtube_header_background_color' => '#222222',
	'socialtube_header_border_color' => '#000',
	'socialtube_menu_logo_top_space' => '10px',
	'socialtube_mainmenu_background_color' => '#515151',
	'socialtube_mainmenu_background_color_hover' => '#363636',
	'socialtube_mainmenu_link_color' => '#ddd',
	'socialtube_mainmenu_link_color_hover' => '#fff',
	'socialtube_mainmenu_border_color' => '#666',
	'socialtube_minimenu_link_color' => '#ddd',
	'socialtube_minimenu_link_color_hover' => '#fff',
	'socialtube_minimenu_border_color' => '#aaa',
	'socialtube_minimenu_icon' => 'minimenu-icons-white.png',
	'socialtube_header_searchbox_background_color' => '#222222',
	'socialtube_header_searchbox_text_color' => '#ddd',
	'socialtube_header_searchbox_border_color' => '#666',
	'socialtube_footer_background_image' => 'public/admin/blank.png',
	'socialtube_footer_design' => '1',
	'socialtube_footer_background_color' => '#2D2D2D',
	'socialtube_footer_border_color' => '#e82f34',
	'socialtube_footer_text_color' => '#fff',
	'socialtube_footer_link_color' => '#fff',
	'socialtube_footer_link_hover_color' => '#e82f34',
	'socialtube_popup_design' => '2',
);
Engine_Api::_()->sessocialtube()->readWriteXML('', '', $default_constants);

//Search Work
$availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
if( is_array($availableTypes) && count($availableTypes) > 0 ) {
  $options = array();
  foreach( $availableTypes as $index => $type ) {
    $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
    $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'sessocialtube')->hasType(array('type' => $type));
    if(!$hasType) {
      $db->query("INSERT IGNORE INTO `engine4_sessocialtube_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
    }
  }
}

$table_exist_recipients = $db->query('SHOW TABLES LIKE \'engine4_messages_recipients\'')->fetch();
if (!empty($table_exist_recipients)) {
	$socialtube_read = $db->query('SHOW COLUMNS FROM engine4_messages_recipients LIKE \'socialtube_read\'')->fetch();
	if (empty($socialtube_read)) {
		$db->query('ALTER TABLE `engine4_messages_recipients` ADD `socialtube_read` TINYINT(1) NOT NULL DEFAULT "0";');
	}
}

$table_exist_notifications = $db->query('SHOW TABLES LIKE \'engine4_activity_notifications\'')->fetch();
if (!empty($table_exist_notifications)) {
	$socialtube_read = $db->query('SHOW COLUMNS FROM engine4_activity_notifications LIKE \'socialtube_read\'')->fetch();
	if (empty($socialtube_read)) {
		$db->query('ALTER TABLE `engine4_activity_notifications` ADD `socialtube_read` TINYINT(1) NOT NULL DEFAULT "0";');
	}
}