<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_Installer extends Engine_Package_Installer_Module {

//   public function onPreinstall() {
//
//     $db = $this->getDb();
//     $plugin_currentversion = '4.10.3p21';
//
//     //Check: Basic Required Plugin
//     $select = new Zend_Db_Select($db);
//     $select->from('engine4_core_modules')
//             ->where('name = ?', 'sesbasic');
//     $results = $select->query()->fetchObject();
//     if (empty($results)) {
//       return $this->_error('<div class="global_form"><div><div><p style="color:red;">The required SocialEngineSolutions Basic Required Plugin is not installed on your website. Please download the latest version of this FREE plugin from <a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');
//     } else {
//       $error = include APPLICATION_PATH . "/application/modules/Sesbasic/controllers/checkPluginVersion.php";
//       if($error != '1') {
//         return $this->_error($error);
//       }
//     }
//     parent::onPreinstall();
//   }

  public function onInstall() {

    $db = $this->getDb();
    $select = $db->select()
                ->from('engine4_core_pages')
                ->where('name = ?', 'seslike_index_home')
                ->limit(1);
    $info = $select->query()->fetch();
    if (empty($info)) {
        $widgetOrder = 1;
        $db->insert('engine4_core_pages', array(
            'name' => 'seslike_index_home',
            'displayname' => 'SES - Professional Likes Plugin - Likes Home Page',
            'title' => 'Likes Home',
            'description' => 'This is the like home page.',
            'custom' => 0,
        ));
        $page_id = $db->lastInsertId('engine4_core_pages');

        // Insert top
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'top',
            'page_id' => $page_id,
            'order' => 1,
        ));
        $topId = $db->lastInsertId();

        // Insert main
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'main',
            'page_id' => $page_id,
            'order' => 2,
        ));
        $mainId = $db->lastInsertId();

        // Insert top-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $topId,
        ));
        $topMiddleId = $db->lastInsertId();

        // Insert main-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $mainId,
            'order' => 3,
        ));
        $mainMiddleId = $db->lastInsertId();

        // Insert main-left
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'left',
            'page_id' => $page_id,
            'parent_content_id' => $mainId,
            'order' => 1,
        ));
        $mainLeftId = $db->lastInsertId();

        // Insert main-right
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'right',
            'page_id' => $page_id,
            'parent_content_id' => $mainId,
            'order' => 2,
        ));
        $mainRightId = $db->lastInsertId();

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'seslike.browse-menu',
            'parent_content_id' => $topMiddleId,
            'order' => $widgetOrder++,
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'seslike.side-widget',
            'parent_content_id' => $mainLeftId,
            'order' => $widgetOrder++,
            'params' => '{"module":"businesses","limit":"3","title":"Most Liked Businesses","nomobile":"0","name":"seslike.side-widget"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'seslike.sidebar-tabbed-widget',
            'parent_content_id' => $mainLeftId,
            'order' => $widgetOrder++,
            'params' => '{"type":"sesgroup_group","search_type":["week","month","overall"],"dummy1":null,"week_order":"1","week_label":"This Week","dummy2":null,"month_order":"2","month_label":"This Month","dummy3":null,"overall_order":"3","overall_label":"Overall","limit":"2","title":"Most Liked Groups","nomobile":"0","name":"seslike.sidebar-tabbed-widget"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'seslike.side-widget',
            'parent_content_id' => $mainLeftId,
            'order' => $widgetOrder++,
            'params' => '{"module":"sesblog_blog","limit":"3","title":"Most Liked Blogs","nomobile":"0","name":"seslike.side-widget"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'seslike.sidebar-tabbed-widget',
            'parent_content_id' => $mainLeftId,
            'order' => $widgetOrder++,
            'params' => '{"type":"sesrecipe_recipe","search_type":["week","month","overall"],"dummy1":null,"week_order":"1","week_label":"This Week","dummy2":null,"month_order":"2","month_label":"This Month","dummy3":null,"overall_order":"3","overall_label":"Overall","limit":"2","title":"Most Liked Recipies","nomobile":"0","name":"seslike.sidebar-tabbed-widget"}',
        ));

        //Middle
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'seslike.tabbed-widget',
            'parent_content_id' => $mainMiddleId,
            'order' => $widgetOrder++,
            'params' => '{"type":"","show_criteria":["likeButton","like","title","by"],"show_limited_data":"0","pagging":"button","search_type":["recent","popular","random","week","month","overall"],"dummy1":null,"recent_order":"1","recent_label":"Recent","dummy2":null,"popular_order":"2","popular_label":"Popular","dummy3":null,"random_order":"3","random_label":"Random","dummy4":null,"week_order":"4","week_label":"This Week","dummy5":null,"month_order":"5","month_label":"This Month","dummy6":null,"overall_order":"6","overall_label":"Overall","limit":"20","title":"","nomobile":"0","name":"seslike.tabbed-widget"}',
        ));

        //Right side
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'seslike.sidebar-tabbed-widget',
            'parent_content_id' => $mainRightId,
            'order' => $widgetOrder++,
            'params' => '{"type":"pagevideo","search_type":["week","month","overall"],"dummy1":null,"week_order":"1","week_label":"This Week","dummy2":null,"month_order":"2","month_label":"This Month","dummy3":null,"overall_order":"3","overall_label":"Overall","limit":"2","title":"Most Liked Page Videos","nomobile":"0","name":"seslike.sidebar-tabbed-widget"}',
        ));
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'seslike.sidebar-tabbed-widget',
            'parent_content_id' => $mainRightId,
            'order' => $widgetOrder++,
            'params' => '{"type":"sesevent_event","search_type":["week","month","overall"],"dummy1":null,"week_order":"1","week_label":"This Week","dummy2":null,"month_order":"2","month_label":"This Month","dummy3":null,"overall_order":"3","overall_label":"Overall","limit":"3","title":"Most Liked Events","nomobile":"0","name":"seslike.sidebar-tabbed-widget"}',
        ));
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'seslike.side-widget',
            'parent_content_id' => $mainRightId,
            'order' => $widgetOrder++,
            'params' => '{"module":"sesarticle","limit":"2","title":"Most Liked Articles","nomobile":"0","name":"seslike.side-widget"}',
        ));
    }


    $page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'seslike_index_mylikes')
    ->limit(1)
    ->query()
    ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
        $widgetOrder = 1;
        // Insert page
        $db->insert('engine4_core_pages', array(
            'name' => 'seslike_index_mylikes',
            'displayname' => 'SES - Professional Likes Plugin - My Likes Page',
            'title' => 'My Likes Page',
            'description' => 'This page lists a user\'s likes entries.',
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
            'name' => 'seslike.browse-menu',
            'page_id' => $page_id,
            'parent_content_id' => $top_middle_id,
            'order' => $widgetOrder++,
        ));

        // Insert content
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'seslike.mylikes-widget',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
        ));
    }


    $page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'seslike_index_wholikeme')
    ->limit(1)
    ->query()
    ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
        $widgetOrder = 1;
        // Insert page
        $db->insert('engine4_core_pages', array(
            'name' => 'seslike_index_wholikeme',
            'displayname' => 'SES - Professional Likes Plugin - Who Likes Me Page',
            'title' => 'Who Like Me Page',
            'description' => 'This page lists a user\'s who like viewer profile.',
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
            'name' => 'seslike.browse-menu',
            'page_id' => $page_id,
            'parent_content_id' => $top_middle_id,
            'order' => $widgetOrder++,
        ));

        // Insert content
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'seslike.wholikeme',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
        ));
    }

    $page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'seslike_index_mycontentlike')
    ->limit(1)
    ->query()
    ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
        $widgetOrder = 1;
        // Insert page
        $db->insert('engine4_core_pages', array(
            'name' => 'seslike_index_mycontentlike',
            'displayname' => 'SES - Professional Likes Plugin - My Content Likes Page',
            'title' => 'My Content Likes Page',
            'description' => 'This page lists a user\'s content likes entries.',
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
            'name' => 'seslike.browse-menu',
            'page_id' => $page_id,
            'parent_content_id' => $top_middle_id,
            'order' => $widgetOrder++,
        ));

        // Insert content
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'seslike.mycontentlike',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
        ));
    }


    $page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'seslike_index_myfriendslike')
    ->limit(1)
    ->query()
    ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
        $widgetOrder = 1;
        // Insert page
        $db->insert('engine4_core_pages', array(
            'name' => 'seslike_index_myfriendslike',
            'displayname' => 'SES - Professional Likes Plugin - My Friend\'s Like Content Page',
            'title' => 'My Friend\'s Like Content Page',
            'description' => 'This page lists a friend\'s Like content entries.',
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
            'name' => 'seslike.browse-menu',
            'page_id' => $page_id,
            'parent_content_id' => $top_middle_id,
            'order' => $widgetOrder++,
        ));

        // Insert content
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'seslike.myfriendcontentlike',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
        ));
    }



    $page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'seslike_index_mylikesettings')
    ->limit(1)
    ->query()
    ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$page_id ) {
        $widgetOrder = 1;
        // Insert page
        $db->insert('engine4_core_pages', array(
            'name' => 'seslike_index_mylikesettings',
            'displayname' => 'SES - Professional Likes Plugin - My Like Settings Page',
            'title' => 'My Like Settings Page',
            'description' => 'This page my profile like settings.',
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
            'name' => 'seslike.browse-menu',
            'page_id' => $page_id,
            'parent_content_id' => $top_middle_id,
            'order' => $widgetOrder++,
        ));

        // Insert content
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'core.content',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
        ));
    }

    parent::onInstall();
  }
}
