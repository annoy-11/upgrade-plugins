<?php

class Ecoupon_Form_Edit extends Ecoupon_Form_Create {
  public function init() {
    parent::init();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->setTitle('Edit Coupon')
            ->setDescription("Edit your coupon's details below, then click 'Save Changes' to publish it on your Page.");
     $this->submit->setLabel("Save Changes");
  }
}
?>
