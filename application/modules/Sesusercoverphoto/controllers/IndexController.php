<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercoverphoto
 * @package    Sesusercoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2016-05-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesusercoverphoto_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }
	public function confirmationAction(){

	}
	 public function rateAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $user_id = $viewer->getIdentity();
    $rating = $this->_getParam('rating');
    $resource_id = $this->_getParam('resource_id');
    $resource_type = $this->_getParam('resource_type');
    $table = Engine_Api::_()->getDbtable('ratings', 'sesmember');
    $db = $table->getAdapter();
    $db->beginTransaction();
    try {
      Engine_Api::_()->getDbtable('ratings', 'sesmember')->setRating($resource_id, $user_id, $rating, $resource_type);

			$item = Engine_Api::_()->getItem('user', $resource_id);
      $item->rating = Engine_Api::_()->getDbtable('ratings', 'sesmember')->getRating($item->getIdentity(), $resource_type);
      $item->save();

      $type = 'sesmember_user_rating';

      //Activity Feed / Notification
        $owner = $item->getOwner();
        if ($viewer->getIdentity() != $item->user_id) {
          Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $type, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));

          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $item, $type);
        }

      $result = Engine_Api::_()->getDbtable('actions', 'activity')->fetchRow(array('type =?' => $type, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      if (!$result) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $item, $type);
        if ($action)
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $item);
      }

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $total = Engine_Api::_()->getDbtable('ratings', 'sesmember')->ratingCount($item->getIdentity(), $resource_type);
    $rating_sum = Engine_Api::_()->getDbtable('ratings', 'sesmember')->getSumRating($item->getIdentity(), $resource_type);
    $data = array();
    $totalTxt = $this->view->translate(array('%s rating', '%s ratings', $total), $total);
    $data[] = array(
        'total' => $total,
        'rating' => $rating,
        'totalTxt' => str_replace($total, '', $totalTxt),
        'rating_sum' => $rating_sum
    );
    return $this->_helper->json($data);
  }
		//update cover photo function
	public function editCoverphotoAction(){
		$user_id = $this->_getParam('user_id', '0');
		if ($user_id == 0)
			return;
		$user = Engine_Api::_()->getItem('user', $user_id);
		if(!$user)
			return;
		$art_cover = $user->coverphoto;
		if(isset($_FILES['Filedata']))
			$data = $_FILES['Filedata'];
		else if(isset($_FILES['webcam']))
			$data = $_FILES['webcam'];
		try{
      $type = 'cover';
      $album = Engine_Api::_()->getApi('core', 'sesusercoverphoto')->getSpecialAlbum($user, $type);

      $photoTable = Engine_Api::_()->getItemTable('photo');
      $photo = $photoTable->createRow();
      $photo->setFromArray(array(
          'owner_type' => 'user',
          'owner_id' => $user->getIdentity()
      ));
      $photo->save();
      $user = $this->setCoverPhoto($data,$user);
      if(isset($photo->order))
      	$photo->order = $photo->photo_id;
      $photo->album_id = $album->album_id;
			$photo->file_id = $user->coverphoto;
      $photo->save();
      if (!$album->photo_id) {
        $album->photo_id = $photo->getIdentity();
        $album->save();
      }

      //Cover Video Plugin
      if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesusercovevideo') && isset($user->cover_video)) {
        $user->cover_video = 0;
        $user->save();
      }

			// Authorizations
			$auth = Engine_Api::_()->authorization()->context;
			$auth->setAllowed($photo, 'everyone', 'view', true);
			$auth->setAllowed($photo, 'everyone', 'comment', true);

		}catch(Exception $e){
			throw $e;
		}

		if($art_cover != 0){
			//$im = Engine_Api::_()->getItem('storage_file', $art_cover);
			//$im->delete();
		}
		echo json_encode(array('status'=>"true",'src'=>Engine_Api::_()->storage()->get($user->coverphoto)->getPhotoUrl('')));die;
	}
	//remove cover photo action
	public function removeCoverAction(){
		$user_id = $this->_getParam('user_id', '0');
		if ($user_id == 0)
			return;
		$user = Engine_Api::_()->getItem('user', $user_id);
		if(!$user)
			return;
		if(isset($user->coverphoto) && $user->coverphoto > 0){
			//$im = Engine_Api::_()->getItem('storage_file', $user->coverphoto);
			$user->coverphoto = 0;
			$user->coverphotoparams = Zend_Json_Encoder::encode(array('top' => '0', 'left' => 0));
			$user->save();
			//$im->delete();
		}
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesusercovervideo')) {
      if(isset($user->cover_video))
        $user->cover_video = 0;
      if(isset($user->coverphoto))
        $user->coverphoto = 0;
      $user->coverphotoparams = Zend_Json_Encoder::encode(array('top' => '0', 'left' => 0));
      $user->save();
    }
		$viewer = $user;
    if ($viewer->getIdentity() == 0)
      $level = Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel()->level_id;
    else
      $level = $user;
		$defaultCoverPhoto = Engine_Api::_()->authorization()->getPermission($level, 'sesusercover', 'defaultcover');
		if($defaultCoverPhoto != 0 || $defaultCoverPhoto != '')
			$defaultCoverPhoto = $defaultCoverPhoto;
		else
			$defaultCoverPhoto = 'application/modules/Sesusercoverphoto/externals/images/default_cover.jpg';

		echo json_encode(array('status'=>1,'src'=>$defaultCoverPhoto));die;

	}

	public function setCoverPhoto($photo,$user){
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
    $user->modified_date = date('Y-m-d H:i:s');
    $user->coverphoto = $iMain->file_id;
    $user->save();
    // Delete the old file?
    if( !empty($tmpRow) ) {
      $tmpRow->delete();
    }
    return $user;
	}

	public function uploadMainAction(){
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

    if( !$this->getRequest()->isPost() ) {
      echo json_encode(array('status'=>"error"));die;
    }
    // Uploading a new photo
    if(isset($_FILES['webcam']['tmp_name']) && $_FILES['webcam']['tmp_name'] != '') {
      $db = $user->getTable()->getAdapter();
      $db->beginTransaction();

      try {
        $userUp = $user->setPhoto($_FILES['webcam']);

        $iMain = Engine_Api::_()->getItem('storage_file', $user->photo_id);

        // Insert activity
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($user, $user, 'profile_photo_update',
          '{item:$subject} added a new profile photo.');

        // Hooks to enable albums to work
        if( $action ) {
          $event = Engine_Hooks_Dispatcher::_()
            ->callEvent('onUserProfilePhotoUpload', array(
                'user' => $user,
                'file' => $iMain,
              ));

          $attachment = $event->getResponse();
          if( !$attachment ) $attachment = $iMain;

          // We have to attach the user himself w/o album plugin
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $attachment);
        }

        $db->commit();
        $file = Engine_Api::_()->getItemTable('storage_file')->getFile($userUp->photo_id, '');
        echo json_encode(array('status'=>"true",'src'=>$file->map()));die;
      }
      // If an exception occurred within the image adapter, it's probably an invalid image
      catch( Engine_Image_Adapter_Exception $e )
      {
        $db->rollBack();
        echo json_encode(array('status'=>"error"));die;
      }
    }
  	 echo json_encode(array('status'=>"false"));die;

	}
	public function repositionCoverAction(){
		$user_id = $this->_getParam('user_id', '0');
		if ($user_id == 0)
			return;
		$user = Engine_Api::_()->getItem('user', $user_id);
		if(!$user)
			return;

		$position = $this->_getParam('position', '0');

		if(!empty($position)) {
            $user->coverphotoparams = Zend_Json_Encoder::encode(array('top' => str_replace('px', '',$position), 'left' => 0));
            $user->save();
        } else {
            $user->coverphotoparams = Zend_Json_Encoder::encode(array('top' => 0, 'left' => 0));
            $user->save();
        }
		echo json_encode(array('status'=>"1"));die;
	}

	public function removeMainAction(){
		$user_id = $this->_getParam('user_id', '0');
		if ($user_id == 0)
			return;
		$user = Engine_Api::_()->getItem('user', $user_id);
		if(!$user)
			return;
		if(isset($user->photo_id) && $user->photo_id > 0){
			$im = Engine_Api::_()->getItem('storage_file', $user->photo_id);
			$user->photo_id = 0;
			$user->save();
			$im->delete();
		}

		if(!$user->getPhotoUrl('')){
			$imgurl = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png';
		}else
			$imgurl = $user->getPhotoUrl();
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
      if( $photo instanceof $photoModel &&
          ($photoParent = $photo->getParent()) instanceof $albumModel &&
          $photoParent->owner_id == $photoOwnerId &&
          $photoParent->type == 'profile' ) {

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
        $action = Engine_Api::_()->getDbtable('actions', 'activity')
            ->addActivity($user, $user, 'profile_photo_update',
                '{item:$subject} changed their profile photo.');
        if( $action ) {
          // We have to attach the user himself w/o sesalbum plugin
          Engine_Api::_()->getDbtable('actions', 'activity')
              ->attachActivity($action, $photo);
        }
				$db->commit();
				echo json_encode(array('status'=>"true",'src'=>Engine_Api::_()->storage()->get($user->photo_id)->getPhotoUrl('')));die;
      }

      // Otherwise copy to the profile album
      else {
        $userUp = $user->setPhoto($photo);

        // Insert activity
        $action = Engine_Api::_()->getDbtable('actions', 'activity')
            ->addActivity($user, $user, 'profile_photo_update',
                '{item:$subject} added a new profile photo.');

        // Hooks to enable albums to work
        $newStorageFile = Engine_Api::_()->getItem('storage_file', $user->photo_id);
        $event = Engine_Hooks_Dispatcher::_()
          ->callEvent('onUserProfilePhotoUpload', array(
              'user' => $user,
              'file' => $newStorageFile,
            ));

        $attachment = $event->getResponse();
        if( !$attachment ) {
          $attachment = $newStorageFile;
        }

        if( $action  ) {
          // We have to attach the user himself w/o album plugin
          Engine_Api::_()->getDbtable('actions', 'activity')
              ->attachActivity($action, $attachment);
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

	  $id = $this->_getParam('id', null);
	  $user_id = $this->_getParam('user_id', null);
	  $photo = Engine_Api::_()->getItem('photo', $id);
	  $user  = Engine_Api::_()->getItem('user', $user_id);
	  $newStorageFile = Engine_Api::_()->getItem('storage_file', $photo->file_id)->storage_path;

		if(isset($newStorageFile))
			$data = $newStorageFile;

		try{
      $type = 'cover';
      $album = Engine_Api::_()->getApi('core', 'sesusercoverphoto')->getSpecialAlbum($user, $type);

      $photoTable = Engine_Api::_()->getItemTable('photo');
      $photo = $photoTable->createRow();
      $photo->setFromArray(array(
          'owner_type' => 'user',
          'owner_id' => $user->getIdentity()
      ));
      $photo->save();
      $user = $this->setCoverPhoto($data,$user);
      if(isset($photo->order))
      	$photo->order = $photo->photo_id;
      $photo->album_id = $album->album_id;
			$photo->file_id = $user->coverphoto;
      $photo->save();
      if (!$album->photo_id) {
        $album->photo_id = $photo->getIdentity();
        $album->save();
      }

			// Authorizations
			$auth = Engine_Api::_()->authorization()->context;
			$auth->setAllowed($photo, 'everyone', 'view', true);
			$auth->setAllowed($photo, 'everyone', 'comment', true);

		}catch(Exception $e){
			throw $e;
		}
		echo json_encode(array('status'=>"true",'src'=>Engine_Api::_()->storage()->get($user->coverphoto)->getPhotoUrl('')));die;
	}

	//get album photos as per given album id
	public function existingAlbumphotosAction(){
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$this->view->album_id = $album_id = isset($_POST['id']) ? $_POST['id'] : 0;
		if($album_id == 0){
			echo "";die;
		}
		$paginator = $this->view->paginator = Engine_Api::_()->sesusercoverphoto()->getPhotoSelect(array('album_id'=>$album_id,'pagNator'=>true));
		$limit = 12;
		$paginator->setItemCountPerPage($limit);
		$paginator->setCurrentPageNumber($page);
		$this->view->page = $page ;
	}

	//get existing photo for profile photo change widget
	public function existingPhotosAction(){
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$this->view->coverphoto = isset($_POST['cover']) ? $_POST['cover'] : 'profile';
		$paginator = $this->view->paginator = Engine_Api::_()->sesusercoverphoto()->getUserAlbum();
		$this->view->limit = $limit = 12;
		$paginator->setItemCountPerPage($limit);
		$this->view->page = $page ;
		$paginator->setCurrentPageNumber($page);
	}
}
