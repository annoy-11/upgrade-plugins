<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Dashboards.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Model_DbTable_Dashboards extends Engine_Db_Table {

  protected $_rowClass = "Sesrecipe_Model_Dashboard";
  
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