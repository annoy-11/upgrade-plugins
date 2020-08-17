<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Reviewvotes.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Model_DbTable_Reviewvotes extends Engine_Db_Table {

  protected $_rowClass = 'Sesmember_Model_Reviewvote';

  public function isReviewVote($params = array()) {
    $select = $this->select();
    if (isset($params['user_id']))
      $select->where('user_id =?', $params['user_id']);

    if (isset($params['review_id']))
      $select->where('review_id =?', $params['review_id']);

    if (isset($params['type']))
      $select->where('type =?', $params['type']);

    return $select->limit(1)->query()
                    ->fetchColumn();
  }

}