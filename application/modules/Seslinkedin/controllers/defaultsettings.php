<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Header Default Work
$content_id = $this->widgetCheck(array('widget_name' => 'seslinkedin.header', 'page_id' => '1'));
$minimenu = $this->widgetCheck(array('widget_name' => 'core.menu-mini', 'page_id' => '1'));
$menulogo = $this->widgetCheck(array('widget_name' => 'core.menu-logo', 'page_id' => '1'));
$mainmenu = $this->widgetCheck(array('widget_name' => 'core.menu-main', 'page_id' => '1'));
$minisearch = $this->widgetCheck(array('widget_name' => 'core.search-mini', 'page_id' => '1'));
$parent_content_id = $db->select()
      ->from('engine4_core_content', 'content_id')
      ->where('type = ?', 'container')
      ->where('page_id = ?', '1')
      ->where('name = ?', 'main')
      ->limit(1)
      ->query()
      ->fetchColumn();

  if($minimenu)
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$minimenu.'";');
  if($menulogo)
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$menulogo.'";');
  if($mainmenu)
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$mainmenu.'";');
  if($minisearch)
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$minisearch.'";');
if (empty($content_id)) {
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslinkedin.header',
    'page_id' => 1,
    'parent_content_id' => $parent_content_id,
    'order' => 20,
  ));
}

//Footer Default Work
$footerContent_id = $this->widgetCheck(array('widget_name' => 'seslinkedin.footer', 'page_id' => '2'));
$footerMenu = $this->widgetCheck(array('widget_name' => 'core.menu-footer', 'page_id' => '2'));
$parent_content_id = $db->select()
        ->from('engine4_core_content', 'content_id')
        ->where('type = ?', 'container')
        ->where('page_id = ?', '2')
        ->where('name = ?', 'main')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (empty($footerContent_id)) {
  if($footerMenu)
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$footerMenu.'";');
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seslinkedin.footer',
      'page_id' => 2,
      'parent_content_id' => $parent_content_id,
      'order' => 10,
  ));
}

$db->query('UPDATE `engine4_sesbasic_menuitems` SET `enabled` = "0" WHERE `engine4_sesbasic_menuitems`.`name` = "core_mini_profile";');
$db->query('UPDATE `engine4_sesbasic_menuitems` SET `enabled` = "0" WHERE `engine4_sesbasic_menuitems`.`name` = "core_mini_update";');

