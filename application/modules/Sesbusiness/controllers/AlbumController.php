<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AlbumController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_AlbumController extends Core_Controller_Action_Standard {

  public function createAction() {

    if (isset($_GET['ul']) || isset($_FILES['Filedata']))
    return $this->_forward('upload-photo', null, null, array('format' => 'json'));

    $business_id = $this->_getParam('business_id',false);
    $album_id = $this->_getParam('album_id',false);
    if($album_id) {
    	$this->view->album = $album = Engine_Api::_()->getItem('sesbusiness_album', $album_id);
			$this->view->business_id = $business_id = $album->business_id;
		} else {
      $this->view->business_id = $business_id = $business_id;
		}

		$business = $this->view->business = Engine_Api::_()->getItem('businesses', $business_id);

    // set up data needed to check quota
    $viewer = Engine_Api::_()->user()->getViewer();
    $values['user_id'] = $viewer->getIdentity();
    $this->view->current_count = Engine_Api::_()->getDbTable('albums', 'sesbusiness')->getUserAlbumCount($values);
    $this->view->quota = $quota = 0;

    $sesbusiness_sesbusinessalbumcreate = Zend_Registry::isRegistered('sesbusiness_sesbusinessalbumcreate') ? Zend_Registry::get('sesbusiness_sesbusinessalbumcreate') : null;
    if(!empty($sesbusiness_sesbusinessalbumcreate)) {
      // Get form
      $this->view->form = $form = new Sesbusiness_Form_Album();
    }

    // Render
    if (!$this->getRequest()->isPost()) {
      if (null !== ($album_id = $this->_getParam('album_id'))) {
        $form->populate(array('album' => $album_id));
      }
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    $db = Engine_Api::_()->getItemTable('sesbusiness_album')->getAdapter();
    $db->beginTransaction();
    try {
      $album = $form->saveValues();
      // Add tags
      $values = $form->getValues();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    header('location:'.$album->getHref());
  }

  public function uploadPhotoAction() {

  	if(isset($_GET['business_id']) && $_GET['business_id'] != '') {
			$business_id = $_GET['business_id'];
		} else
			$business_id = $this->_getParam('business_id');
    $business = Engine_Api::_()->getItem('businesses', $business_id);

//     if (!$this->_helper->requireAuth()->setAuthParams($business, null, 'album')->isValid()) {
//       return;
//     }

    if (!$this->_helper->requireUser()->checkRequire()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Max file size limit exceeded (probably).');
      return;
    }

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    if(empty($_GET['isURL']) || $_GET['isURL'] == 'false'){
      $isURL = false;
      $values = $this->getRequest()->getPost();
      if (empty($values['Filename']) && !isset($_FILES['Filedata'])) {
				$this->view->status = false;
				$this->view->error = Zend_Registry::get('Zend_Translate')->_('No file');
				return;
      }
      if (!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
				$this->view->status = false;
				$this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid Upload');
				return;
      }
      $uploadSource = $_FILES['Filedata'];
    }
    else{
      $uploadSource = $_POST['Filedata'];
      $isURL = true;
    }
    $db = Engine_Api::_()->getDbTable('photos', 'sesbusiness')->getAdapter();
    $db->beginTransaction();
    try {
      $viewer = Engine_Api::_()->user()->getViewer();
      $photoTable = Engine_Api::_()->getDbTable('photos', 'sesbusiness');
      $photo = $photoTable->createRow();
      $photo->setFromArray(array(
				'business_id' => $business->business_id,
				'user_id' => $viewer->getIdentity()
      ));
			//wall photos
			$album = null;
			$type = $this->_getParam('type',null);

			if($type == 'wall') {
				$viewer = Engine_Api::_()->user()->getViewer();
				 $table = Engine_Api::_()->getDbTable('albums', 'sesbusiness');
				$album = $table->getSpecialAlbum($viewer, $type,$business->business_id);
			}
      $photo->save();
      //$photo->order = $photo->photo_id;
      $photo = $photo->setAlbumPhoto($uploadSource,$isURL,false,$album);
      $photo->collection_id = $photo->album_id;
      $photo->save();
      if(!$photo){
				$db->rollBack();
				$this->view->status = false;
				$this->view->error = 'An error occurred.';
				return;
      }
      $photo->save();
			if($album){
				if(!$album->photo_id)	{
					$album->photo_id = $photo->photo_id;
					$album->save();
				}
			}
      $this->view->status = true;
      $this->view->photo_id = $photo->photo_id;
      $this->view->url = $photo->getAlbumPhotoUrl('thumb.normalmain');
      $db->commit();
    }catch (Sesbusiness_Model_Exception $e) {
      $db->rollBack();
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('An error occurred.');
      throw $e;
      return;
    }
    if(isset($_GET['ul']) || $this->_getParam('type'))
    	echo json_encode(array('status'=>$this->view->status,'name'=>'','photo_id'=> $this->view->photo_id,'src'=> $photo->getPhotoUrl('thumb.normalmain')));die;
  }


  //album view function.
  public function viewAction() {
		$album_id = $this->_getParam('album_id');
		$album = null;
    if ($album_id) {
      $album = Engine_Api::_()->getItem('sesbusiness_album', $album_id);
      if ($album) {
     	  Engine_Api::_()->core()->setSubject($album);
      }else
				return $this->_forward('requireauth', 'error', 'core');
		}

		$viewer = Engine_Api::_()->user()->getViewer();
    /* Insert data for recently viewed widget */
    if ($viewer->getIdentity() != 0 && isset($album->album_id)) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_sesbusiness_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $album->album_id . '", "sesbusiness_album","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
    }

    // Render
    $this->_helper->content
            ->setEnabled();
  }

	public function homeAction() {
			// Render
    $sesbusiness_sesbusinessalbumhome = Zend_Registry::isRegistered('sesbusiness_sesbusinessalbumhome') ? Zend_Registry::get('sesbusiness_sesbusinessalbumhome') : null;
    if(!empty($sesbusiness_sesbusinessalbumhome)) {
      $this->_helper->content->setEnabled();
    }
	}

	public function browseAction() {
    // Render
    $sesbusiness_sesbusinessbrowsealbum = Zend_Registry::isRegistered('sesbusiness_sesbusinessbrowsealbum') ? Zend_Registry::get('sesbusiness_sesbusinessbrowsealbum') : null;
    if(!empty($sesbusiness_sesbusinessbrowsealbum)) {
      $this->_helper->content->setEnabled();
    }
	}

  //function for autosuggest album
  public function getAlbumAction() {
    $sesdata = array();
    $value['text'] = $this->_getParam('text');
    $albums = Engine_Api::_()->getDbTable('albums', 'sesbusiness')->getAlbumsAction($value);
    foreach ($albums as $album) {
      $album_icon_photo = $this->view->itemPhoto($album, 'thumb.icon');
      $sesdata[] = array(
          'id' => $album->album_id,
          'label' => $album->title,
          'photo' => $album_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }

  //album edit action
  public function editAction() {
    if (!$this->_helper->requireUser()->isValid())
      return;
		$album_id = $this->_getParam('album_id',false);
    if($album_id)
    $this->view->album = $album = Engine_Api::_()->getItem('sesbusiness_album', $album_id);
	  else
			return;
		$this->view->business = $business = Engine_Api::_()->getItem('businesses', $album->business_id);
		if ($business) {
			Engine_Api::_()->core()->setSubject($business);
		}else{
			return;
		}
    if (!$this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid())
      return;

    // Make form
    $this->view->form = $form = new Sesbusiness_Form_Album_Edit();
		$form->populate($album->toArray());
		 if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    //is post
    if (!$form->isValid($this->getRequest()->getPost())) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    // Process
    $db = $album->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $values = $form->getValues();
      $album->setFromArray($values);
      $album->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $db->beginTransaction();
    $url = $album->getHref();
    header('location:' . $url);
  }

  // album delete action
  public function deleteAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$this->_helper->requireUser()->isValid())
      return;

		$album_id = $this->_getParam('album_id',false);
    if($album_id)
    $this->view->album = $album = Engine_Api::_()->getItem('sesbusiness_album', $album_id);
	  else
			return;

		$business = Engine_Api::_()->getItem('businesses', $album->business_id);
		if ($business) {
			Engine_Api::_()->core()->setSubject($business);
		} else {
			return;
		}

    if (!$this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid())
      return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $this->view->form = $form = new Sesbusiness_Form_Album_Delete();
    if (!$album) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Album doesn't exists or not authorized to delete");
      return;
    }

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $album->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $album->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected albums have been successfully deleted.');
    return $this->_forward('success', 'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('id'=>$business->custom_url), 'sesbusiness_profile', true),
      'messages' => Array($this->view->message)
    ));
  }

  // function for edit photo action
  public function editphotosAction() {
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $pageNumber = isset($_POST['page']) ? $_POST['page'] : 1;
		$album_id = $this->_getParam('album_id',false);
		if($album_id){
		 $this->view->album =	$album = Engine_Api::_()->getItem('sesbusiness_album', $album_id);
			$this->view->business_id = $business_id = $album->business_id;
			$business = $this->view->sesbusiness = Engine_Api::_()->getItem('businesses', $business_id);
		}else{
			return $this->_forward('notfound', 'error', 'core');
		}
    if (!$is_ajax) {
      if (!$this->_helper->requireUser()->isValid())
        return;
      if (!$this->_helper->requireAuth()->setAuthParams($business, null, 'edit')->isValid())
        return;
    }
    if (!$is_ajax) {
      // Get navigation
      $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
              ->getNavigation('sesbusiness_main');
      // Hack navigation
      foreach ($navigation->getPages() as $business) {
        if ($business->route != 'sesbusiness_general' || $business->action != 'manage')
          continue;
        $business->active = true;
      }
    }
    // Prepare data
    $photoTable = Engine_Api::_()->getItemTable('sesbusiness_photo');
    $this->view->paginator = $paginator = $photoTable->getPhotoPaginator(array(
        'album' => $album,
        'order' => 'order ASC'
    ));
    $this->view->album_id = $album->album_id;
    $paginator->setCurrentPageNumber ($pageNumber);
    $itemCount = (count($_POST) > 0 && !$is_ajax) ? count($_POST) : 10;
    $paginator->setItemCountPerPage($itemCount);
    $this->view->page = $pageNumber;
    // Get albums
    $myAlbums = Engine_Api::_()->getDbTable('albums', 'sesbusiness')->editPhotos();
    $albumOptions = array('' => '');
    foreach ($myAlbums as $myAlbum) {
      $albumOptions[$myAlbum['album_id']] = $myAlbum['title'];
    }
    if (count($albumOptions) == 1) {
      $albumOptions = array();
    }
    // Make form
    $this->view->form = $form = new Sesbusiness_Form_Album_Photos();
    foreach ($paginator as $photo) {
      $subform = new Sesbusiness_Form_Album_EditPhoto(array('elementsBelongTo' => $photo->getGuid()));
      $subform->populate($photo->toArray());
      $form->addSubForm($subform, $photo->getGuid());
      $form->cover->addMultiOption($photo->getIdentity(), $photo->getIdentity());
      if (empty($albumOptions)) {
        $subform->removeElement('move');
      } else {
        $subform->move->setMultiOptions($albumOptions);
      }
    }
    if ($is_ajax) {
      return;
    }
    if (!$this->getRequest()->isPost()) {
      return;
    }
    $table = $album->getTable();
    $db = $table->getAdapter();
    $db->beginTransaction();
    try {
      $values = $_POST;
      if (!empty($values['cover'])) {
        $album->photo_id = $values['cover'];
        $album->save();
      }
      // Process
      foreach ($paginator as $photo) {
        if (isset($_POST[$photo->getGuid()])) {
          $values = $_POST[$photo->getGuid()];
        } else {
          continue;
        }
        unset($values['photo_id']);
        if (isset($values['delete']) && $values['delete'] == '1') {
					if($album->photo_id == $photo->photo_id){
						$album->photo_id = 0;
						$photoCn = Engine_Api::_()->getDbTable('photos', 'sesbusiness')->getPhotoSelect(array('album_id'=>$album->album_id,'fetchAll'=>true,'limit_data'=>1));
						if(count($photoCn)){
								$photo_id_album = $photoCn[0]->photo_id;
								$album->photo_id = $photo_id_album;
								$album->save();
						}
					}
          $photo->delete();
        } else if (!empty($values['move'])) {
          $nextPhoto = $photo->getNextPhoto();
          $old_album_id = $photo->album_id;
          $photo->album_id = $values['move'];
          $photo->save();
          // Change album cover if necessary
          if (($nextPhoto instanceof Sesbusiness_Model_Photo) &&
                  (int) $album->photo_id == (int) $photo->getIdentity()) {
            $album->photo_id = $nextPhoto->getIdentity();
            $album->save();
          }
          // Remove activity attachments for this photo
          Engine_Api::_()->getDbTable('actions', 'activity')->detachFromActivity($photo);
        } else {
          $photo->setFromArray($values);
          $photo->save();
        }
      }
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    //send to specific album view business.
    return $this->_helper->redirector->gotoRoute(array('action' => 'view', 'album_id' => $album->album_id), 'sesbusiness_specific_album', true);
  }


  public function removeAction() {

    if(empty($_POST['photo_id']))
    die('error');
    //GET PHOTO ID AND ITEM
    $photo_id = (int) $this->_getParam('photo_id');
    $photo = Engine_Api::_()->getItem('sesbusiness_photo', $photo_id);
    $db = Engine_Api::_()->getDbTable('photos', 'sesbusiness')->getAdapter();
    $db->beginTransaction();
    try {
      $photo->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function editPhotoAction() {

    $this->view->photo_id = $photo_id = $this->_getParam('photo_id');
    $this->view->photo = Engine_Api::_()->getItem('sesbusiness_photo', $photo_id);
  }

  public function saveInformationAction() {

    $photo_id = $this->_getParam('photo_id');
    $title = $this->_getParam('title', null);
    $description = $this->_getParam('description', null);
    Engine_Api::_()->getDbTable('photos', 'sesbusiness')->update(array('title' => $title, 'description' => $description), array('photo_id = ?' => $photo_id));
  }
		//update cover photo function
	public function uploadCoverAction(){
		$album_id = $this->_getParam('album_id', '0');
		if ($album_id == 0)
			return;
		$album = Engine_Api::_()->getItem('sesbusiness_album', $album_id);
		if(!$album)
			return;
		$art_cover = $album->art_cover;
		if(isset($_FILES['Filedata']))
			$data = $_FILES['Filedata'];
		else if(isset($_FILES['webcam']))
			$data = $_FILES['webcam'];
		$album->setCoverPhoto($data);
		if($art_cover != 0){
			$im = Engine_Api::_()->getItem('storage_file', $art_cover);
			$im->delete();
		}
		echo json_encode(array('file'=>Engine_Api::_()->storage()->get($album->art_cover)->getPhotoUrl('')));die;
	}
	//remove cover photo action
	public function removeCoverAction(){
		$album_id = $this->_getParam('album_id', '0');
		if ($album_id == 0)
			return;
		$album = Engine_Api::_()->getItem('sesbusiness_album', $album_id);
		if(!$album)
			return;
		if(isset($album->art_cover) && $album->art_cover>0){
			$im = Engine_Api::_()->getItem('storage_file', $album->art_cover);
			$album->art_cover = 0;
			$album->save();
			$im->delete();
		}
		echo "true";die;
	}
}
