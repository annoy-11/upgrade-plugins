<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Document Home Page
$select = $db->select()
            ->from('engine4_core_pages')
            ->where('name = ?', 'edocument_index_home')
            ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'edocument_index_home',
    'displayname' => 'SES - Advanced Document - Documents Home Page',
    'title' => 'Document Home',
    'description' => 'This is the document home page.',
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
    'name' => 'edocument.browse-menu',
    'parent_content_id' => $topmiddle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'edocument.featured-sponsored-verified-category-slideshow',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"category":"0","criteria":"2","order":"","info":"most_liked","isfullwidth":"0","autoplay":"1","speed":"2000","type":"slide","navigation":"nextprev","show_criteria":["like","comment","favourite","view","title","by","rating","ratingStar","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing","creationDate"],"title_truncation":"45","height":"400","limit_data":"12","title":"Sponsored Document Posts","nomobile":"0","name":"edocument.featured-sponsored-verified-category-slideshow"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'edocument.tabbed-widget-document',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","simplelist","advlist","grid","advgrid","supergrid","pinboard","map"],"openViewType":"list","tabOption":"advance","htmlTitle":"1","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","location","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","readmore","creationDate","descriptionlist","descriptiongrid","descriptionpinboard","descriptionsimplelist","descriptionadvlist","descriptionadvgrid","descriptionsupergrid","enableCommentPinboard"],"show_limited_data":"no","pagging":"pagging","title_truncation_grid":"40","title_truncation_list":"50","title_truncation_simplelist":"45","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_supergrid":"45","title_truncation_pinboard":"30","limit_data_pinboard":"12","limit_data_list":"6","limit_data_grid":"15","limit_data_simplelist":"10","limit_data_advlist":"10","limit_data_advgrid":"10","limit_data_supergrid":"9","description_truncation_list":"190","description_truncation_grid":"160","description_truncation_simplelist":"300","description_truncation_advlist":"300","description_truncation_advgrid":"160","description_truncation_supergrid":"160","description_truncation_pinboard":"160","height_grid":"200","width_grid":"307","height_list":"230","width_list":"350","height_simplelist":"230","width_simplelist":"260","height_advgrid":"400","width_advgrid":"460","height_supergrid":"220","width_supergrid":"307","width_pinboard":"300","search_type":["mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","week","month","featured","sponsored","verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"edocument.tabbed-widget-document"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'edocument.of-the-day',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid1","fixHover":"fix","show_criteria":["title","like","view","comment","favourite","rating","ratingStar","by","favouriteButton","likeButton","featuredLabel","verifiedLabel","socialSharing"],"title_truncation":"20","description_truncation":"60","height":"180","width":"180","title":"Document of the Day","nomobile":"0","name":"edocument.of-the-day"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'edocument.featured-sponsored',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"rounded","criteria":"5","order":"","info":"recently_created","show_criteria":["title","category"],"show_star":"0","showLimitData":"1","title_truncation":"20","description_truncation":"60","height":"70","width":"70","limit_data":"4","title":"Recent Documents","nomobile":"0","name":"edocument.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'edocument.featured-sponsored',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"most_viewed","show_criteria":["view","title"],"show_star":"1","showLimitData":"1","title_truncation":"15","description_truncation":"60","height":"60","width":"70","limit_data":"3","title":"Most Read Documents","nomobile":"0","name":"edocument.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'edocument.tag-cloud-category',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#00f","showType":"simple","text_height":"15","height":"300","itemCountPerPage":"12","title":"Categories","nomobile":"0","name":"edocument.tag-cloud-category"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'edocument.tag-cloud-documents',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#00f","type":"cloud","text_height":"15","height":"170","itemCountPerPage":"20","title":"Popular Tags","nomobile":"0","name":"edocument.tag-cloud-documents"}',
  ));

}

