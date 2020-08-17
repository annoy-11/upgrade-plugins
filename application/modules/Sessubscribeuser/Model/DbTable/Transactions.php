<?php

class Sessubscribeuser_Model_DbTable_Transactions extends Engine_Db_Table {

  protected $_rowClass = 'Sessubscribeuser_Model_Transaction';
  
  
 	public function getItemTransaction($params = array()) {

		$tableName = $this->info('name');
		$select = $this->select()
                  ->from($tableName)
                  ->where('user_id =?', $params['user_id'])
                  //->where('gateway_profile_id !=?','')
                  ->where('subject_id =?', $params['subject_id'])
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