$default_constants = array(
  'seslinkedin_header_background_color' => '#4267b2',
  'seslinkedin_header_border_color' => '#29487d',
  'seslinkedin_header_search_background_color' => '#fff',
  'seslinkedin_header_search_border_color' => '#4267b2',
  'seslinkedin_header_search_button_background_color' => '#f6f7f9',
  'seslinkedin_header_search_button_font_color' => '#7d7d7d',
  'seslinkedin_header_font_color' => '#fff',
  'seslinkedin_mainmenu_search_background_color' => '#131923',
  'seslinkedin_mainmenu_background_color' => '#2d3f61',
  'seslinkedin_mainmenu_links_color' => '#eef3fd',
  'seslinkedin_mainmenu_links_hover_color' => '#fff',
  'seslinkedin_mainmenu_footer_font_color' => '#bdbdbd',
  'seslinkedin_minimenu_links_color' => '#000',
  'seslinkedin_minimenu_link_active_color' => '#fff',
  'seslinkedin_footer_background_color' => '#fff',
  'seslinkedin_footer_font_color' => '#737373',
  'seslinkedin_footer_links_color' => '#365899',
  'seslinkedin_footer_border_color' => '#e9ebee',
  'seslinkedin_theme_color' => '#4267b2',
  'seslinkedin_body_background_color' => '#e9ebee',
  'seslinkedin_font_color' => '#000',
  'seslinkedin_font_color_light' => '#808..D97',
  'seslinkedin_links_color' => '#365899',
  'seslinkedin_links_hover_color' => '#29487d',
  'seslinkedin_headline_background_color' => '#f6f7f9',
  'seslinkedin_headline_color' => '#000',
  'seslinkedin_border_color' => '#e9ebee',
  'seslinkedin_box_background_color' => '#fff',
  'seslinkedin_form_label_color' => '#455B6B',
  'seslinkedin_input_background_color' => '#fff',
  'seslinkedin_input_font_color' => '#5f727f',
  'seslinkedin_input_border_color' => '#d7d8da',
  'seslinkedin_button_background_color' => '#4267b2',
  'seslinkedin_button_background_color_hover' => '#365899',
  'seslinkedin_button_font_color' => '#fff',
  'seslinkedin_button_border_color' => '#4267b2',
  'seslinkedin_dashboard_list_background_color_hover' => '#f4f6f7',
  'seslinkedin_dashboard_list_border_color' => '#dddfe2',
  'seslinkedin_dashboard_font_color' => '#4b4f56',
  'seslinkedin_dashboard_link_color' => '#4b4f56',
	'seslinkedin_comments_background_color' => '#f2f3f5',
  'custom_theme_color' => '11',

  'seslinkedin_body_fontfamily' => 'Arial, Helvetica, sans-serif',
  'seslinkedin_body_fontsize'  =>  '13px',
  'seslinkedin_heading_fontfamily' =>  'Arial, Helvetica, sans-serif',
  'seslinkedin_heading_fontsize' =>  '17px',
  'seslinkedin_mainmenu_fontfamily' =>  'Arial, Helvetica, sans-serif',
  'seslinkedin_mainmenu_fontsize' =>  '13px',
  'seslinkedin_tab_fontfamily' =>  'Arial, Helvetica, sans-serif',
  'seslinkedin_tab_fontsize' =>  '15px',
);
Engine_Api::_()->seslinkedin()->readWriteXML('', '', $default_constants);


//Member Home Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'user_index_home')
        ->limit(1)
        ->query()
        ->fetchColumn();
if($page_id) {
  $left_id = $db->select()
    ->from('engine4_core_content', 'content_id')
    ->where('page_id = ?', $page_id)
    ->where('type = ?', 'container')
    ->where('name = ?', 'left')
    ->limit(1)
    ->query()
    ->fetchColumn();
}

