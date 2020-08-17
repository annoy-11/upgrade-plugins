<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();
//$this->uploadDefaultCategory();
// $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("seslisting_admin_main_importlisting", "seslisting", "Import SE Listing", "", \'{"route":"admin_default","module":"seslisting","controller":"import-listing"}\', "seslisting_admin_main", "", 996);');

// //Listings Welcome Page
// $page_id = $db->select()
//               ->from('engine4_core_pages', 'page_id')
//               ->where('name = ?', 'seslisting_index_welcome')
//               ->limit(1)
//               ->query()
//               ->fetchColumn();
// if (!$page_id) {
//   $widgetOrder = 1;
//   $db->insert('engine4_core_pages', array(
//     'name' => 'seslisting_index_welcome',
//     'displayname' => 'SES - Advanced Listing - Listings Welcome Page',
//     'title' => 'Listing Welcome Page',
//     'description' => 'This page is the listing welcome page.',
//     'custom' => 0,
//   ));
//   $page_id = $db->lastInsertId();

//   // Insert top
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'top',
//     'page_id' => $page_id,
//     'order' => 1,
//   ));
//   $top_id = $db->lastInsertId();

//   // Insert main
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'main',
//     'page_id' => $page_id,
//     'order' => 2,
//   ));
//   $main_id = $db->lastInsertId();

//   // Insert top-middle
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'middle',
//     'page_id' => $page_id,
//     'parent_content_id' => $top_id,
//   ));
//   $top_middle_id = $db->lastInsertId();

//   // Insert main-middle
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'middle',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 2,
//   ));
//   $main_middle_id = $db->lastInsertId();

//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'sesbasic.simple-html-block',
//     'parent_content_id' => $top_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"bodysimple":"<div class=\"seslisting_welcome_text_block_wrapper sesbasic_bxs sesbasic_clearfix\">\r\n\t<div class=\"seslisting_welcome_text_block\">\r\n  \t<h2 class=\"seslisting_welcome_text_block_maintxt\">SHARE YOUR  IDEAS & STORIES  WITH THE WORLD<\/h2>\r\n    <div class=\"seslisting_welcome_text_block_buttons sesbasic_clearfix\">\r\n    \t<a href=\"javascript:void(0);\" onclick=\"changeSeslistingManifestUrl(\'home\');\"class=\"seslisting_landing_link sesbasic_link_btn sesbasic_animation\">Explore Popular Listings<\/a>\r\n      <a href=\"javascript:void(0);\" onclick=\"changeSeslistingManifestUrl(\'create\');\" class=\"seslisting_landing_link sesbasic_link_btn sesbasic_animation\">Create Your Unique Listing<\/a>\r\n      <a href=\"javascript:void(0);\" onclick=\"changeSeslistingManifestUrl(\'categories\');\" class=\"seslisting_landing_link sesbasic_link_btn\">Explore By Category<\/a>\r\n    <\/div>\r\n<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 6px;width: 1200px; margin-left: 50px;\">\r\n<\/div>\r\n<div style=\"font-size: 24px;margin-bottom: 30px;  margin-top: 25px;text-align: center;\">Read our Sponsored Listings!<\/div>\r\n  <\/div>\r\n<\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'seslisting.featured-sponsored-verified-category-carousel',
//     'parent_content_id' => $top_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"carousel_type":"1","slidesToShow":"4","category":"0","criteria":"2","order":"","info":"most_liked","isfullwidth":"1","autoplay":"1","speed":"2000","show_criteria":["title","favouriteButton","likeButton","category","socialSharing"],"title_truncation":"35","height":"350","width":"400","limit_data":"10","title":"","nomobile":"0","name":"seslisting.featured-sponsored-verified-category-carousel"}',
//   ));

//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'sesbasic.simple-html-block',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"bodysimple":"<div style=\"font-size: 34px;margin-bottom: 50px;margin-top:50px;text-align: center;\">Featured Posts -  Heads up listinggers!<\/div>","en_US_bodysimple":"<div style=\"font-size: 34px;margin-bottom: 50px;margin-top:50px;text-align: center;\">Featured Posts -  Heads up listinggers!<\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'seslisting.featured-sponsored-verified-random-listing',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"category":"0","criteria":"1","order":"","show_criteria":["like","comment","favourite","view","title","by","rating","ratingStar","verifiedLabel","favouriteButton","likeButton","category","socialSharing","creationDate"],"title":"","nomobile":"0","name":"seslisting.featured-sponsored-verified-random-listing"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'sesbasic.simple-html-block',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"seslisting_landing_link seslisting_welcome_btn sesbasic_animation\" href=\"javascript:void(0);\" onclick=\"changeSeslistingManifestUrl(\'browse\');\">Read all Posts\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">Verified Listings on our Community\r\n<\/span><\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'seslisting.tabbed-widget-listing',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"enableTabs":["grid"],"openViewType":"grid","show_criteria":["favouriteButton","location","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","readmore","creationDate","descriptiongrid"],"pagging":"button","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","description_truncation_list":"35","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"280","width_grid":"393","height_list":"230","width_list":"260","width_pinboard":"300","search_type":["verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"seslisting.tabbed-widget-listing"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'sesbasic.simple-html-block',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"seslisting_landing_link seslisting_welcome_btn sesbasic_animation\" href=\"javascript:void(0);\" onclick=\"changeSeslistingManifestUrl(\'locations\');\">Explore All Listings\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">What do you want to read out?\r\n<\/span><\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'seslisting.listing-category',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"height":"180","width":"196","limit":"12","video_required":"1","criteria":"admin_order","show_criteria":["title","countListings"],"title":"","nomobile":"0","name":"seslisting.listing-category"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'sesbasic.simple-html-block',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"seslisting_landing_link seslisting_welcome_btn sesbasic_animation\" href=\"javascript:void(0);\" onclick=\"changeSeslistingManifestUrl(\'categories\');\">Browse All Categories\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">Meet our Top Listinggers!\r\n<\/span><\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'seslisting.top-listinggers',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"view_type":"horizontal","show_criteria":["count","ownername"],"height":"180","width":"234","showLimitData":"0","limit_data":"5","title":"","nomobile":"0","name":"seslisting.top-listinggers"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'page_id' => $page_id,
//     'type' => 'widget',
//     'name' => 'sesspectromedia.banner',
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"is_full":"1","is_pattern":"1","banner_image":"public\/admin\/banner_final.jpg","banner_title":"Start by creating your Unique Listing","title_button_color":"FFFFFF","description":"Publish your personal or professional listings at your desired date and time!","description_button_color":"FFFFFF","button1":"1","button1_text":"Get Started","button1_text_color":"0295FF","button1_color":"FFFFFF","button1_mouseover_color":"EEEEEE","button1_link":"listings\/create","button2":"0","button2_text":"Button - 2","button2_text_color":"FFFFFF","button2_color":"0295FF","button2_mouseover_color":"067FDE","button2_link":"","button3":"0","button3_text":"Button - 3","button3_text_color":"FFFFFF","button3_color":"F25B3B","button3_mouseover_color":"EA350F","button3_link":"","height":"400","title":"","nomobile":"0","name":"sesspectromedia.banner"}',
//   ));
// }


