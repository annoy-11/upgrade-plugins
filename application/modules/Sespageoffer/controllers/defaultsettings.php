<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Offer Browse Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespageoffer_index_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sespageoffer_index_browse',
      'displayname' => 'SES - Page Offers Extension - Browse Offers Page',
      'title' => 'Browse Offers',
      'description' => 'This page lists offers.',
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
      'name' => 'sespage.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespageoffer.carousel',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"horizontal","info":"like_count","show_criteria":["title","pagename","description","likecount","followcount","favouritecount","commentcount","viewcount","totalquantitycount","offerlink","offertypevalue","getofferlink","featured","hot","new","likeButton","favouriteButton","followButton","griddescription","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","grid_title_truncation":"45","grid_description_truncation":"100","imageheight":"150","width":"335","limit_data":"3","title":"","nomobile":"0","name":"sespageoffer.carousel"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespageoffer.browse-notes',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","grid"],"openViewType":"grid","show_criteria":["title","by","pagename","description","posteddate","likecount","followcount","favouritecount","commentcount","viewcount","totalquantitycount","offerlink","offertypevalue","showcouponcode","claimedcount","remainingcount","getofferlink","featured","hot","new","likeButton","favouriteButton","followButton","listdescription","griddescription","socialSharing"],"pagging":"auto_load","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"230","width":"260","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"250","width_grid":"389","title":"","nomobile":"0","name":"sespageoffer.browse-offers"}',
  ));

  // Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespageoffer.browse-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","featured","hot","new"],"default_search_type":"recentlySPcreated","title":"","nomobile":"0","name":"sespageoffer.browse-search"}',
  ));

  // Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespageoffer.popular-offers',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid","info":"creation_date","show_criteria":["title","pagename","description","followcount","offertypevalue","getofferlink","likeButton","favouriteButton","followButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"20","height_grid":"160","width_grid":"250","limit_data":"3","title":"Most Followed Offers","nomobile":"0","name":"sespageoffer.popular-offers"}',
  ));
  // Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesbasic.column-layout-width',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"layoutColumnWidthType":"px","columnWidth":"280","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
  ));
}

