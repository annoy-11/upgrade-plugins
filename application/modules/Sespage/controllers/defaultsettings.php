<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsetings.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();
$activutyType = (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedactivity.pluginactivated')) ? 1 : 0;

// Welcome page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_welcome')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_welcome',
      'displayname' => 'SES - Page Directories - Pages Welcome Page',
      'title' => 'Page Welcome Page',
      'description' => 'This page lists pages.',
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
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.banner-search',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"banner_title":"Explore World\u2019s Largest Page Directory","description":"Search Pages from 11,99,389 Awesome Verified Directories!","height_image":"520","show_criteria":["title","location","category"],"show_carousel":"1","category_carousel_title":"Boost your search with Trending Categories","show_full_width":"yes","title":"","nomobile":"0","name":"sespage.banner-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid","order":"","category_id":"","criteria":"6","info":"most_liked","show_criteria":["title","by","ownerPhoto","category","status","location","contactDetail","likeButton","favouriteButton","followButton","like","comment","favourite","view","follow","verifiedLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"160","width":"300","limit_data":"8","title":"Verified Pages","nomobile":"0","name":"sespage.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.html-block',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title":"","adminTitle":"Explore All Verified Pages Button","data":"<a href=\"javascript:void(0);\" onclick=\"changeSespageManifestUrl(&#39;verified&#39;);\" class=\"sesbasic_link_btn\">Explore All Verified Pages<\/a>","nomobile":"0","name":"core.html-block"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"horrizontallist","order":"","category_id":"","criteria":"1","info":"favourite_count","show_criteria":["title","by","ownerPhoto","creationDate","category","status","description","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","like","favourite","follow"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"200","width":"250","limit_data":"6","title":"Explore Featured Pages","nomobile":"0","name":"sespage.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.html-block',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title":"","adminTitle":"View All Featured Pages Button","data":"<a href=\"javascript:void(0);\" onclick=\"changeSespageManifestUrl(&#39;featured&#39;);\" class=\"sesbasic_link_btn\">View All Featured Pages<\/a>","nomobile":"0","name":"core.html-block"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.featured-sponsored-carousel',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"horizontal","order":"","category_id":"","criteria":"5","info":"creation_date","show_criteria":["title","by","ownerPhoto","creationDate","category","status","location","socialSharing","likeButton","favouriteButton","followButton","joinButton","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","imageheight":"235","width":"397","limit_data":"10","title":"Latest Posted Pages","nomobile":"0","name":"sespage.featured-sponsored-carousel"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.html-block',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title":"","adminTitle":"Recent Pages Button","data":"<a href=\"javascript:void(0);\" onclick=\"changeSespageManifestUrl(&#39;browse&#39;);\" class=\"sesbasic_link_btn\">Find Recent Pages<\/a>","nomobile":"0","name":"core.html-block"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesbasic.body-class',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"bodyclass":"sespage_welcome_page","title":"","nomobile":"0","name":"sesbasic.body-class"}',
  ));
}

//SES - Page Home Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_home')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_home',
      'displayname' => 'SES - Page Directories - Pages Home Page',
      'title' => 'Page Directories Home',
      'description' => 'This page lists a user\'s pages.',
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
      'order' => 3,
  ));
  $mainMiddleId = $db->lastInsertId();

  // Insert main-left
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'left',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 1,
  ));
  $mainLeftId = $db->lastInsertId();

// Insert main-right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 2,
  ));
  $mainRightId = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-of-day',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Page of the Day","category_id":"","information":["title","postedby","category","location","likeButton","favouriteButton","followButton","contactButton","like","comment","view","favourite","follow","featuredLabel","sponsoredLabel","hotLabel","verifiedLabel"],"imageheight":"150","title_truncation":"45","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","nomobile":"0","name":"sespage.page-of-day"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid","order":"","category_id":"","criteria":"6","info":"recently_created","show_criteria":["title"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"140","width":"250","limit_data":"2","title":"Verified Pages","nomobile":"0","name":"sespage.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.recently-viewed-item',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","category_id":"","criteria":"by_me","show_criteria":["title","by","location","like","verifiedLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","height":"50","width":"50","width_pinboard":"200","limit_data":"3","title":"Recently Viewed Pages","nomobile":"0","name":"sespage.recently-viewed-item"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":"","category_id":"","criteria":"5","info":"recently_created","show_criteria":["title","by","creationDate","category","description","joinButton","hotLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"210","height":"50","width":"55","limit_data":"3","title":"Hot Pages","nomobile":"0","name":"sespage.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.pages-slideshow',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"leftPage":"0","category":"","info":"recently_created","criteria":"5","order":"","enableSlideshow":"1","criteria_right":"5","info_right":"most_viewed","navigation":"1","autoplay":"1","title_truncation":"45","description_truncation":"100","speed":"2500","height":"300","limit_data":"6","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_criteria":["title","socialSharing","likeButton","favouriteButton","followButton","member","like","comment","favourite","view","follow"],"title":"Popular Pages","nomobile":"0","name":"sespage.pages-slideshow"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.tabbed-widget-page',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","grid","simplegrid","advgrid","pinboard","map"],"openViewType":"advlist","tabOption":"filter","category_id":"","show_criteria":["title","by","ownerPhoto","creationDate","category","location","listdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","price","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"button","show_limited_data":"no","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","htmlTitle":"1","dummy15":null,"limit_data_list":"8","list_title_truncation":"45","list_description_truncation":"45","height":"100","width":"100","dummy16":null,"limit_data_advlist":"6","advlist_title_truncation":"45","advlist_description_truncation":"40","height_advlist":"133","width_advlist":"120","dummy17":null,"limit_data_grid":"6","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"159","width_grid":"324","dummy18":null,"limit_data_simplegrid":"6","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"199","width_simplegrid":"324","dummy19":null,"limit_data_advgrid":"6","advgrid_title_truncation":"45","advgrid_description_truncation":"45","height_advgrid":"250","width_advgrid":"324","dummy20":null,"limit_data_pinboard":"6","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"320","dummy21":null,"limit_data_map":"15","search_type":["open","mostSPliked","mostSPfavourite","mostSPjoined","sponsored","verified","hot"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPliked_order":"2","mostSPliked_label":"Most Liked","dummy3":null,"mostSPcommented_order":"3","mostSPcommented_label":"Most Commented","dummy4":null,"mostSPviewed_order":"4","mostSPviewed_label":"Most Viewed","dummy5":null,"mostSPfavourite_order":"5","mostSPfavourite_label":"Most Favourited","dummy6":null,"mostSPfollowed_order":"6","mostSPfollowed_label":"Most Followed","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"hot_order":"10","hot_label":"Hot","title":"","nomobile":"0","name":"sespage.tabbed-widget-page"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.category-associate-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"grid","criteria":"admin_order","popularty":"all","order":"like_count","show_category_criteria":["seeAll"],"show_criteria":["title"],"pagging":"auto_load","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","grid_description_truncation":"45","title_truncation":"45","slideshow_description_truncation":"45","height":"230","width":"324","category_limit":"6","page_limit":"3","allignment_seeall":"right","title":"Popular Pages-  Categories","nomobile":"0","name":"sespage.category-associate-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid","order":"open","category_id":"","criteria":"5","info":"most_liked","show_criteria":["title","joinButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"140","width":"250","limit_data":"3","title":"Most Liked Pages","nomobile":"0","name":"sespage.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.you-may-also-like-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Pages You May Also Like","viewType":"listView","category_id":"","information":["title","socialSharing","contactButton","joinButton","favourite"],"title_truncation":"45","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","height":"50","width":"50","limit_data":"3","nomobile":"0","name":"sespage.you-may-also-like-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.tag-cloud-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"color":"#95ff00","type":"tab","text_height":"20","height":"250","itemCountPerPage":"15","title":"","nomobile":"0","name":"sespage.tag-cloud-pages"}',
  ));
}

//SES - Page Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_browse',
      'displayname' => 'SES - Page Directories - Pages Browse Page',
      'title' => 'Page Browse',
      'description' => 'This page lists pages.',
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

  // Insert main-right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 1,
  ));
  $mainRightId = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-category-icons',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"titleC":"Browse by Category","criteria":"most_page","show_criteria":["title"],"alignContent":"center","viewType":"image","shapeType":"circle","show_bg_color":"1","bgColor":"#FFFFFF","height":"130","width":"130","limit_data":"10","title":"","nomobile":"0","name":"sespage.page-category-icons"}',
  ));
// Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"mostSPliked","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchPageTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closepage"],"hide_option":["searchPageTitle","view","browseBy","alphabet","Categories","location","miles","closepage"],"title":"","nomobile":"0","name":"sespage.browse-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-alphabet',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","price","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","verifiedLabel"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"250","height":"130","width":"215","dummy16":null,"limit_data_advlist":"5","advlist_title_truncation":"45","advlist_description_truncation":"150","height_advlist":"250","width_advlist":"310","dummy17":null,"limit_data_grid":"9","grid_title_truncation":"45","grid_description_truncation":"100","height_grid":"220","width_grid":"304","dummy18":null,"limit_data_simplegrid":"9","simplegrid_title_truncation":"45","simplegrid_description_truncation":"50","height_simplegrid":"230","width_simplegrid":"304","dummy19":null,"limit_data_advgrid":"9","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"260","width_advgrid":"304","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"25","title":"","nomobile":"0","name":"sespage.browse-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.featured-sponsored-verified-hot-slideshow',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"category":"","criteria":"6","info":"creation_date","isfullwidth":"0","autoplay":"1","speed":"2000","navigation":"nextprev","show_criteria":["title","description"],"title_truncation":"45","description_truncation":"55","height":"200","limit_data":"5","title":"Verified Pages","nomobile":"0","name":"sespage.featured-sponsored-verified-hot-slideshow"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":"","category_id":"","criteria":"5","info":"most_viewed","show_criteria":["title","like","comment"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"21","description_truncation":"45","width_pinboard":"300","height":"50","width":"50","limit_data":"3","title":"Sponsored Pages","nomobile":"0","name":"sespage.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.tag-cloud-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"color":"#00000","type":"cloud","text_height":"15","height":"150","itemCountPerPage":"20","title":"","nomobile":"0","name":"sespage.tag-cloud-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":"","category_id":"","criteria":"5","info":"follow_count","show_criteria":["title","like","comment"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"21","description_truncation":"45","width_pinboard":"50","height":"50","width":"50","limit_data":"3","title":"Featured Pages","nomobile":"0","name":"sespage.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.you-may-also-like-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Pages You May Also Like","viewType":"listView","category_id":"","information":["title","by","ownerPhoto","joinButton","like","comment"],"title_truncation":"45","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","height":"80","width":"80","limit_data":"3","nomobile":"0","name":"sespage.you-may-also-like-pages"}',
  ));
}

//SES - Page Browse Locations Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_browse-locations')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_browse-locations',
      'displayname' => 'SES - Page Directories - Pages Browse Locations Page',
      'title' => 'Page Browse Locations',
      'description' => 'This page lists pages locations.',
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
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"recentlySPcreated","criteria":["0","4","1","2","3"],"default_view_search_type":"0","show_option":["searchPageTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closepage"],"hide_option":["miles","country","state","city","zip","venue","closepage"],"title":"","nomobile":"0","name":"sespage.browse-search"}',
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-locations-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"category_id":"","show_criteria":["title","by","category","description","location","socialSharing","like","comment","favourite","view","follow","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"show_item_count":"1","height":"230","width":"260","title_truncation":"45","description_truncation":"45","limit_data_list":"10","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"pagging","title":"","nomobile":"0","name":"sespage.browse-locations-pages"}',
  ));
}

//SES - Page Manage Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_manage')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_manage',
      'displayname' => 'SES - Page Directories - Page Manage Page',
      'title' => 'My Pages',
      'description' => 'This page lists a user\'s pages.',
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
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
  ));

// Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.manage-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","grid","simplegrid","advgrid","pinboard","map"],"openViewType":"list","tabOption":"vertical","category_id":"","show_criteria":["title","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"button","show_limited_data":"no","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","htmlTitle":"1","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"340","width":"300","dummy16":null,"limit_data_advlist":"10","advlist_title_truncation":"45","advlist_description_truncation":"45","height_advlist":"230","width_advlist":"260","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"270","width_grid":"389","dummy18":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"270","width_simplegrid":"389","dummy19":null,"limit_data_advgrid":"10","advgrid_title_truncation":"45","advgrid_description_truncation":"45","height_advgrid":"230","width_advgrid":"260","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"300","dummy21":null,"limit_data_map":"10","search_type":["open","close","recentlySPcreated","mostSPliked","mostSPcommented","mostSPviewed","mostSPfavourite","mostSPjoined","featured","sponsored","verified","hot"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPliked_order":"2","mostSPliked_label":"Most Liked","dummy3":null,"mostSPcommented_order":"3","mostSPcommented_label":"Most Commented","dummy4":null,"mostSPviewed_order":"4","mostSPviewed_label":"Most Viewed","dummy5":null,"mostSPfavourite_order":"5","mostSPfavourite_label":"Most Favourited","dummy6":null,"mostSPfollowed_order":"6","mostSPfollowed_label":"Most Followed","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"hot_order":"10","hot_label":"Hot","title":"","nomobile":"0","name":"sespage.manage-pages"}',
  ));
}

//SES - Page Create Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_create')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_create',
      'displayname' => 'SES - Page Directories - Page Create Page',
      'title' => 'Page Create',
      'description' => 'This page allows page to be create.',
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

// profile page design 1
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_profile_index_1')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_profile_index_1',
      'displayname' => 'SES - Page Directories - page View Page Design 1',
      'title' => 'page View',
      'description' => 'This page displays a page entry.',
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
  // Insert middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'left',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 1,
  ));
  $mainLeftId = $db->lastInsertId();
// Insert middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 2,
  ));
  $mainMiddleId = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-main-photo',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["photo","title","pageUrl","tab"],"title":"","nomobile":"0","name":"sespage.profile-main-photo"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.open-hours',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Operating Hours","name":"sespage.open-hours"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.main-page-details',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["pagePhoto","title","likeButton","favouriteButton","followButton","joinButton"],"title":"","nomobile":"0","name":"sespage.main-page-details"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.recent-people-activity',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["like","favourite","follow"],"height":"50","width":"50","view_more_like":"8","view_more_favourite":"8","view_more_follow":"8","title":"","nomobile":"0","name":"sespage.recent-people-activity"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.recently-viewed-item',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","category_id":"","criteria":"on_site","show_criteria":["title","like","comment","favourite","view"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","height":"50","width":"50","width_pinboard":"300","limit_data":"3","title":"Recently Viewed Pages","nomobile":"0","name":"sespage.recently-viewed-item"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-liked',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Pages Liked by This Page","name":"sespage.page-liked"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-view',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"layout_type":"2","tab_placement":"in","show_criteria":["socialSharing","likeButton","favouriteButton","followButton","joinButton","verifiedLabel","optionMenu"],"show_full_width":"no","margin_top":"1","description_truncation":"150","cover_height":"360","socialshare_enable_plusicon":"1","socialshare_icon_limit":"5","title":"","nomobile":"0","name":"sespage.page-view"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-tips',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.container-tabs',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"max":"7","title":"","name":"core.container-tabs","nomobile":"0"}',
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');
  if ($activutyType) {
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvancedactivity.feed',
        'page_id' => $pageId,
        'parent_content_id' => $tab_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Posts","design":"2","feeddesign":"1","scrollfeed":"1","autoloadTimes":"3","statusplacehoder":"Write Something...","userphotoalign":"left","enablefeedbgwidget":"1","feedbgorder":"random","enablewidthsetting":"0","sesact_image1":null,"sesact_image1_width":"500","sesact_image1_height":"450","sesact_image2":null,"sesact_image2_width":"289","sesact_image2_height":"200","sesact_image3":null,"sesact_image3_bigwidth":"328","sesact_image3_bigheight":"300","sesact_image3_smallwidth":"250","sesact_image3_smallheight":"150","sesact_image4":null,"sesact_image4_bigwidth":"578","sesact_image4_bigheight":"300","sesact_image4_smallwidth":"192","sesact_image4_smallheight":"100","sesact_image5":null,"sesact_image5_bigwidth":"289","sesact_image5_bigheight":"260","sesact_image5_smallwidth":"289","sesact_image5_smallheight":"130","sesact_image6":null,"sesact_image6_width":"289","sesact_image6_height":"150","sesact_image7":null,"sesact_image7_bigwidth":"192","sesact_image7_bigheight":"150","sesact_image7_smallwidth":"144","sesact_image7_smallheight":"150","sesact_image8":null,"sesact_image8_width":"144","sesact_image8_height":"150","sesact_image9":null,"sesact_image9_width":"192","sesact_image9_height":"150","nomobile":"0","name":"sesadvancedactivity.feed"}',
    ));
  } else {
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'activity.feed',
        'page_id' => $pageId,
        'parent_content_id' => $tab_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Posts"}',
    ));
  }
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-overview',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Overview","name":"sespage.page-overview"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-info',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["info","description","profilefield","location"],"title":"Details","nomobile":"0","name":"sespage.page-info"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-map',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Locations","titleCount":true,"name":"sespage.page-map"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-announcements',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"limit_data":"5","title":"Announcements","nomobile":"0","name":"sespage.profile-announcements"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-members',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Members","name":"sespage.profile-members"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.sub-pages',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"list","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","price","location","socialSharing","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"230","width":"260","dummy16":null,"limit_data_advlist":"10","advlist_title_truncation":"45","advlist_description_truncation":"45","height_advlist":"230","width_advlist":"260","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"270","width_grid":"389","dummy18":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"270","width_simplegrid":"389","dummy19":null,"limit_data_advgrid":"10","advgrid_title_truncation":"45","advgrid_description_truncation":"45","height_advgrid":"230","width_advgrid":"260","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"300","dummy21":null,"limit_data_map":"10","title":"Associated Sub Pages","nomobile":"0","name":"sespage.sub-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-photos',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Photos","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"outside","fixHover":"fix","show_criteria":["title","socialSharing","photoCount","likeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"sespage.profile-photos"}',
  ));
}
// profile page design 2
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_profile_index_2')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_profile_index_2',
      'displayname' => 'SES - Page Directories - page View Page Design 2',
      'title' => 'page View',
      'description' => 'This page displays a page entry.',
      'custom' => 0,
  ));
  $pageId = $db->lastInsertId();

// Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $pageId,
      'order' => 1,
  ));
  $topId = $db->lastInsertId();

// Insert top middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $topId,
  ));
  $topMiddleId = $db->lastInsertId();

// Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $pageId,
      'order' => 2,
  ));
  $mainId = $db->lastInsertId();

// Insert middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 2,
  ));
  $mainMiddleId = $db->lastInsertId();

// Insert left
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 1,
  ));
  $mainRightId = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-view',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"layout_type":"2","tab_placement":"out","show_criteria":["title","photo","by","category","socialSharing","likeButton","favouriteButton","followButton","joinButton","like","comment","favourite","view","follow","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","optionMenu"],"show_full_width":"no","margin_top":"1","description_truncation":"250","cover_height":"400","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","title":"","nomobile":"0","name":"sespage.page-view"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-tips',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Tips","description":"","types":["addLocation","addCover","addProfilePhoto"],"nomobile":"0","name":"sespage.profile-tips"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.container-tabs',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"max":"9","title":"","name":"core.container-tabs","nomobile":"0"}',
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');
  if ($activutyType) {
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvancedactivity.feed',
        'page_id' => $pageId,
        'parent_content_id' => $tab_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Posts","design":"2","feeddesign":"1","scrollfeed":"1","autoloadTimes":"3","statusplacehoder":"Post Something...","userphotoalign":"left","enablefeedbgwidget":"1","feedbgorder":"random","enablewidthsetting":"0","sesact_image1":null,"sesact_image1_width":"500","sesact_image1_height":"450","sesact_image2":null,"sesact_image2_width":"289","sesact_image2_height":"200","sesact_image3":null,"sesact_image3_bigwidth":"328","sesact_image3_bigheight":"300","sesact_image3_smallwidth":"250","sesact_image3_smallheight":"150","sesact_image4":null,"sesact_image4_bigwidth":"578","sesact_image4_bigheight":"300","sesact_image4_smallwidth":"192","sesact_image4_smallheight":"100","sesact_image5":null,"sesact_image5_bigwidth":"289","sesact_image5_bigheight":"260","sesact_image5_smallwidth":"289","sesact_image5_smallheight":"130","sesact_image6":null,"sesact_image6_width":"289","sesact_image6_height":"150","sesact_image7":null,"sesact_image7_bigwidth":"192","sesact_image7_bigheight":"150","sesact_image7_smallwidth":"144","sesact_image7_smallheight":"150","sesact_image8":null,"sesact_image8_width":"144","sesact_image8_height":"150","sesact_image9":null,"sesact_image9_width":"192","sesact_image9_height":"150","nomobile":"0","name":"sesadvancedactivity.feed"}',
    ));
  } else {
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'activity.feed',
        'page_id' => $pageId,
        'parent_content_id' => $tab_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Posts"}',
    ));
  }
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-info',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["info","description","profilefield"],"title":"Info","nomobile":"0","name":"sespage.page-info"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-overview',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Overview","name":"sespage.page-overview"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-photos',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","title","by","socialSharing","photoCount","likeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"sespage.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-map',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Map","titleCount":true}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-announcements',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"limit_data":"5","title":"Announcements","nomobile":"0","name":"sespage.profile-announcements"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.sub-pages',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","ownerPhoto","by"],"pagging":"auto_load","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"230","width":"260","dummy16":null,"limit_data_advlist":"10","advlist_title_truncation":"45","advlist_description_truncation":"45","height_advlist":"230","width_advlist":"260","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"270","width_grid":"389","dummy18":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"270","width_simplegrid":"389","dummy19":null,"limit_data_advgrid":"10","advgrid_title_truncation":"45","advgrid_description_truncation":"45","height_advgrid":"230","width_advgrid":"260","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"300","dummy21":null,"limit_data_map":"10","title":"Associated Pages","nomobile":"0","name":"sespage.sub-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.open-hours',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Operating Hours","name":"sespage.open-hours"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-info',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["owner","creationDate","categories","tag","like","comment","favourite","view","follow"],"title":"","nomobile":"0","name":"sespage.profile-info"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.recent-people-activity',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["like","favourite","follow"],"height":"70","width":"70","view_more_like":"1","view_more_favourite":"1","view_more_follow":"1","title":"","nomobile":"0","name":"sespage.recent-people-activity"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.you-may-also-like-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"You May Also Like ","viewType":"gridview","category_id":"","information":["title","socialSharing","contactButton","likeButton","favouriteButton","followButton","joinButton","member","like","comment","favourite","view","follow","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"title_truncation":"45","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","height":"200","width":"200","limit_data":"2","nomobile":"0","name":"sespage.you-may-also-like-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-tags',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"itemCountPerPage":"15","title":"Associated Tags","nomobile":"0","name":"sespage.profile-tags"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.main-page-details',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["pagePhoto","title","likeButton","favouriteButton","followButton","joinButton"],"title":"","nomobile":"0","name":"sespage.main-page-details"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.recently-viewed-item',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","category_id":"","criteria":"by_me","show_criteria":["title","like","comment","favourite","view"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","height":"80","width":"80","width_pinboard":"120","limit_data":"3","title":"Recently Viewed Pages","nomobile":"0","name":"sespage.recently-viewed-item"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-liked',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Pages Liked by This Page","name":"sespage.page-liked"}',
  ));
}
// profile page design 3
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_profile_index_3')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_profile_index_3',
      'displayname' => 'SES - Page Directories - page View Page Design 3',
      'title' => 'page View',
      'description' => 'This page displays a page entry.',
      'custom' => 0,
  ));
  $pageId = $db->lastInsertId();

// Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $pageId,
      'order' => 1,
  ));
  $topId = $db->lastInsertId();

// Insert top middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $topId,
  ));
  $topMiddleId = $db->lastInsertId();

// Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $pageId,
      'order' => 2,
  ));
  $mainId = $db->lastInsertId();

// Insert middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 3,
  ));
  $mainMiddleId = $db->lastInsertId();

