<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesprofilelock_admin_main', array(), 'sesprofilelock_admin_main_settings');

    $this->view->form = $form = new Sesprofilelock_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.pluginactivated')) {
        $values['sesprofilelock_lockedlink'] = 1;
        $values['sesproflelock_levels'] = array('1', '2', '3', '4');
        $values['sesprofilelock_popupinfo'] = array('site_title', 'member_title', 'email', 'locked_text', 'signout_link');
      }

      include_once APPLICATION_PATH . "/application/modules/Sesprofilelock/controllers/License.php";

      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.pluginactivated')) {

        if (isset($values['sesproflelock_levels']))
        $values['sesproflelock_levels'] = serialize($values['sesproflelock_levels']);
        else
        $values['sesproflelock_levels'] = serialize(array());
        
        if (isset($values['sesprofilelock_popupinfo']))
        $values['sesprofilelock_popupinfo'] = serialize($values['sesprofilelock_popupinfo']);
        else
        $values['sesprofilelock_popupinfo'] = serialize(array());
       
        $availableOptions = array('sesprofilelock_main_admin','sesprofilelock_footer_admin','seslock_mini_admin');
        $difference = array_diff($availableOptions,(array)$values['sesprofilelock_lockedlink']);
        if (isset($values['sesprofilelock_lockedlink']) && count($values['sesprofilelock_lockedlink'])) {
          foreach($values['sesprofilelock_lockedlink'] as $valueLock){
            $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '1' WHERE `engine4_core_menuitems`.`name` = '".$valueLock."';");
          }
        }
        unset($values['sesprofilelock_lockedbackground']);
        unset($values['sesprofilelock_lockedbackground_display']);

        foreach ($values as $key => $value) {
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }

        $form->addNotice('Your changes have been saved.');
        if($error)
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function setPhoto($photo) {

    if ($photo instanceof Zend_Form_Element_File)
    $file = $photo->getFileName();
    else if (is_array($photo) && !empty($photo['tmp_name']))
    $file = $photo['tmp_name'];
    else if (is_string($photo) && file_exists($photo)) 
    $file = $photo;
    else
    return;

    if (empty($file))
    return;

    //GET PHOTO DETAILS
    $name = basename($file);
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $mainName = $path . '/' . $name;

    $photo_params = array(
      'parent_type' => "sesprofilelock",
    );

    //RESIZE IMAGE WORK
    $image = Engine_Image::factory();
    $image->open($file);
    $image->open($file)
            ->resample(0, 0, $image->width, $image->height, $image->width, $image->height)
            ->write($mainName)
            ->destroy();

    try {
      $photoFile = Engine_Api::_()->storage()->create($mainName, $photo_params);
    } catch (Exception $e) {
      if ($e->getCode() == Storage_Api_Storage::SPACE_LIMIT_REACHED_CODE) {
        echo $e->getMessage();
        exit();
      }
    }

    //Delete temp file.
    @unlink($mainName);
    return $photoFile;
  }

  public function removePhotoAction() {

    $file_id = $this->_getParam('file_id');

    // Get form
    $this->view->form = $form = new Sesprofilelock_Form_RemovePhoto();

    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    if ($file_id)
    Engine_Api::_()->getApi('settings', 'core')->setSetting("sesprofilelock.lockedbackground", '');

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your have successfully removed background image.');

    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your have successfully removed background image.'))
    ));
  }
}
