<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ReviewController.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_ReviewController extends Core_Controller_Action_Standard {

    public function init() {
        if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.allow.review', 1) || !Engine_Api::_()->sesbasic()->getViewerPrivacy('sesproductreview', 'view'))
            return $this->_forward('notfound', 'error', 'core');

        //Get subject
        if (null !== ($review_id = $this->_getParam('review_id')) && null !== ($review = Engine_Api::_()->getItem('sesproductreview', $review_id)) && $review instanceof Sesproduct_Model_SesproductReview && !Engine_Api::_()->core()->hasSubject()) {
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
        $this->view->item = $userInfoItem = $item = Engine_Api::_()->getItem('sesproduct', $subjectId);
        if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('sesproductreview', 'create'))
            return $this->_forward('notfound', 'error', 'core');
        if (!$item)
            return $this->_forward('notfound', 'error', 'core');
        //check review exists
        $isReview = Engine_Api::_()->getDbtable('sesproductreviews', 'sesproduct')->isReview(array('product_id' => $item->getIdentity(), 'column_name' => 'review_id'));
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.allow.owner', 1)) {
            $allowedCreate = true;
        } else {
            if ($item->owner_id == $viewer->getIdentity())
                $allowedCreate = false;
            else
                $allowedCreate = true;
        }
        if ($isReview || !$allowedCreate)
            return $this->_forward('notfound', 'error', 'core');

        $values = $_POST;
        $values['rating'] = $_POST['rate_value'];
        $values['owner_id'] = $viewer->getIdentity();
        $values['product_id'] = $item->getIdentity();
        $reviews_table = Engine_Api::_()->getDbtable('sesproductreviews', 'sesproduct');
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
            $table = Engine_Api::_()->getDbtable('parametervalues', 'sesproduct');
            $tablename = $table->info('name');
            foreach ($_POST as $key => $reviewC) {
                if (count(explode('_', $key)) != 3 || !$reviewC)
                    continue;
                $key = str_replace('review_parameter_', '', $key);
                if (!is_numeric($key))
                    continue;
                $parameter = Engine_Api::_()->getItem('sesproduct_parameter', $key);
                $query = 'INSERT INTO ' . $tablename . ' (`parameter_id`, `rating`, `user_id`, `resources_id`,`content_id`) VALUES ("' . $key . '","' . $reviewC . '","' . $viewer->getIdentity() . '","' . $item->getIdentity() . '","' . $review->getIdentity() . '") ON DUPLICATE KEY UPDATE rating = "' . $reviewC . '"';
                $dbObject->query($query);
                $ratingP = $table->getRating($key);
                $parameter->rating = $ratingP;
                $parameter->save();
            }
            $db->commit();
            //save rating in parent table if exists
            if (isset($item->rating)) {
                $item->rating = Engine_Api::_()->getDbtable('sesproductreviews', 'sesproduct')->getRating($review->product_id);
                $item->save();
            }
            $review->save();

            $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $item, 'sesproduct_reviewpost');
            if ($action != null) {
                Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $review);
            }

            if ($item->owner_id != $viewer->getIdentity()) {
                $itemOwner = $item->getOwner();
                $subject = Engine_Api::_()->getItem('sesproduct', $review->product_id);
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($subject->getOwner(), $viewer, $subject, 'sesproduct_reviewpost');
                $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
                $action = $activityTable->addActivity($viewer, $subject, "sesproduct_review_product");
                if ($action)
                    $activityTable->attachActivity($action, $subject);

            }

            $db->commit();
            $stats = Engine_Api::_()->sesproduct()->getWidgetParams($viewer->getIdentity());
            $this->view->stats = count($stats) ? $stats : $this->_getParam('stats', array('featured', 'sponsored', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating'));
            $this->view->review = $reviewObject;
            if (Engine_Api::_()->sesbasic()->getViewerPrivacy('sesproductreview', 'edit')) {
                $this->view->form = $form = new Sesproduct_Form_Review_Create(array('reviewId' => $reviewObject->review_id, 'productItem' => $item));
                $form->populate($reviewObject->toArray());
                $form->rate_value->setvalue($reviewObject->rating);
                $form->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesproduct', 'controller' => 'review', 'action' => 'edit', 'review_id' => $reviewObject->review_id), 'default', true));
            }
            $this->view->rating_count = Engine_Api::_()->getDbTable('sesproductreviews', 'sesproduct')->ratingCount($item->getIdentity());
            $this->view->rating_sum = $userInfoItem->rating;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public function editAction() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review_id = $this->_getParam('review_id', null);
        $subject = Engine_Api::_()->getItem('sesproductreview', $review_id);

        if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('sesproductreview', 'edit'))
            return $this->_forward('notfound', 'error', 'core');

        $this->view->item = $item = Engine_Api::_()->getItem('sesproduct', $subject->product_id);

        if (!$review_id || !$subject)
            return $this->_forward('notfound', 'error', 'core');

        $values = $_POST;
        $values['rating'] = $_POST['rate_value'];
        $reviews_table = Engine_Api::_()->getDbtable('sesproductreviews', 'sesproduct');
        $db = $reviews_table->getAdapter();
        $db->beginTransaction();
        try {
            $subject->setFromArray($values);
            $subject->save();
            $table = Engine_Api::_()->getDbtable('parametervalues', 'sesproduct');
            $tablename = $table->info('name');
            $dbObject = Engine_Db_Table::getDefaultAdapter();
            foreach ($_POST as $key => $reviewC) {
                if (count(explode('_', $key)) != 3 || !$reviewC)
                    continue;
                $key = str_replace('review_parameter_', '', $key);
                if (!is_numeric($key))
                    continue;
                $parameter = Engine_Api::_()->getItem('sesproduct_parameter', $key);
                $query = 'INSERT INTO ' . $tablename . ' (`parameter_id`, `rating`, `user_id`, `resources_id`,`content_id`) VALUES ("' . $key . '","' . $reviewC . '","' . $subject->owner_id . '","' . $item->owner_id . '","' . $subject->review_id . '") ON DUPLICATE KEY UPDATE rating = "' . $reviewC . '"';
                $dbObject->query($query);
                $ratingP = $table->getRating($key);
                $parameter->rating = $ratingP;
                $parameter->save();
            }
            if (isset($item->rating)) {
                $item->rating = Engine_Api::_()->getDbtable('sesproductreviews', 'sesproduct')->getRating($subject->owner_id);
                $item->save();
            }
            $subject->save();
            $reviewObject = $subject;
            $db->commit();
            $stats = Engine_Api::_()->sesproduct()->getWidgetParams($viewer->getIdentity());
            $this->view->stats = count($stats) ? $stats : $this->_getParam('stats', array('featured', 'sponsored', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating'));
            $this->view->review = $reviewObject;
            $this->view->form = $form = new Sesproduct_Form_Review_Edit(array( 'reviewId' => $reviewObject->review_id, 'productItem' => $item));
            $form->populate($reviewObject->toArray());
            $form->rate_value->setvalue($reviewObject->rating);
            $form->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesproduct', 'controller' => 'review', 'action' => 'edit', 'review_id' => $reviewObject->review_id), 'default', true));
            $this->view->rating_count = Engine_Api::_()->getDbTable('sesproductreviews', 'sesproduct')->ratingCount($reviewObject->owner_id);
            $this->view->total_rating_average = Engine_Api::_()->getDbtable('sesproductreviews', 'sesproduct')->getRating($reviewObject->owner_id);
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public function deleteAction() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->getItem('sesproductreview', $this->getRequest()->getParam('review_id'));
        $content_item = Engine_Api::_()->getItem('sesproduct', $review->product_id);
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
                $reviewParameterTable = Engine_Api::_()->getDbTable('parametervalues', 'sesproduct');
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

        if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('sesproductreview', 'view'))
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
        $subject = Engine_Api::_()->getItem('sesproductreview', $review_id);

        if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('sesproductreview', 'edit'))
            return $this->_forward('notfound', 'error', 'core');

        $this->view->item = $item = Engine_Api::_()->getItem('sesproduct', $subject->product_id);

        if (!$review_id || !$subject)
            return $this->_forward('notfound', 'error', 'core');

        $this->view->form = $form = new Sesproduct_Form_Review_Edit(array('reviewId' => $subject->review_id,  'productItem' => $item));
        $form->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesproduct', 'controller' => 'review', 'action' => 'edit-review', 'review_id' => $review_id), 'default', true));
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
        $reviews_table = Engine_Api::_()->getDbtable('sesproductreviews', 'sesproduct');
        $db = $reviews_table->getAdapter();
        $db->beginTransaction();
        try {
            $subject->setFromArray($values);
            $subject->save();
            $table = Engine_Api::_()->getDbtable('parametervalues', 'sesproduct');
            $tablename = $table->info('name');
            $dbObject = Engine_Db_Table::getDefaultAdapter();
            foreach ($_POST as $key => $reviewC) {
                if (count(explode('_', $key)) != 3 || !$reviewC)
                    continue;
                $key = str_replace('review_parameter_', '', $key);
                if (!is_numeric($key))
                    continue;
                $parameter = Engine_Api::_()->getItem('sesproduct_parameter', $key);
               $query = 'INSERT INTO ' . $tablename . ' (`parameter_id`, `rating`, `user_id`, `resources_id`,`content_id`) VALUES ("' . $key . '","' . $reviewC . '","' . $subject->owner_id . '","' . $item->owner_id . '","' . $subject->review_id . '") ON DUPLICATE KEY UPDATE rating = "' . $reviewC . '"';
                $dbObject->query($query);
                $ratingP = $table->getRating($key);
                $parameter->rating = $ratingP;
                $parameter->save();
            }
            if (isset($item->rating)) {
                $item->rating = Engine_Api::_()->getDbtable('sesproductreviews', 'sesproduct')->getRating($subject->product_id);
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
        $itemTable = Engine_Api::_()->getItemTable('sesproductreview');
        $tableLike = Engine_Api::_()->getDbtable('likes', 'core');
        $tableMainLike = $tableLike->info('name');
        $select = $tableLike->select()
            ->from($tableMainLike)
            ->where('resource_type = ?', 'sesproductreview')
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
                $like->resource_type = 'sesproductreview';
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
