<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Businesses.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Model_DbTable_Businesses extends Core_Model_Item_DbTable_Abstract {

  protected $_rowClass = "Sesbusiness_Model_Business";

  public function countBusinesses($userId = null) {
    $count = $this->select()->from($this->info('name'), array("COUNT(business_id)"));
    if ($userId)
      $count->where('owner_id =?', $userId);
    return $count->query()->fetchColumn();
  }

  public function packageBusinessCount($packageId = null) {
    $count = $this->select()->from($this->info('name'), array("COUNT(business_id)"))->where('package_id =?', $packageId);
    return $count->query()->fetchColumn();
  }

  public function checkCustomUrl($value = '', $business_id = '') {
    $select = $this->select('business_id')->where('custom_url = ?', $value);
    if ($business_id)
      $select->where('business_id !=?', $business_id);
    return $select->query()->fetchColumn();
  }

  public function getActivityQuery($viewerid = 0) {
    //favourites
    $favouriteTable = Engine_Api::_()->getDbTable('favourites', 'sesbusiness');
    $select = $favouriteTable->select()->where('resource_type =?', 'businesses')->where('owner_id =?', $viewerid);
    $fav = $favouriteTable->fetchAll($select);
    $businesses = array();
    foreach ($fav as $fa)
      $businesses[$fa->resource_id] = $fa->resource_id;
    //follows
    $followerTable = Engine_Api::_()->getDbTable('followers', 'sesbusiness');
    $select = $followerTable->select()->where('resource_type =?', 'businesses')->where('owner_id =?', $viewerid);
    $follow = $followerTable->fetchAll($select);
    foreach ($follow as $fa)
      $businesses[$fa->resource_id] = $fa->resource_id;
    //membership
    $db = Engine_Db_Table::getDefaultAdapter();
    $memberships = $db->query("SELECT resource_id FROM engine4_sesbusiness_membership WHERE user_id = " . $viewerid . ' AND resource_approved = 1 AND active = 1 AND user_approved = 1')->fetchAll();
    foreach ($memberships as $fa)
      $businesses[$fa["resource_id"]] = $fa['resource_id'];
    //like
    $likes = $db->query("SELECT resource_id FROM engine4_core_likes WHERE poster_id = " . $viewerid . ' AND resource_type = "businesses" AND poster_type = "user" AND poster_id = ' . $viewerid)->fetchAll();
    foreach ($likes as $fa)
      $businesses[$fa["resource_id"]] = $fa['resource_id'];
    //owner businesses
    $business = $db->query("SELECT business_id FROM engine4_sesbusiness_businesses WHERE owner_id = " . $viewerid)->fetchAll();
    foreach ($business as $fa)
      $businesses[$fa["business_id"]] = $fa['business_id'];
    return $businesses;
  }

  public function getBusinessId($slug = null)
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
        $business_id = $slug;
      } else
        $business_id = $row->business_id;
      return $business_id;
    }
    return '';
  }

  public function getBusinessPaginator($params = array())
  {

    return Zend_Paginator::factory($this->getBusinessSelect($params));
  }

  public function getBusinessSelect($params = array())
  {


    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $currentTime = date('Y-m-d H:i:s');
    $tableLocationName = Engine_Api::_()->getDbTable('locations', 'sesbasic')->info('name');
    $businessTable = Engine_Api::_()->getDbTable('businesses', 'sesbusiness');
    $businessTableName = $businessTable->info('name');
    $tableTagmap = Engine_Api::_()->getDbTable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbTable('tags', 'core');
    $select = $businessTable->select()->setIntegrityCheck(false);
    if (isset($params['left']))
      $select->from($businessTableName, array('*', new Zend_Db_Expr('"left" AS type')));
    else if (isset($params['right']))
      $select->from($businessTableName, array('*', new Zend_Db_Expr('"right" AS type')));
    else
      $select->from($businessTableName);

    if (isset($params['sort']) && $params['sort'] != 'open' && $params['sort'] != 'close')
    {

    }
    if (empty($params['widgetManage'])) {
      $select->where($businessTableName . '.draft = ?', (bool) 1);
      $select->where($businessTableName . '.is_approved = ?', (bool) 1);
      $select->where($businessTableName . '.search = ?', (bool) 1);
      if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesbusinesspackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspackage.enable.package', 1)){
        $order = Engine_Api::_()->getDbTable('orderspackages','sesbusinesspackage');
        $orderTableName = $order->info('name');
        $select->joinLeft($orderTableName, $orderTableName . '.orderspackage_id = ' . $businessTableName . '.orderspackage_id',null);
        $select->where($orderTableName . '.expiration_date  > "'.date("Y-m-d H:i:s").'" || expiration_date IS NULL || expiration_date = "0000-00-00 00:00:00"');
      }
      if (!isset($params['sort']) || (isset($params['sort']) && $params['sort'] != 'open' && $params['sort'] != 'close')) {
        $select->where($businessTableName . '.status = ?', (bool) 1);
      }
    }

    //Start Location Work
    if (isset($params['lat']) && isset($params['lng']) && $params['lat'] != '' && $params['lng'] != '' && ((isset($params['location']) && $params['location'] != '' && strtolower($params['location']) != 'world'))) {
      if (empty($params['miles']) || $params['miles'] == 0) {
        $params['miles'] = 50;
      }
      $origLat = $params['lat'];
      $origLon = $params['lng'];
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.search.type', 1) == 1)
        $searchType = 3956;
      else
        $searchType = 6371;
      //This is the maximum distance (in miles) away from $origLat, $origLon in which to search
      $dist = $params['miles'];
      $asinSort = array('lat', 'lng', 'distance' => new Zend_Db_Expr(($searchType . " * 2 * ASIN(SQRT( POWER(SIN(($origLat - abs(lat))*pi()/180/2),2) + COS($origLat*pi()/180 )*COS(abs(lat)*pi()/180) *POWER(SIN(($origLon-lng)*pi()/180/2),2)))")));
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $businessTableName . '.business_id AND ' . $tableLocationName . '.resource_type = "businesses" ', $asinSort);
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

      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $tableName . '.business_id AND ' . $tableLocationName . '.resource_type = "businesses" ', array('lat', 'lng', 'distance' => new Zend_Db_Expr($searchType . " * 2 * ASIN(SQRT( POWER(SIN(($lat - lat) *  pi()/180 / 2), 2) +COS($lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(($long - lng) * pi()/180 / 2), 2) ))")));
      $rectLong1 = $long - $dist / abs(cos(deg2rad($lat)) * 69);
      $rectLong2 = $long + $dist / abs(cos(deg2rad($lat)) * 69);
      $rectLat1 = $lat - ($dist / 69);
      $rectLat2 = $lat + ($dist / 69);
      $select->where($tableLocationName . ".lng between $rectLong1 AND $rectLong2  and " . $tableLocationName . ".lat between $rectLat1 AND $rectLat2");
      $select->order('distance');
      $select->having("distance < $dist");
    }
    else {
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $businessTableName . '.business_id AND ' . $tableLocationName . '.resource_type = "businesses" ', array('lat', 'lng'));
    }

    if (isset($params['actionname']) && $params['actionname'] == 'locationbusiness') {
      $select->where($businessTableName . '.location != ?', '');
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
        $networkSql = $networkSql . ' || networks IS NULL || networks = "" || ' . $businessTableName . '.owner_id =' . $viewerId;
        $select->where($networkSql);
      }
    }

    if (!$networkSqlExecute) {
      $networkUser = '';
      if ($viewerId)
        $networkUser = ' ||' . $businessTableName . '.owner_id =' . $viewerId . ' ';
      $select->where('networks IS NULL || networks = ""  ' . $networkUser);
    }

    //if(method_exists('Core_Model_Item_DbTable_Abstract','getItemsSelect') ) {
     // $select = $this->getItemsSelect($params, $select);
    //}

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
      $select->where($businessTableName . '.parent_id =?', $params['parent_id']);

    if (isset($params['link_business_id']) && !empty($params['link_business_id'])) {
      $select->where($businessTableName.'. business_id IN (SELECT link_business_id From engine4_sesbusiness_linkbusinesses where business_id = '.$params['link_business_id'].' and active = 1)');
    }

    if (!empty($params['tag'])) {
      $select->joinLeft($tableTagName, "$tableTagName.resource_id = $businessTableName.business_id")
              ->where($tableTagName . '.resource_type = ?', 'businesses')
              ->where($tableTagName . '.tag_id = ?', $params['tag']);
    }

    if (isset($params['sameTag']) && !empty($params['sameTag'])) {
      $select->joinLeft($tableTagName, "$tableTagName.resource_id = $businessTableName.business_id", NULL)
              ->where($tableTagName . '.resource_type = ?', 'businesses')
              ->distinct(true)
              ->where($tableTagName . '.resource_id != ?', $params['sameTagresource_id'])
              ->where($tableTagName . '.tag_id IN(?)', $params['sameTagTag_id']);
    }
    elseif (isset($params['sameCategory']) && !empty($params['sameCategory']))
    {
      $select = $select->where($businessTableName . '.category_id =?', $params['category_id'])
              ->where($businessTableName . '.business_id !=?', $params['business_id']);
    }
    elseif (isset($params['other-business']))
    {
      $select->where($businessTableName . '.business_id !=?', $params['business_id']);
    }

    if (isset($params['popularity']) && $params['popularity'] == "You May Also Like")
    {
      $businessIds = Engine_Api::_()->sesbusiness()->likeIds(array('type' => 'businesses', 'id' => $viewerId));
      $select->where($businessTableName . '.business_id NOT IN(?)', $businessIds);
    }

    if (isset($params['sort']) && !empty($params['sort']))
    {

      if ($params['sort'] == 'open')
        $select = $select->where($businessTableName . '.status =?', 1);
      elseif ($params['sort'] == 'close')
        $select = $select->where($businessTableName . '.status =?', 0);
      elseif ($params['sort'] == 'featured')
        $select = $select->where($businessTableName . '.featured =?', 1);
      elseif ($params['sort'] == 'sponsored')
        $select = $select->where($businessTableName . '.sponsored =?', 1);
      elseif ($params['sort'] == 'verified')
        $select = $select->where($businessTableName . '.verified =?', 1);
      elseif ($params['sort'] == 'hot')
        $select = $select->where($businessTableName . '.hot =?', 1);
      else
        $select = $select->order($businessTableName . '.' . $params['sort'] . ' DESC');
    }

    if (isset($params['show']) && !empty($params['show']))
    {
      if ($params['show'] == 1 && $viewerId) {
        $users = $viewer->membership()->getMembershipsOfIds();
        if ($users)
          $select->where($businessTableName . '.owner_id IN (?)', $users);
        else
          $select->where($businessTableName . '.owner_id IN (?)', 0);
      }
      elseif ($params['show'] == 2) {
        $networkMembershipTable = Engine_Api::_()->getDbTable('membership', 'network');
        $membershipNetworkUserIds = $networkMembershipTable->getMembershipsOfIds($viewer);
        $networkMembershipTableName = $networkMembershipTable->info('name');
        $select->join($networkMembershipTableName, $businessTableName . ".owner_id = " . $networkMembershipTableName . ".user_id  ", null)
                ->where($networkMembershipTableName . ".resource_id  IN (?) ", $membershipNetworkUserIds);
      } elseif ($params['show'] == 3) {
        $select->where($businessTableName . '.owner_id=?', $viewerId);
      } elseif ($params['show'] == 4) {
        $select->where($businessTableName . '.status=?', 1);
      } elseif ($params['show'] == 5) {
        $select->where($businessTableName . '.status=?', 0);
      }
      elseif ($params['show'] == 6) {
        $select->where($businessTableName . '.rating=?', 5);
      }
      elseif ($params['show'] == 7) {
        $select->where($businessTableName . '.rating=?', 4);
      }
      elseif ($params['show'] == 8) {
        $select->where($businessTableName . '.rating=?', 3);
      }
      elseif ($params['show'] == 9) {
        $select->where($businessTableName . '.rating=?', 2);
      }
      elseif ($params['show'] == 10) {
        $select->where($businessTableName . '.rating=?', 1);
      }
    }
    if (!empty($params['user_id']) && empty($params['businessIds'])) {
      $select->where($businessTableName . '.owner_id =?', $params['user_id']);
    }


    if (!empty($params['user_id']) && !empty($params['businessIds'])) {
      if (count($params['businessIds']))
        $select->where($businessTableName . '.owner_id = ' . $params['user_id'] . ' || ' . $businessTableName . '.business_id IN (?)', $params['businessIds']);
      else
        $select->where($businessTableName . '.owner_id =?', $params['user_id']);
    }

    if (isset($params['is_close_business']) && !empty($params['is_close_business'])) {
      $select->where($businessTableName . '.status=?', 1);
      $select->orWhere($businessTableName . '.status=?', 0);
    }

    if (isset($params['featured']) && !empty($params['featured']))
      $select = $select->where($businessTableName . '.featured =?', 1);

    if (isset($params['verified']) && !empty($params['verified']))
      $select = $select->where($businessTableName . '.verified =?', 1);

    if (isset($params['sponsored']) && !empty($params['sponsored']))
      $select = $select->where($businessTableName . '.sponsored =?', 1);

    if (!empty($params['category_id']))
      $select->where($businessTableName . '.category_id = ?', $params['category_id']);

    if (!empty($params['subcat_id']))
      $select = $select->where($businessTableName . '.subcat_id =?', $params['subcat_id']);

    if (!empty($params['subsubcat_id']))
      $select = $select->where($businessTableName . '.subsubcat_id =?', $params['subsubcat_id']);

    if (isset($params['draft']))
      $select->where($businessTableName . '.draft = ?', $params['draft']);

    if (!empty($params['text']))
      $select->where($businessTableName . ".title LIKE ? OR " . $businessTableName . ".description LIKE ?", '%' . $params['text'] . '%');

    if (!empty($params['alphabet']))
      $select->where($businessTableName . '.title LIKE ?', "{$params['alphabet']}%");

    if (!empty($params['getbusiness'])) {
      $select->where($businessTableName . ".title LIKE ? OR " . $businessTableName . ".description LIKE ?", '%' . $params['textSearch'] . '%')->where($businessTableName . ".search = ?", 1);
    }

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
        $select->where($businessTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($businessTableName . '.sponsored =?', '1');
      else if ($params['criteria'] == 6)
        $select->where($businessTableName . '.verified =?', '1');
      else if ($params['criteria'] == 7)
        $select->where($businessTableName . '.hot =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($businessTableName . '.featured = 1 AND ' . $businessTableName . '.sponsored = 1');
      else if ($params['criteria'] == 4)
        $select->where($businessTableName . '.featured = 0 AND ' . $businessTableName . '.sponsored = 0');
    }

    if (isset($params['order']) && !empty($params['order'])) {
      if ($params['order'] == 'open')
        $select->where('status = ?', '1');
      elseif ($params['order'] == 'close')
        $select->where('status = ?', '0');

      if ($params['order'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(" . $businessTableName . ".creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['order'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(" . $businessTableName . ".creation_date) between ('$endTime') and ('$currentTime')");
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
          $select->order($businessTableName . '.view_count DESC');
          break;
        case "favourite_count":
          $select->order($businessTableName . '.favourite_count DESC');
          break;
        case "most_favourite":
          $select->order($businessTableName . '.favourite_count DESC');
          break;
        case "member_count":
          $select->order($businessTableName . '.member_count DESC');
          break;
        case 'random':
          $select->order('Rand()');
          break;
        case "sponsored" :
          $select->where($businessTableName . '.sponsored' . ' = 1')
                  ->order($businessTableName . '.business_id DESC');
          break;
        case "hot" :
          $select->where($businessTableName . '.hot' . ' = 1')
                  ->order($businessTableName . '.business_id DESC');
          break;
        case "featured" :
          $select->where($businessTableName . '.featured' . ' = 1')
                  ->order($businessTableName . '.business_id DESC');
          break;
        case "creation_date":
          $select->order($businessTableName . '.creation_date DESC');
          break;
        case "modified_date":
          $select->order($businessTableName . '.modified_date DESC');
          break;
      }
    }

    if(!empty($params['notBusinessId']) && count($params['notBusinessId']) &&  !empty($params['info'])){
        $select->where($businessTableName.'.business_id NOT IN (?)',$params["notBusinessId"]);
    }
    if(!empty($params['notBusinessId']) && count($params['notBusinessId']) &&  !empty($params['category_id'])){
        $select->where($businessTableName.'.business_id NOT IN (?)',$params["notBusinessId"]);
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
      $searchTable = Engine_Api::_()->fields()->getTable('businesses', 'search');
      $searchTableName = $searchTable->info('name');
      $select->joinLeft($searchTableName, "`{$searchTableName}`.`item_id` = `{$businessTableName}`.`owner_id`", null);
      if (empty($params['widgetManage'])) {
        $select->where("{$businessTableName}.search = ?", 1);
      }
      // Build search part of query
      $searchParts = Engine_Api::_()->fields()->getSearchQuery('businesses', $customFields);

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
    $select->order($businessTableName . '.creation_date DESC');

    if (!empty($params['user_id']) && !empty($params['businessIds'])) {

      //echo $select;die;
    }
    if (isset($params['fetchAll'])) {
      return $this->fetchAll($select);
    } else {
      return $select;
    }
  }

  public function getOfTheDayResults($categoryId = null) {

    $select = $this->select()
            ->from($this->info('name'), array('*'))
            ->where('offtheday =?', 1)
            ->where('startdate <= DATE(NOW())')
            ->where('enddate >= DATE(NOW())');
    if ($categoryId) {
      $select->where('category_id =?', $categoryId);
    }
    $select->order('RAND()');
    return $this->fetchRow($select);
  }

  public function getReportData($params = array()) {
    $businessTableName = $this->info('name');
    $select = $this->select()
            ->from($businessTableName);
    if (isset($params['business_id']))
      $select->where($businessTableName . '.business_id =?', $params['business_id']);
    if (isset($params['type'])) {
      if ($params['type'] == 'month') {
        $select->where("DATE_FORMAT(" . $businessTableName . " .creation_date, '%Y-%m') <= ?", $params['enddate'])
                ->where("DATE_FORMAT(" . $businessTableName . " .creation_date, '%Y-%m') >= ?", $params['startdate'])
                ->group("$businessTableName.business_id")
                ->group("YEAR($businessTableName.creation_date)")
                ->group("MONTH($businessTableName.creation_date)");
      } else {
        $select->where("DATE_FORMAT(" . $businessTableName . " .creation_date, '%Y-%m-%d') <= ?", $params['enddate'])
                ->where("DATE_FORMAT(" . $businessTableName . " .creation_date, '%Y-%m-%d') >= ?", $params['startdate'])
                ->group("$businessTableName.business_id")
                ->group("YEAR($businessTableName.creation_date)")
                ->group("MONTH($businessTableName.creation_date)")
                ->group("DAY($businessTableName.creation_date)");
      }
    }
    return $this->fetchAll($select);
  }

}
