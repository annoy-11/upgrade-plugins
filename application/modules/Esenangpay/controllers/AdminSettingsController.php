<?php

class Esenangpay_AdminSettingsController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {

    // Make form
    $this->view->form = $form = new Esenangpay_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
    }
  }
}
