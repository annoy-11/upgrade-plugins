<?php

class Sesblogpackage_AdminPackageController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesblog_admin_main', array(), 'sesblogpackage_admin_main_managepackage');

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
          $this->view->escape($this->view->url(array('controller' => 'gateway','module'=>'payment'))) .
          '">', '</a>');
    }

    // Make form
    $this->view->formFilter = $formFilter = new Sesblogpackage_Form_Admin_Package_Filter();

    // Process form
    if( $formFilter->isValid($this->_getAllParams()) ) {
      if( null === $this->_getParam('enabled') ) {
      }
      $filterValues = $formFilter->getValues();
    }
    if( empty($filterValues['order']) ) {
      $filterValues['order'] = 'package_id';
    }
    if( empty($filterValues['direction']) ) {
			$filterValues['order'] = 'order';
      $filterValues['direction'] = 'ASC';
    }
    $this->view->filterValues = $filterValues;
    $this->view->order = $filterValues['order'];
    $this->view->direction = $filterValues['direction'];

    // Initialize select
    $table = Engine_Api::_()->getDbtable('packages', 'sesblogpackage');
    $select = $table->select();

    // Add filter values
    if( !empty($filterValues['query']) ) {
      $select->where('title LIKE ?', '%' . $filterValues['package_id'] . '%');
    }
    
    if( isset($filterValues['enabled']) && '' != $filterValues['enabled'] ) {
      $select->where('enabled = ?', $filterValues['enabled']);
    }
   
    if( !empty($filterValues['order']) ) {
      if( empty($filterValues['direction']) ) {
        $filterValues['direction'] = 'ASC';
      }
      $select->order($filterValues['order'] . ' ' . $filterValues['direction']);
    }
		
    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Get blog totals for each plan
    $blogCounts = array();
    foreach( $paginator as $item ) {
      $blogCounts[$item->package_id] = Engine_Api::_()->getDbtable('blogs', 'sesblog')
        ->select()
        ->from('engine4_sesblog_blogs', new Zend_Db_Expr('COUNT(*)'))
        ->where('package_id = ?', $item->package_id)
        ->where('is_approved = ?', true)
        ->query()
        ->fetchColumn();
    }
    $this->view->blogCounts = $blogCounts;
  }
	
	public function settingsAction(){
			$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      	->getNavigation('sesblog_admin_main', array(), 'sesblogpackage_admin_main_packagesetting');
			
			// Make form
    $this->view->form = $form = new Sesblogpackage_Form_Admin_Package_Settings();
		
		 // Check method/data
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
			$values = $form->getValues();
			foreach ($values as $key => $value){
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
		
	}
	
	public function createAction()
  {
		$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesblog_admin_main', array(), 'sesblogpackage_admin_main_managepackage');
		
		$customFields = array();
		if(count($_POST) && $_POST['custom_fields'] == 2){
			foreach($_POST as $key=>$customValues){
				$val = explode('_',$key);
				if(count($val) < 3 || !is_numeric($val[0]) || !is_numeric($val[1]) || !is_numeric($val[2])){
					continue;
				}
				$customFields[] = $key;
			}
		}
		$this->view->customFields = $customFields;
		
    // Make form
    $this->view->form = $form = new Sesblogpackage_Form_Admin_Package_Create(array('customFields'=>$customFields));

    // Get supported billing cycles
    $gateways = array();
    $supportedBillingCycles = array();
    $partiallySupportedBillingCycles = array();
    $fullySupportedBillingCycles = null;
    $gatewaysTable = Engine_Api::_()->getDbtable('gateways', 'payment');
    foreach( $gatewaysTable->fetchAll() as $gateway ) {
      $gateways[$gateway->gateway_id] = $gateway;
      $supportedBillingCycles[$gateway->gateway_id] = $gateway->getGateway()->getSupportedBillingCycles();
      $partiallySupportedBillingCycles = array_merge($partiallySupportedBillingCycles, $supportedBillingCycles[$gateway->gateway_id]);
      if( null === $fullySupportedBillingCycles ) {
        $fullySupportedBillingCycles = $supportedBillingCycles[$gateway->gateway_id];
      } else {
        $fullySupportedBillingCycles = array_intersect($fullySupportedBillingCycles, $supportedBillingCycles[$gateway->gateway_id]);
      }
    }
    $partiallySupportedBillingCycles = array_diff($partiallySupportedBillingCycles, $fullySupportedBillingCycles);

    $multiOptions =  array_combine(array_map('strtolower', $fullySupportedBillingCycles), $fullySupportedBillingCycles);
		
		//remove day
		if(empty($multiOptions['day']) || !(strtolower($multiOptions['day']))){
			//$multiOptions['day']	= 'Day';
		}
    $form->getElement('recurrence')
      ->setMultiOptions($multiOptions)
      ;
    $form->getElement('recurrence')->options['forever'] = 'One-time';

    $form->getElement('duration')
      ->setMultiOptions($multiOptions)
      ;
    $form->getElement('duration')->options['forever'] = 'Forever';
		
    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
		$values = $form->getValues();
    // Process
    
		
		if ($values['price'] > 0) {
			//check gateway enable
      if (Engine_Api::_()->getDbtable('gateways', 'payment')->getEnabledGatewayCount() <= 0) {
        $form->getDecorator('errors')->setOption('escape', false);
        $gatewayError = $this->view->translate('You have not enabled any payment gateway yet. Please %1$senable payment gateways%2$s  before creating a paid package.', '<a href="' . $this->view->baseUrl() . '/admin/payment/gateway" ' . " target='_blank'" . '">', '</a>');
        return $form->addError($gatewayError);
      }
    }
		
    $tmp = $values['recurrence'];
    unset($values['recurrence']);
    if( empty($tmp) || !is_array($tmp) ) {
      $tmp = array(null, null);
    }
    $values['recurrence'] = (int) $tmp[0];
    $values['recurrence_type'] = $tmp[1];
    $tmp = $values['duration'];
    unset($values['duration']);
    if( empty($tmp) || !is_array($tmp) ) {
      $tmp = array(null, null);
    }
    $values['duration'] = (int) $tmp[0];
    $values['duration_type'] = $tmp[1];
    $packageTable = Engine_Api::_()->getDbtable('packages', 'sesblogpackage');
    $db = $packageTable->getAdapter();
    $db->beginTransaction();

    try {
      
      // Create package
			$values['custom_fields_params'] = json_encode($customFields);
      $package = $packageTable->createRow();
			$params['is_featured'] = $values['is_featured'];
			$params['is_sponsored'] = $values['is_sponsored'];
			$params['is_verified'] = $values['is_verified'];
			$params['modules'] = $values['modules'];
			$params['enable_location'] = $values['enable_location'];
			$params['enable_tinymce'] = $values['enable_tinymce'];

			$params['custom_fields'] = $values['custom_fields'];
			$params['photo_count'] = $values['photo_count'];
			$params['video_count'] = $values['video_count'];
			$params['music_count'] = $values['music_count'];
			$values['params']	= json_encode($params);
			$values['member_level'] = ','.implode(',',$values['member_level']).',';
      $package->setFromArray($values);
      $package->save();
			$package->order = $package->getIdentity();
			$package->save();
      // Create package in gateways?
      if( !$package->isFree() ) {
        $gatewaysTable = Engine_Api::_()->getDbtable('gateways', 'payment');
        foreach( $gatewaysTable->fetchAll(array('enabled = ?' => 1)) as $gateway ) {
          $gatewayPlugin = $gateway->getGateway();
          // Check billing cycle support
          if( !$package->isOneTime() ) {
            $sbc = $gateway->getGateway()->getSupportedBillingCycles();
            if( !in_array($package->recurrence_type, array_map('strtolower', $sbc)) ) {
              continue;
            }
          }
          if( method_exists($gatewayPlugin, 'createProduct') ) {
            $gatewayPlugin->createProduct($package->getGatewayParams());
          }
        }
      }
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    // Redirect
    return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }
	
	  public function editAction()
  {
			$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesblog_admin_main', array(), 'sesblogpackage_admin_main_managepackage');
			
    // Get package
    if( null === ($packageIdentity = $this->_getParam('package_id')) ||
        !($package = Engine_Api::_()->getDbtable('packages', 'sesblogpackage')->find($packageIdentity)->current()) ) {
      throw new Engine_Exception('No package found');
    }
    $customFields = array();
		if(count($_POST) && $_POST['custom_fields'] == 2){
			foreach($_POST as $key=>$customValues){
				$val = explode('_',$key);
				if(count($val) < 3 || !is_numeric($val[0]) || !is_numeric($val[1]) || !is_numeric($val[2])){
					continue;
				}
				$customFields[] = $key;
			}
		}else{
			$fields = json_decode($package->custom_fields_params,true);
			if(count($fields)){
				foreach($fields as $customValues){
					$val = explode('_',$customValues);
					if(count($val) < 3 || !is_numeric($val[0]) || !is_numeric($val[1]) || !is_numeric($val[2])){
						continue;
					}
					$customFields[] = $customValues;
				}
			}
		}
		$this->view->customFields = $customFields;
    // Make form
    $this->view->form = $form = new Sesblogpackage_Form_Admin_Package_Edit(array('customFields'=>$customFields));

    // Populate form
    $values = $package->toArray();
   	
    $values['recurrence'] = array($values['recurrence'], $values['recurrence_type']);
    $values['duration'] = array($values['duration'], $values['duration_type']);

    unset($values['recurrence_type']);
    unset($values['duration_type']);
		
		$params = json_decode($values['params'],true);
		$values =	array_merge($values,$params);
		$values['member_level'] = explode(',',$package->member_level);
    $otherValues = array(
      'price' => $values['price'],
      'recurrence' => $values['recurrence'],
      'duration' => $values['duration'],
    );
    
    $form->populate($values);
    
    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Hack em up
    $form->populate($otherValues);

    // Process
    $values = $form->getValues();
		$values['custom_fields_params'] = json_encode($customFields);
    unset($values['price']);
    unset($values['recurrence']);
    unset($values['recurrence_type']);
    unset($values['duration']);
    unset($values['duration_type']);
		unset($values['is_renew_link']);
		unset($values['renew_link_days']);
    
    $packageTable = Engine_Api::_()->getDbtable('packages', 'sesblogpackage');
    $db = $packageTable->getAdapter();
    $db->beginTransaction();

    try {
			$params['is_featured'] = $values['is_featured'];
			$params['is_sponsored'] = $values['is_sponsored'];
			$params['is_verified'] = $values['is_verified'];
			$params['enable_location'] = $values['enable_location'];
			$params['enable_tinymce'] = $values['enable_tinymce'];
			$params['modules'] = $values['modules'];
			$values['member_level'] = ','.implode(',',$values['member_level']).',';
			
			$params['custom_fields'] = $values['custom_fields'];
			$params['photo_count'] = $values['photo_count'];
			$params['video_count'] = $values['video_count'];
			$params['music_count'] = $values['music_count'];
			
			$values['params']	= json_encode($params);
			
      $package->setFromArray($values);
      $package->save();
			
      // Update package
      $package->setFromArray($values);
      $package->save();
      
      // Create package in gateways?
      if( !$package->isFree() ) {
        $gatewaysTable = Engine_Api::_()->getDbtable('gateways', 'payment');
        foreach( $gatewaysTable->fetchAll(array('enabled = ?' => 1)) as $gateway ) {
          $gatewayPlugin = $gateway->getGateway();
          // Check billing cycle support
          if( !$package->isOneTime() ) {
            $sbc = $gateway->getGateway()->getSupportedBillingCycles();
            if( !in_array($package->recurrence_type, array_map('strtolower', $sbc)) ) {
              continue;
            }
          }
          if( !method_exists($gatewayPlugin, 'createProduct') ||
              !method_exists($gatewayPlugin, 'editProduct') ||
              !method_exists($gatewayPlugin, 'detailVendorProduct') ) {
            continue;
          }
          // If it throws an exception, or returns empty, assume it doesn't exist?
          try {
            $info = $gatewayPlugin->detailVendorProduct($package->getGatewayIdentity());
          } catch( Exception $e ) {
            $info = false;
          }
          // Create
          if( !$info ) {
            $gatewayPlugin->createProduct($package->getGatewayParams());
          }
          // Edit
          else {
            $gatewayPlugin->editProduct($package->getGatewayIdentity(), $package->getGatewayParams());
          }
        }
      }
      
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    // Redirect
    return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }
	 public function orderAction() {
    if (!$this->getRequest()->isPost())
      return;
    $packageTable = Engine_Api::_()->getDbtable('packages', 'sesblogpackage');
    $packages = $packageTable->fetchAll($packageTable->select());
    foreach ($packages as $package) {
      $order = $this->getRequest()->getParam('package_' . $package->package_id);
      if (!$order)
        $order = 999;
      $package->order = $order;
      $package->save();
    }
    return;
  }
	public function deleteAction()
  {
    // Get package
    if( null === ($packageIdentity = $this->_getParam('package_id')) ||
        !($package = Engine_Api::_()->getDbtable('packages', 'sesblogpackage')->find($packageIdentity)->current()) ) {
      throw new Engine_Exception('No package found');
    }
    $this->view->form = $form = new Sesblogpackage_Form_Admin_Package_Delete();
    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    // Process
    $packageTable = Engine_Api::_()->getDbtable('packages', 'sesblogpackage');
    $db = $packageTable->getAdapter();
    $db->beginTransaction();
    try {
      // Delete package
      $package->delete();
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
   $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Package deleted successfully.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRefresh' => true,
      'messages' => Array($this->view->message)
    ));
  }
	
	 //Approved Action
  public function highlightAction() {
    $package_id = $this->_getParam('package_id');
    if (!empty($package_id)) {
      $package = Engine_Api::_()->getItem('sesblogpackage_package', $package_id);
      $package->highlight = !$package->highlight;
      $package->save();
    }
    $this->_redirect($_SERVER['HTTP_REFERER']);
  }
	 //Approved Action
  public function showUpgradeAction() {
    $package_id = $this->_getParam('package_id');
    if (!empty($package_id)) {
      $package = Engine_Api::_()->getItem('sesblogpackage_package', $package_id);
      $package->show_upgrade = !$package->show_upgrade;
      $package->save();
    }
    $this->_redirect($_SERVER['HTTP_REFERER']);
  }
	 //Approved Action
  public function approvedAction() {
    $package_id = $this->_getParam('package_id');
    if (!empty($package_id)) {
      $package = Engine_Api::_()->getItem('sesblogpackage_package', $package_id);
      $package->enabled = !$package->enabled;
      $package->save();
    }
    $this->_redirect($_SERVER['HTTP_REFERER']);
  }
	public function manageTransactionAction(){
		$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesblog_admin_main', array(), 'sesblogpackage_admin_main_transaction');

    $this->view->formFilter = $formFilter = new Sesblogpackage_Form_Admin_Filter();
    
		$values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    	$values = $formFilter->getValues();
    $values = array_merge(array(
			'order' => isset($_GET['order']) ? $_GET['order'] :'',
			'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);
    $this->view->assign($values);
		
    $tableTransaction = Engine_Api::_()->getItemTable('sesblogpackage_transaction');
		$tableTransactionName = $tableTransaction->info('name');
    $blogTable = Engine_Api::_()->getDbTable('blogs', 'sesblog');
    $blogTableName = $blogTable->info('name');
		$tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
		
    $select = $tableTransaction->select()
    ->setIntegrityCheck(false)
    ->from($tableTransactionName)
    ->joinLeft($tableUserName, "$tableTransactionName.owner_id = $tableUserName.user_id", 'username')
		->where($tableUserName.'.user_id IS NOT NULL')
		->joinLeft($blogTableName, "$tableTransactionName.transaction_id = $blogTableName.transaction_id", 'blog_id')
		->where($blogTableName.'.blog_id IS NOT NULL')
    ->order((!empty($_GET['order']) ? $_GET['order'] : 'transaction_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
		
		if (!empty($_GET['title'])) {
      $select
          ->where('(' . $tableTransactionName . '.gateway_transaction_id LIKE ? || ' .
							 $tableTransactionName . '.gateway_profile_id LIKE ? || ' .
              'title LIKE ? || ' .
              'displayname LIKE ? || username LIKE ? || ' .
              $tableUserName.'.email LIKE ?)', '%' . $_GET['title'] . '%');
    }
		
		if (!empty($_GET['gateway_id']))
    	$select->where($tableTransactionName . '.gateway_id LIKE ?', '%' . $_GET['gateway_id'] . '%');
		
		if (!empty($_GET['gateway_type']))
    	$select->where($tableTransactionName . '.gateway_type LIKE ?', '%' . $_GET['gateway_type'] . '%');
		
		
		$urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
      if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
      continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
	}
	public function detailAction() {
    if (!($transaction_id = $this->_getParam('transaction_id')) ||
        !($transaction = Engine_Api::_()->getItem('sesblogpackage_transaction', $transaction_id))) {
      return;
    }

    $this->view->transaction = $transaction;
    $this->view->gateway = Engine_Api::_()->getItem('payment_gateway', $transaction->gateway_id);
    $this->view->order = Engine_Api::_()->getItem('payment_order', $transaction->order_id);
    $this->view->item = Engine_Api::_()->getItem('sesblog_blog', $this->_getParam('blog_id'));
    $this->view->user = Engine_Api::_()->getItem('user', $transaction->owner_id);
  }
}