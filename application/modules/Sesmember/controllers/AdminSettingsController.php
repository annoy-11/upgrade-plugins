<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmember_admin_main', array(), 'sesmember_admin_main_settings');

    $this->view->form = $form = new Sesmember_Form_Admin_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesmember/controllers/License.php";
      //$this->getUserPhotoURL();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.pluginactivated')) {
        if($values['sesmember_autofollow'] == 1) {
            $db->query('UPDATE `engine4_sesmember_follows` SET `user_approved` = "1";');
            $db->query('UPDATE `engine4_sesmember_follows` SET `resource_approved` = "1";');
        }
        foreach ($values as $key => $value) {
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  // for default installation
  function setComplimentPhoto($file, $compliment_id, $resize = false) {
    $fileName = $file;
    $extension = ltrim(strrchr($fileName, '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'sesmember_compliment',
        'parent_id' => $compliment_id,
        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        'name' => basename($file),
    );
    // Save
    $filesTable = Engine_Api::_()->getDbtable('files', 'storage');
    if ($resize) {
      // Resize image (main)
      $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_poster.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
              ->autoRotate()
              ->resize(800, 800)
              ->write($mainPath)
              ->destroy();
      // Resize image (normal) make same image for activity feed so it open in pop up with out jump effect.
      $normalPath = $path . DIRECTORY_SEPARATOR . $base . '_thumb.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
              ->autoRotate()
              ->resize(500, 500)
              ->write($normalPath)
              ->destroy();
    } else {
      $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_poster.' . $extension;
      copy($file, $mainPath);
    }
    if ($resize) {
      // normal main  image resize
      $normalMainPath = $path . DIRECTORY_SEPARATOR . $base . '_icon.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
              ->autoRotate()
              ->resize(100, 100)
              ->write($normalMainPath)
              ->destroy();
    } else {
      $normalMainPath = $path . DIRECTORY_SEPARATOR . $base . '_icon.' . $extension;
      copy($file, $normalMainPath);
    }
    // Store
    try {
      $iMain = $filesTable->createFile($mainPath, $params);
      if ($resize) {
        $iIconNormal = $filesTable->createFile($normalPath, $params);
        $iMain->bridge($iIconNormal, 'thumb.thumb');
      }
      $iNormalMain = $filesTable->createFile($normalMainPath, $params);
      $iMain->bridge($iNormalMain, 'thumb.icon');
    } catch (Exception $e) {
      die;
      // Remove temp files
      @unlink($mainPath);
      if ($resize) {
        @unlink($normalPath);
      }
      @unlink($normalMainPath);
      // Throw
      if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
        throw new Sesevent_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    // Remove temp files
    @unlink($mainPath);
    if ($resize) {
      @unlink($normalPath);
    }
    @unlink($normalMainPath);
    // Update row
    // Delete the old file?
    if (!empty($tmpRow)) {
      $tmpRow->delete();
    }
    return $iMain->file_id;
  }
  public function manageWidgetizePageAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmember_admin_main', array(), 'sesmember_admin_main_managepages');

    $this->view->pagesArray = array('sesmember_index_browse', 'sesmember_index_nearest-member', 'sesmember_index_member-compliments', 'sesmember_index_top-members', 'sesmember_review_browse', 'sesmember_index_locations', 'sesmember_index_pinborad-view-members', 'sesmember_review_view', 'sesmember_index_alphabetic-members-search', 'sesmember_index_editormembers');
  }

  function getUserPhotoURL() {

    $file = APPLICATION_PATH . DIRECTORY_SEPARATOR . "application/modules/User/Model/User.php";
    chmod($file, 0777);
    $Vdata = file_get_contents($file);
    $searchterm = "array('search', 'displayname', 'username');";

    $findString = "public function getPhotoUrl(";

    if (strpos($Vdata, "$findString") !== false) {
    } else {
      $new_code = '

      public function getPhotoUrl($type = NULL) {
        if(!$this->getIdentity()) return "application/modules/User/externals/images/nophoto_user_thumb_profile.png";
        $photoId = $this->photo_id;
        if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesmember")) {
          if(empty($photoId)) {
            $profiletype_id = Engine_Api::_()->sesmember()->getProfileTypeId(array("user_id" => $this->user_id, "field_id" => 1));
            $photo_id = Engine_Api::_()->getDbtable("profilephotos", "sesmember")->getPhotoId($profiletype_id);
            if ($photo_id) {
              $file = Engine_Api::_()->getItemTable("storage_file")->getFile($photo_id, $type);
              if($file) {
                return $file->map();
              } elseif($photo_id) {
                $file = Engine_Api::_()->getItemTable("storage_file")->getFile($photo_id,"thumb.profile");
                if($file)
                  return $file->map();
              } else {
                return "application/modules/User/externals/images/nophoto_user_thumb_profile.png";
              }
            } else {
              return "application/modules/User/externals/images/nophoto_user_thumb_profile.png";
            }
          } else {
            $file = Engine_Api::_()->getItemTable("storage_file")->getFile($photoId, $type);
            if($file) {
              return $file->map();
            } elseif($photoId) {
              $file = Engine_Api::_()->getItemTable("storage_file")->getFile($photoId,"thumb.profile");
              if($file)
              return $file->map();
            } else {
              return "application/modules/User/externals/images/nophoto_user_thumb_profile.png";
            }
          }
        }
        else {
          if ($photoId) {
            $file = Engine_Api::_()->getItemTable("storage_file")->getFile($photoId, $type);
            if($file)
            return $file->map();
            else
            return "application/modules/User/externals/images/nophoto_user_thumb_profile.png";
          } else {
            return "application/modules/User/externals/images/nophoto_user_thumb_profile.png";
          }
        }
      }';
      $newstring = str_replace($searchterm, $searchterm.$new_code, $Vdata);
      chmod($file, 0777);
      chmod($file, 0777);
      $user_model_codewrite = fopen($file, 'w+');
      fwrite($user_model_codewrite, $newstring);
      fclose($user_model_codewrite);
    }
  }
}
