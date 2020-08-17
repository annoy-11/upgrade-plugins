<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Crowdfundings Welcome Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sescrowdfunding_index_welcome')
              ->limit(1)
              ->query()
              ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_welcome',
    'displayname' => 'SES - Crowdfunding - Crowdfunding Welcome Page',
    'title' => 'Crowdfunding Welcome Page',
    'description' => 'This page is the crowdfunding welcome page.',
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

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.welcome-banner',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.feature-block',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.who-we-are',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.parallax-banner',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.carousel',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"slidesToShow":"3","category":"0","criteria":"0","order":"","info":"recently_created","autoplay":"1","speed":"3000","show_criteria":["like","comment","view","title","by","rating","featuredLabel","likeButton","category","socialSharing","description","viewButton"],"title_truncation":"45","description_truncation":"45","height":"180","limit_data":"10","title":"","nomobile":"0","name":"sescrowdfunding.carousel"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.category-icons',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"titleC":"Browse by Popular Categories","height":"150px","width":"160px","alignContent":"center","criteria":"alphabetical","show_criteria":["title","countCrowdfundings"],"limit_data":"8","title":"","nomobile":"0","name":"sescrowdfunding.category-icons"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.slideshow',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"slideshowtype":"1","category":"0","criteria":"0","order":"","info":"recently_created","autoplay":"1","speed":"2000","show_criteria":["featuredLabel","like","comment","view","title","by","rating","likeButton","category","description","socialSharing","viewButton"],"title_truncation":"100","description_truncation":"5000","height":"250","limit_data":"12","title":"","nomobile":"0","name":"sescrowdfunding.slideshow"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.tabbed-widget',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["grid"],"openViewType":"grid","tabOption":"advance","htmlTitle":"1","category_id":"","show_criteria":["featuredLabel","likeButton","socialSharing","like","comment","rating","view","title","category","by","viewButton","descriptionlist","descriptiongrid"],"show_limited_data":"no","pagging":"button","title_truncation_grid":"45","title_truncation_list":"45","limit_data_list":"10","limit_data_grid":"4","description_truncation_list":"45","description_truncation_grid":"45","height_list":"230","width_list":"260","height_grid":"270","width_grid":"304","search_type":["recentlySPcreated"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPdonated_order":"6","mostSPdonated_label":"Most Donated","dummy7":null,"featured_order":"7","featured_label":"Featured","sponsored_order":"8","sponsored_label":"Sponsored","verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"sescrowdfunding.tabbed-widget"}',
  ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'sesatoz.counters',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"backgroundimage":"public\/admin\/hero-13.jpg","counter1":"350","counter1text":"TOTAL AWARDS","counter2":"3150","counter2text":"TOTAL VOLUNTEER","counter3":"1220","counter3text":"TOTAL PROJECTS","counter4":"65","counter4text":"RUNNING PROJECTS","title":"","nomobile":"0","name":"sesatoz.counters"}',
//   ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.make-community',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"slideshowtype":"1","category":"0","criteria":"0","order":"","info":"recently_created","autoplay":"1","speed":"2000","show_criteria":["featuredLabel","like","comment","view","title","by","rating","likeButton","category","description","socialSharing","viewButton"],"title_truncation":"100","description_truncation":"5000","height":"250","limit_data":"12","title":"","nomobile":"0","name":"sescrowdfunding.slideshow"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesbasic.body-class',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"bodyclass":"sescrowdfunding_welcome_page","title":"","nomobile":"0","name":"sesbasic.body-class"}',
  ));
}

//Crowdfunding Home Page
$select = $db->select()
            ->from('engine4_core_pages')
            ->where('name = ?', 'sescrowdfunding_index_home')
            ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_home',
    'displayname' => 'SES - Crowdfunding - Crowdfunding Home Page',
    'title' => 'Crowdfunding Home',
    'description' => 'This is the crowdfunding home page.',
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
    'name' => 'sescrowdfunding.browse-menu',
    'parent_content_id' => $topmiddle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.carousel',
    'parent_content_id' => $topmiddle_id,
    'order' => $widgetOrder++,
    'params' => '{"slidesToShow":"3","category":"0","criteria":"0","order":"","info":"recently_created","autoplay":"1","speed":"3000","show_criteria":["like","comment","view","title","by","rating","featuredLabel","likeButton","category","socialSharing","description","viewButton"],"title_truncation":"45","description_truncation":"45","height":"150","limit_data":"10","title":"","nomobile":"0","name":"sescrowdfunding.carousel"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.slideshow',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"slideshowtype":"2","category":"0","criteria":"0","order":"","info":"recently_created","autoplay":"1","speed":"2000","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","like","comment","view","title","by","rating","likeButton","category","description","socialSharing","viewButton"],"title_truncation":"100","description_truncation":"5000","height":"350","limit_data":"8","title":"","nomobile":"0","name":"sescrowdfunding.slideshow"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.tabbed-widget',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","grid"],"openViewType":"list","tabOption":"advance","htmlTitle":"1","category_id":"","show_criteria":["featuredLabel","likeButton","socialSharing","like","comment","rating","view","title","category","by","viewButton","descriptionlist","descriptiongrid"],"show_limited_data":"no","pagging":"button","title_truncation_grid":"45","title_truncation_list":"45","limit_data_list":"10","limit_data_grid":"10","description_truncation_list":"45","description_truncation_grid":"45","height_list":"230","width_list":"260","height_grid":"270","width_grid":"312","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","week","month","featured"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy7":null,"featured_order":"6","featured_label":"Featured","sponsored_order":"8","sponsored_label":"Sponsored","verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"7","week_label":"This Week","dummy11":null,"month_order":"8","month_label":"This Month","title":"","nomobile":"0","name":"sescrowdfunding.tabbed-widget"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.browse-menu-quick',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.of-the-day',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","like","view","comment","rating","likeButton","featuredLabel","socialSharing"],"title_truncation":"20","description_truncation":"60","height":"180","width":"180","title":"Crowdfunding of the Day","nomobile":"0","name":"sescrowdfunding.of-the-day"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.top-donors-sidebar',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["donationAmount","date"],"itemCount":"3","title":"Top Donors","nomobile":"0","name":"sescrowdfunding.top-donors-sidebar"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.sidebar-widget',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","criteria":"5","order":"","info":"most_liked","show_criteria":["like","title","likeButton"],"title_truncation":"20","description_truncation":"20","height":"180","width":"180","limit_data":"3","title":"Most Liked Crowdfundings","nomobile":"0","name":"sescrowdfunding.sidebar-widget"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.sidebar-widget',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","criteria":"5","order":"","info":"most_rated","show_criteria":["title","rating"],"title_truncation":"20","description_truncation":"60","height":"180","width":"180","limit_data":"3","title":"Most Rated Crowdfundings","nomobile":"0","name":"sescrowdfunding.sidebar-widget"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesbasic.column-layout-width',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"layoutColumnWidthType":"px","columnWidth":"250","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.category-sidebar',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Categories","name":"sescrowdfunding.category-sidebar"}',
  ));
}

