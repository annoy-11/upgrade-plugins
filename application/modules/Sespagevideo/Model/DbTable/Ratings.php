<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Ratings.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagevideo_Model_DbTable_Ratings extends Engine_Db_Table {

  protected $_rowClass = "Sespagevideo_Model_Rating";
  protected $_name = "sespagevideo_ratings";

  // rating functions
  public function getRating($resource_id, $resource_type = 'pagevideo') {
    $rating_sum = $this->select()
            ->from($this->info('name'), new Zend_Db_Expr('SUM(rating)'))
            ->group('resource_id')
            ->where('resource_id = ?', $resource_id)
            ->where('resource_type =?', $resource_type)
            ->query()
            ->fetchColumn(0)
    ;
    $total = $this->ratingCount($resource_id, $resource_type);
    if ($total)
      $rating = $rating_sum / $this->ratingCount($resource_id, $resource_type);
    else
      $rating = 0;

    return $rating;
  }

  public function getCountUserRate($resource_type = 'pagevideo', $resource_id) {
    $rName = $this->info('name');
    $rating_sum = $this->select()
            ->from($rName, new Zend_Db_Expr('COUNT(rating_id)'))
            ->where('resource_id = ?', $resource_id)
            ->where('resource_type = ?', $resource_type)
            ->group('resource_id')
            ->group('resource_type')
            ->query()
            ->fetchColumn();
    if (!$rating_sum)
      return 0;
    return $rating_sum;
  }

  public function getRatings($resource_id, $resource_type = 'pagevideo') {
    $rName = $this->info('name');
    $select = $this->select()
            ->from($rName)
            ->where($rName . '.resource_id = ?', $resource_id)
            ->where('resource_type =?', $resource_type);
    $row = $this->fetchAll($select);
    return $row;
  }

  public function checkRated($resource_id, $user_id, $resource_type = 'pagevideo') {
    $rName = $this->info('name');
    $select = $this->select()
            ->setIntegrityCheck(false)
            ->where('resource_type = ?', $resource_type)
            ->where('user_id = ?', $user_id)
            ->where('resource_id =?', $resource_id)
            ->limit(1);
    $row = $this->fetchAll($select);

    if (count($row) > 0)
      return true;
    return false;
  }

  public function setRating($resource_id, $user_id, $rating, $resource_type = 'pagevideo') {

    $rName = $this->info('name');
    $select = $this->select()
            ->from($rName)
            ->where($rName . '.resource_id = ?', $resource_id)
            ->where('resource_type =?', $resource_type)
            ->where($rName . '.user_id = ?', $user_id);
    $row = $this->fetchAll($select);
    if (count($row) == 0) {
      // create rating
      Engine_Api::_()->getDbTable('ratings', 'sespagevideo')->insert(array(
          'video_id' => $resource_id,
          'resource_id' => $resource_id,
          'user_id' => $user_id,
          'rating' => $rating,
          'resource_type' => $resource_type
      ));
    } else {
      Engine_Api::_()->getDbTable('ratings', 'sespagevideo')->update(array(
          'rating' => $rating,
              ), array(
          'resource_id = ?' => $resource_id,
          'user_id = ?' => $user_id,
          'resource_type = ?' => $resource_type
      ));
    }
  }

  public function ratingCount($resource_id, $resource_type = 'pagevideo') {
    $rName = $this->info('name');
    $select = $this->select()
            ->from($rName)
            ->where('resource_type =?', $resource_type)
            ->where($rName . '.resource_id = ?', $resource_id);
    $row = $this->fetchAll($select);
    $total = count($row);
    return $total;
  }

  public function getSumRating($resource_id, $resource_type) {
    $rName = $this->info('name');
    $rating_sum = $this->select()
            ->from($rName, new Zend_Db_Expr('SUM(rating)'))
            ->where('resource_id = ?', $resource_id)
            ->where('resource_type = ?', $resource_type)
            ->group('resource_id')
            ->group('resource_type')
            ->query()
            ->fetchColumn();
    return $rating_sum;
  }

  public function getRatedItems($resource_id = 'pagevideo') {
    $user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $rName = $this->info('name');
    $videoTableName = Engine_Api::_()->getDbTable('videos', 'sespagevideo')->info('name');
    $rating = $this->select()
            ->from($rName, array('resource_id'))
            ->where($rName . '.user_id = ?', $user_id)
            ->order($rName . '.creation_date DESC')
            ->where($rName . '.resource_type = ?', $resource_id);
    $rating = $rating->setIntegrityCheck(false);
    $rating = $rating->joinLeft($videoTableName, "$rName.resource_id=$videoTableName.video_id", NULL);
    $rating = $rating->where($videoTableName . '.video_id != ?', '');
    return Zend_Paginator::factory($rating);
  }

}
