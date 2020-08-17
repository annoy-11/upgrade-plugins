<?php
class Ecoupon_AdminCouponController extends Core_Controller_Action_Admin {
  public function indexAction() {
    
  }
  public function createAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('ecoupon_admin_main', array(), 'ecoupon_admin_main_create');
    $this->view->form = $form = new Ecoupon_Form_Admin_Coupon_Create();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $viewer = $this->view->viewer();
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $couponTable = Engine_Api::_()->getDbtable('coupons', 'ecoupon');
      $values = $form->getValues();
      $result = $couponTable->isAvailable($values['coupon_code']);
      if($result){
        return $form->addError('Coupon Code is not available');
      }
      $db = $couponTable->getAdapter();
      $db->beginTransaction();
      try {
        $couponsRow = $couponTable->createRow();
        $couponsRow->setFromArray($values);
        $couponsRow->owner_id = $viewer->getIdentity();
        $couponsRow->remaining_coupon = $values['count_per_coupon'];
        $couponsRow->save();
        if (!empty($values['photo'])) {
          $couponsRow->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo, false,false,'ecoupon','ecoupon','',$couponsRow,true);
        }
        $couponsRow->save();
        if(!empty($_POST['item_ids']) && isset($_POST['item_ids'])){
          $couponsRow->item_ids = trim($_POST['item_ids'],',');
          $couponsRow->save();
        }
        $db->commit();
      $form->addNotice('Your changes have been saved.');
      } catch (Exception $e) {
        $db->rollBack();
        $error = 1;
      }
      if (@$error)
        $this->_helper->redirector->gotoRoute(array());
      else 
        $this->_redirect('admin/ecoupon/manage');
    }
  } 
  public function editAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('ecoupon_admin_main', array(), 'ecoupon_admin_main_create');
    $coupon_id = $this->_getParam('coupon_id',false);
    $coupon = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
    if(empty($coupon))
      return false;
    $this->view->form = $form = new Ecoupon_Form_Admin_Coupon_Edit();
    $form->populate($coupon->toArray());
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $viewer = $this->view->viewer();
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $values = $form->getValues();
      if($values['coupon_code'] != $coupon->coupon_code){
        $result = $couponTable->isAvailable($values['coupon_code']);
        if($result){
          return $form->addError('Coupon Code is not available');
        }
      }
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $coupon->setFromArray($values);
        $coupon->owner_id = $viewer->getIdentity();
        $coupon->save();
        if (!empty($values['photo'])) {
          $coupon->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo, false,false,'ecoupon','ecoupon','',$coupon,true);
        }
        $coupon->remaining_coupon = $values['count_per_coupon'];
        $coupon->save();
        if(!empty($_POST['item_ids']) && isset($_POST['item_ids'])){
          $couponsRow->item_ids = trim($_POST['item_ids'],',');
          $couponsRow->save();
        }
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        $error = 1;
      }
      $form->addNotice('Your changes have been saved.');
      if (@$error)
        $this->_helper->redirector->gotoRoute(array());
      else 
        $this->_redirect('admin/ecoupon/manage');
    }
  }
}

?>
