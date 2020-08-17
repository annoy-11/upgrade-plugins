<?php

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Album Create Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesgroupalbum_album_create')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesgroupalbum_album_create',
      'displayname' => 'SES - Group Albums Extension - Album Create Page',
      'title' => 'Add New Photos',
      'description' => 'This page is the album create page.',
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
  // Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'group.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => 3,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.content',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 4,
  ));
}


//Album Browse Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesgroupalbum_index_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$page_id) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesgroupalbum_index_browse',
      'displayname' => 'SES - Group Albums Extension - Browse Group Albums Page',
      'title' => 'Browse Group Albums Page',
      'description' => 'This page is the browse group albums page.',
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
  // Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'group.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => 3,
  ));
	// Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.browse-search',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => 4,
      'params' => '{"search_for":"album","view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","featured","sponsored"],"default_search_type":"mostSPliked","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","title":"","nomobile":"0","name":"sesgroupalbum.browse-search"}'
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.browse-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 7,
      'params' => '{"load_content":"auto_load","sort":"most_liked","view_type":"2","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","featured","sponsored","likeButton","favouriteButton"],"title_truncation":"30","limit_data":"21","height":"240","width":"395","title":"","nomobile":"0","name":"sesgroupalbum.browse-albums"}'
  ));
}

//Album Home Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesgroupalbum_index_home')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesgroupalbum_index_home',
      'displayname' => 'SES - Group Albums Extension - Albums Home Page',
      'title' => 'Group Albums Home Page',
      'description' => 'This page is the group albums home page.',
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
  // Insert main-left
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'left',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 4,
  ));
  $main_left_id = $db->lastInsertId();
  // Insert main-right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 5,
  ));
  $main_right_id = $db->lastInsertId();
  // Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'group.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => 3
  ));
	$db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.featured-sponsored-carosel',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => 4,
			'params'=>'{"featured_sponsored_carosel":"2","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"duration":"300","height":"270","width":"293","info":"most_favourite","title_truncation":"20","limit_data":"20","aliganment_of_widget":"1","title":"Featured Albums","nomobile":"0","name":"sesgroupalbum.featured-sponsored-carosel"}'
  ));
  //Insert popular albums widget
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.of-the-day',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => 7,
      'params' => '{"ofTheDayType":"albums","insideOutside":"outside","fixHover":"fix","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"title_truncation":"15","height":"250","width":"200","title":"Album Of The Day","nomobile":"0","name":"sesgroupalbum.of-the-day"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => 8,
      'params' => '{"tableName":"album","criteria":"5","info":"most_download","insideOutside":"inside","fixHover":"hover","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"view_type":"2","title_truncation":"20","height":"160","width":"180","limit_data":"3","title":"Most Downloaded Albums","nomobile":"0","name":"sesgroupalbum.featured-sponsored"}',
  ));
	$db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => 9,
      'params' => '{"tableName":"album","criteria":"5","info":"most_liked","insideOutside":"inside","fixHover":"hover","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"view_type":"2","title_truncation":"20","height":"160","width":"180","limit_data":"3","title":"Most Liked Albums","nomobile":"0","name":"sesgroupalbum.featured-sponsored"}',
  ));
	$db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => 10,
      'params' => '{"tableName":"album","criteria":"5","info":"recently_liked","insideOutside":"inside","fixHover":"hover","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"view_type":"2","title_truncation":"20","height":"162","width":"180","limit_data":"3","title":"Most Viewed Albums","nomobile":"0","name":"sesgroupalbum.featured-sponsored"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.browse-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 12,
      'params' => '{"search_for":"album","view_type":"horizontal","search_type":"","friend_show":"no","search_title":"yes","browse_by":"no","categories":"yes","location":"yes","kilometer_miles":"yes","title":"","nomobile":"0","name":"sesgroupalbum.browse-search"}',
  ));

	$db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 14,
      'params' => '{"tableName":"album","criteria":"5","info":"most_rated","insideOutside":"inside","fixHover":"hover","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"view_type":"1","title_truncation":"20","height":"200","width":"220","limit_data":"3","title":"Top Rated Albums","nomobile":"0","name":"sesgroupalbum.featured-sponsored"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.album-home-error',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 15,
      'params' => '{"itemType":"album","title":"","nomobile":"0","name":"sesgroupalbum.album-home-error"}',
  ));
