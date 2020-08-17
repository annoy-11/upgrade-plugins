<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageAlbumController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_AdminManageAlbumController extends Core_Controller_Action_Admin {

  public function indexAction() {
   $this->view->navigation  = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_mgphlbum');
   $this->view->subNavigation  = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_mgphlbum', array(), 'estore_admin_main_managealbum');
		$this->view->formFilter = $formFilter = new Estore_Form_Admin_Manage_FilterAlbum();

		// Process form
    $values = array();
    if( $formFilter->isValid($this->_getAllParams()) ) {
      $values = $formFilter->getValues();
    }

    foreach( $_GET as $key => $value ) {
      if( '' === $value ) {
        unset($_GET[$key]);
      } else
				$values[$key]=$value;
    }

    if( $this->getRequest()->isPost() ) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $album = Engine_Api::_()->getItem('estore_album', $value);
          $album->delete();
        }
      }
    }

    $tableAlbum = Engine_Api::_()->getDbTable('albums', 'estore');
    $tableAlbumName = $tableAlbum->info('name');

    $tableStore = Engine_Api::_()->getDbTable('stores', 'estore');
    $tableStoreName = $tableStore->info('name');

    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select = $tableAlbum->select()
                        ->from($tableAlbumName)
                        ->setIntegrityCheck(false)
                        ->joinLeft($tableUserName, "$tableUserName.user_id = $tableAlbumName.owner_id", 'username')
                        ->join($tableStoreName, "$tableStoreName.store_id = $tableAlbumName.store_id", null)
                        ->order($tableAlbumName.'.album_id DESC');

    if( !empty($_GET['title']) )
      $select->where($tableAlbumName.'.title LIKE ?', '%' . $values['title'] . '%');

    if( !empty($_GET['storetitle']) )
      $select->where($tableStoreName.'.title LIKE ?', '%' . $values['storetitle'] . '%');

    if( !empty($values['creation_date']) )
      $select->where($tableStoreName.'.date(creation_date) = ?', $values['creation_date'] );

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ( $this->_getParam('page', 1) );
  }
  //Featured Action
  public function featuredalbumAction() {
    $album_id = $this->_getParam('id');
    if (!empty($album_id)) {
      $album = Engine_Api::_()->getItem('estore_album', $album_id);
      $album->featured = !$album->featured;
      $album->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/estore/manage-album';
    $this->_redirect($url);
  }

  //Sponsored Action
  public function sponsoredalbumAction() {
    $album_id = $this->_getParam('id');
    if (!empty($album_id)) {
      $album = Engine_Api::_()->getItem('estore_album', $album_id);
      $album->sponsored = !$album->sponsored;
      $album->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/estore/manage-album';
    $this->_redirect($url);
  }

	public function photosAction() {

   $this->view->navigation  = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_mgphlbum');

   $this->view->subNavigation  = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_mgphlbum', array(), 'estore_admin_main_managephotos');

		$this->view->formFilter = $formFilter = new Estore_Form_Admin_Manage_FilterAlbum(array('albumTitle' =>'yes'));

		// Process form
    $values = array();
    if( $formFilter->isValid($this->_getAllParams()) ) {
      $values = $formFilter->getValues();
    }

    foreach( $_GET as $key => $value ) {
      if( '' === $value ) {
        unset($_GET[$key]);
      } else
				$values[$key]=$value;
    }

		if( $this->getRequest()->isPost() ) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $photo = Engine_Api::_()->getItem('estore_photo', $value);
          $photo->delete();
        }
      }
    }

    $tablePhoto = Engine_Api::_()->getDbTable('photos', 'estore');
    $tablePhotoName = $tablePhoto->info('name');

    $tableStore = Engine_Api::_()->getDbTable('stores', 'estore');
    $tableStoreName = $tableStore->info('name');

    $tableAlbum = Engine_Api::_()->getDbTable('albums', 'estore');
    $tableAlbumName = $tableAlbum->info('name');

    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select =  $tablePhoto->select()
                        ->from($tablePhotoName)
                        ->setIntegrityCheck(false)
                        ->joinLeft($tableAlbumName, "$tableAlbumName.album_id = $tablePhotoName.album_id",NULL)
                        ->joinLeft($tableStoreName, "$tableStoreName.store_id = $tablePhotoName.store_id", null)
                        ->joinLeft($tableUserName, "$tableUserName.user_id = $tablePhotoName.user_id", 'username');

		 // Set up select info
    if( !empty($values['title']) )
      $select->where($tablePhotoName.'.title LIKE ?',$values['title'] );

    if( !empty($values['album_title']) )
      $select->where($tableAlbumName.'.title LIKE ?', $values['album_title']);

    if( !empty($_GET['storetitle']) )
      $select->where($tableStoreName.'.title LIKE ?', '%' . $values['storetitle'] . '%');

    if( !empty($values['creation_date']) )
      $select->where($tablePhotoName.'.date(creation_date) = ?', $values['creation_date'] );

    if (!empty($values['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    $select->where($tableAlbumName.'.album_id != ?',0);
    $select->where($tablePhotoName.'.album_id != ?',0);
    $select->order($tablePhotoName.'.photo_id DESC');

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  //Featured Action
  public function featuredphotoAction() {
    $photo_id = $this->_getParam('id');
    if (!empty($photo_id)) {
      $photo = Engine_Api::_()->getItem('estore_photo', $photo_id);
      $photo->featured = !$photo->featured;
      $photo->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/estore/manage-album';
    $this->_redirect($url);
  }

  //Sponsored Action
  public function sponsoredphotoAction() {
    $photo_id = $this->_getParam('id');
    if (!empty($photo_id)) {
      $photo = Engine_Api::_()->getItem('estore_photo', $photo_id);
      $photo->sponsored = !$photo->sponsored;
      $photo->save();
    }
    if (isset($_SERVER['HTTP_REFERER']))
      $url = $_SERVER['HTTP_REFERER'];
    else
      $url = 'admin/estore/manage-album';
    $this->_redirect($url);
  }

	public function deletePhotoAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->album_id = $id = $this->_getParam('id');
    // Check post
    if( $this->getRequest()->isPost())
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try
      {
        $photo = Engine_Api::_()->getItem('estore_photo', $id);
        // delete the photo in the database
        $photo->delete();
        $db->commit();
      }
      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('Photo deleted successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manage-album/delete-photo.tpl');
	}
  public function deleteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->album_id = $id = $this->_getParam('id');
    // Check post
    if( $this->getRequest()->isPost())
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try
      {
        $album = Engine_Api::_()->getItem('estore_album', $id);
        // delete the album in the database
        $album->delete();
        $db->commit();
      }
      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('Album deleted successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manage-album/delete.tpl');
  }
}
