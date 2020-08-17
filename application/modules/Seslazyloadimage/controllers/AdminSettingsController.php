<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslazyloadimage
 * @package    Seslazyloadimage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-02-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslazyloadimage_AdminSettingsController extends Core_Controller_Action_Admin {

    public function indexAction() {

        $db = Engine_Db_Table::getDefaultAdapter();

        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslazyloadimage_admin_main', array(), 'seslazyloadimage_admin_main_settings');

        $this->view->form = $form = new Seslazyloadimage_Form_Admin_Global();

        if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
            $values = $form->getValues();
            foreach ($values as $key => $value) {
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
            }
            $form->addNotice('Your changes have been saved.');
            if($error)
            $this->_helper->redirector->gotoRoute(array());
        }
    }

    public function supportAction() {
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslazyloadimage_admin_main', array(), 'seslazyloadimage_admin_main_support');
    }
}
