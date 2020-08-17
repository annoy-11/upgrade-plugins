<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesuserdocverification_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesuserdocverion_admin_main', array(), 'sesuserdocverification_admin_main_manage');

    $this->view->formFilter = $formFilter = new Sesuserdocverification_Form_Admin_Manage_Filter();

    $page = $this->_getParam('page', 1);

    $documentsTable = Engine_Api::_()->getDbTable('documents', 'sesuserdocverification');
    $documentsTableName = $documentsTable->info('name');

    $table = Engine_Api::_()->getDbtable('users', 'user');
    $tableName = $table->info('name');

    $select = $table->select()
              ->setIntegrityCheck(false)
              ->from($tableName, array('user_id', 'displayname', 'email'))
              ->join($documentsTableName, "$documentsTableName.user_id = $tableName.user_id", array('file_id', 'storage_path', 'verified', 'document_id', 'documenttype_id', 'note'))
              ->where($documentsTableName. '.submintoadmin =?', '1');

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array(
        'order' => 'document_id',
        'order_direction' => 'DESC',
            ), $values);
    $this->view->assign($values);

    //Set up select info
    $select->order((!empty($values['order']) ? $values['order'] : 'document_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    if (!empty($values['displayname']))
      $select->where($tableName.'.displayname LIKE ?', '%' . $values['displayname'] . '%');

    if (!empty($values['username']))
      $select->where($tableName.'.username LIKE ?', '%' . $values['username'] . '%');

    if (!empty($values['email']))
      $select->where($tableName.'.email LIKE ?', '%' . $values['email'] . '%');

    if (!empty($values['user_id']))
      $select->where($tableName.'.user_id = ?', (int) $values['user_id']);

    // Filter out junk
    $valuesCopy = array_filter($values);
    if (isset($_GET['documenttype_id']) && $_GET['documenttype_id'] != '0')
      $select->where($documentsTableName .'.documenttype_id = ?', $values['documenttype_id']);

    if (isset($_GET['verified']) && $_GET['verified'] != '' && $_GET['verified'] == '1')
      $select->where($documentsTableName .'.verified = ?', '1');
    else if (isset($_GET['verified']) && $_GET['verified'] != '' && $_GET['verified'] == '0')
        $select->where($documentsTableName .'.verified IN (?)', array('0', '2'));

    if (isset($_GET['rejected']) && $_GET['rejected'] != '' && $_GET['rejected'] == '1')
      $select->where($documentsTableName .'.verified = ?', '2');
    else if (isset($_GET['rejected']) && $_GET['rejected'] != '' && $_GET['rejected'] == '0')
        $select->where($documentsTableName .'.verified IN (?)', array('0', '1'));

    if (isset($_GET['pending']) && $_GET['pending'] != '' && $_GET['pending'] == '1') {
      $select->where($documentsTableName .'.submintoadmin = ?', $values['pending'])->where($documentsTableName .'.verified = ?', '0');
    } else if (isset($_GET['pending']) && $_GET['pending'] != '' && $_GET['pending'] == '0') {
        $select->where($documentsTableName .'.submintoadmin = ?', '1')->where($documentsTableName .'.verified IN (?)', array('1', '2'));
    }
    $select->order($documentsTableName.'.document_id DESC');
    //echo $select;die;
    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(50);
    $this->view->formValues = $valuesCopy;
    $this->view->hideEmails = _ENGINE_ADMIN_NEUTER;
  }

  public function verificationTipAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesuserdocverion_admin_main', array(), 'sesuserdocverification_admin_main_vertip');

    $this->view->form = $form = new Sesuserdocverification_Form_Admin_Manage_Tip();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
        $values = $form->getValues();
        if (isset($values['sesuserdocverification_dotypetip']))
            $values['sesuserdocverification_dotypetip'] = serialize($values['sesuserdocverification_dotypetip']);
        else
            $values['sesuserdocverification_dotypetip'] = serialize(array());

        foreach ($values as $key => $value) {
          if($value != '')
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
    }
  }


  public function multiModifyAction()
  {
    if( $this->getRequest()->isPost() ) {
      $values = $this->getRequest()->getPost();
      $viewer = Engine_Api::_()->user()->getViewer();
      foreach ($values as $key=>$value) {
        if( $key == 'modify_' . $value ) {
          $document = Engine_Api::_()->getItem('sesuserdocverification_document', (int) $value);
          $user = Engine_Api::_()->getItem('user', $document->user_id);
          if( $values['submit_button'] == 'delete' ) {
              $document->delete();
          } else if( $values['submit_button'] == 'approve' ) {

            $document->verified = 1;
            $document->save();

            if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmember')) {
                $user->user_verified = !$document->verified;
                $user->save();
            }

            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $user, 'sesdocveri_verified');

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesdocveri_verified', array('sender_title' => $viewer->getTitle(), 'object_link' => $viewer->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          } else if( $values['submit_button'] == 'reject' ) {

            $document->verified = '2';
            $document->save();

            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $user, 'sesdocveri_reject');

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesdocveri_reject', array('sender_title' => $viewer->getTitle(), 'object_link' => $viewer->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
    }

    return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

  public function verifiedAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $id = $this->_getParam('document_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesuserdocverification_document', $id);
      $item->verified = !$item->verified;
      $item->save();
    }

    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmember')) {
      $user = Engine_Api::_()->getItem('user', $item->user_id);
      $user->user_verified = !$item->verified;
      $user->save();
    }
    $this->_redirect('admin/sesuserdocverification/manage');
  }

  public function rejectAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $document_id = $this->_getParam('id');

    $document = Engine_Api::_()->getItem('sesuserdocverification_document', $document_id);
    $documentsTable = Engine_Api::_()->getDbtable('documents', 'sesuserdocverification');
    $user = Engine_Api::_()->getItem('user', $document->user_id);
    $viewer = Engine_Api::_()->user()->getViewer();

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-manage/reject.tpl');
      return;
    }

    // Process
    $db = $documentsTable->getAdapter();
    $db->beginTransaction();
    try {
        $document->verified = '2';
        if(!empty($_POST['note'])) {
            $document->note = $_POST['note'];
        }
        $document->save();

        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $user, 'sesdocveri_reject');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesdocveri_reject', array('sender_title' => $viewer->getTitle(), 'object_link' => $viewer->getHref(), 'host' => $_SERVER['HTTP_HOST']));

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('You have successfully rejected document verification.')
    ));
  }


  public function verifieddocumentAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $document_id = $this->_getParam('id');

    $this->view->enable = $enable = $this->_getParam('enable', 0);
    $this->view->user_id = $user_id = $this->_getParam('user_id', 0);

    $document = Engine_Api::_()->getItem('sesuserdocverification_document', $document_id);
    $documentsTable = Engine_Api::_()->getDbtable('documents', 'sesuserdocverification');
    $user = Engine_Api::_()->getItem('user', $document->user_id);
    $viewer = Engine_Api::_()->user()->getViewer();

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-manage/verifieddocument.tpl');
      return;
    }

    // Process
    $db = $documentsTable->getAdapter();
    $db->beginTransaction();

    try {

      $document->verified = 1;
      $document->save();

      if($enable) {
        $user = Engine_Api::_()->getItem('user', $user_id);
        $user->enabled = 1;
        $user->approved = 1;
        $user->save();
      }

      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $user, 'sesdocveri_verified');

      Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_sesdocveri_verified', array('sender_title' => $viewer->getTitle(), 'object_link' => $viewer->getHref(), 'host' => $_SERVER['HTTP_HOST']));

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('')
    ));
  }


  public function documenttypesAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesuserdocverion_admin_main', array(), 'sesuserdocverification_admin_main_documenttype');

    $this->view->documenttypes = Engine_Api::_()->getItemTable('sesuserdocverification_documenttype')->fetchAll();
  }


  public function addAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    // Generate and assign form
    $form = $this->view->form = new Sesuserdocverification_Form_Admin_Document();
    $form->setAction($this->view->url(array()));

    // Check post
    if( !$this->getRequest()->isPost() ) {
      $this->renderScript('admin-manage/form.tpl');
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      $this->renderScript('admin-manage/form.tpl');
      return;
    }


    // Process
    $values = $form->getValues();

    $documenttypeTable = Engine_Api::_()->getItemTable('sesuserdocverification_documenttype');
    $db = $documenttypeTable->getAdapter();
    $db->beginTransaction();

    $viewer = Engine_Api::_()->user()->getViewer();

    try {
      $documenttypeTable->insert(array(
        'user_id' => $viewer->getIdentity(),
        'document_name' => $values['label'],
      ));

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('')
    ));
  }


  public function editAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $documenttype_id = $this->_getParam('id');
    $this->view->documenttype_id = $documenttype_id;
    $documenttypesTable = Engine_Api::_()->getDbtable('documenttypes', 'sesuserdocverification');
    $documenttype = $documenttypesTable->find($documenttype_id)->current();

    if( !$documenttype ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $documenttype_id = $documenttype->getIdentity();
    }

    $form = $this->view->form = new Sesuserdocverification_Form_Admin_Document();
    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
    $form->setField($documenttype);

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-manage/form.tpl');
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      // Output
      $this->renderScript('admin-manage/form.tpl');
      return;
    }

    // Process
    $values = $form->getValues();

    $db = $documenttypesTable->getAdapter();
    $db->beginTransaction();

    try {
      $documenttype->document_name = $values['label'];
      $documenttype->save();

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('')
    ));
  }

  public function noteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $document_id = $this->_getParam('id');
    $this->view->document = Engine_Api::_()->getItem('sesuserdocverification_document', $document_id);

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-manage/note.tpl');
      return;
    }
  }

  public function deletedocumentAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $document_id = $this->_getParam('id');
    $documentTable = Engine_Api::_()->getDbtable('documents', 'sesuserdocverification');
    $document = Engine_Api::_()->getItem('sesuserdocverification_document', $document_id);

    if( !$document ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    }

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-manage/deletedocument.tpl');
      return;
    }

    // Process
    $db = $documentTable->getAdapter();
    $db->beginTransaction();

    try {
      $storage = Engine_Api::_()->getItem('storage_file', $document->file_id);
      $storage->delete();
      $document->delete();
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('You have successfully deleted document.')
    ));
  }

  public function deletedocumentsAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $document_id = $this->_getParam('id');
    $documentTable = Engine_Api::_()->getDbtable('documents', 'sesuserdocverification');
    $document = Engine_Api::_()->getItem('sesuserdocverification_document', $document_id);

    if( !$document ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    }

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-manage/deletedocuments.tpl');
      return;
    }

    // Process
    $db = $documentTable->getAdapter();
    $db->beginTransaction();

    try {
      $storage = Engine_Api::_()->getItem('storage_file', $document->file_id);
      $storage->delete();
      $document->file_id = '0';
      $document->storage_path = '';
      $document->save();
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('You have successfully deleted document.')
    ));
  }


  public function deleteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $documenttype_id = $this->_getParam('id');
    $this->view->documenttype_id = $documenttype_id;
    $documenttypesTable = Engine_Api::_()->getDbtable('documenttypes', 'sesuserdocverification');
    $documenttype = $documenttypesTable->find($documenttype_id)->current();

    if( !$documenttype ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh'=> 10,
        'messages' => array('')
      ));
    } else {
      $documenttype_id = $documenttype->getIdentity();
    }

    if( !$this->getRequest()->isPost() ) {
      // Output
      $this->renderScript('admin-manage/delete.tpl');
      return;
    }

    // Process
    $db = $documenttypesTable->getAdapter();
    $db->beginTransaction();

    try {
      //$storage = Engine_Api::_()->getItem('storage_file', $documenttype->file_id);
      //$storage->delete();
      $documenttype->delete();

      $documentTable = Engine_Api::_()->getDbtable('documents', 'sesuserdocverification');
      $documentTable->update(array('documenttype_id' => 0), array('documenttype_id = ?' => $documenttype_id));

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh'=> 10,
      'messages' => array('')
    ));
  }
}
