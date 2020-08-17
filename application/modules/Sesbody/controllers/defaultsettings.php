<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$default_constants = array(
  'sesbody_theme_color' => '#e82f34',
	'sesbody_theme_secondary_color' => '#222',
	'sesbody_main_width' => '1200px',
	'sesbody_left_columns_width' => '240px',
	'sesbody_right_columns_width' => '240px',
	//'sesbody_header_fixed_layout' => '2',
	'sesbody_responsive_layout' => '1',
	'sesbody_header_design' => '1',
	'sesbody_user_photo_round' => '2',
	'sesbody_body_background_image' => 'public/admin/blank.png',
	'sesbody_body_background_color' => '#f7f8fa',
	'sesbody_font_color' => '#555',
	'sesbody_font_color_light' => '#888',
	'sesbody_heading_color' => '#555',
	'sesbody_link_color' => '#222',
	'sesbody_link_color_hover' => '#e82f34',
	'sesbody_content_heading_background_color' => '#f1f1f1',
	'sesbody_content_background_color' => '#fff',
	'sesbody_content_border_color' => '#eee',
	'sesbody_content_border_color_dark' => '#ddd',
	'sesbody_input_background_color' => '#fff',
	'sesbody_input_font_color' => '#000',
	'sesbody_input_border_color' => '#dce0e3',
	'sesbody_button_background_color' => '#e82f34',
	'sesbody_button_background_color_hover' => '#2d2d2d',
	'sesbody_button_background_color_active' => '#e82f34',
	'sesbody_button_font_color' => '#fff',
	'sesbody_header_background_color' => '#191919',
	'sesbody_header_border_color' => '#000',
	'sesbody_menu_logo_top_space' => '10px',
	'sesbody_mainmenu_background_color' => '#E82F34',
	'sesbody_mainmenu_background_color_hover' => '#C9292D',
	'sesbody_mainmenu_link_color' => '#FFFFFF',
	'sesbody_mainmenu_link_color_hover' => '#fff',
	'sesbody_mainmenu_border_color' => '#666',
	'sesbody_minimenu_link_color' => '#ddd',
	'sesbody_minimenu_link_color_hover' => '#C9292D',
	'sesbody_minimenu_border_color' => '#aaa',
	'sesbody_minimenu_icon' => 'minimenu-icons-white.png',
	'sesbody_header_searchbox_background_color' => '#191919',
	'sesbody_header_searchbox_text_color' => '#FFFFFF',
	'sesbody_header_searchbox_border_color' => '#666',
	'sesbody_footer_background_image' => 'public/admin/blank.png',
	'sesbody_footer_design' => '1',
	'sesbody_footer_background_color' => '#2D2D2D',
	'sesbody_footer_border_color' => '#e82f34',
	'sesbody_footer_text_color' => '#fff',
	'sesbody_footer_link_color' => '#fff',
	'sesbody_footer_link_hover_color' => '#e82f34',
	'sesbody_popup_design' => '2',

	'sesbody_body_fontfamily' => 'Arial, Helvetica, sans-serif',
	'sesbody_body_fontsize'  =>  '13px',
	'sesbody_heading_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sesbody_heading_fontsize' =>  '17px',
	'sesbody_mainmenu_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sesbody_mainmenu_fontsize' =>  '13px',
	'sesbody_tab_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sesbody_tab_fontsize' =>  '15px',
	'sesbody_buttoneffect' => 0,
);
Engine_Api::_()->sesbody()->readWriteXML('', '', $default_constants);

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesbody_admin_main_customcss", "sesbody", "Custom CSS", "", \'{"route":"admin_default","module":"sesbody","controller":"custom-theme", "action":"index"}\', "sesbody_admin_main", "", 54);');

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesbody_admin_main_typography", "sesbody", "Manage Fonts", "", \'{"route":"admin_default","module":"sesbody","controller":"settings", "action":"typography"}\', "sesbody_admin_main", "", 50);');
