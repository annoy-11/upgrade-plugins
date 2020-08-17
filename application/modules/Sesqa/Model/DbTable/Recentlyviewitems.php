<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Recentlyviewitems.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesqa_Model_DbTable_Recentlyviewitems extends Engine_Db_Table {
  
  protected $_name = 'sesqa_recentlyviewitems';
  protected $_rowClass = 'Sesqa_Model_Recentlyviewitem';
  
  public function getitem($params = array()) {
    $itemTable = Engine_Api::_()->getItemTable('sesqa_question');
    $itemTableName = $itemTable->info('name');
    $fieldName = 'question_id';
		$subquery = $this->select()->from($this->info('name'),array('*','MAX(creation_date) as maxcreadate'))->group($this->info('name').".resource_id")->order($this->info('name').".resource_id DESC");		
   
 if ($params['criteria'] == 'by_me') {
      $subquery->where($this->info('name') . '.owner_id =?', Engine_Api::_()->user()->getViewer()->getIdentity());
    } else if ($params['criteria'] == 'by_myfriend') {
      /* friends array */
      $friendIds = Engine_Api::_()->user()->getViewer()->membership()->getMembershipsOfIds();
      if (count($friendIds) == 0)
        return array();
      $subquery->where($this->info('name') . ".owner_id IN ('" . implode(',', $friendIds) . "')");
    }

   $select = $this->select()
            ->setIntegrityCheck(false)
            ->from(array('engine4_sesqa_recentlyviewitems' => $subquery))
            ->order('maxcreadate DESC')
            ->group($this->info('name') . '.resource_id')
            ->limit($params['limit']);
    if ($params['criteria'] == 'by_me') {
      $select->where($this->info('name') . '.owner_id =?', Engine_Api::_()->user()->getViewer()->getIdentity());
    } else if ($params['criteria'] == 'by_myfriend') {
      /* friends array */
      $friendIds = Engine_Api::_()->user()->getViewer()->membership()->getMembershipsOfIds();
      if (count($friendIds) == 0)
        return array();
      $select->where($this->info('name') . ".owner_id IN ('" . implode(',', $friendIds) . "')");
    }
    $select->joinLeft($itemTableName, $itemTableName . ".$fieldName =  " . $this->info('name') . '.resource_id', array('*'));
		$select->where($itemTableName.'.'.$fieldName.' != ?','');
    if(!empty($params['category_id']))
      $select->where($itemTableName.'.category_id=?',$params['category_id']);
     
     $select->where('search =?',1);
     $select->where('draft =?',1);
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('seslocation_enable', 0) && ((empty($params['locationEnable'])) || (!empty($params['locationEnable']) && $params['locationEnable'] != "no" )) && !empty($_COOKIE['seslocation_content_data'])){
      $locationData = json_decode($_COOKIE['seslocation_content_data'],true);
      $lat = $locationData['lat'];
      $long = $locationData['lng'];
      $dist = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslocation.search.miles', 50); // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
      $tableLocation = Engine_Api::_()->getDbtable('locations', 'sesbasic');
      $tableLocationName = $tableLocation->info('name');
      $origLat = $lat ;
      $origLon = $long ;
      $select = $select->setIntegrityCheck(false);
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seslocation.search.type', 1) == 1) {
        $searchType = 3956;
      } else
        $searchType = 6371;       
      $select->setIntegrityCheck(false);
      $select->joinLeft($tableLocationName, $tableLocationName . '.resource_id = ' . $itemTable->info('name') . '.question_id AND ' . $tableLocationName . '.resource_type = "sesqa_question" ', array('lat', 'lng', 'distance' => new Zend_Db_Expr($searchType." * 2 * ASIN(SQRT( POWER(SIN(($lat - lat) *  pi()/180 / 2), 2) +COS($lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(($long - lng) * pi()/180 / 2), 2) ))")));      
        
      $rectLong1 = $long - $dist/abs(cos(deg2rad($lat))*69);
      $rectLong2 = $long + $dist/abs(cos(deg2rad($lat))*69);
      $rectLat1 = $lat-($dist/69);
      $rectLat2 = $lat+($dist/69);        
      $select->where($tableLocationName . ".lng between $rectLong1 AND $rectLong2  and " . $tableLocationName . ".lat between $rectLat1 AND $rectLat2");
      $select->order('distance');
      $select->having("distance < $dist");
    }  
	//echo $select;die;
    return $this->fetchAll($select);
  }
}