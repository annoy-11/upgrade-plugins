<?php


class Seslink_Model_DbTable_Recentlyviewitems extends Engine_Db_Table {

  protected $_name = 'seslink_recentlyviewitems';
  protected $_rowClass = 'Seslink_Model_Recentlyviewitem';

  public function getitem($params = array()) {

    $linkTableName = Engine_Api::_()->getItemTable('seslink_link')->info('name');

    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->info('name'), array('*'))
            ->where('resource_type = ?', 'seslink_link')
            ->order('creation_date DESC')
            ->limit($params['limit']);

    if ($params['criteria'] == 'by_me') {
      $select->where($this->info('name') . '.owner_id =?', Engine_Api::_()->user()->getViewer()->getIdentity());
    } else if ($params['criteria'] == 'by_myfriend') {
      /* friends array */
      $friendIds = Engine_Api::_()->user()->getViewer()->membership()->getMembershipsOfIds();
      if (count($friendIds) == 0)
        return array();
      $select->where($this->info('name') . ".owner_id IN ('" . implode(',', $friendIds) . "')");
    }
    $select->joinLeft($linkTableName, $linkTableName . ".link_id =  " . $this->info('name') . '.resource_id', null);
    return $this->fetchAll($select);
  }
}