//Listing Home Page
$select = $db->select()
            ->from('engine4_core_pages')
            ->where('name = ?', 'seslisting_index_home')
            ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'seslisting_index_home',
    'displayname' => 'SES - Advanced Listing - Listings Home Page',
    'title' => 'Listing Home',
    'description' => 'This is the listing home page.',
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
    'name' => 'seslisting.browse-menu',
    'parent_content_id' => $topmiddle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'seslisting.category-carousel',
    'parent_content_id' => $topmiddle_id,
    'order' => $widgetOrder++,
    'params' => '{"title_truncation_grid":"45","description_truncation_grid":"45","height":"300","width":"388","autoplay":"1","speed":"2000","criteria":"alphabetical","show_criteria":["title","description","countListings","socialshare"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","isfullwidth":"1","limit_data":"12","title":"","nomobile":"0","name":"seslisting.category-carousel"}',
  ));


  // $db->insert('engine4_core_content', array(
  //   'page_id' => $page_id,
  //   'type' => 'widget',
  //   'name' => 'seslisting.featured-sponsored-verified-category-slideshow',
  //   'parent_content_id' => $middle_id,
  //   'order' => $widgetOrder++,
  //   'params' => '{"title_truncation_grid":"45","description_truncation_grid":"45","height":"300","width":"388","autoplay":"1","speed":"2000","criteria":"alphabetical","show_criteria":["title","description","countListings","socialshare"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","isfullwidth":"1","limit_data":"12","title":"","nomobile":"0","name":"seslisting.category-carousel"}',
  // ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'seslisting.tabbed-widget-listing',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","grid"],"openViewType":"list","tabOption":"advance","htmlTitle":"1","category_id":"","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","location","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","readmore","creationDate","descriptionlist","price"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","show_limited_data":"no","pagging":"button","title_truncation_grid":"40","title_truncation_list":"50","limit_data_list":"6","limit_data_grid":"15","description_truncation_list":"190","description_truncation_grid":"160","height_grid":"200","width_grid":"307","height_list":"230","width_list":"350","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","week","month","featured","sponsored","verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"seslisting.tabbed-widget-listing"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'seslisting.of-the-day',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid1","show_criteria":["title","like","view","comment","favourite","rating","ratingStar","by","favouriteButton","likeButton","featuredLabel","verifiedLabel","price","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"20","description_truncation":"60","height":"180","width":"180","title":"Listing of the Day","nomobile":"0","name":"seslisting.of-the-day"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'seslisting.featured-sponsored',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"rounded","criteria":"5","order":"","info":"recently_created","show_criteria":["title","creationDate","category","price"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_star":"0","showLimitData":"1","title_truncation":"20","description_truncation":"60","height":"70","width":"70","limit_data":"4","title":"Recent Listings","nomobile":"0","name":"seslisting.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'seslisting.featured-sponsored',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"most_viewed","show_criteria":["view","title","price"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_star":"1","showLimitData":"1","title_truncation":"15","description_truncation":"60","height":"60","width":"70","limit_data":"3","title":"Most Viewed Listings","nomobile":"0","name":"seslisting.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'seslisting.tag-cloud-category',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#00f","showType":"simple","text_height":"15","height":"300","itemCountPerPage":"12","title":"Categories","nomobile":"0","name":"seslisting.tag-cloud-category"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'seslisting.top-listinggers',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","show_criteria":["count"],"height":"100","width":"210","showLimitData":"1","limit_data":"3","title":"Top Posters","nomobile":"0","name":"seslisting.top-listinggers"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'seslisting.tag-cloud-listings',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#00f","type":"cloud","text_height":"15","height":"170","itemCountPerPage":"20","title":"Popular Tags","nomobile":"0","name":"seslisting.tag-cloud-listings"}',
  ));

}

