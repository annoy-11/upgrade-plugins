<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seslinkedin_Widget_FooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Languages
    $translate = Zend_Registry::get('Zend_Translate');
    $languageList = $translate->getList();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_footer');

    $this->view->paginator = Engine_Api::_()->getDbTable('socialicons', 'seslinkedin')->getSocialInfo(array('enabled' => 1));
    $this->view->footerlogo = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.footerlogo', '');
    $this->view->logintextnonloggined = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.logintext', 1);
    $this->view->footerlinks = Engine_Api::_()->getDbTable('footerlinks', 'seslinkedin')->getInfo(array('sublink' => 0, 'enabled' => 1));

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

    $this->view->socialnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_social_sites');

    $this->view->seslinkedin_extra_menu = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslinkedin_extra_menu');
    $seslinkedin_footer = Zend_Registry::isRegistered('seslinkedin_footer') ? Zend_Registry::get('seslinkedin_footer') : null;
    if(empty($seslinkedin_footer)) {
      return $this->setNoRender();
    }
    $this->view->storage = Engine_Api::_()->storage();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->footerlogo = $settings->getSetting('seslinkedin.footerlogo', '');

  }
}
