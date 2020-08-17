<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslangtranslator
 * @package    Seslangtranslator
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2017-08-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslangtranslator_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslangtranslator_admin_main', array(), 'seslangtranslator_admin_main_manage');
    $this->view->form = new Seslangtranslator_Form_Admin_Manage_Settings();
  }
  
  public function addnewpackAction() {

    $enFolderFilePath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . 'en';

    // Get all existing csv file
    if (file_exists(@$enFolderFilePath)) {

      $file = $this->_getParam('langs', null);
      $file_type = strtolower( end( explode('.', @$file ) ) );
      
      ini_set('max_execution_time', 0);
      set_time_limit(0);
      
      if ( ($file !== '.') && ($file !== '..') && (in_array( $file_type, array('csv'))) ) {
      
        $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/'.$file, 'null', array('delimiter' => ';','enclosure' => '"'));

        if( !empty($tmp['null']) && is_array($tmp['null']) )
          $phrases = $tmp['null'];
        else
          $phrases = array();
          
        $specialValues = $this->specialValuesArray();
        
        $convert_languages = $this->_getParam('convert_languages', null);
        
        // Check convert languages folder exist or not
        $targetFolder = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . $convert_languages;

        if (!is_dir($targetFolder)) {
          mkdir($targetFolder);
          chmod($targetFolder, 0777);
        }
        
        $translateTextArray = array();
        foreach($phrases as $key => $phrase) {
          $phrase = strtr($phrase, $specialValues); 
          $getTranslateData = $this->getTranslateData($phrase, 'en', $convert_languages);
          if($getTranslateData['HTTPCODE'] == 200) {
            $translatedText = $getTranslateData['translatedText'];
          }
          $replace = array_keys($specialValues);
          $find    = array_values($specialValues);
          $translatedText = str_ireplace($find, $replace, $translatedText);
          $translateTextArray[$key] = htmlspecialchars_decode($translatedText);
        }
        
        if($translateTextArray) {
          // Check File exist or not 
          $targetFilePath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . $convert_languages . DIRECTORY_SEPARATOR . $file;
          if (!file_exists($targetFilePath)) {
            touch($targetFilePath);
            chmod($targetFilePath, 0777);
            $writer = new Engine_Translate_Writer_Csv($targetFilePath);
            $writer->setTranslations($translateTextArray);
            $writer->write();
          } else {
            chmod($targetFilePath, 0777);
            $writer = new Engine_Translate_Writer_Csv($targetFilePath);
            $writer->setTranslations($translateTextArray);
            $writer->write();
          }
        }
      }
    }
    echo json_encode(array('status' => 1));
    die;
  }
  
  
  public function missingPhraseAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslangtranslator_admin_main', array(), 'seslangtranslator_admin_main_misssingphrase');
    $this->view->form = $form = new Seslangtranslator_Form_Admin_Manage_MissingPhrase();
    $this->view->missing_lang = Zend_Controller_Front::getInstance()->getRequest()->getParam('missing_lang', 'en');
    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues(); 
      //$main_language = 'en';
      $convert_language = $values['convert_language'];
      $phrases = explode('||||',$values['convert_language_phrase_'.$convert_language]);

      foreach($phrases as $phrase) {
      
        $finalText = explode('";"', trim($phrase,'"'));
        $targetFile = APPLICATION_PATH . '/application/languages/'.$convert_language.'/custom.csv';

        if( !file_exists($targetFile) ) {
          touch($targetFile);
          chmod($targetFile, 0777);
        }
        if( file_exists($targetFile) ) {
          $writer = new Engine_Translate_Writer_Csv($targetFile);
          $writer->setTranslations(array(
            $finalText[0] => $finalText[1],
          ));
          $writer->write();
          @Zend_Registry::get('Zend_Cache')->clean();
        }
      }
      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }
  
  public function convertmisssinglangAction() {
  
    $main_language_phrase = $this->_getParam('main_language_phrase', null);
    $langs = $this->_getParam('langs', null);

    $targetFile = APPLICATION_PATH . '/application/languages/'.$langs.'/custom.csv';
    if( !file_exists($targetFile) ) {
      touch($targetFile);
      chmod($targetFile, 0777);
    }

    if($main_language_phrase){
      $main_language_phrases = explode('||||', $main_language_phrase);
    }
    $specialValues = $this->specialValuesArray();
    $allGeneratedLang = '';
    ini_set('max_execution_time', 0);
    set_time_limit(0);
    foreach($main_language_phrases as $main_language_phrase) {
    
      if(empty($main_language_phrase)) continue;
      
      $langArray = explode('";"', trim($main_language_phrase,'"'));
      $phrase = strtr($langArray[1], $specialValues); 
      $getTranslateData = $this->getTranslateData($phrase, 'en', $langs);
      
      if($getTranslateData['HTTPCODE'] == 200) {
        $getTranslateText = $getTranslateData['translatedText'];
      }
      
      if($lang == 'en')
        $getTranslateText = $main_language_phrase;
      
      $replace = array_keys($specialValues);
      $find    = array_values($specialValues);
      $getTranslateText = str_ireplace($find, $replace, $getTranslateText);
      $getTranslateText = htmlspecialchars_decode($getTranslateText);

      if( file_exists($targetFile) ) {
        $writer = new Engine_Translate_Writer_Csv($targetFile);
        $writer->setTranslations(array(
          $langArray[0] => htmlspecialchars_decode($getTranslateText),
        ));
        $writer->write();
        @Zend_Registry::get('Zend_Cache')->clean();
      }
    }
    echo json_encode(array('status' => 1));
    die;
  }

  public function addNewPhraseAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslangtranslator_admin_main', array(), 'seslangtranslator_admin_main_addnewpack');
    $this->view->form = $form = new Seslangtranslator_Form_Admin_Manage_AddNewPhrase();
    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      $main_language = $values['main_language_phrase'];
      $convert_languages = $values['convert_language'];
      foreach($convert_languages as $convert_language) {

        $targetFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . $convert_language . DIRECTORY_SEPARATOR . 'custom.csv';
        if( !file_exists($targetFile) ) {
          touch($targetFile);
          chmod($targetFile, 0777);
        }
        if( file_exists($targetFile) ) {
          $writer = new Engine_Translate_Writer_Csv($targetFile);
          $writer->setTranslations(array(
            $main_language => $values['convert_language_phrase_'.$convert_language],
            '' => '',
          ));
          $writer->write();
          @Zend_Registry::get('Zend_Cache')->clean();
        }
      }
      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function convertlangAction() {
  
    $main_language_phrase = $this->_getParam('main_language_phrase', null);
    $langs = $this->_getParam('langs', null);
    if($langs)
      $langs = explode(',', $langs);
    
    $allGeneratedTexts = array();
    foreach($langs as $lang) {
    
      if(empty($lang)) continue;
      
      $getTranslateData = $this->getTranslateData($main_language_phrase, 'en', $lang);
      if($getTranslateData['HTTPCODE'] == 200) {
        $translatedText = $getTranslateData['translatedText'];
      }
      if($lang == 'en')
        $translatedText = $main_language_phrase;

      $allGeneratedTexts[$lang] = htmlspecialchars_decode($translatedText);
    }
    echo json_encode(array('allGeneratedLang' => $allGeneratedTexts, 'status' => 1));
    die;
  }


  public function manageLangPacksAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslangtranslator_admin_main', array(), 'seslangtranslator_admin_main_managelangpacks');
    
    $translate = Zend_Registry::get('Zend_Translate');

    // Prepare language list
    $this->view->languageList = $languageList = $translate->getList();

    // Prepare default langauge
    $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
    if( !in_array($defaultLanguage, $languageList) ) {
      if( $defaultLanguage == 'auto' && isset($languageList['en']) ) {
        $defaultLanguage = 'en';
      } else {
        $defaultLanguage = null;
      }
    }
    $this->view->defaultLanguage = $defaultLanguage;

    // Init default locale
    $localeObject = Zend_Registry::get('Locale');

    $languages = Zend_Locale::getTranslationList('language', $localeObject);
    $territories = Zend_Locale::getTranslationList('territory', $localeObject);

    $localeMultiOptions = array();
    foreach( /*array_keys(Zend_Locale::getLocaleList())*/ $languageList as $key ) {
      $languageName = null;
      if( !empty($languages[$key]) ) {
        $languageName = $languages[$key];
      } else {
        $tmpLocale = new Zend_Locale($key);
        $region = $tmpLocale->getRegion();
        $language = $tmpLocale->getLanguage();
        if( !empty($languages[$language]) && !empty($territories[$region]) ) {
          $languageName =  $languages[$language] . ' (' . $territories[$region] . ')';
        }
      }

      if( $languageName ) {
        $localeMultiOptions[$key] = $languageName . ' [' . $key . ']';
      } else {
        $localeMultiOptions[$key] = $this->view->translate('Unknown')  . ' [' . $key . ']';
      }
    }
    $localeMultiOptions = array_merge(array(
      $defaultLanguage => $defaultLanguage
    ), $localeMultiOptions);
    $this->view->languageNameList = $localeMultiOptions;

  }

  public function getTranslateData($text, $main_language = 'en', $convert_language = '') {
  
    $googletranslatorapi = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslangtranslator.googletranslatorapi', null);
    
    $postdata = array();
    $postdata['key'] = $googletranslatorapi;
    $postdata['q'] = $text;
    $postdata['source'] = $main_language;
    $postdata['target'] = $convert_language;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/language/translate/v2');
    // receive server response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));
    $server_output = curl_exec($ch); 
    $server_output = json_decode($server_output, true);
    //Get information regarding a specific transfer
    $information = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    
    
    return array('translatedText' => $server_output['data']['translations'][0]['translatedText'], 'HTTPCODE' => $information);
  }
  
  public function specialValuesArray() {
  
    return array(
    '{item:$subject}' => 'SES_SES_1', 
    '{others:$otherItems}' => 'SES_SES_2',
    '%s' => 'SES_SES_3',
    '&nbsp;' => 'SES_SES_4',
    '(subject)' => 'SES_SES_5',
    '(object)' => 'SES_SES_6',
    '<br /><br />' => 'SES_SES_8',
    '</a>' => 'SES_SES_9',
    '(%d)' => 'SES_SES_10',
    '{translate:$label}' => 'SES_SES_tr_la',
    '{var:$value}' => 'SES_SES_var_val',
    '{item:$object}' => 'SES_SES_itm_obj',
    '{actors:$subject:$object}:' => 'SES_SES_actr_sub_obj',
    '{body:$body}' => 'SES_SES_bo_bo',
    '{var:$label}' => 'SES_SES_va_la',
    '{var:$type}' => 'SES_SES_va_tpe',
    '{item:$object:$label}' => 'SES_SES_it_ob_la',
    '[sender_title]' => 'SES_SES_se_ti',
    '[header]' => 'SES_SES_header',
    'http://[host][object_link]' => 'SES_SES_htt_link',
    '[footer]' => 'SES_SES_ft',
    '%1$s' => 'SES_23_SES',
    '%2$s' => 'SES24SES',
    '{var:$count}' => 'SES_SES_vr_cnt',
    '(s)' => 'SES26SES',
    '{item:$owner}' => 'SES_SES_it_onr',
    '{item:$object:album}' => 'SES_SES_it_ob_al',
    '{item:$object:photo}' => 'SES_SES_it_ob_poto',
    '{item:$action:new photos}' => 'SES_SES_it_ac_nw_pots',
    '\r\n' => 'SES_per_s_SES',
    "<a href='%s'>" => 'SES_a_SES',
    '%d' => 'SESSES',
    '{item:$object:blog entry}' => 'SES_blg_etry_SES',
    '[object_title]' => 'SES__ojt_tle_SES',
    '&#187' => 'SES__187_SES',
    '{item:$object:classified listing}' => 'SES_cl_lit_SES',
    '<span>' => 'SES_op_spn_SES',
    '</span>' => 'SES_cl_spn_SES',
    'http://www.yoursite.com/pages/[url]' => 'SES_pgs_url_SES',
    '%1$d' => 'SES_41SES',
    '{name}' => 'SES_nme_SES',
    '{fileListMax}' => 'SES_file_mx_SES',
    '{fileListSizeMax}' => 'SES_fle_li_mx_SES',
    '<code>' => 'SES_op_cd_SES',
    '</code>' => 'SES__cd_SES',
    '{text}' => 'SES_txt_SES',
    '%max%' => 'SES_mx_SES',
    '%value%' => 'SES_vle_SES',
    '%hostname%' => 'SES_ht_nme_SES',
    '%localPart%' => 'SES_lo_prt_SES',
    '[recipient_title]' => 'SES_rcpt_tle_SES',
    '[sender_email]' => 'SES_se_eml_SES',
    '[message]' => 'SES_msg_SES',
    '[error_report]' => 'SES_eor_rpt_SES',
    '[password]' => 'SES_pwds_SES',
    '[date]' => 'SES_dte_SES',
    '{item:$object:posted}' => 'SES__postd_SES',
    '{itemParent:$object::event topic}' => 'SES_prnt_SES',
    '{itemParent:$object:event}' => 'SES_60SES',
    '{item:$object:topic}' => 'SES_61SES',
    '[object_parent_title]' => 'SES_62SES',
    '{itemParent:$object:forum}' => 'SES_63SES',
    '{item:$postGuid:posted}' => 'SES_64SES',
    '{itemParent:$object::group topic}' => 'SES_65SES',
    '{itemParent:$object:group}:' => 'SES_66SES',
    '<style>' => 'SES_67SES',
    '</style>' => 'SES_68SES',
    'http://[host][message_link]' => 'SES_69SES',
    '{item:$object:video}' => 'SES_70SES',
    '[object_type_name]' => 'SES_71SES',
    '%3$s' => 'SES_72SES',
    '{item:$object:poll}' => 'SES_em_ct_ll_SES',
    '[object_link]' => 'SES_oct_lnk_SES',
    '[subscription_title]' => 'SES_subf_tle_SES',
    '[subscription_description]' => 'SES_subs_desptn_SES',
    '[subscription_terms]' => 'SES_subs_trms_SES',
    '{item:$object:playlist}' => 'SES_it_plst_SES',
    '[object_description]' => 'SES_SES_ojt_des',
    '{item:$object:message}' => 'SES_SES_itm_msg',
    '&quot;' => 'SES81_SES',
    '[category_name]' => 'SES82_SES',
    '{var:$commentLink}' => 'SES83_SES',
    '<i>' => 'SES84_SES',
    '</i>' => 'SES85_SES',
    '<b>' => 'SES86_SES',
    '</b>' => 'SES87_SES',
    '[invoice_body]' => 'SES88SES',
    '[event_title]' => 'SES89SES',
    '[ticket_body]' => 'SES_90_SES',
    '[description]' => 'SES_91_SES',
    '[site_title]' => 'SES_92_SES',
    '[questionreply]' => 'SES_93_SES',
    '[event_description]' => 'SES_94_SES',
    'http://[host]' => 'SES_95_SES',
    '[birthday_content]' => 'SES_96_SES',
    '[birthday_subject]' => 'SES_97_SES',
    '{item:$object:photos}' => 'SES_SES_it_ob_potos',
    '<strong>' => 'SES_SES_op_strng',
    '</strong>' => 'SES_SES_strng',
    '{var:$pokedPageLink}' => 'SES_SES_vr_pkd_lnk',
    '{item:$playlist}' => 'SES_SES_it_plst',
    '[sender_name]' => 'SES_SES_se_nme',
    '[content]' => 'SES_SES_connt'
    );
  }
}