<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$ses_field = $db->query('SHOW COLUMNS FROM engine4_user_fields_meta LIKE \'ses_field\'')->fetch();
if (empty($ses_field)) {
  $db->query('ALTER TABLE `engine4_user_fields_meta` ADD `ses_field` TINYINT(1) NOT NULL DEFAULT "0";');
}

//Browse Members Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesmember_index_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
if( !$page_id ) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sesmember_index_browse',
    'displayname' => 'SES - Advanced Members - Browse Members Page',
    'title' => 'Browse Members',
    'description' => 'This page show all members of your site.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'top',
    'page_id' => $page_id,
    'order' => 1,
  ));
  $top_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
    'order' => 2,
  ));
  $main_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPrated","featured","sponsored","verified"],"view":["0","1","3","week","month"],"default_search_type":"creation_date ASC","show_advanced_search":"1","network":"yes","alphabet":"yes","friend_show":"yes","search_title":"yes","browse_by":"yes","location":"yes","kilometer_miles":"yes","country":"yes","state":"yes","city":"yes","zip":"yes","member_type":"yes","has_photo":"yes","is_online":"yes","is_vip":"yes","title":"","nomobile":"0","name":"sesmember.browse-search"}'
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-members',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","advlist","grid","advgrid","pinboard","map"],"openViewType":"advlist","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","vipLabel","message","friendButton","followButton","likeButton","likemainButton","socialSharing","like","location","rating","view","title","friendCount","mutualFriendCount","profileType","age","profileField","heading","labelBold","pinboardSlideshow"],"limit_data":"12","profileFieldCount":"5","pagging":"button","order":"mostSPviewed","show_item_count":"1","list_title_truncation":"45","grid_title_truncation":"45","advgrid_title_truncation":"45","pinboard_title_truncation":"45","main_height":"350","main_width":"585","height":"200","width":"250","photo_height":"250","photo_width":"284","info_height":"315","advgrid_height":"322","advgrid_width":"382","pinboard_width":"350","title":"","nomobile":"0","name":"sesmember.browse-members"}',
  ));
}

//Nearest Member Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesmember_index_nearest-member')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sesmember_index_nearest-member',
    'displayname' => 'SES - Advanced Members - Nearest Member Page',
    'title' => 'Nearest Member',
    'description' => 'This page show nearest member based on current viewer.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  //Insert top
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'top',
    'page_id' => $page_id,
    'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  //Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
    'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  //Insert top-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();

  //Insert main-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  //Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPrated","featured","sponsored","verified"],"view":["0","1","3","week","month"],"default_search_type":"creation_date ASC","show_advanced_search":"yes","network":"no","alphabet":"no","friend_show":"no","search_title":"yes","browse_by":"yes","location":"yes","kilometer_miles":"yes","country":"yes","state":"yes","city":"yes","zip":"yes","member_type":"yes","has_photo":"no","is_online":"no","is_vip":"no","title":"","nomobile":"0","name":"sesmember.browse-search"}',
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-members',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["map"],"openViewType":"list","show_criteria":"","limit_data":"20","profileFieldCount":"5","pagging":"auto_load","order":null,"show_item_count":"0","list_title_truncation":"45","grid_title_truncation":"45","advgrid_title_truncation":"45","pinboard_title_truncation":"45","main_height":"160","main_width":"250","height":"160","width":"250","photo_height":"160","photo_width":"250","info_height":"160","advgrid_height":"322","advgrid_width":"322","pinboard_width":"250","title":"","nomobile":"0","name":"sesmember.browse-members"}',
  ));
}