$db->query('INSERT IGNORE INTO `engine4_seslinkedin_customthemes` (`customtheme_id`, `name`, `description`, `default`) VALUES
(1, "Theme - 1", \'a:60:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:1:"1";s:13:"custom_themes";N;s:34:"seslinkedin_header_background_color";s:7:"#4267B2";s:30:"seslinkedin_header_border_color";s:7:"#133783";s:41:"seslinkedin_header_search_background_color";s:7:"#FFFFFF";s:37:"seslinkedin_header_search_border_color";s:7:"#FFFFFF";s:48:"seslinkedin_header_search_button_background_color";s:7:"#F6F7F9";s:42:"seslinkedin_header_search_button_font_color";s:7:"#7D7D7D";s:28:"seslinkedin_header_font_color";s:7:"#FFFFFF";s:43:"seslinkedin_mainmenu_search_background_color";s:7:"#131923";s:36:"seslinkedin_mainmenu_background_color";s:7:"#2D3F61";s:31:"seslinkedin_mainmenu_links_color";s:7:"#EEF3FD";s:37:"seslinkedin_mainmenu_links_hover_color";s:7:"#FFFFFF";s:37:"seslinkedin_mainmenu_footer_font_color";s:7:"#BDBDBD";s:31:"seslinkedin_minimenu_links_color";s:7:"#FFFFFF";s:37:"seslinkedin_minimenu_link_active_color";s:7:"#FFFFFF";s:28:"seslinkedin_header_icons_type";s:1:"2";s:34:"seslinkedin_footer_background_color";s:7:"#FFFFFF";s:28:"seslinkedin_footer_font_color";s:7:"#737373";s:29:"seslinkedin_footer_links_color";s:7:"#365899";s:30:"seslinkedin_footer_border_color";s:7:"#E9EBEE";s:22:"seslinkedin_theme_color";s:7:"#4267B2";s:32:"seslinkedin_body_background_color";s:7:"#E9EBEE";s:21:"seslinkedin_font_color";s:7:"#000000";s:27:"seslinkedin_font_color_light";s:7:"#808D97";s:22:"seslinkedin_links_color";s:7:"#365899";s:28:"seslinkedin_links_hover_color";s:7:"#29487D";s:36:"seslinkedin_headline_background_color";s:7:"#F6F7F9";s:25:"seslinkedin_headline_color";s:7:"#000000";s:23:"seslinkedin_border_color";s:7:"#E1E2E3";s:31:"seslinkedin_box_background_color";s:7:"#FFFFFF";s:27:"seslinkedin_form_label_color";s:7:"#455B6B";s:33:"seslinkedin_input_background_color";s:7:"#FFFFFF";s:27:"seslinkedin_input_font_color";s:7:"#5F727F";s:29:"seslinkedin_input_border_color";s:7:"#D7D8DA";s:34:"seslinkedin_button_background_color";s:7:"#4267B2";s:40:"seslinkedin_button_background_color_hover";s:7:"#365899";s:28:"seslinkedin_button_font_color";s:7:"#FFFFFF";s:30:"seslinkedin_button_border_color";s:7:"#133783";s:48:"seslinkedin_dashboard_list_background_color_hover";s:7:"#F4F6F7";s:38:"seslinkedin_dashboard_list_border_color";s:7:"#DDDFE2";s:31:"seslinkedin_dashboard_font_color";s:7:"#4B4F56";s:31:"seslinkedin_dashboard_link_color";s:7:"#4B4F56";s:36:"seslinkedin_comments_background_color";s:7:"#F2F3F5";s:11:"lp_settings";N;s:37:"seslinkedin_lp_header_background_color";s:7:"#4267B2";s:33:"seslinkedin_lp_header_border_color";s:7:"#133783";s:43:"seslinkedin_lp_header_input_background_color";s:7:"#FFFFFF";s:39:"seslinkedin_lp_header_input_border_color";s:7:"#4267B2";s:44:"seslinkedin_lp_header_button_background_color";s:7:"#4267B2";s:38:"seslinkedin_lp_header_button_font_color";s:7:"#FFFFFF";s:39:"seslinkedin_lp_header_button_hover_color";s:7:"#365899";s:31:"seslinkedin_lp_header_font_color";s:7:"#FFFFFF";s:31:"seslinkedin_lp_header_link_color";s:7:"#9CB4D8";s:33:"seslinkedin_lp_signup_button_color";s:7:"#67AE55";s:40:"seslinkedin_lp_signup_button_border_color";s:7:"#2C5115";s:38:"seslinkedin_lp_signup_button_font_color";s:7:"#FFFFFF";s:39:"seslinkedin_lp_signup_button_hover_color";s:7:"#67AE55";s:44:"seslinkedin_lp_signup_button_hover_font_color";s:7:"#FFFFFF";}\', 1),
(2, "Theme - 2", \'a:60:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:1:"2";s:13:"custom_themes";N;s:34:"seslinkedin_header_background_color";s:7:"#FFFFFF";s:30:"seslinkedin_header_border_color";s:7:"#F1EEEE";s:41:"seslinkedin_header_search_background_color";s:7:"#FFFFFF";s:37:"seslinkedin_header_search_border_color";s:7:"#E4E4E4";s:48:"seslinkedin_header_search_button_background_color";s:7:"#2C8EF1";s:42:"seslinkedin_header_search_button_font_color";s:7:"#FFFFFF";s:28:"seslinkedin_header_font_color";s:7:"#000000";s:43:"seslinkedin_mainmenu_search_background_color";s:7:"#131923";s:36:"seslinkedin_mainmenu_background_color";s:7:"#2D3F61";s:31:"seslinkedin_mainmenu_links_color";s:7:"#EEF3FD";s:37:"seslinkedin_mainmenu_links_hover_color";s:7:"#FFFFFF";s:37:"seslinkedin_mainmenu_footer_font_color";s:7:"#BDBDBD";s:31:"seslinkedin_minimenu_links_color";s:7:"#000000";s:37:"seslinkedin_minimenu_link_active_color";s:7:"#FFFFFF";s:28:"seslinkedin_header_icons_type";s:1:"2";s:34:"seslinkedin_footer_background_color";s:7:"#FFFFFF";s:28:"seslinkedin_footer_font_color";s:7:"#737373";s:29:"seslinkedin_footer_links_color";s:7:"#365899";s:30:"seslinkedin_footer_border_color";s:7:"#E9EBEE";s:22:"seslinkedin_theme_color";s:7:"#2C8EF1";s:32:"seslinkedin_body_background_color";s:7:"#F7F7F7";s:21:"seslinkedin_font_color";s:7:"#000000";s:27:"seslinkedin_font_color_light";s:7:"#808D97";s:22:"seslinkedin_links_color";s:7:"#000000";s:28:"seslinkedin_links_hover_color";s:7:"#2C8EF1";s:36:"seslinkedin_headline_background_color";s:7:"#F6F7F9";s:25:"seslinkedin_headline_color";s:7:"#000000";s:23:"seslinkedin_border_color";s:7:"#E9EBEE";s:31:"seslinkedin_box_background_color";s:7:"#FFFFFF";s:27:"seslinkedin_form_label_color";s:7:"#455B6B";s:33:"seslinkedin_input_background_color";s:7:"#FFFFFF";s:27:"seslinkedin_input_font_color";s:7:"#5F727F";s:29:"seslinkedin_input_border_color";s:7:"#D7D8DA";s:34:"seslinkedin_button_background_color";s:7:"#2C8EF1";s:40:"seslinkedin_button_background_color_hover";s:7:"#4EA6FF";s:28:"seslinkedin_button_font_color";s:7:"#FFFFFF";s:30:"seslinkedin_button_border_color";s:7:"#4EA6FF";s:48:"seslinkedin_dashboard_list_background_color_hover";s:7:"#F1F1F1";s:38:"seslinkedin_dashboard_list_border_color";s:7:"#DDDFE2";s:31:"seslinkedin_dashboard_font_color";s:7:"#4B4F56";s:31:"seslinkedin_dashboard_link_color";s:7:"#4B4F56";s:36:"seslinkedin_comments_background_color";s:7:"#F7F7F7";s:11:"lp_settings";N;s:37:"seslinkedin_lp_header_background_color";s:7:"#FFFFFF";s:33:"seslinkedin_lp_header_border_color";s:7:"#F1EEEE";s:43:"seslinkedin_lp_header_input_background_color";s:7:"#FFFFFF";s:39:"seslinkedin_lp_header_input_border_color";s:7:"#4267B2";s:44:"seslinkedin_lp_header_button_background_color";s:7:"#2C8EF1";s:38:"seslinkedin_lp_header_button_font_color";s:7:"#FFFFFF";s:39:"seslinkedin_lp_header_button_hover_color";s:7:"#4EA6FF";s:31:"seslinkedin_lp_header_font_color";s:7:"#000000";s:31:"seslinkedin_lp_header_link_color";s:7:"#4EA6FF";s:33:"seslinkedin_lp_signup_button_color";s:7:"#67AE55";s:40:"seslinkedin_lp_signup_button_border_color";s:7:"#2C5115";s:38:"seslinkedin_lp_signup_button_font_color";s:7:"#FFFFFF";s:39:"seslinkedin_lp_signup_button_hover_color";s:7:"#67AE55";s:44:"seslinkedin_lp_signup_button_hover_font_color";s:7:"#FFFFFF";}\', 1);');

