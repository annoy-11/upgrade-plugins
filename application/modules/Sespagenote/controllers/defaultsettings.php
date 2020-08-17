<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Note Browse Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespagenote_index_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sespagenote_index_browse',
      'displayname' => 'SES - Page Notes Extension - Browse Notes Page',
      'title' => 'Browse Notes',
      'description' => 'This page lists notes.',
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
      'name' => 'sespagenote.carousel',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"vertical","info":"like_count","show_criteria":["title","by","posteddate","description","likecount","commentcount","favouritecount","viewcount","featured","sponsored","likeButton","favouriteButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","grid_title_truncation":"45","grid_description_truncation":"100","imageheight":"180","width":"180","limit_data":"5","title":"","nomobile":"0","name":"sespagenote.carousel"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagenote.browse-notes',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","grid"],"openViewType":"grid","show_criteria":["title","by","description","posteddate","pagename","likecount","commentcount","favouritecount","viewcount","featured","sponsored","likeButton","favouriteButton","listdescription","griddescription","socialSharing"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"230","width":"260","dummy17":null,"limit_data_grid":"5","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"270","width_grid":"389","title":"","nomobile":"0","name":"sespagenote.browse-notes"}',
  ));

  // Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagenote.browse-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","featured","sponsored"],"default_search_type":"recentlySPcreated","title":"","nomobile":"0","name":"sespagenote.browse-search"}',
  ));

  // Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagenote.popular-notes',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"creation_date","show_criteria":["title","posteddate","pagename","likecount","commentcount","favouritecount","viewcount","likeButton","favouriteButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"20","height_grid":"160","width_grid":"250","limit_data":"3","title":"Most Recent","nomobile":"0","name":"sespagenote.popular-notes"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagenote.recently-viewed-item',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid","criteria":"on_site","show_criteria":["title","pagename","likecount","commentcount","favouritecount","viewcount","likeButton","favouriteButton","griddescription","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"10","grid_title_truncation":"20","grid_description_truncation":"45","height_grid":"160","width_grid":"250","limit_data":"3","title":"Recently Viewed","nomobile":"0","name":"sespagenote.recently-viewed-item"}',
  ));
}

//Note Home Page
$select = $db->select()
        ->from('engine4_core_pages')
        ->where('name = ?', 'sespagenote_index_home')
        ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sespagenote_index_home',
      'displayname' => 'SES - Page Notes Extension - Note Home Page',
      'title' => 'Note Home',
      'description' => 'This is the note home page.',
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
        'name' => 'sespagenote.note-home-error',
        'parent_content_id' => $topmiddle_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagenote.of-the-day',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Note of the Day","show_criteria":["title","pagename","viewcount","likecount","griddescription","commentcount","favouritecount","featured","sponsored","socialSharing","likeButton","favouriteButton"],"height_grid":"160","width_grid":"160","grid_title_truncation":"45","grid_description_truncation":"20","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","nomobile":"0","name":"sespagenote.of-the-day"}',
    ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagenote.popular-notes',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"featured","show_criteria":["title","posteddate","pagename","likecount","commentcount","favouritecount","featured","likeButton","griddescription","favouriteButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"15","height_grid":"160","width_grid":"250","limit_data":"3","title":"Only Featured","nomobile":"0","name":"sespagenote.popular-notes"}',
    ));
        $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagenote.popular-notes',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"sponsored","show_criteria":["title","pagename","likecount","commentcount","favouritecount","viewcount","sponsored","likeButton","griddescription","favouriteButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"20","height_grid":"160","width_grid":"250","limit_data":"3","title":"Only Sponsored","nomobile":"0","name":"sespagenote.popular-notes"}',
  ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagenote.popular-notes',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"creation_date","show_criteria":["title","posteddate","pagename","likecount","commentcount","favouritecount","viewcount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"30","height_grid":"160","width_grid":"250","limit_data":"3","title":"Most Recent Notes","nomobile":"0","name":"sespagenote.popular-notes"}',
    ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagenote.carousel',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"horizontal","info":"creation_date","show_criteria":["title","posteddate","description","likecount","commentcount","favouritecount","viewcount","featured","sponsored","likeButton","favouriteButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","grid_title_truncation":"45","grid_description_truncation":"45","imageheight":"150","width":"335","limit_data":"3","title":"","nomobile":"0","name":"sespagenote.carousel"}',
    ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagenote.tabbed-widget-note',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","grid"],"openViewType":"list","tabOption":"advance","show_criteria":["title","by","description","pagename","posteddate","likecount","commentcount","favouritecount","viewcount","featured","sponsored","likeButton","favouriteButton","listdescription","griddescription","socialSharing"],"pagging":"button","show_limited_data":"no","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","htmlTitle":"1","dummy15":null,"limit_data_list":"5","list_title_truncation":"45","list_description_truncation":"100","height":"230","width":"260","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"240","width_grid":"384","search_type":["recentlySPcreated","mostSPliked","mostSPcommented","mostSPviewed","mostSPfavourite","featured","sponsored"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPliked_order":"2","mostSPliked_label":"Most Liked","dummy3":null,"mostSPcommented_order":"3","mostSPcommented_label":"Most Commented","dummy4":null,"mostSPviewed_order":"4","mostSPviewed_label":"Most Viewed","dummy5":null,"mostSPfavourite_order":"5","mostSPfavourite_label":"Most Favourited","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","title":"","nomobile":"0","name":"sespagenote.tabbed-widget-note"}',
    ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagenote.browse-note-button',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagenote.popular-notes',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"like_count","show_criteria":["title","posteddate","pagename","likecount","likeButton","griddescription","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"20","height_grid":"160","width_grid":"250","limit_data":"3","title":"Most Liked Notes","nomobile":"0","name":"sespagenote.popular-notes"}',
    ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagenote.popular-notes',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"comment_count","show_criteria":["title","by","commentcount","favouritecount","viewcount","likeButton","favouriteButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"160","width_grid":"250","limit_data":"3","title":"Most Commented Notes","nomobile":"0","name":"sespagenote.popular-notes"}',
    ));

      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagenote.popular-notes',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"view_count","show_criteria":["title","viewcount","likeButton","griddescription","favouriteButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"10","height_grid":"160","width_grid":"250","limit_data":"3","title":"Most Viewed Notes","nomobile":"0","name":"sespagenote.popular-notes"}',
  ));
      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagenote.popular-notes',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","info":"favourite_count","show_criteria":["title","by","likecount","commentcount","favouritecount","viewcount","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","list_title_truncation":"45","grid_title_truncation":"45","grid_description_truncation":"25","height_grid":"160","width_grid":"250","limit_data":"3","title":"Most Favourite Notes","nomobile":"0","name":"sespagenote.popular-notes"}',
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

