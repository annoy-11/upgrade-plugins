<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Emailtemplates_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('emailtemplates_admin_main', array(), 'emailtemplates_admin_main_settings');
    
    $table_exist = $db->query('SHOW TABLES LIKE \'engine4_emailtemplates_templates\'')->fetch();
    if($table_exist) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('emailtemplates.pluginactivated', 1);
    }
    
    $this->view->form = $form = new Emailtemplates_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
        $values = $form->getValues();
        unset($values['defaulttext']);
        include_once APPLICATION_PATH . "/application/modules/Emailtemplates/controllers/License.php";
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('emailtemplates.pluginactivated')) {
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