//Listing Browse Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'seslisting_index_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslisting_index_browse',
    'displayname' => 'SES - Advanced Listing - Browse Listings Page',
    'title' => 'Listing Browse',
    'description' => 'This page lists listing entries.',
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
    'name' => 'seslisting.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  // $db->insert('engine4_core_content', array(
  //   'type' => 'widget',
  //   'name' => 'seslisting.category-carousel',
  //   'page_id' => $page_id,
  //   'parent_content_id' => $top_middle_id,
  //   'order' => $widgetOrder++,
  //   'params' => '{"title_truncation_grid":"45","description_truncation_grid":"45","height":"300","width":"388","autoplay":"1","speed":"2000","criteria":"alphabetical","show_criteria":["title","description","countListings","socialshare"],"isfullwidth":"0","limit_data":"12","title":"Categories","nomobile":"0","name":"seslisting.category-carousel"}',
  // ));

  // Insert search
  // $db->insert('engine4_core_content', array(
  //   'type' => 'widget',
  //   'name' => 'seslisting.alphabet-search',
  //   'page_id' => $page_id,
  //   'parent_content_id' => $top_middle_id,
  //   'order' => $widgetOrder++,
  // ));

  // Insert gutter menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.browse-listings',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","grid"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","ratingStar","rating","view","title","price","category","by","readmore","creationDate","location","descriptionlist"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","category":"0","sort":"recentlySPcreated","show_item_count":"1","title_truncation_list":"100","title_truncation_grid":"50","description_truncation_list":"200","description_truncation_grid":"150","height_list":"222","width_list":"320","height_grid":"200","width_grid":"307","limit_data_grid":"12","limit_data_list":"6","pagging":"button","title":"","nomobile":"0","name":"seslisting.browse-listings"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.browse-menu-quick',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"seslisting.browse-search"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid1","imageType":"rounded","criteria":"6","order":"","info":"recently_created","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","price","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_star":"0","showLimitData":"1","title_truncation":"45","description_truncation":"60","height":"180","width":"180","limit_data":"1","title":"Verified Listings","nomobile":"0","name":"seslisting.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"most_commented","show_criteria":["like","comment","favourite","view","title","price"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_star":"0","showLimitData":"0","title_truncation":"20","description_truncation":"60","height":"60","width":"60","limit_data":"3","title":"Most Commented Listings","nomobile":"0","name":"seslisting.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.tag-cloud-listings',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#4a4444","type":"tab","text_height":"15","height":"170","itemCountPerPage":"20","title":"Popular Tags","nomobile":"0","name":"seslisting.tag-cloud-listings"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.popular-featured-verified-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"info":"most_viewed","imageType":"rounded","showLimitData":"1","show_criteria":["title","like","view","comment","description","by"],"title_truncation":"45","review_description_truncation":"45","limit_data":"3","title":"Most Viewed Reviews","nomobile":"0","name":"seslisting.popular-featured-verified-reviews"}',
  ));
}

//Browse Categories Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seslisting_category_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {

  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'seslisting_category_browse',
      'displayname' => 'SES - Advanced Listing - Browse Categories Page',
      'title' => 'Listing Browse Category',
      'description' => 'This page lists listing categories.',
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
      'name' => 'seslisting.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));
  $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Seslisting' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "category" . DIRECTORY_SEPARATOR;
  if (is_file($PathFile . "banner" . DIRECTORY_SEPARATOR . 'category.jpg')) {
    if (!file_exists(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin')) {
      mkdir(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin', 0777, true);
    }
    copy($PathFile . "banner" . DIRECTORY_SEPARATOR . 'category.jpg', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin/listing-category-banner.jpg');
    $category_banner = 'public/admin/listing-category-banner.jpg';
  } else {
    $category_banner = '';
  }
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seslisting.banner-category',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"description":"Discover top-notch listings, creators, and collections related to your interests, hand-selected by our 100-percent-human curation team.","seslisting_categorycover_photo":"' . $category_banner . '","title":"Categories","nomobile":"0","name":"seslisting.banner-category"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seslisting.listing-category-icons',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"titleC":"Popular Categories","height":"150","width":"180","alignContent":"center","criteria":"admin_order","show_criteria":["title","countListings"],"limit_data":"12","title":"","nomobile":"0","name":"seslisting.listing-category-icons"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seslisting.category-associate-listing',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["like","comment","rating","ratingStar","view","title","favourite","by","featuredLabel","sponsoredLabel","creationDate","readmore"],"popularity_listing":"like_count","pagging":"button","count_listing":"1","criteria":"alphabetical","category_limit":"5","listing_limit":"5","listing_description_truncation":"45","seemore_text":"+ See all [category_name]","allignment_seeall":"left","height":"160","width":"250","title":"","nomobile":"0","name":"seslisting.category-associate-listing"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seslisting.of-the-day',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid2","show_criteria":["title","like","view","comment","favourite","rating","ratingStar","by","favouriteButton","likeButton","featuredLabel","verifiedLabel","price","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"60","height":"180","width":"180","title":"Listing of the Day","nomobile":"0","name":"seslisting.of-the-day"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seslisting.sidebar-tabbed-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":"list","show_criteria":["location","like","favourite","comment","view","title","category","by","creationDate","price"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_limited_data":null,"pagging":"button","title_truncation_grid":"45","title_truncation_list":"20","limit_data_list":"3","limit_data_grid":"10","description_truncation_grid":"45","height_grid":"270","width_grid":"389","height_list":"60","width_list":"60","search_type":["week","month"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"seslisting.sidebar-tabbed-widget"}'
  ));



  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seslisting.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"most_rated","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","price","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_star":"1","showLimitData":"1","title_truncation":"20","description_truncation":"60","height":"50","width":"50","limit_data":"3","title":"Most Rated Listings","nomobile":"0","name":"seslisting.featured-sponsored"}'
  ));


  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seslisting.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","imageType":"rounded","criteria":"5","order":"","info":"most_favourite","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","price","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_star":"0","showLimitData":"0","title_truncation":"20","description_truncation":"60","height":"60","width":"60","limit_data":"3","title":"Most Favourited Listings","nomobile":"0","name":"seslisting.featured-sponsored"}'
  ));

   $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seslisting.tag-cloud-listings',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"color":"#00f","type":"tab","text_height":"15","height":"300","itemCountPerPage":"21","title":"Trending Tags","nomobile":"0","name":"seslisting.tag-cloud-listings"}'
  ));
}

