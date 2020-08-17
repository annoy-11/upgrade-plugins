<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Reviewvotes.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagereview_Model_DbTable_Reviewvotes extends Engine_Db_Table {

  protected $_rowClass = 'Sespagereview_Model_Reviewvote';

  public function isReviewVote($params = array()) {
    $select = $this->select();
    if (isset($params['user_id']))
      $select->where('user_id =?', $params['user_id']);
    if (isset($params['review_id']))
      $select->where('review_id =?', $params['review_id']);
    if (isset($params['type']))
      $select->where('type =?', $params['type']);
    return $select->limit(1)->query()->fetchColumn();
  }

}