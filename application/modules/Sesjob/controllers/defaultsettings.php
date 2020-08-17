<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Job Home Page
$select = $db->select()
            ->from('engine4_core_pages')
            ->where('name = ?', 'sesjob_index_home')
            ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sesjob_index_home',
    'displayname' => 'SES - Advanced Job - Jobs Home Page',
    'title' => 'Job Home',
    'description' => 'This is the job home page.',
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
    'name' => 'sesjob.browse-menu',
    'parent_content_id' => $topmiddle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesjob.featured-sponsored-verified-category-slideshow',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"category":"0","criteria":"0","order":"","info":"most_liked","isfullwidth":"0","autoplay":"1","speed":"2000","type":"slide","navigation":"nextprev","show_criteria":["like","comment","favourite","view","title","companyname","industry","by","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing","creationDate"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"400","limit_data":"12","title":"","nomobile":"0","name":"sesjob.featured-sponsored-verified-category-slideshow"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesjob.tabbed-widget-job',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","grid","map"],"openViewType":"list","tabOption":"advance","htmlTitle":"1","category_id":"","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","location","companyname","industry","socialSharing","like","favourite","comment","view","skills","title","category","by","readmore","creationDate"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","show_limited_data":"no","pagging":"button","title_truncation_grid":"40","title_truncation_list":"50","limit_data_list":"9","limit_data_grid":"15","description_truncation_list":"190","description_truncation_grid":"160","height_grid":"90","width_grid":"337","height_list":"100","width_list":"130","width_grid_photo":"90","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","featured","sponsored","verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","dummy12":null,"hot_order":"12","hot_label":"Hot","title":"","nomobile":"0","name":"sesjob.tabbed-widget-job"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'core.layout-column-width',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","columnWidth":"250","columnWidthType":"px","nomobile":"0","name":"core.layout-column-width"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesjob.of-the-day',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","companyname","like","view","comment","favourite","by","favouriteButton","likeButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"50","description_truncation":"50","height":"180","width":"180","title":"Job of the Day","nomobile":"0","name":"sesjob.of-the-day"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesjob.featured-sponsored',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"rounded","criteria":"5","order":"","info":"recently_created","show_criteria":["like","comment","view","title","companyname","category","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"1","title_truncation":"50","description_truncation":"50","height":"70","width":"70","limit_data":"4","title":"Recent Jobs","nomobile":"0","name":"sesjob.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesjob.tag-cloud-category',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#00f","showType":"simple","text_height":"15","height":"300","itemCountPerPage":"12","title":"Categories","nomobile":"0","name":"sesjob.tag-cloud-category"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesjob.featured-sponsored',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"most_viewed","show_criteria":["view","title","companyname","industry","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"1","title_truncation":"50","description_truncation":"50","height":"60","width":"70","limit_data":"3","title":"Most Viewed Jobs","nomobile":"0","name":"sesjob.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesjob.top-jobgers',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","show_criteria":["count","ownername"],"height":"135","width":"205","showLimitData":"1","limit_data":"3","title":"Top Job Posters","nomobile":"0","name":"sesjob.top-jobgers"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesjob.tag-cloud-jobs',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#000000","type":"cloud","text_height":"15","height":"170","itemCountPerPage":"15","title":"Popular Tags","nomobile":"0","name":"sesjob.tag-cloud-jobs"}',
  ));

}