// //Browse Locations Page
// $page_id = $db->select()
//     ->from('engine4_core_pages', 'page_id')
//     ->where('name = ?', 'seslisting_index_locations')
//     ->limit(1)
//     ->query()
//     ->fetchColumn();
// if (!$page_id) {
//   $widgetOrder = 1;
//   $db->insert('engine4_core_pages', array(
//       'name' => 'seslisting_index_locations',
//       'displayname' => 'SES - Advanced Listing - Browse Locations Page',
//       'title' => 'Listing Browse Location',
//       'description' => 'This page show listing locations.',
//       'custom' => 0,
//   ));
//   $page_id = $db->lastInsertId();
//   // Insert top
//   $db->insert('engine4_core_content', array(
//       'type' => 'container',
//       'name' => 'top',
//       'page_id' => $page_id,
//       'order' => 1,
//   ));
//   $top_id = $db->lastInsertId();
//   // Insert main
//   $db->insert('engine4_core_content', array(
//       'type' => 'container',
//       'name' => 'main',
//       'page_id' => $page_id,
//       'order' => 2,
//   ));
//   $main_id = $db->lastInsertId();
//   // Insert top-middle
//   $db->insert('engine4_core_content', array(
//       'type' => 'container',
//       'name' => 'middle',
//       'page_id' => $page_id,
//       'parent_content_id' => $top_id,
//   ));
//   $top_middle_id = $db->lastInsertId();

//   // Insert main-middle
//   $db->insert('engine4_core_content', array(
//       'type' => 'container',
//       'name' => 'middle',
//       'page_id' => $page_id,
//       'parent_content_id' => $main_id,
//       'order' => 2,
//   ));
//   $main_middle_id = $db->lastInsertId();

//   // Insert menu
//   $db->insert('engine4_core_content', array(
//       'type' => 'widget',
//       'name' => 'seslisting.browse-menu',
//       'page_id' => $page_id,
//       'parent_content_id' => $top_middle_id,
//       'order' => $widgetOrder++,
//   ));

//   // Insert content
//   $db->insert('engine4_core_content', array(
//       'type' => 'widget',
//       'name' => 'seslisting.browse-search',
//       'page_id' => $page_id,
//       'parent_content_id' => $top_middle_id,
//       'order' => $widgetOrder++,
//       'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"seslisting.browse-search"}',
//   ));

//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.listing-location',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"location":"World","lat":"56.6465227","lng":"-6.709638499999983","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","location","likeButton","0","1","ratingStar","rating","socialSharing","like","view","comment","favourite"],"location-data":null,"title":"","nomobile":"0","name":"seslisting.listing-location"}',
//   ));
// }

//Browse Reviews Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'seslisting_review_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslisting_review_browse',
    'displayname' => 'SES - Advanced Listing - Browse Reviews Page',
    'title' => 'Listing Browse Reviews',
    'description' => 'This page show listing browse reviews page.',
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
    'name' => 'seslisting.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

 $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.browse-review-search',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","review_title":"1","review_search":"1","view":["mostSPliked","mostSPviewed","mostSPcommented","mostSPrated","verified","featured"],"review_stars":"1","review_recommendation":"1","title":"Review Browse Search","nomobile":"0","name":"seslisting.browse-review-search"}',
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.review-of-the-day',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","like","view","rating","featuredLabel","verifiedLabel","socialSharing","by"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","title":"Review of the Day","nomobile":"0","name":"sesmember.review-of-the-day"}',
  ));



  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.browse-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","likeButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_criteria":"","pagging":"button","limit_data":"9","title":"","nomobile":"0","name":"seslisting.browse-reviews"}',
  ));
}

//Manage Listings Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'seslisting_index_manage')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslisting_index_manage',
    'displayname' => 'SES - Advanced Listing - Manage Listings Page',
    'title' => 'My Listing Entries',
    'description' => 'This page lists a user\'s listing entries.',
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
    'name' => 'seslisting.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.manage-listings',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","grid"],"openViewType":"grid","tabOption":"advance","htmlTitle":"1","category_id":"","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","location","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","readmore","creationDate","descriptionlist","price"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","show_limited_data":"no","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","limit_data_list":"10","limit_data_grid":"10","description_truncation_list":"45","description_truncation_grid":"45","height_grid":"270","width_grid":"306","height_list":"230","width_list":"260","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","week","month","featured","sponsored","verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"seslisting.manage-listings"}'
  ));
}


//New Claims Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'seslisting_index_claim')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslisting_index_claim',
    'displayname' => 'SES - Advanced Listing - New Claims Page',
    'title' => 'Listing Claim',
    'description' => 'This page lists listing entries.',
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
    'name' => 'seslisting.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.claim-listing',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Listing Create Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'seslisting_index_create')
  ->limit(1)
  ->query()
  ->fetchColumn();

if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslisting_index_create',
    'displayname' => 'SES - Advanced Listing - Listing Create Page',
    'title' => 'Write New Listing',
    'description' => 'This page is the listing create page.',
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
    'name' => 'seslisting.browse-menu',
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


//Browse Tags Page
$page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'seslisting_index_tags')
            ->limit(1)
            ->query()
            ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslisting_index_tags',
    'displayname' => 'SES - Advanced Listing - Browse Tags Page',
    'title' => 'Listing Browse Tags Page',
    'description' => 'This page displays the listing tags.',
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
    'name' => 'seslisting.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.tag-listings',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Album View Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'seslisting_album_view')
              ->limit(1)
              ->query()
              ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslisting_album_view',
    'displayname' => 'SES - Advanced Listing - Album View Page',
    'title' => 'Listing Album View',
    'description' => 'This page displays an listing album.',
    'provides' => 'subject=album',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();
  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
    'order' => 2,
  ));
  $main_id = $db->lastInsertId();
  // Insert main-middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 6,
  ));
  $main_middle_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.album-breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.album-view-page',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"masonry","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","by","socialSharing","likeButton","favouriteButton"],"limit_data":"20","pagging":"auto_load","title_truncation":"45","height":"160","width":"140","title":"","nomobile":"0","name":"seslisting.album-view-page"}'
  ));
}

