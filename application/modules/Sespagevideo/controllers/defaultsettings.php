<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();
// profile page design1
		$design1_page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sespage_profile_index_1')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
		  if($design1_page_id){ 
			 $tab_id=  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'core.container-tabs')
				->where('page_id = ?', $design1_page_id)
				->limit(1) 
				->query()
				->fetchColumn();
			// insert if it doesn't exist yet
			if ($tab_id){
				$isWidgetExist =  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'sespagevideo.profile-videos')
				->where('page_id = ?', $design1_page_id)
				->where('parent_content_id = ?', $tab_id)
				->limit(1) 
				->query()
				->fetchColumn();
				if(!$isWidgetExist){
					$db->insert('engine4_core_content', array(
					'type' => 'widget',
					'name' => 'sespagevideo.profile-videos',
					'page_id' => $design1_page_id,
					'parent_content_id' => $tab_id,
					'order' => 10,
					'params' => '{"enableTabs":"","openViewType":"list","viewTypeStyle":"fixed","showTabType":"1","show_criteria":"","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","show_limited_data":"no","description_truncation_list":"45","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"270","width_grid":"389","height_list":"230","width_list":"260","width_pinboard":"300","title":"Videos","nomobile":"0","name":"sespagevideo.profile-videos"}',
				));
				}
			}
		}
	// profile page design2
		$design2_page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sespage_profile_index_2')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
		  if($design2_page_id){ 
			 $tab_id=  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'core.container-tabs')
				->where('page_id = ?', $design2_page_id)
				->limit(1) 
				->query()
				->fetchColumn();
			// insert if it doesn't exist yet
			if ($tab_id){
				$isWidgetExist =  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'sespagevideo.profile-videos')
				->where('page_id = ?', $design2_page_id)
				->where('parent_content_id = ?', $tab_id)
				->limit(1) 
				->query()
				->fetchColumn();
				if(!$isWidgetExist){
					$db->insert('engine4_core_content', array(
					'type' => 'widget',
					'name' => 'sespagevideo.profile-videos',
					'page_id' => $design2_page_id,
					'parent_content_id' => $tab_id,
					'order' => 10,
					'params' => '{"enableTabs":"","openViewType":"list","viewTypeStyle":"fixed","showTabType":"1","show_criteria":"","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","show_limited_data":"no","description_truncation_list":"45","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"270","width_grid":"389","height_list":"230","width_list":"260","width_pinboard":"300","title":"Videos","nomobile":"0","name":"sespagevideo.profile-videos"}',
					));
				}
			}
		}
	// profile page design3
		$design3_page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sespage_profile_index_3')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
		  if($design3_page_id){ 
			 $tab_id=  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'core.container-tabs')
				->where('page_id = ?', $design3_page_id)
				->limit(1) 
				->query()
				->fetchColumn();
			// insert if it doesn't exist yet
			if ($tab_id){
				$isWidgetExist =  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'sespagevideo.profile-videos')
				->where('page_id = ?', $design3_page_id)
				->where('parent_content_id = ?', $tab_id)
				->limit(1) 
				->query()
				->fetchColumn();
				if(!$isWidgetExist){
					$db->insert('engine4_core_content', array(
					'type' => 'widget',
					'name' => 'sespagevideo.profile-videos',
					'page_id' => $design3_page_id,
					'parent_content_id' => $tab_id,
					'order' => 10,
					'params' => '{"enableTabs":"","openViewType":"list","viewTypeStyle":"fixed","showTabType":"1","show_criteria":"","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","show_limited_data":"no","description_truncation_list":"45","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"270","width_grid":"389","height_list":"230","width_list":"260","width_pinboard":"300","title":"Videos","nomobile":"0","name":"sespagevideo.profile-videos"}',
				));
				}
			}
		}
	// profile page design4
		$design4_page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sespage_profile_index_4')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
		  if($design4_page_id){ 
			 $tab_id=  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'core.container-tabs')
				->where('page_id = ?', $design4_page_id)
				->limit(1) 
				->query()
				->fetchColumn();
			
			// insert if it doesn't exist yet
			if ($tab_id){
				$isWidgetExist =  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'sespagevideo.profile-videos')
				->where('page_id = ?', $design4_page_id)
				->where('parent_content_id = ?', $tab_id)
				->limit(1) 
				->query()
				->fetchColumn();
				if(!$isWidgetExist){
					$db->insert('engine4_core_content', array(
					'type' => 'widget',
					'name' => 'sespagevideo.profile-videos',
					'page_id' => $design4_page_id,
					'parent_content_id' => $tab_id,
					'order' => 10,
					'params' => '{"enableTabs":"","openViewType":"list","viewTypeStyle":"fixed","showTabType":"1","show_criteria":"","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","show_limited_data":"no","description_truncation_list":"45","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"270","width_grid":"389","height_list":"230","width_list":"260","width_pinboard":"300","title":"Videos","nomobile":"0","name":"sespagevideo.profile-videos"}',
				));
				}
			}
		}