// Insert left
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'left',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 1,
  ));
  $mainLeftId = $db->lastInsertId();
  // Insert Right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 2,
  ));
  $mainRightId = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-view',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"layout_type":"1","tab_placement":"in","show_criteria":["title","photo","view","follow","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","optionMenu"],"show_full_width":"yes","margin_top":"20","description_truncation":"150","cover_height":"400","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title":"","nomobile":"0","name":"sespage.page-view"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.owner-photo',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"title":"","showTitle":"1","nomobile":"0","name":"sespage.owner-photo"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-labels',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"option":["featured","sponsored","verified","hot"],"title":"","nomobile":"0","name":"sespage.page-labels"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.you-may-also-like-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Pages You May Also Like","viewType":"listView","category_id":"","information":["title","by","ownerPhoto"],"title_truncation":"45","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","height":"50","width":"50","limit_data":"2","nomobile":"0","name":"sespage.you-may-also-like-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.main-page-details',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["pagePhoto","title","likeButton","favouriteButton","followButton","joinButton"],"title":"","nomobile":"0","name":"sespage.main-page-details"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.recently-viewed-item',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid","category_id":"","criteria":"by_me","show_criteria":["title"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","height":"150","width":"250","width_pinboard":"300","limit_data":"2","title":"Recently Viewed Pages","nomobile":"0","name":"sespage.recently-viewed-item"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-liked',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Pages Liked by This Page","name":"sespage.page-liked"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-tips',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title":"","description":"","types":["addLocation","addCover","addProfilePhoto"],"nomobile":"0","name":"sespage.profile-tips"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.container-tabs',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"max":"8","title":"","name":"core.container-tabs","nomobile":"0"}',
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');
  if ($activutyType) {
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvancedactivity.feed',
        'page_id' => $pageId,
        'parent_content_id' => $tab_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Posts","design":"2","feeddesign":"1","scrollfeed":"1","autoloadTimes":"3","statusplacehoder":"Post Something...","userphotoalign":"left","enablefeedbgwidget":"1","feedbgorder":"random","enablewidthsetting":"0","sesact_image1":null,"sesact_image1_width":"500","sesact_image1_height":"450","sesact_image2":null,"sesact_image2_width":"289","sesact_image2_height":"200","sesact_image3":null,"sesact_image3_bigwidth":"328","sesact_image3_bigheight":"300","sesact_image3_smallwidth":"250","sesact_image3_smallheight":"150","sesact_image4":null,"sesact_image4_bigwidth":"578","sesact_image4_bigheight":"300","sesact_image4_smallwidth":"192","sesact_image4_smallheight":"100","sesact_image5":null,"sesact_image5_bigwidth":"289","sesact_image5_bigheight":"260","sesact_image5_smallwidth":"289","sesact_image5_smallheight":"130","sesact_image6":null,"sesact_image6_width":"289","sesact_image6_height":"150","sesact_image7":null,"sesact_image7_bigwidth":"192","sesact_image7_bigheight":"150","sesact_image7_smallwidth":"144","sesact_image7_smallheight":"150","sesact_image8":null,"sesact_image8_width":"144","sesact_image8_height":"150","sesact_image9":null,"sesact_image9_width":"192","sesact_image9_height":"150","nomobile":"0","name":"sesadvancedactivity.feed"}',
    ));
  } else {
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'activity.feed',
        'page_id' => $pageId,
        'parent_content_id' => $tab_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Posts"}',
    ));
  }
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-info',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["info","description","profilefield"],"title":"Info","nomobile":"0","name":"sespage.page-info"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-overview',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Overview","name":"sespage.page-overview"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-photos',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","title","by","socialSharing","photoCount","likeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"sespage.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-announcements',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"limit_data":"5","title":"Announcements","nomobile":"0","name":"sespage.profile-announcements"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-members',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Members","name":"sespage.profile-members"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-map',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Map","titleCount":true}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.sub-pages',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"list","category_id":"","show_criteria":["title","griddescription","advgriddescription"],"pagging":"auto_load","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"230","width":"260","dummy16":null,"limit_data_advlist":"10","advlist_title_truncation":"45","advlist_description_truncation":"45","height_advlist":"230","width_advlist":"260","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"270","width_grid":"389","dummy18":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"270","width_simplegrid":"389","dummy19":null,"limit_data_advgrid":"10","advgrid_title_truncation":"45","advgrid_description_truncation":"45","height_advgrid":"230","width_advgrid":"260","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"300","dummy21":null,"limit_data_map":"10","title":"Associated Pages","nomobile":"0","name":"sespage.sub-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.open-hours',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.like-button',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"","name":"sespage.like-button"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.follow-button',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"","name":"sespage.follow-button"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.favourite-button',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"","name":"sespage.favourite-button"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.advance-share',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"advShareOptions":"","title":"","nomobile":"0","name":"sespage.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.profile-info',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["owner","creationDate","categories","tag"],"title":"","nomobile":"0","name":"sespage.profile-info"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.recent-people-activity',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["like","favourite","follow"],"height":"50","width":"50","view_more_like":"8","view_more_favourite":"8","view_more_follow":"8","title":"","nomobile":"0","name":"sespage.recent-people-activity"}',
  ));
}
// profile page design 4
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_profile_index_4')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_profile_index_4',
      'displayname' => 'SES - Page Directories - page View Page Design 4',
      'title' => 'page View',
      'description' => 'This page displays a page entry.',
      'custom' => 0,
  ));
  $pageId = $db->lastInsertId();

// Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $pageId,
      'order' => 1,
  ));
  $mainId = $db->lastInsertId();

// Insert middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 3,
  ));
  $mainMiddleId = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'left',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 1,
  ));
  $mainLeftId = $db->lastInsertId();

// Insert right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 1,
  ));
  $mainRightId = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.profile-main-photo',
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["photo","title","pageUrl"],"title":"","nomobile":"0","name":"sespage.profile-main-photo"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.open-hours',
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Operating Hours","name":"sespage.open-hours"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.follow-button',
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.favourite-button',
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.advance-share',
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","tellAFriend","addThis"],"title":"","nomobile":"0","name":"sespage.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.page-labels',
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"option":["featured","sponsored","verified","hot"],"title":"","nomobile":"0","name":"sespage.page-labels"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.you-may-also-like-pages',
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Pages You May Also Like","viewType":"listView","category":"","information":["title","by","ownerPhoto","price","status","joinButton","like","verifiedLabel","hotLabel"],"title_truncation":"45","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","height":"50","width":"50","limit_data":"3","nomobile":"0","name":"sespage.you-may-also-like-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.recently-viewed-item',
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","category_id":"","criteria":"by_me","show_criteria":["title","category","location","member","view","follow","featuredLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","height":"60","width":"60","width_pinboard":"300","limit_data":"3","title":"Sponsored Pages","nomobile":"0","name":"sespage.recently-viewed-item"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sesbasic.column-layout-width',
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"layoutColumnWidthType":"px","columnWidth":"240","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.breadcrumb',
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.page-view',
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"layout_type":"2","tab_placement":"in","show_criteria":["likeButton","followButton","optionMenu"],"show_full_width":"no","margin_top":"1","description_truncation":"150","cover_height":"300","socialshare_enable_plusicon":"1","socialshare_icon_limit":"1","title":"","nomobile":"0","name":"sespage.page-view"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.profile-tips',
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'core.container-tabs',
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"max":6}',
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');
  if ($activutyType) {
    $db->insert('engine4_core_content', array(
        'page_id' => $pageId,
        'type' => 'widget',
        'name' => 'sesadvancedactivity.feed',
        'parent_content_id' => $tab_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Posts","design":"4","upperdesign":"0","feeddesign":"1","sesact_pinboard_width":"300","scrollfeed":"1","autoloadTimes":"3","statusplacehoder":"Post Something...","userphotoalign":"left","enablefeedbgwidget":"1","feedbgorder":"random","enablewidthsetting":"0","sesact_image1":null,"sesact_image1_width":"500","sesact_image1_height":"450","sesact_image2":null,"sesact_image2_width":"289","sesact_image2_height":"200","sesact_image3":null,"sesact_image3_bigwidth":"328","sesact_image3_bigheight":"300","sesact_image3_smallwidth":"250","sesact_image3_smallheight":"150","sesact_image4":null,"sesact_image4_bigwidth":"578","sesact_image4_bigheight":"300","sesact_image4_smallwidth":"192","sesact_image4_smallheight":"100","sesact_image5":null,"sesact_image5_bigwidth":"289","sesact_image5_bigheight":"260","sesact_image5_smallwidth":"289","sesact_image5_smallheight":"130","sesact_image6":null,"sesact_image6_width":"289","sesact_image6_height":"150","sesact_image7":null,"sesact_image7_bigwidth":"192","sesact_image7_bigheight":"150","sesact_image7_smallwidth":"144","sesact_image7_smallheight":"150","sesact_image8":null,"sesact_image8_width":"144","sesact_image8_height":"150","sesact_image9":null,"sesact_image9_width":"192","sesact_image9_height":"150","nomobile":"0","name":"sesadvancedactivity.feed"}',
    ));
  } else {
    $db->insert('engine4_core_content', array(
        'page_id' => $pageId,
        'type' => 'widget',
        'name' => 'activity.feed',
        'parent_content_id' => $tab_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Posts"}',
    ));
  }
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.page-info',
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["info","date","description","overview","profilefield"],"title":"Details","nomobile":"0","name":"sespage.page-info"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.page-map',
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Map","titleCount":true}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.profile-members',
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Members","name":"sespage.profile-members"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.main-page-details',
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["pagePhoto","title","likeButton","favouriteButton","joinButton"],"title":"","nomobile":"0","name":"sespage.main-page-details"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.profile-announcements',
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"limit_data":"3","title":"Announcements","nomobile":"0","name":"sespage.profile-announcements"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.profile-photos',
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Photo Albums","titleCount":false,"load_content":"pagging","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"hover","show_criteria":["title","socialSharing","likeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"3","height":"120","width":"150","nomobile":"0","name":"sespage.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.recent-people-activity',
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["like","favourite","follow"],"height":"48","width":"52","view_more_like":"10","view_more_favourite":"10","view_more_follow":"10","title":"","nomobile":"0","name":"sespage.recent-people-activity"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sespage.page-liked',
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Pages Liked by This Page","name":"sespage.page-liked"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'sesbasic.column-layout-width',
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"layoutColumnWidthType":"px","columnWidth":"315","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
  ));
}

