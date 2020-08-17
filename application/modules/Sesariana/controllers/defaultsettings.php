<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$default_constants = array(
	'sesariana_responsive_layout'=> '1',
	'sesariana_body_background_image' => 'public/admin/blank.png',
	'sesariana_user_photo_round' => '1',
	'sesariana_feed_style' => '2',
	'sesariana_left_columns_width' => '240px',
	'sesariana_right_columns_width' => '240px',
	'sesariana_header_design' => '2',
	'sesariana_sidepanel_effect' => '2',
  'sesariana_footer_background_image' => 'public/admin/blank.png',
  'sesariana_header_background_color' => '#E8288D',
  'sesariana_menu_logo_font_color' => '#FFFFFF',
	'sesariana_mainmenu_background_color' => '#FFFFFF',
	'sesariana_mainmenu_links_color' => '#36383D',
	'sesariana_mainmenu_links_hover_color' => '#4682B4',
	'sesariana_minimenu_links_color' => '#FFFFFF',
	'sesariana_minimenu_links_hover_color' => '#4682B4',
  'sesariana_minimenu_icon_background_color' => '#F07AB1',
	'sesariana_minimenu_icon_background_active_color' => '#FFFFFF',
	'sesariana_minimenu_icon_color' => '#FFFFFF',
	'sesariana_minimenu_icon_active_color' => '#ED54A4',
	'sesariana_header_searchbox_background_color' => '#C7C7C7',
	'sesariana_header_searchbox_text_color' => '#FFFFFF',
  'sesariana_toppanel_userinfo_background_color' => '#ED54A4',
  'sesariana_toppanel_userinfo_font_color' => '#FFFFFF',
	'sesariana_login_popup_header_background_color' => '#ED54A4',
	'sesariana_login_popup_header_font_color' => '#FFFFFF',
	'sesariana_footer_background_color' => '#FFFFFF',
	'sesariana_footer_links_color' => '#A4A4A4',
	'sesariana_footer_links_hover_color' => '#4682B4',
	'sesariana_footer_border_color' => '#ED54A4',
  'sesariana_theme_color' => '#ED54A4',
	'sesariana_body_background_color' => '#F5F5F5',
	'sesariana_font_color' => '#243238',
	'sesariana_font_color_light' => '#707070',
	'sesariana_heading_color' => '#243238',
	'sesariana_links_color' => '#243238',
	'sesariana_links_hover_color' => '#4682B4',	
	'sesariana_content_header_background_color' => '#FFFFFF',
	'sesariana_content_header_font_color' => '#243238',
	'sesariana_content_background_color' => '#FFFFFF',
	'sesariana_content_border_color' => '#EBECEE',
	'sesariana_form_label_color' => '#243238',
	'sesariana_input_background_color' => '#FFFFFF',
	'sesariana_input_font_color' => '#6D6D6D',
	'sesariana_input_border_color' => '#CACACA',
	'sesariana_button_background_color' => '#4682B4',
	'sesariana_button_background_color_hover' => '#ED54A4',
	'sesariana_button_font_color' => '#FFFFFF',
	'sesariana_button_font_hover_color' => '#FFFFFF',
	'sesariana_comment_background_color' => '#FDFDFD',
  'custom_theme_color' => '11',
  
  'sesariana_body_fontfamily' => 'Arial, Helvetica, sans-serif',
	'sesariana_body_fontsize'  =>  '13px',
	'sesariana_heading_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sesariana_heading_fontsize' =>  '17px',
	'sesariana_mainmenu_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sesariana_mainmenu_fontsize' =>  '13px',
	'sesariana_tab_fontfamily' =>  'Arial, Helvetica, sans-serif',
	'sesariana_tab_fontsize' =>  '15px',
);
// 	'sesariana_mainmenu_background_color_hover' => '#363636',
// 	'sesariana_main_width' => '1200px',
// 	'sesariana_mainmenu_border_color' => '#666',
// 	'sesariana_minimenu_border_color' => '#aaa',
// 	'sesariana_minimenu_icon' => 'minimenu-icons-white.png',
// 	'sesariana_popup_design' => '2',
Engine_Api::_()->sesariana()->readWriteXML('', '', $default_constants);

//Quick links footer
$menuitem_id = $db->select()
  ->from('engine4_core_menuitems', 'id')
  ->limit(1)
  ->order('id DESC')
  ->query()
  ->fetchColumn();
  
$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
("custom_'.$menuitem_id++.'", "core", "Albums", "", \'{"uri":"albums","icon":""}\', "sesariana_quicklinks_footer", "", 1, 1, 1),
("custom_'.$menuitem_id++.'", "core", "Blogs", "", \'{"uri":"blogs","icon":""}\', "sesariana_quicklinks_footer", "", 1, 1, 2),
("custom_'.$menuitem_id++.'", "core", "Events", "", \'{"uri":"events"}\', "sesariana_quicklinks_footer", "", 1, 1, 3),
("custom_'.$menuitem_id++.'", "core", "Videos", "", \'{"uri":"videos","icon":"","target":"","enabled":"1"}\', "sesariana_quicklinks_footer", "", 1, 1, 4),
("custom_'.$menuitem_id++.'", "core", "Music", "", \'{"uri":"music/album/home","icon":"","target":"","enabled":"1"}\', "sesariana_quicklinks_footer", "", 1, 1, 5);');

//Header Default Work
$content_id = $this->widgetCheck(array('widget_name' => 'sesariana.header', 'page_id' => '1'));

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
      'name' => 'sesariana.header',
      'page_id' => 1,
      'parent_content_id' => $parent_content_id,
      'order' => 20,
  ));
}

//Footer Default Work
$footerContent_id = $this->widgetCheck(array('widget_name' => 'sesariana.menu-footer', 'page_id' => '2'));
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
      'name' => 'sesariana.menu-footer',
      'page_id' => 2,
      'parent_content_id' => $parent_content_id,
      'order' => 10,
  ));
}

