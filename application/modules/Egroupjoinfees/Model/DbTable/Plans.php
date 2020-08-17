<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Order.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Egroupjoinfees_Model_DbTable_Plans extends Engine_Db_Table {
  protected $_rowClass = "Egroupjoinfees_Model_Plan";
	public function getPlan($groupId){
		$select = $this->select('*')->where('group_id =?',$groupId);
		return $this->fetchRow($select);
	}

}
