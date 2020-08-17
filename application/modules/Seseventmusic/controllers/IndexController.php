<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_IndexController extends Core_Controller_Action_Standard {

	//Init
  public function init() {

		//Check auth
    if (!$this->_helper->requireAuth()->setAuthParams('sesevent_event', null, 'view')->isValid())
      return;

		//Get viewer info
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
  }

	//Home Action
  public function homeAction() {
		//Render
    $this->_helper->content->setEnabled();
  }
  
  //Browse Action
  public function browseAction() {
    $this->_helper->content->setEnabled();
  }
  
  public function searchAction() {

    $text = $this->_getParam('text', null);
    $actonType = $this->_getParam('actonType', null);
    $seseventmusic_commonsearch = $this->_getParam('seseventmusic_commonsearch', 'seseventmusic_album');
    if ($seseventmusic_commonsearch && $actonType == 'browse') {
      $type = $seseventmusic_commonsearch;
    } else {
      if (isset($_COOKIE['seseventmusic_commonsearch']))
        $type = $_COOKIE['seseventmusic_commonsearch'];
      else
        $type = 'seseventmusic_album';
    }

    if ($type == 'seseventmusic_album') {
      $table = Engine_Api::_()->getDbTable('albums', 'seseventmusic');
      $tableName = $table->info('name');
      $id = 'album_id';
      $route = 'seseventmusic_album_view';
      $photo = 'thumb.icon';
      $label = 'title';
    } elseif ($type == 'seseventmusic_albumsong') {
      $table = Engine_Api::_()->getDbTable('albumsongs', 'seseventmusic');
      $tableName = $table->info('name');
      $id = 'albumsong_id';
      $route = 'seseventmusic_albumsong_view';
      $photo = 'thumb.normal';
      $label = 'title';
    }

    $data = array();
    $select = $table->select()->from($tableName);
    $select->where('title  LIKE ? ', '%' . $text . '%')->order('title ASC');

    if ($type == 'seseventmusic_album')
      $select->where('search = ?', 1);

    $select->limit('40');
    $results = $table->fetchAll($select);

    foreach ($results as $result) {
      $url = $this->view->url(array($id => $result->$id, 'slug' => $result->getSlug()), $route, true);

      if ($type == 'seseventmusic_albumsong' && !$result->photo_id) {
        $albumsong = Engine_Api::_()->getItem('seseventmusic_albumsong', $result->albumsong_id);
        $photo = $this->view->itemPhoto($albumsong, $photo);
      } else {
        $photo = $this->view->itemPhoto($result, $photo);
      }

      if ($actonType == 'browse') {
        $data[] = array(
            'id' => $result->$id,
            'label' => $result->$label,
                // 'photo' => $photo,
//'url' => $url,
        );
      } else {
        $data[] = array(
            'id' => $result->$id,
            'label' => $result->$label,
            //  'photo' => $photo,
            'url' => $url,
        );
      }
    }
    return $this->_helper->json($data);
  }

  //Album Create Action
  public function createAction() {
    
    $viewer = Engine_Api::_()->user()->getViewer();
    
    $this->view->resource_type = $this->_getParam('resource_type', null);
    $this->view->event_id = $this->_getParam('event_id', null);
    
    //Privacy Work
    $event = Engine_Api::_()->getItem('sesevent_event', $this->view->event_id);
    $allowMusic = Engine_Api::_()->authorization()->isAllowed('sesevent_event', $viewer, 'event_music');
    $canCreateMusic = $event->authorization()->isAllowed($viewer, 'music');
//     if(!$canCreateMusic)
// 	    return $this->_forward('requireauth', 'error', 'core');

    //Only members can upload music
    if (!$this->_helper->requireUser()->isValid())
      return;

    //Render Layout
    $this->_helper->content->setEnabled();

    //Catch uploads from FLASH fancy-uploader and redirect to uploadSongAction()
    if ($this->getRequest()->getQuery('ul', false))
      return $this->_forward('upload', 'song', null, array('format' => 'json'));

    //Get form
    $this->view->form = $form = new Seseventmusic_Form_Create();
    $this->view->album_id = $this->_getParam('album_id', '0');

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.checkmusic'))
      return $this->_forward('notfound', 'error', 'core');

    //Check method/data
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Process
    $db = Engine_Api::_()->getDbTable('albums', 'seseventmusic')->getAdapter();
    $db->beginTransaction();
    try {
      $album = $this->view->form->saveValues();
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

  //Album Delete Action
  public function deleteAction() {

    $album = Engine_Api::_()->getItem('seseventmusic_album', $this->getRequest()->getParam('album_id'));
    $resource = Engine_Api::_()->getItem('sesevent_event', $this->getRequest()->getParam('resource_id'));

    $viewer = Engine_Api::_()->user()->getViewer();
    $canDelete = $resource->authorization()->isAllowed($viewer, 'delete'); 
    if(!$canDelete)
	    return $this->_forward('requireauth', 'error', 'core');
	    
    //In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    //Get From
    $this->view->form = new Seseventmusic_Form_Delete();

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

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.checkmusic'))
      return $this->_forward('notfound', 'error', 'core');

    $ratingTable = Engine_Api::_()->getDbtable('ratings', 'seseventmusic');
    $db = $album->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      //All songs delete from the album
      foreach ($album->getSongs() as $song) {
        $ratingTable->delete(array('resource_id =?' => $song->albumsong_id, 'resource_type =?' => 'seseventmusic_albumsong'));
        $song->deleteUnused();
      }
      //Delete rating accociate with deleted album
      $ratingTable->delete(array('resource_id =?' => $album->album_id, 'resource_type =?' => 'seseventmusic_album'));
      $album->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected albums has been deleted.');
    return $this->_forward('success', 'utility', 'core', array('parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('id' => $resource->custom_url), 'sesevent_profile', true), 'messages' => Array($this->view->message)));
  }

//Action for show all like by users when click on the view all link
  public function allLikesAction() {

    $this->view->id = $id = $this->_getParam('id');
    $this->view->type = $type = $this->_getParam('type');
    $this->view->showUsers = $showUsers = $this->_getParam('showUsers');
    $this->view->viewmore = $this->_getParam('viewmore', 0);

    $likeTable = Engine_Api::_()->getItemTable('core_like');
    $likeTableName = $likeTable->info('name');

    $select = $likeTable->select()
            ->from($likeTableName, array('poster_id'))
            ->where($likeTableName . '.resource_type = ?', $type)
            ->where($likeTableName . '.resource_id = ?', $id);

    if ($showUsers != 'all') {
      $friendids = Engine_Api::_()->user()->getViewer()->membership()->getMembershipsOfIds();
      $select = $select->where($likeTableName . '.poster_id IN (?)', (array) $friendids);
    } else {
      $select = $select->where($likeTableName . '.poster_id != ?', 0);
    }
    $select = $select->order('like_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $paginator->getTotalItemCount();
  }

  public function soundcloudintAction() {

    require_once 'services/Soundcloud.php';

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $client_id = $settings->getSetting('seseventmusic.scclientid');
    $client_screat = $settings->getSetting('seseventmusic.scclientscreatid');

    if (empty($client_id) && empty($client_screat))
      return;

//Create a client object with your app credentials
    $client = new Services_Soundcloud($client_id, $client_screat);

    $songURL = $this->_getParam('song_url');

//Upload From Sound Clous playlist, user and groups tracks
    if (strpos($songURL, 'playlists') > 0) {
      $playlistId = str_replace("https://api.soundcloud.com/playlists/", "", $songURL);
      $tracks_json = file_get_contents('https://api.soundcloud.com/playlists/' . $playlistId . '/tracks.json?client_id=' . $client_id);
      $tracks = json_decode($tracks_json);
    } elseif (strpos($songURL, 'groups') > 0) {
      $playlistId = str_replace("https://api.soundcloud.com/groups/", "", $songURL);
      $tracks_json = file_get_contents('http://api.soundcloud.com/groups/' . $playlistId . '/tracks.json?client_id=' . $client_id);
      $tracks = json_decode($tracks_json);
    } elseif (strpos($songURL, 'users') > 0) {
      $playlistId = str_replace("https://api.soundcloud.com/users/", "", $songURL);
      $tracks_json = file_get_contents('http://api.soundcloud.com/users/' . $playlistId . '/tracks.json?client_id=' . $client_id);
      $tracks = json_decode($tracks_json);
    }


    if (!empty($tracks)) {
//Upload From Sound Clous playlist, user and groups tracks
      $trackIds = array();
      if (!empty($tracks)) {
        foreach ($tracks as $track) {

          $trackID = $track->id;
          $trackTitle = $track->title;
          $streamable = $track->streamable;
          $downloadable = $track->downloadable;
          $purchase_url = $track->purchase_url;
          $songURL = $track->permalink_url;


          if ($track->id && $track->title && empty($track->tracks) && isset($track->streamable) && $track->streamable) {

//Upload to storage system
            $downloadable = isset($track->downloadable) ? $track->downloadable : false;
            if (!empty($track->purchase_url))
              $downloadable = false;

            $row = Engine_Api::_()->getItemTable('storage_file')->createRow();
            $row->setFromArray(array('type' => 'song', 'name' => $track->title, 'parent_type' => 'seseventmusic_albumsongs', 'parent_id' => Engine_Api::_()->user()->getViewer()->getIdentity(), 'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(), 'extension' => 'mp3', 'storage_path' => $songURL, 'size' => $track->id, 'mime_minor' => $downloadable));
            $row->save();
            if ($row->file_id) {
              $trackIds[] = $row->file_id;
              if ($track->artwork_url) {
                $imageURL = str_replace("https://", "", $track->artwork_url);
                $imageURL = str_replace("large.jpg", "t500x500.jpg", $imageURL);
                $imageURL = "http://" . $imageURL;
                if ($imageURL)
                  @copy($imageURL, APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary/' . $row->file_id . '.jpg');
              }
              $this->view->file_id = $trackIds;
            }
          }
        }
      } else {
        $this->view->file_id = 0;
      }
    } else {

//Resolve track URL into track resource
      $track = json_decode($client->get('resolve', array('url' => $songURL), array(
                  CURLOPT_SSL_VERIFYPEER => false,
                  CURLOPT_SSL_VERIFYHOST => false,
                  CURLOPT_FOLLOWLOCATION => true
      )));
      if (isset($track->urlGetContent)) {
        $file = file_get_contents($track->urlGetContent);
        if ($file != '')
          $track = json_decode($file);
      }
      if ($track->id && $track->title && empty($track->tracks) && isset($track->streamable) && $track->streamable) {

//Upload to storage system
        $downloadable = isset($track->downloadable) ? $track->downloadable : false;
        if (!empty($track->purchase_url))
          $downloadable = false;

        $row = Engine_Api::_()->getItemTable('storage_file')->createRow();
        $row->setFromArray(array('type' => 'song', 'name' => $track->title, 'parent_type' => 'seseventmusic_albumsongs', 'parent_id' => Engine_Api::_()->user()->getViewer()->getIdentity(), 'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(), 'extension' => 'mp3', 'storage_path' => $songURL, 'size' => $track->id, 'mime_minor' => $downloadable));
        $row->save();
        if ($row->file_id)
          $this->view->file_id = $row->file_id;
        if ($track->artwork_url) {
          $imageURL = str_replace("https://", "", $track->artwork_url);
          $imageURL = str_replace("large.jpg", "t500x500.jpg", $imageURL);
          $imageURL = "http://" . $imageURL;
          if ($imageURL)
            @copy($imageURL, APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary/' . $row->file_id . '.jpg');
        }
      } else {
        $this->view->file_id = 0;
      }
    }
  }

  public function soundcloudSongDeleteAction() {
    $file_id = $this->_getParam('file_id');
    if (empty($file_id))
      return;
    $storageTable = Engine_Api::_()->getItem('storage_file', $file_id);
    $storageTable->delete();
  }

}
