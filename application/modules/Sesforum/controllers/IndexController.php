<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_IndexController extends Core_Controller_Action_Standard
{
    public function init() {

    }
    public function dashboardAction () {

        // Render
        $this->_helper->content
            //->setNoRender()
            ->setEnabled()
            ;

    }

    public function searchAction() {
        $this->_helper->content->setEnabled();
    }

    public function tagsAction() {
        $this->_helper->content->setEnabled();
    }

    public function myPostsAction() {

        $is_ajax = $this->_getParam('is_ajax', null);
        $liked = $this->_getParam('liked', 0);

        $viewer = Engine_Api::_()->user()->getViewer();
        // Get sesforums allowed to be viewed by current user
        $sesforumIds = array();
        $authTable = Engine_Api::_()->getDbtable('allow', 'authorization');
        $perms = $authTable->select()
            ->where('resource_type = ?', 'sesforum_forum')
            ->where('action = ?', 'view')
            ->query()
            ->fetchAll();
        foreach( $perms as $perm ) {
            if( $perm['role'] == 'everyone' ) {
                $sesforumIds[] = $perm['resource_id'];
            } else if( $viewer &&
                $viewer->getIdentity() &&
                $perm['role'] == 'authorization_level' &&
                $perm['role_id'] == $viewer->level_id ) {
                $sesforumIds[] = $perm['resource_id'];
            }
        }
//         if( empty($sesforumIds) ) {
//             return $this->setNoRender();
//         }


        // Get paginator
        //$this->view->subject = $subject = Engine_Api::_()->core()->getSubject('user');
         $likeTableName = Engine_Api::_()->getDbtable('likes', 'core')->info('name');
        $postsTable = Engine_Api::_()->getDbtable('posts', 'sesforum');
        $postsSelect = $postsTable->select()->order('creation_date DESC');

         if(!empty($liked) && $liked == '1') {
            $postsSelect->setIntegrityCheck(false)
            ->from($postsTable->info('name'))
            ->join($likeTableName, $likeTableName . '.resource_id = ' . $postsTable->info('name') . '.post_id', null)->where($likeTableName.'.resource_type = ?', 'sesforum_post');
            $postsSelect->where($likeTableName.'.poster_id = ?', $viewer->getIdentity())->where($postsTable->info('name').'.forum_id IN(?)', $sesforumIds);
        } else {
            $postsSelect->where('user_id = ?', $viewer->getIdentity())->where('forum_id IN(?)', $sesforumIds);
        }

        $this->view->paginator = $paginator = Zend_Paginator::factory($postsSelect);

        // Set item count per page and current page number
        $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', 30));
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    }

  public function subscribeAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    if (empty($viewer_id))
      return;

    $resource_id = $this->_getParam('resource_id');
    $resource_type = $this->_getParam('resource_type');
    $subscribe_id = $this->_getParam('subscribe_id');

    $item = Engine_Api::_()->getItem($resource_type, $resource_id);



    $subscribeTable = Engine_Api::_()->getDbTable('subscribes', 'sesforum');
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
            if ($resource_type == 'sesforum_forum') {
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
        $subsitem = Engine_Api::_()->getItem('sesforum_subscribe', $subscribe_id);
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


    public function myTopicsAction() {

        $is_ajax = $this->_getParam('is_ajax', null);
        $liked = $this->_getParam('liked', 0);

        $viewer = Engine_Api::_()->user()->getViewer();
        // Get sesforums allowed to be viewed by current user
        $sesforumIds = array();
        $authTable = Engine_Api::_()->getDbtable('allow', 'authorization');
        $perms = $authTable->select()
            ->where('resource_type = ?', 'sesforum_forum')
            ->where('action = ?', 'view')
            ->query()
            ->fetchAll();
        foreach( $perms as $perm ) {
            if( $perm['role'] == 'everyone' ) {
                $sesforumIds[] = $perm['resource_id'];
            } else if( $viewer &&
                $viewer->getIdentity() &&
                $perm['role'] == 'authorization_level' &&
                $perm['role_id'] == $viewer->level_id ) {
                $sesforumIds[] = $perm['resource_id'];
            }
        }
//         if( empty($sesforumIds) ) {
//             return $this->setNoRender();
//         }

        // Get paginator
        $postsTable = Engine_Api::_()->getDbtable('topics', 'sesforum');
        $likeTableName = Engine_Api::_()->getDbtable('likes', 'core')->info('name');
        $topicwatchesTableName = Engine_Api::_()->getDbTable('topicwatches', 'sesforum')->info('name');
        $postsSelect = $postsTable->select();
        if(!empty($liked) && $liked == '1') {
            $postsSelect->setIntegrityCheck(false)
            ->from($postsTable->info('name'))
            ->join($likeTableName, $likeTableName . '.resource_id = ' . $postsTable->info('name') . '.topic_id', null)->where($likeTableName.'.resource_type = ?', 'sesforum_topic')->where($likeTableName.'.poster_id = ?', $viewer->getIdentity());
        } elseif(!empty($liked) && $liked == '2') {
            $postsSelect->setIntegrityCheck(false)
            ->from($postsTable->info('name'))
            ->join($topicwatchesTableName, $topicwatchesTableName . '.topic_id = ' . $postsTable->info('name') . '.topic_id', null)->where($topicwatchesTableName.'.watch =?', 1)->where($topicwatchesTableName.'.user_id =?', $viewer->getIdentity())->group($topicwatchesTableName.'.topic_id');
        }

        $postsSelect->where('forum_id IN(?)', $sesforumIds)
                    ->order('creation_date DESC');
        if(empty($liked))
            $postsSelect->where('user_id = ?', $viewer->getIdentity());

        $settings = Engine_Api::_()->getApi('settings', 'core');
        $this->view->sesforum_topic_pagelength = $settings->getSetting('sesforum_topic_pagelength');
        $this->view->paginator = $paginator = Zend_Paginator::factory($postsSelect);

        // Set item count per page and current page number
        $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', 30));
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
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

        $topic = Engine_Api::_()->getItem('sesforum_topic', $resource->topic_id);

        $thankTable = Engine_Api::_()->getDbTable('thanks', 'sesforum');

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
                    if ($resource_type == 'sesforum_post') {
                        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $topic, 'sesforum_post_thanks', array('label' => $topic->getShortType()));
                        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $topic, 'sesforum_post_thanks');
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
            if ($resource_type == 'sesforum_topic') {
              Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'sesforum_like_topic', array('label' => $item->getShortType()));

              $action = $activityTable->addActivity($viewer, $item, 'sesforum_like_topic');
              if ($action)
                $activityTable->attachActivity($action, $item);
            } else if ($resource_type == 'sesforum_post') {
              $topic = Engine_Api::_()->getItem('sesforum_topic', $item->topic_id);
              Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $topic, 'sesforum_like_post', array('label' => $item->getShortType()));

              $action = $activityTable->addActivity($viewer, $topic, 'sesforum_like_post');
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
      if ($resource_type == 'sesforum_topic') {
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => "liked", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => 'sesforum_topic', "object_id = ?" => $item->getIdentity()));
       $action = $activityTable->fetchRow(array('type =?' => "sesforum_like_topic", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
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


        $table = Engine_Api::_()->getDbtable('ratings', 'sesforum');
        $db = $table->getAdapter();
        $db->beginTransaction();

        try {
            Engine_Api::_()->sesforum()->setRating($topic_id, $user_id, $rating);

            $forum_topic = Engine_Api::_()->getItem('sesforum_topic', $topic_id);
            $forum_topic->rating = Engine_Api::_()->sesforum()->getRating($forum_topic->getIdentity());
            $forum_topic->save();

            if($forum_topic->user_id != $viewer->getIdentity()) {
                $owner = Engine_Api::_()->getItem('user', $forum_topic->user_id);
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $forum_topic, 'sesforum_rating');
            }

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }

        $total = Engine_Api::_()->sesforum()->ratingCount($forum_topic->getIdentity());

        $data = array();
        $data[] = array(
            'total' => $total,
            'rating' => $rating,
        );
        return $this->_helper->json($data);
    }


  public function indexAction()
  {
    if ( !$this->_helper->requireAuth()->setAuthParams('sesforum_forum', null, 'view')->isValid() ) {
      return;
    }

    $categoryTable = Engine_Api::_()->getItemTable('sesforum_category');
    $this->view->categories = $categoryTable->fetchAll($categoryTable->select()->where('subcat_id =?', 0)->where('subsubcat_id =?', 0)->order('order ASC'));

    $sesforumTable = Engine_Api::_()->getItemTable('sesforum_forum');
    $sesforumSelect = $sesforumTable->select()
      ->order('order ASC')
      ;
    $sesforums = array();
    foreach( $sesforumTable->fetchAll() as $sesforum ) {
      if( Engine_Api::_()->authorization()->isAllowed($sesforum, null, 'view') ) {
        $order = $sesforum->order;
        while( isset($sesforums[$sesforum->category_id][$order]) ) {
          $order++;
        }
        $sesforums[$sesforum->category_id][$order] = $sesforum;
        ksort($sesforums[$sesforum->category_id]);
      }
    }
    $this->view->sesforums = $sesforums;

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;
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
      $album = $table->getSpecialAlbum($viewer, 'sesforum');

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
        $topic = Engine_Api::_()->getItem('sesforum_topic', $resource->topic_id);

        $this->view->form = $form = new Sesforum_Form_Reputation();

        if (!$this->getRequest()->isPost())
            return;

        if (!$form->isValid($this->getRequest()->getPost()))
            return;

        $values = $form->getValues();

        // Process
        $table = Engine_Api::_()->getDbTable('reputations', 'sesforum');
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
                    if ($resource_type == 'sesforum_post') {
                        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $topic, 'sesforum_post_reputation', array('label' => $topic->getShortType()));
                        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $topic, 'sesforum_post_reputation');
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