//Crowdfunding Browse Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sescrowdfunding_index_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_browse',
    'displayname' => 'SES - Crowdfunding - Browse Crowdfundings Page',
    'title' => 'Crowdfunding Browse',
    'description' => 'This page lists crowdfunding entries.',
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
    'name' => 'sescrowdfunding.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.category-carousel',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title_truncation":"45","description_truncation":"45","height":"180","width":"300","speed":"300","autoplay":"1","criteria":"admin_order","show_criteria":["title","description","countCrowdfundings"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","isfullwidth":"1","limit_data":"8","title":"","nomobile":"0","name":"sescrowdfunding.category-carousel"}',
  ));

  // Insert gutter menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.browse-crowdfundings',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","grid"],"openViewType":null,"show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","likeButton","socialSharing","like","comment","ratingStar","rating","view","title","category","by","viewButton","descriptionlist","descriptiongrid"],"sort":"recentlySPcreated","show_item_count":"1","title_truncation_list":"100","title_truncation_grid":"100","description_truncation_list":"300","description_truncation_grid":"150","height_list":"250","width_list":"310","height_grid":"270","width_grid":"307","limit_data_grid":"20","limit_data_list":"20","pagging":"button","title":"","nomobile":"0","name":"sescrowdfunding.browse-crowdfundings"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.browse-menu-quick',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","featured"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"no","kilometer_miles":"no","title":"","nomobile":"0","name":"sescrowdfunding.browse-search"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.sidebar-widget',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","criteria":"1","order":"","info":"recently_created","show_criteria":["like","comment","view","title","rating","description","viewButton"],"title_truncation":"15","description_truncation":"20","height":"180","width":"180","limit_data":"3","title":"Popular Crowdfundings","nomobile":"0","name":"sescrowdfunding.sidebar-widget"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.category-sidebar',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Categories","name":"sescrowdfunding.category-sidebar"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.tag-cloud',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#000","type":"cloud","text_height":"15","height":"150","itemCountPerPage":"50","title":"Tags","nomobile":"0","name":"sescrowdfunding.tag-cloud"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesbasic.column-layout-width',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"layoutColumnWidthType":"px","columnWidth":"290","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
  ));
}


