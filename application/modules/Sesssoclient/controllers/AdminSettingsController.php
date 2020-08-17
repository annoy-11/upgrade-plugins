<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoclient
 * @package    Sesssoclient
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesssoclient_AdminSettingsController extends Core_Controller_Action_Admin {

    public function indexAction() {

        $db = Engine_Db_Table::getDefaultAdapter();

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesssoclient_admin_main', array(), 'sesssoclient_admin_main_settings');

        $this->view->form = $form = new Sesssoclient_Form_Admin_Settings_Global();

        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

            $values = $form->getValues();

            include_once APPLICATION_PATH . "/application/modules/Sesssoclient/controllers/License.php";
            if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesssoclient.pluginactivated')) {
                foreach ($values as $key => $value) {
                    if (Engine_Api::_()->getApi('settings', 'core')->hasSetting($key, $value))
                        Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
                    if (!$value && strlen($value) == 0)
                        continue;
                    Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
                }
                $form->addNotice('Your changes have been saved.');
                if ($error)
                    $this->_helper->redirector->gotoRoute(array());
            }
        }
    }

    function profiletypesAction() {

        $db = Engine_Db_Table::getDefaultAdapter();
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesssoclient_admin_main', array(), 'sesssoclient_admin_main_profiletypes');
        $profiles = $db->query("SELECT * FROM engine4_user_fields_options WHERE field_id = 1")->fetchAll();
        $this->view->profiles = $profiles;
    }
}
