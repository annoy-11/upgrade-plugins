<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Userpayrequests.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Userpayrequests extends Engine_Db_Table {

  protected $_name = 'sesproduct_userpayrequests';
  protected $_rowClass = "Sesproduct_Model_Userpayrequest";

  public function getPaymentRequests($params = array()) {
    $tabeleName = $this->info('name');
    $select = $this->select()->from($tabeleName);
    if (isset($params['store_id']))
      $select->where('store_id =?', $params['store_id']);
		if(isset($params['isPending']) && $params['isPending']){
			$select->where('state =?', 'pending');
		}else{
             if (isset($params['state']) && $params['state'] == 'complete')
              $select->where('state =?', $params['state']);
		}
		$select->order('userpayrequest_id DESC');
    $select->where('is_delete	= ?', '0');
   // echo $select;die;
    return $this->fetchAll($select);
  }
}