//Browse Categories Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sescrowdfunding_category_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {

  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sescrowdfunding_category_browse',
      'displayname' => 'SES - Crowdfunding - Browse Categories Page',
      'title' => 'Crowdfunding Browse Category',
      'description' => 'This page lists crowdfunding categories.',
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
      'name' => 'sescrowdfunding.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sescrowdfunding' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "category" . DIRECTORY_SEPARATOR;
  if (is_file($PathFile . "banner" . DIRECTORY_SEPARATOR . 'category.jpg')) {
    if (!file_exists(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin')) {
      mkdir(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin', 0777, true);
    }
    copy($PathFile . "banner" . DIRECTORY_SEPARATOR . 'category.jpg', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin/crowdfunding-category-banner.jpg');
    $category_banner = 'public/admin/crowdfunding-category-banner.jpg';
  } else {
    $category_banner = '';
  }
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sescrowdfunding.banner-category',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"description":"Discover top-notch crowdfundings, creators, and collections related to your interests, hand-selected by our 100-percent-human curation team.","sescrowdfunding_categorycover_photo":"public\/admin\/crowd1.jpg","title":"Categories","nomobile":"0","name":"sescrowdfunding.banner-category"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sescrowdfunding.category-icons',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"titleC":"Browse By Popular Categories","height":"150","width":"160","alignContent":"center","criteria":"alphabetical","show_criteria":["title","countCrowdfundings"],"limit_data":"8","title":"","nomobile":"0","name":"sescrowdfunding.category-icons"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sescrowdfunding.category-associate-crowdfunding',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["like","comment","rating","view","title","by","category","featuredLabel","socialshare","likeButton","viewButton"],"popularity_crowdfunding":"creationdate","pagging":"autoload","criteria":"most_crowdfunding","category_limit":"6","crowdfunding_limit":"2","crowdfunding_description_truncation":"45","seemore_text":"+ See all [category_name]","allignment_seeall":"right","height":"160","title":"","nomobile":"0","name":"sescrowdfunding.category-associate-crowdfunding"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sescrowdfunding.of-the-day',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["title","like","view","comment","rating","by","category","likeButton","featuredLabel","sponsoredLabel","verifiedLabel","socialSharing","description","viewButton"],"title_truncation":"45","description_truncation":"60","height":"180","width":"180","title":"Crowdfunding of the Day","nomobile":"0","name":"sescrowdfunding.of-the-day"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sescrowdfunding.tag-cloud',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"color":"#000","type":"cloud","text_height":"15","height":"150","itemCountPerPage":"10","title":"Popular Tags","nomobile":"0","name":"sescrowdfunding.tag-cloud"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sescrowdfunding.sidebar-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","criteria":"5","order":"","info":"recently_created","show_criteria":["like","comment","view","title","category","rating","socialSharing","likeButton","description","viewButton"],"title_truncation":"25","description_truncation":"25","height":"180","width":"180","limit_data":"3","title":"Most Viewed Crowdfundings","nomobile":"0","name":"sescrowdfunding.sidebar-widget"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sescrowdfunding.sidebar-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","criteria":"5","order":"","info":"recently_created","show_criteria":["like","comment","view","title"],"title_truncation":"20","description_truncation":"20","height":"180","width":"180","limit_data":"3","title":"Recent Crowdfundings","nomobile":"0","name":"sescrowdfunding.sidebar-widget"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesbasic.column-layout-width',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"layoutColumnWidthType":"px","columnWidth":"280","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}'
  ));
}


//Category View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sescrowdfunding_category_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sescrowdfunding_category_index',
      'displayname' => 'SES - Crowdfunding - Crowdfunding Category View Page',
      'title' => 'Crowdfunding Category View Page',
      'description' => 'This page lists crowdfunding category view page.',
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
      'name' => 'sescrowdfunding.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sescrowdfunding.category-view-banner',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sescrowdfunding.category-view',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","show_criteria":["featuredLabel","sponsoredLabel","like","comment","rating","view","title","by","description"],"pagging":"button","description_truncation":"150","crowdfunding_limit":"12","height":"200","width":"294","title":"","nomobile":"0","name":"sescrowdfunding.category-view"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sescrowdfunding.sidebar-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","criteria":"5","order":"","info":"most_donated","show_criteria":["title","by","category"],"title_truncation":"45","description_truncation":"60","height":"50","width":"50","limit_data":"5","title":"Popular Crowdfunding","nomobile":"0","name":"sescrowdfunding.sidebar-widget"}'
  ));
}


//Crowdfunding Owner FAQs Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sescrowdfunding_index_crowdfunding-owner-faqs')
  ->limit(1)
  ->query()
  ->fetchColumn();

if( !$page_id ) {

  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_crowdfunding-owner-faqs',
    'displayname' => 'SES - Crowdfunding - Crowdfunding Owner FAQs Page',
    'title' => 'Crowdfunding Owner FAQs',
    'description' => 'This page is the crowdfunding owner faqs page.',
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
    'name' => 'sescrowdfunding.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.crowdfunding-owner-faqs',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}


//Crowdfunding Donors FAQs Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sescrowdfunding_index_doners-faqs')
  ->limit(1)
  ->query()
  ->fetchColumn();

if( !$page_id ) {

  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_doners-faqs',
    'displayname' => 'SES - Crowdfunding - Crowdfunding Donors FAQs Page',
    'title' => 'Donors FAQs',
    'description' => 'This page is the crowdfunding donors page.',
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
    'name' => 'sescrowdfunding.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.donor-faqs',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}




//Manage Crowdfundings Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sescrowdfunding_index_manage')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_manage',
    'displayname' => 'SES - Crowdfunding - Manage Crowdfundings Page',
    'title' => 'My Crowdfunding Entries',
    'description' => 'This page lists a user\'s crowdfunding entries.',
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
    'name' => 'sescrowdfunding.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.manage-crowdfundings',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.of-the-day',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","like","view","comment","rating"],"title_truncation":"25","description_truncation":"25","height":"180","width":"180","title":" Crowdfunding of the Day","nomobile":"0","name":"sescrowdfunding.of-the-day"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.sidebar-widget',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","criteria":"5","order":"","info":"recently_created","show_criteria":["comment","title"],"title_truncation":"20","description_truncation":"25","height":"180","width":"180","limit_data":"3","title":"Most Commented","nomobile":"0","name":"sescrowdfunding.sidebar-widget"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.top-donors-sidebar',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["donationAmount","date"],"itemCount":"3","title":"Top Donors","nomobile":"0","name":"sescrowdfunding.top-donors-sidebar"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesbasic.column-layout-width',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"layoutColumnWidthType":"px","columnWidth":"280","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
  ));
}

