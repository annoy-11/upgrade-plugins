<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Speakers.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Seseventspeaker_Model_DbTable_Speakers extends Engine_Db_Table {

  protected $_rowClass = "Seseventspeaker_Model_Speaker";
  
  public function getOfTheDayResults($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), array('*'))
            ->where('offtheday =?', 1)
            ->where('enabled = ?', 1)
            ->where('type =?', 'admin')
            ->where('starttime <= DATE(NOW())')
            ->where('endtime >= DATE(NOW())')
            ->order('RAND()');
    return $this->fetchRow($select);
  }
  
  public function getSpeakerMemers($params = array()) {

    $select = $this->select()->from($this->info('name'));

    if (!empty($params)) {

      if (isset($params['type']) && $params['type'] == 'widget')
        $select = $select->where('enabled = ?', 1);

      if (isset($params['widgettype']) && $params['widgettype'] == 'widget')
        $select = $select->where('enabled = ?', 1);

      if (isset($params['allSpeaker']))
        $select = $select->where('user_id IN(?)', $params['allSpeaker']);

      if (!empty($params['designation_id']))
        $select->where($this->info('name') . '.designation_id = ?', $params['designation_id']);

      if (!empty($params['type']))
        $select->where($this->info('name') . '.type = ?', $params['type']);

      if (!empty($params['popularity'])) {
        if ($params['popularity'] == 'featured')
          $select->where($this->info('name') . '.featured = ?', 1);
        elseif ($params['popularity'] == 'sponsored')
          $select->where($this->info('name') . '.sponsored = ?', 1);
      }

      if (isset($params['limit']))
        $select = $select->limit($params['limit']);
    }


    if (isset($params['widgettype']) && $params['widgettype'] == 'widget')
      return $this->fetchAll($select);
    else
      return $paginator = Zend_Paginator::factory($select);
  }
  
  public function getEventAddedSiteMemberSpeakers($params = array()) {
  
    $select = $this->select()
	        ->from($this, array('user_id'))
		      ->where('speaker_id IN(?)', $params['speaker_id'])
		      ->where('type =?', $params['type']);
    $data = array();
    foreach( $this->fetchAll($select) as $speaker ) {
      $data[] = $speaker['user_id'];
    }
    return $data;
  }

  public function getUserId($params = array()) {

    return $this->select()
                    ->from($this->info('name'), array('speaker_id'))
                    ->where('user_id =?', $params['user_id'])
                    ->query()
                    ->fetchColumn();
  }

  public function getSpeakerId($params = array()) {

    return $this->select()
                    ->from($this->info('name'), array('speaker_id'))
                    ->where('user_id =?', $params['user_id'])
                    //->where('enabled = ?', 1)
                    ->query()
                    ->fetchColumn();
  }

}
