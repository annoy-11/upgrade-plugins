<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestwitterclone_AdminManageController extends Core_Controller_Action_Admin {

  public function headerAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestwitterclone_admin_main', array(), 'sestwitterclone_admin_main_header');

    $this->view->form = $form = new Sestwitterclone_Form_Admin_HeaderSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();

      if (isset($values['sestwitterclone_headernonloggedinoptions']))
        $values['sestwitterclone_headernonloggedinoptions'] = serialize($values['sestwitterclone_headernonloggedinoptions']);
      else
        $values['sestwitterclone_headernonloggedinoptions'] = serialize(array());

      if (isset($values['sestwitterclone_headerloggedinoptions']))
        $values['sestwitterclone_headerloggedinoptions'] = serialize($values['sestwitterclone_headerloggedinoptions']);
      else
        $values['sestwitterclone_headerloggedinoptions'] = serialize(array());

      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function landingpageAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestwitterclone_admin_main', array(), 'sestwitterclone_admin_main_landingpage');

    $this->view->form = $form = new Sestwitterclone_Form_Admin_LandingPageSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();

      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }
}