$db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.tabbed-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 16,
      'params' => '{"photo_album":"album","tab_option":"default","view_type":"grid","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"limit_data":"4","show_limited_data":"no","pagging":"pagging","title_truncation":"20","height":"200","width":"334","search_type":["recentlySPcreated"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPfavourite_order":"2","mostSPfavourite_label":"Most Favourite","dummy4":null,"mostSPdownloaded_order":"2","mostSPdownloaded_label":"Most Downloaded","dummy5":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy6":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy7":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy8":null,"featured_order":"6","featured_label":"Featured","dummy9":null,"sponsored_order":"7","sponsored_label":"Sponsored","title":"Recent Albums","nomobile":"0","name":"sesgroupalbum.tabbed-widget"}',
  ));
  // Insert slide show featured photo
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.tabbed-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 17,
      'params' => '{"photo_album":"album","tab_option":"filter","view_type":"grid","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","featured","sponsored","likeButton","favouriteButton"],"limit_data":"6","show_limited_data":"no","pagging":"button","title_truncation":"20","height":"210","width":"334","search_type":["mostSPfavourite","mostSPliked","mostSPrated","mostSPdownloaded","featured","sponsored"],"dummy1":null,"recentlySPcreated_order":"9","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"8","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy4":null,"mostSPdownloaded_order":"5","mostSPdownloaded_label":"Most Downloaded","dummy5":null,"mostSPliked_order":"4","mostSPliked_label":"Most Liked","dummy6":null,"mostSPcommented_order":"7","mostSPcommented_label":"Most Commented","dummy7":null,"mostSPrated_order":"3","mostSPrated_label":"Most Rated","dummy8":null,"featured_order":"1","featured_label":"Featured","dummy9":null,"sponsored_order":"2","sponsored_label":"Sponsored","title":"Popular Albums","nomobile":"0","name":"sesgroupalbum.tabbed-widget"}'
  ));
  // Insert categories
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.featured-sponsored-carosel',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => 19,
      'params' => '{"featured_sponsored_carosel":"4","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"duration":"250","height":"275","width":"200","info":"recently_created","title_truncation":"18","limit_data":"10","aliganment_of_widget":"2","title":"Sponsored Albums","nomobile":"0","name":"sesgroupalbum.featured-sponsored-carosel"}'
  ));
  // Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.tag-cloud-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => 20,
			'params'=>'{"color":"#000000","text_height":"15","height":"150","itemCountPerPage":"25","title":"Popular Tags","nomobile":"0","name":"sesgroupalbum.tag-cloud-albums"}'
  ));
  // Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => 21,
      'params' => '{"tableName":"album","criteria":"5","info":"most_favourite","insideOutside":"inside","fixHover":"hover","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"view_type":"2","title_truncation":"20","height":"155","width":"180","limit_data":"3","title":"Most Favourite Album","nomobile":"0","name":"sesgroupalbum.featured-sponsored"}'
  ));
  // Insert browse menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => 22,
      'params' => '{"tableName":"album","criteria":"5","info":"most_commented","insideOutside":"inside","fixHover":"hover","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"view_type":"2","title_truncation":"20","height":"151","width":"180","limit_data":"3","title":"Most Commented Albums","nomobile":"0","name":"sesgroupalbum.featured-sponsored"}',
  ));
	$db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.recently-viewed-item',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => 23,
      'params' => '{"category":"album","criteria":"on_site","insideOutside":"inside","fixHover":"hover","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"title_truncation":"20","height":"150","width":"180","limit_data":"2","title":"Recently Viewed Albums","nomobile":"0","name":"sesgroupalbum.recently-viewed-item"}',
  ));
}


//Album Photo View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesgroupalbum_photo_view')
        ->limit(1)
        ->query()
        ->fetchColumn();

if (!$page_id) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesgroupalbum_photo_view',
      'displayname' => 'SES - Group Albums Extension - Photo View Page',
      'title' => 'Group Album Photo View Page',
      'description' => 'This page displays an group album\'s photo.',
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
      'name' => 'sesgroupalbum.breadcrumb-photo-view',
      'page_id' => $page_id,
      'parent_content_id' => $middle_id,
      'order' => 3,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.photo-view-page',
      'page_id' => $page_id,
      'parent_content_id' => $middle_id,
      'order' => 4,
      'params' => '{"criteria":["like","favourite","tagged","slideshowPhoto"],"maxHeight":"550","view_more_like":"17","view_more_favourite":"10","view_more_tagged":"10","title":"","nomobile":"0","name":"sesgroupalbum.photo-view-page"}'
  ));
}

