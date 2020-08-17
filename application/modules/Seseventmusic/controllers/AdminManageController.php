<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventmusic_admin_main', array(), 'seseventmusic_admin_main_manage');
    $ratingTable = Engine_Api::_()->getDbtable('ratings', 'seseventmusic');
    $favouriteTable = Engine_Api::_()->getDbtable('favourites', 'seseventmusic');

    $this->view->formFilter = $formFilter = new Seseventmusic_Form_Admin_Manage_Filter();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $musicAlbum = Engine_Api::_()->getItem('seseventmusic_album', $value);
          foreach ($musicAlbum->getSongs() as $song) {
            if ($song->albumsong_id) {
              
              $ratingTable->delete(array('resource_type =?' => 'seseventmusic_album', 'resource_id =?' => $song->album_id));
              $favouriteTable->delete(array('resource_type =?' => 'seseventmusic_album', 'resource_id =?' => $song->album_id));
              $ratingTable->delete(array('resource_type =?' => 'seseventmusic_albumsong', 'resource_id =?' => $song->albumsong_id));
              $favouriteTable->delete(array('resource_type =?' => 'seseventmusic_albumsong', 'resource_id =?' => $song->albumsong_id));
            }
            $song->deleteUnused();
          }
          $musicAlbum->delete();
        }
      }
    }

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    
    $values = array_merge(array(
      'order' => $_GET['order'],
      'order_direction' => $_GET['order_direction'],
    ), $values);
    
    $this->view->assign($values);
    
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $musicAlbumTable = Engine_Api::_()->getDbTable('albums', 'seseventmusic');
    $musicAlbumTableName = $musicAlbumTable->info('name');

    $select = $musicAlbumTable->select()
            ->setIntegrityCheck(false)
            ->from($musicAlbumTableName)
            ->joinLeft($tableUserName, "$musicAlbumTableName.owner_id = $tableUserName.user_id", 'username')
            ->order(( !empty($_GET['order']) ? $_GET['order'] : 'album_id' ) . ' ' . ( !empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['name']))
      $select->where($musicAlbumTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['hot']) && $_GET['hot'] != '')
      $select->where($musicAlbumTableName . '.hot = ?', $_GET['hot']);

    if (isset($_GET['upcoming']) && $_GET['upcoming'] != '')
      $select->where($musicAlbumTableName . '.upcoming = ?', $_GET['upcoming']);

    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where($musicAlbumTableName . '.featured = ?', $_GET['featured']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
      $select->where($musicAlbumTableName . '.sponsored = ?', $_GET['sponsored']);

    if (isset($_GET['rating']) && $_GET['rating'] != '') {
      if ($_GET['rating'] == 1):
        $select->where($musicAlbumTableName . '.rating <> ?', 0);
      elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
        $select->where($musicAlbumTableName . '.rating = ?', $_GET['rating']);
      endif;
    }

    if (!empty($_GET['creation_date']))
      $select->where($musicAlbumTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function deleteAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->seseventmusic_id = $id = $this->_getParam('id');
    $ratingTable = Engine_Api::_()->getDbtable('ratings', 'seseventmusic');
    $favouriteTable = Engine_Api::_()->getDbtable('favourites', 'seseventmusic');

    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $musicAlbum = Engine_Api::_()->getItem('seseventmusic_albums', $id);
        foreach ($musicAlbum->getSongs() as $song) {
          if ($song->albumsong_id) {
            
            $ratingTable->delete(array('resource_type =?' => 'seseventmusic_album', 'resource_id =?' => $id));
            $favouriteTable->delete(array('resource_type =?' => 'seseventmusic_album', 'resource_id =?' => $id));
            $ratingTable->delete(array('resource_type =?' => 'seseventmusic_albumsong', 'resource_id =?' => $song->albumsong_id));
            $favouriteTable->delete(array('resource_type =?' => 'seseventmusic_albumsong', 'resource_id =?' => $song->albumsong_id));
          }
          $song->deleteUnused();
        }
        $musicAlbum->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully delete albums.')
      ));
    }
    //Output
    $this->renderScript('admin-manage/delete.tpl');
  }

  //Featured Action
  public function featuredAction() {

    $album_id = $this->_getParam('id');
    if (!empty($album_id)) {
      $album = Engine_Api::_()->getItem('seseventmusic_album', $album_id);
      $album->featured = !$album->featured;
      $album->save();
    }
    $this->_redirect('admin/seseventmusic/manage');
  }

  //Sponsored Action
  public function sponsoredAction() {

    $album_id = $this->_getParam('id');
    if (!empty($album_id)) {
      $album = Engine_Api::_()->getItem('seseventmusic_album', $album_id);
      $album->sponsored = !$album->sponsored;
      $album->save();
    }
    $this->_redirect('admin/seseventmusic/manage');
  }

  //Hot Action
  public function hotAction() {

    $album_id = $this->_getParam('id');
    if (!empty($album_id)) {
      $album = Engine_Api::_()->getItem('seseventmusic_album', $album_id);
      $album->hot = !$album->hot;
      $album->save();
    }
    $this->_redirect('admin/seseventmusic/manage');
  }

  //Latest Action
  public function upcomingAction() {

    $album_id = $this->_getParam('id');
    if (!empty($album_id)) {
      $album = Engine_Api::_()->getItem('seseventmusic_album', $album_id);
      $album->upcoming = !$album->upcoming;
      $album->save();
    }
    $this->_redirect('admin/seseventmusic/manage');
  }

  public function ofthedayAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');

    $this->view->form = $form = new Seseventmusic_Form_Admin_Manage_Oftheday();
    if ($type == 'seseventmusic_album') {
      $item = Engine_Api::_()->getItem('seseventmusic_albums', $id);
      $form->setTitle("Music Album of the Day");
      $form->setDescription('Here, choose the start date and end date for this music album to be displayed as "Music Album of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Music Album of the Day");
      $table = 'engine4_seseventmusic_albums';
      $item_id = 'album_id';
    } elseif ($type == 'seseventmusic_albumsong') {
      $item = Engine_Api::_()->getItem('seseventmusic_albumsongs', $id);
      $form->setTitle("Song of the Day");
      if (!$param)
        $form->remove->setLabel("Remove as Song of the Day");
      $form->setDescription('Here, choose the start date and end date for this song to be displayed as "Song of the Day".');
      $table = 'engine4_seseventmusic_albumsongs';
      $item_id = 'albumsong_id';
    }

    if (!empty($id))
      $form->populate($item->toArray());

    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost())) {
        return;
      }
      $values = $form->getValues(); //print_r();die;

      $start = strtotime($values['starttime']);
      $end = strtotime($values['endtime']);

      $values['starttime'] = date('Y-m-d', $start);
      $values['endtime'] = date('Y-m-d', $end);

      $db->update($table, array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("$item_id = ?" => $id));
      if ($values['remove']) {
        $db->update($table, array('offtheday' => 0), array("$item_id = ?" => $id));
      } else {
        $db->update($table, array('offtheday' => 1), array("$item_id = ?" => $id));
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
  }

  public function viewAction() {
    $this->view->item = Engine_Api::_()->getItem('seseventmusic_album', $this->_getParam('id', null));
  }

}
