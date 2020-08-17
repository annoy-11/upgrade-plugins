<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminCustomThemeController.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_AdminCustomThemeController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesytube_admin_main', array(), 'sesytube_admin_main_customcss');

    $writeable = array();
    $writeable['sesytube'] = false;
    try {
      foreach(array('theme.css', 'constants.css', 'media-queries.css', 'sesytube-custom.css') as $file ) {
        if( !file_exists(APPLICATION_PATH . "/application/themes/sesytube/$file") ) {
          throw new Core_Model_Exception('Missing file');
        } else {
          $this->checkWriteable(APPLICATION_PATH . "/application/themes/sesytube/$file");
        }
      }
      $writeable['sesytube'] = true;
    }
    catch( Exception $e ) {
      $this->view->errorMessage = $e->getMessage();
    }
    $this->view->writeable = $writeable;
    $this->view->activeFileContents = file_get_contents(APPLICATION_PATH . '/application/themes/sesytube/sesytube-custom.css');
  }

  public function saveAction() {

    $theme_id = 'sesytube';
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
    $basePath = APPLICATION_PATH . '/application/themes/sesytube';
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

//     // Check for original file (try to create if not exists)
//     if( !file_exists($basePath . '/original.' . $file) ) {
//       if( !copy($fullFilePath, $basePath . '/original.' . $file) ) {
//         $this->view->status = false;
//         $this->view->message = Zend_Registry::get('Zend_Translate')->_("Could not create backup");
//         return;
//       }
//       chmod("$basePath/original.$file", 0777);
//     }

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
