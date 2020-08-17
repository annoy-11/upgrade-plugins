<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesuserimport
 * @package    Sesuserimport
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Import.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserimport_Form_Admin_Import extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Upload CSV file only');

    $this->addElement('File', 'csvfile', array(
        'label' => '',
        'allowEmpty' => false,
        'required' => true,
    ));
    $this->csvfile->addValidator('Extension', false, 'csv');



    $this->addElement('Select', 'timezone', array(
      'label' => 'Timezone',
      'value' => $settings->getSetting('core.locale.timezone'),
      'multiOptions' => array(
        'US/Pacific' => '(UTC-8) Pacific Time (US & Canada)',
        'US/Mountain' => '(UTC-7) Mountain Time (US & Canada)',
        'US/Central' => '(UTC-6) Central Time (US & Canada)',
        'US/Eastern' => '(UTC-5) Eastern Time (US & Canada)',
        'America/Halifax' => '(UTC-4)  Atlantic Time (Canada)',
        'America/Anchorage' => '(UTC-9)  Alaska (US & Canada)',
        'Pacific/Honolulu' => '(UTC-10) Hawaii (US)',
        'Pacific/Samoa' => '(UTC-11) Midway Island, Samoa',
        'Etc/GMT-12' => '(UTC-12) Eniwetok, Kwajalein',
        'Canada/Newfoundland' => '(UTC-3:30) Canada/Newfoundland',
        'America/Buenos_Aires' => '(UTC-3) Brasilia, Buenos Aires, Georgetown',
        'Atlantic/South_Georgia' => '(UTC-2) Mid-Atlantic',
        'Atlantic/Azores' => '(UTC-1) Azores, Cape Verde Is.',
        'Europe/London' => 'Greenwich Mean Time (Lisbon, London)',
        'Europe/Berlin' => '(UTC+1) Amsterdam, Berlin, Paris, Rome, Madrid',
        'Europe/Athens' => '(UTC+2) Athens, Helsinki, Istanbul, Cairo, E. Europe',
        'Europe/Moscow' => '(UTC+3) Baghdad, Kuwait, Nairobi, Moscow',
        'Iran' => '(UTC+3:30) Tehran',
        'Asia/Dubai' => '(UTC+4) Abu Dhabi, Kazan, Muscat',
        'Asia/Kabul' => '(UTC+4:30) Kabul',
        'Asia/Yekaterinburg' => '(UTC+5) Islamabad, Karachi, Tashkent',
        'Asia/Calcutta' => '(UTC+5:30) Bombay, Calcutta, New Delhi',
        'Asia/Katmandu' => '(UTC+5:45) Nepal',
        'Asia/Omsk' => '(UTC+6) Almaty, Dhaka',
        'Indian/Cocos' => '(UTC+6:30) Cocos Islands, Yangon',
        'Asia/Krasnoyarsk' => '(UTC+7) Bangkok, Jakarta, Hanoi',
        'Asia/Hong_Kong' => '(UTC+8) Beijing, Hong Kong, Singapore, Taipei',
        'Asia/Tokyo' => '(UTC+9) Tokyo, Osaka, Sapporto, Seoul, Yakutsk',
        'Australia/Adelaide' => '(UTC+9:30) Adelaide, Darwin',
        'Australia/Sydney' => '(UTC+10) Brisbane, Melbourne, Sydney, Guam',
        'Asia/Magadan' => '(UTC+11) Magadan, Solomon Is., New Caledonia',
        'Pacific/Auckland' => '(UTC+12) Fiji, Kamchatka, Marshall Is., Wellington',
      ),
    ));
    $this->timezone->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));

    // Languages
    $translate = Zend_Registry::get('Zend_Translate');
    $languageList = $translate->getList();

    //$currentLocale = Zend_Registry::get('Locale')->__toString();
    // Prepare default langauge
    $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
    if( !in_array($defaultLanguage, $languageList) ) {
      if( $defaultLanguage == 'auto' && isset($languageList['en']) ) {
        $defaultLanguage = 'en';
      } else {
        $defaultLanguage = null;
      }
    }

    // Prepare language name list
    $localeObject = Zend_Registry::get('Locale');

    $languageNameList = array();
    $languageDataList = Zend_Locale_Data::getList($localeObject, 'language');
    $territoryDataList = Zend_Locale_Data::getList($localeObject, 'territory');

    foreach( $languageList as $localeCode ) {
      $languageNameList[$localeCode] = Zend_Locale::getTranslation($localeCode, 'language', $localeCode);
      if( empty($languageNameList[$localeCode]) ) {
        list($locale, $territory) = explode('_', $localeCode);
        $languageNameList[$localeCode] = "{$territoryDataList[$territory]} {$languageDataList[$locale]}";
      }
    }
    $languageNameList = array_merge(array(
      $defaultLanguage => $defaultLanguage
    ), $languageNameList);

    if(count($languageNameList)>1){
      $this->addElement('Select', 'language', array(
        'label' => 'Language',
        'multiOptions' => $languageNameList,
      ));
      $this->language->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
    }
    else{
      $this->addElement('Hidden', 'language', array(
        'value' => current((array)$languageNameList),
        'order' => 1002
      ));
    }

    $topStructure = Engine_Api::_()->fields()->getFieldStructureTop('user');
    if (count($topStructure) == 1 && $topStructure[0]->getChild()->type == 'profile_type') {
        $profileTypeField = $topStructure[0]->getChild();
        $options = $profileTypeField->getOptions();
        $options = $profileTypeField->getElementParams('user');
        unset($options['options']['order']);
        unset($options['options']['multiOptions']['']);
        $optionValues = array();
        foreach ($options['options']['multiOptions'] as $key => $option) {
          $optionValues[] = $key;
        }

        $this->addElement('Select', 'profile_types', array(
            'label' => 'Profile Types',
            'multiOptions' => $options['options']['multiOptions'],
            'value' => $optionValues
        ));
    }

    //Element member level
    $authorizationTable = Engine_Api::_()->getDbtable('levels', 'authorization');

    $selectAuth = $authorizationTable->select()
                                    ->from( $authorizationTable->info('name'), array('level_id','title'));
    $levelResults =  $authorizationTable->fetchAll($selectAuth);
    $memberLevelsArray = array();
    foreach($levelResults as $key  => $levelResult) {
        if($levelResult->level_id == '5') continue;
        $memberLevelsArray[$levelResult->level_id] = $levelResult->title;
    }

    $defaultLevel = Engine_Api::_()->sesuserimport()->defaultLevel();

    $this->addElement('Select', 'level_id',array(
        'label'  => 'Select Member Level',
        'required'  => true,
        'multiOptions'  => $memberLevelsArray,
        'value' => $defaultLevel['level_id'],
    ));

    // Init level
    $networkMultiOptions = array(); //0 => ' ');
    $networks = Engine_Api::_()->getDbtable('networks', 'network')->fetchAll();
    foreach( $networks as $row ) {
      $networkMultiOptions[$row->network_id] = $row->getTitle();
    }
    $this->addElement('Multiselect', 'network_id', array(
      'label' => 'Networks',
      'multiOptions' => $networkMultiOptions,
    ));

    $this->addElement('Checkbox', 'approved', array(
        'label' => 'Approved?',
        'validators' => array(
            'notEmpty',
            array('GreaterThan', false, array(0)),
        ),
    ));

    $this->addElement('Checkbox', 'verified', array(
        'label' => 'Verified?',
        'validators' => array(
            'notEmpty',
            array('GreaterThan', false, array(0)),
        ),
    ));

    $this->addElement('Checkbox', 'enabled', array(
        'label' => 'Enabled?',
        'validators' => array(
            'notEmpty',
            array('GreaterThan', false, array(0)),
        ),
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Import',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'onclick' => 'javascript:parent.Smoothbox.close()',
        'link' => true,
        'prependText' => ' or ',
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }
}
