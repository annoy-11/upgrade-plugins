<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Header Default Work
$content_id = $this->widgetCheck(array('widget_name' => 'sestwitterclone.header', 'page_id' => '1'));
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
    'name' => 'sestwitterclone.header',
    'page_id' => 1,
    'parent_content_id' => $parent_content_id,
    'order' => 20,
  ));
}

//Footer Default Work
$footerContent_id = $this->widgetCheck(array('widget_name' => 'sestwitterclone.footer', 'page_id' => '2'));
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
      'name' => 'sestwitterclone.footer',
      'page_id' => 2,
      'parent_content_id' => $parent_content_id,
      'order' => 10,
  ));
}

$db->query('UPDATE `engine4_sesbasic_menuitems` SET `enabled` = "0" WHERE `engine4_sesbasic_menuitems`.`name` = "core_mini_profile";');
$db->query('UPDATE `engine4_sesbasic_menuitems` SET `enabled` = "0" WHERE `engine4_sesbasic_menuitems`.`name` = "core_mini_update";');

$default_constants = array(
  'sestwitterclone_header_background_color' => '#fff',
  'sestwitterclone_header_border_color' => '#b7b7b7',
  'sestwitterclone_header_search_background_color' => '#f5f8fa',
  'sestwitterclone_header_search_border_color' => '#e6ecf0',
  'sestwitterclone_header_search_button_background_color' => '#f5f8fa',
  'sestwitterclone_header_search_button_font_color' => '#66757f',
  'sestwitterclone_mainmenu_search_background_color' => '#1DA1F2',
  'sestwitterclone_mainmenu_background_color' => '#fff',
  'sestwitterclone_mainmenu_links_color' => '#66757f',
  'sestwitterclone_mainmenu_links_hover_color' => '#1DA1F2',
  'sestwitterclone_mainmenu_footer_font_color' => '#bdbdbd',
  'sestwitterclone_minimenu_links_color' => '#657786',
  'sestwitterclone_minimenu_link_active_color' => '#1DA1F2',
  'sestwitterclone_footer_background_color' => '#fff',
  'sestwitterclone_footer_font_color' => '#aab8c2',
  'sestwitterclone_footer_links_color' => '#aab8c2',
  'sestwitterclone_footer_border_color' => '#e6ecf0',
  'sestwitterclone_theme_color' => '#1DA1F2',
  'sestwitterclone_body_background_color' => '#e6ecf0',
  'sestwitterclone_font_color' => '#14171a',
  'sestwitterclone_font_color_light' => '#657786',
  'sestwitterclone_links_color' => '#14171a',
  'sestwitterclone_links_hover_color' => '#1DA1F2',
  'sestwitterclone_headline_color' => '#14171a',
  'sestwitterclone_border_color' => '#e6ecf0',
  'sestwitterclone_box_background_color' => '#fff',
  'sestwitterclone_form_label_color' => '#455B6B',
  'sestwitterclone_input_background_color' => '#fff',
  'sestwitterclone_input_font_color' => '#5f727f',
  'sestwitterclone_input_border_color' => '#d7d8da',
  'sestwitterclone_button_background_color' => '#1da1f2',
  'sestwitterclone_button_background_color_hover' => '#eaf5fd',
  'sestwitterclone_button_font_color' => '#FFFFFF',
  'sestwitterclone_button_border_color' => '#1da1f2',
  'sestwitterclone_comments_background_color' => '#e8f5fe',
  'custom_theme_color' => '1',

  'sestwitterclone_body_fontfamily' => '"Noto Sans"',
  'sestwitterclone_body_fontsize'  =>  '14px',
  'sestwitterclone_heading_fontfamily' =>  '"Noto Sans"',
  'sestwitterclone_heading_fontsize' =>  '18px',
  'sestwitterclone_mainmenu_fontfamily' =>  '"Noto Sans"',
  'sestwitterclone_mainmenu_fontsize' =>  '14px',
  'sestwitterclone_tab_fontfamily' =>  '"Noto Sans"',
  'sestwitterclone_tab_fontsize' =>  '14px',
);
Engine_Api::_()->sestwitterclone()->readWriteXML('', '', $default_constants);

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
    'name' => 'sestwitterclone.home-photo',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => 1,
  ));

  //Right Side Footer
  $right_id = $db->select()
    ->from('engine4_core_content', 'content_id')
    ->where('page_id = ?', $page_id)
    ->where('type = ?', 'container')
    ->where('name = ?', 'right')
    ->limit(1)
    ->query()
    ->fetchColumn();

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sestwitterclone.sidebar-footer',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => 999,
  ));
}

