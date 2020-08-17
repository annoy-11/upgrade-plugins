<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Remainingpayments.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Model_DbTable_Remainingpayments extends Engine_Db_Table {
  protected $_name = 'courses_remainingpayments';
	public function getCourseRemainingAmount($params = array()){
    $tabeleName = $this->info('name');
    $select = $this->select()->from($tabeleName);
    if(isset($params['course_id']))
      $select->where('course_id =?',$params['course_id']);
    return $this->fetchRow($select);
	}
}
