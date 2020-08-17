<?php

class Sessubscribeuser_Model_DbTable_Orders extends Engine_Db_Table {

  protected $_rowClass = "Sessubscribeuser_Model_Order";
  
	public function getOrder($params = array()){
		$select = $this->select()->where('owner_id =?',$params['owner_id'])->where('is_delete =?',0);
		return $this->fetchAll($select);
	}
	public function getOrderStatus($order_id = ''){
		return $this->select()
								->from($this->info('name'), new Zend_Db_Expr('COUNT(*)'))
								->where('state =?', 'complete')
								->where('order_id =?',$order_id)
								->query()
								->fetchColumn();
							
	}
}