//Member Compliment Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesmember_index_member-compliments')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sesmember_index_member-compliments',
    'displayname' => 'SES - Advanced Members - Members Compliment Page',
    'title' => 'Member Compliments',
    'description' => 'This page show members compliment.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert top
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'top',
    'page_id' => $page_id,
    'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
    'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  // Insert top-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  // Insert main-left
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'left',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 1,
  ));
  $left_id = $db->lastInsertId();

  // Insert main-right
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'right',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $right_id = $db->lastInsertId();

  //Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'params' => '{"viewType":"list","imageType":"square","order":"","criteria":"5","compliment":"1","showLimitData":"1","show_star":"0","show_criteria":["title"],"grid_title_truncation":"45","list_title_truncation":"45","height":"180","width":"180","photo_height":"160","photo_width":"250","limit_data":"6","title":"Beautiful Members","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'params' => '{"viewType":"thumbView","imageType":"rounded","order":"","criteria":"5","compliment":"6","showLimitData":"1","show_star":"0","show_criteria":"","grid_title_truncation":"45","list_title_truncation":"45","height":"103","width":"103","photo_height":"160","photo_width":"250","limit_data":"4","title":"Good Writer","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'params' => '{"viewType":"thumbView","imageType":"rounded","order":"","criteria":"5","compliment":"15","showLimitData":"1","show_star":"0","show_criteria":"","grid_title_truncation":"45","list_title_truncation":"45","height":"66","width":"66","photo_height":"160","photo_width":"250","limit_data":"6","title":"Well Done Persons","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'params' => '{"viewType":"thumbView","imageType":"square","order":"","criteria":"5","compliment":"14","showLimitData":"1","show_star":"0","show_criteria":"","grid_title_truncation":"45","list_title_truncation":"45","height":"66","width":"66","photo_height":"160","photo_width":"250","limit_data":"3","title":"Thankful Persons","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'params' => '{"viewType":"list","imageType":"square","order":"","criteria":"5","compliment":"6","showLimitData":"1","show_star":"0","show_criteria":["title"],"grid_title_truncation":"45","list_title_truncation":"45","height":"180","width":"180","photo_height":"160","photo_width":"250","limit_data":"3","title":"Good Writer","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'params' => '{"viewType":"gridOutside","imageType":"square","order":"","criteria":"5","compliment":"11","showLimitData":"1","show_star":"0","show_criteria":["title"],"grid_title_truncation":"45","list_title_truncation":"45","height":"212","width":"212","photo_height":"160","photo_width":"250","limit_data":"3","title":"Most Hottest Members","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'params' => '{"viewType":"thumbView","imageType":"square","order":"","criteria":"5","compliment":"13","showLimitData":"1","show_star":"0","show_criteria":["title"],"grid_title_truncation":"45","list_title_truncation":"45","height":"216","width":"216","photo_height":"160","photo_width":"250","limit_data":"6","title":"Most Liked Profile Members","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'params' => '{"viewType":"gridInside","imageType":"rounded","order":"","criteria":"5","compliment":"2","showLimitData":"1","show_star":"0","show_criteria":["title"],"grid_title_truncation":"45","list_title_truncation":"45","height":"200","width":"212","photo_height":"150","photo_width":"150","limit_data":"6","title":"Most Clever Persons","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'params' => '{"viewType":"thumbView","imageType":"rounded","order":"","criteria":"5","compliment":"7","showLimitData":"1","show_star":"0","show_criteria":"","grid_title_truncation":"45","list_title_truncation":"45","height":"216","width":"216","photo_height":"216","photo_width":"250","limit_data":"3","title":"Most Learner Members","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'params' => '{"viewType":"list","imageType":"square","order":"","criteria":"5","compliment":"3","showLimitData":"1","show_star":"0","show_criteria":["title"],"grid_title_truncation":"45","list_title_truncation":"45","height":"180","width":"180","photo_height":"160","photo_width":"250","limit_data":"5","title":"Most Cool Members","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
   $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'params' => '{"viewType":"list","imageType":"rounded","order":"","criteria":"5","compliment":"4","showLimitData":"1","show_star":"0","show_criteria":["title"],"grid_title_truncation":"45","list_title_truncation":"45","height":"56","width":"56","photo_height":"160","photo_width":"250","limit_data":"3","title":"Funniest Members","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
   $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'params' => '{"viewType":"list","imageType":"square","order":"","criteria":"5","compliment":"10","showLimitData":"0","show_star":"0","show_criteria":["title"],"grid_title_truncation":"45","list_title_truncation":"45","height":"180","width":"180","photo_height":"160","photo_width":"250","limit_data":"3","title":"Happiest Members","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
   $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'params' => '{"viewType":"thumbView","imageType":"rounded","order":"","criteria":"5","compliment":"8","showLimitData":"0","show_star":"0","show_criteria":"","grid_title_truncation":"45","list_title_truncation":"45","height":"66","width":"66","photo_height":"160","photo_width":"250","limit_data":"9","title":"Great Stuff","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
   $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'params' => '{"viewType":"gridInside","imageType":"square","order":"","criteria":"5","compliment":"12","showLimitData":"0","show_star":"0","show_criteria":["title","like","view","age"],"grid_title_truncation":"45","list_title_truncation":"45","height":"150","width":"219","photo_height":"120","photo_width":"120","limit_data":"1","title":"Noted Members","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => $widgetOrder++,
  ));
}

