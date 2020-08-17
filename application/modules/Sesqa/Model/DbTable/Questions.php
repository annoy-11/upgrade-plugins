<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Questions.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesqa_Model_DbTable_Questions extends Engine_Db_Table {

  protected $_rowClass = 'Sesqa_Model_Question';
  function getQuestionPaginator($params = array()){
      return Zend_Paginator::factory($this->getQuestions($params));
  }
  public function getQuestions($params = array()){
      $select = $this->select()->from($this->info('name'),'*');
      $tableName = $this->info('name');
      $tmTable = Engine_Api::_()->getDbtable('TagMaps', 'core');
      $tmName = $tmTable->info('name');
      
      $tableLocation = Engine_Api::_()->getDbtable('locations', 'sesbasic');
      $tableLocationName = $tableLocation->info('name');

      //Location Based search
      if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seslocation') && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslocationenable', 1) && empty($params['lat']) && !empty($_COOKIE['sesbasic_location_data'])) {
        $params['location'] = $_COOKIE['sesbasic_location_data'];
        $params['lat'] = $_COOKIE['sesbasic_location_lat'];
        $params['lng'] = $_COOKIE['sesbasic_location_lng'];
        $params['miles'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslocation.searchmiles', 50);
      }
      

      if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) {
        if (isset($params['lat']) && isset($params['miles']) && $params['miles'] != 0 && isset($params['lng']) && $params['lat'] != '' && $params['lng'] != '' && ((isset($params['location']) && $params['location'] != '') || isset($params['locationWidget']))) {
        
        $origLat = $lat = $params['lat'];
        $origLon = $long = $params['lng'];
        $select = $select->setIntegrityCheck(false);
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.search.type', 1) == 1) {
          $searchType = 3956;
        } else
          $searchType = 6371;
        $dist = $params['miles']; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search

          $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $tableName . '.question_id AND ' . $tableLocationName . '.resource_type = "sesqa_question" ', array('lat', 'lng', 'distance' => new Zend_Db_Expr($searchType." * 2 * ASIN(SQRT( POWER(SIN(($lat - lat) *  pi()/180 / 2), 2) +COS($lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(($long - lng) * pi()/180 / 2), 2) ))")));

        $rectLong1 = $long - $dist/abs(cos(deg2rad($lat))*69);
        $rectLong2 = $long + $dist/abs(cos(deg2rad($lat))*69);
        $rectLat1 = $lat-($dist/69);
        $rectLat2 = $lat+($dist/69);

        $select->where($tableLocationName . ".lng between $rectLong1 AND $rectLong2  and " . $tableLocationName . ".lat between $rectLat1 AND $rectLat2");
        $select->order('distance');
        $select->having("distance < $dist");
      }else if(Engine_Api::_()->getApi('settings', 'core')->getSetting('seslocation_enable', 0) && ((empty($params['locationEnable'])) || (!empty($params['locationEnable']) && $params['locationEnable'] != "no" )) && !empty($_COOKIE['seslocation_content_data'])){
        $locationData = json_decode($_COOKIE['seslocation_content_data'],true);
        $lat = $locationData['lat'];
        $long = $locationData['lng'];
        $dist = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslocation.search.miles', 50); // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
        $origLat = $lat ;
        $origLon = $long ;
        $select = $select->setIntegrityCheck(false);
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seslocation.search.type', 1) == 1) {
          $searchType = 3956;
        } else
          $searchType = 6371;

        $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $tableName . '.question_id AND ' . $tableLocationName . '.resource_type = "sesqa_question" ', array('lat', 'lng', 'distance' => new Zend_Db_Expr($searchType." * 2 * ASIN(SQRT( POWER(SIN(($lat - lat) *  pi()/180 / 2), 2) +COS($lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(($long - lng) * pi()/180 / 2), 2) ))")));
        $rectLong1 = $long - $dist/abs(cos(deg2rad($lat))*69);
        $rectLong2 = $long + $dist/abs(cos(deg2rad($lat))*69);
        $rectLat1 = $lat-($dist/69);
        $rectLat2 = $lat+($dist/69);
        $select->where($tableLocationName . ".lng between $rectLong1 AND $rectLong2  and " . $tableLocationName . ".lat between $rectLat1 AND $rectLat2");
        $select->order('distance');
        $select->having("distance < $dist");
      }
    } else {
      $select = $select->setIntegrityCheck(false);
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $tableName . '.question_id AND ' . $tableLocationName . '.resource_type = "sesqa_question" ', array('lat', 'lng'));
    }
    
    if(!empty($params['location']) && !Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) {
      $select->where('`' . $tableName . '`.`location` LIKE ?', '%' . $params['location'] . '%');
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

    if (!empty($params['tag_id'])) {
      $select
              ->joinLeft($tmName, "$tmName.resource_id = $tableName.question_id", NULL)
              ->where($tmName . '.resource_type = ?', 'sesqa_question')
              ->where($tmName . '.tag_id = ?', $params['tag_id']);
    }
    if (!empty($params['sameTag'])) {
      $select->joinLeft($tmName, "$tmName.resource_id=$tableName.question_id", null)
              ->where('resource_type = ?', 'sesqa_question')
              ->distinct(true)
              ->where('resource_id != ?', $params['sameTagresource_id'])
              ->where('tag_id IN(?)', $params['sameTagTag_id']);

    }

    if(!empty($params['notIn']))
      $select->where('question_id != ?',$params['notIn']);
    $viewer = Engine_Api::_()->user()->getViewer();
    if (isset($params['show']) && $params['show'] == 2 && $viewer->getIdentity()) {
      $users = $viewer->membership()->getMembershipsOfIds();
      if ($users)
        $select->where($tableName . '.owner_id IN (?)', $users);
      else
        $select->where($tableName . '.owner_id IN (?)', 0);
    }

    if (isset($params['show']) && !empty($params['show'])) {
      $currentTime = date('Y-m-d H:i:s');
      $tomorrow_date = date("Y-m-d H:i:s", strtotime("+ 1 day"));
      $nextWeekDate = date("Y-m-d H:i:s", strtotime("+ 7 day"));
      if ($params['show'] == 'week') {
        $select->where("((YEARWEEK(creation_date) = YEARWEEK('$currentTime')))");
      } elseif ($params['show'] == 'today') {
        $select->where("$tableName.creation_date LIKE '%".date('Y-m-d',strtotime($currentTime))."%'");
      }  elseif ($params['show'] == 'month') {
        $select->where("((YEAR(creation_date) = YEAR('$currentTime')) AND (MONTH(creation_date) = MONTH('$currentTime')))");
      } 
      //else
        //$select = $select->order($tableName . '.' .$params['show'] . ' DESC');
    }
    if(!empty($params['fixedColumn'])){
      if($params['fixedColumn'] != "new"){
        $select->where($tableName.'.'.$params['fixedColumn'].' =?',1)  ;
      }else{
         $newSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_new_label', 5);
         $enableNewSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_enable_newLabel', 1);
         if($enableNewSetting){
            $select->where('CURDATE() < DATE_ADD(('.$tableName.'.creation_date), INTERVAL '.$newSetting.' DAY)');
         }
      }
    }
    if (isset($params['starttime']) && isset($params['endtime']))
      $select->where("DATE_FORMAT(" . $tableName . ".creation_date, '%Y-%m-%d') between ('" . date('Y-m-d', strtotime($params["starttime"])) . "') and ('" . date('Y-m-d', strtotime($params["endtime"])) . "')");
      if(!empty($params['user_id'])){
        $select->where('owner_id =?',$params['user_id']);
      }
      if(empty($params['managePage'])){
        $select->where('search =?',1)
                ->where('draft =?',1)
                ->where('approved =?', 1);
      }
      if(!empty($params['category_id'])){
        $select->where('category_id =?',$params['category_id']);
      }

      if(!empty($params['subcat_id'])){
        $select->where('subcat_id =?',$params['subcat_id']);
      }
      if(!empty($params['contentCriteria'])){
        $select->where('open_close =?',$params['contentCriteria']);
      }
      if(!empty($params['offtheday'])){
        $select->where('offtheday =?', 1)
            ->where('starttime <= DATE(NOW())')
            ->where('endtime >= DATE(NOW())');
      }
      if (isset($params['criteria'])) {
        if ($params['criteria'] == 1)
          $select->where($tableName . '.featured =?', '1');
        else if ($params['criteria'] == 2)
          $select->where($tableName . '.sponsored =?', '1');
        else if ($params['criteria'] == 6)
          $select->where($tableName . '.verified =?', '1');
        else if ($params['criteria'] == 7)
          $select->where($tableName . '.hot =?', '1');
        else if ($params['criteria'] == 3)
          $select->where($tableName . '.featured = 1 AND ' . $tableName . '.sponsored = 1');
        else if ($params['criteria'] == 4)
          $select->where($tableName . '.featured = 0 AND ' . $tableName . '.sponsored = 0');
      }

      if (isset($params['info'])) {
      switch ($params['info']) {
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
          $select->order($tableName . '.view_count DESC');
          break;
        case "favourite_count":
          $select->order($tableName . '.favourite_count DESC');
          break;
        case "most_answered":
          $select->order($tableName . '.answer_count DESC');
          break;
        case "most_favourite":
          $select->order($tableName . '.favourite_count DESC');
          break;
        case 'random':
          $select->order('Rand()');
          break;
        case "sponsored" :
          $select->where($tableName . '.sponsored' . ' = 1')
                  ->order($tableName . '.contest_id DESC');
          break;
        case "hot" :
          $select->where($tableName . '.hot' . ' = 1')
                  ->order($tableName . '.contest_id DESC');
          break;
        case "featured" :
          $select->where($tableName . '.featured' . ' = 1')
                  ->order($tableName . '.contest_id DESC');
          break;
        case "creation_date":
          $select->order($tableName . '.creation_date DESC');
          break;
        case "modified_date":
          $select->order($tableName . '.modified_date DESC');
          break;
      }
    }
    
      if(!empty($params['alphabet']) && $params['alphabet'] != "all")
        $select->where($tableName.'.title LIKE "%'.$params['alphabet'].'%"');
      if(!empty($params['limit']))
        $select->limit($params['limit']);
      if(!empty($params['subsubcat_id'])){
        $select->where('subsubcat_id =?',$params['subsubcat_id']);
      }
      if(!empty($params['searchText'])){
        $select->where('title LIKE ("%'.$params['searchText'].'%")');
      }
      if(!empty($params['user_id'])){
        $select->where('owner_id =?',$params['user_id']);
      }
      
      if(!empty($params['popularCol']) && $params['popularCol'] != "unanswered"){
        $select->order($params['popularCol'].' DESC');
      }else if(!empty($params['popularCol']) && $params['popularCol'] == "unanswered"){
        $select->where('answer_count =?',0);
      }
      
      if(!empty($params['fetchAll'])){
        return $this->fetchAll($select);
      }
	
      return $select;
  }

}
