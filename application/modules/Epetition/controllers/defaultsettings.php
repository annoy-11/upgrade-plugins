<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: defaultsettings.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


$db = Zend_Db_Table_Abstract::getDefaultAdapter();

// //Petitions Welcome Page
// $page_id = $db->select()
//   ->from('engine4_core_pages', 'page_id')
//   ->where('name = ?', 'epetition_index_welcome')
//   ->limit(1)
//   ->query()
//   ->fetchColumn();
// if (!$page_id) {
//   $widgetOrder = 1;
//   $db->insert('engine4_core_pages', array(
//     'name' => 'epetition_index_welcome',
//     'displayname' => 'SNS- Petition - Petitions Welcome Page',
//     'title' => 'Petition Welcome Page',
//     'description' => 'This page is the petition welcome page.',
//     'custom' => 0,
//   ));
//   $page_id = $db->lastInsertId();
// 
//   // Insert top
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'top',
//     'page_id' => $page_id,
//     'order' => 1,
//   ));
//   $top_id = $db->lastInsertId();
// 
//   // Insert main
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'main',
//     'page_id' => $page_id,
//     'order' => 2,
//   ));
//   $main_id = $db->lastInsertId();
// 
//   // Insert top-middle
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'middle',
//     'page_id' => $page_id,
//     'parent_content_id' => $top_id,
//   ));
//   $top_middle_id = $db->lastInsertId();
// 
//   // Insert main-middle
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'middle',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 2,
//   ));
//   $main_middle_id = $db->lastInsertId();
// 
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'sesbasic.simple-html-block',
//     'parent_content_id' => $top_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"bodysimple":"<div class=\"epetition_welcome_text_block_wrapper sesbasic_bxs sesbasic_clearfix\">\r\n\t<div class=\"epetition_welcome_text_block\">\r\n  \t<h2 class=\"epetition_welcome_text_block_maintxt\">SHARE YOUR  IDEAS & STORIES  WITH THE WORLD<\/h2>\r\n    <div class=\"epetition_welcome_text_block_buttons sesbasic_clearfix\">\r\n    \t<a href=\"javascript:void(0);\" onclick=\"changeEpetitionManifestUrl(\'home\');\"class=\"epetition_landing_link sesbasic_link_btn sesbasic_animation\">Explore Popular Petitions<\/a>\r\n      <a href=\"javascript:void(0);\" onclick=\"changeEpetitionManifestUrl(\'create\');\" class=\"epetition_landing_link sesbasic_link_btn sesbasic_animation\">Create Your Unique Petition<\/a>\r\n      <a href=\"javascript:void(0);\" onclick=\"changeEpetitionManifestUrl(\'categories\');\" class=\"epetition_landing_link sesbasic_link_btn\">Explore By Category<\/a>\r\n    <\/div>\r\n<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 6px;width: 1200px; margin-left: 50px;\">\r\n<\/div>\r\n<div style=\"font-size: 24px;margin-bottom: 30px;  margin-top: 25px;text-align: center;\">Read our Sponsored Petitions!<\/div>\r\n  <\/div>\r\n<\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'epetition.featured-sponsored-verified-category-carousel',
//     'parent_content_id' => $top_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"carousel_type":"1","slidesToShow":"4","category":"0","criteria":"2","order":"","info":"most_liked","isfullwidth":"1","autoplay":"1","speed":"2000","show_criteria":["title","favouriteButton","likeButton","category","socialSharing"],"title_truncation":"35","height":"350","width":"400","limit_data":"10","title":"","nomobile":"0","name":"epetition.featured-sponsored-verified-category-carousel"}',
//   ));
// 
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'sesbasic.simple-html-block',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"bodysimple":"<div style=\"font-size: 34px;margin-bottom: 50px;margin-top:50px;text-align: center;\">Featured Posts -  Heads up petitions!<\/div>","en_US_bodysimple":"<div style=\"font-size: 34px;margin-bottom: 50px;margin-top:50px;text-align: center;\">Featured Posts -  Heads up petitions!<\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'sesbasic.simple-html-block',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"epetition_landing_link epetition_welcome_btn sesbasic_animation\" href=\"javascript:void(0);\" onclick=\"changeEpetitionManifestUrl(\'browse\');\">Read all Posts\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">Verified Petitions on our Community\r\n<\/span><\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'epetition.tabbed-widget-petition',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"enableTabs":["grid"],"openViewType":"grid","show_criteria":["favouriteButton","location","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","readmore","creationDate","descriptiongrid"],"pagging":"button","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","description_truncation_list":"35","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"280","width_grid":"393","height_list":"230","width_list":"260","width_pinboard":"300","search_type":["verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"epetition.tabbed-widget-petition"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'sesbasic.simple-html-block',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"epetition_landing_link epetition_welcome_btn sesbasic_animation\" href=\"javascript:void(0);\" onclick=\"changeEpetitionManifestUrl(\'locations\');\">Explore All Petitions\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">What do you want to read out?\r\n<\/span><\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'sesbasic.simple-html-block',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"epetition_landing_link epetition_welcome_btn sesbasic_animation\" href=\"javascript:void(0);\" onclick=\"changeEpetitionManifestUrl(\'categories\');\">Browse All Categories\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">Check our Top Petitions!\r\n<\/span><\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'epetition.top-petitions',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"view_type":"horizontal","show_criteria":["count","ownername"],"height":"180","width":"234","showLimitData":"0","limit_data":"5","title":"","nomobile":"0","name":"epetition.top-petitions"}',
//   ));
// }


