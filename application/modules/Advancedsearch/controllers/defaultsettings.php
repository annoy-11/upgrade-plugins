<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


$db = Zend_Db_Table_Abstract::getDefaultAdapter();

Engine_Api::_()->advancedsearch()->createPage();
$db->query("UPDATE `engine4_advancedsearch_modules` SET `order` = `module_id`");


$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'advancedsearch_index_search-other-module-results')
    ->limit(1)
    ->query()
    ->fetchColumn();
// insert if it doesn't exist yet
if( !$pageId ) {
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'advancedsearch_index_search-other-module-results',
        'displayname' => 'SES - Professional Search : Search Module Page Results' ,
        'title' => "SES - Professional Search Plugin : Search Page",
        'description' => "This page show on advanced search page",
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

    // Insert middle content
    $order = 1;
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'advancedsearch.core-content',
        'params'=> "[]",
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $order++,
    ));
    $order = 1;
    // Insert search
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => "advancedsearch.browse-search",
        'params' => "[]",
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $order++,
    ));
}


$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'advancedsearch_index_index')
    ->limit(1)
    ->query()
    ->fetchColumn();
// insert if it doesn't exist yet
if( !$pageId ) {
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'advancedsearch_index_index',
        'displayname' => 'SES - Professional Search : All Search Result Page' ,
        'title' => "SES - Professional Search Plugin : Search Page",
        'description' => "This page show on advanced search page",
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
    // Insert middle content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => "advancedsearch.search-results",
        'params'=>'{"more_tab":"6","show_criteria":["view","likes","comment","contentType","postedBy","rating","photo","review","description","category","location","sponsored","featured","hot"],"pagging":"pagging","title":"","nomobile":"0","itemCountPerPage":"5","name":"advancedsearch.search-results"}',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => 1,
    ));
}


$db->query("UPDATE engine4_core_content SET `name` = 'advancedsearch.search' WHERE `name` = 'core.search-mini' AND `page_id` = 1");