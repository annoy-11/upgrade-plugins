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
class Sespagebuilder_Widget_TabsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (strpos($_SERVER['REQUEST_URI'], 'admin') == 1)
      return $this->setNoRender();

    $tab_name = $this->_getParam('tabName');

    $this->view->customcolor = $this->_getParam('customcolor');
    $this->view->width = $this->_getParam('width', 'auto');
    $this->view->height = $this->_getParam('height');
    $this->view->headingBgColor = $this->_getParam('headingBgColor', '#bfdbff');
    $this->view->tabBgColor = $this->_getParam('tabBgColor', '#bfdbff');
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagebuilder.showpages'))
      return $this->setNoRender();
    $this->view->tabTextBgColor = $this->_getParam('tabTextBgColor', '#000066');
    $this->view->tabActiveBgColor = $this->_getParam('tabActiveBgColor', '#f3f3f4');
    $this->view->tabActiveTextColor = $this->_getParam('tabActiveTextColor', '#000066');
    $this->view->tabTextFontSize = $this->_getParam('tabTextFontSize', '14');
    $this->view->descriptionBgColor = $this->_getParam('descriptionBgColor', '#f3f3f4');
    $this->view->showViewType = $this->_getParam('showViewType', '1');

    if ($tab_name){
      $this->view->tabs = $tab = Engine_Api::_()->getItem('sespagebuilder_tab', $tab_name);
			
		$languageNameList  = array();
    $languageDataList  = Zend_Locale_Data::getList(null, 'language');
    $territoryDataList = Zend_Locale_Data::getList(null, 'territory');

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
    else
      return $this->setNoRender();
  }

}
