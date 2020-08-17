<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespageoffer_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_sespageoffer');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespageoffer_admin_main', array(), 'sespageoffer_admin_main_settings');

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sespageoffer_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sespageoffer/controllers/License.php";
      if ($settings->getSetting('sespageoffer.pluginactivated')) {
        foreach ($values as $key => $value) {
          $settings->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function manageWidgetizePageAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_sespageoffer');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespageoffer_admin_main', array(), 'sespageoffer_admin_main_managewidgetizepage');

    $pagesArray = array('sespageoffer_index_browse','sespageoffer_index_home','sespageoffer_index_create','sespageoffer_index_edit','sespageoffer_index_view');
    $this->view->pagesArray = $pagesArray;
  }
}
