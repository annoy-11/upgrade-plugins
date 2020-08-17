<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_AdminSettingsController extends Core_Controller_Action_Admin {

    public function indexAction() {

        $db = Engine_Db_Table::getDefaultAdapter();

        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_settings');

        $this->view->form = $form = new Sesautoaction_Form_Admin_Settings_Global();

        if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
        $values = $form->getValues();
        unset($values['defaulttext']);
        include_once APPLICATION_PATH . "/application/modules/Sesautoaction/controllers/License.php";
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesautoaction.pluginactivated')) {
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
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesautoaction_admin_main', array(), 'sesautoaction_admin_main_support');
    }
}