//Top Members Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesmember_index_top-members')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sesmember_index_top-members',
    'displayname' => 'SES - Advanced Members - Top Members Page',
    'title' => 'Top Members',
    'description' => 'This page show top members based on ratings and reviews.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert top
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'top',
    'page_id' => $page_id,
    'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
    'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  // Insert top-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  // Insert main-right
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'right',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 1,
  ));
  $right_id = $db->lastInsertId();

  //Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-search-toprated',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'params' => '{"view_type":"vertical","view":["0","1","3","week","month"],"show_advanced_search":"yes","network":"no","alphabet":"no","friend_show":"yes","search_title":"yes","location":"yes","kilometer_miles":"yes","country":"no","state":"no","city":"no","zip":"no","member_type":"yes","has_photo":"yes","is_online":"yes","is_vip":"no","title":"","nomobile":"0","name":"sesmember.browse-search-toprated"}',
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.top-rated-members',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["likeButton","friendButton","followButton","message","likemainButton","socialSharing","title","location","like","rating","view","friendCount","mutualFriendCount","profileType","age"],"list_title_truncation":"45","height":"200","width":"180","pagging":"button","limit_data":"12","title":"Top Rated Members","nomobile":"0","name":"sesmember.top-rated-members"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-featured-verified-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"info":"featured","imageType":"square","showLimitData":"1","show_criteria":["title","description","by"],"list_title_truncation":"45","review_description_truncation":"80","limit_data":"3","title":"Featured Reviews","nomobile":"0","name":"sesmember.popular-featured-verified-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-featured-verified-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"info":"most_rated","imageType":"rounded","showLimitData":"1","show_criteria":["title","like","view","comment","rating","description","by"],"list_title_truncation":"45","review_description_truncation":"45","limit_data":"3","title":"Most Rated Members","nomobile":"0","name":"sesmember.popular-featured-verified-reviews"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"square","order":"","criteria":"6","info":"creation_date","showLimitData":"0","show_star":"0","show_criteria":["verifiedLabel","title","like","rating","view"],"grid_title_truncation":"45","list_title_truncation":"45","height":"180","width":"180","photo_height":"160","photo_width":"250","limit_data":"5","title":"Verified Members","nomobile":"0","name":"sesmember.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.top-reviewers',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"square","show_criteria":["title","rating"],"grid_title_truncation":"45","list_title_truncation":"45","showLimitData":"0","height":"180","width":"180","photo_height":"160","photo_width":"250","limit_data":"5","title":"Top Reviewers","nomobile":"0","name":"sesmember.top-reviewers"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesbasic.column-layout-width',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"layoutColumnWidthType":"px","columnWidth":"300","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-featured-verified-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"info":"most_commented","imageType":"rounded","showLimitData":"1","show_criteria":["title","like","view","comment","rating","verifiedLabel","featuredLabel","description","by"],"list_title_truncation":"45","review_description_truncation":"45","limit_data":"2","title":"Most Commented Reviews","nomobile":"0","name":"sesmember.popular-featured-verified-reviews"}',
  ));
}

