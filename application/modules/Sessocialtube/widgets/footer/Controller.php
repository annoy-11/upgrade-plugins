<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessocialtube_Widget_FooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_footer');

    $this->view->footerlogo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialtube.footerlogo', '');
    $this->view->logintextnonloggined = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialtube.logintext', 0);

    $this->view->paginator = Engine_Api::_()->getDbTable('socialicons', 'sessocialtube')->getSocialInfo(array('enabled' => 1));
    $this->view->footerlinks = Engine_Api::_()->getDbTable('footerlinks', 'sessocialtube')->getInfo(array('sublink' => 0, 'enabled' => 1));

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

    $this->view->facebookButton = $this->_getParam('facebook_url_path', 'http://www.facebook.com/');
    $this->view->pinterestButton = $this->_getParam('pinterest_url_path', 'https://www.pinterest.com/');
    $this->view->twitterButton = $this->_getParam('twitter_url_path', 'https://www.twitter.com/');
    $this->view->googleplusButton = $this->_getParam('googleplus_url_path', 'http://plus.google.com/');
		
		$popShow = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialtube.popupshow', 1);
		if(empty($popShow)) {
			$contentText = '<div class="socialtube_footer_top_section sesbasic_clearfix sesbasic_bxs">
  	<p><img src="application/modules/Sessocialtube/externals/images/bottom-text.png" alt=""></p><p><a href="signup">Join Now</a></p></div>';
		} else {
	    $contentText = '<div class="socialtube_footer_top_section sesbasic_clearfix sesbasic_bxs">
  	<p><img src="application/modules/Sessocialtube/externals/images/bottom-text.png" alt=""></p><p><a id="popup-signup" data-effect="signup-link mfp-zoom-in" class="popup-with-move-anim" href="#user_signup_form">Join Now</a></p></div>';
  	}
  
    $languages = Zend_Locale::getTranslationList('language', Zend_Registry::get('Locale'));
    $languageList = Zend_Registry::get('Zend_Translate')->getList();
    $local_language = $this->view->locale()->getLocale()->__toString(); 
    $local_language = explode('_', $local_language);
    
    $language = @$local_language[0] . @$local_language[1];
    if(count($languageList) == '1') {
      $this->view->content = Engine_Api::_()->getApi('settings', 'core')->getSetting("sessocialtube.footertext.en", $contentText);
    } else {
      $this->view->content = Engine_Api::_()->getApi('settings', 'core')->getSetting("sessocialtube.footertext.$language", $contentText);
    }
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $select = new Zend_Db_Select($db);
		$select->from('engine4_core_content', 'name')
		        ->where('page_id = ?', 1)
		        ->where('name LIKE ?', '%sessocialtube.header%')
		        ->limit(1);
		$this->view->info = $info = $select->query()->fetch();
  }

}