//Job Browse Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesjob_index_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesjob_index_browse',
    'displayname' => 'SES - Advanced Job - Browse Jobs Page',
    'title' => 'Job Browse',
    'description' => 'This page lists job entries.',
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
    'name' => 'sesjob.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.category-carousel',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title_truncation_grid":"45","description_truncation_grid":"45","height":"300","width":"388","autoplay":"1","speed":"2000","criteria":"most_job","show_criteria":["title","description","countJobs","socialshare"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","isfullwidth":"0","limit_data":"15","title":"","nomobile":"0","name":"sesjob.category-carousel"}',
  ));

  // Insert search
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.alphabet-search',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert gutter menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.browse-jobs',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","grid","map"],"openViewType":"grid","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","view","title","companyname","industry","category","by","readmore","creationDate","descriptionlist","descriptiongrid"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","category":"0","sort":"mostSPviewed","show_item_count":"1","title_truncation_list":"150","title_truncation_grid":"150","description_truncation_list":"400","description_truncation_grid":"400","height_list":"90","width_list":"120","height_grid":"90","width_grid":"337","width_grid_photo":"90","limit_data_grid":"18","limit_data_list":"10","pagging":"button","title":"","nomobile":"0","name":"sesjob.browse-jobs"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid1","imageType":"square","criteria":"2","order":"","info":"most_liked","show_criteria":["like","comment","view","title","companyname","by","creationDate","category","socialSharing","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"1","title_truncation":"150","description_truncation":"200","height":"150","width":"150","limit_data":"1","title":"Sponsored Jobs","nomobile":"0","name":"sesjob.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.browse-menu-quick',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"sesjob.browse-search"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"rounded","criteria":"5","order":"","info":"most_commented","show_criteria":["like","comment","favourite","view","title","category"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"0","title_truncation":"150","description_truncation":"300","height":"65","width":"65","limit_data":"5","title":"Most Commented Jobs","nomobile":"0","name":"sesjob.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.tag-cloud-jobs',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#000000","type":"cloud","text_height":"12","height":"170","itemCountPerPage":"18","title":"Popular Tags","nomobile":"0","name":"sesjob.tag-cloud-jobs"}',
  ));
}

//Browse Categories Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesjob_category_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {

  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesjob_category_browse',
      'displayname' => 'SES - Advanced Job - Browse Categories Page',
      'title' => 'Job Browse Category',
      'description' => 'This page lists job categories.',
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
      'name' => 'sesjob.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));
  $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesjob' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "category" . DIRECTORY_SEPARATOR;
  if (is_file($PathFile . "banner" . DIRECTORY_SEPARATOR . 'category.jpg')) {
    if (!file_exists(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin')) {
      mkdir(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin', 0777, true);
    }
    copy($PathFile . "banner" . DIRECTORY_SEPARATOR . 'category.jpg', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin/job-category-banner.jpg');
    $category_banner = 'public/admin/job-category-banner.jpg';
  } else {
    $category_banner = '';
  }
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesjob.banner-category',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"description":"Discover top-notch jobs, creators, and collections related to your interests, hand-selected by our 100-percent-human curation team.","sesjob_categorycover_photo":"","title":"Categories","nomobile":"0","name":"sesjob.banner-category"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesjob.job-category-icons',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"titleC":"Popular Categories","height":"150","width":"180","alignContent":"center","criteria":"admin_order","show_criteria":["title","countJobs"],"limit_data":"12","title":"","nomobile":"0","name":"sesjob.job-category-icons"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesjob.category-associate-job',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["like","comment","view","title","favourite","by","creationDate","readmore"],"popularity_job":"like_count","pagging":"button","criteria":"alphabetical","category_limit":"5","job_limit":"3","seemore_text":"+ See all [category_name]","allignment_seeall":"left","title":"","nomobile":"0","name":"sesjob.category-associate-job"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.layout-column-width',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"","columnWidth":"250","columnWidthType":"px","nomobile":"0","name":"core.layout-column-width"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesjob.of-the-day',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid1","fixHover":"hover","show_criteria":["title","like","view","comment","favourite","rating","ratingStar","by","favouriteButton","likeButton","featuredLabel","verifiedLabel","socialSharing"],"title_truncation":"45","description_truncation":"60","height":"180","width":"180","title":"Job of the Day","nomobile":"0","name":"sesjob.of-the-day"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesjob.sidebar-tabbed-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":"list","show_criteria":["likeButton","socialSharing","like","favourite","comment","view","title","category","by"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_limited_data":null,"pagging":"button","title_truncation_grid":"45","title_truncation_list":"20","limit_data_list":"3","limit_data_grid":"10","description_truncation_grid":"45","height_grid":"270","width_grid":"389","height_list":"60","width_list":"60","search_type":["recentlySPcreated"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","dummy12":null,"hot_order":"12","hot_label":"Hot","title":"Recent Created Jobs","nomobile":"0","name":"sesjob.sidebar-tabbed-widget"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesjob.tag-cloud-jobs',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"color":"#00f","type":"tab","text_height":"15","height":"300","itemCountPerPage":"15","title":"Trending Tags","nomobile":"0","name":"sesjob.tag-cloud-jobs"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesjob.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"recently_created","show_criteria":["like","comment","favourite","view","title","companyname","category","socialSharing","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"1","title_truncation":"20","description_truncation":"60","height":"50","width":"50","limit_data":"3","title":"Recent Posts","nomobile":"0","name":"sesjob.featured-sponsored"}'
  ));


  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesjob.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","imageType":"rounded","criteria":"5","order":"","info":"most_favourite","show_criteria":["favourite","view","title","industry","category","socialSharing","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"0","title_truncation":"20","description_truncation":"60","height":"60","width":"60","limit_data":"3","title":"Most Favourite Jobs","nomobile":"0","name":"sesjob.featured-sponsored"}'
  ));
}

