<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DashboardController.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_DashboardController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('crowdfunding', null, 'view')->isValid()) return;
    if (!$this->_helper->requireUser->isValid()) return;
    $id = $this->_getParam('crowdfunding_id', null);
    $crowdfunding_id = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->getCrowdfundingId($id);
    if ($crowdfunding_id) {
      $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $crowdfunding_id);
      if ($crowdfunding)
        Engine_Api::_()->core()->setSubject($crowdfunding);

        if (!$this->_helper->requireAuth()->setAuthParams($crowdfunding, null, 'edit')->isValid())
        return;
    } else
      return $this->_forward('requireauth', 'error', 'core');
  }
  public function designAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Viewdesign();
    $form->pagestyle->setValue($crowdfunding->pagestyle);
    if (!$this->getRequest()->isPost() || ($is_ajax_content))
      return;
    $crowdfunding->pagestyle = $_POST['pagestyle'];
    $crowdfunding->save();
    return $this->_helper->redirector->gotoRoute(array('action' => 'design', 'crowdfunding_id' => $crowdfunding->custom_url), "sescrowdfunding_dashboard", true);
  }

  //Get sales report
  public function donationsReportsAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $crowdfunding->isOwner($viewer)))
      return;
    //$crowdfundingTicketDetails = Engine_Api::_()->getDbtable('tickets', 'sescrowdfunding')->getTicket(array('crowdfunding_id' => $crowdfunding->crowdfunding_id));
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Searchdonationreport();
    $value = array();
    if (isset($_GET['startdate']))
      $value['startdate'] = $value['start'] = date('Y-m-d', strtotime($_GET['startdate']));
    if (isset($_GET['enddate']))
     $value['enddate'] = $value['end'] = date('Y-m-d', strtotime($_GET['enddate']));
    if (isset($_GET['type']))
      $value['type'] = $_GET['type'];
    if (!count($value)) {
      $value['enddate'] = date('Y-m-d', strtotime(date('Y-m-d')));
      $value['startdate'] = date('Y-m-d', strtotime('-30 days'));
      $value['type'] = $form->type->getValue();
    }
		if(isset($_GET['excel']) && $_GET['excel'] != '')
			$value['download'] = 'excel';
		if(isset($_GET['csv']) && $_GET['csv'] != '')
			$value['download'] = 'csv';
    $form->populate($value);
		$value['crowdfunding_id'] = $crowdfunding->getIdentity();
    $this->view->crowdfundingSaleData = $data = Engine_Api::_()->getDbtable('orders', 'sescrowdfunding')->getReportData($value);
		if(isset($value['download'])){
			$name = str_replace(' ','_',$crowdfunding->getTitle()).'_'.time();
			switch($value["download"])
    {
			case "excel" :
			// Submission from
			$filename = $name . ".xls";
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=\"$filename\"");
			$this->exportFile($data);
			exit();
			case "csv" :
				// Submission from
			$filename = $name . ".csv";
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Expires: 0");
			$this->exportCSVFile($data);
				exit();
			default :
				//silence
			break;
			}
		}
  }
	protected function exportCSVFile($records) {
    // create a file pointer connected to the output stream
    $fh = fopen( 'php://output', 'w' );
    $heading = false;
    $counter = 1;
    if(!empty($records))
      foreach($records as $row) {
      $user = Engine_Api::_()->getItem('user', $row['user_id']);
      $valueVal['S.No'] = $counter;
      $valueVal['Donor Name'] = $user->getTitle();
      $valueVal['Date of Donation'] = Engine_Api::_()->sesbasic()->dateFormat($row['creation_date']);
      $valueVal['Total Amount'] = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($row['total_useramount'],$defaultCurrency);
      $counter++;
      if(!$heading) {
        // output the column headings
        fputcsv($fh, array_keys($valueVal));
        $heading = true;
      }
      // loop over the rows, outputting them
      fputcsv($fh, array_values($valueVal));

      }
      fclose($fh);
  }

  protected function exportFile($records) {

    $heading = false;
    $counter = 1;
    $defaultCurrency = Engine_Api::_()->sescrowdfunding()->defaultCurrency();
    if(!empty($records))
      foreach($records as $row) {
        $user = Engine_Api::_()->getItem('user', $row['user_id']);
        $valueVal['S.No'] = $counter;
        $valueVal['Donor Name'] = $user->getTitle();
        $valueVal['Date of Donation'] = Engine_Api::_()->sesbasic()->dateFormat($row['creation_date']);
        $valueVal['Total Amount'] = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($row['total_useramount'],$defaultCurrency);
        $counter++;
      if(!$heading) {
        // display field/column names as a first row
        echo implode("\t", array_keys($valueVal)) . "\n";
        $heading = true;
      }
      echo implode("\t", array_values($valueVal)) . "\n";
      }
    exit;
  }

  public function donationsStatsAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $sescrowdfunding->isOwner($viewer)))
      return;
    $this->view->todaySale = Engine_Api::_()->getDbtable('orders', 'sescrowdfunding')->getSaleStats(array('stats' => 'today', 'crowdfunding_id' => $sescrowdfunding->crowdfunding_id));
    $this->view->weekSale = Engine_Api::_()->getDbtable('orders', 'sescrowdfunding')->getSaleStats(array('stats' => 'week', 'crowdfunding_id' => $sescrowdfunding->crowdfunding_id));
    $this->view->monthSale = Engine_Api::_()->getDbtable('orders', 'sescrowdfunding')->getSaleStats(array('stats' => 'month', 'crowdfunding_id' => $sescrowdfunding->crowdfunding_id));
    //get getCrowdfundingStats
    $this->view->crowdfundingStatsSale = Engine_Api::_()->getDbtable('orders', 'sescrowdfunding')->getCrowdfundingStats(array('crowdfunding_id' => $sescrowdfunding->crowdfunding_id));
  }

  public function paymentTransactionAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $sescrowdfunding->isOwner($viewer)))
      return;
    $this->view->paymentRequests = Engine_Api::_()->getDbtable('userpayrequests', 'sescrowdfunding')->getPaymentRequests(array('crowdfunding_id' => $sescrowdfunding->crowdfunding_id, 'state' => 'complete'));
  }

  //get payment to admin information
  public function paymentRequestsAction() {
    //Set up navigation
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $sescrowdfunding->isOwner($viewer)))
      return;
    $this->view->thresholdAmount = Engine_Api::_()->authorization()->getPermission($viewer, 'crowdfunding', 'threshold_amount');
    //get total amount of ticket sold in given crowdfunding
		$this->view->userGateway = Engine_Api::_()->getDbtable('usergateways', 'sesbasic')->getUserGateway(array('user_id' => $viewer->user_id));
    $this->view->orderDetails = Engine_Api::_()->getDbtable('orders', 'sescrowdfunding')->getCrowdfundingStats(array('crowdfunding_id' => $sescrowdfunding->crowdfunding_id));
    //get ramaining amount
    $remainingAmount = Engine_Api::_()->getDbtable('remainingpayments', 'sescrowdfunding')->getCrowdfundingRemainingAmount(array('crowdfunding_id' => $sescrowdfunding->crowdfunding_id));
    if (!$remainingAmount) {
      $this->view->remainingAmount = 0;
    } else
      $this->view->remainingAmount = $remainingAmount->remaining_payment;
    $this->view->isAlreadyRequests = Engine_Api::_()->getDbtable('userpayrequests', 'sescrowdfunding')->getPaymentRequests(array('crowdfunding_id' => $sescrowdfunding->crowdfunding_id,'isPending'=>true));
    $this->view->paymentRequests = Engine_Api::_()->getDbtable('userpayrequests', 'sescrowdfunding')->getPaymentRequests(array('crowdfunding_id' => $sescrowdfunding->crowdfunding_id,'isPending'=>true));
  }
  public function paymentRequestAction() {
    //Set up navigation
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $sescrowdfunding->isOwner($viewer)))
      return;
    $this->view->thresholdAmount = $thresholdAmount = Engine_Api::_()->authorization()->getPermission($viewer, 'crowdfunding', 'threshold_amount');
    //get remaining amount
    $remainingAmount = Engine_Api::_()->getDbtable('remainingpayments', 'sescrowdfunding')->getCrowdfundingRemainingAmount(array('crowdfunding_id' => $sescrowdfunding->crowdfunding_id));
    if (!$remainingAmount) {
      $this->view->remainingAmount = 0;
    } else {
      $this->view->remainingAmount = $remainingAmount->remaining_payment;
    }
    $defaultCurrency = Engine_Api::_()->sescrowdfunding()->defaultCurrency();
    $orderDetails = Engine_Api::_()->getDbtable('orders', 'sescrowdfunding')->getCrowdfundingStats(array('crowdfunding_id' => $sescrowdfunding->crowdfunding_id));
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Paymentrequest();
    $value = array();
    $totalRemainingAmount = $orderDetails['totalAmountSale'] - $orderDetails['commission_amount'];
    $value['total_amount'] = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($totalRemainingAmount, $defaultCurrency);
    $totalRemainingAmountafterPayreceived = $remainingAmount->remaining_payment - $orderDetails['commission_amount'];
    $value['remaining_amount'] = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($totalRemainingAmountafterPayreceived, $defaultCurrency);
    //$value['requested_amount'] = round($totalRemainingAmountafterPayreceived,2);
    //set value to form
    if ($this->_getParam('id', false)) {
      $item = Engine_Api::_()->getItem('sescrowdfunding_userpayrequest', $this->_getParam('id'));
      if ($item) {
        $itemValue = $item->toArray();
        //unset($value['requested_amount']);
        $value = array_merge($itemValue, $value);
      } else {
        return $this->_forward('requireauth', 'error', 'core');
      }
    }
    if (empty($_POST))
      $form->populate($value);

    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    if (isset($_POST['requested_amount']) && @round($_POST['requested_amount'],2) > @round($remainingAmount->remaining_payment,2)) {
      $form->addError('Requested amount must be less than or equal to remaining amount.');
      return;
    }
    $db = Engine_Api::_()->getDbtable('userpayrequests', 'sescrowdfunding')->getAdapter();
    $db->beginTransaction();
    try {
      $tableOrder = Engine_Api::_()->getDbtable('userpayrequests', 'sescrowdfunding');
      if (isset($itemValue))
        $order = $item;
      else
        $order = $tableOrder->createRow();
      $order->requested_amount = round($_POST['requested_amount'],2);
      $order->user_message = $_POST['user_message'];
      $order->crowdfunding_id = $sescrowdfunding->crowdfunding_id;
      $order->owner_id = $viewer->getIdentity();
      $order->user_message = $_POST['user_message'];
      $order->creation_date = date('Y-m-d h:i:s');
      $order->currency_symbol = $defaultCurrency;
			$settings = Engine_Api::_()->getApi('settings', 'core');
   	  $userGatewayEnable = 'paypal'; //$settings->getSetting('sescrowdfunding.userGateway', 'paypal');
      $order->save();
      $db->commit();
    //Notification work
    $owner_admin = Engine_Api::_()->getItem('user', 1);
    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner_admin, $viewer, $sescrowdfunding, 'sescrowdfunding_paymentrequest', array('requestAmount' => round($_POST['requested_amount'],2)));
    //Payment request mail send to admin
    $sescrowdfunding_owner = Engine_Api::_()->getItem('user', $sescrowdfunding->owner_id);
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner_admin, 'sescrowdfunding_payment_requestadmin', array('crowdfunding_title' => $sescrowdfunding->title, 'object_link' => $sescrowdfunding->getHref(), 'crowdfunding_owner' => $sescrowdfunding_owner->getTitle(), 'host' => $_SERVER['HTTP_HOST']));

      $this->view->status = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Payment request send successfully.');
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array($this->view->message)
      ));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }
  //delete payment request
  public function deletePaymentAction() {
    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->core()->getSubject();
    $paymnetReq = Engine_Api::_()->getItem('sescrowdfunding_userpayrequest', $this->getRequest()->getParam('id'));
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$this->_helper->requireAuth()->setAuthParams($crowdfunding, null, 'delete')->isValid())
      return;
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    // Make form
    $this->view->form = $form = new Sesbasic_Form_Delete();
    $form->setTitle('Delete Payment Request?');
    $form->setDescription('Are you sure that you want to delete this payment request? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    if (!$paymnetReq) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Paymnet request doesn't exists or not authorized to delete");
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
      $paymnetReq->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Payment Request has been deleted.');
    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh' => 10,
      'messages' => array($this->view->message)
    ));
  }

  //get paymnet detail
  public function detailPaymentAction() {

    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->core()->getSubject();
    $this->view->item = $paymnetReq = Engine_Api::_()->getItem('sescrowdfunding_userpayrequest', $this->getRequest()->getParam('id'));
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    if (!$this->_helper->requireAuth()->setAuthParams($crowdfunding, null, 'edit')->isValid())
      return;

    if (!$paymnetReq) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Paymnet request doesn't exists or not authorized to delete");
      return;
    }
  }

  //Get user paypal account details which he recived payment from admin
  public function accountDetailsAction() {
    //Set up navigation
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $gateway_type = $this->view->gateway = $this->_getParam('gateway_type', "paypal");
    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $userGateway = Engine_Api::_()->getDbtable('usergateways', 'sesbasic')->getUserGateway(array('user_id' => $viewer->getIdentity(),'enabled' => true,'gateway_type'=>$gateway_type));
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if($gateway_type == "paypal") {
        $userGatewayEnable = 'paypal';
        $this->view->form = $form = new Sesbasic_Form_PayPal();
        $gatewayTitle = 'Paypal';
        $gatewayClass= 'Sescrowdfunding_Plugin_Gateway_PayPal';
    } else if($gateway_type == "stripe") {
        $userGatewayEnable = 'stripe';
        $this->view->form = $form = new Sesadvpmnt_Form_Admin_Settings_Stripe();
        $gatewayTitle = 'Stripe';
        $gatewayClass= 'Sesadvpmnt_Plugin_Gateway_User_Stripe';
    } else if($gateway_type == "paytm") {
        $userGatewayEnable = 'paytm';
        $this->view->form = $form = new Epaytm_Form_Admin_Settings_Paytm();
        $gatewayTitle = 'Paytm';
        $gatewayClass= 'Epaytm_Plugin_Gateway_User_Paytm';
    }
    if (count($userGateway)) {
      $form->populate($userGateway->toArray());
      if (is_array($userGateway['config'])) {
        $form->populate($userGateway['config']);
      }
    }

    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost())
      return;
    if (!$form->isValid($this->getRequest()->getPost()))
      return;
    // Process
    $values = $form->getValues();
    $enabled = (bool) $values['enabled'];
    unset($values['enabled']);

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    $userGatewayTable = Engine_Api::_()->getDbtable('usergateways', 'sesbasic');
    // insert data to table if not exists
    try {
      if (!count($userGateway)) {
        $gatewayObject = $userGatewayTable->createRow();
        $gatewayObject->user_id = $viewer->getIdentity();
        $gatewayObject->title = $gatewayTitle;
        $gatewayObject->plugin = $gatewayClass;
        $gatewayObject->gateway_type = $gateway_type;
        $gatewayObject->save();
      } else {
        $gatewayObject = Engine_Api::_()->getItem("sesbasic_usergateway", $userGateway['usergateway_id']);
      }
      $db->commit();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    // Validate gateway config
    if ($enabled) {
      $gatewayObjectObj = $gatewayObject->getGateway(array('plugin'=>$gatewayClass,'is_sponsorship'=>'sescrowdfunding'));
      try {
        $gatewayObjectObj->setConfig($values);
        if($gateway_type == "paypal") {
            $response = $gatewayObjectObj->test();
        }
      } catch (Exception $e) {
        $enabled = false;
        $form->populate(array('enabled' => false));
        $form->addError(sprintf('Gateway login failed. Please double check ' .
                        'your connection information. The gateway has been disabled. ' .
                        'The message was: [%2$d] %1$s', $e->getMessage(), $e->getCode()));
      }
    } else {
      $form->addError('Gateway is currently disabled.');
    }
    // Process
    $message = null;
    try {
      $values = $gatewayObject->getPlugin()->processAdminGatewayForm($values);
    } catch (Exception $e) {
      $message = $e->getMessage();
      $values = null;
    }
    if (null !== $values) {
      $gatewayObject->setFromArray(array(
          'enabled' => $enabled,
          'config' => $values,
      ));
			//echo "asdf<pre>";var_dump($gatewayObject);die;
      $gatewayObject->save();
      $form->addNotice('Changes saved.');
    } else {
      $form->addError($message);
    }
  }

  public function viewDonersAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->core()->getSubject();

