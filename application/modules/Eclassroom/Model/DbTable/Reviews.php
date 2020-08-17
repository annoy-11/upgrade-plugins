<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Reviews.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Model_DbTable_Reviews extends Engine_Db_Table {

  protected $_rowClass = 'Eclassroom_Model_Review';

  public function getClassroomReviewSelect($params = array()) {
    $table = Engine_Api::_()->getItemTable('eclassroom_review');
    $classroomTableName = $table->info('name');
    $select = $table->select()->from($classroomTableName);
    $currentTime = date('Y-m-d H:i:s');
    if (isset($params['view'])) {
      if ($params['view'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['view'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(creation_date) between ('$endTime') and ('$currentTime')");
      }
    }
    //Full Text
    if (isset($params['order']) && !empty($params['order'])) {
      if ($params['order'] == 'featured')
        $select->where('featured = ?', '1');
      elseif ($params['order'] == 'verified')
        $select->where('verified = ?', '1');
      if ($params['order'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['order'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(creation_date) between ('$endTime') and ('$currentTime')");
      }
    }
    if (!empty($params['search_text']))
      $select->where('`' . $classroomTableName . '`.`title` LIKE ?', '%' . $params['search_text'] . '%');
    if (!empty($params['owner_id']))
      $select->where('`' . $classroomTableName . '`.`owner_id` = ?', $params['owner_id']);
    if (!empty($params['review_stars']))
      $select->where('`' . $classroomTableName . '`.`rating` = ?', $params['review_stars']);
    if (!empty($params['review_recommended']))
      $select->where('`' . $classroomTableName . '`.`recommended` = ?', $params['review_recommended']);
    if (isset($params['order']) && $params['order'] != '') {
      $select->order($classroomTableName . '.' . $params['order']);
    }
    if (isset($params['criteria'])) {
      if ($params['criteria'] == 1)
        $select->where($classroomTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($classroomTableName . '.verified =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($classroomTableName . '.featured = 1 OR ' . $classroomTableName . '.verified = 1');
      else if ($params['criteria'] == 4)
        $select->where($classroomTableName . '.featured = 0 AND ' . $classroomTableName . '.verified = 0');
    }
    if (isset($params['info'])) {
      switch ($params['info']) {
        case 'most_viewed':
          $select->order('view_count DESC');
          break;
        case 'most_liked':
          $select->order('like_count DESC');
          break;
        case 'like_count':
          $select->order('like_count DESC');
          break;
        case 'most_commented':
          $select->order('comment_count DESC');
          break;
        case 'comment_count':
          $select->order('comment_count DESC');
          break;
        case "view_count":
          $select->order($classroomTableName . '.view_count DESC');
          break;
        case "most_rated":
          $select->order($classroomTableName . '.rating DESC');
          break;
        case "least_rated":
          $select->order($classroomTableName . '.rating ASC');
          break;
        case 'random':
          $select->order('Rand()');
          break;
        case "verified" :
          $select->where($classroomTableName . '.verified' . ' = 1')
                  ->order($classroomTableName . '.owner_id DESC');
          break;
        case "featured" :
          $select->where($classroomTableName . '.featured' . ' = 1')
                  ->order($classroomTableName . '.owner_id DESC');
          break;
        case "creation_date":
          $select->order($classroomTableName . '.creation_date DESC');
          break;
        case "modified_date":
          $select->order($classroomTableName . '.modified_date DESC');
          break;
      }
    }
    if (isset($params['widgetName']) && $params['widgetName'] == 'oftheday') {
      $select->where($classroomTableName . '.oftheday =?', 1)
              ->where($classroomTableName . '.starttime <= DATE(NOW())')
              ->where($classroomTableName . '.endtime >= DATE(NOW())')
              ->limit(1)
              ->order('RAND()');
    }
    if(isset($params['classroom_id']) && !empty($params['classroom_id']))
      $select->where($classroomTableName . '.classroom_id =?', $params['classroom_id']);
    if (isset($params['limit']) && !empty($params['limit']))
      $select->limit($params['limit']);
    if (!empty($params['limit_data']))
      $select->limit($params['limit_data']);
      $select->order($classroomTableName . '.creation_date DESC');
    if (isset($params['paginator']))
      return Zend_Paginator::factory($select);
    if (isset($params['fetchAll']))
      return $table->fetchAll($select);
    else
      return $select;
  }

	public function isReview($params = array()) {
		$viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
		$select = $this->select()
		->from($this->info('name'), 'review_id')
		->where('classroom_id = ?', $params['classroom_id'])
		->where('owner_id = ?', $viewerId);
		return $select = $select->query()->fetchColumn();
	}

	public function ratingCount($resource_id = NULL){
		$rName = $this->info('name');
		return $this->select()
		->from($rName,new Zend_Db_Expr('COUNT(review_id) as total_rating'))
		->where($rName.'.classroom_id = ?', $resource_id)
		->limit(1)->query()->fetchColumn();
	}
	// rating functions
	public function getRating($resource_id) {
		$rating_sum = $this->select()
		->from($this->info('name'), new Zend_Db_Expr('SUM(rating)'))
		->group('classroom_id')
		->where('classroom_id = ?', $resource_id)
		->query()
		->fetchColumn(0);
		$total = $this->ratingCount($resource_id);
		if ($total)
		$rating = $rating_sum / $total;
		else
		$rating = 0;
		return $rating;
	}
	public function getSumRating($resource_id) {
		$rName = $this->info('name');
		$rating_sum = $this->select()
			->from($rName, new Zend_Db_Expr('SUM(rating)'))
			->where('classroom_id = ?', $resource_id)
			->group('classroom_id')
			->query()
			->fetchColumn();
		return $rating_sum;
	}
  public function getReviewCount($resource_id) {
		return $this->select()
			->from($this->info('name'), array("COUNT(review_id)"))
			->where('classroom_id = ?', $resource_id)
			->query()
			->fetchAll(Zend_Db::FETCH_COLUMN);
  }

	public function getClassroomReviewCount($params = array()) {
		$select =  $this->select()
		->where('classroom_id = ?', $params['classroom_id']);
		if($params['rating']) {
			$select = $select->where('rating =?', $params['rating']);
		}
		return  $this->fetchAll($select);
	}
	public function getUserReviewCount($params = array()) {
		$select =  $this->select()
		->where('classroom_id = ?', $params['classroom_id']);
		if($params['rating']) {
			$select = $select->where('rating =?', $params['rating']);
		}
		return  $this->fetchAll($select);
	}
}