//Browse Locations Page
$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesjob_index_locations')
    ->limit(1)
    ->query()
    ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sesjob_index_locations',
      'displayname' => 'SES - Advanced Job - Browse Locations Page',
      'title' => 'Job Browse Location',
      'description' => 'This page show job locations.',
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
      'name' => 'sesjob.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesjob.browse-search',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"sesjob.browse-search"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.job-location',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"location":"World","lat":"56.6465227","lng":"-6.709638499999983","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","location","likeButton","0","1","ratingStar","rating","socialSharing","like","view","comment","favourite"],"location-data":null,"title":"","nomobile":"0","name":"sesjob.job-location"}',
  ));
}


//Manage Jobs Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesjob_index_manage')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesjob_index_manage',
    'displayname' => 'SES - Advanced Job - Manage Jobs Page',
    'title' => 'My Job Entries',
    'description' => 'This page lists a user\'s job entries.',
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
    'name' => 'sesjob.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.manage-jobs',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","grid","map"],"openViewType":"list","tabOption":"advance","htmlTitle":"1","category_id":"","show_criteria":["favouriteButton","likeButton","location","companyname","industry","socialSharing","like","favourite","comment","view","skills","title","category","by","readmore","creationDate"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","show_limited_data":"no","pagging":"button","title_truncation_grid":"45","title_truncation_list":"45","limit_data_list":"5","limit_data_grid":"5","description_truncation_list":"45","description_truncation_grid":"45","height_grid":"90","width_grid":"337","height_list":"100","width_list":"130","width_grid_photo":"90","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","week","month","featured","sponsored","verified","hot"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","dummy12":null,"hot_order":"12","hot_label":"Hot","title":"","nomobile":"0","name":"sesjob.manage-jobs"}',
  ));
}


//Job Create Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesjob_index_create')
  ->limit(1)
  ->query()
  ->fetchColumn();

if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesjob_index_create',
    'displayname' => 'SES - Advanced Job - Job Create Page',
    'title' => 'Write New Job',
    'description' => 'This page is the job create page.',
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
    'name' => 'sesjob.browse-menu',
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
            ->where('name = ?', 'sesjob_index_tags')
            ->limit(1)
            ->query()
            ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesjob_index_tags',
    'displayname' => 'SES - Advanced Job - Browse Tags Page',
    'title' => 'Job Browse Tags Page',
    'description' => 'This page displays the job tags.',
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
    'name' => 'sesjob.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.tag-jobs',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

// //Job List Page
// $page_id = $db->select()
//   ->from('engine4_core_pages', 'page_id')
//   ->where('name = ?', 'sesjob_index_list')
//   ->limit(1)
//   ->query()
//   ->fetchColumn();
//
// // insert if it doesn't exist yet
// if( !$page_id ) {
//   $widgetOrder = 1;
//   // Insert page
//   $db->insert('engine4_core_pages', array(
//     'name' => 'sesjob_index_list',
//     'displayname' => 'SES - Advanced Job - Job List Page',
//     'title' => 'Job List',
//     'description' => 'This page lists a member\'s job entries.',
//     'provides' => 'subject=user',
//     'custom' => 0,
//   ));
//   $page_id = $db->lastInsertId();
//
//   // Insert main
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'main',
//     'page_id' => $page_id,
//   ));
//   $main_id = $db->lastInsertId();
//
//   // Insert left
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'left',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 1,
//   ));
//   $left_id = $db->lastInsertId();
//
//   // Insert middle
//   $db->insert('engine4_core_content', array(
//     'type' => 'container',
//     'name' => 'middle',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_id,
//     'order' => 2,
//   ));
//   $middle_id = $db->lastInsertId();
//
//   // Insert gutter
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'sesjob.gutter-photo',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'sesjob.gutter-menu',
//     'page_id' => $page_id,
//     'parent_content_id' => $left_id,
//     'order' => $widgetOrder++,
//   ));
//
//   // Insert content
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'core.content',
//     'page_id' => $page_id,
//     'parent_content_id' => $middle_id,
//     'order' => $widgetOrder++,
//   ));
// }

