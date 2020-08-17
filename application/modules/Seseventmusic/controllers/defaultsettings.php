<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Album home Page
$widgetOrder = 1;

$select = new Zend_Db_Select($db);
$select
        ->from('engine4_core_pages')
        ->where('name = ?', 'seseventmusic_index_home')
        ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {
  $db->insert('engine4_core_pages', array(
      'name' => 'seseventmusic_index_home',
      'displayname' => 'SES - Advanced Events - Music Album Home Page',
      'title' => 'Event Music Album Home',
      'description' => 'This is the event music album home page.',
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
      'params' => '',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.music-home-error',
      'parent_content_id' => $topmiddle_id,
      'order' => $widgetOrder++
  ));

  //Left side
  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.album-song-day-of-the',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Album of the Day","contentType":"album","album_title":"","album_id":"","information":["likeCount","commentCount","viewCount","ratingCount","title","postedby","songsCount","favouriteCount"],"starttime":"","endtime":"","nomobile":"0","name":"seseventmusic.album-song-day-of-the"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.album-song-day-of-the',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Song of the Day","contentType":"albumsong","album_title":"","album_id":"","information":["likeCount","commentCount","viewCount","ratingCount","title","postedby","songsCount","favouriteCount"],"starttime":"","endtime":"","nomobile":"0","name":"seseventmusic.album-song-day-of-the"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-songs',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"all","viewType":"listview","popularity":"download_count","information":["likeCount","commentCount","viewCount","downloadCount","playCount","ratingCount","postedby"],"height":"150","width":"100","limit":"3","title":"Most Downloaded Songs","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-songs"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-albums',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"all","popularity":"like_count","viewType":"listview","showPhoto":"1","information":["likeCount","commentCount","viewCount","songsCount","ratingCount","title","postedby"],"height":"110","width":"100","limit":"3","title":"Most Liked Albums","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-albums"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-songs',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"recommanded","viewType":"listview","popularity":"creation_date","information":["likeCount","commentCount","viewCount","downloadCount","playCount","ratingCount","title","postedby"],"height":"200","width":"100","limit":"3","title":"Recommended Songs","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-songs"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-albums',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"all","popularity":"comment_count","viewType":"listview","showPhoto":"1","information":["likeCount","commentCount","viewCount","songsCount","ratingCount","title","postedby"],"height":"100","width":"100","limit":"3","title":"Most Commented Albums","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-albums"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.recently-viewed-item',
      'parent_content_id' => $left_id,
      'order' => $widgetOrder++,
      'params' => '{"category":"seseventmusic_albumsong","viewType":"listView","criteria":"by_me","information":["postedby","viewCount","likeCount","songsCount","ratingCount","commentCount","downloadCount","share","favourite"],"Height":"180","Width":"180","limit_data":"3","title":"Recently Viewed Songs","nomobile":"0","name":"seseventmusic.recently-viewed-item"}',
  ));


  //Middle
  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.search',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '["[]"]',
  ));


  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.featured-sponsored-hot-carousel',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"contentType":"songs","popularity":"creation_date","displayContentType":"upcoming","information":["songsCount","ratingCount","downloadCount","playCount","title","postedby","share","favourite"],"viewType":"horizontal","height":"150","width":"163","limit":"12","title":"New Releases","nomobile":"0","name":"seseventmusic.featured-sponsored-hot-carousel"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.featured-sponsored-hot-carousel',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"contentType":"albums","popularity":"creation_date","displayContentType":"featured","information":["likeCount","songsCount","ratingCount","title","postedby","share","favourite"],"viewType":"horizontal","height":"150","width":"163","limit":"10","title":"Featured Music Albums","nomobile":"0","name":"seseventmusic.featured-sponsored-hot-carousel"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.tabbed-widget-songs',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"height":"150","width":"159","showTabType":"1","search_type":["recently1Created","play1Count","most1Rated","most1Downloaded","featured","sponsored"],"default":"play1Count","information":["ratingStars","postedby","favourite","share"],"limit_data":"12","title":"Songs","nomobile":"0","name":"seseventmusic.tabbed-widget-songs"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.tabbed-widget',
      'parent_content_id' => $middle_id,
      'order' => $widgetOrder++,
      'params' => '{"height":"150","width":"159","showTabType":"1","search_type":["recently1Created","song1Count","most1Rated","hot","featured","sponsored"],"default":"recently1Created","information":["songCount","title","postedby","favourite","share"],"limit_data":"12","title":"Music Albums","nomobile":"0","name":"seseventmusic.tabbed-widget"}',
  ));


  //Right side
  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.featured-sponsored-hot-carousel',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"contentType":"songs","popularity":"like_count","displayContentType":"featured","information":["viewCount","downloadCount","playCount","title","postedby","share","favourite"],"viewType":"vertical","height":"220","width":"200","limit":"6","title":"Featured Songs","nomobile":"0","name":"seseventmusic.featured-sponsored-hot-carousel"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-songs',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"all","viewType":"listview","popularity":"creation_date","information":["likeCount","commentCount","viewCount","downloadCount","playCount","ratingCount","title","postedby"],"height":"200","width":"100","limit":"3","title":"Recently Uploaded Songs","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-songs"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-songs',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"all","viewType":"listview","popularity":"play_count","information":["likeCount","commentCount","viewCount","downloadCount","playCount","ratingCount","title","postedby"],"height":"200","width":"100","limit":"3","title":"Most Played Songs","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-songs"}',
  ));

  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'seseventmusic.you-may-also-like-album-songs',
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Music You May Also Like","showPhoto":"1","information":["likeCount","commentCount","viewCount","ratingCount","songCount","title","postedby"],"viewType":"listView","height":"200","width":"100","itemCount":"3","nomobile":"0","name":"seseventmusic.you-may-also-like-album-songs"}',
  ));
}


