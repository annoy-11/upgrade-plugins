<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ReviewController.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagereview_ReviewController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('sespage_page', null, 'view')->isValid())
      return;
    if (!Engine_Api::_()->getApi('core', 'sespagereview')->allowReviewRating() || !Engine_Api::_()->sesbasic()->getViewerPrivacy('pagereview', 'view'))
      return $this->_forward('notfound', 'error', 'core');
    //Get subject
    if (null !== ($review_id = $this->_getParam('review_id')) && null !== ($review = Engine_Api::_()->getItem('pagereview', $review_id)) && $review instanceof Sespagereview_Model_Pagereview && !Engine_Api::_()->core()->hasSubject()) {
      Engine_Api::_()->core()->setSubject($review);
    }
  }

  public function browseAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function homeAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function createAction() {
    if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('pagereview', 'create'))
      return $this->_forward('notfound', 'error', 'core');
    $subjectId = $this->_getParam('object_id', 0);
    $this->view->item = $item = Engine_Api::_()->getItem('sespage_page', $subjectId);
    if (!$item)
      return $this->_forward('notfound', 'error', 'core');
    $viewer = $this->view->viewer();
    $viewerId = $viewer->getIdentity();
    //check review exists
    $isReview = Engine_Api::_()->getDbtable('pagereviews', 'sespagereview')->isReview(array('page_id' => $item->page_id, 'column_name' => 'review_id'));
    $allowedCreate = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.allow.owner', 1) ? true : ($item->owner_id == $viewerId ? false : true);
    if ($isReview || !$allowedCreate)
      return $this->_forward('notfound', 'error', 'core');
    $values = $_POST;
    $values['rating'] = $_POST['rate_value'];
    $values['owner_id'] = $viewerId;
    $values['page_id'] = $item->page_id;
    $reviews_table = Engine_Api::_()->getDbtable('pagereviews', 'sespagereview');
    $db = $reviews_table->getAdapter();
    $db->beginTransaction();
    try {
      $review = $reviews_table->createRow();
      $review->setFromArray($values);
      $review->description = $_POST['description'];
      $review->save();
      $reviewObject = $review;
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      //tak review ids from post
      $parameterValueTable = Engine_Api::_()->getDbtable('parametervalues', 'sespagereview');
      $parameterTableName = $parameterValueTable->info('name');
      foreach ($_POST as $key => $reviewC) {
        if (count(explode('_', $key)) != 3 || !$reviewC)
          continue;
        $key = str_replace('review_parameter_', '', $key);
        if (!is_numeric($key))
          continue;
        $parameter = Engine_Api::_()->getItem('sespagereview_parameter', $key);
        $query = 'INSERT INTO ' . $parameterTableName . ' (`parameter_id`, `rating`, `page_id`,`content_id`) VALUES ("' . $key . '","' . $reviewC . '","' . $item->page_id . '","' . $review->getIdentity() . '") ON DUPLICATE KEY UPDATE rating = "' . $reviewC . '"';
        $dbObject->query($query);
        $ratingP = $parameterValueTable->getRating($key);
        $parameter->rating = $ratingP;
        $parameter->save();
      }
      $db->commit();
      //save rating in parent table if exists
      if (isset($item->rating)) {
        $item->rating = Engine_Api::_()->getDbtable('pagereviews', 'sespagereview')->getRating($review->page_id);
        $item->review_count = $item->review_count + 1;
        $item->save();
      }
      $review->save();
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
      $viewMax = array_search('everyone', $roles);
      $commentMax = array_search('everyone', $roles);
      foreach ($roles as $i => $role) {
        $auth->setAllowed($review, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($review, $role, 'comment', ($i <= $commentMax));
      }
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $item, 'sespagereview_reviewpost');
      if ($action != null) {
        Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $review);
      }
      if ($item->owner_id != $viewerId) {
        $itemOwner = $item->getOwner('user');
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($itemOwner, $viewer, $review, 'sespagereview_reviewpost');
      }
      $db->commit();
      $stats = Engine_Api::_()->sespagereview()->getWidgetParams($item->pagestyle);
      $this->view->stats = count($stats) ? $stats : $this->_getParam('stats', array('featured', 'sponsored', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating'));
      $this->view->review = $reviewObject;
      if (Engine_Api::_()->sesbasic()->getViewerPrivacy('pagereview', 'edit')) {
        $this->view->form = $form = new Sespagereview_Form_Review_Create(array('pageId' => $reviewObject->page_id, 'reviewId' => $reviewObject->review_id));
        $form->populate($reviewObject->toArray());
        $form->rate_value->setvalue($reviewObject->rating);
        $form->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespagereview', 'controller' => 'review', 'action' => 'edit', 'review_id' => $reviewObject->review_id), 'default', true));
      }
      $this->view->rating_count = Engine_Api::_()->getDbTable('pagereviews', 'sespagereview')->ratingCount($reviewObject->page_id);
      $this->view->rating_sum = $item->rating;
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function editAction() {
    if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('pagereview', 'edit'))
      return $this->_forward('notfound', 'error', 'core');
    $review_id = $this->_getParam('review_id', null);
    $subject = Engine_Api::_()->getItem('pagereview', $review_id);
    $this->view->item = $item = Engine_Api::_()->getItem('sespage_page', $subject->page_id);
    if (!$review_id || !$subject)
      return $this->_forward('notfound', 'error', 'core');
    $values = $_POST;
    $values['rating'] = $_POST['rate_value'];
    $values['owner_id'] = $subject->owner_id;
    $values['page_id'] = $item->page_id;
    $reviews_table = Engine_Api::_()->getDbtable('pagereviews', 'sespagereview');
    $db = $reviews_table->getAdapter();
    $db->beginTransaction();
    try {
      $subject->setFromArray($values);
      $subject->save();
      $table = Engine_Api::_()->getDbtable('parametervalues', 'sespagereview');
      $tablename = $table->info('name');
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      foreach ($_POST as $key => $reviewC) {
        if (count(explode('_', $key)) != 3 || !$reviewC)
          continue;
        $key = str_replace('review_parameter_', '', $key);
        if (!is_numeric($key))
          continue;
        $parameter = Engine_Api::_()->getItem('sespagereview_parameter', $key);
        $query = 'INSERT INTO ' . $tablename . ' (`parameter_id`, `rating`, `page_id`,`content_id`) VALUES ("' . $key . '","' . $reviewC . '","' . $item->page_id . '","' . $subject->review_id . '") ON DUPLICATE KEY UPDATE rating = "' . $reviewC . '"';
        $dbObject->query($query);
        $ratingP = $table->getRating($key);
        $parameter->rating = $ratingP;
        $parameter->save();
      }
      if (isset($item->rating)) {
        $item->rating = Engine_Api::_()->getDbtable('pagereviews', 'sespagereview')->getRating($subject->page_id);
        $item->save();
      }
      $subject->save();
      $reviewObject = $subject;
      $db->commit();

      $stats = Engine_Api::_()->sespagereview()->getWidgetParams($item->pagestyle);
      $this->view->stats = count($stats) ? $stats : $this->_getParam('stats', array('featured', 'sponsored', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating'));
      $this->view->review = $reviewObject;
      $this->view->form = $form = new Sespagereview_Form_Review_Create(array('reviewId' => $reviewObject->review_id, 'pageId' => $reviewObject->page_id));
      $form->populate($reviewObject->toArray());
      $form->rate_value->setvalue($reviewObject->rating);
      $form->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespagereview', 'controller' => 'review', 'action' => 'edit', 'review_id' => $reviewObject->review_id), 'default', true));
      $this->view->rating_count = Engine_Api::_()->getDbTable('pagereviews', 'sespagereview')->ratingCount($reviewObject->page_id);
      $this->view->total_rating_average = Engine_Api::_()->getDbtable('pagereviews', 'sespagereview')->getRating($reviewObject->page_id);
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function deleteAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->getItem('pagereview', $this->getRequest()->getParam('review_id'));
    $content_item = Engine_Api::_()->getItem('sespage_page', $review->page_id);
    if (!$this->_helper->requireAuth()->setAuthParams($review, $viewer, 'delete')->isValid())
      return;
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $this->view->form = $form = new Sesbasic_Form_Delete();
    $form->setTitle('Delete Review?');
    $form->setDescription('Are you sure that you want to delete this review? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    if ($this->getRequest()->isPost()) {
      $db = $review->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $review->delete();
        $db->commit();
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('SESPAGE The selected review has been deleted.');
        return $this->_forward('success', 'utility', 'core', array('parentRedirect' => $content_item->gethref(), 'messages' => array($this->view->message)));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function viewAction() {
    if (Engine_Api::_()->core()->hasSubject('pagereview'))
      $subject = Engine_Api::_()->core()->getSubject();
    else
      return $this->_forward('notfound', 'error', 'core');
    if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('pagereview', 'view'))
      return $this->_forward('notfound', 'error', 'core');
    //Increment view count
    if (!$this->view->viewer()->isSelf($subject->getOwner())) {
      $subject->view_count++;
      $subject->save();
    }
    //Render
    $this->_helper->content->setEnabled();
  }

  public function editReviewAction() {
    $this->_helper->layout->setLayout('default-simple');
    if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('pagereview', 'edit'))
      return $this->_forward('notfound', 'error', 'core');
    $review_id = $this->_getParam('review_id', null);
    $subject = Engine_Api::_()->getItem('pagereview', $review_id);
    $this->view->item = $item = Engine_Api::_()->getItem('sespage_page', $subject->page_id);
    if (!$review_id || !$subject)
      return $this->_forward('notfound', 'error', 'core');
    $this->view->form = $form = new Sespagereview_Form_Review_Edit(array('pageId' => $subject->page_id, 'reviewId' => $subject->review_id));
    $form->setAttrib('id', 'sespagereview_edit_review');
    $form->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespagereview', 'controller' => 'review', 'action' => 'edit-review', 'review_id' => $review_id), 'default', true));
    $title = Zend_Registry::get('Zend_Translate')->_('SESPAGE Edit a Review for "<b>%s</b>".');
    $form->setTitle(sprintf($title, $subject->getTitle()));
    $form->setDescription("Please fill below information.");

    if (!$this->getRequest()->isPost()) {
      $form->populate($subject->toArray());
      $form->rate_value->setValue($subject->rating);
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    $values = $_POST;
    $values['rating'] = $_POST['rate_value'];
    $values['owner_id'] = $subject->owner_id;
    $values['page_id'] = $item->page_id;
    $reviews_table = Engine_Api::_()->getDbtable('pagereviews', 'sespagereview');
    $db = $reviews_table->getAdapter();
    $db->beginTransaction();
    try {
      $subject->setFromArray($values);
      $subject->save();
      $table = Engine_Api::_()->getDbtable('parametervalues', 'sespagereview');
      $tablename = $table->info('name');
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      foreach ($_POST as $key => $reviewC) {
        if (count(explode('_', $key)) != 3 || !$reviewC)
          continue;
        $key = str_replace('review_parameter_', '', $key);
        if (!is_numeric($key))
          continue;
        $parameter = Engine_Api::_()->getItem('sespagereview_parameter', $key);
        $query = 'INSERT INTO ' . $tablename . ' (`parameter_id`, `rating`, `page_id`, `content_id`) VALUES ("' . $key . '","' . $reviewC . '","' . $item->page_id . '","' . $subject->review_id . '") ON DUPLICATE KEY UPDATE rating = "' . $reviewC . '"';
        $dbObject->query($query);
        $ratingP = $table->getRating($key);
        $parameter->rating = $ratingP;
        $parameter->save();
      }
      if (isset($item->rating)) {
        $item->rating = Engine_Api::_()->getDbtable('pagereviews', 'sespagereview')->getRating($subject->page_id);
        $item->save();
      }
      $subject->save();
      $reviewObject = $subject;
      $db->commit();
      echo json_encode(array('status' => 'true'));
      die;
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  function likeAction() {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    $itemTable = Engine_Api::_()->getItemTable('pagereview');
    $tableLike = Engine_Api::_()->getDbtable('likes', 'core');
    $tableMainLike = $tableLike->info('name');
    $select = $tableLike->select()
            ->from($tableMainLike)
            ->where('resource_type = ?', 'pagereview')
            ->where('poster_id = ?', $viewer_id)
            ->where('poster_type = ?', 'user')
            ->where('resource_id = ?', $item_id);
    $result = $tableLike->fetchRow($select);
    if (count($result) > 0) {
      //delete		
      $db = $result->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $result->delete();
        $itemTable->update(array('like_count' => new Zend_Db_Expr('like_count - 1')), array('review_id = ?' => $item_id));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $selectPageReview = $itemTable->select()->where('review_id =?', $item_id);
      $pageReview = $itemTable->fetchRow($selectPageReview);
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $pageReview->like_count));
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('likes', 'core')->getAdapter();
      $db->beginTransaction();
      try {
        $like = $tableLike->createRow();
        $like->poster_id = $viewer_id;
        $like->resource_type = 'pagereview';
        $like->resource_id = $item_id;
        $like->poster_type = 'user';
        $like->save();
        $itemTable->update(array('like_count' => new Zend_Db_Expr('like_count + 1')), array('review_id = ?' => $item_id));
        //Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //Send notification and activity feed work.
      $selectPageReview = $itemTable->select()->where('review_id =?', $item_id);
      $item = $itemTable->fetchRow($selectPageReview);
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer_id) {
        $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => 'liked', "subject_id =?" => $viewer_id, "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, 'liked');
        $result = $activityTable->fetchRow(array('type =?' => 'liked', "subject_id =?" => $viewer_id, "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, 'liked');
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->like_count));
      die;
    }
  }

}
