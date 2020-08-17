<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Pagereviews.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagereview_Model_DbTable_Pagereviews extends Engine_Db_Table {

  protected $_rowClass = 'Sespagereview_Model_Pagereview';
  protected $_name = "sespagereview_reviews";

  public function getPageReviewSelect($params = array()) {

    $table = Engine_Api::_()->getItemTable('pagereview');
    $pagereviewTableName = $table->info('name');
    $select = $table->select()->from($pagereviewTableName);

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
      $select->where('`' . $pagereviewTableName . '`.`title` LIKE ?', '%' . $params['search_text'] . '%');
    if (!empty($params['page_id']))
      $select->where('`' . $pagereviewTableName . '`.`page_id` = ?', $params['page_id']);
    if (!empty($params['review_stars']))
      $select->where('`' . $pagereviewTableName . '`.`rating` = ?', $params['review_stars']);

    if (!empty($params['review_recommended']))
      $select->where('`' . $pagereviewTableName . '`.`recommended` = ?', $params['review_recommended']);

    if (isset($params['order']) && $params['order'] != '') {
      $select->order($pagereviewTableName . '.' . $params['order']);
    }
    if (isset($params['criteria'])) {
      if ($params['criteria'] == 1)
        $select->where($pagereviewTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($pagereviewTableName . '.verified =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($pagereviewTableName . '.featured = 1 OR ' . $pagereviewTableName . '.verified = 1');
      else if ($params['criteria'] == 4)
        $select->where($pagereviewTableName . '.featured = 0 AND ' . $pagereviewTableName . '.verified = 0');
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
          $select->order($pagereviewTableName . '.view_count DESC');
          break;
        case "most_rated":
          $select->order($pagereviewTableName . '.rating DESC');
          break;
        case "useful_count":
          $select->order($pagereviewTableName . '.useful_count DESC');
          break;
        case "funny_count":
          $select->order($pagereviewTableName . '.funny_count DESC');
          break;
        case "cool_count":
          $select->order($pagereviewTableName . '.cool_count DESC');
          break;

        case "least_rated":
          $select->order($pagereviewTableName . '.rating ASC');
          break;
        case 'random':
          $select->order('Rand()');
          break;
        case "verified" :
          $select->where($pagereviewTableName . '.verified' . ' = 1')
                  ->order($pagereviewTableName . '.page_id DESC');
          break;
        case "featured" :
          $select->where($pagereviewTableName . '.featured' . ' = 1')
                  ->order($pagereviewTableName . '.page_id DESC');
          break;
        case "creation_date":
          $select->order($pagereviewTableName . '.creation_date DESC');
          break;
        case "modified_date":
          $select->order($pagereviewTableName . '.modified_date DESC');
          break;
      }
    }
    if (isset($params['widgetName']) && $params['widgetName'] == 'oftheday') {
      $select->where($pagereviewTableName . '.oftheday =?', 1)
              ->where($pagereviewTableName . '.starttime <= DATE(NOW())')
              ->where($pagereviewTableName . '.endtime >= DATE(NOW())')
              ->limit(1)
              ->order('RAND()');
    }
    if (isset($params['limit']) && !empty($params['limit']))
      $select->limit($params['limit']);
    if (!empty($params['limit_data']))
      $select->limit($params['limit_data']);
    $select->order($pagereviewTableName . '.creation_date DESC');

    if (isset($params['paginator']))
      return Zend_Paginator::factory($select);

    if (isset($params['fetchAll']))
      return $table->fetchAll($select);
    else
      return $select;
  }
  public function isReview($params = array()) {
    $select = $this->select()->from($this->info('name'), $params['column_name']);
    if (isset($params['page_id']))
      $select->where('page_id = ?', $params['page_id']);
    $select->where('owner_id =?', Engine_Api::_()->user()->getViewer()->getIdentity());
    return $select = $select->query()->fetchColumn();
  }
  public function ratingCount($resource_id = NULL) {
    $rName = $this->info('name');
    return $this->select()
                    ->from($rName, new Zend_Db_Expr('COUNT(review_id) as total_rating'))
                    ->where($rName . '.page_id = ?', $resource_id)
                    ->limit(1)->query()->fetchColumn();
  }
  // rating functions
  public function getRating($resource_id) {
    $rating_sum = $this->select()
            ->from($this->info('name'), new Zend_Db_Expr('SUM(rating)'))
            ->group('page_id')
            ->where('page_id = ?', $resource_id)
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
            ->from($this->info('name'), array('count' => 'COUNT(*)', 'rating', 'sum' => new Zend_Db_Expr('(SELECT COUNT(*) FROM ' . $this->info('name') . ' where page_id =' . $param['page_id'] . ')')))
            ->where('page_id =?', $param['page_id'])
            ->order('rating DESC')
            ->group('rating');
    return $this->fetchAll($select);
  }

}
