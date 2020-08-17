<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageveroth
 * @package    Sespageveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageveroth_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_sespageveroth');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespageveroth_admin_main', array(), 'sespageveroth_admin_main_settings');


    $this->view->form = $form = new Sespageveroth_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      unset($values['defaulttext']);
      include_once APPLICATION_PATH . "/application/modules/Sespageveroth/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageveroth.pluginactivated')) {
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

  public function statisticAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_sespageveroth');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespageveroth_admin_main', array(), 'sespageveroth_admin_main_statistic');

    $this->view->allverifiers = Engine_Api::_()->getDbTable('verifications', 'sespageveroth')->getAllUserVerificationRequests('', 'verifiers');


    $this->view->allverifications = Engine_Api::_()->getDbTable('verifications', 'sespageveroth')->getAllUserVerificationRequests();
  }
}
