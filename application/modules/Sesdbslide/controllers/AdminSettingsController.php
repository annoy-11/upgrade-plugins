<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesdbslide
 * @package Sesdbslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: AdminSettingsController.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
class Sesdbslide_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesdbslide_admin_main', array(), 'sesdbslide_admin_main_settings');

    $this->view->form = $form = new Sesdbslide_Form_Admin_Global();

    if( $this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesdbslide/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdbslide.pluginactivated')) {
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
