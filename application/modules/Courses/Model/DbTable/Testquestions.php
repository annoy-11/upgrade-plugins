<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Testquestions.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Testquestions extends Core_Model_Item_DbTable_Abstract {

  protected $_rowClass = "Courses_Model_Testquestion";
  protected $_type = 'courses_testquestions';
  public function countQuestions($testId = null) {
    $count = $this->select()->from($this->info('name'), array("COUNT(testquestion_id)"));
    if ($testId)
      $count->where('test_id =?', $testId);
    return $count->query()->fetchColumn();
  }
  public function getQuestionInfo($params = array())
  {
    $count = $this->select()->from($this->info('name'), array("COUNT(testquestion_id)"));
    if ($userId)
      $count->where('owner_id =?', $userId);
    return $count->query()->fetchColumn();
  }
  public function getQuestionsPaginator($params = array())
  {

    return Zend_Paginator::factory($this->getQuestionsSelect($params));
  }

  public function getQuestionsSelect($params = array(),$customFields = array('*'))
  {
    $questionTableName = $this->info('name');
     $select = $this->select($customFields);
    if( !empty($params['test_id']) && is_numeric($params['test_id']) )
        $select->where($questionTableName.'.test_id = ?', $params['test_id']);

    //End Custom Field Fieltering Work
    if (isset($params['limit']))
      $select->limit($params['limit']);
    $select->order($questionTableName . '.testquestion_id DESC');
    if (isset($params['fetchAll'])) {
      return $this->fetchAll($select);
    } else {
      return $select;
    }
  }
}
