<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: States.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_States extends Engine_Db_Table {

  protected $_rowClass = 'Courses_Model_State';
 function getCount($country_id){
    $select = $this->select()->where('country_id =?',$country_id);
    return count($this->fetchAll($select));
 }
 function getStates($params = array()){
     $select = $this->select()->where('status =?',1)->order('name ASC')->where('country_id =?',$params['country_id']);
     return $this->fetchAll($select);
 }
}
