<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesminify
 * @package    Sesminify
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2017-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesminify_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $db = Engine_Db_Table::getDefaultAdapter();    
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesminify_admin_main', array(), 'sesminifyadmin_admin_main_settings');
    
    $this->view->form = $form = new Sesminify_Form_Admin_Settings_General();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      unset($values['defaulttext']);
      include_once APPLICATION_PATH . "/application/modules/Sesminify/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesminify.pluginactivated')) {
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
  
  public function ignoreAction(){
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesminify_admin_main', array(), 'sesminifyadmin_admin_main_ignore');    
    $this->view->form = $form = new Sesminify_Form_Admin_Settings_Ignorejs();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        $values = $form->getValues();
        $db = Engine_Db_Table::getDefaultAdapter();;
        foreach ($values as $key => $value) {
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
    }
  }
  public function ignorecssAction(){
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesminify_admin_main', array(), 'sesminifyadmin_admin_main_ignorecss');    
    $this->view->form = $form = new Sesminify_Form_Admin_Settings_Ignorecss();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        $values = $form->getValues();
        $db = Engine_Db_Table::getDefaultAdapter();;
        foreach ($values as $key => $value) {
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
    }
  }
  public function gzipAction(){
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesminify_admin_main', array(), 'sesminifyadmin_admin_main_gzipcompression'); 
    $this->view->staticURL =  Zend_Registry::get('StaticBaseUrl');
    
  }
}