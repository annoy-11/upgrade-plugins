<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminManageController.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_AdminManageController extends Core_Controller_Action_Admin {

  public function headerAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('einstaclone_admin_main', array(), 'einstaclone_admin_main_header');

    $this->view->form = $form = new Einstaclone_Form_Admin_HeaderSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();

      if (isset($values['einstaclone_headernonloggedinoptions']))
        $values['einstaclone_headernonloggedinoptions'] = serialize($values['einstaclone_headernonloggedinoptions']);
      else
        $values['einstaclone_headernonloggedinoptions'] = serialize(array());

      if (isset($values['einstaclone_headerloggedinoptions']))
        $values['einstaclone_headerloggedinoptions'] = serialize($values['einstaclone_headerloggedinoptions']);
      else
        $values['einstaclone_headerloggedinoptions'] = serialize(array());

      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function landingpageAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('einstaclone_admin_main', array(), 'einstaclone_admin_main_landingpage');

    $this->view->form = $form = new Einstaclone_Form_Admin_LandingPageSettings();

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
