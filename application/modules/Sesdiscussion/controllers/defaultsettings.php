<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$db->query('INSERT IGNORE INTO `engine4_sesdiscussion_categories` (`category_id`, `slug`, `category_name`, `subcat_id`, `subsubcat_id`, `title`, `description`, `color`, `thumbnail`, `cat_icon`, `colored_icon`, `order`, `profile_type_review`, `profile_type`) VALUES
(1, "", "Festive", 0, 0, "", NULL, NULL, 0, 36580, 0, 1, NULL, NULL),
(2, "new-year", "New Year", 1, 0, "", NULL, NULL, 0, 0, 0, 1, NULL, NULL),
(3, "christmas", "Christmas", 1, 0, "", NULL, NULL, 0, 0, 0, 2, NULL, NULL),
(4, "diwali", "Diwali", 1, 0, "", NULL, NULL, 0, 0, 0, 3, NULL, NULL),
(5, "thanksgiving", "Thanksgiving", 1, 0, "", NULL, NULL, 0, 0, 0, 4, NULL, NULL),
(6, "", "Wishes", 0, 0, "", NULL, NULL, 0, 36578, 0, 2, NULL, NULL),
(7, "new-job", "New Job", 6, 0, "", NULL, NULL, 0, 0, 0, 1, NULL, NULL),
(8, "father-s-day", "Father\"s Day", 6, 0, "", NULL, NULL, 0, 0, 0, 2, NULL, NULL),
(9, "mother-s-day", "Mother\"s Day", 6, 0, "", NULL, NULL, 0, 0, 0, 3, NULL, NULL),
(10, "having-a-child", "Having a Child", 6, 0, "", NULL, NULL, 0, 0, 0, 4, NULL, NULL),
(11, "engagement", "Engagement", 6, 0, "", NULL, NULL, 0, 0, 0, 5, NULL, NULL),
(12, "marriage", "Marriage", 6, 0, "", NULL, NULL, 0, 0, 0, 6, NULL, NULL),
(13, "anniversary", "Anniversary", 6, 0, "", NULL, NULL, 0, 0, 0, 7, NULL, NULL),
(14, "birthday", "Birthday", 6, 0, "", NULL, NULL, 0, 0, 0, 8, NULL, NULL),
(15, "", "Feeling", 0, 0, "", NULL, NULL, 0, 36576, 0, 3, NULL, NULL),
(16, "romantic", "Romantic", 15, 0, "", NULL, NULL, 0, 0, 0, 1, NULL, NULL),
(17, "jealous", "Jealous", 15, 0, "", NULL, NULL, 0, 0, 0, 2, NULL, NULL),
(18, "kind", "Kind", 15, 0, "", NULL, NULL, 0, 0, 0, 3, NULL, NULL),
(19, "grateful", "Grateful", 15, 0, "", NULL, NULL, 0, 0, 0, 4, NULL, NULL),
(20, "angry", "Angry", 15, 0, "", NULL, NULL, 0, 0, 0, 5, NULL, NULL),
(21, "sad", "Sad", 15, 0, "", NULL, NULL, 0, 0, 0, 6, NULL, NULL),
(22, "lonely", "Lonely", 15, 0, "", NULL, NULL, 0, 0, 0, 7, NULL, NULL),
(23, "happy", "Happy", 15, 0, "", NULL, NULL, 0, 0, 0, 8, NULL, NULL),
(24, "", "Sports", 0, 0, "", NULL, NULL, 0, 36574, 0, 4, NULL, NULL),
(25, "", "Teamwork", 0, 0, "", NULL, NULL, 0, 36572, 0, 5, NULL, NULL),
(26, "", "Poetry", 0, 0, "", NULL, NULL, 0, 36570, 0, 6, NULL, NULL),
(27, "", "Money", 0, 0, "", NULL, NULL, 0, 36568, 0, 7, NULL, NULL),
(28, "", "Success", 0, 0, "", NULL, NULL, 0, 36566, 0, 8, NULL, NULL),
(29, "", "Education", 0, 0, "", NULL, NULL, 0, 36564, 0, 9, NULL, NULL),
(30, "", "Equailty", 0, 0, "", NULL, NULL, 0, 36562, 0, 10, NULL, NULL),
(31, "", "Death", 0, 0, "", NULL, NULL, 0, 36560, 0, 11, NULL, NULL),
(32, "", "Life", 0, 0, "", NULL, NULL, 0, 36558, 0, 12, NULL, NULL),
(33, "", "Relations", 0, 0, "", NULL, NULL, 0, 36556, 0, 13, NULL, NULL),
(34, "children", "Children", 33, 0, "", NULL, NULL, 0, 0, 0, 1, NULL, NULL),
(35, "son", "Son", 33, 0, "", NULL, NULL, 0, 0, 0, 2, NULL, NULL),
(36, "daughter", "Daughter", 33, 0, "", NULL, NULL, 0, 0, 0, 3, NULL, NULL),
(37, "sister", "Sister", 33, 0, "", NULL, NULL, 0, 0, 0, 4, NULL, NULL),
(38, "brother", "Brother", 33, 0, "", NULL, NULL, 0, 0, 0, 5, NULL, NULL),
(39, "father", "Father", 33, 0, "", NULL, NULL, 0, 0, 0, 6, NULL, NULL),
(41, "friendship", "Friendship", 33, 0, "", NULL, NULL, 0, 0, 0, 7, NULL, NULL),
(42, "love", "Love", 33, 0, "", NULL, NULL, 0, 0, 0, 8, NULL, NULL),
(43, "mother", "Mother", 33, 0, "", NULL, NULL, 0, 0, 0, 9, NULL, NULL),
(44, "", "Parenting", 0, 0, "", NULL, NULL, 0, 36554, 0, 14, NULL, NULL),
(45, "", "Health", 0, 0, "", NULL, NULL, 0, 36552, 0, 15, NULL, NULL),
(46, "", "Religion", 0, 0, "", NULL, NULL, 0, 36550, 0, 16, NULL, NULL),
(47, "", "Funny", 0, 0, "", NULL, NULL, 0, 36548, 0, 17, NULL, NULL),
(48, "", "God", 0, 0, "", NULL, NULL, 0, 36546, 0, 18, NULL, NULL),
(49, "", "Inspirational", 0, 0, "", NULL, NULL, 0, 36544, 0, 19, NULL, NULL),
(50, "", "Motivational", 0, 0, "", NULL, NULL, 0, 36542, 0, 20, NULL, NULL);');

$categories = Engine_Api::_()->getDbtable('categories', 'sesdiscussion' )->getCategoriesAssoc();
$PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesdiscussion' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "category-icons" . DIRECTORY_SEPARATOR;
foreach($categories as $key => $category) {
  $category = Engine_Api::_()->getItem('sesdiscussion_category', $key);
  $file = $PathFile.$category.'.png';
  if(!empty($file)) {
    $file_ext = pathinfo($file);
    $file_ext = $file_ext['extension'];

    $storage = Engine_Api::_()->getItemTable('storage_file');
    $storageObject = $storage->createFile(@$file, array(
      'parent_id' => $category->getIdentity(),
      'parent_type' => $category->getType(),
      'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
    ));
    // Remove temporary file
    @unlink($file['tmp_name']);
    $category->cat_icon = $storageObject->file_id;
    $category->save();
  }
}

// Discussions Browse Page
$pageId = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesdiscussion_index_index')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {

    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sesdiscussion_index_index',
        'displayname' => 'SES - Discussions - Discussions Browse Page',
        'title' => 'Discussion Browse',
        'description' => 'This page lists discussion entries.',
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
    $rightId = $db->lastInsertId();

    // Insert menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesdiscussion.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesdiscussion.browse-search',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"viewType":"horizontal","title":"","nomobile":"0","name":"sesdiscussion.browse-search"}',
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesdiscussion.browse-discussions',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"viewtype":"list","category_id":"0","stats":["title","likecount","favouritecount","commentcount","viewcount","postedby","posteddate","source","voting","category","socialSharing","newlabel","tags","description","likebutton","favouritebutton","followcount","followbutton","permalink","pinboardcomment"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","width":"250","pagging":"button","title_truncation":"60","description_truncation":"500","limit":"6","title":"","nomobile":"0","name":"sesdiscussion.browse-discussions"}',
    ));

    // Rigtht Side
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesdiscussion.discussions-of-the-day',
        'page_id' => $pageId,
        'parent_content_id' => $rightId,
        'order' => $widgetOrder++,
        'params' => '{"information":["title","likeCount","favouritecount","commentCount","viewCount","socialSharing","likebutton","favouritebutton","followcount","followbutton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","width":"300","title_truncation":"16","description_truncation":"60","title":"Discussion Of The Day","nomobile":"0","name":"sesdiscussion.discussions-of-the-day"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesdiscussion.popularity-discussions',
        'page_id' => $pageId,
        'parent_content_id' => $rightId,
        'order' => $widgetOrder++,
        'params' => '{"title":"Popular Discussions","viewType":"list","popularity":"like_count","information":["title","likeCount","favouritecount","commentCount","viewCount","postedby","posteddate","socialSharing","likebutton","favouritebutton","followcount","followbutton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"1","width":"250","title_truncation":"30","description_truncation":"10","limit":"3","nomobile":"0","name":"sesdiscussion.popularity-discussions"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesbasic.column-layout-width',
        'page_id' => $pageId,
        'parent_content_id' => $rightId,
        'order' => $widgetOrder++,
        'params' => '{"layoutColumnWidthType":"px","columnWidth":"300","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesdiscussion.top-discussion-poster',
        'page_id' => $pageId,
        'parent_content_id' => $rightId,
        'order' => $widgetOrder++,
        'params' => '{"limit_data":"5","title":"Top Discussion Posters","nomobile":"0","name":"sesdiscussion.top-discussion-poster"}',
    ));

}