//Browse Members Review Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesmember_review_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesmember_review_browse',
    'displayname' => 'SES - Advanced Member - Browse Members Review Page',
    'title' => 'Member Browse Reviews',
    'description' => 'This page show member reviews.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert top
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'top',
    'page_id' => $page_id,
    'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
    'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  // Insert top-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  // Insert main-left
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'left',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 1,
  ));
  $main_left_id = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.review-of-the-day',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"gridOutside","show_criteria":["title","like","view","rating","featuredLabel","verifiedLabel","socialSharing","likeButton"],"grid_title_truncation":"45","list_title_truncation":"45","height":"180","width":"180","photo_height":"160","photo_width":"250","title":"Review of the Day","nomobile":"0","name":"sesmember.review-of-the-day"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-review-search',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","review_title":"1","view":["likeSPcount","viewSPcount","commentSPcount","mostSPrated","leastSPrated","usefulSPcount","funnySPcount","coolSPcount","verified","featured"],"review_stars":"1","network":"1","title":"Review Browse Search","nomobile":"0","name":"sesmember.browse-review-search"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesbasic.column-layout-width',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"layoutColumnWidthType":"px","columnWidth":"300","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.top-reviewers',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"rounded","show_criteria":["title","like","rating","view"],"grid_title_truncation":"45","list_title_truncation":"45","showLimitData":"0","height":"180","width":"180","photo_height":"160","photo_width":"250","limit_data":"5","title":"Top Reviewers","nomobile":"0","name":"sesmember.top-reviewers"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"thumbView","imageType":"square","order":"","criteria":"5","info":"most_rated","showLimitData":"1","show_star":"0","show_criteria":["title"],"grid_title_truncation":"45","list_title_truncation":"45","height":"86","width":"86","photo_height":"160","photo_width":"250","limit_data":"18","title":"Most Rated Members","nomobile":"0","name":"sesmember.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-featured-verified-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"info":"featured","imageType":"rounded","showLimitData":"1","show_criteria":["title","like","view","comment","rating","verifiedLabel","featuredLabel","description","by"],"list_title_truncation":"45","review_description_truncation":"45","limit_data":"3","title":"Featured Reviews","nomobile":"0","name":"sesmember.popular-featured-verified-reviews"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-featured-verified-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"info":"verified","imageType":"rounded","showLimitData":"1","show_criteria":["title","like","view","comment","rating","verifiedLabel","featuredLabel","description","by"],"list_title_truncation":"45","review_description_truncation":"45","limit_data":"2","title":"Verfied Reviews","nomobile":"0","name":"sesmember.popular-featured-verified-reviews"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating"],"show_criteria":"","pagging":"button","limit_data":"9","title":"","nomobile":"0","name":"sesmember.browse-reviews"}',
  ));
}

//Members Location Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesmember_index_locations')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sesmember_index_locations',
    'displayname' => 'SES - Advanced Members - Members Location Page',
    'title' => 'Member Locations',
    'description' => 'This page show member locations.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  //Insert top
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'top',
    'page_id' => $page_id,
    'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  //Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
    'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  //Insert top-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();

  //Insert main-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  //Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPrated","featured","sponsored","verified"],"view":["0","1","week","month"],"default_search_type":"creation_date ASC","show_advanced_search":"yes","alphabet":"no","friend_show":"yes","search_title":"yes","browse_by":"yes","location":"yes","kilometer_miles":"yes","country":"yes","state":"yes","city":"yes","zip":"yes","title":"","nomobile":"0","name":"sesmember.browse-search"}',
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.member-location',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"location":"","lat":"","lng":"","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","location","likeButton","friendButton","followButton","message","likemainButton","rating","socialSharing","like","view","profileType","age"],"location-data":null,"title":"","nomobile":"0","name":"sesmember.member-location"}',
  ));
}

//Pinboard View Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesmember_index_pinborad-view-members')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sesmember_index_pinborad-view-members',
    'displayname' => 'SES - Advanced Members - Pinboard View Page',
    'title' => 'Show Member in Pinboard View',
    'description' => 'This page show all members in pinboard view.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert top
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'top',
    'page_id' => $page_id,
    'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
    'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  // Insert top-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  //Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPrated","featured","sponsored","verified"],"view":["0","1","3","week","month"],"default_search_type":"creation_date ASC","show_advanced_search":"yes","network":"yes","alphabet":"yes","friend_show":"yes","search_title":"yes","browse_by":"yes","location":"yes","kilometer_miles":"yes","country":"yes","state":"yes","city":"yes","zip":"yes","member_type":"yes","has_photo":"yes","is_online":"yes","is_vip":"yes","title":"","nomobile":"0","name":"sesmember.browse-search"}',
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-members',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["pinboard"],"openViewType":"pinboard","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","vipLabel","message","friendButton","followButton","likeButton","likemainButton","socialSharing","like","location","rating","view","title","friendCount","mutualFriendCount","profileType","age","profileField","labelBold","pinboardSlideshow"],"limit_data":"18","profileFieldCount":"5","pagging":"auto_load","order":"mostSPviewed","show_item_count":"1","list_title_truncation":"45","grid_title_truncation":"45","advgrid_title_truncation":"45","pinboard_title_truncation":"45","main_height":"160","main_width":"250","height":"160","width":"250","photo_height":"160","photo_width":"250","info_height":"160","advgrid_height":"322","advgrid_width":"322","pinboard_width":"250","title":"","nomobile":"0","name":"sesmember.browse-members"}',
  ));
}

