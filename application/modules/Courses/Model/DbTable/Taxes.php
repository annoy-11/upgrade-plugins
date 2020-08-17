<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Taxes.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Taxes extends Engine_Db_Table {
  protected $_rowClass = 'Courses_Model_Tax';
  function getTaxes($params = array()){
      $select = $this->select();
      if(!empty($params['is_admin'])){
          $select->where('is_admin =?',$params['is_admin']);
      }
      if(!empty($params['course_id'])){
          $select->where('course_id =?',$params['course_id']);
      }
      $select->order('tax_id DESC');
      return Zend_Paginator::factory($select);
  }
}
