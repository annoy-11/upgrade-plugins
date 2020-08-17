<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventpdfticket
 * @package    Seseventpdfticket
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2016-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventpdfticket_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesevent_admin_main', array(), 'sesevent_admin_main_seseventpdfticket');    
    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventpdfticket_admin_main', array(), 'seseventpdfticket_admin_main_settings');
    
    $this->view->form = $form = new Seseventpdfticket_Form_Admin_Settings_Global();
    
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
    
      include_once APPLICATION_PATH . "/application/modules/Seseventpdfticket/controllers/License.php";
      
      $values = $form->getValues();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventpdfticket.pluginactivated')) {
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