//Review View Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesmember_review_view')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sesmember_review_view',
    'displayname' => 'SES - Advanced Members - Review View Page',
    'title' => 'Member Review View',
    'description' => 'This page displays a review entry.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert top
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'top',
    'page_id' => $page_id,
    'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
    'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  // Insert top-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  // Insert main-left
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'left',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 1,
  ));
  $main_left_id = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesmember.review-owner-photo',
    'parent_content_id' => $main_left_id,
    'params' => '{"title":"","showTitle":"1","nomobile":"0","name":"sesmember.review-owner-photo"}',
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesmember.review-profile-options',
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesmember.profile-review',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","pros","cons","description","recommended","postedin","creationDate","parameter","rating"],"title":"","nomobile":"0","name":"sesmember.profile-review"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'core.comments',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Comments"}',
  ));
}

// Default Complement Icon Upload Work
$complementryData = array(0 => array('Beautiful', 'beautiful.png'), 1 => array('Clever', 'clever.png'), 2 => array('Cool', 'cool.png'), 3 => array('Funny', 'funny.png'), 4 => array('Funny', 'funny1.png'), 5 => array('Good Writer', 'good-writer.png'), 6 => array('Great Learner', 'great-learner.png'), 7 => array('Greate Lists', 'great-lists.png'), 8 => array('Great Photo', 'great-photo.png'), 9 => array('Happy', 'happy.png'), 10 => array('Hot Stuff', 'hot-stuff.png'), 11 => array('Just a Note', 'just-a-note.png'), 12 => array('Like Your profile', 'like-profile.png'), 13 => array('Thank You', 'thank-you.png'), 14 => array('Well Done', 'well-done.png'));
foreach ($complementryData as $key => $value) {
  //Upload complenent icon
  $db->query("INSERT IGNORE INTO `engine4_sesmember_compliments` (`title`,`file_id`) VALUES ( '" . $value[0] . "',0)");
  $complementId = $db->lastInsertId();
  $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesmember' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "complementry" . DIRECTORY_SEPARATOR ;
  //colored icon upload
  if (is_file($PathFile .DIRECTORY_SEPARATOR. $value[1]))
  $compliment_icon = $this->setComplimentPhoto($PathFile . DIRECTORY_SEPARATOR. $value[1], $complementId);
  else
  $compliment_icon = 0;
  $db->query("UPDATE `engine4_sesmember_compliments` SET `file_id` = '" . $compliment_icon . "' WHERE compliment_id = " . $complementId);
}
$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES ("sesmember_follow_create", "sesmember", \'{item:$subject} create a {var:$itemtype} {item:$object}.\', 0, "");');

//Member Profile Page
$page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'user_profile_index')
            ->limit(1)
            ->query()
            ->fetchColumn();
