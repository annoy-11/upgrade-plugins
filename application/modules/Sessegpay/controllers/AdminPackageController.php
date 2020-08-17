<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminPackageController.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessegpay_AdminPackageController extends Core_Controller_Action_Admin
{

  public function createAction(){
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessegpay_admin_main', array(), 'sessegpay_admin_main_plans');


    // Make form
    $this->view->form = $form = new Sessegpay_Form_Admin_Package_Create();
    $locale = $this->view->locale()->getLocaleDefault();


    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }


    // Process
    $values = $form->getValues();



    if( !empty($values['default']) && (float) $values['price'] > 0 ) {
      return $form->addError('Only a free plan may be the default plan.');
    }


    $packageTable = Engine_Api::_()->getDbtable('packages', 'payment');
    $db = $packageTable->getAdapter();
    $db->beginTransaction();

    try {

      // Update default
      if( !empty($values['default']) ) {
        $packageTable->update(array(
          'default' => 0,
        ), array(
          '`default` = ?' => 1,
        ));
      }

      $values['recurrence_type'] = "day";
      $values['duration'] = 0;
      $values['duration_type'] = "day";

      if($values['type'] == 1){
        $values['price'] = Zend_Locale_Format::getNumber($values['recurring_price'], array('locale' => $locale));
      }else{
        $values['price'] = Zend_Locale_Format::getNumber($values['price'], array('locale' => $locale));
        $values['initial_price'] = NULL;
        $values['initial_length'] = NULL;
        $values['recurring_price'] = NULL;
        $values['recurring_length'] = NULL;
      }
      // Create package
      $values['is_segpay'] = 1;
      $package = $packageTable->createRow();
      $package->setFromArray($values);
      $package->save();

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    // Redirect
    return $this->_helper->redirector->gotoRoute(array('action' => 'index'));


  }
  public function editAction(){

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessegpay_admin_main', array(), 'sessegpay_admin_main_plans');
    $package_id = $this->_getParam('package_id',0);

    // Make form
    $this->view->form = $form = new Sessegpay_Form_Admin_Package_Create();
    $locale = $this->view->locale()->getLocaleDefault();

    $form->execute->setLabel('Save');

    $package = Engine_Api::_()->getItem('payment_package',$package_id);
    if($package){
      $form->populate($package->toArray());
    }
    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $values = $form->getValues();

    if( !empty($values['default']) && (float) $values['price'] > 0 ) {
      return $form->addError('Only a free plan may be the default plan.');
    }

    $packageTable = Engine_Api::_()->getDbtable('packages', 'payment');
    $db = $packageTable->getAdapter();
    $db->beginTransaction();

    try {

      // Update default
      if( !empty($values['default']) ) {
        $packageTable->update(array(
          'default' => 0,
        ), array(
          '`default` = ?' => 1,
        ));
      }

      $values['recurrence_type'] = "day";
      $values['duration'] = 0;
      $values['duration_type'] = "day";

      if($values['type'] == 1){
        $values['price'] = Zend_Locale_Format::getNumber($values['recurring_price'], array('locale' => $locale));
      }else{
        $values['price'] = Zend_Locale_Format::getNumber($values['price'], array('locale' => $locale));
        $values['initial_price'] = NULL;
        $values['initial_length'] = NULL;
        $values['recurring_price'] = NULL;
        $values['recurring_length'] = NULL;
      }
      // Create package
      $values['is_segpay'] = 1;
      $package->setFromArray($values);
      $package->save();

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    // Redirect
    return $this->_helper->redirector->gotoRoute(array('action' => 'index'));

  }
  public function indexAction(){
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessegpay_admin_main', array(), 'sessegpay_admin_main_plans');


    // Make form
    $this->view->formFilter = $formFilter = new Payment_Form_Admin_Package_Filter();

    // Process form
    if( $formFilter->isValid($this->_getAllParams()) ) {
      if( null === $this->_getParam('enabled') ) {
        //$formFilter->populate(array('enabled' => 1));
      }
      $filterValues = $formFilter->getValues();
    } else {
      $filterValues = array(
        'enabled' => 1,
      );
      $formFilter->populate(array('enabled' => 1));
    }
    if( empty($filterValues['order']) ) {
      $filterValues['order'] = 'package_id';
    }
    if( empty($filterValues['direction']) ) {
      $filterValues['direction'] = 'DESC';
    }
    $this->view->filterValues = $filterValues;
    $this->view->order = $filterValues['order'];
    $this->view->direction = $filterValues['direction'];

    // Initialize select
    $table = Engine_Api::_()->getDbtable('packages', 'payment');
    $select = $table->select();

    // Add filter values
    if( !empty($filterValues['query']) ) {
      $select->where('title LIKE ?', '%' . $filterValues['package_id'] . '%');
    }
    if( !empty($filterValues['level_id']) ) {
      $select->where('level_id = ?', $filterValues['level_id']);
    }
    if( isset($filterValues['enabled']) && '' != $filterValues['enabled'] ) {
      $select->where('enabled = ?', $filterValues['enabled']);
    }
    if( isset($filterValues['signup']) && '' != $filterValues['signup'] ) {
      $select->where('signup = ?', $filterValues['signup']);
    }
    if( !empty($filterValues['order']) ) {
      if( empty($filterValues['direction']) ) {
        $filterValues['direction'] = 'ASC';
      }
      $select->order($filterValues['order'] . ' ' . $filterValues['direction']);
    }
    $select->where('is_segpay = 1');
    // Make paginator

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Get member totals for each plan
    $memberCounts = array();
    foreach( $paginator as $item ) {
      $memberCounts[$item->package_id] = Engine_Api::_()->getDbtable('subscriptions', 'payment')
        ->select()
        ->from('engine4_payment_subscriptions', new Zend_Db_Expr('COUNT(*)'))
        ->where('package_id = ?', $item->package_id)
        ->where('active = ?', true)
        ->where('status = ?', 'active')
        ->query()
        ->fetchColumn();
    }
    $this->view->memberCounts = $memberCounts;
  }

  public function coreAction()
  {
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
    $this->view->formFilter = $formFilter = new Payment_Form_Admin_Package_Filter();

    // Process form
    if( $formFilter->isValid($this->_getAllParams()) ) {
      if( null === $this->_getParam('enabled') ) {
        $formFilter->populate(array('enabled' => 1));
      }
      $filterValues = $formFilter->getValues();
    } else {
      $filterValues = array(
        'enabled' => 1,
      );
      $formFilter->populate(array('enabled' => 1));
    }
    if( empty($filterValues['order']) ) {
      $filterValues['order'] = 'package_id';
    }
    if( empty($filterValues['direction']) ) {
      $filterValues['direction'] = 'DESC';
    }
    $this->view->filterValues = $filterValues;
    $this->view->order = $filterValues['order'];
    $this->view->direction = $filterValues['direction'];

    // Initialize select
    $table = Engine_Api::_()->getDbtable('packages', 'payment');
    $select = $table->select();

    // Add filter values
    if( !empty($filterValues['query']) ) {
      $select->where('title LIKE ?', '%' . $filterValues['package_id'] . '%');
    }
    if( !empty($filterValues['level_id']) ) {
      $select->where('level_id = ?', $filterValues['level_id']);
    }
    if( isset($filterValues['enabled']) && '' != $filterValues['enabled'] ) {
      $select->where('enabled = ?', $filterValues['enabled']);
    }
    if( isset($filterValues['signup']) && '' != $filterValues['signup'] ) {
      $select->where('signup = ?', $filterValues['signup']);
    }
    if( !empty($filterValues['order']) ) {
      if( empty($filterValues['direction']) ) {
        $filterValues['direction'] = 'ASC';
      }
      $select->order($filterValues['order'] . ' ' . $filterValues['direction']);
    }
    $select->where('is_segpay = 0');
    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Get member totals for each plan
    $memberCounts = array();
    foreach( $paginator as $item ) {
      $memberCounts[$item->package_id] = Engine_Api::_()->getDbtable('subscriptions', 'payment')
        ->select()
        ->from('engine4_payment_subscriptions', new Zend_Db_Expr('COUNT(*)'))
        ->where('package_id = ?', $item->package_id)
        ->where('active = ?', true)
        ->where('status = ?', 'active')
        ->query()
        ->fetchColumn();
    }
    $this->view->memberCounts = $memberCounts;
    $this->renderScript('application/modules/Payment/views/scripts/admin-package/index.tpl');
  }
}