//Video Browse Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespagevideo_index_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sespagevideo_index_browse',
      'displayname' => 'SES - Page Videos Extension - Browse Videos Page',
      'title' => 'Browse Videos',
      'description' => 'This page lists videos.',
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
      'name' => 'sespagevideo.browse-video',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","grid","pinboard"],"openViewType":"grid","show_criteria":["watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","duration","descriptionlist","descriptionpinboard","enableCommentPinboard"],"sort":"mostSPliked","title_truncation_list":"70","title_truncation_grid":"30","description_truncation_list":"230","description_truncation_grid":"45","description_truncation_pinboard":"60","height_list":"180","width_list":"260","height_grid":"270","width_grid":"305","width_pinboard":"305","limit_data_pinboard":"10","limit_data_grid":"15","limit_data_list":"20","pagging":"pagging","title":"","nomobile":"0","name":"sespagevideo.browse-video"}',
  ));

  // Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagevideo.browse-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"search_for":"video","view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","featured","sponsored","verified","hot"],"default_search_type":"mostSPliked","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","title":"Search Videos","nomobile":"0","name":"sespagevideo.browse-search"}',
  ));

  // Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagevideo.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"grid","criteria":"5","info":"most_viewed","show_criteria":["like","comment","rating","favourite","view","title","by","category","duration","watchLater"],"title_truncation":"45","height":"130","width":"180","limit_data":"3","title":"Most Viewed Videos","nomobile":"0","name":"sespagevideo.featured-sponsored"}',
  ));
}

