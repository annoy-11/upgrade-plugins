<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescontentcoverphoto_IndexController extends Core_Controller_Action_Standard {

  public function confirmationAction(){
  }

  //update cover photo function
	public function editCoverphotoAction(){

	  $resource_type = $this->_getParam('resource_type', null);
	  $resource_id = $this->_getParam('resource_id', null);
	  $contentInfo = Engine_Api::_()->sescontentcoverphoto()->isResourceExist($resource_type, $resource_id);
	  $item = Engine_Api::_()->getItem($resource_type, $resource_id);

		$user_id = $this->_getParam('user_id', '0');
		if ($user_id == 0)
			return;

		$user = Engine_Api::_()->getItem('user', $user_id);
		if(!$user)
			return;

// 		$art_cover = $user->cover;
		if(isset($_FILES['Filedata']))
			$data = $_FILES['Filedata'];
		else if(isset($_FILES['webcam']))
			$data = $_FILES['webcam'];
		try {

		  if($resource_type == 'album') {
        $type = 'cover';
      } else {
        $type = $resource_type;
      }

      $album = Engine_Api::_()->getApi('core', 'sescontentcoverphoto')->getSpecialAlbum($user, $type);

      $photoTable = Engine_Api::_()->getItemTable('photo');
      $photo = $photoTable->createRow();
      $photo->setFromArray(array(
          'owner_type' => 'user',
          'owner_id' => $user->getIdentity()
      ));
      $photo->save();
      $cover = $this->setCoverPhoto($data,$user, $item,$contentInfo);
      if(isset($photo->order))
      	$photo->order = $photo->photo_id;
      $photo->album_id = $album->album_id;
			$photo->file_id = $cover->cover;
      $photo->save();
      if (!$album->photo_id) {
        $album->photo_id = $photo->getIdentity();
        $album->save();
      }

			// Authorizations
			$auth = Engine_Api::_()->authorization()->context;
			$auth->setAllowed($photo, 'everyone', 'view', true);
			$auth->setAllowed($photo, 'everyone', 'comment', true);

		} catch(Exception $e) {
			throw $e;
		}
		echo json_encode(array('status'=>"true",'src'=>Engine_Api::_()->storage()->get($cover->cover)->getPhotoUrl('')));die;
	}

	//remove cover photo action
	public function removeCoverAction(){

    $resource_type = $this->_getParam('resource_type', null);
	  $resource_id = $this->_getParam('resource_id', null);
	  $contentInfo = Engine_Api::_()->sescontentcoverphoto()->isResourceExist($resource_type, $resource_id);
	  $item = Engine_Api::_()->getItem($resource_type, $resource_id);

		$user_id = $this->_getParam('user_id', '0');
		if ($user_id == 0)
			return;

		$user = Engine_Api::_()->getItem('user', $user_id);
		if(!$user)
			return;

		if(isset($contentInfo->cover) && $contentInfo->cover > 0){
			//$im = Engine_Api::_()->getItem('storage_file', $user->cover);
			$contentInfo->cover = 0;
			$contentInfo->cover_position = 0;
			$contentInfo->save();
			//$im->delete();
		}

		$viewer = $user;
    if ($viewer->getIdentity() == 0)
      $level = Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel()->level_id;
    else
      $level = $user;

		$defaultCoverPhoto = Engine_Api::_()->authorization()->getPermission($level, 'sescontcvrpto', 'dfpto_'.$resource_type);
		if($defaultCoverPhoto != 0 || $defaultCoverPhoto != '')
			$defaultCoverPhoto = $defaultCoverPhoto;
		else
			$defaultCoverPhoto = 'application/modules/Sescontentcoverphoto/externals/images/default_cover.jpg';

		echo json_encode(array('status'=>1,'src'=>$defaultCoverPhoto));die;

	}

	public function setCoverPhoto($photo,$user, $item,$contentInfo){

    if( $photo instanceof Zend_Form_Element_File ) {
      $file = $photo->getFileName();
      $fileName = $file;
    } else if( $photo instanceof Storage_Model_File ) {
      $file = $photo->temporary();
      $fileName = $photo->name;
    } else if( $photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id) ) {
      $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
      $file = $tmpRow->temporary();
      $fileName = $tmpRow->name;
    } else if( is_array($photo) && !empty($photo['tmp_name']) ) {
      $file = $photo['tmp_name'];
      $fileName = $photo['name'];
    } else if( is_string($photo) && file_exists($photo) ) {
      $file = $photo;
      $fileName = $photo;
      $unlink = false;
    } else {
      throw new User_Model_Exception('invalid argument passed to setPhoto');
    }
      $name = basename($file);
      $extension = ltrim(strrchr($fileName, '.'), '.');
      $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');

    if( !$fileName ) {
      $fileName = $file;
    }

		$filesTable = Engine_Api::_()->getDbtable('files', 'storage');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
      'parent_type' => $user->getType(),
      'parent_id' => $user->getIdentity(),
      'user_id' => $user->user_id,
      'name' => $fileName,
    );

    // Resize image (main)
    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_m.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(1900, 1900)
      ->write($mainPath)
      ->destroy();
    // Store
    try {
      $iMain = $filesTable->createFile($mainPath, $params);
    } catch( Exception $e ) {
			@unlink($file);
      // Remove temp files
      @unlink($mainPath);
      // Throw
      if( $e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE ) {
        throw new User_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }

    if(!isset($unlink))
				@unlink($file);
    // Remove temp files
      @unlink($mainPath);
    // Update row
    //$user->modified_date = date('Y-m-d H:i:s');
    $contentInfo->cover = $iMain->file_id;
    $contentInfo->save();
    // Delete the old file?
    if( !empty($tmpRow) ) {
      $tmpRow->delete();
    }
    return $contentInfo;
	}

	public function uploadMainAction() {

    $resource_type = $this->_getParam('resource_type', null);
	  $resource_id = $this->_getParam('resource_id', null);
	  $item = Engine_Api::_()->getItem($resource_type, $resource_id);

	  if($resource_type == 'blog' || $resource_type == 'poll') {
      if( !Engine_Api::_()->core()->hasSubject() ) {
        // Can specifiy custom id
        $user_id = $this->_getParam('user_id', null);
        $subject = null;
        if( null === $user_id ) {
          echo json_encode(array('status'=>"error"));die;
        } else {
          $subject = Engine_Api::_()->getItem('user', $user_id);
          Engine_Api::_()->core()->setSubject($subject);
        }
      }
      $user = Engine_Api::_()->core()->getSubject();
    } elseif($resource_type == 'classified' || $resource_type == 'event' || $resource_type == 'group' || $resource_type == 'album') {
      $user = $item;
    }

    if( !$this->getRequest()->isPost() ) {
      echo json_encode(array('status'=>"error"));die;
    }

    // Uploading a new photo
    if(isset($_FILES['webcam']['tmp_name']) && $_FILES['webcam']['tmp_name'] != '') {
      $db = $user->getTable()->getAdapter();
      $db->beginTransaction();

      try {

        if($resource_type == 'blog' || $resource_type == 'classified') {
          $userUp = $user->setPhoto($_FILES['webcam']);
        } elseif($resource_type == 'event' || $resource_type == 'group'  || $resource_type == 'album') {
          $userUp = $this->setPhoto($_FILES['webcam'], $user);
        }

        $iMain = Engine_Api::_()->getItem('storage_file', $user->photo_id);

//         // Insert activity
//         $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($user, $user, 'profile_photo_update', '{item:$subject} added a new profile photo.');
//         // Hooks to enable albums to work
//         if( $action ) {
//           $event = Engine_Hooks_Dispatcher::_()->callEvent('onUserProfilePhotoUpload', array('user' => $user, 'file' => $iMain));
//
//           $attachment = $event->getResponse();
//           if( !$attachment ) $attachment = $iMain;
//
//           // We have to attach the user himself w/o album plugin
//           Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $attachment);
//         }

        $db->commit();
        echo json_encode(array('status'=>"true",'src'=>Engine_Api::_()->storage()->get($userUp->photo_id)->getPhotoUrl('')));die;
      }
      // If an exception occurred within the image adapter, it's probably an invalid image
      catch( Engine_Image_Adapter_Exception $e ) {
        $db->rollBack();
        echo json_encode(array('status'=>"error"));die;
      }
    }
    echo json_encode(array('status'=>"false"));die;
	}

  public function setPhoto($photo, $resource) {

    $typeArray = Engine_Api::_()->sescontentcoverphoto()->getResourceTypeData($resource->getType());

    if( $photo instanceof Zend_Form_Element_File ) {
      $file = $photo->getFileName();
      $fileName = $file;
    } else if( $photo instanceof Storage_Model_File ) {
      $file = $photo->temporary();
      $fileName = $photo->name;
    } else if( $photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id) ) {
      $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
      $file = $tmpRow->temporary();
      $fileName = $tmpRow->name;
    } else if( is_array($photo) && !empty($photo['tmp_name']) ) {
      $file = $photo['tmp_name'];
      $fileName = $photo['name'];
    } else if( is_string($photo) && file_exists($photo) ) {
      $file = $photo;
      $fileName = $photo;
    } else {
      throw new Classified_Model_Exception('invalid argument passed to setPhoto');
    }

    if( !$fileName ) {
      $fileName = basename($file);
    }

    $extension = ltrim(strrchr(basename($fileName), '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';

    $user_id = $typeArray['userId'];
    $params = array(
      'parent_type' => $resource->gettype(),
      'parent_id' => $resource->getIdentity(),
      'user_id' => $resource->$user_id,
      'name' => $fileName,
    );

    // Save
    $filesTable = Engine_Api::_()->getDbtable('files', 'storage');

    // Resize image (main)
    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_m.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(720, 720)
      ->write($mainPath)
      ->destroy();

    // Resize image (profile)
    $profilePath = $path . DIRECTORY_SEPARATOR . $base . '_p.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(200, 400)
      ->write($profilePath)
      ->destroy();

    // Resize image (normal)
    $normalPath = $path . DIRECTORY_SEPARATOR . $base . '_in.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(140, 160)
      ->write($normalPath)
      ->destroy();

    // Resize image (icon)
    $squarePath = $path . DIRECTORY_SEPARATOR . $base . '_is.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file);

    $size = min($image->height, $image->width);
    $x = ($image->width - $size) / 2;
    $y = ($image->height - $size) / 2;

    $image->resample($x, $y, $size, $size, 48, 48)
      ->write($squarePath)
      ->destroy();

    // Store
    $iMain = $filesTable->createFile($mainPath, $params);
    $iProfile = $filesTable->createFile($profilePath, $params);
    $iIconNormal = $filesTable->createFile($normalPath, $params);
    $iSquare = $filesTable->createFile($squarePath, $params);

    $iMain->bridge($iProfile, 'thumb.profile');
    $iMain->bridge($iIconNormal, 'thumb.normal');
    $iMain->bridge($iSquare, 'thumb.icon');

    // Remove temp files
    @unlink($mainPath);
    @unlink($profilePath);
    @unlink($normalPath);
    @unlink($squarePath);

    // Add to album
    $viewer = Engine_Api::_()->user()->getViewer();
    $photoTable = Engine_Api::_()->getItemTable($typeArray['photoTableName']);
    $classifiedAlbum = $this->getSingletonAlbum($resource, $typeArray);
    $photoItem = $photoTable->createRow();
    $photoItem->setFromArray(array(
      $typeArray["id"] => $resource->getIdentity(),
      'album_id' => $classifiedAlbum->getIdentity(),
      'user_id' => $viewer->getIdentity(),
      'file_id' => $iMain->getIdentity(),
      'collection_id' => $classifiedAlbum->getIdentity(),
    ));
    $photoItem->save();

    // Update row
    $resource->modified_date = date('Y-m-d H:i:s');
    $resource->photo_id = $photoItem->file_id;
    $resource->save();

    return $resource;
  }

  public function getSingletonAlbum($resource, $typeArray) {

    $table = Engine_Api::_()->getItemTable($typeArray['albumTableName']);
    $select = $table->select()
      ->where($typeArray['id']." = ?", $resource->getIdentity())
      ->order('album_id ASC')
      ->limit(1);

    $album = $table->fetchRow($select);

    if( null === $album ) {
      $album = $table->createRow();
      $album->setFromArray(array(
        'title' => $resource->getTitle(),
        $typeArray['id'] => $resource->getIdentity()
      ));
      $album->save();
    }

    return $album;
  }

	public function repositionCoverAction(){

    $resource_type = $this->_getParam('resource_type', null);
	  $resource_id = $this->_getParam('resource_id', null);
	  $contentInfo = Engine_Api::_()->sescontentcoverphoto()->isResourceExist($resource_type, $resource_id);
    if ($resource_id == 0)
			return;
	  $item = Engine_Api::_()->getItem($resource_type, $resource_id);
  	if(!$item)
			return;
		$position = $this->_getParam('position', '0');
		$contentInfo->cover_position = $position;
		$contentInfo->save();
		echo json_encode(array('status'=>"1"));die;
	}

	public function removeMainAction(){

    $resource_type = $this->_getParam('resource_type', null);
	  $resource_id = $this->_getParam('resource_id', null);
		if ($resource_id == 0)
			return;

		$item = Engine_Api::_()->getItem($resource_type, $resource_id);
		if(!$item)
			return;

	  $typeArray = Engine_Api::_()->sescontentcoverphoto()->getResourceTypeData($resource_type);
	  if($resource_type == 'blog' || $resource_type == 'poll') {
      $user_id = $this->_getParam('user_id', null);
      if($user_id == 0)
        return;
      $item = Engine_Api::_()->getItem('user', $user_id);
	  }
	  $photoURL = $typeArray['defaultPhoto'];

		if(isset($item->photo_id) && $item->photo_id > 0){
			$im = Engine_Api::_()->getItem('storage_file', $item->photo_id);
			$item->photo_id = 0;
			$item->save();
			if($im)
			$im->delete();
		}

		if(!$item->getPhotoUrl()){
			$imgurl = $photoURL;
		} else
			$imgurl = $item->getPhotoUrl();
		echo json_encode(array('status'=>"true",'src'=>$imgurl));die;
	}

  //upload existing photo
	public function uploadExistingphotoAction(){

    $id = $this->_getParam('id', null);
    if(!$id){
      echo json_encode(array('status'=>"error"));die;
    }

    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesalbum')) {
      $photo = Engine_Api::_()->getItem('album_photo', $id);
    } else {
      $photo = Engine_Api::_()->getItem('photo', $id);
    }

    $user_id = $this->_getParam('user_id', null);
    if(null == $user_id){
      echo json_encode(array('status'=>"error"));die;
    }
    $user  = Engine_Api::_()->getItem('user', $user_id);

    // Process
    $db = $user->getTable()->getAdapter();
    $db->beginTransaction();
    try {

      // Get the owner of the photo
      $photoOwnerId = null;
      if( isset($photo->user_id) ) {
        $photoOwnerId = $photo->user_id;
      } else if( isset($photo->owner_id) && (!isset($photo->owner_type) || $photo->owner_type == 'user') ) {
        $photoOwnerId = $photo->owner_id;
      }

      // if it is from your own profile album do not make copies of the image
      if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesalbum')) {
        $albumModel = 'Sesalbum_Model_Album';
        $photoModel = 'Sesalbum_Model_Photo';
      } else {
        $albumModel = 'Album_Model_Album';
        $photoModel = 'Album_Model_Photo';
      }

      if( $photo instanceof $photoModel && ($photoParent = $photo->getParent()) instanceof $albumModel &&       $photoParent->owner_id == $photoOwnerId && $photoParent->type == 'profile' ) {

        // ensure thumb.icon and thumb.profile exist
        $newStorageFile = Engine_Api::_()->getItem('storage_file', $photo->file_id);
        $filesTable = Engine_Api::_()->getDbtable('files', 'storage');
        if( $photo->file_id == $filesTable->lookupFile($photo->file_id, 'thumb.profile') ) {
          try {
            $tmpFile = $newStorageFile->temporary();
            $image = Engine_Image::factory();
            $image->open($tmpFile)
              ->resize(200, 400)
              ->write($tmpFile)
              ->destroy();
            $iProfile = $filesTable->createFile($tmpFile, array(
              'parent_type' => $user->getType(),
              'parent_id' => $user->getIdentity(),
              'user_id' => $user->getIdentity(),
              'name' => basename($tmpFile),
            ));
            $newStorageFile->bridge($iProfile, 'thumb.profile');
            @unlink($tmpFile);
          } catch( Exception $e ) {	echo json_encode(array('status'=>"error"));die;}
        }

        if( $photo->file_id == $filesTable->lookupFile($photo->file_id, 'thumb.icon') ) {
          try {
            $tmpFile = $newStorageFile->temporary();
            $image = Engine_Image::factory();
            $image->open($tmpFile);
            $size = min($image->height, $image->width);
            $x = ($image->width - $size) / 2;
            $y = ($image->height - $size) / 2;
            $image->resample($x, $y, $size, $size, 48, 48)
              ->write($tmpFile)
              ->destroy();
            $iSquare = $filesTable->createFile($tmpFile, array(
              'parent_type' => $user->getType(),
              'parent_id' => $user->getIdentity(),
              'user_id' => $user->getIdentity(),
              'name' => basename($tmpFile),
            ));
            $newStorageFile->bridge($iSquare, 'thumb.icon');
            @unlink($tmpFile);
          } catch( Exception $e ) {	echo json_encode(array('status'=>"error"));die;}
        }

        // Set it
        $user->photo_id = $photo->file_id;
        $user->save();

        // Insert activity
        // @todo maybe it should read "changed their profile photo" ?
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($user, $user, 'profile_photo_update', '{item:$subject} changed their profile photo.');
        if( $action ) {
          // We have to attach the user himself w/o sesalbum plugin
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $photo);
        }
				$db->commit();
				echo json_encode(array('status'=>"true",'src'=>Engine_Api::_()->storage()->get($user->photo_id)->getPhotoUrl('')));die;
      }
      // Otherwise copy to the profile album
      else {
        $userUp = $user->setPhoto($photo);

        // Insert activity
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($user, $user, 'profile_photo_update', '{item:$subject} added a new profile photo.');

        // Hooks to enable albums to work
        $newStorageFile = Engine_Api::_()->getItem('storage_file', $user->photo_id);
        $event = Engine_Hooks_Dispatcher::_()->callEvent('onUserProfilePhotoUpload', array('user' => $user,      'file' => $newStorageFile));

        $attachment = $event->getResponse();
        if( !$attachment ) {
          $attachment = $newStorageFile;
        }

        if( $action  ) {
          // We have to attach the user himself w/o album plugin
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $attachment);
        }
      }

      $db->commit();
			echo json_encode(array('status'=>"true",'src'=>Engine_Api::_()->storage()->get($userUp->photo_id)->getPhotoUrl('')));die;
    }
    // Otherwise it's probably a problem with the database or the storage system (just throw it)
    catch( Exception $e )
    {
      $db->rollBack();
      echo json_encode(array('status'=>"error"));die;
    }
		echo json_encode(array('status'=>"error"));die;
	}

  //update cover photo function from existing photos
	public function uploadexistingcoverphotoAction(){

    $resource_type = $this->_getParam('resource_type', null);
	  $resource_id = $this->_getParam('resource_id', null);
	  $contentInfo = Engine_Api::_()->sescontentcoverphoto()->isResourceExist($resource_type, $resource_id);
	  $item = Engine_Api::_()->getItem($resource_type, $resource_id);

	  $id = $this->_getParam('id', null);
	  $user_id = $this->_getParam('user_id', null);
	  $photo = Engine_Api::_()->getItem('photo', $id);
	  $user  = Engine_Api::_()->getItem('user', $user_id);
	  $newStorageFile = Engine_Api::_()->getItem('storage_file', $photo->file_id)->storage_path;

		if(isset($newStorageFile))
			$data = $newStorageFile;

		try {
		  if($resource_type == 'album') {
        $type = 'cover';
      } else {
        $type = $resource_type;
      }
      $album = Engine_Api::_()->getApi('core', 'sescontentcoverphoto')->getSpecialAlbum($user, $type);

      $photoTable = Engine_Api::_()->getItemTable('photo');
      $photo = $photoTable->createRow();
      $photo->setFromArray(array(
          'owner_type' => 'user',
          'owner_id' => $user->getIdentity()
      ));
      $photo->save();
      $cover = $this->setCoverPhoto($data,$user, $item,$contentInfo);
      if(isset($photo->order))
      	$photo->order = $photo->photo_id;
      $photo->album_id = $album->album_id;
			$photo->file_id = $cover->cover;
      $photo->save();
      if (!$album->photo_id) {
        $album->photo_id = $photo->getIdentity();
        $album->save();
      }

			// Authorizations
			$auth = Engine_Api::_()->authorization()->context;
			$auth->setAllowed($photo, 'everyone', 'view', true);
			$auth->setAllowed($photo, 'everyone', 'comment', true);

		} catch(Exception $e){
			throw $e;
		}
		echo json_encode(array('status'=>"true",'src'=>Engine_Api::_()->storage()->get($cover->cover)->getPhotoUrl('')));die;
	}

	//get album photos as per given album id
	public function existingAlbumphotosAction(){

		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$this->view->album_id = $album_id = isset($_POST['id']) ? $_POST['id'] : 0;
		if($album_id == 0){
			echo "";die;
		}
		$paginator = $this->view->paginator = Engine_Api::_()->sescontentcoverphoto()->getPhotoSelect(array('album_id'=>$album_id,'pagNator'=>true));
		$limit = 12;
		$paginator->setItemCountPerPage($limit);
		$paginator->setCurrentPageNumber($page);
		$this->view->page = $page ;
	}

	//get existing photo for profile photo change widget
	public function existingPhotosAction(){
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$this->view->cover = isset($_POST['cover']) ? $_POST['cover'] : 'profile';
		$paginator = $this->view->paginator = Engine_Api::_()->sescontentcoverphoto()->getUserAlbum();
		$this->view->limit = $limit = 12;
		$paginator->setItemCountPerPage($limit);
		$this->view->page = $page ;
		$paginator->setCurrentPageNumber($page);
	}
}