if($page_id) {
  $main_id = $db->select()
            ->from('engine4_core_content', 'content_id')
            ->where('page_id = ?', $page_id)
            ->where('name = ?', 'main')
            ->limit(1)
            ->query()
            ->fetchColumn();

  $left_id = $db->select()
          ->from('engine4_core_content', 'content_id')
          ->where('page_id = ?', $page_id)
          ->where('name = ?', 'left')
          ->limit(1)
          ->query()
          ->fetchColumn();

  $right_id = $db->select()
          ->from('engine4_core_content', 'content_id')
          ->where('page_id = ?', $page_id)
          ->where('name = ?', 'right')
          ->limit(1)
          ->query()
          ->fetchColumn();

  if($left_id) {
    $widgets = $db->select()
    ->from('engine4_core_content')
    ->where('parent_content_id = ?', $left_id)
    ->query()
    ->fetchAll();

    if(!$right_id) {
      $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
      ));
      $right_id = $db->lastInsertId();
    }
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesmember.follow-button',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'order' => 0,
    ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesmember.like-button',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'params' => '{"title":""}',
      'order' => 0,
    ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesmember.review-add',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'order' => 0,
    ));

    $infoContentId = $db->select()
    ->from('engine4_core_content', 'content_id')
    ->where('page_id = ?', $page_id)
    ->where('name = ?', 'user.profile-info')
    ->limit(1)
    ->query()
    ->fetchColumn();

    if($infoContentId) {
      $db->delete('engine4_core_content', array('page_id =?' => $page_id, 'content_id =?' => $infoContentId));
    }

    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesmember.profile-info',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'params' => '{"show_criteria":["location","like","rating","view","friendCount","mutualFriendCount","profileType","joinInfo","updateInfo","network"],"title":"Information","nomobile":"0","name":"sesmember.profile-info"}',
      'order' => 0,
    ));

    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesmember.member-featured-photos',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'params' => '{"title":"Featured Photos","name":"sesmember.member-featured-photos"}',
      'order' => 0,
    ));

    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesmember.profile-user-compliments',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'params' => '{"title":"User\'s Compliments","name":"sesmember.profile-user-compliments"}',
      'order' => 0,
    ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesmember.profile-user-ratings',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'params' => '{"title":"User\'s Ratings","name":"sesmember.profile-user-ratings"}',
      'order' => 0,
    ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesmember.profile-user-review-votes',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'params' => '{"title":"Review Votes","name":"sesmember.profile-user-review-votes"}',
      'order' => 0,
    ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesbasic.column-layout-width',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'params' => '{"layoutColumnWidthType":"px","columnWidth":"300","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
      'order' => 0,
    ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesmember.member-liked',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'params' => '{"viewType":"thumbView","imageType":"square","showLimitData":"1","show_criteria":["title"],"grid_title_truncation":"45","list_title_truncation":"45","height":"66","width":"66","photo_height":"160","photo_width":"250","limit_data":"9","title":"Member Liked Me","nomobile":"0","name":"sesmember.member-liked"}',
      'order' => 0,
    ));
    foreach($widgets as $widget) {
      $db->query("UPDATE `engine4_core_content` SET `parent_content_id` = '" . $right_id . "' WHERE parent_content_id = " . $left_id);
    }
    $db->delete('engine4_core_content', array('content_id =?' => $left_id));
  }

  $select = new Zend_Db_Select($db);
  $select->from('engine4_core_content')
        ->where('type = ?', 'widget')
        ->where('name = ?', 'core.container-tabs')
        ->where('page_id = ?', $page_id)
        ->limit(1);
  $tab_id = $select->query()->fetchObject();
  if( $tab_id && @$tab_id->content_id ) {
    $tab_id = $tab_id->content_id;
  } else {
    $tab_id = null;
  }

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.user-map',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'params' => '{"title":"Map","titleCount":true,"name":"sesmember.user-map"}',
    'order' => 0,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.member-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating"],"title":"Reviews","nomobile":"0","name":"sesmember.member-reviews"}',
    'order' => 0,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.profile-compliments',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'params' => '{"title":"Compliments","criterias":["photo","username","friends","mutual","addfriend","follow","message"],"pagging":"button","limit_data":"10","nomobile":"0","name":"sesmember.profile-compliments"}',
    'order' => 0,
  ));

  $infoContentId = $db->select()
              ->from('engine4_core_content', 'content_id')
              ->where('page_id = ?', $page_id)
              ->where('name = ?', 'user.profile-friends')
              ->limit(1)
              ->query()
              ->fetchColumn();
  if($infoContentId) {
    $db->delete('engine4_core_content', array('page_id =?' => $page_id, 'content_id =?' => $infoContentId));
  }

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.profile-friends',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'params' => '{"show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","likeButton","friendButton","followButton","message","likemainButton","socialSharing","title","location","like","rating","view","friendCount","mutualFriendCount","profileType","age"],"title":"Friends","nomobile":"0","name":"sesmember.profile-friends"}',
    'order' => 0,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.recently-viewed-by-me',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'params' => '{"viewType":"gridOutside","imageType":"square","showLimitData":"1","order":"","criteria":"5","info":"creation_date","show_criteria":["friendButton","followButton","message","socialSharing","title","location","like","rating","view","friendCount","mutualFriendCount","age"],"grid_title_truncation":"45","list_title_truncation":"45","height":"300","width":"277","photo_height":"200","photo_width":"250","limit_data":"9","title":"Recently Viewed By Me","nomobile":"0","name":"sesmember.recently-viewed-by-me"}',
    'order' => 0,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.recently-viewed-me',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'params' => '{"viewType":"gridInside","imageType":"square","showLimitData":"1","order":"","criteria":"5","info":"creation_date","show_criteria":["friendButton","followButton","message","socialSharing","title","location","like","rating","view","friendCount","mutualFriendCount","profileType","age"],"grid_title_truncation":"45","list_title_truncation":"45","height":"320","width":"205","photo_height":"200","photo_width":"200","limit_data":"9","title":"Recently Viewed Me","nomobile":"0","name":"sesmember.recently-viewed-me"}',
    'order' => 0,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.followers',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'params' => '{"viewType":"list","imageType":"square","showLimitData":"1","show_criteria":["title","friendCount","mutualFriendCount"],"grid_title_truncation":"45","list_title_truncation":"45","height":"180","width":"180","photo_height":"160","photo_width":"250","limit_data":"10","title":"Followers","nomobile":"0","name":"sesmember.followers"}',
    'order' => 0,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.following',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'params' => '{"viewType":"gridInside","imageType":"square","showLimitData":"1","show_criteria":["followButton","title"],"grid_title_truncation":"45","list_title_truncation":"45","height":"185","width":"162","photo_height":"100","photo_width":"100","limit_data":"10","title":"Following","nomobile":"0","name":"sesmember.following"}',
    'order' => 0,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.recently-viewed-me',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'params' => '{"viewType":"gridInside","imageType":"square","showLimitData":"1","order":"","criteria":"5","info":"creation_date","show_criteria":["friendButton","followButton","message","socialSharing","title","location","like","rating","view","friendCount","mutualFriendCount","profileType","age"],"grid_title_truncation":"45","list_title_truncation":"45","height":"320","width":"205","photo_height":"200","photo_width":"200","limit_data":"9","title":"Recently Viewed Me","nomobile":"0","name":"sesmember.recently-viewed-me"}',
    'order' => 0,
  ));
}
//Member Home Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'user_index_home')
        ->limit(1)
        ->query()
        ->fetchColumn();