//Browse Locations Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'epetition_index_locations')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'epetition_index_locations',
    'displayname' => 'SNS- Petitions - Petition Locations',
    'title' => 'Petition Browse Location',
    'description' => 'This page show petition locations.',
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

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"horizontal","search_type":["open","close","onlySPvictory","recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"epetition.browse-search"}',
  ));
  
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.petition-location',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"location":"","lat":"34.0256262","lng":"-118.28504399999997","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","location","likeButton","0","1","socialSharing","like","view","comment","favourite"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","limit_data":"100","location-data":null,"title":"","nomobile":"0","name":"epetition.petition-location"}',
  ));
}


// Petition My Sign
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'epetition_index_mysign')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'epetition_index_mysign',
    'displayname' => 'SNS- Petition - My Signature Page',
    'title' => 'Petition user signature page',
    'description' => 'This page displays the user signature.',
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
    'order' => 6
  ));
  $top_middle_id = $db->lastInsertId();
  // Insert main-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 6
  ));
  $main_middle_id = $db->lastInsertId();
  // Insert main-right
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'right',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 7,
  ));
  $main_right_id = $db->lastInsertId();
  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.petitions-mysignature',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params'=>'{"enableTabs":["list"],"detailsdiplay":["petitiontitle","signaturelocation","statement","reason","category","submissiondate"],"displaystyle":"autoload","countshow":"10","title":"","nomobile":"0","name":"epetition.petitions-mysignature"}',
  ));
}



