<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminSettingsController.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Emessages_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('emessages_admin_main', array(), 'emessages_admin_main_settings');

    $this->view->form = $form = new Emessages_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Emessages/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('emessages.pluginactivated')) {
        foreach ($values as $key => $value) {
          if (Engine_Api::_()->getApi('settings', 'core')->hasSetting($key, $value))
            Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
          if (!$value && strlen($value) == 0)
            continue;
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  function helpAction(){
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('emessages_admin_main', array(), 'emessages_admin_main_help');

  }
}
