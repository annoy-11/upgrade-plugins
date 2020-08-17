<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesconstpackage
 * @package    Sesconstpackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-09-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesconstpackage_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesconstpackage_admin_main', array(), 'sesconstpackage_admin_main_settings');

    $this->view->form = $form = new Sesconstpackage_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
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
