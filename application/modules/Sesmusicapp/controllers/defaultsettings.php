<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();


$page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesmusicapp_index_home')
      ->limit(1)
      ->query()
      ->fetchColumn();
    if( !$page_id ) {
			$widgetOrder = 1;
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesmusicapp_index_home',
        'displayname' => 'SES - Custom Music App Ext - Music App Home Page',
        'title' => 'SES - Custom Music App Ext - Music App Home Page',
        'description' => 'This page is the music app Home page.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();
      // Insert main
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => $widgetOrder++,
      ));
      $main_id = $db->lastInsertId();
			
      
      // Insert top-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
				'order' => $widgetOrder++,
      ));
      $topMiddleId = $db->lastInsertId();
	
			// Insert right-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'right',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
				'order' => 4,
      ));
      $topRightId = $db->lastInsertId();
			
      /*-----------topMiddleId's content --------------*/
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.popular-playlist',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"showOptionsType":"all","showType":"carouselview","popularity":"view_count","information":["title"],"viewType":"horizontal","height":"200","width":"278","limit":"12","title":"Popular Playlists","nomobile":"0","name":"sesmusicapp.popular-playlist"}',
      ));
			
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.popular-artists',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"popularity":"favourite_count","viewType":"gridview","information":"","height":"124","width":"204","limit":"8","title":"Most Favourited Artists","nomobile":"0","name":"sesmusicapp.popular-artists"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.featured-sponsored-hot-carousel',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"contentType":"songs","popularity":"creation_date","displayContentType":"hot","information":["likeCount","favouriteCount","downloadCount","playCount","title","share","favourite","addplaylist","socialSharing","addLikeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"3","viewType":"horizontal","height":"140","width":"235","limit":"12","title":"Hot Songs","nomobile":"0","name":"sesmusicapp.featured-sponsored-hot-carousel"}',
      ));
			
			
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'core.ad-campaign',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"title":"","name":"core.ad-campaign","adcampaign_id":"2","nomobile":"0"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.popular-recommanded-other-related-songs',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"showType":"all","viewType":"gridview","popularity":"favourite_count","information":["viewCount","favouriteCount","downloadCount","playCount","ratingCount","socialSharing","favourite"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","height":"140","width":"278","limit":"6","title":"Most Favourited Songs","nomobile":"0","name":"sesmusicapp.popular-recommanded-other-related-songs"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.popular-albums',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"showType":"all","popularity":"creation_date","viewType":"gridview","showPhoto":"0","information":["likeCount","favouriteCount","songsCount","ratingCount","title","addLikeButton","favourite"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","height":"140","width":"278","limit":"6","title":"Recentently created Albums","nomobile":"0","name":"sesmusicapp.popular-albums"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'core.ad-campaign',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '["[]"]',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.category',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"contentType":"song","showType":"simple","image":"1","color":"#00f","text_height":"15","height":"140","width":"234","limit":"4","title":"Browse Songs by Popular Categories","nomobile":"0","name":"sesmusicapp.category"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.popular-recommanded-songs',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"showType":"recommanded","viewType":"gridview","popularity":"play_count","information":["likeCount","favouriteCount","downloadCount","playCount","ratingCount","socialSharing","addLikeButton","favourite"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"3","height":"140","width":"278","limit":"6","title":"Recommended Songs","nomobile":"0","name":"sesmusicapp.popular-recommanded-songs"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.recently-viewed-item',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"category":"sesmusic_albumsong","viewType":"gridview","criteria":"by_myfriend","information":["viewCount","likeCount","songsCount","commentCount","downloadCount","favourite","addplaylist","socialSharing","addLikeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"1","height":"110","width":"140","limit":"8","title":"Recently played Songs","nomobile":"0","name":"sesmusicapp.recently-viewed-item"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.popular-artists',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"popularity":"rating","viewType":"gridview","information":"","height":"140","width":"204","limit":"8","title":"Most Rated Artist","nomobile":"0","name":"sesmusicapp.popular-artists"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.popular-recommanded-other-related-songs',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"showType":"all","viewType":"gridview","popularity":"rating","information":["downloadCount","playCount","ratingCount","socialSharing","addLikeButton","favourite"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"3","height":"140","width":"278","limit":"3","title":"Most Rated Songs","nomobile":"0","name":"sesmusicapp.popular-recommanded-other-related-songs"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.popular-recommanded-other-related-songs',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"showType":"all","viewType":"gridview","popularity":"creation_date","information":["downloadCount","playCount","ratingCount","addLikeButton","favourite"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"1","height":"140","width":"278","limit":"3","title":"Recently Created Songs","nomobile":"0","name":"sesmusicapp.popular-recommanded-other-related-songs"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'core.ad-campaign',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"title":"","name":"core.ad-campaign","adcampaign_id":"2","nomobile":"0"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.popular-recommanded-other-related-songs',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"showType":"all","viewType":"gridview","popularity":"like_count","information":["likeCount","commentCount","viewCount","socialSharing","addLikeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"3","height":"140","width":"278","limit":"3","title":"Most Liked Songs","nomobile":"0","name":"sesmusicapp.popular-recommanded-other-related-songs"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.popular-recommanded-other-related-songs',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"showType":"all","viewType":"gridview","popularity":"play_count","information":["hot","viewCount","downloadCount","playCount","socialSharing","addLikeButton","favourite"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"3","height":"140","width":"278","limit":"3","title":"Most Played Related  Songs","nomobile":"0","name":"sesmusicapp.popular-recommanded-other-related-songs"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.featured-sponsored-hot-carousel',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"contentType":"albums","popularity":"comment_count","displayContentType":"featured","information":["title","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"3","viewType":"horizontal","height":"140","width":"235","limit":"6","title":"Featured Albums","nomobile":"0","name":"sesmusicapp.featured-sponsored-hot-carousel"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.popular-albums',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"showType":"all","viewType":"gridview","popularity":"modified_date","information":["downloadCount","playCount","socialSharing","addLikeButton","favourite"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"3","height":"140","width":"278","limit":"6","title":"Recently Updated Songs ","nomobile":"0","name":"sesmusicapp.popular-recommanded-other-related-songs"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.popular-recommanded-other-related-songs',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"showType":"all","viewType":"gridview","popularity":"modified_date","information":["downloadCount","playCount","socialSharing","addLikeButton","favourite"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"3","height":"140","width":"278","limit":"6","title":"Recently Updated Songs ","nomobile":"0","name":"sesmusicapp.popular-recommanded-other-related-songs"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.category',
          'page_id' => $page_id,
          'parent_content_id' => $topMiddleId,
          'order' => $widgetOrder++,
          'params' => '{"contentType":"album","showType":"simple","image":"1","color":"#00f","text_height":"15","height":"140","width":"234","limit":"4","title":"Music Album Categories","nomobile":"0","name":"sesmusicapp.category"}',
      ));
			/*-----------topMiddleId's content --------------*/
			
			/*-----------topRightId's content --------------*/
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sescommunityads.sidebar-widget-ads',
          'page_id' => $page_id,
          'parent_content_id' => $topRightId,
          'order' => $widgetOrder++,
          'params' => '{"category":"","featured_sponsored":"3","limit":"3","title":"Sponsored","nomobile":"0","name":"sescommunityads.sidebar-widget-ads"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesfixedlayout',
          'page_id' => $page_id,
          'parent_content_id' => $topRightId,
          'order' => $widgetOrder++,
          'params' => '["[]"]',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesbasic.column-layout-width',
          'page_id' => $page_id,
          'parent_content_id' => $topRightId,
          'order' => $widgetOrder++,
          'params' => '{"layoutColumnWidthType":"px","columnWidth":"300","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
      ));
			$db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesmusicapp.album-song-playlist-artist-day-of-the',
          'page_id' => $page_id,
          'parent_content_id' => $topRightId,
          'order' => $widgetOrder++,
          'params' => '{"title":"Songs of the day","contentType":"albumsong","information":["ratingCount","title","songsCount","downloadCount","socialSharing","addLikeButton","addFavouriteButton"],"color":"#E74C3C","socialshare_enable_plusicon":"1","socialshare_icon_limit":"1","nomobile":"0","name":"sesmusicapp.album-song-playlist-artist-day-of-the"}',
      ));
			/*-----------topRightId's content --------------*/
			
    }