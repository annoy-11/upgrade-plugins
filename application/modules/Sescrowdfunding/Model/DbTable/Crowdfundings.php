<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Crowdfundings.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Model_DbTable_Crowdfundings extends Engine_Db_Table {

    protected $_rowClass = "Sescrowdfunding_Model_Crowdfunding";
    protected $_name = "sescrowdfunding_crowdfundings";

    public function getCrowdfundingId($slug = null) {

        if ($slug) {
            $tableName = $this->info('name');
            $select = $this->select()
                            ->from($tableName)
                            ->where($tableName . '.custom_url = ?', $slug);
            $row = $this->fetchRow($select);
            if (empty($row)) {
                $crowdfunding_id = $slug;
            } else
                $crowdfunding_id = $row->crowdfunding_id;
            return $crowdfunding_id;
        }
        return '';
    }

    public function getOfTheDayResults() {

        return $this->select()
                ->from($this->info('name'), 'crowdfunding_id')
                ->where('offtheday =?', 1)
                ->where('draft =?', 0)
                ->where('search =?', 1)
                ->where('approved =?', 1)
                ->where('startdate <= DATE(NOW())')
                ->where('enddate >= DATE(NOW())')
                ->order('RAND()')
                ->query()
                ->fetchColumn();
    }

    public function checkCustomUrl($value = '', $crowdfunding_id = '') {

        $select = $this->select('crowdfunding_id')->where('custom_url = ?', $value);
        if ($crowdfunding_id)
            $select->where('crowdfunding_id !=?', $crowdfunding_id);
        return $select->query()->fetchColumn();
    }

    public function countFaqs($params = array()) {

        $select = $this->select()->from($this->info('name'), array('*'))->where($this->info('name') . ".status = ?",1);

        if(isset($params['category_id'])) {
            $select->where('category_id =?', $params['category_id']);
        }

        if(isset($params['subcat_id'])) {
            $select->where('subcat_id =?', $params['subcat_id']);
        }

        if(isset($params['fetchAll'])){
            return  $this->fetchAll($select);
        }

        return Zend_Paginator::factory($select);
    }

  public function getSescrowdfundingsPaginator($params = array(), $customFields = array()) {

    $paginator = Zend_Paginator::factory($this->getSescrowdfundingsSelect($params, $customFields));
    if( !empty($params['page']) )
      $paginator->setCurrentPageNumber($params['page']);
    if( !empty($params['limit']) )
      $paginator->setItemCountPerPage($params['limit']);
    if( empty($params['limit']) ) {
      $page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.page', 10);
      $paginator->setItemCountPerPage($page);
    }

    return $paginator;
  }

  public function getSescrowdfundingsSelect($params = array(), $customFields = array()) {

        $viewer = Engine_Api::_()->user()->getViewer();
        $viewerId = $viewer->getIdentity();

        $tableLocationName = Engine_Api::_()->getDbtable('locations', 'sesbasic')->info('name');

        $crowdfundingTable = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding');
        $crowdfundingTableName = $crowdfundingTable->info('name');

        $select = $crowdfundingTable->select()
                                ->setIntegrityCheck(false)
                                ->from($crowdfundingTableName)
                                ->where('search =?', 1);

        if( !empty($params['user_id']) && is_numeric($params['user_id']) )
        $select->where($crowdfundingTableName.'.owner_id = ?', $params['user_id']);

        if( !empty($params['user']) && $params['user'] instanceof User_Model_User )
        $select->where($crowdfundingTableName.'.owner_id = ?', $params['user_id']->getIdentity());

        if (isset($params['show']) && $params['show'] == 2 && $viewer->getIdentity()) {
        $users = $viewer->membership()->getMembershipsOfIds();
        if ($users)
            $select->where($crowdfundingTableName . '.owner_id IN (?)', $users);
        else
            $select->where($crowdfundingTableName . '.owner_id IN (?)', 0);
        }

        if(empty($params['miles']))
        $params['miles'] = 200;

        if (isset($params['lat']) && isset($params['miles']) && $params['miles'] != 0 && isset($params['lng']) && $params['lat'] != '' && $params['lng'] != '' && ((isset($params['location']) && $params['location'] != '' && strtolower($params['location']) != 'world'))) {

        $origLat = $params['lat'];
        $origLon = $params['lng'];

        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.search.type', 1) == 1)
        $searchType = 3956;
        else
        $searchType = 6371;

        //This is the maximum distance (in miles) away from $origLat, $origLon in which to search
        $dist = $params['miles'];
        $asinSort = array('lat', 'lng', 'distance' => new Zend_Db_Expr(($searchType . " * 2 * ASIN(SQRT( POWER(SIN(($origLat - abs(lat))*pi()/180/2),2) + COS($origLat*pi()/180 )*COS(abs(lat)*pi()/180) *POWER(SIN(($origLon-lng)*pi()/180/2),2)))")));
        $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $crowdfundingTableName . '.crowdfunding_id AND ' . $tableLocationName . '.resource_type = "crowdfunding" ', $asinSort);
        $select->where($tableLocationName . ".lng between ($origLon-$dist/abs(cos(radians($origLat))*69)) and ($origLon+$dist/abs(cos(radians($origLat))*69)) and " . $tableLocationName . ".lat between ($origLat-($dist/69)) and ($origLat+($dist/69))");
        $select->order('distance');
        $select->having("distance < $dist");
        } else {
        $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $crowdfundingTableName . '.crowdfunding_id AND ' . $tableLocationName . '.resource_type = "crowdfunding" ', array('lat', 'lng'));
        }

        if( !empty($params['tag']) ) {

        $tmName = Engine_Api::_()->getDbtable('TagMaps', 'core')->info('name');
        $select->setIntegrityCheck(false)
                ->joinLeft($tmName, "$tmName.resource_id = $crowdfundingTableName.crowdfunding_id")
                ->where($tmName.'.resource_type = ?', 'crowdfunding')
                ->where($tmName.'.tag_id = ?', $params['tag']);
        }

        if (!empty($params['alphabet']) && $params['alphabet'] != 'all')
        $select->where($crowdfundingTableName . ".title LIKE ?", $params['alphabet'] . '%');

        $currentTime = date('Y-m-d H:i:s');
        if(isset($params['popularCol']) && !empty($params['popularCol'])) {

            if($params['popularCol'] == 'week') {
                $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
                $select->where("DATE(".$crowdfundingTableName.".creation_date) between ('$endTime') and ('$currentTime')");
            } elseif($params['popularCol'] == 'month') {
                $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
                $select->where("DATE(".$crowdfundingTableName.".creation_date) between ('$endTime') and ('$currentTime')");
            } else {
                $select = $select->order($crowdfundingTableName . '.' .$params['popularCol'] . ' DESC');
            }
        }

        if (isset($params['popularCol']) && !empty($params['popularCol']) && $params['popularCol'] == 'featured')
            $select = $select->where($crowdfundingTableName . '.featured =?', 1);

        if (isset($params['featured']) && !empty($params['featured']))
            $select = $select->where($crowdfundingTableName . '.featured =?', 1);

        if (!empty($params['category_id']))
            $select = $select->where($crowdfundingTableName . '.category_id =?', $params['category_id']);

        if (!empty($params['subcat_id']))
            $select = $select->where($crowdfundingTableName . '.subcat_id =?', $params['subcat_id']);

        if (!empty($params['subsubcat_id']))
            $select = $select->where($crowdfundingTableName . '.subsubcat_id =?', $params['subsubcat_id']);

        if(@$params['manage-widget'] != '1')
            $select->where($crowdfundingTableName.'.draft = ?', 0);

        if( !empty($params['text']) )
            $select->where($crowdfundingTableName.".title LIKE ? OR ".$crowdfundingTableName.".description LIKE ?", '%'.$params['text'].'%');

        if( !empty($params['date']) )
            $select->where("DATE_FORMAT(" . $crowdfundingTableName.".creation_date, '%Y-%m-%d') = ?", date('Y-m-d', strtotime($params['date'])));

        if( !empty($params['visible']) )
            $select->where($crowdfundingTableName.".search = ?", $params['visible']);

        if(!isset($params['manage-widget'])) {
            $select->where('approved =?', 1);
// 			$select->where($crowdfundingTableName . ".publish_date <= '$currentTime' OR " . $crowdfundingTableName . ".publish_date = ''");
// 			$select->where($crowdfundingTableName.'.search = ?', (bool) 1);
// 			//check package query
// 			if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sescrowdfundingpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingpackage.enable.package', 1)){
// 				$order = Engine_Api::_()->getDbTable('orderspackages','sescrowdfundingpackage');
// 				$orderTableName = $order->info('name');
// 				$select->joinLeft($orderTableName, $orderTableName . '.orderspackage_id = ' . $crowdfundingTableName . '.orderspackage_id',null);
// 				$select->where($orderTableName . '.expiration_date  > "'.date("Y-m-d H:i:s").'" || expiration_date IS NULL || expiration_date = "0000-00-00 00:00:00"');
// 			}
        } else {
            $select->where($crowdfundingTableName.'.owner_id = ?',$viewerId);
        }
        
        //don't show other module crowdfundings
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.other.modulecrowdfundings', 1) && empty($params['resource_type'])) {
          $select->where($crowdfundingTableName . '.resource_type IS NULL')
                  ->where($crowdfundingTableName . '.resource_id =?', 0);
        } else if (!empty($params['resource_type']) && !empty($params['resource_id'])) {
          $select->where($crowdfundingTableName . '.resource_type =?', $params['resource_type'])
                  ->where($crowdfundingTableName . '.resource_id =?', $params['resource_id']);
        } else if(!empty($params['resource_type'])) {
          $select->where($crowdfundingTableName . '.resource_type =?', $params['resource_type']);
        }
        //don't show other module crowdfundings

        if (isset($params['criteria'])) {
            if ($params['criteria'] == 1)
                $select->where($crowdfundingTableName . '.featured =?', '1');
            elseif ($params['criteria'] == 2)
                $select->where($crowdfundingTableName . '.sponsored =?', '1');
            elseif ($params['criteria'] == 3)
                $select->where($crowdfundingTableName . '.verified =?', '1');
            elseif ($params['criteria'] == 4)
                $select->where($crowdfundingTableName . '.featured = 0 AND ' . $crowdfundingTableName . '.sponsored = 0');
        }

        if (isset($params['order']) && !empty($params['order'])) {
            if ($params['order'] == 'week') {
                $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
                $select->where("DATE(".$crowdfundingTableName.".creation_date) between ('$endTime') and ('$currentTime')");
            } elseif ($params['order'] == 'month') {
                $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
                $select->where("DATE(".$crowdfundingTableName.".creation_date) between ('$endTime') and ('$currentTime')");
            }
            if(in_array($params['order'],array('view_count','comment_count','like_count')))
                 $select->order( !empty($params['orderby']) ? $params['orderby'].' DESC' :  $crowdfundingTableName.'.'.$params['order'].' DESC' );
        }

        if (isset($params['widgetName']) && !empty($params['widgetName']) && $params['widgetName'] == 'Similar Crowdfunding') {
        if(!empty($params['widgetName'])) {
            $select->where($crowdfundingTableName.'.category_id =?', $params['category_id']);
        }
        $select->where($crowdfundingTableName.'.crowdfunding_id !=?', $params['crowdfunding_id']);
        }

		if(isset($params['similar_crowdfunding']))
		$select->where($crowdfundingTableName . '.parent_id =?', $params['crowdfunding_id']);

		if (isset($customFields['has_photo']) && !empty($customFields['has_photo'])) {
            $select->where($crowdfundingTableName . '.photo_id != ?', "0");
        }

		if (isset($params['criteria'])) {
			switch ($params['info']) {
				case 'recently_created':
					$select->order($crowdfundingTableName . '.creation_date DESC');
					break;
				case 'most_viewed':
					$select->order($crowdfundingTableName . '.view_count DESC');
					break;
				case 'most_liked':
					$select->order($crowdfundingTableName . '.like_count DESC');
					break;
				case 'most_commented':
					$select->order($crowdfundingTableName . '.comment_count DESC');
					break;
				case 'most_rated':
					$select->order($crowdfundingTableName . '.rating DESC');
					break;
                case 'most_donated':
					$select->order($crowdfundingTableName . '.donate_count DESC');
					break;
				case 'random':
					$select->order('Rand()');
					break;
			}
		}

		if(!empty($params['getcrowdfunding']))	{
			$select->where($crowdfundingTableName.".title LIKE ? OR ".$crowdfundingTableName.".description LIKE ?", '%'.$params['textSearch'].'%')->where($crowdfundingTableName.".search = ?", 1);
		}

        $select->order( !empty($params['orderby']) ? $params['orderby'].' DESC' :  $crowdfundingTableName.'.creation_date DESC' );

        if(isset($params['limit_data']) && !empty($params['limit_data'])) {
            $select->limit($params['limit_data']);
        }

        if(isset($params['fetchAll'])) {
            return $this->fetchAll($select);
        } else {
            return $select;
        }
  }

}
