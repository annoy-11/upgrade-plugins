<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: defaultsettings.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

// profile page Design 1
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'ecoupon_profile_index')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'ecoupon_profile_index',
      'displayname' => 'SNS - Coupon - Profile View Page',
      'title' => 'Coupon View Page',
      'description' => 'This page display all details related to the current coupon like description, start, end date etc.',
      'custom' => 0,
  ));
  $pageId = $db->lastInsertId();
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
      'order' => 6,
  ));
  $mainMiddleId = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
    'page_id' => $pageId,
    'type' => 'container',
    'name' => 'right',
    'parent_content_id' => $mainId,
    'order' => 5,
    'params' => '',
  ));
  $right_id = $db->lastInsertId('engine4_core_content');
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'ecoupon.breadcrumb',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title":"","name":"ecoupon.breadcrumb"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'ecoupon.coupon-view',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["title","coursePhoto","category","by","creationDate","description","price","socialSharing","likeButton","favouriteButton","classroonNamePhoto","addCart","addWishlist","addCompare"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","maxHeight":"550","title":"","nomobile":"0","name":"ecoupon.course-view"}',
  ));
}
//SNS - Coupon Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'ecoupon_index_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'ecoupon_index_browse',
      'displayname' => 'SNS - Coupons - Coupon Browse Page',
      'title' => 'Browse Coupons',
      'description' => 'This page lists all coupons which are created by members of the website.',
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
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'ecoupon.alphabet-search',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Browse By Alphabets","name":"ecoupon.alphabet-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'ecoupon.browse-coupons',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","grid","pinboard"],"openViewType":"list","category_id":"","show_criteria":["title","coursePhoto","category","by","creationDate","listdescription","pinboarddescription","socialSharing","likeButton","favouriteButton","lectureCount","like","comment","favourite","view","featuredLabel","sponsoredLabel","verifiedLabel","rating","price","classroonNamePhoto","addCart","addWishlist","addCompare"],"sort":"recentlySPcreated","show_item_count":"0","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"130","height":"210","width":"350","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"270","width_grid":"290","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"280","pagging":"auto_load","title":"Browse Coupons","nomobile":"0","name":"ecoupon.browse-ecoupon"}',
  ));
}

//SNS - Coupon Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'ecoupon_index_manage')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'ecoupon_index_manage',
      'displayname' => 'SNS - Manage Coupons Page',
      'title' => 'Manage Coupons',
      'description' => 'This page displays all the coupons which are created by users.',
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
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'ecoupon.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Browse Menu","name":"ecoupon.browse-menu"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'ecoupon.manage-coupons',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '',
  ));
}

//Coupon Owner FAQs Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'ecoupon_index_coupon-faqs')
  ->limit(1)
  ->query()
  ->fetchColumn();

if( !$page_id ) {

  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'ecoupon_index_coupon-faqs',
    'displayname' => 'SNS  - Coupon - FAQS',
    'title' => ' Coupon FAQs',
    'description' => 'This page displays Coupon FAQs.',
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
    'name' => 'ecoupon.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'ecoupon.coupon-faqs',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}


