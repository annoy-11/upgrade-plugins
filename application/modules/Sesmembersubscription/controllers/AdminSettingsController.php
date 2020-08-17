<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembersubscription
 * @package    Sesmembersubscription
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2017-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembersubscription_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmembersubscription_admin_main', array(), 'sesmembersubscription_admin_main_settings');

    $this->view->form = $form = new Sesmembersubscription_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      unset($values['defaulttext']);
      include_once APPLICATION_PATH . "/application/modules/Sesmembersubscription/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembersubscription.pluginactivated')) {
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