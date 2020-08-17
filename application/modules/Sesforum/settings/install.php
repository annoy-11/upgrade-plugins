<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Installer extends Engine_Package_Installer_Module
{
  public function onInstall()
  {
    $db = $this->getDb();
    $this->_addUserProfileContent();
    $this->_addSesforumViewPage();
    $select = $db->select()
                ->from('engine4_core_pages')
                ->where('name = ?', 'sesforum_index_index')
                ->limit(1);
    $info = $select->query()->fetch();
    if (empty($info)) {
        $widgetOrder = 1;
        $db->insert('engine4_core_pages', array(
            'name' => 'sesforum_index_index',
            'displayname' => 'SES - Advanced Forums - Forum Main Page',
            'title' => 'Forum Main',
            'description' => 'This is the main forum page.',
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
            'name' => 'sesforum.navigation',
            'parent_content_id' => $topmiddle_id,
            'order' => $widgetOrder++,
        ));
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesforum.forum-category',
            'params'=>'{"showcategory":"1","themecolor":"random","iconShape":"0","description_truncation_category":"70","description_truncation_post":"45","show_criteria":["topicCount","postCount","postDetails"],"showForum":"1","showTopics":"1","limit_data":"10","forum_limit_data":"5","topic_limit_data":"5","load_content":"auto_load","topic_load_content":"auto_load","forum_load_content":"auto_load","title":"","nomobile":"0","name":"sesforum.forum-category"}',
            'parent_content_id' => $middle_id,
            'order' => $widgetOrder++,
        ));
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesforum.popular-members',
            'parent_content_id' => $right_id,
            'order' => $widgetOrder++,
            'params' => '{"criteria":"topicCount","itemCountPerPage":"3","title":"Most Popular Members","nomobile":"0","name":"sesforum.popular-members"}',
        ));
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesforum.statistics',
            'parent_content_id' => $right_id,
            'order' => $widgetOrder++,
            'params' => '{"viewtype":"vertical","stats":["forumCount","topicCount","postCount","totaluserCount","activeusercount"],"title":"Forum Statistics","nomobile":"0","name":"sesforum.statistics"}',
        ));
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesforum.list-recent-topics',
            'parent_content_id' => $right_id,
            'order' => $widgetOrder++,
            'params' => '{"stats":["forumName","topicName","likeCount","by","postCount","viewCount","photo","rating","creationdate"],"itemCountPerPage":"3","descLimit":"64","title":"Most Recent Topics","nomobile":"0","name":"sesforum.list-recent-topics"}',
        ));
    } else {
        $contentId = $db->select()
      ->from('engine4_core_content', 'content_id')
      ->where('page_id = ?', $info['page_id'])
      ->where('name = ?','core.content')
      ->limit(1)
      ->query()
      ->fetchColumn();
      if($contentId){
        $db->update('engine4_core_content', array('name' => 'sesforum.forum-category','params'=>'{"showcategory":"1","themecolor":"random","iconShape":"0","description_truncation_category":"70","description_truncation_post":"45","show_criteria":["topicCount","postCount","postDetails"],"showForum":"1","showTopics":"1","limit_data":"10","forum_limit_data":"5","topic_limit_data":"5","load_content":"auto_load","topic_load_content":"auto_load","forum_load_content":"auto_load","title":"","nomobile":"0","name":"sesforum.forum-category"}'), array('content_id =?' => $contentId));
      }
    }
    //User Dashboard Page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesforum_index_dashboard')
      ->limit(1)
      ->query()
      ->fetchColumn();
    // insert if it doesn't exist yet
    if( !$page_id ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesforum_index_dashboard',
        'displayname' => 'SES - Advanced Forums - User Dashboard Page',
        'title' => 'User Dashboard Page',
        'description' => 'This is the user dashboard page.',
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
        'name' => 'sesforum.user-dashboard',
        'params'=> '{"show_criteria":["myTopics","myPosts","mySubscribedTopics","TopicsILiked","postsILiked","signature"],"limit_data":"5","load_content":"auto_load","title":"","nomobile":"0","name":"sesforum.user-dashboard"}',
        'page_id' => $page_id,
        'parent_content_id' => $middle_id,
      ));
    }  else {
        $contentId = $db->select()
      ->from('engine4_core_content', 'content_id')
      ->where('page_id = ?', $page_id)
      ->where('name = ?','sesforum.user-dashboard')
      ->limit(1)
      ->query()
      ->fetchColumn();
      if($contentId){
        $db->update('engine4_core_content', array('params'=>'{"show_criteria":["myTopics","myPosts","mySubscribedTopics","TopicsILiked","postsILiked","signature"],"limit_data":"5","load_content":"auto_load","title":"","nomobile":"0","name":"sesforum.user-dashboard"}'), array('content_id =?' => $contentId));
      }
    }
    //Search Page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesforum_index_search')
      ->limit(1)
      ->query()
      ->fetchColumn();
    // insert if it doesn't exist yet
    if( !$page_id ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesforum_index_search',
        'displayname' => 'SES - Advanced Forums - Topic Search Page',
        'title' => 'Topic Search Page',
        'description' => 'This is the topic search page.',
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
        'name' => 'sesforum.browse-search',
        'params'=>'{"title":"Search","name":"sesforum.browse-search"}',
        'page_id' => $page_id,
        'parent_content_id' => $middle_id,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesforum.browse-topics',
        'params'=>'{"title_truncation_limit":"45","description_truncation_limit":"45","load_content":"auto_load","limit_data":"5","title":"","nomobile":"0","name":"sesforum.browse-topics"}',
        'page_id' => $page_id,
        'parent_content_id' => $middle_id,
    ));
    } else {
        $contentId = $db->select()
      ->from('engine4_core_content', 'content_id')
      ->where('page_id = ?', $page_id)
      ->where('name = ?','sesforum.browse-topics')
      ->limit(1)
      ->query()
      ->fetchColumn();
      if($contentId){
        $db->update('engine4_core_content', array('params'=>'{"title_truncation_limit":"45","description_truncation_limit":"45","load_content":"auto_load","limit_data":"5","title":"","nomobile":"0","name":"sesforum.browse-topics"}'), array('content_id =?' => $contentId));
      }
    }

    //Topic View Page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesforum_topic_view')
      ->limit(1)
      ->query()
      ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesforum_topic_view',
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
        'name' => 'sesforum.topic-view',
        'params'=>'{"show_criteria":["likeCount","replyCount","ratings","postReply","shareButton","backToTopicButton","likeButton","quote","signature"],"show_details":["thanksCount","reputationCount","postsCount"],"tags":"1","limit_data":"5","title":"","nomobile":"0","name":"sesforum.topic-view"}',
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
        $db->update('engine4_core_content', array('name' => 'sesforum.topic-view','params'=>'{"show_criteria":["likeCount","replyCount","ratings","postReply","shareButton","backToTopicButton","likeButton","quote","signature"],"show_details":["thanksCount","reputationCount","postsCount"],"tags":"1","limit_data":"5","title":"","nomobile":"0","name":"sesforum.topic-view"}'), array('content_id =?' => $contentId));
      }
    }
    //Forum Category View Page
    $select = $db->select()
                ->from('engine4_core_pages')
                ->where('name = ?', 'sesforum_category_view')
                ->limit(1);
    $info = $select->query()->fetch();
    if (empty($info)) {
    $widgetOrder = 1;
    $db->insert('engine4_core_pages', array(
        'name' => 'sesforum_category_view',
        'displayname' => 'SES - Advanced Forums - Forum Category View Page',
        'title' => 'Forum Category View',
        'description' => 'This is theforum category view page.',
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
        'name' => 'sesforum.breadcrumb',
        'parent_content_id' => $topmiddle_id,
        'order' => $widgetOrder++,
    ));

    $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'sesforum.forum-category',
        'params'=>'{"viewType":"grid","show_subcat":"1","show_subcatcriteria":["icon","title","countArticle"],"heightSubcat":"160","widthSubcat":"290","textArticle":"Articles we like","show_criteria":["featuredLabel","sponsoredLabel","like","comment","rating","ratingStar","favourite","view","title","by","description","readmore","creationDate"],"pagging":"button","description_truncation":"150","article_limit":"12","height":"200","width":"294","title":"","nomobile":"0","name":"sesarticle.category-view"}',
        'parent_content_id' => $middle_id,
        'order' => $widgetOrder++,
    ));
    }  else {
        $contentId = $db->select()
      ->from('engine4_core_content', 'content_id')
      ->where('page_id = ?', $info['page_id'])
      ->where('name = ?','core.content')
      ->limit(1)
      ->query()
      ->fetchColumn();
      if($contentId) {
        $db->update('engine4_core_content', array('name' => 'sesforum.forum-category','params'=>'{"viewType":"grid","show_subcat":"1","show_subcatcriteria":["icon","title","countArticle"],"heightSubcat":"160","widthSubcat":"290","textArticle":"Articles we like","show_criteria":["featuredLabel","sponsoredLabel","like","comment","rating","ratingStar","favourite","view","title","by","description","readmore","creationDate"],"pagging":"button","description_truncation":"150","article_limit":"12","height":"200","width":"294","title":"","nomobile":"0","name":"sesarticle.category-view"}'), array('content_id =?' => $contentId));
      }
    }


   //Browse Tags Page
    $page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'sesforum_index_tags')
                ->limit(1)
                ->query()
                ->fetchColumn();
    if (!$page_id) {
        $widgetOrder = 1;
        // Insert page
        $db->insert('engine4_core_pages', array(
            'name' => 'sesforum_index_tags',
            'displayname' => 'SES - Advanced Forums - Browse Tags Page',
            'title' => 'Browse Tags Page',
            'description' => 'This page displays the Topic tags.',
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
        // Insert main-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $main_id,
            'order' => 6
        ));
        $main_middle_id = $db->lastInsertId();
        // Insert main-right
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'right',
            'page_id' => $page_id,
            'parent_content_id' => $main_id,
            'order' => 7,
        ));
        $main_right_id = $db->lastInsertId();

        // Insert content
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesforum.tag-topics',
            'params'=>'{"title":"Tags","name":"sesforum.tag-topics"}',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
        ));
    }

    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesforum_forum_topic-create')
      ->limit(1)
      ->query()
      ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesforum_forum_topic-create',
        'displayname' => 'SES - Advanced Forums - Topic Create Page',
        'title' => 'Post Topic',
        'description' => 'This is the sesforum topic create page.',
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
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $middle_id,
      ));
    }

     $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesforum_post_edit')
      ->limit(1)
      ->query()
      ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesforum_post_edit',
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
  protected function _addSesforumViewPage()
  {
    $db = $this->getDb();

    // check page
     //Forum Main Page
  $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesforum_forum_view')
      ->limit(1)
      ->query()
      ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
        $widgetOrder = 1;
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesforum_forum_view',
        'displayname' => 'SES - Advanced Forums - Forum View Page',
        'title' => 'Forum View',
        'description' => 'This is the view forum page.',
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

      // Insert middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'order' => 6,
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
      ));
      $middle_id = $db->lastInsertId();

    $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'container',
        'name' => 'left',
        'parent_content_id' => $main_id,
        'order' => 4,
        'params' => '',
    ));
    $left_id = $db->lastInsertId('engine4_core_content');

      // Insert content
     $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesforum.post-new-topic',
        'params'=>'{"title":"","name":"sesforum.post-new-topic"}',
        'page_id' => $page_id,
        'parent_content_id' => $left_id,
        'order' => 3,
        'order' => $widgetOrder++,
      ));

     $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesforum.tags',
        'params'=>'{"tags_count":"10","title":"Tags","nomobile":"0","name":"sesforum.tags"}',
        'page_id' => $page_id,
        'order' => 4,
        'parent_content_id' => $left_id,
        'order' => $widgetOrder++,
      ));

      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesforum.forum-view',
        'params'=>'{"moderators":"1","show_criteria":["ownerName","ownerPhoto","likeCount","ratings","tags","showDatetime","viewCount","replyCount","latestPostDetails","postTopicButton"],"show_data":"1","load_content":"auto_load","limit_data":"5","title":"Forum View","nomobile":"0","name":"sesforum.forum-view"}',
        'page_id' => $page_id,
        'order' => 6,
        'parent_content_id' => $middle_id,
      ));
    } else {
        $contentId = $db->select()
      ->from('engine4_core_content', 'content_id')
      ->where('page_id = ?', $page_id)
      ->where('name = ?','core.content')
      ->limit(1)
      ->query()
      ->fetchColumn();
      if($contentId) {
        $db->update('engine4_core_content', array( 'name' => 'sesforum.forum-view','params'=>'{"moderators":"1","show_criteria":["ownerName","ownerPhoto","likeCount","ratings","tags","showDatetime","viewCount","replyCount","latestPostDetails","postTopicButton"],"show_data":"1","load_content":"auto_load","limit_data":"5","title":"Forum View","nomobile":"0","name":"sesforum.forum-view"}'), array('content_id =?' => $contentId));
      }
    }
  }

  protected function _addUserProfileContent()
  {
    //
    // install content areas
    //
    $db     = $this->getDb();
    $select = new Zend_Db_Select($db);

    //INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`) VALUES

    // profile page
    $select
      ->from('engine4_core_pages')
      ->where('name = ?', 'user_profile_index')
      ->limit(1);
    $page_id = $select->query()->fetchObject()->page_id;


    // sesforum.profile-sesforum-posts

    // Check if it's already been placed
    $select = new Zend_Db_Select($db);
    $select
      ->from('engine4_core_content')
      ->where('page_id = ?', $page_id)
      ->where('type = ?', 'widget')
      ->where('name = ?', 'sesforum.profile-sesforum-posts')
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
        'name'    => 'sesforum.profile-sesforum-posts',
        'parent_content_id' => ($tab_id ? $tab_id : $middle_id),
        'order'   => 9,
        'params'  => '{"title":"Sesforum Posts","titleCount":true}',
      ));
    }
  }
}