//Album View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesgroupalbum_album_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesgroupalbum_album_view',
      'displayname' => 'SES - Group Albums Extension - Album View Page',
      'title' => 'Group Album View Page',
      'description' => 'This page displays an album.',
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
  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.breadcrumb-album-view',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 3,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroupalbum.album-view-page',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 4,
      'params' => '{"view_type":"masonry","insideOutside":"inside","fixHover":"hover","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","featured","sponsored","likeButton","favouriteButton"],"limit_data":"20","pagging":"auto_load","title_truncation":"20","height":"350","width":"250","dummy1":null,"insideOutsideRelated":"outside","fixHoverRelated":"fix","show_criteriaRelated":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","featured","sponsored","likeButton","favouriteButton"],"limit_dataRelated":"15","paggingRelated":"auto_load","title_truncationRelated":"45","heightRelated":"240","widthRelated":"294","dummy2":null,"search_type":["RecentAlbum","Like","TaggedUser","Fav"],"dummy":null,"RecentAlbum_order":"1","RecentAlbum_label":"[USER_NAME]\'s Recent Albums","RecentAlbum_limitdata":"17","dummy4":null,"Like_order":"2","Like_label":"People Who Like This","Like_limitdata":"17","dummy5":null,"TaggedUser_order":"3","TaggedUser_label":"People Who Are Tagged In This Album","TaggedUser_limitdata":"17","dummy6":null,"Fav_order":"4","Fav_label":"People Who Added This As Favourite","Fav_limitdata":"17","title":"","nomobile":"0","name":"sesgroupalbum.album-view-page"}'
  ));
}

$table_exist_photos = $db->query('SHOW TABLES LIKE \'engine4_group_photos\'')->fetch();
if (!empty($table_exist_photos)) {
  $rating = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'rating\'')->fetch();
  if (empty($rating)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `rating` INT( 11 ) NOT NULL DEFAULT '0';");
  }
  $offtheday = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'offtheday\'')->fetch();
  if (empty($offtheday)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `offtheday` tinyint(1) NOT NULL DEFAULT '0';");
  }
  $starttime = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'starttime\'')->fetch();
  if (empty($starttime)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `starttime` date  NULL ;");
  }
  $endtime = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'endtime\'')->fetch();
  if (empty($endtime)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `endtime` date  NULL ;");
  }
  $location = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'location\'')->fetch();
  if (empty($location)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `location` TEXT  NULL ;");
  }
  $ip_address = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'ip_address\'')->fetch();
  if (empty($ip_address)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `ip_address` VARCHAR(45)  NULL ;");
  }
  $download_count = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'download_count\'')->fetch();
  if (empty($download_count)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `download_count` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0';");
  }

  $is_featured = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'is_featured\'')->fetch();
  if (empty($is_featured)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `is_featured` TINYINT( 1 ) NOT NULL DEFAULT '0';");
  }
  $favourite_count = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'favourite_count\'')->fetch();
  if (empty($favourite_count)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `favourite_count` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0';");
  }
  $is_sponsored = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'is_sponsored\'')->fetch();
  if (empty($is_sponsored)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `is_sponsored` TINYINT( 1 ) NOT NULL DEFAULT '0';");
  }
  $view_count = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'view_count\'')->fetch();
  if (empty($view_count)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `view_count` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0';");
  }
  $comment_count = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'comment_count\'')->fetch();
  if (empty($comment_count)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `comment_count` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0';");
  }
  $like_count = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'like_count\'')->fetch();
  if (empty($like_count)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `like_count` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0';");
  }
  $owner_id = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'owner_id\'')->fetch();
  if (empty($owner_id)) {
    $db->query("ALTER TABLE  `engine4_group_photos` ADD  `owner_id` INT( 11 ) NOT NULL;");
  }
    
  $owner_type = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'owner_type\'')->fetch();
  if (empty($owner_type)) {
    $db->query("ALTER TABLE  `engine4_group_photos` ADD  `owner_type` VARCHAR( 255 ) NOT NULL DEFAULT  'user';");
  }

  $order = $db->query('SHOW COLUMNS FROM engine4_group_photos LIKE \'order\'')->fetch();
  if (empty($order)) {
    $db->query("ALTER TABLE `engine4_group_photos` ADD `order` INT(11) NOT NULL;");
  }

}

