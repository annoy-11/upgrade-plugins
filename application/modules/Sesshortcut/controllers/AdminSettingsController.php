<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshortcut
 * @package    Sesshortcut
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesshortcut_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesshortcut_admin_main', array(), 'sesshortcut_admin_main_settings');

    $this->view->form = $form = new Sesshortcut_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      unset($values['defaulttext']);
      include_once APPLICATION_PATH . "/application/modules/Sesshortcut/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.pluginactivated')) {
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