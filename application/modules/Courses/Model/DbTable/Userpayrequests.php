<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Userpayrequests.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Userpayrequests extends Engine_Db_Table {

  protected $_name = 'courses_userpayrequests';
  protected $_rowClass = "Courses_Model_Userpayrequest";

  public function getPaymentRequests($params = array()) {
    $tabeleName = $this->info('name');
    $select = $this->select()->from($tabeleName);
    if (isset($params['course_id']))
      $select->where('course_id =?', $params['course_id']);
		if(isset($params['isPending']) && $params['isPending']){
			$select->where('state =?', 'pending');
		}else{
      if (isset($params['state']) && $params['state'] == 'complete')
      $select->where('state =?', $params['state']);
		}
		$select->order('userpayrequest_id DESC');
    $select->where('is_delete	= ?', '0');
   // echo $select;die;
    return $this->fetchAll($select);
  }
}
