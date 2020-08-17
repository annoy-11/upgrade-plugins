<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Topic.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Model_Topic extends Core_Model_Item_Abstract
{
  protected $_parent_type = 'sesgroupforum';
  protected $_owner_type = 'user';
  protected $_children_types = array('sesgroupforum_post');


  // Generic content methods
  public function getDescription()
  {
    if( !isset($this->store()->firstPost) ) {
      $postTable = Engine_Api::_()->getDbtable('posts', 'sesgroupforum');
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
      'route' => 'sesgroupforum_topic',
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
		$defaultPhoto = 'application/modules/Sesgroupforum/externals/images/nophoto_topic_thumb_icon.png';
		return $defaultPhoto;
  }
  
  // hooks

//   protected function _insert()
//   {
//     if( empty($this->forum_id) ) {
//       throw new Sesgroupforum_Model_Exception('Cannot have a topic without a groupforum');
//     }
// 
//     if( empty($this->user_id) ) {
//       throw new Sesgroupforum_Model_Exception('Cannot have a topic without a user');
//     }
// 
//     // Increment parent topic count
// //     $sesgroupforum = $this->getParent();
// //     
// //     $sesgroupforum->topic_count = new Zend_Db_Expr('topic_count + 1');
// //     $sesgroupforum->modified_date = date('Y-m-d H:i:s');
// //     $sesgroupforum->save();
// 
//     parent::_insert();
//   }

  protected function _update()
  {
    if( empty($this->forum_id) ) {
      throw new Sesgroupforum_Model_Exception('Cannot have a topic without a sesgroupforum');
    }

    if( empty($this->user_id) ) {
      throw new Sesgroupforum_Model_Exception('Cannot have a topic without a user');
    }

    if( !empty($this->_modifiedFields['forum_id']) ) {
      $originalSesgroupforumIdentity = $this->getTable()->select()
        ->from($this->getTable()->info('name'), 'forum_id')
        ->where('topic_id = ?', $this->getIdentity())
        ->limit(1)
        ->query()
        ->fetchColumn(0)
        ;
      if( $originalSesgroupforumIdentity != $this->forum_id ) {
        $postsTable = Engine_Api::_()->getItemTable('sesgroupforum_post');

        $topicLastPost = $this->getLastCreatedPost();

        $oldSesgroupforum = Engine_Api::_()->getItem('sesgroupforum', $originalSesgroupforumIdentity);
        $newSesgroupforum = Engine_Api::_()->getItem('sesgroupforum', $this->forum_id);

        $oldSesgroupforumLastPost = $oldSesgroupforum->getLastCreatedPost();
        $newSesgroupforumLastPost = $newSesgroupforum->getLastCreatedPost();

        // Update old sesgroupforum
        $oldSesgroupforum->topic_count = new Zend_Db_Expr('topic_count - 1');
        $oldSesgroupforum->post_count = new Zend_Db_Expr(sprintf('post_count - %d', $this->post_count));
        if( !$oldSesgroupforumLastPost || $oldSesgroupforumLastPost->topic_id == $this->getIdentity() ) {
          // Update old sesgroupforum last post
          $oldSesgroupforumNewLastPost = $postsTable->select()
            ->from($postsTable->info('name'), array('post_id', 'user_id'))
            ->where('forum_id = ?', $originalSesgroupforumIdentity)
            ->where('topic_id != ?', $this->getIdentity())
            ->order('post_id DESC')
            ->limit(1)
            ->query()
            ->fetch();
          if( $oldSesgroupforumNewLastPost ) {
            $oldSesgroupforum->lastpost_id = $oldSesgroupforumNewLastPost['post_id'];
            $oldSesgroupforum->lastposter_id = $oldSesgroupforumNewLastPost['user_id'];
          } else {
            $oldSesgroupforum->lastpost_id = 0;
            $oldSesgroupforum->lastposter_id = 0;
          }
        }
        $oldSesgroupforum->save();

        // Update new sesgroupforum
        $newSesgroupforum->topic_count = new Zend_Db_Expr('topic_count + 1');
        $newSesgroupforum->post_count = new Zend_Db_Expr(sprintf('post_count + %d', $this->post_count));
        if( !$newSesgroupforumLastPost || strtotime($topicLastPost->creation_date) > strtotime($newSesgroupforumLastPost->creation_date) ) {
          // Update new sesgroupforum last post
          $newSesgroupforum->lastpost_id = $topicLastPost->post_id;
          $newSesgroupforum->lastposter_id = $topicLastPost->user_id;
        }
        if( strtotime($topicLastPost->creation_date) > strtotime($newSesgroupforum->modified_date) ) {
          $newSesgroupforum->modified_date = $topicLastPost->creation_date;
        }
        $newSesgroupforum->save();

        // Update posts
        $postsTable = Engine_Api::_()->getItemTable('sesgroupforum_post');
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
  
  public function getParent($recurseType = NULL) {
    return Engine_Api::_()->getItem('sesgroupforum', $this->forum_id);
  }

  protected function _delete() {

//     $sesgroupforum = $this->getParent();
// 
//     // Decrement sesgroupforum topic and post count
// //     $sesgroupforum->topic_count = new Zend_Db_Expr('topic_count - 1');
// //     $sesgroupforum->post_count = new Zend_Db_Expr(sprintf('post_count - %s', $this->post_count));
// 
//     // Update sesgroupforum last post
//     $olderSesgroupforumLastPost = Engine_Api::_()->getDbtable('posts', 'sesgroupforum')->select()
//       ->where('forum_id = ?', $this->forum_id)
//       ->where('topic_id != ?', $this->topic_id)
//       ->order('post_id DESC')
//       ->limit(1)
//       ->query()
//       ->fetch();
// 
//     if( $olderSesgroupforumLastPost['post_id'] != $sesgroupforum->lastpost_id ) {
//       if( $olderSesgroupforumLastPost ) {
//         $sesgroupforum->lastpost_id = $olderSesgroupforumLastPost['post_id'];
//         $sesgroupforum->lastposter_id = $olderSesgroupforumLastPost['user_id'];
//       } else {
//         $sesgroupforum->lastpost_id = null;
//         $sesgroupforum->lastposter_id = null;
//       }
//     }
// 
//     $sesgroupforum->save();

    // Delete all posts
    $table = Engine_Api::_()->getItemTable('sesgroupforum_post');
    $select = $table->select()
      ->where('topic_id = ?', $this->getIdentity())
      ;

    foreach( $table->fetchAll($select) as $post ) {
      $post->deletingTopic = true;
      $post->delete();
    }

    // remove topic views
    Engine_Api::_()->getDbTable('topicviews', 'sesgroupforum')->delete(array(
      'topic_id = ?' => $this->topic_id,
    ));

    // remove topic watches
    Engine_Api::_()->getDbTable('topicwatches', 'sesgroupforum')->delete(array(
      'resource_id = ?' => $this->forum_id,
      'topic_id = ?' => $this->topic_id,
    ));

    parent::_delete();
  }

  public function getLastCreatedPost()
  {
    $post = Engine_Api::_()->getItem('sesgroupforum_post', $this->lastpost_id);
    if (!$post) {
      // this can happen if the last post was deleted
      $table  = Engine_Api::_()->getDbTable('posts', 'sesgroupforum');
      $post   = $table->fetchRow(array('topic_id = ?' => $this->getIdentity()), 'creation_date DESC');
      if ($post) {
        // update topic table with valid information
        $db = $table->getAdapter();
        $db->beginTransaction();
        try {
          $row = Engine_Api::_()->getItem('sesgroupforum_topic', $this->getIdentity());
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
    $table = Engine_Api::_()->getDbTable('topicviews', 'sesgroupforum');
    $table->delete(array('topic_id = ?'=>$this->getIdentity(), 'user_id = ?'=>$user->getIdentity()));
    $row = $table->createRow();
    $row->user_id = $user->user_id;
    $row->topic_id = $this->topic_id;
    $row->last_view_date = date('Y-m-d H:i:s');
    $row->save();
  }

  public function isViewed($user)
  {
    $table = Engine_Api::_()->getDbTable('topicviews', 'sesgroupforum');
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
    $table = Engine_Api::_()->getItemTable('sesgroupforum_post');
    $select = $table->select()->from($table->info('name'), new Zend_Db_Expr('COUNT(post_id) as post_count'))
      ->where("user_id = ?", $user_id);
    return $table->fetchRow($select);
  }
}