//Video Home Page
$select = $db->select()
        ->from('engine4_core_pages')
        ->where('name = ?', 'sespagevideo_index_home')
        ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sespagevideo_index_home',
      'displayname' => 'SES - Page Videos Extension - Video Home Page',
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
      'name' => 'sespage.browse-menu',
      'parent_content_id' => $topmiddle_id,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.video-home-error',
      'parent_content_id' => $topmiddle_id,
      'order' => $widgetOrder++,
  ));


  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.featured-sponsored-fixed-view',
      'parent_content_id' => $topmiddle_id,
      'order' => $widgetOrder++,
      'params' => '{"category":"videos","featured_sponsored_carosel":"featured","show_criteria":["title","socialSharing","duration","watchlater","likeButton","favouriteButton"],"heightMain":"450","height":"150","info":"most_liked","title_truncation":"45","limit_data":"7","title":"Featured Videos","nomobile":"0","name":"sespagevideo.featured-sponsored-fixed-view"}',
  ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.of-the-day',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"ofTheDayType":"video","show_criteria":["like","comment","rating","view","title","by","socialSharing","likeButton","favouriteButton","favouriteCount","watchLater","songsListShow","duration"],"title_truncation":"22","height":"170","width":"180","title":"Video of the Day","nomobile":"0","name":"sespagevideo.of-the-day"}',
  ));

      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.featured-sponsored',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"grid","criteria":"5","info":"most_rated","show_criteria":["like","comment","rating","favourite","view","title","by","duration","watchLater"],"title_truncation":"24","height":"100","width":"105","limit_data":"3","title":"Top Rated Videos","nomobile":"0","name":"sespagevideo.featured-sponsored"}',
  ));
        $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.featured-sponsored',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"list","criteria":"5","info":"most_liked","show_criteria":["like","comment","favourite","view","title","by","duration","watchLater"],"title_truncation":"11","height":"80","width":"105","limit_data":"3","title":"Most Liked Videos","nomobile":"0","name":"sespagevideo.featured-sponsored"}',
  ));

          $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.featured-sponsored',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"list","criteria":"5","info":"most_viewed","show_criteria":["like","comment","favourite","view","title","by","duration","watchLater"],"title_truncation":"11","height":"80","width":"105","limit_data":"3","title":"Most Viewed Videos","nomobile":"0","name":"sespagevideo.featured-sponsored"}',
  ));


    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.featured-sponsored-carosel',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"category":"videos","featured_sponsored_carosel":"hot","show_criteria":["title"],"duration":"200","bgColor":"#eee","textColor":"","spacing":"","heightMain":"200","height":"170","width":"217","info":"recently_created","title_truncation":"24","limit_data":"9","aliganment_of_widget":"1","title":"Hot Videos","nomobile":"0","name":"sespagevideo.featured-sponsored-carosel"}',
  ));

    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.tabbed-widget-video',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","grid","pinboard"],"openViewType":"grid","viewTypeStyle":"mouseover","showTabType":"1","show_criteria":["watchLater","favouriteButton","location","likeButton","socialSharing","like","favourite","comment","view","title","by","duration","descriptionlist","enableCommentPinboard"],"pagging":"pagging","title_truncation_grid":"24","title_truncation_list":"24","title_truncation_pinboard":"45","limit_data_pinboard":"6","limit_data_list":"6","limit_data_grid":"12","show_limited_data":"no","description_truncation_list":"100","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"190","width_grid":"212","height_list":"150","width_list":"220","width_pinboard":"335","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","hot"],"recentlySPupdated_order":"3","recentlySPcreated_label":"Recently Created","mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","mostSPliked_order":"1","mostSPliked_label":"Most Liked","mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","mostSPrated_order":"5","mostSPrated_label":"Most Rated","mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","hot_order":"7","hot_label":"Hot","featured_order":"6","featured_label":"Featured","sponsored_order":"7","sponsored_label":"Sponsored","title":"Popular Videos","nomobile":"0","name":"sespagevideo.tabbed-widget-video"}',
  ));


    $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.featured-sponsored-carosel',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"category":"videos","featured_sponsored_carosel":"sponsored","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","duration","watchlater","likeButton","favouriteButton"],"duration":"300","bgColor":"","textColor":"","spacing":"","heightMain":"264","height":"200","width":"200","info":"most_liked","title_truncation":"24","limit_data":"8","aliganment_of_widget":"2","title":"Sponsored Videos","nomobile":"0","name":"sespagevideo.featured-sponsored-carosel"}',
  ));

      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.featured-sponsored',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"list","criteria":"6","info":"most_liked","show_criteria":["like","comment","favourite","view","title","by","duration","watchLater"],"title_truncation":"11","height":"80","width":"105","limit_data":"3","title":"Hot Videos","nomobile":"0","name":"sespagevideo.featured-sponsored"}',
  ));

      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.featured-sponsored',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"list","criteria":"5","info":"most_commented","show_criteria":["like","comment","favourite","view","title","by","duration","watchLater"],"title_truncation":"11","height":"80","width":"105","limit_data":"3","title":"Most Commented Videos","nomobile":"0","name":"sespagevideo.featured-sponsored"}',
  ));
      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.featured-sponsored',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"list","criteria":"5","info":"most_favourite","show_criteria":["like","comment","favourite","view","title","by","duration","watchLater"],"title_truncation":"11","height":"80","width":"105","limit_data":"3","title":"Most Favourite Videos","nomobile":"0","name":"sespagevideo.featured-sponsored"}',
  ));
      $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.featured-sponsored',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"tableName":"video","type":"list","criteria":"5","info":"recently_created","show_criteria":["like","comment","favourite","view","title","by","duration","watchLater"],"title_truncation":"11","height":"80","width":"105","limit_data":"3","title":"Most Recent Videos","nomobile":"0","name":"sespagevideo.featured-sponsored"}',
  ));

}

