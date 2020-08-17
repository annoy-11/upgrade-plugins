<?php


class Sesadvancedbanner_Model_DbTable_Banners extends Engine_Db_Table {

  protected $_rowClass = "Sesadvancedbanner_Model_Banner";

  public function getBanner($param = array()) {
    $tableName = $this->info('name');
    $select = $this->select()
            ->from($tableName);
    if (isset($param['fetchAll'])) {
      $select->where('enabled =?', 1);
      return $this->fetchAll($select);
      }
    return Zend_Paginator::factory($select);
  }

}