$db->query("INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
('sesariana.staticcontent', 'Connect With the World!'),
('sesariana.banner.bgimage', 'public/admin/theme-banner.jpg'),
('sesariana.banner.bannerupimage', 'public/admin/banner-img.png'),
('sesariana.banner.content', 'Share your Photos and let them talk for you.,Music & Videos in the Community.,Create your events and sell tickets online.,Write new Blogs and share your thoughts.'),
('sesariana.feature.heading', 'What is Inside Our Community?'),
('sesariana.feature.caption', 'Create your own events, book tickets online, share photos, videos, music, etc. Meet new people, join new groups, write your own blogs and more!'),
('sesariana.feature.bgimage', 'public/admin/online-community.jpg'),
('sesariana.feature.content.0.caption', 'Explore Popular Blogs'),
('sesariana.feature.content.0.description', 'Write new blogs and share your ideas and stories with the World. Meet our bloggers here.'),
('sesariana.feature.content.0.iconimage', 'public/admin/blog-icon.png'),
('sesariana.feature.content.0.url', 'blogs'),
('sesariana.feature.content.1.caption', 'Events & Online Booking'),
('sesariana.feature.content.1.description', 'Create, promote, manage, and host your meetings, conferences & special events, etc.'),
('sesariana.feature.content.1.iconimage', 'public/admin/event-icon.png'),
('sesariana.feature.content.1.url', 'events'),
('sesariana.feature.content.2.caption', 'Music Albums & Songs'),
('sesariana.feature.content.2.description', 'What do you want to listen? Choose from awesome collection in our Community.'),
('sesariana.feature.content.2.iconimage', 'public/admin/music-icon.png'),
('sesariana.feature.content.2.url', 'music/album/home'),
('sesariana.feature.content.3.caption', 'Discover New Groups'),
('sesariana.feature.content.3.description', 'Join groups based on your interest and get connetced with the world.'),
('sesariana.feature.content.3.iconimage', 'public/admin/group-icon.png'),
('sesariana.feature.content.3.url', 'groups'),
('sesariana.feature.content.4.caption', 'Videos, Channels & Playlists'),
('sesariana.feature.content.4.description', 'We make Videos worth watching. Share videos with friends, family, & with the whole world.'),
('sesariana.feature.content.4.iconimage', 'public/admin/video-icon.png'),
('sesariana.feature.content.4.url', 'videos'),
('sesariana.feature.content.5.caption', 'Photos & Albums'),
('sesariana.feature.content.5.description', 'Share your Stories with Photos! Let your photos do the talking for you.'),
('sesariana.feature.content.5.iconimage', 'public/admin/photo-icon.png'),
('sesariana.feature.content.5.url', 'albums'),
('sesariana.memeber.heading', 'Meet Our Members!'),
('sesariana.memeber.caption', 'Meet our members and grow your network.'),
('sesariana.memeber.height', '100'),
('sesariana.memeber.width', '100'),
('sesariana.member.link', '1'),

('sesariana.body.background.image', 'public/admin/blank.png'),
('sesariana.facebookurl', 'http://www.facebook.com/'),
('sesariana.feed.style', '1'),
('sesariana.googleplusurl', 'http://plus.google.com/'),
('sesariana.header.design', '2'),
('sesariana.header.loggedin.options.0', 'search'),
('sesariana.header.loggedin.options.1', 'miniMenu'),
('sesariana.header.loggedin.options.2', 'mainMenu'),
('sesariana.header.loggedin.options.3', 'logo'),
('sesariana.header.nonloggedin.options.0', 'search'),
('sesariana.header.nonloggedin.options.1', 'miniMenu'),
('sesariana.header.nonloggedin.options.2', 'mainMenu'),
('sesariana.header.nonloggedin.options.3', 'logo'),
('sesariana.helpenable', '1'),
('sesariana.limit', '6'),
('sesariana.landingpage.style', '1'),
('sesariana.menu.img', 'public/admin/blank.png'),
('sesariana.menu.logo.top.space', '0px'),
('sesariana.menuinformation.img', 'public/admin/info-bg2.png'),
('sesariana.miniuserphotoround', '1'),
('sesariana.moretext', 'More'),
('sesariana.pinteresturl', 'https://www.pinterest.com/'),
('sesariana.popup.day', '5'),
('sesariana.popup.enable', '1'),
('sesariana.popupfixed', '0'),
('sesariana.popupsign', '1'),
('sesariana.quicklinksenable', '1'),
('sesariana.responsive.layout', '1'),
('sesariana.right.columns.width', '240px'),
('sesariana.sidepanel.effect', '2'),
('sesariana.sidepanel.showhide', '0'),
('sesariana.socialenable', '1'),
('sesariana.submenu', '1'),
('sesariana.twitterurl', 'https://www.twitter.com/'),
('sesariana.loginsignupbgimage', 'public/admin/popup-bg.png'),
('sesariana.user.photo.round', '1');
");

$db->query('INSERT IGNORE INTO `engine4_sesariana_banners` (`banner_name`, `creation_date`, `modified_date`, `enabled`) VALUES ("Member Home Page", "2016-11-21 15:45:57", "2016-11-21 15:45:57", 1);');

$db->query('INSERT IGNORE INTO `engine4_sesariana_slides` (`slide_id`, `banner_id`, `title`, `title_button_color`, `description`, `description_button_color`, `file_type`, `file_id`, `status`, `extra_button_linkopen`, `extra_button`, `extra_button_text`, `extra_button_link`, `order`, `creation_date`, `modified_date`, `enabled`) VALUES
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
  $db->query("UPDATE  `engine4_core_content` SET  `name` =  'sesariana.login' WHERE  `engine4_core_content`.`name` ='core.content' AND `engine4_core_content`.`page_id` ='".$page_login_id."' LIMIT 1");
}

//Member Home Page widget
$select = new Zend_Db_Select($db);
$page_id = $select
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'user_index_home')
        ->query()
        ->fetchColumn();
