<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_settings');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sespagebuilder/controllers/License.php";
      $setting = Engine_Api::_()->getApi('settings', 'core');
      if ($setting->getSetting('sespagebuilder.pluginactivated') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagebuilder.showpages')) {
        foreach ($values as $key => $value)
          $setting->setSetting($key, $value);
        $form->addNotice('Your changes have been saved.');
        if($error)
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

}
