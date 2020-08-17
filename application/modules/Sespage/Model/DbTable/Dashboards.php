<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Dashboards.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Model_DbTable_Dashboards extends Engine_Db_Table {

  protected $_rowClass = "Sespage_Model_Dashboard";

  public function getDashboardsItems($params = array()) {
    $select = $this->select()->from($this->info('name'));
    if (isset($params['type'])) {
      $select = $select->where('type =?', $params['type']);
      return $this->fetchRow($select);
    }else if(!empty($params['action_name'])){
        $select = $select->where('action_name =?', $params['action_name']);
        if($params['type'] == "edit_photo"){
        echo $select;die;
        }
      return $this->fetchRow($select);
    } else {
      return $this->fetchAll($select);
    }
  }

}
