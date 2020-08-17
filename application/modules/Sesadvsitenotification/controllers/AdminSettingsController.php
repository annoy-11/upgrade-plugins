<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvsitenotification
 * @package    Sesadvsitenotification
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2017-01-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesadvsitenotification_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesadvsitenotification_admin_main', array(), 'sesadvsitenotification_admin_main_settings');
    
    $this->view->form = $form = new Sesadvsitenotification_Form_Admin_General();
    
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesadvsitenotification/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvsitenotification.pluginactivated')) {
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
}