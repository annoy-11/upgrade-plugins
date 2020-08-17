<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespaymentapi
 * @package    Sespaymentapi
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Userpayrequests.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespaymentapi_Model_DbTable_Refundrequests extends Engine_Db_Table {

  protected $_name = 'sespaymentapi_refundrequests';
  protected $_rowClass = "Sespaymentapi_Model_Refundrequest";

  public function getPaymentRequests($params = array()) {
  
    $tableName = $this->info('name');
    
    $select = $this->select()->from($tableName);
    
    if (isset($params['resource_id']))
      $select->where('resource_id =?', $params['resource_id']);
      
    if (isset($params['resource_type']))
      $select->where('resource_type =?', $params['resource_type']);
      
		if(isset($params['isPending']) && $params['isPending']) {
			$select->where('state =?', 'pending');
		} else {
      if (isset($params['state']) && $params['state'] == 'complete')
        $select->where('state =?', $params['state']);
		}
		
		$select->order('userpayrequest_id DESC');
    $select->where('is_delete	= ?', '0');
    return $this->fetchAll($select);
  }

  public function getRefundEntry($params = array()) {
  
    $select = $this->select()
                  ->where('transaction_id = ?', $params['transaction_id'])
                  ->where('state = "pending" || state = "complete" || state = "refund"')
                  ->limit(1);
    return $this->fetchRow($select);
  
  }
}
