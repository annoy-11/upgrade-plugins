<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminPaymentmadeController.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_AdminPaymentmadeController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_paymentmade');

    $this->view->formFilter = $formFilter = new Sescrowdfunding_Form_Admin_FilterPaymentCrowdfundingOwner();
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    $values = array_merge(array('order' => @$_GET['order'], 'order_direction' => @$_GET['order_direction']), $values);

    $this->view->assign($values);

    $crowdfundingTableName = Engine_Api::_()->getItemTable('crowdfunding')->info('name');

    $ordersTable = Engine_Api::_()->getDbTable('userpayrequests', 'sescrowdfunding');
    $ordersTableName = $ordersTable->info('name');

    $select = $ordersTable->select()
                        ->setIntegrityCheck(false)
                        ->from($ordersTableName)
                        ->joinLeft($crowdfundingTableName, "$ordersTableName.crowdfunding_id = $crowdfundingTableName.crowdfunding_id", 'title')
                        ->where($ordersTableName . '.state = ?', 'complete')
                        ->order((!empty($_GET['order']) ? $_GET['order'] : 'userpayrequest_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['name']))
      $select->where($crowdfundingTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['creation_date']))
      $select->where($ordersTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    if (!empty($_GET['gateway']))
      $select->where($ordersTableName . '.gateway_type LIKE ?', $_GET['gateway'] . '%');

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function viewPaymentrequestAction() {
    $this->view->item = Engine_Api::_()->getItem('sescrowdfunding_userpayrequest', $this->_getParam('id', null));
  }


//   public function indexAction() {
//
//     $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_paymentmade');
//
//     $userTableName = Engine_Api::_()->getItemTable('crowdfunding')->info('name');
//
//     $sescrowdfundingTable = Engine_Api::_()->getDbTable('remainingpayments', 'sescrowdfunding');
//     $sescrowdfundingTableName = $sescrowdfundingTable->info('name');
//
//     $select = $sescrowdfundingTable->select()
//             ->setIntegrityCheck(false)
//             ->from($sescrowdfundingTableName)
//             ->joinLeft($userTableName, "$sescrowdfundingTableName.crowdfunding_id = $userTableName.crowdfunding_id", 'title')
//             //->where($sescrowdfundingTableName . '.state = ?', 'complete')
//             ->order((!empty($_GET['order']) ? $_GET['order'] : 'remainingpayment_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
//
//     $paginator = Zend_Paginator::factory($select);
//     $this->view->paginator = $paginator;
//     $paginator->setItemCountPerPage(100);
//     $paginator->setCurrentPageNumber($this->_getParam('page', 1));
//   }

  public function approveAction() {

		$user = Engine_Api::_()->getItem('user', $this->getRequest()->getParam('user_id'));
	  $remainingpaymentItem = Engine_Api::_()->getItem('sescrowdfunding_remainingpayment', $this->getRequest()->getParam('id'));

		// In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
		$gateway_enable = Engine_Api::_()->getDbtable('usergateways', 'sesbasic')->getUserGateway(array('user_id'=>$user->user_id));

		if(empty($gateway_enable)) {
			$this->view->disable_gateway = true;
    } else {
      $this->view->disable_gateway = false;

      //Make form
      $this->view->form = $form = new Sescrowdfunding_Form_Admin_Payment_Approve();
      $defaultCurrency = Engine_Api::_()->sesbasic() ->defaultCurrency();

      $remainingAmount  =  $remainingpaymentItem->remaining_payment;
      $value = array();
      $value['remaining_payment'] = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($remainingAmount, $defaultCurrency);

      //set value to form
      if($this->_getParam('id',false)) {
        $item = Engine_Api::_()->getItem('sescrowdfunding_remainingpayment', $this->_getParam('id'));
        if($item) {
          $itemValue = $item->toArray();
          $value = array_merge($itemValue,$value);
        } else {
          return $this->_forward('requireauth', 'error', 'core');
        }
      }

      if(empty($_POST))
        $form->populate($value);

      if (!$this->getRequest()->isPost())
        return;

      if (!$form->isValid($this->getRequest()->getPost()))
        return;

//       if($item->remaining_payment < @round($_POST['release_amount'],2)){
//         $form->addError('Release amount must be less than or equal to total amount.');
//         return;
//       }

      $db = Engine_Api::_()->getDbtable('remainingpayments', 'sescrowdfunding')->getAdapter();
      $db->beginTransaction();
      try {

        $session = new Zend_Session_Namespace();
        $session->remainingpayment_id = $remainingpaymentItem->remainingpayment_id;
        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Processing...');
        return $this->_forward('success', 'utility', 'core', array(
              'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sescrowdfunding', 'controller' => 'paymentmade', 'action' => 'process', 'remainingpayment_id' => $remainingpaymentItem->remainingpayment_id),'admin_default',true),
              'messages' => array($this->view->message)
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
	}

	public function processAction() {

		$session = new Zend_Session_Namespace();
		$viewer = Engine_Api::_()->user()->getViewer();

// 		if(!$session->remainingpayment_id)
// 			return $this->_forward('requireauth', 'error', 'core');

		$remainingpayment_id = $this->_getParam('remainingpayment_id', null);

		$item = Engine_Api::_()->getItem('sescrowdfunding_remainingpayment', $remainingpayment_id);

		$user = Engine_Api::_()->getItem('user', $item->user_id);

    // Get gateway
    $gatewayId = 2; //$item->gateway_id;

		$gateway = Engine_Api::_()->getDbtable('usergateways', 'sesbasic')->getUserGateway(array('user_id' => $user->user_id));

		if( !$gatewayId || !($gateway) || !($gateway->enabled) ) {
       return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
    }

    $this->view->gateway = $gateway;
		$this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway();
		$plugin = $gateway->getPlugin();

		$ordersTable = Engine_Api::_()->getDbtable('orders', 'payment');
    //Process
    $ordersTable->insert(array(
        'user_id' => $viewer->getIdentity(),
        'gateway_id' => 2,
        'state' => 'pending',
        'creation_date' => new Zend_Db_Expr('NOW()'),
        'source_type' => 'sescrowdfunding_remainingpayment',
        'source_id' => $remainingpayment_id,
    ));

		$session = new Zend_Session_Namespace();
    $session->sescrowdfunding_order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();
		$session->sescrowdfunding_item_id = $remainingpayment_id; //$item->getIdentity();
    // Prepare host info
    $schema = 'http://';
    if( !empty($_ENV["HTTPS"]) && 'on' == strtolower($_ENV["HTTPS"]) ) {
      $schema = 'https://';
    }
    $host = $_SERVER['HTTP_HOST'];
    // Prepare transaction
    $params = array();
    $params['language'] = $viewer->language;
    $localeParts = explode('_', $viewer->language);
		if( count($localeParts) > 1 ) {
			$params['region'] = $localeParts[1];
		}

    $params['vendor_order_id'] = $order_id;
    $params['return_url'] = $schema . $host
      .  $this->view->url(array('action' => 'return', 'controller' => 'paymentmade', 'module' => 'sescrowdfunding'), 'admin_default', true)
      . '/?state=' . 'return&order_id=' . $order_id;
    $params['cancel_url'] = $schema . $host
      .  $this->view->url(array('action' => 'return', 'controller' => 'paymentmade', 'module' => 'sescrowdfunding'), 'admin_default', true)
      . '/?state=' . 'cancel&order_id=' . $order_id;
    $params['ipn_url'] = $schema . $host
      .  $this->view->url(array('action' => 'index', 'controller' => 'ipn', 'module' => 'payment'), 'admin_default', true).'&order_id=' . $order_id;
    // Process transaction

    $transaction = $plugin->createOrderTransaction($item,$user,$params);

    // Pull transaction params
    $this->view->transactionUrl = $transactionUrl = $gatewayPlugin->getGatewayUrl();
    $this->view->transactionMethod = $transactionMethod = $gatewayPlugin->getGatewayMethod();
    $this->view->transactionData = $transactionData = $transaction->getData();
    // Handle redirection
    if( $transactionMethod == 'GET' ) {
     $transactionUrl .= '?' . http_build_query($transactionData);
     return $this->_helper->redirector->gotoUrl($transactionUrl, array('prependBase' => false));
    }
    // Post will be handled by the view script
	}

	public function returnAction() {

		$session = new Zend_Session_Namespace();

    // Get order
		$orderId = $this->_getParam('order_id', null);
		$orderPaymentId = $session->sescrowdfunding_order_id;
		$orderPayment = Engine_Api::_()->getItem('payment_order', $orderPaymentId);

		$item_id = $session->sescrowdfunding_item_id ;
		$item = Engine_Api::_()->getItem('sescrowdfunding_remainingpayment', $item_id);
    if (!$orderPayment || ($orderId != $orderPaymentId) ||
			 ($orderPayment->source_type != 'sescrowdfunding_remainingpayment') ||
			 !($user_order = $orderPayment->getSource()) ) {
			return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
    }

		$gateway = Engine_Api::_()->getDbtable('usergateways', 'sesbasic')->getUserGateway(array('user_id'=>$user_order->user_id));

		if( !$gateway )
      return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);

    // Get gateway plugin
    $plugin = $gateway->getPlugin();
    unset($session->errorMessage);
    try {
     //get all params
      $params = $this->_getAllParams();
      $status = $plugin->orderTransactionReturn($orderPayment, $params,$item);
    } catch (Payment_Model_Exception $e) {
      $status = 'failure';
      $session->errorMessage = $e->getMessage();
    }
    return $this->_finishPayment($status,$orderPayment->source_id);
  }

  protected function _finishPayment($state = 'active',$orderPaymentId) {

		$session = new Zend_Session_Namespace();
    // Clear session
    $errorMessage = $session->errorMessage;
    $session->errorMessage = $errorMessage;
    // Redirect
    if ($state == 'free') {
      return $this->_helper->redirector->gotoRoute(array(), 'default', true);
    } else {
			 return $this->_helper->redirector->gotoRoute(array('action' => 'finish', 'state' => $state));
    }
  }

  public function finishAction() {

    $session = new Zend_Session_Namespace();
    if (!empty($session->sescrowdfunding_order_id))
      $session->sescrowdfunding_order_id = '';
		//if(empty($session->sescrowdfunding_order_id))
			//return $this->_forward('notfound', 'error', 'core');
    $orderTrabsactionDetails = array('state' => $this->_getParam('state'), 'errorMessage' => $session->errorMessage);
    $session->sescrowdfunding_order_details = $orderTrabsactionDetails;
		$state = $this->_getParam('state');
	  if(!$state)
	 	 return $this->_forward('notfound', 'error', 'core');
		$this->view->error = $error =  $session->errorMessage;
		$session->unsetAll();
		if($state == 'active')
      return $this->_helper->redirector->gotoRoute(array('controller' => 'paymentmade', 'module' => 'sescrowdfunding'), 'admin_default', true);
  }

	public function cancelAction() {

		$this->view->crowdfunding = $user = Engine_Api::_()->getItem('crowdfunding', $this->getRequest()->getParam('crowdfunding_id'));
	  $paymnetReq = Engine_Api::_()->getItem('sescrowdfunding_userpayrequest', $this->getRequest()->getParam('id'));

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    // Make form
	   $this->view->form = $form = new Sesbasic_Form_Delete();
		 $form->setTitle('Reject Payment Request');
		 $form->setDescription('Are you sure that you want to reject this payment request?');
		 $form->submit->setLabel('Reject');

    if (!$paymnetReq) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Paymnet request doesn't exists or not authorized to cancel");
      return;
    }

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $paymnetReq->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      $paymnetReq->state = 'cancelled';
			$paymnetReq->save();
      $db->commit();

      //Notification work
      $viewer = Engine_Api::_()->user()->getViewer();
			$owner = $user->getOwner();
			Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $user, 'sescrowdfunding_adminpaymentcancel', array());
      //Payment cancel mail send to user profile
			Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner, 'sescrowdfunding_ticketpayment_adminrequestcancel', array('crowdfunding_title' => $user->title, 'object_link' => $user->getHref(), 'host' => $_SERVER['HTTP_HOST']));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Payment Request has been cancelled.');
    return $this->_forward('success', 'utility', 'core', array(
               'smoothboxClose' => 10,
							 'parentRefresh' => 10,
               'messages' => array($this->view->message)
    ));
	}
}
