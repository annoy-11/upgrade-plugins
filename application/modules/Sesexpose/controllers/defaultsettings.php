<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$default_constants = array(
    'theme_color' => '1',
    'custom_theme_color' => '5',
    'exp_theme_color' => '#f03e30',
	'exp_main_width' => '1200px',
	'exp_left_columns_width' => '240px',
	'exp_right_columns_width' => '240px',
	'exp_body_background_color' => '#fff',
	'exp_font_color' => '#424242',
	'exp_font_color_light' => '#424242',
	'exp_heading_color' => '#000',
	'exp_links_color' => '#292929',
	'exp_links_hover_color' => '#000',
	//'exp_content_heading_background_color' => '#f1f1f1',
	'exp_content_background_color' => '#fff',
	'exp_content_border_color' => '#E7E7E7',
	'exp_form_label_color' => '#000',
	'exp_input_background_color' => '#fff',
	'exp_input_font_color' => '#000',
	'exp_input_border_color' => '#E7E7E7',
	'exp_button_background_color' => '#fff',
	'exp_button_background_color_hover' => '#000',
	'exp_button_border_color' => '#000',
	'exp_button_font_color' => '#000',
	'exp_button_font_hover_color' => '#fff',
	'exp_comment_background_color' => '#f6f7f9',
	'exp_header_background_color' => '#fff',
	'exp_header_border_color' => '#919191',
	'exp_menu_logo_top_space' => '30px',
	//'exp_mainmenu_background_color' => '#515151',
	//'exp_mainmenu_background_color_hover' => '#363636',
	'exp_mainmenu_links_color' => '#1c1c1c',
	'exp_mainmenu_links_hover_color' => '#000',
	//'exp_mainmenu_border_color' => '#666',
	'exp_minimenu_links_color' => '#292929',
	'exp_minimenu_links_hover_color' => '#000',
	//'exp_minimenu_border_color' => '#aaa',
	//'exp_minimenu_icon' => 'minimenu-icons-white.png',
	'exp_header_searchbox_background_color' => '#fff',
	'exp_header_searchbox_text_color' => '#000',
	'exp_header_searchbox_border_color' => '#E7E7E7',
	'exp_header_searchbox_border_color' => '#E7E7E7',
	'exp_footer_background_color' => '#222',
	'exp_footer_border_color' => '#E7E7E7',
	'exp_footer_text_color' => '#FFFFFF',
	'exp_footer_links_color' => '#FFFFFF',
	'exp_footer_links_hover_color' => '#FFF',
	'exp_body_background_image' =>'public/admin/blank.png',
	'exp_header_type' => '2',


	'exp_body_fontfamily' => "'Open Sans', sans-serif",
	'exp_body_fontsize'  =>  '13px',
	'exp_heading_fontfamily' =>  "'Open Sans', sans-serif",
	'exp_heading_fontsize' =>  '17px',
	'exp_mainmenu_fontfamily' =>  "'Open Sans', sans-serif",
	'exp_mainmenu_fontsize' =>  '13px',
	'exp_tab_fontfamily' =>  "'Open Sans', sans-serif",
	'exp_tab_fontsize' =>  '15px',
);
Engine_Api::_()->sesexpose()->readWriteXML('', '', $default_constants);

//Header Default Work
$content_id = $this->widgetCheck(array('widget_name' => 'sesexpose.header', 'page_id' => '1'));
$minimenu = $this->widgetCheck(array('widget_name' => 'core.menu-mini', 'page_id' => '1'));
$menulogo = $this->widgetCheck(array('widget_name' => 'core.menu-logo', 'page_id' => '1'));
$mainmenu = $this->widgetCheck(array('widget_name' => 'core.menu-main', 'page_id' => '1'));
$searchmini = $this->widgetCheck(array('widget_name' => 'core.search-mini', 'page_id' => '1'));

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
  if($searchmini)
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$searchmini.'";');
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesexpose.header',
      'page_id' => 1,
      'parent_content_id' => $parent_content_id,
      'order' => 20,
  ));
}

//Footer Default Work
$footerContent_id = $this->widgetCheck(array('widget_name' => 'sesexpose.menu-footer', 'page_id' => '2'));
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
      'name' => 'sesexpose.menu-footer',
      'page_id' => 2,
      'parent_content_id' => $parent_content_id,
      'order' => 10,
  ));
}