//Petition Home Page
$select = $db->select()
  ->from('engine4_core_pages')
  ->where('name = ?', 'epetition_index_home')
  ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'epetition_index_home',
    'displayname' => 'SNS- Petition - Petitions Home Page',
    'title' => 'Petition Home',
    'description' => 'This is the petition home page.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId('engine4_core_pages');

  //CONTAINERS
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'container',
    'name' => 'main',
    'parent_content_id' => null,
    'order' => 2,
    'params' => '',
  ));
  $container_id = $db->lastInsertId('engine4_core_content');

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'container',
    'name' => 'middle',
    'parent_content_id' => $container_id,
    'order' => 6,
    'params' => '',
  ));
  $middle_id = $db->lastInsertId('engine4_core_content');

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'container',
    'name' => 'top',
    'parent_content_id' => null,
    'order' => 1,
    'params' => '',
  ));
  $topcontainer_id = $db->lastInsertId('engine4_core_content');

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'container',
    'name' => 'middle',
    'parent_content_id' => $topcontainer_id,
    'order' => 6,
    'params' => '',
  ));
  $topmiddle_id = $db->lastInsertId('engine4_core_content');

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'container',
    'name' => 'right',
    'parent_content_id' => $container_id,
    'order' => 5,
    'params' => '',
  ));
  $right_id = $db->lastInsertId('engine4_core_content');


  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'epetition.browse-menu',
    'parent_content_id' => $topmiddle_id,
    'order' => $widgetOrder++,
  ));
  
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'epetition.featured-sponsored-verified-category-slideshow',
    'parent_content_id' => $topmiddle_id,
    'order' => $widgetOrder++,
    'params'=>'{"category":"0","criteria":"1","order":"","info":"recently_created","autoplay":"1","show_criteria":["like","comment","favourite","view","title","by","favouriteButton","likeButton","description","category","socialSharing","creationDate"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"300","title":"Sponsored Petition Posts","nomobile":"0","name":"epetition.featured-sponsored-verified-category-slideshow"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'epetition.browse-menu-quick',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'epetition.tabbed-widget-petition',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","grid","pinboard","map"],"openViewType":"list","tabOption":"advance","htmlTitle":"1","category_id":"","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","location","likeButton","socialSharing","like","favourite","signatureLable","comment","view","title","category","by","imageLabel","creationDate","descriptionlist","descriptiongrid","descriptionpinboard","enableCommentPinboard"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_pinviewplusicon":"1","socialshare_icon_pinviewlimit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","pagging":"button","title_truncation_grid":"40","title_truncation_list":"50","title_truncation_pinboard":"30","limit_data_pinboard":"12","limit_data_list":"6","limit_data_grid":"15","description_truncation_list":"150","description_truncation_grid":"150","description_truncation_pinboard":"150","height_grid":"200","width_grid":"420","height_list":"255","width_list":"350","width_pinboard":"420","search_type":["recentlySPcreated","mostSPliked","mostSPrated","mostSPfavourite","featured","sponsored","verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"epetition.tabbed-widget-petition"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'epetition.of-the-day',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid1","fixHover":"fix","show_criteria":["title","like","view","comment","favourite","rating","ratingStar","by","favouriteButton","likeButton","featuredLabel","verifiedLabel","socialSharing"],"title_truncation":"20","description_truncation":"60","height":"180","width":"180","title":"Petition of the Day","nomobile":"0","name":"epetition.of-the-day"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'epetition.tag-cloud-category',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#00f","showType":"simple","text_height":"15","height":"300","itemCountPerPage":"12","title":"Categories","nomobile":"0","name":"epetition.tag-cloud-category"}',
  ));
  
    $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'epetition.featured-sponsored',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","criteria":"5","order":"","info":"most_viewed","show_criteria":["like","view","title","category","socialSharing","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"1","title_truncation":"15","height":"200","width":"200","limit_data":"3","title":"Most Read Petitions","nomobile":"0","name":"epetition.featured-sponsored"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'epetition.tag-cloud-petitions',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#00f","type":"cloud","text_height":"15","height":"170","itemCountPerPage":"20","title":"Popular Tags","nomobile":"0","name":"epetition.tag-cloud-petitions"}',
  ));
}

//Petition Browse Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'epetition_index_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
// insert if it doesn't exist yet
if (!$page_id) {
  $widgetOrder = 1;
 $db->insert('engine4_core_pages', array(
    'name' => 'epetition_index_browse',
    'displayname' => 'SNS- Petition - Browse Petitions Page',
    'title' => 'Petition Browse',
    'description' => 'This page lists petition entries.',
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

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.category-carousel',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title_truncation_grid":"45","description_truncation_grid":"45","height":"250","autoplay":"1","speed":"1000","criteria":"alphabetical","show_criteria":["title","description","countPetitions","socialshare"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","isfullwidth":"0","limit_data":"12","title":"Categories","nomobile":"0","name":"epetition.category-carousel"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"epetition.browse-search"}',
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.browse-petitions',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","grid","map"],"openViewType":"grid","show_criteria":["imageLabel","signatureLable","verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","view","title","category","by","readmore","descriptionlist","descriptiongrid","descriptionpinboard","enableCommentPinboard"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_pinviewplusicon":"1","socialshare_icon_pinviewlimit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","category":"0","sort":"mostSPfavourite","show_item_count":"1","title_truncation":"45","grid_title_truncation":"30","description_truncation_list":"100","description_truncation_grid":"100","height_list":"250","width_list":"461","height_grid":"300","width_grid":"375","limit_data_pinboard":"12","limit_data_grid":"12","limit_data_list":"12","pagging":"button","title":"","nomobile":"0","name":"epetition.browse-petitions"}',
  ));
  
}

