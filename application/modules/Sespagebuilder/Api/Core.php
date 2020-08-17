<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Api_Core extends Core_Api_Abstract {

  public function getCategories($params = array()) {

    if ($params['module_name'] == 'group' || $params['module_name'] == 'forum' || $params['module_name'] == 'event') {
      $getFields = array('category_id', 'title');
      $order = 'title';
    } else {
      $getFields = array('category_id', 'category_name');
      $order = 'category_name';
    }

    $categoryTable = Engine_Api::_()->getDbtable('categories', $params['module_name']);
    $select = $categoryTable->select()->from($categoryTable->info('name'), $getFields);
    if ($params['module_name'] == 'sesalbum')
      $select->where('subcat_id =?', 0);
    $select->order("$order ASC");
    return $categoryTable->fetchAll($select);
  }

  public function catParameters($params = array()) {

    $catParams = array();
    switch ($params['module_name']) {
      case 'sesmusic':
        $catParams['URL'] = 'http://' . $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'browse'), 'sesmusic_general', true) . '?category_id=';
        break;
      case 'sesalbum':
        $catParams['URL'] = 'http://' . $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'browse'), 'sesalbum_general', true) . '?category_id=';
        break;
      case 'album':
        $catParams['URL'] = 'http://' . $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index'), 'album_extended', true) . '?category=';
        break;
      case 'blog':
        $catParams['URL'] = 'http://' . $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index'), 'blog_general', true) . '?category=';
        break;
      case 'classified':
        $catParams['URL'] = 'http://' . $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index'), 'classified_extended', true) . '?category=';
        break;
      case 'group':
        $catParams['URL'] = 'http://' . $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index'), 'group_extended', true) . '?category_id=';
        break;
      case 'event':
        $catParams['URL'] = 'http://' . $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index'), 'event_extended', true) . '?category_id=';
        break;
      case 'music':
        $catParams['URL'] = 'http://' . $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index'), 'music_extended', true) . '?category=';
        break;
      case 'video':
        $catParams['URL'] = 'http://' . $_SERVER['HTTP_HOST'] . Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'browse'), 'video_general', true) . '?category=';
        break;
    }
    return $catParams;
  }

  public function checkPage($pageName, $pageTitle = '') {

    $db = Engine_Db_Table::getDefaultAdapter();

    // profile page
    $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', $pageName)
            ->limit(1)
            ->query()
            ->fetchColumn();

    if ($page_id)
      return 0;
    else {
      // Insert page
      $db->insert('engine4_core_pages', array(
          'name' => $pageName,
          'displayname' => 'SES - ' . $pageTitle . ' Page',
          'title' => 'SES - ' . $pageTitle . ' Page',
          'description' => '',
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

      // Insert main-middle
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'middle',
          'page_id' => $page_id,
          'parent_content_id' => $main_id,
          'order' => 2,
      ));
      $main_middle_id = $db->lastInsertId();

      // Insert content
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sespagebuilder.pages',
          'page_id' => $page_id,
          'parent_content_id' => $main_middle_id,
          'order' => 1,
      ));
      return $page_id;
    }
  }

  public function getWidgetizePageId($staticPageId = null) {

    return Engine_Db_Table::getDefaultAdapter()->select()
                    ->from('engine4_core_pages', 'page_id')
                    ->where('name = ?', 'sespagebuilder_index_' . $staticPageId)
                    ->limit(1)
                    ->query()
                    ->fetchColumn();
  }

  public function checkPrivacySetting($fixedPageId) {

    $pageObject = Engine_Api::_()->getItem('sespagebuilder_pagebuilder', $fixedPageId);
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    if (empty($pageObject->enable))
      return false;
		
// 		if(empty($pageObject->show_page) && empty($viewerId))
// 			return false;
	 
    if ($viewerId)
      $level_id = $viewer->level_id;
    else
      $level_id = 5;

    $member_levels = $pageObject->member_levels;
    $member_level = json_decode($member_levels);
    if (!empty($member_level)) {
      if (!in_array($level_id, $member_level))
        return false;
    } else
      return false;


    if ($viewerId) {
      if($level_id == 1 || $level_id == 2)
        return true;
      $network_table = Engine_Api::_()->getDbtable('membership', 'network');
      $network_select = $network_table->select('resource_id')->where('user_id = ?', $viewerId);
      $network_id_query = $network_table->fetchAll($network_select);
      $network_id_query_count = count($network_id_query);
      $network_id_array = array();
      for ($i = 0; $i < $network_id_query_count; $i++) {
        $network_id_array[$i] = $network_id_query[$i]['resource_id'];
      }

      if (!empty($network_id_array)) {
        $networks = json_decode($pageObject->networks);

        if (!empty($networks)) {
          if (!array_intersect($network_id_array, $networks))
            return false;
        } else
          return false;
      }

      $profile_table = Engine_Api::_()->fields()->getTable('user', 'values');
      $profile_select = $profile_table->select('value')->where('field_id = 1 AND item_id = ?', $viewerId);
      $profile_type_query = $profile_table->fetchRow($profile_select);
      $profile_type_id = $profile_type_query['value'];
      $profile_types = json_decode($pageObject->profile_types);
      if (!empty($profile_types)) {
        if (is_array($profile_types)) {
          if (!in_array($profile_type_id, $profile_types))
            return false;
        }
        else {
          if ($profile_type_id != $profile_types)
            return false;
        }
      } else
        return false;
    }
    return true;
  }

  public function isFileIdExist($fileId = null, $columnId = null) {

    $column = $fileId . '_file_id';
    $pricingTable = Engine_Api::_()->getDbtable('pricingtables', 'sespagebuilder');
    $db = Engine_Db_Table::getDefaultAdapter();
    $columnName = $db->query("SHOW COLUMNS FROM engine4_sespagebuilder_pricingtables LIKE '$column'")->fetch();
    if(empty($columnName))
    return '0';
    
    $fileId = $pricingTable->select()->from($pricingTable->info('name'), $column)->where('pricingtable_id =?', $columnId)->query()->fetchColumn();
    return ($fileId) ? '1' : '0';
  }

}
