<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Widget_PagesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->page_title = $this->_getParam('show_title', 0);
    $fixedPageId = Zend_Controller_Front::getInstance()->getRequest()->getParam('pagebuilder_id', null);
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagebuilder.showpages'))
      return $this->setNoRender();
    $page_id = Engine_Api::_()->sespagebuilder()->getWidgetizePageId($fixedPageId);
    $table = Engine_Api::_()->getItemTable('sespagebuilder_pagebuilder');
    $select = $table->select()->where('page_id = ?', $page_id);
    $this->view->content = $table->fetchRow($select);
    
    
    $languageNameList  = array();
    $languageDataList  = Zend_Locale_Data::getList(null, 'language');
    $territoryDataList = Zend_Locale_Data::getList(null, 'territory');
    $languageList = Zend_Registry::get('Zend_Translate')->getList();
    foreach( $languageList as $localeCode ) {
      $languageNameList[$localeCode] = Engine_String::ucfirst(Zend_Locale::getTranslation($localeCode, 'language', $localeCode));
      if (empty($languageNameList[$localeCode])) {
        if( false !== strpos($localeCode, '_') ) {
          list($locale, $territory) = explode('_', $localeCode);
        } else {
          $locale = $localeCode;
          $territory = null;
        }
        if( isset($territoryDataList[$territory]) && isset($languageDataList[$locale]) ) {
          $languageNameList[$localeCode] = $territoryDataList[$territory] . ' ' . $languageDataList[$locale];
        } else if( isset($territoryDataList[$territory]) ) {
          $languageNameList[$localeCode] = $territoryDataList[$territory];
        } else if( isset($languageDataList[$locale]) ) {
          $languageNameList[$localeCode] = $languageDataList[$locale];
        } else {
          continue;
        }
      }
    }
    $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
    $languageNameList = array_merge(array(
      $defaultLanguage => $defaultLanguage
    ), $languageNameList);
    $this->view->languageNameList = $languageNameList;
  }

}