//Manage Petitions Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'epetition_index_manage')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'epetition_index_manage',
    'displayname' => 'SNS- Petition - Manage Petitions Page',
    'title' => 'My Petition Entries',
    'description' => 'This page lists a user\'s petition entries.',
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
  $main_right_id = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.manage-petitions',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' =>'{"enableTabs":["list"],"openViewType":"list","tabOption":"vertical","htmlTitle":"1","category_id":"","show_criteria":["location","likeButton","socialSharing","like","favourite","signatureLable","view","title","category","by","imageLabel","descriptionlist"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_pinviewplusicon":"1","socialshare_icon_pinviewlimit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","pagging":"button","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","description_truncation_list":"45","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"270","width_grid":"389","height_list":"230","width_list":"260","width_pinboard":"300","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","featured","sponsored","verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"epetition.manage-petitions"}',
  ));
}

//Browse Tags Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'epetition_index_tags')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'epetition_index_tags',
    'displayname' => 'SNS- Petition - Browse Tags Page',
    'title' => 'Petition Browse Tags Page',
    'description' => 'This page displays the petition tags.',
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
    'order' => 6
  ));
  $top_middle_id = $db->lastInsertId();
  // Insert main-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 6
  ));
  $main_middle_id = $db->lastInsertId();
  // Insert main-right
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'right',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 7,
  ));
  $main_right_id = $db->lastInsertId();
  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.tag-petitions',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params'=>'{"title":"","name":"epetition.tag-petitions"}'
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.browse-menu-quick',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params'=>''
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.of-the-day',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params'=>''
  ));
}


//Browse Categories Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'epetition_category_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {

  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'epetition_category_browse',
    'displayname' => 'SNS- Petition - Browse Categories Page',
    'title' => 'Petition Browse Category',
    'description' => 'This page lists petition categories.',
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
    'order' => 3,
  ));
  $main_right_id = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.petition-category-icons',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"titleC":"Popular Categories","height":"150","width":"180","alignContent":"center","criteria":"most_petition","show_criteria":["title","countPetitions","icon"],"limit_data":"12","title":"","nomobile":"0","name":"epetition.petition-category-icons"}'
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.category-associate-petition',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","view","title","favourite","victoryLabelActive","readmore"],"popularity_petition":"like_count","pagging":"button","count_petition":"1","criteria":"most_petition","category_limit":"5","petition_limit":"5","petition_description_truncation":"45","seemore_text":"+ See all [category_name]","allignment_seeall":"left","height_list":"230","width_list":"260","title":"","nomobile":"0","name":"epetition.category-associate-petition"}'
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.tag-cloud-petitions',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#00f","type":"cloud","text_height":"15","height":"200","itemCountPerPage":"21","title":"Trending Tags","nomobile":"0","name":"epetition.tag-cloud-petitions"}'
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"recently_created","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","likeButton","favouriteButton"],"show_star":"0","showLimitData":"1","title_truncation":"20","description_truncation":"60","height":"50","width":"50","limit_data":"3","title":"Recent Posts","nomobile":"0","name":"epetition.featured-sponsored"}'
  ));
}


//Category View Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'epetition_category_index')
  ->limit(1)
  ->query()
  ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'epetition_category_index',
    'displayname' => 'SNS- Petition - Petition Category View Page',
    'title' => 'Petition Category View Page',
    'description' => 'This page lists petition category view page.',
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

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.category-view',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid","show_banner":"1","show_subcat":"1","show_subcatcriteria":["icon","title","countPetition"],"heightSubcat":"160","widthSubcat":"290","textPetition":"Petitions we like","show_criteria":["featuredLabel","sponsoredLabel","like","comment","favourite","view","title","by","description","readmore","creationDate"],"pagging":"button","description_truncation":"150","petition_limit":"12","height":"200","width":"294","title":"","nomobile":"0","name":"epetition.category-view"}'
  ));
}

//Petition Create Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'epetition_index_create')
  ->limit(1)
  ->query()
  ->fetchColumn();

