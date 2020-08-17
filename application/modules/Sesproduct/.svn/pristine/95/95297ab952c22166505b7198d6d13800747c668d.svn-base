<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Remainingpayments.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Model_DbTable_Remainingpayments extends Engine_Db_Table {
  protected $_name = 'sesevent_remainingpayments';
	public function getStoreRemainingAmount($params = array()){
		$tabeleName = $this->info('name');
	 $select = $this->select()->from($tabeleName);
	 if(isset($params['store_id']))
	 	$select->where('store_id =?',$params['store_id']);
	 return $this->fetchRow($select);
	}
}
