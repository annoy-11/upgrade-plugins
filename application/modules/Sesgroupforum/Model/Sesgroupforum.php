<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Forum.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Model_Sesgroupforum extends Core_Model_Item_Collectible
{
  protected $_children_types = array('sesgroupforum_topic');

  protected $_parent_type = 'sesgroupforum_category';

  protected $_owner_type = 'sesgroupforum_category';

  protected $_collection_type = 'sesgroupforum_category';

  protected $_collection_column_name = 'category_id';
  
  protected $_type = 'sesgroupforum';

  //We use membership system to manage moderators
  public function membership()
  {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('membership', 'sesgroupforum'));
  }

  public function getCollection()
  {
    return Engine_Api::_()->getItem($this->_collection_type, $this->category_id);

  }
  
  public function getPhotoUrl($type = null) {
    $forum_icon = $this->forum_icon;
    if ($forum_icon) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->forum_icon, $type);
			if($file)
      	return $file->map();
			else{
				$file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->forum_icon,'thumb.profile');	
				if($file)
					return $file->map();
			}
    } 
		$settings = Engine_Api::_()->getApi('settings', 'core');
		$defaultPhoto = 'application/modules/Sesgroupforum/externals/images/topic-icon.png';
		return $defaultPhoto;
  }
  
  public function getHref($params = array())
  {
    $params = array_merge(array(
      'route' => 'sesgroupforum_forum',
      'reset' => true,
      'forum_id' => $this->getIdentity(),
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

  public function getSlug($str = null, $maxstrlen = 64)
  {
    $translate = Zend_Registry::get('Zend_Translate');
    $title = $translate->translate($this->getTitle());
    return parent::getSlug($title, $maxstrlen);
  }

  public function getLastCreatedPost()
  {
    return Engine_Api::_()->getItem('sesgroupforum_post', $this->lastpost_id);
  }

  public function getLastUpdatedTopic()
  {
    $lastPost = Engine_Api::_()->getItem('sesgroupforum_post', $this->lastpost_id);
    if( !$lastPost ) return false;
    return Engine_Api::_()->getItem('sesgroupforum_topic', $lastPost->topic_id);
    //return $this->getChildren('sesgroupforum_topic', array('limit'=>1, 'order'=>'modified_date DESC'))->current();
  }

  // Hooks

  protected function _insert()
  {
    if( empty($this->category_id) ) {
      throw new Sesgroupforum_Model_Exception('Cannot have a sesgroupforum without a category');
    }

    // Increment parent sesgroupforum count
    $category = $this->getParent();
    $category->sesgroupforum_count = new Zend_Db_Expr('sesgroupforum_count + 1');
    $category->save();

    parent::_insert();
  }

  protected function _update()
  {
    if( empty($this->category_id) ) {
      throw new Sesgroupforum_Model_Exception('Cannot have a sesgroupforum without a category');
    }

    parent::_update();
  }

  protected function _delete()
  {
    // Decrement parent sesgroupforum count
    $category = $this->getParent();
    $category->sesgroupforum_count = new Zend_Db_Expr('sesgroupforum_count - 1');
    $category->save();

    // Delete all child topics
    $table = Engine_Api::_()->getItemTable('sesgroupforum_topic');
    $select = $table->select()
      ->where('forum_id = ?', $this->getIdentity())
      ;
    foreach( $table->fetchAll($select) as $topic )
    {
      $topic->delete();
    }


    parent::_delete();
  }

  public function isModerator($user)
  {
    $list = $this->getModeratorList();
    return $list->has($user);
  }

  public function getModeratorList()
  {
    $table = Engine_Api::_()->getItemTable('sesgroupforum_list');
    $select = $table->select()
      ->where('owner_id = ?', $this->getIdentity())
      ->limit(1);

    $list = $table->fetchRow($select);

    if( null === $list ) {
      $list = $table->createRow();
      $list->setFromArray(array(
        'owner_id' => $this->getIdentity(),
      ));
      $list->save();
    }

    return $list;
  }


  public function getPrevSesgroupforum()
  {
    $table = $this->getTable();
    if( !in_array('order', $table->info('cols')) ) {
      throw new Core_Model_Item_Exception('Unable to use order as order column doesn\'t exist');
    }

    $select = $table->select()
      ->where('`order` < ?', $this->order)
      // Should be confined to a category
      ->where('`category_id` = ?', $this->category_id)
      ->order('order DESC')
      ->limit(1);

    return $table->fetchRow($select);
  }

  public function moveUp()
  {
    $table = $this->getTable();
    $db = $table->getAdapter();
    $db->beginTransaction();
    try
    {
      $sesgroupforums   = $table->select()->where('category_id = ?', $this->category_id)->order('order ASC')->query()->fetchAll();
      $newOrder = array();
      foreach ($sesgroupforums as $sesgroupforum) {
        if ($this->forum_id == $sesgroupforum['forum_id']) {
          $prevSesgroupforum = array_pop($newOrder);
          array_push($newOrder, $sesgroupforum['forum_id']);
          if ($prevSesgroupforum) {
            array_push($newOrder, $prevSesgroupforum);
            unset($prevSesgroupforum);
          }
        } else {
          array_push($newOrder, $sesgroupforum['forum_id']);
        }
      }
      foreach ($table->fetchAll($table->select()) as $row) {
        if ($row->category_id == $this->category_id) {
          $order = array_search($row->forum_id, $newOrder);
          $row->order = $order+1;
          $row->save();
        }
      }
      $db->commit();
    }
    catch (Exception $e)
    {
      $db->rollBack();
      throw $e;
    }
  }
}