//Album Browse Page
$widgetOrder = 1;
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seseventmusic_index_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $db->insert('engine4_core_pages', array(
      'name' => 'seseventmusic_index_browse',
      'displayname' => 'SES - Advanced Events - Event Browse Music Albums Page',
      'title' => 'Event Browse Music Albums',
      'description' => 'This page lists all event music albums.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $main_right_id = $db->lastInsertId();

  //Main Top
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesevent.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.album-songs-alphabet',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"","contentType":"albums","nomobile":"0","name":"seseventmusic.album-songs-alphabet"}',
  ));

  //Middle
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.search',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '["[]"]',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.featured-sponsored-hot-carousel',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"contentType":"albums","popularity":"creation_date","displayContentType":"sponsored","information":["songsCount","ratingCount","title","postedby","share","favourite","addplaylist"],"viewType":"horizontal","height":"150","width":"150","limit":"15","title":"Sponsored Music Albums","nomobile":"0","name":"seseventmusic.featured-sponsored-hot-carousel"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.browse-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"gridview","Type":"1","popularity":"creation_date","information":["featured","sponsored","hot","likeCount","commentCount","viewCount","title","postedby","favourite","addplaylist","share"],"height":"220","width":"225","itemCount":"12","title":"","nomobile":"0","name":"seseventmusic.browse-albums"}',
  ));

  //Rigth Side
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.album-song-day-of-the',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Album of the Day","contentType":"album","album_title":"She Wolf","album_id":"12","information":["featured","sponsored","hot","likeCount","commentCount","viewCount","ratingCount","title","postedby","songsCount","favouriteCount"],"starttime":"2015-03-18 01:00:00","endtime":"2021-10-31 01:00:00","nomobile":"0","name":"seseventmusic.album-song-day-of-the"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.featured-sponsored-hot-carousel',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"contentType":"albums","popularity":"creation_date","displayContentType":"hot","information":["likeCount","commentCount","viewCount","songsCount","ratingCount","title","postedby","share","favourite","addplaylist"],"viewType":"vertical","height":"200","width":"200","limit":"5","title":"Hot Music Albums","nomobile":"0","name":"seseventmusic.featured-sponsored-hot-carousel"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.browse-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"searchOptionsType":["searchBox","category","view","show","artists"],"title":"","nomobile":"0","name":"seseventmusic.browse-search"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"all","popularity":"rating","viewType":"listview","showPhoto":"0","information":["featured","sponsored","hot","likeCount","commentCount","viewCount","songsCount","ratingCount","title","postedby"],"height":"200","width":"200","limit":"3","title":"Most Rated Music Albums","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-albums"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.recently-viewed-item',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"category":"seseventmusic_album","viewType":"listView","criteria":"by_me","information":["hot","featured","postedby","sponsored","viewCount","likeCount","songsCount","ratingCount","commentCount","downloadCount","share","favourite","addplaylist"],"Height":"180","Width":"180","limit_data":"3","title":"Recently Viewed Albums","nomobile":"0","name":"seseventmusic.recently-viewed-item"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"all","popularity":"song_count","viewType":"listview","showPhoto":"0","information":["likeCount","commentCount","viewCount","songsCount","ratingCount","title","postedby"],"height":"200","width":"100","limit":"3","title":"Having Maximum Songs","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-albums"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"all","popularity":"comment_count","viewType":"listview","showPhoto":"0","information":["likeCount","commentCount","viewCount","songsCount","ratingCount","title","postedby"],"height":"200","width":"100","limit":"3","title":"Most Commented Albums","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-albums"}',
  ));
}


