<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestour_Api_Core extends Core_Api_Abstract {
  
  public function getAllWidgetizePages($id = null) {
  
    $toursTable = Engine_Api::_()->getDbtable('tours', 'sestour');
    $toursTableName = $toursTable->info('name');
    
    $pageIDS = array();
    $select = $toursTable->select()->from($toursTableName, 'page_id');
    $tours = $toursTable->fetchAll($select);
    foreach($tours as $tour) {
      $pageIDS[] = $tour->page_id;
    }

    $allPages = array('' => 'Choose Page');
    $corePagesTable = Engine_Api::_()->getDbtable('pages', 'core');
    $select = $corePagesTable->select();
    
    if($pageIDS && !$id) {
      $select->where('page_id NOT IN(?)', $pageIDS);
    } 
    $pages = $corePagesTable->fetchAll($select);
    foreach ($pages as $result) {
      if (stristr($result->name, 'mobi'))
        continue;
      $allPages[$result->page_id] = $result->displayname;
    }
    return $allPages;
  }
  
  public function getPageInfo($page_id) { 
    
    $pageTable = Engine_Api::_()->getDbtable('pages', 'core');
    $pageTableName = $pageTable->info('name');
    
    $select = $pageTable->select()
                        ->where('page_id =?', $page_id);
    return $pageTable->fetchAll($select);
  }
  
  public function getWidgeName($content_id) {
  
    $contentsTable = Engine_Api::_()->getDbtable('content', 'core');
    $contentsTableName = $contentsTable->info('name');
    
    return $contentsTable->select()->from($contentsTableName, 'name')->where('content_id =?', $content_id)->query()->fetchColumn();
  
  }
  
  public function checkWidgetInTabContanier($content_id) {
  
    $contentsTable = Engine_Api::_()->getDbtable('content', 'core');
    $contentsTableName = $contentsTable->info('name');
    
    $select = $contentsTable->select()->from($contentsTableName)->where('content_id =?', $content_id);

    $row = $contentsTable->fetchRow($select);

    return $contentsTable->select()->from($contentsTableName, 'content_id')->where('type =?', 'widget')->where('name =?', 'core.container-tabs')->where('content_id =?', $row->parent_content_id)->query()->fetchColumn();
  
  }
  
  public function getAllWidgets($page_id, $tour_id = null) { 
  
    $contentsTable = Engine_Api::_()->getDbtable('content', 'core');
    $contentsTableName = $contentsTable->info('name');
    
    $widgetIDs = array();
    
    if($tour_id) {
    
      $tourTable = Engine_Api::_()->getDbtable('contents', 'sestour');
      $tourTableName = $tourTable->info('name');
      
      $select = $tourTable->select()
                          ->from($tourTableName, 'widget_id')
                          ->where('tour_id =?', $tour_id);
      $resultswidgets = $tourTable->fetchAll($select);
      foreach($resultswidgets as $resultswidget) {
        $widgetIDs[] = $resultswidget->widget_id;
      }
    }

    $select = $contentsTable->select()
                        ->where('type =?', 'widget')
                        ->where('name <> ?', 'sestour.tour')
                        ->where('page_id =?', $page_id)
                        ->group('name');
    $results = $contentsTable->fetchAll($select);
    
    $allPages = array();
    foreach ($results as $result) {

      if(count($widgetIDs) > 0 && in_array($result->content_id, $widgetIDs)) {
        continue;
      } 
      
      if(!empty($result->params['title']))
        $title = $result->params['title'];
      else
        $title = '';

      if($title) {
        $allPages[$result->content_id] = $title . ' - ' . $result->name;
      } else {
        $allPages[$result->content_id] = $result->name;
      }
    }

    return $allPages;
  }
}