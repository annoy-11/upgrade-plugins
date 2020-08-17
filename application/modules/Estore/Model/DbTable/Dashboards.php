<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Dashboards.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Dashboards extends Engine_Db_Table {

  protected $_rowClass = "Estore_Model_Dashboard";

  public function getDashboardsItems($params = array()) {
    $select = $this->select()->from($this->info('name'))->order('action_name ASC');
    if (isset($params['type'])) {
      $select = $select->where('type =?', $params['type']);
      return $this->fetchRow($select);
    }else if(!empty($params['action_name'])){
        $select = $select->where('action_name =?', $params['action_name']);
      return $this->fetchRow($select);
    } else {
      return $this->fetchAll($select);
    }
  }

}
