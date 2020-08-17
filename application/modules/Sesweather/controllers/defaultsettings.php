<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$pageId = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesweather_index_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
// insert if it doesn't exist yet
if (!$pageId) {
    $widgetOrder = 1;
// Insert group
    $db->insert('engine4_core_pages', array(
        'name' => 'sesweather_index_index',
        'displayname' => 'SES - Weather - Browse Page',
        'title' => 'Weather Browse',
        'description' => 'This page lists weather.',
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

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesweather.weather-dark-bg',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"sesweather_isintegrate":"1","location":"","lat":"","lng":"","location-data":null,"sesweather_temdesign":"1","sesweather_bgphoto":"0","sesweather_location_search":"1","title":"Weather with Background Image - Design 1","nomobile":"0","name":"sesweather.weather-dark-bg"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesweather.weather-main',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"sesweather_isintegrate":"1","location":"","lat":"","lng":"","location-data":null,"sesweather_temdesign":"1","sesweather_bgphoto":"0","sesweather_location_search":"1","title":"Weather with Info Graphics","nomobile":"0","name":"sesweather.weather-main"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesweather.weather-dark-bg',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"sesweather_isintegrate":"1","location":"","lat":"","lng":"","location-data":null,"sesweather_temdesign":"0","sesweather_bgphoto":"0","sesweather_location_search":"1","title":"Weather with Background Image - Design 2","nomobile":"0","name":"sesweather.weather-dark-bg"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesweather.location-detect',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesweather.weather-sidebar',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"sesweather_isintegrate":"1","location":"Japanese Tea Garden, San Francisco, CA, USA","lat":"37.7700913","lng":"-122.47043589999998","location-data":null,"title":"Sidebar Weather","nomobile":"0","name":"sesweather.weather-sidebar"}',
    ));
}
//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sesweather_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('sesweatherview', $level->level_id, array_keys($form->getValues()));

  $form->populate($valuesForm);
  $db = $permissionsTable->getAdapter();
  $db->beginTransaction();
  try {
    $nonBooleanSettings = $form->nonBooleanFields();
    $permissionsTable->setAllowed('sesweatherview', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}