$db->query('INSERT IGNORE INTO `engine4_sestwitterclone_customthemes` (`name`, `value`, `column_key`, `theme_id`, `default`) VALUES
("Theme - 1", "1", "theme_color", 1, 0),
("Theme - 1", "1", "custom_theme_color", 1, 0),
("Theme - 1", "#fff", "sestwitterclone_header_background_color", 1, 0),
("Theme - 1", "#b7b7b7", "sestwitterclone_header_border_color", 1, 0),
("Theme - 1", "#f5f8fa", "sestwitterclone_header_search_background_color", 1, 0),
("Theme - 1", "#e6ecf0", "sestwitterclone_header_search_border_color", 1, 0),
("Theme - 1", "#f5f8fa", "sestwitterclone_header_search_button_background_color", 1, 0),
("Theme - 1", "#66757f", "sestwitterclone_header_search_button_font_color", 1, 0),
("Theme - 1", "#1DA1F2", "sestwitterclone_mainmenu_search_background_color", 1, 0),
("Theme - 1", "#fff", "sestwitterclone_mainmenu_background_color", 1, 0),
("Theme - 1", "#66757f", "sestwitterclone_mainmenu_links_color", 1, 0),
("Theme - 1", "#1DA1F2", "sestwitterclone_mainmenu_links_hover_color", 1, 0),
("Theme - 1", "#bdbdbd", "sestwitterclone_mainmenu_footer_font_color", 1, 0),
("Theme - 1", "#657786", "sestwitterclone_minimenu_links_color", 1, 0),
("Theme - 1", "#1DA1F2", "sestwitterclone_minimenu_link_active_color", 1, 0),
("Theme - 1", "#fff", "sestwitterclone_footer_background_color", 1, 0),
("Theme - 1", "#aab8c2", "sestwitterclone_footer_font_color", 1, 0),
("Theme - 1", "#aab8c2", "sestwitterclone_footer_links_color", 1, 0),
("Theme - 1", "#e6ecf0", "sestwitterclone_footer_border_color", 1, 0),
("Theme - 1", "#1DA1F2", "sestwitterclone_theme_color", 1, 0),
("Theme - 1", "#e6ecf0", "sestwitterclone_body_background_color", 1, 0),
("Theme - 1", "#14171a", "sestwitterclone_font_color", 1, 0),
("Theme - 1", "#657786", "sestwitterclone_font_color_light", 1, 0),
("Theme - 1", "#14171a", "sestwitterclone_links_color", 1, 0),
("Theme - 1", "#1DA1F2", "sestwitterclone_links_hover_color", 1, 0),
("Theme - 1", "#14171a", "sestwitterclone_headline_color", 1, 0),
("Theme - 1", "#e6ecf0", "sestwitterclone_border_color", 1, 0),
("Theme - 1", "#fff", "sestwitterclone_box_background_color", 1, 0),
("Theme - 1", "#455B6B", "sestwitterclone_form_label_color", 1, 0),
("Theme - 1", "#fff", "sestwitterclone_input_background_color", 1, 0),
("Theme - 1", "#5f727f", "sestwitterclone_input_font_color", 1, 0),
("Theme - 1", "#d7d8da", "sestwitterclone_input_border_color", 1, 0),
("Theme - 1", "#1da1f2", "sestwitterclone_button_background_color", 1, 0),
("Theme - 1", "#eaf5fd", "sestwitterclone_button_background_color_hover", 1, 0),
("Theme - 1", "#FFFFFF", "sestwitterclone_button_font_color", 1, 0),
("Theme - 1", "#1da1f2", "sestwitterclone_button_border_color", 1, 0),
("Theme - 1", "#e8f5fe", "sestwitterclone_comments_background_color", 1, 0),
("Theme - 2", "2", "theme_color", 2, 0),
("Theme - 2", "1", "custom_theme_color", 2, 0),
("Theme - 2", "#22313e", "sestwitterclone_header_background_color", 2, 0),
("Theme - 2", "#22313e", "sestwitterclone_header_border_color", 2, 0),
("Theme - 2", "#2C4058", "sestwitterclone_header_search_background_color", 2, 0),
("Theme - 2", "#2C4058", "sestwitterclone_header_search_border_color", 2, 0),
("Theme - 2", "#2C4058", "sestwitterclone_header_search_button_background_color", 2, 0),
("Theme - 2", "#fff", "sestwitterclone_header_search_button_font_color", 2, 0),
("Theme - 2", "#141414", "sestwitterclone_mainmenu_search_background_color", 2, 0),
("Theme - 2", "#1DA1F2", "sestwitterclone_mainmenu_background_color", 2, 0),
("Theme - 2", "#fff", "sestwitterclone_mainmenu_links_color", 2, 0),
("Theme - 2", "#000", "sestwitterclone_mainmenu_links_hover_color", 2, 0),
("Theme - 2", "#fff", "sestwitterclone_mainmenu_footer_font_color", 2, 0),
("Theme - 2", "#fff", "sestwitterclone_minimenu_links_color", 2, 0),
("Theme - 2", "#1DA1F2", "sestwitterclone_minimenu_link_active_color", 2, 0),
("Theme - 2", "#2c4058", "sestwitterclone_footer_background_color", 2, 0),
("Theme - 2", "#acacac", "sestwitterclone_footer_font_color", 2, 0),
("Theme - 2", "#acacac", "sestwitterclone_footer_links_color", 2, 0),
("Theme - 2", "#2c4058", "sestwitterclone_footer_border_color", 2, 0),
("Theme - 2", "#1DA1F2", "sestwitterclone_theme_color", 2, 0),
("Theme - 2", "#2c4058", "sestwitterclone_body_background_color", 2, 0),
("Theme - 2", "#fff", "sestwitterclone_font_color", 2, 0),
("Theme - 2", "#acacac", "sestwitterclone_font_color_light", 2, 0),
("Theme - 2", "#fff", "sestwitterclone_links_color", 2, 0),
("Theme - 2", "#1DA1F2", "sestwitterclone_links_hover_color", 2, 0),
("Theme - 2", "#fff", "sestwitterclone_headline_color", 2, 0),
("Theme - 2", "#2c4058", "sestwitterclone_border_color", 2, 0),
("Theme - 2", "#1b2936", "sestwitterclone_box_background_color", 2, 0),
("Theme - 2", "#fff", "sestwitterclone_form_label_color", 2, 0),
("Theme - 2", "#1B2936", "sestwitterclone_input_background_color", 2, 0),
("Theme - 2", "#ACACAC", "sestwitterclone_input_font_color", 2, 0),
("Theme - 2", "#2C4058", "sestwitterclone_input_border_color", 2, 0),
("Theme - 2", "#1da1f2", "sestwitterclone_button_background_color", 2, 0),
("Theme - 2", "#eaf5fd", "sestwitterclone_button_background_color_hover", 2, 0),
("Theme - 2", "#1b2936", "sestwitterclone_button_font_color", 2, 0),
("Theme - 2", "#1da1f2", "sestwitterclone_button_border_color", 2, 0),
("Theme - 2", "#2c4058", "sestwitterclone_comments_background_color", 2, 0);');


$db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
("sestwitterclone.body.fontfamily", "Georgia, serif"),
("sestwitterclone.body.fontsize", "14px"),
("sestwitterclone.footersidepanel", "1"),
("sestwitterclone.googlebody.fontfamily", \'\"Open Sans\"\'),
("sestwitterclone.googlebody.fontsize", "14px"),
("sestwitterclone.googlefonts", "1"),
("sestwitterclone.googleheading.fontfamily", \'\"Open Sans\"\'),
("sestwitterclone.googleheading.fontsize", "18px"),
("sestwitterclone.googlemainmenu.fontfamily", \'\"Open Sans\"\'),
("sestwitterclone.googlemainmenu.fontsize", "14px"),
("sestwitterclone.googletab.fontfamily", \'\"Open Sans\"\'),
("sestwitterclone.googletab.fontsize", "14px"),
("sestwitterclone.header.fixed.layout", "1"),
("sestwitterclone.headerloggedinoptions", \'a:4:{i:0;s:6:\"search\";i:1;s:8:\"miniMenu\";i:2;s:8:\"mainMenu\";i:3;s:4:\"logo\";}\'),
("sestwitterclone.headernonloggedinoptions", \'a:3:{i:0;s:8:\"miniMenu\";i:1;s:8:\"mainMenu\";i:2;s:4:\"logo\";}\'),
("sestwitterclone.heading.fontfamily", "Georgia, serif"),
("sestwitterclone.heading.fontsize", "18px"),
("sestwitterclone.mainmenu.fontfamily", "Georgia, serif"),
("sestwitterclone.mainmenu.fontsize", "14px"),
("sestwitterclone.popup.day", "1"),
("sestwitterclone.popup.enable", "1"),
("sestwitterclone.popupfixed", "0"),
("sestwitterclone.popupsign", "1"),
("sestwitterclone.sidepaneldesign", "1"),
("sestwitterclone.tab.fontfamily", "Georgia, serif"),
("sestwitterclone.tab.fontsize", "14px");');
