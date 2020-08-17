<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Installer extends Engine_Package_Installer_Module {

  public function onInstall() {
    $db = $this->getDb();

    //Group Profile Page - 1
		$page_id = $db->select()
                  ->from('engine4_core_pages', 'page_id')
                  ->where('name = ?', 'sesgroup_profile_index_1')
                  ->limit(1)
                  ->query()
                  ->fetchColumn();
    $tab_id = $db->select()
              ->where('type = ?', 'widget')
              ->from('engine4_core_content', 'content_id')
              ->where('name = ?', 'core.container-tabs')
              ->where('page_id = ?', $page_id)
              ->limit(1) 
              ->query()
              ->fetchColumn();
    if ($page_id){
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesgroupforum.forum-view',
        'page_id' => $page_id,
        'parent_content_id' => $tab_id,
        'order' => 11,
        'params' => '{"moderators":"1","show_criteria":["ownerName","ownerPhoto","likeCount","ratings","tags","showDatetime","viewCount","replyCount","latestPostDetails","postTopicButton"],"show_data":"1","load_content":"button","limit_data":"10","title":"Topics","nomobile":"0","name":"sesgroupforum.forum-view"}',
      ));
    }
    
    //Group Profile Page - 2
		$page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'sesgroup_profile_index_2')
                ->limit(1)
                ->query()
                ->fetchColumn();
    $tab_id =  $db->select()
            ->where('type = ?', 'widget')
            ->from('engine4_core_content', 'content_id')
            ->where('name = ?', 'core.container-tabs')
            ->where('page_id = ?', $page_id)
            ->limit(1) 
            ->query()
            ->fetchColumn();
    if ($page_id) {
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesgroupforum.forum-view',
        'page_id' => $page_id,
        'parent_content_id' => $tab_id,
        'order' => 11,
        'params' => '{"moderators":"1","show_criteria":["ownerName","ownerPhoto","likeCount","ratings","tags","showDatetime","viewCount","replyCount","latestPostDetails","postTopicButton"],"show_data":"1","load_content":"button","limit_data":"10","title":"Topics","nomobile":"0","name":"sesgroupforum.forum-view"}',
      ));
    }
    
    //Group Profile Page - 3
		$page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sesgroup_profile_index_3')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
    $tab_id = $db->select()
              ->where('type = ?', 'widget')
              ->from('engine4_core_content', 'content_id')
              ->where('name = ?', 'core.container-tabs')
              ->where('page_id = ?', $page_id)
              ->limit(1) 
              ->query()
              ->fetchColumn();
    if ($page_id){
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesgroupforum.forum-view',
        'page_id' => $page_id,
        'parent_content_id' => $tab_id,
        'order' => 11,
        'params' => '{"moderators":"1","show_criteria":["ownerName","ownerPhoto","likeCount","ratings","tags","showDatetime","viewCount","replyCount","latestPostDetails","postTopicButton"],"show_data":"1","load_content":"button","limit_data":"10","title":"Topics","nomobile":"0","name":"sesgroupforum.forum-view"}',
      ));
    }
    
    //Group Profile Page - 4
		$page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'sesgroup_profile_index_4')
                ->limit(1)
                ->query()
                ->fetchColumn();
    $tab_id = $db->select()
              ->where('type = ?', 'widget')
              ->from('engine4_core_content', 'content_id')
              ->where('name = ?', 'core.container-tabs')
              ->where('page_id = ?', $page_id)
              ->limit(1) 
              ->query()
              ->fetchColumn();
    if ($page_id) {
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesgroupforum.forum-view',
        'page_id' => $page_id,
        'parent_content_id' => $tab_id,
        'order' => 11,
        'params' => '{"moderators":"1","show_criteria":["ownerName","ownerPhoto","likeCount","ratings","tags","showDatetime","viewCount","replyCount","latestPostDetails","postTopicButton"],"show_data":"1","load_content":"button","limit_data":"10","title":"Topics","nomobile":"0","name":"sesgroupforum.forum-view"}',
      ));
    }

    //Topic View Page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesgroupforum_topic_view')
      ->limit(1)
      ->query()
      ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesgroupforum_topic_view',
        'displayname' => 'SES - Advanced Forums - Topic View Page',
        'title' => 'Topic View',
        'description' => 'This is the view topic page.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();

      // Insert main
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
      ));
      $main_id = $db->lastInsertId();

      // Insert middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
      ));
      $middle_id = $db->lastInsertId();

      // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesgroupforum.topic-view',
        'params'=>'{"show_criteria":["likeCount","replyCount","ratings","postReply","shareButton","backToTopicButton","likeButton","quote","signature"],"show_details":["thanksCount","reputationCount","postsCount"],"tags":"1","limit_data":"5","title":"","nomobile":"0","name":"sesgroupforum.topic-view"}',
        'page_id' => $page_id,
        'parent_content_id' => $middle_id,
      ));
    }  else {
        $contentId = $db->select()
      ->from('engine4_core_content', 'content_id')
      ->where('page_id = ?', $page_id)
      ->where('name = ?','core.content')
      ->limit(1)
      ->query()
      ->fetchColumn();
      if($contentId) {
        $db->update('engine4_core_content', array('name' => 'sesgroupforum.topic-view','params'=>'{"show_criteria":["likeCount","replyCount","ratings","postReply","shareButton","backToTopicButton","likeButton","quote","signature"],"show_details":["thanksCount","reputationCount","postsCount"],"tags":"1","limit_data":"5","title":"","nomobile":"0","name":"sesgroupforum.topic-view"}'), array('content_id =?' => $contentId));
      }
    }
    
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesgroupforum_forum_topic-create')
      ->limit(1)
      ->query()
      ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesgroupforum_forum_topic-create',
        'displayname' => 'SES - Advanced Forums - Topic Create Page',
        'title' => 'Post Topic',
        'description' => 'This is the sesgroupforum topic create page.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();

      // Insert main
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
      ));
      $main_id = $db->lastInsertId();

      // Insert middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
      ));
      $middle_id = $db->lastInsertId();

      // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesgroup.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $middle_id,
      ));
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $middle_id,
      ));
    }

    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesgroupforum_post_edit')
      ->limit(1)
      ->query()
      ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesgroupforum_post_edit',
        'displayname' => 'SES - Advanced Forums - Post Edit Page',
        'title' => 'Post Edit Page',
        'description' => 'This is the post edit page.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();

      // Insert main
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
      ));
      $main_id = $db->lastInsertId();

      // Insert middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
      ));
      $middle_id = $db->lastInsertId();
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesgroup.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $middle_id,
      ));
      // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $middle_id,
      ));
    }
    parent::onInstall();
  }
}
