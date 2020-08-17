<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinviter
 * @package    Sesinviter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2017-05-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesinviter_index_invite')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
    $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sesinviter_index_invite',
      'displayname' => 'SES - Inviter - Invite Page',
      'title' => 'Invite Page',
      'description' => 'This page is inviter page.',
      'custom' => 0,
      'layout' => 'default',
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
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();
    // Insert menu
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesinviter.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    ));
  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesinviter.invite',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
  ));
}

// Invite manage page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesinviter_index_manage')
    ->limit(1)
    ->query()
    ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesinviter_index_manage',
    'displayname' => 'SES - Inviter - Invite Manage Page',
    'title' => 'My Invites',
    'description' => 'This page lists a user\'s invite entries.',
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
    'name' => 'sesinviter.browse-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => $widgetOrder++,
    ));
    // Insert search
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesinviter.browse-search',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => $widgetOrder++,
    ));
    // Insert content
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.content',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => $widgetOrder++,
    ));
}

// Invite manage page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesinviter_index_manage-referrals')
    ->limit(1)
    ->query()
    ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sesinviter_index_manage-referrals',
        'displayname' => 'SES - Inviter - My Referrals Page',
        'title' => 'My Referrals',
        'description' => 'This page lists a user\'s referrals entries.',
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
        'name' => 'sesinviter.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => $widgetOrder++,
    ));
    // Insert search
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesinviter.manage-search',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => $widgetOrder++,
    ));
    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
    ));
}
