<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: defaultsettings.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();
//Album Home Courses
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'coursesalbum_album_home')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'coursesalbum_album_home',
      'displayname' => 'SNS - Courses - Albums Home Page',
      'title' => 'Albums Home Course',
      'description' => 'This page is the albums home page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();
// Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1
  ));
  $top_id = $db->lastInsertId();
// Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2
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
      'order' => 3
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
// Insert main-right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_right_id = $db->lastInsertId();
// Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"view_count","showdefaultalbum":"0","insideOutside":"outside","fixHover":"hover","show_criteria":["classroomName","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"0","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"160","width":"1","limit_data":"3","title":"Most Viewed Albums","nomobile":"0","name":"coursesalbum.popular-albums"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"like_count","showdefaultalbum":"0","insideOutside":"outside","fixHover":"hover","show_criteria":["classroomName","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"160","width":"180","limit_data":"3","title":"Most Liked Albums","nomobile":"0","name":"coursesalbum.popular-albums"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"like_count","showdefaultalbum":"1","insideOutside":"inside","fixHover":"hover","show_criteria":["classroomName","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"1","title_truncation":"20","height":"162","width":"180","limit_data":"2","title":"Most Commented Albums","nomobile":"0","name":"coursesalbum.popular-albums"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.album-tabbed-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"tab_option":"advance","showdefaultalbum":"1","insideOutside":"inside","fixHover":"fix","show_criteria":["classroomName","featured","sponsored","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"show_item_count":"1","limit_data":"15","show_limited_data":"1","pagging":"button","title_truncation":"20","height":"210","width":"250","search_type":["recentlySPcreated","mostSPviewed","mostSPfavourite","mostSPliked","mostSPcommented","featured","sponsored"],"dummy1":null,"recentlySPcreated_order":"9","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"8","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy5":null,"mostSPliked_order":"4","mostSPliked_label":"Most Liked","dummy6":null,"mostSPcommented_order":"7","mostSPcommented_label":"Most Commented","dummy7":null,"featured_order":"5","featured_label":"Featured","dummy8":null,"sponsored_order":"6","sponsored_label":"Sponsored","title":"Popular Albums","nomobile":"0","name":"coursesalbum.album-tabbed-widget"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.album-home-error',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"","name":"coursesalbum.album-home-error"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"creation_date","showdefaultalbum":"0","insideOutside":"outside","fixHover":"fix","show_criteria":["classroomName","featured","sponsored","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"45","height":"210","width":"190","limit_data":"6","title":"","nomobile":"0","name":"coursesalbum.popular-albums"}',
  ));
  
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.browse-album-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","title":"","nomobile":"0","name":"coursesalbum.browse-album-search"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"favourite_count","showdefaultalbum":"0","insideOutside":"outside","fixHover":"hover","show_criteria":["classroomName","like","comment","view","title","by","favouriteCount","photoCount"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"155","width":"180","limit_data":"3","title":"Most Favourite Album","nomobile":"0","name":"coursesalbum.popular-albums"}'
  ));
// Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"comment_count","showdefaultalbum":"0","insideOutside":"outside","fixHover":"hover","show_criteria":["like","comment","view","title","by","favouriteCount","photoCount"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"151","width":"180","limit_data":"3","title":"Most Commented Albums","nomobile":"0","name":"coursesalbum.popular-albums"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.recently-viewed-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"criteria":"on_site","showdefaultalbum":"0","insideOutside":"inside","fixHover":"hover","show_criteria":["classroomName","featured","sponsored","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"20","height":"150","width":"180","limit_data":"2","title":"Recently Viewed Albums","nomobile":"0","name":"coursesalbum.recently-viewed-albums"}',
  ));
}

//Album Browse Course
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'coursesalbum_album_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$page_id) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'coursesalbum_album_browse',
      'displayname' => 'SNS - Courses Album Browse Page',
      'title' => 'Browse Albums Course',
      'description' => 'This page is the browse albums page.',
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
      'order' => 2
  ));
  $main_middle_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1
  ));
  $main_right_id = $db->lastInsertId();
// Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));
// Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.browse-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"showdefaultalbum":"1","load_content":"pagging","sort":"recentlySPcreated","view_type":"2","insideOutside":"inside","fixHover":"hover","show_criteria":["classroomname","like","featured","sponsored","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"15","height":"155","width":"290","title":"Browse Albums","nomobile":"0","name":"coursesalbum.browse-albums"}'
  ));
// Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.browse-album-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","featured","sponsored"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","title":"","nomobile":"0","name":"coursesalbum.browse-album-search"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"view_count","showdefaultalbum":"0","insideOutside":"inside","fixHover":"hover","show_criteria":["classroomname","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"1","title_truncation":"45","height":"250","width":"250","limit_data":"3","title":"Most Viewed Albums","nomobile":"0","name":"coursesalbum.popular-albums"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"favourite_count","showdefaultalbum":"0","insideOutside":"outside","fixHover":"hover","show_criteria":["classroomName","featured","sponsored","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"1","title_truncation":"45","height":"150","width":"180","limit_data":"3","title":"Most Favourite Albums","nomobile":"0","name":"coursesalbum.popular-albums"}'
  ));
}

//Course Album View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'coursesalbum_album_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'coursesalbum_album_view',
      'displayname' => 'SNS - Courses Album View Page',
      'title' => 'Album View Page',
      'description' => 'This page displays an album.',
      'provides' => 'subject=courses_album',
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
      'name' => 'coursesalbum.photo-album-view-breadcrumb',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 3,
      'params' => ''
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.album-view-page',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 4,
      'params' => '{"view_type":"masonry","insideOutside":"inside","fixHover":"hover","show_criteria":["featured","sponsored","like","comment","view","title","by","socialSharing","likeButton"],"limit_data":"2","pagging":"button","title_truncation":"45","height":"250","width":"300","title":"Album options","nomobile":"0","name":"coursesalbum.album-view-page"}'
  ));
}

//Photo View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'coursesalbum_photo_view')
        ->limit(1)
        ->query()
        ->fetchColumn();

if (!$page_id) {
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'coursesalbum_photo_view',
      'displayname' => 'SNS - Courses - Photo View Page',
      'title' => 'Album Photo View',
      'description' => 'This page displays an album\'s photo.',
      'provides' => 'subject=coursesalbum_photo',
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
// Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.photo-view-breadcrumb',
      'page_id' => $page_id,
      'parent_content_id' => $middle_id,
      'order' => 3,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'coursesalbum.photo-view-page',
      'page_id' => $page_id,
      'parent_content_id' => $middle_id,
      'order' => 4,
      'params' => '{"criteria":"1","maxHeight":"550","title":"","nomobile":"0","name":"coursesalbum.photo-view-page"}'
  ));
}



