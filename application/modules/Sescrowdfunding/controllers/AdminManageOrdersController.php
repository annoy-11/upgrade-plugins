<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageOrdersController.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_AdminManageOrdersController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_manageorders');

    $this->view->formFilter = $formFilter = new Sescrowdfunding_Form_Admin_ManageOrders_Filter();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('orders', 'sescrowdfunding');
    $tableName = $table->info('name');
    $crowdfundingTableName = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->info('name');
    $select = $table->select()
                    ->from($tableName)
                    ->setIntegrityCheck(false)
                    ->join($crowdfundingTableName, "$crowdfundingTableName.crowdfunding_id = $tableName.crowdfunding_id", null)
                    ->where($tableName.'.state =?', 'complete');

    // Process form
    $values = array();
    if( $formFilter->isValid($this->_getAllParams()) ) {
      $values = $formFilter->getValues();
    }

    foreach( $values as $key => $value ) {
      if( null === $value ) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array(
      'order' => 'order_id',
      'order_direction' => 'DESC',
    ), $values);

    $this->view->assign($values);

    // Set up select info
    $select->order(( !empty($values['order']) ? $values['order'] : 'order_id' ) . ' ' . ( !empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    if( !empty($values['title']) ) {
      $select->where($crowdfundingTableName .'.title LIKE ?', '%' . $values['title'] . '%');
    }

    if( !empty($values['email']) ) {
      $select->where($tableName .'.email LIKE ?', '%' . $values['email'] . '%');
    }

    // Filter out junk
    $valuesCopy = array_filter($values);

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber( $page );
    $this->view->formValues = $valuesCopy;
  }
}
