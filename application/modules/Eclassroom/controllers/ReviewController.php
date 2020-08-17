<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: ReviewController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_ReviewController extends Core_Controller_Action_Standard {

    public function init() {
        if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('classroom.allow.review', 1) || !Engine_Api::_()->sesbasic()->getViewerPrivacy('eclass_review', 'view'))
            return $this->_forward('notfound', 'error', 'core');

        //Get subject
        if (null !== ($review_id = $this->_getParam('review_id')) && null !== ($review = Engine_Api::_()->getItem('eclassroom_review', $review_id)) && $review instanceof Eclassroom_Model_Review && !Engine_Api::_()->core()->hasSubject()) {
            Engine_Api::_()->core()->setSubject($review);
        }
    }
    public function browseAction() {
        // Render
        $this->_helper->content->setEnabled();
    }
    public function createAction() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $subjectId = $this->_getParam('object_id', 0);
        $this->view->item = $userInfoItem = $item = Engine_Api::_()->getItem('classroom', $subjectId);
        if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('eclass_review', 'create'))
            return $this->_forward('notfound', 'error', 'core');
        if (!$item)
            return $this->_forward('notfound', 'error', 'core');
        //check review exists
        $isReview = Engine_Api::_()->getDbtable('reviews', 'eclassroom')->isReview(array('classroom_id' => $item->getIdentity(), 'column_name' => 'review_id'));
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.owner.review', 1)) {
            $allowedCreate = true;
        } else {
            if($item->owner_id == $viewer->getIdentity())
                $allowedCreate = false;
            else
                $allowedCreate = true;
        }
        if ($isReview || !$allowedCreate)
            return $this->_forward('notfound', 'error', 'core');
        $values = $_POST;
        $values['rating'] = $_POST['rate_value'];
        $values['owner_id'] = $viewer->getIdentity();
        $values['classroom_id'] = $item->getIdentity();
        $reviews_table = Engine_Api::_()->getDbtable('reviews', 'eclassroom');
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
            $table = Engine_Api::_()->getDbtable('parametervalues', 'eclassroom');
            $tablename = $table->info('name');
            foreach ($_POST as $key => $reviewC) {
                if (count(explode('_', $key)) != 3 || !$reviewC)
                    continue;
                $key = str_replace('review_parameter_', '', $key);
                if (!is_numeric($key))
                    continue;
                $parameter = Engine_Api::_()->getItem('eclassroom_parameter', $key);
                $query = 'INSERT INTO ' . $tablename . ' (`parameter_id`, `rating`, `user_id`, `resources_id`,`content_id`) VALUES ("' . $key . '","' . $reviewC . '","' . $viewer->getIdentity() . '","' . $item->getIdentity() . '","' . $review->getIdentity() . '") ON DUPLICATE KEY UPDATE rating = "' . $reviewC . '"';
                $dbObject->query($query);
                $ratingP = $table->getRating($key);
                $parameter->rating = $ratingP;
                $parameter->save();
            }
            $db->commit();
            //save rating in parent table if exists
            if (isset($item->rating)) {
                $item->rating = Engine_Api::_()->getDbtable('reviews', 'eclassroom')->getRating($review->classroom_id);
                $item->save();
            }
            $review->save();
            $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $item, 'eclassroom_reviewpost');
            if ($action != null) {
                Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $review);
            }
            $subject = Engine_Api::_()->getItem('classroom', $review->classroom_id);
            $classroomTitle = '<a href="'.$subject->getHref().'">'.$subject->getTitle().'</a>';
            $reviewtitle = '<a href="'.$review->getHref().'">'.$review->getTitle().'</a>';
            if ($item->owner_id != $viewer->getIdentity()) {
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($subject->getOwner(), $viewer, $review, 'eclassroom_reviewpost',array('classroom'=>$classroomTitle));
                $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
                $action = $activityTable->addActivity($viewer, $review, "eclassroom_reviewpost", null, array('classroomTitle' => $classroomTitle));
                if ($action)
                    $activityTable->attachActivity($action, $review);
                 Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'eclassroom_reviewpost', array('classroom_name' => $subject->getTitle(), 'review_title' => $review->getTitle(),'object_link' => $review->getHref(), 'host' => $_SERVER['HTTP_HOST']));
            }
            $followerMembers = Engine_Api::_()->getDbTable('followers', 'eclassroom')->getFollowers($review->classroom_id);
            foreach($followerMembers as $followerMember) {
                 $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($followerMember, $viewer, $subject, 'eclassroom_bsreviewpost',array('reviewtitle'=>$reviewtitle));
                $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
                $action = $activityTable->addActivity($followerMember, $subject, "eclassroom_bsreviewpost", null, array('reviewtitle' => $reviewtitle));
                if ($action)
                    $activityTable->attachActivity($action, $subject);
                 Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'eclassroom_bsreviewpostfollow', array('classroom_name' => $subject->getTitle(),'review_title' => $review->getTitle(),'object_link' => $review->getHref(), 'host' => $_SERVER['HTTP_HOST']));
            } 
            $db->commit();
            $stats = Engine_Api::_()->eclassroom()->getWidgetParams(@$_POST['widget_id']);
            $this->view->stats = count($stats) ? $stats['widget_id'] : $this->_getParam('stats', array('featured', 'sponsored', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating'));
            $this->view->review = $reviewObject;
            if (Engine_Api::_()->sesbasic()->getViewerPrivacy('eclass_review', 'edit')) {
                $this->view->form = $form = new Eclassroom_Form_Review_Create(array('reviewId' => $reviewObject->review_id, 'classroomItem' => $item));
                $form->populate($reviewObject->toArray());
                $form->rate_value->setvalue($reviewObject->rating);
                $form->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'eclassroom', 'controller' => 'review', 'action' => 'edit', 'review_id' => $reviewObject->review_id), 'default', true));
            }
            $this->view->rating_count = Engine_Api::_()->getDbTable('reviews', 'eclassroom')->ratingCount($item->getIdentity());
            $this->view->rating_sum = $userInfoItem->rating;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
    public function editAction() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review_id = $this->_getParam('review_id', null);
        $subject = Engine_Api::_()->getItem('eclassroom_review', $review_id);

        if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('eclass_review', 'edit'))
            return $this->_forward('notfound', 'error', 'core');

        $this->view->item = $item = Engine_Api::_()->getItem('classroom', $subject->classroom_id);

        if (!$review_id || !$subject)
            return $this->_forward('notfound', 'error', 'core');

        $values = $_POST;
        $values['rating'] = $_POST['rate_value'];
        $reviews_table = Engine_Api::_()->getDbtable('reviews', 'eclassroom');
        $db = $reviews_table->getAdapter();
        $db->beginTransaction();
        try {
            $subject->setFromArray($values);
            $subject->save();
            $table = Engine_Api::_()->getDbtable('parametervalues', 'eclassroom');
            $tablename = $table->info('name');
            $dbObject = Engine_Db_Table::getDefaultAdapter();
            foreach ($_POST as $key => $reviewC) {
                if (count(explode('_', $key)) != 3 || !$reviewC)
                    continue;
                $key = str_replace('review_parameter_', '', $key);
                if (!is_numeric($key))
                    continue;
                $parameter = Engine_Api::_()->getItem('eclassroom_parameter', $key);
                $query = 'INSERT INTO ' . $tablename . ' (`parameter_id`, `rating`, `user_id`, `resources_id`,`content_id`) VALUES ("' . $key . '","' . $reviewC . '","' . $subject->owner_id . '","' . $item->owner_id . '","' . $subject->review_id . '") ON DUPLICATE KEY UPDATE rating = "' . $reviewC . '"';
                $dbObject->query($query);
                $ratingP = $table->getRating($key);
                $parameter->rating = $ratingP;
                $parameter->save();
            }
            if (isset($item->rating)) {
                $item->rating = Engine_Api::_()->getDbtable('reviews', 'eclassroom')->getRating($subject->owner_id);
                $item->save();
            }
            $subject->save();
            $reviewObject = $subject;
            $db->commit();
            $stats = Engine_Api::_()->eclassroom()->getWidgetParams($viewer->getIdentity());
            $this->view->stats = count($stats) ? $stats : $this->_getParam('stats', array('featured', 'sponsored', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating'));
            $this->view->review = $reviewObject;
            $this->view->form = $form = new Eclassroom_Form_Review_Edit(array( 'reviewId' => $reviewObject->review_id, 'courseItem' => $item));
            $form->populate($reviewObject->toArray());
            $form->rate_value->setvalue($reviewObject->rating);
            $form->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'eclassroom', 'controller' => 'review', 'action' => 'edit', 'review_id' => $reviewObject->review_id), 'default', true));
            $this->view->rating_count = Engine_Api::_()->getDbTable('reviews', 'eclassroom')->ratingCount($reviewObject->owner_id);
            $this->view->total_rating_average = Engine_Api::_()->getDbtable('reviews', 'eclassroom')->getRating($reviewObject->owner_id);
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public function deleteAction() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->getItem('eclassroom_review', $this->getRequest()->getParam('review_id'));
        $content_item = Engine_Api::_()->getItem('classroom', $review->classroom_id);
        if (!Engine_Api::_()->authorization()->isAllowed('eclass_review',$viewer, 'delete'))
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
                $reviewParameterTable = Engine_Api::_()->getDbTable('parametervalues', 'eclassroom');
                $select = $reviewParameterTable->select()->where('content_id =?', $review->review_id);
                $parameters = $reviewParameterTable->fetchAll($select);
                if (count($parameters) > 0) {
                    foreach ($parameters as $parameter) {
                        $reviewParameterTable->delete(array('parametervalue_id =?' => $parameter->parametervalue_id));
                    }
                }
                $review->delete();
                $db->commit();
                $this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected review has been deleted.');
                return $this->_forward('success', 'utility', 'core', array('parentRedirect' => $content_item->gethref(), 'messages' => array($this->view->message)));
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
        }
    }

    public function viewAction() {
        $viewer = Engine_Api::_()->user()->getViewer();
        if (Engine_Api::_()->core()->hasSubject())
            $subject = Engine_Api::_()->core()->getSubject();
        else
            return $this->_forward('notfound', 'error', 'core');

        $review_id = $this->_getParam('review_id', null);

        if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('eclass_review', 'view'))
            return $this->_forward('notfound', 'error', 'core');
        //Increment view count
        if (!$viewer->isSelf($subject->getOwner())) {
            $subject->view_count++;
            $subject->save();
        }
        //Render
        $this->_helper->content->setEnabled();
    }

    public function editReviewAction() {
        $this->_helper->layout->setLayout('default-simple');
        $review_id = $this->_getParam('review_id', null);
        $subject = Engine_Api::_()->getItem('eclassroom_review', $review_id);

        if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('eclass_review', 'edit'))
            return $this->_forward('notfound', 'error', 'core');

        $this->view->item = $item = Engine_Api::_()->getItem('classroom', $subject->classroom_id);

        if (!$review_id || !$subject)
            return $this->_forward('notfound', 'error', 'core');

        $this->view->form = $form = new Eclassroom_Form_Review_Edit(array('reviewId' => $subject->review_id,  'classroomItem' => $item));
        $form->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'eclassroom', 'controller' => 'review', 'action' => 'edit-review', 'review_id' => $review_id), 'default', true));
        $title = Zend_Registry::get('Zend_Translate')->_('Edit a Review for "<b>%s</b>".');
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
        $reviews_table = Engine_Api::_()->getDbtable('reviews', 'eclassroom');
        $db = $reviews_table->getAdapter();
        $db->beginTransaction();
        try {
            $subject->setFromArray($values);
            $subject->save();
            $table = Engine_Api::_()->getDbtable('parametervalues', 'eclassroom');
            $tablename = $table->info('name');
            $dbObject = Engine_Db_Table::getDefaultAdapter();
            foreach ($_POST as $key => $reviewC) {
                if (count(explode('_', $key)) != 3 || !$reviewC)
                    continue;
                $key = str_replace('review_parameter_', '', $key);
                if (!is_numeric($key))
                    continue;
                $parameter = Engine_Api::_()->getItem('eclassroom_parameter', $key);
               $query = 'INSERT INTO ' . $tablename . ' (`parameter_id`, `rating`, `user_id`, `resources_id`,`content_id`) VALUES ("' . $key . '","' . $reviewC . '","' . $subject->owner_id . '","' . $item->owner_id . '","' . $subject->review_id . '") ON DUPLICATE KEY UPDATE rating = "' . $reviewC . '"';
                $dbObject->query($query);
                $ratingP = $table->getRating($key);
                $parameter->rating = $ratingP;
                $parameter->save();
            }
            if (isset($item->rating)) {
                $item->rating = Engine_Api::_()->getDbtable('reviews', 'eclassroom')->getRating($subject->classroom_id);
                $item->save();
            }
            $subject->save();
            $reviewObject = $subject;
            $db->commit();
            $this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected review has been edited.');
            return $this->_forward('success', 'utility', 'core', array('parentRedirect' => $reviewObject->gethref(), 'messages' => array($this->view->message)));
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
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();
        $itemTable = Engine_Api::_()->getItemTable('eclassroom_review');
        $tableLike = Engine_Api::_()->getDbtable('likes', 'core');
        $tableMainLike = $tableLike->info('name');
        $select = $tableLike->select()
            ->from($tableMainLike)
            ->where('resource_type = ?', 'eclassroom_review')
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
            $selectUser = $itemTable->select()->where('review_id =?', $item_id);
            $user = $itemTable->fetchRow($selectUser);
            echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $user->like_count));
            die;
        } else {
            //update
            $db = Engine_Api::_()->getDbTable('likes', 'core')->getAdapter();
            $db->beginTransaction();
            try {
                $like = $tableLike->createRow();
                $like->poster_id = $viewer_id;
                $like->resource_type = 'eclassroom_review';
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
            $selectUser = $itemTable->select()->where('review_id =?', $item_id);
            $item = $itemTable->fetchRow($selectUser);
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
