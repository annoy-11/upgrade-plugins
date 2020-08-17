<?php

class Sesusercovervideo_IndexController extends Core_Controller_Action_Standard {

  public function uploadAction() {

    $this->_helper->layout->setLayout('default-simple');
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    $this->view->form = $form = new Sesusercovervideo_Form_UploadVideo();
    $subject = Engine_Api::_()->getItem('user', $this->_getParam('subject_id', null));
    $subject_id = $subject->getIdentity();
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {

        $storage = Engine_Api::_()->getItemTable('storage_file');
        $filename = $storage->createFile($form->file, array(
          'parent_id' => $subject_id,
          'parent_type' => 'sesusercovervideo',
          'user_id' => $subject_id,
          'cover_video' => '1',
        ));
        // Remove temporary file
        @unlink($file['tmp_name']);


        $filenamephoto = $storage->createFile($form->photo, array(
          'parent_id' => $subject_id,
          'parent_type' => 'sesusercovervideo',
          'user_id' => $subject_id,
        ));
        // Remove temporary file
        @unlink($file['tmp_name']);


        Engine_Api::_()->getDbTable('users', 'user')->update(array('cover_video'=>  $filename->file_id), array('user_id =?' => $subject_id));
        Engine_Api::_()->getDbTable('videos', 'sesusercovervideo')->update(array('cover_video'=>  0), array('user_id =?' => $subject_id));

        $table = Engine_Api::_()->getDbTable('videos', 'sesusercovervideo');
        $video = $table->createRow();
        $video->user_id = $subject_id;
        $video->file_id = $filename->file_id;
        $video->storage_path = $filename->storage_path;
        $video->photo_id = $filenamephoto->file_id;
        $video->cover_video = '1';
        $video->save();

        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesusercoverphoto')) {
          $viewer->coverphoto = $filenamephoto->file_id;
          $viewer->save();
        }
      }

      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('Slide Delete Successfully.')
      ));
    }
  }


	public function uploadexistingcovervideoAction(){

	  $id = $this->_getParam('id', null);
	  $user_id = $this->_getParam('user_id', null);
	  $video = Engine_Api::_()->getItem('sesusercovervideo_video', $id);
	  Engine_Api::_()->getDbTable('videos', 'sesusercovervideo')->update(array('cover_video'=>  0), array('user_id =?' => $user_id));
	  $video->cover_video = '1';
	  $video->save();
	  $user  = Engine_Api::_()->getItem('user', $user_id);
	  $user->cover_video = $video->file_id;
	  $user->save();
	  $newStorageFile = Engine_Api::_()->getItem('storage_file', $video->file_id)->storage_path;

		if(isset($newStorageFile))
			$data = $newStorageFile;
		echo json_encode(array('status'=>"true",'src' => $data));die;
	}

	public function existingVideosAction() {
		$this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
		$this->view->cover = 'cover';
		$paginator = $this->view->paginator = Engine_Api::_()->sesusercovervideo()->getUserVideo();
		$this->view->limit = $limit = 50;
		$paginator->setItemCountPerPage($limit);
		$paginator->setCurrentPageNumber($page);
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

	//remove cover photo action
	public function removeCoverAction() {

		$user_id = $this->_getParam('user_id', '0');
		if ($user_id == 0)
			return;
		$user = Engine_Api::_()->getItem('user', $user_id);
		if(!$user)
			return;
        $isUserVideo = Engine_Api::_()->getDbTable('videos', 'sesusercovervideo')->isUserVideo(array('user_id' => $this->subject->getIdentity()));
		if(isset($isUserVideo) && $isUserVideo > 0) {
      Engine_Api::_()->getDbTable('videos', 'sesusercovervideo')->update(array('cover_video'=>  0), array('user_id =?' => $user_id));
			$im = Engine_Api::_()->getItem('storage_file', $user->cover_video);
			$user->cover_video = 0;
			$user->save();
			$im->delete();
		}

		$viewer = $user;
        if ($viewer->getIdentity() == 0)
            $level = Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel()->level_id;
        else
            $level = $user;
		$defaultCoverPhoto = Engine_Api::_()->authorization()->getPermission($level, 'sesusercovevideo', 'defaultcovephoto');
		if($defaultCoverPhoto != 0 || $defaultCoverPhoto != '')
			$defaultCoverPhoto = $defaultCoverPhoto;
		else
			$defaultCoverPhoto = 'application/modules/Sesusercovervideo/externals/images/default_cover.jpg';

		echo json_encode(array('status'=>1,'src'=>$defaultCoverPhoto));die;

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
}
