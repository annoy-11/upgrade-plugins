<?php

class Snsdemo_Model_DbTable_Services extends Engine_Db_Table
{
  protected $_rowClass = 'Snsdemo_Model_Service';
  
  public function getServicesAssoc() {
    $stmt = $this->select()
        ->from($this, array('service_id', 'service_name'))
        ->order('service_name ASC')
        ->query();
    
    $data = array();
    foreach( $stmt->fetchAll() as $service ) {
      $data[$service['service_id']] = $service['service_name'];
    }
    
    return $data;
  }
}
