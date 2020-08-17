<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Wishlists.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Model_DbTable_Wishlists extends Engine_Db_Table {
  protected $_rowClass = 'Sesproduct_Model_Wishlist';
  public function getOfTheDayResults() {
    $select = $this->select()
            ->from($this->info('name'), array('*'))
            ->where('offtheday =?', 1)
            ->where('starttime <= DATE(NOW())')
            ->where('endtime >= DATE(NOW())')
            ->order('RAND()');
    return Zend_Paginator::factory($select);
  }
  public function getWishlistPaginator($params = array()) {
    $paginator = Zend_Paginator::factory($this->getWishlistSelect($params));
    if (!empty($params['page']))
      $paginator->setCurrentPageNumber($params['page']);
    if (!empty($params['limit']))
      $paginator->setItemCountPerPage($params['limit']);
    return $paginator;
  }
  public function getWishlistSelect($params = array(),$paginator = true) {
    $playlistTableName = $this->info('name');
    $playlistVideosTableName = Engine_Api::_()->getDbTable('playlistproducts', 'sesproduct')->info('name');

    $productTable = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct');
    $productTableName = $productTable->info('name');

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $this->select()
            ->from($playlistTableName)
            ->joinLeft($playlistVideosTableName, "$playlistTableName.wishlist_id = $playlistVideosTableName.wishlist_id", '');

    $select->joinLeft($productTableName, $productTableName . '.product_id = ' . $playlistTableName . '.product_id','');
		if(isset($params['brand']) && !empty($params['brand'])){
			$select->where($productTableName.".brand LIKE ? ", '%' . $params['brand'] . '%');
		}
		if(isset($params['category_id']) && !empty($params['category_id'])){
			$select->where($productTableName.".category_id = ? ", $params['category_id']);
		}

    if (isset($params['action']) && ($params['action'] != 'manage' || $params['action'] != 'browse')) {
      $select->where("$playlistVideosTableName.playlistproduct_id IS NOT NULL");
    }

    if ($viewer_id) {
     $select->where("($playlistTableName.is_private = '0' ||  ($playlistTableName.is_private = 1 && $playlistTableName.owner_id = $viewer_id))");
    } else
      $select->where("$playlistTableName.is_private = '0' ");
    if (!empty($params['user']))
      $select->where("owner_id =?", $params['user']);
    if (!empty($params['is_featured']))
      $select = $select->where($playlistTableName . '.is_featured =?', 1);
    if (!empty($params['is_sponsored']))
      $select = $select->where($playlistTableName . '.is_sponsored =?', 1);
    //USER SEARCH
    //if (!empty($params['show']) && $params['show'] == 2 && !empty($params['users'])) {
      //$select->where($playlistTableName . '.owner_id IN(?)', $params['users']);
    //}
	if (isset($params['show']) && $params['show'] == 2 && $viewer_id) {
      $users = Engine_Api::_()->user()->getViewer()->membership()->getMembershipsOfIds();
      if ($users)
      $select->where($playlistTableName . '.owner_id IN (?)', $users);
      else
      $select->where($playlistTableName . '.owner_id IN (?)', 0);
    }
    if (!empty($params['alphabet']) && $params['alphabet'] != 'all')
      $select->where($playlistTableName . ".title LIKE ?", $params['alphabet'] . '%');

    if (isset($params['popularity']) && $params['popularity'] == 'is_featured') {
      $select->where($playlistTableName . ".is_featured = ?", 1);
    }
    if (isset($params['popularity']) && $params['popularity'] == 'is_sponsored') {
      $select->where($playlistTableName . ".is_sponsored = ?", 1);
    }
		 if (!empty($params['popularCol']))
      $select = $select->order($params['popularCol'] . ' DESC');
    //String Search
    if (!empty($params['title']) && !empty($params['title'])) {
      $select->where("$playlistTableName.title LIKE ?", "%{$params['title']}%")
              ->orWhere("$playlistTableName.description LIKE ?", "%{$params['title']}%");
    }
    if (isset($params['widgteName']) && $params['widgteName'] == "Recommanded Wishlist") {
      $select->where($playlistTableName . ".owner_id <> ?", $viewer_id);
    }
    if (isset($params['widgteName']) && $params['widgteName'] == "Other Wishlist") {
      $select->where($playlistTableName . ".wishlist_id <> ?", $params['wishlist_id'])
              ->where($playlistTableName . ".owner_id = ?", $params['owner_id']);
    }
    $select->group("$playlistTableName.wishlist_id");
    if (isset($params['popularity'])) {
      switch ($params['popularity']) {
        case "featured" :
          $select->where($playlistTableName . '.is_featured = 1')
                  ->order($playlistTableName . '.wishlist_id DESC');
          break;
        case "sponsored" :
          $select->where($playlistTableName . '.is_sponsored = 1')
                  ->order($playlistTableName . '.wishlist_id DESC');
        break;
        case "view_count":
          $select->where($playlistTableName . '.view_count > 0')
                ->order($playlistTableName . '.view_count DESC');
          break;
        case "like_count":
          $select->where($playlistTableName . '.like_count  > 0')
            ->order($playlistTableName . '.like_count DESC');
          break;
        case "favourite_count":
          $select->where($playlistTableName . '.favourite_count  > 0')
            ->order($playlistTableName . '.favourite_count DESC');
          break;
        case "product_count":
          $select->where($playlistTableName . '.product_count > 0')
            ->order($playlistTableName . '.product_count DESC');
          break;
        case "creation_date":
          $select->where($playlistTableName . '.creation_date > 0')
            ->order($playlistTableName . '.creation_date DESC');
          break;
        case "modified_date":
          $select->where($playlistTableName . '.modified_date > 0')
            ->order($playlistTableName . '.modified_date DESC');
          break;
        case "verified":
          $select->where($productTableName . '.verified = 1')
            ->order($productTableName . '.verified DESC');
          break;
      }
    }
		if (isset($params['limit_data']))
      $select = $select->limit($params['limit_data']);

    	if (isset($params['limit']))
      $select = $select->limit($params['limit']);

    if (!$paginator)
      return $this->fetchAll($select);
    return $select;
  }
  public function getWishlistsCount($params = array()) {
    return $this->select()
                    ->from($this->info('name'), $params['column_name'])
                    ->where('owner_id = ?', $params['viewer_id'])
                    ->query()
                    ->fetchAll();
  }
 public function getWishlistsProduct($params = array()) {
    return $this->select()
                    ->from($this->info('name'))
                    ->where('product_id = ?', $params['product_id'])
                    ->query()
                    ->fetchAll();
  }
}