//Photo View Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'seslisting_photo_view')
              ->limit(1)
              ->query()
              ->fetchColumn();
if (!$page_id) {
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslisting_photo_view',
    'displayname' => 'SES - Advanced Listing - Photo View Page',
    'title' => 'Listing Album Photo View',
    'description' => 'This page displays an listing album\'s photo.',
    'provides' => 'subject=seslisting_photo',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
    'order' => 2
  ));
  $main_id = $db->lastInsertId();

  // Insert middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 6,
  ));
  $middle_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.photo-view-page',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => 1,
    'params' => '{"title":"","nomobile":"0","name":"seslisting.photo-view-page"}'
  ));
}


//Browse Claim Requests Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'seslisting_index_claim-requests')
              ->limit(1)
              ->query()
              ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslisting_index_claim-requests',
    'displayname' => 'SES - Advanced Listing - Browse Claim Requests Page',
    'title' => 'Listing Claim Requests',
    'description' => 'This page lists listing claims request entries.',
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
    'name' => 'seslisting.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.claim-requests',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

// //Listing List Page
// $page_id = $db->select()
//   ->from('engine4_core_pages', 'page_id')
//   ->where('name = ?', 'seslisting_index_list')
//   ->limit(1)
//   ->query()
//   ->fetchColumn();

// // insert if it doesn't exist yet
// if( !$page_id ) {
//   $widgetOrder = 1;
//   // Insert page
//   $db->insert('engine4_core_pages', array(
//     'name' => 'seslisting_index_list',
//     'displayname' => 'SES - Advanced Listing - Listing List Page',
//     'title' => 'Listing List',
//     'description' => 'This page lists a member\'s listing entries.',
//     'provides' => 'subject=user',
//     'custom' => 0,
//   ));
//   $page_id = $db->lastInsertId();

//   // Insert main
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'main',
//     'page_id' => $page_id,
//   ));
//   $main_id = $db->lastInsertId();

//   // Insert left
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'left',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 1,
//   ));
//   $left_id = $db->lastInsertId();

//   // Insert middle
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'middle',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 2,
//   ));
//   $middle_id = $db->lastInsertId();

//   // Insert gutter
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.gutter-photo',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.gutter-menu',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));

//   // Insert content
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'core.content',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//   ));
// }

//Listing Profile Page Design 1
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'seslisting_index_view_1')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'seslisting_index_view_1',
    'displayname' => 'SES - Advanced Listing - Listing Profile Page',
    'title' => 'Listing View',
    'description' => 'This page displays a listing entry.',
    'provides' => 'subject=seslisting',
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
    'name' => 'seslisting.breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.view-listing',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","description","photo","socialShare","ownerOptions","postComment","rating","shareButton","smallShareButton","view","like","comment","review","statics"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title":"","nomobile":"0","name":"seslisting.view-listing"}'
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
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.profile-photos',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Photos","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","socialSharing","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"seslisting.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.profile-videos',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","hotLabel","watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","comment","favourite","rating","view","title","category","by","duration","description"],"pagging":"auto_load","title_truncation_list":"45","title_truncation_grid":"45","DescriptionTruncationList":"45","height":"160","width":"140","limit_data":"20","title":"Videos","nomobile":"0","name":"seslisting.profile-videos"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.profile-musicalbums',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"informationAlbum":["featured","sponsored","hot","postedBy","commentCount","viewCount","likeCount","ratingStars","songCount","favourite","share"],"pagging":"auto_load","Height":"180","Width":"180","limit_data":"3","title":"Music Albums","nomobile":"0","name":"seslisting.profile-musicalbums"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.listing-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","likeButton","socialSharing"],"pagging":"button","limit_data":"5","title":"Reviews","nomobile":"0","name":"seslisting.listing-reviews"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","name":"core.comments"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.related-listings',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","ratingStar","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"1","height":"180","width":"180","list_title_truncation":"45","limit_data":"3","title":" Sub Listings","nomobile":"0","name":"seslisting.related-listings"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.css-listing',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '["[]"]',
  ));

  // Insert gutter
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"photoviewtype":"circle","user_description_limit":"150","title":"","nomobile":"0","name":"seslisting.gutter-photo"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.labels',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.like-button',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.favourite-button',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.advance-share',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"seslisting.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.similar-listings',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","by","favouriteButton","likeButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"0","height":"200","width":"294","list_title_truncation":"45","limit_data":"3","title":"Related Listings","nomobile":"0","name":"seslisting.similar-listings"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.sidebar-tabbed-widget',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":"list","show_criteria":["title","category","by"],"show_limited_data":"yes","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","limit_data_list":"5","limit_data_grid":"10","description_truncation_grid":"45","height_grid":"270","width_grid":"389","height_list":"60","width_list":"60","search_type":["recentlySPcreated","mostSPviewed"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recent Listings","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Popular Listings","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"seslisting.sidebar-tabbed-widget"}',
  ));

 }



// //Listing Profile Page Design 2
// $page_id = $db->select()
//   ->from('engine4_core_pages', 'page_id')
//   ->where('name = ?', 'seslisting_index_view_2')
//   ->limit(1)
//   ->query()
//   ->fetchColumn();

