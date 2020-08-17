<?php

class Sespagepackage_IndexController extends Core_Controller_Action_Standard {

  public function indexAction() {
    $this->view->someVar = 'someVal';
  }

  public function cancelAction() {
    $packageId = $this->_getParam('package_id', 0);

    $this->view->form = $form = new Sespagepackage_Form_Cancel();

    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    
    Engine_Api::_()->getDbTable('packages','sespagepackage')->cancelSubscription(array('package_id' => $packageId));

    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your Package Subscription has been Deleted Successfully.'))
    ));
  }

  public function pageAction() {
    if (!$this->_helper->requireUser->isValid())
      return;
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->package = $packageMemberLevel = Engine_Api::_()->getDbTable('packages', 'sespagepackage')->getPackage(array('member_level' => $viewer->level_id, 'enabled' => 0));
    if (!count($packageMemberLevel) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepackage.enable.package', 0))
      return $this->_helper->redirector->gotoRoute(array('action' => 'create'), 'sespage_general', true);

    $this->view->existingleftpackages = $existingleftpackages = Engine_Api::_()->getDbTable('orderspackages', 'sespagepackage')->getLeftPackages(array('owner_id' => $viewer->getIdentity()));

    $this->_helper->content->setEnabled();
  }

  public function confirmUpgradeAction() {
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $page_id = $this->_getParam('page_id', false);
    $package_id = $this->_getParam('package_id', false);
    if (!$page_id || !$package_id)
      return $this->_forward('notfound', 'error', 'core');
    $sespage = Engine_Api::_()->getItem('sespage_page', $page_id);
    $package = Engine_Api::_()->getItem('sespagepackage_package', $package_id);
    if (!$sespage || !$package || $sespage->package_id == $package_id)
      return $this->_forward('notfound', 'error', 'core');

    $this->view->form = $form = new Sespagepackage_Form_Confirm();

    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    $validPackage = Engine_Api::_()->getDbTable('packages', 'sespagepackage')->getPackage(array('member_level' => $viewer->level_id, 'show_upgrade' => 1, 'package_id' => $package_id));
    if (empty($package->enabled) || !$validPackage)
      return $this->_forward('notfound', 'error', 'core');
    $tablePage = Engine_Api::_()->getDbTable('pages', 'sespage');
    if ($this->getRequest()->getPost()) {
      $orderpackage_id = $sespage->orderspackage_id;
      if (empty($sespage->transaction_id)) {
        //get transaction id
        $select = $tablePage->select()->where('transaction_id !=?', '')->where('orderspackage_id =?', $sespage->orderspackage_id);
        $transactionPage = $tablePage->fetchRow($select);
        if ($transactionPage)
          $transaction = Engine_Api::_()->getItem('sespagepackage_transaction', $transactionPage->transaction_id);
        else
          $transaction = '';
      }else {
        $transaction = Engine_Api::_()->getItem('sespagepackage_transaction', $sespage->transaction_id);
        $transactionPage = $sespage;
      }
      if ($transactionPage) {
        $transactionPage->cancel();
        $tablePage->update(array('transaction_id' => '', 'package_id' => $package_id), array('orderspackage_id' => $orderpackage_id));
        if ($transaction) {
          $tablePage->update(array('transaction_id' => '', 'package_id' => $package_id), array('orderspackage_id' => $orderpackage_id));
          $transaction->delete();
        }
      }
      if ($package->isFree()) {
        if (!empty($orderpackage_id))
          $tablePage->update(array('transaction_id' => '', 'package_id' => $package_id, 'is_approved' => 1), array('orderspackage_id' => $orderpackage_id));
        else {
          $sespage->is_approved = 1;
          $sespage->package_id = $package_id;
          $sespage->save();
        }
      } else {
        if (!empty($orderpackage_id))
          $tablePage->update(array('transaction_id' => '', 'package_id' => $package_id, 'is_approved' => 0), array('orderspackage_id' => $orderpackage_id));
        else {
          $sespage->is_approved = 0;
          $sespage->package_id = $package_id;
          $sespage->save();
        }
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => true,
          'parentRefresh' => true,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('Page Package changed successfully.'))
      ));
    }
  }

}