//Offer Home Page
$select = $db->select()
        ->from('engine4_core_pages')
        ->where('name = ?', 'sespageoffer_index_home')
        ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sespageoffer_index_home',
      'displayname' => 'SES - Page Offers Extension - Offer Home Page',
      'title' => 'Offer Home',
      'description' => 'This is the offer home page.',
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
      'name' => 'left',
      'parent_content_id' => $container_id,
      'order' => 4,
      'params' => '',
  ));
  $left_id = $db->lastInsertId('engine4_core_content');

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
      'name' => 'sespage.browse-menu',
      'parent_content_id' => $topmiddle_id,
      'order' => $widgetOrder++,
  ));

    $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'sespageoffer.offer-home-error',
        'parent_content_id' => $topmiddle_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespageoffer.of-the-day',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Offer of the Day","show_criteria":["title","pagename","totalquantitycount","offerlink","offertypevalue","showcouponcode","getofferlink"],"height_grid":"160","width_grid":"160","grid_title_truncation":"45","grid_description_truncation":"60","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","nomobile":"0","name":"sespageoffer.of-the-day"}',
    ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespageoffer.popular-offers',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"hot","show_criteria":["title","pagename","description","likecount","followcount","favouritecount","commentcount","offertypevalue","getofferlink","hot","likeButton","favouriteButton","followButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"160","width_grid":"250","limit_data":"3","title":"Only Hot Offers","nomobile":"0","name":"sespageoffer.popular-offers"}',
    ));
        $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespageoffer.popular-offers',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"new","show_criteria":["title","pagename","offertypevalue","getofferlink","new"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"160","width_grid":"250","limit_data":"3","title":"New Offers","nomobile":"0","name":"sespageoffer.popular-offers"}',
  ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespageoffer.popular-offers',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"featured","show_criteria":["title","pagename","totalquantitycount","offertypevalue","showcouponcode","getofferlink","featured","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"160","width_grid":"250","limit_data":"3","title":"Only Featured Offers","nomobile":"0","name":"sespageoffer.popular-offers"}',
    ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespageoffer.slideshow',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"creation_date","show_criteria":["title","by","pagename","description","posteddate","likecount","followcount","favouritecount","commentcount","viewcount","totalquantitycount","offerlink","offertypevalue","showcouponcode","claimedcount","remainingcount","getofferlink","featured","hot","new","likeButton","favouriteButton","followButton","griddescription","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","limit_data":"10","title_truncation":"45","grid_description_truncation":"45","height":"230","width":"260","title":"","nomobile":"0","name":"sespageoffer.slideshow"}',
  ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespageoffer.tabbed-widget-offer',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","grid"],"openViewType":"list","tabOption":"advance","show_criteria":["title","by","pagename","description","posteddate","likecount","followcount","favouritecount","commentcount","viewcount","totalquantitycount","offerlink","offertypevalue","showcouponcode","claimedcount","remainingcount","getofferlink","featured","hot","new","likeButton","favouriteButton","followButton","listdescription","griddescription","socialSharing"],"pagging":"auto_load","show_limited_data":"no","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","htmlTitle":"1","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"230","width":"260","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"240","width_grid":"384","search_type":["recentlySPcreated","mostSPliked","mostSPcommented","mostSPviewed","mostSPfavourite","mostSPfollowed","new","featured","hot"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPliked_order":"2","mostSPliked_label":"Most Liked","dummy3":null,"mostSPcommented_order":"3","mostSPcommented_label":"Most Commented","dummy4":null,"mostSPviewed_order":"4","mostSPviewed_label":"Most Viewed","dummy5":null,"new_order":"5","new_label":"New","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"hot_order":"8","hot_label":"Hot","dummy9":null,"favourite_order":"9","favourite_label":"Most Favourite","dummy10":null,"followed_order":"10","followed_label":"Most Followed","title":"","nomobile":"0","name":"sespageoffer.tabbed-widget-offer"}',
  ));


    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespageoffer.browse-offer-button',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
  ));

      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespageoffer.popular-offers',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"like_count","show_criteria":["title","pagename","description","likecount","followcount","favouritecount","offertypevalue","showcouponcode","getofferlink","likeButton","favouriteButton","followButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"20","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"160","width_grid":"250","limit_data":"3","title":"Most Liked Offers","nomobile":"0","name":"sespageoffer.popular-offers"}',
  ));

      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespageoffer.popular-offers',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"comment_count","show_criteria":["title","by","likecount","followcount","commentcount","offertypevalue","likeButton","favouriteButton","followButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"160","width_grid":"250","limit_data":"3","title":"Most Commented offers","nomobile":"0","name":"sespageoffer.popular-offers"}',
  ));
      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespageoffer.popular-offers',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"favourite_count","show_criteria":["title","by","likecount","followcount","favouritecount","offertypevalue","getofferlink","likeButton","favouriteButton","followButton","griddescription"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"160","width_grid":"250","limit_data":"3","title":"Most Favourite Offers","nomobile":"0","name":"sespageoffer.popular-offers"}',
  ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespageoffer.popular-offers',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"view_count","show_criteria":["title","pagename","viewcount","offertypevalue","getofferlink","likeButton","favouriteButton","followButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"160","width_grid":"250","limit_data":"3","title":"Most Viewed Offers","nomobile":"0","name":"sespageoffer.popular-offers"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sesbasic.column-layout-width',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"layoutColumnWidthType":"px","columnWidth":"250","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
    ));
}

// offer create page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sespageoffer_index_create')
    ->limit(1)
    ->query()
    ->fetchColumn();

if( !$pageId ) {

    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sespageoffer_index_create',
        'displayname' => 'SES - Page Offers Extension - Page Offer Create Page',
        'title' => 'Create Offer',
        'description' => 'This page is the offer create page.',
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

    // Insert top-middle
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $pageId,
        'parent_content_id' => $topId,
    ));
    $topMiddleId = $db->lastInsertId();

    // Insert main-middle
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $pageId,
        'parent_content_id' => $mainId,
        'order' => 2,
    ));
    $mainMiddleId = $db->lastInsertId();

    // Insert menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sespage.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => 1,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => 1,
    ));
}