$table_exist_albums = $db->query('SHOW TABLES LIKE \'engine4_group_albums\'')->fetch();
if (!empty($table_exist_albums)) {
  $rating = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'rating\'')->fetch();
  if (empty($rating)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `rating` INT( 11 ) NOT NULL DEFAULT '0';");
  }
  $position_cover = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'position_cover\'')->fetch();
  if (empty($position_cover)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `position_cover` VARCHAR(255) NULL;");
  }
  $offtheday = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'offtheday\'')->fetch();
  if (empty($offtheday)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `offtheday` tinyint(1) NOT NULL DEFAULT '0';");
  }
  $starttime = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'starttime\'')->fetch();
  if (empty($starttime)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `starttime` date  NULL ;");
  }
  $endtime = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'endtime\'')->fetch();
  if (empty($endtime)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `endtime` date  NULL ;");
  }
  $location = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'location\'')->fetch();
  if (empty($location)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `location` TEXT  NULL ;");
  }
  $is_featured = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'is_featured\'')->fetch();
  if (empty($is_featured)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `is_featured` TINYINT( 1 ) NOT NULL DEFAULT '0';");
  }
  $is_sponsored = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'is_sponsored\'')->fetch();
  if (empty($is_sponsored)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `is_sponsored` TINYINT( 1 ) NOT NULL DEFAULT '0';");
  }
  $view_count = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'view_count\'')->fetch();
  if (empty($view_count)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `view_count` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0';");
  }
  $comment_count = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'comment_count\'')->fetch();
  if (empty($comment_count)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `comment_count` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0';");
  }
  $favourite_count = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'favourite_count\'')->fetch();
  if (empty($favourite_count)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `favourite_count` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0';");
  }
  $like_count = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'like_count\'')->fetch();
  if (empty($like_count)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `like_count` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0';");
  }
  $art_cover = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'art_cover\'')->fetch();
  if (empty($art_cover)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `art_cover` int(11) unsigned NOT NULL DEFAULT '0';");
  }
  $ip_address = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'ip_address\'')->fetch();
  if (empty($ip_address)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `ip_address` VARCHAR(45)  NULL ;");
  }
  $download_count = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'download_count\'')->fetch();
  if (empty($download_count)) {
    $db->query("ALTER TABLE `engine4_group_albums` ADD `download_count` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0';");
  }

  $owner_id = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'owner_id\'')->fetch();
  if (empty($owner_id)) {
    $db->query("ALTER TABLE  `engine4_group_albums` ADD  `owner_id` INT( 11 ) NOT NULL;");
  }
    
  $owner_type = $db->query('SHOW COLUMNS FROM engine4_group_albums LIKE \'owner_type\'')->fetch();
  if (empty($owner_type)) {
    $db->query("ALTER TABLE  `engine4_group_albums` ADD  `owner_type` VARCHAR( 255 ) NOT NULL DEFAULT  'user';");
  }


}


