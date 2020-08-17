<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesseo_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesseo_admin_main', array(), 'sesseo_admin_main_settings');
    
    $table_exist = $db->query('SHOW TABLES LIKE \'engine4_sesseo_managemetatags\'')->fetch();
    if($table_exist) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesseo.pluginactivated', 1);
    }
    
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sesseo_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesseo/controllers/License.php";
      if ($settings->getSetting('sesseo.pluginactivated')) {
        foreach ($values as $key => $value) {
          if($key ==  'sesseo_nonmeta_photo') {
            if($value == '0')
              $value = 'public/admin/social_share.jpg';
          }
          $settings->setSetting($key, $value);
        }

        //Page Metas sync
        $getAllPages = Engine_Api::_()->getDbtable('managemetatags', 'sesseo')->getAllPages();
        $getAllPageIds = array();
        foreach($getAllPages as $getAllPage) {
          $getAllPageIds[] = $getAllPage['page_id'];
        }

        $select = Engine_Api::_()->getDbtable('pages', 'core')->select()->where('custom =?', 0)->where('page_id NOT IN (?)', array('1', '2'));
        if($getAllPageIds) {
          $select->where('page_id NOT IN (?)', $getAllPageIds);
        }
        $results = $select->query()->fetchAll();
        foreach($results as $result) {
          $db->query('INSERT IGNORE INTO `engine4_sesseo_managemetatags` (`page_id`, `meta_title`, `meta_description`, `file_id`, `enabled`) VALUES ("'.$result["page_id"].'", "'.htmlentities($result["title"]).'", "'.htmlentities($result["description"]).'", 0, 1);');
        }
        //Page Metas sync

        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }

    }
  }

  public function schemaMarkupAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesseo_admin_main', array(), 'sesseo_admin_main_schema');


    $this->view->form = $form = new Sesseo_Form_Admin_Schema();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
        foreach ($values as $key => $value) {
            if (Engine_Api::_()->getApi('settings', 'core')->hasSetting($key, $value))
                Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
            if (!$value && strlen($value) == 0)
                continue;
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
    }
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

  public function opensearchAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesseo_admin_main', array(), 'sesseo_admin_main_manageopsedes');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $writeable = array();
    $writeable['sesseo'] = false;
    try {

        if(!file_exists(APPLICATION_PATH . "/osdd.xml")) {
            $dom = new DOMDocument();
            $xml_file_name = APPLICATION_PATH . "/osdd.xml";
            $dom->save($xml_file_name);
            $xml_content = '<?xml version="1.0" encoding="UTF-8"?>
            <OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">
            <ShortName>'.$_SERVER['HTTP_HOST'].'</ShortName>
            <Description>'.$_SERVER['HTTP_HOST'].'Search Description'.'</Description>
            <InputEncoding>[UTF-8]</InputEncoding>
            <Image width="16" height="16" type="image/x-icon">'.$_SERVER['HTTP_HOST'].'/favicon.ico</Image>
            <Url type="text/html" template="'.$view->absoluteUrl($view->baseUrl('search')).'" method="GET">
                <Param name="query" value="{searchTerms}"/>
                <Param name="otracker" value="{start}"/>
            </Url>
            </OpenSearchDescription>';
            file_put_contents($xml_file_name, $xml_content);
          throw new Core_Model_Exception('Missing file');
        } else {
          $this->checkWriteable(APPLICATION_PATH . "/osdd.xml");
        }
      $writeable['sesseo'] = true;
    } catch(Exception $e) {
      $this->view->errorMessage = $e->getMessage();
    }

    $this->view->writeable = $writeable;
    $this->view->activeFileContents = file_get_contents(APPLICATION_PATH . '/osdd.xml');
  }

  public function htaccessAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesseo_admin_main', array(), 'sesseo_admin_main_managehtaccess');

    $writeable = array();
    $writeable['sesseo'] = false;
    try {
        if(!file_exists(APPLICATION_PATH . "/.htaccess")) {
          throw new Core_Model_Exception('Missing file');
        } else {
          $this->checkWriteable(APPLICATION_PATH . "/.htaccess");
        }
      $writeable['sesseo'] = true;
    } catch(Exception $e) {
      $this->view->errorMessage = $e->getMessage();
    }

    $this->view->writeable = $writeable;
    $this->view->activeFileContents = file_get_contents(APPLICATION_PATH . '/.htaccess');
  }

  public function robotoAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesseo_admin_main', array(), 'sesseo_admin_main_manageroboto');

    $writeable = array();
    $writeable['sesseo'] = false;
    try {
        if(!file_exists(APPLICATION_PATH . "/robots.txt")) {
          throw new Core_Model_Exception('Missing file');
        } else {
          $this->checkWriteable(APPLICATION_PATH . "/robots.txt");
        }
      $writeable['sesseo'] = true;
    } catch(Exception $e) {
      $this->view->errorMessage = $e->getMessage();
    }

    $this->view->writeable = $writeable;
    $this->view->activeFileContents = file_get_contents(APPLICATION_PATH . '/robots.txt');
  }

  public function saveAction() {

    $file = $this->_getParam('basePath');
    $body = $this->_getParam('body');

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_("Bad method");
      return;
    }

    if(!$file || !$body ) {
      $this->view->status = false;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_("Bad params");
      return;
    }

    //Check file
    $basePath = APPLICATION_PATH . '/'.$file;
    try {
      $this->checkWriteable($basePath);
    } catch( Exception $e ) {
      $this->view->status = false;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_("Not writeable");
      return;
    }

    // Now lets write the custom file
    if( !file_put_contents($basePath, $body) ) {
      $this->view->status = false;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Could not save contents');
      return;
    }
    $this->view->status = true;
  }

}
