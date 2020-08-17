<?php

class Sesgroupalbum_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupalbum.pluginactivated')) {
    include_once APPLICATION_PATH . "/application/modules/Sesgroupalbum/controllers/defaultsettings.php";
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sesgroupalbum.pluginactivated', 1);
    }
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroupalbum_admin_main', array(), 'sesgroupalbum_admin_main_settings');
    
    $this->view->form = $form = new Sesgroupalbum_Form_Admin_Global();
    
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
     // if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupalbum.pluginactivated')) {
      if (1) {
        foreach ($values as $key => $value) {
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function flushPhotoAction() {
    $dbObject = Engine_Db_Table::getDefaultAdapter();
    $dbObject->query('DELETE  FROM `engine4_group_photos` WHERE (album_id =0) AND (DATE(NOW()) != DATE(creation_date))');
    header('location:' . $_SERVER['HTTP_REFERER']);
  }
}