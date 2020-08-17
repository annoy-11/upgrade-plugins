<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Managesearchoptions.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_Model_DbTable_Managesearchoptions extends Engine_Db_Table {

  protected $_rowClass = "Einstaclone_Model_Managesearchoption";

  public function hasType($params = array()) {

    return $this->select()
                    ->from($this->info('name'), array('managesearchoption_id'))
                    ->where('type =?', $params['type'])
                    ->query()
                    ->fetchColumn();
  }

  public function getAllSearchOptions($params = array()) {

    $select = $this->select()->order('order ASC');

    if (isset($params['enabled']) && !empty($params['enabled'])) {
      $select = $select->where('enabled = ?', 1);
    }
    if (isset($params['limit']) && !empty($params['limit'])) {
      $select->limit($params['limit']);
    }
    return $this->fetchAll($select);
  }

}
