<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Recipes.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Model_DbTable_Recipes extends Engine_Db_Table {

  protected $_rowClass = "Sesrecipe_Model_Recipe";
  
  /**
   * Gets a paginator for sesrecipes
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getSesrecipesPaginator($params = array(), $customFields = array()) {
  
    $paginator = Zend_Paginator::factory($this->getSesrecipesSelect($params, $customFields));
    if( !empty($params['page']) )
    $paginator->setCurrentPageNumber($params['page']);
    if( !empty($params['limit']) )
    $paginator->setItemCountPerPage($params['limit']);

    if( empty($params['limit']) ) {
      $page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.page', 10);
      $paginator->setItemCountPerPage($page);
    }

    return $paginator;
  }
  
  /**
   * Gets a select object for the user's sesrecipe entries
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Db_Table_Select
   */
  public function getSesrecipesSelect($params = array(), $customFields = array()) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $tableLocationName = Engine_Api::_()->getDbtable('locations', 'sesbasic')->info('name');
    $recipeTable = Engine_Api::_()->getDbtable('recipes', 'sesrecipe');
    $recipeTableName = $recipeTable->info('name');
    $select = $recipeTable->select()->setIntegrityCheck(false)->from($recipeTableName);
      
    if( !empty($params['user_id']) && is_numeric($params['user_id']) )
    $select->where($recipeTableName.'.owner_id = ?', $params['user_id']);
    
    if(isset($params['parent_type'])) 
      $select->where($recipeTableName.'.parent_type = ?', $params['parent_type']);
    
    if( !empty($params['user']) && $params['user'] instanceof User_Model_User ) 
    $select->where($recipeTableName.'.owner_id = ?', $params['user']->getIdentity());

    if (isset($params['show']) && $params['show'] == 2 && $viewer->getIdentity()) {
      $users = $viewer->membership()->getMembershipsOfIds();
      if ($users)
      $select->where($recipeTableName . '.owner_id IN (?)', $users);
      else
      $select->where($recipeTableName . '.owner_id IN (?)', 0);
    }

    if(empty($params['miles']))
    $params['miles'] = 200;
    
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) {
    
      if (isset($params['lat']) && isset($params['miles']) && $params['miles'] != 0 && isset($params['lng']) && $params['lat'] != '' && $params['lng'] != '' && ((isset($params['location']) && $params['location'] != '' && strtolower($params['location']) != 'world'))) {
        $origLat = $params['lat'];
        $origLon = $params['lng'];
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.search.type', 1) == 1) 
        $searchType = 3956;
        else
        $searchType = 6371;
        //This is the maximum distance (in miles) away from $origLat, $origLon in which to search
        $dist = $params['miles'];
        $asinSort = array('lat', 'lng', 'distance' => new Zend_Db_Expr(($searchType . " * 2 * ASIN(SQRT( POWER(SIN(($origLat - abs(lat))*pi()/180/2),2) + COS($origLat*pi()/180 )*COS(abs(lat)*pi()/180) *POWER(SIN(($origLon-lng)*pi()/180/2),2)))")));
        $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $recipeTableName . '.recipe_id AND ' . $tableLocationName . '.resource_type = "sesrecipe_recipe" ', $asinSort);
        $select->where($tableLocationName . ".lng between ($origLon-$dist/abs(cos(radians($origLat))*69)) and ($origLon+$dist/abs(cos(radians($origLat))*69)) and " . $tableLocationName . ".lat between ($origLat-($dist/69)) and ($origLat+($dist/69))");
        $select->order('distance');
        $select->having("distance < $dist");
      }
      else {
        $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $recipeTableName . '.recipe_id AND ' . $tableLocationName . '.resource_type = "sesrecipe_recipe" ', array('lat', 'lng'));
      }
    } else {
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $recipeTableName . '.recipe_id AND ' . $tableLocationName . '.resource_type = "sesrecipe_recipe" ', array('lat', 'lng'));
    }
    
    if(!empty($params['location']) && !Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) {
      $select->where('`' . $recipeTableName . '`.`location` LIKE ?', '%' . $params['location'] . '%');
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

    if( !empty($params['tag']) ) {
      $tmName = Engine_Api::_()->getDbtable('TagMaps', 'core')->info('name');
      $select->setIntegrityCheck(false)->joinLeft($tmName, "$tmName.resource_id = $recipeTableName.recipe_id")
	    ->where($tmName.'.resource_type = ?', 'sesrecipe_recipe')
	    ->where($tmName.'.tag_id = ?', $params['tag']);
    }
  
    if (!empty($params['alphabet']) && $params['alphabet'] != 'all')
    $select->where($recipeTableName . ".title LIKE ?", $params['alphabet'] . '%');
        
    $currentTime = date('Y-m-d H:i:s');
    if(isset($params['popularCol']) && !empty($params['popularCol'])) {
			if($params['popularCol'] == 'week') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
				$select->where("DATE(".$recipeTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			elseif($params['popularCol'] == 'month') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$recipeTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			else {
				$select = $select->order($recipeTableName . '.' .$params['popularCol'] . ' DESC');
			}
    }

    if (isset($params['fixedData']) && !empty($params['fixedData']) && $params['fixedData'] != '')
    $select = $select->where($recipeTableName . '.' . $params['fixedData'] . ' =?', 1);
    
    if (isset($params['featured']) && !empty($params['featured']))
    $select = $select->where($recipeTableName . '.featured =?', 1);
    
    if (isset($params['verified']) && !empty($params['verified']))
    $select = $select->where($recipeTableName . '.verified =?', 1);

    if (isset($params['sponsored']) && !empty($params['sponsored']))
    $select = $select->where($recipeTableName . '.sponsored =?', 1);

    if (!empty($params['category_id']))
    $select = $select->where($recipeTableName . '.category_id =?', $params['category_id']);

    if (!empty($params['subcat_id']))
    $select = $select->where($recipeTableName . '.subcat_id =?', $params['subcat_id']);

    if (!empty($params['subsubcat_id']))
    $select = $select->where($recipeTableName . '.subsubcat_id =?', $params['subsubcat_id']);
      
    if( isset($params['draft']) ) 
    $select->where($recipeTableName.'.draft = ?', $params['draft']);

    if( !empty($params['text']) )
    $select->where($recipeTableName.".title LIKE ? OR ".$recipeTableName.".body LIKE ?", '%'.$params['text'].'%');
   
    if( !empty($params['date']) ) 
    $select->where("DATE_FORMAT(" . $recipeTableName.".creation_date, '%Y-%m-%d') = ?", date('Y-m-d', strtotime($params['date'])));
		
		if( !empty($params['start_date']) ) 
    $select->where($recipeTableName.".creation_date = ?", date('Y-m-d', $params['start_date']));
		
    if( !empty($params['end_date']) ) 
    $select->where($recipeTableName.".creation_date < ?", date('Y-m-d', $params['end_date']));
    
    if( !empty($params['visible']) )
    $select->where($recipeTableName.".search = ?", $params['visible']);

		if(!isset($params['manage-widget'])) {
			$select->where($recipeTableName . ".publish_date <= '$currentTime' OR " . $recipeTableName . ".publish_date = ''");
			$select->where($recipeTableName.'.is_approved = ?',(bool) 1)->where($recipeTableName.'.search = ?', (bool) 1);
			//check package query
			if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesrecipepackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipepackage.enable.package', 1)){
				$order = Engine_Api::_()->getDbTable('orderspackages','sesrecipepackage');
				$orderTableName = $order->info('name');
				$select->joinLeft($orderTableName, $orderTableName . '.orderspackage_id = ' . $recipeTableName . '.orderspackage_id',null);
				$select->where($orderTableName . '.expiration_date  > "'.date("Y-m-d H:i:s").'" || expiration_date IS NULL || expiration_date = "0000-00-00 00:00:00"');
			}
		}else
			$select->where($recipeTableName.'.owner_id = ?',$viewerId);
		
		if (isset($params['criteria'])) {
			if ($params['criteria'] == 1)
			$select->where($recipeTableName . '.featured =?', '1');
			else if ($params['criteria'] == 2)
			$select->where($recipeTableName . '.sponsored =?', '1');
			else if ($params['criteria'] == 3)
			$select->where($recipeTableName . '.featured = 1 OR ' . $recipeTableName . '.sponsored = 1');
			else if ($params['criteria'] == 4)
			$select->where($recipeTableName . '.featured = 0 AND ' . $recipeTableName . '.sponsored = 0');
			else if ($params['criteria'] == 6)
			$select->where($recipeTableName . '.verified =?', '1');
		}
		
		if (isset($params['order']) && !empty($params['order'])) {
      if ($params['order'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(".$recipeTableName.".creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['order'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$recipeTableName.".creation_date) between ('$endTime') and ('$currentTime')");
      }
    }
    
    if (isset($params['widgetName']) && !empty($params['widgetName']) && $params['widgetName'] == 'Similar Recipes') {
      if(!empty($params['widgetName'])) {
        $select->where($recipeTableName.'.category_id =?', $params['category_id']);
      }
    }
    
		if(isset($params['similar_recipe']))
		$select->where($recipeTableName . '.parent_id =?', $params['recipe_id']);
		
		if (isset($customFields['has_photo']) && !empty($customFields['has_photo'])) {
      $select->where($recipeTableName . '.photo_id != ?', "0");
    }
 
		if (isset($params['criteria'])) {
			switch ($params['info']) {
				case 'recently_created':
					$select->order($recipeTableName . '.creation_date DESC');
					break;
				case 'most_viewed':
					$select->order($recipeTableName . '.view_count DESC');
					break;
				case 'most_liked':
					$select->order($recipeTableName . '.like_count DESC');
					break;
				case 'most_favourite':
					$select->order($recipeTableName . '.favourite_count DESC');
					break;
				case 'most_commented':
					$select->order($recipeTableName . '.comment_count DESC');
					break;
				case 'most_rated':
					$select->order($recipeTableName . '.rating DESC');
					break;
				case 'random':
					$select->order('Rand()');
					break;
			}
		}
		if(!empty($params['getrecipe']))	{
			$select->where($recipeTableName.".title LIKE ? OR ".$recipeTableName.".body LIKE ?", '%'.$params['textSearch'].'%')->where($recipeTableName.".search = ?", 1);	
		}

    //don't show other module recipes
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.other.modulerecipes', 1) && empty($params['resource_type'])) {
      $select->where($recipeTableName . '.resource_type IS NULL')
              ->where($recipeTableName . '.resource_id =?', 0);
    } else if (!empty($params['resource_type']) && !empty($params['resource_id'])) {
      $select->where($recipeTableName . '.resource_type =?', $params['resource_type'])
              ->where($recipeTableName . '.resource_id =?', $params['resource_id']);
    } else if(!empty($params['resource_type'])) {
      $select->where($recipeTableName . '.resource_type =?', $params['resource_type']);
    }
    //don't show other module recipes
		
    $select->order( !empty($params['orderby']) ? $params['orderby'].' DESC' : $recipeTableName.'.creation_date DESC' );
    
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
  
  public function getRecipe($params = array()) {
  
    $table = Engine_Api::_()->getDbtable('recipes', 'sesrecipe');
    $recipeTableName = $table->info('name');
    $select = $table->select()
                    ->where($recipeTableName.'.draft = ?', 0)
                    ->where($recipeTableName.".title LIKE ? OR ".$recipeTableName.".body LIKE ?", '%'.$params['text'].'%')
                    ->where($recipeTableName.".search = ?", 1)
                    ->order('creation_date DESC');
                    
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.other.modulerecipes', 1) && empty($params['resource_type'])) {
      $select->where($recipeTableName . '.resource_type IS NULL')->where($recipeTableName . '.resource_id =?', 0);
    }
    
    return $this->fetchAll($select);
  }
  
  /**
   * Returns an array of dates where a given user created a sesrecipe entry
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
        ->order('recipe_id DESC')
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
	      ->from($this->info('name'), 'recipe_id')
	      ->where('offtheday =?', 1)
	      ->where('starttime <= DATE(NOW())')
	      ->where('endtime >= DATE(NOW())')
	      ->order('RAND()')
	      ->query()
	      ->fetchColumn();
  }
  
  public function checkCustomUrl($value = '', $recipe_id = '') {
    $select = $this->select('recipe_id')->where('custom_url = ?', $value);
    if ($recipe_id)
      $select->where('recipe_id !=?', $recipe_id);
    return $select->query()->fetchColumn();
  }
  
  public function getRecipeId($slug = null) {
    if ($slug) {
      $tableName = $this->info('name');
      $select = $this->select()
      ->from($tableName)
      ->where($tableName . '.custom_url = ?', $slug);
      $row = $this->fetchRow($select);
      if (empty($row)) {
      $recipe_id = $slug;
      } else
      $recipe_id = $row->recipe_id;
      return $recipe_id;
    }
    return '';
  }
}
