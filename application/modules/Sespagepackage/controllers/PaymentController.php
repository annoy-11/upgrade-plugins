<?php
include_once APPLICATION_PATH . "/application/modules/Sesadvpmnt/Api/Stripe/init.php";
class Sespagepackage_PaymentController extends Core_Controller_Action_Standard {

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
  protected $_order;

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
  protected $_couponSessionCode;
  public function init() {
    // If there are no enabled gateways or packages, disable
    if (Engine_Api::_()->getDbtable('gateways', 'payment')->getEnabledGatewayCount() <= 0 ||
            Engine_Api::_()->getDbtable('packages', 'sespagepackage')->getEnabledNonFreePackageCount() <= 0) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sespage_general', true);
    }

    // Get user and session
    $this->_user = Engine_Api::_()->user()->getViewer();
    $this->_session = new Zend_Session_Namespace('Payment_Sespagepackage');
    $this->_session->gateway_id = $this->_getParam('gateway_id', 0);
    $this->_item = Engine_Api::_()->getItem('sespage_page', $this->_getParam('page_id'));
    if (!$this->_item)
      return $this->_helper->redirector->gotoRoute(array('action' => 'create'), 'sespage_general', true);
    // Check viewer and user
    if (!$this->_user || !$this->_user->getIdentity()) {
      if (!empty($this->_session->user_id)) {
        $this->_user = Engine_Api::_()->getItem('user', $this->_session->user_id);
      }
      // If no user, redirect to home?
      if (!$this->_user || !$this->_user->getIdentity()) {
        $this->_session->unsetAll();
        return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sespage_general', true);
      }
    }
  }

  public function indexAction() {
    return $this->_forward('gateway');
  }

  public function gatewayAction() {

    $item = $this->_item;
    if (!($item)) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sespage_general', true);
    }
    $this->view->item = $item;

    // Check subscription status
    if ($this->_checkItemStatus($item)) {
      return;
    }

    // Get package
    if (!$this->_user ||
            $item->owner_id != $this->_user->getIdentity() ||
            !($package = Engine_Api::_()->getItem('sespagepackage_package', $item->package_id))) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sespage_general', true);
    }
    $this->view->package = $package;

    // Unset certain keys
    unset($this->_session->gateway_id);
    unset($this->_session->order_id);

    // Gateways
    $gatewayTable = Engine_Api::_()->getDbtable('gateways', 'payment');
    $gatewaySelect = $gatewayTable->select()
            ->where('enabled = ?', 1)
    ;
    $gateways = $gatewayTable->fetchAll($gatewaySelect);

    $gatewayPlugins = array();
    foreach ($gateways as $gateway) {
      // Check billing cycle support
      if (!$package->isOneTime()) {
        $sbc = $gateway->getGateway()->getSupportedBillingCycles();
        if (!in_array($package->recurrence_type, array_map('strtolower', $sbc))) {
          //continue;
        }
      }
      $gatewayPlugins[] = array(
          'gateway' => $gateway,
          'plugin' => $gateway->getGateway(),
      );
    }
    
    // For Coupon 
    $this->view->couponSessionCode = $package->getType().'-'.$package->package_id.'-'.$this->_item->getType().'-'.$this->_item->page_id.'-1';
    $this->view->itemPrice = @isset($_SESSION[$this->view->couponSessionCode]) ? round($package->price - $_SESSION[$this->view->couponSessionCode]['discount_amount']) : $package->price;
    
    $this->view->gateways = $gatewayPlugins;
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sespage_main');
  }

  public function processAction($bankTransfer = false) {
    if (!$bankTransfer) {
      // Get gateway
      $gatewayId = $this->_getParam('gateway_id', $this->_session->gateway_id);

      if (!$gatewayId ||
              !($gateway = Engine_Api::_()->getDbtable('gateways', 'sespagepackage')->find($gatewayId)->current()) ||
              !($gateway->enabled)) {
        return $this->_helper->redirector->gotoRoute(array('action' => 'gateway'));
      }
      $this->view->gateway = $gateway;

      // Get package
      if (!$gatewayId ||
              !($package = $this->_item->getPackage())) {
        return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
      }
    
    // Get package
    if (!$package || $package->isFree()) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }
    $this->view->package = $package;
}
    // Check package?
    if ($this->_checkItemStatus($this->_item)) {
      return;
    }
    // For Coupon 
    $couponSessionCode = $package->getType().'-'.$package->package_id.'-'.$this->_item->getType().'-'.$this->_item->page_id.'-1';
    // Process
    // Create order
    $ordersTable = Engine_Api::_()->getDbtable('orders', 'payment');
    if (!empty($this->_session->order_id)) {
      $previousOrder = $ordersTable->find($this->_session->order_id)->current();
      if ($previousOrder && $previousOrder->state == 'pending') {
        $previousOrder->state = 'incomplete';
        $previousOrder->save();
      }
    }
    $ordersTable->insert(array(
        'user_id' => $this->_user->getIdentity(),
        'gateway_id' => !$bankTransfer ? $gateway->gateway_id : 10,
        'state' => 'pending',
        'creation_date' => new Zend_Db_Expr('NOW()'),
        'source_type' => 'sespage_page',
        'source_id' => $this->_item->getIdentity(),
    ));
    $this->_session->order_id = $order_id = $ordersTable->getAdapter()->lastInsertId();
    $this->_session->currency = $currentCurrency = Engine_Api::_()->sespagepackage()->getCurrentCurrency();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->_session->change_rate = $settings->getSetting('sesmultiplecurrency.' . $currentCurrency);
    // Unset certain keys
    unset($this->_session->package_id);
    unset($this->_session->page_id);
    unset($this->_session->gateway_id);

    if (!$bankTransfer) {
      // Get gateway plugin
      $this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway();
      $plugin = $gateway->getPlugin();
    } else {
      $class = str_replace('Payment', 'Sespagepackage', 'Payment_Plugin_Gateway_Paypal');
      Engine_Loader::loadClass($class);
      $gatewayPaypal = Engine_Api::_()->getItem('sespagepackage_gateway', 1);
      $plugin = new $class($gatewayPaypal);
      $order = Engine_Api::_()->getItem('payment_order', $order_id);
      try {
        $status = $plugin->onPageTransactionReturn($order, array(), 'banktransfer');
      } catch (Payment_Model_Exception $e) {
        throw $e;
        $status = 'failure';
        $this->_session->errorMessage = $e->getMessage();
      }
      return $this->_finishPayment($status);
    }

    // Prepare host info
    $schema = 'http://';
    if (!empty($_ENV["HTTPS"]) && 'on' == strtolower($_ENV["HTTPS"])) {
      $schema = 'https://';
    }
    $host = $_SERVER['HTTP_HOST'];

    // Prepare transaction
    $params = array();
    $params['language'] = $this->_user->language;
    $localeParts = explode('_', $this->_user->language);
    if (count($localeParts) > 1) {
      $params['region'] = $localeParts[1];
    }
    $params['vendor_order_id'] = $order_id;
    $params['return_url'] = $schema . $host
            . $this->view->url(array('action' => 'return'))
            . '?order_id=' . $order_id
            . '&state=' . 'return';
    $params['cancel_url'] = $schema . $host
            . $this->view->url(array('action' => 'return'))
            . '?order_id=' . $order_id
            . '&state=' . 'cancel';
    $params['ipn_url'] = $schema . $host . $this->view->url(array('action' => 'index', 'controller' => 'ipn', 'module' => 'sespagepackage'), 'default') . '?order_id=' . $order_id . '&gateway_id=' . $gatewayId;
    $params['amount'] = @isset($_SESSION[$couponSessionCode]) ? round($package->price - $_SESSION[$couponSessionCode]['discount_amount']) : $package->price;
    
     //For Credit integration
    $creditCode =  'credit'.'-sespagepackage-'.$package->package_id.'-'.$this->_item->page_id;
    $sessionCredit = new Zend_Session_Namespace($creditCode);
    if(isset($sessionCredit->total_amount) && $sessionCredit->total_amount > 0) { 
      $params['amount'] = $sessionCredit->total_amount;
    }
    
    // Process transaction
    if($gateway->plugin == "Sesadvpmnt_Plugin_Gateway_Stripe") {
          $this->view->currency =  $params['currency'] =  $currentCurrency = Engine_Api::_()->sespagepackage()->getCurrentCurrency();
          $this->view->publishKey = $publishKey = $gateway->config['sesadvpmnt_stripe_publish']; 
          $this->view->title = $title = $gateway->config['sesadvpmnt_stripe_title'];
          $this->view->description = $description = $gateway->config['sesadvpmnt_stripe_description'];
          $this->view->logo = $logo = $gateway->config['sesadvpmnt_stripe_logo'];
          $this->view->returnUrl = $params['return_url'];
          $this->view->amount = $params['amount'];
          $this->renderScript('/application/modules/Sesadvpmnt/views/scripts/payment/index.tpl');
    } elseif($gateway->plugin  == "Epaytm_Plugin_Gateway_Paytm") {
        $paytmParams = $plugin->createPageTransaction($this->_user, $this->_item, $package, $params);
        $secretKey  = $gateway->config['paytm_secret_key'];
        $this->view->paytmParams = $paytmParams;
        $this->view->checksum = getChecksumFromArray($paytmParams, $secretKey);
        if($gateway->test_mode){
          $this->view->url = "https://securegw-stage.paytm.in/order/process";
        } else {
          $this->view->url = "https://securegw.paytm.in/merchant-status/getTxnStatus";
        }
         $this->renderScript('/application/modules/Epaytm/views/scripts/payment/index.tpl');
    } else {
        $transaction = $plugin->createPageTransaction($this->_user, $this->_item, $package, $params);
        $this->view->transactionUrl = $transactionUrl = $gatewayPlugin->getGatewayUrl();
        $this->view->transactionMethod = $transactionMethod = $gatewayPlugin->getGatewayMethod();
        $this->view->transactionData = $transactionData = $transaction->getData();
    }
   
    // Handle redirection
    if ($transactionMethod == 'GET') {
      $transactionUrl .= '?' . http_build_query($transactionData);
      return $this->_helper->redirector->gotoUrl($transactionUrl, array('prependBase' => false));
    }

    // Post will be handled by the view script
  }

  public function returnAction() {
    // Get order
    if (!$this->_user ||
            !($orderId = $this->_getParam('order_id', $this->_session->order_id)) ||
            !($order = Engine_Api::_()->getItem('payment_order', $orderId)) ||
            $order->user_id != $this->_user->getIdentity() ||
            $order->source_type != 'sespage_page' ||
            !($item = $order->getSource()) ||
            !($package = $this->_item->getPackage()) ||
            !($gateway = Engine_Api::_()->getItem('sespagepackage_gateway', $order->gateway_id))) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sespage_general', true);
    }
    // Get gateway plugin
    $this->view->gatewayPlugin = $gatewayPlugin = $gateway->getGateway();
    $plugin = $gateway->getPlugin();
    
    $params  = array();
    //For Coupon
    $couponSessionCode = $package->getType().'-'.$package->package_id.'-'.$this->_item->getType().'-'.$this->_item->page_id.'-1';
    $params['amount'] = @isset($_SESSION[$couponSessionCode]) ? round($package->price - $_SESSION[$couponSessionCode]['discount_amount']) : $package->price;
    $params['couponSessionCode'] = $couponSessionCode;
    
    //For Credit integration
    $creditCode =  'credit'.'-sespagepackage-'.$package->package_id.'-'.$this->_item->page_id;
    $sessionCredit = new Zend_Session_Namespace($creditCode);
    if(isset($sessionCredit->total_amount) && $sessionCredit->total_amount > 0) { 
      $params['amount'] = $sessionCredit->total_amount;
      $params['creditCode'] = $creditCode;
    }
    
    // Process return
    unset($this->_session->errorMessage);
    try {
      if($gateway->plugin == "Sesadvpmnt_Plugin_Gateway_Stripe") {
          if(isset($_POST['stripeToken'])){
            $settings = Engine_Api::_()->getApi('settings', 'core');
            $this->view->secretKey = $params['secretKey'] = $secretKey = $gateway->config['sesadvpmnt_stripe_secret'];
            \Stripe\Stripe::setApiKey($secretKey);
            $params['token'] = $_POST['stripeToken'];
            $params['gateway'] = $gateway;
            $params['order_id'] = $order->order_id;
            $params['type'] = "sespagepackage_gateway";
            if(!$package->isOneTime()){
              $customer = \Stripe\Customer::create([
                      "source" => $params['token'],
                      "email" => $_POST['stripeEmail']
                  ]);
              $params['customer'] = $customer->id;
            }
            $transaction = $plugin->createPageTransaction($this->_user, $this->_item, $package, $params);
          }
          $params['transaction'] = $transaction;
         $status = $plugin->onPageTransactionReturn($order,$params);
      } else {
        $status = $plugin->onPageTransactionReturn($order, array_merge($this->_getAllParams(),$params));
      }
    } catch (Payment_Model_Exception $e) {
      $status = 'failure';
      $this->_session->errorMessage = $e->getMessage();
    }
    return $this->_finishPayment($status);
  }

  public function finishAction() {
    $this->view->status = $status = $this->_getParam('state');
    $this->view->error = $this->_session->errorMessage;
    $this->view->page_id = $page_id = $this->_getParam('page_id');
    if (!$page_id)
      return $this->_forward('notfound', 'error', 'core');
  }
  protected function _checkItemStatus(
  Zend_Db_Table_Row_Abstract $item = null) {

    if (!$this->_user) {
      return false;
    }

    if ($item->getPackage()->isFree()) {
      $this->_finishPayment('active');
      return true;
    }
    return false;
  }

  protected function _finishPayment($state = 'active') {

    $viewer = Engine_Api::_()->user()->getViewer();
    $user = $this->_user;

    // No user?
    if (!$this->_user) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sespage_general', true);
    }

    // Redirect
    if ($state == 'free') {
      return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sespage_general', true);
    } else {
      return $this->_helper->redirector->gotoRoute(array('action' => 'finish', 'state' => $state));
    }
  }

  protected function _checkDefaultPaymentPlan() {
    // No user?
    if (!$this->_user) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sespage_general', true);
    }

    // Handle default payment plan
    try {
      $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'payment');
      if ($subscriptionsTable) {
        $subscription = $subscriptionsTable->activateDefaultPlan($this->_user);
        if ($subscription) {
          return $this->_finishPayment('free');
        }
      }
    } catch (Exception $e) {
      // Silence
    }

    // Fall-through
  }

  public function fillDetailsAction() {
    $item = $this->_item;
    if (!($item)) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sespage_general', true);
    }
    $this->view->item = $item;
    // Check subscription status
    if ($this->_checkItemStatus($item)) {
      return;
    }
    // Get package
    if (!$this->_user ||
            $item->owner_id != $this->_user->getIdentity() ||
            !($package = Engine_Api::_()->getItem('sespagepackage_package', $item->package_id))) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'sespage_general', true);
    }
    $this->view->form = $form = new Sespagepackage_Form_Filldetail();
    //Check post
    if (!$this->getRequest()->isPost())
      return;
    //Check
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    if (isset($_FILES['payment_file']['name']) && $_FILES['payment_file']['name'] != '') {
      $admin_file = APPLICATION_PATH . '/public/paymentfiles';
      $path = realpath($admin_file);
      if (!is_dir($admin_file) && mkdir($admin_file, 0777, true))
        chmod($admin_file, 0777);
      $info = $_FILES['payment_file'];
      $targetFile = $path . '/' . time().'_'.$info['name'];
      if (!move_uploaded_file($info['tmp_name'], $targetFile)) {
        $this->view->error = "Unable to move file to upload directory.";
        return;
      }
      $_SESSION['message'] = $_POST['message'];
      $_SESSION['file_path'] = $targetFile;
    }
    return $this->processAction(true);
  }

}
