<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Header Default Work
$content_id = $this->widgetCheck(array('widget_name' => 'sesfbstyle.header', 'page_id' => '1'));
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
if (empty($content_id)) {
  if($minimenu)
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$minimenu.'";');
  if($menulogo)
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$menulogo.'";');
  if($mainmenu)
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$mainmenu.'";');
  if($minisearch)
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$minisearch.'";');
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesfbstyle.header',
    'page_id' => 1,
    'parent_content_id' => $parent_content_id,
    'order' => 20,
  ));
}

//Footer Default Work
$footerContent_id = $this->widgetCheck(array('widget_name' => 'sesfbstyle.footer', 'page_id' => '2'));
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
      'name' => 'sesfbstyle.footer',
      'page_id' => 2,
      'parent_content_id' => $parent_content_id,
      'order' => 10,
  ));
}

$db->query('UPDATE `engine4_sesbasic_menuitems` SET `enabled` = "0" WHERE `engine4_sesbasic_menuitems`.`name` = "core_mini_profile";');
$db->query('UPDATE `engine4_sesbasic_menuitems` SET `enabled` = "0" WHERE `engine4_sesbasic_menuitems`.`name` = "core_mini_update";');

$default_constants = array(
  'sesfbstyle_header_background_color' => '#264c9a',
  'sesfbstyle_header_border_color' => '#133783',
  'sesfbstyle_header_search_background_color' => '#fff',
  'sesfbstyle_header_search_border_color' => '#264c9a',
  'sesfbstyle_header_search_button_background_color' => '#f6f7f9',
  'sesfbstyle_header_search_button_font_color' => '#7d7d7d',
  'sesfbstyle_header_font_color' => '#fff',
  'sesfbstyle_mainmenu_search_background_color' => '#131923',
  'sesfbstyle_mainmenu_background_color' => '#2d3f61',
  'sesfbstyle_mainmenu_links_color' => '#eef3fd',
  'sesfbstyle_mainmenu_links_hover_color' => '#fff',
  'sesfbstyle_mainmenu_footer_font_color' => '#bdbdbd',
  'sesfbstyle_minimenu_links_color' => '#000',
  'sesfbstyle_minimenu_link_active_color' => '#fff',
  'sesfbstyle_footer_background_color' => '#fff',
  'sesfbstyle_footer_font_color' => '#737373',
  'sesfbstyle_footer_links_color' => '#133783',
  'sesfbstyle_footer_border_color' => '#d8dadc',
  'sesfbstyle_theme_color' => '#264c9a',
  'sesfbstyle_body_background_color' => '#d8dadc',
  'sesfbstyle_font_color' => '#000',
  'sesfbstyle_font_color_light' => '#808D97',
  'sesfbstyle_links_color' => '#133783',
  'sesfbstyle_links_hover_color' => '#133783',
  'sesfbstyle_headline_background_color' => '#f6f7f9',
  'sesfbstyle_headline_color' => '#000',
  'sesfbstyle_border_color' => '#d8dadc',
  'sesfbstyle_box_background_color' => '#fff',
  'sesfbstyle_form_label_color' => '#455B6B',
  'sesfbstyle_input_background_color' => '#fff',
  'sesfbstyle_input_font_color' => '#5f727f',
  'sesfbstyle_input_border_color' => '#d7d8da',
  'sesfbstyle_button_background_color' => '#264c9a',
  'sesfbstyle_button_background_color_hover' => '#133783',
  'sesfbstyle_button_font_color' => '#fff',
  'sesfbstyle_button_border_color' => '#264c9a',
  'sesfbstyle_dashboard_list_background_color_hover' => '#f4f6f7',
  'sesfbstyle_dashboard_list_border_color' => '#dddfe2',
  'sesfbstyle_dashboard_font_color' => '#4b4f56',
  'sesfbstyle_dashboard_link_color' => '#4b4f56',
	'sesfbstyle_comments_background_color' => '#f2f3f5',
  'custom_theme_color' => '11',
);
Engine_Api::_()->sesfbstyle()->readWriteXML('', '', $default_constants);

//$this->uploadDashboardIcons();

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

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesfbstyle.deshboard-links',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => 1,
  ));
}

