<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Post.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Model_Post extends Core_Model_Item_Abstract
{
  protected $_parent_type = 'sesgroupforum_topic';
  protected $_owner_type = 'user';

  public $deletingTopic;

  public function getDescription()
  {
    // strip HTML and BBcode
    $content = strip_tags($this->body);
    $content = preg_replace('|[[\/\!]*?[^\[\]]*?]|si', '', $content);
    return $content;
  }

  public function getHref($params = array())
  {
    $topic = $this->getParent();
    $params = array_merge(array(
      'route' => 'sesgroupforum_topic',
      'reset' => true,
      'topic_id' => $this->topic_id,
      'slug' => $topic->getSlug(),
      'post_id' => $this->getIdentity(),
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
  }


  // Hooks

  protected function _insert()
  {
    if( empty($this->topic_id) ) {
      throw new Sesgroupforum_Model_Exception('Cannot have a post without a topic');
    }

    if( empty($this->user_id) ) {
      throw new Sesgroupforum_Model_Exception('Cannot have a post without a user');
    }

    parent::_insert();
  }

  protected function _postInsert()
  {
    // Increment user post count
    $table = Engine_Api::_()->getItemTable('sesgroupforum_signature');
    $select = $table->select()
      ->where('user_id = ?', $this->user_id)
      ->limit(1);

    // Update user post count
    $row = $table->fetchRow($select);
    if( null === $row ) {
      $row = $table->createRow();
      $row->user_id = $this->user_id;
      $row->post_count = 0;
    }
    $row->post_count = new Zend_Db_Expr('post_count + 1');
    $row->save();

    // Update topic post count
    $topic = $this->getParent();
    $topic->post_count = new Zend_Db_Expr('post_count + 1');
    $topic->modified_date = $this->creation_date;
    $topic->lastpost_id = $this->post_id;
    $topic->lastposter_id = $this->user_id;
    $topic->save();

    // Update sesgroupforum post count
//     $sesgroupforum = $topic->getParent();
//     $sesgroupforum->post_count = new Zend_Db_Expr('post_count + 1');
//     $sesgroupforum->modified_date = $this->creation_date;
//     $sesgroupforum->lastpost_id = $this->post_id;
//     $sesgroupforum->lastposter_id = $this->user_id;
//     $sesgroupforum->save();

    parent::_postInsert();
  }

  protected function _update()
  {
    if( empty($this->topic_id) ) {
      throw new Sesgroupforum_Model_Exception('Cannot have a post without a topic');
    }

    // removed this because it needs to be backwards compatible to v3,
    // where posts with user_id=0 were allowed because of deleted users
    //if( empty($this->user_id) ) {
    //  throw new Sesgroupforum_Model_Exception('Cannot have a post without a user');
    //}

    $this->modified_date = date('Y-m-d H:i:s');

    parent::_update();
  }

  protected function _delete()
  {
    $this->deletePhoto();

    // Decrement user post count
    Engine_Api::_()->getItemTable('sesgroupforum_signature')->update(array(
      'post_count' => new Zend_Db_Expr('post_count - 1'),
    ), array(
      'user_id = ?' => $this->user_id,
      // only decrement if the post_count is greater than 0
      'post_count > 0'
    ));

    if( !$this->deletingTopic ) {

      $topic = $this->getParent();
      $sesgroupforum = $topic->getParent();


      // if post count is 0, delete the topic
      if( $topic->post_count - 1 == 0 ) {
        $topic->delete();

      } else {

          // Update topic post count
          $topic->post_count = new Zend_Db_Expr('post_count - 1');

          // Update topic last post
          if( $topic->lastpost_id == $this->post_id ) {
            $olderTopicLastPost = $this->getTable()->select()
              ->where('topic_id = ?', $this->topic_id)
              ->order('post_id DESC')
              ->limit(1)
              ->query()
              ->fetch();

            if( $olderTopicLastPost ) {
              $topic->lastpost_id = $olderTopicLastPost['post_id'];
              $topic->lastposter_id = $olderTopicLastPost['user_id'];
            } else {
              $topic->lastpost_id = null;
              $topic->lastposter_id = null;
            }
          }

          // Update sesgroupforum post count
          $sesgroupforum->post_count = new Zend_Db_Expr('post_count - 1');

          // Update sesgroupforum last post
          if( $sesgroupforum->lastpost_id == $this->post_id ) {
            $olderSesgroupforumLastPost = $this->getTable()->select()
              ->where('forum_id = ?', $this->forum_id)
              ->order('post_id DESC')
              ->limit(1)
              ->query()
              ->fetch();

            if( $olderSesgroupforumLastPost ) {
              $sesgroupforum->lastpost_id = $olderSesgroupforumLastPost['post_id'];
              $sesgroupforum->lastposter_id = $olderSesgroupforumLastPost['user_id'];
            } else {
              $sesgroupforum->lastpost_id = null;
              $sesgroupforum->lastposter_id = null;
            }
          }

          $topic->save();
          $sesgroupforum->save();
      }
    }
  }

  public function getLastCreatedPost()
  {
    return $this->getChildren('sesgroupforum_post', array('limit'=>1, 'order'=>'creation_date DESC'));
  }

  public function setPhoto($photo)
  {
    if( $photo instanceof Zend_Form_Element_File ) {
      $file = $photo->getFileName();
    } else if( is_array($photo) && !empty($photo['tmp_name']) ) {
      $file = $photo['tmp_name'];
    } else if( is_string($photo) && file_exists($photo) ) {
      $file = $photo;
    } else {
      throw new Event_Model_Exception('invalid argument passed to setPhoto');
    }

    $name = basename($file);
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
     'parent_id' => $this->getIdentity(),
     'parent_type'=>'sesgroupforum_post'
    );

    // Save
    $storage = Engine_Api::_()->storage();

    // Resize image (main)
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(2000, 2000)
      ->write($path.'/m_'.$name)
      ->destroy();

    // Store
    $iMain = $storage->create($path.'/m_'.$name, $params);

    // Remove temp files
    @unlink($path.'/m_'.$name);

    // Update row
    $this->modified_date = date('Y-m-d H:i:s');
    $this->file_id = $iMain->getIdentity();
    $this->save();

    return $this;
  }

  public function getSignature()
  {
    $user_id = $this->user_id;
    $table = Engine_Api::_()->getItemTable('sesgroupforum_signature');
    $select = $table->select()
      ->where("user_id = ?", $user_id)
      ->limit(1);
    return $table->fetchRow($select);
  }
//   public function getUserPosts()
//   {
//     $user_id = $this->user_id;
//     $topic_id = $this->topic_id;
//     $table = Engine_Api::_()->getDbTable('sesgroupforum', 'posts');
//     $select = $table->select()->from($table->info('name'), new Zend_Db_Expr('COUNT(post_id) as post_count'))
//       ->where("user_id = ?", $user_id)
//       ->where("topic_id = ?", $topic_id);
//     return $table->fetchAll($select);
//   }

  public function getPhotoUrl($type = null)
  {
    $photo_id = $this->file_id;
    if( !$photo_id ) {
      return null;
    }

    $file = Engine_Api::_()->getItemTable('storage_file')->getFile($photo_id, $type);
    if( !$file ) {
      return null;
    }

    return $file->map();
  }

  public function getPostIndex()
  {
    $table = $this->getTable();


    $select = new Zend_Db_Select($table->getAdapter());
    $select
      ->from($table->info('name'), new Zend_Db_Expr('COUNT(post_id) as count'))
      ->where('topic_id = ?', $this->topic_id)
      ->where('post_id < ?', $this->getIdentity())
      ->order('post_id ASC')
      ;

    $data = $select->query()->fetch();
    return (int) $data['count'];
  }

  public function canEdit($user)
  {
    return $this->getParent()->getParent()->authorization()->isAllowed($user, 'moderate') || ($this->isOwner($user) && !$this->getParent()->closed);
  }

  public function canDelete($user)
  {
    return $this->getParent()->getParent()->authorization()->isAllowed($user, 'moderate');
  }


  public function deletePhoto()
  {
    if( empty($this->file_id) ) {
      return;
    }
    // This is dangerous, what if something throws an exception in postDelete
    // after the files are deleted?
    try {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->file_id);
      if( $file ) {
        $file->remove();
      }
      $this->file_id = null;
    } catch( Exception $e ) {
      // @todo completely silencing them probably isn't good enough
      throw $e;
    }
  }

}