// // insert if it doesn't exist yet
// if( !$page_id ) {
//   $widgetOrder = 1;
//   // Insert page
//   $db->insert('engine4_core_pages', array(
//     'name' => 'seslisting_index_view_2',
//     'displayname' => 'SES - Advanced Listing - Listing Profile Page Design 2',
//     'title' => 'Listing View',
//     'description' => 'This page displays a listing entry.',
//     'provides' => 'subject=seslisting',
//     'custom' => 0,
//   ));
//   $page_id = $db->lastInsertId();

//   // Insert main
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'main',
//     'page_id' => $page_id,
//   ));
//   $main_id = $db->lastInsertId();

//   // Insert left
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'left',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 1,
//   ));
//   $left_id = $db->lastInsertId();

//   // Insert middle
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'middle',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 2,
//   ));
//   $middle_id = $db->lastInsertId();

//   // Insert gutter
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.gutter-photo',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.gutter-menu',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.like-button',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.advance-share',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//     'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"seslisting.advance-share"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.favourite-button',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.profile-tags',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//     'params' => '{"itemCountPerPage":"30","title":"Tags","nomobile":"0","name":"seslisting.profile-tags"}',
//   ));

//   // Insert content
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.view-listing',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.listing-reviews',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","likeButton","socialSharing"],"pagging":"auto_load","limit_data":"5","title":"Listing Profile - Reviews","nomobile":"0","name":"seslisting.listing-reviews"}',
//   ));

//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'core.container-tabs',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//   ));
//   $tab_id = $db->lastInsertId('engine4_core_content');
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.similar-listings',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//     'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"1","height":"207","width":"307","list_title_truncation":"45","limit_data":"3","title":"Listings","nomobile":"0","name":"seslisting.similar-listings"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.profile-musicalbums',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//     'params' => '{"informationAlbum":["featured","sponsored","hot","postedBy","commentCount","viewCount","likeCount","ratingStars","songCount","favourite","share"],"pagging":"auto_load","Height":"180","Width":"180","limit_data":"3","title":"Music Albums","nomobile":"0","name":"seslisting.profile-musicalbums"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.profile-videos',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//     'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","hotLabel","watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","comment","favourite","rating","view","title","category","by","duration","description"],"pagging":"auto_load","title_truncation_list":"45","title_truncation_grid":"45","DescriptionTruncationList":"45","height":"160","width":"140","limit_data":"20","title":"Videos","nomobile":"0","name":"seslisting.profile-videos"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.profile-photos',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":null,"insideOutside":"outside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","by","socialSharing","photoCount","likeButton","favouriteButton"],"title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"seslisting.profile-photos"}',
//   ));

//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'core.comments',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//   ));
// }


// //Listing Profile Page Design 3
// $page_id = $db->select()
//   ->from('engine4_core_pages', 'page_id')
//   ->where('name = ?', 'seslisting_index_view_3')
//   ->limit(1)
//   ->query()
//   ->fetchColumn();

// // insert if it doesn't exist yet
// if( !$page_id ) {
//   $widgetOrder = 1;
//   // Insert page
//   $db->insert('engine4_core_pages', array(
//     'name' => 'seslisting_index_view_3',
//     'displayname' => 'SES - Advanced Listing - Listing Profile Page Design 3',
//     'title' => 'Listing View',
//     'description' => 'This page displays a listing entry.',
//     'provides' => 'subject=seslisting',
//     'custom' => 0,
//   ));
//   $page_id = $db->lastInsertId();

//   // Insert main
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'main',
//     'page_id' => $page_id,
//   ));
//   $main_id = $db->lastInsertId();

//   // Insert left
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'left',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 1,
//   ));
//   $left_id = $db->lastInsertId();

//   // Insert middle
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'middle',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 2,
//   ));
//   $middle_id = $db->lastInsertId();

//   // Insert gutter
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.gutter-photo',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.gutter-menu',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.like-button',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.advance-share',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//     'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"seslisting.advance-share"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.favourite-button',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.profile-tags',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//     'params' => '{"itemCountPerPage":"30","title":"Tags","nomobile":"0","name":"seslisting.profile-tags"}',
//   ));

//   // Insert content
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.view-listing',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.profile-musicalbums',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"informationAlbum":["featured","sponsored","hot","postedBy","commentCount","viewCount","likeCount","ratingStars","songCount","favourite","share"],"pagging":"auto_load","Height":"180","Width":"180","limit_data":"3","title":"Music Albums","nomobile":"0","name":"seslisting.profile-musicalbums"}',
//   ));

//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'core.container-tabs',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//   ));
//   $tab_id = $db->lastInsertId('engine4_core_content');
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.profile-photos',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//     'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","by","socialSharing","photoCount","likeButton","favouriteButton"],"title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"seslisting.profile-photos"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.listing-reviews',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//     'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","likeButton","socialSharing"],"pagging":"auto_load","limit_data":"5","title":"Reviews","nomobile":"0","name":"seslisting.listing-reviews"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.related-listings',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.profile-videos',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//     'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","hotLabel","watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","comment","favourite","rating","view","title","category","by","duration","description"],"pagging":"auto_load","title_truncation_list":"45","title_truncation_grid":"45","DescriptionTruncationList":"45","height":"160","width":"140","limit_data":"20","title":"Videos","nomobile":"0","name":"seslisting.profile-videos"}',
//   ));

//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.similar-listings',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"0","height":"200","width":"307","list_title_truncation":"45","limit_data":"3","title":"Similar Listings","nomobile":"0","name":"seslisting.similar-listings"}',
//   ));

//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'core.comments',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//   ));
// }


//Listing Profile Page Design 4
// $page_id = $db->select()
//   ->from('engine4_core_pages', 'page_id')
//   ->where('name = ?', 'seslisting_index_view_4')
//   ->limit(1)
//   ->query()
//   ->fetchColumn();

