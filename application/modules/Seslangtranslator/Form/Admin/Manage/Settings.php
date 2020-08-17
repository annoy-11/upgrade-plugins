<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslangtranslator
 * @package    Seslangtranslator
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Settings.php 2017-08-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslangtranslator_Form_Admin_Manage_Settings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $this->setTitle('Manage Language Translations for Plugin CSV Files')
       ->setDescription('Here, you can create csv file of the selected plugins in any chosen language. If you are translating csv files in a language for first time, then a new language pack will be automatically created. When you translate any csv file in any existing language on your website, then the new csv file in that language will be appended to the existing pack.');

    $googletranslatorapi = $settings->getSetting('seslangtranslator.googletranslatorapi', null);
    if($googletranslatorapi) {
    
      $this->addElement('Dummy', 'main_language', array(
        'label' => 'Default Language',
        'content'=> "English [en]",
      ));

      // Get all language from google for translation
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://translation.googleapis.com/language/translate/v2/languages?key='.$googletranslatorapi."&target=en");
      // receive server response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $server_output = curl_exec($ch); 
      $server_output = json_decode($server_output, true);
      curl_close($ch);

      $googleLanguages = $server_output['data']['languages'];
      $googleLanguagesArray = array();
      if($googleLanguages) { 
        foreach ($googleLanguages as $key => $value) {
          $googleLanguagesArray[$value['language']] = $value['name']."[".$value['language']."]";
        }
      }

      $files = glob(APPLICATION_PATH . "/application/languages/en/*.csv");
      $allLanguageFiles = array('all' => 'All');
      foreach($files as $file) {
        $basefilename = basename($file);
        $allLanguageFiles[$basefilename] = $basefilename;
      }

      $this->addElement('MultiCheckbox', 'main_languagefiles', array(
        'label' => 'CSV Files of Plugins to Translate',
        'description' => 'Choose from here the plugin csv files that you want to translate in other language.',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => $allLanguageFiles,
        'class' => 'checkBoxClass',
      ));
          
      $this->addElement('Select', 'convert_languages', array(
        'label' => 'Target Language',
        'description' => 'Select the language in which you want to translate above selected csv files. (A new language pack will be automatically created, if there is no existing language pack for the selected language.',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => $googleLanguagesArray,
        'class' => 'checkBoxClassconvert',
      ));

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