<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupteam
 * @package    Sesgroupteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroupteam_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroup_admin_main', array(), 'sesgroup_admin_main_sesgroupteam');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroupteam_admin_main', array(), 'sesgroupteam_admin_main_settings');

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sesgroupteam_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesgroupteam/controllers/License.php";
      if ($settings->getSetting('sesgroupteam.pluginactivated')) {
        foreach ($values as $key => $value) {
          $settings->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
}