//Browse Tags Page
$page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sescrowdfunding_index_tags')
            ->limit(1)
            ->query()
            ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_tags',
    'displayname' => 'SES - Crowdfunding - Browse Tags Page',
    'title' => 'Crowdfunding Browse Tags Page',
    'description' => 'This page displays the crowdfunding tags.',
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
    'name' => 'sescrowdfunding.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.browse-tags',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}



//Crowdfunding Create Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sescrowdfunding_index_create')
  ->limit(1)
  ->query()
  ->fetchColumn();

if( !$page_id ) {

  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_create',
    'displayname' => 'SES - Crowdfunding - Crowdfunding Create Page',
    'title' => 'Crowdfunding Create',
    'description' => 'This page is the srowdfunding create page.',
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
    'name' => 'sescrowdfunding.browse-menu',
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


//Crowdfunding view page
$select = new Zend_Db_Select($db);
$hasWidget = $select
  ->from('engine4_core_pages', new Zend_Db_Expr('TRUE'))
  ->where('name = ?', 'sescrowdfunding_index_view_1')
  ->limit(1)
  ->query()
  ->fetchColumn();

if(empty($hasWidget)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_view_1',
    'displayname' => 'SES - Crowdfunding - Crowdfunding View Page Design 1',
    'title' => 'Crowdfunding View Page',
    'description' => 'This is the view page for crowdfunding.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId('engine4_core_pages');


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

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-breadcrumb',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-cover',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"desgin":"desgin1","show_criteria":["like","comment","view","rating","location","by","likeButton","category","donation","socialSharing"],"title":"","nomobile":"0","name":"sescrowdfunding.profile-cover"}',
  ));

  // middle column
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'core.container-tabs',
    'parent_content_id' => $main_middle_id,
    'order' => 2,
    'params' => '{"max":"6"}',
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');

  // tabs
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-description',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Description","name":"sescrowdfunding.profile-description"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.crowdfunding-overview',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Overview","name":"sescrowdfunding.crowdfunding-overview"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-aboutme',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"About Me","name":"sescrowdfunding.profile-aboutme"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-donors',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["donationAmount","date"],"itemCount":"10","title":"Donors","nomobile":"0","name":"sescrowdfunding.profile-donors"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-map',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Map","titleCount":true}',
  ));


  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-announcements',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"limit_data":"","title":"Announcements","nomobile":"0","name":"sescrowdfunding.profile-announcements"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-rewards',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"limit_data":"10","title":"Rewards","nomobile":"0","name":"sescrowdfunding.profile-rewards"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesadvancedactivity.feed',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Updates","design":"2","upperdesign":"0","enablestatusbox":"2","feeddesign":"1","sesact_pinboard_width":"300","scrollfeed":"1","autoloadTimes":"3","statusplacehoder":"Post Something...","userphotoalign":"left","enablefeedbgwidget":"1","feedbgorder":"random","enablewidthsetting":"0","sesact_image1":null,"sesact_image1_width":"500","sesact_image1_height":"450","sesact_image2":null,"sesact_image2_width":"289","sesact_image2_height":"200","sesact_image3":null,"sesact_image3_bigwidth":"328","sesact_image3_bigheight":"300","sesact_image3_smallwidth":"250","sesact_image3_smallheight":"150","sesact_image4":null,"sesact_image4_bigwidth":"578","sesact_image4_bigheight":"300","sesact_image4_smallwidth":"192","sesact_image4_smallheight":"100","sesact_image5":null,"sesact_image5_bigwidth":"289","sesact_image5_bigheight":"260","sesact_image5_smallwidth":"289","sesact_image5_smallheight":"130","sesact_image6":null,"sesact_image6_width":"289","sesact_image6_height":"150","sesact_image7":null,"sesact_image7_bigwidth":"192","sesact_image7_bigheight":"150","sesact_image7_smallwidth":"144","sesact_image7_smallheight":"150","sesact_image8":null,"sesact_image8_width":"144","sesact_image8_height":"150","sesact_image9":null,"sesact_image9_width":"192","sesact_image9_height":"150","nomobile":"0","name":"sesadvancedactivity.feed"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-similar-crowdfundings',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid","show_criteria":["like","comment","view","title","by","featuredLabel","sponsoredLabel","verifiedLabel","likeButton","category","socialSharing","description","viewButton"],"height":"180","width":"335","title_truncation":"45","description_truncation":"45","limit_data":"3","title":"Similar Campaigns","nomobile":"0","name":"sescrowdfunding.profile-similar-crowdfundings"}',
  ));


  //Right column
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-featured-labels',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-goal',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-advance-share',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-like-button',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-owner-photo',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"photoviewtype":"circle","height":"150","width":"150","title":"Campaign Owner","nomobile":"0","name":"sescrowdfunding.profile-owner-photo"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-options',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
}


//Crowdfunding view page
$select = new Zend_Db_Select($db);
$hasWidget = $select
  ->from('engine4_core_pages', new Zend_Db_Expr('TRUE'))
  ->where('name = ?', 'sescrowdfunding_index_view_2')
  ->limit(1)
  ->query()
  ->fetchColumn();

