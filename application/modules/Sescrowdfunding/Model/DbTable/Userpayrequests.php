<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Userpayrequests.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfunding_Model_DbTable_Userpayrequests extends Engine_Db_Table {

  protected $_name = 'sescrowdfunding_userpayrequests';
  protected $_rowClass = "Sescrowdfunding_Model_Userpayrequest";

  public function getPaymentRequests($params = array()) {
    $tabeleName = $this->info('name');
    $select = $this->select()->from($tabeleName);
    if (isset($params['crowdfunding_id']))
      $select->where('crowdfunding_id =?', $params['crowdfunding_id']);
		if(isset($params['isPending']) && $params['isPending']){
			$select->where('state =?', 'pending');
		}else{
    if (isset($params['state']) && $params['state'] == 'complete')
      $select->where('state =?', $params['state']);
		}
		$select->order('userpayrequest_id DESC');
    $select->where('is_delete	= ?', '0');
    return $this->fetchAll($select);
  }
}
