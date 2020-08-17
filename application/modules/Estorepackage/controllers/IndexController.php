<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Estorepackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: IndexController.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Estorepackage_IndexController extends Core_Controller_Action_Standard {
  public function init(){

  }
  public function indexAction() {
    $this->view->someVar = 'someVal';
  }

  public function cancelAction() {
    $packageId = $this->_getParam('package_id', 0);

    $this->view->form = $form = new Estorepackage_Form_Cancel();

    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    Engine_Api::_()->getDbTable('packages','estorepackage')->cancelSubscription(array('package_id' => $packageId));

    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your Package Subscription has been Deleted Successfully.'))
    ));
  }

  public function storesAction() {
    if (!$this->_helper->requireUser->isValid())
      return;
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->package = $packageMemberLevel = Engine_Api::_()->getDbTable('packages', 'estorepackage')->getPackage(array('member_level' => $viewer->level_id, 'enabled' => 0));
    if (!count($packageMemberLevel) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('estorepackage.enable.package', 0))
      return $this->_helper->redirector->gotoRoute(array('action' => 'create'), 'estore_general', true);

    $this->view->existingleftpackages = $existingleftpackages = Engine_Api::_()->getDbTable('orderspackages', 'estorepackage')->getLeftPackages(array('owner_id' => $viewer->getIdentity()));

    $this->_helper->content->setEnabled();
  }

  public function confirmUpgradeAction() {
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
      $store_id = $this->_getParam('store_id', false);
    $package_id = $this->_getParam('package_id', false);
    if (!$store_id || !$package_id)
      return $this->_forward('notfound', 'error', 'core');
    $estore = Engine_Api::_()->getItem('stores', $store_id);
    $package = Engine_Api::_()->getItem('estorepackage_package', $package_id);
    if (!$estore || !$package || $estore->package_id == $package_id)
      return $this->_forward('notfound', 'error', 'core');

    $this->view->form = $form = new Estorepackage_Form_Confirm();

    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    $validPackage = Engine_Api::_()->getDbTable('packages', 'estorepackage')->getPackage(array('member_level' => $viewer->level_id, 'show_upgrade' => 1, 'package_id' => $package_id));
    if (empty($package->enabled) || !$validPackage)
      return $this->_forward('notfound', 'error', 'core');
    $tableStore = Engine_Api::_()->getDbTable('pages', 'estore');
    if ($this->getRequest()->getPost()) {
      $orderpackage_id = $estore->orderspackage_id;
      if (empty($estore->transaction_id)) {
        //get transaction id
        $select = $tableStore->select()->where('transaction_id !=?', '')->where('orderspackage_id =?', $estore->orderspackage_id);
        $transactionStore = $tableStore->fetchRow($select);
        if ($transactionStore)
          $transaction = Engine_Api::_()->getItem('estorepackage_transaction', $transactionStore->transaction_id);
        else
          $transaction = '';
      }else {
        $transaction = Engine_Api::_()->getItem('estorepackage_transaction', $estore->transaction_id);
        $transactionStore = $estore;
      }
      if ($transactionStore) {
        $transactionStore->cancel();
        $tableStore->update(array('transaction_id' => '', 'package_id' => $package_id), array('orderspackage_id' => $orderpackage_id));
        if ($transaction) {
          $tableStore->update(array('transaction_id' => '', 'package_id' => $package_id), array('orderspackage_id' => $orderpackage_id));
          $transaction->delete();
        }
      }
      if ($package->isFree()) {
        if (!empty($orderpackage_id))
          $tableStore->update(array('transaction_id' => '', 'package_id' => $package_id, 'is_approved' => 1), array('orderspackage_id' => $orderpackage_id));
        else {
          $estore->is_approved = 1;
          $estore->package_id = $package_id;
          $estore->save();
        }
      } else {
        if (!empty($orderpackage_id))
          $tableStore->update(array('transaction_id' => '', 'package_id' => $package_id, 'is_approved' => 0), array('orderspackage_id' => $orderpackage_id));
        else {
          $estore->is_approved = 0;
          $estore->package_id = $package_id;
          $estore->save();
        }
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => true,
          'parentRefresh' => true,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('Store Package changed successfully.'))
      ));
    }
  }

}