if($page_id) {
  $right_id = $db->select()
    ->from('engine4_core_content', 'content_id')
    ->where('page_id = ?', $page_id)
    ->where('type = ?', 'container')
    ->where('name = ?', 'right')
    ->limit(1)
    ->query()
    ->fetchColumn();

  $topContainerId = $db->select()
    ->from('engine4_core_content', 'content_id')
    ->where('page_id = ?', $page_id)
    ->where('type = ?', 'container')
    ->where('name = ?', 'main')
    ->limit(1)
    ->query()
    ->fetchColumn();

  $middleContainerId = $db->select()
    ->from('engine4_core_content', 'content_id')
    ->where('page_id = ?', $page_id)
    ->where('type = ?', 'container')
    ->where('name = ?', 'middle')
    ->where('parent_content_id = ?', $topContainerId)
    ->limit(1)
    ->query()
    ->fetchColumn();

  $infoContentId = $db->select()
    ->from('engine4_core_content', 'content_id')
    ->where('page_id = ?', $page_id)
    ->where('type = ?', 'widget')
    ->where('name = ?', 'user.home-photo')
    ->limit(1)
    ->query()
    ->fetchColumn();

  if($infoContentId) {
    $db->update('engine4_core_content', array('name' => 'sesmember.home-photo', 'params' => '{"show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","vipLabel","title"],"title":"","nomobile":"0","name":"sesmember.home-photo"}'), array('content_id =?' => $infoContentId));
  }

  $infoContentId = $db->select()
    ->from('engine4_core_content', 'content_id')
    ->where('page_id = ?', $page_id)
    ->where('name = ?', 'user.list-online')
    ->limit(1)
    ->query()
    ->fetchColumn();

  if($infoContentId) {
		$db->update('engine4_core_content', array('name' => 'sesmember.list-online', 'params' => '{"viewType":"thumbView","imageType":"square","show_criteria":"","grid_title_truncation":"45","list_title_truncation":"45","showLimitData":"0","height":"66","width":"66","photo_height":"160","photo_width":"250","limit_data":"6","title":"Online Users","nomobile":"0","name":"sesmember.list-online"}'), array('content_id =?' => $infoContentId));
  }

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'params' => '{"viewType":"thumbView","imageType":"square","order":"","criteria":"5","info":"most_viewed","showLimitData":"1","show_star":"0","show_criteria":"","grid_title_truncation":"45","list_title_truncation":"45","height":"66","width":"66","photo_height":"160","photo_width":"250","limit_data":"12","title":"Popular Members","nomobile":"0","name":"sesmember.featured-sponsored"}',
    'order' => 0,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.popular-compliment-members',
    'page_id' => $page_id,
    'parent_content_id' => $middleContainerId,
    'params' => '{"viewType":"thumbView","imageType":"square","order":"","criteria":"5","compliment":"3","showLimitData":"1","show_star":"0","show_criteria":["title"],"grid_title_truncation":"45","list_title_truncation":"45","height":"161","width":"161","photo_height":"160","photo_width":"250","limit_data":"4","title":"Most Cool Members","nomobile":"0","name":"sesmember.popular-compliment-members"}',
    'order' => 0,
  ));
}
//Birthday Default Installation
$birthdayContent = '<table style="background: #C2C2C2; padding: 20px; width: 100%; height: 100vh;" cellspacing="0" cellpadding="0"><tbody><tr><td><table style="width: 625px; margin: 0 auto;"><tbody><tr><td style="font-family: Arial, Helvetica, sans-serif;"><div style="background-image: url(\'/application/modules/Sesmember/externals/images/Balloon_Birthday.jpg\'); color: #ff008a; min-height: 466px; position: relative; text-align: center; background-repeat: no-repeat;"><h1 style="font-family: \'Comic Sans MS\', cursive; padding-top: 15%; text-align: center;"><br>Many Many Happy <br> Returns <br> Of The Day<br>[recipient_title]</h1><img style="width: 135px;" src="/application/modules/Sesmember/externals/images/Pink_Birthday.png" alt="" align="center"></div></td></tr></tbody></table></td></tr></tbody></table>';
Engine_Api::_()->getApi('settings', 'core')->setSetting('sesmember.birthday.subject', 'Wish you a very Happy Birthday!');
Engine_Api::_()->getApi('settings', 'core')->setSetting('sesmember.birthday.content', $birthdayContent);
Engine_Api::_()->getApi('settings', 'core')->setSetting('sesmember.birthday.enable', 1);

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
("sesmember_admin_main_browsememberspage", "sesmember", "Browse Pages for Profile Types", "", \'{"route":"admin_default","module":"sesmember","controller":"manage", "action":"manage-browsepage"}\', "sesmember_admin_main", "", 1, 0, 999);');

