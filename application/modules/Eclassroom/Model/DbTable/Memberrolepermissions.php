<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Memberrolepermissions.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Model_DbTable_Memberrolepermissions extends Engine_Db_Table {
  public function getLevels($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('memberrole_id =?',$params['memberrole_id']);
    return $this->fetchAll($select);
  }
}
