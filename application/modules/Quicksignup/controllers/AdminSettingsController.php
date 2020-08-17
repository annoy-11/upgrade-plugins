<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Quicksignup_AdminSettingsController extends Core_Controller_Action_Admin {

    public function indexAction() {

        $db = Engine_Db_Table::getDefaultAdapter();
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('quicksignup_admin_main', array(), 'quicksignup_admin_main_settings');
        $this->view->form = $form = new Quicksignup_Form_Admin_Global();

        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            $values = $form->getValues();
            include_once APPLICATION_PATH . "/application/modules/Quicksignup/controllers/License.php";
            if (Engine_Api::_()->getApi('settings', 'core')->getSetting('quicksignup.pluginactivated')) {
                foreach ($values as $key => $value){
                    if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key))
                        Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
                    Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
                }
                $form->addNotice('Your changes have been saved.');
                if($error)
                    $this->_helper->redirector->gotoRoute(array());
            }
        }
    }

    function manageFieldsAction(){
        if(!empty($_POST['order'])){
            $counter = 1;
            $table = Engine_Api::_()->getDbTable('enablefields','quicksignup');
            foreach($_POST['order'] as $order){
                $item = $table->find($order)->current();
                if(!$item)
                    continue;
                $counter = $counter*10;
                $item->order = $counter;
                $item->save();
                //$counter++;
            }
        }
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('quicksignup_admin_main', array(), 'quicksignup_admin_main_fields');
        $table = Engine_Api::_()->getDbTable('enablefields','quicksignup');
        $this->view->paginator = $table->fetchAll($table->select()->order('order ASC'));
    }

    function enableAction(){
        $id = $this->_getParam('id','');
        if($id){
            $table = Engine_Api::_()->getDbTable('enablefields','quicksignup');
            $item = $table->find($id)->current();
            $item->display = !$item->display;
            $item->save();
        }
        header('Location:'.$_SERVER["HTTP_REFERER"]);
    }
}
