<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

// profile page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespagereview_review_home')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespagereview_review_home',
      'displayname' => 'SES - Page Review Extension - Review Home Page',
      'title' => 'Review Home',
      'description' => 'This page lists reviews.',
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
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'left',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $main_left_id = $db->lastInsertId();
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
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => 1,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => ' 	sespagereview.review-of-the-day',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["title","like","view","rating","featuredLabel","verifiedLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","width":"180","title":"Review Of The Day","nomobile":"0","name":"sespagereview.review-of-the-day"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.popular-featured-verified-reviews',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"most_rated","imageType":"square","showLimitData":"0","show_criteria":["title","like","rating","by"],"title_truncation":"35","review_description_truncation":"20","limit_data":"3","title":"Most Rated Reviews","nomobile":"0","name":"sespagereview.popular-featured-verified-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.popular-featured-verified-reviews',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"most_liked","imageType":"square","showLimitData":"0","show_criteria":["title","like","view","comment","by"],"title_truncation":"35","review_description_truncation":"35","limit_data":"3","title":"Most Liked Reviews","nomobile":"0","name":"sespagereview.popular-featured-verified-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.popular-featured-verified-reviews',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"featured","imageType":"square","showLimitData":"0","show_criteria":["title","like","view","comment","featuredLabel"],"title_truncation":"20","review_description_truncation":"45","limit_data":"3","title":"Featured Reviews","nomobile":"0","name":"sespagereview.popular-featured-verified-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.tabbed-widget-review',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"tabOption":"0","stats":["likeCount","commentCount","viewCount","title","share","report","description","creationDate"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"button","show_limited_data":"no","title_truncation":"45","height":"100","width":"100","limit_data":"6","description_truncation":"45","search_type":["recentlySPcreated","mostSPliked","mostSPcommented","mostrated","verified","featured"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPliked_order":"2","mostSPliked_label":"Most Liked","dummy3":null,"mostSPcommented_order":"3","mostSPcommented_label":"Most Commented","dummy4":null,"mostSPviewed_order":"4","mostSPviewed_label":"Most Viewed","dummy5":null,"mostrated_order":"5","mostrated_label":"Most Rated","dummy6":null,"featured_order":"6","featured_label":"Featured","dummy7":null,"verified_order":"7","verified_label":"Verified","title":"","nomobile":"0","name":"sespagereview.tabbed-widget-review"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.browse-review-button',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.browse-review-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.popular-featured-verified-reviews',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"most_commented","imageType":"rounded","showLimitData":"0","show_criteria":["title","like","view","comment","by"],"title_truncation":"10","review_description_truncation":"20","limit_data":"3","title":"Most Commented Reviews","nomobile":"0","name":"sespagereview.popular-featured-verified-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.popular-featured-verified-reviews',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"most_viewed","imageType":"square","showLimitData":"0","show_criteria":["title","like","view","comment","by"],"title_truncation":"10","review_description_truncation":"20","limit_data":"4","title":"Most Viewed Reviews","nomobile":"0","name":"sespagereview.popular-featured-verified-reviews"}',
  ));
}
//Browse Members Review Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespagereview_review_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespagereview_review_browse',
      'displayname' => 'SES - Page Review Extension - Browse Review Page',
      'title' => 'Page Browse Reviews',
      'description' => 'This page show page reviews.',
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
  // Insert main-left
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'left',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $main_left_id = $db->lastInsertId();
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
      'name' => 'sespagereview.review-of-the-day',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["title","like","view","rating","featuredLabel","verifiedLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"15","width":"180","title":"Review of the Day","nomobile":"0","name":"sespagereview.review-of-the-day"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.browse-review-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"vertical","review_title":"1","view":["likeSPcount","viewSPcount","commentSPcount","mostSPrated","leastSPrated","usefulSPcount","funnySPcount","coolSPcount","verified","featured"],"review_stars":"1","network":"1","title":"Review Browse Search","nomobile":"0","name":"sespagereview.browse-review-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.popular-featured-verified-reviews',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"featured","imageType":"rounded","showLimitData":"0","show_criteria":["title","like","view","comment","featuredLabel","by"],"title_truncation":"45","review_description_truncation":"45","limit_data":"3","title":"Featured Reviews","nomobile":"0","name":"sespagereview.popular-featured-verified-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.popular-featured-verified-reviews',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"verified","imageType":"rounded","showLimitData":"0","show_criteria":["title","like","view","comment","verifiedLabel","by"],"title_truncation":"35","review_description_truncation":"40","limit_data":"3","title":"Verfied Reviews","nomobile":"0","name":"sespagereview.popular-featured-verified-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.browse-reviews',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating"],"show_criteria":["featuredLabel","verifiedLabel"],"title_truncation":"45","description_truncation":"45","pagging":"button","limit_data":"5","title":"","nomobile":"0","name":"sespagereview.browse-reviews"}',
  ));
}
//Review View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespagereview_review_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sespagereview_review_view',
      'displayname' => 'SES - Page Review Extension - Review View Page',
      'title' => 'Page Review View',
      'description' => 'This page displays a review entry.',
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
  // Insert main-left
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'left',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $main_left_id = $db->lastInsertId();
  // Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.breadcrumb-review',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagereview.review-owner-photo',
      'parent_content_id' => $main_left_id,
      'params' => '{"title":"Review Owner","showTitle":"1","nomobile":"0","name":"sespagereview.review-owner-photo"}',
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagereview.review-taker-photo',
      'parent_content_id' => $main_left_id,
      'params' => '{"title":"Review Taker","showTitle":"1","nomobile":"0","name":"sespagereview.review-taker-photo"}',
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sespagereview.profile-review',
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"stats":["likeCount","commentCount","viewCount","title","pros","cons","description","recommended","postedin","creationDate","parameter","rating"],"title":"","nomobile":"0","name":"sespagereview.profile-review"}',
  ));
  if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment')) {
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvancedcomment.comments',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Comments"}',
    ));
  } else {
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.comments',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Comments"}',
    ));
  }
}
//Top Pages Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespage_index_top-pages')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sespage_index_top-pages',
      'displayname' => 'SES - Page Directories - Top Pages Page',
      'title' => 'Top Pages',
      'description' => 'This page show top pages based on ratings and reviews.',
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
  $right_id = $db->lastInsertId();
  //Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","lowestSPrated","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"mostSPrated","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchPageTitle","browseBy","Categories"],"hide_option":["view","alphabet","location","miles","country","state","city","zip","venue","closepage"],"title":"","nomobile":"0","name":"sespage.browse-search"}',
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespage.browse-pages',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","price","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","rating","review","member","view","follow","statusLabel","verifiedLabel"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"250","height":"150","width":"215","dummy16":null,"limit_data_advlist":"7","advlist_title_truncation":"45","advlist_description_truncation":"150","height_advlist":"250","width_advlist":"310","dummy17":null,"limit_data_grid":"6","grid_title_truncation":"45","grid_description_truncation":"100","height_grid":"172","width_grid":"333","dummy18":null,"limit_data_simplegrid":"6","simplegrid_title_truncation":"45","simplegrid_description_truncation":"50","height_simplegrid":"200","width_simplegrid":"333","dummy19":null,"limit_data_advgrid":"9","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"232","width_advgrid":"333","dummy20":null,"limit_data_pinboard":"6","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"25","title":"","nomobile":"0","name":"sespage.browse-pages"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.review-of-the-day',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["title","like","view","rating","featuredLabel","verifiedLabel","description","reviewOwnerName","pageName"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"15","width":"180","title":"Review Of The Day","nomobile":"0","name":"sespagereview.review-of-the-day"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.popular-featured-verified-reviews',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"most_rated","imageType":"square","showLimitData":"0","show_criteria":["title","like","view","comment","rating"],"title_truncation":"15","review_description_truncation":"45","limit_data":"4","title":"Most Rated Reviews","nomobile":"0","name":"sespagereview.popular-featured-verified-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.popular-featured-verified-reviews',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"most_commented","imageType":"square","showLimitData":"1","show_criteria":["title","like","view","comment"],"title_truncation":"20","review_description_truncation":"45","limit_data":"3","title":"Most Commented Reviews","nomobile":"0","name":"sespagereview.popular-featured-verified-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.popular-featured-verified-reviews',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"most_liked","imageType":"square","showLimitData":"0","show_criteria":["title","like","view","comment"],"title_truncation":"45","review_description_truncation":"45","limit_data":"3","title":"Most Liked Reviews","nomobile":"0","name":"sespagereview.popular-featured-verified-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespagereview.popular-featured-verified-reviews',
      'page_id' => $page_id,
      'parent_content_id' => $right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"most_viewed","imageType":"square","showLimitData":"1","show_criteria":["title","like","view","comment"],"title_truncation":"10","review_description_truncation":"20","limit_data":"4","title":"Most Viewed Reviews","nomobile":"0","name":"sespagereview.popular-featured-verified-reviews"}',
  ));
}
Engine_Api::_()->sespagereview()->updateTabOnViewPage('sespage_profile_index_1');
Engine_Api::_()->sespagereview()->updateTabOnViewPage('sespage_profile_index_2');
Engine_Api::_()->sespagereview()->updateTabOnViewPage('sespage_profile_index_3');
Engine_Api::_()->sespagereview()->updateTabOnViewPage('sespage_profile_index_4');

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sespage_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('pagereview', $level->level_id, array_keys($form->getValues()));

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
    $permissionsTable->setAllowed('pagereview', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}