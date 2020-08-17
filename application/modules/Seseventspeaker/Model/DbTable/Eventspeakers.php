<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Eventspeakers.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seseventspeaker_Model_DbTable_Eventspeakers extends Engine_Db_Table {

  protected $_rowClass = "Seseventspeaker_Model_Eventspeaker";
  
  public function getSpeakerMemers($params = array()) {

    $select = $this->select()->from($this->info('name'))->order('eventspeaker_id DESC');
    if (!empty($params)) {
      if (isset($params['event_id']))
        $select = $select->where('event_id = ?', $params['event_id']);
    }
    return $paginator = Zend_Paginator::factory($select);
  }
  
  public function getSpeakersPaginator($params = array()) { 

    $tableName = $this->info('name');
    $speakerTable = Engine_Api::_()->getDbTable('speakers', 'seseventspeaker');
    $speakerTableName = $speakerTable->info('name');
    $select = $speakerTable->select()
								  ->from($speakerTableName)
								  ->where($speakerTableName .'.enabled =?', 1);
								  
    if (isset($params['widgetName']) && !empty($params['widgetName']) && $params['widgetName'] == 'profileEvents') {
      $select->setIntegrityCheck(false)->joinLeft($tableName, "$tableName.speaker_id = $speakerTableName.speaker_id", null);
      if (isset($params['event_id']) && !empty($params['event_id'])) {
        $select->where("$tableName.event_id =?", $params['event_id']);
      }
    }
    
    //String Search
    if (isset($params['name']) && !empty($params['name'])) {
      $select->where("$speakerTableName.name LIKE ?", "%{$params['name']}%");
    }
    
    if (isset($params['criteria'])) {
      if ($params['criteria'] == 1)
        $select->where($speakerTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($speakerTableName . '.sponsored =?', '1');
      else if ($params['criteria'] == 6)
        $select->where($speakerTableName . '.verified =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($speakerTableName . '.featured = 1 OR ' . $speakerTableName . '.sponsored = 1');
      else if ($params['criteria'] == 4)
        $select->where($speakerTableName . '.featured = 0 AND ' . $speakerTableName . '.sponsored = 0');
    }
    
    
    if (isset($params['popularity']) && $params['popularity'] == 'featured') {
      $select->where($speakerTableName . ".featured = ?", 1);
    }
    if (isset($params['popularity']) && $params['popularity'] == 'sponsored') {
      $select->where($speakerTableName . ".sponsored = ?", 1);
    }
    
    if (isset($params['popularity'])) {
      switch ($params['popularity']) {
        case "favourite_count":
          $select->order($speakerTableName . '.favourite_count DESC')
                  ->order($speakerTableName . '.speaker_id DESC');
        break;
        case "like_count":
          $select->order($speakerTableName . '.like_count DESC')
                  ->order($speakerTableName . '.speaker_id DESC');
        break;
        case "view_count":
          $select->order($speakerTableName . '.view_count DESC')
                  ->order($speakerTableName . '.speaker_id DESC');
        break;
				case "creation_date":
					$select->order($speakerTableName . '.creation_date DESC');
				break;
      }
    }
    if(empty($params['popularity']))
	    $select->order($speakerTableName . '.speaker_id DESC');

    $paginator = Zend_Paginator::factory($select);
    if (!empty($params['page']))
      $paginator->setCurrentPageNumber($params['page']);

    if (!empty($params['limit']))
      $paginator->setItemCountPerPage($params['limit']);

    return $paginator;
  }
  
  public function getEventAddedAdminSpeakers($params = array())
  {
    $select = $this->select()
        ->from($this, array('speaker_id'))
        ->where('event_id =?', $params['event_id'])
        ->where('type =?', $params['type'])
        ->query();
    
    $data = array();
    foreach( $select->fetchAll() as $speaker ) {
      $data[] = $speaker['speaker_id'];
    }
    return $data;
  }
  
  public function getSpeakerEventCounts($params = array()) {

    return $this->select() 
                    ->from($this->info('name'), array('count(*) as speakerEventCount'))
                    ->where('speaker_id =?', $params['speaker_id'])
                    ->query()
                    ->fetchColumn();
  }
  
  public function getEventCreatedSpeakers($params = array()) {
  
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
		$tableName = $this->info('name');
		$select = $this->select()
								  ->from($this->info('name'), 'speaker_id')
									->where('enabled =?', 1)
									->where('owner_id =?', $viewer_id)
									->where('type =?', 'eventspeaker');
		return $this->fetchAll($select);
  
  }
  
  
}
