<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinviter
 * @package    Sesinviter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2017-05-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinviter_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesinviter_admin_main', array(), 'sesinviter_admin_main_settings');

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sesinviter_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();

      if (isset($values['sesinviter_socialmediaoptions']))
        $values['sesinviter_socialmediaoptions'] = serialize($values['sesinviter_socialmediaoptions']);
      else
        $values['sesinviter_socialmediaoptions'] = serialize(array());

      include_once APPLICATION_PATH . "/application/modules/Sesinviter/controllers/License.php";
      if ($settings->getSetting('sesinviter.pluginactivated')) {


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

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesinviter_admin_main', array(), 'sesinviter_admin_main_managewidgetizepage');
    $this->view->pagesArray = array('sesinviter_index_invite', 'sesinviter_index_manage', 'sesinviter_index_manage-referrals');
  }

  public function socialMediaKeyAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesinviter_admin_main', array(), 'sesinviter_admin_main_managesocialmedia');
    $this->view->form = $form = new Sesinviter_Form_Admin_SocialMediaKeys();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['sesinviter_facebook']);
      unset($values['sesinviter_twitter']);
      unset($values['sesinviter_hotmail']);
      unset($values['sesinviter_yahoo']);
      unset($values['sesinviter_gmail']);
       foreach ($values as $key => $value) {
          //if($value != '')
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
    }
  }
}
