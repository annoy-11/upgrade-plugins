<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Widget_MenuFooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_footer');
    $this->view->quickLinksMenu = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesariana_quicklinks_footer');

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
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->footerlogo =  $settings->getSetting('sesariana.footerlogo', '');
    
    $this->view->aboutusdescription =  $settings->getSetting('sesariana.aboutusdescription', 'Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry.');
    $this->view->quicklinksenable =  $settings->getSetting('sesariana.quicklinksenable', '1');
    $this->view->quicklinksheading =  $settings->getSetting('sesariana.quicklinksheading', 'QUICK LINKS');
    $this->view->helpenable =  $settings->getSetting('sesariana.helpenable', '1');
    $this->view->helpheading =  $settings->getSetting('sesariana.helpheading', 'HELP');
    $this->view->socialenable =  $settings->getSetting('sesariana.socialenable', '1');
    $this->view->socialheading =  $settings->getSetting('sesariana.socialheading', 'SOCIAL');
    $this->view->facebookurl =  $settings->getSetting('sesariana.facebookurl', 'http://www.facebook.com/');
    $this->view->googleplusurl =  $settings->getSetting('sesariana.googleplusurl', 'http://plus.google.com/');
    $this->view->twitterurl =  $settings->getSetting('sesariana.twitterurl', 'https://www.twitter.com/');
    $this->view->pinteresturl =  $settings->getSetting('sesariana.pinteresturl', 'https://www.pinterest.com/');
    
    
  }

}