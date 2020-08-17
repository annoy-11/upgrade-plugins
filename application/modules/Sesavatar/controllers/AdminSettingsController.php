<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesavatar_AdminSettingsController extends Core_Controller_Action_Admin {

    public function indexAction() {

        $db = Engine_Db_Table::getDefaultAdapter();

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesavatar_admin_main', array(), 'sesavatar_admin_main_settings');

        $this->view->form = $form = new Sesavatar_Form_Admin_Settings_Global();

        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

            $values = $form->getValues();

            include_once APPLICATION_PATH . "/application/modules/Sesavatar/controllers/License.php";
            if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesavatar.pluginactivated')) {
                foreach ($values as $key => $value) {
                    if (Engine_Api::_()->getApi('settings', 'core')->hasSetting($key, $value))
                        Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
                    if (!$value && strlen($value) == 0)
                        continue;
                    Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
                }
                $form->addNotice('Your changes have been saved.');
                if ($error)
                    $this->_helper->redirector->gotoRoute(array());
            }
        }
    }

  public function uploadBackgrounds() {

    $avatarsTable = Engine_Api::_()->getDbtable('images', 'sesavatar');
    $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesavatar' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "avatars" . DIRECTORY_SEPARATOR;

    $file_display = array('jpg', 'jpeg', 'png', 'gif');
    if (file_exists($PathFile)) {
      $dir_contents = scandir( $PathFile );
      foreach ( $dir_contents as $file ) {
        $f = explode('.', $file );
        $g = end($f);
        $file_type = strtolower($g);
        if ( ($file !== '.') && ($file !== '..') && (in_array( $file_type, $file_display)) ) {
          $images = explode('.', $file);
          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
          // If we're here, we're done
          try {
            $item = $avatarsTable->createRow();
            $values['enabled'] = 1;
            $item->setFromArray($values);
            $item->save();
            $item->order = $item->image_id;
            $item->save();
            if(!empty($file)) {
              $file_ext = pathinfo($file);
              $file_ext = $file_ext['extension'];
              $storage = Engine_Api::_()->getItemTable('storage_file');
              $pngFile = $PathFile . $file;
              $storageObject = $storage->createFile($pngFile, array(
                'parent_id' => $item->getIdentity(),
                'parent_type' => $item->getType(),
                'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
              ));
              // Remove temporary file
              @unlink($file['tmp_name']);
              $item->file_id = $storageObject->file_id;
              $item->save();
            }
            $db->commit();
          } catch(Exception $e) {
            $db->rollBack();
            throw $e;
          }
        }
      }
    }
  }
}
