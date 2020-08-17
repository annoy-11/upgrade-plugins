<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Collactions.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Model_DbTable_Callactions extends Engine_Db_Table {

  public function getCallactions($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('classroom_id =?', $params['classroom_id']);
   return $this->fetchRow($select);
  }
}
