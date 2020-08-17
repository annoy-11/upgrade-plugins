<?php

class Sessubscribeuser_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessubscribeuser_admin_main', array(), 'sessubscribeuser_admin_main_settings');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sessubscribeuser_Form_Admin_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      foreach ($values as $key => $value) {
        $settings->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }
}