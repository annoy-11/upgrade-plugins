<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminOrdersController.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_AdminOrdersController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'sesproduct_admin_main_manageorde');

    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main_manageorde', array(), 'sesproduct_admin_main_manageordersub');

    $this->view->formFilter = $formFilter = new Sesproduct_Form_Admin_FilterOrders();
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    $values = array_merge(array('order' => $_GET['order'], 'order_direction' => $_GET['order_direction']), $values);

    $this->view->assign($values);
    if ($this->getRequest()->isPost()) {
        $orderValues = $this->getRequest()->getPost();
        foreach ($orderValues as $key => $order_id) {
            if ($key == 'delete_' . $order_id) {
                $order = Engine_Api::_()->getItem('sesproduct_order', $order_id);
                if($order)
                 $order->delete();
            }
        }
    }

    $storeTableName = Engine_Api::_()->getItemTable('stores')->info('name');
    $ordersTable = Engine_Api::_()->getDbTable('orders', 'sesproduct');
    $ordersTableName = $ordersTable->info('name');
    $userName = Engine_Api::_()->getItemTable('user')->info('name');

    $ordersAddressName =  Engine_Api::_()->getDbTable('orderaddresses', 'sesproduct')->info('name');
      $ordersChequesName =  Engine_Api::_()->getDbTable('ordercheques', 'sesproduct')->info('name');

    $select = $ordersTable->select()
            ->setIntegrityCheck(false)
            ->from($ordersTableName)
            ->joinLeft($storeTableName, "$ordersTableName.store_id = $storeTableName.store_id", 'title')
						->joinLeft($userName, "$userName.user_id = $storeTableName.owner_id", null)
						->where($storeTableName.'.store_id !=?','')
            ->order((!empty($_GET['order']) ? $_GET['order'] : 'order_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ))
            ->joinLeft($ordersAddressName,$ordersAddressName.'.order_id = '.$ordersTableName.'.order_id AND '.$ordersAddressName.'.type = 0',array('billing_name'=>'CONCAT('.$ordersAddressName.'.first_name," ",'.$ordersAddressName.'.last_name)'))
      ->joinLeft($ordersAddressName . " as c",'c.order_id = '.$ordersTableName.'.order_id AND c.type = 1',array('shipping_name'=>'CONCAT(c.first_name," ",c.last_name)'))
        ->joinLeft($ordersChequesName, "$ordersChequesName.ordercheque_id = $ordersTableName.cheque_id", null);

    if (!empty($_GET['store_name']))
      $select->where($storeTableName . '.title LIKE ?', '%' . $_GET['store_name'] . '%');

    if (!empty($_GET['gateway']))
      $select->where($ordersTableName . '.gateway_type LIKE ?', '%' . $_GET['gateway'] . '%');

    if (!empty($_GET['billing_name']))
      $select->where(  'CONCAT('.$ordersAddressName.'.first_name," ",'.$ordersAddressName.'.last_name) LIKE ?', '%' . $_GET['billing_name'] . '%');

    if (!empty($_GET['shipping_name']))
      $select->where('CONCAT(c.first_name," ",c.last_name) LIKE ?', '%' . $_GET['shipping_name'] . '%');


      if (!empty($_GET['cheque_number']))
          $select->where($ordersChequesName . '.cheque_number = ?', $_GET['cheque_number']);
      if (!empty($_GET['owner_name']))
      $select->where($userName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    if (!empty($_GET['creation_date']))
      $select->where($ordersTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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
          if (!empty($_GET['commission']['commission_min']))
              $select->where("$ordersTableName.commission_amount >=?", $_GET['commission']['commission_min']);
          if (!empty($_GET['commission']['commission_max']))
              $select->where("$ordersTableName.commission_amount <=?", $_GET['commission']['commission_max']);

          if (!empty($_GET['date']['date_to']))
              $select->where("$ordersTableName.creation_date >=?", $_GET['date']['date_to']);
          if (!empty($_GET['date']['commission_max']))
              $select->where("$ordersTableName.creation_date <=?", $_GET['date']['date_from']);

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

  }

    function changeOrderStatusAction(){
        $order_id = $this->_getParam('order_id');
        $status = $this->_getParam('status');
        $notifyBuyer = $this->_getParam('notify_buyer',0);
        $notifySeller = $this->_getParam('notify_seller',0);
        $order = Engine_Api::_()->getItem('sesproduct_order',$order_id);
        if($order && $status){
            if($status == 4){
                //set from admin
               $order->fromAdmin();
               Engine_Api::_()->sesproduct()->orderComplete($order,array(),true);
            }else if($status == 2){
                //on hold
                $order->state = "hold";
                $order->save();
            }else if($status == 3){
                //fraud payment
                $order->state = "fraud";
                $order->save();
            }
            $status = $this->view->partial('orderStatus.tpl','sesproduct',array('item'=>$order));
            echo json_encode(array('status'=>1,'message'=>$status));die;
        }
        echo json_encode(array('status'=>0,'message'=>''));die;
    }
    function paymentApproveAction(){
        $order_id = $this->_getParam('order_id');
        $this->view->order_id = $order_id;
        $order = Engine_Api::_()->getItem('sesproduct_order',$order_id);
        $this->view->order = $order;
        $this->view->store = Engine_Api::_()->getItem('stores',$order->store_id);
        if($order->gateway_id == 20){
            $this->view->orderCheques = Engine_Api::_()->getItem('sesproduct_ordercheques',$order->cheque_id);
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
            Engine_Api::_()->sesproduct()->orderComplete($order,array(),true);
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
        $order = Engine_Api::_()->getItem('sesproduct_order',$order_id);
        $this->view->order = $order;
        $this->view->store = Engine_Api::_()->getItem('stores',$order->store_id);
        $this->view->form = $form = new Sesproduct_Form_Delete();
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
