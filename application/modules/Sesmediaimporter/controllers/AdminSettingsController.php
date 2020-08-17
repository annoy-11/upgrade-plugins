<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesmediaimporter_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmediaimporter_admin_main', array(), 'sesmediaimporter_admin_main_settings');
    
    $this->view->form = $form = new Sesmediaimporter_Form_Admin_General();
    
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesmediaimporter/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.pluginactivated')) {
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
  public function facebookAction()
  {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmediaimporter_admin_main', array(), 'sesmediaimporter_admin_main_facebook');
    
    $form = $this->view->form = new Sesmediaimporter_Form_Admin_Facebook();
    $form->populate((array) Engine_Api::_()->getApi('settings', 'core')->sesmediaimporter_facebook);

    if( _ENGINE_ADMIN_NEUTER ) {
      $form->populate(array(
        'appid' => '******',
        'secret' => '******',
      ));
    }
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    
    $values = $form->getValues();
    if( empty($values['appid']) || empty($values['secret']) ) {
      $values['appid'] = '';
      $values['secret'] = '';
      $values['enable'] = 'none';
    }else{
      $values['enable'] = "publish";  
    }

    Engine_Api::_()->getApi('settings', 'core')->sesmediaimporter_facebook = $values;
    $form->addNotice('Your changes have been saved.');
    $form->populate($values);
  }
  public function instagramAction() {
  
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmediaimporter_admin_main', array(), 'sesmediaimporter_admin_main_instagram');
     $this->view->form = $form = new Sesmediaimporter_Form_Admin_Instagram();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
       foreach ($values as $key => $value) {
          if($value != '')
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        
    }
  }
  
  public function flickrAction(){
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmediaimporter_admin_main', array(), 'sesmediaimporter_admin_main_flickr');
     $this->view->form = $form = new Sesmediaimporter_Form_Admin_Flickr();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
       foreach ($values as $key => $value) {
          if($value != '')
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        
    }
  }
  public function px500Action(){
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmediaimporter_admin_main', array(), 'sesmediaimporter_admin_main_500px');
     $this->view->form = $form = new Sesmediaimporter_Form_Admin_500px();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
       foreach ($values as $key => $value) {
          if($value != '')
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        
    }
  }
   public function googleAction(){
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmediaimporter_admin_main', array(), 'sesmediaimporter_admin_main_google');
     $this->view->form = $form = new Sesmediaimporter_Form_Admin_Google();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
       foreach ($values as $key => $value) {
          if($value != '')
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        
    }
  }
}