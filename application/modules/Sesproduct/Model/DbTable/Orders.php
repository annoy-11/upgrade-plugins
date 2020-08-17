<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Orders.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Orders extends Engine_Db_Table {
   protected $_rowClass = "Sesproduct_Model_Order";
   protected $_type = 'sesproduct_orders';

    public function getProduct() {
        if (null === $this->_product) {
            $productTable = Engine_Api::_()->getDbtable('sesproducts', 'payment');
            $this->_product = $productTable->fetchRow($productTable->select()
                ->where('extension_type = ?', 'sescontestjoinfees_order')
                ->where('extension_id = ?', $this->getIdentity())
                ->limit(1));
            // Create a new product?
            if (!$this->_product) {
                $this->_product = $productTable->createRow();
                $this->_product->setFromArray($this->getProductParams());
                $this->_product->save();
            }
        }
        return $this->_product;
    }

    public function getOrder($params = array()){
		$select = $this->select()->where('owner_id =?',$params['owner_id'])->where('is_delete =?',0);
		return $this->fetchAll($select);
	}
	public function getOrderStatus($order_id = ''){
		return $this->select()
								->from($this->info('name'), new Zend_Db_Expr('COUNT(*)'))
								//->where('state =?', 'complete')
								->where('order_id =?',$order_id)
								->query()
								->fetchColumn();

	}
	public function checkRegistrationNumber($code = ''){
		if(!$code)
			$code = Engine_Api::_()->sesproduct()->generateTicketCode(8);;
		return $this->select()
								->from($this->info('name'), new Zend_Db_Expr('COUNT(*)'))
								->where('ragistration_number =?', $code)
								->query()
								->fetchColumn();

	}
	public function getOrders($params = array()){
		$orderTableName = $this->info('name');
		$productTableName = Engine_Api::_()->getItemTable('sesproduct')->info('name');
		$select = $this->select()->from($orderTableName)->where($orderTableName.'.is_delete =?',0)->where($productTableName.'.is_delete =?',0)->setIntegrityCheck(false)
		 						->joinLeft($productTableName, "$orderTableName.store_id = $productTableName.store_id", array());
		//$select->where('state =?','complete');
		 if(isset($params['viewer_id']))
		 	$select->where('owner_id =?',$params['viewer_id']);
		 if(isset($params['store_id']))
		 	$select->where($orderTableName.'.store_id =?',$params['store_id']);
		 if(isset($params['groupBy']))
		 	$select->group($params['groupBy']);
			if (isset($params['view_type'])) {
				$now = date("Y-m-d H:i:s");
				if ($params['view_type'] == 'current')
						$select->where("$productTableName.endtime >= '$now'");
			  else
						$select->where("$productTableName.endtime < ?", $now);
        $select->order('creation_date DESC');
			}
			$paginator = Zend_Paginator::factory($select);
			if (!empty($params['page']))
					$paginator->setCurrentPageNumber($params['page']);
			if (!empty($params['limit']))
					$paginator->setItemCountPerPage($params['limit']);
			return $paginator;
	}
	public function getTotalTicketSoldCount($params = array()){
		$orderTableName =  $this->info('name');
	  return $this->select()
					  ->from($orderTableName, new Zend_Db_Expr('SUM(total_tickets)'))
					  ->where('store_id =?', $params['store_id'])
						//->where('state =?',$params['state'])
					  ->limit(1)
					  ->query()
					  ->fetchColumn();
	}
	public function getSaleStats($params = array()){
		 $select = $this->select()
                    ->from($this->info('name'), array('total_amount'=>new Zend_Db_Expr("sum(total)"),'total_billingtax_cost' => new Zend_Db_Expr("sum(total_billingtax_cost)") ,'total_shippingtax_cost' => new Zend_Db_Expr("sum(total_shippingtax_cost)"),'totalAmountSale' => new Zend_Db_Expr("(sum(total_billingtax_cost) + sum(total_shippingtax_cost) + sum(total))")))
                ->where("store_id =?", $params['store_id'])
                ->where("state = 'complete'");
    if ($params['stats'] == 'month')
          $select->where("YEAR(creation_date) = YEAR(NOW()) AND MONTH(creation_date) = MONTH(NOW())");
    if ($params['stats'] == 'week')
          $select->where("YEARWEEK(creation_date) = YEARWEEK(CURRENT_DATE)");
	if ($params['stats'] == 'today')
          $select->where("DATE(creation_date) = DATE(NOW())");
	return $select->query()->fetchColumn();
	}
	public function getProductStats($params = array()) {
        $select = $this->select()
            ->from($this->info('name'), array('total_amount'=>new Zend_Db_Expr("sum(total)"),'totalOrder'=> new Zend_Db_Expr("COUNT(order_id)"),"commission_amount" => new Zend_Db_Expr("SUM(commission_amount)"), 'total_billingtax_cost' => new Zend_Db_Expr("sum(total_billingtax_cost)"),'total_shippingtax_cost' => new Zend_Db_Expr("sum(total_shippingtax_cost)"),'total_admintax_cost' => new Zend_Db_Expr("sum(total_admintax_cost)"),'total_products' => new Zend_Db_Expr("SUM(item_count)")))
            ->where('store_id =?',$params['store_id'])
            ->where("state = 'complete' OR state = 'processing'");
        return $select->query()->fetch();
	}
	public function manageOrders($params = array()){
        $addressTable =   Engine_Api::_()->getDbtable('addresses', 'sesproduct');
        $addressTableName = $addressTable->info('name');
		$orderTableName = $this->info('name');
		$select = $this->select()
		->from($this->info('name'));
		//->where("state = 'complete'");
		$userTableName = Engine_Api::_()->getItemTable('user')->info('name');
		$select ->setIntegrityCheck(false)->joinLeft($userTableName, "$orderTableName.user_id = $userTableName.user_id", array())
		->joinLeft($addressTableName, "$orderTableName.user_id = $addressTableName.user_id", array());

		 if (!empty($params['store_id']))
            $select->where($orderTableName . '.store_id =?', $params['store_id']);
        if(!empty($params['buyer_name'])){
            $select->where('CONCAT('.$addressTableName.'.first_name," ",'.$addressTableName.'.last_name) LIKE ?', '%' . $params['buyer_name'] . '%');
        }

		if (!empty($params['order_id']))
            $select->where($orderTableName . '.order_id =?', $params['order_id']);
        if (!empty($params['user_id']))
            $select->where($orderTableName . '.user_id =?', $params['user_id']);
		if (!empty($params['order_max']))
            $select->having("total <=?", $params['order_max']);
		if (!empty($params['order_min']))
            $select->having("total >=?", $params['order_min']);
		if (!empty($params['commision_min']))
            $select->where("$orderTableName.commission_amount >=?", $params['commision_min']);
		if (!empty($params['commision_max']))
            $select->where("$orderTableName.commission_amount <=?", $params['commision_max']);
		if (!empty($params['gateway']))
            $select->where($orderTableName . '.gateway_type LIKE ?', '%' . $params['gateway'] . '%');
		if(!empty($params['date_to']) && !empty($params['date_from']))
			$select->where("DATE($orderTableName.creation_date) BETWEEN '".$params['date_to']."' AND '".$params['date_from']."'");
		else{
			if (!empty($params['date_to']))
					$select->where("DATE($orderTableName.creation_date) >=?", $params['date_to']);
			if (!empty($params['date_from']))
					$select->where("DATE($orderTableName.creation_date) <=?", $params['date_from']);
		}
		$select->group($orderTableName.'.order_id');
		$select->order('order_id DESC');
		return $select;
	}
    public function productsOrders($params = array()){
         $addressTable =   Engine_Api::_()->getDbtable('addresses', 'sesproduct');
        $addressTableName = $addressTable->info('name');
        $productOrderTable = Engine_Api::_()->getDbtable('orderproducts', 'sesproduct')->info('name');
        $orderTableName = $this->info('name');
		$select = $this->select()
		->from($this->info('name'))
		->where($productOrderTable.'.product_id =?',$params['product_id']);
		//->where("state = 'complete'");
		$userTableName = Engine_Api::_()->getItemTable('user')->info('name');
		$select ->setIntegrityCheck(false)->joinLeft($userTableName, "$orderTableName.user_id = $userTableName.user_id",'*')
		->joinLeft($productOrderTable, "$productOrderTable.order_id = $orderTableName.order_id",'*')->joinLeft($addressTableName, "$orderTableName.user_id = $addressTableName.user_id", array())
		->group($orderTableName.'.order_id');

		if(!empty($params['buyer_name'])){
            $select->where('CONCAT('.$addressTableName.'.first_name," ",'.$addressTableName.'.last_name) LIKE ?', '%' . $params['buyer_name'] . '%');
        }
        if(!empty($params['email'])){
            $select->where($addressTableName . ".email LIKE "."'%".$params['email'] . "%'");
        }
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
        if(!empty($params['fetchAll']) && !empty($params['fetchAll']))
		  return $this->fetchAll($select);

		return $select;
	}

    public function getProductReportData($params = array()){
        $orderTableName = $this->info('name');
        $producttableName = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->info('name');
        $orderProduct = Engine_Api::_()->getDbtable('orderproducts', 'sesproduct');
        $orderProductTableName = Engine_Api::_()->getDbtable('orderproducts', 'sesproduct')->info('name');

        $select = $orderProduct->select()->from($orderProductTableName,array("title", "product_id"))->setIntegrityCheck(false);

        $select->joinLeft($orderTableName, "($orderTableName.order_id  = $orderProductTableName.order_id)", array('total_entertainment_tax' => new Zend_Db_Expr("sum(($orderProductTableName.price*".$orderProductTableName.".entertainment_tax * $orderProductTableName.quantity)/100)") ,'total_service_tax' => new Zend_Db_Expr("sum(($orderProductTableName.price*".$orderProductTableName.".service_tax* $orderProductTableName.quantity)/100)") ,'totalTaxAmount' =>new Zend_Db_Expr("(sum(($orderProductTableName.price*".$orderProductTableName.".service_tax* $orderProductTableName.quantity)/100) + sum(($orderProductTableName.price*".$orderProductTableName.".entertainment_tax* $orderProductTableName.quantity)/100))"),'totalAmountSale' => new Zend_Db_Expr("sum(((($orderProductTableName.price*".$orderProductTableName.".service_tax)/100 )* $orderProductTableName.quantity) + ((($orderProductTableName.price*".$orderProductTableName.".entertainment_tax)/100 )* $orderProductTableName.quantity) + $orderProductTableName.price* $orderProductTableName.quantity)"),'total_tickets' => new Zend_Db_Expr("SUM($orderProductTableName.quantity)"),"$orderProductTableName.creation_date"));

        $select->joinLeft($producttableName, "($producttableName.ticket_id  = $orderProductTableName.ticket_id)", null);
        if(!empty($params['product_id']))
            $select->where($orderProductTableName.'.product_id =?',$params['product_id']);
        if(isset($params['store_id']))
            $select->where($orderTableName.'.store_id =?',$params['store_id']);
        $select->where($orderProductTableName.'.state =?','complete');
        if(isset($params['type'])){
            if($params['type'] == 'month'){
                $select->where("DATE_FORMAT(" . $orderProductTableName . " .creation_date, '%Y-%m') <= ?", $params['enddate'])
                    ->where("DATE_FORMAT(" . $orderProductTableName . " .creation_date, '%Y-%m') >= ?", $params['startdate'])
                    ->group("$orderProductTableName.ticket_id")
                    ->group("YEAR($orderProductTableName.creation_date)")
                    ->group("MONTH($orderProductTableName.creation_date)");
            }else{
                $select->where("DATE_FORMAT(" . $orderProductTableName . " .creation_date, '%Y-%m-%d') <= ?", $params['enddate'])
                    ->where("DATE_FORMAT(" . $orderProductTableName . " .creation_date, '%Y-%m-%d') >= ?", $params['startdate'])
                    ->group("$orderProductTableName.ticket_id")
                    ->group("YEAR($orderProductTableName.creation_date)")
                    ->group("MONTH($orderProductTableName.creation_date)")
                    ->group("DAY($orderProductTableName.creation_date)");
            }
        }
        return $orderProduct->fetchAll($select);
    }

	public function getStoreReportData($params = array()){
		$orderTableName = $this->info('name');

		$select = $this->select()->from($orderTableName,array('total_orders'=>"COUNT(*)",'commission_amount' => new Zend_Db_Expr("sum(commission_amount)") ,'total_amount'=>new Zend_Db_Expr("sum(total)"),'total_billingtax_cost' => new Zend_Db_Expr("sum(total_billingtax_cost)"),'total_admintax_cost' => new Zend_Db_Expr("sum(total_admintax_cost)") ,'total_shippingtax_cost' => new Zend_Db_Expr("sum(total_shippingtax_cost)"),'totalAmountSale' => new Zend_Db_Expr("(sum(total_billingtax_cost) + sum(total_shippingtax_cost) + sum(total) - SUM(commission_amount))"),"$orderTableName.creation_date"));

		if(!empty($params['store_id']))
			$select->where($orderTableName.'.store_id =?',$params['store_id']);
		$select->where($orderTableName.'.state =?','complete');
		if(isset($params['type'])){
			if($params['type'] == 'month'){
				$select->where("DATE_FORMAT(" . $orderTableName . " .creation_date, '%Y-%m') <= ?", $params['enddate'])
							 ->where("DATE_FORMAT(" . $orderTableName . " .creation_date, '%Y-%m') >= ?", $params['startdate'])
							 ->group("$orderTableName.store_id")
							 ->group("YEAR($orderTableName.creation_date)")
							 ->group("MONTH($orderTableName.creation_date)");
			}else{
				$select->where("DATE_FORMAT(" . $orderTableName . " .creation_date, '%Y-%m-%d') <= ?", $params['enddate'])
							 ->where("DATE_FORMAT(" . $orderTableName . " .creation_date, '%Y-%m-%d') >= ?", $params['startdate'])
							 ->group("$orderTableName.store_id")
							 ->group("YEAR($orderTableName.creation_date)")
							 ->group("MONTH($orderTableName.creation_date)")
							 ->group("DAY($orderTableName.creation_date)");
			}
		}
		return $this->fetchAll($select);
	}
  public function getTotalCartPrice($orderId){
		$orderTableName = $this->info('name');
		return $this->select()->from($orderTableName,array('total_price' => new Zend_Db_Expr("sum(total)")))
              ->where($orderTableName.'.parent_order_id = ?',$orderId)
              ->query()
              ->fetchColumn();
	}
}
