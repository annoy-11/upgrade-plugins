<?php

class Sesvideosell_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesvideosell_admin_main', array(), 'sesvideosell_admin_main_settings');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sesvideosell_Form_Admin_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesvideosell/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesvideosell.pluginactivated')) {
        foreach ($values as $key => $value) {
          $settings->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
}