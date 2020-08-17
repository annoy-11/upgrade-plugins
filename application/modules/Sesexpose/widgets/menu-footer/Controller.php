<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesexpose_Widget_MenuFooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->footer_image = $this->_getParam('footer_image', '');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_footer');
    
    $module = $this->_getParam('sesexpose_module', '');
    if($module) {
      $table = Engine_Api::_()->getItemTable($module);
      $tableName = $table->info('name');
      $select = $table->select()->from($tableName)->limit(3);
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

      $select->order('creation_date DESC');
      $column_exist = $db->query("SHOW COLUMNS FROM ".$tableName." LIKE 'is_delete'")->fetch();
      if (!empty($column_exist)) {
        $select->where('is_delete =?',0);
      }
      $this->view->results = $table->fetchAll($select);
    }

    // Languages
    $translate = Zend_Registry::get('Zend_Translate');
    $languageList = $translate->getList();

    //$currentLocale = Zend_Registry::get('Locale')->__toString();
    // Prepare default langauge
    $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
    if (!in_array($defaultLanguage, $languageList)) {
      if ($defaultLanguage == 'auto' && isset($languageList['en'])) {
        $defaultLanguage = 'en';
      } else {
        $defaultLanguage = null;
      }
    }

    // Prepare language name list
    $languageNameList = array();
    $languageDataList = Zend_Locale_Data::getList(null, 'language');
    $territoryDataList = Zend_Locale_Data::getList(null, 'territory');

    foreach ($languageList as $localeCode) {
      $languageNameList[$localeCode] = Engine_String::ucfirst(Zend_Locale::getTranslation($localeCode, 'language', $localeCode));
      if (empty($languageNameList[$localeCode])) {
        if (false !== strpos($localeCode, '_')) {
          list($locale, $territory) = explode('_', $localeCode);
        } else {
          $locale = $localeCode;
          $territory = null;
        }
        if (isset($territoryDataList[$territory]) && isset($languageDataList[$locale])) {
          $languageNameList[$localeCode] = $territoryDataList[$territory] . ' ' . $languageDataList[$locale];
        } else if (isset($territoryDataList[$territory])) {
          $languageNameList[$localeCode] = $territoryDataList[$territory];
        } else if (isset($languageDataList[$locale])) {
          $languageNameList[$localeCode] = $languageDataList[$locale];
        } else {
          continue;
        }
      }
    }
    $languageNameList = array_merge(array(
        $defaultLanguage => $defaultLanguage
            ), $languageNameList);
    $this->view->languageNameList = $languageNameList;

    // Get affiliate code
    $this->view->affiliateCode = Engine_Api::_()->getDbtable('settings', 'core')->core_affiliate_code;

    $this->view->aboutusheading = $this->_getParam('aboutusheading', 'About Us');
    $this->view->aboutusdescription = $this->_getParam('aboutusdescription', 'Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry.');
    $this->view->blogsectionheading = $this->_getParam('blogsectionheading', 'Blogs');
    $this->view->socialmediaheading = $this->_getParam('socialmediaheading', 'SOCIAL');
    
    
    $this->view->facebookButton = $this->_getParam('facebook_url_path', 'http://www.facebook.com/');
    $this->view->pinterestButton = $this->_getParam('pinterest_url_path', 'https://www.pinterest.com/');
    $this->view->twitterButton = $this->_getParam('twitter_url_path', 'https://www.twitter.com/');
    $this->view->googleplusButton = $this->_getParam('googleplus_url_path', 'http://plus.google.com/');
  }

}