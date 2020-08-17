<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Memberroles.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Memberroles extends Engine_Db_Table {
  protected $_rowClass = 'Courses_Model_Memberrole';
  protected $_searchTriggers = false;
  public function getLevels($params = array()) {
    $select = $this->select()
            ->from($this->info('name'));
    if(!empty($params['status']))
      $select->where('active =?',1);
    return $this->fetchAll($select);
  }
}
