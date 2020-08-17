<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmetatag
 * @package    Sesmetatag
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2017-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmetatag_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmetatag_admin_main', array(), 'sesmetatag_admin_main_settings');

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sesmetatag_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesmetatag/controllers/License.php";
      if ($settings->getSetting('sesmetatag.pluginactivated')) {
        foreach ($values as $key => $value) {
          if($key ==  'sesmetatag_nonmeta_photo') {
            if($value == '0')
              $value = 'public/admin/social_share.jpg';
          }
          $settings->setSetting($key, $value);
        }

        //Page Metas sync
        $getAllPages = Engine_Api::_()->getDbtable('managemetatags', 'sesmetatag')->getAllPages();
        $getAllPageIds = array();
        foreach($getAllPages as $getAllPage) {
          $getAllPageIds[] = $getAllPage['page_id'];
        } 
      
        $select = Engine_Api::_()->getDbtable('pages', 'core')->select()->where('custom =?', 0)->where('page_id NOT IN (?)', array('1', '2'));
        if($getAllPageIds) {
          $select->where('page_id NOT IN (?)', $getAllPageIds);
        }
        $results = $select->query()->fetchAll();
        foreach($results as $result) {
          $db->query('INSERT IGNORE INTO `engine4_sesmetatag_managemetatags` (`page_id`, `meta_title`, `meta_description`, `file_id`, `enabled`) VALUES ("'.$result["page_id"].'", "'.htmlentities($result["title"]).'", "'.htmlentities($result["description"]).'", 0, 1);');
        }
        //Page Metas sync

        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }

    }
  }
}