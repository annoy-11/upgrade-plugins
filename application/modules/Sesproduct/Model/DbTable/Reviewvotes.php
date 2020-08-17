<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Reviewvotes.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Model_DbTable_Reviewvotes extends Engine_Db_Table {

  protected $_rowClass = 'Sesproduct_Model_Reviewvote';

  public function isReviewVote($params = array()) {
    $select = $this->select();
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if(!$viewer_id)
        return false;
    //if (isset($params['product_id']))
      //$select->where('product_id =?', $params['product_id']);
    $select->where('user_id =?',$viewer_id);
    if (isset($params['review_id']))
      $select->where('review_id =?', $params['review_id']);

    if (isset($params['type']))
      $select->where('type =?', $params['type']);

    return $select->limit(1)->query()
                    ->fetchColumn();
  }

}