//SES - Page Category Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_category_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_category_browse',
      'displayname' => 'SES - Page Directories - Page Category Browse Page',
      'title' => 'Page Category Browse',
      'description' => 'This page lists page categories.',
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

  // Insert main-right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $pageId,
      'parent_content_id' => $mainId,
      'order' => 1,
  ));
  $mainRightId = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.category-carousel',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title_truncation":"45","description_truncation":"45","height":"150","width":"300","speed":"300","autoplay":"1","criteria":"alphabetical","show_criteria":["title","description","countPages"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","isfullwidth":"1","limit_data":"10","title":"","nomobile":"0","name":"sespage.category-carousel"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.banner-category',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"description":"Discover pages of all media types based on the categories and your interests.","sespage_categorycover_photo":"public\/admin\/pages-category-banner.jpg","show_popular_pages":"1","title_pop":"Popular Pages","order":"","info":"most_joined","height":"300","height_advgrid":"180","width":"260","isfullwidth":"0","margin_top":"20","title":"Categories","nomobile":"0","name":"sespage.banner-category"}',
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.category-associate-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"carousel","criteria":"most_page","popularty":"all","order":"like_count","show_category_criteria":["seeAll","countPage","categoryDescription"],"show_criteria":["title","by","description","socialSharing","contactButton","likeButton","favouriteButton","followButton","joinButton","like","comment","favourite","view","follow","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"auto_load","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","grid_description_truncation":"45","title_truncation":"45","slideshow_description_truncation":"250","height":"130","width":"302","category_limit":"6","page_limit":"8","allignment_seeall":"right","title":"","nomobile":"0","name":"sespage.category-associate-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":null,"category_id":"","criteria":"5","info":null,"show_criteria":["title","by","joinButton","like","comment"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"70","width":"70","limit_data":"4","title":"Most Participated Pages","nomobile":"0","name":"sespage.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.recently-viewed-item',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","category_id":"","criteria":"on_site","show_criteria":["title","by","category","like","comment"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","height":"70","width":"70","width_pinboard":"300","limit_data":"4","title":"Recently Viewed Pages","nomobile":"0","name":"sespage.recently-viewed-item"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.tag-cloud-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"color":"#00f","type":"tab","text_height":"15","height":"300","itemCountPerPage":"15","title":"Popular Tags","nomobile":"0","name":"sespage.tag-cloud-pages"}',
  ));
}

//SES - Page Category View Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_category_index')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_category_index',
      'displayname' => 'SES - Page Directories - Page Category View Page',
      'title' => 'Page Category View',
      'description' => 'This page displays a page entry.',
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
      'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.category-view',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"show_subcat":"0","subcategory_title":"Sub-Categories of this catgeory","show_subcatcriteria":["title","icon","countPages"],"heightSubcat":"160px","widthSubcat":"250px","show_popular_pages":"1","pop_title":"Popular Pages","info":"creationSPdate","dummy1":null,"page_title":"Explore Pages","show_criteria":["title","by","socialSharing","likeButton","favouriteButton","followButton","like","comment","favourite","view","follow","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"button","page_limit":"9","height":"250","width":"392","title":"","nomobile":"0","name":"sespage.category-view"}',
  ));
}

//SES - Page Browse Tag Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_tags')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$pageId) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_tags',
      'displayname' => 'SES - Page Directories - Pages Tags Browse Page',
      'title' => 'Browse Tag Page',
      'description' => 'This page displays all tags.',
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
      'name' => 'sespage.tag-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => 1,
      'params' => '{"title":"","name":"sespage.tag-pages"}',
  ));
}

//SES - Page Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_pinboard')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_pinboard',
      'displayname' => 'SES - Page Directories - Pages Browse Pinboard Page',
      'title' => 'Page Browse Pnboard',
      'description' => 'This page lists pages.',
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
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"mostSPliked","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchPageTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","venue","closepage"],"hide_option":["alphabet","Categories","location","miles","country","state","city","zip","venue","closepage"],"title":"","nomobile":"0","name":"sespage.browse-search"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["pinboard"],"openViewType":"pinboard","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","price","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"pagging","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"60","height":"200","width":"310","dummy16":null,"limit_data_advlist":"5","advlist_title_truncation":"45","advlist_description_truncation":"70","height_advlist":"250","width_advlist":"310","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"60","height_grid":"250","width_grid":"310","dummy18":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"60","height_simplegrid":"250","width_simplegrid":"260","dummy19":null,"limit_data_advgrid":"10","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"250","width_advgrid":"295","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"10","title":"","nomobile":"0","name":"sespage.browse-pages"}',
  ));
}

//SES - Page Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_verified')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_verified',
      'displayname' => 'SES - Page Directories - Pages Verified Page',
      'title' => 'Page Verified',
      'description' => 'This page lists pages.',
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
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["verified"],"default_search_type":"verified","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchPageTitle","view","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closepage"],"hide_option":["alphabet","Categories","location","miles","country","state","city","zip","venue","closepage"],"title":"","nomobile":"0","name":"sespage.browse-search"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advgrid","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","price","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"auto_load","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"60","height":"105","width":"245","dummy16":null,"limit_data_advlist":"6","advlist_title_truncation":"45","advlist_description_truncation":"70","height_advlist":"230","width_advlist":"370","dummy17":null,"limit_data_grid":"12","grid_title_truncation":"45","grid_description_truncation":"60","height_grid":"250","width_grid":"392","dummy18":null,"limit_data_simplegrid":"12","simplegrid_title_truncation":"45","simplegrid_description_truncation":"60","height_simplegrid":"200","width_simplegrid":"294","dummy19":null,"limit_data_advgrid":"9","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"270","width_advgrid":"392","dummy20":null,"limit_data_pinboard":"12","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"40","title":"","nomobile":"0","name":"sespage.browse-pages"}',
  ));
}

//SES - Page Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_featured')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_featured',
      'displayname' => 'SES - Page Directories - Pages Featured Page',
      'title' => 'Page Featured',
      'description' => 'This page lists pages.',
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
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["featured"],"default_search_type":"featured","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchPageTitle","view","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closepage"],"hide_option":["alphabet","Categories","location","miles","country","state","city","zip","venue","closepage"],"title":"","nomobile":"0","name":"sespage.browse-search"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","price","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"60","height":"105","width":"245","dummy16":null,"limit_data_advlist":"5","advlist_title_truncation":"45","advlist_description_truncation":"70","height_advlist":"230","width_advlist":"370","dummy17":null,"limit_data_grid":"12","grid_title_truncation":"45","grid_description_truncation":"60","height_grid":"250","width_grid":"392","dummy18":null,"limit_data_simplegrid":"12","simplegrid_title_truncation":"45","simplegrid_description_truncation":"60","height_simplegrid":"200","width_simplegrid":"294","dummy19":null,"limit_data_advgrid":"10","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"270","width_advgrid":"392","dummy20":null,"limit_data_pinboard":"12","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"20","title":"","nomobile":"0","name":"sespage.browse-pages"}',
  ));
}

//SES - Page Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_sponsored')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_sponsored',
      'displayname' => 'SES - Page Directories - Pages Sponsored  Page',
      'title' => 'Page Sponsored ',
      'description' => 'This page lists pages.',
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
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["sponsored"],"default_search_type":"sponsored","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchPageTitle","view","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closepage"],"hide_option":["alphabet","Categories","location","miles","country","state","city","zip","venue","closepage"],"title":"","nomobile":"0","name":"sespage.browse-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"grid","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","price","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"pagging","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"60","height":"105","width":"245","dummy16":null,"limit_data_advlist":"6","advlist_title_truncation":"45","advlist_description_truncation":"70","height_advlist":"230","width_advlist":"370","dummy17":null,"limit_data_grid":"12","grid_title_truncation":"45","grid_description_truncation":"60","height_grid":"250","width_grid":"392","dummy18":null,"limit_data_simplegrid":"12","simplegrid_title_truncation":"45","simplegrid_description_truncation":"60","height_simplegrid":"200","width_simplegrid":"294","dummy19":null,"limit_data_advgrid":"9","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"270","width_advgrid":"392","dummy20":null,"limit_data_pinboard":"12","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"20","title":"","nomobile":"0","name":"sespage.browse-pages"}',
  ));
}


