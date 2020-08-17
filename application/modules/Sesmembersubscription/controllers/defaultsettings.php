<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembersubscription
 * @package    Sesmembersubscription
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2017-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

    
// profile page for member subscription
$pageId = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesmembersubscription_profile_index')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesmembersubscription_profile_index',
    'displayname' => 'SES - Member Subscription - Member Profile Page',
    'title' => 'Member Profile',
    'description' => 'This is a member\'s profile.',
    'provides' => 'subject=user',
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

  // Insert gutter
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmembersubscription.subscribe-button',
    'page_id' => $pageId,
    'parent_content_id' => $leftId,
    'order' => 1,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'user.profile-photo',
    'page_id' => $pageId,
    'parent_content_id' => $leftId,
    'order' => 2,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'user.profile-info',
    'page_id' => $pageId,
    'parent_content_id' => $leftId,
    'order' => 3,
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'user.profile-status',
    'page_id' => $pageId,
    'parent_content_id' => $middleId,
    'order' => 1,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.content',
    'page_id' => $pageId,
    'parent_content_id' => $middleId,
    'order' => 2,
  ));
}