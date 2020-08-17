<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesprofilefield_admin_main', array(), 'sesprofilefield_admin_global');

    $table_exist = $db->query('SHOW TABLES LIKE \'engine4_sesprofilefield_authorities\'')->fetch();
    if($table_exist) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesprofilefield.pluginactivated', 1);
    }

    $this->view->form = $form = new Sesprofilefield_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
        $values = $form->getValues();
        include_once APPLICATION_PATH . "/application/modules/Sesprofilefield/controllers/License.php";
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilefield.pluginactivated')) {
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
