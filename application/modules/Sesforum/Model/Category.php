<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Category.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Model_Category extends Core_Model_Item_Collection
{
  protected $_children_types = array('sesforum_forum');

  protected $_collectible_type = "sesforum_forum";

  protected $_collection_column_name = "category_id";

  public function getHref($params = array())
  {
    $params = array_merge(array(
     // 'route' => 'sesforum_general',
      //'reset' => true,

      'route' => 'sesforum_category',
      'reset' => true,
      'module' => 'sesforum',
      'controller' => 'category',
      'action' => 'view',
      'category_id' => $this->slug,


    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
  }
  
  public function getPhotoUrl($type = null) {
    $cat_icon = $this->cat_icon;
    if ($cat_icon) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->cat_icon, $type);
			if($file)
      	return $file->map();
			else{
				$file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->cat_icon,'thumb.profile');	
				if($file)
					return $file->map();
			}
    } 
		$settings = Engine_Api::_()->getApi('settings', 'core');
		$defaultPhoto = 'application/modules/Sesforum/externals/images/topic-icon.png';
		return $defaultPhoto;
  }

  protected function getPrevCategory()
  {
    $table = Engine_Api::_()->getItemTable('sesforum_category');
    if( !in_array('order', $table->info('cols')) )
    {
      throw new Core_Model_Item_Exception('Unable to use order as order column doesn\'t exist');
    }


    $select = $table->select()->setIntegrityCheck(false)
      ->from($table->info('name'), 'MAX(`order`) AS max_order')
      ->where('`order` < ?', $this->order);

    $row = $select->query()->fetch();
    return $table->fetchAll($table->select()->where('`order` = ?', $row['max_order']))->current();
  }
  public function getTopics()
  {
    $category_id = $this->category_id;
    $values = "";
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();


     $categoriesId = $db->query("SELECT `category_id` FROM `engine4_sesforum_categories` WHERE `subsubcat_id` IN(SELECT category_id FROM `engine4_sesforum_categories` WHERE `subcat_id` = ".$category_id.") OR `category_id` IN(SELECT category_id FROM `engine4_sesforum_categories` WHERE `subsubcat_id` = ".$category_id.") OR `subcat_id` = ".$category_id." OR `category_id` = ".$category_id)->fetchAll();
    foreach($categoriesId as $categoryId){
        $values .= $categoryId['category_id'].',';
    }
    $values .= 0;
    $topicTable = Engine_Api::_()->getItemTable('sesforum_topic');
    $topicTableName = $topicTable->info('name');
    $forumTable = Engine_Api::_()->getItemTable('sesforum_forum')->info('name');
    $select = $topicTable->select()->from($topicTableName, new Zend_Db_Expr('COUNT('.$topicTableName.'.topic_id) as topics_count'))
      ->setIntegrityCheck(false)->joinLeft($forumTable, "$forumTable.forum_id = $topicTableName.forum_id")
      ->where($forumTable.".category_id  IN(".$values.")");

    $topic = $topicTable->fetchRow($select);
    if(count($topic) > 0)
        return $topic->topics_count;
    else
        return '0';
  }

  public function getPosts()
  {
     $category_id = $this->category_id;
    $values = "";
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();


     $categoriesId = $db->query("SELECT `category_id` FROM `engine4_sesforum_categories` WHERE `subsubcat_id` IN(SELECT category_id FROM `engine4_sesforum_categories` WHERE `subcat_id` = ".$category_id.") OR `category_id` IN(SELECT category_id FROM `engine4_sesforum_categories` WHERE `subsubcat_id` = ".$category_id.") OR `subcat_id` = ".$category_id." OR `category_id` = ".$category_id)->fetchAll();
    foreach($categoriesId as $categoryId){
        $values .= $categoryId['category_id'].',';
    }
    $values .= 0;

    $postTable = Engine_Api::_()->getItemTable('sesforum_post');
    $postTableName = $postTable->info('name');
    $forumTable = Engine_Api::_()->getItemTable('sesforum_forum')->info('name');
    $select = $postTable->select()->from($postTableName, new Zend_Db_Expr('COUNT('.$postTableName.'.post_id) as posts_count'))
      ->setIntegrityCheck(false)->joinLeft($forumTable, "$forumTable.forum_id = $postTableName.forum_id")
      ->where($forumTable.".category_id IN(".$values.")");

    $posts = $postTable->fetchRow($select);
    if(count($posts) > 0)
        return $posts->posts_count;
    else
        return '0';
  }

  public function moveUp()
  {
    $table = $this->getTable();
    $db = $table->getAdapter();
    $db->beginTransaction();
    try
    {

      if(!$this->subsubcat_id && !$this->subcat_id)
        $categories = $table->select()->where('subsubcat_id = 0')->where('subcat_id = 0')->order('order ASC')->query()->fetchAll();
      else if($this->subcat_id)
        $categories = $table->select()->where('subcat_id > 0')->order('order ASC')->query()->fetchAll();
      else
        $categories = $table->select()->where('subsubcat_id > 0')->order('order ASC')->query()->fetchAll();
      $new_cats   = array();
      foreach ($categories as $category) {
        if ($this->category_id == $category['category_id']) {
          $prev_cat = array_pop($new_cats);
          array_push($new_cats, $category['category_id']);
          if ($prev_cat) {
            array_push($new_cats, $prev_cat);
            unset($prev_cat);
          }
        } else {
          array_push($new_cats, $category['category_id']);
        }
      }
      foreach ($table->fetchAll($table->select()) as $row) {
        $order = array_search($row->category_id, $new_cats);
        $row->order = $order+1;
        $row->save();
      }
      $db->commit();
    }
    catch (Exception $e)
    {
      $db->rollBack();
      throw $e;
    }
  }

  public function lastPost()
  {
    $values = array();
     $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $categoryTableName = $this->getTable()->info('name');
    try
    {
    $category_id = $this->category_id;

    $postTable = Engine_Api::_()->getItemTable('sesforum_post');
    $postTableName = $postTable->info('name');
    $categoriesId = $db->query("SELECT `category_id` FROM `engine4_sesforum_categories` WHERE `subsubcat_id` IN(SELECT category_id FROM `engine4_sesforum_categories` WHERE `subcat_id` = ".$category_id.") OR `category_id` IN(SELECT category_id FROM `engine4_sesforum_categories` WHERE `subsubcat_id` = ".$category_id.") OR `subcat_id` = ".$category_id." OR `category_id` = ".$category_id)->fetchAll();
    foreach($categoriesId as $categoryId){
        $values[] = $categoryId['category_id'];
    }

    $forumTable = Engine_Api::_()->getItemTable('sesforum_forum')->info('name');
    $select = $postTable->select()
                    ->from($postTableName, '*')
                    ->setIntegrityCheck(false)
                    ->joinLeft($forumTable, "$forumTable.forum_id = $postTableName.forum_id",null)
                    ->joinLeft($categoryTableName, "$categoryTableName.category_id = $forumTable.category_id",null);
    if(count($values) > 0) {
        $select->where($forumTable.".category_id IN (?)", $values);
    }
    $select->where($postTableName.'.modified_date < ?', date('Y-m-d H:i:s'))
      ->order($postTableName.'.modified_date DESC')
      ->limit(1);

    $posts = $postTable->fetchRow($select);

    return $posts;
    }
    catch (Exception $e)
    {
      $db->rollBack();
      throw $e;
    }
  }

   public function getForum()
  {
    try
    {
     $category_id = $this->category_id;
    $sesforumTable = Engine_Api::_()->getItemTable('sesforum_forum');
    $sesforumSelect = $sesforumTable->select()
    ->where("category_id = ?", $category_id)
      ->order('order ASC')
      ;
        $sesforums = array();
        foreach($sesforumTable->fetchAll() as $sesforum ) {
            if(Engine_Api::_()->authorization()->isAllowed($sesforum, null, 'view') ) {
                $sesforums[] = $sesforum;
            }
        }
    return $sesforums;
    }
    catch (Exception $e)
    {
      $db->rollBack();
      throw $e;
    }
  }
}
