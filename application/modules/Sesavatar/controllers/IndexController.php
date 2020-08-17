<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesavatar_IndexController extends Core_Controller_Action_Standard {

  public function avatarsAction() {

    if (!$this->_helper->requireUser()->isValid())
      return;

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();


    if (!Engine_Api::_()->core()->hasSubject()) {
      // Can specifiy custom id
      $id = $this->_getParam('user_id', null);
      $subject = null;
      if (null === $id) {
        $subject = Engine_Api::_()->user()->getViewer();
        Engine_Api::_()->core()->setSubject($subject);
      } else {
        $subject = Engine_Api::_()->getItem('user', $id);
        Engine_Api::_()->core()->setSubject($subject);
      }
    }
    if ($id) {
      $params = array('id' => $id);
    } else {
      $params = array();
    }

    $this->view->user = $user = Engine_Api::_()->getItem('user', $subject->getIdentity());

    // Set up navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('user_edit', array('params' => $params));

    $this->view->form = $form = new Sesavatar_Form_Avatars();

    if (empty($user->photo_id)) {
        $form->removeElement('remove');
    }

    $form->populate(array('image_id' => $user->photo_id));

    // Check if post
    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Not post');
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      $this->view->status = false;
      $this->view->error =  Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }

    if ($this->getRequest()->getPost()) {
      Engine_Api::_()->getItemTable('user')->update(array('photo_id' => $_POST['image_id']), array('user_id = ?' => $user->getIdentity()));
      $form->addNotice(Zend_Registry::get('Zend_Translate')->_('Your changes have been saved.'));
      return $this->_helper->redirector->gotoRoute(array());
    }
  }

    public function removePhotoAction()
    {
        // Get form
        $this->view->form = $form = new Sesavatar_Form_RemovePhoto();

        if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost())) {
            return;
        }
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer->photo_id = 0;
        $viewer->save();

        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your avatar photo has been removed.');

        $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => true,
            'parentRefresh' => true,
            'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your avatar photo has been removed.'))
        ));
    }

  public function avatarAction() {

    $userId = Zend_Controller_Front::getInstance()->getRequest()->getParam('user_id', 0);
    $rowExists = Engine_Api::_()->getDbTable('avatars', 'sesavatar')->rowExists($userId);

    $hours = 0;
    if(!empty($rowExists)) {
      $creation_date = $rowExists->creation_date;

      $date1 = $creation_date;
      $date2 = date('Y-m-d H:i:s');
      $seconds = strtotime($date2) - strtotime($date1);
      $hours = $seconds / 60 /  60;
      if($hours > 24) {
        $rowExists->delete();
      }
    }

    $this->view->form = $form = new Sesavatar_Form_Avatar();

    // Check if post
    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Not post');
      return;
    }

    if(!$form->isValid($this->getRequest()->getPost()) && !$id) {
      $this->view->status = false;
      $this->view->error =  Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    $userphoto_id = $viewer->photo_id;

    $values = $form->getValues();

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    // If we're here, we're done
    $this->view->status = true;
    try {
      $isRowExists = Engine_Api::_()->getDbTable('avatars', 'sesavatar')->isRowExists($viewer_id, $values['image_id'], 'avatar');
      $db->commit();
    } catch(Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('Avatar Image Uploaded Successfully.')
    ));
  }

  public function takemeoutavatarAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesavatar_Form_TakeMeOut();

    $form->setTitle('Take Me Out From Avatar');
    $form->setDescription('Are you sure that you want to out from avatar. It will not be recoverable after being out from avatar mode.');

    $form->submit->setLabel('Take Me Out');

    $userphoto_id = $this->_getParam('userphoto_id', null);

    $avatar_id = $this->_getParam('avatar_id', null);
    $avatar = Engine_Api::_()->getItem('sesavatar_avatar', $avatar_id);

    $user_id = $this->_getParam('user_id', null);

    $user = Engine_Api::_()->getItem('user', $user_id);

    // Check post
    if ($this->getRequest()->isPost()) {

      $avatar->image_id = 0;
      $avatar->save();

      $user->photo_id = $userphoto_id;
      $user->save();

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have Successfully out from avatar mode.')
      ));
    }
  }

  public function takemeoutingoavatarAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesavatar_Form_TakeMeOutIncognito();

    $form->setTitle('Take Me Out From Incognito Avatar');
    $form->setDescription('Are you sure that you want to out from incognito avatar. It will not be recoverable after being out from avatar mode.');

    $form->submit->setLabel('Take Me Out From Incognito Avatar');

    $userphoto_id = $this->_getParam('userphoto_id', null);
    $user_id = $this->_getParam('user_id', null);
    $user = Engine_Api::_()->getItem('user', $user_id);

    $avatar_id = $this->_getParam('avatar_id', null);
    $avatar = Engine_Api::_()->getItem('sesavatar_avatar', $avatar_id);

    // Check post
    if ($this->getRequest()->isPost()) {

      $avatar->avatar_ingo_id = 0;
      $avatar->save();

      $user->photo_id = $userphoto_id;
      $user->save();

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have Successfully out from incognito avatar mode.')
      ));
    }
  }

  public function incognitoavatarAction() {

    $userId = Zend_Controller_Front::getInstance()->getRequest()->getParam('user_id', 0);
    $rowExists = Engine_Api::_()->getDbTable('avatars', 'sesavatar')->rowExists($userId);
    $hours = 0;
    if(!empty($rowExists)) {
      $creation_date = $rowExists->creation_date;

      $date1 = $creation_date;
      $date2 = date('Y-m-d H:i:s');
      $seconds = strtotime($date2) - strtotime($date1);
      $hours = $seconds / 60 /  60;
      if($hours > 24) {
        $rowExists->delete();
      }
    }

    $this->view->form = $form = new Sesavatar_Form_Incognitoavatar();

    if(empty($userId)) {
      $form->setTitle('Go To Incognito Mode');
      $form->setDescription('Are you sure that you want to go in incognito avatar mode.');
      $form->submit->setLabel('Go to Incognito Mode');
    } else {
      $form->setTitle('Go To Incognito Mode');
    }

    // Check if post
    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Not post');
      return;
    }

    if(!$form->isValid($this->getRequest()->getPost()) && !$id) {
      $this->view->status = false;
      $this->view->error =  Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    $userphoto_id = $viewer->photo_id;

    $values = $form->getValues();

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    // If we're here, we're done
    $this->view->status = true;
    try {

      $profile_type = Engine_Api::_()->sesavatar()->getprofileFieldValue(array('user_id' => $viewer_id, 'field_id' => 1));

      $firstNameFieldId = Engine_Api::_()->sesavatar()->getFieldId(array('first_name'), $profile_type);

      $firstName = Engine_Api::_()->sesavatar()->getprofileFieldValue(array('user_id' => $viewer_id, 'field_id' => $firstNameFieldId));

      $image_id = Engine_Api::_()->sesavatar()->letterAvatar($viewer, $firstName);

      $isRowExists = Engine_Api::_()->getDbTable('avatars', 'sesavatar')->isRowExists($viewer_id, $image_id, 'ingo');

      $db->commit();
    } catch(Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('Avatar Image Uploaded Successfully.')
    ));
  }
}