//Job Profile Page Design 1
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesjob_index_view_1')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesjob_index_view_1',
    'displayname' => 'SES - Advanced Job - Job Profile Page',
    'title' => 'Job View',
    'description' => 'This page displays a job entry.',
    'provides' => 'subject=sesjob',
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
    'name' => 'sesjob.breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.view-job',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","name":"core.comments"}',
  ));

  // Insert gutter
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.labels',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.like-button',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.favourite-button',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.advance-share',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"sesjob.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.similar-jobs',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","by","favouriteButton","likeButton","socialSharing"],"showLimitData":"0","height":"200","width":"294","list_title_truncation":"45","limit_data":"3","title":"Related Jobs","nomobile":"0","name":"sesjob.similar-jobs"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.sidebar-tabbed-widget',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":"list","show_criteria":["title","category","by"],"show_limited_data":"yes","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","limit_data_list":"5","limit_data_grid":"10","description_truncation_grid":"45","height_grid":"270","width_grid":"389","height_list":"60","width_list":"60","search_type":["recentlySPcreated","mostSPviewed"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recent Jobs","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Popular Jobs","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"sesjob.sidebar-tabbed-widget"}',
  ));

}

//Company Browse Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesjob_company_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesjob_company_browse',
    'displayname' => 'SES - Advanced Job - Browse Company Page',
    'title' => 'Company Browse',
    'description' => 'This page lists company entries.',
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
    'name' => 'sesjob.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert gutter menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.browse-company',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","grid"],"openViewType":"list","show_criteria":["socialSharing","title","by","category","subscribecount","jobcount","readmore","creationDate","descriptionlist","descriptiongrid"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","show_item_count":"0","title_truncation_list":"150","title_truncation_grid":"150","description_truncation_list":"150","description_truncation_grid":"150","height_list":"90","width_list":"120","height_grid":"72","width_grid":"340","width_grid_photo":"72","limit_data_grid":"5","limit_data_list":"4","pagging":"button","title":"","nomobile":"0","name":"sesjob.browse-company"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.browse-company-search',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.calendar',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Find Jobs By Date","name":"sesjob.calendar"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.tag-cloud-category',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#00f","showType":"simple","text_height":"15","height":"300","itemCountPerPage":"50","title":"","nomobile":"0","name":"sesjob.tag-cloud-category"}',
  ));
}

//Company Profile Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesjob_company_view')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesjob_company_view',
    'displayname' => 'SES - Advanced Job - Company Profile Page',
    'title' => 'Company View',
    'description' => 'This page displays a compnay information.',
    'provides' => 'subject=sesjob',
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
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.company-breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.company-view',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesjob.company-sesjobs',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list"],"openViewType":"list","tabOption":"advance","htmlTitle":"1","category_id":"","show_criteria":["featuredLabel","sponsoredLabel","favouriteButton","likeButton","location","companyname","industry","socialSharing","like","favourite","comment","view","skills","title","category","by","readmore","creationDate"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","show_limited_data":"no","pagging":"auto_load","title_truncation_grid":"70","title_truncation_list":"70","limit_data_list":"10","limit_data_grid":"10","description_truncation_list":"45","description_truncation_grid":"45","height_grid":"230","width_grid":"260","height_list":"230","width_list":"260","width_grid_photo":"72","search_type":["recentlySPcreated"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","dummy12":null,"hot_order":"12","hot_label":"Hot","title":"","nomobile":"0","name":"sesjob.company-sesjobs"}',
  ));
}

//Category View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesjob_category_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesjob_category_index',
      'displayname' => 'SES - Advanced Job - Job Category View Page',
      'title' => 'Job Category View Page',
      'description' => 'This page lists job category view page.',
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
      'name' => 'sesjob.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesjob.category-view',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid","show_subcat":"1","show_subcatcriteria":["icon","title","countJob"],"heightSubcat":"160","widthSubcat":"290","textJob":"Jobs We Like","show_criteria":["featuredLabel","sponsoredLabel","like","comment","favourite","view","title","companyname","industry","by","description","readmore","creationDate"],"pagging":"button","description_truncation":"150","job_limit":"12","height":"200","width":"300","title":"","nomobile":"0","name":"sesjob.category-view"}'
  ));
}