//Album Create Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seseventmusic_index_create')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $db->insert('engine4_core_pages', array(
      'name' => 'seseventmusic_index_create',
      'displayname' => 'SES - Advanced Events - Music Album Create Page',
      'title' => 'Music Album Create',
      'description' => 'This page is the music album create page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
  ));
  $top_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();
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
      'name' => 'core.content',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 1,
  ));
}

//Album Edit Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seseventmusic_album_edit')
        ->limit(1)
        ->query()
        ->fetchColumn();

if (!$page_id) {
  $db->insert('engine4_core_pages', array(
      'name' => 'seseventmusic_album_edit',
      'displayname' => 'SES - Advanced Events - Music Album Edit Page',
      'title' => 'Music Album Edit',
      'description' => 'This page is the music album edit page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
  ));
  $top_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();
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
      'name' => 'core.content',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 1,
  ));
}

//Album View Page
$widgetOrder = 1;
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seseventmusic_album_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $db->insert('engine4_core_pages', array(
      'name' => 'seseventmusic_album_view',
      'displayname' => 'SES - Advanced Events - Music Album View Page',
      'title' => 'Music Album View',
      'description' => 'This page displays a music album view page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
  ));
  $top_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $main_right_id = $db->lastInsertId();

  //Main Top
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.breadcrumb',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewPageType":"album"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.album-cover',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"height":"360","mainPhotoHeight":"320","mainPhotowidth":"330","information":["postedBy","creationDate","commentCount","viewCount","likeCount","ratingCount","ratingStars","favouriteCount","description","editButton","deleteButton","share","report","addFavouriteButton","photo"],"title":"","nomobile":"0","name":"seseventmusic.album-cover"}'
  ));

  //Middle 
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.content',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.comments',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
  ));

  //Right Side
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.albums-songs-like',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Members Who Liked This","contentType":"albums","showUsers":"all","showViewType":"0","itemCount":"8","nomobile":"0","name":"seseventmusic.albums-songs-like"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.albums-songs-like',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Friends Who Liked This","contentType":"albums","showUsers":"friends","showViewType":"1","itemCount":"3","nomobile":"0","name":"seseventmusic.albums-songs-like"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"other","popularity":"view_count","viewType":"listview","showPhoto":"0","information":["likeCount","commentCount","viewCount","songsCount","ratingCount","title","postedby"],"height":"200","width":"200","limit":"3","title":"Other Music Albums","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-albums"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"related","popularity":"creation_date","viewType":"listview","showPhoto":"0","information":["likeCount","commentCount","viewCount","songsCount","ratingCount","title","postedby"],"height":"200","width":"200","limit":"3","title":"Related Music Albums","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-albums"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.you-may-also-like-album-songs',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Music You May Also Like","showPhoto":"0","information":["likeCount","commentCount","viewCount","ratingCount","title","postedby"],"viewType":"listView","height":"200","width":"200","itemCount":"3","nomobile":"0","name":"seseventmusic.you-may-also-like-album-songs"}',
  ));
}

//Song View Page
$widgetOrder = 1;
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seseventmusic_song_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $db->insert('engine4_core_pages', array(
      'name' => 'seseventmusic_song_view',
      'displayname' => 'SES - Advanced Events - Song View Page',
      'title' => 'Song View',
      'description' => 'This page displays a all music album songs.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
  ));
  $top_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $main_right_id = $db->lastInsertId();

  //Main Top
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.breadcrumb',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewPageType":"song"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.song-cover',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"height":"300","mainPhotoHeight":"170","mainPhotowidth":"190","information":["postedBy","creationDate","commentCount","viewCount","likeCount","ratingCount","ratingStars","favouriteCount","playCount","playButton","editButton","deleteButton","share","report","printButton","downloadButton","addFavouriteButton","photo","category"],"title":"","nomobile":"0","name":"seseventmusic.song-cover"}',
  ));

  //Middle
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.content',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 1,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.comments',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
  ));

  //Right Side
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.albums-songs-like',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Members Who Liked This","contentType":"songs","showUsers":"all","showViewType":"0","itemCount":"8","nomobile":"0","name":"seseventmusic.albums-songs-like"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.albums-songs-like',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Friends Who Likes This","contentType":"songs","showUsers":"friends","showViewType":"1","itemCount":"3","nomobile":"0","name":"seseventmusic.albums-songs-like"}',
  ));


  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-songs',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"other","viewType":"listview","popularity":"like_count","information":["likeCount","commentCount","viewCount","downloadCount","playCount","ratingCount","title","postedby"],"height":"200","width":"200","limit":"3","title":"Other Songs","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-songs"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.popular-recommanded-other-related-songs',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"showType":"related","viewType":"listview","popularity":"creation_date","information":["likeCount","commentCount","viewCount","downloadCount","playCount","ratingCount","title","postedby"],"height":"200","width":"100","limit":"3","title":"Related Songs","nomobile":"0","name":"seseventmusic.popular-recommanded-other-related-songs"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'seseventmusic.recently-viewed-item',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"category":"seseventmusic_albumsong","viewType":"listView","criteria":"by_me","information":["postedby","viewCount","likeCount","songsCount","ratingCount","commentCount","downloadCount","share","favourite"],"Height":" ","Width":"180","limit_data":"3","title":"Recently Viewed Songs","nomobile":"0","name":"seseventmusic.recently-viewed-item"}',
  ));
}