if(empty($hasWidget)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_view_2',
    'displayname' => 'SES - Crowdfunding - Crowdfunding View Page Design 2',
    'title' => 'Crowdfunding View Page',
    'description' => 'This is the view page for crowdfunding.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId('engine4_core_pages');


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

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-breadcrumb',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-cover',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"desgin":"desgin1","show_criteria":["like","comment","view","rating","location","by","likeButton","category","donation","socialSharing"],"title":"","nomobile":"0","name":"sescrowdfunding.profile-cover"}',
  ));

  // middle column
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'core.container-tabs',
    'parent_content_id' => $main_middle_id,
    'order' => 2,
    'params' => '{"max":"6"}',
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');

  // tabs
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-description',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Description","name":"sescrowdfunding.profile-description"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.crowdfunding-overview',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Overview","name":"sescrowdfunding.crowdfunding-overview"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-aboutme',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"About Me","name":"sescrowdfunding.profile-aboutme"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-donors',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["donationAmount","date"],"itemCount":"10","title":"Donors","nomobile":"0","name":"sescrowdfunding.profile-donors"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-map',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Map","titleCount":true}',
  ));


  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-announcements',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"limit_data":"","title":"Announcements","nomobile":"0","name":"sescrowdfunding.profile-announcements"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-rewards',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"limit_data":"10","title":"Rewards","nomobile":"0","name":"sescrowdfunding.profile-rewards"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesadvancedactivity.feed',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Updates","design":"2","upperdesign":"0","enablestatusbox":"2","feeddesign":"1","sesact_pinboard_width":"300","scrollfeed":"1","autoloadTimes":"3","statusplacehoder":"Post Something...","userphotoalign":"left","enablefeedbgwidget":"1","feedbgorder":"random","enablewidthsetting":"0","sesact_image1":null,"sesact_image1_width":"500","sesact_image1_height":"450","sesact_image2":null,"sesact_image2_width":"289","sesact_image2_height":"200","sesact_image3":null,"sesact_image3_bigwidth":"328","sesact_image3_bigheight":"300","sesact_image3_smallwidth":"250","sesact_image3_smallheight":"150","sesact_image4":null,"sesact_image4_bigwidth":"578","sesact_image4_bigheight":"300","sesact_image4_smallwidth":"192","sesact_image4_smallheight":"100","sesact_image5":null,"sesact_image5_bigwidth":"289","sesact_image5_bigheight":"260","sesact_image5_smallwidth":"289","sesact_image5_smallheight":"130","sesact_image6":null,"sesact_image6_width":"289","sesact_image6_height":"150","sesact_image7":null,"sesact_image7_bigwidth":"192","sesact_image7_bigheight":"150","sesact_image7_smallwidth":"144","sesact_image7_smallheight":"150","sesact_image8":null,"sesact_image8_width":"144","sesact_image8_height":"150","sesact_image9":null,"sesact_image9_width":"192","sesact_image9_height":"150","nomobile":"0","name":"sesadvancedactivity.feed"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-similar-crowdfundings',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid","show_criteria":["like","comment","view","title","by","featuredLabel","sponsoredLabel","verifiedLabel","likeButton","category","socialSharing","description","viewButton"],"height":"180","width":"335","title_truncation":"45","description_truncation":"45","limit_data":"3","title":"Similar Campaigns","nomobile":"0","name":"sescrowdfunding.profile-similar-crowdfundings"}',
  ));


  //Right column
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-featured-labels',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-goal',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-advance-share',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-like-button',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-owner-photo',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"photoviewtype":"circle","height":"150","width":"150","title":"Campaign Owner","nomobile":"0","name":"sescrowdfunding.profile-owner-photo"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-options',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
}

//Crowdfunding view page
$select = new Zend_Db_Select($db);
$hasWidget = $select
  ->from('engine4_core_pages', new Zend_Db_Expr('TRUE'))
  ->where('name = ?', 'sescrowdfunding_index_view_3')
  ->limit(1)
  ->query()
  ->fetchColumn();