// note create page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sespagenote_index_create')
    ->limit(1)
    ->query()
    ->fetchColumn();

if( !$pageId ) {

    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sespagenote_index_create',
        'displayname' => 'SES - Page Note Extension - Page Note Create Page',
        'title' => 'Create Note',
        'description' => 'This page is the note create page.',
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

// note create page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sespagenote_index_edit')
    ->limit(1)
    ->query()
    ->fetchColumn();

if( !$pageId ) {

    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sespagenote_index_edit',
        'displayname' => 'SES - Page Note Extension - Page Note Edit Page',
        'title' => 'Edit Note',
        'description' => 'This page is the note edit page.',
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

// note profile page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sespagenote_index_view')
    ->limit(1)
    ->query()
    ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sespagenote_index_view',
        'displayname' => 'SES - Page Note Extension - Page Note View Page',
        'title' => 'Page Note View',
        'description' => 'This page displays a note entry.',
        'provides' => 'subject=pagenote',
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
        'name' => 'sespagenote.profile-breadcrumb',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => $widgetOrder++,
    ));

    // Insert gutter
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sespagenote.profile-gutter-photo',
        'page_id' => $pageId,
        'parent_content_id' => $leftId,
        'order' => $widgetOrder++,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sespagenote.profile-gutter-menu',
        'page_id' => $pageId,
        'parent_content_id' => $leftId,
        'order' => $widgetOrder++,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sespagenote.profile-view-page',
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
//     'name' => 'sespagenote.team',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => 35,
//     'params' => '{"sesteam_template":"1","sesteam_contentshow":["displayname","photo","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"deslimit":"100","viewMoreText":"View Details","height":"200","width":"200","center_block":"1","center_description":"1","title":"Teams","nomobile":"0","name":"sespagenote.team"}',
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
//     'name' => 'sespagenote.team',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => 35,
//     'params' => '{"sesteam_template":"1","sesteam_contentshow":["displayname","photo","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"deslimit":"100","viewMoreText":"View Details","height":"200","width":"200","center_block":"1","center_description":"1","title":"Teams","nomobile":"0","name":"sespagenote.team"}',
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
//     'name' => 'sespagenote.team',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => 35,
//     'params' => '{"sesteam_template":"1","sesteam_contentshow":["displayname","photo","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"deslimit":"100","viewMoreText":"View Details","height":"200","width":"200","center_block":"1","center_description":"1","title":"Teams","nomobile":"0","name":"sespagenote.team"}',
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
//     'name' => 'sespagenote.team',
//     'page_id' => $page_id,
//     'parent_content_id' => $tab_id,
//     'order' => 35,
//     'params' => '{"sesteam_template":"1","sesteam_contentshow":["displayname","photo","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"deslimit":"100","viewMoreText":"View Details","height":"200","width":"200","center_block":"1","center_description":"1","title":"Teams","nomobile":"0","name":"sespagenote.team"}',
//     ));
// }
//
// //Page Team View Page
// $page_id = $db->select()
//         ->from('engine4_core_pages', 'page_id')
//         ->where('name = ?', 'sespagenote_index_view')
//         ->limit(1)
//         ->query()
//         ->fetchColumn();
// if (!$page_id) {
//   $widgetOrder = 1;
//   //Insert page
//   $db->insert('engine4_core_pages', array(
//       'name' => 'sespagenote_index_view',
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
//     'name' => 'sespagenote.viewpage-team',
//     'page_id' => $page_id,
//     'parent_content_id' => $main_middle_id,
//     'order' => $widgetOrder++,
//     'params' => '{"infoshow":["featured","sponsored","profilePhoto","displayname","designation","description","detaildescription","email","phone","location","website","facebook","linkdin","twitter","googleplus"],"title":"","nomobile":"0","name":"sespagenote.viewpage-team"}',
//   ));
// }


//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sespagenote_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('sespagenote', $level->level_id, array_keys($form->getValues()));

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
    $permissionsTable->setAllowed('sespagenote', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}
