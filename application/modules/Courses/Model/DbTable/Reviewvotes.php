<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Reviewvotes.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Model_DbTable_Reviewvotes extends Engine_Db_Table {

  protected $_rowClass = 'Courses_Model_Reviewvote';

  public function isReviewVote($params = array()) {
    $select = $this->select();
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if(!$viewer_id)
        return false;
    if (isset($params['course_id']))
      $select->where('course_id =?', $params['course_id']);
    $select->where('user_id =?',$viewer_id);
    if (isset($params['review_id']))
      $select->where('review_id =?', $params['review_id']);
    if (isset($params['type']))
      $select->where('type =?', $params['type']);
    return $select->limit(1)->query()
                    ->fetchColumn();
  }

}
