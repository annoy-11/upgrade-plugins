<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Dashboards.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Epetition_Model_DbTable_Dashboards extends Engine_Db_Table {

  protected $_rowClass = "Epetition_Model_Dashboard";

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
