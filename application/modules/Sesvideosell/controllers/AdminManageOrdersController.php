<?php

class Sesvideosell_AdminManageOrdersController extends Core_Controller_Action_Admin {

  public function indexAction() { 
  
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesvideosell_admin_main', array(), 'sesvideosell_admin_manageorders');
    
    $this->view->formFilter = $formFilter = new Sesvideosell_Form_Admin_Manage_Filter();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('orders', 'sesvideosell');
    $tableName = $table->info('name');
    $videoTableName = Engine_Api::_()->getDbtable('videos', 'sesvideo')->info('name');
    $select = $table->select()
                    ->from($tableName)
                    ->setIntegrityCheck(false)
                    ->join($videoTableName, "$videoTableName.video_id = $tableName.video_id", null)
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
      $select->where($videoTableName .'.title LIKE ?', '%' . $values['title'] . '%');
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