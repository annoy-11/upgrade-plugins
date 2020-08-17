<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Api_Core extends Core_Api_Abstract
{

  public function getMaxCategoryOrder()
  {
    $table = Engine_Api::_()->getItemTable('sesforum_category');
    $select = new Zend_Db_Select($table->getAdapter());
    $select = $select->from($table->info('name'), new Zend_Db_Expr('MAX(`order`) as max_order'));
    $data = $select->query()->fetch();
    $order = (int) @$data['max_order'];
    return $order;

  }

  public function getwidgetizePage($params = array()) {

    $corePages = Engine_Api::_()->getDbtable('pages', 'core');
    $corePagesName = $corePages->info('name');
    $select = $corePages->select()
            ->from($corePagesName, array('*'))
            ->where('name = ?', $params['name'])
            ->limit(1);
    return $corePages->fetchRow($select);
  }

  public function getRating($forum_id)
  {
    $table  = Engine_Api::_()->getDbTable('ratings', 'sesforum');
    $rating_sum = $table->select()
      ->from($table->info('name'), new Zend_Db_Expr('SUM(rating)'))
      ->group('forum_id')
      ->where('forum_id = ?', $forum_id)
      ->query()
      ->fetchColumn(0)
      ;

    $total = $this->ratingCount($forum_id);
    if ($total) $rating = $rating_sum/$this->ratingCount($forum_id);
    else $rating = 0;

    return $rating;
  }

  public function getRatings($forum_id)
  {
    $table  = Engine_Api::_()->getDbTable('ratings', 'sesforum');
    $rName = $table->info('name');
    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.forum_id = ?', $forum_id);
    $row = $table->fetchAll($select);
    return $row;
  }

  public function checkRated($forum_id, $user_id)
  {
    $table  = Engine_Api::_()->getDbTable('ratings', 'sesforum');

    $rName = $table->info('name');
    $select = $table->select()
                 ->setIntegrityCheck(false)
                    ->where('forum_id = ?', $forum_id)
                    ->where('user_id = ?', $user_id)
                    ->limit(1);
    $row = $table->fetchAll($select);

    if (count($row)>0) return true;
    return false;
  }

  public function setRating($forum_id, $user_id, $rating){
    $table  = Engine_Api::_()->getDbTable('ratings', 'sesforum');
    $rName = $table->info('name');
    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.forum_id = ?', $forum_id)
                    ->where($rName.'.user_id = ?', $user_id);
    $row = $table->fetchRow($select);
    if (empty($row)) {
      // create rating
      Engine_Api::_()->getDbTable('ratings', 'sesforum')->insert(array(
        'forum_id' => $forum_id,
        'user_id' => $user_id,
        'rating' => $rating
      ));
    }
  }

  public function ratingCount($forum_id){
    $table  = Engine_Api::_()->getDbTable('ratings', 'sesforum');
    $rName = $table->info('name');
    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.forum_id = ?', $forum_id);
    $row = $table->fetchAll($select);
    $total = count($row);
    return $total;
  }

 function tagCloudItemCore($fetchtype = '',$limit = null, $topic_id = '') {

    $tableTagmap = Engine_Api::_()->getDbtable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbtable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $selecttagged_photo = $tableTagmap->select()
            ->from($tableTagName)
            ->setIntegrityCheck(false)
            ->where('resource_type =?', 'sesforum_topic')
            ->where('tag_type =?', 'core_tag')
            ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
            ->group($tableTagName . '.tag_id');
    if($topic_id) {
      $selecttagged_photo->where($tableTagName.'.resource_id =?', $topic_id);
    }
    if(!empty($limit)) {
        $selecttagged_photo->limit($limit);
    }
    $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));
    if ($fetchtype == '')
      return Zend_Paginator::factory($selecttagged_photo);
    else
      return $tableTagmap->fetchAll($selecttagged_photo);
  }
   function isAllowed($type,$levelId , $name){
    $table  = Engine_Api::_()->getDbTable('permissions', 'authorization');
    $tableName = $table->info('name');
    $select = $table->select();
    $select->from($table->info('name'),'value');
    if($name) {
        $select->where($tableName . '.name = ?', $name);
    }
    if($type) {
      $select->where($tableName . '.type = ?',$type);
    }
    if($levelId) {
      $select->where($tableName . '.level_id = ?', $levelId);
    }

    return $table->fetchRow($select);
   }

}
