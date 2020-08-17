<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Cartcourses.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Cartcourses extends Engine_Db_Table {
   protected $_rowClass = "Courses_Model_Cartcourse";
   protected $_type = 'sescourse_cartcourses';
   function checkcourseadded($params = array()){
        $courseTable = Engine_Api::_()->getDbtable('courses', 'courses');
        $courseTableName =$courseTable->info('name');
        $cartTable = $this->info('name');
        $select = $this->select()
        ->setIntegrityCheck(false)
        ->from($cartTable);
        if(!empty($params['cart_id'])){
            $select->where('cart_id =?',$params['cart_id']);
        }
        if(!empty($params['course_id'])){
           $select->where('course_id =?',$params['course_id']);
        }
        if($params['limit']){
            $select->joinLeft($courseTableName, $courseTableName . '.course_id = ' . $cartTable . '.course_id')
            ->query();
            return $this->fetchAll($select);
        }
        $select->limit(1);
        return $this->fetchRow($select);
   }
}