// // insert if it doesn't exist yet
// if( !$page_id ) {
//   $widgetOrder = 1;
//   // Insert page
//   $db->insert('engine4_core_pages', array(
//     'name' => 'seslisting_index_view_4',
//     'displayname' => 'SES - Advanced Listing - Listing Profile Page Design 4',
//     'title' => 'Listing View',
//     'description' => 'This page displays a listing entry.',
//     'provides' => 'subject=seslisting',
//     'custom' => 0,
//   ));
//   $page_id = $db->lastInsertId();

//   // Insert main
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'main',
//     'page_id' => $page_id,
//   ));
//   $main_id = $db->lastInsertId();

//   // Insert left
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'left',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 1,
//   ));
//   $left_id = $db->lastInsertId();

//   // Insert middle
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'middle',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 2,
//   ));
//   $middle_id = $db->lastInsertId();

//   // Insert gutter
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.gutter-photo',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.like-button',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.favourite-button',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.advance-share',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//     'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"seslisting.advance-share"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.gutter-menu',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.profile-tags',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//     'params' => '{"itemCountPerPage":"30","title":"Tags","nomobile":"0","name":"seslisting.profile-tags"}',
//   ));

//   // Insert content
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.view-listing',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.similar-listings',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"0","height":"200","width":"307","list_title_truncation":"45","limit_data":"3","title":"Similar Listings","nomobile":"0","name":"seslisting.similar-listings"}',
//   ));

//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'core.container-tabs',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"max":6}',
//   ));
//   $tab_id = $db->lastInsertId('engine4_core_content');
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.profile-photos',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//     'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","by","socialSharing","photoCount","likeButton","favouriteButton"],"title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"seslisting.profile-photos"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.listing-reviews',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//     'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","likeButton","socialSharing"],"pagging":"auto_load","limit_data":"5","title":"Listing Profile - Reviews","nomobile":"0","name":"seslisting.listing-reviews"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.review-profile',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.profile-videos',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//     'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","hotLabel","watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","comment","favourite","rating","view","title","category","by","duration","description"],"pagging":"auto_load","title_truncation_list":"45","title_truncation_grid":"45","DescriptionTruncationList":"45","height":"160","width":"140","limit_data":"20","title":"Videos","nomobile":"0","name":"seslisting.profile-videos"}',
//   ));

//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.related-listings',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//     'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"0","height":"200","width":"307","list_title_truncation":"45","limit_data":"3","title":"Similar Listings","nomobile":"0","name":"seslisting.similar-listings"}',
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'seslisting.profile-musicalbums',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => $widgetOrder++,
//     'params' => '{"informationAlbum":["featured","sponsored","hot","postedBy","commentCount","viewCount","likeCount","ratingStars","songCount","favourite","share"],"pagging":"auto_load","Height":"180","Width":"180","limit_data":"3","title":"Music","nomobile":"0","name":"seslisting.profile-musicalbums"}',
//   ));

//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'core.comments',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"title":"","name":"core.comments"}',
//   ));
// }

//Review Profile Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seslisting_review_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'seslisting_review_view',
      'displayname' => 'SES - Advanced Listing - Review Profile Page',
      'title' => 'Listing Review View',
      'description' => 'This page displays a listing review entry.',
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

  // Insert left
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'left',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $left_id = $db->lastInsertId();

  // Insert middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $middle_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.review-owner-photo',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","showTitle":"1","nomobile":"0","name":"seslisting.review-owner-photo"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.review-profile-options',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"vertical","title":"","nomobile":"0","name":"seslisting.review-profile-options"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.review-breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'seslisting.review-profile',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","pros","cons","description","recommended","postedin","creationDate","parameter","rating","customfields","likeButton","socialSharing","share"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title":"","nomobile":"0","name":"seslisting.review-profile"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Comments"}',
  ));
}

//Category View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seslisting_category_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'seslisting_category_index',
      'displayname' => 'SES - Advanced Listing - Listing Category View Page',
      'title' => 'Listing Category View Page',
      'description' => 'This page lists listing category view page.',
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
      'name' => 'seslisting.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seslisting.category-view',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid","show_subcat":"1","show_subcatcriteria":["icon","title","countListing"],"heightSubcat":"160","widthSubcat":"290","textListing":"Listings we like","show_criteria":["featuredLabel","sponsoredLabel","like","comment","rating","ratingStar","favourite","view","title","by","description","readmore","creationDate"],"pagging":"button","description_truncation":"150","listing_limit":"12","height":"200","width":"294","title":"","nomobile":"0","name":"seslisting.category-view"}'
  ));
}

$listing_table_exist = $db->query('SHOW TABLES LIKE \'engine4_seslisting_listings\'')->fetch();
if (!empty($listing_table_exist)) {
  $selisting_id = $db->query('SHOW COLUMNS FROM engine4_seslisting_listings LIKE \'selisting_id\'')->fetch();
  if (empty($selisting_id)) {
    $db->query('ALTER TABLE `engine4_seslisting_listings` ADD `selisting_id` INT(11) NOT NULL DEFAULT "0";');
  }
}

$listingcat_table_exist = $db->query('SHOW TABLES LIKE \'engine4_seslisting_categories\'')->fetch();
if (!empty($listingcat_table_exist)) {
  $selisting_cayegoryid = $db->query('SHOW COLUMNS FROM engine4_seslisting_categories LIKE \'selisting_categoryid\'')->fetch();
  if (empty($selisting_cayegoryid)) {
    $db->query('ALTER TABLE `engine4_seslisting_categories` ADD `selisting_categoryid` INT(11) NULL;');
  }
}

$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'seslisting_link_listing';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'seslisting_link_event';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'seslisting_reject_listing_request';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'seslisting_reject_event_request';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesuser_claimadmin_listing';");


