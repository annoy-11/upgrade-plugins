<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescommunityads
 * @package    Sescommunityads
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//browse page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_sponsored')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_sponsored',
    'displayname' => 'SES - Q&A - Sponsored Browse Page',
    'title' => 'Browse Q&A',
    'description' => 'This page lists questions.',
    'custom' => 0,
    ));
    $pageId = $db->lastInsertId();

     $pageName = 'sesqa_index_sponsored';
  include APPLICATION_PATH . "/application/modules/Sesqa/controllers/resetPage.php";
}

//browse page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_featured')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_featured',
    'displayname' => 'SES - Q&A - Featured Browse Page',
    'title' => 'Browse Q&A',
    'description' => 'This page lists questions.',
    'custom' => 0,
    ));
    $pageId = $db->lastInsertId();
    $pageName = 'sesqa_index_featured';
  include APPLICATION_PATH . "/application/modules/Sesqa/controllers/resetPage.php";
    
}

//browse page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_hot')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_hot',
    'displayname' => 'SES - Q&A - Hot Browse Page',
    'title' => 'Browse Q&A',
    'description' => 'This page lists questions.',
    'custom' => 0,
    ));
    $pageId = $db->lastInsertId();
    $pageName = 'sesqa_index_hot';
  include APPLICATION_PATH . "/application/modules/Sesqa/controllers/resetPage.php";
   
}

//Question Category Browse Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesqa_category_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sesqa_category_browse',
        'displayname' => 'SES - Q&A - Browse Categories Page',
        'title' => 'Browse Categories Page',
        'description' => 'This page is the browse questions categories page.',
        'custom' => 0,
    ));
    $page_id = $db->lastInsertId();
   $pageName = 'sesqa_category_browse';
  include APPLICATION_PATH . "/application/modules/Sesqa/controllers/resetPage.php";

}

//Faq Category View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesqa_category_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sesqa_category_index',
        'displayname' => 'SES - Q&A - Category View Page',
        'title' => 'Category View Page',
        'description' => 'This page is the category view page.',
        'custom' => 0,
    ));
    $page_id = $db->lastInsertId();
   $pageName = 'sesqa_category_index';
  include APPLICATION_PATH . "/application/modules/Sesqa/controllers/resetPage.php";
}

//browse page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_tags')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_tags',
    'displayname' => 'SES - Q&A - Browse Tags Page',
    'title' => 'Browse Q&A',
    'description' => 'This page lists tags.',
    'custom' => 0,
    ));
    $pageId = $db->lastInsertId();

    $pageName = 'sesqa_index_tags';
  include APPLICATION_PATH . "/application/modules/Sesqa/controllers/resetPage.php";
}

//browse page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_browse')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_browse',
    'displayname' => 'SES - Q&A - Browse Page',
    'title' => 'Browse Q&A',
    'description' => 'This page lists questions.',
    'custom' => 0,
    ));
    $pageId = $db->lastInsertId();

   $pageName = 'sesqa_index_browse';
  include APPLICATION_PATH . "/application/modules/Sesqa/controllers/resetPage.php";
}

//create page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_create')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_create',
    'displayname' => 'SES - Q&A - Create Page',
    'title' => 'Create Q&A',
    'description' => 'This page is question create page.',
    'custom' => 0,
    ));
    $pageId = $db->lastInsertId();
     $pageName = 'sesqa_index_create';
  include APPLICATION_PATH . "/application/modules/Sesqa/controllers/resetPage.php";
}

//view page
    $pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_view')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_view',
    'displayname' => 'SES - Q&A - View Page',
    'title' => 'View Q&A',
    'description' => 'This page lists question view page.',
    'custom' => 0,
    ));
    $pageId = $db->lastInsertId();

    $pageName = 'sesqa_index_view';
  include APPLICATION_PATH . "/application/modules/Sesqa/controllers/resetPage.php";
}

//manage page
    $pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_manage')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_manage',
    'displayname' => 'SES - Q&A - Manage Page',
    'title' => 'Browse Q&A',
    'description' => 'This page lists manage page.',
    'custom' => 0,
    ));
    $pageId = $db->lastInsertId();

    $pageName = 'sesqa_index_manage';
  include APPLICATION_PATH . "/application/modules/Sesqa/controllers/resetPage.php";
}

