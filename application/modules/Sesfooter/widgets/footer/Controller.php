<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesfooter_Widget_FooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->storage = Engine_Api::_()->storage();
		$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_footer');
    $this->view->footerlogo = $settings->getSetting('sesfooter.footerlogo', '');
    $this->view->logintextnonloggined = $settings->getSetting('sesfooter.logintext', 1);
    

    $this->view->paginator = Engine_Api::_()->getDbTable('socialicons', 'sesfooter')->getSocialInfo(array('enabled' => 1));
    $this->view->footerlinks = Engine_Api::_()->getDbTable('footerlinks', 'sesfooter')->getInfo(array('sublink' => 0, 'enabled' => 1));

    // Languages
    $translate = Zend_Registry::get('Zend_Translate');
    $languageList = $translate->getList();

    // Prepare default langauge
    $defaultLanguage = $settings->getSetting('core.locale.locale', 'en');
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

    $contentText = '<p><img src="application/modules/Sesfooter/externals/images/bottom-text.png" alt=""></p>
    <p><a href="signup">Join Now</a></p>';
  
	  $local_language = $this->view->locale()->getLocale()->__toString(); 
    $local_language = explode('_', $local_language);
    
    if(isset($local_language[0]) && isset($local_language[1]))
      $language = @$local_language[0] . '.'. @$local_language[1];
    else
      $language = $local_language[0];
    
    $this->view->content = $settings->getSetting("sesfooter.footertext.$language", $contentText);
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $footerDesign = Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_design');
    
    if($footerDesign == '6') {
      $module = $settings->getSetting('sesfooter6.module', 'user');

      $membercount = $settings->getSetting('sesfooter5.membercount', 12);
      $popularity = $settings->getSetting('sesfooter5.popularity', 'creation_date');
      
      if($module) {
      
        $table = Engine_Api::_()->getItemTable($module);
        $tableName = $table->info('name');

        $select = $table->select()->from($tableName)->limit($membercount);
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $select->order($popularity.' DESC');
        $column_exist = $db->query("SHOW COLUMNS FROM ".$tableName." LIKE 'is_delete'")->fetch();
        if (!empty($column_exist)) {
          $select->where('is_delete =?',0);
        }

        $this->view->members_results = $table->fetchAll($select);
      }
    }
  }
}