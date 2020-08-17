<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class sesmemveroth_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmemveroth_admin_main', array(), 'sesmemveroth_admin_main_manage');

    $this->view->formFilter = $formFilter = new Sesmemveroth_Form_Admin_Manage_FilterManage();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('users', 'user');
    $tableName = $table->info('name');

    $verificationsTable = Engine_Api::_()->getDbtable('verifications', 'sesmemveroth');
    $verificationsTableName = $verificationsTable->info('name');

    $select = $table->select()
                    ->setIntegrityCheck(false)
                    ->from($tableName, array('user_id', 'displayname', 'email', 'photo_id', new Zend_Db_Expr('COUNT(verification_id) as totalverificationcount')))
                    ->join($verificationsTableName, "$tableName.user_id = $verificationsTableName.resource_id", array('*'))
                    ->where($verificationsTableName.'.admin_approved =?', 1);

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

    //Set up select info
    $select->order((!empty($values['order']) ? $values['order'] : 'user_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    if (!empty($values['displayname']))
      $select->where($tableName.'.displayname LIKE ?', '%' . $values['displayname'] . '%');

    if (!empty($values['username']))
      $select->where($tableName.'.username LIKE ?', '%' . $values['username'] . '%');

    if (!empty($values['email']))
      $select->where($tableName.'.email LIKE ?', '%' . $values['email'] . '%');

    if (isset($values['admin_enabled']) && $values['admin_enabled'] != -1)
      $select->where($verificationsTableName.'.admin_enabled = ?', $values['admin_enabled']);

    if (!empty($values['user_id']))
      $select->where($tableName.'.user_id = ?', (int) $values['user_id']);

    $select->group($verificationsTableName.'.resource_id');
    // Filter out junk
    $valuesCopy = array_filter($values);

//     if (isset($_GET['featured']) && $_GET['featured'] != '')
//       $select->where('featured = ?', $values['featured']);

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(50);
    $this->view->formValues = $valuesCopy;
    $this->view->hideEmails = _ENGINE_ADMIN_NEUTER;
  }

  public function enabledAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $resource_id = $this->_getParam('resource_id');
    $admin_enabled = $this->_getParam('admin_enabled');
    if (!empty($resource_id) && $admin_enabled) {
      Engine_Api::_()->getDbTable('verifications', 'sesmemveroth')->update(array('admin_enabled' => 0), array('resource_id = ?' => $resource_id));
    } else {
      Engine_Api::_()->getDbTable('verifications', 'sesmemveroth')->update(array('admin_enabled' => 1), array('resource_id = ?' => $resource_id));
    }
    $this->_redirect('admin/sesmemveroth/manage');
  }

  public function viewAction() {
    $resource_id = $this->_getParam('resource_id', null);
    $this->view->resource = Engine_Api::_()->getItem('user', $resource_id);
    $this->view->allRequests = Engine_Api::_()->getDbTable('verifications', 'sesmemveroth')->getAllUserVerificationRequests($resource_id);
  }


  public function removeAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $resource_id = $this->_getParam('resource_id');

    $this->view->form = $form = new Sesmemveroth_Form_Admin_Remove();
    $form->setTitle('Remove Verification');
    $form->setDescription('Are you sure you want to Remove all the verifications for this user? Removing all the verifications will delete all the verifications made by all other users on your website. Once removed, this action cannot be undone.');
    $form->submit->setLabel('Remove');

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        Engine_Api::_()->getDbTable('verifications', 'sesmemveroth')->delete(array('resource_id' => $resource_id));
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