$this->uploadBanner();

$db->query("INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
('sesexpose.googlefonts', '0'),
('sesexpose.header.fixed', '0'),
('sesexpose.limit', '8'),
('sesexpose.moretext', 'More'),
('sesexpose.popup.day', '1'),
('sesexpose.popup.enable', '1'),
('sesexpose.popupfixed', '0'),
('sesexpose.popupsign', '1'),
('sesexpose.responsive.layout', '1'),
('sesexpose.search.limit', '8'),
('sesexpose.searchleftoption', '1'),
('exp.body.background.color', '#181818'),
('exp.body.background.image', 'public/admin/blank.png'),
('exp.body.fontfamily', 'Arial, Helvetica, sans-serif'),
('exp.body.fontsize', '14px'),
('exp.button.background.color.hover', '#FF2851'),
('exp.button.backgroundcolor', '#282828'),
('exp.button.border.color', '#FF2851'),
('exp.button.font.color', '#FFFFFF'),
('exp.button.font.hover.color', '#FFFFFF'),
('exp.comment.background.color', '#282828'),
('exp.content.background.color', '#282828'),
('exp.content.bordercolor', '#313131'),
('exp.font.color.light', '#AAAAAA'),
('exp.fontcolor', '#AAAAAA'),
('exp.footer.background.color', '#222222'),
('exp.footer.border.color', '#FF2851'),
('exp.footer.links.color', '#767676'),
('exp.footer.links.hover.color', '#FFFFFF'),
('exp.footer.text.color', '#767676'),
('exp.form.label.color', '#FFFFFF'),
('exp.googlebody.fontfamily', '\"ABeeZee\"'),
('exp.googlebody.fontsize', '14px'),
('exp.googleheading.fontfamily', '\"ABeeZee\"'),
('exp.googleheading.fontsize', '16px'),
('exp.googlemainmenu.fontfamily', '\"ABeeZee\"'),
('exp.googlemainmenu.fontsize', '14px'),
('exp.googletab.fontfamily', '\"ABeeZee\"'),
('exp.googletab.fontsize', '14px'),
('exp.header.background.color', '#282828'),
('exp.header.border.color', '#313131'),
('exp.header.searchbox.background.color', '#FFFFFF'),
('exp.header.searchbox.border.color', '#313131'),
('exp.header.searchbox.text.color', '#636363'),
('exp.heading.color', '#FFFFFF'),
('exp.heading.fontfamily', 'Arial, Helvetica, sans-serif'),
('exp.heading.fontsize', '16px'),
('exp.input.background.color', '#181818'),
('exp.input.border.color', '#313131'),
('exp.input.font.color', '#FFFFFF'),
('exp.links.color', '#FFFFFF'),
('exp.links.hover.color', '#FF2851'),
('exp.mainmenu.fontfamily', 'Arial, Helvetica, sans-serif'),
('exp.mainmenu.fontsize', '14px'),
('exp.mainmenu.links.color', '#FFFFFF'),
('exp.mainmenu.links.hover.color', '#FF2851'),
('exp.minimenu.links.hover.color', '#FF2851'),
('exp.minimenu.linkscolor', '#FFFFFF'),
('exp.tab.fontfamily', 'Arial, Helvetica, sans-serif'),
('exp.tab.fontsize', '14px'),
('exp.theme.color', '#FF2851'),
('sesexp.enable.footer', '1'),
('sesexp.header.loggedin.options.0', 'search'),
('sesexp.header.loggedin.options.1', 'miniMenu'),
('sesexp.header.loggedin.options.2', 'mainMenu'),
('sesexp.header.loggedin.options.3', 'logo'),
('sesexp.header.loggedin.options.4', 'socialshare'),
('sesexp.header.nonloggedin.options.0', 'search'),
('sesexp.header.nonloggedin.options.1', 'miniMenu'),
('sesexp.header.nonloggedin.options.2', 'mainMenu'),
('sesexp.header.nonloggedin.options.3', 'logo'),
('sesexp.header.nonloggedin.options.4', 'socialshare');
");
