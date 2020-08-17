<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_AdminSettingsController extends Core_Controller_Action_Admin {

    public function indexAction() {

        $db = Engine_Db_Table::getDefaultAdapter();

        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslike_admin_main', array(), 'seslike_admin_main_settings');

        $this->view->form = $form = new Seslike_Form_Admin_Settings_Global();

        if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
            $values = $form->getValues();

            //before activation
            if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslike.pluginactivated') && !empty($values['seslike_userlike'])) {
                $db->query('INSERT IGNORE INTO engine4_seslike_mylikesettings (`user_id`) SELECT `user_id` FROM engine4_users;');
                if(!empty($values['seslike_bydefaultuserlike'])) {
                    $db->query('UPDATE `engine4_seslike_mylikesettings` SET `mylikesetting` = "'.$values['seslike_bydefaultuserlike'].'"');
                }
            }

            foreach ($values as $key => $value) {
                if($value != '')
                    Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
            }
            $form->addNotice('Your changes have been saved.');
        }
    }

    public function manageWidgetizePageAction() {

        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslike_admin_main', array(), 'seslike_admin_main_managepages');

        $this->view->pagesArray = array('seslike_index_home', 'seslike_index_mylikes', 'seslike_index_wholikeme', 'seslike_index_mycontentlike', 'seslike_index_myfriendslike', 'seslike_index_mylikesettings');
    }

    public function supportAction() {
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslike_admin_main', array(), 'seslike_admin_main_support');
    }
}
