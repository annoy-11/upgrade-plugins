<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: defaultsettings.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Header Default Work
$content_id = $this->widgetCheck(array('widget_name' => 'einstaclone.header', 'page_id' => '1'));
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
    'name' => 'einstaclone.header',
    'page_id' => 1,
    'parent_content_id' => $parent_content_id,
    'order' => 20,
  ));
}

//Footer Default Work
$footerContent_id = $this->widgetCheck(array('widget_name' => 'einstaclone.footer', 'page_id' => '2'));
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
      'name' => 'einstaclone.footer',
      'page_id' => 2,
      'parent_content_id' => $parent_content_id,
      'order' => 10,
  ));
}

$default_constants = array(
  'einstaclone_header_background_color' => '#fff',
  'einstaclone_header_border_color' => '#e6e6e6',
  'einstaclone_header_search_background_color' => '#fbfbfb',
  'einstaclone_header_search_border_color' => '#dcdcdc',
  'einstaclone_header_search_button_background_color' => '#fbfbfb',
  'einstaclone_header_search_button_font_color' => '#999',
  'einstaclone_mainmenu_search_background_color' => '#1DA1F2',
  'einstaclone_mainmenu_background_color' => '#fff',
  'einstaclone_mainmenu_links_color' => '#66757f',
  'einstaclone_mainmenu_links_hover_color' => '#1B9BE9',
  'einstaclone_mainmenu_footer_font_color' => '#8e8e8e',
  'einstaclone_minimenu_links_color' => '#929292',
  'einstaclone_minimenu_link_active_color' => '#1B9BE9',
  'einstaclone_footer_background_color' => '#fff',
  'einstaclone_footer_font_color' => '#999999',
  'einstaclone_footer_links_color' => '#01376d',
  'einstaclone_footer_border_color' => '#fbfbfb',
  'einstaclone_theme_color' => '#1B9BE9',
  'einstaclone_body_background_color' => '#fafafa',
  'einstaclone_font_color' => '#14171a',
  'einstaclone_font_color_light' => '#999999',
  'einstaclone_links_color' => '#14171a',
  'einstaclone_links_hover_color' => '#1B9BE9',
  'einstaclone_headline_color' => '#14171a',
  'einstaclone_border_color' => '#e6e6e6',
  'einstaclone_box_background_color' => '#fff',
  'einstaclone_form_label_color' => '#455B6B',
  'einstaclone_input_background_color' => '#fafafa',
  'einstaclone_input_font_color' => '#5f727f',
  'einstaclone_input_border_color' => '#eeeeee',
  'einstaclone_button_background_color' => '#1B9BE9',
  'einstaclone_button_background_color_hover' => '#32a5eb',
  'einstaclone_button_font_color' => '#FFFFFF',
  'einstaclone_button_border_color' => '#1B9BE9',
  'einstaclone_comments_background_color' => '#FFFFFF',
  'custom_theme_color' => '1',
  'theme_color' => '1',
  'einstaclone_body_fontfamily' => '"Open Sans"',
  'einstaclone_body_fontsize'  =>  '13px',
  'einstaclone_heading_fontfamily' =>  '"Open Sans"',
  'einstaclone_heading_fontsize' =>  '16px',
  'einstaclone_mainmenu_fontfamily' =>  '"Open Sans"',
  'einstaclone_mainmenu_fontsize' =>  '13px',
  'einstaclone_tab_fontfamily' =>  '"Open Sans"',
  'einstaclone_tab_fontsize' =>  '13px',
);
Engine_Api::_()->einstaclone()->readWriteXML('', '', $default_constants);

