<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Countries.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Countries extends Engine_Db_Table {
  protected $_rowClass = 'Courses_Model_Country';
  function getCountries(){
      $select = $this->select()->where('status =?',1)->order('name ASC');
      return $this->fetchAll($select);

  }
}
