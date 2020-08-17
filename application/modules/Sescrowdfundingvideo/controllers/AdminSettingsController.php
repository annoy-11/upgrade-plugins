<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfundingvideo_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_sescrowdfundingvideo');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfundingvideo_admin_main', array(), 'sescrowdfundingvideo_admin_main_settings');


    // Check ffmpeg path for correctness
    if (function_exists('exec')) {
      $ffmpeg_path = Engine_Api::_()->getApi('settings', 'core')->sescrowdfundingvideo_ffmpeg_path;

      $output = null;
      $return = null;
      if (!empty($ffmpeg_path)) {
        exec($ffmpeg_path . ' -version', $output, $return);
      }
      // Try to auto-guess ffmpeg path if it is not set correctly
      $ffmpeg_path_original = $ffmpeg_path;
      if (empty($ffmpeg_path) || $return > 0 || stripos(join('', $output), 'ffmpeg') === false) {
        $ffmpeg_path = null;
        // Windows
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
          // @todo
        }
        // Not windows
        else {
          $output = null;
          $return = null;
          @exec('which ffmpeg', $output, $return);
          if (0 == $return) {
            $ffmpeg_path = array_shift($output);
            $output = null;
            $return = null;
            exec($ffmpeg_path . ' -version 2>&1', $output, $return);
            if ($output == null) {
              $ffmpeg_path = null;
            }
          }
        }
      }
      if ($ffmpeg_path != $ffmpeg_path_original) {
        Engine_Api::_()->getApi('settings', 'core')->sescrowdfundingvideo_ffmpeg_path = $ffmpeg_path;
      }
    }

    // Make form
    $this->view->form = $form = new Sescrowdfundingvideo_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();

      $oldYoutubeApikey = Engine_Api::_()->getApi('settings', 'core')->getSetting('video.youtube.apikey');

      if (!empty($values['sescrowdfundingvideo_youtube_apikey']) && $values['sescrowdfundingvideo_youtube_apikey'] != $oldYoutubeApikey) {
        $response = $this->verifyYotubeApiKey($values['sescrowdfundingvideo_youtube_apikey']);
        if (!empty($response['errors'])) {
          $error_message = array('Invalid API Key');
          foreach ($response['errors'] as $error) {
            $error_message[] = "Error Reason (" . $error['reason'] . '): ' . $error['message'];
          }
          return $form->video_youtube_apikey->addErrors($error_message);
        }
      }

      // Check ffmpeg path
      if (!empty($values['sescrowdfundingvideo_ffmpeg_path'])) {
        if (function_exists('exec')) {
          $ffmpeg_path = $values['sescrowdfundingvideo_ffmpeg_path'];
          $output = null;
          $return = null;
          exec($ffmpeg_path . ' -version', $output, $return);

          if ($return > 0 && $output != NULL) {
            $form->sescrowdfundingvideo_ffmpeg_path->addError('FFMPEG path is not valid or does not exist');
            $values['sescrowdfundingvideo_ffmpeg_path'] = '';
          }
        } else {
          $form->sescrowdfundingvideo_ffmpeg_path->addError('The exec() function is not available. The ffmpeg path has not been saved.');
          $values['sescrowdfundingvideo_ffmpeg_path'] = '';
        }
      }

      include_once APPLICATION_PATH . "/application/modules/Sescrowdfundingvideo/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.pluginactivated')) {
        foreach ($values as $key => $value) {
          if (is_null($value) || $value == '')
            continue;
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  private function verifyYotubeApiKey($key) {
    $option = array(
        'part' => 'id',
        'key' => $key,
        'maxResults' => 1
    );
    $url = "https://www.googleapis.com/youtube/v3/search?" . http_build_query($option, 'a', '&');
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $json_response = curl_exec($curl);
    curl_close($curl);
    $responseObj = Zend_Json::decode($json_response);
    if (empty($responseObj['error'])) {
      return array('success' => 1);
    }
    return $responseObj['error'];
  }

  public function levelAction() {

    // Make navigation
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_sescrowdfundingvideo');

    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfundingvideo_admin_main', array(), 'sescrowdfundingvideo_admin_main_level');

    // Get level id
    if (null !== ($id = $this->_getParam('id'))) {
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    } else {
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
    }

    if (!$level instanceof Authorization_Model_Level) {
      throw new Engine_Exception('missing level');
    }

    $level_id = $id = $level->level_id;
    // Make form
    $this->view->form = $form = new Sescrowdfundingvideo_Form_Admin_Settings_Level(array(
        'public' => ( in_array($level->type, array('public')) ),
        'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($id);
    // Populate values
    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
    $form->populate($permissionsTable->getAllowed('crowdfundingvideo', $id, array_keys($form->getValues())));
    // Check post
    if (!$this->getRequest()->isPost()) {
      return;
    }
    // Check validitiy
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    // Process
    $values = $form->getValues();
    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();
    try {
      // Set permissions
      $permissionsTable->setAllowed('crowdfundingvideo', $id, $values);
      // Commit
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }

  public function utilityAction() {

    if (defined('_ENGINE_ADMIN_NEUTER') && _ENGINE_ADMIN_NEUTER) {
      return $this->_helper->redirector->gotoRoute(array(), 'admin_default', true);
    }
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_sescrowdfundingvideo');
    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sescrowdfundingvideo_admin_main', array(), 'sescrowdfundingvideo_admin_main_utility');
    $ffmpeg_path = Engine_Api::_()->getApi('settings', 'core')->sescrowdfundingvideo_ffmpeg_path;
    if (function_exists('shell_exec')) {
      // Get version
      $this->view->version = $version = shell_exec(escapeshellcmd($ffmpeg_path) . ' -version 2>&1');
      $command = "$ffmpeg_path -formats 2>&1";
      $this->view->format = $format = shell_exec(escapeshellcmd($ffmpeg_path) . ' -formats 2>&1')
              . shell_exec(escapeshellcmd($ffmpeg_path) . ' -codecs 2>&1');
    }
  }

  //site statis for sescrowdfundingvideo plugin
  public function statisticAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_sescrowdfundingvideo');

    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfundingvideo_admin_main', array(), 'sescrowdfundingvideo_admin_main_statistic');

    $videoTable = Engine_Api::_()->getDbtable('videos', 'sescrowdfundingvideo');
    $videoTableName = $videoTable->info('name');

    //Total Videos
    $select = $videoTable->select()->from($videoTableName, 'count(*) AS totalvideo');
    $this->view->totalvideo = $select->query()->fetchColumn();

    //Total featured video
    $select = $videoTable->select()->from($videoTableName, 'count(*) AS totalfeatured')->where('is_featured =?', 1);
    $this->view->totalvideofeatured = $select->query()->fetchColumn();

    //Total sponsored video
    $select = $videoTable->select()->from($videoTableName, 'count(*) AS totalsponsored')->where('is_sponsored =?', 1);
    $this->view->totalvideosponsored = $select->query()->fetchColumn();

    //Total favourite video
    $select = $videoTable->select()->from($videoTableName, 'count(*) AS totalfavourite')->where('favourite_count <>?', 0);
    $this->view->totalvideofavourite = $select->query()->fetchColumn();

    //Total rated video
    $select = $videoTable->select()->from($videoTableName, 'count(*) AS totalrated')->where('rating <>?', 0);
    $this->view->totalvideorated = $select->query()->fetchColumn();
  }

  public function manageWidgetizePageAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_sescrowdfundingvideo');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfundingvideo_admin_main', array(), 'sescrowdfundingvideo_admin_main_managepages');

    $this->view->pagesArray = array('sescrowdfundingvideo_index_home','sescrowdfundingvideo_index_browse','sescrowdfundingvideo_index_create','sescrowdfundingvideo_index_edit','sescrowdfundingvideo_index_view');
  }
}
