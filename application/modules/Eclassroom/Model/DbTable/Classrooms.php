<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Classrooms.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Model_DbTable_Classrooms extends Core_Model_Item_DbTable_Abstract {

  protected $_rowClass = "Eclassroom_Model_Classroom";

  public function countClassrooms($userId = null) {
    $count = $this->select()->from($this->info('name'), array("COUNT(classroom_id)"));
    if ($userId)
      $count->where('owner_id =?', $userId);
    return $count->query()->fetchColumn();
  }

  public function packageClassroomCount($packageId = null) {
    $count = $this->select()->from($this->info('name'), array("COUNT(course_id)"))->where('package_id =?', $packageId);
    return $count->query()->fetchColumn();
  }
//   public function getActivityQuery($viewerid = 0) {
//     favourites
//     $favouriteTable = Engine_Api::_()->getDbTable('favourites', 'eclassroom');
//     $select = $favouriteTable->select()->where('resource_type =?', 'classroom')->where('owner_id =?', $viewerid);
//     $fav = $favouriteTable->fetchAll($select);
//     $classroom = array();
//     foreach ($fav as $fa)
//       $classroom[$fa->resource_id] = $fa->resource_id;
//
//     follows
//     $followerTable = Engine_Api::_()->getDbTable('followers', 'eclassroom');
//     $select = $followerTable->select()->where('resource_type =?', 'classroom')->where('owner_id =?', $viewerid);
//     $follow = $followerTable->fetchAll($select);
//     foreach ($follow as $fa)
//       $classroom[$fa->resource_id] = $fa->resource_id;
//
//     membership
//     $db = Engine_Db_Table::getDefaultAdapter();
//     $memberships = $db->query("SELECT resource_id FROM engine4_eclassroom_membership WHERE user_id = " . $viewerid . ' AND resource_approved = 1 AND active = 1 AND user_approved = 1')->fetchAll();
//     foreach ($memberships as $fa)
//       $classroom[$fa["resource_id"]] = $fa['resource_id'];
//     like
//
//     $likes = $db->query("SELECT resource_id FROM engine4_core_likes WHERE poster_id = " . $viewerid . ' AND resource_type = "classroom" AND poster_type = "user" AND poster_id = ' . $viewerid)->fetchAll();
//     foreach ($likes as $fa)
//       $classroom[$fa["resource_id"]] = $fa['resource_id'];
//     owner classroom
//     $classroom = $db->query("SELECT course_id FROM engine4_eclassroom_classrooms WHERE owner_id = " . $viewerid)->fetchAll();
//     foreach ($classroom as $fa)
//       $classrooms[$fa["course_id"]] = $fa['course_id'];
//     return $classrooms;
//   }

  public function getClassroomId($slug = null)
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
        $classroom_id = $slug;
      } else
        $classroom_id = $row->classroom_id;
      return $classroom_id;
    }
    return '';
  }

  public function getClassroomPaginator($params = array())
  {

    return Zend_Paginator::factory($this->getClassroomSelect($params));
  }

  public function getClassroomSelect($params = array())
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $currentTime = date('Y-m-d H:i:s');
    $tableLocationName = Engine_Api::_()->getDbTable('locations', 'sesbasic')->info('name');
    $classroomTableName = $this->info('name');
    $tableTagmap = Engine_Api::_()->getDbTable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbTable('tags', 'core');

    $select = $this->select()->setIntegrityCheck(false);
    if (isset($params['left']))
      $select->from($classroomTableName, array('*', new Zend_Db_Expr('"left" AS type')));
    else if (isset($params['right']))
      $select->from($classroomTableName, array('*', new Zend_Db_Expr('"right" AS type')));
    else
      $select->from($classroomTableName);

    if (empty($params['widgetManage'])) {
      $select->where($classroomTableName . '.draft = ?', (bool) 1);
      $select->where($classroomTableName . '.is_approved = ?', (bool) 1);
      $select->where($classroomTableName . '.search = ?', (bool) 1);
      if (!isset($params['sort']) || (isset($params['sort']) && $params['sort'] != 'open' && $params['sort'] != 'close')) {
        $select->where($classroomTableName . '.status = ?', (bool) 1);
      }
    } else  {
      $select->where($classroomTableName.'.owner_id = ?',$viewerId);
    }
    //Start Location Work
    if (isset($params['lat']) && isset($params['lng']) && $params['lat'] != '' && $params['lng'] != '' && ((isset($params['location']) && $params['location'] != '' && strtolower($params['location']) != 'world'))) {
      if (empty($params['miles']) || $params['miles'] == 0) {
        $params['miles'] = 50;
      }
      $origLat = $params['lat'];
      $origLon = $params['lng'];
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.search.type', 1) == 1)
        $searchType = 3956;
      else
        $searchType = 6371;
      //This is the maximum distance (in miles) away from $origLat, $origLon in which to search
      $dist = $params['miles'];
      $asinSort = array('lat', 'lng', 'distance' => new Zend_Db_Expr(($searchType . " * 2 * ASIN(SQRT( POWER(SIN(($origLat - abs(lat))*pi()/180/2),2) + COS($origLat*pi()/180 )*COS(abs(lat)*pi()/180) *POWER(SIN(($origLon-lng)*pi()/180/2),2)))")));
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $classroomTableName . '.classroom_id AND ' . $tableLocationName . '.resource_type = "classroom" ', $asinSort);
      $select->where($tableLocationName . ".lng between ($origLon-$dist/abs(cos(radians($origLat))*69)) and ($origLon+$dist/abs(cos(radians($origLat))*69)) and " . $tableLocationName . ".lat between ($origLat-($dist/69)) and ($origLat+($dist/69))");
      $select->order('distance');
      $select->having("distance < $dist");
    }
    else if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seslocation_enable', 0) && ((empty($params['locationEnable'])) || (!empty($params['locationEnable']) && $params['locationEnable'] != "no" )) && !empty($_COOKIE['seslocation_content_data'])) {
      $locationData = json_decode($_COOKIE['seslocation_content_data'], true);
      $lat = $locationData['lat'];
      $long = $locationData['lng'];
      $dist = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslocation.search.miles', 50); // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
      $origLat = $lat;
      $origLon = $long;
      $select = $select->setIntegrityCheck(false);
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seslocation.search.type', 1) == 1) {
        $searchType = 3956;
      } else
        $searchType = 6371;

      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $classroomTableName . '.classroom_id AND ' . $tableLocationName . '.resource_type = "classroom" ', array('lat', 'lng', 'distance' => new Zend_Db_Expr($searchType . " * 2 * ASIN(SQRT( POWER(SIN(($lat - lat) *  pi()/180 / 2), 2) +COS($lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(($long - lng) * pi()/180 / 2), 2) ))")));
      $rectLong1 = $long - $dist / abs(cos(deg2rad($lat)) * 69);
      $rectLong2 = $long + $dist / abs(cos(deg2rad($lat)) * 69);
      $rectLat1 = $lat - ($dist / 69);
      $rectLat2 = $lat + ($dist / 69);
      $select->where($tableLocationName . ".lng between $rectLong1 AND $rectLong2  and " . $tableLocationName . ".lat between $rectLat1 AND $rectLat2");
      $select->order('distance');
      $select->having("distance < $dist");
    }
    else {
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $classroomTableName . '.classroom_id AND ' . $tableLocationName . '.resource_type = "classroom" ', array('lat', 'lng'));
    }

    if (isset($params['actionname']) && $params['actionname'] == 'locationclassroom') {
      $select->where($classroomTableName . '.location != ?', '');
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
        $networkSql = $networkSql . ' || networks IS NULL || networks = "" || ' . $classroomTableName . '.owner_id =' . $viewerId;
        $select->where($networkSql);
      }
    }
    if (!$networkSqlExecute) {
      $networkUser = '';
      if ($viewerId)
        $networkUser = ' ||' . $classroomTableName . '.owner_id =' . $viewerId . ' ';
      $select->where('networks IS NULL || networks = ""  ' . $networkUser);
    }
    if (!empty($params['city'])) {
      $select->where('`' . $tableLocationName . '`.`city` LIKE ?', '%' . $params['city'] . '%');
    }
    if (!empty($params['state'])) {
      $select->where('`' . $tableLocationName . '`.`state` LIKE ?', '%' . $params['state'] . '%');
    }
    if (!empty($params['country'])) {
      $select->where('`' . $tableLocationName . '`.`country` LIKE ?', '%' . $params['country'] . '%');
    }
    if (!empty($params['zip'])) {
      $select->where('`' . $tableLocationName . '`.`zip` LIKE ?', '%' . $params['zip'] . '%');
    }
    if (!empty($params['venue'])) {
      $select->where('`' . $tableLocationName . '`.`venue` LIKE ?', '%' . $params['venue'] . '%');
    }
    //End Location Work
    if (isset($params['parent_id']))
      $select->where($classroomTableName . '.parent_id =?', $params['parent_id']);
    if (isset($params['link_classroom_id']) && !empty($params['link_classroom_id'])) {
      $select->where($classroomTableName.'. classroom_id IN (SELECT link_classroom_id From engine4_eclassroom_linkclassrooms where classroom_id = '.$params['link_classroom_id'].' and active = 1)');
    }
    if (!empty($params['tag'])) {
      $select->joinLeft($tableTagName, "$tableTagName.resource_id = $classroomTableName.classroom_id")
              ->where($tableTagName . '.resource_type = ?', 'eclassroom')
              ->where($tableTagName . '.tag_id = ?', $params['tag']);
    }
    if (isset($params['sameTag']) && !empty($params['sameTag'])) {
      $select->joinLeft($tableTagName, "$tableTagName.resource_id = $classroomTableName.classroom_id", NULL)
              ->where($tableTagName . '.resource_type = ?', 'eclassroom')
              ->distinct(true)
              ->where($tableTagName . '.resource_id != ?', $params['sameTagresource_id'])
              ->where($tableTagName . '.tag_id IN(?)', $params['sameTagTag_id']);
    }
    if (isset($params['popularity']) && $params['popularity'] == "You May Also Like")
    {
      $classroomIds = Engine_Api::_()->courses()->likeIds(array('type' => 'classrooms', 'id' => $viewerId));
      $select->where($classroomTableName . '.classroom_id NOT IN(?)', $classroomIds);
    }

    if (isset($params['sort']) && !empty($params['sort']))
    {

      if ($params['sort'] == 'open')
        $select = $select->where($classroomTableName . '.status =?', 1);
      elseif ($params['sort'] == 'close')
        $select = $select->where($classroomTableName . '.status =?', 0);
      elseif ($params['sort'] == 'featured')
        $select = $select->where($classroomTableName . '.featured =?', 1);
      elseif ($params['sort'] == 'sponsored')
        $select = $select->where($classroomTableName . '.sponsored =?', 1);
      elseif ($params['sort'] == 'verified')
        $select = $select->where($classroomTableName . '.verified =?', 1);
      elseif ($params['sort'] == 'hot')
        $select = $select->where($classroomTableName . '.hot =?', 1);
      else
        $select = $select->order($classroomTableName . '.' . $params['sort'] . ' DESC');
    }

    if (isset($params['show']) && !empty($params['show']))
    {
      if ($params['show'] == 1 && $viewerId) {
        $users = $viewer->membership()->getMembershipsOfIds();
        if ($users)
          $select->where($classroomTableName . '.owner_id IN (?)', $users);
        else
          $select->where($classroomTableName . '.owner_id IN (?)', 0);
      }
      elseif ($params['show'] == 2) {
        $networkMembershipTable = Engine_Api::_()->getDbTable('membership', 'network');
        $membershipNetworkUserIds = $networkMembershipTable->getMembershipsOfIds($viewer);
        $networkMembershipTableName = $networkMembershipTable->info('name');
        $select->join($networkMembershipTableName, $classroomTableName . ".owner_id = " . $networkMembershipTableName . ".user_id  ", null)
                ->where($networkMembershipTableName . ".resource_id  IN (?) ", $membershipNetworkUserIds);
      } elseif ($params['show'] == 3) {
        $select->where($classroomTableName . '.owner_id=?', $viewerId);
      } elseif ($params['show'] == 4) {
        $select->where($classroomTableName . '.rating =?', 5);
      } elseif ($params['show'] == 5) {
        $select->where($classroomTableName . '.rating=?', 4);
      } elseif ($params['show'] == 6) {
        $select->where($classroomTableName . '.rating=?', 3);
      } elseif ($params['show'] == 7) {
        $select->where($classroomTableName . '.rating=?', 2);
      } elseif ($params['show'] == 8) {
        $select->where($classroomTableName . '.rating=?', 1);
      }
    }
    if (!empty($params['user_id']) && empty($params['classroomIds'])) {
      $select->where($classroomTableName . '.owner_id =?', $params['user_id']);
    }


    if (!empty($params['user_id']) && !empty($params['classroomIds'])) {
      if (count($params['classroomIds']))
        $select->where($classroomTableName . '.owner_id = ' . $params['user_id'] . ' || ' . $classroomTableName . '.course_id IN (?)', $params['classroomIds']);
      else
        $select->where($classroomTableName . '.owner_id =?', $params['user_id']);
    }

    if (isset($params['featured']) && !empty($params['featured']))
      $select = $select->where($classroomTableName . '.featured =?', 1);

    if (isset($params['verified']) && !empty($params['verified']))
      $select = $select->where($classroomTableName . '.verified =?', 1);

    if (isset($params['sponsored']) && !empty($params['sponsored']))
      $select = $select->where($classroomTableName . '.sponsored =?', 1);

    if (!empty($params['category_id']))
      $select->where($classroomTableName . '.category_id = ?', $params['category_id']);

    if (!empty($params['subcat_id']))
      $select = $select->where($classroomTableName . '.subcat_id =?', $params['subcat_id']);

    if (!empty($params['subsubcat_id']))
      $select = $select->where($classroomTableName . '.subsubcat_id =?', $params['subsubcat_id']);

    if (isset($params['draft']))
      $select->where($classroomTableName . '.draft = ?', $params['draft']);

    if (!empty($params['text']))
      $select->where($classroomTableName . ".title LIKE ? OR " . $classroomTableName . ".description LIKE ?", '%' . $params['text'] . '%');

    if (!empty($params['alphabet']) && $params['alphabet'] !='all')
      $select->where($classroomTableName . '.title LIKE ?', "%{$params['alphabet']}%");

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
        $select->where($classroomTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($classroomTableName . '.sponsored =?', '1');
      else if ($params['criteria'] == 6)
        $select->where($classroomTableName . '.verified =?', '1');
      else if ($params['criteria'] == 7)
        $select->where($classroomTableName . '.hot =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($classroomTableName . '.featured = 1 AND ' . $classroomTableName . '.sponsored = 1');
      else if ($params['criteria'] == 4)
        $select->where($classroomTableName . '.featured = 0 AND ' . $classroomTableName . '.sponsored = 0');
    }

    if (isset($params['order']) && !empty($params['order'])) {
      if ($params['order'] == 'open')
        $select->where('status = ?', '1');
      elseif ($params['order'] == 'close')
        $select->where('status = ?', '0');

      if ($params['order'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(" . $classroomTableName . ".creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['order'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(" . $classroomTableName . ".creation_date) between ('$endTime') and ('$currentTime')");
      }
    }
    if (isset($params['info'])) {
      switch ($params['info'])
      {
        case 'most_viewed':
          $select->order('view_count DESC');
          break;
        case 'most_liked':
          $select->order('like_count DESC');
          break;
        case 'most_commented':
          $select->order('comment_count DESC');
          break;
        case "view_count":
          $select->order($classroomTableName . '.view_count DESC');
          break;
        case "favourite_count":
          $select->order($classroomTableName . '.favourite_count DESC');
          break;
        case "most_favourite":
          $select->order($classroomTableName . '.favourite_count DESC');
          break;
        case "member_count":
          $select->order($classroomTableName . '.member_count DESC');
          break;
        case 'random':
          $select->order('Rand()');
          break;
        case "sponsored" :
          $select->where($classroomTableName . '.sponsored' . ' = 1')
                  ->order($classroomTableName . '.course_id DESC');
          break;
        case "hot" :
          $select->where($classroomTableName . '.hot' . ' = 1')
                  ->order($classroomTableName . '.course_id DESC');
          break;
        case "featured" :
          $select->where($classroomTableName . '.featured' . ' = 1')
                  ->order($classroomTableName . '.course_id DESC');
          break;
        case "creation_date":
          $select->order($classroomTableName . '.creation_date DESC');
          break;
        case "modified_date":
          $select->order($classroomTableName . '.modified_date DESC');
          break;
        case "courses":
          $select->order($classroomTableName . '.course_count DESC');
          break;
      }
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
      $searchTable = Engine_Api::_()->fields()->getTable('classroom', 'search');
      $searchTableName = $searchTable->info('name');
      $select->joinLeft($searchTableName, "`{$searchTableName}`.`item_id` = `{$classroomTableName}`.`owner_id`", null);
      if (empty($params['widgetManage'])) {
        $select->where("{$classroomTableName}.search = ?", 1);
      }

     // Build search part of query
      $searchParts = Engine_Api::_()->fields()->getSearchQuery('classroom', $customFields);
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
    $select->order($classroomTableName . '.creation_date DESC');

    if (isset($params['fetchAll'])) {
      return $this->fetchAll($select);
    } else {
      return $select;
    }
  }
  public function checkCustomUrl($value = '', $classroom_id = '') {
    $select = $this->select('course_id')->where('custom_url = ?', $value);
    if ($classroom_id)
      $select->where('classroom_id !=?', $classroom_id);
    return $select->query()->fetchColumn();
  }
  public function getOfTheDayResults($categoryId = null,$customFields = array('*')) {
    $select = $this->select()
            ->from($this->info('name'),$customFields)
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
