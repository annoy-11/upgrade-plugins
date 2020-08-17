<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserdocverification_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesuserdocverion_admin_main', array(), 'sesuserdocverification_admin_main_settings');
    
    $table_exist = $db->query('SHOW TABLES LIKE \'engine4_sesuserdocverification_documents\'')->fetch();
    if($table_exist) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesuserdocverification.pluginactivated', 1);
    }

    $this->view->form = $form = new Sesuserdocverification_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
    
      $values = $form->getValues();
      
      if (isset($values['sesuserdocverification_extension']))
        $values['sesuserdocverification_extension'] = serialize($values['sesuserdocverification_extension']);
      else
        $values['sesuserdocverification_extension'] = serialize(array());
        
      include_once APPLICATION_PATH . "/application/modules/Sesuserdocverification/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.pluginactivated')) {
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

  public function supportAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesuserdocverion_admin_main', array(), 'sesuserdocverification_admin_main_support');

  }
}