if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'epetition_index_create',
    'displayname' => 'SNS- Petition - Petition Create Page',
    'title' => 'Create Petition',
    'description' => 'This page is the petition create page.',
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

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.content',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Petition Profile Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'epetition_index_view')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'epetition_index_view',
    'displayname' => 'SNS- Petition - Petition Profile Page',
    'title' => 'Petition View',
    'description' => 'This page displays a petition entry.',
    'provides' => 'subject=epetition',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
  ));
  $main_id = $db->lastInsertId();

  // Insert middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 3,
  ));
  $middle_id = $db->lastInsertId();

  // Insert right
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'right',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $right_id = $db->lastInsertId();

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.view-petition',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params'=>'{"show_criteria":["title","shortDescription","socialShare","likeButton","favouriteButton","view","favourite","like","comment"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title":"","nomobile":"0","name":"epetition.view-petition"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.container-tabs',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"max":6}',
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'epetition.petition-location',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//   ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'epetition.view-about',
      'page_id' => $page_id,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params'=>'{"title":"Overview","titleCount":true,"name":"epetition.view-about"}'
    ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'epetition.view-contact',
      'page_id' => $page_id,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params'=>'{"title":"Contact Details","search_type":["contactname","contactemail","contactphonenumber","contactfacebook","contactlinkedin","contacttwitter","contactwebsite"],"nomobile":"0","name":"epetition.view-contact"}',
    ));

      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'epetition.view-letter',
          'page_id' => $page_id,
          'parent_content_id' => $tab_id,
          'order' => $widgetOrder++,
          'params'=>'{"title":"Letter","name":"epetition.view-letter"}',
        ));
        
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'epetition.view-decisionmaker',
          'page_id' => $page_id,
          'parent_content_id' => $tab_id,
          'order' => $widgetOrder++,
          'params'=>'{"title":"Decision Maker","titleCount":true,"name":"epetition.view-decisionmaker","itemCountPerPage":""}',
      ));
      
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'epetition.petition-map',
          'page_id' => $page_id,
          'parent_content_id' => $tab_id,
          'order' => $widgetOrder++,
          'params'=>'{"title":"Map","titleCount":true,"name":"epetition.petition-map"}',
      ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","name":"core.comments"}',
  ));
/*      $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.related-petitions',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","ratingStar","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"1","height":"180","width":"180","list_title_truncation":"45","limit_data":"3","title":" Sub Petitions","nomobile":"0","name":"epetition.related-petitions"}',
  ));*/

  // Insert gutter
  
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'epetition.view-signatures',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params'=>'{"title":"Signature List","name":"epetition.view-signatures"}',
    ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.labels',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.like-button',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.favourite-button',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.advance-share',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"epetition.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.similar-petitions',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","view","title","by","favouriteButton","likeButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"0","height":"200","width":"294","list_title_truncation":"45","limit_data":"3","title":"Related Petitions","nomobile":"0","name":"epetition.similar-petitions"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.view-signpetition',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","name":"epetition.view-signpetition"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.view-owner',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"ownername":"yes","toppetition":"yes","ownerphoto":"yes","photoviewtype":"circle","aboutuser":"30","title":"Owner","nomobile":"0","name":"epetition.view-owner"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.profile-tags',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.sidebar-info',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"sidebar_info":["petitioncategory","tags","petitionlocation"],"title":"","nomobile":"0","name":"epetition.sidebar-info"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'epetition.petition-statistics',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"statistics_info":["createdby","creationdate","goalreach","approvedby","markedvictory","countpresentsign"],"title":"","nomobile":"0","name":"epetition.petition-statistics"}',
  ));
}

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Epetition_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('epetition', $level->level_id, array_keys($form->getValues()));

  $form->populate($valuesForm);
  if ($form->defattribut)
    $form->defattribut->setValue(0);
  $db = $permissionsTable->getAdapter();
  $db->beginTransaction();
  try {
    if ($level->type != 'public') {
      // Set permissions
      $values['auth_comment'] = (array) $values['auth_comment'];
      $values['auth_view'] = (array) $values['auth_view'];
    }
    $nonBooleanSettings = $form->nonBooleanFields();
    $permissionsTable->setAllowed('epetition', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}

