<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$default_constants = array(
    'sesytube_body_background_image' => 'public/admin/blank.png',
    'sesytube_user_photo_round' => '1',
    'sesytube_feed_style' => '2',
    'sesytube_left_columns_width' => '240px',
    'sesytube_right_columns_width' => '240px',
    'sesytube_footer_background_image' => 'public/admin/blank.png',
    'sesytube_header_background_color' => '#FFFFFF',
    'sesytube_menu_logo_font_color' => '#EE0F11',
    'sesytube_mainmenu_background_color' => '#F5F5F5',
    'sesytube_mainmenu_links_color' => '#000000',
    'sesytube_mainmenu_links_hover_color' => '#EE0F11',
    'sesytube_minimenu_links_color' => '#59B2F6',
    'sesytube_minimenu_links_hover_color' => '#0098DD',
    'sesytube_minimenu_icon_background_color' => '#F07AB1',
    'sesytube_minimenu_icon_background_active_color' => '#FFFFFF',
    'sesytube_minimenu_icon_color' => '#9C9C9C',
    'sesytube_minimenu_icon_active_color' => '#EE0F11',
    'sesytube_header_searchbox_background_color' => '#F5F5F5',
    'sesytube_header_searchbox_text_color' => '#A0A0A0',
    'sesytube_toppanel_userinfo_background_color' => '#ED54A4',
    'sesytube_toppanel_userinfo_font_color' => '#FFFFFF',
    'sesytube_login_popup_header_background_color' => '#FFFFFF',
    'sesytube_login_popup_header_font_color' => '#FFFFFF',
    'sesytube_footer_background_color' => '#FFFFFF',
    'sesytube_footer_links_color' => '#A4A4A4',
    'sesytube_footer_links_hover_color' => '#4682B4',
    'sesytube_footer_border_color' => '#ED54A4',
    'sesytube_theme_color' => '#EE0F11',
    'sesytube_body_background_color' => '#FAFAFA',
    'sesytube_font_color' => '#545454',
    'sesytube_font_color_light' => '#999999',
    'sesytube_heading_color' => '#545454',
    'sesytube_links_color' => '#000000',
    'sesytube_links_hover_color' => '#EE0F11',
    'sesytube_content_header_font_color' => '#545454',
    'sesytube_content_background_color' => '#FFFFFF',
    'sesytube_content_border_color' => '#EDEDED',
    'sesytube_form_label_color' => '#545454',
    'sesytube_input_background_color' => '#FFFFFF',
    'sesytube_input_font_color' => '#545454',
    'sesytube_input_border_color' => '#C6C6C6',
    'sesytube_button_background_color' => '#EE0F11',
    'sesytube_button_background_color_hover' => '#FE2022',
    'sesytube_button_font_color' => '#FFFFFF',
    'sesytube_button_font_hover_color' => '#FFFFFF',
    'sesytube_comment_background_color' => '#FDFDFD',
    'custom_theme_color' => '13',
    'sesytube_body_fontfamily' => 'Roboto',
    'sesytube_body_fontsize' => '14px',
    'sesytube_heading_fontfamily' => 'Roboto',
    'sesytube_heading_fontsize' => '17px',
    'sesytube_mainmenu_fontfamily' => 'Roboto',
    'sesytube_mainmenu_fontsize' => '14px',
    'sesytube_tab_fontfamily' => 'Roboto',
    'sesytube_tab_fontsize' => '15px',
    'theme_color' => '1',
    'sesytube_mainmenu_background_hover_color' => '#FFFFFF',
    'sesytube_topbar_menu_section_border_color' => '#FFFFFF',
    'sesytube_content_background_color_hover' => '#F2F2F2',
);

Engine_Api::_()->sesytube()->readWriteXML('', '', $default_constants);

//Header Default Work
$content_id = $this->widgetCheck(array('widget_name' => 'sesytube.header', 'page_id' => '1'));

$minimenu = $this->widgetCheck(array('widget_name' => 'core.menu-mini', 'page_id' => '1'));
$menulogo = $this->widgetCheck(array('widget_name' => 'core.menu-logo', 'page_id' => '1'));
$mainmenu = $this->widgetCheck(array('widget_name' => 'core.menu-main', 'page_id' => '1'));
$search = $this->widgetCheck(array('widget_name' => 'core.search-mini', 'page_id' => '1'));

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
  if($search)
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$search.'";');
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesytube.header',
      'page_id' => 1,
      'parent_content_id' => $parent_content_id,
      'order' => 20,
  ));
}

// //Footer Default Work
// $footerContent_id = $this->widgetCheck(array('widget_name' => 'sesytube.menu-footer', 'page_id' => '2'));
// $footerMenu = $this->widgetCheck(array('widget_name' => 'core.menu-footer', 'page_id' => '2'));
// $parent_content_id = $db->select()
//         ->from('engine4_core_content', 'content_id')
//         ->where('type = ?', 'container')
//         ->where('page_id = ?', '2')
//         ->where('name = ?', 'main')
//         ->limit(1)
//         ->query()
//         ->fetchColumn();
// if (empty($footerContent_id)) {
//   if($footerMenu)
//     $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$footerMenu.'";');
//
//   $db->insert('engine4_core_content', array(
//       'type' => 'widget',
//       'name' => 'sesytube.menu-footer',
//       'page_id' => 2,
//       'parent_content_id' => $parent_content_id,
//       'order' => 10,
//   ));
// }

