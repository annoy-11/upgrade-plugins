<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Usertests.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Usertests extends Core_Model_Item_DbTable_Abstract {

    protected $_rowClass = "Courses_Model_Usertest";
    protected $_type = 'courses_usertests';
    public function countAnswers($userId = null) {
        $count = $this->select()->from($this->info('name'), array("COUNT(testquestion_id)"));
        if ($userId)
        $count->where('owner_id =?', $userId);
        return $count->query()->fetchColumn();
    }
    public function addMoreAnswers($testquestion_id) {
        $count = $this->select()->from($this->info('name'), array("COUNT(testquestion_id)"));
        if (isset($params['testquestion_id']) && !empty($params['testquestion_id']))
        $count->where('testquestion_id =?', $params['testquestion_id']); echo $count;die;
        return $count->query()->fetchColumn();
    }
    public function getUserTestPaginator($params = array(),$customFields = array('*'))
    {
        return Zend_Paginator::factory($this->getUserTestSelect($params ,$customFields));
    }
    public function getUserTestSelect($params = array(),$customFields = array('*'))
    {
        $questionTableName = $this->info('name');
        $select = $this->select()->from($questionTableName,$customFields)->setIntegrityCheck(false)->joinLeft('engine4_courses_userquestions', "$questionTableName.usertest_id = engine4_courses_userquestions.usertest_id",array('userquestion_id','testanswers','testquestion_id','is_true','is_attempt'));
        if( !empty($params['usertest_id']) && is_numeric($params['usertest_id']) )
            $select->where($questionTableName.'.usertest_id = ?', $params['usertest_id']);
        //End Custom Field Fieltering Work
        if (isset($params['user_id']))
          $select->where($questionTableName.'.user_id = ?', $params['user_id']);
        if (isset($params['limit']))
          $select->limit($params['limit']);
        $select->order($questionTableName . '.usertest_id DESC');
        if (isset($params['fetchAll'])) {
            return $this->fetchAll($select);
        } else {
            return $select;
        }
    }
    public function manageTest($params = array(),$customFields = array('*'))
    {
        $questionTableName = $this->info('name');
        $select = $this->select($customFields)->setIntegrityCheck(false)->joinLeft('engine4_courses_tests', "$questionTableName.test_id = engine4_courses_tests.test_id",null);
        if( !empty($params['usertest_id']) && is_numeric($params['usertest_id']) )
            $select->where($questionTableName.'.usertest_id = ?', $params['usertest_id']);
        //End Custom Field Fieltering Work
        if (isset($params['title']))
          $select->where('engine4_courses_tests.title LIKE ?', '%' . $params['title'] . '%');
        if (isset($params['is_passed']))
          $select->where($questionTableName.'.is_passed LIKE ?', '%' . $params['is_passed'] . '%');
        if(!empty($params['date_to']) && !empty($params['date_from']))
          $select->where("DATE($questionTableName.test_start) BETWEEN '".$params['date_to']."' AND '".$params['date_from']."'");
        if (isset($params['user_id']))
          $select->where($questionTableName.'.user_id = ?', $params['user_id']);
        if (isset($params['limit']))
          $select->limit($params['limit']);
        $select->order($questionTableName . '.usertest_id DESC');
        if (isset($params['fetchAll'])) {
            return $this->fetchAll($select);
        } else {
            return $select;
        }
    }
}