//Document Browse Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'edocument_index_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'edocument_index_browse',
    'displayname' => 'SES - Advanced Document - Browse Documents Page',
    'title' => 'Document Browse',
    'description' => 'This page lists document entries.',
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
    'name' => 'edocument.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.category-carousel',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title_truncation_grid":"45","description_truncation_grid":"45","height":"300","width":"388","autoplay":"1","speed":"2000","criteria":"alphabetical","show_criteria":["title","description","countDocuments","socialshare"],"isfullwidth":"0","limit_data":"12","title":"Categories","nomobile":"0","name":"edocument.category-carousel"}',
  ));

  // Insert search
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.alphabet-search',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert gutter menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.browse-documents',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","simplelist","advlist","grid","advgrid","supergrid","pinboard","map"],"openViewType":"advgrid","show_criteria":["verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","ratingStar","rating","view","title","category","by","readmore","creationDate","location","descriptionlist","descriptiongrid","descriptionpinboard","descriptionsimplelist","descriptionadvlist","descriptionadvgrid","descriptionsupergrid","enableCommentPinboard"],"sort":"recentlySPcreated","show_item_count":"1","title_truncation_list":"100","title_truncation_grid":"100","title_truncation_pinboard":"30","title_truncation_simplelist":"45","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_supergrid":"45","description_truncation_list":"300","description_truncation_grid":"150","description_truncation_pinboard":"150","description_truncation_simplelist":"150","description_truncation_advlist":"150","description_truncation_advgrid":"150","description_truncation_supergrid":"200","height_list":"230","width_list":"461","height_grid":"270","width_grid":"307","height_simplelist":"230","width_simplelist":"260","height_advgrid":"230","width_advgrid":"461","height_supergrid":"250","width_supergrid":"461","width_pinboard":"280","limit_data_pinboard":"12","limit_data_grid":"12","limit_data_list":"12","limit_data_simplelist":"12","limit_data_advlist":"12","limit_data_advgrid":"12","limit_data_supergrid":"12","pagging":"button","title":"","nomobile":"0","name":"edocument.browse-documents"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid1","imageType":"square","criteria":"5","order":"","info":"recently_created","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","likeButton","favouriteButton"],"show_star":"0","showLimitData":"1","title_truncation":"45","description_truncation":"60","height":"180","width":"180","limit_data":"1","title":"Verified Document","nomobile":"0","name":"edocument.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.browse-menu-quick',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"edocument.browse-search"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"most_commented","show_criteria":["like","comment","favourite","view","title"],"show_star":"0","showLimitData":"0","title_truncation":"20","description_truncation":"60","height":"60","width":"60","limit_data":"5","title":"Most Commented Documents","nomobile":"0","name":"edocument.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.tag-cloud-documents',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#4a4444","type":"cloud","text_height":"15","height":"170","itemCountPerPage":"20","title":"Popular Tags","nomobile":"0","name":"edocument.tag-cloud-documents"}',
  ));
}

//Browse Categories Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'edocument_category_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {

  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'edocument_category_browse',
      'displayname' => 'SES - Advanced Document - Browse Categories Page',
      'title' => 'Document Browse Category',
      'description' => 'This page lists document categories.',
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
      'name' => 'edocument.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));
  $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Edocument' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "category" . DIRECTORY_SEPARATOR;
  if (is_file($PathFile . "banner" . DIRECTORY_SEPARATOR . 'category.jpg')) {
    if (!file_exists(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin')) {
      mkdir(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin', 0777, true);
    }
    copy($PathFile . "banner" . DIRECTORY_SEPARATOR . 'category.jpg', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin/document-category-banner.jpg');
    $category_banner = 'public/admin/document-category-banner.jpg';
  } else {
    $category_banner = '';
  }
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'edocument.banner-category',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"description":"Discover top-notch documents, creators, and collections related to your interests, hand-selected by our 100-percent-human curation team.","edocument_categorycover_photo":"' . $category_banner . '","title":"Categories","nomobile":"0","name":"edocument.banner-category"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'edocument.document-category-icons',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"titleC":"Popular Categories","height":"150","width":"180","alignContent":"center","criteria":"admin_order","show_criteria":["title","countDocuments"],"limit_data":"12","title":"","nomobile":"0","name":"edocument.document-category-icons"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'edocument.category-associate-document',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["like","comment","rating","ratingStar","view","title","favourite","by","featuredLabel","sponsoredLabel","creationDate","readmore"],"popularity_document":"like_count","pagging":"button","count_document":"1","criteria":"alphabetical","category_limit":"5","document_limit":"5","document_description_truncation":"45","seemore_text":"+ See all [category_name]","allignment_seeall":"left","height":"160","width":"250","title":"","nomobile":"0","name":"edocument.category-associate-document"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'edocument.of-the-day',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid1","fixHover":"hover","show_criteria":["title","like","view","comment","favourite","rating","ratingStar","by","favouriteButton","likeButton","featuredLabel","verifiedLabel","socialSharing"],"title_truncation":"45","description_truncation":"60","height":"180","width":"180","title":"Document of the Day","nomobile":"0","name":"edocument.of-the-day"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'edocument.sidebar-tabbed-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":"list","show_criteria":["location","like","favourite","comment","view","title","category","by","creationDate"],"show_limited_data":"no","pagging":"button","title_truncation_grid":"45","title_truncation_list":"20","limit_data_list":"3","limit_data_grid":"10","description_truncation_grid":"45","height_grid":"270","width_grid":"389","height_list":"60","width_list":"60","search_type":["week","month"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"Documents Created","nomobile":"0","name":"edocument.sidebar-tabbed-widget"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'edocument.tag-cloud-documents',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"color":"#00f","type":"tab","text_height":"15","height":"300","itemCountPerPage":"21","title":"Trending Tags","nomobile":"0","name":"edocument.tag-cloud-documents"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'edocument.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"recently_created","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","likeButton","favouriteButton"],"show_star":"0","showLimitData":"1","title_truncation":"20","description_truncation":"60","height":"50","width":"50","limit_data":"3","title":"Recent Posts","nomobile":"0","name":"edocument.featured-sponsored"}'
  ));


  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'edocument.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","imageType":"rounded","criteria":"5","order":"","info":"most_favourite","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","likeButton","favouriteButton"],"show_star":"0","showLimitData":"0","title_truncation":"20","description_truncation":"60","height":"60","width":"60","limit_data":"3","title":"Most Favourite Documents","nomobile":"0","name":"edocument.featured-sponsored"}'
  ));
}