//Quick links footer
$menuitem_id = $db->select()
  ->from('engine4_core_menuitems', 'id')
  ->limit(1)
  ->order('id DESC')
  ->query()
  ->fetchColumn();

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
("custom_'.$menuitem_id++.'", "core", "Albums", "", \'{"uri":"albums","icon":""}\', "sesytube_quicklinks_footer", "", 1, 1, 1),
("custom_'.$menuitem_id++.'", "core", "Blogs", "", \'{"uri":"blogs","icon":""}\', "sesytube_quicklinks_footer", "", 1, 1, 2),
("custom_'.$menuitem_id++.'", "core", "Events", "", \'{"uri":"events"}\', "sesytube_quicklinks_footer", "", 1, 1, 3),
("custom_'.$menuitem_id++.'", "core", "Videos", "", \'{"uri":"videos","icon":"","target":"","enabled":"1"}\', "sesytube_quicklinks_footer", "", 1, 1, 4),
("custom_'.$menuitem_id++.'", "core", "Music", "", \'{"uri":"music/album/home","icon":"","target":"","enabled":"1"}\', "sesytube_quicklinks_footer", "", 1, 1, 5);');


$db->query('INSERT IGNORE INTO `engine4_sesytube_banners` (`banner_name`, `creation_date`, `modified_date`, `enabled`) VALUES ("Member Home Page", "2016-11-21 15:45:57", "2016-11-21 15:45:57", 1);');

$db->query('INSERT IGNORE INTO `engine4_sesytube_slides` (`slide_id`, `banner_id`, `title`, `title_button_color`, `description`, `description_button_color`, `file_type`, `file_id`, `status`, `extra_button_linkopen`, `extra_button`, `extra_button_text`, `extra_button_link`, `order`, `creation_date`, `modified_date`, `enabled`) VALUES
(1, 1, "Grow your network with us", "FFFFFF", "", "FFFFFF", "jpg", 26519, "1", 0, 0, "Read More", "", 0, "2016-11-21 15:46:41", "2016-11-21 16:23:07", 1),
(2, 1, "Join Your Favourite Groups", "FFFFFF", "", "FFFFFF", "jpg", 26520, "1", 0, 0, "Read More", "", 0, "2016-11-21 15:49:10", "2016-11-21 16:24:00", 1),
(3, 1, "Write To Share Your Thoughts", "FFFFFF", "", "FFFFFF", "jpg", 26518, "1", 0, 1, "Write New Blog", "blog/create", 0, "2016-11-21 15:50:06", "2016-11-21 16:25:32", 1);');

//Upload Banner images
$this->uploadHomeBanner();


$page_table = Engine_Api::_()->getDbtable('pages', 'core');
$page_table_name = $page_table->info('name');

$content_table = Engine_Api::_()->getDbtable('content', 'core');
$content_table_name = $content_table->info('name');

//Login Page
$select = new Zend_Db_Select($db);
$page_login_id = $select
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'user_auth_login')
        ->query()
        ->fetchColumn();
if ($page_login_id) {
  $db->query("UPDATE  `engine4_core_content` SET  `name` =  'sesytube.login' WHERE  `engine4_core_content`.`name` ='core.content' AND `engine4_core_content`.`page_id` ='".$page_login_id."' LIMIT 1");
}


//Default theme color for custom theme
$db->query('INSERT IGNORE INTO `engine4_sesytube_customthemes` (`customtheme_id`, `name`, `description`, `default`) VALUES
(1, "Theme - 1", \'a:38:{s:11:"theme_color";s:1:"1";s:18:"custom_theme_color";s:2:"11";s:13:"custom_themes";N;s:32:"sesytube_header_background_color";s:7:"#FFFFFF";s:29:"sesytube_menu_logo_font_color";s:7:"#EE0F11";s:34:"sesytube_mainmenu_background_color";s:7:"#F5F5F5";s:40:"sesytube_mainmenu_background_hover_color";s:7:"#EBEBEB";s:29:"sesytube_mainmenu_links_color";s:7:"#000000";s:35:"sesytube_mainmenu_links_hover_color";s:7:"#EE0F11";s:41:"sesytube_topbar_menu_section_border_color";s:7:"#DCDCDC";s:29:"sesytube_minimenu_links_color";s:7:"#59B2F6";s:35:"sesytube_minimenu_links_hover_color";s:7:"#0098DD";s:28:"sesytube_minimenu_icon_color";s:7:"#9C9C9C";s:35:"sesytube_minimenu_icon_active_color";s:7:"#EE0F11";s:42:"sesytube_header_searchbox_background_color";s:7:"#F5F5F5";s:36:"sesytube_header_searchbox_text_color";s:7:"#A0A0A0";s:44:"sesytube_login_popup_header_background_color";s:7:"#EE0F11";s:38:"sesytube_login_popup_header_font_color";s:7:"#FFFFFF";s:20:"sesytube_theme_color";s:7:"#EE0F11";s:30:"sesytube_body_background_color";s:7:"#FAFAFA";s:19:"sesytube_font_color";s:7:"#545454";s:25:"sesytube_font_color_light";s:7:"#999999";s:22:"sesytube_heading_color";s:7:"#545454";s:20:"sesytube_links_color";s:7:"#000000";s:26:"sesytube_links_hover_color";s:7:"#EE0F11";s:34:"sesytube_content_header_font_color";s:7:"#545454";s:33:"sesytube_content_background_color";s:7:"#FFFFFF";s:39:"sesytube_content_background_color_hover";s:7:"#F2F2F2";s:29:"sesytube_content_border_color";s:7:"#EDEDED";s:25:"sesytube_form_label_color";s:7:"#545454";s:31:"sesytube_input_background_color";s:7:"#FFFFFF";s:25:"sesytube_input_font_color";s:7:"#545454";s:27:"sesytube_input_border_color";s:7:"#C6C6C6";s:32:"sesytube_button_background_color";s:7:"#EE0F11";s:38:"sesytube_button_background_color_hover";s:7:"#FE2022";s:26:"sesytube_button_font_color";s:7:"#FFFFFF";s:32:"sesytube_button_font_hover_color";s:7:"#FFFFFF";s:33:"sesytube_comment_background_color";s:7:"#FDFDFD";}\', 0),
(2, "Theme - 2", \'a:38:{s:11:"theme_color";s:1:"2";s:18:"custom_theme_color";s:2:"11";s:13:"custom_themes";N;s:32:"sesytube_header_background_color";s:7:"#FFFFFF";s:29:"sesytube_menu_logo_font_color";s:7:"#03AAF5";s:34:"sesytube_mainmenu_background_color";s:7:"#F5F5F5";s:40:"sesytube_mainmenu_background_hover_color";s:7:"#EBEBEB";s:29:"sesytube_mainmenu_links_color";s:7:"#000000";s:35:"sesytube_mainmenu_links_hover_color";s:7:"#03aaf5";s:41:"sesytube_topbar_menu_section_border_color";s:7:"#DCDCDC";s:29:"sesytube_minimenu_links_color";s:7:"#59B2F6";s:35:"sesytube_minimenu_links_hover_color";s:7:"#0098DD";s:28:"sesytube_minimenu_icon_color";s:7:"#9C9C9C";s:35:"sesytube_minimenu_icon_active_color";s:7:"#03AAF5";s:42:"sesytube_header_searchbox_background_color";s:7:"#F5F5F5";s:36:"sesytube_header_searchbox_text_color";s:7:"#A0A0A0";s:44:"sesytube_login_popup_header_background_color";s:7:"#03AAF5";s:38:"sesytube_login_popup_header_font_color";s:7:"#FFFFFF";s:20:"sesytube_theme_color";s:7:"#03AAF5";s:30:"sesytube_body_background_color";s:7:"#FAFAFA";s:19:"sesytube_font_color";s:7:"#545454";s:25:"sesytube_font_color_light";s:7:"#999999";s:22:"sesytube_heading_color";s:7:"#545454";s:20:"sesytube_links_color";s:7:"#000000";s:26:"sesytube_links_hover_color";s:7:"#03AAF5";s:34:"sesytube_content_header_font_color";s:7:"#545454";s:33:"sesytube_content_background_color";s:7:"#FFFFFF";s:39:"sesytube_content_background_color_hover";s:7:"#F2F2F2";s:29:"sesytube_content_border_color";s:7:"#EDEDED";s:25:"sesytube_form_label_color";s:7:"#545454";s:31:"sesytube_input_background_color";s:7:"#FFFFFF";s:25:"sesytube_input_font_color";s:7:"#545454";s:27:"sesytube_input_border_color";s:7:"#C6C6C6";s:32:"sesytube_button_background_color";s:7:"#03AAF5";s:38:"sesytube_button_background_color_hover";s:7:"#0098DD";s:26:"sesytube_button_font_color";s:7:"#FFFFFF";s:32:"sesytube_button_font_hover_color";s:7:"#FFFFFF";s:33:"sesytube_comment_background_color";s:7:"#FDFDFD";}\', 0),
(3, "Theme - 3", \'a:38:{s:11:"theme_color";s:1:"3";s:18:"custom_theme_color";s:1:"1";s:13:"custom_themes";N;s:32:"sesytube_header_background_color";s:7:"#FFFFFF";s:29:"sesytube_menu_logo_font_color";s:7:"#8BC34A";s:34:"sesytube_mainmenu_background_color";s:7:"#F5F5F5";s:40:"sesytube_mainmenu_background_hover_color";s:7:"#EBEBEB";s:29:"sesytube_mainmenu_links_color";s:7:"#000000";s:35:"sesytube_mainmenu_links_hover_color";s:7:"#7cb43b";s:41:"sesytube_topbar_menu_section_border_color";s:7:"#DCDCDC";s:29:"sesytube_minimenu_links_color";s:7:"#59B2F6";s:35:"sesytube_minimenu_links_hover_color";s:7:"#0098DD";s:28:"sesytube_minimenu_icon_color";s:7:"#9C9C9C";s:35:"sesytube_minimenu_icon_active_color";s:7:"#8BC34A";s:42:"sesytube_header_searchbox_background_color";s:7:"#F5F5F5";s:36:"sesytube_header_searchbox_text_color";s:7:"#A0A0A0";s:44:"sesytube_login_popup_header_background_color";s:7:"#8BC34A";s:38:"sesytube_login_popup_header_font_color";s:7:"#FFFFFF";s:20:"sesytube_theme_color";s:7:"#8BC34A";s:30:"sesytube_body_background_color";s:7:"#FAFAFA";s:19:"sesytube_font_color";s:7:"#545454";s:25:"sesytube_font_color_light";s:7:"#999999";s:22:"sesytube_heading_color";s:7:"#545454";s:20:"sesytube_links_color";s:7:"#000000";s:26:"sesytube_links_hover_color";s:7:"#8BC34A";s:34:"sesytube_content_header_font_color";s:7:"#545454";s:33:"sesytube_content_background_color";s:7:"#FFFFFF";s:39:"sesytube_content_background_color_hover";s:7:"#F2F2F2";s:29:"sesytube_content_border_color";s:7:"#EDEDED";s:25:"sesytube_form_label_color";s:7:"#545454";s:31:"sesytube_input_background_color";s:7:"#FFFFFF";s:25:"sesytube_input_font_color";s:7:"#545454";s:27:"sesytube_input_border_color";s:7:"#C6C6C6";s:32:"sesytube_button_background_color";s:7:"#8BC34A";s:38:"sesytube_button_background_color_hover";s:7:"#7CB43B";s:26:"sesytube_button_font_color";s:7:"#FFFFFF";s:32:"sesytube_button_font_hover_color";s:7:"#FFFFFF";s:33:"sesytube_comment_background_color";s:7:"#FDFDFD";}\', 0),
(4, "Theme - 4", \'a:38:{s:11:"theme_color";s:1:"4";s:18:"custom_theme_color";s:1:"1";s:13:"custom_themes";N;s:32:"sesytube_header_background_color";s:7:"#FFFFFF";s:29:"sesytube_menu_logo_font_color";s:7:"#FF9800";s:34:"sesytube_mainmenu_background_color";s:7:"#F5F5F5";s:40:"sesytube_mainmenu_background_hover_color";s:7:"#EBEBEB";s:29:"sesytube_mainmenu_links_color";s:7:"#000000";s:35:"sesytube_mainmenu_links_hover_color";s:7:"#ff9800";s:41:"sesytube_topbar_menu_section_border_color";s:7:"#DCDCDC";s:29:"sesytube_minimenu_links_color";s:7:"#59B2F6";s:35:"sesytube_minimenu_links_hover_color";s:7:"#0098DD";s:28:"sesytube_minimenu_icon_color";s:7:"#9C9C9C";s:35:"sesytube_minimenu_icon_active_color";s:7:"#FF9800";s:42:"sesytube_header_searchbox_background_color";s:7:"#F5F5F5";s:36:"sesytube_header_searchbox_text_color";s:7:"#A0A0A0";s:44:"sesytube_login_popup_header_background_color";s:7:"#FF9800";s:38:"sesytube_login_popup_header_font_color";s:7:"#FFFFFF";s:20:"sesytube_theme_color";s:7:"#FF9800";s:30:"sesytube_body_background_color";s:7:"#FAFAFA";s:19:"sesytube_font_color";s:7:"#545454";s:25:"sesytube_font_color_light";s:7:"#999999";s:22:"sesytube_heading_color";s:7:"#545454";s:20:"sesytube_links_color";s:7:"#000000";s:26:"sesytube_links_hover_color";s:7:"#FF9800";s:34:"sesytube_content_header_font_color";s:7:"#545454";s:33:"sesytube_content_background_color";s:7:"#FFFFFF";s:39:"sesytube_content_background_color_hover";s:7:"#F2F2F2";s:29:"sesytube_content_border_color";s:7:"#EDEDED";s:25:"sesytube_form_label_color";s:7:"#545454";s:31:"sesytube_input_background_color";s:7:"#FFFFFF";s:25:"sesytube_input_font_color";s:7:"#545454";s:27:"sesytube_input_border_color";s:7:"#C6C6C6";s:32:"sesytube_button_background_color";s:7:"#FF9800";s:38:"sesytube_button_background_color_hover";s:7:"#E78F0E";s:26:"sesytube_button_font_color";s:7:"#FFFFFF";s:32:"sesytube_button_font_hover_color";s:7:"#FFFFFF";s:33:"sesytube_comment_background_color";s:7:"#FDFDFD";}\', 0),
(5, "Theme - 5", \'a:38:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:1:"1";s:13:"custom_themes";N;s:32:"sesytube_header_background_color";s:7:"#FFFFFF";s:29:"sesytube_menu_logo_font_color";s:7:"#EE0F11";s:34:"sesytube_mainmenu_background_color";s:7:"#F5F5F5";s:40:"sesytube_mainmenu_background_hover_color";s:7:"#EBEBEB";s:29:"sesytube_mainmenu_links_color";s:7:"#000000";s:35:"sesytube_mainmenu_links_hover_color";s:7:"#EE0F11";s:41:"sesytube_topbar_menu_section_border_color";s:7:"#DCDCDC";s:29:"sesytube_minimenu_links_color";s:7:"#59B2F6";s:35:"sesytube_minimenu_links_hover_color";s:7:"#0098DD";s:28:"sesytube_minimenu_icon_color";s:7:"#9C9C9C";s:35:"sesytube_minimenu_icon_active_color";s:7:"#EE0F11";s:42:"sesytube_header_searchbox_background_color";s:7:"#F5F5F5";s:36:"sesytube_header_searchbox_text_color";s:7:"#A0A0A0";s:44:"sesytube_login_popup_header_background_color";s:7:"#EE0F11";s:38:"sesytube_login_popup_header_font_color";s:7:"#FFFFFF";s:20:"sesytube_theme_color";s:7:"#EE0F11";s:30:"sesytube_body_background_color";s:7:"#FAFAFA";s:19:"sesytube_font_color";s:7:"#545454";s:25:"sesytube_font_color_light";s:7:"#999999";s:22:"sesytube_heading_color";s:7:"#545454";s:20:"sesytube_links_color";s:7:"#000000";s:26:"sesytube_links_hover_color";s:7:"#EE0F11";s:34:"sesytube_content_header_font_color";s:7:"#545454";s:33:"sesytube_content_background_color";s:7:"#FFFFFF";s:39:"sesytube_content_background_color_hover";s:7:"#F2F2F2";s:29:"sesytube_content_border_color";s:7:"#EDEDED";s:25:"sesytube_form_label_color";s:7:"#545454";s:31:"sesytube_input_background_color";s:7:"#FFFFFF";s:25:"sesytube_input_font_color";s:7:"#545454";s:27:"sesytube_input_border_color";s:7:"#C6C6C6";s:32:"sesytube_button_background_color";s:7:"#EE0F11";s:38:"sesytube_button_background_color_hover";s:7:"#FE2022";s:26:"sesytube_button_font_color";s:7:"#FFFFFF";s:32:"sesytube_button_font_hover_color";s:7:"#FFFFFF";s:33:"sesytube_comment_background_color";s:7:"#FDFDFD";}\', 0),
(6, "Theme - 6", \'a:38:{s:11:"theme_color";s:1:"6";s:18:"custom_theme_color";s:1:"1";s:13:"custom_themes";N;s:32:"sesytube_header_background_color";s:7:"#FFFFFF";s:29:"sesytube_menu_logo_font_color";s:7:"#FB0060";s:34:"sesytube_mainmenu_background_color";s:7:"#F5F5F5";s:40:"sesytube_mainmenu_background_hover_color";s:7:"#EBEBEB";s:29:"sesytube_mainmenu_links_color";s:7:"#000000";s:35:"sesytube_mainmenu_links_hover_color";s:7:"#FB0060";s:41:"sesytube_topbar_menu_section_border_color";s:7:"#DCDCDC";s:29:"sesytube_minimenu_links_color";s:7:"#59B2F6";s:35:"sesytube_minimenu_links_hover_color";s:7:"#0098DD";s:28:"sesytube_minimenu_icon_color";s:7:"#9C9C9C";s:35:"sesytube_minimenu_icon_active_color";s:7:"#FB0060";s:42:"sesytube_header_searchbox_background_color";s:7:"#F5F5F5";s:36:"sesytube_header_searchbox_text_color";s:7:"#A0A0A0";s:44:"sesytube_login_popup_header_background_color";s:7:"#FB0060";s:38:"sesytube_login_popup_header_font_color";s:7:"#FFFFFF";s:20:"sesytube_theme_color";s:7:"#FB0060";s:30:"sesytube_body_background_color";s:7:"#FAFAFA";s:19:"sesytube_font_color";s:7:"#545454";s:25:"sesytube_font_color_light";s:7:"#999999";s:22:"sesytube_heading_color";s:7:"#545454";s:20:"sesytube_links_color";s:7:"#000000";s:26:"sesytube_links_hover_color";s:7:"#FB0060";s:34:"sesytube_content_header_font_color";s:7:"#545454";s:33:"sesytube_content_background_color";s:7:"#FFFFFF";s:39:"sesytube_content_background_color_hover";s:7:"#F2F2F2";s:29:"sesytube_content_border_color";s:7:"#EDEDED";s:25:"sesytube_form_label_color";s:7:"#545454";s:31:"sesytube_input_background_color";s:7:"#FFFFFF";s:25:"sesytube_input_font_color";s:7:"#545454";s:27:"sesytube_input_border_color";s:7:"#C6C6C6";s:32:"sesytube_button_background_color";s:7:"#FB0060";s:38:"sesytube_button_background_color_hover";s:7:"#DD0859";s:26:"sesytube_button_font_color";s:7:"#FFFFFF";s:32:"sesytube_button_font_hover_color";s:7:"#FFFFFF";s:33:"sesytube_comment_background_color";s:7:"#FDFDFD";}\', 0),
(7, "Theme - 7", \'a:38:{s:11:"theme_color";s:1:"7";s:18:"custom_theme_color";s:1:"1";s:13:"custom_themes";N;s:32:"sesytube_header_background_color";s:7:"#FFFFFF";s:29:"sesytube_menu_logo_font_color";s:7:"#2C6C73";s:34:"sesytube_mainmenu_background_color";s:7:"#F5F5F5";s:40:"sesytube_mainmenu_background_hover_color";s:7:"#EBEBEB";s:29:"sesytube_mainmenu_links_color";s:7:"#000000";s:35:"sesytube_mainmenu_links_hover_color";s:7:"#2C6C73";s:41:"sesytube_topbar_menu_section_border_color";s:7:"#DCDCDC";s:29:"sesytube_minimenu_links_color";s:7:"#59B2F6";s:35:"sesytube_minimenu_links_hover_color";s:7:"#0098DD";s:28:"sesytube_minimenu_icon_color";s:7:"#9C9C9C";s:35:"sesytube_minimenu_icon_active_color";s:7:"#2C6C73";s:42:"sesytube_header_searchbox_background_color";s:7:"#F5F5F5";s:36:"sesytube_header_searchbox_text_color";s:7:"#A0A0A0";s:44:"sesytube_login_popup_header_background_color";s:7:"#2C6C73";s:38:"sesytube_login_popup_header_font_color";s:7:"#FFFFFF";s:20:"sesytube_theme_color";s:7:"#2C6C73";s:30:"sesytube_body_background_color";s:7:"#FAFAFA";s:19:"sesytube_font_color";s:7:"#545454";s:25:"sesytube_font_color_light";s:7:"#999999";s:22:"sesytube_heading_color";s:7:"#545454";s:20:"sesytube_links_color";s:7:"#000000";s:26:"sesytube_links_hover_color";s:7:"#2C6C73";s:34:"sesytube_content_header_font_color";s:7:"#545454";s:33:"sesytube_content_background_color";s:7:"#FFFFFF";s:39:"sesytube_content_background_color_hover";s:7:"#F2F2F2";s:29:"sesytube_content_border_color";s:7:"#EDEDED";s:25:"sesytube_form_label_color";s:7:"#545454";s:31:"sesytube_input_background_color";s:7:"#FFFFFF";s:25:"sesytube_input_font_color";s:7:"#545454";s:27:"sesytube_input_border_color";s:7:"#C6C6C6";s:32:"sesytube_button_background_color";s:7:"#2C6C73";s:38:"sesytube_button_background_color_hover";s:7:"#21575D";s:26:"sesytube_button_font_color";s:7:"#FFFFFF";s:32:"sesytube_button_font_hover_color";s:7:"#FFFFFF";s:33:"sesytube_comment_background_color";s:7:"#FDFDFD";}\', 0),
(8, "Theme - 8", \'a:38:{s:11:"theme_color";s:1:"8";s:18:"custom_theme_color";s:1:"1";s:13:"custom_themes";N;s:32:"sesytube_header_background_color";s:7:"#282828";s:29:"sesytube_menu_logo_font_color";s:7:"#EE0F11";s:34:"sesytube_mainmenu_background_color";s:7:"#1C1C1C";s:40:"sesytube_mainmenu_background_hover_color";s:7:"#474747";s:29:"sesytube_mainmenu_links_color";s:7:"#FFFFFF";s:35:"sesytube_mainmenu_links_hover_color";s:7:"#FFFFFF";s:41:"sesytube_topbar_menu_section_border_color";s:7:"#333333";s:29:"sesytube_minimenu_links_color";s:7:"#59B2F6";s:35:"sesytube_minimenu_links_hover_color";s:7:"#0098DD";s:28:"sesytube_minimenu_icon_color";s:7:"#9C9C9C";s:35:"sesytube_minimenu_icon_active_color";s:7:"#EE0F11";s:42:"sesytube_header_searchbox_background_color";s:7:"#191919";s:36:"sesytube_header_searchbox_text_color";s:7:"#FFFFFF";s:44:"sesytube_login_popup_header_background_color";s:7:"#EE0F11";s:38:"sesytube_login_popup_header_font_color";s:7:"#FFFFFF";s:20:"sesytube_theme_color";s:7:"#EE0F11";s:30:"sesytube_body_background_color";s:7:"#121212";s:19:"sesytube_font_color";s:7:"#FFFFFF";s:25:"sesytube_font_color_light";s:7:"#999999";s:22:"sesytube_heading_color";s:7:"#FFFFFF";s:20:"sesytube_links_color";s:7:"#FFFFFF";s:26:"sesytube_links_hover_color";s:7:"#EE0F11";s:34:"sesytube_content_header_font_color";s:7:"#FFFFFF";s:33:"sesytube_content_background_color";s:7:"#282828";s:39:"sesytube_content_background_color_hover";s:7:"#474747";s:29:"sesytube_content_border_color";s:7:"#4D4D4D";s:25:"sesytube_form_label_color";s:7:"#FFFFFF";s:31:"sesytube_input_background_color";s:7:"#191919";s:25:"sesytube_input_font_color";s:7:"#FFFFFF";s:27:"sesytube_input_border_color";s:7:"#333333";s:32:"sesytube_button_background_color";s:7:"#EE0F11";s:38:"sesytube_button_background_color_hover";s:7:"#FE2022";s:26:"sesytube_button_font_color";s:7:"#FFFFFF";s:32:"sesytube_button_font_hover_color";s:7:"#FFFFFF";s:33:"sesytube_comment_background_color";s:7:"#303030";}\', 0),
(9, "Theme - 9", \'a:38:{s:11:"theme_color";s:1:"9";s:18:"custom_theme_color";s:1:"1";s:13:"custom_themes";N;s:32:"sesytube_header_background_color";s:7:"#282828";s:29:"sesytube_menu_logo_font_color";s:7:"#03AAF5";s:34:"sesytube_mainmenu_background_color";s:7:"#1C1C1C";s:40:"sesytube_mainmenu_background_hover_color";s:7:"#474747";s:29:"sesytube_mainmenu_links_color";s:7:"#FFFFFF";s:35:"sesytube_mainmenu_links_hover_color";s:7:"#FFFFFF";s:41:"sesytube_topbar_menu_section_border_color";s:7:"#333333";s:29:"sesytube_minimenu_links_color";s:7:"#59B2F6";s:35:"sesytube_minimenu_links_hover_color";s:7:"#0098DD";s:28:"sesytube_minimenu_icon_color";s:7:"#9C9C9C";s:35:"sesytube_minimenu_icon_active_color";s:7:"#03AAF5";s:42:"sesytube_header_searchbox_background_color";s:7:"#191919";s:36:"sesytube_header_searchbox_text_color";s:7:"#FFFFFF";s:44:"sesytube_login_popup_header_background_color";s:7:"#03AAF5";s:38:"sesytube_login_popup_header_font_color";s:7:"#FFFFFF";s:20:"sesytube_theme_color";s:7:"#03AAF5";s:30:"sesytube_body_background_color";s:7:"#121212";s:19:"sesytube_font_color";s:7:"#FFFFFF";s:25:"sesytube_font_color_light";s:7:"#999999";s:22:"sesytube_heading_color";s:7:"#FFFFFF";s:20:"sesytube_links_color";s:7:"#FFFFFF";s:26:"sesytube_links_hover_color";s:7:"#03AAF5";s:34:"sesytube_content_header_font_color";s:7:"#FFFFFF";s:33:"sesytube_content_background_color";s:7:"#282828";s:39:"sesytube_content_background_color_hover";s:7:"#474747";s:29:"sesytube_content_border_color";s:7:"#4D4D4D";s:25:"sesytube_form_label_color";s:7:"#FFFFFF";s:31:"sesytube_input_background_color";s:7:"#191919";s:25:"sesytube_input_font_color";s:7:"#FFFFFF";s:27:"sesytube_input_border_color";s:7:"#333333";s:32:"sesytube_button_background_color";s:7:"#03AAF5";s:38:"sesytube_button_background_color_hover";s:7:"#0098DD";s:26:"sesytube_button_font_color";s:7:"#FFFFFF";s:32:"sesytube_button_font_hover_color";s:7:"#FFFFFF";s:33:"sesytube_comment_background_color";s:7:"#303030";}\', 0),
(10, "Theme - 10", \'a:38:{s:11:"theme_color";s:2:"11";s:18:"custom_theme_color";s:1:"1";s:13:"custom_themes";N;s:32:"sesytube_header_background_color";s:7:"#282828";s:29:"sesytube_menu_logo_font_color";s:7:"#FF9800";s:34:"sesytube_mainmenu_background_color";s:7:"#1C1C1C";s:40:"sesytube_mainmenu_background_hover_color";s:7:"#474747";s:29:"sesytube_mainmenu_links_color";s:7:"#FFFFFF";s:35:"sesytube_mainmenu_links_hover_color";s:7:"#FFFFFF";s:41:"sesytube_topbar_menu_section_border_color";s:7:"#333333";s:29:"sesytube_minimenu_links_color";s:7:"#59B2F6";s:35:"sesytube_minimenu_links_hover_color";s:7:"#0098DD";s:28:"sesytube_minimenu_icon_color";s:7:"#9C9C9C";s:35:"sesytube_minimenu_icon_active_color";s:7:"#FF9800";s:42:"sesytube_header_searchbox_background_color";s:7:"#191919";s:36:"sesytube_header_searchbox_text_color";s:7:"#FFFFFF";s:44:"sesytube_login_popup_header_background_color";s:7:"#FF9800";s:38:"sesytube_login_popup_header_font_color";s:7:"#FFFFFF";s:20:"sesytube_theme_color";s:7:"#FF9800";s:30:"sesytube_body_background_color";s:7:"#121212";s:19:"sesytube_font_color";s:7:"#FFFFFF";s:25:"sesytube_font_color_light";s:7:"#999999";s:22:"sesytube_heading_color";s:7:"#FFFFFF";s:20:"sesytube_links_color";s:7:"#FFFFFF";s:26:"sesytube_links_hover_color";s:7:"#FF9800";s:34:"sesytube_content_header_font_color";s:7:"#FFFFFF";s:33:"sesytube_content_background_color";s:7:"#282828";s:39:"sesytube_content_background_color_hover";s:7:"#474747";s:29:"sesytube_content_border_color";s:7:"#4D4D4D";s:25:"sesytube_form_label_color";s:7:"#FFFFFF";s:31:"sesytube_input_background_color";s:7:"#191919";s:25:"sesytube_input_font_color";s:7:"#FFFFFF";s:27:"sesytube_input_border_color";s:7:"#333333";s:32:"sesytube_button_background_color";s:7:"#FF9800";s:38:"sesytube_button_background_color_hover";s:7:"#E78F0E";s:26:"sesytube_button_font_color";s:7:"#FFFFFF";s:32:"sesytube_button_font_hover_color";s:7:"#FFFFFF";s:33:"sesytube_comment_background_color";s:7:"#303030";}\', 0),
(11, "Theme - 11", \'a:38:{s:11:"theme_color";s:2:"12";s:18:"custom_theme_color";s:1:"1";s:13:"custom_themes";N;s:32:"sesytube_header_background_color";s:7:"#282828";s:29:"sesytube_menu_logo_font_color";s:7:"#FB0060";s:34:"sesytube_mainmenu_background_color";s:7:"#1C1C1C";s:40:"sesytube_mainmenu_background_hover_color";s:7:"#474747";s:29:"sesytube_mainmenu_links_color";s:7:"#FFFFFF";s:35:"sesytube_mainmenu_links_hover_color";s:7:"#FFFFFF";s:41:"sesytube_topbar_menu_section_border_color";s:7:"#333333";s:29:"sesytube_minimenu_links_color";s:7:"#59B2F6";s:35:"sesytube_minimenu_links_hover_color";s:7:"#0098DD";s:28:"sesytube_minimenu_icon_color";s:7:"#9C9C9C";s:35:"sesytube_minimenu_icon_active_color";s:7:"#FB0060";s:42:"sesytube_header_searchbox_background_color";s:7:"#191919";s:36:"sesytube_header_searchbox_text_color";s:7:"#FFFFFF";s:44:"sesytube_login_popup_header_background_color";s:7:"#FB0060";s:38:"sesytube_login_popup_header_font_color";s:7:"#FFFFFF";s:20:"sesytube_theme_color";s:7:"#FB0060";s:30:"sesytube_body_background_color";s:7:"#121212";s:19:"sesytube_font_color";s:7:"#FFFFFF";s:25:"sesytube_font_color_light";s:7:"#999999";s:22:"sesytube_heading_color";s:7:"#FFFFFF";s:20:"sesytube_links_color";s:7:"#FFFFFF";s:26:"sesytube_links_hover_color";s:7:"#FB0060";s:34:"sesytube_content_header_font_color";s:7:"#FFFFFF";s:33:"sesytube_content_background_color";s:7:"#282828";s:39:"sesytube_content_background_color_hover";s:7:"#474747";s:29:"sesytube_content_border_color";s:7:"#4D4D4D";s:25:"sesytube_form_label_color";s:7:"#FFFFFF";s:31:"sesytube_input_background_color";s:7:"#191919";s:25:"sesytube_input_font_color";s:7:"#FFFFFF";s:27:"sesytube_input_border_color";s:7:"#333333";s:32:"sesytube_button_background_color";s:7:"#FB0060";s:38:"sesytube_button_background_color_hover";s:7:"#DD0859";s:26:"sesytube_button_font_color";s:7:"#FFFFFF";s:32:"sesytube_button_font_hover_color";s:7:"#FFFFFF";s:33:"sesytube_comment_background_color";s:7:"#303030";}\', 1),
(12, "Theme - 12", \'a:38:{s:11:"theme_color";s:2:"13";s:18:"custom_theme_color";s:1:"1";s:13:"custom_themes";N;s:32:"sesytube_header_background_color";s:7:"#282828";s:29:"sesytube_menu_logo_font_color";s:7:"#2C6C73";s:34:"sesytube_mainmenu_background_color";s:7:"#1C1C1C";s:40:"sesytube_mainmenu_background_hover_color";s:7:"#474747";s:29:"sesytube_mainmenu_links_color";s:7:"#FFFFFF";s:35:"sesytube_mainmenu_links_hover_color";s:7:"#FFFFFF";s:41:"sesytube_topbar_menu_section_border_color";s:7:"#333333";s:29:"sesytube_minimenu_links_color";s:7:"#59B2F6";s:35:"sesytube_minimenu_links_hover_color";s:7:"#0098DD";s:28:"sesytube_minimenu_icon_color";s:7:"#9C9C9C";s:35:"sesytube_minimenu_icon_active_color";s:7:"#2C6C73";s:42:"sesytube_header_searchbox_background_color";s:7:"#191919";s:36:"sesytube_header_searchbox_text_color";s:7:"#FFFFFF";s:44:"sesytube_login_popup_header_background_color";s:7:"#2C6C73";s:38:"sesytube_login_popup_header_font_color";s:7:"#FFFFFF";s:20:"sesytube_theme_color";s:7:"#2C6C73";s:30:"sesytube_body_background_color";s:7:"#121212";s:19:"sesytube_font_color";s:7:"#FFFFFF";s:25:"sesytube_font_color_light";s:7:"#999999";s:22:"sesytube_heading_color";s:7:"#FFFFFF";s:20:"sesytube_links_color";s:7:"#FFFFFF";s:26:"sesytube_links_hover_color";s:7:"#2C6C73";s:34:"sesytube_content_header_font_color";s:7:"#FFFFFF";s:33:"sesytube_content_background_color";s:7:"#282828";s:39:"sesytube_content_background_color_hover";s:7:"#474747";s:29:"sesytube_content_border_color";s:7:"#4D4D4D";s:25:"sesytube_form_label_color";s:7:"#FFFFFF";s:31:"sesytube_input_background_color";s:7:"#191919";s:25:"sesytube_input_font_color";s:7:"#FFFFFF";s:27:"sesytube_input_border_color";s:7:"#333333";s:32:"sesytube_button_background_color";s:7:"#2C6C73";s:38:"sesytube_button_background_color_hover";s:7:"#21575D";s:26:"sesytube_button_font_color";s:7:"#FFFFFF";s:32:"sesytube_button_font_hover_color";s:7:"#FFFFFF";s:33:"sesytube_comment_background_color";s:7:"#303030";}\', 1);');

$db->query("INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
('sesytube.banerdes', 'Share your Videos and let them talk for you'),
('sesytube.banner.bgimage', 'public/admin/ytube-theme-banner.jpg'),
('sesytube.body.background.image', 'public/admin/blank.png'),
('sesytube.body.fontfamily', 'Georgia, serif'),
('sesytube.body.fontsize', '14px'),
('sesytube.googlebody.fontfamily', '\"Roboto\"'),
('sesytube.googlebody.fontsize', '14px'),
('sesytube.googlefonts', '1'),
('sesytube.googleheading.fontfamily', '\"Roboto\"'),
('sesytube.googleheading.fontsize', '17px'),
('sesytube.googlemainmenu.fontfamily', '\"Roboto\"'),
('sesytube.googlemainmenu.fontsize', '14px'),
('sesytube.googletab.fontfamily', '\"Roboto\"'),
('sesytube.googletab.fontsize', '15px'),
('sesytube.header.loggedin.options.0', 'search'),
('sesytube.header.loggedin.options.1', 'miniMenu'),
('sesytube.header.loggedin.options.2', 'mainMenu'),
('sesytube.header.loggedin.options.3', 'logo'),
('sesytube.header.nonloggedin.options.0', 'search'),
('sesytube.header.nonloggedin.options.1', 'miniMenu'),
('sesytube.header.nonloggedin.options.2', 'mainMenu'),
('sesytube.header.nonloggedin.options.3', 'logo'),
('sesytube.heading.fontfamily', 'Georgia, serif'),
('sesytube.heading.fontsize', '17px'),
('sesytube.htmlblock1description', 'Totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo'),
('sesytube.htmlblock1title', 'Create a profile'),
('sesytube.htmlblock2description', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium'),
('sesytube.htmlblock2title', 'Post Content'),
('sesytube.htmlblock3description', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium'),
('sesytube.htmlblock3title', 'Set Your On Price'),
('sesytube.htmldescription', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit'),
('sesytube.htmlheading', 'HELP US MAKE VIDEO BETTER'),
('sesytube.landingpage.style', '1'),
('sesytube.left.columns.width', '240px'),
('sesytube.mainmenu.fontfamily', 'Georgia, serif'),
('sesytube.mainmenu.fontsize', '13px'),
('sesytube.member.infotooltip', '1'),
('sesytube.member.link', '1'),
('sesytube.memeber.caption', ''),
('sesytube.memeber.count', '10'),
('sesytube.memeber.heading', 'Popular Members'),
('sesytube.miniuserphotoround', '1'),
('sesytube.popup.day', '5'),
('sesytube.popup.enable', '1'),
('sesytube.popupfixed', '0'),
('sesytube.popupsign', '1'),
('sesytube.right.columns.width', '240px'),
('sesytube.staticcontent', 'Connect With the World!'),
('sesytube.submenu', '0'),
('sesytube.tab.fontfamily', 'Georgia, serif'),
('sesytube.tab.fontsize', '15px'),
('sesytube.user.photo.round', '1');");

$db->query('ALTER TABLE `engine4_sesbasic_menusicons` ADD `activeicon` INT(11) NOT NULL;');

//Main Menu Icon default installation work
// $select = Engine_Api::_()->getDbTable('menuitems', 'core')->select()
// 				->where('menu = ?', 'core_main')
// 				//->where('enabled = ?', 1)
// 				->order('order ASC');
// $paginator = Engine_Api::_()->getDbTable('menuitems', 'core')->fetchAll($select);
// foreach($paginator as $result) {
// 	$data = explode('_', $result->name);
// 	if($data[2] == 'sesblog') {
// 		$data[2] = 'blog';
// 	} else if($data[2] == 'sesalbum'){
// 		$data[2] = 'album';
// 	} else if($data[2] == 'sesevent') {
// 		$data[2] = 'event';
// 	} else if ($data[2] == 'sesvideo') {
// 		$data[2] = 'video';
// 	} else if ($data[2] == 'sesmember') {
// 		$data[2] = 'user';
// 	} else if ($data[2] == 'sesmusic') {
// 		$data[2] = 'music';
// 	}
// 	$PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesytube' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "menu-icons" . DIRECTORY_SEPARATOR;
// 	if (is_file($PathFile . $data[2] . '.png'))  {
// 		$pngFile = $PathFile . $data[2] . '.png';
// 		$photo_params = array(
// 				'parent_id' => $result->id,
// 				'parent_type' => "sesytube_slideshow_image",
// 		);
// 		$photoFile = Engine_Api::_()->storage()->create($pngFile, $photo_params);
// 		if (!empty($photoFile->file_id)) {
// 			//$db->update('engine4_core_menuitems', array('file_id' => $photoFile->file_id), array('id = ?' => $result->id));
// 		}
// 	}
// }