if(empty($hasWidget)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_view_3',
    'displayname' => 'SES - Crowdfunding - Crowdfunding View Page Design 3',
    'title' => 'Crowdfunding View Page',
    'description' => 'This is the view page for crowdfunding.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId('engine4_core_pages');


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

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-breadcrumb',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-cover',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"desgin":"desgin1","show_criteria":["like","comment","view","rating","location","by","likeButton","category","donation","socialSharing"],"title":"","nomobile":"0","name":"sescrowdfunding.profile-cover"}',
  ));

  // middle column
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'core.container-tabs',
    'parent_content_id' => $main_middle_id,
    'order' => 2,
    'params' => '{"max":"6"}',
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');

  // tabs
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-description',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Description","name":"sescrowdfunding.profile-description"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.crowdfunding-overview',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Overview","name":"sescrowdfunding.crowdfunding-overview"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-aboutme',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"About Me","name":"sescrowdfunding.profile-aboutme"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-donors',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["donationAmount","date"],"itemCount":"10","title":"Donors","nomobile":"0","name":"sescrowdfunding.profile-donors"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-map',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Map","titleCount":true}',
  ));


  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-announcements',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"limit_data":"","title":"Announcements","nomobile":"0","name":"sescrowdfunding.profile-announcements"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-rewards',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"limit_data":"10","title":"Rewards","nomobile":"0","name":"sescrowdfunding.profile-rewards"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesadvancedactivity.feed',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Updates","design":"2","upperdesign":"0","enablestatusbox":"2","feeddesign":"1","sesact_pinboard_width":"300","scrollfeed":"1","autoloadTimes":"3","statusplacehoder":"Post Something...","userphotoalign":"left","enablefeedbgwidget":"1","feedbgorder":"random","enablewidthsetting":"0","sesact_image1":null,"sesact_image1_width":"500","sesact_image1_height":"450","sesact_image2":null,"sesact_image2_width":"289","sesact_image2_height":"200","sesact_image3":null,"sesact_image3_bigwidth":"328","sesact_image3_bigheight":"300","sesact_image3_smallwidth":"250","sesact_image3_smallheight":"150","sesact_image4":null,"sesact_image4_bigwidth":"578","sesact_image4_bigheight":"300","sesact_image4_smallwidth":"192","sesact_image4_smallheight":"100","sesact_image5":null,"sesact_image5_bigwidth":"289","sesact_image5_bigheight":"260","sesact_image5_smallwidth":"289","sesact_image5_smallheight":"130","sesact_image6":null,"sesact_image6_width":"289","sesact_image6_height":"150","sesact_image7":null,"sesact_image7_bigwidth":"192","sesact_image7_bigheight":"150","sesact_image7_smallwidth":"144","sesact_image7_smallheight":"150","sesact_image8":null,"sesact_image8_width":"144","sesact_image8_height":"150","sesact_image9":null,"sesact_image9_width":"192","sesact_image9_height":"150","nomobile":"0","name":"sesadvancedactivity.feed"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-similar-crowdfundings',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid","show_criteria":["like","comment","view","title","by","featuredLabel","sponsoredLabel","verifiedLabel","likeButton","category","socialSharing","description","viewButton"],"height":"180","width":"335","title_truncation":"45","description_truncation":"45","limit_data":"3","title":"Similar Campaigns","nomobile":"0","name":"sescrowdfunding.profile-similar-crowdfundings"}',
  ));


  //Right column
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-featured-labels',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-goal',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-advance-share',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-like-button',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-owner-photo',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"photoviewtype":"circle","height":"150","width":"150","title":"Campaign Owner","nomobile":"0","name":"sescrowdfunding.profile-owner-photo"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-options',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
}

//Crowdfunding view page
$select = new Zend_Db_Select($db);
$hasWidget = $select
  ->from('engine4_core_pages', new Zend_Db_Expr('TRUE'))
  ->where('name = ?', 'sescrowdfunding_index_view_4')
  ->limit(1)
  ->query()
  ->fetchColumn();

if(empty($hasWidget)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_view_4',
    'displayname' => 'SES - Crowdfunding - Crowdfunding View Page Design 4',
    'title' => 'Crowdfunding View Page',
    'description' => 'This is the view page for crowdfunding.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId('engine4_core_pages');


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

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-breadcrumb',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-cover',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"desgin":"desgin1","show_criteria":["like","comment","view","rating","location","by","likeButton","category","donation","socialSharing"],"title":"","nomobile":"0","name":"sescrowdfunding.profile-cover"}',
  ));

  // middle column
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'core.container-tabs',
    'parent_content_id' => $main_middle_id,
    'order' => 2,
    'params' => '{"max":"6"}',
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');

  // tabs
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-description',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Description","name":"sescrowdfunding.profile-description"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.crowdfunding-overview',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Overview","name":"sescrowdfunding.crowdfunding-overview"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-aboutme',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"About Me","name":"sescrowdfunding.profile-aboutme"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-donors',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["donationAmount","date"],"itemCount":"10","title":"Donors","nomobile":"0","name":"sescrowdfunding.profile-donors"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-map',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Map","titleCount":true}',
  ));


  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-announcements',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"limit_data":"","title":"Announcements","nomobile":"0","name":"sescrowdfunding.profile-announcements"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-rewards',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"limit_data":"10","title":"Rewards","nomobile":"0","name":"sescrowdfunding.profile-rewards"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesadvancedactivity.feed',
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Updates","design":"2","upperdesign":"0","enablestatusbox":"2","feeddesign":"1","sesact_pinboard_width":"300","scrollfeed":"1","autoloadTimes":"3","statusplacehoder":"Post Something...","userphotoalign":"left","enablefeedbgwidget":"1","feedbgorder":"random","enablewidthsetting":"0","sesact_image1":null,"sesact_image1_width":"500","sesact_image1_height":"450","sesact_image2":null,"sesact_image2_width":"289","sesact_image2_height":"200","sesact_image3":null,"sesact_image3_bigwidth":"328","sesact_image3_bigheight":"300","sesact_image3_smallwidth":"250","sesact_image3_smallheight":"150","sesact_image4":null,"sesact_image4_bigwidth":"578","sesact_image4_bigheight":"300","sesact_image4_smallwidth":"192","sesact_image4_smallheight":"100","sesact_image5":null,"sesact_image5_bigwidth":"289","sesact_image5_bigheight":"260","sesact_image5_smallwidth":"289","sesact_image5_smallheight":"130","sesact_image6":null,"sesact_image6_width":"289","sesact_image6_height":"150","sesact_image7":null,"sesact_image7_bigwidth":"192","sesact_image7_bigheight":"150","sesact_image7_smallwidth":"144","sesact_image7_smallheight":"150","sesact_image8":null,"sesact_image8_width":"144","sesact_image8_height":"150","sesact_image9":null,"sesact_image9_width":"192","sesact_image9_height":"150","nomobile":"0","name":"sesadvancedactivity.feed"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-similar-crowdfundings',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid","show_criteria":["like","comment","view","title","by","featuredLabel","sponsoredLabel","verifiedLabel","likeButton","category","socialSharing","description","viewButton"],"height":"180","width":"335","title_truncation":"45","description_truncation":"45","limit_data":"3","title":"Similar Campaigns","nomobile":"0","name":"sescrowdfunding.profile-similar-crowdfundings"}',
  ));


  //Right column
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-featured-labels',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-goal',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-advance-share',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-like-button',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-owner-photo',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"photoviewtype":"circle","height":"150","width":"150","title":"Campaign Owner","nomobile":"0","name":"sescrowdfunding.profile-owner-photo"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-options',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
}

