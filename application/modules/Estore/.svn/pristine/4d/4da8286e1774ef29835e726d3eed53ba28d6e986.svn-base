<?php

class Estore_Model_DbTable_Reviewvotes extends Engine_Db_Table {

  protected $_rowClass = 'Estore_Model_Reviewvote';

  public function isReviewVote($params = array()) {
    $select = $this->select();
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if(!$viewer_id)
        return false;
   // if (isset($params['store_id']))
     // $select->where('store_id =?', $params['store_id']);
    $select->where('user_id =?',$viewer_id);
    if (isset($params['review_id']))
      $select->where('review_id =?', $params['review_id']);

    if (isset($params['type']))
      $select->where('type =?', $params['type']);

    return $select->limit(1)->query()
                    ->fetchColumn();
  }

}
