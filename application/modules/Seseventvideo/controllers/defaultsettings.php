<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Video Home Page
$select = $db->select()
        ->from('engine4_core_pages')
        ->where('name = ?', 'seseventvideo_index_home')
        ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'seseventvideo_index_home',
      'displayname' => 'SES - Advanced Events Video Ext - Video Home Page',
      'title' => 'Video Home',
      'description' => 'This is the video home page.',
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
      'name' => 'sesevent.browse-menu',
      'parent_content_id' => $topmiddle_id,
      'order' => $widgetOrder++,
  ));
  
  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.video-home-error',
      'parent_content_id' => $topmiddle_id,
      'order' => $widgetOrder++,
  ));
  
    
  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.featured-sponsored-fixed-view',
      'parent_content_id' => $topmiddle_id,
      'order' => $widgetOrder++,
      'params' => '{"category":"videos","featured_sponsored_carosel":"featured","show_criteria":["title","socialSharing","duration","watchlater","likeButton","favouriteButton"],"heightMain":"450","height":"150","info":"most_liked","title_truncation":"45","limit_data":"7","title":"Featured Videos","nomobile":"0","name":"seseventvideo.featured-sponsored-fixed-view"}',
  ));
  
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.of-the-day',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"ofTheDayType":"video","show_criteria":["like","comment","rating","view","title","by","socialSharing","likeButton","favouriteButton","favouriteCount","watchLater","songsListShow","duration"],"title_truncation":"22","height":"170","width":"180","title":"Video of the Day","nomobile":"0","name":"seseventvideo.of-the-day"}',
  ));
  
      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.featured-sponsored',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"grid","criteria":"5","info":"most_rated","show_criteria":["like","comment","rating","favourite","view","title","by","duration","watchLater"],"title_truncation":"24","height":"100","width":"105","limit_data":"3","title":"Top Rated Videos","nomobile":"0","name":"seseventvideo.featured-sponsored"}',
  ));
        $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.featured-sponsored',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"list","criteria":"5","info":"most_liked","show_criteria":["like","comment","favourite","view","title","by","duration","watchLater"],"title_truncation":"11","height":"80","width":"105","limit_data":"3","title":"Most Liked Videos","nomobile":"0","name":"seseventvideo.featured-sponsored"}',
  ));
  
          $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.featured-sponsored',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"list","criteria":"5","info":"most_viewed","show_criteria":["like","comment","favourite","view","title","by","duration","watchLater"],"title_truncation":"11","height":"80","width":"105","limit_data":"3","title":"Most Viewed Videos","nomobile":"0","name":"seseventvideo.featured-sponsored"}',
  ));

  
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.featured-sponsored-carosel',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"category":"videos","featured_sponsored_carosel":"hot","show_criteria":["title"],"duration":"200","bgColor":"#eee","textColor":"","spacing":"","heightMain":"200","height":"170","width":"217","info":"recently_created","title_truncation":"24","limit_data":"9","aliganment_of_widget":"1","title":"Hot Videos","nomobile":"0","name":"seseventvideo.featured-sponsored-carosel"}',
  ));
  
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.tabbed-widget-video',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","grid","pinboard"],"openViewType":"grid","viewTypeStyle":"mouseover","showTabType":"1","show_criteria":["watchLater","favouriteButton","location","likeButton","socialSharing","like","favourite","comment","view","title","by","duration","descriptionlist","enableCommentPinboard"],"pagging":"pagging","title_truncation_grid":"24","title_truncation_list":"24","title_truncation_pinboard":"45","limit_data_pinboard":"6","limit_data_list":"6","limit_data_grid":"12","show_limited_data":"no","description_truncation_list":"100","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"190","width_grid":"212","height_list":"150","width_list":"220","width_pinboard":"335","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","hot"],"recentlySPupdated_order":"3","recentlySPcreated_label":"Recently Created","mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","mostSPliked_order":"1","mostSPliked_label":"Most Liked","mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","mostSPrated_order":"5","mostSPrated_label":"Most Rated","mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","hot_order":"7","hot_label":"Hot","featured_order":"6","featured_label":"Featured","sponsored_order":"7","sponsored_label":"Sponsored","title":"Popular Videos","nomobile":"0","name":"seseventvideo.tabbed-widget-video"}',
  ));
  
  
    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.featured-sponsored-carosel',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"category":"videos","featured_sponsored_carosel":"sponsored","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","duration","watchlater","likeButton","favouriteButton"],"duration":"300","bgColor":"","textColor":"","spacing":"","heightMain":"264","height":"200","width":"200","info":"most_liked","title_truncation":"24","limit_data":"8","aliganment_of_widget":"2","title":"Sponsored Videos","nomobile":"0","name":"seseventvideo.featured-sponsored-carosel"}',
  ));
  
      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.featured-sponsored',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"list","criteria":"6","info":"most_liked","show_criteria":["like","comment","favourite","view","title","by","duration","watchLater"],"title_truncation":"11","height":"80","width":"105","limit_data":"3","title":"Hot Videos","nomobile":"0","name":"seseventvideo.featured-sponsored"}',
  ));
  
      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.featured-sponsored',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"list","criteria":"5","info":"most_commented","show_criteria":["like","comment","favourite","view","title","by","duration","watchLater"],"title_truncation":"11","height":"80","width":"105","limit_data":"3","title":"Most Commented Videos","nomobile":"0","name":"seseventvideo.featured-sponsored"}',
  ));
      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.featured-sponsored',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"list","criteria":"5","info":"most_favourite","show_criteria":["like","comment","favourite","view","title","by","duration","watchLater"],"title_truncation":"11","height":"80","width":"105","limit_data":"3","title":"Most Favourite Videos","nomobile":"0","name":"seseventvideo.featured-sponsored"}',
  ));
      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.featured-sponsored',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"list","criteria":"5","info":"recently_created","show_criteria":["like","comment","favourite","view","title","by","duration","watchLater"],"title_truncation":"11","height":"80","width":"105","limit_data":"3","title":"Most Recent Videos","nomobile":"0","name":"seseventvideo.featured-sponsored"}',
  ));
  
}

