<?php

class Sesinviter_Model_DbTable_Introduces extends Engine_Db_Table {

  protected $_name = 'sesinviter_introduces';
  protected $_rowClass = 'Sesinviter_Model_Introduce';
  
  public function getDescription() {
  
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    
    $name = $this->info('name');
    $select = $this->select()
                ->from($name, array('description', 'user_id', 'introduce_id'))
                ->where('user_id = ?', $viewer_id);
    return $this->fetchRow($select);
  }
  
  public function getWidgetResults($params = array()) {
  
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    
    $name = $this->info('name');
    $select = $this->select()
                ->from($name, array('description', 'user_id', 'introduce_id'))
                ->where('user_id != ?', $viewer_id);
                
    if(isset($params['limit'])) {
      $select->limit($params['limit']);
    }
    if(isset($params['order']) && $params['order'] != 'random') {
      $select->order($params['order'].' DESC');
    } else if($params['order'] == 'random') {
      $select->order('RAND()');
    }

    return $this->fetchAll($select);
  }
}