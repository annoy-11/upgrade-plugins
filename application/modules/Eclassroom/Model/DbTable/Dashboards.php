<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Dashboards.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Model_DbTable_Dashboards extends Engine_Db_Table {

  protected $_rowClass = "Eclassroom_Model_Dashboard";

  public function getDashboardsItems($params = array(),$customFields = array('*')) {
    $select = $this->select()->from($this->info('name'),$customFields)->order('action_name ASC');
    if (isset($params['type'])) {
      $select = $select->where('type =?', $params['type']);
      return $this->fetchRow($select);
    }else if(!empty($params['action_name'])){
        $select = $select->where('action_name =?', $params['action_name']);
      return $this->fetchRow($select);
    }else if(!empty($params['resource_type'])){
        $select = $select->where('resource_type =?', $params['resource_type']);
      return $this->fetchAll($select);
    } else {
      return $this->fetchAll($select);
    }
  }

}
