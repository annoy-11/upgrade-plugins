<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescontentcoverphoto_Api_Core extends Core_Api_Abstract {

    public function isResourceExist($resource_type, $resource_id) {

        $userinfoTable = Engine_Api::_()->getDbTable('contentinfos', 'sescontentcoverphoto');
        $contentinfo_id = $userinfoTable->select()
                    ->from($userinfoTable->info('name'), 'contentinfo_id')
                    ->where($userinfoTable->info('name') . '.resource_id = ?', $resource_id)
                    ->where($userinfoTable->info('name') . '.resource_type = ?', $resource_type)
                    ->query()
                    ->fetchColumn();
        if(empty($contentinfo_id)) {
            $contentinfo = $userinfoTable->createRow();
            $contentinfo->resource_id = $resource_id;
            $contentinfo->resource_type = $resource_type;
            $contentinfo->save();
            return Engine_Api::_()->getItem('sescontentcoverphoto_contentinfo', $contentinfo->getIdentity());
        } else {
            return Engine_Api::_()->getItem('sescontentcoverphoto_contentinfo', $contentinfo_id);
        }
    }

	public function getSpecialAlbum(User_Model_User $user, $type = 'cover') {

    $table = Engine_Api::_()->getItemTable('album');
    $select = $table->select()
        ->where('owner_type = ?', $user->getType())
        ->where('owner_id = ?', $user->getIdentity())
        ->where('type = ?', $type)
        ->order('album_id ASC')
        ->limit(1);
    $album = $table->fetchRow($select);

    $translate = Zend_Registry::get('Zend_Translate');
    if($type != 'cover') {
      if($type == 'music_playlist') {
        $title = $translate->_(ucfirst('music') . ' Cover Photos');
      } else {
        $title = $translate->_(ucfirst($type) . ' Cover Photos');
      }
    } else {
      $title = $translate->_(ucfirst($type) . ' Photos');
    }

    // Create wall photos album if it doesn't exist yet
    if( null === $album ) {

      $album = $table->createRow();
      $album->owner_type = 'user';
      $album->owner_id = $user->getIdentity();
      $album->title = $title;
      $album->type = $type;
      $album->search = 1;
      $album->save();
      // Authorizations
			$auth = Engine_Api::_()->authorization()->context;
			$auth->setAllowed($album, 'everyone', 'view',    true);
			$auth->setAllowed($album, 'everyone', 'comment', true);
    }
    return $album;
  }

  public function getUserAlbum(){
			$viewer = Engine_Api::_()->user()->getViewer();
			$table = Engine_Api::_()->getItemTable('album');
			$select = $table->select()
				->from($table->info('name'))
				->where('owner_id =?',$viewer->getIdentity())
				->order('type DESC');

			return Zend_Paginator::factory($select);
	}

  public function getPhotoSelect($params = array()) {

    $table = Engine_Api::_()->getItemTable('photo');
    $select = $table->select();

    if( !empty($params['album']) && $params['album'] instanceof Sesalbum_Model_Album ) {
      $select->where('album_id = ?', $params['album']->getIdentity());
    } else if( !empty($params['album_id']) && is_numeric($params['album_id']) ) {
      $select->where('album_id = ?', $params['album_id']);
    }

    if( !isset($params['order']) ) {
      $select->order('order ASC');
    } else if( is_string($params['order']) ) {
      $select->order($params['order']);
    }

    if(empty($params['pagNator'])){
      if(isset($params['limit_data'])){
        $select->limit($params['limit_data']);
        return $table->fetchAll($select);
      } else
        return $table->fetchAll($select);
    } else
        return Zend_Paginator::factory($select);
  }

  public function getResourceTypeData($resourceType, $subject = null) {

    if($resourceType == '')
      return;

    $typeArray = array();
    $typeArray['insideOutsideCheck'] = $typeArray['uploadprofilePhoto'] = false;
    switch($resourceType) {
      case 'album':
        $typeArray['albumTableName'] = 'album';
        $typeArray['photoTableName'] = 'album_photo';
        $typeArray['id'] = 'album_id';
        $typeArray['userId'] = 'owner_id';
        $typeArray['defaultPhoto'] = 'application/modules/Album/externals/images/nophoto_album_thumb_normal.png';
        $typeArray['options'] = array('category' => 'Category', 'postedby' => "Posted By", "editinfo" => 'Edit Button');
        $typeArray['defaultOptions'] = array('category', 'postedby', "editinfo");

        if($subject) {
          $typeArray['photo_id'] = $subject->photo_id;
          $typeArray['user_id'] = $subject->owner_id;
          $typeArray['canEdit'] = $subject->authorization()->isAllowed(null, 'edit');
        }
        $typeArray['uploadprofilePhoto'] = true;
      break;
      case 'blog':
        $typeArray['albumTableName'] = '';
        $typeArray['photoTableName'] = '';
        $typeArray['id'] = 'blog_id';
        $typeArray['userId'] = 'owner_id';
        $typeArray['defaultPhoto'] = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png';
        $typeArray['options'] = array('category' => 'Category', 'postedby' => "Posted By", "editinfo" => 'Edit This Entry Button');
        $typeArray['defaultOptions'] = array('category', 'postedby', "editinfo");

        if($subject) {
          $owner_id = $subject->owner_id;
          $User = Engine_Api::_()->getItem('user', $owner_id);
          $typeArray['photo_id'] = $User->photo_id;
          $typeArray['user_id'] = $subject->owner_id;
          $typeArray['canEdit'] = $subject->authorization()->isAllowed(null, 'edit');
        }

      break;
      case 'classified':
        $typeArray['albumTableName'] = 'classified_album';
        $typeArray['photoTableName'] = 'classified_photo';
        $typeArray['id'] = 'classified_id';
        $typeArray['userId'] = 'owner_id';
        $typeArray['defaultPhoto'] = 'application/modules/Classified/externals/images/nophoto_classified_thumb_profile.png';
        $typeArray['options'] = array('category' => 'Category', 'postedby' => "Posted By", "editinfo" => 'Edit Button');
        $typeArray['defaultOptions'] = array('category', 'postedby', "editinfo");
        if($subject) {
          $typeArray['photo_id'] = $subject->photo_id;
          $typeArray['user_id'] = $subject->owner_id;
          $typeArray['canEdit'] = $subject->authorization()->isAllowed(null, 'edit');
        }
        $typeArray['uploadprofilePhoto'] = true;
      break;
      case 'event':
        $typeArray['albumTableName'] = 'event_album';
        $typeArray['photoTableName'] = 'event_photo';
        $typeArray['id'] = 'event_id';
        $typeArray['userId'] = 'user_id';
        $typeArray['defaultPhoto'] = 'application/modules/Event/externals/images/nophoto_event_thumb_profile.png';
        $typeArray['options'] = array('category' => 'Category', 'postedby' => "Posted By", "editinfo" => 'Edit Event Details', 'location' => "Location", 'host' => "Host", "ledby" => "Led By", "membercount" => "Member Count","options" => "Option's Button");
        $typeArray['defaultOptions'] = array('category', 'postedby', "editinfo", 'location', 'host', "ledby", "membercount","options");
        if($subject) {
          $typeArray['photo_id'] = $subject->photo_id;
          $typeArray['user_id'] = $subject->user_id;
          $typeArray['canEdit'] = $subject->authorization()->isAllowed(null, 'edit');
        }
        $typeArray['insideOutsideCheck'] = true;
        $typeArray['uploadprofilePhoto'] = true;
      break;
      case 'group':
        $typeArray['albumTableName'] = 'group_album';
        $typeArray['photoTableName'] = 'group_photo';
        $typeArray['id'] = 'group_id';
        $typeArray['userId'] = 'user_id';
        $typeArray['defaultPhoto'] = 'application/modules/Group/externals/images/nophoto_group_thumb_profile.png';
        $typeArray['options'] = array('category' => 'Category', 'postedby' => "Posted By", "editinfo" => 'Edit Group Details', "membercount" => "Member Count", "options" => "Option's Button");
        $typeArray['defaultOptions'] = array('category', 'postedby', "editinfo", "membercount", "options");
        if($subject) {
          $typeArray['photo_id'] = $subject->photo_id;
          $typeArray['user_id'] = $subject->user_id;
          $typeArray['canEdit'] = $subject->authorization()->isAllowed(null, 'edit');
        }
        $typeArray['insideOutsideCheck'] = true;
        $typeArray['uploadprofilePhoto'] = true;
      break;
      case 'poll':
        $typeArray['albumTableName'] = '';
        $typeArray['photoTableName'] = '';
        $typeArray['id'] = 'poll_id';
        $typeArray['userId'] = 'user_id';
        $typeArray['defaultPhoto'] = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png';
        $typeArray['options'] = array('postedby' => "Posted By");
        $typeArray['defaultOptions'] = array('postedby');
        if($subject) {
          $owner_id = $subject->user_id;
          $User = Engine_Api::_()->getItem('user', $owner_id);
          $typeArray['photo_id'] = $User->photo_id;
          $typeArray['user_id'] = $subject->user_id;
          $typeArray['canEdit'] = $subject->authorization()->isAllowed(null, 'edit');
        }

      break;
      case 'music_playlist':
        $typeArray['albumTableName'] = '';
        $typeArray['photoTableName'] = '';
        $typeArray['id'] = 'playlist_id';
        $typeArray['userId'] = 'owner_id';
        $typeArray['defaultPhoto'] = 'application/modules/Music/externals/images/nophoto_playlist_thumb_profile.png';
        $typeArray['options'] = array('postedby' => "Posted By", 'playcount' => "Plays Count", "editinfo" => 'Edit Playlist');
        $typeArray['defaultOptions'] = array('postedby', 'playcount', "editinfo");

        if($subject) {
          //$owner_id = $subject->user_id;
          //$User = Engine_Api::_()->getItem('user', $owner_id);
          $typeArray['photo_id'] = $User->photo_id;
          $typeArray['user_id'] = $subject->owner_id;
          $typeArray['canEdit'] = $subject->authorization()->isAllowed(null, 'edit');
        }

      break;
      case 'video':
        $typeArray['albumTableName'] = '';
        $typeArray['photoTableName'] = '';
        $typeArray['id'] = 'video_id';
        $typeArray['userId'] = 'owner_id';
        $typeArray['defaultPhoto'] = 'application/modules/Video/externals/images/video.png';
        $typeArray['options'] = array('category' => 'Category', 'postedby' => "Posted By", "editinfo" => 'Edit');
        $typeArray['defaultOptions'] = array('category', 'postedby', "editinfo");
        if($subject) {
          $typeArray['photo_id'] = $subject->photo_id;
          $typeArray['user_id'] = $subject->owner_id;
          $typeArray['canEdit'] = $subject->authorization()->isAllowed(null, 'edit');
        }
      break;
    }
    return $typeArray;
  }

  public function getDesignType($id, $resourceType) {

    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
    $permissionsTableName = $permissionsTable->info('name');
    return $permissionsTable->select()
                    ->from($permissionsTableName, 'value')
                    ->where('level_id = ?', $id)
                    ->where('type = ?', 'sescontentcoverphoto')
                    ->where('name = ?', 'vwty_'.$resourceType)
                    ->query()
                    ->fetchColumn();

  }
}
