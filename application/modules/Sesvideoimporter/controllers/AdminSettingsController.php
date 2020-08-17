<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesvideoimporter
 * @package    Sesvideoimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2016-04-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesvideoimporter_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('videoimporter_admin_main', array(), 'videoimporter_admin_main_settings');
    $this->view->form = $form = new Sesvideoimporter_Form_Admin_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesvideoimporter/controllers/License.php";
      $db->query("INSERT IGNORE INTO `engine4_sesvideoimporter_imports` (`type`, `page_number`, `creation_date`, `modified_date`) VALUES ('xtube', '0', NOW(), NOW());");
			if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesvideoimporter.pluginactivated')) {
        foreach ($values as $key => $value) {
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        //$this->_helper->redirector->gotoRoute(array());
      }
    }
  }
}
