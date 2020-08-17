<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestweet
 * @package    Sestweet
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2017-05-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestweet_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestweet_admin_main', array(), 'sestweet_admin_main_settings');

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sestweet_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sestweet/controllers/License.php";
      Engine_Api::_()->sestweet()->tweetCodeInViewHelper();
      Engine_Api::_()->sestweet()->tweetCode();
      if ($settings->getSetting('sestweet.pluginactivated')) {
        foreach ($values as $key => $value) {
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
  
  public function codewriteAction() {
    Engine_Api::_()->sestweet()->tweetCodeInViewHelper();
    Engine_Api::_()->sestweet()->tweetCode();
    $this->_redirect('admin/sestweet/settings/faq');
  }
  
  public function faqAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestweet_admin_main', array(), 'sestweet_admin_main_faq');
  }
}
