<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AlbumController.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_AlbumController extends Core_Controller_Action_Standard {

  public function init() {

    //Get viewer info
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    //Get subject
    if (null !== ($album_id = $this->_getParam('album_id')) && null !== ($album = Engine_Api::_()->getItem('seseventmusic_album', $album_id)) && $album instanceof Seseventmusic_Model_Album && !Engine_Api::_()->core()->hasSubject()) {
      Engine_Api::_()->core()->setSubject($album);
    }
  }

  //Edit Action
  public function editAction() {

    //Render
    $this->_helper->content->setEnabled();

    //Catch uploads from FLASH fancy-uploader and redirect to uploadSongAction()
    if ($this->getRequest()->getQuery('ul', false))
      return $this->_forward('add-song', null, null, array('format' => 'json'));

    //Only members can upload music
    if (!$this->_helper->requireUser()->isValid())
      return;

    if (!$this->_helper->requireSubject('seseventmusic_album')->isValid())
      return;

    //Get album
    $this->view->album = $album = Engine_Api::_()->core()->getSubject('seseventmusic_album');
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $canEdit = Engine_Api::_()->authorization()->isAllowed('sesevent_event', $viewer, 'edit'); 
    if(!$canEdit)
	    return $this->_forward('requireauth', 'error', 'core');

    //Only user and admins and moderators can edit
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.checkmusic'))
      return $this->_forward('notfound', 'error', 'core');
    //Make form
    $this->view->form = $form = new Seseventmusic_Form_Edit();

    $form->populate($album);

    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    $db = Engine_Api::_()->getDbTable('albums', 'seseventmusic')->getAdapter();
    $db->beginTransaction();
    try {

      $form->saveValues();
      $db->commit();

      //Count Songs according to album_id
      $song_count = Engine_Api::_()->getDbTable('albumsongs', 'seseventmusic')->songsCount($album->album_id);
      $album->song_count = $song_count;
      $album->save();
    } catch (Exception $e) {
      $db->rollback();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'view', 'album_id' => $album->album_id, 'slug' => $album->getSlug()), 'seseventmusic_album_view', true);
  }

  //View Action
  public function viewAction() {

    //Set layout
    if ($this->_getParam('popout')) {
      $this->view->popout = true;
      $this->_helper->layout->setLayout('default-simple');
    }

    //Check subject
    if (!$this->_helper->requireSubject()->isValid())
      return;

    //Get viewer/subject
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->viewer_id = $viewer->getIdentity();
    $this->view->album = $album = Engine_Api::_()->core()->getSubject('seseventmusic_album');

    $event = Engine_Api::_()->getItem('sesevent_event', $album->resource_id);
    $canView = $event->authorization()->isAllowed($viewer, 'view');
    if(!$canView)
	    return $this->_forward('requireauth', 'error', 'core');

    if (!$settings->getSetting('seseventmusic.checkmusic'))
      return $this->_forward('notfound', 'error', 'core');

    /* Insert data for recently viewed widget */
    if ($viewer->getIdentity() != 0 && isset($album->album_id)) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_seseventmusic_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $album->album_id . '", "seseventmusic_album","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
    }

    //Can create
    $this->view->canEdit = Engine_Api::_()->authorization()->isAllowed('sesevent_event', $viewer, 'edit');
    $this->view->canDelete = Engine_Api::_()->authorization()->isAllowed('sesevent_event', $viewer, 'delete');

    $this->view->downloadAlbumSong = Engine_Api::_()->authorization()->isAllowed('seseventmusic_album', $viewer, 'download_albumsong');

    $this->view->canAddFavouriteAlbumSong = Engine_Api::_()->authorization()->isAllowed('seseventmusic_album', $viewer, 'addfavourite_albumsong');

    $allowShowRating = $settings->getSetting('seseventmusic.ratealbumsong.show', 1);
    $allowRating = $settings->getSetting('seseventmusic.albumsong.rating', 1);
    if ($allowRating == 0) {
      if ($allowShowRating == 0)
        $showRating = false;
      else
        $showRating = true;
    }
    else
      $showRating = true;
    $this->view->showAlbumSongRating = $showRating;

    //Increment view count
    if (!$viewer->isSelf($album->getOwner())) {
      $album->view_count++;
      $album->save();
    }

    //Favourite work
    $this->view->isFavourite = Engine_Api::_()->getDbTable('favourites', 'seseventmusic')->isFavourite(array('resource_type' => "seseventmusic_album", 'resource_id' => $album->getIdentity()));

    //Rating Work
    $this->view->rating_count = Engine_Api::_()->getDbTable('ratings', 'seseventmusic')->ratingCount($album->getIdentity(), 'seseventmusic_album');

    $this->view->rated = Engine_Api::_()->getDbTable('ratings', 'seseventmusic')->checkRated($album->getIdentity(), $viewer->getIdentity(), 'seseventmusic_album');

    //Album Settings
    $this->view->albumlink_value = unserialize($settings->getSetting('seseventmusic.albumlink'));

    //Songs settings.
    $this->view->songlink = unserialize($settings->getSetting('seseventmusic.songlink'));

    //Render
    $this->_helper->content->setEnabled();
  }

  //Rating Action
  public function rateAction() {

    $rating = $this->_getParam('rating');
    $resource_id = $this->_getParam('resource_id');
    $resource_type = $this->_getParam('resource_type');
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $item = Engine_Api::_()->getItem($resource_type, $resource_id);

    $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
    $activityStreamTable = Engine_Api::_()->getDbtable('stream', 'activity');
    $table = Engine_Api::_()->getDbtable('ratings', 'seseventmusic');

    $db = $table->getAdapter();
    $db->beginTransaction();
    try {

      $table->setRating($resource_id, $viewer_id, $rating, $resource_type);
      $item = Engine_Api::_()->getItem($resource_type, $resource_id);
      $item->rating = $table->getRating($item->getIdentity(), $resource_type);
      $rating_sum = $table->getSumRating($item->getIdentity(), $resource_type);
      $item->save();

      if ($resource_type == 'seseventmusic_album') {
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => "seseventmusic_rated_musicalbum", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
        $owner = $item->getOwner();
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'seseventmusic_rated_musicalbum');
        $result = $activityTable->fetchRow(array('type =?' => "seseventmusic_albumrating", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $item, 'seseventmusic_albumrating');
          if ($action)
            $activityTable->attachActivity($action, $item);
        }
      } elseif ($resource_type == 'seseventmusic_albumsong') {
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => "seseventmusic_rated_song", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
        $owner = $item->getOwner();
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'seseventmusic_rated_song');
        $result = $activityTable->fetchRow(array('type =?' => "seseventmusic_songrating", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $item, 'seseventmusic_songrating');
          if ($action) {
            $activityStreamTable->delete(array('action_id =?' => $action->action_id));
            $db->query("INSERT INTO `engine4_activity_stream` (`target_type`, `target_id`, `subject_type`, `subject_id`, `object_type`, `object_id`, `type`, `action_id`) VALUES
('everyone', 0, 'user', $viewer_id, 'seseventmusic_albumsong', $resource_id, 'seseventmusic_songrating', $action->action_id),
('members', $viewer_id, 'user', $viewer_id, 'seseventmusic_albumsong', $resource_id, 'seseventmusic_songrating', $action->action_id),
('owner', $viewer_id, 'user', $viewer_id, 'seseventmusic_albumsong', $resource_id, 'seseventmusic_songrating', $action->action_id),
('parent', $viewer_id, 'user', $viewer_id, 'seseventmusic_albumsong', $resource_id, 'seseventmusic_songrating', $action->action_id),
('registered', 0, 'user', $viewer_id, 'seseventmusic_albumsong', $resource_id, 'seseventmusic_songrating', $action->action_id);");
            $activityTable->attachActivity($action, $item);
          }
        }
      }
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $total = $table->ratingCount($item->getIdentity(), $resource_type);
    $data = array();
    $data[] = array(
        'total' => $total,
        'rating' => $rating,
        'rating_sum' => $rating_sum,
    );
    return $this->_helper->json($data);
    $data = Zend_Json::encode($data);
    $this->getResponse()->setBody($data);
  }

  //Download all album songs in zip file
  public function downloadZipAction() {

    $getAllSongs = Engine_Api::_()->getDbTable('albumsongs', 'seseventmusic')->getAllSongs($this->_getParam('album_id'));

    $song_files = array();
    foreach ($getAllSongs as $song) {
      $song_files[] = Engine_Api::_()->getItem('storage_file', $song->file_id)->storage_path;
    }

    if (count($song_files > 0)) {
      $zip = new ZipArchive();
      $zip_name = "zipfile.zip";
      if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== TRUE) {
        $error .= "* Sorry ZIP creation failed at this time";
      }

      foreach ($song_files as $song_file) {
        $zip->addFile($song_file);
      }

      $zip->close();
      if ($zip_name) {
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=zipfile.zip');
        header('Content-Length: ' . filesize($zip_name));
        readfile($zip_name);
        //Remove zip file from temp path
        unlink($zip_name);
        exit;
        return;
      }
    } else {
      echo "No valid files to zip";
      exit;
    }
  }

  //Sort Action
  public function sortAction() {

    if (!$this->_helper->requireSubject('seseventmusic_album')->isValid()) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Invalid playlist');
      return;
    }

    //Get playlist
    $this->view->album = $album = Engine_Api::_()->core()->getSubject('seseventmusic_album');
    $this->view->album_id = $album->getIdentity();

    //only user and admins and moderators can edit
    if (!$this->_helper->requireAuth()->setAuthParams($album, null, 'edit')->isValid()) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Not allowed to edit this playlist');
      return;
    }

    $songs = $album->getSongs();
    $order = explode(',', $this->getRequest()->getParam('order'));
    foreach ($order as $i => $item) {
      $song_id = substr($item, strrpos($item, '_') + 1);
      foreach ($songs as $song) {
        if ($song->albumsong_id == $song_id) {
          $song->order = $i;
          $song->save();
        }
      }
    }
    $this->view->songs = $album->getSongs()->toArray();
  }

  //Add New Song Action
  public function addSongAction() {

    //Check user
    if (!$this->_helper->requireUser()->isValid()) {
      $this->view->success = false;
      $this->view->error = $this->view->translate('You must be logged in.');
      return;
    }
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.checkmusic'))
      return;

    //Prepare
    $viewer = Engine_Api::_()->user()->getViewer();
    $albumTable = Engine_Api::_()->getDbTable('albums', 'seseventmusic');

    //Get special playlist
    if (0 >= ($album_id = $this->_getParam('album_id')) && false != ($type = $this->_getParam('type'))) {
      $album = $albumTable->getSpecialPlaylist($viewer, $type);
      Engine_Api::_()->core()->setSubject($album);
    }

    //Check subject
//     if (!$this->_helper->requireSubject('seseventmusic_album')->checkRequire()) {
//       $this->view->success = false;
//       $this->view->error = $this->view->translate('Invalid playlist');
//       return;
//     }

    //Get playlist
    $this->view->album = $album = Engine_Api::_()->core()->getSubject('seseventmusic_album');
    $this->view->album_id = $album_id = $album->getIdentity();

    //check auth
//     if (!$this->_helper->requireAuth()->setAuthParams($album, null, 'edit')->isValid()) {
//       $this->view->status = false;
//       $this->view->error = $this->view->translate('You are not allowed to edit this playlist');
//       return;
//     }

    //Check file
    $values = $this->getRequest()->getPost();
    if (empty($values['Filename']) || empty($_FILES['Filedata'])) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('No file');
      return;
    }

    //Process
    $db = $albumTable->getAdapter();
    $db->beginTransaction();
    try {

      //Create song
      $file = Engine_Api::_()->getApi('core', 'seseventmusic')->createSong($_FILES['Filedata']);
      if (!$file)
        throw new Seseventmusic_Model_Exception('Song was not successfully attached');

      //Add song
      $albumsong = $album->addSong($file);
      if (!$albumsong)
        throw new Seseventmusic_Model_Exception('Song was not successfully attached');

      //Response
      $this->view->status = true;
      $this->view->song = $albumsong;
      $this->view->albumsong_id = $albumsong->albumsong_id;
      $this->view->song_url = $albumsong->getFilePath();
      $this->view->song_title = $albumsong->title;
      $db->commit();
    } catch (Seseventmusic_Model_Exception $e) {
      $db->rollback();
      $this->view->status = false;
      $this->view->message = $this->view->translate($e->getMessage());
      return;
    } catch (Exception $e) {
      $db->rollback();
      $this->view->status = false;
      $this->view->message = $this->view->translate('Upload failed by database query');
      throw $e;
    }
  }

  //Check this action it is useful or not if not then remove it after finish the work.
  public function setProfileAction() {

    if (!$this->getRequest()->isPost())
      return;

    $this->view->playlist_id = $album_id = $this->_getParam('album_id');
    $this->view->playlist = $album = Engine_Api::_()->getItem('seseventmusic_albums', $album_id);

    //Check owner
    if ($album->owner_id != Engine_Api::_()->user()->getViewer()->getIdentity())
      return;

    //Process
    $db = Engine_Api::_()->getDbTable('albums', 'seseventmusic')->getAdapter();
    $db->beginTransaction();
    try {
      $album->setProfile();
      $this->view->success = true;
      $this->view->enabled = $album->profile;
      $db->commit();
    } catch (Exception $e) {
      $this->view->success = false;
      $db->rollback();
    }

    //Redirect
    if (null === $this->_helper->contextSwitch->getCurrentContext()) {
      return $this->_helper->redirector->gotoRoute(array('controller' => 'index', 'action' => 'manage'));
    }
  }

}