$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES ("sesmember_member_likes", "sesmember", \'{item:$subject} has liked your profile.\', 0, "");');

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesmember_main_alphbeticmemberssearch", "sesmember", "Alphabetic Members Search", "", \'{"route":"sesmember_general","action":"alphabetic-members-search"}\', "sesmember_main", "", 880);');

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesmember_admin_main_adminpicks", "sesmember", "Admin Picks Members", "", \'{"route":"admin_default","module":"sesmember","controller":"manage", "action":"admin-picks"}\', "sesmember_admin_main", "", 999),
("sesmember_main_editormembers", "sesmember", "Editor Members", "", \'{"route":"sesmember_general","action":"editormembers"}\', "sesmember_main", "", 999);');

//$db->query('ALTER TABLE `engine4_users` ADD `adminpicks` TINYINT(1) NOT NULL DEFAULT "0", ADD `order` INT(11) NOT NULL DEFAULT "0";');

$db->query('ALTER TABLE `engine4_sesmember_follows` ADD `resource_approved` TINYINT(1) NOT NULL DEFAULT "0" AFTER `creation_date`, ADD `user_approved` TINYINT(1) NOT NULL DEFAULT "0" AFTER `resource_approved`;');

$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`, `default`) VALUES
("sesmember_follow_request", "sesmember", \'{item:$subject} send you follow request.\', "0", "", "1"),
("sesmember_follow_requestaccept", "sesmember", \'{item:$subject} accept your follow request.\', "0", "", "1");');

$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesmember_userinfos` (
	`userinfo_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`follow_count` INT(11) NOT NULL DEFAULT "0",
	`location` VARCHAR(512) NOT NULL,
	`rating` float NOT NULL DEFAULT "0",
	`user_verified` TINYINT(1) NOT NULL DEFAULT "0",
	`cool_count` INT( 11 ) NOT NULL DEFAULT "0",
	`funny_count` INT( 11 ) NOT NULL DEFAULT "0",
	`useful_count` INT( 11 ) NOT NULL DEFAULT "0",
	`featured` TINYINT( 1 ) NOT NULL DEFAULT "0",
	`sponsored` TINYINT( 1 ) NOT NULL DEFAULT "0",
	`vip` TINYINT( 1 ) NOT NULL DEFAULT "0",
	`offtheday` tinyint(1)	NOT NULL DEFAULT "0",
	`starttime` DATE DEFAULT NULL,
	`endtime` DATE DEFAULT NULL,
	`adminpicks` TINYINT(1) NOT NULL DEFAULT "0",
	`order` INT(11) NOT NULL DEFAULT "0",
	PRIMARY KEY (`userinfo_id`),
	UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
$db->query('INSERT IGNORE INTO `engine4_sesmember_userinfos`(`user_id`) select `user_id` from `engine4_users`;');
