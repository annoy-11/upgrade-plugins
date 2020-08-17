<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesshoutbox_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesshoutbox_admin_main', array(), 'sesshoutbox_admin_main_settings');

    $this->view->form = $form = new Sesshoutbox_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      unset($values['defaulttext']);
      include_once APPLICATION_PATH . "/application/modules/Sesshoutbox/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshoutbox.pluginactivated')) {
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

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesshoutbox_admin_main', array(), 'sesshoutbox_admin_main_support');

    }
  public function uploadPhotoAction() {

    //Set default layout
    $this->_helper->layout->setLayout('default-simple');

    $admin_file = APPLICATION_PATH . '/public/sesshoutbox';

    $path = realpath($admin_file);

    if (!is_dir($admin_file) && mkdir($admin_file, 0777, true))
      chmod($admin_file, 0777);

    if (empty($_FILES['userfile'])) {
      $this->view->error = 'File failed to upload. Check your server settings (such as php.ini max_upload_filesize).';
      return;
    }

    $info = $_FILES['userfile'];
    $targetFile = $path . '/' . $info['name'];

    if (!move_uploaded_file($info['tmp_name'], $targetFile)) {
      $this->view->error = "Unable to move file to upload directory.";
      return;
    }

    $this->view->status = true;
    $this->view->photo_url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . Zend_Controller_Front::getInstance()->getBaseUrl() . '/public/sesshoutbox/' . $info['name'];
  }

}
