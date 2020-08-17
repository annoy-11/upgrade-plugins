<?php

class Sesmembersubscription_Model_DbTable_Commissions extends Engine_Db_Table
{
  protected $_rowClass = 'Sesmembersubscription_Model_Commission';
  
  public function getCommisionEntry($params = array()) {
  
    $select = $this->select()
                    ->where('`from` <= ?', $params['from'])
                    ->where('`to` >= ?', $params['from'])->limit(1);
    return $this->fetchRow($select);
  
  }
}
