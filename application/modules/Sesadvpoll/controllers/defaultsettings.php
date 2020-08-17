<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesadvpoll_index_create')
    ->limit(1)
    ->query()
    ->fetchColumn();

if( !$page_id ) {

    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sesadvpoll_index_create',
        'displayname' => 'SES - Advanced Polls Plugin - Poll Create Page',
        'title' => 'Create New Poll',
        'description' => 'This page is the poll create page.',
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

    //Page menu widget
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => 1,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => 1,
    ));
}

$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesadvpoll_poll_edit')
    ->limit(1)
    ->query()
    ->fetchColumn();

if( !$page_id ) {

    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sesadvpoll_poll_edit',
        'displayname' => 'SES - Advanced Polls Plugin - Poll Edit Page',
        'title' => 'Edit Poll',
        'description' => 'This page is the poll edit page.',
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

    // 	breadcrumb widget
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.breadcrumb',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => 1,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => 1,
    ));
}

$page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesadvpoll_index_browse')
            ->limit(1)
            ->query()
            ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sesadvpoll_index_browse',
        'displayname' => 'SES - Advanced Polls Plugin - Poll Browse Page',
        'title' => 'Poll Browse',
        'description' => 'This page lists polls.',
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
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'right',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 1,
    ));
    $main_right_id = $db->lastInsertId();
    // 	page menu widget
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => 1,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.browse-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => 1,
        'params'=>'{"title":"Polls","show_criteria":["favouriteButton","vote","by","in","description","title","socialSharing","like","likeButton","favourite","comment","view"],"scialshare_enable_plusicon":"1","pagging":"auto_load","gridlist":"0","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","show_limited_data":"no","limit_data":"20","nomobile":"0","name":"sesadvpoll.browse-polls"}',
    ));
    // Insert search
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.browse-search',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 1,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.list-popular-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 3,
        'params'=>'{"title":"Most Recent Polls","show_criteria":["in","title"],"popular_type":"recentlycreated","socialshare_enable_plusicon":"1","title_truncation":"20","limit_data":"4","nomobile":"0","name":"sesadvpoll.list-popular-polls"}',
    ));
    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.list-popular-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 4,
        'params'=>'{"title":"Most Vote Polls","show_criteria":["vote","in","title"],"popular_type":"mostvoted","socialshare_enable_plusicon":"1","title_truncation":"20","limit_data":"4","nomobile":"0","name":"sesadvpoll.list-popular-polls"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.list-popular-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 4,
        'params'=>'{"title":"Most Favourite Polls","show_criteria":["favouriteButton","favourite","in","title"],"popular_type":"mostfavourite","socialshare_enable_plusicon":"1","title_truncation":"20","limit_data":"4","nomobile":"0","name":"sesadvpoll.list-popular-polls"}',
    ));
}


$page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesadvpoll_index_manage')
            ->limit(1)
            ->query()
            ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {

    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sesadvpoll_index_manage',
        'displayname' => 'SES - Advanced Polls Plugin - Poll Manage Page',
        'title' => 'Poll Manage',
        'description' => 'This page lists polls.',
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
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'right',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 1,
    ));
    $main_right_id = $db->lastInsertId();
    // 	page menu widget
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => 1,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.manage-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => 1,
        'params'=>'{"title":"Polls","show_criteria":["favouriteButton","vote","by","in","description","title","socialSharing","like","likeButton","favourite","comment","view"],"scialshare_enable_plusicon":"1","pagging":"auto_load","gridlist":"0","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","show_limited_data":"no","limit_data":"20","nomobile":"0","name":"sesadvpoll.manage-polls"}',
    ));

    // Insert search
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.manage-search',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 1,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.list-popular-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 3,
        'params'=>'{"title":"Most Recent Polls","show_criteria":["in","title"],"popular_type":"recentlycreated","socialshare_enable_plusicon":"1","title_truncation":"20","limit_data":"4","nomobile":"0","name":"sesadvpoll.list-popular-polls"}',
    ));
    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.list-popular-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 4,
        'params'=>'{"title":"Most Vote Polls","show_criteria":["vote","in","title"],"popular_type":"mostvoted","socialshare_enable_plusicon":"1","title_truncation":"20","limit_data":"4","nomobile":"0","name":"sesadvpoll.list-popular-polls"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.list-popular-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 4,
        'params'=>'{"title":"Most Favourite Polls","show_criteria":["favouriteButton","favourite","in","title"],"popular_type":"mostfavourite","socialshare_enable_plusicon":"1","title_truncation":"20","limit_data":"4","nomobile":"0","name":"sesadvpoll.list-popular-polls"}',
    ));
}


