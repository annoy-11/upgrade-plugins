<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seschristmas_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seschristmas_admin_main', array(), 'seschristmas_admin_main_settings');

    $this->view->form = $sesform = new Seschristmas_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $sesform->isValid($this->getRequest()->getPost())) {

      $sesvalues = $sesform->getValues();
      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.pluginactivated')) {
        $sesvalues['seschristmas_wish'] = 1;
        $sesvalues['seschristmas_template'] = 0;
        $sesvalues['seschristmas_template1'] = array('header_before', 'header_after', 'footer_before', 'footer_after');
        $sesvalues['seschristmas_template2'] = array('header_before', 'left_right_bell', 'footer_before');
        $sesvalues['seschristmas_snoweffect'] = 1;
        $sesvalues['seschristmas_snowimages'] = 1;
        $sesvalues['seschristmas_snowquantity'] = 30;
        $sesvalues['seschristmas_wisheslimit'] = 20;
        $sesvalues['seschristmas_showviewmore'] = 2;
      }

      include_once APPLICATION_PATH . "/application/modules/Seschristmas/controllers/License.php";

      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.pluginactivated')) {

        //Update wishes link in main menu.
        $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '" . $sesvalues['seschristmas_wish'] . "' WHERE `engine4_core_menuitems`.`name` = 'core_main_seschristmas' LIMIT 1 ;");

        if (!empty($sesvalues['seschristmas_snoweffect'])) {
          $select = new Zend_Db_Select($db);
          $select
                  ->from('engine4_core_content', 'content_id')
                  ->where('page_id = ?', 2)
                  ->where('name = ?', 'main')
                  ->limit(1);
          $info = $select->query()->fetch();
          $select = new Zend_Db_Select($db);
          $select
                  ->from('engine4_core_content', 'content_id')
                  ->where('type = ?', 'widget')
                  ->where('name = ?', 'seschristmas.welcome')
                  ->limit(1);
          $welcome = $select->query()->fetch();
          if ($info && !$welcome) {
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'seschristmas.welcome',
                'parent_content_id' => $info['content_id'],
                'page_id' => 2,
                'order' => 999,
            ));
          }
        } else {
          $db->query("DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`name` = 'seschristmas.welcome' AND `engine4_core_content`.`page_id` = 2;");
        }


        if (isset($sesvalues['seschristmas_template1'])) {
          $sesvalues['seschristmas_template1'] = serialize($sesvalues['seschristmas_template1']);
        } else {
          $sesvalues['seschristmas_template1'] = serialize(array());
        }

        if (isset($sesvalues['seschristmas_template2'])) {
          $sesvalues['seschristmas_template2'] = serialize($sesvalues['seschristmas_template2']);
        } else {
          $sesvalues['seschristmas_template2'] = serialize(array());
        }

        foreach ($sesvalues as $key => $value) {
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }

        $sesform->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function contactUsAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seschristmas_admin_main', array(), 'seschristmas_admin_main_contact');
  }

  public function welcomeAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seschristmas_admin_main', array(), 'seschristmas_admin_main_welcome');

    $this->view->form = $sesform = new Seschristmas_Form_Admin_Welcome();

    if ($this->getRequest()->isPost() && $sesform->isValid($this->getRequest()->getPost())) {

      $sesvalues = $sesform->getValues();

      foreach ($sesvalues as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }

      $sesform->addNotice('Your changes have been saved.');
    }
  }

}