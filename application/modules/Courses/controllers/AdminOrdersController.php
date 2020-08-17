<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminOrdersController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_AdminOrdersController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_manageorde');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_manageorde', array(), 'courses_admin_main_manageordersub');
    $this->view->formFilter = $formFilter = new Courses_Form_Admin_FilterOrders();
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();
    $values = array_merge(array('order' => $_GET['order'], 'order_direction' => $_GET['order_direction']), $values);
    $this->view->assign($values);
    if ($this->getRequest()->isPost()) {
        $orderValues = $this->getRequest()->getPost();
        foreach ($orderValues as $key => $order_id) {
            if ($key == 'delete_' . $order_id) {
                $order = Engine_Api::_()->getItem('courses_order', $order_id);
                if($order)
                 $order->delete();
            }
        }
    }
    $ordersTable = Engine_Api::_()->getDbTable('orders', 'courses');
    $ordersTableName = $ordersTable->info('name');
    $select = $ordersTable->select()
            ->setIntegrityCheck(false)
            ->from($ordersTableName,array('order_id','total_amount','change_rate','currency_symbol','gateway_type','state','creation_date','modified_date','gateway_id','user_id'))
            ->order($ordersTableName.'.'.(!empty($_GET['order']) ? $_GET['order'] : 'order_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['gateway']))
      $select->where($ordersTableName . '.gateway_type LIKE ?', '%' . $_GET['gateway'] . '%');
    if (!empty($_GET['owner_name']))
      $select->where($userName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    if (!empty($_GET['status'])) {
       $status = $_GET['status'];
       if($status == "approval_pending"){
           $select->where($ordersTableName . '.gateway_id = 20 || '.$ordersTableName.'.gateway_id = 21')
           ->where($ordersTableName.'.state = "processing"');
       }else if($status == "pending"){
            $select ->where($ordersTableName.'.state = "pending"');
       }else if($status == "prcessing"){
           $select ->where($ordersTableName.'.state = "processing"');
       }else if($status == "hold"){
           $select ->where($ordersTableName.'.state = "hold"');
       }else if($status == "fraud"){
           $select ->where($ordersTableName.'.state = "fraud"');
       }else if($status == "complete"){
           $select ->where($ordersTableName.'.state = "complete"');
       }else if($status == "cancelled"){
           $select ->where($ordersTableName.'.state = "cancelled"');
       }
    }
    if (!empty($_GET['date']['date_from']))
        $select->having($ordersTableName . '.creation_date <=?', $_GET['date']['date_from']);
    if (!empty($_GET['date']['date_to']))
        $select->having($ordersTableName . '.creation_date >=?', $_GET['date']['date_to']);
    if (!empty($_GET['amount']['order_min']))
        $select->where("$courseTableName.total_amount >=?", $_GET['amount']['order_min']);
    if (!empty($_GET['amount']['order_max']))
        $select->where("$courseTableName.total_amount <=?", $_GET['amount']['order_max']);
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

  }

    function changeOrderStatusAction(){
        $order_id = $this->_getParam('order_id');
        $status = $this->_getParam('status');
        $notifyBuyer = $this->_getParam('notify_buyer',0);
        $notifySeller = $this->_getParam('notify_seller',0);
        $order = Engine_Api::_()->getItem('courses_order',$order_id);
        if($order && $status){
            if($status == 4){
                //set from admin
               $order->fromAdmin();
               Engine_Api::_()->courses()->orderComplete($order,array(),true);
            }else if($status == 2){
                //on hold
                $order->state = "hold";
                $order->save();
            }else if($status == 3){
                //fraud payment
                $order->state = "fraud";
                $order->save();
            }
            $status = $this->view->partial('orderStatus.tpl','courses',array('item'=>$order));
            echo json_encode(array('status'=>1,'message'=>$status));die;
        }
        echo json_encode(array('status'=>0,'message'=>''));die;
    }
    function paymentApproveAction(){
        $order_id = $this->_getParam('order_id');
        $this->view->order_id = $order_id;
        $order = Engine_Api::_()->getItem('courses_order',$order_id);
        $this->view->order = $order;
        $this->view->course = Engine_Api::_()->getItem('courses',$order->course_id);
        if($order->gateway_id == 20){
            $this->view->orderCheques = Engine_Api::_()->getItem('courses_ordercheques',$order->cheque_id);
        }
        $this->_helper->layout->setLayout('admin-simple');
        if( !$order ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_("Order entry doesn't exist");
            return;
        }
        if( !$this->getRequest()->isPost() ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }
        $db = $order->getTable()->getAdapter();
        $db->beginTransaction();
        try {
            $order->fromAdmin();
            Engine_Api::_()->courses()->orderComplete($order,array(),true);
            $db->commit();
        } catch( Exception $e ) {
            $db->rollBack();
            throw $e;
        }
        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Order marked as completed successfully.');
        return $this->_forward('success' ,'utility', 'core', array(
            'smoothboxClose' => true,
            'parentRefresh' => true,
            'messages' => array($this->view->message)
        ));

    }
    function paymentCancelAction(){
        $order_id = $this->_getParam('order_id');
        $this->view->order_id = $order_id;
        $order = Engine_Api::_()->getItem('courses_order',$order_id);
        $this->view->order = $order;
        $this->view->course = Engine_Api::_()->getItem('courses',$order->course_id);
        $this->view->form = $form = new Courses_Form_Delete();
        $form->setTitle('Cancel this Order?');
        $form->submit->setLabel('Cancel Order');
        $form->setDescription("Are you sure you want to cancel this order?");

        $this->_helper->layout->setLayout('admin-simple');
        if( !$order ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_("Order entry doesn't exist");
            return;
        }
        if( !$this->getRequest()->isPost() ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }
        $db = $order->getTable()->getAdapter();
        $db->beginTransaction();
        try {
            $order->fromAdmin();
            $order->onCancel();
            $db->commit();
        } catch( Exception $e ) {
            $db->rollBack();
            throw $e;
        }
        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Order cancelled successfully.');
        return $this->_forward('success' ,'utility', 'core', array(
            'smoothboxClose' => true,
            'parentRefresh' => true,
            'messages' => array($this->view->message)
        ));

    }



}