//SES - Page Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_hot')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_hot',
      'displayname' => 'SES - Page Directories - Pages Hot Page',
      'title' => 'Page Hot ',
      'description' => 'This page lists pages.',
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
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["hot"],"default_search_type":"hot","criteria":["0"],"default_view_search_type":"0","show_option":["searchPageTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closepage"],"hide_option":["alphabet","Categories","location","miles","country","state","city","zip","venue","closepage"],"title":"","nomobile":"0","name":"sespage.browse-search"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"pinboard","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","price","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"60","height":"105","width":"245","dummy16":null,"limit_data_advlist":"6","advlist_title_truncation":"45","advlist_description_truncation":"70","height_advlist":"230","width_advlist":"370","dummy17":null,"limit_data_grid":"12","grid_title_truncation":"45","grid_description_truncation":"60","height_grid":"250","width_grid":"392","dummy18":null,"limit_data_simplegrid":"12","simplegrid_title_truncation":"45","simplegrid_description_truncation":"60","height_simplegrid":"200","width_simplegrid":"294","dummy19":null,"limit_data_advgrid":"9","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"270","width_advgrid":"392","dummy20":null,"limit_data_pinboard":"12","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"20","title":"","nomobile":"0","name":"sespage.browse-pages"}',
  ));
}


//SES - Page Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_localpick')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_localpick',
      'displayname' => 'SES - Page Directories - Pages Local Picks Page',
      'title' => 'Page Local Picks',
      'description' => 'This page lists pages.',
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
      'order' => $widgetOrder++,
  ));
// Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-category-icons',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"titleC":"","criteria":"most_page","show_criteria":["title"],"alignContent":"center","viewType":"image","shapeType":"circle","show_bg_color":"1","bgColor":"#FFFFFF","height":"130","width":"130","limit_data":"10","title":"","nomobile":"0","name":"sespage.page-category-icons"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"mostSPliked","criteria":["0"],"default_view_search_type":"0","show_option":["searchPageTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","venue","closepage"],"hide_option":"","title":"","nomobile":"0","name":"sespage.browse-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.page-alphabet',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","price","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"pagging","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"60","height":"200","width":"310","dummy16":null,"limit_data_advlist":"5","advlist_title_truncation":"45","advlist_description_truncation":"70","height_advlist":"250","width_advlist":"310","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"60","height_grid":"250","width_grid":"310","dummy18":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"60","height_simplegrid":"250","width_simplegrid":"260","dummy19":null,"limit_data_advgrid":"10","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"250","width_advgrid":"295","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"10","title":"","nomobile":"0","name":"sespage.browse-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.featured-sponsored-verified-hot-slideshow',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"category":"","criteria":"6","info":"creation_date","isfullwidth":"0","autoplay":"1","speed":"2000","navigation":"nextprev","show_criteria":["title","description"],"title_truncation":"45","description_truncation":"55","height":"200","limit_data":"5","title":"Verified Pages","nomobile":"0","name":"sespage.featured-sponsored-verified-hot-slideshow"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.you-may-also-like-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Sponsored Pages","viewType":"listView","category":"","information":["title","by","category","socialSharing","contactButton","followButton","member","sponsoredLabel"],"title_truncation":"45","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","height":"80","width":"79","limit_data":"3","nomobile":"0","name":"sespage.you-may-also-like-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.tag-cloud-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"color":"#fa0a0a","type":"cloud","text_height":"20","height":"200","itemCountPerPage":"10","title":"","nomobile":"0","name":"sespage.tag-cloud-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.you-may-also-like-pages',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Featured pages","viewType":"listView","category_id":"","information":["title","by","ownerPhoto","likeButton","favouriteButton","followButton","joinButton","like","comment","featuredLabel"],"title_truncation":"45","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","height":"80","width":"80","limit_data":"3","nomobile":"0","name":"sespage.you-may-also-like-pages"}',
  ));
}

//Album Home Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_album_home')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_album_home',
      'displayname' => 'SES - Page Directories - Albums Home Page',
      'title' => 'Albums Home Page',
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
      'name' => 'sespage.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"view_count","showdefaultalbum":"0","insideOutside":"inside","fixHover":"hover","show_criteria":["pagename","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"160","width":"180","limit_data":"3","title":"Most Viewed Albums","nomobile":"0","name":"sespage.popular-albums"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"like_count","insideOutside":"outside","fixHover":"hover","show_criteria":["like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"160","width":"180","limit_data":"3","title":"Most Liked Albums","nomobile":"0","name":"sespage.popular-albums"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"comment_count","showdefaultalbum":"0","insideOutside":"inside","fixHover":"hover","show_criteria":["pagename","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"162","width":"180","limit_data":"3","title":"Most Commented Albums","nomobile":"0","name":"sespage.popular-albums"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.album-tabbed-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"tab_option":"filter","showdefaultalbum":"0","insideOutside":"inside","fixHover":"fix","show_criteria":["pagename","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_item_count":"0","limit_data":"6","show_limited_data":null,"pagging":"button","title_truncation":"20","height":"210","width":"325","search_type":["recentlySPcreated","mostSPviewed","mostSPfavourite","mostSPliked"],"dummy1":null,"recentlySPcreated_order":"9","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"8","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy5":null,"mostSPliked_order":"4","mostSPliked_label":"Most Liked","dummy6":null,"mostSPcommented_order":"7","mostSPcommented_label":"Most Commented","title":"Popular Albums","nomobile":"0","name":"sespage.album-tabbed-widget"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.album-home-error',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"itemType":"album","title":"","nomobile":"0","name":"sespage.album-home-error"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"creation_date","showdefaultalbum":"0","insideOutside":"outside","fixHover":"fix","show_criteria":["pagename","featured","sponsored","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"45","height":"220","width":"216","limit_data":"6","title":"","nomobile":"0","name":"sespage.popular-albums"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-album-button',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-album-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite"],"default_search_type":"recentlySPcreated","friend_show":"no","search_title":"yes","browse_by":"no","title":"","nomobile":"0","name":"sespage.browse-album-search"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"favourite_count","showdefaultalbum":"0","insideOutside":"outside","fixHover":"hover","show_criteria":["pagename","comment","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"155","width":"180","limit_data":"3","title":"Most Favourite Album","nomobile":"0","name":"sespage.popular-albums"}'
  ));
// Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"comment_count","insideOutside":"outside","fixHover":"hover","show_criteria":["like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"151","width":"180","limit_data":"3","title":"Most Commented Albums","nomobile":"0","name":"sespage.popular-albums"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.recently-viewed-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"criteria":"on_site","showdefaultalbum":"0","insideOutside":"outside","fixHover":"hover","show_criteria":["pagename","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"20","height":"150","width":"180","limit_data":"2","title":"Recently Viewed Albums","nomobile":"0","name":"sespage.recently-viewed-albums"}',
  ));
}


//Album Browse Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_album_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$page_id) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_album_browse',
      'displayname' => 'SES - Page Directories - Browse Albums Page',
      'title' => 'Browse Albums Page',
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
      'name' => 'sespage.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));
// Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"showdefaultalbum":"0","load_content":"auto_load","sort":"mostSPliked","view_type":"1","insideOutside":"outside","fixHover":"fix","show_criteria":["pagename","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"30","limit_data":"15","height":"150","width":"307","title":"","nomobile":"0","name":"sespage.browse-albums"}'
  ));
// Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-album-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite"],"default_search_type":"mostSPliked","friend_show":"yes","search_title":"yes","browse_by":"yes","title":"","nomobile":"0","name":"sespage.browse-album-search"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"view_count","showdefaultalbum":"0","insideOutside":"inside","fixHover":"hover","show_criteria":["pagename","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"1","title_truncation":"45","height":"250","width":"250","limit_data":"3","title":"Most Viewed Albums","nomobile":"0","name":"sespage.popular-albums"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"favourite_count","insideOutside":"inside","fixHover":"hover","show_criteria":["title","socialSharing","favouriteCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"1","title_truncation":"45","height":"150","width":"180","limit_data":"3","title":"Most Favourite Albums","nomobile":"0","name":"sespage.popular-albums"}'
  ));
}



//Page Album View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_album_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_album_view',
      'displayname' => 'SES - Page Directories - Album View Page',
      'title' => 'Album View Page',
      'description' => 'This page displays an album.',
      'provides' => 'subject=sespage_album',
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
      'name' => 'sespage.photo-album-view-breadcrumb',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 3,
      'params' => ''
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.album-view-page',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 4,
      'params' => '{"view_type":"masonry","insideOutside":"inside","fixHover":"fix","show_criteria":["featured","sponsored","like","comment","view","title","by","socialSharing","likeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","limit_data":"20","pagging":"auto_load","title_truncation":"45","height":"160","width":"140","title":"","nomobile":"0","name":"sespage.album-view-page"}'
  ));
}

