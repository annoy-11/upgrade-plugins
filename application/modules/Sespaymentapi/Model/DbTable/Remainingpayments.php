<?php

class Sespaymentapi_Model_DbTable_Remainingpayments extends Engine_Db_Table {

  protected $_name = 'sespaymentapi_remainingpayments';
  
  public function getUserEntry($params = array()) {

    $select = $this->select()
              ->from($this->info('name'))
              ->where('user_id =?', $params['resource_id'])
              ->where('resource_id =?', $params['resource_id'])
              ->where('resource_type =?', $params['resource_type']);
    return $select->query()->fetchAll();
  }

	public function getRemainingAmount($params = array()) {
	
    $tableName = $this->info('name');
    $select = $this->select()
                  ->from($tableName)
                  ->where('user_id =?', $params['user_id'])
                  ->where('resource_id =?', $params['resource_id'])
                  ->where('resource_type =?', $params['resource_type']);
    return $this->fetchRow($select);
	}
}