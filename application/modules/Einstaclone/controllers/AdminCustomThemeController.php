<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminCustomThemeController.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_AdminCustomThemeController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('einstaclone_admin_main', array(), 'einstaclone_admin_main_customcss');

    $writeable = array();
    $writeable['einstaclone'] = false;
    try {
      foreach(array('theme.css', 'constants.css', 'media-queries.css', 'einstaclone-custom.css') as $file ) {
        if( !file_exists(APPLICATION_PATH . "/application/themes/einstaclone/$file") ) {
          throw new Core_Model_Exception('Missing file');
        } else {
          $this->checkWriteable(APPLICATION_PATH . "/application/themes/einstaclone/$file");
        }
      }
      $writeable['einstaclone'] = true;
    }
    catch( Exception $e ) {
      $this->view->errorMessage = $e->getMessage();
    }
    $this->view->writeable = $writeable;
    $this->view->activeFileContents = file_get_contents(APPLICATION_PATH . '/application/themes/einstaclone/einstaclone-custom.css');
  }

  public function saveAction() {

    $theme_id = 'einstaclone';
    $file = $this->_getParam('file');
    $body = $this->_getParam('body');

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_("Bad method");
      return;
    }

    if( !$theme_id || !$file || !$body ) {
      $this->view->status = false;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_("Bad params");
      return;
    }

    // Get theme
    $themeTable = Engine_Api::_()->getDbtable('themes', 'core');
    $themeSelect = $themeTable->select()->where('name = ?', $theme_id)->limit(1);
    $theme = $themeTable->fetchRow($themeSelect);

    if( !$theme ) {
      $this->view->status = false;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_("Missing theme");
      return;
    }

    //Check file
    $basePath = APPLICATION_PATH . '/application/themes/einstaclone';
    $manifestData = include $basePath . '/manifest.php';
    if( empty($manifestData['files']) || !in_array($file, $manifestData['files']) ) {
      $this->view->status = false;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_("Not in theme files");
      return;
    }
    $fullFilePath = $basePath . '/' . $file;
    try {
      $this->checkWriteable($fullFilePath);
    } catch( Exception $e ) {
      $this->view->status = false;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_("Not writeable");
      return;
    }

    // Now lets write the custom file
    if( !file_put_contents($fullFilePath, $body) ) {
      $this->view->status = false;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Could not save contents');
      return;
    }

    // clear scaffold cache
    Core_Model_DbTable_Themes::clearScaffoldCache();
    $this->view->status = true;
  }

  public function checkWriteable($path)
  {
    if( !file_exists($path) ) {
      throw new Core_Model_Exception('Path doesn\'t exist');
    }
    if( !is_writeable($path) ) {
      throw new Core_Model_Exception('Path is not writeable');
    }
    if( !is_dir($path) ) {
      if( !($fh = fopen($path, 'ab')) ) {
        throw new Core_Model_Exception('File could not be opened');
      }
      fclose($fh);
    }
  }
}