$db->query('DROP TABLE IF EXISTS `engine4_sesgroupalbum_relatedalbums`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupalbum_relatedalbums` (
	`relatedalbum_id` int(11) unsigned NOT NULL auto_increment,
	`resource_id` int(11) NOT NULL,
	`album_id` INT(11) DEFAULT NULL,
	`modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	UNIQUE KEY `uniqueKey` (`resource_id`,`album_id`),
  PRIMARY KEY (`relatedalbum_id`) 
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');

$db->query('DROP TABLE IF EXISTS `engine4_sesgroupalbum_favourites`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupalbum_favourites` (
	`favourite_id` int(11) unsigned NOT NULL auto_increment,
	`user_id` int(11) unsigned NOT NULL,
	`resource_type` varchar(128) NOT NULL,
	`resource_id` int(11) NOT NULL,
	 PRIMARY KEY (`favourite_id`), 
	 KEY `user_id` (`user_id`,`resource_type`,`resource_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
	
$db->query('DROP TABLE IF EXISTS `engine4_sesgroupalbum_ratings`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupalbum_ratings` (
`rating_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`resource_id` int(11) NOT NULL,
`resource_type` varchar(64) NOT NULL,
`user_id` int(11) unsigned NOT NULL,
`rating` tinyint(1) unsigned DEFAULT NULL, 
UNIQUE KEY `uniqueKey` (`user_id`,`resource_type`,`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');

$db->query('DROP TABLE IF EXISTS `engine4_sesgroupalbum_recentlyviewitems`;');
$db->query('CREATE TABLE IF NOT EXISTS  `engine4_sesgroupalbum_recentlyviewitems` (
`recentlyviewed_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`resource_id` INT NOT NULL ,
`resource_type` VARCHAR(64) NOT NULL DEFAULT "album",
`owner_id` INT NOT NULL ,
`creation_date` DATETIME NOT NULL,
UNIQUE KEY `uniqueKey` (`resource_id`,`resource_type`, `owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');


$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
      level_id as `level_id`,
      "sesgroupalbum_album" as `type`,
      "edit" as `name`,
      1 as `value`,
      NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
            $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
      level_id as `level_id`,
      "sesgroupalbum_album" as `type`,
      "edit" as `name`,
      2 as `value`,
      NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"auth_view" as `name`,
5 as `value`,
\'["everyone","registered","owner_network","owner_member_member","owner_member","owner"]\' as `params`
FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"auth_comment" as `name`,
5 as `value`,
\'["everyone","registered","owner_network","owner_member_member","owner_member","owner"]\' as `params`
FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"auth_tag" as `name`,
5 as `value`,
\'["everyone","registered","owner_network","owner_member_member","owner_member","owner"]\' as `params`
FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"view" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` IN("user");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"comment" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` IN("user");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"tag" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` IN("user");');

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"view" as `name`,
2 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"comment" as `name`,
2 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"tag" as `name`,
2 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"view" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"download" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"favourite_album" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"favourite_photo" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"max_albums" as `name`,
0 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"imageviewer" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"rating_album" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"rating_photo" as `name`,
1 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
SELECT
level_id as `level_id`,
"sesgroupalbum_album" as `type`,
"tag" as `name`,
0 as `value`,
NULL as `params`
FROM `engine4_authorization_levels` WHERE `type` IN("public");');


$db->query('INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
("sesgroupalbum_photo_new", "sesgroupalbum", \'{item:$subject} added {var:$count} photo(s) to the album {item:$object}:\', 1, 5, 1, 3, 1, 1),
("comment_album", "sesgroupalbum", \'{item:$subject} commented on {item:$owner}\'\'s {item:$object:album}: {body:$body}\', 1, 1, 1, 1, 1, 0),
("comment_album_photo", "sesgroupalbum", \'{item:$subject} commented on {item:$owner}\'\'s {item:$object:photo}: {body:$body}\', 1, 1, 1, 1, 1, 0),
("sesgroupalbum_albumrated", "sesgroupalbum", \'{item:$subject} rated album {item:$object}:\', 1, 5, 1, 1, 1, 1),
("sesgroupalbum_photorated", "sesgroupalbum", \'{item:$subject} rated photo {item:$object}:\', 1, 5, 1, 1, 1, 1),
("sesgroupalbum_favouritealbum", "sesgroupalbum", \'{item:$subject} added album {item:$object} to favourite:\', 1, 5, 1, 1, 1, 1),
("sesgroupalbum_favouritephoto", "sesgroupalbum", \'{item:$subject} added photo {item:$object} to favourite:\', 1, 5, 1, 1, 1, 1)');

//notification type
$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`, `default`) VALUES
("sesgroupalbum_favouritephoto", "sesgroupalbum", \'{item:$subject} favourite your {item:$object:photo}.\', "0", "", "1"),
("sesgroupalbum_favouritealbum", "sesgroupalbum", \'{item:$subject} favourite your {item:$object:album}.\', "0", "", "1"),
("sesgroupalbum_albumrated", "sesgroupalbum", \'{item:$subject} rate your {item:$object:album}.\', "0", "", "1"),
("sesgroupalbum_photorated", "sesgroupalbum", \'{item:$subject} rate your {item:$object:photo}.\', "0", "", "1");');

//Update owner_id in group album table
$tableAlbum = Engine_Api::_()->getDbtable('albums', 'sesgroupalbum');
$tableAlbumName = $tableAlbum->info('name');
$select = $tableAlbum->select()
											->from($tableAlbumName, array('group_id', 'album_id'))
											->where('owner_id = ?', 0);
$results = Zend_Paginator::factory($select);
foreach($results as $result) {
  $groupsTable = Engine_Api::_()->getDbTable('groups', 'group');
  $user_id = $groupsTable->select()
            ->from($groupsTable->info('name'), 'user_id')
            ->where('group_id = ?', $result->group_id)
            ->query()
            ->fetchColumn();
  if($user_id) {
	  $db->query("UPDATE `engine4_group_albums` SET  `owner_id` =  '".$user_id."' WHERE  `engine4_group_albums`.`album_id` ='".$result->album_id."';");
  }
}

$db->query("UPDATE  `engine4_group_albums` SET  `title` =  'Untitled Album' WHERE  `engine4_group_albums`.`title` =  '';");
$db->query("UPDATE `engine4_core_comments` SET  `resource_type` =  'sesgroupalbum_photo' WHERE  `engine4_core_comments`.`resource_type` ='group_photo';");
$db->query("UPDATE `engine4_core_comments` SET  `resource_type` =  'sesgroupalbum_album' WHERE  `engine4_core_comments`.`resource_type` ='group_album';");
$db->query("UPDATE `engine4_core_likes` SET  `resource_type` =  'sesgroupalbum_photo' WHERE  `engine4_core_likes`.`resource_type` ='group_photo';");
$db->query("UPDATE `engine4_core_likes` SET  `resource_type` =  'sesgroupalbum_album' WHERE  `engine4_core_likes`.`resource_type` ='group_album';");