<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmenu_AdminSettingsController extends Core_Controller_Action_Admin
{
  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmenu_admin_main', array(), 'sesmenu_admin_main_settings');

    $table_exist = $db->query('SHOW TABLES LIKE \'engine4_sesmenu_menuitems\'')->fetch();
    if($table_exist) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesmenu.pluginactivated', 1);
    }

    $this->view->form = $form = new Sesmenu_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
        $values = $form->getValues();
        include_once APPLICATION_PATH . "/application/modules/Sesmenu/controllers/License.php";
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmenu.pluginactivated')) {
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
  
    public function sinkMenusAction() {

      $param = $this->_getParam('param', 0);
      $db = Engine_Db_Table::getDefaultAdapter();
      $menuItemsTable = Engine_Api::_()->getDbtable('menuItems', 'core');
      $select = $menuItemsTable->select()
        ->where("id  NOT IN ( Select id from engine4_sesmenu_menuitems) and menu='core_main'");
        $result = $menuItemsTable->fetchAll($select);

        if(count($result) > 0) {
           foreach($result as $id)
            {

                $db->query("INSERT IGNORE INTO `engine4_sesmenu_menuitems`(`id`, `name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) select `id`, `name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order` from `engine4_core_menuitems` where `menu`='core_main' and id=$id->id");
            }
        }
        if($param == 1) {
            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh'=> 10,
                'messages' => array('')
            ));
        } else {
            $this->_redirect('admin');
        }
    }
}
