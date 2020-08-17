<?php

class Sespaymentapi_Model_DbTable_Orders extends Engine_Db_Table {

  protected $_rowClass = "Sespaymentapi_Model_Order";
  
	public function getOrder($params = array()) {
	
		$select = $this->select()->where('owner_id =?',$params['owner_id'])->where('is_delete =?',0);
		return $this->fetchAll($select);
	}
	
	public function getOrderStatus($order_id = '') {
	
		return $this->select()
								->from($this->info('name'), new Zend_Db_Expr('COUNT(*)'))
								->where('state =?', 'complete')
								->where('order_id =?',$order_id)
								->query()
								->fetchColumn();
							
	}

  public function getOrderStats($params = array()) {
  
    $select = $this->select()
            ->from($this->info('name'), array('totalOrder'=> new Zend_Db_Expr("COUNT(order_id)"),"commission_amount" => new Zend_Db_Expr("SUM(commission_amount)"), 'totalAmountSale' => new Zend_Db_Expr("sum(total_amount)")))
            ->where('resource_id =?',$params['resource_id'])
            ->where('resource_type =?',$params['resource_type'])
            ->where("state = 'complete'");
		return $select->query()->fetch();
	}
	
	public function manageOrders($params = array()) {
    
    $userTableName = Engine_Api::_()->getItemTable('user')->info('name');
		$orderTableName = $this->info('name');
		
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($orderTableName)
            ->joinLeft($userTableName, "$orderTableName.user_id = $userTableName.user_id", 'displayname')
            ->where($orderTableName . '.resource_id = ?', $params['resource_id'])
            ->where($orderTableName . '.resource_type = ?', $params['resource_type'])
            ->where($orderTableName . '.state = ?', 'complete')
            ->order('order_id DESC');
		
		if (!empty($params['order_id']))
				$select->where($orderTableName . '.order_id =?', $params['order_id']);	

		if (!empty($params['order_max']))
				$select->having("total_amount <=?", $params['order_max']);
		if (!empty($params['order_min']))
				$select->having("total_amount >=?", $params['order_min']);
				
		if (!empty($params['commision_min']))
				$select->where("$orderTableName.commission_amount >=?", $params['commision_min']);
		if (!empty($params['commision_max']))
				$select->where("$orderTableName.commission_amount <=?", $params['commision_max']);
				
		if (!empty($params['gateway']))
				$select->where($orderTableName . '.gateway_type = ? ', $params['gateway']);
				
		if (!empty($params['email']))
				$select->where($orderTableName . '.email  LIKE ?', '%' . $params['email'] . '%');
				
		if (!empty($params['buyer_name']))
				$select->where($userTableName . '.displayname  LIKE ?', '%' . $params['buyer_name'] . '%');
				
		if(!empty($params['date_to']) && !empty($params['date_from'])) {
			$select->where("DATE($orderTableName.creation_date) BETWEEN '".$params['date_to']."' AND '".$params['date_from']."'");
    } else {
			if (!empty($params['date_to']))
					$select->where("DATE($orderTableName.creation_date) >=?", $params['date_to']);
			if (!empty($params['date_from']))
					$select->where("DATE($orderTableName.creation_date) <=?", $params['date_from']);	
		}

		return $select;
	}
}