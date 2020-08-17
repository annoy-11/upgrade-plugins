<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvpoll_AdminSettingsController extends Core_Controller_Action_Admin{

    public function indexAction() {

        $db = Engine_Db_Table::getDefaultAdapter();

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesadvpoll_admin_main', array(), 'sesadvpoll_admin_main_settings');

        $this->view->form = $form = new Sesadvpoll_Form_Admin_Settings_Global();

        $settings = Engine_Api::_()->getApi('settings', 'core');

        if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
            $values = $form->getValues();
            include_once APPLICATION_PATH . "/application/modules/Sesadvpoll/controllers/License.php";
            if ($settings->getSetting('sesadvpoll.pluginactivated')) {
                $db = Engine_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $values = $form->getValues();
                    $settings->sesadvpoll = $values;
                    $db->commit();
                } catch( Exception $e ) {
                    $db->rollback();
                    throw $e;
                }
                $form->addNotice('Your changes have been saved.');
                if($error)
                    $this->_helper->redirector->gotoRoute(array());
            }
        }
    }

    public function manageWidgetizePageAction() {

        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesadvpoll_admin_main', array(), 'sesadvpoll_admin_main_managepages');

        $this->view->pagesArray = array('sesadvpoll_index_create', 'sesadvpoll_poll_edit', 'sesadvpoll_index_browse', 'sesadvpoll_index_home', 'sesadvpoll_poll_view', 'sesadvpoll_index_manage');
    }


    public function levelAction(){

        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesadvpoll_admin_main', array(), 'sesadvpoll_admin_main_level');

        // Get level id
        if( null !== ($id = $this->_getParam('id')) ) {
            $level = Engine_Api::_()->getItem('authorization_level', $id);
        } else {
            $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
        }

        if( !$level instanceof Authorization_Model_Level ) {
            throw new Engine_Exception('missing level');
        }
        $level_id = $id = $level->level_id;

        // Make form
        $this->view->form = $form = new Sesadvpoll_Form_Admin_Settings_Level(array(
            'public' => ( in_array($level->type, array('public')) ),
            'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
        ));
        $form->level_id->setValue($id);

        // Populate values
        $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
        $form->populate($permissionsTable->getAllowed('sesadvpoll_poll', $id, array_keys($form->getValues())));

        // Check post
        if( !$this->getRequest()->isPost() ) {
            return;
        }

        // Check validitiy
        if( !$form->isValid($this->getRequest()->getPost()) ) {
            return;
        }

        // Process
        $values = $form->getValues();
        // Form elements with NonBoolean values
        $nonBooleanSettings = $form->nonBooleanFields();
        $db = $permissionsTable->getAdapter();
        $db->beginTransaction();
        try {
            // Set permissions
            $permissionsTable->setAllowed('sesadvpoll_poll', $id, $values, '', $nonBooleanSettings);
            // Commit
            $db->commit();
        } catch( Exception $e ) {
            $db->rollBack();
            throw $e;
        }
        $form->addNotice('Your changes have been saved.');
    }
}