//Photo View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_photo_view')
        ->limit(1)
        ->query()
        ->fetchColumn();

if (!$page_id) {
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_photo_view',
      'displayname' => 'SES - Page Directories - Photo View Page',
      'title' => 'Album Photo View',
      'description' => 'This page displays an album\'s photo.',
      'provides' => 'subject=sespage_photo',
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
      'name' => 'sespage.photo-view-breadcrumb',
      'page_id' => $page_id,
      'parent_content_id' => $middle_id,
      'order' => 3,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.photo-view-page',
      'page_id' => $page_id,
      'parent_content_id' => $middle_id,
      'order' => 4,
      'params' => '{"title":"","nomobile":"0","name":"sespage.photo-view-page"}'
  ));
}

$catgoryData = array(0 => array('Cause or Community', 'CauseorCommunity.png', 'CauseorCommunity', 'CauseorCommunity.png', '990066'), 1 => array('Entertainment', 'Entertainment.png', 'Entertainment.png', 'Entertainment.png', '990066'), 2 => array('Artist, Band or Public Figure', 'ArtistBandorPublicFigure.png', 'ArtistBandorPublicFigure.png', 'ArtistBandorPublicFigure.png', '990066'), 3 => array('Company, Organisation or Institution', 'CompanyOrganisationorInstitution.png', 'CompanyOrganisationorInstitution.png', 'CompanyOrganisationorInstitution.png', '990066'), 4 => array('Brand or product', 'Brandorproduct.png', 'Brandorproduct.png', 'Brandorproduct.png', '990066'), 5 => array('Local Business or Place', 'LocalBusinessorPlace.png', 'LocalBusinessorPlace.png', 'LocalBusinessorPlace.png', '179C36'));

$Entertainment = array(0 => array('Art', '', '', ''), 1 => array('Film', '', '', ''), 2 => array('Book', '', '', ''), 3 => array('Festival', '', '', ''), 4 => array('Performance and Event Venue', '', '', ''));
$Art = array(0 => array('Performance Art', '', '', ''), 1 => array('Performing Art', '', '', ''));
$PerformanceandEventVenue = array(0 => array('Music Award', '', '', ''));
$Film = array(0 => array('Film Character', '', '', ''), 1 => array('TV/Film Award', '', '', ''), 2 => array('TV Show', '', '', ''));
$Book = array(0 => array('Magazine', '', '', ''), 1 => array('Book Shop', '', '', ''), 2 => array('Book Series', '', '', ''));

$ArtistBandorPublicFigure = array(0 => array('Sportsperson', '', '', ''), 1 => array('Photographer', '', '', ''), 2 => array('Chef', '', '', ''), 3 => array('Band', '', '', ''), 4 => array('Writer', '', '', ''), 5 => array('Actor', '', '', ''));

$Band = array(0 => array('Musician', '', '', ''));
$Writer = array(0 => array('Story Writer', '', '', ''), 1 => array('Content Writer', '', '', ''), 2 => array('Blogger', '', '', ''));
$Actor = array(0 => array('Artist', '', '', ''), 1 => array('Fashion Model', '', '', ''), 2 => array('Dancer', '', '', ''));

$CompanyOrganisationorInstitution = array(0 => array('Travel Agent', '', '', ''), 1 => array('Internet Company', '', '', ''), 2 => array('Health/Beauty', '', '', ''), 3 => array('Education', '', '', ''), 4 => array('Aerospace Company', '', '', ''));

$Brandorproduct = array(0 => array('Phone/Tablet', '', '', ''), 1 => array('Website', '', '', ''), 2 => array('Furniture', '', '', ''), 3 => array('Electronics', '', '', ''), 4 => array('Cars', '', '', ''), 5 => array('Baby Goods/Kids Goods', '', '', ''), 6 => array('Appliances', '', '', ''), 7 => array('Kitchen/Cooking', '', '', ''), 8 => array('Accessories', '', '', ''));

$Accessories = array(0 => array('Watches', '', '', ''), 1 => array('Clothing', '', '', ''), 2 => array('Jewellery', '', '', ''));

foreach ($catgoryData as $key => $value) {
//Upload categories icon
  $db->query("INSERT IGNORE INTO `engine4_sespage_categories` (`category_name`,`subcat_id`,`subsubcat_id`,`slug`,`description`) VALUES ( '" . $value[0] . "',0,0,'','')");
  $catId = $db->lastInsertId();
  $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sespage' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "category" . DIRECTORY_SEPARATOR;

//colored icon upload
  if (is_file($PathFile . "color-icons" . DIRECTORY_SEPARATOR . $value[3]))
    $color_icon = $this->setCategoryPhoto($PathFile . "color-icons" . DIRECTORY_SEPARATOR . $value[3], $catId, false);
  else
    $color_icon = 0;

//simple icon
  if (is_file($PathFile . "icons" . DIRECTORY_SEPARATOR . $value[2]))
    $cat_icon = $this->setCategoryPhoto($PathFile . "icons" . DIRECTORY_SEPARATOR . $value[2], $catId, false);
  else
    $cat_icon = 0;

//banner image
  if (is_file($PathFile . "banners" . DIRECTORY_SEPARATOR . $value[1]))
    $thumbnail_icon = $this->setCategoryPhoto($PathFile . "banners" . DIRECTORY_SEPARATOR . $value[1], $catId, true);
  else
    $thumbnail_icon = 0;

  $db->query("UPDATE `engine4_sespage_categories` SET `cat_icon` = '" . $cat_icon . "',`thumbnail` = '" . $thumbnail_icon . "' ,`colored_icon` = '" . $color_icon . "' , `color` = '" . $value[4] . "' WHERE category_id = " . $catId);
  $valueName = str_replace(array(' ', '&', '/', ','), array('', '', '', ''), $value[0]);
  if (isset(${$valueName})) {
    foreach (${$valueName} as $value) {
      $db->query("INSERT IGNORE INTO `engine4_sespage_categories` (`category_name`,`subcat_id`,`subsubcat_id`,`slug`,`description`) VALUES ( '" . $value[0] . "','" . $catId . "',0,'','')");
      $subId = $db->lastInsertId();
      $cat_icon = 0;
      $thumbnail_icon = 0;
      $db->query("UPDATE `engine4_sespage_categories` SET `cat_icon` = '" . $cat_icon . "',`thumbnail` = '" . $thumbnail_icon . "' WHERE category_id = " . $subId);
      $valueSubName = str_replace(array(' ', '&', '/'), array('', '', ''), $value[0]);
      if (isset(${$valueSubName})) {
        foreach (${$valueSubName} as $value) {
          $db->query("INSERT IGNORE INTO `engine4_sespage_categories` (`category_name`,`subcat_id`,`subsubcat_id`,`slug`,`description`) VALUES ( '" . $value[0] . "','0','" . $subId . "','','')");
          $subsubId = $db->lastInsertId();
          $thumbnail_icon = 0;
          $db->query("UPDATE `engine4_sespage_categories` SET `cat_icon` = '" . $cat_icon . "',`thumbnail` = '" . $thumbnail_icon . "' WHERE category_id = " . $subsubId);
        }
      }
    }
  }
  $runInstallCategory = true;
}
$db->query('UPDATE `engine4_sespage_categories` set `slug` = LOWER(REPLACE(REPLACE(REPLACE(category_name,"&",""),"  "," ")," ","-")) where slug = "";');
$db->query('UPDATE `engine4_sespage_categories` SET `order` = `category_id` WHERE `order` = 0;');
$db->query('UPDATE `engine4_sespage_categories` set `title` = `category_name` where title = "" OR title IS NULL;');




// $table_exist_action = $db->query('SHOW TABLES LIKE \'engine4_activity_actions\'')->fetch();
// if (!empty($table_exist_action)) {
//   $sesresId = $db->query('SHOW COLUMNS FROM engine4_activity_actions LIKE \'sesresource_id\'')->fetch();
//   if (empty($sesresId)) {
//     $db->query('ALTER TABLE  `engine4_activity_actions` ADD  `sesresource_id` INT( 11 ) NOT NULL DEFAULT "0";');
//   }
// }
// if (!empty($table_exist_action)) {
//   $sesresType = $db->query('SHOW COLUMNS FROM engine4_activity_actions LIKE \'sesresource_type\'')->fetch();
//   if (empty($sesresType)) {
//     $db->query('ALTER TABLE  `engine4_activity_actions` ADD  `sesresource_type` VARCHAR( 45 ) NULL;');
//   }
// }

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sespage_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => (in_array($level->type, array('admin', 'moderator'))),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('sespage_page', $level->level_id, array_keys($form->getValues()));

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
    $permissionsTable->setAllowed('sespage_page', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}

