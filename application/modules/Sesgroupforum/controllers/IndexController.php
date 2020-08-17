<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_IndexController extends Core_Controller_Action_Standard {

  public function subscribeAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    if (empty($viewer_id))
      return;

    $resource_id = $this->_getParam('resource_id');
    $resource_type = $this->_getParam('resource_type');
    $subscribe_id = $this->_getParam('subscribe_id');

    $item = Engine_Api::_()->getItem($resource_type, $resource_id);



    $subscribeTable = Engine_Api::_()->getDbTable('subscribes', 'sesgroupforum');
    $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
    $activityStrameTable = Engine_Api::_()->getDbtable('stream', 'activity');

    if (empty($subscribe_id)) {
      $isSubscribe = $subscribeTable->isSubscribe(array('resource_id' => $resource_id));
      if (empty($isSubscribe)) {
        $db = $subscribeTable->getAdapter();
        $db->beginTransaction();
        try {
          $row = $subscribeTable->createRow();
          $row->poster_id = $viewer_id;
          $row->resource_id = $resource_id;
          $row->save();
          $this->view->subscribe_id = $row->subscribe_id;

          $owner = $item->getOwner();
          if($owner->getIdentity() != $viewer_id) {
            if ($resource_type == 'sesgroupforum') {
              $owner = $item->getOwner();

              //Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'subscribed', array('label' => $item->getShortType()));

//               $action = $activityTable->addActivity($viewer, $item, 'sesmusic_subscribealbum');
//               if ($action)
//                 $activityTable->attachActivity($action, $item);
            }
          }

          $db->commit();
        } catch (Exception $e) {
          $db->rollBack();
          throw $e;
        }
      } else {
        $this->view->subscribe_id = $isSubscribe;
      }
    } else {
        $subsitem = Engine_Api::_()->getItem('sesgroupforum_subscribe', $subscribe_id);
        //Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => "sesmusic_subscribe_musicalbum", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
       // $action = $activityTable->fetchRow(array('type =?' => "sesmusic_subscribealbum", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
//       if (!empty($action)) {
//         $action->deleteItem();
//         $action->delete();
//       }
      $subsitem->delete();
      $this->view->subscribe_id = 0;
    }
  }

  public function thankAction() {
  
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    if (empty($viewer_id))
        return;

    $topicuser_id = $this->_getParam('topicuser_id');
    $resource_id = $this->_getParam('resource_id');
    $thank_id = $this->_getParam('thank_id');

    $resource_id = $this->_getParam('resource_id', null);
    $resource_type = $this->_getParam('resource_type', null);
    $resource = Engine_Api::_()->getItem($resource_type, $resource_id);

    $topic = Engine_Api::_()->getItem('sesgroupforum_topic', $resource->topic_id);

    $thankTable = Engine_Api::_()->getDbTable('thanks', 'sesgroupforum');

    if (empty($thank_id)) {
      $db = $thankTable->getAdapter();
      $db->beginTransaction();
      try {
        $row = $thankTable->createRow();
        $row->poster_id = $viewer_id;
        $row->resource_id = $topicuser_id;
        $row->post_id = $resource_id;
        $row->save();
        $resource->thanks_count++;
        $resource->save();
        $this->view->thank_id = $row->thank_id;
        $owner = Engine_Api::_()->getItem('user', $resource->user_id);
        if($owner->getIdentity() != $viewer_id) {
          if ($resource_type == 'sesgroupforum_post') {
            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $topic, 'sesgroupforum_post_thanks', array('label' => $topic->getShortType()));
            $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $topic, 'sesgroupforum_post_thanks');
            if ($action)
              Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $topic);
          }
        }
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function likeAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    if (empty($viewer_id))
      return;

    $resource_id = $this->_getParam('resource_id');
    $resource_type = $this->_getParam('resource_type');
    $like_id = $this->_getParam('like_id');

    $item = Engine_Api::_()->getItem($resource_type, $resource_id);

    $likeTable = Engine_Api::_()->getDbTable('likes', 'core');
    $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
    $activityStrameTable = Engine_Api::_()->getDbtable('stream', 'activity');

    if (empty($like_id)) {
      $isLike = $likeTable->isLike($item, $viewer);
      if (empty($isLike)) {
        $db = $likeTable->getAdapter();
        $db->beginTransaction();

        try {
          if (!empty($item))
            $like_id = $likeTable->addLike($item, $viewer)->like_id;
          $this->view->like_id = $like_id;
          $owner = $item->getOwner();
          if($owner->getIdentity() != $viewer_id) {
            if ($resource_type == 'sesgroupforum_topic') {
              Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'sesgroupforum_like_topic', array('label' => $item->getShortType()));

              $action = $activityTable->addActivity($viewer, $item, 'sesgroupforum_like_topic');
              if ($action)
                $activityTable->attachActivity($action, $item);
            } else if ($resource_type == 'sesgroupforum_post') {
              $topic = Engine_Api::_()->getItem('sesgroupforum_topic', $item->topic_id);
              Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $topic, 'sesgroupforum_like_post', array('label' => $item->getShortType()));

              $action = $activityTable->addActivity($viewer, $topic, 'sesgroupforum_like_post');
              if ($action)
                $activityTable->attachActivity($action, $item);
            }
          }

          $db->commit();
        } catch (Exception $e) {
          $db->rollBack();
          throw $e;
        }
      } else {
        $this->view->like_id = $isLike;
      }
    } else {
      if ($resource_type == 'sesgroupforum_topic') {
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => "liked", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => 'sesgroupforum_topic', "object_id = ?" => $item->getIdentity()));
       $action = $activityTable->fetchRow(array('type =?' => "sesgroupforum_like_topic", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      }
      if (!empty($action)) {
        $action->delete();
      }

      $likeTable->removeLike($item, $viewer);
      $this->view->like_id = 0;
    }
  }


    public function rateAction()
    {
        $viewer = Engine_Api::_()->user()->getViewer();
        $user_id = $viewer->getIdentity();

        $rating = $this->_getParam('rating');
        $topic_id =  $this->_getParam('topic_id');


        $table = Engine_Api::_()->getDbtable('ratings', 'sesgroupforum');
        $db = $table->getAdapter();
        $db->beginTransaction();

        try {
            Engine_Api::_()->sesgroupforum()->setRating($topic_id, $user_id, $rating);

            $forum_topic = Engine_Api::_()->getItem('sesgroupforum_topic', $topic_id);
            $forum_topic->rating = Engine_Api::_()->sesgroupforum()->getRating($forum_topic->getIdentity());
            $forum_topic->save();

            if($forum_topic->user_id != $viewer->getIdentity()) {
                $owner = Engine_Api::_()->getItem('user', $forum_topic->user_id);
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $forum_topic, 'sesgroupforum_rating');
            }

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }

        $total = Engine_Api::_()->sesgroupforum()->ratingCount($forum_topic->getIdentity());

        $data = array();
        $data[] = array(
            'total' => $total,
            'rating' => $rating,
        );
        return $this->_helper->json($data);
    }

  public function uploadPhotoAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    $this->_helper->layout->disableLayout();

    if( !Engine_Api::_()->authorization()->isAllowed('album', $viewer, 'create') ) {
      return false;
    }

    if( !$this->_helper->requireAuth()->setAuthParams('album', null, 'create')->isValid() ) return;

    if( !$this->_helper->requireUser()->checkRequire() )
    {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Max file size limit exceeded (probably).');
      return;
    }

    if( !$this->getRequest()->isPost() )
    {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    if( !isset($_FILES['userfile']) || !is_uploaded_file($_FILES['userfile']['tmp_name']) )
    {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid Upload');
      return;
    }

    $db = Engine_Api::_()->getDbtable('photos', 'album')->getAdapter();
    $db->beginTransaction();

    try
    {
      $viewer = Engine_Api::_()->user()->getViewer();

      $photoTable = Engine_Api::_()->getDbtable('photos', 'album');
      $photo = $photoTable->createRow();
      $photo->setFromArray(array(
        'owner_type' => 'user',
        'owner_id' => $viewer->getIdentity()
      ));
      $photo->save();

      $photo->setPhoto($_FILES['userfile']);

      $this->view->status = true;
      $this->view->name = $_FILES['userfile']['name'];
      $this->view->photo_id = $photo->photo_id;
      $this->view->photo_url = $photo->getPhotoUrl();

      $table = Engine_Api::_()->getDbtable('albums', 'album');
      $album = $table->getSpecialAlbum($viewer, 'sesgroupforum');

      $photo->album_id = $album->album_id;
      $photo->save();

      if( !$album->photo_id )
      {
        $album->photo_id = $photo->getIdentity();
        $album->save();
      }

      $auth      = Engine_Api::_()->authorization()->context;
      $auth->setAllowed($photo, 'everyone', 'view',    true);
      $auth->setAllowed($photo, 'everyone', 'comment', true);
      $auth->setAllowed($album, 'everyone', 'view',    true);
      $auth->setAllowed($album, 'everyone', 'comment', true);


      $db->commit();

    } catch( Album_Model_Exception $e ) {
      $db->rollBack();
      $this->view->status = false;
      $this->view->error = $this->view->translate($e->getMessage());
      throw $e;
      return;

    } catch( Exception $e ) {
      $db->rollBack();
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('An error occurred.');
      throw $e;
      return;
    }
  }

    public function addReputationAction() {

        if (!$this->_helper->requireUser()->isValid()) {
            return;
        }

        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();

        $resource_id = $this->_getParam('resource_id', null);
        $post_id = $this->_getParam('post_id', null);

        $resource_type = $this->_getParam('resource_type', null);
        $resource = Engine_Api::_()->getItem($resource_type, $post_id);
        $topic = Engine_Api::_()->getItem('sesgroupforum_topic', $resource->topic_id);

        $this->view->form = $form = new Sesgroupforum_Form_Reputation();

        if (!$this->getRequest()->isPost())
            return;

        if (!$form->isValid($this->getRequest()->getPost()))
            return;

        $values = $form->getValues();

        // Process
        $table = Engine_Api::_()->getDbTable('reputations', 'sesgroupforum');
        $db = $table->getAdapter();
        $db->beginTransaction();

        try
        {
            $row = $table->createRow();
            $row->resource_id = $resource_id;
            $row->post_id = $post_id;
            $row->poster_id = $viewer_id;
            $row->reputation = $values['reputation'];
            $row->save();

            $owner = Engine_Api::_()->getItem('user', $resource_id);
             if($owner->getIdentity() != $viewer_id) {
                    if ($resource_type == 'sesgroupforum_post') {
                        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $topic, 'sesgroupforum_post_reputation', array('label' => $topic->getShortType()));
                        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $topic, 'sesgroupforum_post_reputation');
                        if ($action)
                            Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $topic);
                    }
                }

            $db->commit();
        }

        catch( Exception $e )
        {
            $db->rollBack();
            throw $e;
        }

        return $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh'=> 10,
            'messages' => array('')
        ));
    }

}
