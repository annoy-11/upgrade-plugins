<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Businessreviews.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessreview_Model_DbTable_Businessreviews extends Engine_Db_Table {

  protected $_rowClass = 'Sesbusinessreview_Model_Businessreview';
  protected $_name = "sesbusinessreview_reviews";

  public function getBusinessReviewSelect($params = array()) {

    $table = Engine_Api::_()->getItemTable('businessreview');
    $businessreviewTableName = $table->info('name');
    $select = $table->select()->from($businessreviewTableName);

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
      $select->where('`' . $businessreviewTableName . '`.`title` LIKE ?', '%' . $params['search_text'] . '%');
    if (!empty($params['business_id']))
      $select->where('`' . $businessreviewTableName . '`.`business_id` = ?', $params['business_id']);
    if (!empty($params['review_stars']))
      $select->where('`' . $businessreviewTableName . '`.`rating` = ?', $params['review_stars']);

    if (!empty($params['review_recommended']))
      $select->where('`' . $businessreviewTableName . '`.`recommended` = ?', $params['review_recommended']);

    if (isset($params['order']) && $params['order'] != '') {
      $select->order($businessreviewTableName . '.' . $params['order']);
    }
    if (isset($params['criteria'])) {
      if ($params['criteria'] == 1)
        $select->where($businessreviewTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($businessreviewTableName . '.verified =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($businessreviewTableName . '.featured = 1 OR ' . $businessreviewTableName . '.verified = 1');
      else if ($params['criteria'] == 4)
        $select->where($businessreviewTableName . '.featured = 0 AND ' . $businessreviewTableName . '.verified = 0');
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
          $select->order($businessreviewTableName . '.view_count DESC');
          break;
        case "most_rated":
          $select->order($businessreviewTableName . '.rating DESC');
          break;
        case "useful_count":
          $select->order($businessreviewTableName . '.useful_count DESC');
          break;
        case "funny_count":
          $select->order($businessreviewTableName . '.funny_count DESC');
          break;
        case "cool_count":
          $select->order($businessreviewTableName . '.cool_count DESC');
          break;

        case "least_rated":
          $select->order($businessreviewTableName . '.rating ASC');
          break;
        case 'random':
          $select->order('Rand()');
          break;
        case "verified" :
          $select->where($businessreviewTableName . '.verified' . ' = 1')
                  ->order($businessreviewTableName . '.business_id DESC');
          break;
        case "featured" :
          $select->where($businessreviewTableName . '.featured' . ' = 1')
                  ->order($businessreviewTableName . '.business_id DESC');
          break;
        case "creation_date":
          $select->order($businessreviewTableName . '.creation_date DESC');
          break;
        case "modified_date":
          $select->order($businessreviewTableName . '.modified_date DESC');
          break;
      }
    }
    if (isset($params['widgetName']) && $params['widgetName'] == 'oftheday') {
      $select->where($businessreviewTableName . '.oftheday =?', 1)
              ->where($businessreviewTableName . '.starttime <= DATE(NOW())')
              ->where($businessreviewTableName . '.endtime >= DATE(NOW())')
              ->limit(1)
              ->order('RAND()');
    }
    if (isset($params['limit']) && !empty($params['limit']))
      $select->limit($params['limit']);
    if (!empty($params['limit_data']))
      $select->limit($params['limit_data']);
    $select->order($businessreviewTableName . '.creation_date DESC');

    if (isset($params['paginator']))
      return Zend_Paginator::factory($select);

    if (isset($params['fetchAll']))
      return $table->fetchAll($select);
    else
      return $select;
  }
  public function isReview($params = array()) {
    $select = $this->select()->from($this->info('name'), $params['column_name']);
    if (isset($params['business_id']))
      $select->where('business_id = ?', $params['business_id']);
    $select->where('owner_id =?', Engine_Api::_()->user()->getViewer()->getIdentity());
    return $select = $select->query()->fetchColumn();
  }
  public function ratingCount($resource_id = NULL) {
    $rName = $this->info('name');
    return $this->select()
                    ->from($rName, new Zend_Db_Expr('COUNT(review_id) as total_rating'))
                    ->where($rName . '.business_id = ?', $resource_id)
                    ->limit(1)->query()->fetchColumn();
  }
  // rating functions
  public function getRating($resource_id) {
    $rating_sum = $this->select()
            ->from($this->info('name'), new Zend_Db_Expr('SUM(rating)'))
            ->group('business_id')
            ->where('business_id = ?', $resource_id)
            ->query()
            ->fetchColumn(0);
    $total = $this->ratingCount($resource_id);
    if ($total)
      $rating = $rating_sum / $total;
    else
      $rating = 0;
    return $rating;
  }
  public function getStarData($param = array()) {
    $select = $this->select()
            ->from($this->info('name'), array('count' => 'COUNT(*)', 'rating', 'sum' => new Zend_Db_Expr('(SELECT COUNT(*) FROM ' . $this->info('name') . ' where business_id =' . $param['business_id'] . ')')))
            ->where('business_id =?', $param['business_id'])
            ->order('rating DESC')
            ->group('rating');
    return $this->fetchAll($select);
  }

}
