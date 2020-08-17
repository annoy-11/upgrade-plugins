<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Userpayrequest.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Egroupjoinfees_Model_DbTable_Userpayrequests extends Engine_Db_Table {

  protected $_name = 'egroupjoinfees_userpayrequests';
  protected $_rowClass = "Egroupjoinfees_Model_Userpayrequest";

  public function getPaymentRequests($params = array()) {
    $tabeleName = $this->info('name');
    $select = $this->select()->from($tabeleName);
    if (isset($params['group_id']))
      $select->where('group_id =?', $params['group_id']);
		if(isset($params['isPending']) && $params['isPending']){
			$select->where('state =?', 'pending');
		}else{
    if (isset($params['state']) && $params['state'] == 'complete')
      $select->where('state =?', $params['state']);
    else  if (isset($params['state']) && $params['state'] == 'both')
      $select->where('state = "complete" || state = "cancelled"');
		}
		$select->order('userpayrequest_id DESC');
    $select->where('is_delete	= ?', '0');
    return $this->fetchAll($select);
  }
}
