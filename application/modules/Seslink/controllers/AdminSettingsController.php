<?php


class Seslink_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslink_admin_main', array(), 'seslink_admin_main_settings');

    $this->view->form = $form = new Seslink_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Seslink/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seslink.pluginactivated')) {

        foreach ($values as $key => $value) {
          if($value != '') 
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
  
  public function manageWidgetizePageAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslink_admin_main', array(), 'seslink_admin_main_managepages');

    $this->view->pagesArray = array('seslink_index_index', 'seslink_index_manage', 'seslink_index_view', 'seslink_index_create');
  }
}