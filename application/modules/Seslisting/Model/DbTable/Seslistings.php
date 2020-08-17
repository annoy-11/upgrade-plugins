<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Seslistings.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Model_DbTable_Seslistings extends Engine_Db_Table {

  protected $_rowClass = "Seslisting_Model_Listing";
  protected $_name = "seslisting_listings";

  /**
   * Gets a paginator for seslistings
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getSeslistingsPaginator($params = array(), $customFields = array()) {

    $paginator = Zend_Paginator::factory($this->getSeslistingsSelect($params, $customFields));
    if( !empty($params['page']) )
    $paginator->setCurrentPageNumber($params['page']);
    if( !empty($params['limit']) )
    $paginator->setItemCountPerPage($params['limit']);

    if( empty($params['limit']) ) {
      $page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.page', 10);
      $paginator->setItemCountPerPage($page);
    }

    return $paginator;
  }

  /**
   * Gets a select object for the user's seslisting entries
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Db_Table_Select
   */
  public function getSeslistingsSelect($params = array(), $customFields = array()) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $tableLocationName = Engine_Api::_()->getDbtable('locations', 'sesbasic')->info('name');
    $listingTable = Engine_Api::_()->getDbtable('seslistings', 'seslisting');
    $listingTableName = $listingTable->info('name');
    $select = $listingTable->select()->setIntegrityCheck(false)->from($listingTableName);

    if( !empty($params['user_id']) && is_numeric($params['user_id']) )
    $select->where($listingTableName.'.owner_id = ?', $params['user_id']);

    if(isset($params['parent_type']))
      $select->where($listingTableName.'.parent_type = ?', $params['parent_type']);

    if( !empty($params['user']) && $params['user'] instanceof User_Model_User )
    $select->where($listingTableName.'.owner_id = ?', $params['user']->getIdentity());

    if (isset($params['show']) && $params['show'] == 2 && $viewer->getIdentity()) {
      $users = $viewer->membership()->getMembershipsOfIds();
      if ($users)
      $select->where($listingTableName . '.owner_id IN (?)', $users);
      else
      $select->where($listingTableName . '.owner_id IN (?)', 0);
    }

    if(empty($params['miles']))
    $params['miles'] = 200;

    if (isset($params['lat']) && isset($params['miles']) && $params['miles'] != 0 && isset($params['lng']) && $params['lat'] != '' && $params['lng'] != '' && ((isset($params['location']) && $params['location'] != '' && strtolower($params['location']) != 'world'))) {
      $origLat = $params['lat'];
      $origLon = $params['lng'];
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.search.type', 1) == 1)
       $searchType = 3956;
      else
      $searchType = 6371;
      //This is the maximum distance (in miles) away from $origLat, $origLon in which to search
      $dist = $params['miles'];
      $asinSort = array('lat', 'lng', 'distance' => new Zend_Db_Expr(($searchType . " * 2 * ASIN(SQRT( POWER(SIN(($origLat - abs(lat))*pi()/180/2),2) + COS($origLat*pi()/180 )*COS(abs(lat)*pi()/180) *POWER(SIN(($origLon-lng)*pi()/180/2),2)))")));
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $listingTableName . '.listing_id AND ' . $tableLocationName . '.resource_type = "seslisting" ', $asinSort);
      $select->where($tableLocationName . ".lng between ($origLon-$dist/abs(cos(radians($origLat))*69)) and ($origLon+$dist/abs(cos(radians($origLat))*69)) and " . $tableLocationName . ".lat between ($origLat-($dist/69)) and ($origLat+($dist/69))");
      $select->order('distance');
      $select->having("distance < $dist");
    }
    else {
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $listingTableName . '.listing_id AND ' . $tableLocationName . '.resource_type = "seslisting" ', array('lat', 'lng'));
    }

    if( !empty($params['tag']) ) {
      $tmName = Engine_Api::_()->getDbtable('TagMaps', 'core')->info('name');
      $select->setIntegrityCheck(false)->joinLeft($tmName, "$tmName.resource_id = $listingTableName.listing_id")
	    ->where($tmName.'.resource_type = ?', 'seslisting')
	    ->where($tmName.'.tag_id = ?', $params['tag']);
    }

    if (!empty($params['alphabet']) && $params['alphabet'] != 'all')
    $select->where($listingTableName . ".title LIKE ?", $params['alphabet'] . '%');

    $currentTime = date('Y-m-d H:i:s');

    if (!empty($params['ordering'])) {
      switch ($params['ordering']) {
        case "1":
          $select->order($listingTableName . '.creation_date DESC');
          break;
        case "2":
          $select->order($listingTableName . '.view_count DESC');
          break;
        case "3":
          $select->order($listingTableName . '.title');
          break;
        case "4":
          $select->order($listingTableName . '.sponsored' . ' DESC');
          break;
        case "5":
          $select->order($listingTableName . '.featured' . ' DESC');
          break;
        case "6":
          $select->order($listingTableName . '.sponsored' . ' DESC');
          $select->order($listingTableName . '.featured' . ' DESC');
          break;
        case "7":
          $select->order($listingTableName . '.featured' . ' DESC');
          $select->order($listingTableName . '.sponsored' . ' DESC');
          break;
      }
    }

    if(isset($params['popularCol']) && !empty($params['popularCol'])) {
			if($params['popularCol'] == 'week') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
				$select->where("DATE(".$listingTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			elseif($params['popularCol'] == 'month') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$listingTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			else {
				$select = $select->order($listingTableName . '.' .$params['popularCol'] . ' DESC');
			}
    }

    if (isset($params['fixedData']) && !empty($params['fixedData']) && $params['fixedData'] != '')
    $select = $select->where($listingTableName . '.' . $params['fixedData'] . ' =?', 1);

    if (isset($params['featured']) && !empty($params['featured']))
    $select = $select->where($listingTableName . '.featured =?', 1);

    if (isset($params['verified']) && !empty($params['verified']))
    $select = $select->where($listingTableName . '.verified =?', 1);

    if (isset($params['sponsored']) && !empty($params['sponsored']))
    $select = $select->where($listingTableName . '.sponsored =?', 1);

    if (!empty($params['category_id']))
    $select = $select->where($listingTableName . '.category_id =?', $params['category_id']);

    if (!empty($params['subcat_id']))
    $select = $select->where($listingTableName . '.subcat_id =?', $params['subcat_id']);

    if (!empty($params['subsubcat_id']))
    $select = $select->where($listingTableName . '.subsubcat_id =?', $params['subsubcat_id']);

    if( isset($params['draft']) )
    $select->where($listingTableName.'.draft = ?', $params['draft']);

    if( !empty($params['text']) )
    $select->where($listingTableName.".title LIKE ? OR ".$listingTableName.".body LIKE ?", '%'.$params['text'].'%');

    if( !empty($params['date']) )
    $select->where("DATE_FORMAT(" . $listingTableName.".creation_date, '%Y-%m-%d') = ?", date('Y-m-d', strtotime($params['date'])));

		if( !empty($params['start_date']) )
    $select->where($listingTableName.".creation_date = ?", date('Y-m-d', $params['start_date']));

    if( !empty($params['end_date']) )
    $select->where($listingTableName.".creation_date < ?", date('Y-m-d', $params['end_date']));

    if( !empty($params['visible']) )
    $select->where($listingTableName.".search = ?", $params['visible']);

		if(!isset($params['manage-widget'])) {
			$select->where($listingTableName . ".publish_date <= '$currentTime' OR " . $listingTableName . ".publish_date = ''");
			$select->where($listingTableName.'.is_approved = ?',(bool) 1)->where($listingTableName.'.draft = ?',(bool) 0)->where($listingTableName.'.search = ?', (bool) 1);
			//check package query
			if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seslistingpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslistingpackage.enable.package', 1)){
				$order = Engine_Api::_()->getDbTable('orderspackages','seslistingpackage');
				$orderTableName = $order->info('name');
				$select->joinLeft($orderTableName, $orderTableName . '.orderspackage_id = ' . $listingTableName . '.orderspackage_id',null);
				$select->where($orderTableName . '.expiration_date  > "'.date("Y-m-d H:i:s").'" || expiration_date IS NULL || expiration_date = "0000-00-00 00:00:00"');
			}
		}else
			$select->where($listingTableName.'.owner_id = ?',$viewerId);

		if (isset($params['criteria'])) {
			if ($params['criteria'] == 1)
			$select->where($listingTableName . '.featured =?', '1');
			else if ($params['criteria'] == 2)
			$select->where($listingTableName . '.sponsored =?', '1');
			else if ($params['criteria'] == 3)
			$select->where($listingTableName . '.featured = 1 OR ' . $listingTableName . '.sponsored = 1');
			else if ($params['criteria'] == 4)
			$select->where($listingTableName . '.featured = 0 AND ' . $listingTableName . '.sponsored = 0');
			else if ($params['criteria'] == 6)
			$select->where($listingTableName . '.verified =?', '1');
		}

		if (isset($params['order']) && !empty($params['order'])) {
      if ($params['order'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(".$listingTableName.".creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['order'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$listingTableName.".creation_date) between ('$endTime') and ('$currentTime')");
      }
    }

    if (isset($params['widgetName']) && !empty($params['widgetName']) && $params['widgetName'] == 'Similar Listings') {
      if(!empty($params['widgetName'])) {
        $select->where($listingTableName.'.category_id =?', $params['category_id']);
      }
    }

		if(isset($params['similar_listing']))
		$select->where($listingTableName . '.parent_id =?', $params['listing_id']);

		if (isset($customFields['has_photo']) && !empty($customFields['has_photo'])) {
      $select->where($listingTableName . '.photo_id != ?', "0");
    }

		if (isset($params['criteria'])) {
			switch ($params['info']) {
				case 'recently_created':
					$select->order($listingTableName . '.creation_date DESC');
					break;
				case 'most_viewed':
					$select->order($listingTableName . '.view_count DESC');
					break;
				case 'most_liked':
					$select->order($listingTableName . '.like_count DESC');
					break;
				case 'most_favourite':
					$select->order($listingTableName . '.favourite_count DESC');
					break;
				case 'most_commented':
					$select->order($listingTableName . '.comment_count DESC');
					break;
				case 'most_rated':
					$select->order($listingTableName . '.rating DESC');
					break;
				case 'random':
					$select->order('Rand()');
					break;
			}
		}
		if(!empty($params['getlisting']))	{
			$select->where($listingTableName.".title LIKE ? OR ".$listingTableName.".body LIKE ?", '%'.$params['textSearch'].'%')->where($listingTableName.".search = ?", 1);
		}

    //don't show other module listings
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.other.modulelistings', 1) && empty($params['resource_type'])) {
      $select->where($listingTableName . '.resource_type IS NULL')
              ->where($listingTableName . '.resource_id =?', 0);
    } else if (!empty($params['resource_type']) && !empty($params['resource_id'])) {
      $select->where($listingTableName . '.resource_type =?', $params['resource_type'])
              ->where($listingTableName . '.resource_id =?', $params['resource_id']);
    } else if(!empty($params['resource_type'])) {
      $select->where($listingTableName . '.resource_type =?', $params['resource_type']);
    }
    //don't show other module listings

    $select->order( !empty($params['orderby']) ? $params['orderby'].' DESC' : $listingTableName.'.creation_date DESC' );
    if(isset($params['fetchAll'])) {
      if(!isset($params['rss'])) {
        if(empty($params['limit']))
        $select->limit(3);
        else
        $select->limit($params['limit']);
      }
      return $this->fetchAll($select);
    }
    else
    return $select;
  }

  public function getListing($params = array()) {

    $table = Engine_Api::_()->getDbtable('seslistings', 'seslisting');
    $listingTableName = $table->info('name');
    $select = $table->select()
                    ->where($listingTableName.'.draft = ?', 0)
                    ->where($listingTableName.".title LIKE ? OR ".$listingTableName.".body LIKE ?", '%'.$params['text'].'%')
                    ->where($listingTableName.".search = ?", 1)
                    ->order('creation_date DESC');

    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.other.modulelistings', 1) && empty($params['resource_type'])) {
      $select->where($listingTableName . '.resource_type IS NULL')->where($listingTableName . '.resource_id =?', 0);
    }

    return $this->fetchAll($select);
  }

  /**
   * Returns an array of dates where a given user created a seslisting entry
   *
   * @param User_Model_User user to calculate for
   * @return Array Dates
   */
  public function getArchiveList($spec) {

    if( !($spec instanceof User_Model_User) )
    return null;

    $localeObject = Zend_Registry::get('Locale');
    if( !$localeObject )
    $localeObject = new Zend_Locale();

    $dates = $this->select()
        ->from($this, 'creation_date')
        ->where('owner_type = ?', 'user')
        ->where('owner_id = ?', $spec->getIdentity())
        ->where('draft = ?', 0)
        ->order('listing_id DESC')
        ->query()
        ->fetchAll(Zend_Db::FETCH_COLUMN);

    $time = time();

    $archive_list = array();
    foreach( $dates as $date ) {

      $date = strtotime($date);
      $ltime = localtime($date, true);
      $ltime["tm_mon"] = $ltime["tm_mon"] + 1;
      $ltime["tm_year"] = $ltime["tm_year"] + 1900;

      // LESS THAN A YEAR AGO - MONTHS
      if( $date + 31536000 > $time ) {
        $date_start = mktime(0, 0, 0, $ltime["tm_mon"], 1, $ltime["tm_year"]);
        $date_end = mktime(0, 0, 0, $ltime["tm_mon"] + 1, 1, $ltime["tm_year"]);
        $type = 'month';

        $dateObject = new Zend_Date($date);
        $format = $localeObject->getTranslation('yMMMM', 'dateitem', $localeObject);
        $label = $dateObject->toString($format, $localeObject);
      }
      // MORE THAN A YEAR AGO - YEARS
      else {
        $date_start = mktime(0, 0, 0, 1, 1, $ltime["tm_year"]);
        $date_end = mktime(0, 0, 0, 1, 1, $ltime["tm_year"] + 1);
        $type = 'year';

        $dateObject = new Zend_Date($date);
        $format = $localeObject->getTranslation('yyyy', 'dateitem', $localeObject);
        if( !$format )
        $format = $localeObject->getTranslation('y', 'dateitem', $localeObject);

        $label = $dateObject->toString($format, $localeObject);
      }

      if( !isset($archive_list[$date_start]) ) {
        $archive_list[$date_start] = array(
          'type' => $type,
          'label' => $label,
          'date' => $date,
          'date_start' => $date_start,
          'date_end' => $date_end,
          'count' => 1
        );
      }
      else
      $archive_list[$date_start]['count']++;
    }
    return $archive_list;
  }

  public function getOfTheDayResults() {
    return $this->select()
	      ->from($this->info('name'), 'listing_id')
	      ->where('offtheday =?', 1)
	      ->where('starttime <= DATE(NOW())')
	      ->where('endtime >= DATE(NOW())')
	      ->order('RAND()')
	      ->query()
	      ->fetchColumn();
  }

  public function checkCustomUrl($value = '', $listing_id = '') {
    $select = $this->select('listing_id')->where('custom_url = ?', $value);
    if ($listing_id)
      $select->where('listing_id !=?', $listing_id);
    return $select->query()->fetchColumn();
  }

  public function getListingId($slug = null) {
    if ($slug) {
      $tableName = $this->info('name');
      $select = $this->select()
      ->from($tableName)
      ->where($tableName . '.custom_url = ?', $slug);
      $row = $this->fetchRow($select);
      if (empty($row)) {
      $listing_id = $slug;
      } else
      $listing_id = $row->listing_id;
      return $listing_id;
    }
    return '';
  }
}
