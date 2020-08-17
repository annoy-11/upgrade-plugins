<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Remainingpayments.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Egroupjoinfees_Model_DbTable_Remainingpayments extends Engine_Db_Table {
  protected $_name = 'egroupjoinfees_remainingpayments';
	public function getGroupRemainingAmount($params = array()){
		$tabeleName = $this->info('name');
	 $select = $this->select()->from($tabeleName);
	 if(isset($params['group_id']))
	 	$select->where('group_id =?',$params['group_id']);	 
	 return $this->FetchRow($select);
	}
}
