<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Reviews.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Model_DbTable_Sesarticlereviews extends Engine_Db_Table {

  protected $_rowClass = 'Sesarticle_Model_Review';
  protected $_name = "sesarticle_reviews";
  
  public function getArticleReviewSelect($params = array()) {

    $table = Engine_Api::_()->getItemTable('sesarticlereview');
    $articleReviewTableName = $table->info('name');
    $select = $table->select()->from($articleReviewTableName);

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
      $select->where('`' . $articleReviewTableName . '`.`title` LIKE ?', '%' . $params['search_text'] . '%');
    if (!empty($params['owner_id']))
      $select->where('`' . $articleReviewTableName . '`.`owner_id` = ?', $params['owner_id']);
    if (!empty($params['review_stars']))
      $select->where('`' . $articleReviewTableName . '`.`rating` = ?', $params['review_stars']);
    if (!empty($params['review_recommended']))
      $select->where('`' . $articleReviewTableName . '`.`recommended` = ?', $params['review_recommended']);
    if (isset($params['order']) && $params['order'] != '') {
      $select->order($articleReviewTableName . '.' . $params['order']);
    }
    if (isset($params['criteria'])) {
      if ($params['criteria'] == 1)
        $select->where($articleReviewTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($articleReviewTableName . '.verified =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($articleReviewTableName . '.featured = 1 OR ' . $articleReviewTableName . '.verified = 1');
      else if ($params['criteria'] == 4)
        $select->where($articleReviewTableName . '.featured = 0 AND ' . $articleReviewTableName . '.verified = 0');
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
          $select->order($articleReviewTableName . '.view_count DESC');
          break;
        case "most_rated":
          $select->order($articleReviewTableName . '.rating DESC');
          break;
        case "least_rated":
          $select->order($articleReviewTableName . '.rating ASC');
          break;
        case 'random':
          $select->order('Rand()');
          break;
        case "verified" :
          $select->where($articleReviewTableName . '.verified' . ' = 1')
                  ->order($articleReviewTableName . '.owner_id DESC');
          break;
        case "featured" :
          $select->where($articleReviewTableName . '.featured' . ' = 1')
                  ->order($articleReviewTableName . '.owner_id DESC');
          break;
        case "creation_date":
          $select->order($articleReviewTableName . '.creation_date DESC');
          break;
        case "modified_date":
          $select->order($articleReviewTableName . '.modified_date DESC');
          break;
      }
    }

    if (isset($params['widgetName']) && $params['widgetName'] == 'oftheday') {
      $select->where($articleReviewTableName . '.oftheday =?', 1)
              ->where($articleReviewTableName . '.starttime <= DATE(NOW())')
              ->where($articleReviewTableName . '.endtime >= DATE(NOW())')
              ->limit(1)
              ->order('RAND()');
    }
    
    if(isset($params['article_id']) && !empty($params['article_id']))
    $select->where($articleReviewTableName . '.article_id =?', $params['article_id']);
    
    if (isset($params['limit']) && !empty($params['limit']))
      $select->limit($params['limit']);
    if (!empty($params['limit_data']))
      $select->limit($params['limit_data']);
    $select->order($articleReviewTableName . '.creation_date DESC');

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
		->where('article_id = ?', $params['article_id'])
		->where('owner_id = ?', $viewerId);
		return $select = $select->query()->fetchColumn();
	}
  
	public function ratingCount($resource_id = NULL){
		$rName = $this->info('name');
		return $this->select()
		->from($rName,new Zend_Db_Expr('COUNT(review_id) as total_rating'))
		->where($rName.'.article_id = ?', $resource_id)
		->limit(1)->query()->fetchColumn();
	}
	// rating functions
	public function getRating($resource_id) {
		$rating_sum = $this->select()
		->from($this->info('name'), new Zend_Db_Expr('SUM(rating)'))
		->group('article_id')
		->where('article_id = ?', $resource_id)
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
			->where('article_id = ?', $resource_id)
			->group('article_id')
			->query()
			->fetchColumn();
		return $rating_sum;
	}
  public function getReviewCount($resource_id) {
		return $this->select()
			->from($this->info('name'), 'review_id')
			->where('article_id = ?', $resource_id)
			->query()
			->fetchAll(Zend_Db::FETCH_COLUMN);
  }
  
	public function getUserReviewCount($params = array()) {
		$select =  $this->select()
		->where('article_id = ?', $params['article_id']);
		if($params['rating']) {
			$select = $select->where('rating =?', $params['rating']);
		}
		return  $this->fetchAll($select); 
	}

}
