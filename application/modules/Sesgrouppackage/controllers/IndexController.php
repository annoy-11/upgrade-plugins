<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppackage
 * @package    Sesgrouppackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgrouppackage_IndexController extends Core_Controller_Action_Standard {

  public function indexAction() {
    $this->view->someVar = 'someVal';
  }

  public function cancelAction() {
    $packageId = $this->_getParam('package_id', 0);

    $this->view->form = $form = new Sesgrouppackage_Form_Cancel();

    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    
    Engine_Api::_()->getDbTable('packages','sesgrouppackage')->cancelSubscription(array('package_id' => $packageId));

    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your Package Subscription has been Deleted Successfully.'))
    ));
  }

  public function groupAction() {
    if (!$this->_helper->requireUser->isValid())
      return;
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->package = $packageMemberLevel = Engine_Api::_()->getDbTable('packages', 'sesgrouppackage')->getPackage(array('member_level' => $viewer->level_id, 'enabled' => 0));
    if (!count($packageMemberLevel) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppackage.enable.package', 0))
      return $this->_helper->redirector->gotoRoute(array('action' => 'create'), 'sesgroup_general', true);

    $this->view->existingleftpackages = $existingleftpackages = Engine_Api::_()->getDbTable('orderspackages', 'sesgrouppackage')->getLeftPackages(array('owner_id' => $viewer->getIdentity()));

    //this->_helper->content->setEnabled();
  }

  public function confirmUpgradeAction() {
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $group_id = $this->_getParam('group_id', false);
    $package_id = $this->_getParam('package_id', false);
    if (!$group_id || !$package_id)
      return $this->_forward('notfound', 'error', 'core');
    $sesgroup = Engine_Api::_()->getItem('sesgroup_group', $group_id);
    $package = Engine_Api::_()->getItem('sesgrouppackage_package', $package_id);
    if (!$sesgroup || !$package || $sesgroup->package_id == $package_id)
      return $this->_forward('notfound', 'error', 'core');

    $this->view->form = $form = new Sesgrouppackage_Form_Confirm();

    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    $validPackage = Engine_Api::_()->getDbTable('packages', 'sesgrouppackage')->getPackage(array('member_level' => $viewer->level_id, 'show_upgrade' => 1, 'package_id' => $package_id));
    if (empty($package->enabled) || !$validPackage)
      return $this->_forward('notfound', 'error', 'core');
    $tableGroup = Engine_Api::_()->getDbTable('groups', 'sesgroup');
    if ($this->getRequest()->getPost()) {
      $orderpackage_id = $sesgroup->orderspackage_id;
      if (empty($sesgroup->transaction_id)) {
        //get transaction id
        $select = $tableGroup->select()->where('transaction_id !=?', '')->where('orderspackage_id =?', $sesgroup->orderspackage_id);
        $transactionGroup = $tableGroup->fetchRow($select);
        if ($transactionGroup)
          $transaction = Engine_Api::_()->getItem('sesgrouppackage_transaction', $transactionGroup->transaction_id);
        else
          $transaction = '';
      }else {
        $transaction = Engine_Api::_()->getItem('sesgrouppackage_transaction', $sesgroup->transaction_id);
          $transactionGroup = $sesgroup;
      }
      if ($transactionGroup) {
        $transactionGroup->cancel();
        $tableGroup->update(array('transaction_id' => '', 'package_id' => $package_id), array('orderspackage_id' => $orderpackage_id));
        if ($transaction) {
          $tableGroup->update(array('transaction_id' => '', 'package_id' => $package_id), array('orderspackage_id' => $orderpackage_id));
          $transaction->delete();
        }
      }
      if ($package->isFree()) {
        if (!empty($orderpackage_id))
          $tableGroup->update(array('transaction_id' => '', 'package_id' => $package_id, 'is_approved' => 1), array('orderspackage_id' => $orderpackage_id));
        else {
          $sesgroup->is_approved = 1;
          $sesgroup->package_id = $package_id;
          $sesgroup->save();
        }
      } else {
        if (!empty($orderpackage_id))
          $tableGroup->update(array('transaction_id' => '', 'package_id' => $package_id, 'is_approved' => 0), array('orderspackage_id' => $orderpackage_id));
        else {
          $sesgroup->is_approved = 0;
          $sesgroup->package_id = $package_id;
          $sesgroup->save();
        }
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => true,
          'parentRefresh' => true,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('Group Package changed successfully.'))
      ));
    }
  }

}
