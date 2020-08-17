<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Jobs.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Model_DbTable_Jobs extends Engine_Db_Table {

  protected $_rowClass = "Sesjob_Model_Job";

  /**
   * Gets a paginator for sesjobs
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getSesjobsPaginator($params = array(), $customFields = array()) {

    $paginator = Zend_Paginator::factory($this->getSesjobsSelect($params, $customFields));
    if( !empty($params['page']) )
    $paginator->setCurrentPageNumber($params['page']);
    if( !empty($params['limit']) )
    $paginator->setItemCountPerPage($params['limit']);

    if( empty($params['limit']) ) {
      $page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.page', 10);
      $paginator->setItemCountPerPage($page);
    }

    return $paginator;
  }

  /**
   * Gets a select object for the user's sesjob entries
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Db_Table_Select
   */
  public function getSesjobsSelect($params = array(), $customFields = array()) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $tableLocationName = Engine_Api::_()->getDbtable('locations', 'sesbasic')->info('name');
    $jobTable = Engine_Api::_()->getDbtable('jobs', 'sesjob');
    $jobTableName = $jobTable->info('name');

    $companiesTable = Engine_Api::_()->getDbtable('companies', 'sesjob');
    $companiesTableName = $companiesTable->info('name');

    $select = $jobTable->select()->setIntegrityCheck(false)->from($jobTableName);

    $select->joinLeft($companiesTableName, $companiesTableName . '.company_id = ' . $jobTableName . '.company_id', null);

    if(!in_array($params['widgetName'], array('profile-sesjobs')))
        $select->where($companiesTableName.'.enable = ?', 1);

    if( !empty($params['industry_id']) && is_numeric($params['industry_id']) )
        $select->where($companiesTableName.'.industry_id = ?', $params['industry_id']);

    if( !empty($params['employment_id']) && is_numeric($params['employment_id']) )
        $select->where($jobTableName.'.employment_id = ?', $params['employment_id']);

    if( !empty($params['company_id']) && is_numeric($params['company_id']) )
        $select->where($jobTableName.'.company_id = ?', $params['company_id']);

    if( !empty($params['user_id']) && is_numeric($params['user_id']) )
    $select->where($jobTableName.'.owner_id = ?', $params['user_id']);

    if(isset($params['parent_type']))
      $select->where($jobTableName.'.parent_type = ?', $params['parent_type']);

    if( !empty($params['user']) && $params['user'] instanceof User_Model_User )
    $select->where($jobTableName.'.owner_id = ?', $params['user']->getIdentity());

    if (isset($params['show']) && $params['show'] == 2 && $viewer->getIdentity()) {
      $users = $viewer->membership()->getMembershipsOfIds();
      if ($users)
      $select->where($jobTableName . '.owner_id IN (?)', $users);
      else
      $select->where($jobTableName . '.owner_id IN (?)', 0);
    }

    if(empty($params['miles']))
    $params['miles'] = 200;

    if (isset($params['lat']) && isset($params['miles']) && $params['miles'] != 0 && isset($params['lng']) && $params['lat'] != '' && $params['lng'] != '' && ((isset($params['location']) && $params['location'] != '' && strtolower($params['location']) != 'world'))) {
      $origLat = $params['lat'];
      $origLon = $params['lng'];
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.search.type', 1) == 1)
       $searchType = 3956;
      else
      $searchType = 6371;
      //This is the maximum distance (in miles) away from $origLat, $origLon in which to search
      $dist = $params['miles'];
      $asinSort = array('lat', 'lng', 'distance' => new Zend_Db_Expr(($searchType . " * 2 * ASIN(SQRT( POWER(SIN(($origLat - abs(lat))*pi()/180/2),2) + COS($origLat*pi()/180 )*COS(abs(lat)*pi()/180) *POWER(SIN(($origLon-lng)*pi()/180/2),2)))")));
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $jobTableName . '.job_id AND ' . $tableLocationName . '.resource_type = "sesjob_job" ', $asinSort);
      $select->where($tableLocationName . ".lng between ($origLon-$dist/abs(cos(radians($origLat))*69)) and ($origLon+$dist/abs(cos(radians($origLat))*69)) and " . $tableLocationName . ".lat between ($origLat-($dist/69)) and ($origLat+($dist/69))");
      $select->order('distance');
      $select->having("distance < $dist");
    }
    else {
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $jobTableName . '.job_id AND ' . $tableLocationName . '.resource_type = "sesjob_job" ', array('lat', 'lng'));
    }

    if( !empty($params['tag']) ) {
      $tmName = Engine_Api::_()->getDbtable('TagMaps', 'core')->info('name');
      $select->setIntegrityCheck(false)->joinLeft($tmName, "$tmName.resource_id = $jobTableName.job_id")
	    ->where($tmName.'.resource_type = ?', 'sesjob_job')
	    ->where($tmName.'.tag_id = ?', $params['tag']);
    }

    if (!empty($params['alphabet']) && $params['alphabet'] != 'all')
    $select->where($jobTableName . ".title LIKE ?", $params['alphabet'] . '%');

    $currentTime = date('Y-m-d H:i:s');
    if(isset($params['popularCol']) && !empty($params['popularCol'])) {
			if($params['popularCol'] == 'week') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
				$select->where("DATE(".$jobTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			elseif($params['popularCol'] == 'month') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$jobTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			else {
				$select = $select->order($jobTableName . '.' .$params['popularCol'] . ' DESC');
			}
    }

    if (isset($params['fixedData']) && !empty($params['fixedData']) && $params['fixedData'] != '')
    $select = $select->where($jobTableName . '.' . $params['fixedData'] . ' =?', 1);

    if (isset($params['featured']) && !empty($params['featured']))
    $select = $select->where($jobTableName . '.featured =?', 1);

    if (isset($params['hot']) && !empty($params['hot']))
    $select = $select->where($jobTableName . '.hot =?', 1);

    if (isset($params['verified']) && !empty($params['verified']))
    $select = $select->where($jobTableName . '.verified =?', 1);

    if (isset($params['sponsored']) && !empty($params['sponsored']))
    $select = $select->where($jobTableName . '.sponsored =?', 1);

    if (!empty($params['category_id']))
    $select = $select->where($jobTableName . '.category_id =?', $params['category_id']);

    if (!empty($params['subcat_id']))
    $select = $select->where($jobTableName . '.subcat_id =?', $params['subcat_id']);

    if (!empty($params['subsubcat_id']))
    $select = $select->where($jobTableName . '.subsubcat_id =?', $params['subsubcat_id']);

    if( isset($params['draft']) )
    $select->where($jobTableName.'.draft = ?', $params['draft']);

    if( !empty($params['text']) )
    $select->where($jobTableName.".title LIKE ? OR ".$jobTableName.".body LIKE ?", '%'.$params['text'].'%');

    if( !empty($params['date']) )
    $select->where("DATE_FORMAT(" . $jobTableName.".creation_date, '%Y-%m-%d') = ?", date('Y-m-d', strtotime($params['date'])));

		if( !empty($params['start_date']) )
    $select->where($jobTableName.".creation_date = ?", date('Y-m-d', $params['start_date']));

    if( !empty($params['end_date']) )
    $select->where($jobTableName.".creation_date < ?", date('Y-m-d', $params['end_date']));

    if( !empty($params['visible']) )
    $select->where($jobTableName.".search = ?", $params['visible']);

		if(!isset($params['manage-widget'])) {
			$select->where($jobTableName . ".publish_date <= '$currentTime' OR " . $jobTableName . ".publish_date = ''");
			$select->where($jobTableName.'.is_approved = ?',(bool) 1)->where($jobTableName.'.draft = ?',(bool) 0)->where($jobTableName.'.search = ?', (bool) 1);
			//check package query
			if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesjobpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjobpackage.enable.package', 1)){
				$order = Engine_Api::_()->getDbTable('orderspackages','sesjobpackage');
				$orderTableName = $order->info('name');
				$select->joinLeft($orderTableName, $orderTableName . '.orderspackage_id = ' . $jobTableName . '.orderspackage_id',null);
				$select->where($orderTableName . '.expiration_date  > "'.date("Y-m-d H:i:s").'" || expiration_date IS NULL || expiration_date = "0000-00-00 00:00:00"');
			}
		}else
			$select->where($jobTableName.'.owner_id = ?',$viewerId);

		if (isset($params['criteria'])) {
			if ($params['criteria'] == 1)
			$select->where($jobTableName . '.featured =?', '1');
			else if ($params['criteria'] == 2)
			$select->where($jobTableName . '.sponsored =?', '1');
			else if ($params['criteria'] == 3)
			$select->where($jobTableName . '.featured = 1 OR ' . $jobTableName . '.sponsored = 1');
			else if ($params['criteria'] == 4)
			$select->where($jobTableName . '.featured = 0 AND ' . $jobTableName . '.sponsored = 0');
			else if ($params['criteria'] == 6)
			$select->where($jobTableName . '.verified =?', '1');
			else if ($params['criteria'] == 7)
			$select->where($jobTableName . '.hot =?', '1');
		}

		if (isset($params['order']) && !empty($params['order'])) {
      if ($params['order'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(".$jobTableName.".creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['order'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$jobTableName.".creation_date) between ('$endTime') and ('$currentTime')");
      }
    }

    if (isset($params['widgetName']) && !empty($params['widgetName']) && $params['widgetName'] == 'Similar Jobs') {
      if(!empty($params['widgetName'])) {
        $select->where($jobTableName.'.category_id =?', $params['category_id']);
      }
    }

		if(isset($params['similar_job']))
		$select->where($jobTableName . '.parent_id =?', $params['job_id']);

		if (isset($customFields['has_photo']) && !empty($customFields['has_photo'])) {
      $select->where($jobTableName . '.photo_id != ?', "0");
    }

		if (isset($params['criteria'])) {
			switch ($params['info']) {
				case 'recently_created':
					$select->order($jobTableName . '.creation_date DESC');
					break;
				case 'most_viewed':
					$select->order($jobTableName . '.view_count DESC');
					break;
				case 'most_liked':
					$select->order($jobTableName . '.like_count DESC');
					break;
				case 'most_favourite':
					$select->order($jobTableName . '.favourite_count DESC');
					break;
				case 'most_commented':
					$select->order($jobTableName . '.comment_count DESC');
					break;
				case 'most_rated':
					$select->order($jobTableName . '.rating DESC');
					break;
				case 'random':
					$select->order('Rand()');
					break;
			}
		}
		if(!empty($params['getjob']))	{
			$select->where($jobTableName.".title LIKE ? OR ".$jobTableName.".body LIKE ?", '%'.$params['textSearch'].'%')->where($jobTableName.".search = ?", 1);
		}

    //don't show other module jobs
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.other.modulejobs', 1) && empty($params['resource_type'])) {
      $select->where($jobTableName . '.resource_type IS NULL')
              ->where($jobTableName . '.resource_id =?', 0);
    } else if (!empty($params['resource_type']) && !empty($params['resource_id'])) {
      $select->where($jobTableName . '.resource_type =?', $params['resource_type'])
              ->where($jobTableName . '.resource_id =?', $params['resource_id']);
    } else if(!empty($params['resource_type'])) {
      $select->where($jobTableName . '.resource_type =?', $params['resource_type']);
    }
    //don't show other module jobs
//echo $select;die;
    $select->order( !empty($params['orderby']) ? $params['orderby'].' DESC' : $jobTableName.'.creation_date DESC' );
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

  public function getJob($params = array()) {

    $table = Engine_Api::_()->getDbtable('jobs', 'sesjob');
    $jobTableName = $table->info('name');
    $select = $table->select()
                    ->where($jobTableName.'.draft = ?', 0)
                    ->where($jobTableName.".title LIKE ? OR ".$jobTableName.".body LIKE ?", '%'.$params['text'].'%')
                    ->where($jobTableName.".search = ?", 1)
                    ->order('creation_date DESC');

    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.other.modulejobs', 1) && empty($params['resource_type'])) {
      $select->where($jobTableName . '.resource_type IS NULL')->where($jobTableName . '.resource_id =?', 0);
    }

    return $this->fetchAll($select);
  }

  /**
   * Returns an array of dates where a given user created a sesjob entry
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
        ->order('job_id DESC')
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
	      ->from($this->info('name'), 'job_id')
	      ->where('offtheday =?', 1)
	      ->where('starttime <= DATE(NOW())')
	      ->where('endtime >= DATE(NOW())')
	      ->order('RAND()')
	      ->query()
	      ->fetchColumn();
  }

  public function checkCustomUrl($value = '', $job_id = '') {
    $select = $this->select('job_id')->where('custom_url = ?', $value);
    if ($job_id)
      $select->where('job_id !=?', $job_id);
    return $select->query()->fetchColumn();
  }

  public function getJobId($slug = null) {
    if ($slug) {
      $tableName = $this->info('name');
      $select = $this->select()
      ->from($tableName)
      ->where($tableName . '.custom_url = ?', $slug);
      $row = $this->fetchRow($select);
      if (empty($row)) {
      $job_id = $slug;
      } else
      $job_id = $row->job_id;
      return $job_id;
    }
    return '';
  }
}