//Add Player in footer
// $select = new Zend_Db_Select($db);
// $select
//         ->from('engine4_core_content', 'content_id')
//         ->where('page_id = ?', 2)
//         ->where('name = ?', 'main')
//         ->limit(1);
// $info = $select->query()->fetch();
// if ($info) {
//   $select = new Zend_Db_Select($db);
//   $select
//           ->from('engine4_core_content', 'content_id')
//           ->where('type = ?', 'widget')
//           ->where('name = ?', 'seseventmusic.player')
//           ->limit(1);
//   $welcome = $select->query()->fetch();
//   if ($info && !$welcome) {
//     $db->query("UPDATE `engine4_core_content` SET `order` = '999' WHERE `engine4_core_content`.`name` = 'core.menu-footer' LIMIT 1;");
//     $db->insert('engine4_core_content', array(
//         'type' => 'widget',
//         'name' => 'seseventmusic.player',
//         'parent_content_id' => $info['content_id'],
//         'page_id' => 2,
//         'order' => 1,
//     ));
//   }
// }

// //Member Profile Page
// $select = new Zend_Db_Select($db);
// $select->from('engine4_core_pages')
//         ->where('name = ?', 'user_profile_index')
//         ->limit(1);
// $page_id = $select->query()->fetchObject()->page_id;
// if ($page_id) {
//   $select = new Zend_Db_Select($db);
//   $select
//           ->from('engine4_core_content')
//           ->where('page_id = ?', $page_id)
//           ->where('type = ?', 'widget')
//           ->where('name = ?', 'seseventmusic.profile-musicalbums');
//   $info = $select->query()->fetch();
//   if (empty($info)) {
//     $select = new Zend_Db_Select($db);
//     $select
//             ->from('engine4_core_content')
//             ->where('page_id = ?', $page_id)
//             ->where('type = ?', 'container')
//             ->limit(1);
//     $container_id = $select->query()->fetchObject()->content_id;
//     $select = new Zend_Db_Select($db);
//     $select
//             ->from('engine4_core_content')
//             ->where('parent_content_id = ?', $container_id)
//             ->where('type = ?', 'container')
//             ->where('name = ?', 'middle')
//             ->limit(1);
//     $middle_id = $select->query()->fetchObject()->content_id;
//     $select
//             ->reset('where')
//             ->where('type = ?', 'widget')
//             ->where('name = ?', 'core.container-tabs')
//             ->where('page_id = ?', $page_id)
//             ->limit(1);
//     $tab_id = $select->query()->fetchObject();
//     if ($tab_id && @$tab_id->content_id) {
//       $tab_id = $tab_id->content_id;
//     } else {
//       $tab_id = null;
//     }
//     $db->insert('engine4_core_content', array(
//         'page_id' => $page_id,
//         'type' => 'widget',
//         'name' => 'seseventmusic.profile-musicalbums',
//         'parent_content_id' => ($tab_id ? $tab_id : $middle_id),
//         'order' => 999,
//         'params' => '{"defaultOptionsShow":["profilemusicalbums","songofyou","favouriteSong"],"pagging":"auto_load","Height":"222","Width":"222","limit_data":"12","title":"Music","nomobile":"0","name":"seseventmusic.profile-musicalbums"}',
//     ));
//   }
// }


$music_album_table_exist = $db->query('SHOW TABLES LIKE \'engine4_seseventmusic_albums\'')->fetch();
if (!empty($music_album_table_exist)) {
  $resource_type = $db->query("SHOW COLUMNS FROM engine4_seseventmusic_albums LIKE 'resource_type'")->fetch();
  if (empty($resource_type)) {
    $db->query("ALTER TABLE `engine4_seseventmusic_albums` ADD `resource_type` varchar(128) NOT NULL");
  }

  $resource_id = $db->query("SHOW COLUMNS FROM engine4_seseventmusic_albums LIKE 'resource_id'")->fetch();
  if (empty($resource_id)) {
    $db->query("ALTER TABLE `engine4_seseventmusic_albums` ADD `resource_id` int(11) NOT NULL");
  }
}