$job_table_exist = $db->query('SHOW TABLES LIKE \'engine4_sesjob_jobs\'')->fetch();
if (!empty($job_table_exist)) {
  $sejob_id = $db->query('SHOW COLUMNS FROM engine4_sesjob_jobs LIKE \'sejob_id\'')->fetch();
  if (empty($sejob_id)) {
    $db->query('ALTER TABLE `engine4_sesjob_jobs` ADD `sejob_id` INT(11) NOT NULL DEFAULT "0";');
  }
}

$jobcat_table_exist = $db->query('SHOW TABLES LIKE \'engine4_sesjob_categories\'')->fetch();
if (!empty($jobcat_table_exist)) {
  $sejob_cayegoryid = $db->query('SHOW COLUMNS FROM engine4_sesjob_categories LIKE \'sejob_categoryid\'')->fetch();
  if (empty($sejob_cayegoryid)) {
    $db->query('ALTER TABLE `engine4_sesjob_categories` ADD `sejob_categoryid` INT(11) NULL;');
  }
}

$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesjob_link_job';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesjob_link_event';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesjob_reject_job_request';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesjob_reject_event_request';");


//Action Type Change for Apps
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'sesjob_job_like' WHERE `engine4_activity_actiontypes`.`type` = 'sesjob_like_job';");
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'sesjob_album_like' WHERE `engine4_activity_actiontypes`.`type` = 'sesjob_like_jobalbum';");
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'sesjob_photo_like' WHERE `engine4_activity_actiontypes`.`type` = 'sesjob_like_jobphoto';");
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'sesjob_job_favourite' WHERE `engine4_activity_actiontypes`.`type` = 'sesjob_favourite_job';");

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    "sesjob_job" as `type`,
    "job_approve" as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');

$table_exist = $db->query("SHOW TABLES LIKE 'engine4_sesjob_categories'")->fetch();
if (!empty($table_exist)) {
    $member_levels = $db->query("SHOW COLUMNS FROM engine4_sesjob_categories LIKE 'member_levels'")->fetch();
    if (empty($member_levels)) {
        $db->query('ALTER TABLE `engine4_sesjob_categories` ADD `member_levels` VARCHAR(255) NULL DEFAULT NULL;');
    }
}
$db->query('UPDATE `engine4_sesjob_categories` SET `member_levels` = "1,2,3,4" WHERE `engine4_sesjob_categories`.`subcat_id` = 0 and  `engine4_sesjob_categories`.`subsubcat_id` = 0;');


$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesjob_job" as `type`,
"cotinuereading" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesjob_job" as `type`,
"cotinuereading" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` IN("user");');

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesjob_job" as `type`,
"cntrdng_dflt" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesjob_job" as `type`,
"cntrdng_dflt" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` IN("user");');

$table_exist = $db->query("SHOW TABLES LIKE 'engine4_sesjob_jobs'")->fetch();
if (!empty($table_exist)) {
    $resource_type = $db->query("SHOW COLUMNS FROM engine4_sesjob_jobs LIKE 'resource_type'")->fetch();
    if (empty($resource_type)) {
        $db->query('ALTER TABLE `engine4_sesjob_jobs` ADD `resource_type` VARCHAR(128) NULL;');
    }
    $resource_id = $db->query("SHOW COLUMNS FROM engine4_sesjob_jobs LIKE 'resource_id'")->fetch();
    if (empty($resource_id)) {
        $db->query('ALTER TABLE `engine4_sesjob_jobs` ADD `resource_id` INT(11) NOT NULL DEFAULT "0";');
    }
    $networks = $db->query("SHOW COLUMNS FROM engine4_sesjob_jobs LIKE 'networks'")->fetch();
    if (empty($networks)) {
        $db->query('ALTER TABLE `engine4_sesjob_jobs` ADD `networks` VARCHAR(255) NULL');
    }
    $levels = $db->query("SHOW COLUMNS FROM engine4_sesjob_jobs LIKE 'levels'")->fetch();
    if (empty($levels)) {
        $db->query('ALTER TABLE `engine4_sesjob_jobs` ADD `levels` VARCHAR(255) NULL');
    }
    $cotinuereading = $db->query("SHOW COLUMNS FROM engine4_sesjob_jobs LIKE 'cotinuereading'")->fetch();
    if (empty($cotinuereading)) {
        $db->query('ALTER TABLE `engine4_sesjob_jobs` ADD `cotinuereading` TINYINT(1) NOT NULL DEFAULT \'0\';');
    }

    $continue_height = $db->query("SHOW COLUMNS FROM engine4_sesjob_jobs LIKE 'continue_height'")->fetch();
    if(empty($continue_height)) {
        $db->query('ALTER TABLE `engine4_sesjob_jobs` ADD `continue_height` INT(11) NOT NULL DEFAULT "0";');
    }
}

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    "sesjob_job" as `type`,
    "allow_levels" as `name`,
    0 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    "sesjob_job" as `type`,
    "allow_network" as `name`,
    0 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');

