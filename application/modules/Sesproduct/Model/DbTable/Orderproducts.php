<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Orderproducts.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Orderproducts extends Engine_Db_Table {
   protected $_rowClass = "Sesproduct_Model_Orderproduct";
   protected $_type = 'sesproduct_order_products';
   protected $_name = 'sesproduct_order_products';
    public function productsOrders($params = array()){
		$orderTableName = $this->info('name');
		$select = $this->select()
		->from($this->info('name'))
		->where($this->info('name').'.product_id =?',$params['product_id']);
		//->where("state = 'complete'");
        $userTableName = Engine_Api::_()->getItemTable('user')->info('name');
		$productTable = Engine_Api::_()->getItemTable('sesproduct_order')->info('name');
		$select ->setIntegrityCheck(false)->joinLeft($userTableName, "$orderTableName.user_id = $userTableName.user_id",null)
		->joinLeft($productTable, "$productTable.product_id = $orderTableName.product_id",'*')
		->group($orderTableName.'.order_id');
		if (!empty($params['order_id']))
				$select->where($orderTableName . '.order_id =?', $params['order_id']);
		if (!empty($params['order_max']))
				$select->having("total <=?", $params['order_max']);
		if (!empty($params['order_min']))
				$select->having("total >=?", $params['order_min']);
		if (!empty($params['commision_min']))
				$select->where("$orderTableName.commission_amount >=?", $params['commision_min']);
		if (!empty($params['commision_max']))
				$select->where("$orderTableName.commission_amount <=?", $params['commision_max']);
		if (!empty($params['gateway']))
				$select->where($orderTableName . '.gateway_type = ? ', $params['gateway']);
		if(!empty($params['date_to']) && !empty($params['date_from']))
			$select->where("DATE($orderTableName.creation_date) BETWEEN '".$params['date_to']."' AND '".$params['date_from']."'");
		else{
			if (!empty($params['date_to']))
					$select->where("DATE($orderTableName.creation_date) >=?", $params['date_to']);
			if (!empty($params['date_from']))
					$select->where("DATE($orderTableName.creation_date) <=?", $params['date_from']);
		}
       $select->order($orderTableName.'.order_id DESC');

		return $select;
	}
	  public function orderProducts($params = array()){
		$orderTableName = $this->info('name');
		$select = $this->select()
		->from($this->info('name'));
		$productTable = Engine_Api::_()->getItemTable('sesproduct_order')->info('name');
		$select ->setIntegrityCheck(false)
		->joinLeft($productTable, "$productTable.order_id = $orderTableName.order_id",'*');
		if (!empty($params['order_id']))
				$select->where($orderTableName . '.order_id =?', $params['order_id']);
    $select->order($orderTableName.'.order_id DESC');

		return $this->fetchAll($select);;
	}
}
