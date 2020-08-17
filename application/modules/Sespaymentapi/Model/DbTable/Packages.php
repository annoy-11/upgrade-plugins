<?php

class Sespaymentapi_Model_DbTable_Packages extends Engine_Db_Table
{
  protected $_rowClass = 'Sespaymentapi_Model_Package';
  
  public function getPackageId($params = array()) {
    
    return $this->select()
          ->from($this->info('name'), new Zend_Db_Expr('package_id'))
          ->where('resource_id = ?', $params['resource_id'])
          ->where('resource_type = ?', $params['resource_type'])
          ->query()
          ->fetchColumn();
  }
}