// profile page
$pageId = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesdiscussion_index_manage')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesdiscussion_index_manage',
    'displayname' => 'SES - Discussions - Discussions Manage Page',
    'title' => 'My Discussion',
    'description' => 'This page lists a user\'s discussion entries.',
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
    'type' => 'container',
    'name' => 'right',
    'page_id' => $pageId,
    'parent_content_id' => $mainId,
    'order' => 3,
  ));
  $rightId = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesdiscussion.browse-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesdiscussion.manage-discussions',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => $widgetOrder++,
    'params' => '{"tabOption":"advance","htmlTitle":"0","category_id":"","show_criteria":["title","likecount","favouritecount","commentcount","viewcount","postedby","posteddate","source","voting","category","socialSharing","newlabel","tags","description","likebutton","favouritebutton","followcount","followbutton","permalink"],"socialshare_enable_pinviewplusicon":"1","socialshare_icon_pinviewlimit":"2","show_limited_data":"no","pagging":"button","limit_data_list":"6","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","title":"","nomobile":"0","name":"sesdiscussion.manage-discussions"}',
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesdiscussion.discussions-of-the-day',
    'page_id' => $pageId,
    'parent_content_id' => $rightId,
    'order' => $widgetOrder++,
    'params' => '{"information":["title","likeCount","favouritecount","commentCount","viewCount","socialSharing","likebutton","favouritebutton","followcount","followbutton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"1","width":"300","title_truncation":"16","description_truncation":"60","title":"Discussion Of The Day","nomobile":"0","name":"sesdiscussion.discussions-of-the-day"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesdiscussion.popularity-discussions',
    'page_id' => $pageId,
    'parent_content_id' => $rightId,
    'order' => $widgetOrder++,
    'params' => '{"title":"Most Liked Discussions","viewType":"list","popularity":"like_count","information":["title","likeCount","favouritecount","commentCount","viewCount","postedby","description","socialSharing","likebutton","followcount"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","width":"250","title_truncation":"30","description_truncation":"50","limit":"2","nomobile":"0","name":"sesdiscussion.popularity-discussions"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesbasic.column-layout-width',
    'page_id' => $pageId,
    'parent_content_id' => $rightId,
    'order' => $widgetOrder++,
    'params' => '{"layoutColumnWidthType":"px","columnWidth":"260","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
  ));
}


