<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspackage
 * @package    Sesbusinesspackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinesspackage_IndexController extends Core_Controller_Action_Standard {

  public function indexAction() {
    $this->view->someVar = 'someVal';
  }

  public function cancelAction() {
    $packageId = $this->_getParam('package_id', 0);

    $this->view->form = $form = new Sesbusinesspackage_Form_Cancel();

    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    
    Engine_Api::_()->getDbTable('packages','sesbusinesspackage')->cancelSubscription(array('package_id' => $packageId));

    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your Package Subscription has been Deleted Successfully.'))
    ));
  }

  public function businessAction() {
    if (!$this->_helper->requireUser->isValid())
      return;
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->package = $packageMemberLevel = Engine_Api::_()->getDbTable('packages', 'sesbusinesspackage')->getPackage(array('member_level' => $viewer->level_id, 'enabled' => 0));
    if (!count($packageMemberLevel) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspackage.enable.package', 0))
      return $this->_helper->redirector->gotoRoute(array('action' => 'create'), 'sesbusiness_general', true);

    $this->view->existingleftpackages = $existingleftpackages = Engine_Api::_()->getDbTable('orderspackages', 'sesbusinesspackage')->getLeftPackages(array('owner_id' => $viewer->getIdentity()));

   // $this->_helper->content->setEnabled();
  }

  public function confirmUpgradeAction() {
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $business_id = $this->_getParam('business_id', false);
    $package_id = $this->_getParam('package_id', false);
    if (!$business_id || !$package_id)
      return $this->_forward('notfound', 'error', 'core');
    $sesbusiness = Engine_Api::_()->getItem('businesses', $business_id);
    $package = Engine_Api::_()->getItem('sesbusinesspackage_package', $package_id);
    if (!$sesbusiness || !$package || $sesbusiness->package_id == $package_id)
      return $this->_forward('notfound', 'error', 'core');

    $this->view->form = $form = new Sesbusinesspackage_Form_Confirm();

    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    $validPackage = Engine_Api::_()->getDbTable('packages', 'sesbusinesspackage')->getPackage(array('member_level' => $viewer->level_id, 'show_upgrade' => 1, 'package_id' => $package_id));
    if (empty($package->enabled) || !$validPackage)
      return $this->_forward('notfound', 'error', 'core');
    $tableBusiness = Engine_Api::_()->getDbTable('businesses', 'sesbusiness');
    if ($this->getRequest()->getPost()) {
      $orderpackage_id = $sesbusiness->orderspackage_id;
      if (empty($sesbusiness->transaction_id)) {
        //get transaction id
        $select = $tableBusiness->select()->where('transaction_id !=?', '')->where('orderspackage_id =?', $sesbusiness->orderspackage_id);
        $transactionBusiness = $tableBusiness->fetchRow($select);
        if ($transactionBusiness)
          $transaction = Engine_Api::_()->getItem('sesbusinesspackage_transaction', $transactionBusiness->transaction_id);
        else
          $transaction = '';
      }else {
        $transaction = Engine_Api::_()->getItem('sesbusinesspackage_transaction', $sesbusiness->transaction_id);
        $transactionBusiness = $sesbusiness;
      }
      if ($transactionBusiness) {
        $transactionBusiness->cancel();
        $tableBusiness->update(array('transaction_id' => '', 'package_id' => $package_id), array('orderspackage_id' => $orderpackage_id));
        if ($transaction) {
          $tableBusiness->update(array('transaction_id' => '', 'package_id' => $package_id), array('orderspackage_id' => $orderpackage_id));
          $transaction->delete();
        }
      }
      if ($package->isFree()) {
        if (!empty($orderpackage_id))
          $tableBusiness->update(array('transaction_id' => '', 'package_id' => $package_id, 'is_approved' => 1), array('orderspackage_id' => $orderpackage_id));
        else {
          $sesbusiness->is_approved = 1;
          $sesbusiness->package_id = $package_id;
          $sesbusiness->save();
        }
      } else {
        if (!empty($orderpackage_id))
          $tableBusiness->update(array('transaction_id' => '', 'package_id' => $package_id, 'is_approved' => 0), array('orderspackage_id' => $orderpackage_id));
        else {
          $sesbusiness->is_approved = 0;
          $sesbusiness->package_id = $package_id;
          $sesbusiness->save();
        }
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => true,
          'parentRefresh' => true,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('Business Package changed successfully.'))
      ));
    }
  }

}
