<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdemouser_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesdemouser_admin_main', array(), 'sesdemouser_admin_main_settings');

    $this->view->form = $form = new Sesdemouser_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesdemouser/controllers/License.php";
      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdemouser.pluginactivated')) {
	      foreach ($values as $key => $value) {
	        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
	      }

	      $form->addNotice('Your changes have been saved.');
	      $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

}
