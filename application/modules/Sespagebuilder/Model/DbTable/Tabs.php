<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tabs.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Model_DbTable_Tabs extends Engine_Db_Table {

  public function getTabs($params = array()) { 
    
    $select = $this->select();
    
    if(isset($params['column_name']))
      $select->from($this->info('name'), $params['column_name']);
  
    return $this->fetchAll($select);
  }
  
  public function getParams($tabId) {
     $select = $this->select()->from($this->info('name'),array('*'))
           ->where('tab_id =?',$tabId);
     return $this->fetchRow($select);
  }
}