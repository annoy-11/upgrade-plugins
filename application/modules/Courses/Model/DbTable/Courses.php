<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Courses.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Courses extends Core_Model_Item_DbTable_Abstract {
  protected $_rowClass = "Courses_Model_Course";
  public function countCourses($userId = null) {
    $count = $this->select()->from($this->info('name'), array("COUNT(course_id)"));
    if ($userId)
      $count->where('owner_id =?', $userId);
    return $count->query()->fetchColumn();
  }
  public function packageCourseCount($packageId = null) {
    $count = $this->select()->from($this->info('name'), array("COUNT(course_id)"))->where('package_id =?', $packageId);
    return $count->query()->fetchColumn();
  }
  public function checkCustomUrl($value = '', $course_id = '') {
    $select = $this->select('course_id')->where('custom_url = ?', $value);
    if ($course_id)
      $select->where('course_id !=?', $course_id);
    return $select->query()->fetchColumn();
  }
  public function getCourseId($slug = null)
  {
    if ($slug)
    {
      $tableName = $this->info('name');
      $select = $this->select()
              ->from($tableName)
              ->where($tableName . '.custom_url = ?', $slug);
      $row = $this->fetchRow($select);
      if (empty($row))
      {
        $course_id = $slug;
      } else
        $course_id = $row->course_id;
      return $course_id;
    }
    return '';
  }
//
//   public function getActivityQuery($viewerid = 0) {
//     //favourites
//     $favouriteTable = Engine_Api::_()->getDbTable('favourites', 'courses');
//     $select = $favouriteTable->select()->where('resource_type =?', 'courses')->where('owner_id =?', $viewerid);
//     $fav = $favouriteTable->fetchAll($select);
//     $courses = array();
//     foreach ($fav as $fa)
//       $courses[$fa->resource_id] = $fa->resource_id;
//
//     //follows
//     $followerTable = Engine_Api::_()->getDbTable('followers', 'courses');
//     $select = $followerTable->select()->where('resource_type =?', 'courses')->where('owner_id =?', $viewerid);
//     $follow = $followerTable->fetchAll($select);
//     foreach ($follow as $fa)
//       $courses[$fa->resource_id] = $fa->resource_id;
//
//     //membership
//     $db = Engine_Db_Table::getDefaultAdapter();
//     $memberships = $db->query("SELECT resource_id FROM engine4_courses_membership WHERE user_id = " . $viewerid . ' AND resource_approved = 1 AND active = 1 AND user_approved = 1')->fetchAll();
//     foreach ($memberships as $fa)
//       $courses[$fa["resource_id"]] = $fa['resource_id'];
//     //like
//
//     $likes = $db->query("SELECT resource_id FROM engine4_core_likes WHERE poster_id = " . $viewerid . ' AND resource_type = "courses" AND poster_type = "user" AND poster_id = ' . $viewerid)->fetchAll();
//     foreach ($likes as $fa)
//       $courses[$fa["resource_id"]] = $fa['resource_id'];
//     //owner courses
//     $course = $db->query("SELECT course_id FROM engine4_courses_courses WHERE owner_id = " . $viewerid)->fetchAll();
//     foreach ($course as $fa)
//       $courses[$fa["course_id"]] = $fa['course_id'];
//     return $courses;
//   }
//
  public function getCoursePaginator($params = array())
  {
    return Zend_Paginator::factory($this->getCourseSelect($params));
  }
  public function getCourseSelect($params = array())
  { 
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $currentTime = date('Y-m-d H:i:s');
    $courseTableName = $this->info('name');
    $tableTagmap = Engine_Api::_()->getDbTable('tagMaps', 'core');
    $tableLocationName = Engine_Api::_()->getDbTable('locations', 'sesbasic')->info('name');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbTable('tags', 'core');
    $select = $this->select()->setIntegrityCheck(false);
    if (isset($params['left']))
      $select->from($courseTableName, array('*', new Zend_Db_Expr('"left" AS type')));
    else if (isset($params['right']))
      $select->from($courseTableName, array('*', new Zend_Db_Expr('"right" AS type')));
    else
      $select->from($courseTableName);
    $select->where($courseTableName.'.is_approved = ?',(bool) 1);
    if (empty($params['widgetManage'])) {
      $select->where($courseTableName . '.draft = ?', (bool) 1);
      $select->where($courseTableName . '.is_approved = ?', (bool) 1);
      $select->where($courseTableName . '.search = ?', (bool) 1);
    }
    $networkSqlExecute = false;
    if ($viewerId) {
      $network_table = Engine_Api::_()->getDbTable('membership', 'network');
      $network_select = $network_table->select('resource_id')->where('user_id = ?', $viewerId);
      $network_id_query = $network_table->fetchAll($network_select);
      $network_id_query_count = count($network_id_query);
      $networkSql = '(';
      for ($i = 0; $i < $network_id_query_count; $i++) {
        $networkSql = $networkSql . "networks LIKE  '%," . $network_id_query[$i]['resource_id'] . "%' || ";
      }
      $networkSql = trim($networkSql, '|| ') . ')';
      if ($networkSql != '()') {
        $networkSqlExecute = true;
        $networkSql = $networkSql . ' || networks IS NULL || networks = "" || ' . $courseTableName . '.owner_id =' . $viewerId;
        $select->where($networkSql);
      }
    }
    if (!$networkSqlExecute) {
      $networkUser = '';
      if ($viewerId)
        $networkUser = ' ||' . $courseTableName . '.owner_id =' . $viewerId . ' ';
        $select->where('networks IS NULL || networks = ""  ' . $networkUser);
    }
    //if(method_exists('Core_Model_Item_DbTable_Abstract','getItemsSelect') ) {
     // $select = $this->getItemsSelect($params, $select);/}
    if (isset($params['parent_id']))
      $select->where($courseTableName . '.parent_id =?', $params['parent_id']);
    if (isset($params['classroom_id']))
      $select->where($courseTableName . '.classroom_id = ?', $params['classroom_id']);

    if (!empty($params['tag'])) {
      $select->joinLeft($tableTagName, "$tableTagName.resource_id = $courseTableName.course_id")
              ->where($tableTagName . '.resource_type = ?', 'courses')
              ->where($tableTagName . '.tag_id = ?', $params['tag']);
    }
    if (isset($params['sameTag']) && !empty($params['sameTag'])) {
      $select->joinLeft($tableTagName, "$tableTagName.resource_id = $courseTableName.course_id", NULL)
              ->where($tableTagName . '.resource_type = ?', 'courses')
              ->distinct(true)
              ->where($tableTagName . '.resource_id != ?', $params['sameTagresource_id'])
              ->where($tableTagName . '.tag_id IN(?)', $params['sameTagTag_id']);
    }
    elseif (isset($params['sameCategory']) && !empty($params['sameCategory']))
    {
      $select = $select->where($courseTableName . '.category_id =?', $params['category_id'])
              ->where($courseTableName . '.course_id !=?', $params['course_id']);
    }
    elseif (isset($params['other-courses']))
    {
      $select->where($courseTableName . '.course_id !=?', $params['course_id']);
    }
   
    if(!empty($params['upsell'])){
        $select->where($courseTableName.'.course_id IN (SELECT resource_id FROM engine4_courses_upsells WHERE course_id = '.$params["course_id"].')');
    
    }
    if(!empty($params['crosssell'])){
        $select->where($courseTableName.'.course_id IN (SELECT resource_id FROM engine4_courses_crosssells WHERE course_id IN('.$params["courseIds"].') )');
    }
    if (isset($params['wishlist_id'])) {
          $wishlistTable = Engine_Api::_()->getDbtable('playlistcourses', 'courses');
           $wishlistTableName = $wishlistTable->info('name');
            $select->joinLeft($wishlistTableName, $wishlistTableName . '.file_id = ' . $courseTableName . '.course_id',null)
            ->where($wishlistTableName.'.wishlist_id = ?',$params['wishlist_id']);
    }
    if (isset($params['popularity']) && $params['popularity'] == "You May Also Like")
    {
      $courseIds = Engine_Api::_()->courses()->likeIds(array('type' => 'courses', 'id' => $viewerId));
      $select->where($courseTableName . '.course_id NOT IN(?)', $courseIds);
    }
    if(!isset($params['manage-widget'])) {
        $select->where($courseTableName.'.is_approved = ?',(bool) 1)->where($courseTableName.'.search = ?', (bool) 1)->where($courseTableName.'.enable_course = ?', 1);;
        $select->where("CASE WHEN ".$courseTableName.".show_start_time = '0' AND  ".$courseTableName.".starttime < NOW() THEN TRUE ELSE  CASE WHEN ".$courseTableName.".show_start_time = '1' THEN TRUE ELSE FALSE END END");
        $select->where("CASE WHEN ".$courseTableName.".show_end_time = '1' AND  ".$courseTableName.".endtime > NOW() THEN TRUE  ELSE CASE WHEN ".$courseTableName.".show_end_time = '0' THEN TRUE ELSE FALSE END END");
    }else
        $select->where($courseTableName.'.owner_id = ?',$viewerId);
    if (isset($params['sort']) && !empty($params['sort']))
    {
      if ($params['sort'] == 'open')
        $select = $select->where($courseTableName . '.status =?', 1);
      elseif ($params['sort'] == 'close')
        $select = $select->where($courseTableName . '.status =?', 0);
      elseif ($params['sort'] == 'featured')
        $select = $select->where($courseTableName . '.featured =?', 1);
      elseif ($params['sort'] == 'sponsored')
        $select = $select->where($courseTableName . '.sponsored =?', 1);
      elseif ($params['sort'] == 'verified')
        $select = $select->where($courseTableName . '.verified =?', 1);
      elseif ($params['sort'] == 'hot')
        $select = $select->where($courseTableName . '.hot =?', 1);
      else
        $select = $select->order($courseTableName . '.' . $params['sort'] . ' DESC');
    }
    if (isset($params['show']) && !empty($params['show']))
    {
      if ($params['show'] == 1 && $viewerId) {
        $users = $viewer->membership()->getMembershipsOfIds();
        if ($users)
          $select->where($courseTableName . '.owner_id IN (?)', $users);
        else
          $select->where($courseTableName . '.owner_id IN (?)', 0);
      }elseif ($params['show'] == 2) {
        $networkMembershipTable = Engine_Api::_()->getDbTable('membership', 'network');
        $membershipNetworkUserIds = $networkMembershipTable->getMembershipsOfIds($viewer);
        if(empty($membershipNetworkUserIds))
          $membershipNetworkUserIds = 0;
          $networkMembershipTableName = $networkMembershipTable->info('name');
          $select->join($networkMembershipTableName, $courseTableName . ".owner_id = " . $networkMembershipTableName . ".user_id  ", null)
                  ->where($networkMembershipTableName . ".resource_id  IN (?) ", $membershipNetworkUserIds);
      } elseif ($params['show'] == 3) {
        $select->where($courseTableName . '.owner_id=?', $viewerId);
      }
    } 
    if (!empty($params['user_id']) && empty($params['courseIds'])) {
      $select->where($courseTableName . '.owner_id =?', $params['user_id']);
    }
    if (isset($params['featured']) && !empty($params['featured']))
      $select = $select->where($courseTableName . '.featured =?', 1);
    if (isset($params['verified']) && !empty($params['verified']))
      $select = $select->where($courseTableName . '.verified =?', 1);
    if (isset($params['sponsored']) && !empty($params['sponsored']))
      $select = $select->where($courseTableName . '.sponsored =?', 1);
    if (!empty($params['category_id']))
      $select->where($courseTableName . '.category_id = ?', $params['category_id']);
    if (!empty($params['subcat_id']))
      $select = $select->where($courseTableName . '.subcat_id =?', $params['subcat_id']);
    if (!empty($params['subsubcat_id']))
      $select = $select->where($courseTableName . '.subsubcat_id =?', $params['subsubcat_id']);
//     if (isset($params['draft']))
//       $select->where($courseTableName . '.draft = ?', $params['draft']);
    if (!empty($params['text']))
      $select->where($courseTableName . ".title LIKE ? OR " . $courseTableName . ".description LIKE ?", '%' . $params['text'] . '%');
    if (!empty($params['alphabet']) && $params['alphabet'] !='all')
      $select->where($courseTableName . '.title LIKE ?', "%{$params['alphabet']}%");
    if (!empty($params['getcourse'])) {
      $select->where($courseTableName . ".title LIKE ? OR " . $courseTableName . ".description LIKE ?", '%' . $params['textSearch'] . '%')->where($courseTableName . ".search = ?", 1);
    }
    if (!empty($params['date_from']))
      $select->having($courseTableName . '.creation_date <=?', $params['date_from']);
    if (!empty($params['date_to']))
      $select->having($courseTableName . '.creation_date >=?', $params['date_to']);
        
    if( !empty($params['date']) )
        $select->where("DATE_FORMAT(" . $courseTableName.".creation_date, '%Y-%m-%d') = ?", date('Y-m-d', strtotime($params['date'])));
    if( !empty($params['start_date']) )
        $select->where($courseTableName.".creation_date = ?", date('Y-m-d', $params['start_date']));
    if (!empty($params['price_max']))
        $select->having($courseTableName.".price <=?", $params['price_max']);
    if (!empty($params['price_min']))
        $select->having($courseTableName.".price >=?", $params['price_min']);
    if( !empty($params['end_date']) )
        $select->where($courseTableName.".creation_date < ?", date('Y-m-d', $params['end_date']));
    if(!empty($params['lecture']) && $params['lecture'] != 0)
        $select->where($courseTableName.".lecture_count > ?", 0);
    if (isset($params['order']) && !empty($params['order'])) {
      if ($params['order'] == 'featured')
        $select->where('featured = ?', '1');
      elseif ($params['order'] == 'sponsored')
        $select->where('sponsored = ?', '1');
      elseif ($params['order'] == 'hot')
        $select->where('hot = ?', '1');
    }
    if (isset($params['criteria'])) {
      if ($params['criteria'] == 1)
        $select->where($courseTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($courseTableName . '.sponsored =?', '1');
      else if ($params['criteria'] == 6)
        $select->where($courseTableName . '.verified =?', '1');
      else if ($params['criteria'] == 7)
        $select->where($courseTableName . '.hot =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($courseTableName . '.featured = 1 AND ' . $courseTableName . '.sponsored = 1');
      else if ($params['criteria'] == 4)
        $select->where($courseTableName . '.featured = 0 AND ' . $courseTableName . '.sponsored = 0');
    }
    $currentTime = date('Y-m-d H:i:s');
    if(isset($params['popularCol']) && !empty($params['popularCol'])) {
			if($params['popularCol'] == 'week') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
				$select->where("DATE(".$courseTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			elseif($params['popularCol'] == 'month') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$courseTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			elseif($params['popularCol'] == 'price_high') {
        $select->order($courseTableName . '.price' .' DESC');
			} elseif($params['popularCol'] == 'price_low') {
        $select->order($courseTableName . '.price' .' ASC');
			}
			else {
				 $select->order($courseTableName . '.' .$params['popularCol'] . ' DESC');
			}
    } 
    if (isset($params['info'])) {
			switch ($params['info']) {
				case 'recently_created': 
					$select->order($courseTableName . '.creation_date DESC');
					break;
				case 'most_viewed':
					$select->order($courseTableName . '.view_count DESC');
					break;
				case 'most_liked':
					$select->order($courseTableName . '.like_count DESC');
					break;
				case 'most_favourite':
					$select->order($courseTableName . '.favourite_count DESC');
					break;
				case 'most_commented':
					$select->order($courseTableName . '.comment_count DESC');
					break;
        case 'most_rated':
					$select->order($courseTableName . '.rating DESC');
				case 'random':
					$select->order('Rand()');
					break;
			} 
		}
		
    //don't show other module blogs
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.other.modulecourses', 1) && empty($params['resource_type'])) {
      $select->where($courseTableName . '.resource_type IS NULL')
        ->where($courseTableName . '.resource_id =?', 0);
    } else if (!empty($params['resource_type']) && !empty($params['resource_id'])) {
      $select->where($courseTableName . '.resource_type =?', $params['resource_type'])
        ->where($courseTableName . '.resource_id =?', $params['resource_id']);
    } else if (!empty($params['resource_type'])) {
      $select->where($courseTableName . '.resource_type =?', $params['resource_type']);
    }
    
    if(isset($params['fixedData']) && !empty($params['fixedData']) && $params['fixedData'] != '')
         $select->where($courseTableName . '.' . $params['fixedData'] . ' =?', 1);
    if(!empty($params['notCourseId']) && count($params['notCourseId']) &&  !empty($params['info'])){
        $select->where($courseTableName.'.course_id NOT IN (?)',$params["notCourseId"]);
    }
    if(!empty($params['notCourseId']) && count($params['notCourseId']) &&  !empty($params['category_id'])){
        $select->where($courseTableName.'.course_id NOT IN (?)',$params["notCourseId"]);
    }
    //Start Custom Field Fieltering Work
    $tmp = array();
    $customFields = array();

    if (isset($_POST['is_search'])) {
      foreach ($params as $k => $v) {
        if (null == $v || '' == $v || (is_array($v) && count(array_filter($v)) == 0)) {
          continue;
        } else if (false !== strpos($k, '_field_')) {
          list($null, $field) = explode('_field_', $k);
          $tmp['field_' . $field] = $v;
        } else if (false !== strpos($k, '_alias_')) {
          list($null, $alias) = explode('_alias_', $k);
          $tmp[$alias] = $v;
        } else {
          $tmp[$k] = $v;
        }
      }
      $customFields = $tmp;
      if (!empty($customFields['extra'])) {
        extract($customFields['extra']); // is_online, has_photo, submit
      }
      $searchTable = Engine_Api::_()->fields()->getTable('courses', 'search');
      $searchTableName = $searchTable->info('name');
      $select->joinLeft($searchTableName, "`{$searchTableName}`.`item_id` = `{$courseTableName}`.`owner_id`", null);
      if (empty($params['widgetManage'])) {
        $select->where("{$courseTableName}.search = ?", 1);
      }

      // Build search part of query
      $searchParts = Engine_Api::_()->fields()->getSearchQuery('courses', $customFields);

      foreach ($searchParts as $k => $v) {
        if (strpos($k, 'FIND_IN_SET') !== false) {
          $select->where("{$k}", $v);
          continue;
        }
        $select->where("`{$searchTableName}`.{$k}", $v);

        if (isset($v) && $v != "") {
          $searchDefault = false;
        }
      }
    }
    //End Custom Field Fieltering Work
    if (isset($params['limit']))
      $select->limit($params['limit']);

    if (isset($params['popularity']) && $params['popularity'] == "You May Also Like") {
      $select->order('RAND() DESC');
    }
    $select->order($courseTableName . '.creation_date DESC');
    if (isset($params['fetchAll'])) {
      return $this->fetchAll($select);
    } else {
      return $select;
    }
  }
  public function getPopularInstructor($params = array(),$customFields = array()) {
      $defaultFields = array("owner_id","total_lectures"=>"SUM(engine4_courses_courses.lecture_count)","total_courses"=>"COUNT(engine4_courses_courses.course_id)","total_tests"=>"SUM(engine4_courses_courses.test_count)");
      $select = $this->select()
              ->from($this->info('name'),array_merge($customFields,$defaultFields))
      ->group($this->info('name').'.owner_id')
      ->order('lecture_count')
      ->order('total_courses');
       if(isset($params['limit']) && !empty($params['limit']))
        $select->limit($params['limit']); 
      return Zend_Paginator::factory($select);
  }
  public function getWelcomePageMember($params = array()) {
    $tableUser = Engine_Api::_()->getDbTable('users', 'user');
    $select = $tableUser->select();
    if(!empty($params['member_level']) && isset($params['member_level'])) {
      $select->where($tableUser->info('name').".level_id = ? ",$params['member_level']);
    }
    if(isset($params['limit']) && !empty($params['limit']))
      $select->limit($params['limit']); 
    return Zend_Paginator::factory($select);
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
  public function getCoursePurchasedMember($course_id) {
      $select = $this->select()
              ->from($this->info('name'),'user_id')
              ->where('course_id =?', $course_id)
              ->group('user_id');
      return $this->fetchAll($select);
  }
}
