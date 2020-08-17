<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Topic.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Model_Topic extends Core_Model_Item_Abstract
{
  protected $_parent_type = 'sesforum_forum';

  protected $_owner_type = 'user';

  protected $_children_types = array('sesforum_post');


  // Generic content methods

  public function getDescription()
  {
    if( !isset($this->store()->firstPost) ) {
      $postTable = Engine_Api::_()->getDbtable('posts', 'sesforum');
      $postSelect = $postTable->select()
        ->where('topic_id = ?', $this->getIdentity())
        ->order('post_id ASC')
        ->limit(1);
      $this->store()->firstPost = $postTable->fetchRow($postSelect);
    }
    if( isset($this->store()->firstPost) ) {
      // strip HTML and BBcode
      $content = $this->store()->firstPost->body;
      $content = strip_tags($content);
      $content = preg_replace('|[[\/\!]*?[^\[\]]*?]|si', '', $content);
      return $content;
    }
    return '';
  }

  public function getHref($params = array())
  {
    $params = array_merge(array(
      'route' => 'sesforum_topic',
      'reset' => true,
      'topic_id' => $this->getIdentity(),
      'slug' => $this->getSlug(),
      'action' => 'view',
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
  }
  
  public function getPhotoUrl($type = null) {
		$defaultPhoto = 'application/modules/Sesforum/externals/images/nophoto_topic_thumb_icon.png';
		return $defaultPhoto;
  }
  
  // hooks

  protected function _insert()
  {
    if( empty($this->forum_id) ) {
      throw new Sesforum_Model_Exception('Cannot have a topic without a sesforum');
    }

    if( empty($this->user_id) ) {
      throw new Sesforum_Model_Exception('Cannot have a topic without a user');
    }

    // Increment parent topic count
    $sesforum = $this->getParent();
    $sesforum->topic_count = new Zend_Db_Expr('topic_count + 1');
    $sesforum->modified_date = date('Y-m-d H:i:s');
    $sesforum->save();

    parent::_insert();
  }

  protected function _update()
  {
    if( empty($this->forum_id) ) {
      throw new Sesforum_Model_Exception('Cannot have a topic without a sesforum');
    }

    if( empty($this->user_id) ) {
      throw new Sesforum_Model_Exception('Cannot have a topic without a user');
    }

    if( !empty($this->_modifiedFields['forum_id']) ) {
      $originalSesforumIdentity = $this->getTable()->select()
        ->from($this->getTable()->info('name'), 'forum_id')
        ->where('topic_id = ?', $this->getIdentity())
        ->limit(1)
        ->query()
        ->fetchColumn(0)
        ;
      if( $originalSesforumIdentity != $this->forum_id ) {
        $postsTable = Engine_Api::_()->getItemTable('sesforum_post');

        $topicLastPost = $this->getLastCreatedPost();

        $oldSesforum = Engine_Api::_()->getItem('sesforum_forum', $originalSesforumIdentity);
        $newSesforum = Engine_Api::_()->getItem('sesforum_forum', $this->forum_id);

        $oldSesforumLastPost = $oldSesforum->getLastCreatedPost();
        $newSesforumLastPost = $newSesforum->getLastCreatedPost();

        // Update old sesforum
        $oldSesforum->topic_count = new Zend_Db_Expr('topic_count - 1');
        $oldSesforum->post_count = new Zend_Db_Expr(sprintf('post_count - %d', $this->post_count));
        if( !$oldSesforumLastPost || $oldSesforumLastPost->topic_id == $this->getIdentity() ) {
          // Update old sesforum last post
          $oldSesforumNewLastPost = $postsTable->select()
            ->from($postsTable->info('name'), array('post_id', 'user_id'))
            ->where('forum_id = ?', $originalSesforumIdentity)
            ->where('topic_id != ?', $this->getIdentity())
            ->order('post_id DESC')
            ->limit(1)
            ->query()
            ->fetch();
          if( $oldSesforumNewLastPost ) {
            $oldSesforum->lastpost_id = $oldSesforumNewLastPost['post_id'];
            $oldSesforum->lastposter_id = $oldSesforumNewLastPost['user_id'];
          } else {
            $oldSesforum->lastpost_id = 0;
            $oldSesforum->lastposter_id = 0;
          }
        }
        $oldSesforum->save();

        // Update new sesforum
        $newSesforum->topic_count = new Zend_Db_Expr('topic_count + 1');
        $newSesforum->post_count = new Zend_Db_Expr(sprintf('post_count + %d', $this->post_count));
        if( !$newSesforumLastPost || strtotime($topicLastPost->creation_date) > strtotime($newSesforumLastPost->creation_date) ) {
          // Update new sesforum last post
          $newSesforum->lastpost_id = $topicLastPost->post_id;
          $newSesforum->lastposter_id = $topicLastPost->user_id;
        }
        if( strtotime($topicLastPost->creation_date) > strtotime($newSesforum->modified_date) ) {
          $newSesforum->modified_date = $topicLastPost->creation_date;
        }
        $newSesforum->save();

        // Update posts
        $postsTable = Engine_Api::_()->getItemTable('sesforum_post');
        $postsTable->update(array(
          'forum_id' => $this->forum_id,
        ), array(
          'topic_id = ?' => $this->getIdentity(),
        ));
      }
    }

    parent::_update();
  }

  public function tags() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbTable('tags', 'core'));
  }

  protected function _delete()
  {
    $sesforum = $this->getParent();

    // Decrement sesforum topic and post count
    $sesforum->topic_count = new Zend_Db_Expr('topic_count - 1');
    $sesforum->post_count = new Zend_Db_Expr(sprintf('post_count - %s', $this->post_count));

    // Update sesforum last post
    $olderSesforumLastPost = Engine_Api::_()->getDbtable('posts', 'sesforum')->select()
      ->where('forum_id = ?', $this->forum_id)
      ->where('topic_id != ?', $this->topic_id)
      ->order('post_id DESC')
      ->limit(1)
      ->query()
      ->fetch();

    if( $olderSesforumLastPost['post_id'] != $sesforum->lastpost_id ) {
      if( $olderSesforumLastPost ) {
        $sesforum->lastpost_id = $olderSesforumLastPost['post_id'];
        $sesforum->lastposter_id = $olderSesforumLastPost['user_id'];
      } else {
        $sesforum->lastpost_id = null;
        $sesforum->lastposter_id = null;
      }
    }

    $sesforum->save();

    // Delete all posts
    $table = Engine_Api::_()->getItemTable('sesforum_post');
    $select = $table->select()
      ->where('topic_id = ?', $this->getIdentity())
      ;

    foreach( $table->fetchAll($select) as $post ) {
      $post->deletingTopic = true;
      $post->delete();
    }

    // remove topic views
    Engine_Api::_()->getDbTable('topicviews', 'sesforum')->delete(array(
      'topic_id = ?' => $this->topic_id,
    ));

    // remove topic watches
    Engine_Api::_()->getDbTable('topicwatches', 'sesforum')->delete(array(
      'resource_id = ?' => $this->forum_id,
      'topic_id = ?' => $this->topic_id,
    ));

    parent::_delete();
  }

  public function getLastCreatedPost()
  {
    $post = Engine_Api::_()->getItem('sesforum_post', $this->lastpost_id);
    if (!$post) {
      // this can happen if the last post was deleted
      $table  = Engine_Api::_()->getDbTable('posts', 'sesforum');
      $post   = $table->fetchRow(array('topic_id = ?' => $this->getIdentity()), 'creation_date DESC');
      if ($post) {
        // update topic table with valid information
        $db = $table->getAdapter();
        $db->beginTransaction();
        try {
          $row = Engine_Api::_()->getItem('sesforum_topic', $this->getIdentity());
          $row->lastpost_id   = $post->getIdentity();
          $row->lastposter_id = $post->getOwner('user')->getIdentity();
          $row->save();
          $db->commit();
        } catch (Exception $e) {
          $db->rollback();
          // @todo silence error?
        }
      }
    }
    return $post;
  }

  public function registerView($user)
  {
    $table = Engine_Api::_()->getDbTable('topicviews', 'sesforum');
    $table->delete(array('topic_id = ?'=>$this->getIdentity(), 'user_id = ?'=>$user->getIdentity()));
    $row = $table->createRow();
    $row->user_id = $user->user_id;
    $row->topic_id = $this->topic_id;
    $row->last_view_date = date('Y-m-d H:i:s');
    $row->save();
  }

  public function isViewed($user)
  {
    $table = Engine_Api::_()->getDbTable('topicviews', 'sesforum');
    $row = $table->fetchRow($table->select()->where('user_id = ?', $user->getIdentity())->where('last_view_date > ?', $this->modified_date)->where("topic_id = ?", $this->getIdentity()));
    return $row != null;
  }

  public function getLastPage($per_page)
  {
    return $per_page > 0 ? ceil($this->post_count / $per_page) : 0;
  }

  public function getAuthorizationItem()
  {
    return $this->getParent();
  }
 public function getUserPosts()
  {
    $user_id = $this->user_id;
    $topic_id = $this->topic_id;
    $table = Engine_Api::_()->getItemTable('sesforum_post');
    $select = $table->select()->from($table->info('name'), new Zend_Db_Expr('COUNT(post_id) as post_count'))
      ->where("user_id = ?", $user_id);
    return $table->fetchRow($select);
  }
}