//Discussion View Page
$pageId = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesdiscussion_index_view')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesdiscussion_index_view',
    'displayname' => 'SES - Discussions - Discussion View Page',
    'title' => 'Discussion View',
    'description' => 'This page displays a discussion entry.',
    'provides' => 'subject=sesdiscussion_discussion',
    'custom' => 0,
  ));
  $pageId = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $pageId,
  ));
  $mainId = $db->lastInsertId();

  // Insert left
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'left',
    'page_id' => $pageId,
    'parent_content_id' => $mainId,
    'order' => 1,
  ));
  $leftId = $db->lastInsertId();

  // Insert middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $pageId,
    'parent_content_id' => $mainId,
    'order' => 2,
  ));
  $middleId = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesdiscussion.top-discussion-poster',
    'page_id' => $pageId,
    'parent_content_id' => $leftId,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesdiscussion.other-discussions',
    'page_id' => $pageId,
    'parent_content_id' => $leftId,
    'order' => $widgetOrder++,
    'params' => '{"title":"Other Discussions","viewType":"list","popularity":"like_count","information":["title","likeCount","commentCount","viewCount","description","socialSharing","likebutton","permalink"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","width":"300","title_truncation":"16","description_truncation":"75","limit":"3","nomobile":"0","name":"sesdiscussion.other-discussions"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesdiscussion.people-like-item',
    'page_id' => $pageId,
    'parent_content_id' => $leftId,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesbasic.column-layout-width',
    'page_id' => $pageId,
    'parent_content_id' => $leftId,
    'order' => $widgetOrder++,
    'params' => '{"layoutColumnWidthType":"px","columnWidth":"250","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesdiscussion.breadcrumb',
    'page_id' => $pageId,
    'parent_content_id' => $middleId,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesdiscussion.view-page',
    'page_id' => $pageId,
    'parent_content_id' => $middleId,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likecount","commentcount","viewcount","favouritecount","followcount","postedby","posteddate","source","tags","category","voting","new","socialSharing","likebutton","followbutton","favouritebutton"],"title":"","nomobile":"0","name":"sesdiscussion.view-page"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $pageId,
    'parent_content_id' => $middleId,
    'order' => $widgetOrder++,
    'params' => '{"title":"Comments"}',
  ));
}