//Unanwered question page
    $pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_unanswered')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_unanswered',
    'displayname' => 'SES - Q&A - Unanswered Question Page',
    'title' => 'Unanswered Q&A',
    'description' => 'This page lists unanswered questions.',
    'custom' => 0,
    ));
    $pageId = $db->lastInsertId();
     $pageName = 'sesqa_index_unanswered';
  include APPLICATION_PATH . "/application/modules/Sesqa/controllers/resetPage.php";
   
}


// Get page id
$select = new Zend_Db_Select($db);
$page_id = $select
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'user_profile_index')
        ->limit(1)
        ->query()
        ->fetchColumn(0);

// sesqa.profile-widget
// Check if it's already been placed
$select = new Zend_Db_Select($db);
$hasProfileEvents = $select
        ->from('engine4_core_content', new Zend_Db_Expr('TRUE'))
        ->where('page_id = ?', $page_id)
        ->where('type = ?', 'widget')
        ->where('name = ?', 'sesqa.profile-widget')
        ->query()
        ->fetchColumn();

// Add it
if (!$hasProfileEvents) {

    // container_id (will always be there)
    $select = new Zend_Db_Select($db);
    $container_id = $select
            ->from('engine4_core_content', 'content_id')
            ->where('page_id = ?', $page_id)
            ->where('type = ?', 'container')
            ->limit(1)
            ->query()
            ->fetchColumn();

    // middle_id (will always be there)
    $select = new Zend_Db_Select($db);
    $middle_id = $select
            ->from('engine4_core_content', 'content_id')
            ->where('parent_content_id = ?', $container_id)
            ->where('type = ?', 'container')
            ->where('name = ?', 'middle')
            ->limit(1)
            ->query()
            ->fetchColumn();

    // tab_id (tab container) may not always be there
    $select = new Zend_Db_Select($db);
    $select
            ->from('engine4_core_content', 'content_id')
            ->where('type = ?', 'widget')
            ->where('name = ?', 'core.container-tabs')
            ->where('page_id = ?', $page_id)
            ->limit(1);
    $tab_id = $select->query()->fetchObject();
    if ($tab_id && @$tab_id->content_id) {
    $tab_id = $tab_id->content_id;
    } else {
    $tab_id = $middle_id;
    }

    // insert
    if ($tab_id) {
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesqa.profile-widget',
            'parent_content_id' => $tab_id,
            'order' => 5,
            'params' => '{"title":"Questions","titleCount":true}',
        ));
    }
}

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sesqa_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('sesqa_question', $level->level_id, array_keys($form->getValues()));
  $form->populate($valuesForm);
  $db = $permissionsTable->getAdapter();
  $db->beginTransaction();
  try {
    if ($level->type != 'public') {
      // Set permissions
      $values['auth_comment'] = (array) $values['auth_comment'];
      $values['auth_view'] = (array) $values['auth_view'];
    }
    $nonBooleanSettings = $form->nonBooleanFields();
    $permissionsTable->setAllowed('sesqa_question', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}

$categories = Engine_Api::_()->getDbTable('categories','sesqa')->fetchAll(Engine_Api::_()->getDbTable('categories','sesqa')->select());
foreach($categories as $category){
  $banner = APPLICATION_PATH . '/application/modules/Sesqa/externals/images/Category/Banners';
  $icon = APPLICATION_PATH . '/application/modules/Sesqa/externals/images/Category/Icons';
  $title = str_replace(' ','_',strtolower($category->title));
  if (file_exists($banner.'/'.$title.'.jpg')){
    $category->thumbnail = $this->setCategoryPhoto($banner.'/'.$title.'.jpg',$category->getIdentity(),false);
  }
  if (file_exists($icon.'/'.$title.'_24x24.png')){
    $category->colored_icon = $this->setCategoryPhoto($icon.'/'.$title.'_24x24.png',$category->getIdentity(),false);
  }
  if (file_exists($icon.'/'.$title.'_256x256.png')){
    $category->cat_icon = $this->setCategoryPhoto($icon.'/'.$title.'_256x256.png',$category->getIdentity(),false);
  }
  $category->save();
}
$db->query('ALTER TABLE  `engine4_sesqa_questions` ADD  `enableAnswer` TINYINT( 1 ) NOT NULL DEFAULT "1";');
$db->query('UPDATE `engine4_sesqa_categories` SET `member_levels` = "1,2,3,4" WHERE `engine4_sesqa_categories`.`subcat_id` = 0 and  `engine4_sesqa_categories`.`subsubcat_id` = 0;');
$db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("qanda.polltype.questions", 1);');
