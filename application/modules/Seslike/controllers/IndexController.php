<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_IndexController extends Core_Controller_Action_Standard {

    public function homeAction() {
        //Render
        $this->_helper->content->setEnabled();
    }

    public function mylikesAction() {
        //Render
        $this->_helper->content->setEnabled();
    }

    public function wholikemeAction() {
        //Render
        $this->_helper->content->setEnabled();
    }

    public function mycontentlikeAction() {
        //Render
        $this->_helper->content->setEnabled();
    }

    public function myfriendslikeAction() {
        //Render
        $this->_helper->content->setEnabled();
    }

    public function mylikesettingsAction() {

        $this->_helper->content->setEnabled();
        if (!$this->_helper->requireUser()->isValid())
            return;
        $this->view->form = $form = new Seslike_Form_MyLikeSettings();
        $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            $table = Engine_Api::_()->getDbTable('mylikesettings', 'seslike');
            $db = $table->getAdapter();
            $db->beginTransaction();
            try {
                $isUserExist = $table->isUserExist($viewer_id);
                $values = $form->getValues();
                if (empty($isUserExist)) {
                    $row = $table->createRow() ;
                    $row->user_id = $viewer_id ;
                    $row->mylikesetting = $values["mylikesetting"] ;
                    $row->save() ;
                } else {
                    $table->update(array('mylikesetting' => $values['mylikesetting']),array('user_id =?' => $viewer_id));
                }
                $db->commit();
            }
            catch( Exception $e ) {
            }
            return $this->_helper->redirector->gotoRoute(array('action' => 'mylikesettings'));
        }
    }

    function likeAction() {

        if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
            echo json_encode(array('status' => 'false', 'error' => 'Login'));
            die;
        }

        $type = $this->_getParam('type', null);
        $item_id = $this->_getParam('id', null);
        if (intval($item_id) == 0) {
            echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
            die;
        }

        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();
        $itemTable = Engine_Api::_()->getItemTable($type);
        $primaryId = current($itemTable->info('primary'));
        $dbInsert = Engine_Db_Table::getDefaultAdapter();
        $resource = Engine_Api::_()->getItem($type, $item_id);
        $tableLike = Engine_Api::_()->getDbTable('likes', 'core');
        $seslikeTable = Engine_Api::_()->getDbTable('likes', 'seslike');

        $select = $tableLike->select()
                ->from($tableLike->info('name'))
                ->where('resource_type = ?', $type)
                ->where('poster_id = ?', $viewer_id)
                ->where('poster_type = ?', 'user')
                ->where('resource_id = ?', $item_id);
        $result = $tableLike->fetchRow($select);

        if (count($result) > 0) {
            $db = $result->getTable()->getAdapter();
            $db->beginTransaction();
            try {
                $result->delete();
                $dbInsert->query('DELETE FROM `engine4_seslike_likes` WHERE `engine4_seslike_likes`.`resource_id` = "'.$item_id.'" AND `engine4_seslike_likes`.`resource_type` = "'.$type.'" AND `engine4_seslike_likes`.`poster_id` = "'.$viewer_id.'";');
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }

            if($type == 'user') {
                $owner = $resource->getOwner();
                if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
                    Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'like_user', "subject_id =?" => $resource->getIdentity(), "object_type =? " => $resource->getType(), "object_id = ?" => $viewer->getIdentity()));
                    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($resource, $viewer, $viewer, 'like_user');
                }
            } else {
                Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => 'liked', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $resource->getType(), "object_id = ?" => $resource->getIdentity()));
                $owner = $resource->getOwner();
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $resource, 'liked');
            }
            $like_count = Engine_Api::_()->seslike()->likeCount($type, $item_id);
            if(!in_array($type, array('user'))) {
                echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' =>  $like_count));
            } else {
                echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' =>  $like_count));
            }
            die;
        } else {
            $db = $tableLike->getAdapter();
            $db->beginTransaction();
            try {
                $like = $tableLike->createRow();
                $like->poster_id = $viewer_id;
                $like->resource_type = $type;
                $like->resource_id = $item_id;
                $like->poster_type = 'user';
                $like->save();
                if(!in_array($type, array('user'))) {
                    $itemTable->update(array('like_count' => new Zend_Db_Expr('like_count + 1')), array($primaryId . '= ?' => $item_id));
                }
                $isLikeID = Engine_Api::_()->seslike()->isLikeID($type, $item_id);
                if(!empty($isLikeID)) {
                    $dbInsert->query('DELETE FROM `engine4_seslike_likes` WHERE `engine4_seslike_likes`.`resource_id` = "'.$item_id.'" AND `engine4_seslike_likes`.`resource_type` = "'.$type.'" AND `engine4_seslike_likes`.`poster_id` = "'.$viewer_id.'";');
                    //$db = $seslikeTable->getAdapter();
                    //$db->beginTransaction();
                    try {
                        $values = array('corelike_id' => $isLikeID, 'resource_type' => $type, 'resource_id' => $item_id, 'poster_type' => 'user', 'poster_id' => $viewer_id, 'creation_date' => date('Y-m-d H:i:s'));
                        $row = $seslikeTable->createRow();
                        $row->setFromArray($values);
                        $row->save();
                        // Commit
                        //$db->commit();
                    } catch( Exception $e ) {
                    }
                }
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            $like_count = Engine_Api::_()->seslike()->likeCount($type, $item_id);
            if(!in_array($type, array('user'))) {
                echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $like_count));
            } else {
                echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $like_count));
            }
            die;
        }
    }
}