$db->query('INSERT IGNORE INTO `engine4_sesfbstyle_customthemes` (`customtheme_id`, `name`, `description`, `default`) VALUES
(1, "Theme - 1", \'a:60:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:1:"1";s:13:"custom_themes";N;s:34:"sesfbstyle_header_background_color";s:7:"#264c9a";s:30:"sesfbstyle_header_border_color";s:7:"#133783";s:41:"sesfbstyle_header_search_background_color";s:7:"#FFFFFF";s:37:"sesfbstyle_header_search_border_color";s:7:"#FFFFFF";s:48:"sesfbstyle_header_search_button_background_color";s:7:"#F6F7F9";s:42:"sesfbstyle_header_search_button_font_color";s:7:"#7D7D7D";s:28:"sesfbstyle_header_font_color";s:7:"#FFFFFF";s:43:"sesfbstyle_mainmenu_search_background_color";s:7:"#131923";s:36:"sesfbstyle_mainmenu_background_color";s:7:"#2D3F61";s:31:"sesfbstyle_mainmenu_links_color";s:7:"#EEF3FD";s:37:"sesfbstyle_mainmenu_links_hover_color";s:7:"#FFFFFF";s:37:"sesfbstyle_mainmenu_footer_font_color";s:7:"#BDBDBD";s:31:"sesfbstyle_minimenu_links_color";s:7:"#FFFFFF";s:37:"sesfbstyle_minimenu_link_active_color";s:7:"#FFFFFF";s:28:"sesfbstyle_header_icons_type";s:1:"2";s:34:"sesfbstyle_footer_background_color";s:7:"#FFFFFF";s:28:"sesfbstyle_footer_font_color";s:7:"#737373";s:29:"sesfbstyle_footer_links_color";s:7:"#133783";s:30:"sesfbstyle_footer_border_color";s:7:"#d8dadc";s:22:"sesfbstyle_theme_color";s:7:"#264c9a";s:32:"sesfbstyle_body_background_color";s:7:"#d8dadc";s:21:"sesfbstyle_font_color";s:7:"#000000";s:27:"sesfbstyle_font_color_light";s:7:"#808D97";s:22:"sesfbstyle_links_color";s:7:"#133783";s:28:"sesfbstyle_links_hover_color";s:7:"#133783";s:36:"sesfbstyle_headline_background_color";s:7:"#F6F7F9";s:25:"sesfbstyle_headline_color";s:7:"#000000";s:23:"sesfbstyle_border_color";s:7:"#E1E2E3";s:31:"sesfbstyle_box_background_color";s:7:"#FFFFFF";s:27:"sesfbstyle_form_label_color";s:7:"#455B6B";s:33:"sesfbstyle_input_background_color";s:7:"#FFFFFF";s:27:"sesfbstyle_input_font_color";s:7:"#5F727F";s:29:"sesfbstyle_input_border_color";s:7:"#D7D8DA";s:34:"sesfbstyle_button_background_color";s:7:"#264c9a";s:40:"sesfbstyle_button_background_color_hover";s:7:"#133783";s:28:"sesfbstyle_button_font_color";s:7:"#FFFFFF";s:30:"sesfbstyle_button_border_color";s:7:"#133783";s:48:"sesfbstyle_dashboard_list_background_color_hover";s:7:"#F4F6F7";s:38:"sesfbstyle_dashboard_list_border_color";s:7:"#DDDFE2";s:31:"sesfbstyle_dashboard_font_color";s:7:"#4B4F56";s:31:"sesfbstyle_dashboard_link_color";s:7:"#4B4F56";s:36:"sesfbstyle_comments_background_color";s:7:"#F2F3F5";s:11:"lp_settings";N;s:37:"sesfbstyle_lp_header_background_color";s:7:"#264c9a";s:33:"sesfbstyle_lp_header_border_color";s:7:"#133783";s:43:"sesfbstyle_lp_header_input_background_color";s:7:"#FFFFFF";s:39:"sesfbstyle_lp_header_input_border_color";s:7:"#264c9a";s:44:"sesfbstyle_lp_header_button_background_color";s:7:"#264c9a";s:38:"sesfbstyle_lp_header_button_font_color";s:7:"#FFFFFF";s:39:"sesfbstyle_lp_header_button_hover_color";s:7:"#133783";s:31:"sesfbstyle_lp_header_font_color";s:7:"#FFFFFF";s:31:"sesfbstyle_lp_header_link_color";s:7:"#9CB4D8";s:33:"sesfbstyle_lp_signup_button_color";s:7:"#67AE55";s:40:"sesfbstyle_lp_signup_button_border_color";s:7:"#2C5115";s:38:"sesfbstyle_lp_signup_button_font_color";s:7:"#FFFFFF";s:39:"sesfbstyle_lp_signup_button_hover_color";s:7:"#67AE55";s:44:"sesfbstyle_lp_signup_button_hover_font_color";s:7:"#FFFFFF";}\', 1),
(2, "Theme - 2", \'a:60:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:1:"2";s:13:"custom_themes";N;s:34:"sesfbstyle_header_background_color";s:7:"#FFFFFF";s:30:"sesfbstyle_header_border_color";s:7:"#F1EEEE";s:41:"sesfbstyle_header_search_background_color";s:7:"#FFFFFF";s:37:"sesfbstyle_header_search_border_color";s:7:"#E4E4E4";s:48:"sesfbstyle_header_search_button_background_color";s:7:"#2C8EF1";s:42:"sesfbstyle_header_search_button_font_color";s:7:"#FFFFFF";s:28:"sesfbstyle_header_font_color";s:7:"#000000";s:43:"sesfbstyle_mainmenu_search_background_color";s:7:"#131923";s:36:"sesfbstyle_mainmenu_background_color";s:7:"#2D3F61";s:31:"sesfbstyle_mainmenu_links_color";s:7:"#EEF3FD";s:37:"sesfbstyle_mainmenu_links_hover_color";s:7:"#FFFFFF";s:37:"sesfbstyle_mainmenu_footer_font_color";s:7:"#BDBDBD";s:31:"sesfbstyle_minimenu_links_color";s:7:"#000000";s:37:"sesfbstyle_minimenu_link_active_color";s:7:"#FFFFFF";s:28:"sesfbstyle_header_icons_type";s:1:"2";s:34:"sesfbstyle_footer_background_color";s:7:"#FFFFFF";s:28:"sesfbstyle_footer_font_color";s:7:"#737373";s:29:"sesfbstyle_footer_links_color";s:7:"#133783";s:30:"sesfbstyle_footer_border_color";s:7:"#d8dadc";s:22:"sesfbstyle_theme_color";s:7:"#2C8EF1";s:32:"sesfbstyle_body_background_color";s:7:"#F7F7F7";s:21:"sesfbstyle_font_color";s:7:"#000000";s:27:"sesfbstyle_font_color_light";s:7:"#808D97";s:22:"sesfbstyle_links_color";s:7:"#000000";s:28:"sesfbstyle_links_hover_color";s:7:"#2C8EF1";s:36:"sesfbstyle_headline_background_color";s:7:"#F6F7F9";s:25:"sesfbstyle_headline_color";s:7:"#000000";s:23:"sesfbstyle_border_color";s:7:"#d8dadc";s:31:"sesfbstyle_box_background_color";s:7:"#FFFFFF";s:27:"sesfbstyle_form_label_color";s:7:"#455B6B";s:33:"sesfbstyle_input_background_color";s:7:"#FFFFFF";s:27:"sesfbstyle_input_font_color";s:7:"#5F727F";s:29:"sesfbstyle_input_border_color";s:7:"#D7D8DA";s:34:"sesfbstyle_button_background_color";s:7:"#2C8EF1";s:40:"sesfbstyle_button_background_color_hover";s:7:"#4EA6FF";s:28:"sesfbstyle_button_font_color";s:7:"#FFFFFF";s:30:"sesfbstyle_button_border_color";s:7:"#4EA6FF";s:48:"sesfbstyle_dashboard_list_background_color_hover";s:7:"#F1F1F1";s:38:"sesfbstyle_dashboard_list_border_color";s:7:"#DDDFE2";s:31:"sesfbstyle_dashboard_font_color";s:7:"#4B4F56";s:31:"sesfbstyle_dashboard_link_color";s:7:"#4B4F56";s:36:"sesfbstyle_comments_background_color";s:7:"#F7F7F7";s:11:"lp_settings";N;s:37:"sesfbstyle_lp_header_background_color";s:7:"#FFFFFF";s:33:"sesfbstyle_lp_header_border_color";s:7:"#F1EEEE";s:43:"sesfbstyle_lp_header_input_background_color";s:7:"#FFFFFF";s:39:"sesfbstyle_lp_header_input_border_color";s:7:"#264c9a";s:44:"sesfbstyle_lp_header_button_background_color";s:7:"#2C8EF1";s:38:"sesfbstyle_lp_header_button_font_color";s:7:"#FFFFFF";s:39:"sesfbstyle_lp_header_button_hover_color";s:7:"#4EA6FF";s:31:"sesfbstyle_lp_header_font_color";s:7:"#000000";s:31:"sesfbstyle_lp_header_link_color";s:7:"#4EA6FF";s:33:"sesfbstyle_lp_signup_button_color";s:7:"#67AE55";s:40:"sesfbstyle_lp_signup_button_border_color";s:7:"#2C5115";s:38:"sesfbstyle_lp_signup_button_font_color";s:7:"#FFFFFF";s:39:"sesfbstyle_lp_signup_button_hover_color";s:7:"#67AE55";s:44:"sesfbstyle_lp_signup_button_hover_font_color";s:7:"#FFFFFF";}\', 1),
(3, "Theme - 3", \'a:60:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:1:"3";s:13:"custom_themes";N;s:34:"sesfbstyle_header_background_color";s:7:"#0E0E0E";s:30:"sesfbstyle_header_border_color";s:7:"#0E0E0E";s:41:"sesfbstyle_header_search_background_color";s:7:"#292929";s:37:"sesfbstyle_header_search_border_color";s:7:"#292929";s:48:"sesfbstyle_header_search_button_background_color";s:7:"#04B0D3";s:42:"sesfbstyle_header_search_button_font_color";s:7:"#FFFFFF";s:28:"sesfbstyle_header_font_color";s:7:"#FFFFFF";s:43:"sesfbstyle_mainmenu_search_background_color";s:7:"#141414";s:36:"sesfbstyle_mainmenu_background_color";s:7:"#04B0D3";s:31:"sesfbstyle_mainmenu_links_color";s:7:"#FFFFFF";s:37:"sesfbstyle_mainmenu_links_hover_color";s:7:"#FFFFFF";s:37:"sesfbstyle_mainmenu_footer_font_color";s:7:"#FFFFFF";s:31:"sesfbstyle_minimenu_links_color";s:7:"#FFFFFF";s:37:"sesfbstyle_minimenu_link_active_color";s:7:"#04B0D3";s:28:"sesfbstyle_header_icons_type";s:1:"3";s:34:"sesfbstyle_footer_background_color";s:7:"#0E0E0E";s:28:"sesfbstyle_footer_font_color";s:7:"#FFFFFF";s:29:"sesfbstyle_footer_links_color";s:7:"#04B0D3";s:30:"sesfbstyle_footer_border_color";s:7:"#191919";s:22:"sesfbstyle_theme_color";s:7:"#04B0D3";s:32:"sesfbstyle_body_background_color";s:7:"#191919";s:21:"sesfbstyle_font_color";s:7:"#FFFFFF";s:27:"sesfbstyle_font_color_light";s:7:"#CCCCCC";s:22:"sesfbstyle_links_color";s:7:"#FFFFFF";s:28:"sesfbstyle_links_hover_color";s:7:"#04B0D3";s:36:"sesfbstyle_headline_background_color";s:7:"#0E0E0E";s:25:"sesfbstyle_headline_color";s:7:"#FFFFFF";s:23:"sesfbstyle_border_color";s:7:"#191919";s:31:"sesfbstyle_box_background_color";s:7:"#0E0E0E";s:27:"sesfbstyle_form_label_color";s:7:"#FFFFFF";s:33:"sesfbstyle_input_background_color";s:7:"#FFFFFF";s:27:"sesfbstyle_input_font_color";s:7:"#5F727F";s:29:"sesfbstyle_input_border_color";s:7:"#D7D8DA";s:34:"sesfbstyle_button_background_color";s:7:"#04B0D3";s:40:"sesfbstyle_button_background_color_hover";s:7:"#04B0D3";s:28:"sesfbstyle_button_font_color";s:7:"#FFFFFF";s:30:"sesfbstyle_button_border_color";s:7:"#04B0D3";s:48:"sesfbstyle_dashboard_list_background_color_hover";s:7:"#04B0D3";s:38:"sesfbstyle_dashboard_list_border_color";s:7:"#0E0E0E";s:31:"sesfbstyle_dashboard_font_color";s:7:"#FFFFFF";s:31:"sesfbstyle_dashboard_link_color";s:7:"#FFFFFF";s:36:"sesfbstyle_comments_background_color";s:7:"#131212";s:11:"lp_settings";N;s:37:"sesfbstyle_lp_header_background_color";s:7:"#0E0E0E";s:33:"sesfbstyle_lp_header_border_color";s:7:"#0E0E0E";s:43:"sesfbstyle_lp_header_input_background_color";s:7:"#292929";s:39:"sesfbstyle_lp_header_input_border_color";s:7:"#0E0E0E";s:44:"sesfbstyle_lp_header_button_background_color";s:7:"#04B0D3";s:38:"sesfbstyle_lp_header_button_font_color";s:7:"#FFFFFF";s:39:"sesfbstyle_lp_header_button_hover_color";s:7:"#04B0D3";s:31:"sesfbstyle_lp_header_font_color";s:7:"#FFFFFF";s:31:"sesfbstyle_lp_header_link_color";s:7:"#04B0D3";s:33:"sesfbstyle_lp_signup_button_color";s:7:"#67AE55";s:40:"sesfbstyle_lp_signup_button_border_color";s:7:"#2C5115";s:38:"sesfbstyle_lp_signup_button_font_color";s:7:"#FFFFFF";s:39:"sesfbstyle_lp_signup_button_hover_color";s:7:"#67AE55";s:44:"sesfbstyle_lp_signup_button_hover_font_color";s:7:"#FFFFFF";}\', 1);');

//Update Mini Menu
// $db->update('engine4_core_menuitems', array('order' => 5), array('name = ?' => 'core_mini_profile'));
// $db->update('engine4_core_menuitems', array('order' => 8), array('name = ?' => 'core_mini_notification'));
// $db->update('engine4_core_menuitems', array('order' => 7), array('name = ?' => 'core_mini_messages'));
// $db->update('engine4_core_menuitems', array('order' => 6), array('name = ?' => 'core_mini_friends'));
// $db->update('engine4_core_menuitems', array('order' => 4), array('name = ?' => 'core_mini_settings'));
// $db->update('engine4_core_menuitems', array('order' => 3), array('name = ?' => 'core_mini_admin'));
// $db->update('engine4_core_menuitems', array('order' => 2), array('name = ?' => 'core_mini_auth'));
// $db->update('engine4_core_menuitems', array('order' => 1), array('name = ?' => 'core_mini_signup'));

// $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
// ("core_mini_notification", "user", "Notifications", "", \'{"route":"default","module":"sesfbstyle","controller":"notifications","action":"pulldown"}\', "core_mini", "", 999),
// ("core_mini_friends", "user", "Friend Requests", "", \'{"route":"default","module":"sesfbstyle","controller":"index","action":"friend-request"}\', "core_mini", "", 999);');

// $column_exist = $db->query("SHOW COLUMNS FROM engine4_messages_recipients LIKE 'ses_read'")->fetch();
// if (empty($column_exist)) {
//   $db->query("ALTER TABLE `engine4_messages_recipients` ADD `ses_read` TINYINT( 1 ) NOT NULL DEFAULT '0';");
// }
//
// $table_exist_notifications = $db->query('SHOW TABLES LIKE \'engine4_activity_notifications\'')->fetch();
// if (!empty($table_exist_notifications)) {
//   $ses_read = $db->query('SHOW COLUMNS FROM engine4_activity_notifications LIKE \'ses_read\'')->fetch();
//   if (empty($ses_read)) {
//     $db->query('ALTER TABLE `engine4_activity_notifications` ADD `ses_read` TINYINT(1) NOT NULL DEFAULT "0";');
//   }
// }
//
// $column_exist = $db->query("SHOW COLUMNS FROM engine4_activity_notifications LIKE 'view_notification'")->fetch();
// if (empty($column_exist)) {
//   $db->query("ALTER TABLE `engine4_activity_notifications` ADD `view_notification` TINYINT( 1 ) NOT NULL;");
// }
