<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Orders.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Model_DbTable_Orders extends Engine_Db_Table {

  protected $_rowClass = "Sescrowdfunding_Model_Order";

	public function getOrder($params = array()) {

		$select = $this->select()->where('owner_id =?',$params['owner_id'])->where('is_delete =?',0);
		return $this->fetchAll($select);
	}

	public function getAllDonations($params = array()) {

		$select = $this->select()->where('state =?', 'complete');

		if(isset($params['owner_id']) && $params['owner_id']) {
            $select = $select->where('user_id =?', $params['owner_id']);
		}

		if(isset($params['crowdfundingIds']) && $params['crowdfundingIds']) {
            $select = $select->where('crowdfunding_id IN (?)', $params['crowdfundingIds']);
            $select = $select->order('order_id DESC');
		}


		return $select;
	}

	public function getCrowdfundingTotalAmount($params = array()) {

		$select = $this->select()
                  ->from($this->info('name'), "SUM(total_useramount)")
                  ->where('state =?', 'complete')
                  ->where('crowdfunding_id =?', $params['crowdfunding_id']);
		return $select->query()->fetchColumn();
	}

	public function getAllDoners($params = array()) {


	$select = $this->select()
                  ->from($this->info('name'), array('*','total_amount'=>new Zend_Db_Expr("sum(total_amount)"),new Zend_Db_Expr('COUNT(user_id) as topDonors'), 'user_id'))
                  ->where('state =?', 'complete')
                  ->where('crowdfunding_id =?', $params['crowdfunding_id'])
                  ->group('user_id')
                  ->order('topDonors DESC');

    if(isset($params['itemCount']) && !empty($params['itemCount'])) {
      $select = $select->limit($params['itemCount']);
    }

    if(isset($params['order']) && $params['order'] == 'recent') {
      $select = $select->order('creation_date DESC');
    }

    if(empty($params['fetchAll'])) {

      $paginator = Zend_Paginator::factory($select);

      if (!empty($params['page']))
        $paginator->setCurrentPageNumber($params['page']);

      if (!empty($params['itemCount']))
        $paginator->setItemCountPerPage($params['itemCount']);

      return $paginator;
    } else {
      return $this->fetchAll($select);
		}
	}

	public function getDoners($params = array()) {

		$select = $this->select()
                  ->from($this->info('name'), new Zend_Db_Expr('COUNT(*)'))
                  ->where('state =?', 'complete')
                  ->where('crowdfunding_id =?', $params['crowdfunding_id']);
		return $select->query()->fetchColumn();
	}

	public function getOrderStatus($order_id = '') {

		return $this->select()
								->from($this->info('name'), new Zend_Db_Expr('COUNT(*)'))
								->where('state =?', 'complete')
								->where('order_id =?',$order_id)
								->query()
								->fetchColumn();

	}

	public function getOrderId($params = array()) {

		return $this->select()
								->from($this->info('name'), 'order_id')
								->where('state =?', 'complete')
								->where('crowdfunding_id =?', $params['crowdfunding_id'])
								->where('user_id =?', $params['user_id'])
								->query()
								->fetchColumn();

	}

  public function getCrowdfundingStats($params = array()) {

	 $select = $this->select()
                  ->from($this->info('name'), array('totalOrder'=> new Zend_Db_Expr("COUNT(order_id)") ,'totalAmountSale' => new Zend_Db_Expr("(sum(total_useramount))"), "commission_amount" => new Zend_Db_Expr("SUM(commission_amount)")))
                  ->where('crowdfunding_id =?',$params['crowdfunding_id'])
                  ->where("state = 'complete'");
		return $select->query()->fetch();
	}

  public function getSaleStats($params = array()) {

		 $select = $this->select()
                  ->from($this->info('name'), array('total_amount'=>new Zend_Db_Expr("sum(total_useramount)"), 'totalAmountSale' => new Zend_Db_Expr("sum(total_useramount)")))
                  ->where("crowdfunding_id =?", $params['crowdfunding_id'])
                  ->where("state = 'complete'");

		if ($params['stats'] == 'month')
          $select->where("YEAR(creation_date) = YEAR(NOW()) AND MONTH(creation_date) = MONTH(NOW())");

    if ($params['stats'] == 'week')
          $select->where("YEARWEEK(creation_date) = YEARWEEK(CURRENT_DATE)");

		if ($params['stats'] == 'today')
          $select->where("DATE(creation_date) = DATE(NOW())");

    return $select->query()->fetchColumn();
	}

  public function topAllDoners($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), array(new Zend_Db_Expr('COUNT(user_id) as topDonors'), 'creation_date', 'user_id', new Zend_Db_Expr("SUM(total_useramount) as total_useramount")))
            ->where('state =?', 'complete')
            ->group('user_id')
            ->order('total_useramount DESC');

    if(isset($params['itemCount']) && !empty($params['itemCount'])) {
      $select = $select->limit($params['itemCount']);
    }

    if(empty($params['fetchAll'])) {

      $paginator = Zend_Paginator::factory($select);

      if (!empty($params['page']))
        $paginator->setCurrentPageNumber($params['page']);

      if (!empty($params['itemCount']))
        $paginator->setItemCountPerPage($params['itemCount']);

      return $paginator;
    }
	}

  public function getReportData($params = array()) {

		$orderTableName = $this->info('name');

		$select = $this->select()
                  ->from($this->info('name'), array('total_useramount', 'crowdfunding_id', 'user_id', 'creation_date'))
                  ->setIntegrityCheck(false)
                  ->where($orderTableName.'.state =?','complete')
                  ->where($orderTableName.'.crowdfunding_id =?',$params['crowdfunding_id']);

		if(isset($params['type'])) {
			if($params['type'] == 'month') {
				$select->where("DATE_FORMAT(" . $orderTableName . " .creation_date, '%Y-%m') <= ?", $params['enddate'])
							 ->where("DATE_FORMAT(" . $orderTableName . " .creation_date, '%Y-%m') >= ?", $params['startdate'])
              ->group("$orderTableName.user_id")
							->group("YEAR($orderTableName.creation_date)")
							->group("MONTH($orderTableName.creation_date)");
			} else {
				$select->where("DATE_FORMAT(" . $orderTableName . " .creation_date, '%Y-%m-%d') <= ?", $params['enddate'])
              ->where("DATE_FORMAT(" . $orderTableName . " .creation_date, '%Y-%m-%d') >= ?", $params['startdate'])
              ->group("$orderTableName.user_id")
							->group("YEAR($orderTableName.creation_date)")
							->group("MONTH($orderTableName.creation_date)")
							->group("DAY($orderTableName.creation_date)");
			}
		}

		return $this->fetchAll($select);
	}
}
