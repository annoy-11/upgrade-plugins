<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Dashboards.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Model_DbTable_Dashboards extends Engine_Db_Table {

  protected $_rowClass = "Sesarticle_Model_Dashboard";
  
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