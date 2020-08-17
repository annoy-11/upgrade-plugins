<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesemailverification_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesemailverification_admin_main', array(), 'sesemailverification_admin_main_manage');

    $this->view->formFilter = $formFilter = new Sesemailverification_Form_Admin_Manage_Filter();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('users', 'user');
    $tableName = $table->info('name');

    $verificationsTable = Engine_Api::_()->getDbtable('verifications', 'sesemailverification');
    $verificationsTableName = $verificationsTable->info('name');

    $select = $table->select()->setIntegrityCheck(false)
              ->from($tableName, array('user_id', 'displayname', 'email', 'approved'))
              ->joinLeft($verificationsTableName, $verificationsTableName.'.user_id ='.$tableName.'.user_id', 'sesemailverified');

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

    if (!empty($values['user_id']))
      $select->where($tableName.'.user_id = ?', (int) $values['user_id']);

    // Filter out junk
    $valuesCopy = array_filter($values);

    if (isset($_GET['approved']) && $_GET['approved'] != '')
      $select->where($tableName .'.approved = ?', $values['approved']);

    if (isset($_GET['sesemailverified']) && $_GET['sesemailverified'] != '')
      $select->where($verificationsTableName .'.sesemailverified = ?', $values['sesemailverified']);

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(50);
    $this->view->formValues = $valuesCopy;
    $this->view->hideEmails = _ENGINE_ADMIN_NEUTER;
  }

  public function approvedAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $id = $this->_getParam('user_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('user', $id);
      $item->approved = !$item->approved;
      $item->save();
    }
    $this->_redirect('admin/sesemailverification/manage');
  }

  public function sesemailverifiedAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $id = $this->_getParam('verification_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesemailverification_verification', $id);
      $item->sesemailverified = !$item->sesemailverified;
      $item->save();
    }
    $this->_redirect('admin/sesemailverification/manage');
  }
}