//Video Create Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seseventvideo_index_create')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
 $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'seseventvideo_index_create',
      'displayname' => 'SES - Advanced Events Video Ext - Video Create Page',
      'title' => 'Video Create',
      'description' => 'This page allows video to be added.',
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
      'name' => 'sesevent.browse-menu',
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


//Video Edit Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seseventvideo_index_edit')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'seseventvideo_index_edit',
      'displayname' => 'SES - Advanced Events Video Ext - Video Edit Page',
      'title' => 'Video Edit',
      'description' => 'This page allows video to be edited.',
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
      'name' => 'sesevent.browse-menu',
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

//Video View Page
$select = new Zend_Db_Select($db);
$select
        ->from('engine4_core_pages')
        ->where('name = ?', 'seseventvideo_index_view')
        ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {

  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'seseventvideo_index_view',
      'displayname' => 'SES - Advanced Events Video Ext - Video View Page',
      'title' => 'View Video',
      'description' => 'This is the view page for a video.',
      'custom' => 0,
      'provides' => 'subject=video',
  ));
  $page_id = $db->lastInsertId('engine4_core_pages');

  // containers
  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'container',
      'name' => 'main',
      'parent_content_id' => null,
      'order' => 1,
      'params' => '',
  ));
  $container_id = $db->lastInsertId('engine4_core_content');

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'container',
      'name' => 'right',
      'parent_content_id' => $container_id,
      'order' => 1,
      'params' => '',
  ));
  $right_id = $db->lastInsertId('engine4_core_content');

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'container',
      'name' => 'middle',
      'parent_content_id' => $container_id,
      'order' => 3,
      'params' => '',
  ));
  $middle_id = $db->lastInsertId('engine4_core_content');

  // middle column content
  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.breadcrumb',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewPageType":"video","title":"","nomobile":"0","name":"seseventvideo.breadcrumb"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.video-view-page',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"advSearchOptions":["likeCount","viewCount","commentCount","favouriteButton","watchLater","favouriteCount","rateCount","openVideoLightbox","editVideo","deleteVideo","shareAdvance","reportVideo","peopleLike","favourite","comment","artist"],"autoplay":"0","likelimit_data":"11","favouritelimit_data":"11","advShareOptions":["privateMessage","siteShare","quickShare","addThis","embed"],"title":"","nomobile":"0","name":"seseventvideo.video-view-page"}',
  ));

  // right column
  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.show-same-tags',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"0":"","title":"Similar Videos"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.show-also-liked',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"0":"","title":"People Also Liked"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventvideo.show-same-poster',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"0":"","title":"From the same member"}',
  ));
}

//Video Location Browse Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seseventvideo_index_locations')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'seseventvideo_index_locations',
      'displayname' => 'SES - Advanced Events Video Ext - Video Location Page',
      'title' => 'Video Locations',
      'description' => 'This page show video locations.',
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
      'name' => 'sesevent.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventvideo.browse-search',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"search_for":"video","view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","featured","sponsored","verified","hot"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","title":"","nomobile":"0","name":"seseventvideo.browse-search"}',
  ));
  
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventvideo.video-location',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"location":"United Kingdom","lat":"56.6465227","lng":"-6.709638499999983","location-data":null,"title":"","nomobile":"0","name":"seseventvideo.video-location"}',
  ));
}

//Check ffmpeg path for correctness
$select = new Zend_Db_Select($db);
if (function_exists('exec') && function_exists('shell_exec')) {
  // Api is not available
  //$ffmpeg_path = Engine_Api::_()->getApi('settings', 'core')->video_ffmpeg_path;
  $ffmpeg_path = $db->select()
          ->from('engine4_core_settings', 'value')
          ->where('name = ?', 'seseventvideo.ffmpeg.path')
          ->limit(1)
          ->query()
          ->fetchColumn(0);
  $output = null;
  $return = null;
  if (!empty($ffmpeg_path)) {
    exec($ffmpeg_path . ' -version', $output, $return);
  }
  // Try to auto-guess ffmpeg path if it is not set correctly
  $ffmpeg_path_original = $ffmpeg_path;
  if (empty($ffmpeg_path) || $return > 0 || stripos(join('', $output), 'ffmpeg') === false) {
    $ffmpeg_path = null;
    // Windows
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
      // @todo
    }
    // Not windows
    else {
      $output = null;
      $return = null;
      @exec('which ffmpeg', $output, $return);
      if (0 == $return) {
        $ffmpeg_path = array_shift($output);
        $output = null;
        $return = null;
        exec($ffmpeg_path . ' -version', $output, $return);
        if (0 == $return) {
          $ffmpeg_path = null;
        }
      }
    }
  }
  if ($ffmpeg_path != $ffmpeg_path_original) {
    $count = $db->update('engine4_core_settings', array(
        'value' => $ffmpeg_path,
            ), array(
        'name = ?' => 'seseventvideo.ffmpeg.path',
    ));
    if ($count === 0) {
      try {
        $db->insert('engine4_core_settings', array(
            'value' => $ffmpeg_path,
            'name' => 'seseventvideo.ffmpeg.path',
        ));
      } catch (Exception $e) {
        
      }
    }
  }
}

$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'seseventvideo_video_favourite' WHERE `engine4_activity_actiontypes`.`type` = 'seseventvideo_favourite_video';");