$db->query('DELETE FROM `engine4_core_settings` WHERE `engine4_core_settings`.`name` = "sesjob.chooselayout";');

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    "sesjob_job" as `type`,
    "continue_height" as `name`,
    3 as `value`,
    0 as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    "sesjob_job" as `type`,
    "continue_height" as `name`,
    3 as `value`,
    0 as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN("user");');


$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesjob_admin_main_industries", "sesjob", "Manage Industries", "", \'{"route":"admin_default","module":"sesjob","controller":"industries","action":"index"}\', "sesjob_admin_main", "", 999),
("sesjob_admin_main_employments", "sesjob", "Manage Employments", "", \'{"route":"admin_default","module":"sesjob","controller":"employments","action":"index"}\', "sesjob_admin_main", "", 999),
("sesjob_admin_main_educations", "sesjob", "Manage Educations", "", \'{"route":"admin_default","module":"sesjob","controller":"educations","action":"index"}\', "sesjob_admin_main", "", 999),
("sesjob_admin_main_integrateothermodule", "sesjob", "Integrate Plugins", "", \'{"route":"admin_default","module":"sesjob","controller":"integrateothermodule","action":"index"}\', "sesjob_admin_main", "", 995);');

$db->query('DROP TABLE IF EXISTS `engine4_sesjob_industries`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesjob_industries` (
`industry_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) unsigned NOT NULL,
`industry_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
`order` int(11) NOT NULL DEFAULT "0",
PRIMARY KEY (`industry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
$db->query('DROP TABLE IF EXISTS `engine4_sesjob_employments`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesjob_employments` (
`employment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`employment_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
`order` int(11) NOT NULL DEFAULT "0",
PRIMARY KEY (`employment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
$db->query('DROP TABLE IF EXISTS `engine4_sesjob_educations`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesjob_educations` (
`education_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`education_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
`order` int(11) NOT NULL DEFAULT "0",
PRIMARY KEY (`education_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
$db->query('DROP TABLE IF EXISTS `engine4_sesjob_companies`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesjob_companies` (
  `company_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` INT(11) NOT NULL,
  `company_name` varchar(128) NOT NULL,
  `company_websiteurl` varchar(128) NOT NULL,
  `company_description` TEXT NOT NULL,
  `industry_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `creation_date` DATETIME NOT NULL,
  `subscribe_count` INT(11) NOT NULL,
  `job_count` INT(11) NOT NULL,
  `enable` TINYINT(1) NOT NULL DEFAULT "1",
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
$db->query('DROP TABLE IF EXISTS `engine4_sesjob_applications`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesjob_applications` (
  `application_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` INT(11) NOT NULL,
  `job_id` INT(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `mobile_number` varchar(128) NOT NULL,
  `location` varchar(128) NOT NULL,
  `file_id` int(11) NOT NULL,
  `creation_date` DATETIME NOT NULL,
  PRIMARY KEY (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
$db->query('DROP TABLE IF EXISTS `engine4_sesjob_cpnysubscribes`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesjob_cpnysubscribes` (
  `cpnysubscribe_id` int(11) unsigned NOT NULL auto_increment,
  `resource_type` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `resource_id` int(11) unsigned NOT NULL,
  `poster_type` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `poster_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`cpnysubscribe_id`),
  KEY `resource_type` (`resource_type`, `resource_id`),
  KEY `poster_type` (`poster_type`, `poster_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;');
$db->query('DROP TABLE IF EXISTS `engine4_sesjob_integrateothermodules`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesjob_integrateothermodules` (
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


//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sesjob_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('sesjob_job', $level->level_id, array_keys($form->getValues()));

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
    $permissionsTable->setAllowed('sesjob_job', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}

$db->query("INSERT IGNORE INTO `engine4_sesjob_employments` (`employment_id`, `employment_name`, `order`) VALUES
(1, 'Full Time', 0),
(2, ' Part Time', 0),
(3, 'Contract Based', 0),
(4, 'Temporary ', 0),
(5, 'Internship ', 0),
(6, 'Commission ', 0);");

$db->query("INSERT IGNORE INTO `engine4_sesjob_industries` (`industry_id`, `user_id`, `industry_name`, `order`) VALUES
(1, 1, 'Business services', 0),
(2, 1, 'Information technology', 0),
(3, 1, 'Manufacturing ', 0),
(4, 1, 'Health care ', 0),
(5, 1, 'Finance ', 0),
(6, 1, 'Construction, repair and maintenance ', 0),
(7, 1, 'Media ', 0),
(8, 1, 'Automobiles', 0),
(9, 1, ' Banking ', 0),
(10, 1, 'Science and Technology ', 0),
(11, 1, 'Telecommunications ', 0),
(12, 1, 'Tourism and Hospitality', 0);");
$db->query("INSERT IGNORE INTO `engine4_sesjob_categories` (`category_id`, `user_id`, `category_name`, `description`, `order`, `title`, `slug`, `subcat_id`, `subsubcat_id`, `thumbnail`, `cat_icon`, `colored_icon`, `color`, `profile_type_review`, `profile_type`, `sejob_categoryid`, `member_levels`) VALUES
(14, 0, 'Airlines', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 1, 'Airlines', 'airlines', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6'),
(15, 0, 'Automation Jobs', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 2, 'Automation Jobs', 'automation-jobs', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6'),
(16, 0, 'Electronics Job', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 3, 'Electronics Job', 'electronics-job', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6'),
(17, 0, 'Telecom Jobs', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 4, 'Telecom Jobs', 'telecom-jobs', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6'),
(18, 0, 'Cloud Computing Jobs ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 5, 'Cloud Computing Jobs ', 'cloud-computing-jobs-', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6'),
(19, 0, 'Sales Job ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 6, '', 'sales-job-', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6'),
(20, 0, 'Data Analytics Jobs ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 7, 'Data Analytics Jobs ', 'data-analytics-jobs-', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6'),
(21, 0, 'Graphic Designer Jobs ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 8, 'Graphic Designer Jobs ', 'graphic-designer-jobs-', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6'),
(22, 0, 'HR Jobs ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 9, 'HR Jobs ', 'hr-jobs-', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6'),
(23, 0, 'Testing Jobs ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 10, 'Testing Jobs ', 'testing-jobs-', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6'),
(24, 0, 'Digital Marketing Jobs ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 11, 'Digital Marketing Jobs ', 'digital-marketing-jobs-', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6'),
(25, 0, 'Content Writing Jobs ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 12, 'Content Writing Jobs ', 'content-writing-jobs-', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6'),
(26, 0, 'Bank Jobs ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et erat blandit, congue quam vel, dignissim eros. Quisque vitae velit id mauris pharetra blandit. Praesent in tellus urna. Etiam id lorem eget magna finibus maximus. Cras feugiat nisl nec ante feugiat luctus.', 13, 'Bank Jobs ', 'bank-jobs-', 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, '1,2,3,4,6');");
$db->query("INSERT IGNORE INTO `engine4_sesjob_educations` (`education_id`, `education_name`, `order`) VALUES
(1, 'Bachelor of Commerce', 0),
(2, 'Bachelor of Computer Applications ', 0),
(3, 'Bachelor of Science', 0),
(4, 'Bachelor of Engineering ', 0),
(5, 'Bachelor of Management ', 0),
(6, 'Bachelor of Philosophy', 0),
(7, 'Bachelor of Technology ', 0),
(8, 'Bachelor of Arts', 0),
(9, 'Bachelor of Business Administration', 0),
(10, 'Bachelor of Laws', 0),
(19, 'Bachelor of Education', 0);");
