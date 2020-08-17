<?php

class Snsdemo_Model_DbTable_Themes extends Engine_Db_Table
{
  protected $_rowClass = 'Snsdemo_Model_Theme';
  
  public function getThemesAssoc() {
    $stmt = $this->select()
        ->from($this, array('theme_id', 'theme_name'))
        ->order('theme_name ASC')
        ->query();
    
    $data = array();
    foreach( $stmt->fetchAll() as $theme ) {
      $data[$theme['theme_id']] = $theme['theme_name'];
    }
    
    return $data;
  }
}
