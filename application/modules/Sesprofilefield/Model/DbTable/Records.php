<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Records.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Model_DbTable_Records extends Core_Model_Item_DbTable_Abstract {

  protected $_rowClass = "Sesprofilefield_Model_Record";
  protected $_name = 'sesprofilefield_records';
  
  public function getAllRecords($subject_id = null) {
    
    $select = $this->select()
              ->from($this->info('name'))->order('record_id ASC');
    
    if($subject_id)
      $select->where('user_id =?', $subject_id);

    return $this->fetchAll($select);
  
  }

  public function getViewerRecord($params = array()) {

    return $this->select()
            ->from($this->info('name'), 'record_id')
            ->where('user_id = ?', $params['user_id'])
            ->query()
            ->fetchColumn();
  }
  
  public function getColumnValue($params = array()) {

    return $this->select()
            ->from($this->info('name'), 'record_id')
            ->where('name = ?', $params['name'])
            ->query()
            ->fetchColumn();
  }
  
  
  public function getViewerRecords($params = array()) {

    $select = $this->select();
//     if($params['type'] == '["minute","second"]') {
//       $select->from($this->info('name'), '*');
//     } else {
      $select->from($this->info('name'), json_decode($params['type']));
    //}
            
    $select->where('user_id = ?', $params['user_id'])
          ->where('adminspecialty_id = ?', $params['adminspecialty_id'])
          ->where('subid = ?', $params['subid'])
          ->where('subsubid = ?', $params['subsubid']);
    return $this->fetchRow($select);
    
  }
}