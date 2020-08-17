<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmemveroth_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmemveroth_admin_main', array(), 'sesmemveroth_admin_main_settings');

    $this->view->form = $form = new Sesmemveroth_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      unset($values['defaulttext']);
      include_once APPLICATION_PATH . "/application/modules/Sesmemveroth/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmemveroth.pluginactivated')) {
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
    public function supportAction() {

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmemveroth_admin_main', array(), 'sesmemveroth_admin_main_support');

    }
  public function statisticAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmemveroth_admin_main', array(), 'sesmemveroth_admin_main_statistic');

    $this->view->allverifiers = Engine_Api::_()->getDbTable('verifications', 'sesmemveroth')->getAllUserVerificationRequests('', 'verifiers');


    $this->view->allverifications = Engine_Api::_()->getDbTable('verifications', 'sesmemveroth')->getAllUserVerificationRequests();



  }
}
