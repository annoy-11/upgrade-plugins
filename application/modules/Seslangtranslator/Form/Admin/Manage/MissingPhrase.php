<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslangtranslator
 * @package    Seslangtranslator
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: MissingPhrase.php 2017-08-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslangtranslator_Form_Admin_Manage_MissingPhrase extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $this->setTitle('Add Missing Phrases')
        ->setDescription('Here, you can find the phrases which were missed during the translation process and add them in the custom.csv file in the selected languages. Phrases will be added automatically to the custom.csv file when you click on the "Add Phrases" link. Note: Since, it is an automatic process, we do not recommend you to edit anything in the Missing Phrases section below. If you want any change then please edit the phrases in the custom.csv file later.');
        
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
      
      $missing_lang = Zend_Controller_Front::getInstance()->getRequest()->getParam('missing_lang', 'en');
      
      $this->addElement('Dummy', 'main_language', array(
        'label' => 'Default Language',
        'content'=> "English [en]",
      ));

      $this->addElement('Select', 'convert_language', array(
        'label' => 'Target Language',
        'description' => 'Select the language in which you want to translate the missing phrases.',
        'multiOptions' => $finallanguageArray,
        'required' => true,
        'allowEmpty' => false,
        'class' =>"checkbox_slt_sm_im",
        'value' => $missing_lang,
        'onchange' => 'selectlanguage(this.value)',
      ));
      
      if($missing_lang != 'en') {
      
        // Assign basic locale info
        $localeObject = new Zend_Locale($locale);
        $locale = $localeObject->toString();

        // Query plural system for max and sample space
        $sample = array();
        $max    = 0;
        for ($i = 0; $i <= 1000; $i++) {
          $form = Zend_Translate_Plural::getPlural($i, $locale);
          $max  = max($max, $form);
          if (@count($sample[$form]) < 3) {
            $sample[$form][] = $i;
          }
        }
        $this->view->pluralFormCount  = ( $max + 1 );
        $this->view->pluralFormSample = $sample;

        // Get initial and default values
        $baseMessages = $translate->getMessages('en');
        if( $translate->isAvailable($missing_lang) ) {
          $currentMessages = $translate->getMessages($missing_lang);
        } else {
          $currentMessages = array(); // @todo this should redirect or smth
        }

        // Get phrases that are not in the english pack?
        if( !empty($currentMessages) && $missing_lang != 'en' ) {
          $missingBasePhrases = array_diff_key($currentMessages, $baseMessages);
          $missingBasePhrases = array_combine(array_keys($missingBasePhrases), array_keys($missingBasePhrases)); 
          $baseMessages = array_merge($baseMessages, $missingBasePhrases); 
        }
      
        // Build the fancy array
        $resultantMessages = array();
        $missing = 0;
        $index   = 0;
        foreach( $baseMessages as $key => $value ) {
          // Build
          $composite = array(
            'uid' => ++$index,
            'key' => $key,
            'original' => $value,
            'plural' => (bool) is_array($value),
          );

          // filters, plurals, and missing, oh my.
          if( isset($currentMessages[$key]) ) {
            if( 'missing' == $show ) {
              continue;
            }
            if( is_array($value) && !is_array($currentMessages[$key]) ) {
              $composite['current'] = array($currentMessages[$key]);
            } else if( !is_array($value) && is_array($currentMessages[$key]) ) {
              $composite['current'] = current($currentMessages[$key]);
            } else {
              $composite['current'] = $currentMessages[$key];
            }
          } else {
            if( 'translated' == $show ) {
              continue;
            }
            if( is_array($value) ) {
              $composite['current'] = array();
            } else {
              $composite['current'] = '';
            }
            $missing++;
          }

          // Do search
          if( $search && !$this->_searchArrayRecursive($search, $composite) ) {
            continue;
          }
          // Add
          $resultantMessages[] = $composite;
        }
        $temparray = '';
        foreach($resultantMessages as $resultantMessage) {
          if(empty($resultantMessage['current'])) {
            if(empty($resultantMessage['original'])) continue;
            $temparray .= '"'.$resultantMessage['key'].'";"'.$resultantMessage['original'].'"||||';
          }
        }
      }

      if($temparray) {
      
        $this->addElement('Textarea', 'main_language_phrase', array(
          'label' => 'Missing Phrases',
          'description' => 'Here you can find the missing phrases from the above selected language pack. If you want, you can also enter custom phrases here by following the format used for missing phrases.',
          'required' => true,
          'allowEmpty' => false,
          'value' => strip_tags($temparray),
        ));
        
        $this->addElement('Dummy', 'generatelang', array(
          'content'=> "<a class='generatelang' href='javascript:void(0);' onclick='generatelang();'  style='text-decoration:none;font-weight:bold;padding-left:2px;'><i class='fa fa-language'></i> Translate Phrases</a>",
        ));

        $this->addElement('Textarea', "convert_language_phrase_$missing_lang", array(
          'label' => 'Convert Language Phrase',
          'description' => 'You can edit this converted phrase according to you',
          'allowEmpty' => false,
          'required' => true,
          'class' => 'convert_language_phrase',
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_("There are no phrases missing in this language, please choose another Target Language.") . "</span></div>";
        $this->addElement('Dummy', 'missing', array(
            'description' => $description,
        ));
        $this->missing->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      }
    
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
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