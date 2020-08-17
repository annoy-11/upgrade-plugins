<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageRequestsController.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class sesmemveroth_AdminManageRequestsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmemveroth_admin_main', array(), 'sesmemveroth_admin_main_managerequests');

    $this->view->formFilter = $formFilter = new Sesmemveroth_Form_Admin_Manage_Filter();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('users', 'user');
    $tableName = $table->info('name');

    $verificationsTable = Engine_Api::_()->getDbtable('verifications', 'sesmemveroth');
    $verificationsTableName = $verificationsTable->info('name');

    $select = $table->select()
                    ->setIntegrityCheck(false)
                    ->from($tableName, array('user_id', 'displayname', 'email', 'photo_id'));


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
        'order' => 'user_id',
        'order_direction' => 'DESC',
            ), $values);
    $this->view->assign($values);

//     if (!empty($values['displayname']))
         $select->join($verificationsTableName, "$tableName.user_id = $verificationsTableName.resource_id", array('verification_id', 'poster_id', 'resource_id', 'description', 'admin_approved', 'creation_date'));
//     else
//         $select->join($verificationsTableName, "$tableName.user_id = $verificationsTableName.poster_id",    array('verification_id', 'poster_id', 'resource_id', 'description', 'admin_approved', 'creation_date'));

    $select->where($verificationsTableName.'.admin_approved =?', 0);
    //Set up select info
    $select->order((!empty($values['order']) ? $values['order'] : 'user_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));


    if (!empty($values['displayname']))
      $select->where($verificationsTableName.'.resource_title LIKE ?', '%' . $values['displayname'] . '%');

    if (!empty($values['displaynamea']))
      $select->where($verificationsTableName.'.poster_title LIKE ?', '%' . $values['displaynamea'] . '%');

    if (!empty($values['description']))
      $select->where($verificationsTableName.'.description LIKE ?', '%' . $values['description'] . '%');


    if (!empty($_GET['creation_date']))
      $select->where($verificationsTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

//     if (!empty($values['user_id']))
//       $select->where($tableName.'.user_id = ?', (int) $values['user_id']);

    //$select->group($tableName.'.user_id');
    // Filter out junk
    $valuesCopy = array_filter($values);

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(50);
    $this->view->formValues = $valuesCopy;
    $this->view->hideEmails = _ENGINE_ADMIN_NEUTER;
  }

  public function approveAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->_helper->layout->setLayout('admin-simple');
    $viewer = Engine_Api::_()->user()->getViewer();
    $verification_id = $this->_getParam('verification_id');

    $this->view->form = $form = new Sesmemveroth_Form_Admin_Approve();
    $item = Engine_Api::_()->getItem('sesmemveroth_verification', $verification_id);

    $poster = Engine_Api::_()->getItem('user', $item->poster_id);
    $resource = Engine_Api::_()->getItem('user', $item->resource_id);

    if (!empty($verification_id))
      $form->populate($item->toArray());

    if ($this->getRequest()->isPost()) {

      if (!$form->isValid($this->getRequest()->getPost()))
        return;

      $values = $form->getValues();

      $item->admin_approved = 1;
      $item->description = $values['description'];
      $item->save();

      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($poster, $viewer, $resource, 'sesmemveroth_approve');

      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($resource, $poster, $poster, 'sesmemveroth_verified');

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully approved verifying request.')
      ));
    }
  }

  public function deleteAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $verification_id = $this->_getParam('verification_id');

    $this->view->form = $form = new Sesmemveroth_Form_Admin_Delete();
    $form->setTitle('Delete Verifying Request');
    $form->setDescription('Are you sure you want to delete this request? Member will not be notify.');
    $form->submit->setLabel('Delete');

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $item = Engine_Api::_()->getItem('sesmemveroth_verification', $verification_id);
        $item->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have been rejected verifying request successfully.')
      ));
    }
  }

  public function rejectAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $verification_id = $this->_getParam('verification_id');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Sesmemveroth_Form_Admin_Reject();
    $form->setTitle('Reject Verifying Request');
    $form->setDescription('Are you sure you want to reject this request? Member will be notify.');
    $form->submit->setLabel('Reject');

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $item = Engine_Api::_()->getItem('sesmemveroth_verification', $verification_id);
        $poster = Engine_Api::_()->getItem('user', $item->poster_id);
        $resource = Engine_Api::_()->getItem('user', $item->resource_id);
        $item->delete();
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($poster, $viewer, $resource, 'sesmemveroth_adminreject');
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have been rejected verifying request successfully.')
      ));
    }
  }
}
