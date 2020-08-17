<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Testanswers.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Testanswers extends Core_Model_Item_DbTable_Abstract {

    protected $_rowClass = "Courses_Model_Testanswer";
    protected $_type = 'courses_testanswers';
    public function countAnswers($userId = null) {
        $count = $this->select()->from($this->info('name'), array("COUNT(testquestion_id)"));
        if ($userId)
        $count->where('owner_id =?', $userId);
        return $count->query()->fetchColumn();
    }
    public function addMoreAnswers($testquestion_id) {
        $count = $this->select()->from($this->info('name'), array("COUNT(testquestion_id)"));
        $count->where('testquestion_id =?', $testquestion_id);
        $count->where('is_true =?', 1);
        return $count->query()->fetchColumn();
    }
    public function getAnswersPaginator($params = array())
    {
        return Zend_Paginator::factory($this->getAnswersSelect($params));
    }
    public function getAnswersSelect($params = array(),$customFields = array('*'))
    {
        $questionTableName = $this->info('name');
        $select = $this->select($customFields);
        if( !empty($params['testquestion_id']) && is_numeric($params['testquestion_id']) )
            $select->where($questionTableName.'.testquestion_id = ?', $params['testquestion_id']);
        //End Custom Field Fieltering Work
        if (isset($params['is_true']))
           $select->where($questionTableName.'.is_true = ?',1);
        if (isset($params['limit']))
          $select->limit($params['limit']);
          $select->order($questionTableName . '.testanswer_id DESC');
        if (isset($params['fetchAll'])) {
            return $this->fetchAll($select);
        } else {
            return $select;
        }
    }
}
