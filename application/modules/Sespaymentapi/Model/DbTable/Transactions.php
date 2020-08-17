<?php

class Sespaymentapi_Model_DbTable_Transactions extends Engine_Db_Table {

  protected $_rowClass = 'Sespaymentapi_Model_Transaction';
  
	
	public function manageTransactions($params = array()) {

    $userTableName = Engine_Api::_()->getItemTable('user')->info('name');
		$orderTableName = $this->info('name');
		
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($orderTableName)
            ->joinLeft($userTableName, "$orderTableName.user_id = $userTableName.user_id", 'displayname')
            ->where($orderTableName . '.user_id = ?', $params['user_id'])
            ->where($orderTableName.'.state = "complete" || state = "okay" || state = "active"')
            ->order('order_id DESC');
		
		if (!empty($params['transaction_id']))
				$select->where($orderTableName . '.transaction_id =?', $params['transaction_id']);	

		if (!empty($params['order_max']))
				$select->having("total_amount <=?", $params['order_max']);
		if (!empty($params['order_min']))
				$select->having("total_amount >=?", $params['order_min']);
				
// 		if (!empty($params['email']))
// 				$select->where($orderTableName . '.email  LIKE ?', '%' . $params['email'] . '%');
// 				
// 		if (!empty($params['buyer_name']))
// 				$select->where($userTableName . '.displayname  LIKE ?', '%' . $params['buyer_name'] . '%');
				
		if(!empty($params['date_to']) && !empty($params['date_from'])) {
			$select->where("DATE($orderTableName.timestamp) BETWEEN '".$params['date_to']."' AND '".$params['date_from']."'");
    } else {
			if (!empty($params['date_to']))
					$select->where("DATE($orderTableName.timestamp) >=?", $params['date_to']);
			if (!empty($params['date_from']))
					$select->where("DATE($orderTableName.timestamp) <=?", $params['date_from']);	
		}
		
		return $select;
	}
	
	public function manageSubscribers($params = array()) {

    $userTableName = Engine_Api::_()->getItemTable('user')->info('name');
		$orderTableName = $this->info('name');
		
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($orderTableName)
            ->joinLeft($userTableName, "$orderTableName.user_id = $userTableName.user_id", 'displayname')
            ->where($orderTableName . '.resource_id = ?', $params['resource_id'])
            ->where($orderTableName . '.resource_type = ?', $params['resource_type'])
            ->where($orderTableName.'.state = "complete" || state = "okay" || state = "active"')
            ->order('order_id DESC');

		if (!empty($params['subscriber_email']))
				$select->where($orderTableName . '.email  LIKE ?', '%' . $params['subscriber_email'] . '%');

		if (!empty($params['subscriber_name']))
				$select->where($userTableName . '.displayname  LIKE ?', '%' . $params['subscriber_name'] . '%');

		return $select;
	}
	
 	public function getItemTransaction($params = array()) {

		$tableName = $this->info('name');
		$select = $this->select()
                  ->from($tableName)
                  ->where('user_id =?', $params['user_id'])
                  //->where('gateway_profile_id !=?','')
                  ->where('resource_id =?', $params['resource_id'])
                  ->order('transaction_id DESC')
                  ->limit(1);

		if(empty($params['noCondition'])){
			$select->where('state = "pending" || state = "complete" || state = "okay" || state = "active" ');	
		} else if(!empty($params['noCondition'])) {
      $select->where('state = "complete" || state = "okay" || state = "active"');
		}

		return $this->fetchRow($select);
	}

  public function getBenefitStatus(User_Model_User $user = null)
  {
    // Get benefit setting
    $benefitSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('payment.benefit');
    if( !in_array($benefitSetting, array('all', 'some', 'none')) ) {
      $benefitSetting = 'all';
    }

    switch( $benefitSetting ) {
      default:
      case 'all':
        return true;
        break;

      case 'some':
        if( !$user ) {
          return false;
        }
        return (bool) $this->select()
          ->from($this, new Zend_Db_Expr('TRUE'))
          ->where('user_id = ?', $user->getIdentity())
          ->where('type = ?', 'payment')
          ->where('status = ?', 'okay')
          ->limit(1);
        break;

      case 'none':
        return false;
        break;
    }

    return false;
  }
}