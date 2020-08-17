<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SongController.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_SongController extends Core_Controller_Action_Standard {

  public function init() {
    //Get viewer info
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

    //Get subject
    if (null !== ($song_id = $this->_getParam('albumsong_id')) && null !== ($song = Engine_Api::_()->getItem('seseventmusic_albumsong', $song_id)) && $song instanceof Seseventmusic_Model_Albumsong) {
      Engine_Api::_()->core()->setSubject($song);
    }
  }

  public function printAction() {

    $this->_helper->layout->setLayout('default-simple');
    $this->view->albumsong = Engine_Api::_()->getItem('seseventmusic_albumsong', $this->_getParam('albumsong_id', null));
    if (empty($this->view->albumsong))
      return $this->_forward('notfound', 'error', 'core');
  }

  //View Action
  public function viewAction() {

    //Render
    $this->_helper->content->setEnabled();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    //Check subject
    if (!Engine_Api::_()->core()->hasSubject('seseventmusic_albumsong')) {
      $this->view->success = false;
      $this->view->error = $this->view->translate('Not a valid song');
      return;
    }

    //Check subject
    if (!$this->_helper->requireSubject()->isValid())
      return;

    //Get song
    $this->view->albumsong = $albumsong = Engine_Api::_()->core()->getSubject('seseventmusic_albumsong');
    $this->view->album = $album = $albumsong->getParent();
    
    $event = Engine_Api::_()->getItem('sesevent_event', $album->resource_id);
    $canView = $event->authorization()->isAllowed($viewer, 'view');
    if(!$canView)
	    return $this->_forward('requireauth', 'error', 'core');


    /* Insert data for recently viewed widget */
    if ($viewer->getIdentity() != 0 && isset($album->album_id)) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_seseventmusic_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $albumsong->albumsong_id . '", "seseventmusic_albumsong","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
    }

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $ratingTable = Engine_Api::_()->getDbTable('ratings', 'seseventmusic');

    //Songs settings.
    $this->view->songlink = unserialize($settings->getSetting('seseventmusic.songlink'));

    if (!$settings->getSetting('seseventmusic.checkmusic'))
      return $this->_forward('notfound', 'error', 'core');

    //Favourite work
    $this->view->isFavourite = Engine_Api::_()->getDbTable('favourites', 'seseventmusic')->isFavourite(array('resource_type' => "seseventmusic_albumsong", 'resource_id' => $albumsong->getIdentity()));

    //Rating Work
    $this->view->rating_count = $ratingTable->ratingCount($albumsong->getIdentity(), 'seseventmusic_albumsong');
    $this->view->rated = $ratingTable->checkRated($albumsong->getIdentity(), $viewer->getIdentity(), 'seseventmusic_albumsong');

    //Increment view count of song
    if (!$viewer->isSelf($album->getOwner())) {
      $albumsong->view_count++;
      $albumsong->save();
    }

    //Check song/playlist
    if (!$albumsong || !$album) {
      $this->view->success = false;
      $this->view->error = $this->view->translate('Invalid playlist');
      return;
    }

    //Check auth
    if (!Engine_Api::_()->authorization()->isAllowed($album, null, 'edit')) {
      $this->view->success = false;
      $this->view->error = $this->view->translate('Not allowed to edit this playlist');
      return;
    }

    //Get file
    $file = Engine_Api::_()->getItem('storage_file', $albumsong->file_id);
    if (!$file) {
      $this->view->success = false;
      $this->view->error = $this->view->translate('Invalid playlist');
      return;
    }
  }

  //Edit Action
  public function editAction() {

    $albumsong_id = $this->_getParam('albumsong_id');
    $this->view->albumsong = $albumsong = Engine_Api::_()->getItem('seseventmusic_albumsong', $albumsong_id);
    
    $musicalbum = Engine_Api::_()->getItem('seseventmusic_album', $albumsong->album_id);
    $event = Engine_Api::_()->getItem('sesevent_event', $musicalbum->resource_id);
    $viewer = Engine_Api::_()->user()->getViewer();
    $canEdit = $event->authorization()->isAllowed($viewer, 'edit'); 
    if(!$canEdit)
	    return $this->_forward('requireauth', 'error', 'core');

    //Only members can upload music
    if (!$this->_helper->requireUser()->isValid())
      return;

    if (!$this->_helper->requireSubject('seseventmusic_albumsong')->isValid())
      return;

    //Make form
    $this->view->form = $form = new Seseventmusic_Form_SongEdit();

    $form->populate($albumsong->toarray());

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.checkmusic'))
      return $this->_forward('notfound', 'error', 'core');

    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    $db = Engine_Api::_()->getDbTable('albumsongs', 'seseventmusic')->getAdapter();
    $db->beginTransaction();
    try {
      $values = $form->getValues();
      if (!$values['song_cover'])
        unset($values['song_cover']);

      $albumsong->setFromArray($values);

      //Update title in playlistsong table
      $albumsong->save();

      //Photo upload for song
      if (!empty($values['file'])) {
        $previousPhoto = $albumsong->photo_id;
        if ($previousPhoto) {
          $songPhoto = Engine_Api::_()->getItem('storage_file', $previousPhoto);
          $songPhoto->delete();
        }
        $albumsong->setPhoto($form->file, 'mainPhoto');
      }

      if (isset($values['remove_photo']) && !empty($values['remove_photo'])) {
        $storage = Engine_Api::_()->getItem('storage_file', $albumsong->photo_id);
        $albumsong->photo_id = 0;
        $albumsong->save();
        if ($storage)
          $storage->delete();
      }

      //Photo upload for song cover
      if (!empty($values['song_cover'])) {
        $previousPhoto = $albumsong->song_cover;
        if ($previousPhoto) {
          $songPhoto = Engine_Api::_()->getItem('storage_file', $previousPhoto);
          if ($songPhoto)
            $songPhoto->delete();
        }
        $albumsong->setPhoto($form->song_cover, 'songCover');
      }

      if (isset($values['remove_song_cover']) && !empty($values['remove_song_cover'])) {
        $storage = Engine_Api::_()->getItem('storage_file', $albumsong->song_cover);
        $albumsong->song_cover = 0;
        $albumsong->save();
        if ($storage)
          $storage->delete();
      }
      $db->commit();
    } catch (Exception $e) {
      $db->rollback();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'view', 'albumsong_id' => $albumsong_id, 'slug' => $albumsong->getSlug()), 'seseventmusic_albumsong_view', true);
  }

  //Delete Action
  public function deleteAction() {

    //Check subject
    if (!Engine_Api::_()->core()->hasSubject('seseventmusic_albumsong')) {
      $this->view->success = false;
      $this->view->error = $this->view->translate('Not a valid song');
      return;
    }

    $albumsong = Engine_Api::_()->getItem('seseventmusic_albumsong', $this->getRequest()->getParam('albumsong_id'));
    $album = Engine_Api::_()->getItem('seseventmusic_album', $albumsong->album_id);

    $event = Engine_Api::_()->getItem('sesevent_event', $album->resource_id);
    $viewer = Engine_Api::_()->user()->getViewer();
    $canDelete = $event->authorization()->isAllowed($viewer, 'edit'); 
    if(!$canDelete)
	    return $this->_forward('requireauth', 'error', 'core');


    //In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    //Get From
    $this->view->form = $form = new Seseventmusic_Form_Delete();
    $form->setTitle('Delete Song?');
    $form->setDescription('Are you sure you want to delete this song?');
    $form->submit->setLabel('Delete Song');

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.checkmusic'))
      return $this->_forward('notfound', 'error', 'core');

    if (!$albumsong) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Song doesn't exists or not authorized to delete");
      return;
    }

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $albumsong->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      //Delete ratings
      Engine_Api::_()->getDbtable('ratings', 'seseventmusic')->delete(array('resource_id =?' => $this->_getParam('albumsong_id'), 'resource_type =?' => 'seseventmusic_albumsong'));

      $file = Engine_Api::_()->getItem('storage_file', $albumsong->file_id);
      if ($file)
        $file->remove();

      //Delete album song
      $albumsong->delete();
      $album->song_count--;
      $album->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected song has been deleted.');
    return $this->_forward('success', 'utility', 'core', array('parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('album_id' => $album->album_id, 'slug' => $album->getSlug()), 'seseventmusic_album_view', true), 'messages' => Array($this->view->message)));
  }
  
  //Download song action
  public function downloadSongAction() {

    $albumSong = Engine_Api::_()->getItem('seseventmusic_albumsongs', $this->_getParam('albumsong_id'));

    $storage = Engine_Api::_()->getItem('storage_file', $albumSong->file_id);

    if($storage->service_id == 2) {
      $servicesTable = Engine_Api::_()->getDbtable('services', 'storage');
      $result  = $servicesTable->select()
                  ->from($servicesTable->info('name'), 'config')
                  ->where('service_id = ?', $storage->service_id)
                  ->limit(1)
                  ->query()
                  ->fetchColumn();
      $serviceResults = Zend_Json_Decoder::decode($result);
      if($serviceResults['baseUrl']) {
        $path = 'http://' . $serviceResults['baseUrl'] . '/' . $storage->storage_path;
      } else {
        $path = 'http://' . $serviceResults['bucket'] . '.s3.amazonaws.com/' . $storage->storage_path;
      }
    } else {
      //Song file name and path
      $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . $storage->storage_path;
    }

    //KILL ZEND'S OB
    while (ob_get_level() > 0) {
      ob_end_clean();
    }

    $albumSong->download_count++;
    $albumSong->save();
    
    $baseName = $storage->name . '.' . $storage->extension;

    header("Content-Disposition: attachment; filename=" . urlencode(basename($baseName)), true);
    header("Content-Transfer-Encoding: Binary", true);
    header("Content-Type: application/force-download", true);
    header("Content-Type: application/octet-stream", true);
    header("Content-Type: application/download", true);
    header("Content-Description: File Transfer", true);
    header("Content-Length: " . filesize($path), true);
    readfile("$path");
    exit();
    return;
  }

  public function tallyAction() {

    //Check subject
    if (!Engine_Api::_()->core()->hasSubject('seseventmusic_albumsong')) {
      $this->view->success = false;
      $this->view->error = $this->view->translate('Not a valid song');
      return;
    }

    //Get song/playlist
    $song = Engine_Api::_()->core()->getSubject('seseventmusic_albumsong');

    //Check song
    if (!$song) {
      $this->view->success = false;
      $this->view->error = $this->view->translate('invalid song_id');
      return;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');

    //Process
    $db = $song->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      if($viewer_id) {
      $action = $activityTable->addActivity($viewer, $song, 'seseventmusic_playedsong');
      if ($action) {
        Engine_Api::_()->getDbtable('stream', 'activity')->delete(array('action_id =?' => $action->action_id));
        $db->query("INSERT INTO `engine4_activity_stream` (`target_type`, `target_id`, `subject_type`, `subject_id`, `object_type`, `object_id`, `type`, `action_id`) VALUES
('everyone', 0, 'user', $viewer_id, 'seseventmusic_albumsong', $song->albumsong_id, 'seseventmusic_playedsong', $action->action_id),
('members', $viewer_id, 'user', $viewer_id, 'seseventmusic_albumsong', $song->albumsong_id, 'seseventmusic_playedsong', $action->action_id),
('owner', $viewer_id, 'user', $viewer_id, 'seseventmusic_albumsong', $song->albumsong_id, 'seseventmusic_playedsong', $action->action_id),
('parent', $viewer_id, 'user', $viewer_id, 'seseventmusic_albumsong', $song->albumsong_id, 'seseventmusic_playedsong', $action->action_id),
('registered', 0, 'user', $viewer_id, 'seseventmusic_albumsong', $song->albumsong_id, 'seseventmusic_playedsong', $action->action_id);");
        $activityTable->attachActivity($action, $song);
      }
      }
      $song->play_count++;
      $song->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollback();
      $this->view->success = false;
      return;
    }

    $this->view->success = true;
    $this->view->song = $song->toArray();
    $this->view->play_count = $song->playCountLanguagefield();
  }

  public function uploadAction() {

    //Only members can upload music
    if (!$this->_helper->requireUser()->checkRequire()) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Max file size limit exceeded or session expired.');
      return;
    }

    //Check method
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('Invalid request method');
      return;
    }

    //Check file
    $values = $this->getRequest()->getPost();
    if (empty($values['Filename']) || empty($_FILES['Filedata'])) {
      $this->view->status = false;
      $this->view->error = $this->view->translate('No file');
      return;
    }


    //Process
    $db = Engine_Api::_()->getDbtable('albums', 'seseventmusic')->getAdapter();
    $db->beginTransaction();

    try {
      $song = Engine_Api::_()->getApi('core', 'seseventmusic')->createSong($_FILES['Filedata']);
      $this->view->status = true;
      $this->view->song = $song;
      $this->view->albumsong_id = $song->getIdentity();
      $this->view->song_url = $song->getHref();
      $db->commit();
    } catch (Seseventmusic_Model_Exception $e) {
      $db->rollback();

      $this->view->status = false;
      $this->view->message = $this->view->translate($e->getMessage());
    } catch (Exception $e) {
      $db->rollback();

      $this->view->status = false;
      $this->view->message = $this->view->translate('Upload failed by database query');

      throw $e;
    }
  }
}