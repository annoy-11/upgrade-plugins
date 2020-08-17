<?php
class Estore_Model_DbTable_Remainingpayments extends Engine_Db_Table {
  protected $_name = 'estore_remainingpayments';
	public function getStoreRemainingAmount($params = array()){
		$tabeleName = $this->info('name');
	 $select = $this->select()->from($tabeleName);
	 if(isset($params['store_id']))
	 	$select->where('store_id =?',$params['store_id']);
	 return $this->fetchRow($select);
	}
}
