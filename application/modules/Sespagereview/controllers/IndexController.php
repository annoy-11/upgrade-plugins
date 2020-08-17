<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagereview_IndexController extends Core_Controller_Action_Standard {

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
    $itemTable = Engine_Api::_()->getItemTable('pagereview');
    $tableVotes = Engine_Api::_()->getDbtable('reviewvotes', 'sespagereview');
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
      $pageId = $review->page_id;
      $sespage = Engine_Api::_()->getItemTable('sespage_page');
      $sespage->update(array($votesTitle => new Zend_Db_Expr($votesTitle . ' - 1')), array('page_id = ?' => $pageId));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $review->{$votesTitle}));
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('reviewvotes', 'sespagereview')->getAdapter();
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
      $pageId = $review->page_id;
      $sespage = Engine_Api::_()->getItemTable('sespage_page');
      $sespage->update(array($votesTitle => new Zend_Db_Expr($votesTitle . ' + 1')), array('page_id = ?' => $pageId));

      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $review->{$votesTitle}));
      die;
    }
  }

  public function getReviewAction() {
    $sesdata = array();
    $pagereviewTable = Engine_Api::_()->getItemTable('pagereview');
    $selectPagereviewTable = $pagereviewTable->select()->where('title LIKE "%' . $this->_getParam('text', '') . '%"');
    $reviews = $pagereviewTable->fetchAll($selectPagereviewTable);
    foreach ($reviews as $review) {
      $pageItem = Engine_Api::_()->getItem('sespage_page',$review->page_id);
      $page_icon = $this->view->itemPhoto($pageItem, 'thumb.icon');
      $sesdata[] = array(
          'id' => $review->review_id,
          'page_id' => $review->page_id,
          'label' => $review->title,
          'photo' => $page_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

}