$db->query('INSERT IGNORE INTO `engine4_einstaclone_customthemes` (`name`, `value`, `column_key`, `theme_id`, `default`) VALUES
("Theme - 1", "1", "theme_color", 1, 0),
("Theme - 1", "1", "custom_theme_color", 1, 0),
("Theme - 1", "#fff", "einstaclone_header_background_color", 1, 0),
("Theme - 1", "#e6e6e6", "einstaclone_header_border_color", 1, 0),
("Theme - 1", "#fbfbfb", "einstaclone_header_search_background_color", 1, 0),
("Theme - 1", "#e6e6e6", "einstaclone_header_search_border_color", 1, 0),
("Theme - 1", "#fbfbfb", "einstaclone_header_search_button_background_color", 1, 0),
("Theme - 1", "#999999", "einstaclone_header_search_button_font_color", 1, 0),
("Theme - 1", "#1DA1F2", "einstaclone_mainmenu_search_background_color", 1, 0),
("Theme - 1", "#fff", "einstaclone_mainmenu_background_color", 1, 0),
("Theme - 1", "#66757f", "einstaclone_mainmenu_links_color", 1, 0),
("Theme - 1", "#1B9BE9", "einstaclone_mainmenu_links_hover_color", 1, 0),
("Theme - 1", "#8e8e8e", "einstaclone_mainmenu_footer_font_color", 1, 0),
("Theme - 1", "#929292", "einstaclone_minimenu_links_color", 1, 0),
("Theme - 1", "#1B9BE9", "einstaclone_minimenu_link_active_color", 1, 0),
("Theme - 1", "#fff", "einstaclone_footer_background_color", 1, 0),
("Theme - 1", "#999999", "einstaclone_footer_font_color", 1, 0),
("Theme - 1", "#01376d", "einstaclone_footer_links_color", 1, 0),
("Theme - 1", "#fbfbfb", "einstaclone_footer_border_color", 1, 0),
("Theme - 1", "#1B9BE9", "einstaclone_theme_color", 1, 0),
("Theme - 1", "#fafafa", "einstaclone_body_background_color", 1, 0),
("Theme - 1", "#14171a", "einstaclone_font_color", 1, 0),
("Theme - 1", "#999999", "einstaclone_font_color_light", 1, 0),
("Theme - 1", "#14171a", "einstaclone_links_color", 1, 0),
("Theme - 1", "#1B9BE9", "einstaclone_links_hover_color", 1, 0),
("Theme - 1", "#14171a", "einstaclone_headline_color", 1, 0),
("Theme - 1", "#e6e6e6", "einstaclone_border_color", 1, 0),
("Theme - 1", "#fff", "einstaclone_box_background_color", 1, 0),
("Theme - 1", "#455B6B", "einstaclone_form_label_color", 1, 0),
("Theme - 1", "#fafafa", "einstaclone_input_background_color", 1, 0),
("Theme - 1", "#5f727f", "einstaclone_input_font_color", 1, 0),
("Theme - 1", "#eeeeee", "einstaclone_input_border_color", 1, 0),
("Theme - 1", "#1B9BE9", "einstaclone_button_background_color", 1, 0),
("Theme - 1", "#32a5eb", "einstaclone_button_background_color_hover", 1, 0),
("Theme - 1", "#FFFFFF", "einstaclone_button_font_color", 1, 0),
("Theme - 1", "#1B9BE9", "einstaclone_button_border_color", 1, 0),
("Theme - 1", "#FFFFFF", "einstaclone_comments_background_color", 1, 0),
("Theme - 2", "2", "theme_color", 2, 0),
("Theme - 2", "1", "custom_theme_color", 2, 0),
("Theme - 2", "#22313e", "einstaclone_header_background_color", 2, 0),
("Theme - 2", "#22313e", "einstaclone_header_border_color", 2, 0),
("Theme - 2", "#2C4058", "einstaclone_header_search_background_color", 2, 0),
("Theme - 2", "#2C4058", "einstaclone_header_search_border_color", 2, 0),
("Theme - 2", "#2C4058", "einstaclone_header_search_button_background_color", 2, 0),
("Theme - 2", "#fff", "einstaclone_header_search_button_font_color", 2, 0),
("Theme - 2", "#141414", "einstaclone_mainmenu_search_background_color", 2, 0),
("Theme - 2", "#1B9BE9", "einstaclone_mainmenu_background_color", 2, 0),
("Theme - 2", "#fff", "einstaclone_mainmenu_links_color", 2, 0),
("Theme - 2", "#000", "einstaclone_mainmenu_links_hover_color", 2, 0),
("Theme - 2", "#fff", "einstaclone_mainmenu_footer_font_color", 2, 0),
("Theme - 2", "#fff", "einstaclone_minimenu_links_color", 2, 0),
("Theme - 2", "#1B9BE9", "einstaclone_minimenu_link_active_color", 2, 0),
("Theme - 2", "#1b2936", "einstaclone_footer_background_color", 2, 0),
("Theme - 2", "#acacac", "einstaclone_footer_font_color", 2, 0),
("Theme - 2", "#acacac", "einstaclone_footer_links_color", 2, 0),
("Theme - 2", "#1b2936", "einstaclone_footer_border_color", 2, 0),
("Theme - 2", "#1B9BE9", "einstaclone_theme_color", 2, 0),
("Theme - 2", "#2c4058", "einstaclone_body_background_color", 2, 0),
("Theme - 2", "#fff", "einstaclone_font_color", 2, 0),
("Theme - 2", "#acacac", "einstaclone_font_color_light", 2, 0),
("Theme - 2", "#fff", "einstaclone_links_color", 2, 0),
("Theme - 2", "#1B9BE9", "einstaclone_links_hover_color", 2, 0),
("Theme - 2", "#fff", "einstaclone_headline_color", 2, 0),
("Theme - 2", "#2c4058", "einstaclone_border_color", 2, 0),
("Theme - 2", "#1b2936", "einstaclone_box_background_color", 2, 0),
("Theme - 2", "#fff", "einstaclone_form_label_color", 2, 0),
("Theme - 2", "#1B2936", "einstaclone_input_background_color", 2, 0),
("Theme - 2", "#ACACAC", "einstaclone_input_font_color", 2, 0),
("Theme - 2", "#2C4058", "einstaclone_input_border_color", 2, 0),
("Theme - 2", "#1B9BE9", "einstaclone_button_background_color", 2, 0),
("Theme - 2", "#eaf5fd", "einstaclone_button_background_color_hover", 2, 0),
("Theme - 2", "#1b2936", "einstaclone_button_font_color", 2, 0),
("Theme - 2", "#1B9BE9", "einstaclone_button_border_color", 2, 0),
("Theme - 2", "#2c4058", "einstaclone_comments_background_color", 2, 0);');


$db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
("einstaclone.body.fontfamily", "Georgia, serif"),
("einstaclone.body.fontsize", "14px"),
("einstaclone.footersidepanel", "1"),
("einstaclone.googlebody.fontfamily", \'\"Open Sans\"\'),
("einstaclone.googlebody.fontsize", "14px"),
("einstaclone.googlefonts", "1"),
("einstaclone.googleheading.fontfamily", \'\"Open Sans\"\'),
("einstaclone.googleheading.fontsize", "18px"),
("einstaclone.googlemainmenu.fontfamily", \'\"Open Sans\"\'),
("einstaclone.googlemainmenu.fontsize", "14px"),
("einstaclone.googletab.fontfamily", \'\"Open Sans\"\'),
("einstaclone.googletab.fontsize", "14px"),
("einstaclone.header.fixed.layout", "1"),
("einstaclone.headerloggedinoptions", \'a:4:{i:0;s:6:\"search\";i:1;s:8:\"miniMenu\";i:2;s:8:\"mainMenu\";i:3;s:4:\"logo\";}\'),
("einstaclone.headernonloggedinoptions", \'a:3:{i:0;s:8:\"miniMenu\";i:1;s:8:\"mainMenu\";i:2;s:4:\"logo\";}\'),
("einstaclone.heading.fontfamily", "Georgia, serif"),
("einstaclone.heading.fontsize", "18px"),
("einstaclone.mainmenu.fontfamily", "Georgia, serif"),
("einstaclone.mainmenu.fontsize", "14px"),
("einstaclone.popup.day", "1"),
("einstaclone.popup.enable", "1"),
("einstaclone.popupfixed", "0"),
("einstaclone.popupsign", "1"),
("einstaclone.sidepaneldesign", "1"),
("einstaclone.tab.fontfamily", "Georgia, serif"),
("einstaclone.tab.fontsize", "14px");');


//Explore Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'einstaclone_index_explore')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$pageId) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'einstaclone_index_explore',
      'displayname' => 'Explore Page',
      'title' => 'Explore Page',
      'description' => 'This page list members.',
      'custom' => 0,
  ));
  $pageId = $db->lastInsertId();
  // Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $pageId,
      'order' => 1,
  ));
  $topId = $db->lastInsertId();
  // Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $pageId,
      'order' => 2,
  ));
  $mainId = $db->lastInsertId();
  
  // Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 2,
  ));
  $mainMiddleId = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'einstaclone.explore-people',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => $widgetOrder++,
    'params' => '{"limit":"50","title":"","nomobile":"0","name":"einstaclone.explore-people"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'einstaclone.explore-posts',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => $widgetOrder++,
    'params' => '{"paginationType":"0","limit":"12","title":"","nomobile":"0","name":"einstaclone.explore-posts"}',
  ));
}
