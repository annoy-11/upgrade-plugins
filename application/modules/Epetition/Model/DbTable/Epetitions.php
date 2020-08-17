<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Epetitions.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Model_DbTable_Epetitions extends Core_Model_Item_DbTable_Abstract
{
  protected $_rowClass = 'Epetition_Model_Epetition';
  protected $_name = 'epetition_petitions';

  /**
   * Gets a paginator for epetitions
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function countPages($userId = null) {
    $count = $this->select()->from($this->info('name'), array("COUNT(epetition_id)"));
    if ($userId)
      $count->where('owner_id =?', $userId);
    return $count->query()->fetchColumn();
  }


  public function getEpetitionsPaginator($params = array(), $customFields = array())
  {
    $paginator = Zend_Paginator::factory($this->getEpetitionsSelect($params, $customFields));
    if (!empty($params['page']))
      $paginator->setCurrentPageNumber($params['page']);
    if (!empty($params['limit']))
      $paginator->setItemCountPerPage($params['limit']);

    if (empty($params['limit'])) {
      $page = (int)Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.page', 10);
      $paginator->setItemCountPerPage($page);
    }

    return $paginator;
  }
  /**
   * Gets a Report Data for epetitions
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Return Report data
   */
  public function getReportData($params = array()) {

    $pageTableName = $this->info('name');
    $select = $this->select()
      ->from($pageTableName);
    if (isset($params['epetition_id']))
      $select->where($pageTableName . '.epetition_id =?', $params['epetition_id']);
    if (isset($params['type'])) {
      if ($params['type'] == 'month') {
        $select->where("DATE_FORMAT(" . $pageTableName . " .creation_date, '%Y-%m') <= ?", $params['enddate'])
          ->where("DATE_FORMAT(" . $pageTableName . " .creation_date, '%Y-%m') >= ?", $params['startdate'])
          ->group("$pageTableName.epetition_id")
          ->group("YEAR($pageTableName.creation_date)")
          ->group("MONTH($pageTableName.creation_date)");
      } else {
        $select->where("DATE_FORMAT(" . $pageTableName . " .creation_date, '%Y-%m-%d') <= ?", $params['enddate'])
          ->where("DATE_FORMAT(" . $pageTableName . " .creation_date, '%Y-%m-%d') >= ?", $params['startdate'])
          ->group("$pageTableName.epetition_id")
          ->group("YEAR($pageTableName.creation_date)")
          ->group("MONTH($pageTableName.creation_date)")
          ->group("DAY($pageTableName.creation_date)");
      }
    }
    return $this->fetchAll($select);
  }


  public  function getOwner($recurseType = NULL){
    return 	Engine_Api::_()->getItem('user', $this->owner_id);
  }


  /**
   * Gets a select object for the user's epetition entries
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Db_Table_Select
   */
  public function getEpetitionsSelect($params = array(), $customFields = array())
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $tableLocationName = Engine_Api::_()->getDbtable('locations', 'sesbasic')->info('name');
    $petitionTable = Engine_Api::_()->getDbtable('epetitions', 'epetition');
    $petitionTableName = $petitionTable->info('name');
    $select = $petitionTable->select()->setIntegrityCheck(false)->from($petitionTableName);


    if (!empty($params['user_id']) && is_numeric($params['user_id']))
    {  $select->where($petitionTableName . '.owner_id = ?', $params['user_id']); }
    if(isset($params['sort']) && $params['sort']=="open")
    {
      $select->where($petitionTableName . '.victory= ?','0');
      $params['sort']='recentlySPcreated';
      $params['orderby']='epetition_id';
      $params['popularCol']='epetition_id';
    }
    if(isset($params['sort']) && $params['sort']=="close")
    {
      $select->where($petitionTableName . '.victory= ?','2');
      $params['sort']='recentlySPcreated';
      $params['orderby']='epetition_id';
      $params['popularCol']='epetition_id';
    }
    if(isset($params['sort']) && $params['sort']=="onlySPvictory")
    {
      $select->where($petitionTableName . '.victory= ?','1');
      $params['sort']='recentlySPcreated';
      $params['orderby']='epetition_id';
      $params['popularCol']='epetition_id';
    }


    if (isset($params['parent_type']))
      $select->where($petitionTableName . '.parent_type = ?', $params['parent_type']);

    if (!empty($params['user']) && $params['user'] instanceof User_Model_User)
      $select->where($petitionTableName . '.owner_id = ?', $params['user']->getIdentity());

    if (isset($params['show']) && $params['show'] == 2 && $viewer->getIdentity()) {
      $users = $viewer->membership()->getMembershipsOfIds();
      if ($users)
        $select->where($petitionTableName . '.owner_id IN (?)', $users);
      else
        $select->where($petitionTableName . '.owner_id IN (?)', 0);
    }
    if (empty($params['miles']))
      $params['miles'] = 200;

    if (isset($params['lat']) && isset($params['miles']) && $params['miles'] != 0 && isset($params['lng']) && $params['lat'] != '' && $params['lng'] != '' && ((isset($params['location']) && $params['location'] != '' && strtolower($params['location']) != 'world'))) {
      $origLat = $params['lat'];
      $origLon = $params['lng'];
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.search.type', 1) == 1)
        $searchType = 3956;
      else
        $searchType = 6371;
      //This is the maximum distance (in miles) away from $origLat, $origLon in which to search
      $dist = $params['miles'];
      $asinSort = array('lat', 'lng', 'distance' => new Zend_Db_Expr(($searchType . " * 2 * ASIN(SQRT( POWER(SIN(($origLat - abs(lat))*pi()/180/2),2) + COS($origLat*pi()/180 )*COS(abs(lat)*pi()/180) *POWER(SIN(($origLon-lng)*pi()/180/2),2)))")));
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $petitionTableName . '.epetition_id AND ' . $tableLocationName . '.resource_type = "epetition" ', $asinSort);
      $select->where($tableLocationName . ".lng between ($origLon-$dist/abs(cos(radians($origLat))*69)) and ($origLon+$dist/abs(cos(radians($origLat))*69)) and " . $tableLocationName . ".lat between ($origLat-($dist/69)) and ($origLat+($dist/69))");
      $select->order('distance');
      $select->having("distance < $dist");
    } else {
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $petitionTableName . '.epetition_id AND ' . $tableLocationName . '.resource_type = "epetition" ', array('lat', 'lng'));
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
    if(!empty($params['location'])){
      $select->where('`' . $petitionTableName . '`.`location` LIKE ?', '%' . $params['location'] . '%');
    }
    
    if (!empty($params['tag'])) {
      $tmName = Engine_Api::_()->getDbtable('TagMaps', 'core')->info('name');
      $select->setIntegrityCheck(false)->joinLeft($tmName, "$tmName.resource_id = $petitionTableName.epetition_id")
        ->where($tmName . '.resource_type = ?', 'epetition')
        ->where($tmName . '.tag_id = ?', $params['tag']);
    }

    if (!empty($params['alphabet']) && $params['alphabet'] != 'all')
      $select->where($petitionTableName . ".title LIKE ?", $params['alphabet'] . '%');

    $currentTime = date('Y-m-d H:i:s');
    if (isset($params['popularCol']) && !empty($params['popularCol'])) {
      if ($params['popularCol'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(" . $petitionTableName . ".creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['popularCol'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(" . $petitionTableName . ".creation_date) between ('$endTime') and ('$currentTime')");
      } else {
        $select = $select->order($petitionTableName . '.' . $params['popularCol'] . ' DESC');
      }
    }

    if (isset($params['fixedData']) && !empty($params['fixedData']) && $params['fixedData'] != '')
      $select = $select->where($petitionTableName . '.' . $params['fixedData'] . ' =?', 1);

    if (isset($params['featured']) && !empty($params['featured']))
      $select = $select->where($petitionTableName . '.featured =?', 1);

    if (isset($params['verified']) && !empty($params['verified']))
      $select = $select->where($petitionTableName . '.verified =?', 1);

    if (isset($params['sponsored']) && !empty($params['sponsored']))
      $select = $select->where($petitionTableName . '.sponsored =?', 1);

    if (!empty($params['category_id']))
      $select = $select->where($petitionTableName . '.category_id =?', $params['category_id']);

    if (!empty($params['subcat_id']))
      $select = $select->where($petitionTableName . '.subcat_id =?', $params['subcat_id']);

    if (!empty($params['subsubcat_id']))
      $select = $select->where($petitionTableName . '.subsubcat_id =?', $params['subsubcat_id']);

	  if (isset($params['draft']))
      $select->where($petitionTableName . '.draft = ?', $params['draft']);

    if (!empty($params['text']))
      $select->where($petitionTableName . ".title LIKE ? OR " . $petitionTableName . ".body LIKE ?", '%' . $params['text'] . '%');

    if (!empty($params['date']))
      $select->where("DATE_FORMAT(" . $petitionTableName . ".creation_date, '%Y-%m-%d') = ?", date('Y-m-d', strtotime($params['date'])));

    if (!empty($params['start_date']))
      $select->where($petitionTableName . ".creation_date = ?", date('Y-m-d', $params['start_date']));

    if (!empty($params['end_date']))
      $select->where($petitionTableName . ".creation_date < ?", date('Y-m-d', $params['end_date']));

    if (!empty($params['visible']))
      $select->where($petitionTableName . ".search = ?", $params['visible']);

    $select->where("DATE_FORMAT(starttime, '%Y %m %d %H:%i:%s') <= ? OR starttime is null", date("Y-m-d H:i:s"));
    if (!isset($params['manage-widget'])) {
      //$select->where($petitionTableName . ".starttime <= '$currentTime' OR " . $petitionTableName . ".starttime = ''");
	    { $select->where($petitionTableName . '.is_approved = ?', (bool)1)->where($petitionTableName . '.draft = ?', (bool)0)->where($petitionTableName . '.search = ?', (bool)1); }
      //check package query
      if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('epetitionpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetitionpackage.enable.package', 1)) {
        $order = Engine_Api::_()->getDbTable('orderspackages', 'epetitionpackage');
        $orderTableName = $order->info('name');
        $select->joinLeft($orderTableName, $orderTableName . '.orderspackage_id = ' . $petitionTableName . '.orderspackage_id', null);
        $select->where($orderTableName . '.expiration_date  > "' . date("Y-m-d H:i:s") . '" || expiration_date IS NULL || expiration_date = "0000-00-00 00:00:00"');
      }
    } else
      $select->where($petitionTableName . '.owner_id = ?', $viewerId);

    if (isset($params['criteria'])) {
      if ($params['criteria'] == 1)
        $select->where($petitionTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($petitionTableName . '.sponsored =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($petitionTableName . '.featured = 1 AND ' . $petitionTableName . '.sponsored = 1');
      else if ($params['criteria'] == 4)
        $select->where($petitionTableName . '.featured = 0 AND ' . $petitionTableName . '.sponsored = 0');
      else if ($params['criteria'] == 6)
        $select->where($petitionTableName . '.verified =?', '1');
    }

    if (isset($params['order']) && !empty($params['order'])) {
      if ($params['order'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(" . $petitionTableName . ".creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['order'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(" . $petitionTableName . ".creation_date) between ('$endTime') and ('$currentTime')");
      }
    }

    if (isset($params['widgetName']) && !empty($params['widgetName']) && $params['widgetName'] == 'Similar Petitions') {
      if (!empty($params['widgetName'])) {
        $select->where($petitionTableName . '.category_id =?', $params['category_id']);
      }
    }

    if (isset($params['similar_petition']))
      $select->where($petitionTableName . '.parent_id =?', $params['epetition_id']);

    if (isset($customFields['has_photo']) && !empty($customFields['has_photo'])) {
      $select->where($petitionTableName . '.photo_id != ?', "0");
    }


    if (!empty($params['getpetition'])) {
      $select->where($petitionTableName . ".title LIKE ? OR " . $petitionTableName . ".body LIKE ?", '%' . $params['textSearch'] . '%')->where($petitionTableName . ".search = ?", 1);
    }

    $select->order(!empty($params['orderby']) ? $params['orderby'] . ' DESC' : $petitionTableName . '.epetition_id DESC');
    if (isset($params['fetchAll'])) {
      if (!isset($params['rss'])) {
        if (empty($params['limit']))
          $select->limit(3);
        else
          $select->limit($params['limit']);
      }
      return $this->fetchAll($select);
    } else
      return $select;
  }

  public function getOfTheDayResults()
  {
    return $this->select()
      ->from($this->info('name'), 'epetition_id')
      ->where('offtheday =?', 1)
      ->where('starttime <= DATE(NOW())')
      ->where('endtime is Null or endtime >= DATE(NOW())')
      ->order('RAND()')
      ->query()
      ->fetchColumn();
  }

  public function getEpetitionPaginator($params = array())
  {
    $paginator = Zend_Paginator::factory($this->getPetitioinformSelect($params));
    if (!empty($params['page'])) {
      $paginator->setCurrentPageNumber($params['page']);
    }
    if (!empty($params['limit'])) {
      $paginator->setItemCountPerPage($params['limit']);
    }

    if (empty($params['limit'])) {
      $page = (int)Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.page', 10);
      $paginator->setItemCountPerPage($page);
    }

    return $paginator;
  }

  public function getPetitioinformSelect($params = array())
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $table = Engine_Api::_()->getItemTable('epetition', 'epetition');

    $select = $table->select();
    if(isset($params['user_id']) && !empty($params['user_id']))
    {
      $select=$select->where('owner_id=?',$params['user_id']);
    }
    $select= $select->order(!empty($params['orderby']) ? $params['orderby'] . ' DESC' : $rName . '.epetition_id DESC');
    return $select;
  }

  public function getPetitionId($slug = null)
  {
    if ($slug) {
      $tableName = $this->info('name');
      $select = $this->select()
        ->from($tableName)
        ->where($tableName . '.custom_url like ?', '%'.$slug.'%');

      $row = $this->fetchRow($select);
      if (empty($row)) {
        $epetition_id = $slug;
      } else {
        $epetition_id = $row->epetition_id;
        return $epetition_id;
      }
    }
    return '';
  }

  /**
   * Gets a Title of epetitions
   */
  public function getPetitionTitle($epetition_id = null)
  {
    if ($epetition_id) {
      $tableName = $this->info('name');
      $select = $this->select()
        ->from($tableName)
        ->where($tableName . '.epetition_id = ?', $epetition_id);
      $row = $this->fetchRow($select);
      if (empty($row)) {
        $epetition_title = $epetition_id;
      } else {
        $epetition_title = $row->title;
        return $epetition_title;
      }
    }
    return '';
  }
  /**
   * Gets Owner Id of epetitions
   */
  public function getPetitionOwnerId($slug = null)
  {
    if ($slug) {
      $tableName = $this->info('name');
      $select = $this->select()
        ->from($tableName)
        ->where($tableName . '.custom_url = ?', $slug);
      $row = $this->fetchRow($select);
      if (empty($row)) {
        return '';
      } else {
        return $row->owner_id;
      }
    }

  }

  /**
   * Gets Customer Url Id of epetitions
   */
  public function checkCustomUrl($value = '', $epetition_id = '')
  {
    $select = $this->select('epetition_id')->where('custom_url = ?', $value);
    if ($epetition_id)
      $select->where('epetition_id !=?', $epetition_id);
    return $select->query()->fetchColumn();
  }

  /**
   * Gets Total Signature, Signature Goal, Signature completed and Signature Goal Percent for style, Petition Id,Id of epetitions
   */
  public function getDetailsForAjaxUpdate($epetition_id) // primary key
  {
    $table = Engine_Api::_()->getDbtable('signatures', 'epetition');
    $data = $table->select()
      ->where('epetition_id =?', $epetition_id)
      ->query()
      ->fetchAll();
    $sign_goal = Engine_Api::_()->getItemTable('epetition', 'epetition');
    $sign_goals = $sign_goal->select()
      ->where('epetition_id =?', $epetition_id)
      ->query()
      ->fetch();
    $result_array = array();
    $result_array['id'] = $epetition_id;
    $result_array['signpet'] = count($data);
    $result_array['goal'] = $sign_goals['signature_goal'];
    $result_array['percent'] = round(((count($data) * 100) / $sign_goals['signature_goal']), 2) . "%";
    return $result_array;
  }

  /**
   * Get Total Petition By Owner id
   */
   public function totalpetition($ownerid)
   {
     $table = Engine_Api::_()->getItemTable('epetition', 'epetition');
     $data = $table->select()->from($table->info('name'), 'owner_id')
       ->where('owner_id =?', $ownerid)
       ->query()
       ->fetchAll();
    return count($data);
   }


}