//Video Create Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespagevideo_index_create')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
 $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespagevideo_index_create',
      'displayname' => 'SES - Page Videos Extension - Video Create Page',
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
      'name' => 'sespage.browse-menu',
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
        ->where('name = ?', 'sespagevideo_index_edit')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespagevideo_index_edit',
      'displayname' => 'SES - Page Videos Extension - Video Edit Page',
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
      'name' => 'sespage.browse-menu',
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
        ->where('name = ?', 'sespagevideo_index_view')
        ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {

  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sespagevideo_index_view',
      'displayname' => 'SES - Page Videos Extension - Video View Page',
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
      'name' => 'sespagevideo.breadcrumb',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewPageType":"video","title":"","nomobile":"0","name":"sespagevideo.breadcrumb"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.video-view-page',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"advSearchOptions":["likeCount","viewCount","commentCount","favouriteButton","watchLater","favouriteCount","rateCount","openVideoLightbox","editVideo","deleteVideo","shareAdvance","reportVideo","peopleLike","favourite","comment","artist"],"autoplay":"0","likelimit_data":"11","favouritelimit_data":"11","advShareOptions":["privateMessage","siteShare","quickShare","addThis","embed"],"title":"","nomobile":"0","name":"sespagevideo.video-view-page"}',
  ));

  // right column
  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.show-same-tags',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"0":"","title":"Similar Videos"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.show-also-liked',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"0":"","title":"People Also Liked"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagevideo.show-same-poster',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"0":"","title":"From the same member"}',
  ));
}

// //Video Location Browse Page
// $page_id = $db->select()
//         ->from('engine4_core_pages', 'page_id')
//         ->where('name = ?', 'sespagevideo_index_locations')
//         ->limit(1)
//         ->query()
//         ->fetchColumn();
// if (!$page_id) {
//   $widgetOrder = 1;
//   $db->insert('engine4_core_pages', array(
//       'name' => 'sespagevideo_index_locations',
//       'displayname' => 'SES - Page Videos Extension - Video Location Page',
//       'title' => 'Video Locations',
//       'description' => 'This page show video locations.',
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
//
//   // Insert main-middle
//   $db->insert('engine4_core_content', array(
//       'type' => 'container',
//       'name' => 'middle',
//       'page_id' => $page_id,
//       'parent_content_id' => $main_id,
//       'order' => 2,
//   ));
//   $main_middle_id = $db->lastInsertId();
//
//   // Insert menu
//   $db->insert('engine4_core_content', array(
//       'type' => 'widget',
//       'name' => 'sespage.browse-menu',
//       'page_id' => $page_id,
//       'parent_content_id' => $top_middle_id,
//       'order' => $widgetOrder++,
//   ));
//
//   // Insert content
//   $db->insert('engine4_core_content', array(
//       'type' => 'widget',
//       'name' => 'sespagevideo.browse-search',
//       'page_id' => $page_id,
//       'parent_content_id' => $top_middle_id,
//       'order' => $widgetOrder++,
//       'params' => '{"search_for":"video","view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","featured","sponsored","verified","hot"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","title":"","nomobile":"0","name":"sespagevideo.browse-search"}',
//   ));
//
//     $db->insert('engine4_core_content', array(
//       'type' => 'widget',
//       'name' => 'sespagevideo.video-location',
//       'page_id' => $page_id,
//       'parent_content_id' => $main_middle_id,
//       'order' => $widgetOrder++,
//       'params' => '{"location":"United Kingdom","lat":"56.6465227","lng":"-6.709638499999983","location-data":null,"title":"","nomobile":"0","name":"sespagevideo.video-location"}',
//   ));
// }

//Check ffmpeg path for correctness
$select = new Zend_Db_Select($db);
if (function_exists('exec') && function_exists('shell_exec')) {
  // Api is not available
  //$ffmpeg_path = Engine_Api::_()->getApi('settings', 'core')->video_ffmpeg_path;
  $ffmpeg_path = $db->select()
          ->from('engine4_core_settings', 'value')
          ->where('name = ?', 'sespagevideo.ffmpeg.path')
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
        'name = ?' => 'sespagevideo.ffmpeg.path',
    ));
    if ($count === 0) {
      try {
        $db->insert('engine4_core_settings', array(
            'value' => $ffmpeg_path,
            'name' => 'sespagevideo.ffmpeg.path',
        ));
      } catch (Exception $e) {

      }
    }
  }
}

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sespagevideo_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('pagevideo', $level->level_id, array_keys($form->getValues()));

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
    $permissionsTable->setAllowed('pagevideo', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}
