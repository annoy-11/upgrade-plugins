<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Testimonial View Page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sestestimonial_index_view')
    ->limit(1)
    ->query()
    ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sestestimonial_index_view',
    'displayname' => 'SES - Testimonial View Page',
    'title' => 'Testimonial View',
    'description' => 'This page displays a testimonial entry.',
    'provides' => 'subject=testimonial',
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

    // Insert content
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sestestimonial.view-page',
    'page_id' => $pageId,
    'parent_content_id' => $middleId,
    'order' => 1,
    ));
}

$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sestestimonial_index_index')
    ->limit(1)
    ->query()
    ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sestestimonial_index_index',
    'displayname' => 'SES - Testimonial Browse Page',
    'title' => 'Testimonial Browse',
    'description' => 'This page lists testimonial entries.',
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
    'name' => 'sestestimonial.browse-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => 2,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sestestimonial.browse-testimonials',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => 1,
    ));

    // Insert search
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sestestimonial.browse-search',
    'page_id' => $pageId,
    'parent_content_id' => $mainRightId,
    'order' => 1,
    ));
}



//Manage Testimonials
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sestestimonial_index_manage')
    ->limit(1)
    ->query()
    ->fetchColumn();

// insert if it doesn't exist yet
if( !$pageId ) {
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sestestimonial_index_manage',
    'displayname' => 'SES - Testimonial Manage Page',
    'title' => 'My Testimonials',
    'description' => 'This page lists a user\'s testimonial entries.',
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
    'name' => 'sestestimonial.browse-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => 1,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.content',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => 1,
    ));

    // Insert search
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sestestimonial.browse-search',
    'page_id' => $pageId,
    'parent_content_id' => $mainRightId,
    'order' => 1,
    ));
}

//Testimonial Create Page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sestestimonial_index_create')
    ->limit(1)
    ->query()
    ->fetchColumn();

if( !$pageId ) {

    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sestestimonial_index_create',
    'displayname' => 'SES - Testimonial Create Page',
    'title' => 'Write New Testimonial',
    'description' => 'This page is the testimonial create page.',
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
    'name' => 'sestestimonial.browse-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => 1,
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

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sestestimonial_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('testimonial', $level->level_id, array_keys($form->getValues()));

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
    $permissionsTable->setAllowed('testimonial', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}
