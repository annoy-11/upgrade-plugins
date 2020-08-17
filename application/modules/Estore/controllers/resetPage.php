<?php

/**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesqa
 * @copyright  Copyright 2014-2020 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: defaultsettings.php 2016-07-23 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();
$widgetOrder = 1;

$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'estore_manage_product-reviews')
    ->limit(1)
    ->query()
    ->fetchColumn();
if( !$page_id ) {
    $widgetOrder = 1;
    $db->insert('engine4_core_pages', array(
        'name' => 'estore_manage_product-reviews',
        'displayname' => 'SES - Stores Marketplace - Product Reviews Page',
        'title' => 'Estore - Product reviews Page',
        'description' => 'This page show product reviews.',
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
        'name' => 'left',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 1,
    ));
     $main_left_id = $db->lastInsertId();

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
        'name' => 'estore.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
    ));

     $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'estore.my-account',
        'page_id' => $page_id,
        'parent_content_id' => $main_left_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
    ));

}


$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'estore_manage_store-reviews')
    ->limit(1)
    ->query()
    ->fetchColumn();
if( !$page_id ) {
    $widgetOrder = 1;
    $db->insert('engine4_core_pages', array(
        'name' => 'estore_manage_store-reviews',
        'displayname' => 'SES - Stores Marketplace - Browse Reviews Page',
        'title' => 'Browse Reviews Page',
        'description' => 'This page show stores reviews.',
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
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
        'order' => 6,
    ));
    $top_middle_id = $db->lastInsertId();

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
        'parent_content_id' => $main_id,
        'order' => 6,
    ));
    $main_middle_id = $db->lastInsertId();

     $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'left',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 4,
    ));
     $main_left_id = $db->lastInsertId();
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'estore.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'estore.my-account',
        'page_id' => $page_id,
        'parent_content_id' => $main_left_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
    ));

}

// //Billing Page
$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'estore_manage_billing')
    ->limit(1)
    ->query()
    ->fetchColumn();
if( !$page_id ) {
    $widgetOrder = 1;
    $db->insert('engine4_core_pages', array(
        'name' => 'estore_manage_billing',
        'displayname' => 'SES - Stores Marketplace - Billing Page',
        'title' => 'Billing Address Page',
        'description' => 'This page show billing address of user.',
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
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
        'order' => 6,
    ));
    $top_middle_id = $db->lastInsertId();

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
        'parent_content_id' => $main_id,
        'order' => 6,
    ));
    $main_middle_id = $db->lastInsertId();

     $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'left',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 4,
    ));
     $main_left_id = $db->lastInsertId();

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'estore.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'estore.my-account',
        'page_id' => $page_id,
        'parent_content_id' => $main_left_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
    ));


}

//Shipping  Page
$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'estore_manage_shipping')
    ->limit(1)
    ->query()
    ->fetchColumn();
if( !$page_id ) {
    $widgetOrder = 1;
    $db->insert('engine4_core_pages', array(
        'name' => 'estore_manage_shipping',
        'displayname' => 'SES - Stores Marketplace - Shipping Page',
        'title' => 'Shipping Address Page',
        'description' => 'This page show Shipping address of user.',
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
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
        'order' => 6,
    ));
    $top_middle_id = $db->lastInsertId();

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
        'parent_content_id' => $main_id,
        'order' => 6,
    ));
    $main_middle_id = $db->lastInsertId();

     $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'left',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 4,
    ));
     $main_left_id = $db->lastInsertId();

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'estore.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'estore.my-account',
        'page_id' => $page_id,
        'parent_content_id' => $main_left_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
    ));

}


//My Orders  Page
$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'estore_manage_my-order')
    ->limit(1)
    ->query()
    ->fetchColumn();
if( !$page_id ) {
    $widgetOrder = 1;
    $db->insert('engine4_core_pages', array(
        'name' => 'estore_manage_my-order',
        'displayname' => 'SES - Stores Marketplace - My Orders Page',
        'title' => 'My Orders Page',
        'description' => 'This page show Orders of user.',
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
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
        'order' => 6,
    ));
    $top_middle_id = $db->lastInsertId();

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
        'parent_content_id' => $main_id,
        'order' => 6,
    ));
    $main_middle_id = $db->lastInsertId();

     $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'left',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 4,
    ));
     $main_left_id = $db->lastInsertId();

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'estore.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'estore.my-account',
        'page_id' => $page_id,
        'parent_content_id' => $main_left_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
    ));


}

//My Wishlists  Page
$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'estore_manage_my-wishlists')
    ->limit(1)
    ->query()
    ->fetchColumn();
if( !$page_id ) {
    $widgetOrder = 1;
    $db->insert('engine4_core_pages', array(
        'name' => 'estore_manage_my-wishlists',
        'displayname' => 'SES - Stores Marketplace - My Wishlists Page',
        'title' => 'My Wishlists Page',
        'description' => 'This page show My Wishlists of user.',
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
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
        'order' => 6,
    ));
    $top_middle_id = $db->lastInsertId();

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
        'parent_content_id' => $main_id,
        'order' => 6,
    ));
    $main_middle_id = $db->lastInsertId();

     $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'left',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 4,
    ));
     $main_left_id = $db->lastInsertId();

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'estore.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'estore.my-account',
        'page_id' => $page_id,
        'parent_content_id' => $main_left_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
    ));

}

$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'estore_manage_my-reviews')
    ->limit(1)
    ->query()
    ->fetchColumn();
if( !$page_id ) {
    $widgetOrder = 1;
    $db->insert('engine4_core_pages', array(
        'name' => 'estore_manage_my-reviews',
        'displayname' => 'SES - Stores Marketplace - My Reviews Page',
        'title' => 'My Reviews Page',
        'description' => 'This page show Reviews of user.',
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
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
        'order' => 6,
    ));
    $top_middle_id = $db->lastInsertId();

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
        'parent_content_id' => $main_id,
        'order' => 6,
    ));
    $main_middle_id = $db->lastInsertId();

     $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'left',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 4,
    ));
     $main_left_id = $db->lastInsertId();

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'estore.my-account',
        'page_id' => $page_id,
        'parent_content_id' => $main_left_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
    ));
}

//New Claims Store
$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'estore_index_claim')
    ->limit(1)
    ->query()
    ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'estore_index_claim',
    'displayname' => 'SES - Stores Marketplace - New Claims Store',
    'title' => 'Store Claim',
    'description' => 'This page lists store entries.',
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
    'name' => 'estore.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'estore.claim-store',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    ));
}


//Browse Claim Requests Store
$page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'estore_index_claim-requests')
                ->limit(1)
                ->query()
                ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'estore_index_claim-requests',
    'displayname' => 'SES - Stores Marketplace - Browse Claim Requests Page',
    'title' => 'Store Claim Requests',
    'description' => 'This page lists store claims request entries.',
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
    'name' => 'estore.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'estore.claim-requests',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    ));
}

// Welcome page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_welcome')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_welcome',
      'displayname' => 'SES - Stores Marketplace - Stores Welcome Page',
      'title' => 'Store Welcome Page',
      'description' => 'This page lists stores.',
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
      'name' => 'sesadvancedbanner.banner-slideshow',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"banner_id":"2","inside_outside":"0","full_width":"1","bgimg_move":"0","nav":"1","scrollbottom":"0","duration":"3000","height":"504","title":"","nomobile":"0","name":"sesadvancedbanner.banner-slideshow"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.custom-offer',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"heading":"","button_title":"Shop Now","show_timer":"no","design":"design1","offer_id":"3","itemCount":"4","height":"234","width":"280","title":"","nomobile":"0","name":"sesproduct.custom-offer"}',
  ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.custom-offer',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"heading":"","button_title":"Shop Now","show_timer":"no","design":"design2","offer_id":"4","itemCount":"4","height":"350","width":"280","title":"","nomobile":"0","name":"sesproduct.custom-offer"}',
  ));

     $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.custom-offer',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"heading":"","button_title":"Shop Now","show_timer":"no","design":"design3","offer_id":"5","itemCount":"10","height":"350","width":"280","title":"","nomobile":"0","name":"sesproduct.custom-offer"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.html-block',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title":"HTML Block","adminTitle":"Admin ","data":"<style>\r\n.offer_banner{\r\n text-align:center;\r\n}\r\n.offer_banner img{\r\ndisplay:block;\r\nmargin:10px auto;\r\nheight:auto;\r\nwidth:100%;\r\nobject-fit:contain;\r\n}\r\n<\/style>\r\n<div class=\"offer_banner\">\r\n<img src=\"\/public\/admin\/estore-ad-banner.png\"\/>\r\n<\/div>","nomobile":"0","name":"core.html-block"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.custom-offer',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"heading":"Hot Deals","button_title":"Shop Now","show_timer":"yes","design":"design4","offer_id":"6","itemCount":"10","height":"380","width":"280","title":"Only for limited time.","nomobile":"0","name":"sesproduct.custom-offer"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesbasic.body-class',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"bodyclass":"estore_welcome_store","title":"","nomobile":"0","name":"sesbasic.body-class"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.custom-offer',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"heading":"","button_title":"Shop Now","show_timer":"yes","design":"design5","offer_id":"7","itemCount":"3","height":"180","width":"180","title":"","nomobile":"0","name":"sesproduct.custom-offer"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.custom-offer',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"heading":"","button_title":"Shop Now","show_timer":"no","design":"design1","offer_id":"3","itemCount":"4","height":"234","width":"280","title":"","nomobile":"0","name":"sesproduct.custom-offer"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.custom-offer',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"heading":"","button_title":"Shop Now","show_timer":"no","design":"design2","offer_id":"4","itemCount":"4","height":"350","width":"280","title":"","nomobile":"0","name":"sesproduct.custom-offer"}',
  ));
}

//SES - Store Home Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_home')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_home',
      'displayname' => 'SES - Stores Marketplace - Stores Home Page',
      'title' => 'Stores Home',
      'description' => 'This page lists a user\'s stores.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-of-day',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":"","category_id":"","criteria":"5","info":"recently_created","show_criteria":["title","category","joinButton","like","comment","favourite","view","follow","featuredLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"50","width":"50","limit_data":"4","title":"Featured Stores","nomobile":"0","name":"estore.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":"","category_id":"","criteria":"5","info":"recently_created","show_criteria":["title","category","joinButton","like","comment","favourite","view","follow","featuredLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"50","width":"50","limit_data":"4","title":"Featured Stores","nomobile":"0","name":"estore.featured-sponsored-hot"}',
  ));

 $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":"","category_id":"","criteria":"5","info":"recently_created","show_criteria":["title","category","joinButton","like","comment","favourite","view","follow","featuredLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"50","width":"50","limit_data":"4","title":"Featured Stores","nomobile":"0","name":"estore.featured-sponsored-hot"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.recently-viewed-item',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"pinboard","order":"","category_id":"","criteria":"5","info":"recently_created","show_criteria":["title","by","ownerPhoto","creationDate","category","status","description","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","like","comment","favourite","view","follow","member","featuredLabel","sponsoredLabel","verifiedLabel","newLabel","hotLabel","price","rating","totatProduct"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"160","width":"250","limit_data":"3","title":"","nomobile":"0","name":"estore.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"pinboard","order":"","category_id":"","criteria":"5","info":"recently_created","show_criteria":["title","by","ownerPhoto","creationDate","category","status","description","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","like","comment","favourite","view","follow","member","featuredLabel","sponsoredLabel","verifiedLabel","newLabel","hotLabel","price","rating","totatProduct"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"160","width":"250","limit_data":"3","title":"","nomobile":"0","name":"estore.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.stores-slideshow',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"leftStore":"1","category_id":"","info":"recently_created","criteria":"5","order":"","enableSlideshow":"1","criteria_right":"5","info_right":"recently_created","navigation":"2","autoplay":"1","title_truncation":"45","description_truncation":"45","speed":"2000","height":"365","limit_data":"5","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_criteria":["title","by","ownerPhoto","creationDate","category","price","location","status","description","socialSharing","contactButton","contactDetail","likeButton","favouriteButton","followButton","joinButton","member","like","comment","favourite","view","follow","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newlabel","totalProduct"],"title":"","nomobile":"0","name":"estore.stores-slideshow"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.tabbed-widget-store',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","grid","pinboard","map"],"openViewType":"list","tabOption":"advance","category_id":"","show_criteria":["title","by","ownerPhoto","creationDate","category","location","listdescription","griddescription","pinboarddescription","price","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"button","show_limited_data":"no","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"5","list_title_truncation":"45","list_description_truncation":"45","height":"120","width":"120","dummy16":null,"dummy17":null,"dummy18":null,"limit_data_simplegrid":"5","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"200","width_simplegrid":"289","dummy19":null,"dummy20":null,"limit_data_pinboard":"5","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"280","dummy21":null,"limit_data_map":"5","search_type":["open","close","recentlySPcreated","mostSPliked","mostSPcommented","mostSPviewed","mostSPfavourite","mostSPfollowed","mostSPrated","mostSPjoined","featured","sponsored","verified","hot"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPliked_order":"2","mostSPliked_label":"Most Liked","dummy3":null,"mostSPcommented_order":"3","mostSPcommented_label":"Most Commented","dummy4":null,"mostSPviewed_order":"4","mostSPviewed_label":"Most Viewed","dummy5":null,"mostSPfavourite_order":"5","mostSPfavourite_label":"Most Favourited","dummy6":null,"mostSPfollowed_order":"6","mostSPfollowed_label":"Most Followed","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"hot_order":"10","hot_label":"Hot","title":"Popular Stores","nomobile":"0","name":"estore.tabbed-widget-store"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":"","category_id":"","criteria":"5","info":"most_liked","show_criteria":["title","category","joinButton","like","comment","favourite","view","follow"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"50","width":"50","limit_data":"3","title":"Most Liked Stores","nomobile":"0","name":"estore.featured-sponsored-hot"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.tag-cloud-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"color":"#080707","type":"cloud","text_height":"11","height":"230","itemCountPerPage":"15","title":"Tags","nomobile":"0","name":"estore.tag-cloud-stores"}',
  ));

    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":"","category_id":"","criteria":"5","info":"recently_created","show_criteria":["title","category","like","comment","favourite","view","follow","member","sponsoredLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"50","width":"50","limit_data":"4","title":"Sponsored Stores","nomobile":"0","name":"estore.featured-sponsored-hot"}',
  ));

    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.you-may-also-like-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"You May Also Like Stores","viewType":"listView","category_id":"","information":["title","category","member","like","comment","favourite","view","follow","rating"],"title_truncation":"5","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","limit_data_list":"4","list_title_truncation":"45","list_description_truncation":"60","height_list":"50","width_list":"50","grid_data_list":"4","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_grid":"50","width_grid":"50","nomobile":"0","name":"estore.you-may-also-like-stores"}',
  ));

    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":"","category_id":"","criteria":"6","info":"recently_created","show_criteria":["title","category","description","like","comment","favourite","view","follow","member","verifiedLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"50","width":"50","limit_data":"4","title":"Verified Store","nomobile":"0","name":"estore.featured-sponsored-hot"}',
  ));
}

//SES - Store Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_browse',
      'displayname' => 'SES - Stores Marketplace - Stores Browse Page',
      'title' => 'Store Browse',
      'description' => 'This page lists stores.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));
 $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"recentlySPcreated","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchStoreTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closestore"],"hide_option":["searchStoreTitle","view","browseBy","alphabet","Categories","location","miles","country","state","city","zip","venue","closestore"],"title":"Search stores","nomobile":"0","name":"estore.browse-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-category-icons',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"titleC":"Browse by Category","criteria":"most_store","show_criteria":["title","countStores","followButton"],"alignContent":"center","viewType":"image","shapeType":"circle","show_bg_color":"1","bgColor":"#FFFFFF","height":"130","width":"130","limit_data":"10","title":"","nomobile":"0","name":"estore.store-category-icons"}',
  ));
// Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-alphabet',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"0":"","title":""}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","simplegrid","pinboard","map"],"openViewType":"list","category_id":"","show_criteria":["title","listdescription","simplegriddescription","pinboarddescription","creationDate","category","price","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","member","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel","rating","totalProduct"],"pagging":"pagging","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"100","height":"160","width":"160","dummy17":null,"limit_data_simplegrid":"9","simplegrid_title_truncation":"45","simplegrid_description_truncation":"120","height_simplegrid":"200","width_simplegrid":"295","dummy20":null,"limit_data_pinboard":"5","pinboard_title_truncation":"45","pinboard_description_truncation":"75","width_pinboard":"260","height_pinboard":"300","dummy21":null,"limit_data_map":"5","title":"","nomobile":"0","name":"estore.browse-stores"}',
  ));

 $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.slideshow',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"category_id":"","show_criteria":["title","description","ownerPhoto","by","creationDate","category","price","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","member","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","rating"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","limit_data":"20","title_truncation":"50","description_truncation":"80","height":"200","width":"300","title":"Similar Stores","nomobile":"0","name":"estore.slideshow"}',
  ));

   $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.stores-slideshow',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"leftStore":"1","category_id":"","info":"recently_created","criteria":"5","order":"","enableSlideshow":"1","criteria_right":"5","info_right":"recently_created","navigation":"1","autoplay":"0","title_truncation":"45","description_truncation":"45","speed":"2000","height":"160","limit_data":"20","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_criteria":["title","by","ownerPhoto","creationDate","category","price","location","status","description","socialSharing","contactButton","contactDetail","likeButton","favouriteButton","followButton","joinButton","member","like","comment","favourite","view","follow","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newlabel","totalProduct"],"title":"Double Store Directories","nomobile":"0","name":"estore.stores-slideshow"}',
  ));

 $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.popular-categories',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","showinformation":["description","caticon","socialshare"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","criteria":"alphabetical","title_truncation":"45","description_truncation":"45","mainblockheight":"280","mainblockwidth":"270","categoryiconheight":"64","categoryiconwidth":"64","limit_data":"4","title":"Popular Categories","nomobile":"0","name":"estore.popular-categories"}',
  ));


   $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-menu-quick',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"popup":"1","title":"","nomobile":"0","name":"estore.browse-menu-quick"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":"","category_id":"","criteria":"5","info":"most_viewed","show_criteria":["title","category","joinButton","like","comment","favourite","view","follow","member","sponsoredLabel","rating"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"21","description_truncation":"45","width_pinboard":"300","height":"50","width":"50","limit_data":"4","title":"Sponsored Stores","nomobile":"0","name":"estore.featured-sponsored-hot"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":"","category_id":"","criteria":"5","info":"follow_count","show_criteria":["title","category","joinButton","like","comment","favourite","view","follow","member","featuredLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"21","description_truncation":"45","width_pinboard":"50","height":"50","width":"50","limit_data":"4","title":"Featured Stores","nomobile":"0","name":"estore.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.tag-cloud-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"color":"#eb7c7c","type":"cloud","text_height":"15","height":"150","itemCountPerPage":"20","title":"","nomobile":"0","name":"estore.tag-cloud-stores"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.you-may-also-like-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Stores You May Also Like","viewType":"listView","category_id":"","information":["title","by","storeName","category","price","description","location","socialSharing","contactButton","member","like","comment","favourite","view","follow","rating","totalProduct"],"title_truncation":"45","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","limit_data":"2","list_title_truncation":"45","list_description_truncation":"45","height_list":"50","width_list":"50","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_grid":"230","width_grid":"260","nomobile":"0","name":"estore.you-may-also-like-stores"}',
  ));

 $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesbasic.column-layout-width',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"layoutColumnWidthType":"px","columnWidth":"250","title":"","nomobile":"0","name":"sesbasic.column-layout-width"}',
  ));
   $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-of-day',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Store of the Day","category_id":"","information":["title","postedby","category","creationDate","location","socialSharing","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","view","favourite","follow","member","featuredLabel","sponsoredLabel","hotLabel","verifiedLabel","price","rating"],"imageheight":"260","title_truncation":"180","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","nomobile":"0","name":"estore.store-of-day"}',
  ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.recently-viewed-item',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","category_id":"","criteria":"by_me","show_criteria":["title","category","member","like","comment","favourite","view"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"5","description_truncation":"10","height":"50","width":"50","width_pinboard":"300","limit_data":"5","title":"Recently viewed","nomobile":"0","name":"estore.recently-viewed-item"}',
  ));
}

//SES - Store Browse Locations Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_browse-locations')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_browse-locations',
      'displayname' => 'SES - Stores Marketplace - Stores Browse Locations Page',
      'title' => 'Store Browse Locations',
      'description' => 'This page lists stores locations.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"recentlySPcreated","criteria":["0","4","1","2","3"],"default_view_search_type":"0","show_option":["searchStoreTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closestore"],"hide_option":["miles","country","state","city","zip","venue","closestore"],"title":"","nomobile":"0","name":"estore.browse-search"}',
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-locations-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"category_id":"","show_criteria":["title","description","by","creationDate","category","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","member","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"show_item_count":"1","height":"120","width":"120","title_truncation":"45","description_truncation":"45","limit_data_list":"10","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"pagging","title":"","nomobile":"0","name":"estore.browse-locations-stores"}',
  ));
}

//SES - Store Manage Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_manage')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_manage',
      'displayname' => 'SES - Stores Marketplace - Store Manage Page',
      'title' => 'My Stores',
      'description' => 'This page lists a user\'s stores.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' =>'{"title":"Navigation ","name":"estore.browse-menu"}',
  ));

// Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.manage-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","simplegrid","pinboard","map"],"openViewType":"list","tabOption":"vertical","category_id":"","show_criteria":["title","by","ownerPhoto","creationDate","category","location","listdescription","simplegriddescription","pinboarddescription","price","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"button","show_limited_data":"no","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","htmlTitle":"1","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"340","width":"300","dummy16":null,"dummy17":null,"dummy18":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"270","width_simplegrid":"389","dummy19":null,"dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"300","dummy21":null,"limit_data_map":"10","search_type":["open","close","recentlySPcreated","mostSPliked","mostSPcommented","mostSPviewed","mostSPfavourite","mostSPfollowed","mostSPjoined","featured","sponsored","verified","hot"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPliked_order":"2","mostSPliked_label":"Most Liked","dummy3":null,"mostSPcommented_order":"3","mostSPcommented_label":"Most Commented","dummy4":null,"mostSPviewed_order":"4","mostSPviewed_label":"Most Viewed","dummy5":null,"mostSPfavourite_order":"5","mostSPfavourite_label":"Most Favourited","dummy6":null,"mostSPfollowed_order":"6","mostSPfollowed_label":"Most Followed","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"hot_order":"10","hot_label":"Hot","title":"","nomobile":"0","name":"estore.manage-stores"}',
  ));
}

//SES - Store Create Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_create')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_create',
      'displayname' => 'SES - Stores Marketplace - Store Create Page',
      'title' => 'Store Create',
      'description' => 'This page allows store to be create.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => 1,
      'params' => '{"title":"","name":"estore.browse-menu"}',
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
        ->where('name = ?', 'estore_profile_index_1')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_profile_index_1',
      'displayname' => 'SES - Stores Marketplace - Store View Page Design 1',
      'title' => 'store View',
      'description' => 'This page displays a store entry.',
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
      'name' => 'estore.profile-main-photo',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["photo","title","storeUrl","tab"],"limit_data":"5","height":"150","width":"150","title":"","nomobile":"0","name":"estore.profile-main-photo"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.open-hours',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Operating Hours","name":"estore.open-hours"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.recent-people-activity',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["like","favourite","follow","review"],"height":"50","width":"50","view_more_like":"2","view_more_favourite":"2","view_more_follow":"3","view_more_reviews":"3","title":"People who acted","nomobile":"0","name":"estore.recent-people-activity"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-liked',
      'page_id' => $pageId,
      'parent_content_id' => $mainLeftId,
      'order' => $widgetOrder++,
      'params' => '{"limit_data":"2","height":"100","width":"100","title":"Liked by you","nomobile":"0","name":"estore.store-liked"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-view',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"layout_type":"1","tab_placement":"out","show_criteria":["title","photo","by","messageOwner","rating","member","price","creationDate","category","socialSharing","likeButton","favouriteButton","followButton","joinButton","addButton","like","comment","favourite","view","member","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","optionMenu"],"show_full_width":"no","margin_top":"1","description_truncation":"150","cover_height":"360","main_photo_height":"100","main_photo_width":"100","socialshare_enable_plusicon":"1","socialshare_icon_limit":"1","title":"","nomobile":"0","name":"estore.store-view"}',
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
      $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.profile-sesproducts',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","grid","pinboard","map"],"openViewType":"list","category_id":"","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","location","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","quickView","creationDate","descriptionlist","descriptiongrid","descriptionpinboard","enableCommentPinboard","price","discount","stock","storeName","addCart","addWishlist","addCompare","brand","offer","totalProduct"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_pinviewplusicon":"1","socialshare_icon_pinviewlimit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","show_limited_data":"no","pagging":"button","title_truncation_list":"45","limit_data_list":"10","description_truncation_list":"45","height_list":"230","width_list":"260","title_truncation_grid":"45","limit_data_grid":"10","description_truncation_grid":"45","height_grid":"270","width_grid":"389","title_truncation_pinboard":"45","limit_data_pinboard":"10","description_truncation_pinboard":"45","height_pinboard":"300","width_pinboard":"300","limit_data_map":"10","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","week","month","featured","sponsored","verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"Products","nomobile":"0","name":"sesproduct.profile-sesproducts"}',
  ));

  if ($activutyType) {
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvancedactivity.feed',
        'page_id' => $pageId,
        'parent_content_id' => $tab_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Posts","max_photo":"8"}',
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
      'name' => 'estore.store-reviews',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","storeName"],"title":"Profile Store Review","nomobile":"0","name":"estore.store-reviews"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-overview',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Overview","name":"estore.store-overview"}',
  ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.like-button',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":" Like ","name":"estore.like-button"}',
  ));
     $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-tips',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Useful tips","description":"Make attractive stores","types":["addLocation","addCover","addProfilePhoto"],"nomobile":"0","name":"estore.profile-tips"}',
  ));
 $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.follow-button',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Follow","name":"estore.follow-button"}',
  ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.comments',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Comments"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-info',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":"","title":"Details","nomobile":"0","name":"estore.store-info"}',
  ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-action-button',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Call To Action ","name":"estore.profile-action-button"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-map',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Locations","titleCount":true,"name":"estore.store-map"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-announcements',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"limit_data":"2","title":"Announcements","nomobile":"0","name":"estore.profile-announcements"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-members',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Members","name":"estore.profile-members"}',
  ));

 $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.link-stores',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","simplegrid","pinboard","map"],"openViewType":"list","category_id":"","show_criteria":["title","listdescription","simplegriddescription","pinboarddescription","by","creationDate","category","price","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","member","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel","rating","totalProduct"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"2","list_title_truncation":"45","list_description_truncation":"45","height":"100","width":"100","dummy17":null,"limit_data_simplegrid":"2","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"220","width_simplegrid":"250","dummy20":null,"limit_data_pinboard":"1","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"250","height_pinboard":"300","dummy21":null,"limit_data_map":"1","title":"Link stores","nomobile":"0","name":"estore.link-stores"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.sub-stores',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","simplegrid","pinboard","map"],"openViewType":"list","category_id":"","show_criteria":["title","listdescription","simplegriddescription","pinboarddescription","by","creationDate","category","price","location","socialSharing","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"230","width":"260","dummy17":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"270","width_simplegrid":"389","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"300","height_pinboard":"300","dummy21":null,"limit_data_map":"10","title":"Sub Stores","nomobile":"0","name":"estore.sub-stores"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.main-store-details',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["storePhoto","title","likeButton","favouriteButton","followButton","joinButton"],"title":"Sub stores","nomobile":"0","name":"estore.main-store-details"}',
  ));
}
// profile page design 2
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_profile_index_2')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_profile_index_2',
      'displayname' => 'SES - Stores Marketplace - page View Page Design 2',
      'title' => 'page View',
      'description' => 'This page displays a store entry.',
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
      'name' => 'estore.store-view',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"layout_type":"1","tab_placement":"out","show_criteria":["title","photo","by","messageOwner","rating","member","price","creationDate","category","socialSharing","likeButton","favouriteButton","followButton","joinButton","addButton","like","comment","favourite","view","member","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","optionMenu"],"show_full_width":"no","margin_top":"1","description_truncation":"150","cover_height":"360","main_photo_height":"120","main_photo_width":"120","socialshare_enable_plusicon":"1","socialshare_icon_limit":"1","title":"","nomobile":"0","name":"estore.store-view"}',
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
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.profile-sesproducts',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","grid","pinboard","map"],"openViewType":"list","tabOption":"advance","htmlTitle":"1","category_id":"","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","location","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","readmore","creationDate","descriptionlist","descriptiongrid","descriptionpinboard","enableCommentPinboard","price","discount","stock","storeName","addCart","addWishlist","addCompare","brand","offer","totalProduct"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_listview2plusicon":"1","socialshare_icon_listview2limit":"2","socialshare_enable_listview3plusicon":"1","socialshare_icon_listview3limit":"2","socialshare_enable_listview4plusicon":"1","socialshare_icon_listview4limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_gridview2plusicon":"1","socialshare_icon_gridview2limit":"2","socialshare_enable_gridview3plusicon":"1","socialshare_icon_gridview3limit":"2","socialshare_enable_gridview4plusicon":"1","socialshare_icon_gridview4limit":"2","socialshare_enable_pinviewplusicon":"1","socialshare_icon_pinviewlimit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","show_limited_data":"no","pagging":"auto_load","title_truncation_list":"45","limit_data_list":"10","description_truncation_list":"45","height_list":"230","width_list":"260","title_truncation_grid":"45","limit_data_grid":"10","description_truncation_grid":"45","height_grid":"270","width_grid":"389","title_truncation_pinboard":"45","limit_data_pinboard":"10","description_truncation_pinboard":"45","height_pinboard":"300","width_pinboard":"300","limit_data_map":"10","search_type":"","dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"Products","nomobile":"0","name":"sesproduct.profile-sesproducts"}',
  ));
  if ($activutyType) {
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvancedactivity.feed',
        'page_id' => $pageId,
        'parent_content_id' => $tab_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Posts","max_photo":"8"}',
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
      'name' => 'estore.store-info',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["info","description","profilefield"],"title":"Info","nomobile":"0","name":"estore.store-info"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-overview',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Overview","name":"estore.store-overview"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-photos',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","title","by","socialSharing","photoCount","likeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"estore.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-map',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Map","titleCount":true}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-announcements',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"limit_data":"5","title":"Announcements","nomobile":"0","name":"estore.profile-announcements"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.sub-stores',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","ownerPhoto","by"],"pagging":"auto_load","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"230","width":"260","dummy16":null,"limit_data_advlist":"10","advlist_title_truncation":"45","advlist_description_truncation":"45","height_advlist":"230","width_advlist":"260","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"270","width_grid":"389","dummy18":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"270","width_simplegrid":"389","dummy19":null,"limit_data_advgrid":"10","advgrid_title_truncation":"45","advgrid_description_truncation":"45","height_advgrid":"230","width_advgrid":"260","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"300","dummy21":null,"limit_data_map":"10","title":"Associated Stores","nomobile":"0","name":"estore.sub-stores"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.service',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Services","name":"estore.service"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.product-reviews',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"stats":["likeCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","rating","productTitle"],"title":"Profile Product Review","nomobile":"0","name":"sesproduct.product-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.open-hours',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Operating Hours","name":"estore.open-hours"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-info',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["owner","creationDate","categories","tag","like","comment","favourite","view","follow"],"title":"","nomobile":"0","name":"estore.profile-info"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.recent-people-activity',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["like","favourite","follow"],"height":"70","width":"70","view_more_like":"1","view_more_favourite":"1","view_more_follow":"1","title":"","nomobile":"0","name":"estore.recent-people-activity"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.main-store-details',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["storePhoto","title","likeButton","favouriteButton","followButton","joinButton"],"title":"","nomobile":"0","name":"estore.main-store-details"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-liked',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Stores Liked by This Store","name":"estore.store-liked"}',
  ));
}

// profile page design 3
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_profile_index_3')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_profile_index_3',
      'displayname' => 'SES - Stores Marketplace - page View Page Design 3',
      'title' => 'page View',
      'description' => 'This page displays a store entry.',
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
      'name' => 'estore.store-view',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"layout_type":"1","tab_placement":"out","show_criteria":["title","photo","by","messageOwner","rating","member","price","creationDate","category","socialSharing","likeButton","favouriteButton","followButton","joinButton","addButton","like","comment","favourite","view","member","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","optionMenu"],"show_full_width":"no","margin_top":"1","description_truncation":"150","cover_height":"360","main_photo_height":"120","main_photo_width":"120","socialshare_enable_plusicon":"1","socialshare_icon_limit":"1","title":"","nomobile":"0","name":"estore.store-view"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-tips',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Tips","description":"","types":["addLocation","addCover","addProfilePhoto"],"nomobile":"0","name":"estore.profile-tips"}',
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
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.profile-sesproducts',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","grid","pinboard","map"],"openViewType":"list","tabOption":"advance","htmlTitle":"1","category_id":"","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","location","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","readmore","creationDate","descriptionlist","descriptiongrid","descriptionpinboard","enableCommentPinboard","price","discount","stock","storeName","addCart","addWishlist","addCompare","brand","offer","totalProduct"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_listview2plusicon":"1","socialshare_icon_listview2limit":"2","socialshare_enable_listview3plusicon":"1","socialshare_icon_listview3limit":"2","socialshare_enable_listview4plusicon":"1","socialshare_icon_listview4limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_gridview2plusicon":"1","socialshare_icon_gridview2limit":"2","socialshare_enable_gridview3plusicon":"1","socialshare_icon_gridview3limit":"2","socialshare_enable_gridview4plusicon":"1","socialshare_icon_gridview4limit":"2","socialshare_enable_pinviewplusicon":"1","socialshare_icon_pinviewlimit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","show_limited_data":"no","pagging":"auto_load","title_truncation_list":"45","limit_data_list":"10","description_truncation_list":"45","height_list":"230","width_list":"260","title_truncation_grid":"45","limit_data_grid":"10","description_truncation_grid":"45","height_grid":"270","width_grid":"389","title_truncation_pinboard":"45","limit_data_pinboard":"10","description_truncation_pinboard":"45","height_pinboard":"300","width_pinboard":"300","limit_data_map":"10","search_type":"","dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"Products","nomobile":"0","name":"sesproduct.profile-sesproducts"}',
  ));
  if ($activutyType) {
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvancedactivity.feed',
        'page_id' => $pageId,
        'parent_content_id' => $tab_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Posts","max_photo":"8"}',
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
      'name' => 'estore.store-info',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["info","description","profilefield"],"title":"Info","nomobile":"0","name":"estore.store-info"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-overview',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Overview","name":"estore.store-overview"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-photos',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","title","by","socialSharing","photoCount","likeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"estore.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-map',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Map","titleCount":true}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-announcements',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"limit_data":"5","title":"Announcements","nomobile":"0","name":"estore.profile-announcements"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.sub-stores',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","ownerPhoto","by"],"pagging":"auto_load","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"230","width":"260","dummy16":null,"limit_data_advlist":"10","advlist_title_truncation":"45","advlist_description_truncation":"45","height_advlist":"230","width_advlist":"260","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"270","width_grid":"389","dummy18":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"270","width_simplegrid":"389","dummy19":null,"limit_data_advgrid":"10","advgrid_title_truncation":"45","advgrid_description_truncation":"45","height_advgrid":"230","width_advgrid":"260","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"300","dummy21":null,"limit_data_map":"10","title":"Associated Stores","nomobile":"0","name":"estore.sub-stores"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.service',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Services","name":"estore.service"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.product-reviews',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"stats":["likeCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","rating","productTitle"],"title":"Profile Product Review","nomobile":"0","name":"sesproduct.product-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.open-hours',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Operating Hours","name":"estore.open-hours"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-info',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["owner","creationDate","categories","tag","like","comment","favourite","view","follow"],"title":"","nomobile":"0","name":"estore.profile-info"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.recent-people-activity',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"criteria":["like","favourite","follow"],"height":"70","width":"70","view_more_like":"1","view_more_favourite":"1","view_more_follow":"1","title":"","nomobile":"0","name":"estore.recent-people-activity"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.main-store-details',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["storePhoto","title","likeButton","favouriteButton","followButton","joinButton"],"title":"","nomobile":"0","name":"estore.main-store-details"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-liked',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Stores Liked by This Store","name":"estore.store-liked"}',
  ));
}

// profile page design 4
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_profile_index_4')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_profile_index_4',
      'displayname' => 'SES - Stores Marketplace - page View Page Design 4',
      'title' => 'page View',
      'description' => 'This page displays a store entry.',
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
      'name' => 'estore.store-view',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"layout_type":"1","tab_placement":"out","show_criteria":["title","photo","by","messageOwner","rating","member","price","creationDate","category","socialSharing","likeButton","favouriteButton","followButton","joinButton","addButton","like","comment","favourite","view","member","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","optionMenu"],"show_full_width":"no","margin_top":"1","description_truncation":"150","cover_height":"360","main_photo_height":"120","main_photo_width":"120","socialshare_enable_plusicon":"1","socialshare_icon_limit":"1","title":"","nomobile":"0","name":"estore.store-view"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-tips',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Tips","description":"","types":["addLocation","addCover","addProfilePhoto"],"nomobile":"0","name":"estore.profile-tips"}',
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
        'params' => '{"title":"Posts","max_photo":"8"}',
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
      'name' => 'estore.store-info',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["info","description","profilefield"],"title":"Info","nomobile":"0","name":"estore.store-info"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-map',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Map","titleCount":true}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-overview',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Overview","name":"estore.store-overview"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-photos',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","title","by","socialSharing","photoCount","likeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"estore.profile-photos"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.profile-announcements',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"limit_data":"5","title":"Announcements","nomobile":"0","name":"estore.profile-announcements"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.sub-stores',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","ownerPhoto","by"],"pagging":"auto_load","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"230","width":"260","dummy16":null,"limit_data_advlist":"10","advlist_title_truncation":"45","advlist_description_truncation":"45","height_advlist":"230","width_advlist":"260","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"45","height_grid":"270","width_grid":"389","dummy18":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"270","width_simplegrid":"389","dummy19":null,"limit_data_advgrid":"10","advgrid_title_truncation":"45","advgrid_description_truncation":"45","height_advgrid":"230","width_advgrid":"260","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"300","dummy21":null,"limit_data_map":"10","title":"Associated Stores","nomobile":"0","name":"estore.sub-stores"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.service',
      'page_id' => $pageId,
      'parent_content_id' => $tab_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Services","name":"estore.service"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesproduct.product-reviews',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"stats":["likeCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","rating","productTitle"],"title":"Profile Product Review","nomobile":"0","name":"sesproduct.product-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.open-hours',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Operating Hours","name":"estore.open-hours"}',
  ));
  $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'estore.profile-photos',
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Photo Albums","titleCount":false,"load_content":"pagging","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"hover","show_criteria":["title","socialSharing","likeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"3","height":"120","width":"150","nomobile":"0","name":"estore.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-liked',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Stores Liked by This Store","name":"estore.store-liked"}',
  ));
}

//SES - Store Category Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_category_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_category_browse',
      'displayname' => 'SES - Stores Marketplace - Store Category Browse Page',
      'title' => 'Store Category Browse',
      'description' => 'This page lists store categories.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.category-carousel',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"title_truncation":"45","description_truncation":"45","height":"200","width":"300","speed":"300","autoplay":"1","criteria":"alphabetical","show_criteria":["title","description","countStores"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","isfullwidth":"1","limit_data":"10","nomobile":"0","name":"estore.category-carousel"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.banner-category',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"description":"Discover stores of all media types based on the categories and your interests.","estore_categorycover_photo":"application\/modules\/Estore\/externals\/images\/stores-category-banner.jpg","show_popular_stores":"1","title_pop":"Popular Stores","order":"","info":"most_viewed","height":"300","height_advgrid":"180","width":"260","isfullwidth":"0","margin_top":"20","title":"Categories","nomobile":"0","name":"estore.banner-category"}',
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.category-associate-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"carousel","criteria":null,"popularty":"all","order":"like_count","show_category_criteria":["seeAll","countStore","categoryDescription"],"show_criteria":["title","by","ownerPhoto","creationDate","category","location","description","socialSharing","contactButton","contactDetail","likeButton","favouriteButton","followButton","joinButton","member","like","comment","favourite","view","follow","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"auto_load","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","grid_description_truncation":"45","title_truncation":"45","slideshow_description_truncation":"250","height":"150","width":"300","category_limit":"6","page_limit":"8","allignment_seeall":"right","title":"","nomobile":"0","name":"estore.category-associate-stores"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.featured-sponsored-hot',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","order":null,"category_id":"","criteria":"5","info":null,"show_criteria":["title","by","joinButton","like","comment"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","width_pinboard":"300","height":"50","width":"50","limit_data":"4","title":"Most Participated Stores","nomobile":"0","name":"estore.featured-sponsored-hot"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.recently-viewed-item',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","category_id":"","criteria":"on_site","show_criteria":["title","by","category","like","comment"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","height":"50","width":"50","width_pinboard":"300","limit_data":"4","title":"Recently Viewed Stores","nomobile":"0","name":"estore.recently-viewed-item"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.tag-cloud-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"color":"#00f","type":"tab","text_height":"15","height":"300","itemCountPerPage":"15","title":"Popular Tags","nomobile":"0","name":"estore.tag-cloud-stores"}',
  ));
}

//SES - Store Category View Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_category_index')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_category_index',
      'displayname' => 'SES - Stores Marketplace - Store Category View Page',
      'title' => 'Store Category View',
      'description' => 'This page displays a store entry.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.category-view',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"show_subcat":"1","subcategory_title":"Sub-Categories of this catgeory","show_subcatcriteria":["title","icon","countStores"],"show_follow_button":"1","heightSubcat":"160px","widthSubcat":"250px","show_popular_pages":"1","pop_title":"Popular Stores","info":"creationSPdate","dummy1":null,"store_title":"Explore Stores","show_criteria":["title","ownerPhoto","by","creationDate","category","price","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","member","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"button","page_limit":"2","height":"250","width":"392","title":"Main Category","nomobile":"0","name":"estore.category-view"}',
  ));
}

//SES - Store Browse Tag Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_tags')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$pageId) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_tags',
      'displayname' => 'SES - Stores Marketplace - Stores Tags Browse Page',
      'title' => 'Browse Tag Store',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => 1,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.tag-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => 1,
      'params' => '{"title":"","name":"estore.tag-stores"}',
  ));
}

//SES - Store Pinboard Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_pinboard')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_pinboard',
      'displayname' => 'SES - Stores Marketplace - Stores Browse Pinboard Page',
      'title' => 'Store Browse Pnboard',
      'description' => 'This page lists stores.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"mostSPliked","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchStoreTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","venue","closestore"],"hide_option":["alphabet","Categories","location","miles","country","state","city","zip","venue","closestore"],"title":"","nomobile":"0","name":"estore.browse-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["pinboard"],"openViewType":"pinboard","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"pagging","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"60","height":"200","width":"310","dummy16":null,"limit_data_advlist":"5","advlist_title_truncation":"45","advlist_description_truncation":"70","height_advlist":"250","width_advlist":"310","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"60","height_grid":"250","width_grid":"310","dummy18":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"60","height_simplegrid":"250","width_simplegrid":"260","dummy19":null,"limit_data_advgrid":"10","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"250","width_advgrid":"295","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"10","title":"","nomobile":"0","name":"estore.browse-stores"}',
  ));
}

//SES - Store Verified Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_verified')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_verified',
      'displayname' => 'SES - Stores Marketplace - Stores Verified Page',
      'title' => 'Store Verified',
      'description' => 'This page lists stores.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["verified"],"default_search_type":"verified","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchStoreTitle","view","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closestore"],"hide_option":["alphabet","Categories","location","miles","country","state","city","zip","venue","closestore"],"title":"","nomobile":"0","name":"estore.browse-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","simplegrid","pinboard","map"],"openViewType":"simplegrid","category_id":"","show_criteria":["title","listdescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","verifiedLabel"],"pagging":"auto_load","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"100","width":"100","dummy17":null,"limit_data_simplegrid":"16","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"270","width_simplegrid":"290","dummy20":null,"limit_data_pinboard":"16","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"290","dummy21":null,"limit_data_map":"10","title":"","nomobile":"0","name":"estore.browse-stores"}',
  ));
}

//SES - Store Featured Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_featured')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_featured',
      'displayname' => 'SES - Stores Marketplace - Stores Featured Page',
      'title' => 'Store Featured',
      'description' => 'This page lists stores.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["featured"],"default_search_type":"featured","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchStoreTitle","view","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closestore"],"hide_option":["alphabet","Categories","location","miles","country","state","city","zip","venue","closestore"],"title":"","nomobile":"0","name":"estore.browse-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","simplegrid","pinboard","map"],"openViewType":"simplegrid","category_id":"","show_criteria":["title","listdescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","verifiedLabel"],"pagging":"pagging","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"60","height":"100","width":"100","dummy17":null,"limit_data_simplegrid":"16","simplegrid_title_truncation":"45","simplegrid_description_truncation":"60","height_simplegrid":"220","width_simplegrid":"290","dummy20":null,"limit_data_pinboard":"16","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"290","dummy21":null,"limit_data_map":"20","title":"","nomobile":"0","name":"estore.browse-stores"}',
  ));
}

//SES - Store Sponsored Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_sponsored')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_sponsored',
      'displayname' => 'SES - Stores Marketplace - Stores Sponsored  Page',
      'title' => 'Store Sponsored ',
      'description' => 'This page lists stores.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["sponsored"],"default_search_type":"sponsored","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchStoreTitle","view","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closestore"],"hide_option":["alphabet","Categories","location","miles","country","state","city","zip","venue","closestore"],"title":"","nomobile":"0","name":"estore.browse-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","simplegrid","pinboard","map"],"openViewType":"simplegrid","category_id":"","show_criteria":["title","listdescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","sponsoredLabel","verifiedLabel"],"pagging":"pagging","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"60","height":"100","width":"100","dummy17":null,"limit_data_simplegrid":"16","simplegrid_title_truncation":"45","simplegrid_description_truncation":"60","height_simplegrid":"210","width_simplegrid":"290","dummy20":null,"limit_data_pinboard":"16","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"290","dummy21":null,"limit_data_map":"20","title":"","nomobile":"0","name":"estore.browse-stores"}',
  ));
}
//SES - Store Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_hot')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_hot',
      'displayname' => 'SES - Stores Marketplace - Stores Hot Page',
      'title' => 'Store Hot ',
      'description' => 'This page lists stores.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["hot"],"default_search_type":"hot","criteria":["0"],"default_view_search_type":"0","show_option":["searchStoreTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closestore"],"hide_option":["alphabet","Categories","location","miles","country","state","city","zip","venue","closestore"],"title":"","nomobile":"0","name":"estore.browse-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","simplegrid","pinboard","map"],"openViewType":"list","category_id":"","show_criteria":["title","listdescription","simplegriddescription","pinboarddescription","by","creationDate","category","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","member","statusLabel","verifiedLabel","hotLabel"],"pagging":"auto_load","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy15":null,"limit_data_list":"10","list_title_truncation":"45","list_description_truncation":"45","height":"100","width":"100","dummy17":null,"limit_data_simplegrid":"16","simplegrid_title_truncation":"45","simplegrid_description_truncation":"45","height_simplegrid":"270","width_simplegrid":"290","dummy20":null,"limit_data_pinboard":"16","pinboard_title_truncation":"45","pinboard_description_truncation":"45","width_pinboard":"290","height_pinboard":"300","dummy21":null,"limit_data_map":"10","title":"","nomobile":"0","name":"estore.browse-stores"}',
  ));
}

//SES - Store Browse Page
$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_index_localpick')
        ->limit(1)
        ->query()
        ->fetchColumn();

// insert if it doesn't exist yet
if (!$pageId) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_index_localpick',
      'displayname' => 'SES - Stores Marketplace - Stores Local Picks Page',
      'title' => 'Store Local Picks',
      'description' => 'This page lists stores.',
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
      'name' => 'estore.browse-menu',
      'page_id' => $pageId,
      'parent_content_id' => $topMiddleId,
      'order' => $widgetOrder++,
  ));
// Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-category-icons',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"titleC":"","criteria":"most_store","show_criteria":["title"],"alignContent":"center","viewType":"image","shapeType":"circle","show_bg_color":"1","bgColor":"#FFFFFF","height":"130","width":"130","limit_data":"10","title":"","nomobile":"0","name":"estore.store-category-icons"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-search',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"mostSPliked","criteria":["0"],"default_view_search_type":"0","show_option":["searchStoreTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","venue","closestore"],"hide_option":"","title":"","nomobile":"0","name":"estore.browse-search"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.store-alphabet',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":["list","advlist","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel"],"pagging":"pagging","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"60","height":"200","width":"310","dummy16":null,"limit_data_advlist":"5","advlist_title_truncation":"45","advlist_description_truncation":"70","height_advlist":"250","width_advlist":"310","dummy17":null,"limit_data_grid":"10","grid_title_truncation":"45","grid_description_truncation":"60","height_grid":"250","width_grid":"310","dummy18":null,"limit_data_simplegrid":"10","simplegrid_title_truncation":"45","simplegrid_description_truncation":"60","height_simplegrid":"250","width_simplegrid":"260","dummy19":null,"limit_data_advgrid":"10","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"250","width_advgrid":"295","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"10","title":"","nomobile":"0","name":"estore.browse-stores"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.featured-sponsored-verified-hot-slideshow',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"category":"","criteria":"6","info":"creation_date","isfullwidth":"0","autoplay":"1","speed":"2000","navigation":"nextprev","show_criteria":["title","description"],"title_truncation":"45","description_truncation":"55","height":"200","limit_data":"5","title":"Verified Stores","nomobile":"0","name":"estore.featured-sponsored-verified-hot-slideshow"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.you-may-also-like-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Sponsored Stores","viewType":"listView","category":"","information":["title","by","category","socialSharing","contactButton","followButton","member","sponsoredLabel"],"title_truncation":"45","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","height":"80","width":"79","limit_data":"3","nomobile":"0","name":"estore.you-may-also-like-stores"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.tag-cloud-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"color":"#fa0a0a","type":"cloud","text_height":"20","height":"200","itemCountPerPage":"10","title":"","nomobile":"0","name":"estore.tag-cloud-stores"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.you-may-also-like-stores',
      'page_id' => $pageId,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Featured Stores","viewType":"listView","category_id":"","information":["title","by","ownerPhoto","likeButton","favouriteButton","followButton","joinButton","like","comment","featuredLabel"],"title_truncation":"45","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","height":"80","width":"80","limit_data":"3","nomobile":"0","name":"estore.you-may-also-like-stores"}',
  ));
}

//Album Home Store
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_album_home')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_album_home',
      'displayname' => 'SES - Stores Marketplace - Albums Home Page',
      'title' => 'Albums Home Store',
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
      'name' => 'estore.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"view_count","showdefaultalbum":"0","insideOutside":"inside","fixHover":"hover","show_criteria":["storename","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"160","width":"180","limit_data":"3","title":"Most Viewed Albums","nomobile":"0","name":"estore.popular-albums"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"like_count","insideOutside":"outside","fixHover":"hover","show_criteria":["like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"160","width":"180","limit_data":"3","title":"Most Liked Albums","nomobile":"0","name":"estore.popular-albums"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"like_count","showdefaultalbum":"1","insideOutside":"inside","fixHover":"hover","show_criteria":["storename","featured","sponsored","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"1","title_truncation":"20","height":"162","width":"180","limit_data":"2","title":"Most Commented Albums","nomobile":"0","name":"estore.popular-albums"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.album-tabbed-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"tab_option":"advance","showdefaultalbum":"1","insideOutside":"inside","fixHover":"hover","show_criteria":["storeName","featured","sponsored","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"1","show_item_count":"1","limit_data":"15","show_limited_data":"0","pagging":"button","title_truncation":"20","height":"210","width":"250","search_type":["recentlySPcreated","mostSPviewed","mostSPfavourite","mostSPliked","mostSPcommented","featured","sponsored"],"dummy1":null,"recentlySPcreated_order":"9","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"8","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy5":null,"mostSPliked_order":"4","mostSPliked_label":"Most Liked","dummy6":null,"mostSPcommented_order":"7","mostSPcommented_label":"Most Commented","dummy7":null,"featured_order":"5","featured_label":"Featured","dummy8":null,"sponsored_order":"6","sponsored_label":"Sponsored","title":"Popular Albums","nomobile":"0","name":"estore.album-tabbed-widget"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.album-home-error',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"itemType":"album","title":"","nomobile":"0","name":"estore.album-home-error"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"creation_date","showdefaultalbum":"0","insideOutside":"outside","fixHover":"fix","show_criteria":["storename","featured","sponsored","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"45","height":"220","width":"216","limit_data":"6","title":"","nomobile":"0","name":"estore.popular-albums"}',
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-album-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite"],"default_search_type":"recentlySPcreated","friend_show":"no","search_title":"yes","browse_by":"no","title":"","nomobile":"0","name":"estore.browse-album-search"}',
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"favourite_count","showdefaultalbum":"0","insideOutside":"outside","fixHover":"hover","show_criteria":["storename","comment","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"155","width":"180","limit_data":"3","title":"Most Favourite Album","nomobile":"0","name":"estore.popular-albums"}'
  ));
// Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"comment_count","insideOutside":"outside","fixHover":"hover","show_criteria":["like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"2","title_truncation":"20","height":"151","width":"180","limit_data":"3","title":"Most Commented Albums","nomobile":"0","name":"estore.popular-albums"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.recently-viewed-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"criteria":"on_site","showdefaultalbum":"0","insideOutside":"outside","fixHover":"hover","show_criteria":["storesname","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"20","height":"150","width":"180","limit_data":"2","title":"Recently Viewed Albums","nomobile":"0","name":"estore.recently-viewed-albums"}',
  ));
}

//Album Browse Store
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_album_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$page_id) {
  $widgetOrder = 1;
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_album_browse',
      'displayname' => 'SES - Stores Marketplace - Browse Albums Page',
      'title' => 'Browse Albums Store',
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
      'name' => 'estore.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));
// Insert search
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"showdefaultalbum":"1","load_content":"button","sort":null,"view_type":"2","insideOutside":"inside","fixHover":"fix","show_criteria":["storename","like","featured","sponsored","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"20","height":"200","width":"236","title":"Browse Albums","nomobile":"0","name":"estore.browse-albums"}'
  ));
// Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.browse-album-search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","featured","sponsored"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","title":"","nomobile":"0","name":"estore.browse-album-search"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"view_count","showdefaultalbum":"0","insideOutside":"inside","fixHover":"hover","show_criteria":["storename","like","comment","view","title","by","socialSharing","favouriteCount","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"1","title_truncation":"45","height":"250","width":"250","limit_data":"3","title":"Most Viewed Albums","nomobile":"0","name":"estore.popular-albums"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.popular-albums',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"info":"favourite_count","insideOutside":"inside","fixHover":"hover","show_criteria":["title","socialSharing","favouriteCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","view_type":"1","title_truncation":"45","height":"150","width":"180","limit_data":"3","title":"Most Favourite Albums","nomobile":"0","name":"estore.popular-albums"}'
  ));
}


//Store Album View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_album_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_album_view',
      'displayname' => 'SES - Stores Marketplace - Album View Page',
      'title' => 'Album View Page',
      'description' => 'This page displays an album.',
      'provides' => 'subject=estore_album',
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
      'name' => 'estore.photo-album-view-breadcrumb',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 3,
      'params' => ''
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.album-view-page',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 4,
      'params' => '{"view_type":"pinboard","insideOutside":"inside","fixHover":"hover","show_criteria":["featured","sponsored","like","comment","view","title","by","socialSharing","likeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","limit_data":"6","pagging":"button","title_truncation":"45","height":"250","width":"300","title":"Album options","nomobile":"0","name":"estore.album-view-page"}'
  ));
}

//Photo View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'estore_photo_view')
        ->limit(1)
        ->query()
        ->fetchColumn();

if (!$page_id) {
// Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'estore_photo_view',
      'displayname' => 'SES - Stores Marketplace - Photo View Page',
      'title' => 'Album Photo View',
      'description' => 'This page displays an album\'s photo.',
      'provides' => 'subject=estore_photo',
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
      'name' => 'estore.photo-view-breadcrumb',
      'page_id' => $page_id,
      'parent_content_id' => $middle_id,
      'order' => 3,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'estore.photo-view-page',
      'page_id' => $page_id,
      'parent_content_id' => $middle_id,
      'order' => 4,
      'params' => '{"criteria":"1","maxHeight":"550","title":"","nomobile":"0","name":"estore.photo-view-page"}'
  ));
}


//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Estore_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('stores', $level->level_id, array_keys($form->getValues()));

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
    $permissionsTable->setAllowed('stores', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}


$db->query('DROP TABLE IF EXISTS `engine4_estore_claims` ;');
$db->query('CREATE TABLE `engine4_estore_claims` (
  `claim_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `contact_number` varchar(128) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `creation_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL default "0",
  PRIMARY KEY (`claim_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("estore_main_claim", "estore", "Claim For Store", "Estore_Plugin_Menus::canClaimEstores", \'{"route":"estore_general","action":"claim"}\', "estore_main", "", 5),
("estore_admin_main_claim", "estore", "Claim Requests", "", \'{"route":"admin_default","module":"estore","controller":"manage", "action":"claim"}\', "estore_admin_main", "", 6);');

$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
("sesuser_claim_store", "estore", \'{item:$subject} has claimed your store {item:$object}.\', 0, ""),
("sesuser_claimadmin_store", "estore", \'{item:$subject} has claimed a store {item:$object}.\', 0, ""),
("estore_claim_approve", "estore", \'Site admin has approved your claim request for the store: {item:$object}.\', 0, ""),
("estore_claim_declined", "estore", \'Site admin has rejected your claim request for the store: {item:$object}.\', 0, ""),
("estore_owner_informed", "estore", \'Site admin has been approved claim for your store: {item:$object}.\', 0, "");');

$db->query('INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
("estore_store_owner_approve", "estore", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]");');

//New Claims Store
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'estore_index_claim')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'estore_index_claim',
    'displayname' => 'SES - Stores Marketplace - New Claims Store',
    'title' => 'Store Claim',
    'description' => 'This page lists store entries.',
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
    'name' => 'estore.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'estore.claim-store',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' =>'{"title":"","name":"estore.claim-store"}',
  ));
}

//Browse Claim Requests Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'estore_index_claim-requests')
              ->limit(1)
              ->query()
              ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'estore_index_claim-requests',
    'displayname' => 'SES - Stores Marketplace - Browse Claim Requests Page',
    'title' => 'Store Claim Requests',
    'description' => 'This page lists store claims request entries.',
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
    'name' => 'estore.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'estore.claim-requests',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","name":"estore.claim-requests"}',
  ));
}

//Review View Page
$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'estore_review_view')
    ->limit(1)
    ->query()
    ->fetchColumn();
if (!$page_id) {
    $widgetOrder = 1;
    $db->insert('engine4_core_pages', array(
        'name' => 'estore_review_view',
        'displayname' => 'SES - Stores Marketplace - Review View Page',
        'title' => 'Store Review View',
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
        'name' => 'estore.breadcrumb',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'estore.review-owner-photo',
        'parent_content_id' => $main_left_id,
        'params' => '{"title":"","showTitle":"1","photo_view_type":"circle","height":"400","width":"400","nomobile":"0","name":"estore.review-owner-photo"}',
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'estore.review-profile-options',
        'parent_content_id' => $main_left_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Profile ","name":"estore.review-profile-options"}',
    ));

//     $db->insert('engine4_core_content', array(
//         'page_id' => $page_id,
//         'type' => 'widget',
//         'name' => 'estore.profile-review',
//         'parent_content_id' => $main_middle_id,
//         'order' => $widgetOrder++,
//         'params' => '{"stats":["likeCount","commentCount","viewCount","title","pros","cons","description","recommended","postedin","creationDate","parameter","rating"],"title":"","nomobile":"0","name":"estore.profile-review"}',
//     ));

    $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'core.comments',
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
        'params' => '{"title":"Comments"}',
    ));
}


$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES ("estore_follow_category", "estore", \'A new store {item:$object} has been created in {var:$category_title} category that you are Following.\', 0, "");');

$db->query('INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
("notify_estore_follow_category", "estore", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]");');

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
  ('help',''),
  ('activity',''),
  ('updates',''),
  ('messages',''),
  ('admin',''),
  ('user',''),
  ('members',''),
  ('wall',''),
  ('chat',''),
  ('about-us',''),
  ('stats',''),
  ('files',''),
  ('ads',''),
  ('invite',''),
  ('events',''),
  ('album',''),
  ('albums',''),
  ('classifieds',''),
  ('classified',''),
  ('content',''),
  ('forums',''),
  ('stores',''),
  ('stores',''),
  ('blog',''),
  ('blogs',''),
  ('poll',''),
  ('polls',''),
  ('music',''),
  ('musics',''),
  ('video',''),
  ('videos',''),
  ('subscribes',''),
  ('tag',''),
  ('tags',''),
  ('tasks',''),
  ('profile',''),
  ('vote',''),
  ('core',''),
  ('fields',''),
  ('network',''),
  ('payment',''),
  ('sesactivitypoints',''),
  ('sesadvancedactivity',''),
  ('sesadvancedbanner',''),
  ('sesadvancedcomment',''),
  ('sesadvancedheader',''),
  ('sesadvminimenu',''),
  ('sesadvsitenotification',''),
  ('sesalbum',''),
  ('sesandroidapp',''),
  ('sesannouncement',''),
  ('sesapi',''),
  ('sesariana',''),
  ('sesarticle',''),
  ('sesblog',''),
  ('sesblogpackage',''),
  ('sesbody',''),
  ('sesbrowserpush',''),
  ('seschristmas',''),
  ('sescleanwide',''),
  ('sescommunityads',''),
  ('sescompany',''),
  ('sescontactus',''),
  ('sescontentcoverphoto',''),
  ('sescontest',''),
  ('sescontestjoinfees',''),
  ('sescontestjurymember',''),
  ('sescontestpackage',''),
  ('seselegant',''),
  ('sesemoji',''),
  ('seserror',''),
  ('sesevent',''),
  ('seseventcontact',''),
  ('seseventmusic',''),
  ('seseventpdfticket',''),
  ('seseventreview',''),
  ('seseventspeaker',''),
  ('seseventsponsorship',''),
  ('seseventticket',''),
  ('seseventvideo',''),
  ('sesexpose',''),
  ('sesfaq',''),
  ('sesfbstyle',''),
  ('sesfeedbg',''),
  ('sesfeedgif',''),
  ('sesfeelingactivity',''),
  ('sesfooter',''),
  ('sesgdpr',''),
  ('seshtmlbackground',''),
  ('seshtmlblock',''),
  ('seslangtranslator',''),
  ('sesletteravatar',''),
  ('seslink',''),
  ('sesmaterial',''),
  ('sesmember',''),
  ('sesmembershorturl',''),
  ('sesmetatag',''),
  ('sesminify',''),
  ('sesmultiplecurrency',''),
  ('sesmultipleform',''),
  ('sesmusic',''),
  ('estore',''),
  ('estorebuilder',''),
  ('estoreurl',''),
  ('sespoke',''),
  ('sesprayer',''),
  ('sesprofilelock',''),
  ('sesrecipe',''),
  ('sessiteiframe',''),
  ('sessociallogin',''),
  ('sessocialshare',''),
  ('sessocialtube',''),
  ('sesspectromedia',''),
  ('sestour',''),
  ('sestweet',''),
  ('sesusercoverphoto',''),
  ('sesusercovervideo',''),
  ('sesvideo',''),
  ('chanels',''),
  ('quotes',''),
  ('quote',''),
  ('prayers',''),
  ('prayer',''),
  ('page-directories',''),
  ('page-directory',''),
  ('store-directories',''),
  ('store-directory',''),
  ('browse-review',''),
  ('privacy-center',''),
  ('faqs',''),
  ('faq',''),
  ('events',''),
  ('eventmusics',''),
  ('eventmusic',''),
  ('comingsoon',''),
  ('contestpackage',''),
  ('contestpayment',''),
  ('contests',''),
  ('contest',''),
  ('wishes',''),
  ('friend-wishes',''),
  ('welcome',''),
  ('Sesblogs',''),
  ('blog-album',''),
  ('Sesarticles',''),
  ('article-album',''),
  ('articles',''),
  ('comment-like',''),
  ('comment',''),
  ('comments',''),
  ('app-default-data',''),
  ('stickers',''),
  ('feelings',''),
  ('onthisday',''),
  ('storage',''),
  ('page',''),
  ('stores',''),
  ('job-posting',''),
  ('level',''),
  ('likes',''),
  ('list',''),
  ('listing',''),
  ('listingitem',''),
  ('listingitems',''),
  ('listings',''),
  ('product',''),
  ('product-videos',''),
  ('sesproducts',''),
  ('market',''),
  ('media-importer',''),
  ('member',''),
  ('memberlevel',''),
  ('members-details',''),
  ('hashtag',''),
  ('hecore',''),
  ('hecore-friend',''),
  ('hecore-module',''),
  ('newsfeed',''),
  ('pdf',''),
  ('photo',''),
  ('points',''),
  ('pokes',''),
  ('profiletype',''),
  ('project',''),
  ('projects',''),
  ('qp',''),
  ('question',''),
  ('questions',''),
  ('radcodes',''),
  ('whcore',''),
  ('rss',''),
  ('sesbasic',''),
  ('settings',''),
  ('recipe',''),
  ('recipeitems',''),
  ('review-videos',''),
  ('reviews',''),
  ('xml',''),
  ('slideshow',''),
  ('writings','');");
}

//Product Contributors depadent on Advanced Members Plugin
$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sesproduct_main_contributors", "sesproduct", "Browse Contributors", "Sesproduct_Plugin_Menus::canProductsContributors", \'{"route":"sesproduct_general","action":"contributors"}\', "sesproduct_main", "", 6);');

//Browse Product Contributors Page
$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesproduct_index_contributors')
    ->limit(1)
    ->query()
    ->fetchColumn();
if( !$page_id ) {
    $widgetOrder = 1;
    $db->insert('engine4_core_pages', array(
    'name' => 'sesproduct_index_contributors',
    'displayname' => 'SES - Stores Marketplace - Products - Browse Product Contributors Page',
    'title' => 'Browse Product Contributors',
    'description' => 'This page show all product contributors of your site.',
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
    'name' => 'sesmember.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPrated","featured","sponsored","verified"],"view":["0","1","3","week","month"],"default_search_type":"creation_date ASC","show_advanced_search":"1","network":"yes","alphabet":"yes","friend_show":"yes","search_title":"yes","browse_by":"yes","location":"yes","kilometer_miles":"yes","country":"yes","state":"yes","city":"yes","zip":"yes","member_type":"yes","has_photo":"yes","is_online":"yes","is_vip":"yes","title":"","nomobile":"0","name":"sesmember.browse-search"}'
    ));

    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-members',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","advlist","grid","advgrid","pinboard","map"],"openViewType":"advlist","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","vipLabel","message","friendButton","followButton","likeButton","likemainButton","socialSharing","like","location","rating","view","title","friendCount","mutualFriendCount","profileType","age","profileField","heading","labelBold","pinboardSlideshow"],"limit_data":"12","profileFieldCount":"5","pagging":"button","order":"mostSPviewed","show_item_count":"1","list_title_truncation":"45","grid_title_truncation":"45","advgrid_title_truncation":"45","pinboard_title_truncation":"45","main_height":"350","main_width":"585","height":"200","width":"250","photo_height":"250","photo_width":"284","info_height":"315","advgrid_height":"322","advgrid_width":"382","pinboard_width":"350","title":"","nomobile":"0","name":"sesmember.browse-members"}',
    ));
}


    //Compare Product Page
    $page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesproduct_index_compare')
        ->limit(1)
        ->query()
        ->fetchColumn();
    if( !$page_id ) {
        $widgetOrder = 1;
        $db->insert('engine4_core_pages', array(
            'name' => 'sesproduct_index_compare',
            'displayname' => 'SES - Stores Marketplace - Compare Product Page',
            'title' => 'Compare Product Page',
            'description' => 'This page show product compare product on site.',
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
            'name' => 'sesproduct.product-compare',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
        ));
    }


//Cart View Page
  $page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesproduct_cart_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
    if(!$page_id ) {
        $widgetOrder = 1;
        $db->insert('engine4_core_pages', array(
            'name' => 'sesproduct_cart_index',
            'displayname' => 'SES - Stores Marketplace - Cart Manage Page',
            'title' => 'Cart Manage Page',
            'description' => 'This page show product added in cart on your website.',
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
            'order' => 6,
        ));
        $top_middle_id = $db->lastInsertId();

        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $main_id,
            'order' => 6,
        ));
        $main_middle_id = $db->lastInsertId();

        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'right',
            'page_id' => $page_id,
            'parent_content_id' => $main_id,
            'order' => 5,
        ));
        $main_right_id = $db->lastInsertId();

        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'estore.browse-menu',
            'page_id' => $page_id,
            'parent_content_id' => $top_middle_id,
            'order' => $widgetOrder++,
        ));

        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesproduct.my-cart',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
        ));

        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesproduct.of-the-day',
            'page_id' => $page_id,
            'parent_content_id' => $main_right_id,
            'order' => $widgetOrder++,
            'params' => '{"viewType":"grid1","show_criteria":["title","like","view","comment","favourite","rating","featuredLabel","verifiedLabel","socialSharing","productDesc","brand","offre","category","addCart","price","discount","addCompare","addWishlist","stock","storeNamePhoto"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"60","height":"180","width":"180","title":"Product of the Day","nomobile":"0","name":"sesproduct.of-the-day"}',
        ));
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesproduct.featured-sponsored',
            'page_id' => $page_id,
            'parent_content_id' => $main_right_id,
            'order' => $widgetOrder++,
            'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"recently_created","show_criteria":["like","comment","favourite","view","title","category"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","show_star":"0","showLimitData":"1","title_truncation":"45","description_truncation":"60","height":"50","width":"50","limit_data":"3","title":"Popular Products","nomobile":"0","name":"sesproduct.featured-sponsored"}',
        ));
    }




    //Cart Checkout Page
    $page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesproduct_cart_checkout')
        ->limit(1)
        ->query()
        ->fetchColumn();
    if( !$page_id ) {
        $widgetOrder = 1;
        $db->insert('engine4_core_pages', array(
            'name' => 'sesproduct_cart_checkout',
            'displayname' => 'SES - Stores Marketplace - Cart Checkout Page',
            'title' => 'Cart Checkout Page',
            'description' => 'This page show product checkout page on your website.',
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
            'name' => 'sesproduct.product-checkout',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
        ));

        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesproduct.cross-sell-products',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
            'params' => '{"show_criteria":["price","discount","stock","storeName","addCart","addWishlist","addCompare","brand","offre","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","ratingStar","rating","view","title","category","by","readmore","creationDate","location","description","enableCommentPinboard"],"socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","show_item_count":"1","title_truncation_grid":"45","height_grid":"270","width_grid":"389","limit_data_grid":"20","show_sale":"1","title":"Best buy","nomobile":"0","name":"sesproduct.cross-sell-products"}',
        ));
    }
    $select = new Zend_Db_Select($db);
    // profile page
    $select
      ->from('engine4_core_pages')
      ->where('name = ?', 'user_profile_index')
      ->limit(1);
    $page_id = $select->query()->fetchObject()->page_id;
    // Check if it's already been placed
    $select = new Zend_Db_Select($db);
    $select
      ->from('engine4_core_content')
      ->where('page_id = ?', $page_id)
      ->where('type = ?', 'widget')
      ->where('name = ?', 'sesproduct.profile-sesproducts')
      ;
    $info = $select->query()->fetch();
    if( empty($info) ) {

      // container_id (will always be there)
      $select = new Zend_Db_Select($db);
      $select
        ->from('engine4_core_content')
        ->where('page_id = ?', $page_id)
        ->where('type = ?', 'container')
        ->limit(1);
      $container_id = $select->query()->fetchObject()->content_id;

      // middle_id (will always be there)
      $select = new Zend_Db_Select($db);
      $select
        ->from('engine4_core_content')
        ->where('parent_content_id = ?', $container_id)
        ->where('type = ?', 'container')
        ->where('name = ?', 'middle')
        ->limit(1);
      $middle_id = $select->query()->fetchObject()->content_id;

      // tab_id (tab container) may not always be there
      $select
        ->reset('where')
        ->where('type = ?', 'widget')
        ->where('name = ?', 'core.container-tabs')
        ->where('page_id = ?', $page_id)
        ->limit(1);
      $tab_id = $select->query()->fetchObject();
      if( $tab_id && @$tab_id->content_id ) {
          $tab_id = $tab_id->content_id;
      } else {
        $tab_id = null;
      }

      // tab on profile
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type'    => 'widget',
        'name'    => 'sesproduct.profile-sesproducts',
        'parent_content_id' => ($tab_id ? $tab_id : $middle_id),
        'order'   => 6,
        'params'  => '{"title":"Sesproducts","titleCount":true}',
      ));
    }