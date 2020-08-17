<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessegpay_AdminSettingsController extends Core_Controller_Action_Admin {
  public function indexAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessegpay_admin_main', array(), 'sessegpay_admin_main_settings');

    // Make form
    $this->view->form = $form = new Sessegpay_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sessegpay/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sessegpay.pluginactivated')) {
        foreach ($values as $key => $value) {
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function transactionsAction(){

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessegpay_admin_main', array(), 'sessegpay_admin_main_transactions');

    // Test curl support
    if( !function_exists('curl_version') ||
        !($info = curl_version()) ) {
      $this->view->error = $this->view->translate('The PHP extension cURL ' .
          'does not appear to be installed, which is required ' .
          'for interaction with payment gateways. Please contact your ' .
          'hosting provider.');
    }
    // Test curl ssl support
    else if( !($info['features'] & CURL_VERSION_SSL) ||
        !in_array('https', $info['protocols']) ) {
      $this->view->error = $this->view->translate('The installed version of ' .
          'the cURL PHP extension does not support HTTPS, which is required ' .
          'for interaction with payment gateways. Please contact your ' .
          'hosting provider.');
    }
    // Check for enabled payment gateways
    else if( Engine_Api::_()->getDbtable('gateways', 'payment')->getEnabledGatewayCount() <= 0 ) {
      $this->view->error = $this->view->translate('There are currently no ' .
          'enabled payment gateways. You must %1$sadd one%2$s before this ' .
          'page is available.', '<a href="' .
          $this->view->escape($this->view->url(array('controller' => 'gateway'))) .
          '">', '</a>');
    }


    // Make form
    $this->view->formFilter = $formFilter = new Payment_Form_Admin_Transaction_Filter();
    $formFilter->removeElement('gateway_id');
    // Process form
    if( $formFilter->isValid($this->_getAllParams()) ) {
      $filterValues = $formFilter->getValues();
    } else {
      $filterValues = array();
    }
    if( empty($filterValues['order']) ) {
      $filterValues['order'] = 'transaction_id';
    }
    if( empty($filterValues['direction']) ) {
      $filterValues['direction'] = 'DESC';
    }
    $this->view->filterValues = $filterValues;
    $this->view->order = $filterValues['order'];
    $this->view->direction = $filterValues['direction'];

    // Initialize select
    $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'payment');
    $transactionSelect = $transactionsTable->select()
      ;

    $table = Engine_Api::_()->getDbtable('gateways', 'payment');
    $select = $table->select()->where('plugin =?','Sessegpay_Plugin_Gateway_Segpay');
    $res = $table->fetchRow($select);
    $gatId = 0;
    if($res){
      $gatId = $res->gateway_id;
    }
    // Add filter values
    //if( !empty($filterValues['gateway_id']) ) {
      $transactionSelect->where('gateway_id = ?', $gatId);
    //}
    if( !empty($filterValues['type']) ) {
      $transactionSelect->where('type = ?', $filterValues['type']);
    }
    if( !empty($filterValues['state']) ) {
      $transactionSelect->where('state = ?', $filterValues['state']);
    }
    if( !empty($filterValues['query']) ) {
      $transactionSelect
        ->from($transactionsTable->info('name'))
        ->joinLeft('engine4_users', 'engine4_users.user_id=engine4_payment_transactions.user_id', null)
        ->where('(gateway_transaction_id LIKE ? || ' .
            'gateway_parent_transaction_id LIKE ? || ' .
            'gateway_order_id LIKE ? || ' .
            'displayname LIKE ? || username LIKE ? || ' .
            'email LIKE ?)', '%' . $filterValues['query'] . '%');
        ;
    }
    if( ($user_id = $this->_getParam('user_id', @$filterValues['user_id'])) ) {
      $this->view->filterValues['user_id'] = $user_id;
      $transactionSelect->where('engine4_payment_transactions.user_id = ?', $user_id);
    }
    if( !empty($filterValues['order']) ) {
      if( empty($filterValues['direction']) ) {
        $filterValues['direction'] = 'DESC';
      }
      $transactionSelect->order($filterValues['order'] . ' ' . $filterValues['direction']);
    }






    $this->view->paginator = $paginator = Zend_Paginator::factory($transactionSelect);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Preload info
    $gatewayIds = array();
    $userIds = array();
    $orderIds = array();
    foreach( $paginator as $transaction ) {
      if( !empty($transaction->gateway_id) ) {
        $gatewayIds[] = $transaction->gateway_id;
      }
      if( !empty($transaction->user_id) ) {
        $userIds[] = $transaction->user_id;
      }
      if( !empty($transaction->order_id) ) {
        $orderIds[] = $transaction->order_id;
      }
    }
    $gatewayIds = array_unique($gatewayIds);
    $userIds = array_unique($userIds);
    $orderIds = array_unique($orderIds);

    // Preload gateways
    $gateways = array();
    if( !empty($gatewayIds) ) {
      foreach( Engine_Api::_()->getDbtable('gateways', 'payment')->find($gatewayIds) as $gateway ) {
        $gateways[$gateway->gateway_id] = $gateway;
      }
    }
    $this->view->gateways = $gateways;

    // Preload users
    $users = array();
    if( !empty($userIds) ) {
      foreach( Engine_Api::_()->getItemTable('user')->find($userIds) as $user ) {
        $users[$user->user_id] = $user;
      }
    }
    $this->view->users = $users;

    // Preload orders
    $orders = array();
    if( !empty($orderIds) ) {
      foreach( Engine_Api::_()->getDbtable('orders', 'payment')->find($orderIds) as $order ) {
        $orders[$order->order_id] = $order;
      }
    }
    $this->view->orders = $orders;
  }

}