if ($page_id) {
  $top_contanier_id = $content_table->select()
          ->from($content_table_name, 'content_id')
          ->where('page_id =?', $page_id)
          ->where('name =?', 'top')
          ->query()
          ->fetchColumn();
  //Check top container id
  if (empty($top_contanier_id)) {
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'parent_content_id' => NULL,
        'name' => 'top',
        'page_id' => $page_id,
        'order' => 1,
    ));
    //get Last insert Id of top container
    $content_id = $db->lastInsertId('engine4_core_content');
    $middle_contanier_id = $content_table->select()
            ->from($content_table_name, 'content_id')
            ->where('page_id =?', $page_id)
            ->where('parent_content_id =?', $content_id)
            ->where('name =?', 'middle')
            ->query()
            ->fetchColumn();
    if (empty($middle_contanier_id)) {
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'middle',
          'page_id' => $page_id,
          'parent_content_id' => $content_id,
          'order' => 2,
      ));
      $content_id = $db->lastInsertId('engine4_core_content');
      if (!empty($content_id)) {
        $usercoverphotowidgetcontent_id = $content_table->select()
                ->from($content_table_name, array('content_id'))
                ->where('page_id =?', $page_id)
                ->where('name =?', 'sesariana.banner-slideshow')
                ->query()
                ->fetchColumn();
        if (empty($usercoverphotowidgetcontent_id)) {
          $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesariana.banner-slideshow',
            'page_id' => $page_id,
            'parent_content_id' => $content_id,
            'order' => 2,
            'params' => '{"banner_id":"1","full_width":"1","height":"250","title":"","nomobile":"0","name":"sesariana.banner-slideshow"}',
          ));
        }
      }
    }
  }
}
$db->query('ALTER TABLE `engine4_sesariana_customthemes` ADD `default` TINYINT(1) NOT NULL DEFAULT "1";');
//Default theme color for custom theme
$db->query('INSERT IGNORE INTO `engine4_sesariana_customthemes` (`customtheme_id`, `name`, `description`, `default`) VALUES
(1, "Theme - 1", \'a:44:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:2:"18";s:13:"custom_themes";N;s:33:"sesariana_header_background_color";s:7:"#FFFFFF";s:30:"sesariana_menu_logo_font_color";s:7:"#005C99";s:35:"sesariana_mainmenu_background_color";s:7:"#FFFFFF";s:30:"sesariana_mainmenu_links_color";s:7:"#243238";s:36:"sesariana_mainmenu_links_hover_color";s:7:"#005C99";s:30:"sesariana_minimenu_links_color";s:7:"#243238";s:36:"sesariana_minimenu_links_hover_color";s:7:"#005C99";s:40:"sesariana_minimenu_icon_background_color";s:7:"#ECEFF1";s:47:"sesariana_minimenu_icon_background_active_color";s:7:"#005C99";s:29:"sesariana_minimenu_icon_color";s:7:"#243238";s:36:"sesariana_minimenu_icon_active_color";s:7:"#FFFFFF";s:43:"sesariana_header_searchbox_background_color";s:7:"#ECEFF1";s:37:"sesariana_header_searchbox_text_color";s:7:"#8DA1AB";s:44:"sesariana_toppanel_userinfo_background_color";s:7:"#005C99";s:38:"sesariana_toppanel_userinfo_font_color";s:7:"#FFFFFF";s:45:"sesariana_login_popup_header_background_color";s:7:"#005C99";s:39:"sesariana_login_popup_header_font_color";s:7:"#FFFFFF";s:33:"sesariana_footer_background_color";s:7:"#FFFFFF";s:28:"sesariana_footer_links_color";s:7:"#243238";s:34:"sesariana_footer_links_hover_color";s:7:"#005C99";s:29:"sesariana_footer_border_color";s:7:"#DDDDDD";s:21:"sesariana_theme_color";s:7:"#005C99";s:31:"sesariana_body_background_color";s:7:"#ECEFF1";s:20:"sesariana_font_color";s:7:"#243238";s:26:"sesariana_font_color_light";s:7:"#999999";s:23:"sesariana_heading_color";s:7:"#243238";s:21:"sesariana_links_color";s:7:"#243238";s:27:"sesariana_links_hover_color";s:7:"#005C99";s:41:"sesariana_content_header_background_color";s:7:"#FFFFFF";s:35:"sesariana_content_header_font_color";s:7:"#243238";s:34:"sesariana_content_background_color";s:7:"#FFFFFF";s:30:"sesariana_content_border_color";s:7:"#EBECEE";s:26:"sesariana_form_label_color";s:7:"#243238";s:32:"sesariana_input_background_color";s:7:"#FFFFFF";s:26:"sesariana_input_font_color";s:7:"#6D6D6D";s:28:"sesariana_input_border_color";s:7:"#CACACA";s:33:"sesariana_button_background_color";s:7:"#243238";s:39:"sesariana_button_background_color_hover";s:7:"#005C99";s:27:"sesariana_button_font_color";s:7:"#FFFFFF";s:33:"sesariana_button_font_hover_color";s:7:"#FFFFFF";s:34:"sesariana_comment_background_color";s:7:"#FDFDFD";}\', 0),
(2, "Theme - 2", \'a:44:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:2:"19";s:13:"custom_themes";N;s:33:"sesariana_header_background_color";s:7:"#FFFFFF";s:30:"sesariana_menu_logo_font_color";s:7:"#FF5722";s:35:"sesariana_mainmenu_background_color";s:7:"#FFFFFF";s:30:"sesariana_mainmenu_links_color";s:7:"#243238";s:36:"sesariana_mainmenu_links_hover_color";s:7:"#FF5722";s:30:"sesariana_minimenu_links_color";s:7:"#243238";s:36:"sesariana_minimenu_links_hover_color";s:7:"#FF5722";s:40:"sesariana_minimenu_icon_background_color";s:7:"#ECEFF1";s:47:"sesariana_minimenu_icon_background_active_color";s:7:"#FF5722";s:29:"sesariana_minimenu_icon_color";s:7:"#243238";s:36:"sesariana_minimenu_icon_active_color";s:7:"#FFFFFF";s:43:"sesariana_header_searchbox_background_color";s:7:"#ECEFF1";s:37:"sesariana_header_searchbox_text_color";s:7:"#8DA1AB";s:44:"sesariana_toppanel_userinfo_background_color";s:7:"#FF5722";s:38:"sesariana_toppanel_userinfo_font_color";s:7:"#FFFFFF";s:45:"sesariana_login_popup_header_background_color";s:7:"#FF5722";s:39:"sesariana_login_popup_header_font_color";s:7:"#FFFFFF";s:33:"sesariana_footer_background_color";s:7:"#FFFFFF";s:28:"sesariana_footer_links_color";s:7:"#243238";s:34:"sesariana_footer_links_hover_color";s:7:"#FF5722";s:29:"sesariana_footer_border_color";s:7:"#DDDDDD";s:21:"sesariana_theme_color";s:7:"#FF5722";s:31:"sesariana_body_background_color";s:7:"#ECEFF1";s:20:"sesariana_font_color";s:7:"#243238";s:26:"sesariana_font_color_light";s:7:"#999999";s:23:"sesariana_heading_color";s:7:"#243238";s:21:"sesariana_links_color";s:7:"#243238";s:27:"sesariana_links_hover_color";s:7:"#FF5722";s:41:"sesariana_content_header_background_color";s:7:"#FFFFFF";s:35:"sesariana_content_header_font_color";s:7:"#243238";s:34:"sesariana_content_background_color";s:7:"#FFFFFF";s:30:"sesariana_content_border_color";s:7:"#EBECEE";s:26:"sesariana_form_label_color";s:7:"#243238";s:32:"sesariana_input_background_color";s:7:"#FFFFFF";s:26:"sesariana_input_font_color";s:7:"#6D6D6D";s:28:"sesariana_input_border_color";s:7:"#CACACA";s:33:"sesariana_button_background_color";s:7:"#243238";s:39:"sesariana_button_background_color_hover";s:7:"#FF5722";s:27:"sesariana_button_font_color";s:7:"#FFFFFF";s:33:"sesariana_button_font_hover_color";s:7:"#FFFFFF";s:34:"sesariana_comment_background_color";s:7:"#FDFDFD";}\', 0),
(3, "Theme - 3", \'a:44:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:2:"20";s:13:"custom_themes";N;s:33:"sesariana_header_background_color";s:7:"#FFFFFF";s:30:"sesariana_menu_logo_font_color";s:7:"#D03E82";s:35:"sesariana_mainmenu_background_color";s:7:"#FFFFFF";s:30:"sesariana_mainmenu_links_color";s:7:"#243238";s:36:"sesariana_mainmenu_links_hover_color";s:7:"#D03E82";s:30:"sesariana_minimenu_links_color";s:7:"#243238";s:36:"sesariana_minimenu_links_hover_color";s:7:"#D03E82";s:40:"sesariana_minimenu_icon_background_color";s:7:"#ECEFF1";s:47:"sesariana_minimenu_icon_background_active_color";s:7:"#D03E82";s:29:"sesariana_minimenu_icon_color";s:7:"#243238";s:36:"sesariana_minimenu_icon_active_color";s:7:"#FFFFFF";s:43:"sesariana_header_searchbox_background_color";s:7:"#ECEFF1";s:37:"sesariana_header_searchbox_text_color";s:7:"#8DA1AB";s:44:"sesariana_toppanel_userinfo_background_color";s:7:"#D03E82";s:38:"sesariana_toppanel_userinfo_font_color";s:7:"#FFFFFF";s:45:"sesariana_login_popup_header_background_color";s:7:"#D03E82";s:39:"sesariana_login_popup_header_font_color";s:7:"#FFFFFF";s:33:"sesariana_footer_background_color";s:7:"#FFFFFF";s:28:"sesariana_footer_links_color";s:7:"#243238";s:34:"sesariana_footer_links_hover_color";s:7:"#D03E82";s:29:"sesariana_footer_border_color";s:7:"#DDDDDD";s:21:"sesariana_theme_color";s:7:"#D03E82";s:31:"sesariana_body_background_color";s:7:"#ECEFF1";s:20:"sesariana_font_color";s:7:"#243238";s:26:"sesariana_font_color_light";s:7:"#999999";s:23:"sesariana_heading_color";s:7:"#243238";s:21:"sesariana_links_color";s:7:"#243238";s:27:"sesariana_links_hover_color";s:7:"#D03E82";s:41:"sesariana_content_header_background_color";s:7:"#FFFFFF";s:35:"sesariana_content_header_font_color";s:7:"#243238";s:34:"sesariana_content_background_color";s:7:"#FFFFFF";s:30:"sesariana_content_border_color";s:7:"#EBECEE";s:26:"sesariana_form_label_color";s:7:"#243238";s:32:"sesariana_input_background_color";s:7:"#FFFFFF";s:26:"sesariana_input_font_color";s:7:"#6D6D6D";s:28:"sesariana_input_border_color";s:7:"#CACACA";s:33:"sesariana_button_background_color";s:7:"#243238";s:39:"sesariana_button_background_color_hover";s:7:"#D03E82";s:27:"sesariana_button_font_color";s:7:"#FFFFFF";s:33:"sesariana_button_font_hover_color";s:7:"#FFFFFF";s:34:"sesariana_comment_background_color";s:7:"#FDFDFD";}\', 0),
(4, "Theme - 4", \'a:44:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:2:"21";s:13:"custom_themes";N;s:33:"sesariana_header_background_color";s:7:"#FFFFFF";s:30:"sesariana_menu_logo_font_color";s:7:"#354C17";s:35:"sesariana_mainmenu_background_color";s:7:"#FFFFFF";s:30:"sesariana_mainmenu_links_color";s:7:"#243238";s:36:"sesariana_mainmenu_links_hover_color";s:7:"#354C17";s:30:"sesariana_minimenu_links_color";s:7:"#243238";s:36:"sesariana_minimenu_links_hover_color";s:7:"#354C17";s:40:"sesariana_minimenu_icon_background_color";s:7:"#ECEFF1";s:47:"sesariana_minimenu_icon_background_active_color";s:7:"#354C17";s:29:"sesariana_minimenu_icon_color";s:7:"#243238";s:36:"sesariana_minimenu_icon_active_color";s:7:"#FFFFFF";s:43:"sesariana_header_searchbox_background_color";s:7:"#ECEFF1";s:37:"sesariana_header_searchbox_text_color";s:7:"#8DA1AB";s:44:"sesariana_toppanel_userinfo_background_color";s:7:"#354C17";s:38:"sesariana_toppanel_userinfo_font_color";s:7:"#FFFFFF";s:45:"sesariana_login_popup_header_background_color";s:7:"#354C17";s:39:"sesariana_login_popup_header_font_color";s:7:"#FFFFFF";s:33:"sesariana_footer_background_color";s:7:"#FFFFFF";s:28:"sesariana_footer_links_color";s:7:"#243238";s:34:"sesariana_footer_links_hover_color";s:7:"#354C17";s:29:"sesariana_footer_border_color";s:7:"#DDDDDD";s:21:"sesariana_theme_color";s:7:"#354C17";s:31:"sesariana_body_background_color";s:7:"#ECEFF1";s:20:"sesariana_font_color";s:7:"#243238";s:26:"sesariana_font_color_light";s:7:"#999999";s:23:"sesariana_heading_color";s:7:"#243238";s:21:"sesariana_links_color";s:7:"#243238";s:27:"sesariana_links_hover_color";s:7:"#354C17";s:41:"sesariana_content_header_background_color";s:7:"#FFFFFF";s:35:"sesariana_content_header_font_color";s:7:"#243238";s:34:"sesariana_content_background_color";s:7:"#FFFFFF";s:30:"sesariana_content_border_color";s:7:"#EBECEE";s:26:"sesariana_form_label_color";s:7:"#243238";s:32:"sesariana_input_background_color";s:7:"#FFFFFF";s:26:"sesariana_input_font_color";s:7:"#6D6D6D";s:28:"sesariana_input_border_color";s:7:"#CACACA";s:33:"sesariana_button_background_color";s:7:"#243238";s:39:"sesariana_button_background_color_hover";s:7:"#354C17";s:27:"sesariana_button_font_color";s:7:"#FFFFFF";s:33:"sesariana_button_font_hover_color";s:7:"#FFFFFF";s:34:"sesariana_comment_background_color";s:7:"#FDFDFD";}\', 0),
(5, "Theme - 5", \'a:44:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:2:"22";s:13:"custom_themes";N;s:33:"sesariana_header_background_color";s:7:"#FFFFFF";s:30:"sesariana_menu_logo_font_color";s:7:"#2C6C73";s:35:"sesariana_mainmenu_background_color";s:7:"#FFFFFF";s:30:"sesariana_mainmenu_links_color";s:7:"#243238";s:36:"sesariana_mainmenu_links_hover_color";s:7:"#2C6C73";s:30:"sesariana_minimenu_links_color";s:7:"#243238";s:36:"sesariana_minimenu_links_hover_color";s:7:"#2C6C73";s:40:"sesariana_minimenu_icon_background_color";s:7:"#ECEFF1";s:47:"sesariana_minimenu_icon_background_active_color";s:7:"#2C6C73";s:29:"sesariana_minimenu_icon_color";s:7:"#243238";s:36:"sesariana_minimenu_icon_active_color";s:7:"#FFFFFF";s:43:"sesariana_header_searchbox_background_color";s:7:"#ECEFF1";s:37:"sesariana_header_searchbox_text_color";s:7:"#8DA1AB";s:44:"sesariana_toppanel_userinfo_background_color";s:7:"#2C6C73";s:38:"sesariana_toppanel_userinfo_font_color";s:7:"#FFFFFF";s:45:"sesariana_login_popup_header_background_color";s:7:"#2C6C73";s:39:"sesariana_login_popup_header_font_color";s:7:"#FFFFFF";s:33:"sesariana_footer_background_color";s:7:"#FFFFFF";s:28:"sesariana_footer_links_color";s:7:"#243238";s:34:"sesariana_footer_links_hover_color";s:7:"#2C6C73";s:29:"sesariana_footer_border_color";s:7:"#DDDDDD";s:21:"sesariana_theme_color";s:7:"#2C6C73";s:31:"sesariana_body_background_color";s:7:"#ECEFF1";s:20:"sesariana_font_color";s:7:"#243238";s:26:"sesariana_font_color_light";s:7:"#999999";s:23:"sesariana_heading_color";s:7:"#243238";s:21:"sesariana_links_color";s:7:"#243238";s:27:"sesariana_links_hover_color";s:7:"#2C6C73";s:41:"sesariana_content_header_background_color";s:7:"#FFFFFF";s:35:"sesariana_content_header_font_color";s:7:"#243238";s:34:"sesariana_content_background_color";s:7:"#FFFFFF";s:30:"sesariana_content_border_color";s:7:"#EBECEE";s:26:"sesariana_form_label_color";s:7:"#243238";s:32:"sesariana_input_background_color";s:7:"#FFFFFF";s:26:"sesariana_input_font_color";s:7:"#6D6D6D";s:28:"sesariana_input_border_color";s:7:"#CACACA";s:33:"sesariana_button_background_color";s:7:"#243238";s:39:"sesariana_button_background_color_hover";s:7:"#2C6C73";s:27:"sesariana_button_font_color";s:7:"#FFFFFF";s:33:"sesariana_button_font_hover_color";s:7:"#FFFFFF";s:34:"sesariana_comment_background_color";s:7:"#FDFDFD";}\', 0),
(6, "Theme - 6", \'a:44:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:2:"23";s:13:"custom_themes";N;s:33:"sesariana_header_background_color";s:7:"#FFFFFF";s:30:"sesariana_menu_logo_font_color";s:7:"#BF3F34";s:35:"sesariana_mainmenu_background_color";s:7:"#FFFFFF";s:30:"sesariana_mainmenu_links_color";s:7:"#243238";s:36:"sesariana_mainmenu_links_hover_color";s:7:"#BF3F34";s:30:"sesariana_minimenu_links_color";s:7:"#243238";s:36:"sesariana_minimenu_links_hover_color";s:7:"#BF3F34";s:40:"sesariana_minimenu_icon_background_color";s:7:"#ECEFF1";s:47:"sesariana_minimenu_icon_background_active_color";s:7:"#BF3F34";s:29:"sesariana_minimenu_icon_color";s:7:"#243238";s:36:"sesariana_minimenu_icon_active_color";s:7:"#FFFFFF";s:43:"sesariana_header_searchbox_background_color";s:7:"#ECEFF1";s:37:"sesariana_header_searchbox_text_color";s:7:"#8DA1AB";s:44:"sesariana_toppanel_userinfo_background_color";s:7:"#BF3F34";s:38:"sesariana_toppanel_userinfo_font_color";s:7:"#FFFFFF";s:45:"sesariana_login_popup_header_background_color";s:7:"#BF3F34";s:39:"sesariana_login_popup_header_font_color";s:7:"#FFFFFF";s:33:"sesariana_footer_background_color";s:7:"#FFFFFF";s:28:"sesariana_footer_links_color";s:7:"#243238";s:34:"sesariana_footer_links_hover_color";s:7:"#BF3F34";s:29:"sesariana_footer_border_color";s:7:"#DDDDDD";s:21:"sesariana_theme_color";s:7:"#BF3F34";s:31:"sesariana_body_background_color";s:7:"#ECEFF1";s:20:"sesariana_font_color";s:7:"#243238";s:26:"sesariana_font_color_light";s:7:"#999999";s:23:"sesariana_heading_color";s:7:"#243238";s:21:"sesariana_links_color";s:7:"#243238";s:27:"sesariana_links_hover_color";s:7:"#BF3F34";s:41:"sesariana_content_header_background_color";s:7:"#FFFFFF";s:35:"sesariana_content_header_font_color";s:7:"#243238";s:34:"sesariana_content_background_color";s:7:"#FFFFFF";s:30:"sesariana_content_border_color";s:7:"#EBECEE";s:26:"sesariana_form_label_color";s:7:"#243238";s:32:"sesariana_input_background_color";s:7:"#FFFFFF";s:26:"sesariana_input_font_color";s:7:"#6D6D6D";s:28:"sesariana_input_border_color";s:7:"#CACACA";s:33:"sesariana_button_background_color";s:7:"#243238";s:39:"sesariana_button_background_color_hover";s:7:"#BF3F34";s:27:"sesariana_button_font_color";s:7:"#FFFFFF";s:33:"sesariana_button_font_hover_color";s:7:"#FFFFFF";s:34:"sesariana_comment_background_color";s:7:"#FDFDFD";}\', 0),
(7, "Theme - 7", \'a:44:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:2:"24";s:13:"custom_themes";N;s:33:"sesariana_header_background_color";s:7:"#FFFFFF";s:30:"sesariana_menu_logo_font_color";s:7:"#B09800";s:35:"sesariana_mainmenu_background_color";s:7:"#FFFFFF";s:30:"sesariana_mainmenu_links_color";s:7:"#243238";s:36:"sesariana_mainmenu_links_hover_color";s:7:"#B09800";s:30:"sesariana_minimenu_links_color";s:7:"#243238";s:36:"sesariana_minimenu_links_hover_color";s:7:"#B09800";s:40:"sesariana_minimenu_icon_background_color";s:7:"#ECEFF1";s:47:"sesariana_minimenu_icon_background_active_color";s:7:"#B09800";s:29:"sesariana_minimenu_icon_color";s:7:"#243238";s:36:"sesariana_minimenu_icon_active_color";s:7:"#FFFFFF";s:43:"sesariana_header_searchbox_background_color";s:7:"#ECEFF1";s:37:"sesariana_header_searchbox_text_color";s:7:"#8DA1AB";s:44:"sesariana_toppanel_userinfo_background_color";s:7:"#B09800";s:38:"sesariana_toppanel_userinfo_font_color";s:7:"#FFFFFF";s:45:"sesariana_login_popup_header_background_color";s:7:"#B09800";s:39:"sesariana_login_popup_header_font_color";s:7:"#FFFFFF";s:33:"sesariana_footer_background_color";s:7:"#FFFFFF";s:28:"sesariana_footer_links_color";s:7:"#243238";s:34:"sesariana_footer_links_hover_color";s:7:"#B09800";s:29:"sesariana_footer_border_color";s:7:"#DDDDDD";s:21:"sesariana_theme_color";s:7:"#B09800";s:31:"sesariana_body_background_color";s:7:"#ECEFF1";s:20:"sesariana_font_color";s:7:"#243238";s:26:"sesariana_font_color_light";s:7:"#999999";s:23:"sesariana_heading_color";s:7:"#243238";s:21:"sesariana_links_color";s:7:"#243238";s:27:"sesariana_links_hover_color";s:7:"#B09800";s:41:"sesariana_content_header_background_color";s:7:"#FFFFFF";s:35:"sesariana_content_header_font_color";s:7:"#243238";s:34:"sesariana_content_background_color";s:7:"#FFFFFF";s:30:"sesariana_content_border_color";s:7:"#EBECEE";s:26:"sesariana_form_label_color";s:7:"#243238";s:32:"sesariana_input_background_color";s:7:"#FFFFFF";s:26:"sesariana_input_font_color";s:7:"#6D6D6D";s:28:"sesariana_input_border_color";s:7:"#CACACA";s:33:"sesariana_button_background_color";s:7:"#243238";s:39:"sesariana_button_background_color_hover";s:7:"#B09800";s:27:"sesariana_button_font_color";s:7:"#FFFFFF";s:33:"sesariana_button_font_hover_color";s:7:"#FFFFFF";s:34:"sesariana_comment_background_color";s:7:"#FDFDFD";}\', 0),
(8, "Theme - 8", \'a:44:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:2:"25";s:13:"custom_themes";N;s:33:"sesariana_header_background_color";s:7:"#FFFFFF";s:30:"sesariana_menu_logo_font_color";s:7:"#83431B";s:35:"sesariana_mainmenu_background_color";s:7:"#FFFFFF";s:30:"sesariana_mainmenu_links_color";s:7:"#243238";s:36:"sesariana_mainmenu_links_hover_color";s:7:"#000000";s:30:"sesariana_minimenu_links_color";s:7:"#243238";s:36:"sesariana_minimenu_links_hover_color";s:7:"#83431B";s:40:"sesariana_minimenu_icon_background_color";s:7:"#ECEFF1";s:47:"sesariana_minimenu_icon_background_active_color";s:7:"#83431B";s:29:"sesariana_minimenu_icon_color";s:7:"#243238";s:36:"sesariana_minimenu_icon_active_color";s:7:"#FFFFFF";s:43:"sesariana_header_searchbox_background_color";s:7:"#ECEFF1";s:37:"sesariana_header_searchbox_text_color";s:7:"#8DA1AB";s:44:"sesariana_toppanel_userinfo_background_color";s:7:"#83431B";s:38:"sesariana_toppanel_userinfo_font_color";s:7:"#FFFFFF";s:45:"sesariana_login_popup_header_background_color";s:7:"#83431B";s:39:"sesariana_login_popup_header_font_color";s:7:"#FFFFFF";s:33:"sesariana_footer_background_color";s:7:"#FFFFFF";s:28:"sesariana_footer_links_color";s:7:"#243238";s:34:"sesariana_footer_links_hover_color";s:7:"#83431B";s:29:"sesariana_footer_border_color";s:7:"#DDDDDD";s:21:"sesariana_theme_color";s:7:"#83431B";s:31:"sesariana_body_background_color";s:7:"#ECEFF1";s:20:"sesariana_font_color";s:7:"#243238";s:26:"sesariana_font_color_light";s:7:"#999999";s:23:"sesariana_heading_color";s:7:"#243238";s:21:"sesariana_links_color";s:7:"#243238";s:27:"sesariana_links_hover_color";s:7:"#83431B";s:41:"sesariana_content_header_background_color";s:7:"#FFFFFF";s:35:"sesariana_content_header_font_color";s:7:"#243238";s:34:"sesariana_content_background_color";s:7:"#FFFFFF";s:30:"sesariana_content_border_color";s:7:"#EBECEE";s:26:"sesariana_form_label_color";s:7:"#243238";s:32:"sesariana_input_background_color";s:7:"#FFFFFF";s:26:"sesariana_input_font_color";s:7:"#6D6D6D";s:28:"sesariana_input_border_color";s:7:"#CACACA";s:33:"sesariana_button_background_color";s:7:"#243238";s:39:"sesariana_button_background_color_hover";s:7:"#83431B";s:27:"sesariana_button_font_color";s:7:"#FFFFFF";s:33:"sesariana_button_font_hover_color";s:7:"#FFFFFF";s:34:"sesariana_comment_background_color";s:7:"#FDFDFD";}\', 0),
(9, "Theme - 9", \'a:44:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:2:"26";s:13:"custom_themes";N;s:33:"sesariana_header_background_color";s:7:"#222428";s:30:"sesariana_menu_logo_font_color";s:7:"#FF1D23";s:35:"sesariana_mainmenu_background_color";s:7:"#222428";s:30:"sesariana_mainmenu_links_color";s:7:"#FFFFFF";s:36:"sesariana_mainmenu_links_hover_color";s:7:"#FF1D23";s:30:"sesariana_minimenu_links_color";s:7:"#FFFFFF";s:36:"sesariana_minimenu_links_hover_color";s:7:"#FF1D23";s:40:"sesariana_minimenu_icon_background_color";s:7:"#36383D";s:47:"sesariana_minimenu_icon_background_active_color";s:7:"#FF1D23";s:29:"sesariana_minimenu_icon_color";s:7:"#FFFFFF";s:36:"sesariana_minimenu_icon_active_color";s:7:"#FFFFFF";s:43:"sesariana_header_searchbox_background_color";s:7:"#36383D";s:37:"sesariana_header_searchbox_text_color";s:7:"#FFFFFF";s:44:"sesariana_toppanel_userinfo_background_color";s:7:"#FF1D23";s:38:"sesariana_toppanel_userinfo_font_color";s:7:"#FFFFFF";s:45:"sesariana_login_popup_header_background_color";s:7:"#FF1D23";s:39:"sesariana_login_popup_header_font_color";s:7:"#FFFFFF";s:33:"sesariana_footer_background_color";s:7:"#222222";s:28:"sesariana_footer_links_color";s:7:"#B3B3B3";s:34:"sesariana_footer_links_hover_color";s:7:"#FF1D23";s:29:"sesariana_footer_border_color";s:7:"#FF1D23";s:21:"sesariana_theme_color";s:7:"#FF1D23";s:31:"sesariana_body_background_color";s:7:"#111418";s:20:"sesariana_font_color";s:7:"#F1F1F1";s:26:"sesariana_font_color_light";s:7:"#DDDDDD";s:23:"sesariana_heading_color";s:7:"#FFFFFF";s:21:"sesariana_links_color";s:7:"#FFFFFF";s:27:"sesariana_links_hover_color";s:7:"#FF1D23";s:41:"sesariana_content_header_background_color";s:7:"#222428";s:35:"sesariana_content_header_font_color";s:7:"#FFFFFF";s:34:"sesariana_content_background_color";s:7:"#222428";s:30:"sesariana_content_border_color";s:7:"#36383D";s:26:"sesariana_form_label_color";s:7:"#FFFFFF";s:32:"sesariana_input_background_color";s:7:"#222428";s:26:"sesariana_input_font_color";s:7:"#FFFFFF";s:28:"sesariana_input_border_color";s:7:"#36383D";s:33:"sesariana_button_background_color";s:7:"#FF1D23";s:39:"sesariana_button_background_color_hover";s:7:"#FF5252";s:27:"sesariana_button_font_color";s:7:"#FFFFFF";s:33:"sesariana_button_font_hover_color";s:7:"#FFFFFF";s:34:"sesariana_comment_background_color";s:7:"#1E1F23";}\', 0),
(10, "Theme - 10", \'a:44:{s:11:"theme_color";s:1:"5";s:18:"custom_theme_color";s:2:"27";s:13:"custom_themes";N;s:33:"sesariana_header_background_color";s:7:"#ED54A4";s:30:"sesariana_menu_logo_font_color";s:7:"#FFFFFF";s:35:"sesariana_mainmenu_background_color";s:7:"#FFFFFF";s:30:"sesariana_mainmenu_links_color";s:7:"#36383D";s:36:"sesariana_mainmenu_links_hover_color";s:7:"#4682B4";s:30:"sesariana_minimenu_links_color";s:7:"#FFFFFF";s:36:"sesariana_minimenu_links_hover_color";s:7:"#F1F1F1";s:40:"sesariana_minimenu_icon_background_color";s:7:"#F07AB1";s:47:"sesariana_minimenu_icon_background_active_color";s:7:"#FFFFFF";s:29:"sesariana_minimenu_icon_color";s:7:"#FFFFFF";s:36:"sesariana_minimenu_icon_active_color";s:7:"#ED54A4";s:43:"sesariana_header_searchbox_background_color";s:7:"#C7C7C7";s:37:"sesariana_header_searchbox_text_color";s:7:"#FFFFFF";s:44:"sesariana_toppanel_userinfo_background_color";s:7:"#ED54A4";s:38:"sesariana_toppanel_userinfo_font_color";s:7:"#FFFFFF";s:45:"sesariana_login_popup_header_background_color";s:7:"#ED54A4";s:39:"sesariana_login_popup_header_font_color";s:7:"#FFFFFF";s:33:"sesariana_footer_background_color";s:7:"#FFFFFF";s:28:"sesariana_footer_links_color";s:7:"#4682B4";s:34:"sesariana_footer_links_hover_color";s:7:"#ED54A4";s:29:"sesariana_footer_border_color";s:7:"#DDDDDD";s:21:"sesariana_theme_color";s:7:"#ED54A4";s:31:"sesariana_body_background_color";s:7:"#F5F5F5";s:20:"sesariana_font_color";s:7:"#243238";s:26:"sesariana_font_color_light";s:7:"#707070";s:23:"sesariana_heading_color";s:7:"#243238";s:21:"sesariana_links_color";s:7:"#243238";s:27:"sesariana_links_hover_color";s:7:"#4682B4";s:41:"sesariana_content_header_background_color";s:7:"#FFFFFF";s:35:"sesariana_content_header_font_color";s:7:"#243238";s:34:"sesariana_content_background_color";s:7:"#FFFFFF";s:30:"sesariana_content_border_color";s:7:"#EBECEE";s:26:"sesariana_form_label_color";s:7:"#243238";s:32:"sesariana_input_background_color";s:7:"#FFFFFF";s:26:"sesariana_input_font_color";s:7:"#6D6D6D";s:28:"sesariana_input_border_color";s:7:"#CACACA";s:33:"sesariana_button_background_color";s:7:"#4682B4";s:39:"sesariana_button_background_color_hover";s:7:"#E8288D";s:27:"sesariana_button_font_color";s:7:"#FFFFFF";s:33:"sesariana_button_font_hover_color";s:7:"#FFFFFF";s:34:"sesariana_comment_background_color";s:7:"#FDFDFD";}\', 0);');

//Main Menu Icon default installation work
$select = Engine_Api::_()->getDbTable('menuitems', 'core')->select()
				->where('menu = ?', 'core_main')
				//->where('enabled = ?', 1)
				->order('order ASC');
$paginator = Engine_Api::_()->getDbTable('menuitems', 'core')->fetchAll($select);
foreach($paginator as $result) {
	$data = explode('_', $result->name);
	if($data[2] == 'sesblog') {
		$data[2] = 'blog';
	} else if($data[2] == 'sesalbum'){
		$data[2] = 'album';
	} else if($data[2] == 'sesevent') {
		$data[2] = 'event';
	} else if ($data[2] == 'sesvideo') {
		$data[2] = 'video';
	} else if ($data[2] == 'sesmember') {
		$data[2] = 'user';
	} else if ($data[2] == 'sesmusic') {
		$data[2] = 'music';
	}
	$PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesariana' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "menu-icons" . DIRECTORY_SEPARATOR;
	if (is_file($PathFile . $data[2] . '.png'))  {
		$pngFile = $PathFile . $data[2] . '.png';
		$photo_params = array(
				'parent_id' => $result->id,
				'parent_type' => "sesariana_slideshow_image",
		);
		$photoFile = Engine_Api::_()->storage()->create($pngFile, $photo_params);
		if (!empty($photoFile->file_id)) {
			//$db->update('engine4_core_menuitems', array('file_id' => $photoFile->file_id), array('id = ?' => $result->id));
		}
	}
}

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sesariana_admin_main_typography", "sesariana", "Typography", "", \'{"route":"admin_default","module":"sesariana","controller":"settings", "action":"typography"}\', "sesariana_admin_main", "", 50);');

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesariana_admin_main_minimenu", "sesariana", "Mini Menu", "", \'{"route":"admin_default","module":"sesariana","controller":"menu"}\', "sesariana_admin_main", "", 3);');