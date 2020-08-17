<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seseventspeaker_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesevent_admin_main', array(), 'sesevent_admin_main_seseventspeaker');    
    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventspeaker_admin_main', array(), 'seseventspeaker_admin_main_settings');
    
    $this->view->form = $form = new Seseventspeaker_Form_Admin_Global();
    
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
    
      include_once APPLICATION_PATH . "/application/modules/Seseventspeaker/controllers/License.php";
      
      $values = $form->getValues();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventspeaker.pluginactivated')) {
        foreach ($values as $key => $value) {
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
}