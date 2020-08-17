<?php


class Estore_Model_DbTable_Offers extends Engine_Db_Table {

  protected $_rowClass = "Estore_Model_Offer";

  public function getOffers($param = array()) {
    $tableName = $this->info('name');
    $offerSlides = Engine_Api::_()->getDbtable('slides', 'estore')->info('name');
    $select = $this->select()->setIntegrityCheck(false)
            ->from($tableName);
    //$select->joinLeft($offerSlides, $offerSlides . '.offer_id = ' . $tableName . '.offer_id AND '.$offerSlides .'.enabled = 1',null);
    if (isset($param['fetchAll'])) {
      $select->where($tableName.'.enabled =?', 1);
      return $this->fetchAll($select);
      }
    return Zend_Paginator::factory($select);
  }
}