//Manage Documents Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'edocument_index_manage')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'edocument_index_manage',
    'displayname' => 'SES - Advanced Document - Manage Documents Page',
    'title' => 'My Document Entries',
    'description' => 'This page lists a user\'s document entries.',
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
    'name' => 'edocument.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.manage-documents',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Document Create Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'edocument_index_create')
  ->limit(1)
  ->query()
  ->fetchColumn();

if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'edocument_index_create',
    'displayname' => 'SES - Advanced Document - Document Create Page',
    'title' => 'Write New Document',
    'description' => 'This page is the document create page.',
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
    'name' => 'edocument.browse-menu',
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
            ->where('name = ?', 'edocument_index_tags')
            ->limit(1)
            ->query()
            ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'edocument_index_tags',
    'displayname' => 'SES - Advanced Document - Browse Tags Page',
    'title' => 'Document Browse Tags Page',
    'description' => 'This page displays the document tags.',
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
    'name' => 'edocument.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.tag-documents',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Document Profile Page Design
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'edocument_index_view')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'edocument_index_view',
    'displayname' => 'SES - Advanced Document - Document Profile Page',
    'title' => 'Document View',
    'description' => 'This page displays a document entry.',
    'provides' => 'subject=edocument',
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
    'name' => 'edocument.breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.view-document',
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
    'name' => 'edocument.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.labels',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.like-button',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.favourite-button',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.advance-share',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"edocument.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.similar-documents',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","by","favouriteButton","likeButton","socialSharing"],"showLimitData":"0","height":"200","width":"294","list_title_truncation":"45","limit_data":"3","title":"Related Documents","nomobile":"0","name":"edocument.similar-documents"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'edocument.sidebar-tabbed-widget',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":"list","show_criteria":["title","category","by"],"show_limited_data":"yes","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","limit_data_list":"5","limit_data_grid":"10","description_truncation_grid":"45","height_grid":"270","width_grid":"389","height_list":"60","width_list":"60","search_type":["recentlySPcreated","mostSPviewed"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recent Documents","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Popular Documents","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"edocument.sidebar-tabbed-widget"}',
  ));

}

//Category View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'edocument_category_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'edocument_category_index',
      'displayname' => 'SES - Advanced Document - Document Category View Page',
      'title' => 'Document Category View Page',
      'description' => 'This page lists document category view page.',
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
      'name' => 'edocument.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'edocument.category-view',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid","show_subcat":"1","show_subcatcriteria":["icon","title","countDocument"],"heightSubcat":"160","widthSubcat":"290","textDocument":"Documents we like","show_criteria":["featuredLabel","sponsoredLabel","like","comment","rating","ratingStar","favourite","view","title","by","description","readmore","creationDate"],"pagging":"button","description_truncation":"150","document_limit":"12","height":"200","width":"294","title":"","nomobile":"0","name":"edocument.category-view"}'
  ));
}