// offer create page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sespageoffer_index_edit')
    ->limit(1)
    ->query()
    ->fetchColumn();

if( !$pageId ) {

    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sespageoffer_index_edit',
        'displayname' => 'SES - Page Offers Extension - Page Offer Edit Page',
        'title' => 'Edit Offer',
        'description' => 'This page is the offer edit page.',
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

    // Insert top-middle
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $pageId,
        'parent_content_id' => $topId,
    ));
    $topMiddleId = $db->lastInsertId();

    // Insert main-middle
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $pageId,
        'parent_content_id' => $mainId,
        'order' => 2,
    ));
    $mainMiddleId = $db->lastInsertId();

    // Insert menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sespage.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => 1,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => 1,
    ));
}

// offer profile page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sespageoffer_index_view')
    ->limit(1)
    ->query()
    ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sespageoffer_index_view',
        'displayname' => 'SES - Page Offers Extension - Page Offer View Page',
        'title' => 'Page Offer View',
        'description' => 'This page displays a offer entry.',
        'provides' => 'subject=pageoffer',
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
    ));
    $mainId = $db->lastInsertId();

    // Insert top-middle
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $pageId,
        'parent_content_id' => $topId,
    ));
    $topMiddleId = $db->lastInsertId();

    // Insert left
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'left',
        'page_id' => $pageId,
        'parent_content_id' => $mainId,
        'order' => 2,
    ));
    $leftId = $db->lastInsertId();

    // Insert middle
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $pageId,
        'parent_content_id' => $mainId,
        'order' => 3,
    ));
    $middleId = $db->lastInsertId();

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sespageoffer.profile-breadcrumb',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => $widgetOrder++,
    ));

    // Insert gutter
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sespageoffer.profile-gutter-photo',
        'page_id' => $pageId,
        'parent_content_id' => $leftId,
        'order' => $widgetOrder++,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sespageoffer.profile-gutter-menu',
        'page_id' => $pageId,
        'parent_content_id' => $leftId,
        'order' => $widgetOrder++,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sespageoffer.profile-view-page',
        'page_id' => $pageId,
        'parent_content_id' => $middleId,
        'order' => $widgetOrder++,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.comments',
        'page_id' => $pageId,
        'parent_content_id' => $middleId,
        'order' => $widgetOrder++,
    ));
}

