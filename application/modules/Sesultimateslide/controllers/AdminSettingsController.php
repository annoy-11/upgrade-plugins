<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesultimateslide
 * @package Sesultimateslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: AdminSettingsController.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
class Sesultimateslide_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesultimateslide_admin_main', array(), 'sesultimateslide_admin_main_settings');

    $this->view->form = $form = new Sesultimateslide_Form_Admin_Global();

    if( $this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesultimateslide/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesultimateslide.pluginactivated')) {
        foreach ($values as $key => $value){
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
}
