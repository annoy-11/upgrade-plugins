<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Crosssells.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Crosssells extends Engine_Db_Table {

    function create($params = array()){
        $row = $this->createRow();
        $row->setFromArray($params);
        $row->save();
    }
    function getSells($params = array()){
      $select = $this->select()->where('product_id =?',$params['product_id']);
      return $this->fetchAll($select);
    }


 public function getCrosssellPaginator($params = array(), $customFields = array()) {

    $paginator = Zend_Paginator::factory($this->getSesproductsSelect($params, $customFields));
    if( !empty($params['page']) )
    $paginator->setCurrentPageNumber($params['page']);
    if( !empty($params['limit']) )
    $paginator->setItemCountPerPage($params['limit']);

    if( empty($params['limit']) ) {
      $page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.page', 10);
      $paginator->setItemCountPerPage($page);
    }

    return $paginator;
  }


  public function getSesproductsSelect($params = array(), $customFields = array()) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $tableLocationName = Engine_Api::_()->getDbtable('locations', 'sesbasic')->info('name');
    $productTable = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct');

    $productTableName = $productTable->info('name');
    $select = $productTable->select()->setIntegrityCheck(false)->from($productTableName);

    if( !empty($params['store_id']) && is_numeric($params['store_id']) )
    $select->where($productTableName.'.store_id = ?', $params['store_id']);

    if( !empty($params['title']))
       $select->where($productTableName . ".title LIKE ?", $params['title'] . '%');

    if( !empty($params['user_id']) && is_numeric($params['user_id']) )
    $select->where($productTableName.'.owner_id = ?', $params['user_id']);

    if(isset($params['parent_type']))
      $select->where($productTableName.'.parent_type = ?', $params['parent_type']);

    if(!empty($params['user']) && $params['user'] instanceof User_Model_User )
        $select->where($productTableName.'.owner_id = ?', $params['user']->getIdentity());

    if(!empty($params['user']) && $params['user'] instanceof User_Model_User )
        $select->where($productTableName.'.owner_id = ?', $params['user']->getIdentity());

    if (isset($params['show']) && $params['show'] == 2 && $viewer->getIdentity()) {
      $users = $viewer->membership()->getMembershipsOfIds();
      if ($users)
      $select->where($productTableName . '.owner_id IN (?)', $users);
      else
      $select->where($productTableName . '.owner_id IN (?)', 0);
    }
     if (isset($params['wishlist_id'])) {
          $wishlistTable = Engine_Api::_()->getDbtable('wishlists', 'sesproduct');
           $wishlistTableName = $wishlistTable->info('name');
            $select->joinLeft($wishlistTableName, $wishlistTableName . '.product_id = ' . $productTableName . '.product_id',null)
            ->where($wishlistTableName.'.wishlist_id = ?',$params['wishlist_id']);
     }

    if(empty($params['miles']))
    $params['miles'] = 200;

    if (isset($params['lat']) && isset($params['miles']) && $params['miles'] != 0 && isset($params['lng']) && $params['lat'] != '' && $params['lng'] != '' && ((isset($params['location']) && $params['location'] != '' && strtolower($params['location']) != 'world'))) {
      $origLat = $params['lat'];
      $origLon = $params['lng'];
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.search.type', 1) == 1)
       $searchType = 3956;
      else
      $searchType = 6371;
      //This is the maximum distance (in miles) away from $origLat, $origLon in which to search
      $dist = $params['miles'];
      $asinSort = array('lat', 'lng', 'distance' => new Zend_Db_Expr(($searchType . " * 2 * ASIN(SQRT( POWER(SIN(($origLat - abs(lat))*pi()/180/2),2) + COS($origLat*pi()/180 )*COS(abs(lat)*pi()/180) *POWER(SIN(($origLon-lng)*pi()/180/2),2)))")));
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $productTableName . '.product_id AND ' . $tableLocationName . '.resource_type = "sesproduct" ', $asinSort);
      $select->where($tableLocationName . ".lng between ($origLon-$dist/abs(cos(radians($origLat))*69)) and ($origLon+$dist/abs(cos(radians($origLat))*69)) and " . $tableLocationName . ".lat between ($origLat-($dist/69)) and ($origLat+($dist/69))");
      $select->order('distance');
      $select->having("distance < $dist");
    }
    else {
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $productTableName . '.product_id AND ' . $tableLocationName . '.resource_type = "sesproduct" ', array('lat', 'lng'));
    }

    if( !empty($params['tag']) ) {
      $tmName = Engine_Api::_()->getDbtable('TagMaps', 'core')->info('name');
      $select->setIntegrityCheck(false)->joinLeft($tmName, "$tmName.resource_id = $productTableName.product_id")
	    ->where($tmName.'.resource_type = ?', 'sesproduct')
	    ->where($tmName.'.tag_id = ?', $params['tag']);
    }

    if (!empty($params['alphabet']) && $params['alphabet'] != 'all')
    $select->where($productTableName . ".title LIKE ?", $params['alphabet'] . '%');

    $currentTime = date('Y-m-d H:i:s');
    if(isset($params['popularCol']) && !empty($params['popularCol'])) {
			if($params['popularCol'] == 'week') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
				$select->where("DATE(".$productTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			elseif($params['popularCol'] == 'month') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$productTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			else {
				$select = $select->order($productTableName . '.' .$params['popularCol'] . ' DESC');
			}
    }

    if (isset($params['fixedData']) && !empty($params['fixedData']) && $params['fixedData'] != '')
    $select = $select->where($productTableName . '.' . $params['fixedData'] . ' =?', 1);

    if (isset($params['featured']) && !empty($params['featured']))
    $select = $select->where($productTableName . '.featured =?', 1);

    if (isset($params['verified']) && !empty($params['verified']))
    $select = $select->where($productTableName . '.verified =?', 1);

    if (isset($params['sponsored']) && !empty($params['sponsored']))
    $select = $select->where($productTableName . '.sponsored =?', 1);

    if (!empty($params['category_id']))
        $select = $select->where($productTableName . '.category_id =?', $params['category_id']);

    if (!empty($params['subcat_id']))
    $select = $select->where($productTableName . '.subcat_id =?', $params['subcat_id']);

    if (!empty($params['subsubcat_id']))
    $select = $select->where($productTableName . '.subsubcat_id =?', $params['subsubcat_id']);

    if( isset($params['draft']) )
    $select->where($productTableName.'.draft = ?', $params['draft']);

    if( !empty($params['text']) )
    $select->where($productTableName.".title LIKE ? OR ".$productTableName.".body LIKE ?", '%'.$params['text'].'%');

    if( !empty($params['date']) )
    $select->where("DATE_FORMAT(" . $productTableName.".creation_date, '%Y-%m-%d') = ?", date('Y-m-d', strtotime($params['date'])));

		if( !empty($params['start_date']) )
    $select->where($productTableName.".creation_date = ?", date('Y-m-d', $params['start_date']));

    if( !empty($params['end_date']) )
    $select->where($productTableName.".creation_date < ?", date('Y-m-d', $params['end_date']));

    if( !empty($params['visible']) )
    $select->where($productTableName.".search = ?", $params['visible']);

		if(!isset($params['manage-widget'])) {
			$select->where($productTableName . ".starttime <= '$currentTime' OR " . $productTableName . ".starttime IS NULL");
			$select->where($productTableName.'.is_approved = ?',(bool) 1)->where($productTableName.'.search = ?', (bool) 1);
			//check package query
			if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesproductpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproductpackage.enable.package', 1)){
				$order = Engine_Api::_()->getDbTable('orderspackages','sesproductpackage');
				$orderTableName = $order->info('name');
				$select->joinLeft($orderTableName, $orderTableName . '.orderspackage_id = ' . $productTableName . '.orderspackage_id',null);
				$select->where($orderTableName . '.expiration_date  > "'.date("Y-m-d H:i:s").'" || expiration_date IS NULL || expiration_date = "0000-00-00 00:00:00"');
			}
		}else
			$select->where($productTableName.'.owner_id = ?',$viewerId);

		if (isset($params['criteria'])) {
			if ($params['criteria'] == 1)
			$select->where($productTableName . '.featured =?', '1');
			else if ($params['criteria'] == 2)
			$select->where($productTableName . '.sponsored =?', '1');
			else if ($params['criteria'] == 3)
			$select->where($productTableName . '.featured = 1 OR ' . $productTableName . '.sponsored = 1');
			else if ($params['criteria'] == 4)
			$select->where($productTableName . '.featured = 0 AND ' . $productTableName . '.sponsored = 0');
			else if ($params['criteria'] == 6)
			$select->where($productTableName . '.verified =?', '1');
			else if ($params['criteria'] == 7)
			$select->where($productTableName . '.discount =?', '1');
		}

		if (isset($params['order']) && !empty($params['order'])) {
      if ($params['order'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(".$productTableName.".creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['order'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$productTableName.".creation_date) between ('$endTime') and ('$currentTime')");
      }
    }

    if (isset($params['widgetName']) && !empty($params['widgetName']) && $params['widgetName'] == 'Similar Products') {
      if(!empty($params['widgetName'])) {
        $select->where($productTableName.'.category_id =?', $params['category_id']);
      }
    }

		if(isset($params['similar_product']))
		$select->where($productTableName . '.parent_id =?', $params['product_id']);

		if (isset($customFields['has_photo']) && !empty($customFields['has_photo'])) {
      $select->where($productTableName . '.photo_id != ?', "0");
    }

		if (isset($params['criteria'])) {
			switch ($params['info']) {
				case 'recently_created':
					$select->order($productTableName . '.creation_date DESC');
					break;
				case 'most_viewed':
					$select->order($productTableName . '.view_count DESC');
					break;
				case 'most_liked':
					$select->order($productTableName . '.like_count DESC');
					break;
				case 'most_favourite':
					$select->order($productTableName . '.favourite_count DESC');
					break;
				case 'most_commented':
					$select->order($productTableName . '.comment_count DESC');
					break;
				case 'most_rated':
					$select->order($productTableName . '.rating DESC');
					break;
                case 'brand':
					$select->order($productTableName . '.brand DESC');
					break;
                case 'discount':
                    $select->order($productTableName . '.discount DESC');
					break;
                case 'cheapest':
                    $select->where($productTableName . '.price DESC');
					break;
                case 'popular':
                    $select->where($productTableName . '.view_count DESC');
					break;
                case 'category':
                    $select->where($productTableName . '.category_id DESC');
					break;
                case 'myProduct':
                    $select->where($productTableName.'.owner_id = ?',$viewerId);
                    $select->where($productTableName . '.product_id DESC');
					break;
				case 'random':
					$select->order('Rand()');
					break;
			}
		}
		if(!empty($params['getproduct']))	{
			$select->where($productTableName.".title LIKE ? OR ".$productTableName.".body LIKE ?", '%'.$params['textSearch'].'%')->where($productTableName.".search = ?", 1);
		}

    //don't show other module products
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.other.moduleproducts', 1) && empty($params['resource_type'])) {
      $select->where($productTableName . '.resource_type IS NULL')
              ->where($productTableName . '.resource_id =?', 0);
    } else if (!empty($params['resource_type']) && !empty($params['resource_id'])) {
      $select->where($productTableName . '.resource_type =?', $params['resource_type'])
              ->where($productTableName . '.resource_id =?', $params['resource_id']);
    } else if(!empty($params['resource_type'])) {
      $select->where($productTableName . '.resource_type =?', $params['resource_type']);
    }
    //don't show other module products

    $select->order( !empty($params['orderby']) ? $params['orderby'].' DESC' : $productTableName.'.creation_date DESC' );

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
}