// //profile page
// $page_id = $db->select()
//             ->from('engine4_core_pages', 'page_id')
//             ->where('name = ?', 'sespage_profile_index_1')
//             ->limit(1)
//             ->query()
//             ->fetchColumn();
// $tab_id =  $db->select()
//             ->where('type = ?', 'widget')
//             ->from('engine4_core_content', 'content_id')
//             ->where('name = ?', 'core.container-tabs')
//             ->where('page_id = ?', $page_id)
//             ->limit(1)
//             ->query()
//             ->fetchColumn();
// // insert if it doesn't exist yet
// if ($page_id) {
//     $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'sespageoffer.team',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => 35,
//     'params' => '{"sesteam_template":"1","sesteam_contentshow":["displayname","photo","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"deslimit":"100","viewMoreText":"View Details","height":"200","width":"200","center_block":"1","center_description":"1","title":"Teams","nomobile":"0","name":"sespageoffer.team"}',
//     ));
// }
//
// // profile page
// $page_id = $db->select()
//             ->from('engine4_core_pages', 'page_id')
//             ->where('name = ?', 'sespage_profile_index_2')
//             ->limit(1)
//             ->query()
//             ->fetchColumn();
// $tab_id =  $db->select()
//                 ->where('type = ?', 'widget')
//                 ->from('engine4_core_content', 'content_id')
//                 ->where('name = ?', 'core.container-tabs')
//                 ->where('page_id = ?', $page_id)
//                 ->limit(1)
//                 ->query()
//                 ->fetchColumn();
// // insert if it doesn't exist yet
// if ($page_id){
//     $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'sespageoffer.team',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => 35,
//     'params' => '{"sesteam_template":"1","sesteam_contentshow":["displayname","photo","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"deslimit":"100","viewMoreText":"View Details","height":"200","width":"200","center_block":"1","center_description":"1","title":"Teams","nomobile":"0","name":"sespageoffer.team"}',
//     ));
// }
// // profile page
// $page_id = $db->select()
//             ->from('engine4_core_pages', 'page_id')
//             ->where('name = ?', 'sespage_profile_index_3')
//             ->limit(1)
//             ->query()
//             ->fetchColumn();
// $tab_id =  $db->select()
//                 ->where('type = ?', 'widget')
//                 ->from('engine4_core_content', 'content_id')
//                 ->where('name = ?', 'core.container-tabs')
//                 ->where('page_id = ?', $page_id)
//                 ->limit(1)
//                 ->query()
//                 ->fetchColumn();
// if ($page_id){
//     $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'sespageoffer.team',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => 35,
//     'params' => '{"sesteam_template":"1","sesteam_contentshow":["displayname","photo","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"deslimit":"100","viewMoreText":"View Details","height":"200","width":"200","center_block":"1","center_description":"1","title":"Teams","nomobile":"0","name":"sespageoffer.team"}',
//     ));
// }
//
// // profile page
// $page_id = $db->select()
//                 ->from('engine4_core_pages', 'page_id')
//                 ->where('name = ?', 'sespage_profile_index_4')
//                 ->limit(1)
//                 ->query()
//                 ->fetchColumn();
// $tab_id =  $db->select()
//             ->where('type = ?', 'widget')
//             ->from('engine4_core_content', 'content_id')
//             ->where('name = ?', 'core.container-tabs')
//             ->where('page_id = ?', $page_id)
//             ->limit(1)
//             ->query()
//             ->fetchColumn();
// if ($page_id){
//     $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'sespageoffer.team',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => 35,
//     'params' => '{"sesteam_template":"1","sesteam_contentshow":["displayname","photo","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"deslimit":"100","viewMoreText":"View Details","height":"200","width":"200","center_block":"1","center_description":"1","title":"Teams","nomobile":"0","name":"sespageoffer.team"}',
//     ));
// }
//
// //Page Team View Page
// $page_id = $db->select()
//         ->from('engine4_core_pages', 'page_id')
//         ->where('name = ?', 'sespageoffer_index_view')
//         ->limit(1)
//         ->query()
//         ->fetchColumn();
// if (!$page_id) {
//   $widgetOrder = 1;
//   //Insert page
//   $db->insert('engine4_core_pages', array(
//       'name' => 'sespageoffer_index_view',
//       'displayname' => 'SES - Page Team Showcase Extension - Page Team Profile Page',
//       'title' => 'Page Team View Page',
//       'description' => 'This is the page team profile page.',
//       'custom' => 0,
//   ));
//   $page_id = $db->lastInsertId();
//
//   //Insert top
//   $db->insert('engine4_core_content', array(
//       'type' => 'container',
//       'name' => 'top',
//       'page_id' => $page_id,
//       'order' => 1,
//   ));
//   $top_id = $db->lastInsertId();
//
//   //Insert main
//   $db->insert('engine4_core_content', array(
//       'type' => 'container',
//       'name' => 'main',
//       'page_id' => $page_id,
//       'order' => 2,
//   ));
//   $main_id = $db->lastInsertId();
//
//   //Insert main-middle
//   $db->insert('engine4_core_content', array(
//       'type' => 'container',
//       'name' => 'middle',
//       'page_id' => $page_id,
//       'parent_content_id' => $main_id,
//       'order' => 2,
//   ));
//   $main_middle_id = $db->lastInsertId();
//
//
//   //Insert content
//   $db->insert('engine4_core_content', array(
//     'type' => 'widget',
//     'name' => 'sespageoffer.viewpage-team',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"infoshow":["featured","sponsored","profilePhoto","displayname","designation","description","detaildescription","email","phone","location","website","facebook","linkdin","twitter","googleplus"],"title":"","nomobile":"0","name":"sespageoffer.viewpage-team"}',
//   ));
// }


//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sespageoffer_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('sespageoffer', $level->level_id, array_keys($form->getValues()));

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
    $permissionsTable->setAllowed('sespageoffer', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}