// profile page
$pageId = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesdiscussion_index_top-voted')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {

  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesdiscussion_index_top-voted',
    'displayname' => 'SES - Discussions - Top Voted Discussions Page',
    'title' => 'Top Voted Discussion Browse',
    'description' => 'This page lists top voted discussion entries.',
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
    'name' => 'sesdiscussion.browse-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => 1,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesdiscussion.browse-search',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => 2,
    'params' => '{"viewType":"horizontal","title":"","nomobile":"0","name":"sesdiscussion.browse-search"}',
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesdiscussion.browse-discussions',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => 3,
    'params' => '{"viewtype":"pinboard","category_id":"0","stats":["title","likecount","commentcount","viewcount","postedby","posteddate","source","voting","category","socialSharing","newlabel","description","likebutton","favouritebutton","followcount","followbutton","permalink","pinboardcomment"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","width":"250","pagging":"button","title_truncation":"25","description_truncation":"50","limit":"6","title":"","nomobile":"0","name":"sesdiscussion.browse-discussions"}',
  ));
}

// Create Page
$pageId = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesdiscussion_index_create')
  ->limit(1)
  ->query()
  ->fetchColumn();

if( !$pageId ) {

  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesdiscussion_index_create',
    'displayname' => 'SES - Discussions - Discussion Create Page',
    'title' => 'Write New Discussion',
    'description' => 'This page is the discussion create page.',
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
    'name' => 'sesdiscussion.browse-menu',
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

// Edit Page
$pageId = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesdiscussion_index_edit')
  ->limit(1)
  ->query()
  ->fetchColumn();

if( !$pageId ) {

  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesdiscussion_index_edit',
    'displayname' => 'SES - Discussions - Discussion Edit Page',
    'title' => 'Edit Discussion',
    'description' => 'This page is the discussion edit page.',
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
    'name' => 'sesdiscussion.browse-menu',
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

//Discussion Category Browse Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesdiscussion_category_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesdiscussion_category_browse',
      'displayname' => 'SES - Discussions - Discussion Category Browse Page',
      'title' => 'Discussion Category Browse',
      'description' => 'This page is the browse discussions categories page.',
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

  // Insert left
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'right',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 1,
  ));
  $rightId = $db->lastInsertId();

  // Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 6
  ));
  $main_middle_id = $db->lastInsertId();

	$db->insert('engine4_core_content', array(
      'page_id' => $page_id,
      'type' => 'widget',
      'name' => 'sesdiscussion.browse-menu',
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesdiscussion.category-icons',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"height":"200","width":"175","heighticon":"50px","widthicon":"50px","alignContent":"center","criteria":"most_discussion","showStats":["title","countDiscussions"],"limit_data":"30","title":"","nomobile":"0","name":"sesdiscussion.category-icons"}',
  ));
}

$db->query('INSERT IGNORE INTO `engine4_core_tasks` (`title`, `module`, `plugin`, `timeout`) VALUES
("SES - Discussions - Automatically Remove Discussions as New", "sesdiscussion", "Sesdiscussion_Plugin_Task_Removeasnew", 172800);');

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sesdiscussion_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('discussion', $level->level_id, array_keys($form->getValues()));

  $form->populate($valuesForm);
  if ($form->defattribut)
    $form->defattribut->setValue(0);
  $db = $permissionsTable->getAdapter();
  $db->beginTransaction();
  try {
    if ($level->type != 'public') {
      // Set permissions
      $values['auth_comment'] = (array) @$values['auth_comment'];
      $values['auth_view'] = (array) @$values['auth_view'];
    }
    $nonBooleanSettings = $form->nonBooleanFields();
    $permissionsTable->setAllowed('discussion', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}
$db->query('DELETE FROM `engine4_core_settings` WHERE `engine4_core_settings`.`name` = "sesdiscussion.options";');
