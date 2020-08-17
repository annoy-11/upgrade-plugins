<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Reviews.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Model_DbTable_Reviews extends Engine_Db_Table {

  protected $_rowClass = 'Estore_Model_Review';

  public function getProductReviewSelect($params = array()) {

    $table = Engine_Api::_()->getItemTable('sesproduct_review');
    $productReviewTableName = $table->info('name');
    $select = $table->select()->from($productReviewTableName);

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
      $select->where('`' . $productReviewTableName . '`.`title` LIKE ?', '%' . $params['search_text'] . '%');
    if (!empty($params['owner_id']))
      $select->where('`' . $productReviewTableName . '`.`owner_id` = ?', $params['owner_id']);
    if (!empty($params['review_stars']))
      $select->where('`' . $productReviewTableName . '`.`rating` = ?', $params['review_stars']);
    if (!empty($params['review_recommended']))
      $select->where('`' . $productReviewTableName . '`.`recommended` = ?', $params['review_recommended']);
    if (isset($params['order']) && $params['order'] != '') {
      $select->order($productReviewTableName . '.' . $params['order']);
    }
    if (isset($params['criteria'])) {
      if ($params['criteria'] == 1)
        $select->where($productReviewTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($productReviewTableName . '.verified =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($productReviewTableName . '.featured = 1 OR ' . $productReviewTableName . '.verified = 1');
      else if ($params['criteria'] == 4)
        $select->where($productReviewTableName . '.featured = 0 AND ' . $productReviewTableName . '.verified = 0');
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
          $select->order($productReviewTableName . '.view_count DESC');
          break;
        case "most_rated":
          $select->order($productReviewTableName . '.rating DESC');
          break;
        case "least_rated":
          $select->order($productReviewTableName . '.rating ASC');
          break;
        case 'random':
          $select->order('Rand()');
          break;
        case "verified" :
          $select->where($productReviewTableName . '.verified' . ' = 1')
                  ->order($productReviewTableName . '.owner_id DESC');
          break;
        case "featured" :
          $select->where($productReviewTableName . '.featured' . ' = 1')
                  ->order($productReviewTableName . '.owner_id DESC');
          break;
        case "creation_date":
          $select->order($productReviewTableName . '.creation_date DESC');
          break;
        case "modified_date":
          $select->order($productReviewTableName . '.modified_date DESC');
          break;
      }
    }

    if (isset($params['widgetName']) && $params['widgetName'] == 'oftheday') {
      $select->where($productReviewTableName . '.oftheday =?', 1)
              ->where($productReviewTableName . '.starttime <= DATE(NOW())')
              ->where($productReviewTableName . '.endtime >= DATE(NOW())')
              ->limit(1)
              ->order('RAND()');
    }

    if(isset($params['product_id']) && !empty($params['product_id']))
    $select->where($productReviewTableName . '.product_id =?', $params['product_id']);

    if (isset($params['limit']) && !empty($params['limit']))
      $select->limit($params['limit']);
    if (!empty($params['limit_data']))
      $select->limit($params['limit_data']);
    $select->order($productReviewTableName . '.creation_date DESC');

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
		->where('store_id = ?', $params['store_id'])
		->where('owner_id = ?', $viewerId);
		return $select = $select->query()->fetchColumn();
	}

	public function ratingCount($resource_id = NULL){
		$rName = $this->info('name');
		return $this->select()
		->from($rName,new Zend_Db_Expr('COUNT(review_id) as total_rating'))
		->where($rName.'.store_id = ?', $resource_id)
		->limit(1)->query()->fetchColumn();
	}
	// rating functions
	public function getRating($resource_id) {
		$rating_sum = $this->select()
		->from($this->info('name'), new Zend_Db_Expr('SUM(rating)'))
		->group('store_id')
		->where('store_id = ?', $resource_id)
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
			->where('store_id = ?', $resource_id)
			->group('store_id')
			->query()
			->fetchColumn();
		return $rating_sum;
	}
  public function getReviewCount($resource_id) {
		return $this->select()
			->from($this->info('name'), array("COUNT(review_id)"))
			->where('store_id = ?', $resource_id)
			->query()
			->fetchAll(Zend_Db::FETCH_COLUMN);
  }

	public function getStoreReviewCount($params = array()) {
		$select =  $this->select()
		->where('store_id = ?', $params['store_id']);
		if($params['rating']) {
			$select = $select->where('rating =?', $params['rating']);
		}
		return  $this->fetchAll($select);
	}
	public function getUserReviewCount($params = array()) {
		$select =  $this->select()
		->where('store_id = ?', $params['store_id']);
		if($params['rating']) {
			$select = $select->where('rating =?', $params['rating']);
		}
		return  $this->fetchAll($select);
	}

    public function getStoreReviewSelect($params = array()) {

    $table = Engine_Api::_()->getItemTable('estore_review');
    $storeTableName = $table->info('name');
    $select = $table->select()->from($storeTableName);

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
      $select->where('`' . $storeTableName . '`.`title` LIKE ?', '%' . $params['search_text'] . '%');
    if (!empty($params['store_id']))
      $select->where('`' . $storeTableName . '`.`store_id` = ?', $params['store_id']);
    if (!empty($params['review_stars']))
      $select->where('`' . $storeTableName . '`.`rating` = ?', $params['review_stars']);

    if (!empty($params['review_recommended']))
      $select->where('`' . $storeTableName . '`.`recommended` = ?', $params['review_recommended']);


    if (isset($params['order']) && $params['order'] != '') {
      $select->order($storeTableName . '.' . $params['order']);
    }

    if (isset($params['criteria'])) {
      if ($params['criteria'] == 1)
        $select->where($storeTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($storeTableName . '.verified =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($storeTableName . '.featured = 1 OR ' . $storeTableName . '.verified = 1');
      else if ($params['criteria'] == 4)
        $select->where($storeTableName . '.featured = 0 AND ' . $storeTableName . '.verified = 0');
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
          $select->order($storeTableName . '.view_count DESC');
          break;
        case "most_rated":
          $select->order($storeTableName . '.rating DESC');
          break;
        case "useful_count":
          $select->order($storeTableName . '.useful_count DESC');
          break;
        case "funny_count":
          $select->order($storeTableName . '.funny_count DESC');
          break;
        case "cool_count":
          $select->order($storeTableName . '.cool_count DESC');
          break;

        case "least_rated":
          $select->order($storeTableName . '.rating ASC');
          break;
        case 'random':
          $select->order('Rand()');
          break;
        case "verified" :
          $select->where($storeTableName . '.verified' . ' = 1')
                  ->order($storeTableName . '.store_id DESC');
          break;
        case "featured" :
          $select->where($storeTableName . '.featured' . ' = 1')
                  ->order($storeTableName . '.store_id DESC');
          break;
        case "creation_date":
          $select->order($storeTableName . '.creation_date DESC');
          break;
        case "modified_date":
          $select->order($storeTableName . '.modified_date DESC');
          break;
      }
    }

    if (isset($params['widgetName']) && $params['widgetName'] == 'oftheday') {
      $select->where($storeTableName . '.oftheday =?', 1)
              ->where($storeTableName . '.starttime <= DATE(NOW())')
              ->where($storeTableName . '.endtime >= DATE(NOW())')
              ->limit(1)
              ->order('RAND()');
    }

    if (isset($params['limit']) && !empty($params['limit']))
      $select->limit($params['limit']);
    if (!empty($params['limit_data']))
      $select->limit($params['limit_data']);
    $select->order($storeTableName . '.creation_date DESC');
    if (isset($params['paginator']))
      return Zend_Paginator::factory($select);

    if (isset($params['fetchAll']))
      return $table->fetchAll($select);
    else
      return $select;
  }

}