//Action Type Change for Apps
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'seslisting_like' WHERE `engine4_activity_actiontypes`.`type` = 'seslisting_like_listing';");
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'seslisting_album_like' WHERE `engine4_activity_actiontypes`.`type` = 'seslisting_like_listingalbum';");
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'seslisting_photo_like' WHERE `engine4_activity_actiontypes`.`type` = 'seslisting_like_listingphoto';");
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'seslisting_favourite' WHERE `engine4_activity_actiontypes`.`type` = 'seslisting_favourite_listing';");

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    "seslisting" as `type`,
    "listing_approve" as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');

$table_exist = $db->query("SHOW TABLES LIKE 'engine4_seslisting_categories'")->fetch();
if (!empty($table_exist)) {
    $member_levels = $db->query("SHOW COLUMNS FROM engine4_seslisting_categories LIKE 'member_levels'")->fetch();
    if (empty($member_levels)) {
        $db->query('ALTER TABLE `engine4_seslisting_categories` ADD `member_levels` VARCHAR(255) NULL DEFAULT NULL;');
    }
}
$db->query('UPDATE `engine4_seslisting_categories` SET `member_levels` = "1,2,3,4" WHERE `engine4_seslisting_categories`.`subcat_id` = 0 and  `engine4_seslisting_categories`.`subsubcat_id` = 0;');


$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("seslisting_admin_main_integrateothermodule", "seslisting", "Integrate Plugins", "", \'{"route":"admin_default","module":"seslisting","controller":"integrateothermodule","action":"index"}\', "seslisting_admin_main", "", 995);');

$db->query('DROP TABLE IF EXISTS `engine4_seslisting_integrateothermodules`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_seslisting_integrateothermodules` (
  `integrateothermodule_id` int(11) unsigned NOT NULL auto_increment,
  `module_name` varchar(64) NOT NULL,
  `content_type` varchar(64) NOT NULL,
  `content_url` varchar(255) NOT NULL,
  `content_id` varchar(64) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`integrateothermodule_id`),
  UNIQUE KEY `content_type` (`content_type`,`content_id`),
  KEY `module_name` (`module_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');


// $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
// SELECT
// level_id as `level_id`,
// "seslisting" as `type`,
// "cotinuereading" as `name`,
// 1 as `value`,
// NULL as `params`
// FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');

// $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
// SELECT
// level_id as `level_id`,
// "seslisting" as `type`,
// "cotinuereading" as `name`,
// 1 as `value`,
// NULL as `params`
// FROM `engine4_authorization_levels` WHERE `type` IN("user");');

// $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
// SELECT
// level_id as `level_id`,
// "seslisting" as `type`,
// "cntrdng_dflt" as `name`,
// 1 as `value`,
// NULL as `params`
// FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');

// $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
// SELECT
// level_id as `level_id`,
// "seslisting" as `type`,
// "cntrdng_dflt" as `name`,
// 1 as `value`,
// NULL as `params`
// FROM `engine4_authorization_levels` WHERE `type` IN("user");');

$table_exist = $db->query("SHOW TABLES LIKE 'engine4_seslisting_listings'")->fetch();
if (!empty($table_exist)) {
    $resource_type = $db->query("SHOW COLUMNS FROM engine4_seslisting_listings LIKE 'resource_type'")->fetch();
    if (empty($resource_type)) {
        $db->query('ALTER TABLE `engine4_seslisting_listings` ADD `resource_type` VARCHAR(128) NULL;');
    }
    $resource_id = $db->query("SHOW COLUMNS FROM engine4_seslisting_listings LIKE 'resource_id'")->fetch();
    if (empty($resource_id)) {
        $db->query('ALTER TABLE `engine4_seslisting_listings` ADD `resource_id` INT(11) NOT NULL DEFAULT "0";');
    }
    $networks = $db->query("SHOW COLUMNS FROM engine4_seslisting_listings LIKE 'networks'")->fetch();
    if (empty($networks)) {
        $db->query('ALTER TABLE `engine4_seslisting_listings` ADD `networks` VARCHAR(255) NULL');
    }
    $levels = $db->query("SHOW COLUMNS FROM engine4_seslisting_listings LIKE 'levels'")->fetch();
    if (empty($levels)) {
        $db->query('ALTER TABLE `engine4_seslisting_listings` ADD `levels` VARCHAR(255) NULL');
    }
    $cotinuereading = $db->query("SHOW COLUMNS FROM engine4_seslisting_listings LIKE 'cotinuereading'")->fetch();
    if (empty($cotinuereading)) {
        $db->query('ALTER TABLE `engine4_seslisting_listings` ADD `cotinuereading` TINYINT(1) NOT NULL DEFAULT \'0\';');
    }

    $continue_height = $db->query("SHOW COLUMNS FROM engine4_seslisting_listings LIKE 'continue_height'")->fetch();
    if(empty($continue_height)) {
        $db->query('ALTER TABLE `engine4_seslisting_listings` ADD `continue_height` INT(11) NOT NULL DEFAULT "0";');
    }
}

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    "seslisting" as `type`,
    "allow_levels" as `name`,
    0 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    "seslisting" as `type`,
    "allow_network" as `name`,
    0 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');

$db->query('DELETE FROM `engine4_core_settings` WHERE `engine4_core_settings`.`name` = "seslisting.chooselayout";');

// $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
//   SELECT
//     level_id as `level_id`,
//     "seslisting" as `type`,
//     "continue_height" as `name`,
//     3 as `value`,
//     0 as `params`
//   FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');

// $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
//   SELECT
//     level_id as `level_id`,
//     "seslisting" as `type`,
//     "continue_height" as `name`,
//     3 as `value`,
//     0 as `params`
//   FROM `engine4_authorization_levels` WHERE `type` IN("user");');
