<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epaytm
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminSettingsController.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epaytm_AdminSettingsController extends Core_Controller_Action_Admin {
  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('epaytm_admin_main', array(), 'epaytm_admin_main_settings');
    $this->view->form = $form = new Epaytm_Form_Admin_Settings_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
        $values = $form->getValues();
        include_once APPLICATION_PATH . "/application/modules/Epaytm/controllers/License.php";
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('epaytm.pluginactivated')) {
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
