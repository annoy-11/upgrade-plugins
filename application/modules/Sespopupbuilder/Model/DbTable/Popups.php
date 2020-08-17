<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Popups.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespopupbuilder_Model_DbTable_Popups extends Core_Model_Item_DbTable_Abstract {

  protected $_rowClass = "Sespopupbuilder_Model_Popup";
	
	public function getPopup($params){
		return Zend_Paginator::factory($this->getPoupSelect($params));
	}
	public function getPoupSelect($params){
		
		$viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $table = Engine_Api::_()->getItemTable('sespopupbuilder_popup');
    $tableName = $table->info('name');
		$countrytable = Engine_Api::_()->getItemTable('sespopupbuilder_country');
    $countrytableName = $countrytable->info('name');
    $select = $table->select()->from($tableName);
		// User
		
		if (!empty($params['title']) && $params['title'] != null)
      $select->where($tableName . ".title LIKE ? ", '%' . $params['title'] . '%');
		if (!empty($params['is_deleted']) && $params['is_deleted'] != null){
			  if ($params['is_deleted'] == '1')
        $select->where('is_deleted = ?', '1');
      elseif ($params['is_deleted'] == '0')
        $select->where('is_deleted = ?', '0');
		}
		if (!empty($params['popup_type']) && $params['popup_type'] != null){
			$select->where('popup_type = ?', $params['popup_type']);
		}
		
		
		/*----------------- view privacy work ----------/*/
    /*if( !empty($params['user_id']) && is_numeric($params['user_id']) ) {
      $owner = Engine_Api::_()->getItem('user', $params['user_id']);
      $select = $this->getProfileItemsSelect($owner, $select);
    } elseif( isset($params['users']) && is_array($params['users']) ) {
			
      if( empty($params['users']) ) {
        return $select ->where('1 != 1');
      }
      $select
        ->where('user_id IN (?)', $params['users']);

      if( !in_array($viewer->level_id, $this->_excludedLevels) ) {
        $select->where("view_privacy != ? ", 'owner');
      }

    } else {
      $param = array();
      $select = $this->getItemsSelect($param, $select);
    }*/
		
		
		
		
		/*--------------- data for widget ------------------------*/
		if (isset($_SERVER['HTTP_CLIENT_IP'])){
			$cip = $_SERVER['HTTP_CLIENT_IP'];
		}
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$cip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$cip = $_SERVER['REMOTE_ADDR'];
		}
		$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $cip));
			
		if(isset($params['whenshow']) && $params['whenshow'] == 'true'){
			$select->where('whenshow = ?', 5);
		}
		if(isset($params['whenshow']) && $params['whenshow'] == 'false'){
			
			$select->where('whenshow != ?', 5);
			$visitTable = Engine_Api::_()->getDbTable('visits','sespopupbuilder');
			$visittableName = $visitTable->info('name');
			if($viewerId>0){
			$select->setIntegrityCheck(false)
				->joinLeft($visittableName,$visittableName.'.popup_id = '.$tableName.'.popup_id AND '.$visittableName.'.user_id = '.$viewerId,null);
				$select->where("CASE WHEN " .$tableName .".popup_visibility_duration > '0'  THEN  DATE_ADD(".$visittableName.".popup_visit_date, INTERVAL ".$tableName.".popup_visibility_duration DAY) <= now() OR ".$visittableName.".visit_id IS NULL ELSE true END");
				
			}else{
				$nonLogedInUserIp = @$ipdat->geoplugin_request;
				$select->setIntegrityCheck(false)
				->joinLeft($visittableName,$visittableName.'.popup_id = '.$tableName.'.popup_id AND '.$visittableName.'.viewer_ip = "'.$nonLogedInUserIp.'"',null);
				
				$select->where("CASE WHEN " .$tableName .".popup_visibility_duration > '0'  THEN  DATE_ADD(".$visittableName.".popup_visit_date, INTERVAL ".$tableName.".popup_visibility_duration DAY) <= now() OR ".$visittableName.".visit_id IS NULL ELSE true END");
			}
		}
		$network_id_query_count = 0;
		if(isset($params['show']) &&  $params['show'] == 'widget'){


		/*------------------- member Role ---------------*/
		$levelId = ($viewerId) ? $viewer->level_id : Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel()->level_id;//echo '<pre>';print_r($levelId);die;
		if(count($levelId)>0){
			$select->where("CONCAT(',',CONCAT(level_id,',')) LIKE '%,".$levelId.",%' || level_id IS NULL || level_id = \"\" ");
		}

		/*----------------- profile type work -----------*/
		$profileTypes = Engine_Api::_()->sespopupbuilder()->profileTypesMembers($viewerId);
		if(count($profileTypes)>0){
			$select->where("CONCAT(',',CONCAT(profile_type,',')) LIKE '%,".$profileTypes.",%' || profile_type IS NULL || profile_type = \"\" ");
		}


		/*----------------- network work -----------*/
		$networkSqlExecute = false;
    if ($viewerId) {
      $network_table = Engine_Api::_()->getDbTable('membership', 'network');
      $network_select = $network_table->select('resource_id')->where('user_id = ?', $viewerId);
      $network_id_query = $network_table->fetchAll($network_select);
      $network_id_query_count = count($network_id_query);
       //echo $network_id_query_count;die;
      $networkSql = '(';
      for ($i = 0; $i < $network_id_query_count; $i++) {
        $networkSql = $networkSql . "CONCAT(',',CONCAT(networks,',')) LIKE '%,". $network_id_query[$i]['resource_id'] .",%' || ";
      }
     
      $networkSql = trim($networkSql, '|| ') . ')';
      if ($networkSql != '()') {
        $networkSqlExecute = true;
        $networkSql = $networkSql . ' || networks IS NULL || networks = "" || ' . $tableName . '.user_id =' . $viewerId;
        $select->where($networkSql);
      }
    }
    if (!$networkSqlExecute && $network_id_query_count>0 ) {
      $networkUser = '';
      if ($viewerId)
        $networkUser = ' ||' . $tableName . '.user_id =' . $viewerId . ' ';
      $select->where('networks IS NULL || networks = ""  ' . $networkUser);
    }
			$creatorlocation = @$ipdat->geoplugin_countryCode;
			if($creatorlocation){
				$select->setIntegrityCheck(false)
				->joinLeft($countrytableName,$countrytableName.'.popup_id = '.$tableName.'.popup_id',null);
				$select->where($countrytableName.'.country_title IN (?) ', array('all',$creatorlocation));
			}	
		}
		$currentTime = date('Y-m-d H:i:s');
		$select->where("CASE WHEN " .$tableName .".date_display_setting = '1'  THEN  ".$tableName.".endtime >= '$currentTime' AND ".$tableName.".starttime <= '$currentTime' ELSE true END");
		if(isset($params['is_deleted']) && $params['is_deleted'] == false && ($params['show'] == 'widget'|| $params['show'] == 'widgetview')) {
			 $select->where('is_deleted = ?', 0);
		}
		if (isset($params['limit']))
      $select->limit($params['limit']);
		$select->order($tableName . '.creation_date ASC');
		if(isset($params['show']) && $params['show'] == 'widgetview'){
			$select->group("$tableName.popup_type");
		}
		
		if (isset($params['fetchAll'])) {
      return $this->fetchAll($select);
    } else {
      return $select;
    }
	}
  public function getItemsSelect($params, $select = null)
  {
		$viewer = Engine_Api::_()->user()->getViewer();
    if( $select == null ) {
      $select = $this->select();
    }
		
    $table = $this->info('name');
    $registeredPrivacy = array('everyone', 'registered');
    $viewer = Engine_Api::_()->user()->getViewer();
    if( $viewer->getIdentity() && !in_array($viewer->level_id, $this->_excludedLevels)) {
      $viewerId = $viewer->getIdentity();
      $netMembershipTable = Engine_Api::_()->getDbtable('membership', 'network');
      $viewerNetwork = $netMembershipTable->getMembershipsOfIds($viewer);
      if( !empty($viewerNetwork) ) {
        array_push($registeredPrivacy,'owner_network');
      }
      $friendsIds = $viewer->membership()->getMembersIds();
      $friendsOfFriendsIds = $friendsIds;
      foreach( $friendsIds as $friendId ) {
        $friend = Engine_Api::_()->getItem('user', $friendId);
        $friendMembersIds = $friend->membership()->getMembersIds();
        $friendsOfFriendsIds = array_merge($friendsOfFriendsIds, $friendMembersIds);
      }
    }
    if( !$viewer->getIdentity() ) {
      $select->where("view_privacy = ?", 'everyone');
    } elseif( !in_array($viewer->level_id, $this->_excludedLevels) ) {
      $select->Where("$table.user_id = ?", $viewerId)
        ->orwhere("view_privacy IN (?)", $registeredPrivacy);
      if( !empty($friendsIds) ) {
        $select->orWhere("view_privacy = 'owner_member' AND $table.user_id IN (?)", $friendsIds);
      }
      if( !empty($friendsOfFriendsIds) ) {
        $select->orWhere("view_privacy = 'owner_member_member' AND $table.user_id IN (?)", $friendsOfFriendsIds);
      }
      if( empty($viewerNetwork) && !empty($friendsOfFriendsIds) ) {
        $select->orWhere("view_privacy = 'owner_network' AND $table.user_id IN (?)", $friendsOfFriendsIds);
      }
      $subquery = $select->getPart(Zend_Db_Select::WHERE);
      $select ->reset(Zend_Db_Select::WHERE);
      $select ->where(implode(' ',$subquery));
    }
    if( isset($params['search']) ) {
      $select->where("search = ?", $params['search']);
    }
    return $select;
  }
	
	public function getProfileItemsSelect($owner, $select = null)
  {
    if( $select == null ) {
      $select = $this->select();
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    if( !empty($owner) ) {
      $ownerId = $owner->getIdentity();
    }
    $isOwnerOrAdmin = false;
    if( !empty($viewerId) && ($ownerId == $viewerId || in_array($viewer->level_id, $this->_excludedLevels)) ) {
      $isOwnerOrAdmin = true;
    }
    if( !empty($owner) && $owner instanceof Core_Model_Item_Abstract ) {
      $select
        ->where('user_id = ?', $ownerId);

      if( $isOwnerOrAdmin ) {
        return $select;
      }
      $isOwnerViewerLinked = true;
      if( $viewer->getIdentity() ) {
        $restrictedPrivacy = array('owner');
        $ownerFriendsIds = $owner->membership()->getMembersIds();
        if( !in_array($viewerId, $ownerFriendsIds) ) {
          array_push($restrictedPrivacy, 'owner_member');
          $friendsOfFriendsIds = array();
          foreach( $ownerFriendsIds as $friendId ) {
            $friend = Engine_Api::_()->getItem('user', $friendId);
            $friendMembersIds = $friend->membership()->getMembersIds();
            $friendsOfFriendsIds = array_merge($friendsOfFriendsIds, $friendMembersIds);
          }
          if( !in_array($viewerId, $friendsOfFriendsIds) ) {
            array_push($restrictedPrivacy, 'owner_member_member');
            $netMembershipTable = Engine_Api::_()->getDbtable('membership', 'network');
            $viewerNetwork = $netMembershipTable->getMembershipsOfIds($viewer);
            $ownerNetwork = $netMembershipTable->getMembershipsOfIds($owner);
              $checkViewer = array_intersect($viewerNetwork, $ownerNetwork);
            if( empty($checkViewer) ) {
              $isOwnerViewerLinked = false;
            }
          }
        }
        if( $isOwnerViewerLinked ) {
          $select->where("view_privacy NOT IN (?)", $restrictedPrivacy);
          return $select;
        }
      }
      $select->where("view_privacy = ?", 'everyone');
    }
    return $select;
  }
}