//Crowdfundings Donate Order Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sescrowdfunding_order_donate')
              ->limit(1)
              ->query()
              ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_order_donate',
    'displayname' => 'SES - Crowdfunding - Crowdfundings Donate Order',
    'title' => 'Crowdfunding Donate Order Page',
    'description' => 'This page is the crowdfunding donate order page.',
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

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sescrowdfunding.browse-menu',
    'parent_content_id' => $topmiddle_id,
    'order' => $widgetOrder++,
  ));

  // tabs
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'core.content',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}


//My All Donations Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sescrowdfunding_index_manage-donations')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_manage-donations',
    'displayname' => 'SES - Crowdfunding - My All Donations Page',
    'title' => 'My All Donations',
    'description' => 'This page lists a user\'s all donations entries.',
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

//   // Insert main-right
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'right',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 1,
//   ));
//   $main_right_id = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.manage-all-donations',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Manage Received Donations Page
$page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sescrowdfunding_index_manage-received-donations')
            ->limit(1)
            ->query()
            ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sescrowdfunding_index_manage-received-donations',
    'displayname' => 'SES - Crowdfunding - Manage Received Donations Page',
    'title' => 'Manage Received Donations',
    'description' => 'This page lists a user\'s all donations entries.',
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

//   // Insert main-right
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'right',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 1,
//   ));
//   $main_right_id = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sescrowdfunding.manage-received-donations',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Category Work
$db->query('INSERT INTO `engine4_sescrowdfunding_categories` (`category_id`, `slug`, `category_name`, `subcat_id`, `subsubcat_id`, `title`, `description`, `color`, `thumbnail`, `cat_icon`, `colored_icon`, `order`, `profile_type`, `profile_type_review`, `member_levels`) VALUES
(12, "medical", "Medical", 0, 0, "Medical", "Medical", "", 0, 48790, 48806, 1, 0, NULL, "Array"),
(13, "organ-transplant", "Organ Transplant", 12, 0, "Organ Transplant", "Organ Transplant", "", 0, 48330, 48636, 1, 0, NULL, NULL),
(15, "medicines", "Medicines", 12, 0, "Medicines", "Medicines", "", 0, 48334, 48640, 2, 0, NULL, NULL),
(16, "health-checkup", "Health Checkup", 12, 0, "Health Checkup", "Health Checkup", "", 0, 48336, 48644, 3, 0, NULL, NULL),
(17, "social-welfare", "Social Welfare", 0, 0, "Social Welfare", "Social Welfare", "", 0, 48770, 48772, 2, 0, NULL, "Array"),
(18, "build-society", "Build Society", 17, 0, "Build Society", "Build Society", "", 0, 48340, 48650, 1, 3, NULL, NULL),
(19, "share-food", "Share Food", 17, 0, "Share Food", "Share Food", "", 0, 48342, 48652, 2, 4, NULL, NULL),
(20, "provide-shelter", "Provide Shelter", 17, 0, "Provide Shelter", "Provide Shelter", "", 0, 48344, 48656, 3, 5, NULL, NULL),
(21, "recreation", "Recreation", 17, 0, "Recreation", "Recreation", "", 0, 48346, 48660, 4, 0, NULL, NULL),
(22, "photography", "Photography", 0, 0, "Photography", "Photography", "", 0, 48798, 48794, 3, 2, NULL, "Array"),
(23, "nature-", "Nature ", 22, 0, "Nature ", "Nature ", "", 0, 48350, 48664, 1, 2, NULL, NULL),
(24, "animal", "Animal", 22, 0, "Animal", "Animal", "", 0, 48352, 48666, 2, 2, NULL, NULL),
(25, "place", "Place", 22, 0, "Place", "Place", "", 0, 48354, 48670, 3, 0, NULL, NULL),
(26, "monetary-fund", "Monetary Fund", 0, 0, "Monetary Fund", "Monetary Fund", "", 0, 48804, 48796, 4, 3, NULL, "Array"),
(27, "business-models", "Business Models", 26, 0, "Business Models", "Business Models", "", 0, 48358, 48676, 1, 2, NULL, NULL),
(28, "financial-support", "Financial Support", 26, 0, "Financial Support", "Financial Support", "", 0, 48360, 48680, 2, 2, NULL, NULL),
(29, "scholarship", "Scholarship", 26, 0, "Scholarship", "Scholarship", "", 0, 48362, 48682, 3, 4, NULL, NULL),
(30, "social-issues", "Social Issues", 26, 0, "Social Issues", "Social Issues", "", 0, 48364, 48686, 4, 2, NULL, NULL),
(31, "film-theater-video", "Film, Theater & Video", 0, 0, "Film, Theater & Video", "Film, Theater & Video", "", 0, 48800, 48792, 5, 2, NULL, "Array"),
(32, "acting", "Acting", 31, 0, "Acting", "Acting", "", 0, 48368, 48690, 1, 2, NULL, NULL),
(33, "dancing", "Dancing", 31, 0, "Dancing", "Dancing", "", 0, 48370, 48694, 2, 2, NULL, NULL),
(34, "musical", "Musical", 31, 0, "Musical", "Musical", "", 0, 48372, 48696, 3, 0, NULL, NULL),
(35, "technology", "Technology", 0, 0, "Technology", "Technology", "", 0, 48816, 48814, 6, 0, NULL, "Array"),
(36, "software", "Software", 35, 0, "Software", "Software", "", 0, 48376, 48700, 1, 2, NULL, NULL),
(37, "gadgets", "Gadgets", 35, 0, "Gadgets", "Gadgets", "", 0, 48378, 48702, 2, 4, NULL, NULL),
(38, "digital-marketing", "Digital Marketing", 35, 0, "Digital Marketing", "Digital Marketing", "", 0, 48380, 48704, 3, 0, NULL, NULL),
(39, "hip-hop", "Hip-hop", 0, 33, "Hip-hop", "Hip-hop", "", 0, 48382, 48692, 1, 0, NULL, "Array"),
(40, "poverty", "Poverty", 0, 30, "Poverty", "", "", 0, 48384, 48684, 1, 2, NULL, "Array"),
(41, "education-loan", "Education Loan", 0, 28, "Education Loan", "Education ", "", 0, 48386, 48678, 1, 0, NULL, "Array"),
(42, "enterpreneurship", "Enterpreneurship", 0, 27, "Enterpreneurship", "Enterpreneurship", "", 0, 48388, 48674, 1, 2, NULL, "Array"),
(43, "monument", "Monument", 0, 25, "Monument", "Monument", "", 0, 48390, 48668, 1, 0, NULL, "Array"),
(44, "yoga", "Yoga", 0, 21, "Yoga", "Yoga", "", 0, 48396, 48658, 1, 3, NULL, "Array"),
(45, "camps", "Camps", 0, 20, "Camps", "Camps", "", 0, 48398, 48654, 1, 0, NULL, "Array"),
(46, "educate-people", "Educate People", 0, 18, "Educate People", "Educate People", "", 0, 48400, 48648, 1, 0, NULL, "Array"),
(47, "mri-scan", "MRI Scan", 0, 16, "MRI Scan", "MRI Scan", "", 0, 48402, 48642, 1, 2, NULL, "Array"),
(48, "women", "Women", 0, 15, "Women", "Women", "", 0, 48404, 48638, 1, 0, NULL, "Array"),
(49, "heart", "Heart", 0, 13, "Heart", "Heart", "", 0, 48406, 48634, 1, 2, NULL, "Array"),
(50, "eyes", "Eyes", 0, 13, "Eyes", "Eyes", "", 0, 48408, 0, 2, 3, NULL, NULL),
(51, "others", "Others", 0, 0, "Others", "Others", "", 0, 48716, 48808, 7, 0, NULL, "Array");');

$this->uploadDefaultCategory();

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sescrowdfunding_Form_Admin_Level_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('crowdfunding', $level->level_id, array_keys($form->getValues()));

  $form->populate($valuesForm);
  if ($form->defattribut)
    $form->defattribut->setValue(0);
  $db = $permissionsTable->getAdapter();
  $db->beginTransaction();
  try {
    if ($level->type != 'public') {
      // Set permissions
      $values['auth_comment'] = (array) @$values['auth_comment'];
      $values['auth_view'] = (array) @$values['auth_view'];
    }
    $nonBooleanSettings = $form->nonBooleanFields();
    $permissionsTable->setAllowed('crowdfunding', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}

$db->query('ALTER TABLE `engine4_sescrowdfunding_crowdfundings` ADD `pagestyle` TINYINT(1) NOT NULL DEFAULT "1";');



$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sescrowdfunding_admin_main_integrateothermodule", "sescrowdfunding", "Integrate Plugins", "", \'{"route":"admin_default","module":"sescrowdfunding","controller":"integrateothermodule","action":"index"}\', "sescrowdfunding_admin_main", "", 995);');

$db->query('DROP TABLE IF EXISTS `engine4_sescrowdfunding_integrateothermodules`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_sescrowdfunding_integrateothermodules` (
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

$table_exist = $db->query("SHOW TABLES LIKE 'engine4_sescrowdfunding_integrateothermodules'")->fetch();
if (!empty($table_exist)) {
    $resource_type = $db->query("SHOW COLUMNS FROM engine4_sescrowdfunding_crowdfundings LIKE 'resource_type'")->fetch();
    if (empty($resource_type)) {
        $db->query('ALTER TABLE `engine4_sescrowdfunding_crowdfundings` ADD `resource_type` VARCHAR(128) NULL;');
    }
    $resource_id = $db->query("SHOW COLUMNS FROM engine4_sescrowdfunding_crowdfundings LIKE 'resource_id'")->fetch();
    if (empty($resource_id)) {
        $db->query('ALTER TABLE `engine4_sescrowdfunding_crowdfundings` ADD `resource_id` INT(11) NOT NULL DEFAULT "0";');
    }
}
