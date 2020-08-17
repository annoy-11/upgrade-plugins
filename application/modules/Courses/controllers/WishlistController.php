<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: WishlistController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_WishlistController extends Core_Controller_Action_Standard {

  public function init() {
    //Get viewer info
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    //Get subject
    if (null !== ($wishlist_id = $this->_getParam('wishlist_id')) && null !== ($wishlist = Engine_Api::_()->getItem('courses_wishlist', $wishlist_id)) && $wishlist instanceof Courses_Model_Wishlist && !Engine_Api::_()->core()->hasSubject()) {
      Engine_Api::_()->core()->setSubject($wishlist);
    }
  }
  public function browseAction() {
    $this->_helper->content->setEnabled();
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
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $this->view->wishlist = $wishlist = Engine_Api::_()->core()->getSubject('courses_wishlist');
		if(!$viewer->isSelf($wishlist->getOwner())){
			if($wishlist->is_private){
				return $this->_forward('requireauth', 'error', 'core');
			}
		}
    //Increment view count
    if (!$viewer->isSelf($wishlist->getOwner())) {
      $wishlist->view_count++;
      $wishlist->save();
    }
		 /* Insert data for recently viewed widget */
    if ($viewer->getIdentity() != 0) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_courses_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $wishlist->wishlist_id . '", "courses_wishlist","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	 creation_date = NOW()');
    }
    //Render
    $this->_helper->content->setEnabled();
  }
  //Delete wishlist songs Action
  public function deletePlaylistcourseAction() {
    //Get wishlist
    $course = Engine_Api::_()->getItem('courses_playlistcourse', $this->_getParam('playlistcourse_id'));
    $wishlist = Engine_Api::_()->getItem('courses_wishlist',$course->wishlist_id);
    //Check wishlist
    if (!$course || !$wishlist) {
      $this->view->success = false;
      $this->view->error = $this->view->translate('Invalid wishlist');
      return;
    }
    //Get file
    $file = Engine_Api::_()->getItem('storage_file', $course->file_id);
    if ($file) {
     $file->delete();
    }
    $db = $course->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      Engine_Api::_()->getDbtable('playlistcourses', 'courses')->delete(array('playlistcourse_id =?' => $this->_getParam('playlistcourse_id')));
      $wishlist->courses_count--;
      $wishlist->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollback();
      $this->view->success = false;
      $this->view->error = $this->view->translate('Unknown database error');
      throw $e;
    }
    $this->view->success = true;
  }
  //Edit Action
  public function editAction() {
    //Only members can upload video
    if (!$this->_helper->requireUser()->isValid())
      return;
    //Get wishlist
    $this->view->wishlist = $wishlist = Engine_Api::_()->getItem('courses_wishlist', $this->_getParam('wishlist_id'));
    //Make form
    $this->view->form = $form = new Courses_Form_Wishlist_Edit();
    $form->populate($wishlist->toarray());
    if (!$this->getRequest()->isPost())
      return;
    if (!$form->isValid($this->getRequest()->getPost()))
      return;
    $values = $form->getValues();
    unset($values['file']);
    $db = Engine_Api::_()->getDbTable('wishlists', 'courses')->getAdapter();
    $db->beginTransaction();
    try {
      $wishlist->title = $values['title'];
      $wishlist->description = $values['description'];
			$wishlist->is_private = $values['is_private'];
      $wishlist->save();
      //Photo upload for wishlist
      if (!empty($values['mainphoto'])) {
        $previousPhoto = $wishlist->photo_id;
        if ($previousPhoto) {
          $wishlistPhoto = Engine_Api::_()->getItem('storage_file', $previousPhoto);
          $wishlistPhoto->delete();
        }
        $wishlist->setPhoto($form->mainphoto, 'mainPhoto');
      }
      if (isset($values['remove_photo']) && !empty($values['remove_photo'])) {
        $storage = Engine_Api::_()->getItem('storage_file', $wishlist->photo_id);
        $wishlist->photo_id = 0;
        $wishlist->save();
        if ($storage)
          $storage->delete();
      }
      $db->commit();
    } catch (Exception $e) {
      $db->rollback();
      throw $e;
    }
    return $this->_forward('success', 'utility', 'core', array( 'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your changes has been successfully saved')),'closeSmoothbox' => true,'layout' => 'default-simple','parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'my-wishlists'), 'courses_account', true), 'messages' => Array($this->view->message)));
  }

  //Delete Playlist Action
  public function deleteAction() {
    $wishlist = Engine_Api::_()->getItem('courses_wishlist', $this->getRequest()->getParam('wishlist_id'));
    $isAjax = $this->getRequest()->getParam('wishlist_id');
    //In smoothbox

        $this->_helper->layout->setLayout('default-simple');
        $this->view->form = $form = new Sesbasic_Form_Delete();
        $form->setTitle('Delete Wishlist?');
        $form->setDescription('Are you sure that you want to delete this wishlist? It will not be recoverable after being deleted. ');
        $form->submit->setLabel('Delete');
    if (!$wishlist) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Wishlist doesn't exists or not authorized to delete");
      return;
    }
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    $db = $wishlist->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      //Delete all wishlist courses which is related to this wishlist
      Engine_Api::_()->getDbtable('playlistcourses', 'courses')->delete(array('wishlist_id =?' => $this->_getParam('wishlist_id')));
      $wishlist->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected wishlist has been deleted.');
    return $this->_forward('success', 'utility', 'core', array('parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'my-wishlists'), 'courses_account', true), 'messages' => Array($this->view->message)));
  }

  public function addAction() {
    //Check auth
    if (!$this->_helper->requireUser()->isValid())
      return;
    if (!$this->_helper->requireAuth()->setAuthParams('courses', null, 'addwishlist')->isValid())
      return;
    //Set song
    $course = Engine_Api::_()->getItem('courses', $this->_getParam('course_id'));
    $course_id = $course->course_id;
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    //Get form
    $this->view->form = $form = new Courses_Form_Wishlist_Append();
    if ($form->wishlist_id) {
      //Populate form
      $wishlistTable = Engine_Api::_()->getDbtable('wishlists', 'courses');
      $select = $wishlistTable->select()
              ->from($wishlistTable, array('wishlist_id', 'title'));
      $select->where('owner_id = ?', $viewer->getIdentity());
      $wishlists = $wishlistTable->fetchAll($select);
      if ($wishlists)
        $wishlists = $wishlists->toArray();
      foreach ($wishlists as $wishlist)
        $form->wishlist_id->addMultiOption($wishlist['wishlist_id'], html_entity_decode($wishlist['title']));
    }
    //Check method/data
    if (!$this->getRequest()->isPost())
      return;
    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Get values
    $values = $form->getValues();
    if (empty($values['wishlist_id']) && empty($values['title']))
      return $form->addError('Please enter a title or select a wishlist.');
    //Process
    $wishlistCourseTable = Engine_Api::_()->getDbtable('wishlists', 'courses');
    $db = $wishlistCourseTable->getAdapter();
    $db->beginTransaction();
    try {
      //Existing wishlist
      if (!empty($values['wishlist_id'])) {
        $wishlist = Engine_Api::_()->getItem('courses_wishlist', $values['wishlist_id']);
        //Already exists in wishlist
        $alreadyExists = Engine_Api::_()->getDbtable('playlistcourses', 'courses')->checkCoursesAlready(array('column_name' => 'playlistcourse_id','file_id' => $course_id, 'wishlist_id' => $wishlist->wishlist_id));
        if ($alreadyExists)
          return $form->addError($this->view->translate("This wishlist already has this course."));
      }
      //New wishlist
      else {
        $wishlist = $wishlistCourseTable->createRow();
        $wishlist->title = trim($values['title']);
        $wishlist->description = $values['description'];
        $wishlist->owner_id = $viewer->getIdentity();
        $wishlist->is_private = $values['is_private'];
        $wishlist->save();
      }
      $wishlist->courses_count++;
      $wishlist->save(); 
      $wishlist->addCourse($course->photo_id, $course_id);
      //Photo upload for wishlist
      if (!empty($values['mainphoto'])) {
        $previousPhoto = $wishlist->photo_id;
        if ($previousPhoto) {
          $wishlistPhoto = Engine_Api::_()->getItem('storage_file', $previousPhoto);
          $wishlistPhoto->delete();
        }
        $wishlist->setPhoto($form->mainphoto, 'mainPhoto');
      }
      if (isset($values['remove_photo']) && !empty($values['remove_photo'])) {
        $storage = Engine_Api::_()->getItem('storage_file', $wishlist->photo_id);
        $wishlist->photo_id = 0;
        $wishlist->save();
        if($storage)
          $storage->delete();
      }
      $this->view->wishlist = $wishlist;
      $user = Engine_Api::_()->getItem('user', $wishlist->owner_id);
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($user, $viewer, $course, 'courses_wishlist_create');
      //Activity Feed work
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $course, "courses_wishlist_create", '', array('wishlist' => array($wishlist->getType(), $wishlist->getIdentity()),
      ));
      if ($action) {
        Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $course);
      }

      $db->commit();
      //Response
      $this->view->success = true;
      $this->view->message = $this->view->translate('Course has been successfully added to your wishlist.');
      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 300,
                  'messages' => array('Course has been successfully added to your wishlist.')
      ));
    } catch (Eclassroom_Model_Exception $e) {
      $this->view->success = false;
      $this->view->error = $this->view->translate($e->getMessage());
      $form->addError($e->getMessage());
      $db->rollback();
    } catch (Exception $e) {throw $e;
      $this->view->success = false;
      $db->rollback();
    }
  }

}
