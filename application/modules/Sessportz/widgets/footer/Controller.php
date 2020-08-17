<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessportz_Widget_FooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_footer');

    $this->view->footerlogo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.footerlogo', '');

    $this->view->footerbgimage = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.footerbgimage', '');

    $this->view->paginator = Engine_Api::_()->getDbTable('socialicons', 'sessportz')->getSocialInfo(array('enabled' => 1));
    $this->view->footerlinks = Engine_Api::_()->getDbTable('footerlinks', 'sessportz')->getInfo(array('sublink' => 0, 'enabled' => 1));

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
    $sessportz_footer = Zend_Registry::isRegistered('sessportz_footer') ? Zend_Registry::get('sessportz_footer') : null;
    if(empty($sessportz_footer)) {
      return $this->setNoRender();
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

		$popShow = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.popupshow', 1);
		if(empty($popShow)) {
			$contentText = '<div class="sessportz_footer_top_section sesbasic_clearfix sesbasic_bxs">
  	<p><img src="application/modules/Sessportz/externals/images/bottom-text.png" alt=""></p><p><a href="signup">Join Now</a></p></div>';
		} else {
	    $contentText = '<div class="sessportz_footer_top_section sesbasic_clearfix sesbasic_bxs">
  	<p><img src="application/modules/Sessportz/externals/images/bottom-text.png" alt=""></p><p><a id="popup-signup" data-effect="signup-link mfp-zoom-in" class="popup-with-move-anim" href="#user_signup_form">Join Now</a></p></div>';
  	}

    $languages = Zend_Locale::getTranslationList('language', Zend_Registry::get('Locale'));
    $languageList = Zend_Registry::get('Zend_Translate')->getList();
    $local_language = $this->view->locale()->getLocale()->__toString();
    $local_language = explode('_', $local_language);

    $language = @$local_language[0] . @$local_language[1];
    if(count($languageList) == '1') {
      $this->view->content = Engine_Api::_()->getApi('settings', 'core')->getSetting("sessportz.footertext.en", $contentText);
    } else {
      $this->view->content = Engine_Api::_()->getApi('settings', 'core')->getSetting("sessportz.footertext.$language", $contentText);
    }
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $select = new Zend_Db_Select($db);
		$select->from('engine4_core_content', 'name')
		        ->where('page_id = ?', 1)
		        ->where('name LIKE ?', '%sessportz.header%')
		        ->limit(1);
		$this->view->info = $info = $select->query()->fetch();

    $this->view->news_show = $settings->getSetting('sessportz.foshow', 1);
    if($settings->getSetting('sessportz.foshow', 1)) {
        $table = Engine_Api::_()->getItemTable($settings->getSetting('sessportz.fo.module', 'album'));
        $tableName = $table->info('name');
        $select = $table->select()->from($tableName)->limit(2);
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $popularitycriteria = $settings->getSetting('sessportz.fo.popularitycriteria', 'creation_date');

        $popularitycriteria_exist = $db->query("SHOW COLUMNS FROM ".$tableName." LIKE '".$popularitycriteria."'")->fetch();
        if (!empty($popularitycriteria_exist)) {
            $select->order("$popularitycriteria DESC");
        } else {
            $select->order('creation_date DESC');
        }
        $this->view->results = $result = $table->fetchAll($select);
    }
  }

}
