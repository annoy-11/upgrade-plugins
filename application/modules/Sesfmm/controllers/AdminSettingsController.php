<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfmm_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfmm_admin_main', array(), 'sesfmm_admin_main_settings');
    $this->view->form  = $form = new Sesfmm_Form_Admin_Global();
    if( $this->getRequest()->isPost() && $form->isValid($this->_getAllParams()) ) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesfmm/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfmm.pluginactivated')) {
        foreach ($values as $key => $value){
          if (Engine_Api::_()->getApi('settings', 'core')->hasSetting($key, $value))
              Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
          if (!$value && strlen($value) == 0)
              continue;
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
}
