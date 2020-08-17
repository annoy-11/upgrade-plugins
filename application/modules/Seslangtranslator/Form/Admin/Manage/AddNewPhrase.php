<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslangtranslator
 * @package    Seslangtranslator
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddNewPhrase.php 2017-08-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslangtranslator_Form_Admin_Manage_AddNewPhrase extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $this->setTitle('Add New Custom Phrase')
        ->setDescription('Here, you can translate any custom phrase from English language to selected languages. The translated text will automatically be added to the custom.csv file.');
        
    $googletranslatorapi = $settings->getSetting('seslangtranslator.googletranslatorapi', null);
    if($googletranslatorapi) {

    $localeObject = Zend_Registry::get('Locale');
    $languages = Zend_Locale::getTranslationList('language', $localeObject);
    $territories = Zend_Locale::getTranslationList('territory', $localeObject);
    $localeMultiOptions = array();
    foreach( array_keys(Zend_Locale::getLocaleList()) as $key ) {
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
      }
    }

    $translate = Zend_Registry::get('Zend_Translate');
    $languageLists = $translate->getList();
    $finallanguageArray = array_intersect_key($localeMultiOptions, $languageLists);

    $this->addElement('Textarea', 'main_language_phrase', array(
      'label' => 'Type New Phrase',
      'description' => 'Enter new phrase which you want to translate in other languages. (Only 1 phrase at a time which can be a sentence or a word.)',
      'required' => true,
      'allowEmpty' => false,
    ));

    $this->addElement('MultiCheckbox', 'convert_language', array(
      'label' => 'Target Languages',
      'description' => 'Select the languages in which you want to translate the above phrase.',
      'multiOptions' => $finallanguageArray,
      'required' => true,
      'allowEmpty' => false,
      'value' => $languageLists,
      'class' =>"checkbox_slt_sm_im",
    ));
    
    $this->addElement('Dummy', 'generatelang', array(
      'content'=> "<a class='generatelang' href='javascript:void(0);' onclick='generatelang();' style='text-decoration:none;font-weight:bold;padding-left:2px;'><i class='fa fa-language'></i> Translate Phrase</a>",
    ));
    
    foreach($finallanguageArray as $key => $lang) {
      $this->addElement('Textarea', "convert_language_phrase_$key", array(
        'label' => 'Phrase in '.$lang,
        'description' => 'This is the translated phrase for the phrase which have entered above. Below, you can edit this phrase as per your requirement before adding it to the custom.csv file.',
        //'allowEmpty' => false,
        //'required' => true,
        'class' => 'convert_language_phrase',
      ));
    }
  
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Add Phrase',
        'type' => 'submit',
        'ignore' => true
    ));
    } else {
      $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('You have not entered "Google Translation API" key in Global Settings. Please create and enter the Google Translation API Key to start translating on your website.') . "</span></div>";
      $this->addElement('Dummy', 'googleapinot', array(
        'description' => $description,
      ));
      $this->googleapinot->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    }
  }
}