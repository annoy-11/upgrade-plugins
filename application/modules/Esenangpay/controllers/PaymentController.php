<?php
class Esenangpay_PaymentController extends Core_Controller_Action_Standard
{

  /**
   * @var User_Model_User
   */
  protected $_user;

  /**
   * @var Zend_Session_Namespace
   */
  protected $_session;

  /**
   * @var Payment_Model_Order
   */
  protected $order_id;

  protected $_type;

  /**
   * @var Payment_Model_Gateway
   */
  protected $_gateway;

  /**
   * @var Payment_Model_Subscription
   */
  protected $_item;

  /**
   * @var Payment_Model_Package
   */
  protected $_package;

  protected $_module;

  const KEY = "senangPaySession";

  public function setSessions($name)
  {
    $sessionName = isset($name) ? $name : '';
    $this->_user = Engine_Api::_()->user()->getViewer();
    $this->_session = new Zend_Session_Namespace($sessionName);
    $this->_session->type = $this->_getParam('type');
    $this->_session->order_id = $this->_getParam('order_id');
    $this->_session->source_id = $this->_getParam('source_id');
    $this->_session->gateway_id = $this->_getParam('gateway_id', false);
    // Check viewer and user

    if (!$this->_user || !$this->_user->getIdentity()) {
      if (!empty($this->_session->user_id)) {
        $this->_user = Engine_Api::_()->getItem('user', $this->_session->user_id);
      }
    }
  }

  public function indexAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    $gatewayId = $this->_getParam('gateway_id', null);
    if (
      !$gatewayId ||
      !($gateway = Engine_Api::_()->getItem('payment_gateway', $gatewayId)) ||
      !($gateway->enabled)
    ) {
      return false;
    }

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $requestType = $settings->getSetting('esenangpay.request.method');
    $gateway->getGateway();
    $gateway->getGateway()->setGatewayMethod($requestType);
    $plugin = $gateway->getPlugin();
    $this->setSessions(self::KEY);

    if ($this->_getParam('type', null) == "sescommunityads") {

      $this->_item = Engine_Api::_()->getItem('sescommunityads', $this->_getParam('source_id'));
      if (!$this->_item)
        return $this->_forward('notfound', 'error', 'core');

      $campaign_id = $this->_item->campaign_id;
      $campaigns = Engine_Api::_()->getItem('sescommunityads_campaign', $campaign_id);
      if (!$this->_item)
        return $this->_forward('notfound', 'error', 'core');

      $order_id =  $this->_getParam('order_id');
      if (!$order_id)
        return $this->_forward('notfound', 'error', 'core');

      $order = Engine_Api::_()->getItem('payment_order', $order_id);
      $item = $order->getSource();
      $package = $item->getPackage();
      $package->isOneTime();
      if (!$package->isOneTime()) {
        $this->view->notSupport = 'recurring payment not supported yet!';
        return;
      }

      $package = $this->_item->getPackage();
      $detail = "Order For Campaigns {$campaigns->title}, order id {$order_id}";
      $price = $package->price;
    } else {
      return $this->_forward('notfound', 'error', 'core');
    }

