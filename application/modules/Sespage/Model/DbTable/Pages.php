<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Pages.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Model_DbTable_Pages extends Core_Model_Item_DbTable_Abstract {

  protected $_rowClass = "Sespage_Model_Page";

  public function countPages($userId = null) {
    $count = $this->select()->from($this->info('name'), array("COUNT(page_id)"));
    if ($userId)
      $count->where('owner_id =?', $userId);
    return $count->query()->fetchColumn();
  }
  
  public function packagePageCount($packageId = null) {
    $count = $this->select()->from($this->info('name'), array("COUNT(page_id)"))->where('package_id =?', $packageId);
    return $count->query()->fetchColumn();
  }
  
  public function checkCustomUrl($value = '', $page_id = '') {
    $select = $this->select('page_id')->where('custom_url = ?', $value);
    if ($page_id)
      $select->where('page_id !=?', $page_id);
    return $select->query()->fetchColumn();
  }

  public function getActivityQuery($viewerid = 0) {
    //favourites
    $favouriteTable = Engine_Api::_()->getDbTable('favourites', 'sespage');
    $select = $favouriteTable->select()->where('resource_type =?', 'sespage_page')->where('owner_id =?', $viewerid);
    $fav = $favouriteTable->fetchAll($select);
    $pages = array();
    foreach ($fav as $fa)
      $pages[$fa->resource_id] = $fa->resource_id;
    //follows
    $followerTable = Engine_Api::_()->getDbTable('followers', 'sespage');
    $select = $followerTable->select()->where('resource_type =?', 'sespage_page')->where('owner_id =?', $viewerid);
    $follow = $followerTable->fetchAll($select);
    foreach ($follow as $fa)
      $pages[$fa->resource_id] = $fa->resource_id;
    //membership
    $db = Engine_Db_Table::getDefaultAdapter();
    $memberships = $db->query("SELECT resource_id FROM engine4_sespage_membership WHERE user_id = " . $viewerid . ' AND resource_approved = 1 AND active = 1 AND user_approved = 1')->fetchAll();
    foreach ($memberships as $fa)
      $pages[$fa["resource_id"]] = $fa['resource_id'];
    //like
    $likes = $db->query("SELECT resource_id FROM engine4_core_likes WHERE poster_id = " . $viewerid . ' AND resource_type = "sespage_page" AND poster_type = "user" AND poster_id = ' . $viewerid)->fetchAll();
    foreach ($likes as $fa)
      $pages[$fa["resource_id"]] = $fa['resource_id'];
    //owner pages
    $page = $db->query("SELECT page_id FROM engine4_sespage_pages WHERE owner_id = " . $viewerid)->fetchAll();
    foreach ($page as $fa)
      $pages[$fa["page_id"]] = $fa['page_id'];
    return $pages;
  }

  public function getPageId($slug = null)
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
        $page_id = $slug;
      } else
        $page_id = $row->page_id;
      return $page_id;
    }
    return '';
  }

  public function getPagePaginator($params = array())
  {
      
    return Zend_Paginator::factory($this->getPageSelect($params));
  }

  public function getPageSelect($params = array())
  {


    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $currentTime = date('Y-m-d H:i:s');
    $tableLocationName = Engine_Api::_()->getDbTable('locations', 'sesbasic')->info('name');
    $pageTable = Engine_Api::_()->getDbTable('pages', 'sespage');
    $pageTableName = $pageTable->info('name');
    $tableTagmap = Engine_Api::_()->getDbTable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbTable('tags', 'core');
    $select = $pageTable->select()->setIntegrityCheck(false);
    if (isset($params['left']))
      $select->from($pageTableName, array('*', new Zend_Db_Expr('"left" AS type')));
    else if (isset($params['right']))
      $select->from($pageTableName, array('*', new Zend_Db_Expr('"right" AS type')));
    else
      $select->from($pageTableName);

    if (empty($params['widgetManage'])) {
      $select->where($pageTableName . '.draft = ?', (bool) 1);
      $select->where($pageTableName . '.is_approved = ?', (bool) 1);
      $select->where($pageTableName . '.search = ?', (bool) 1);
      if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespagepackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepackage.enable.package', 1)){
        $order = Engine_Api::_()->getDbTable('orderspackages','sespagepackage');
        $orderTableName = $order->info('name');
        $select->joinLeft($orderTableName, $orderTableName . '.orderspackage_id = ' . $pageTableName . '.orderspackage_id',null);
        $select->where($orderTableName . '.expiration_date  > "'.date("Y-m-d H:i:s").'" || expiration_date IS NULL || expiration_date = "0000-00-00 00:00:00"');
      }
      if (!isset($params['sort']) || (isset($params['sort']) && $params['sort'] != 'open' && $params['sort'] != 'close')) {
        $select->where($pageTableName . '.status = ?', (bool) 1);
      }
    }

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) {
      //Start Location Work
      if (isset($params['lat']) && isset($params['lng']) && $params['lat'] != '' && $params['lng'] != '' && ((isset($params['location']) && $params['location'] != '' && strtolower($params['location']) != 'world'))) {
        if (empty($params['miles']) || $params['miles'] == 0) {
          $params['miles'] = 50;
        }
        $origLat = $params['lat'];
        $origLon = $params['lng'];
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.search.type', 1) == 1)
          $searchType = 3956;
        else
          $searchType = 6371;
        //This is the maximum distance (in miles) away from $origLat, $origLon in which to search
        $dist = $params['miles'];
        $asinSort = array('lat', 'lng', 'distance' => new Zend_Db_Expr(($searchType . " * 2 * ASIN(SQRT( POWER(SIN(($origLat - abs(lat))*pi()/180/2),2) + COS($origLat*pi()/180 )*COS(abs(lat)*pi()/180) *POWER(SIN(($origLon-lng)*pi()/180/2),2)))")));
        $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $pageTableName . '.page_id AND ' . $tableLocationName . '.resource_type = "sespage_page" ', $asinSort);
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

        $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $tableName . '.page_id AND ' . $tableLocationName . '.resource_type = "sespage_page" ', array('lat', 'lng', 'distance' => new Zend_Db_Expr($searchType . " * 2 * ASIN(SQRT( POWER(SIN(($lat - lat) *  pi()/180 / 2), 2) +COS($lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(($long - lng) * pi()/180 / 2), 2) ))")));
        $rectLong1 = $long - $dist / abs(cos(deg2rad($lat)) * 69);
        $rectLong2 = $long + $dist / abs(cos(deg2rad($lat)) * 69);
        $rectLat1 = $lat - ($dist / 69);
        $rectLat2 = $lat + ($dist / 69);
        $select->where($tableLocationName . ".lng between $rectLong1 AND $rectLong2  and " . $tableLocationName . ".lat between $rectLat1 AND $rectLat2");
        $select->order('distance');
        $select->having("distance < $dist");
      }
      else {
        $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $pageTableName . '.page_id AND ' . $tableLocationName . '.resource_type = "sespage_page" ', array('lat', 'lng'));
      }
    } else {
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $pageTableName . '.page_id AND ' . $tableLocationName . '.resource_type = "sespage_page" ', array('lat', 'lng'));
    }

    if (isset($params['actionname']) && $params['actionname'] == 'locationpage') {
      $select->where($pageTableName . '.location != ?', '');
    }

    $networkSqlExecute = false;
    if ($viewerId) {
      $network_table = Engine_Api::_()->getDbTable('membership', 'network');
      $network_select = $network_table->select('resource_id')->where('user_id = ?', $viewerId);
      $network_id_query = $network_table->fetchAll($network_select);
      $network_id_query_count = count($network_id_query);
      $networkSql = '(';
      for ($i = 0; $i < $network_id_query_count; $i++) {
        $networkSql = $networkSql . "CONCAT(',',CONCAT(networks,',')) LIKE '%,". $network_id_query[$i]['resource_id'] .",%' || ";
      }
      $networkSql = trim($networkSql, '|| ') . ')';
      if ($networkSql != '()') {
        $networkSqlExecute = true;
        $networkSql = $networkSql . ' || networks IS NULL || networks = "" || ' . $pageTableName . '.owner_id =' . $viewerId;
        $select->where($networkSql);
      }
    }

    if (!$networkSqlExecute) {
      $networkUser = '';
      if ($viewerId)
        $networkUser = ' ||' . $pageTableName . '.owner_id =' . $viewerId . ' ';
      $select->where('networks IS NULL || networks = ""  ' . $networkUser);
    }

    if(method_exists('Core_Model_Item_DbTable_Abstract','getItemsSelect') ) {
      $select = $this->getItemsSelect($params, $select);
    }
    
    if(!empty($params['location']) && !Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) {
      $select->where('`' . $pageTableName . '`.`location` LIKE ?', '%' . $params['location'] . '%');
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
      $select->where($pageTableName . '.parent_id =?', $params['parent_id']);
    
    if (isset($params['link_page_id']) && !empty($params['link_page_id'])) {
      $select->where($pageTableName.'. page_id IN (SELECT link_page_id From engine4_sespage_linkpages where page_id = '.$params['link_page_id'].' and active = 1)');
    }

    if (!empty($params['tag'])) {
      $select->joinLeft($tableTagName, "$tableTagName.resource_id = $pageTableName.page_id")
              ->where($tableTagName . '.resource_type = ?', 'sespage_page')
              ->where($tableTagName . '.tag_id = ?', $params['tag']);
    }

    if (isset($params['sameTag']) && !empty($params['sameTag'])) {
      $select->joinLeft($tableTagName, "$tableTagName.resource_id = $pageTableName.page_id", NULL)
              ->where($tableTagName . '.resource_type = ?', 'sespage_page')
              ->distinct(true)
              ->where($tableTagName . '.resource_id != ?', $params['sameTagresource_id'])
              ->where($tableTagName . '.tag_id IN(?)', $params['sameTagTag_id']);
    }
    elseif (isset($params['sameCategory']) && !empty($params['sameCategory']))
    {
      $select = $select->where($pageTableName . '.category_id =?', $params['category_id'])
              ->where($pageTableName . '.page_id !=?', $params['page_id']);
    }
    elseif (isset($params['other-page']))
    {
      $select->where($pageTableName . '.page_id !=?', $params['page_id']);
    }

    if (isset($params['popularity']) && $params['popularity'] == "You May Also Like")
    {
      $pageIds = Engine_Api::_()->sespage()->likeIds(array('type' => 'sespage_page', 'id' => $viewerId));
      $select->where($pageTableName . '.page_id NOT IN(?)', $pageIds);
    }
    if (isset($params['sort']) && !empty($params['sort'])){
      if ($params['sort'] == 'open')
        $select = $select->where($pageTableName . '.status =?', 1);
      elseif ($params['sort'] == 'close')
        $select = $select->where($pageTableName . '.status =?', 0);
      elseif ($params['sort'] == 'featured')
        $select = $select->where($pageTableName . '.featured =?', 1);
      elseif ($params['sort'] == 'sponsored')
        $select = $select->where($pageTableName . '.sponsored =?', 1);
      elseif ($params['sort'] == 'verified')
        $select = $select->where($pageTableName . '.verified =?', 1);
      elseif ($params['sort'] == 'hot')
        $select = $select->where($pageTableName . '.hot =?', 1);
      else {
        if ($params['sort'] == 'rating DESC' || $params['sort'] == 'rating ASC')
        $select = $select->order($pageTableName . '.' . $params['sort']);
        else
        $select = $select->order($pageTableName . '.' . $params['sort'] . ' DESC');
      }
    }
    if (isset($params['show']) && !empty($params['show'])) {
      if ($params['show'] == 1 && $viewerId) {
        $users = $viewer->membership()->getMembershipsOfIds();
        if ($users)
          $select->where($pageTableName . '.owner_id IN (?)', $users);
        else
          $select->where($pageTableName . '.owner_id IN (?)', 0);
      }
      elseif ($params['show'] == 2) {
        $networkMembershipTable = Engine_Api::_()->getDbTable('membership', 'network');
        $membershipNetworkUserIds = $networkMembershipTable->getMembershipsOfIds($viewer);
        $networkMembershipTableName = $networkMembershipTable->info('name');
        $select->join($networkMembershipTableName, $pageTableName . ".owner_id = " . $networkMembershipTableName . ".user_id  ", null)
                ->where($networkMembershipTableName . ".resource_id  IN (?) ", $membershipNetworkUserIds);
      } elseif ($params['show'] == 3) {
        $select->where($pageTableName . '.owner_id=?', $viewerId);
      } elseif ($params['show'] == 4) {
        $select->where($pageTableName . '.status=?', 1);
      } elseif ($params['show'] == 5) {
        $select->where($pageTableName . '.status=?', 0);
      }
      elseif ($params['show'] == 6) {
        $select->where($pageTableName . '.rating=?', 5);
      }
      elseif ($params['show'] == 7) {
        $select->where($pageTableName . '.rating=?', 4);
      }
      elseif ($params['show'] == 8) {
        $select->where($pageTableName . '.rating=?', 3);
      }
      elseif ($params['show'] == 9) {
        $select->where($pageTableName . '.rating=?', 2);
      }
      elseif ($params['show'] == 10) {
        $select->where($pageTableName . '.rating=?', 1);
      }
    }
    if (!empty($params['user_id']) && empty($params['pageIds'])) {
      $select->where($pageTableName . '.owner_id =?', $params['user_id']);
    }


    if (!empty($params['user_id']) && !empty($params['pageIds'])) {
      if (count($params['pageIds']))
        $select->where($pageTableName . '.owner_id = ' . $params['user_id'] . ' || ' . $pageTableName . '.page_id IN (?)', $params['pageIds']);
      else
        $select->where($pageTableName . '.owner_id =?', $params['user_id']);
    }

    if (isset($params['is_close_page']) && !empty($params['is_close_page'])) {
      $select->where($pageTableName . '.status=?', 1);
      $select->orWhere($pageTableName . '.status=?', 0);
    }

    if (isset($params['featured']) && !empty($params['featured']))
      $select = $select->where($pageTableName . '.featured =?', 1);

    if (isset($params['verified']) && !empty($params['verified']))
      $select = $select->where($pageTableName . '.verified =?', 1);

    if (isset($params['sponsored']) && !empty($params['sponsored']))
      $select = $select->where($pageTableName . '.sponsored =?', 1);

    if (!empty($params['category_id']))
      $select->where($pageTableName . '.category_id = ?', $params['category_id']);

    if (!empty($params['subcat_id']))
      $select = $select->where($pageTableName . '.subcat_id =?', $params['subcat_id']);

    if (!empty($params['subsubcat_id']))
      $select = $select->where($pageTableName . '.subsubcat_id =?', $params['subsubcat_id']);

    if (isset($params['draft']))
      $select->where($pageTableName . '.draft = ?', $params['draft']);

    if (!empty($params['text']))
      $select->where($pageTableName . ".title LIKE ? OR " . $pageTableName . ".description LIKE ?", '%' . $params['text'] . '%');

    if (!empty($params['alphabet']))
      $select->where($pageTableName . '.title LIKE ?', "{$params['alphabet']}%");

    if (!empty($params['getpage'])) {
      $select->where($pageTableName . ".title LIKE ? OR " . $pageTableName . ".description LIKE ?", '%' . $params['textSearch'] . '%')->where($pageTableName . ".search = ?", 1);
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
        $select->where($pageTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($pageTableName . '.sponsored =?', '1');
      else if ($params['criteria'] == 6)
        $select->where($pageTableName . '.verified =?', '1');
      else if ($params['criteria'] == 7)
        $select->where($pageTableName . '.hot =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($pageTableName . '.featured = 1 AND ' . $pageTableName . '.sponsored = 1');
      else if ($params['criteria'] == 4)
        $select->where($pageTableName . '.featured = 0 AND ' . $pageTableName . '.sponsored = 0');
    }

    if (isset($params['order']) && !empty($params['order'])) {
      if ($params['order'] == 'open')
        $select->where('status = ?', '1');
      elseif ($params['order'] == 'close')
        $select->where('status = ?', '0');

      if ($params['order'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(" . $pageTableName . ".creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['order'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(" . $pageTableName . ".creation_date) between ('$endTime') and ('$currentTime')");
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
        case 'most_rated':
          $select->order('rating DESC');
          break;
        case "view_count":
          $select->order($pageTableName . '.view_count DESC');
          break;
        case "favourite_count":
          $select->order($pageTableName . '.favourite_count DESC');
          break;
        case "most_favourite":
          $select->order($pageTableName . '.favourite_count DESC');
          break;
        case "member_count":
          $select->order($pageTableName . '.member_count DESC');
          break;
        case 'random':
          $select->order('Rand()');
          break;
        case "sponsored" :
          $select->where($pageTableName . '.sponsored' . ' = 1')
                  ->order($pageTableName . '.page_id DESC');
          break;
        case "hot" :
          $select->where($pageTableName . '.hot' . ' = 1')
                  ->order($pageTableName . '.page_id DESC');
          break;
        case "featured" :
          $select->where($pageTableName . '.featured' . ' = 1')
                  ->order($pageTableName . '.page_id DESC');
          break;
        case "creation_date":
          $select->order($pageTableName . '.creation_date DESC');
          break;
        case "modified_date":
          $select->order($pageTableName . '.modified_date DESC');
          break;
      }
    }

    if(!empty($params['notPageId']) && count($params['notPageId'])){
        $select->where($pageTableName.'.page_id NOT IN (?)',$params["notPageId"]);
    }
    if(!empty($params['notPageId']) && count($params['notPageId']) &&  !empty($params['category_id'])){
        $select->where($pageTableName.'.page_id NOT IN (?)',$params["notPageId"]);
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
      $searchTable = Engine_Api::_()->fields()->getTable('sespage_page', 'search');
      $searchTableName = $searchTable->info('name');
      $select->joinLeft($searchTableName, "`{$searchTableName}`.`item_id` = `{$pageTableName}`.`owner_id`", null);
      if (empty($params['widgetManage'])) {
        $select->where("{$pageTableName}.search = ?", 1);
      }
      // Build search part of query
      $searchParts = Engine_Api::_()->fields()->getSearchQuery('sespage_page', $customFields);

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
    $select->order($pageTableName . '.creation_date DESC');

    if (!empty($params['user_id']) && !empty($params['pageIds'])) {

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
    $pageTableName = $this->info('name');
    $select = $this->select()
            ->from($pageTableName);
    if (isset($params['page_id']))
      $select->where($pageTableName . '.page_id =?', $params['page_id']);
    if (isset($params['type'])) {
      if ($params['type'] == 'month') {
        $select->where("DATE_FORMAT(" . $pageTableName . " .creation_date, '%Y-%m') <= ?", $params['enddate'])
                ->where("DATE_FORMAT(" . $pageTableName . " .creation_date, '%Y-%m') >= ?", $params['startdate'])
                ->group("$pageTableName.page_id")
                ->group("YEAR($pageTableName.creation_date)")
                ->group("MONTH($pageTableName.creation_date)");
      } else {
        $select->where("DATE_FORMAT(" . $pageTableName . " .creation_date, '%Y-%m-%d') <= ?", $params['enddate'])
                ->where("DATE_FORMAT(" . $pageTableName . " .creation_date, '%Y-%m-%d') >= ?", $params['startdate'])
                ->group("$pageTableName.page_id")
                ->group("YEAR($pageTableName.creation_date)")
                ->group("MONTH($pageTableName.creation_date)")
                ->group("DAY($pageTableName.creation_date)");
      }
    }
    return $this->fetchAll($select);
  }

}
