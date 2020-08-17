<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesletteravatar
 * @package    Sesletteravatar
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2017-12-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesletteravatar_AdminSettingsController extends Core_Controller_Action_Admin {

  public function sinkUserphotosAction() {

    $table = Engine_Api::_()->getItemTable('user');
    $tableName = $table->info('name');
    $select = $table->select()->from($tableName)->where('photo_id =?', 0);
    $users = $table->fetchAll($select);

    foreach($users as $user) {
      $profile_type = Engine_Api::_()->sesletteravatar()->getprofileFieldValue(array('user_id' => $user->getIdentity(), 'field_id' => 1));
      $firstNameFieldId = Engine_Api::_()->sesletteravatar()->getFieldId(array('first_name'), $profile_type);
      $lastNameFieldId = Engine_Api::_()->sesletteravatar()->getFieldId(array('last_name'), $profile_type);
      $firstName = Engine_Api::_()->sesletteravatar()->getprofileFieldValue(array('user_id' => $user->getIdentity(), 'field_id' => $firstNameFieldId));
      $lastName = Engine_Api::_()->sesletteravatar()->getprofileFieldValue(array('user_id' => $user->getIdentity(), 'field_id' => $lastNameFieldId));
      $displayName = $firstName . ' ' . $lastName;
      Engine_Api::_()->sesletteravatar()->letterAvatar($user, $displayName);
    }
    header('location:' . $_SERVER['HTTP_REFERER']);
  }

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesletteravatar_admin_main', array(), 'sesletteravatar_admin_main_settings');

    $this->view->form = $form = new Sesletteravatar_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      unset($values['defaulttext']);
      include_once APPLICATION_PATH . "/application/modules/Sesletteravatar/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesletteravatar.pluginactivated')) {
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
  public function supportAction() {

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesletteravatar_admin_main', array(), 'sesletteravatar_admin_main_support');

    }
  public function stylingAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesletteravatar_admin_main', array(), 'sesletteravatar_admin_main_styling');

    $this->view->form = $form = new Sesletteravatar_Form_Admin_Settings_Styling();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      foreach ($values as $key => $value) {
        if($value != '')
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
    }
  }
}
