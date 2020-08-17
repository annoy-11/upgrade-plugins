<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespoke_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespoke_admin_main', array(), 'sespoke_admin_main_settings');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sespoke_Form_Admin_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sespoke/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespoke.pluginactivated')) {
        foreach ($values as $key => $value) {
          $settings->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  function setPokeIcon($file, $manageaction_id, $resize = false) {

    $name = basename($file);
    $extension = ltrim(strrchr($file, '.'), '.');
    $base = rtrim(substr(basename($file), 0, strrpos(basename($file), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'sespoke',
        'parent_id' => $manageaction_id,
        'name' => $name,
    );

    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '.' . $extension;
    copy($file, $mainPath);
    try {
      $image = Engine_Image::factory();
      $image->open($mainPath);
      $image->open($mainPath)
              ->resample(0, 0, $image->width, $image->height, $image->width, $image->height)
              ->write($mainName)
              ->destroy();

      $photoFile = Engine_Api::_()->storage()->create($mainPath, $params);
    } catch (Exception $e) {
      die;
      @unlink($mainPath);
      if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
        throw new Core_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    @unlink($mainPath);
    return $photoFile->file_id;
  }

}
