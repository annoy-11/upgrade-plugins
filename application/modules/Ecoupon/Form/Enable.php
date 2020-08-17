<?php

class Ecoupon_Form_Enable extends Engine_Form {
  public function init() {
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->setTitle('Enable Coupon')
            ->setDescription("Enable your coupon's details below, then click 'Save Changes' to publish it on your Page.");
    $this->addElement('Button', 'submit', array(
        'label' => $view->translate('Save Change'),
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
  }
}
?>