    $plugin->setSendPaymentDetails(
      $viewer,
      str_replace(' ', '_', $detail),
      $order_id,
      $price
    );
    $apiUrl = $plugin->processPayment();
    if ($requestType == "GET") {
      header('Location: ' . $apiUrl);
      exit();
    } else if ($requestType == "POST") {
      $this->view->transactionUrl = $apiUrl['url'];
      $this->view->transactionData = $apiUrl['data'];
    } else
      return $this->_forward('notfound', 'error', 'core');
  }

  public function returnUrlAction()
  {
    if (!$this->_helper->requireUser()->isValid()) {
      return;
    }
    $session = new Zend_Session_Namespace(self::KEY);
    $gatewayId = $session->gateway_id;
    if (
      !$gatewayId ||
      !($gateway = Engine_Api::_()->getItem('payment_gateway', $gatewayId)) ||
      !($gateway->enabled)
    ) {
      return false;
    }

    $plugin = $gateway->getPlugin();
    $senangPayUserDetails = (object) $gateway->config;
    $request = (object) $this->_getAllParams();
    $request->secretKey = $senangPayUserDetails->esenangpay_secret_key;
    $type = $session->type;
    $order = Engine_Api::_()->getItem('payment_order', $request->order_id);
    if ($order->gateway_id !=  $session->gateway_id) {
      throw new Engine_Payment_Plugin_Exception('Gateways do not match');
    }
    // Get related info
    $user = $order->getUser();
    $item = $order->getSource();
    $package = $item->getPackage();
    $transaction = $item->getTransaction();

    if ($plugin->checkIfReturnHashCorrect($request) == true) {

      if ($type == "sescommunityads") {
        if ($request->status_id == 1) {
          //transaction successfully completed.

          // One-time
          if ($package->isOneTime()) {
            // Update order with profile info and complete status?
            $paymentStatus = 'active';
            $orderStatus = 'complete';
            $order->state = $orderStatus;
            $order->gateway_transaction_id = $request->transaction_id;
            $order->save();
            $orderPackageId = $item->existing_package_order ? $item->existing_package_order : false;
            $orderPackage = Engine_Api::_()->getItem('sescommunityads_orderspackage', $orderPackageId);
            if (!$orderPackageId || !$orderPackage) {
              $transactionsOrdersTable = Engine_Api::_()->getDbtable('orderspackages', 'sescommunityads');
              $transactionsOrdersTable->insert(array(
                'owner_id' => $order->user_id,
                'item_count' => ($package->item_count - 1),
                'package_id' => $package->getIdentity(),
                'state' => $paymentStatus,
                'expiration_date' => $package->getExpirationDate(),
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'creation_date' => new Zend_Db_Expr('NOW()'),
                'modified_date' => new Zend_Db_Expr('NOW()'),
              ));
              $orderPackageId = $transactionsOrdersTable->getAdapter()->lastInsertId();
            } else {
              $orderPackage = Engine_Api::_()->getItem('sescommunityads_orderspackage', $orderPackageId);
              $orderPackage->item_count = $orderPackage->item_count--;
              $orderPackage->save();
              $orderPackageId = $orderPackage->getIdentity();
            }
            $sessionPayment_Sescommunityads = new Zend_Session_Namespace('Payment_Sescommunityads');
            $currency = $sessionPayment_Sescommunityads->currency;
            $rate = $sessionPayment_Sescommunityads->change_rate;
            if (!$rate)
              $rate = 1;
            $defaultCurrency = Engine_Api::_()->sescommunityads()->defaultCurrency();
            $settings = Engine_Api::_()->getApi('settings', 'core');
            $currencyValue = 1;
            if ($currency != $defaultCurrency)
              $currencyValue = $settings->getSetting('sesmultiplecurrency.' . $currency);
            $price = @round(($package->price * $currencyValue), 2);
            //Insert transaction
            $daysLeft = 0;
            //check previous transaction if any for reniew
            if (!empty($transaction->expiration_date) && $transaction->expiration_date != '3000-00-00 00:00:00') {
              $expiration = $package->getExpirationDate();
              //check isonetime condition and renew exiration date if left
              if ($package->isOneTime()) {
                $datediff = strtotime($transaction->expiration_date) - time();
                $daysLeft = floor($datediff / (60 * 60 * 24));
              }
            }
            $oldOrderPackageId = $item->orderspackage_id;
            $tableAds = Engine_Api::_()->getDbTable('sescommunityads', 'sescommunityads');
            if (!empty($oldOrderPackageId)) {
              $select = $tableAds->select()->from($tableAds->info('name'))->where('orderspackage_id =?', $oldOrderPackageId);
              $totalItemCreated = count($tableAds->fetchAll($select));
              if ($package->item_count >= $totalItemCreated && $package->item_count)
                $leftAd = $package->item_count - $totalItemCreated;
              else if (!$package->item_count)
                $leftAd = -1;
              else
                $leftAd = 0;
            } else
              $leftAd = $package->item_count - 1;
            $tableAds->update(array('orderspackage_id' => $orderPackageId), array('orderspackage_id' => $oldOrderPackageId));
            $packageOrder = Engine_Api::_()->getItem('sescommunityads_orderspackage', $orderPackageId);
            $packageOrder->item_count = $leftAd;
            $packageOrder->save();

            $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'sescommunityads');
            $transactionsTable->insert(array(
              'owner_id' => $order->user_id,
              'package_id' => $item->package_id,
              'item_count' => $leftAd,
              'gateway_id' =>  $sessionPayment_Sescommunityads->gateway_id,
              'gateway_transaction_id' => $request->transaction_id,
              'creation_date' => new Zend_Db_Expr('NOW()'),
              'modified_date' => new Zend_Db_Expr('NOW()'),
              'order_id' => $order->order_id,
              'orderspackage_id' => $orderPackageId,
              'state' => 'initial',
              'total_amount' => $package->price,
              'change_rate' => $rate,
              'gateway_type' => 'Paypal',
              'currency_symbol' => $currency,
              'ip_address' => $_SERVER['REMOTE_ADDR'],
            ));
            $transaction_id = $transactionsTable->getAdapter()->lastInsertId();
            $item->transaction_id = $transaction_id;
            $item->orderspackage_id = $orderPackageId;
            $item->existing_package_order = 0;
            $item->save();
            $transaction = Engine_Api::_()->getItem('sescommunityads_transaction', $transaction_id);
            // Get benefit setting
            $giveBenefit = Engine_Api::_()->getDbtable('transactions', 'sescommunityads')
              ->getBenefitStatus($user);
            // Check payment status

            if ($paymentStatus == 'okay' || $paymentStatus == 'active' || ($paymentStatus == 'pending' && $giveBenefit)) {

              //Update subscription info
              $transaction->gateway_id = $this->_gatewayInfo->gateway_id;
              $transaction->gateway_profile_id = $request->transaction_id;
              $transaction->save();
              // Payment success
              $transaction = $item->onPaymentSuccess();
              if ($daysLeft >= 1) {
                $expiration_date = date('Y-m-d H:i:s', strtotime($transaction->expiration_date . '+ ' . $daysLeft . ' days'));
                $transaction->expiration_date = $expiration_date;
                $transaction->save();
                $orderpackage = Engine_Api::_()->getItem('sescommunityads_orderspackage', $orderPackageId);
                $orderpackage->expiration_date = $expiration_date;
                $orderpackage->save();
              }

              //notification
              $getSuperAdmins = Engine_Api::_()->user()->getSuperAdmins();
              foreach ($getSuperAdmins as $getSuperAdmin) {
                $admin = Engine_Api::_()->getItem('user', $getSuperAdmin->user_id);

                $link = 'ads/view/sescommunityad_id/' . $item->sescommunityad_id;
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($admin, $admin, $item, 'sescommunityads_pmtmadeadmin', array("adsLink" => $link));

                //Send email to user

                Engine_Api::_()->getApi('mail', 'core')->sendSystem($admin->email, 'sescommunityads_pmtmadeadmin', array('host' => $_SERVER['HTTP_HOST'], 'queue' => false, 'title' => $item->title, 'description' => $item->description, 'ad_link' => $link));
              }

              //Send to user
              $adsOwner = Engine_Api::_()->getItem('user', $item->user_id);
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($adsOwner, $adsOwner, $item, 'sescommunityads_paymentsuccessfull');
              //Send email to user
              $link = 'ads/view/sescommunityad_id/' . $item->sescommunityad_id;
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($adsOwner->email, 'sescommunityads_paymentsuccessfull', array('host' => $_SERVER['HTTP_HOST'], 'queue' => false, 'title' => $item->title, 'description' => $item->description, 'ad_link' => $link));


              //Ads activated
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($adsOwner, $adsOwner, $item, 'sescommunityads_adsactivated', array("adsLink" => $link));

              Engine_Api::_()->getApi('mail', 'core')->sendSystem($adsOwner->email, 'sescommunityads_adsactivated', array('host' => $_SERVER['HTTP_HOST'], 'queue' => false, 'title' => $item->title, 'description' => $item->description, 'ad_link' => $link));
            }
          } else {
            //Recurring
          }
          return $this->_helper->redirector->gotoRoute(array('action' => 'finish', "sescommunityad_id" => $session->source_id, 'state' => 'active'), 'sescomminityads_payment', true);
        } else { //transaction not successfully done.
          $order->onCancel();
          $item->onPaymentFailure();
          return $this->_helper->redirector->gotoRoute(array('action' => 'finish', "sescommunityad_id" => $session->source_id, 'state' => 'pending'), 'sescomminityads_payment', true);
        }
      } else { //if type not found.
        return $this->_forward('notfound', 'error', 'core');
      }
    } else { // If the value does not match then the data may have been tampered.
      if ($type == "sescommunityads") {
        $order->onFailure();
        $item->onPaymentFailure();
        return $this->_helper->redirector->gotoRoute(array('action' => 'finish', "sescommunityad_id" => $session->source_id), 'sescomminityads_payment', true);
      } else {
        return $this->_forward('notfound', 'error', 'core');
      }
    }
  }

  public function statusAction($transaction)
  {
    switch ($transaction->status) {
      case "active":
      case "succeeded":
        $this->getPaymentInfo($transaction);
        break;
      default:
        echo "";
    }
  }

  public function getPaymentInfo($transaction)
  {
    switch ($transaction->metadata->type) {
      case 'product':
        break;
    }
  }
}
