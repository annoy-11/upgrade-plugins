<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Dashboards.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Model_DbTable_Dashboards extends Engine_Db_Table {

  protected $_rowClass = "Sesproduct_Model_Dashboard";

  public function getDashboardsItems($params = array()) {

    $select = $this->select()
							    ->from($this->info('name'));
		if(isset($params['type'])) {
			$select = $select->where('type =?', $params['type']);

	    return $this->fetchRow($select);

	    }  else {
	    return $this->fetchAll($select);
	    }
  }
}
