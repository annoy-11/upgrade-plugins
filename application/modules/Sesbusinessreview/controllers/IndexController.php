<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessreview_IndexController extends Core_Controller_Action_Standard {

  function reviewVotesAction() {

    $viewer_id = $this->view->viewer()->getIdentity();
    if ($viewer_id == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
    $item_id = $this->_getParam('id');
    $type = $this->_getParam('type');
    if (intval($item_id) == 0 || ($type != 1 && $type != 2 && $type != 3)) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $itemTable = Engine_Api::_()->getItemTable('businessreview');
    $tableVotes = Engine_Api::_()->getDbtable('reviewvotes', 'sesbusinessreview');
    $tableMainVotes = $tableVotes->info('name');

    $select = $tableVotes->select()
            ->from($tableMainVotes)
            ->where('review_id = ?', $item_id)
            ->where('user_id = ?', $viewer_id)
            ->where('type =?', $type);
    $result = $tableVotes->fetchRow($select);
    if ($type == 1)
      $votesTitle = 'useful_count';
    else if ($type == 2)
      $votesTitle = 'funny_count';
    else
      $votesTitle = 'cool_count';

    if (count($result) > 0) {
      //delete		
      $db = $result->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $result->delete();
        $itemTable->update(array($votesTitle => new Zend_Db_Expr($votesTitle . ' - 1')), array('review_id = ?' => $item_id));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $selectReview = $itemTable->select()->where('review_id =?', $item_id);
      $review = $itemTable->fetchRow($selectReview);

      //get review owner
      $businessId = $review->business_id;
      $sesbusiness = Engine_Api::_()->getItemTable('businesses');
      $sesbusiness->update(array($votesTitle => new Zend_Db_Expr($votesTitle . ' - 1')), array('business_id = ?' => $businessId));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $review->{$votesTitle}));
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('reviewvotes', 'sesbusinessreview')->getAdapter();
      $db->beginTransaction();
      try {
        $votereview = $tableVotes->createRow();
        $votereview->user_id = $viewer_id;
        $votereview->review_id = $item_id;
        $votereview->type = $type;
        $votereview->save();
        $itemTable->update(array($votesTitle => new Zend_Db_Expr($votesTitle . ' + 1')), array('review_id = ?' => $item_id));
        //Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //Send notification and activity feed work.
      $selectReview = $itemTable->select()->where('review_id =?', $item_id);
      $review = $itemTable->fetchRow($selectReview);

      //get review owner
      $businessId = $review->business_id;
      $sesbusiness = Engine_Api::_()->getItemTable('businesses');
      $sesbusiness->update(array($votesTitle => new Zend_Db_Expr($votesTitle . ' + 1')), array('business_id = ?' => $businessId));

      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $review->{$votesTitle}));
      die;
    }
  }

  public function getReviewAction() {
    $sesdata = array();
    $businessreviewTable = Engine_Api::_()->getItemTable('businessreview');
    $selectBusinessreviewTable = $businessreviewTable->select()->where('title LIKE "%' . $this->_getParam('text', '') . '%"');
    $reviews = $businessreviewTable->fetchAll($selectBusinessreviewTable);
    foreach ($reviews as $review) {
      $businessItem = Engine_Api::_()->getItem('businesses',$review->business_id);
      $business_icon = $this->view->itemPhoto($businessItem, 'thumb.icon');
      $sesdata[] = array(
          'id' => $review->review_id,
          'business_id' => $review->business_id,
          'label' => $review->title,
          'photo' => $business_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

}