$db->query('DROP TABLE IF EXISTS `engine4_sespage_claims` ;');
$db->query('CREATE TABLE `engine4_sespage_claims` (
  `claim_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `contact_number` varchar(128) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `creation_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL default "0",
  PRIMARY KEY (`claim_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sespage_main_claim", "sespage", "Claim For Page", "Sespage_Plugin_Menus::canClaimSespages", \'{"route":"sespage_general","action":"claim"}\', "sespage_main", "", 5),
("sespage_admin_main_claim", "sespage", "Claim Requests", "", \'{"route":"admin_default","module":"sespage","controller":"manage", "action":"claim"}\', "sespage_admin_main", "", 6);');

$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
("sesuser_claim_page", "sespage", \'{item:$subject} has claimed your page {item:$object}.\', 0, ""),
("sesuser_claimadmin_page", "sespage", \'{item:$subject} has claimed a page {item:$object}.\', 0, ""),
("sespage_claim_approve", "sespage", \'Site admin has approved your claim request for the page: {item:$object}.\', 0, ""),
("sespage_claim_declined", "sespage", \'Site admin has rejected your claim request for the page: {item:$object}.\', 0, ""),
("sespage_owner_informed", "sespage", \'Site admin has been approved claim for your page: {item:$object}.\', 0, "");');

$db->query('INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
("sespage_page_owner_approve", "sespage", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]");');

//New Claims Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sespage_index_claim')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sespage_index_claim',
    'displayname' => 'SES - Page Directories - New Claims Page',
    'title' => 'Page Claim',
    'description' => 'This page lists page entries.',
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
    'name' => 'sespage.claim-page',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}


//Browse Claim Requests Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sespage_index_claim-requests')
              ->limit(1)
              ->query()
              ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sespage_index_claim-requests',
    'displayname' => 'SES - Page Directories - Browse Claim Requests Page',
    'title' => 'Page Claim Requests',
    'description' => 'This page lists page claims request entries.',
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
    'name' => 'sespage.claim-requests',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES ("sespage_follow_category", "sespage", \'A new page {item:$object} has been created in {var:$category_title} category that you are Following.\', 0, "");');

$db->query('INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
("notify_sespage_follow_category", "sespage", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]");');


$bannedTable = $db->query('SHOW TABLES LIKE \'engine4_sesbasic_bannedwords\'')->fetch();
if(empty($bannedTable)) {
  $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesbasic_bannedwords` (
    `bannedword_id` int(10) unsigned NOT NULL auto_increment,
    `resource_type` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
    `resource_id` int(11) unsigned DEFAULT NULL,
    `word` text NOT NULL,
    PRIMARY KEY  (`bannedword_id`),
    KEY `resource_type` (`resource_type`, `resource_id`),
    UNIQUE KEY (`resource_type`, `resource_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
  $db->query("INSERT IGNORE INTO `engine4_sesbasic_bannedwords` (`word`,`resource_type`) VALUES
  ('help',''), ('activity',''), ('updates',''), ('messages',''), ('admin',''), ('user',''), ('members',''), ('wall',''), ('chat',''),  ('about-us',''),  ('stats',''),  ('files',''),  ('ads',''),  ('invite',''), ('events',''),  ('album',''),  ('albums',''),  ('classifieds',''),  ('classified',''),  ('content',''), ('forums',''),  ('group',''),  ('groups',''),  ('blog',''),  ('blogs',''),  ('poll',''),  ('polls',''), ('music',''),  ('musics',''), ('video',''),  ('videos',''),  ('subscribes',''),  ('tag',''),  ('tags',''), ('tasks',''),  ('profile',''),  ('vote',''),  ('core',''),  ('fields',''),  ('network',''),  ('payment',''), ('sesactivitypoints',''),  ('sesadvancedactivity',''),  ('sesadvancedbanner',''),  ('sesadvancedcomment',''), ('sesadvancedheader',''),  ('sesadvminimenu',''),  ('sesadvsitenotification',''),  ('sesalbum',''), ('sesandroidapp',''),  ('sesannouncement',''),  ('sesapi',''),  ('sesariana',''),  ('sesarticle',''), ('sesblog',''),  ('sesblogpackage',''),  ('sesbody',''),  ('sesbrowserpush',''),  ('seschristmas',''), ('sescleanwide',''),  ('sescommunityads',''),  ('sescompany',''),  ('sescontactus',''), ('sescontentcoverphoto',''), ('sescontest',''),  ('sescontestjoinfees',''),  ('sescontestjurymember',''), ('sescontestpackage',''),  ('seselegant',''),  ('sesemoji',''),  ('seserror',''), ('sesevent',''), ('seseventcontact',''),  ('seseventmusic',''),  ('seseventpdfticket',''),  ('seseventreview',''), ('seseventspeaker',''), ('seseventsponsorship',''),  ('seseventticket',''),  ('seseventvideo',''), ('sesexpose',''),  ('sesfaq',''),  ('sesfbstyle',''),  ('sesfeedbg',''),  ('sesfeedgif',''), ('sesfeelingactivity',''),  ('sesfooter',''),  ('sesgdpr',''),  ('seshtmlbackground',''), ('seshtmlblock',''),  ('seslangtranslator',''),  ('sesletteravatar',''),  ('seslink',''), ('sesmaterial',''), ('sesmember',''),  ('sesmembershorturl',''),  ('sesmetatag',''),  ('sesminify',''), ('sesmultiplecurrency',''),  ('sesmultipleform',''),  ('sesmusic',''),  ('sespage',''), ('sespagebuilder',''),  ('sespageurl',''),  ('sespoke',''),  ('sesprayer',''),  ('sesprofilelock',''), ('sesrecipe',''),  ('sessiteiframe',''),  ('sessociallogin',''),  ('sessocialshare',''), ('sessocialtube',''),  ('sesspectromedia',''),  ('sestour',''), ('sestweet',''),  ('sesusercoverphoto',''), ('sesusercovervideo',''),  ('sesvideo',''),  ('chanels',''),  ('quotes',''),  ('quote',''),  ('prayers',''), ('prayer',''),  ('page-directories',''),  ('page-directory',''),  ('browse-review',''),  ('privacycenter',''),  ('faqs',''),  ('faq',''),  ('events',''),  ('eventmusics',''),  ('eventmusic',''), ('comingsoon',''),  ('contestpackage',''),  ('contestpayment',''),  ('contests',''),  ('contest',''), ('wishes',''),  ('friend-wishes',''),  ('welcome',''),  ('Sesblogs',''),  ('blog-album',''), ('Sesarticles',''),  ('article-album',''),  ('articles',''),  ('comment-like',''),  ('comment',''), ('comments',''),  ('app-default-data',''),  ('stickers',''),  ('feelings',''),  ('onthisday',''), ('storage',''),  ('page',''),  ('stores',''),  ('job-posting',''),  ('level',''),  ('likes',''), ('list',''), ('listing',''),  ('listingitem',''),  ('listingitems',''),  ('listings',''),  ('product',''),  ('productvideos',''),  ('products',''),  ('market',''),  ('media-importer',''),  ('member',''), ('memberlevel',''),  ('members-details',''),  ('hashtag',''),  ('hecore',''),  ('hecore-friend',''), ('hecore-module',''),  ('newsfeed',''),  ('pdf',''),  ('photo',''),  ('points',''),  ('pokes',''), ('profiletype',''),  ('project',''),  ('projects',''),  ('qp',''),  ('question',''),  ('questions',''),  ('radcodes',''),  ('whcore',''),  ('rss',''),  ('sesbasic',''),  ('settings',''),  ('recipe',''), ('recipeitems',''),  ('review-videos',''),  ('reviews',''),  ('xml',''),  ('slideshow',''), ('writings','');");
}

$db->query('ALTER TABLE `engine4_sespage_categories` ADD `member_levels` VARCHAR(255) NULL DEFAULT NULL;');
$db->query("UPDATE `engine4_sespage_categories` SET `member_levels` = '1,2,3,4' WHERE `engine4_sespage_categories`.`subcat_id` = 0 and  `engine4_sespage_categories`.`subsubcat_id` = 0;");

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sespage_admin_main_extension", "sespage", "Extensions", "", \'{"route":"admin_default","module":"sespage","controller":"settings", "action": "extensions"}\', "sespage_admin_main", "", 999);');

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sespage_admin_main_manageimport", "sespage", "Import CSV File", "", \'{"route":"admin_default","module":"sespage","controller":"manage-imports", "action":"index"}\', "sespage_admin_main", "", 999);');
