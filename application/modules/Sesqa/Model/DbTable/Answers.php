<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Answers.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Model_DbTable_Answers extends Engine_Db_Table {
  protected $_rowClass = 'Sesqa_Model_Answer';
  function getAnswersPaginator($params = array()){
      return Zend_Paginator::factory($this->getAnswers($params));
  }
  public function getAnswers($params = array()){
    $select = $this->select()->from($this->info('name'),'*');
    
    if(!empty($params['user_id'])){
      $select->where('owner_id =?',$params['user_id']);  
    }
    if(!empty($params['question_id'])){
      $select->where('question_id =?',$params['question_id']);  
    }
    if(!empty($params['answer_id'])){
      $select->where('answer_id =?',$params['answer_id']);  
    }
    $select->order('creation_date DESC');
    if(!empty($params['paginator']))
      return $select;
    if(!empty($params['fetchAll'])){
      return $this->fetchAll($select);  
    }
  }
}