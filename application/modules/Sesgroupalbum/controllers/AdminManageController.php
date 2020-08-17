<?php

class Sesgroupalbum_AdminManageController extends Core_Controller_Action_Admin
{
  public function indexAction() {
  
    $this->view->navigation  = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroupalbum_admin_main', array(), 'sesgroupalbum_admin_main_manage');
		$this->view->formFilter = $formFilter = new Sesgroupalbum_Form_Admin_Manage_Filter();

		// Process form
    $values = array();
    if( $formFilter->isValid($this->_getAllParams()) ) {
      $values = $formFilter->getValues();
    }
    foreach( $_GET as $key => $value ) {
      if( '' === $value ) {
        unset($_GET[$key]);
      }else
				$values[$key]=$value;
    }
    if( $this->getRequest()->isPost() ) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $album = Engine_Api::_()->getItem('sesgroupalbum_album', $value);
          $album->delete();
        }
      }
    }
    
		$tableAlbum = Engine_Api::_()->getDbtable('albums', 'sesgroupalbum');
		$tableAlbumName = $tableAlbum->info('name');
		
    $select = $tableAlbum->select()
													->from($tableAlbumName)
		                      ->order('album_id DESC');
		
		// Set up select info
    if( !empty($_GET['title']) ) 
      $select->where('title LIKE ?', '%' . $values['title'] . '%');
    
    if( isset($_GET['is_featured']) && $_GET['is_featured'] != '') 
      $select->where('is_featured = ?', $values['is_featured']);
    
    if( isset($_GET['is_sponsored']) && $_GET['is_sponsored'] != '') 
      $select->where('is_sponsored = ?', $values['is_sponsored'] );
    
    if( !empty($values['creation_date']) ) 
      $select->where('date(creation_date) = ?', $values['creation_date'] );
    
		 if( isset($_GET['location']) && $_GET['location'] != '')
      $select->where('location != ?', '' );

		if( isset($_GET['offtheday']) && $_GET['offtheday'] != '')
			$select->where($tableAlbumName.'.offtheday =?',$values['offtheday']);	
		
   	if ( isset($_GET['rating']) && $_GET['rating'] != '') {
      if ($_GET['rating'] == 1):
        $select->where('rating != ?', 0);
      elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
        $select->where('rating =?', 0);
      endif;
    }
    $page = $this->_getParam('page', 1);
		
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
		$paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber( $page );
  }
  
  public function viewAction() {
    $this->view->type = $type = $this->_getParam('type', 1);
    $id = $this->_getParam('id', 1);
    if($type == 'sesgroupalbum_album')
      $item = Engine_Api::_()->getItem('sesgroupalbum_album', $id);
    else
      $item = Engine_Api::_()->getItem('sesgroupalbum_photo', $id);
    $this->view->item = $item;
  }
  
	public function ofthedayAction() {
	
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');
    $this->view->form = $form = new Sesgroupalbum_Form_Admin_Oftheday();
    if ($type == 'sesgroupalbum_album') {
      $item = Engine_Api::_()->getItem('sesgroupalbum_album', $id);
      $form->setTitle("Album of the Day");
      $form->setDescription('Here, choose the start date and end date for this album to be displayed as "Album of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Album of the Day");
      $table = 'engine4_group_albums';
      $item_id = 'album_id';
    } elseif ($type == 'sesgroupalbum_photo') {
      $item = Engine_Api::_()->getItem('sesgroupalbum_photo', $id);
      $form->setTitle("Photo of the Day");
      if (!$param)
        $form->remove->setLabel("Remove as Photo of the Day");
      $form->setDescription('Here, choose the start date and end date for this photo to be displayed as "Photo of the Day".');
      $table = 'engine4_group_photos';
      $item_id = 'photo_id';
    }
    if (!empty($id))
      $form->populate($item->toArray());
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost())) 
        return;
      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d',  strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));
      $db->update($table, array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("$item_id = ?" => $id));
      if ($values['remove']) {
        $db->update($table, array('offtheday' => 0), array("$item_id = ?" => $id));
      } else {
        $db->update($table, array('offtheday' => 1), array("$item_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Successfully updated the item.')
      ));
    }
  }

	public function photosAction() {
	
    $this->view->navigation  = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroupalbum_admin_main', array(), 'sesgroupalbum_admin_main_photos');
    
		$this->view->formFilter = $formFilter = new Sesgroupalbum_Form_Admin_Manage_Filter(array('albumTitle' =>'yes'));
		
		// Process form
    $values = array();
    if( $formFilter->isValid($this->_getAllParams()) ) {
      $values = $formFilter->getValues();
    }
    foreach( $_GET as $key => $value ) {
      if( '' === $value ) {
        unset($_GET[$key]);
      }else
				$values[$key]=$value;
    }
		if( $this->getRequest()->isPost() ) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $photo = Engine_Api::_()->getItem('sesgroupalbum_photo', $value);
          $photo->delete();
        }
      }
    }
				
		$tablePhoto = Engine_Api::_()->getDbtable('photos', 'sesgroupalbum');
		$tablePhotoName = $tablePhoto->info('name');
		$tableAlbum = Engine_Api::_()->getDbtable('albums', 'sesgroupalbum');
		$tableAlbumName = $tableAlbum->info('name');
		$tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select =  $tablePhoto->select()
													->from($tablePhotoName)
													->setIntegrityCheck(false)
													->joinLeft($tableAlbumName, "$tableAlbumName.album_id = $tablePhotoName.album_id",NULL);
												 
		 // Set up select info
    if( !empty($values['title']) ) 
      $select->where($tablePhotoName.'.title LIKE ?',$values['title'] );
    if( !empty($values['album_title']) ) 
      $select->where($tableAlbumName.'.title LIKE ?', $values['album_title']);
    
		if( isset($_GET['is_featured']) && $_GET['is_featured'] != '') 
      $select->where($tablePhotoName.'.is_featured  =?',  $values['is_featured'] );
    
    if( isset($_GET['is_sponsored']) && $_GET['is_sponsored'] != '') 
      $select->where($tablePhotoName.'.is_sponsored  =?',  $values['is_sponsored'] );
    
    if( !empty($values['creation_date']) ) 
      $select->where($tablePhotoName.'.date(creation_date) = ?', $values['creation_date'] );
    
   	 if( isset($_GET['location']) && $_GET['location'] != '') 
      $select->where($tablePhotoName.'.location = ?', $values['location'] );
    
		if( isset($_GET['offtheday']) && $_GET['offtheday'] != '')
			$select->where($tablePhotoName.'.offtheday =?',$values['offtheday']);	

   	if ( isset($_GET['rating']) && $_GET['rating'] != '') {
      if ($_GET['rating'] == 1):
        $select->where($tablePhotoName.'.rating <> ?', 0);
      elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
        $select->where($tablePhotoName.'.rating = ?', $_GET['rating']);
      endif;
    }
		$select->where($tableAlbumName.'.album_id != ?',0);
		$select->where($tablePhotoName.'.album_id != ?',0);
		$select->order($tablePhotoName.'.photo_id DESC');
		
    $page = $this->_getParam('page', 1);
		// Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
		$paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber( $page );
  }
  
	public function featureSponsoredAction(){
	
		$this->view->album_id = $id = $this->_getParam('id');
		$this->view->status = $status = $this->_getParam('status');
		$this->view->category = $category = $this->_getParam('category');
		$this->view->params = $params = $this->_getParam('param');
		if($status == 1)
			$statusChange = ' '.$category;
		else
			$statusChange = 'un'.$category;

			if($params == 'photos')
				$col = 'photo_id';
			else
				$col = 'album_id';
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try
      {
				Engine_Api::_()->getDbtable($params, 'sesgroupalbum')->update(array(
        'is_'.$category => $status,
      ), array(
        "$col = ?" => $id,
      ));
       $db->commit();
			}
      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }
			header('location:'.$_SERVER['HTTP_REFERER']);
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
        $photo = Engine_Api::_()->getItem('sesgroupalbum_photo', $id);
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
    $this->renderScript('admin-manage/delete-photo.tpl');
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
        $album = Engine_Api::_()->getItem('sesgroupalbum_album', $id);
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
    $this->renderScript('admin-manage/delete.tpl');
  }
}