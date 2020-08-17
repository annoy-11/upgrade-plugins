<?php

/**
 */
class Sespawsnclaws_Widget_PhotoGalleryController extends Engine_Content_Widget_Abstract {
	
  public function indexAction() {

        $popularitycriteria = $this->_getParam('popularitycriteria', 'creation_date');
        $limit = $this->_getParam('limit', '10');

        // Prepare data
        $albumTable = Engine_Api::_()->getItemTable('album');
        $select = $albumTable->select()->from($albumTable->info('name'), 'album_id');

        $viewer = Engine_Api::_()->user()->getViewer();
        $viewerId = $viewer->getIdentity();
        $excludedLevels = array(1, 2, 3);
        if( $viewer->getIdentity() && !in_array($viewer->level_id, $excludedLevels)) {
            $viewerId = $viewer->getIdentity();
            $netMembershipTable = Engine_Api::_()->getDbtable('membership', 'network');
            $this->view->viewerNetwork = $viewerNetwork = $netMembershipTable->getMembershipsOfIds($viewer);
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
        } elseif( !in_array($viewer->level_id, $excludedLevels) ) {
            $select->Where("owner_id = ?", $viewerId)
                ->orwhere("view_privacy IN (?)", $registeredPrivacy);

            if( !empty($friendsIds) ) {
                $select->orWhere("view_privacy = 'owner_member' AND owner_id IN (?)", $friendsIds);
            }

            if( !empty($friendsOfFriendsIds) ) {
                $select->orWhere("view_privacy = 'owner_member_member' AND owner_id IN (?)", $friendsOfFriendsIds);
            }
            if( empty($viewerNetwork) && !empty($friendsOfFriendsIds) ) {
                $select->orWhere("view_privacy = 'owner_network' AND owner_id IN (?)", $friendsOfFriendsIds);
            }

            $subquery = $select->getPart(Zend_Db_Select::WHERE);
            $select ->reset(Zend_Db_Select::WHERE);
            $select ->where(implode(' ',$subquery));
        }

        $select->where("search = 1");
        $albums = $albumTable->fetchAll($select);
        $albumIds = array();
        foreach ($albums as $album) {
            $albumIds[] = $album->album_id;
        }

        $photoTable = Engine_Api::_()->getItemTable('album_photo');
        $select = $photoTable->getPhotoSelect(array_merge(['album_ids' => $albumIds, 'order' => $popularitycriteria]));
        $select->limit($limit);

        $this->view->results = $results = $photoTable->fetchAll($select);
        if(count($results) == 0)
            return $this->setNoRender();
  }
}