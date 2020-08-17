<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Edeletedmember
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminManageController.php 2019-11-04 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Edeletedmember_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('edeletedmember_admin_main', array(), 'edeletedmember_admin_main_members');

    $this->view->formFilter = $formFilter = new Edeletedmember_Form_Admin_Manage_Filter();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('members', 'edeletedmember');
    $tableName = $table->info('name');

    $select = $table->select()
                    ->from($table->info('name'));

    // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array('order' => 'member_id', 'order_direction' => 'DESC'), $values);
    $this->view->assign($values);

    //Set up select info
    $select->order((!empty($values['order']) ? $values['order'] : 'member_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    if (!empty($values['displayname']))
      $select->where('displayname LIKE ?', '%' . $values['displayname'] . '%');

    if (!empty($values['username']))
      $select->where('username LIKE ?', '%' . $values['username'] . '%');

    if (!empty($values['email']))
      $select->where('email LIKE ?', '%' . $values['email'] . '%');

    // Filter out junk
    $valuesCopy = array_filter($values);

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(10);
    $this->view->formValues = $valuesCopy;
  }
}