//     $this->view->user_id = $user_id = $this->_getParam('user_id', null);
//     $this->view->user = $user = $user = Engine_Api::_()->getItem('user', $user_id);

    $userTableName = Engine_Api::_()->getItemTable('user')->info('name');

    $ordersTable = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding');
    $ordersTableName = $ordersTable->info('name');

    $select = $ordersTable->select()
            ->setIntegrityCheck(false)
            ->from($ordersTableName)
            ->joinLeft($userTableName, "$ordersTableName.user_id = $userTableName.user_id", 'displayname')
            ->where($ordersTableName . '.crowdfunding_id = ?', $sescrowdfunding->crowdfunding_id)
            ->where($ordersTableName . '.state = ?', 'complete')
            ->order('order_id DESC');

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

  }

    public function backgroundphotoAction() {

        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

        $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();

        $viewer = Engine_Api::_()->user()->getViewer();

        // Create form
        $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Backgroundphoto();
        $form->populate($crowdfunding->toArray());
        if (!$this->getRequest()->isPost())
            return;

        // Not post/invalid
        if (!$this->getRequest()->isPost() || $is_ajax_content)
            return;

        if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
            return;

        $db = Engine_Api::_()->getDbTable('crowdfundings', 'sescrowdfunding')->getAdapter();
        $db->beginTransaction();
        try {
            $crowdfunding->setBackgroundPhoto($_FILES['background'], 'background');
            $crowdfunding->save();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
        }
        return $this->_helper->redirector->gotoRoute(array('action' => 'backgroundphoto', 'crowdfunding_id' => $crowdfunding->custom_url), "sescrowdfunding_dashboard", true);
    }

    public function removeBackgroundphotoAction() {

        $crowdfunding = Engine_Api::_()->core()->getSubject();
        $crowdfunding->background_photo_id = 0;
        $crowdfunding->save();
        return $this->_helper->redirector->gotoRoute(array('action' => 'backgroundphoto', 'crowdfunding_id' => $crowdfunding->custom_url), "sescrowdfunding_dashboard", true);
    }


    public function styleAction() {

        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

        $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();

        $viewer = Engine_Api::_()->user()->getViewer();

        // Get current row
        $table = Engine_Api::_()->getDbTable('styles', 'core');
        $select = $table->select()
                ->where('type = ?', 'crowdfunding')
                ->where('id = ?', $crowdfunding->getIdentity())
                ->limit(1);
        $row = $table->fetchRow($select);

        // Create form
        $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Style();

        // Check post
        if (!$this->getRequest()->isPost()) {
            $form->populate(array(
                'style' => ( null === $row ? '' : $row->style )
            ));
        }

        // Not post/invalid
        if (!$this->getRequest()->isPost() || $is_ajax_content)
            return;

        if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
            return;

        // Cool! Process
        $style = $form->getValue('style');

        // Save
        if (null == $row) {
            $row = $table->createRow();
            $row->type = 'crowdfunding';
            $row->id = $crowdfunding->getIdentity();
        }
        $row->style = $style;
        $row->save();
    }

  public function rewardsAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('rewards', 'sescrowdfunding')->getCrowdfundingRewardPaginator(array('crowdfunding_id' => $crowdfunding->crowdfunding_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function postRewardAction() {
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Postreward();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $rewardTable = Engine_Api::_()->getDbTable('rewards', 'sescrowdfunding');
    $db = $rewardTable->getAdapter();
    $db->beginTransaction();
    $viewer = Engine_Api::_()->user()->getViewer();
    try {
      $reward = $rewardTable->createRow();
      $values = $form->getValues();

      $reward->setFromArray(array_merge(array(
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          'crowdfunding_id' => $crowdfunding->crowdfunding_id), $values));
      $reward->save();

      if(!empty($_FILES['photo_file']['name'])) {
        $file_ext = pathinfo($_FILES['photo_file']['name']);
        $file_ext = $file_ext['extension'];
        $storage = Engine_Api::_()->getItemTable('storage_file');
        $storageObject = $storage->createFile($form->photo_file, array(
          'parent_id' => $reward->getIdentity(),
          'parent_type' => $reward->getType(),
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        ));
        // Remove temporary file
        @unlink($file['tmp_name']);
        $reward->photo_id = $storageObject->file_id;
        $reward->save();
      }

      $db->commit();

      // Redirect
      $this->_redirectCustom(array('route' => 'sescrowdfunding_dashboard', 'action' => 'rewards', 'crowdfunding_id' => $crowdfunding->custom_url));
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editRewardAction() {
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();
    $reward = Engine_Api::_()->getItem('sescrowdfunding_reward', $this->_getParam('id'));
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Editreward();
    $form->populate($reward->toArray());
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $values = $form->getValues();
    $reward->setFromArray($values);
    $reward->save();
    if(!empty($_FILES['photo_file']['name'])) {
    $file_ext = pathinfo($_FILES['photo_file']['name']);
    $file_ext = $file_ext['extension'];
    $storage = Engine_Api::_()->getItemTable('storage_file');
    $storageObject = $storage->createFile($form->photo_file, array(
        'parent_id' => $reward->getIdentity(),
        'parent_type' => $reward->getType(),
        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
    ));
    // Remove temporary file
    @unlink($file['tmp_name']);
    $reward->photo_id = $storageObject->file_id;
    $reward->save();
    }
    $this->_redirectCustom(array('route' => 'sescrowdfunding_dashboard', 'action' => 'rewards', 'crowdfunding_id' => $crowdfunding->custom_url));
  }

  public function deleteRewardAction() {
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();
    $reward = Engine_Api::_()->getItem('sescrowdfunding_reward', $this->_getParam('id'));
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Deletereward();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $reward->delete();
    $this->_redirectCustom(array('route' => 'sescrowdfunding_dashboard', 'action' => 'rewards', 'crowdfunding_id' => $crowdfunding->custom_url));
  }

  public function announcementAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('announcements', 'sescrowdfunding')->getCrowdfundingAnnouncementPaginator(array('crowdfunding_id' => $crowdfunding->crowdfunding_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }


  public function postAnnouncementAction() {
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Postannouncement();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcementTable = Engine_Api::_()->getDbTable('announcements', 'sescrowdfunding');
    $db = $announcementTable->getAdapter();
    $db->beginTransaction();
    $viewer = Engine_Api::_()->user()->getViewer();
    try {
      $announcement = $announcementTable->createRow();
      $announcement->setFromArray(array_merge(array(
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          'crowdfunding_id' => $crowdfunding->crowdfunding_id), $form->getValues()));
      $announcement->save();
      $db->commit();

      // Redirect
      $this->_redirectCustom(array('route' => 'sescrowdfunding_dashboard', 'action' => 'announcement', 'crowdfunding_id' => $crowdfunding->custom_url));
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function manageTeamAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();

    $viewer = Engine_Api::_()->user()->getViewer();

    // Permission check
    $enableTeam = Engine_Api::_()->authorization()->isAllowed('crowdfunding', $viewer, 'team');
    if (empty($enableTeam)) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    // Designations
    $this->view->designations = Engine_Api::_()->getDbTable('designations', 'sescrowdfundingteam')->getAllDesignations(array('crowdfunding_id' => $crowdfunding->crowdfunding_id));

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('teams', 'sescrowdfundingteam')->getTeamMemers(array('crowdfunding_id' => $crowdfunding->crowdfunding_id));

    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function editAnnouncementAction() {
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();
    $announcement = Engine_Api::_()->getItem('sescrowdfunding_announcement', $this->_getParam('id'));
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Editannouncement();
    $form->title->setValue($announcement->title);
    $form->body->setValue($announcement->body);
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcement->title = $_POST['title'];
    $announcement->body = $_POST['body'];
    $announcement->save();
    $this->_redirectCustom(array('route' => 'sescrowdfunding_dashboard', 'action' => 'announcement', 'crowdfunding_id' => $crowdfunding->custom_url));
  }

  public function deleteAnnouncementAction() {
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();
    $announcement = Engine_Api::_()->getItem('sescrowdfunding_announcement', $this->_getParam('id'));
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Deleteannouncement();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcement->delete();
    $this->_redirectCustom(array('route' => 'sescrowdfunding_dashboard', 'action' => 'announcement', 'crowdfunding_id' => $crowdfunding->custom_url));
  }

  public function managePhotosAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->crowdfunding_id = $crowdfunding_id = $this->_getParam('crowdfunding_id', null);
    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->core()->getSubject();

    //Prepare data
		$this->view->album_id = $album_id = $this->_getParam('album_id', null);
    $this->view->album = $album = Engine_Api::_()->getItem('sescrowdfunding_album', $album_id);

    $photoTable = Engine_Api::_()->getItemTable('sescrowdfunding_photo');
    $this->view->paginator = $paginator = $photoTable->getPhotoPaginator(array('album' => $album, 'content_type' => 'album', 'file_id' => $sescrowdfunding->photo_id));
    $paginator->setCurrentPageNumber($this->_getParam('page'));
    $paginator->setItemCountPerPage(10);

    //Get albums
    $albumTable = Engine_Api::_()->getItemTable('sescrowdfunding_album');
    $mySescrowdfundings = $albumTable->select()
                                  ->from($albumTable, array('album_id', 'title'))
                                  ->where('owner_id = ?', Engine_Api::_()->user()->getViewer()->getIdentity())
                                  ->query()
                                  ->fetchAll();

    $albumOptions = array('' => '');
    foreach( $mySescrowdfundings as $mySescrowdfunding ) {
      $albumOptions[$mySescrowdfunding['album_id']] = $mySescrowdfunding['title'];
    }

    if( count($albumOptions) == 1 ) {
      $albumOptions = array();
    }

    //Make form
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_ManagePhotos();

    foreach( $paginator as $photo ) {
      $subform = new Sescrowdfunding_Form_Dashboard_EditPhoto(array('elementsBelongTo' => $photo->getGuid()));
      $subform->populate($photo->toArray());
      $form->addSubForm($subform, $photo->getGuid());
      //$form->cover->addMultiOption($photo->getIdentity(), $photo->getIdentity());
      if( empty($albumOptions) ) {
        $subform->removeElement('move');
      } else {
        //$subform->move->setMultiOptions($albumOptions);
      }
    }

    if( !$this->getRequest()->isPost() )
      return;

    if( !$form->isValid($this->getRequest()->getPost()) )
      return;

    $table = $album->getTable();
    $db = $table->getAdapter();
    $db->beginTransaction();

    try {

      $values = $form->getValues();
      if( !empty($values['cover']) ) {
        $album->photo_id = $values['cover'];
        $album->save();
      }

      //Process
      foreach( $paginator as $photo ) {

        $subform = $form->getSubForm($photo->getGuid());
        $values = $subform->getValues();

        $values = $values[$photo->getGuid()];
        unset($values['photo_id']);
        if( isset($values['delete']) && $values['delete'] == '1' ) {
          $photo->delete();
        } else if( !empty($values['move']) ) {
          $nextPhoto = $photo->getNextPhoto();
          $old_album_id = $photo->album_id;
          $photo->album_id = $values['move'];
          $photo->save();

          // Change album cover if necessary
          if( ($nextPhoto instanceof Sescrowdfunding_Model_Photo) &&
              (int) $album->photo_id == (int) $photo->getIdentity() ) {
            $album->photo_id = $nextPhoto->getIdentity();
            $album->save();
          }
        } else {
          $photo->setFromArray($values);
          $photo->save();
        }
      }

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-photos', 'album_id' => $album->album_id, 'crowdfunding_id' => $sescrowdfunding->custom_url), 'sescrowdfunding_dashboard', true);
  }

	public function fieldsAction() {

		if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->core()->getSubject();
		$package_id = $sescrowdfunding->package_id;
		$package = Engine_Api::_()->getItem('sescrowdfundingpackage_package',$package_id);
		$module = json_decode($package->params,true);
		if(empty($module['custom_fields']) || ($package->custom_fields_params == '[]'))
			 return $this->_forward('notfound', 'error', 'core');

		$this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sescrowdfunding')->profileFieldId();
		$this->view->form = $form = new Sescrowdfunding_Form_Custom_Dashboardfields(array('item' => $sescrowdfunding,'topLevelValue'=>0,'topLevelId'=>0));
		 // Check post/form
    if( !$this->getRequest()->isPost() ) return;
    if( !$form->isValid($this->getRequest()->getPost()) ) return;
		$form->saveValues();

	}

  public function editAction() {

    $viewer = Engine_Api::_()->user()->getViewer();

    if( !$this->_helper->requireSubject()->isValid() ) return;

    if( !$this->_helper->requireAuth()->setAuthParams('crowdfunding', $viewer, 'edit')->isValid() ) return;

    if( !$this->_helper->requireUser()->isValid() ) return;

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->core()->getSubject();

    if (isset($sescrowdfunding->category_id) && $sescrowdfunding->category_id != 0)
      $this->view->category_id = $sescrowdfunding->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;

    if (isset($sescrowdfunding->subsubcat_id) && $sescrowdfunding->subsubcat_id != 0)
      $this->view->subsubcat_id = $sescrowdfunding->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;

    if (isset($sescrowdfunding->subcat_id) && $sescrowdfunding->subcat_id != 0)
      $this->view->subcat_id = $sescrowdfunding->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;



//     if( !Engine_Api::_()->core()->hasSubject('crowdfunding') )
//       Engine_Api::_()->core()->setSubject($sescrowdfunding);

    //Get navigation
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_main');

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'sescrowdfunding')->getCategoriesAssoc();

    //Prepare form
    $this->view->form = $form = new Sescrowdfunding_Form_Edit();

    //Populate form
    $form->populate($sescrowdfunding->toArray());

    $latLng = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData('sescrowdfunding',$sescrowdfunding->crowdfunding_id);
    if($latLng) {
      if($form->getElement('lat'))
        $form->getElement('lat')->setValue($latLng->lat);
      if($form->getElement('lng'))
        $form->getElement('lng')->setValue($latLng->lng);
    }

    if($form->getElement('location'))
      $form->getElement('location')->setValue($sescrowdfunding->location);

		if($form->getElement('category_id'))
      $form->getElement('category_id')->setValue($sescrowdfunding->category_id);

    $tagStr = '';
    foreach( $sescrowdfunding->tags()->getTagMaps() as $tagMap ) {
      $tag = $tagMap->getTag();
      if( !isset($tag->text) ) continue;
      if( '' !== $tagStr ) $tagStr .= ', ';
      $tagStr .= $tag->text;
    }

    $form->populate(array(
      'tags' => $tagStr,
    ));
    $this->view->tagNamePrepared = $tagStr;

    $auth = Engine_Api::_()->authorization()->context;
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

    foreach( $roles as $role ) {
      if ($form->auth_view){
        if( $auth->isAllowed($sescrowdfunding, $role, 'view') ) {
         $form->auth_view->setValue($role);
        }
      }

      if ($form->auth_comment){
        if( $auth->isAllowed($sescrowdfunding, $role, 'comment') ) {
          $form->auth_comment->setValue($role);
        }
      }

        if (isset($form->auth_video->options[$role]) && $auth->isAllowed($sescrowdfunding, $role, 'video'))
            $form->auth_video->setValue($role);
    }

    //Hide status change if it has been already published
    if( $sescrowdfunding->draft == "0" )
      $form->removeElement('draft');


    //Check post/form
    if( !$this->getRequest()->isPost() ) return;

    if( !$form->isValid($this->getRequest()->getPost()) ) return;

    //Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();

    try {

      $values = $form->getValues();

      $sescrowdfunding->setFromArray($values);
      $sescrowdfunding->modified_date = date('Y-m-d H:i:s');

			if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
				$starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
      	$sescrowdfunding->publish_date =$starttime;
			}
			if(empty($sescrowdfunding->crowdfunding_contact_name))
        $sescrowdfunding->crowdfunding_contact_name = $viewer->getTitle();
      if(empty($sescrowdfunding->crowdfunding_contact_email))
        $sescrowdfunding->crowdfunding_contact_email = $viewer->email;

      $sescrowdfunding->save();

      unset($_POST['title']);
      unset($_POST['tags']);
      unset($_POST['category_id']);
      unset($_POST['subcat_id']);
      unset($_POST['MAX_FILE_SIZE']);
      unset($_POST['body']);
      unset($_POST['search']);
      unset($_POST['execute']);
      unset($_POST['token']);
      unset($_POST['submit']);

      //Location work
      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '') {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $sescrowdfunding->crowdfunding_id . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","crowdfunding") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      }

      if(isset($values['draft']) && !$values['draft']) {
        $currentDate = date('Y-m-d H:i:s');
        if($sescrowdfunding->publish_date < $currentDate) {
          $sescrowdfunding->publish_date = $currentDate;
          $sescrowdfunding->save();
        }
      }

      //Auth
      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      $videoMax = array_search(@$values['auth_video'], $roles);
      foreach( $roles as $i => $role ) {
        $auth->setAllowed($sescrowdfunding, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($sescrowdfunding, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($sescrowdfunding, $role, 'video', ($i <= $videoMax));
      }

      //Handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $sescrowdfunding->tags()->setTagMaps($viewer, $tags);

			//Upload main image
			if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != ''){
				$photo_id = $sescrowdfunding->setPhoto($form->photo_file,'direct');
			}

      //Insert new activity if sescrowdfunding is just getting published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($sescrowdfunding);
      if( count($action->toArray()) <= 0 && @$values['draft'] == '0' && (!$sescrowdfunding->publish_date || strtotime($sescrowdfunding->publish_date) <= time())) {

        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sescrowdfunding, 'sescrowdfunding_create');
        if( $action != null ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sescrowdfunding);
        }

        $sescrowdfunding->draft = 1;
      	$sescrowdfunding->save();
      }

      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach( $actionTable->getActionsByObject($sescrowdfunding) as $action ) {
        $actionTable->resetActivityBindings($action);
      }
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    $this->_redirectCustom(array('route' => 'sescrowdfunding_dashboard', 'action' => 'edit', 'crowdfunding_id' => $sescrowdfunding->custom_url));
  }

  public function editPhotoAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();
    $this->view->viewer = Engine_Api::_()->user()->getViewer();

    //Get form
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Photo();

    if(empty($crowdfunding->photo_id))
      $form->removeElement('remove');

    if( !$this->getRequest()->isPost())
      return;

    if( !$form->isValid($this->getRequest()->getPost()) )
      return;

    //Uploading a new photo
    if( $form->Filedata->getValue() !== null ) {

      $db = $crowdfunding->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $fileElement = $form->Filedata;
        $photo = $crowdfunding->setPhoto($fileElement);

//         $photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false,false,'sescrowdfunding','sescrowdfunding','',$crowdfunding,true);
//         $crowdfunding->photo_id = $photo_id;
//         $crowdfunding->save();
        $db->commit();
      }
      //If an exception occurred within the image adapter, it's probably an invalid image
      catch( Engine_Image_Adapter_Exception $e ) {
        $db->rollBack();
        $form->addError(Zend_Registry::get('Zend_Translate')->_('The uploaded file is not supported or is corrupt.'));
      }
      //Otherwise it's probably a problem with the database or the storage system (just throw it)
      catch( Exception $e ) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function overviewAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Overview();
    $form->populate($crowdfunding->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('crowdfundings', 'sescrowdfunding')->getAdapter();
    $db->beginTransaction();
    try {
      $crowdfunding->setFromArray($_POST);
      $crowdfunding->save();
      $db->commit();
      $form->addNotice('Changes saved.');
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function removePhotoAction() {

    //Get form
    $this->view->form = $form = new Sescrowdfunding_Form_Edit_RemovePhoto();

    if( !$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    $crowdfunding = Engine_Api::_()->core()->getSubject();
    $crowdfunding->photo_id = 0;
    $crowdfunding->save();

    $this->view->status = true;

    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => true,
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your photo has been removed.'))
    ));
  }

  public function contactInformationAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();

    $viewer = Engine_Api::_()->user()->getViewer();

    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $crowdfunding->isOwner($viewer)))
      return;

    //Create form
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Contactinformation();

    $form->populate($crowdfunding->toArray());

    if (!$this->getRequest()->isPost())
      return;

    //Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;

    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;

    $db = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->getAdapter();
    $db->beginTransaction();
    try {
      $crowdfunding->crowdfunding_contact_name = isset($_POST['crowdfunding_contact_name']) ? $_POST['crowdfunding_contact_name'] : '';

      $crowdfunding->crowdfunding_contact_email = isset($_POST['crowdfunding_contact_email']) ? $_POST['crowdfunding_contact_email'] : '';

      $crowdfunding->crowdfunding_contact_country = isset($_POST['crowdfunding_contact_country']) ? $_POST['crowdfunding_contact_country'] : '';

      $crowdfunding->crowdfunding_contact_state = isset($_POST['crowdfunding_contact_state']) ? $_POST['crowdfunding_contact_state'] : '';

      $crowdfunding->crowdfunding_contact_city = isset($_POST['crowdfunding_contact_city']) ? $_POST['crowdfunding_contact_city'] : '';

      $crowdfunding->crowdfunding_contact_street = isset($_POST['crowdfunding_contact_street']) ? $_POST['crowdfunding_contact_street'] : '';

      $crowdfunding->crowdfunding_contact_phone = isset($_POST['crowdfunding_contact_phone']) ? $_POST['crowdfunding_contact_phone'] : '';

      $crowdfunding->crowdfunding_contact_website = isset($_POST['crowdfunding_contact_website']) ? $_POST['crowdfunding_contact_website'] : '';

      $crowdfunding->crowdfunding_contact_facebook = isset($_POST['crowdfunding_contact_facebook']) ? $_POST['crowdfunding_contact_facebook'] : '';

      $crowdfunding->crowdfunding_contact_twitter = isset($_POST['crowdfunding_contact_twitter']) ? $_POST['crowdfunding_contact_twitter'] : '';

      $crowdfunding->crowdfunding_contact_aboutme = isset($_POST['crowdfunding_contact_aboutme']) ? $_POST['crowdfunding_contact_aboutme'] : '';

      $crowdfunding->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
      echo false; die;
    }
  }


  public function getMembersAction() {
    $sesdata = array();
    $roleIDArray = array();
    $ownerId = Engine_Api::_()->getItem('sesblog_blog', $this->_getParam('blog_id', null))->owner_id;
    $viewer = Engine_Api::_()->getItem('user', $ownerId);
    $users = $viewer->membership()->getMembershipsOfIds();
    $users = array_merge($users, array('0' => $ownerId));
    $blogRoleTable = Engine_Api::_()->getDbTable('roles', 'sesblog');
    $roleIds = $blogRoleTable->select()->from($blogRoleTable->info('name'), 'user_id')->where('blog_id =?',$this->_getParam('blog_id', null))->query()->fetchAll();
    foreach($roleIds as $roleID) {
      $roleIDArray[] = $roleID['user_id'];
    }
    $diffIds = array_diff($users, $roleIDArray);
    $users_table = Engine_Api::_()->getDbtable('users', 'user');
    $usersTableName = $users_table->info('name');
    $select = $users_table->select()->where('displayname  LIKE ? ', '%' . $this->_getParam('text') . '%');
		if ($diffIds)
		$select->where($usersTableName . '.user_id IN (?)', $diffIds);
		else
		$select->where($usersTableName . '.user_id IN (?)', 0);
		$select->order('displayname ASC')->limit('40');
    $users = $users_table->fetchAll($select);
    foreach ($users as $user) {
      $user_icon_photo = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
          'id' => $user->user_id,
          'label' => $user->displayname,
          'photo' => $user_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }

  //get seo detail
  public function seoAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Seo();

    $form->populate($crowdfunding->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('crowdfundings', 'sescrowdfunding')->getAdapter();
    $db->beginTransaction();
    try {
      $crowdfunding->setFromArray($_POST);
      $crowdfunding->save();
      $db->commit();
      $form->addNotice('Changes saved.');
    } catch (Exception $e) {
      $db->rollBack();
    }
  }


  public function advertiseCrowdfundingAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->crowdfunding = $crowdfunding = Engine_Api::_()->core()->getSubject();
  }

  public function saveCrowdfundingAdminAction() {
    $data = explode(',',$_POST['data']);
    $sesblog_edit = Zend_Registry::isRegistered('sesblog_edit') ? Zend_Registry::get('sesblog_edit') : null;
    if (empty($sesblog_edit))
      return $this->_forward('notfound', 'error', 'core');
    $blog_id = $this->_getParam('blog_id', null);
    $this->view->owner_id = Engine_Api::_()->getItem('sesblog_blog',$blog_id)->owner_id;
    foreach($data as $blogAdminId) {
      $checkUser = Engine_Api::_()->getDbTable('roles', 'sesblog')->isCrowdfundingAdmin($blog_id, $blogAdminId);
      if($checkUser)
      continue;
			$roleTable = Engine_Api::_()->getDbtable('roles', 'sesblog');
			$row = $roleTable->createRow();
			$row->blog_id = $blog_id;
			$row->user_id = $blogAdminId;
			$row->save();
    }
    $this->view->paginator = Engine_Api::_()->getDbTable('roles', 'sesblog')->getCrowdfundingAdmins(array('blog_id' => $blog_id));
  }

  public function deleteCrowdfundingAdminAction() {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$db->delete('engine4_sesblog_roles', array(
			'blog_id = ?' => $_POST['blog_id'],
			'role_id =?' => $_POST['role_id'],
		));
  }

  public function editLocationAction() {

    $this->view->crowdfunding = $sescrowdfunding = Engine_Api::_()->core()->getSubject();
    $userLocation = $sescrowdfunding->location;
    if (!$userLocation)
      return $this->_forward('notfound', 'error', 'core');

    $this->view->locationLatLng = $locationLatLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($sescrowdfunding->getType(), $sescrowdfunding->getIdentity());
    if (!$locationLatLng) {
      return $this->_forward('notfound', 'error', 'core');
    }

    $this->view->form = $form = new Sescrowdfunding_Form_Dashboard_Locationedit();
    $form->populate(array(
      'ses_edit_location' => $userLocation,
      'ses_lat' => $locationLatLng['lat'],
      'ses_lng' => $locationLatLng['lng'],
      'ses_zip' => $locationLatLng['zip'],
      'ses_city' => $locationLatLng['city'],
      'ses_state' => $locationLatLng['state'],
      'ses_country' => $locationLatLng['country'],
    ));

    if ($this->getRequest()->getPost()) {

      Engine_Api::_()->getItemTable('crowdfunding')->update(array('location' =>$_POST['ses_edit_location']), array('crowdfunding_id = ?' => $sescrowdfunding->getIdentity()));

      if (isset($_POST['ses_lat']) && isset($_POST['ses_lng']) && $_POST['ses_lat'] != '' && $_POST['ses_lng'] != '' && !empty($_POST['ses_edit_location'])) {

        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng ,city,state,zip,country, resource_type) VALUES ("' . $sescrowdfunding->crowdfunding_id . '", "' . $_POST['ses_lat'] . '","' . $_POST['ses_lng'] . '","' . $_POST['ses_city'] . '","' . $_POST['ses_state'] . '","' . $_POST['ses_zip'] . '","' . $_POST['ses_country'] . '",  "crowdfunding")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['ses_lat'] . '" , lng = "' . $_POST['ses_lng'] . '",city = "' . $_POST['ses_city'] . '", state = "' . $_POST['ses_state'] . '", country = "' . $_POST['ses_country'] . '", zip = "' . $_POST['ses_zip'] . '"');
      }

      $this->_redirectCustom(array('route' => 'sescrowdfunding_dashboard', 'action' => 'edit-location', 'crowdfunding_id' => $sescrowdfunding->custom_url));
    }
  }

}