$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesadvpoll_index_home')
    ->limit(1)
    ->query()
    ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sesadvpoll_index_home',
        'displayname' => 'SES - Advanced Polls Plugin - Polls Home Page',
        'title' => 'Poll Home',
        'description' => 'This page lists polls.',
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
    // 	page menu widget
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => 1,
    ));
    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.list-popular-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_left_id,
        'order' => 1,
        'params'=>'{"title":"Most Voted Polls","show_criteria":["vote","in","title","like"],"popular_type":"mostvoted","socialshare_enable_plusicon":"1","title_truncation":"20","limit_data":"4","nomobile":"0","name":"sesadvpoll.list-popular-polls"}',
    ));
    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.list-popular-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_left_id,
        'order' => 2,
        'params'=>'{"title":"Most Favourite Polls","show_criteria":["vote","title","like","favourite"],"popular_type":"mostfavourite","socialshare_enable_plusicon":"1","title_truncation":"20","limit_data":"4","nomobile":"0","name":"sesadvpoll.list-popular-polls"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.list-popular-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_left_id,
        'order' => 3,
        'params'=>'{"title":"Most Liked Polls","show_criteria":["socialSharing","vote","in","title","like"],"popular_type":"mostliked","socialshare_enable_plusicon":"1","title_truncation":"20","limit_data":"4","nomobile":"0","name":"sesadvpoll.list-popular-polls"}',
    ));
    // 	browse polls menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.browse-poll-button',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 1,
    ));
    // 	browse polls search
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.browse-search',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 2,
    ));
    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.list-popular-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 3,
        'params'=>'{"title":"Most Commented Polls","show_criteria":["vote","in","title","like","comment","view"],"popular_type":"mostcommented","socialshare_enable_plusicon":"1","title_truncation":"20","limit_data":"4","nomobile":"0","name":"sesadvpoll.list-popular-polls"}',
    ));
    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.list-popular-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 4,
        'params'=>'{"title":"Most Viewed Polls","show_criteria":["vote","in","title","like","comment","view"],"popular_type":"mostviewed","socialshare_enable_plusicon":"1","title_truncation":"20","limit_data":"4","nomobile":"0","name":"sesadvpoll.list-popular-polls"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.tabbed-widget-poll',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => 1,
        'params'=>'{"title":"Home","tabOption":"0","show_criteria":["favouriteButton","vote","by","in","description","title","socialSharing","like","likeButton","favourite","comment","view"],"search_type":["open","close","recentlySPcreated","mostSPliked","mostSPcommented","mostvoted","mostSPviewed","mostSPfavourite"],"socialshare_enable_plusicon":"1","pagging":"auto_load","gridlist":"0","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","show_limited_data":"no","limit_data":"20","nomobile":"0","name":"sesadvpoll.tabbed-widget-poll"}',
    ));
}

$select = new Zend_Db_Select($db);
$select->from('engine4_core_modules')
    ->where('name = ?', 'sesadvancedcomment')
    ->where('enabled = ?', 1);
$sesadvancedcomment_Check = $select->query()->fetchObject();

// profile page
$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesadvpoll_poll_view')
    ->limit(1)
    ->query()
    ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sesadvpoll_poll_view',
        'displayname' => 'SES - Advanced Polls Plugin - Poll View Page',
        'title' => 'Poll Home',
        'description' => 'This page view polls.',
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
    // 	page menu widget
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.breadcrumb',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => 1,
    ));
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
    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvpoll.view-poll',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => 1,
        'params'=>'{"show_criteria":["favouriteButton","vote","likeButton","socialSharing","likecount","favouritecount","viewcount","votecount"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","name":"sesadvpoll.poll-view"}',
    ));
    if($sesadvancedcomment_Check){
        $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'sesadvancedcomment.comments',
        'parent_content_id' => $main_middle_id,
        'order' => 2,
        ));
    }else{
        $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'core.comments',
        'parent_content_id' => $main_middle_id,
        'order' => 2,
        'params' => '',
        ));
    }
}

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sesadvpoll_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('sesadvpoll_poll', $level->level_id, array_keys($form->getValues()));

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
    $permissionsTable->setAllowed('sesadvpoll_poll', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}

$db->query('INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES
("sesadvpoll_main", "standard", "SNS - Advanced Polls - Main Navigation Menu");');
