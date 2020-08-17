<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Polls.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgrouppoll_Model_DbTable_Polls extends Core_Model_Item_DbTable_Abstract
{
  protected $_rowClass = 'Sesgrouppoll_Model_Poll';

  public function getPollSelect($params = array())
  {
	
	
	  
    $viewer = Engine_Api::_()->user()->getViewer();
$viewerId = $viewer->getIdentity();
    // Setup
    $params = array_merge(array(
      'user_id' => null,
      'order' => 'recent',
      'search' => '',
      'closed' => 0,
    ), $params);
    $table = Engine_Api::_()->getItemTable('sesgrouppoll_poll');
    $tableName = $table->info('name');
    $groupTable = Engine_Api::_()->getItemTable('sesgroup_group');
    $groupTableName = $groupTable->info('name');

    $select = $table
      ->select()
      ->from($tableName)
      ;

    // User
    if( !empty($params['user_id']) && is_numeric($params['user_id']) ) {
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
    }
 if ($params['show'] == 2 && $viewerId) {
        $users = $viewer->membership()->getMembershipsOfIds();
        if ($users)
          $select->where($tableName . '.user_id IN (?)', $users);
	  else
          $select->where($tableName . '.user_id IN (?)', 0);
      }
    // Browse
    if( isset($params['browse']) ) {
      $select->where($tableName.'.search = ?', (int) (bool) $params['browse']);
    }

    if(isset($params['searchgroup']) && !empty($params['searchgroup'])){
      $select->join($groupTableName, $groupTableName . '.group_id = ' . $tableName . '.group_id',null)
        ->where($groupTableName.'.title LIKE ?','%' . $params['searchgroup'] . '%');
    }
    if( isset($params['group_id']) && $params['group_id'] != null && $params['group_id'] >0 ) {
      $select->where('group_id = ?', $params['group_id']);
    }
    if (!empty($params['text']))
      $select->where($tableName . ".title LIKE ? OR " . $tableName . ".description LIKE ?", '%' . $params['text'] . '%');
    if (!empty($params['search']))
      $select->where($tableName . ".title LIKE ? ", '%' . $params['search'] . '%');

    // Closed
    if( !isset($params['closed']) || null === $params['closed'] ) {
      $params['closed'] = 0;
    }
    if((isset($params['closed']) || null != $params['closed'] ) && $params['closed'] == 1) {
       $select->where($tableName . '.closed =?', 1);
    }
    if((isset($params['closed']) || null != $params['closed'] ) && $params['closed'] == 0 && !isset($params['sort'])) {
       $select->where($tableName . '.closed =?', 0);
    }
 

    // Order
	if (isset($params['sort']) && !empty($params['sort']))
    {

      if ($params['sort'] == 'open')
        $select = $select->where($tableName . '.closed =?', 0);
      elseif ($params['sort'] == 'close')
        $select = $select->where($tableName . '.closed =?', 1);
			elseif ($params['sort'] == 'vote_count')
				$select->order('vote_count DESC');
			elseif ($params['sort'] == 'mostvoted')
				$select->order('vote_count DESC');
      elseif ($params['sort'] == 'creation_date')
         $select->order('creation_date DESC');
      elseif ($params['sort'] == 'like_count')
         $select->order('like_count DESC');
      elseif ($params['sort'] == 'comment_count')
        $select->order('comment_count DESC');
      elseif ($params['sort'] == 'view_count')
        $select->order('view_count DESC'); 
			elseif ($params['sort'] == 'favourite_count')
        $select->order('favourite_count DESC');
     
    }
	
	
    if (isset($params['order'])) {
      switch ($params['order']) {
        case 'recently_created':
          $select->order('creation_date DESC');
          break;
				case 'recentlycreated':
          $select->order('creation_date DESC');
          break;
        case 'most_viewed':
          $select->order('view_count DESC');
          break;
				case 'mostviewed':
          $select->order('view_count DESC');
          break;
        case 'most_liked':
          $select->order('like_count DESC');
          break;
				case 'mostliked':
          $select->order('like_count DESC');
          break;
        case 'most_favourite':
          $select->order('favourite_count DESC');
          break; 
				case 'mostfavourite':
          $select->order('favourite_count DESC');
          break;
        case 'most_commented':
          $select->order('comment_count DESC');
          break; 
				case 'mostcommented':
          $select->order('comment_count DESC');
          break;
        case 'most_voted':
          $select->order('vote_count DESC');
          break;
				case 'mostvoted':
				 $select->order('vote_count DESC');
          break;
        case 'popular':
          $select
            ->order('vote_count DESC');
           $select ->order('view_count DESC');
          break;
        default:
          $select
            ->order('creation_date DESC');
          break;
      }
    }
    if (isset($params['popular_type'])) {
      switch ($params['popular_type']) {
        case 'recently_created':
          $select->order('creation_date DESC');
          break;
        case 'most_viewed':
          $select->order('view_count DESC');
          break;
        case 'most_liked':
          $select->order('like_count DESC');
          break;
        case 'most_favourite':
          $select->order('favourite_count DESC');
          break;
        case 'most_commented':
          $select->order('comment_count DESC');
          break;
        case 'most_voted':
          $select->order('vote_count DESC');
          break;
        case 'popular':
          $select
            ->order('vote_count DESC')
            ->order('view_count DESC');
          break;
        default:
          $select
            ->order('creation_date DESC');
          break;
      }
    }
    if( !empty($owner) ) {
      return $select;
    }
    return $this->getAuthorisedSelect($select);
  }
  /**
   * Gets a paginator for polls
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getPollsPaginator($params = array())
  {
    return Zend_Paginator::factory($this->getPollSelect($params));
  }

  public function getItemsSelect($params, $select = null)
  {

    if( $select == null ) {
      $select = $this->select();
    }
    $table = $this->info('name');
    $registeredPrivacy = array('everyone', 'registered');
    $viewer = Engine_Api::_()->user()->getViewer();
    if( $viewer->getIdentity() && !in_array($viewer->level_id, $this->_excludedLevels) ) {
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
