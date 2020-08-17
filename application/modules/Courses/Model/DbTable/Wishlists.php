<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Wishlists.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Model_DbTable_Wishlists extends Engine_Db_Table {
  protected $_rowClass = 'Courses_Model_Wishlist';
  public function getWishlistPaginator($params = array()) {
    $paginator = Zend_Paginator::factory($this->getWishlistSelect($params));
    if (!empty($params['page']))
      $paginator->setCurrentPageNumber($params['page']);
    if (!empty($params['limit']))
      $paginator->setItemCountPerPage($params['limit']);
    return $paginator;
  }
  public function getWishlistSelect($params = array(),$paginator = true) {
    $wishlistTableName = $this->info('name');
    $playlistTableName = Engine_Api::_()->getDbTable('playlistcourses', 'courses')->info('name');
    $courseTable = Engine_Api::_()->getDbtable('courses', 'courses');
    $courseTableName = $courseTable->info('name');
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $this->select()->setIntegrityCheck(false)
            ->from($wishlistTableName)
            ->joinLeft($playlistTableName, "$wishlistTableName.wishlist_id = $playlistTableName.wishlist_id", '');
    $select->joinLeft($courseTableName, $courseTableName . '.course_id = ' . $wishlistTableName . '.course_id','');

    if(isset($params['category_id']) && !empty($params['category_id'])){
        $select->where($courseTableName.".category_id = ? ", $params['category_id']);
    }
    if (isset($params['action']) && ($params['action'] != 'manage' || $params['action'] != 'browse')) {
      $select->where("$playlistTableName.playlistcourse_id IS NOT NULL");
    }
    if ($viewer_id) {
     $select->where("($wishlistTableName.is_private = '0' ||  ($wishlistTableName.is_private = 1 && $wishlistTableName.owner_id = $viewer_id))");
    } else
      $select->where("$wishlistTableName.is_private = '0' ");
    if (!empty($params['user']))
      $select->where("owner_id =?", $params['user']);
    if (!empty($params['is_featured']))
      $select = $select->where($wishlistTableName . '.is_featured =?', 1);
    if (!empty($params['is_sponsored']))
      $select = $select->where($wishlistTableName . '.is_sponsored =?', 1);
    //USER SEARCH
    //if (!empty($params['show']) && $params['show'] == 2 && !empty($params['users'])) {
      //$select->where($wishlistTableName . '.owner_id IN(?)', $params['users']);
    //}
	if (isset($params['show']) && $params['show'] == 2 && $viewer_id) {
      $users = Engine_Api::_()->user()->getViewer()->membership()->getMembershipsOfIds();
      if ($users)
      $select->where($wishlistTableName . '.owner_id IN (?)', $users);
      else
      $select->where($wishlistTableName . '.owner_id IN (?)', 0);
    }
    if (!empty($params['alphabet']) && $params['alphabet'] != 'all')
      $select->where($wishlistTableName . ".title LIKE ?", '%'.$params['alphabet'] . '%');

    if (isset($params['popularity']) && $params['popularity'] == 'is_featured') {
      $select->where($wishlistTableName . ".is_featured = ?", 1);
    }
    if (isset($params['popularity']) && $params['popularity'] == 'is_sponsored') {
      $select->where($wishlistTableName . ".is_sponsored = ?", 1);
    }
		 if (!empty($params['popularCol']))
      $select = $select->order($params['popularCol'] . ' DESC');
    //String Search
    if (!empty($params['title']) && !empty($params['title'])) {
      $select->where("$wishlistTableName.title LIKE ?", "%{$params['title']}%")
              ->orWhere("$wishlistTableName.description LIKE ?", "%{$params['title']}%");
    }
    if (isset($params['widgteName']) && $params['widgteName'] == "Recommanded Wishlist") {
      $select->where($wishlistTableName . ".owner_id <> ?", $viewer_id);
    }
    if (isset($params['widgteName']) && $params['widgteName'] == "Other Wishlist") {
      $select->where($wishlistTableName . ".wishlist_id <> ?", $params['wishlist_id'])
              ->where($wishlistTableName . ".owner_id = ?", $params['owner_id']);
    }

    $select->group("$wishlistTableName.wishlist_id");
    if (isset($params['popularity'])) { 
      switch ($params['popularity']) { 
        case "featured" :
          $select->where($wishlistTableName . '.is_featured = 1')
                  ->order($wishlistTableName . '.wishlist_id DESC');
          break;
        case "sponsored" :
          $select->where($wishlistTableName . '.is_sponsored = 1')
                  ->order($wishlistTableName . '.wishlist_id DESC');
        break;
        case "view_count":
          $select->where($wishlistTableName . '.view_count > 0')
                ->order($wishlistTableName . '.view_count DESC');
          break;
        case "like_count":
          $select->where($wishlistTableName . '.like_count  > 0')
            ->order($wishlistTableName . '.like_count DESC');
          break;
        case "favourite_count":
          $select->where($wishlistTableName . '.favourite_count  > 0')
            ->order($wishlistTableName . '.favourite_count DESC');
          break;
        case "course_count": 
          $select->where($wishlistTableName . '.courses_count > 0')
            ->order($wishlistTableName . '.courses_count DESC'); 
          break;
        case "creation_date": 
          $select->where($wishlistTableName . '.creation_date > 0')
            ->order($wishlistTableName . '.creation_date DESC');
          break;
        case "modified_date": 
          $select->where($wishlistTableName . '.modified_date > 0')
            ->order($wishlistTableName . '.modified_date DESC');
          break;
        case "verified":
          $select->where($courseTableName . '.verified = 1')
            ->order($courseTableName . '.verified DESC');
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
 public function getWishlistsCourse($params = array()) {
    return $this->select()
            ->from($this->info('name'))
            ->where('course_id = ?', $params['course_id'])
            ->query()
            ->fetchAll();
  }
  public function getOfTheDayResults($categoryId = null,$customFields = array('*')) {
    $select = $this->select()
            ->from($this->info('name'), $customFields)
            ->where('offtheday =?', 1)
            ->where('startdate <= DATE(NOW())')
            ->where('enddate >= DATE(NOW())');
    if ($categoryId) {
        $select->where('category_id =?', $categoryId);
    }
    $select->order('RAND()');
    return $this->fetchRow($select);
  }
}
