<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$default_constants = array(
    'theme_color' => '1',
    'sespagethm_theme_color' => '#85B44C',
	'sespagethm_theme_secondary_color' => '#3593C4',
	'sespagethm_main_width' => '1200px',
	'sespagethm_left_columns_width' => '240px',
	'sespagethm_right_columns_width' => '240px',
	'sespagethm_header_fixed_layout' => '2',
	'sespagethm_responsive_layout' => '1',
	'sespagethm_header_design' => '4',
	'sespagethm_user_photo_round' => '2',
	'sespagethm_body_background_image' => 'public/admin/blank.png',
	'sespagethm_body_background_color' => '#FFFFFF',
	'sespagethm_font_color' => '#555555',
	'sespagethm_font_color_light' => '#999999',
	'sespagethm_heading_color' => '#555555',
	'sespagethm_link_color' => '#000000',
	'sespagethm_link_color_hover' => '#3593C4',
	'sespagethm_content_heading_background_color' => '#FFFFFF',
	'sespagethm_content_background_color' => '#FDFDFD',
	'sespagethm_content_border_color' => '#E2E4E6',
	'sespagethm_content_border_color_dark' => '#E2E4E6',
	'sespagethm_input_background_color' => '#FFFFFF',
	'sespagethm_input_font_color' => '#000000',
	'sespagethm_input_border_color' => '#E2E4E6',
	'sespagethm_button_background_color' => '#85B44C',
	'sespagethm_button_background_color_hover' => '#3593C4',
	'sespagethm_button_background_color_active' => '#3593C4',
	'sespagethm_button_font_color' => '#FFFFFF',
	'sespagethm_header_background_color' => '#444444',
	'sespagethm_header_border_color' => '#444444',
	'sespagethm_menu_logo_top_space' => '10px',
	'sespagethm_mainmenu_background_color' => '#85B44C',
	'sespagethm_mainmenu_background_color_hover' => '#85B44C',
	'sespagethm_mainmenu_link_color' => '#FFFFFF',
	'sespagethm_mainmenu_link_color_hover' => '#FFFFFF',
	'sespagethm_mainmenu_border_color' => '#85B44C',
	'sespagethm_minimenu_link_color' => '#FFFFFF',
	'sespagethm_minimenu_link_color_hover' => '#85B44C',
	'sespagethm_minimenu_border_color' => '#85B44C',
	'sespagethm_minimenu_icon' => 'minimenu-icons-white.png',
	'sespagethm_header_searchbox_background_color' => '#FFFFFF',
	'sespagethm_header_searchbox_text_color' => '#111111',
	'sespagethm_header_searchbox_border_color' => '#FFFFFF',
	'sespagethm_footer_background_image' => 'public/admin/blank.png',
	'sespagethm_footer_design' => '3',
	'sespagethm_footer_background_color' => '#E8E8E8',
	'sespagethm_footer_border_color' => '#3593C4',
	'sespagethm_footer_text_color' => '#555555',
	'sespagethm_footer_link_color' => '#000000',
	'sespagethm_footer_link_hover_color' => '#3593C4',
	'sespagethm_popup_design' => '2',
	'sespagethm_body_fontfamily' => 'Arial, Helvetica, sans-serif',
	'sespagethm_body_fontsize'  =>  '13px',
	'sespagethm_heading_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sespagethm_heading_fontsize' =>  '17px',
	'sespagethm_mainmenu_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sespagethm_mainmenu_fontsize' =>  '13px',
	'sespagethm_tab_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sespagethm_tab_fontsize' =>  '15px',
);
Engine_Api::_()->sespagethm()->readWriteXML('', '', $default_constants);

//Search Work
$availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
if( is_array($availableTypes) && count($availableTypes) > 0 ) {
  $options = array();
  foreach( $availableTypes as $index => $type ) {
    $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
    $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'sespagethm')->hasType(array('type' => $type));
    if(!$hasType) {
      $db->query("INSERT IGNORE INTO `engine4_sespagethm_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
    }
  }
}

$db->query("UPDATE `engine4_core_settings` SET `name` = 'sespagethm.footertext.en' WHERE `engine4_core_settings`.`name` = 'sespagethm.footertext';");
$db->query("UPDATE `engine4_core_settings` SET `name` = 'sespagethm.landinapagetext.en' WHERE `engine4_core_settings`.`name` = 'sespagethm.landinapagetext';");
