<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Fields.php  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Quicksignup_Form_Signup_Fields extends Quicksignup_Form_Signup_Standard
{
    protected $_emailAntispamEnabled = false;
    protected $_orgEmailFieldName = "email";
    protected $_emailFieldName;

  public function init()
  {
      $this
          ->setIsCreation(true)
          ->setItem(Engine_Api::_()->user()->getUser(null));

      parent::init();
      $this->removeElement('submit');
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->_emailAntispamEnabled = ($settings
        ->getSetting('core.spam.email.antispam.signup', 1) == 1) &&
      empty($_SESSION['facebook_signup']) &&
      empty($_SESSION['twitter_signup']) &&
      empty($_SESSION['janrain_signup']);

    $inviteSession = new Zend_Session_Namespace('invite');

    // Init form
      $settings = Engine_Api::_()->getApi('settings', 'core');
      if($settings->getSetting('quicksignup_title', 0)){
          $this->setTitle($settings->getSetting('quicksignup_titletext','Create Account'));
      }
      if($settings->getSetting('quicksignup_description', 0)){
          $this->setDescription($settings->getSetting('quicksignup_descriptiontext','You can signup!!'));
      }

      $this->setAttrib('id', 'signup_account_form');

      $formDescription = $settings->getSetting('quicksignup_field_descriptions',0);
    // Element: name (trap)
    $this->addElement('Text', 'name', array(
      'class' => 'signup-name',
      'label' => 'Name',
      'validators' => array(
	      array('StringLength', true, array('max' => 0)))));

    $this->name->getValidator('StringLength')->setMessage('An error has occured, please try again later.');

      $order = Engine_Api::_()->getDbTable('enablefields','quicksignup')->getField('email');
      $orderIndex = $order->order;

    // Element: email
    $emailElement = $this->addEmailElement(array(
      'label' => 'Email Address',
      'description' => $formDescription ? 'You will use your email address to login.' : '',
      'required' => true,
      'allowEmpty' => false,
      'validators' => array(
        array('NotEmpty', true),
        array('EmailAddress', true),
        array('Db_NoRecordExists', true, array(Engine_Db_Table::getTablePrefix() . 'users', 'email'))
      ),
      'order'=>$orderIndex,
      'filters' => array(
        'StringTrim'
      ),
      // fancy stuff
      'inputType' => 'email',
      'autofocus' => 'autofocus',
    ));

    $emailElement->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
    $emailElement->getValidator('NotEmpty')->setMessage('Please enter a valid email address.', 'isEmpty');
    $emailElement->getValidator('Db_NoRecordExists')->setMessage('Someone has already registered this email address, please use another one.', 'recordFound');
    $emailElement->getValidator('EmailAddress')->getHostnameValidator()->setValidateTld(false);
    // Add banned email validator
    $bannedEmailValidator = new Engine_Validate_Callback(array($this, 'checkBannedEmail'), $emailElement);
    $bannedEmailValidator->setMessage("This email address is not available, please use another one.");
    $emailElement->addValidator($bannedEmailValidator);
    
    if( !empty($inviteSession->invite_email) ) {
      $emailElement->setValue($inviteSession->invite_email);
    }

      if( $settings->getSetting('quicksignup.email.conformation',0) > 0 ) {

          $this->addElement('Text', 'emailconf', array(
              'label' => 'Email Again',
              'description' => $formDescription ? 'Enter your email again for confirmation.' : '',
              'required' => true,
              'validators' => array(
                  array('NotEmpty', true),
              ),
              'order' => $orderIndex + 1
          ));

          $this->emailconf->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
          $this->emailconf->getValidator('NotEmpty')->setMessage('Please make sure the "email" and "email again" fields match.', 'isEmpty');

          $specialValidator = new Engine_Validate_Callback(array($this, 'checkEmailConfirm'), $emailElement);
          $specialValidator->setMessage('Email did not match', 'invalid');
          $this->emailconf->addValidator($specialValidator);
      }
    // Element: code
      $order = Engine_Api::_()->getDbTable('enablefields','quicksignup')->getField('invite_only');
      $orderIndex = $order->order;
    if( $settings->getSetting('user.signup.inviteonly') > 0 && $order->display == 1) {
      $codeValidator = new Engine_Validate_Callback(array($this, 'checkInviteCode'), $emailElement);
      $codeValidator->setMessage("This invite code is invalid or does not match the selected email address");
      $this->addElement('Text', 'code', array(
        'label' => 'Invite Code',
        'required' => true,
          'order'=>$order->order
      ));
      $this->code->addValidator($codeValidator);

      if( !empty($inviteSession->invite_code) ) {
        $this->code->setValue($inviteSession->invite_code);
      }
    }

    if( $settings->getSetting('user.signup.random', 0) == 0 && 
        empty($_SESSION['facebook_signup']) && 
        empty($_SESSION['twitter_signup']) && 
        empty($_SESSION['janrain_signup']) ) {

    $order = Engine_Api::_()->getDbTable('enablefields','quicksignup')->getField('password');
    $orderIndex = $order->order;
        if($order->display == 1) {
            // Element: password
            $this->addElement('Password', 'password', array(
                'label' => 'Password',
                'description' => $formDescription ? 'Passwords must be at least 6 characters in length.' : '',
                'required' => true,
                'allowEmpty' => false,
                'validators' => array(
                    array('NotEmpty', true),
                    array('StringLength', false, array(6, 32)),
                ),
                'order' => $orderIndex,
                //'tabindex' => $tabIndex++,
            ));
            $this->password->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
            $this->password->getValidator('NotEmpty')->setMessage('Please enter a valid password.', 'isEmpty');
            if ($settings->getSetting('quicksignup_password_conformation', 0)) {

                // Element: passconf
                $this->addElement('Password', 'passconf', array(
                    'label' => 'Password Again',
                    'description' => $formDescription ? 'Enter your password again for confirmation.' : '',
                    'required' => true,
                    'validators' => array(
                        array('NotEmpty', true),
                    ),
                    'order' => $orderIndex + 1,
                    //'tabindex' => $tabIndex++,
                ));
                $this->passconf->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
                $this->passconf->getValidator('NotEmpty')->setMessage('Please make sure the "password" and "password again" fields match.', 'isEmpty');

                $specialValidator = new Engine_Validate_Callback(array($this, 'checkPasswordConfirm'), $this->password);
                $specialValidator->setMessage('Password did not match', 'invalid');
                $this->passconf->addValidator($specialValidator);
            }
        }
    }

    // Element: username
      $order = Engine_Api::_()->getDbTable('enablefields','quicksignup')->getField('profile_address');
      $orderIndex = $order->order;
    if( $settings->getSetting('user.signup.username', 1) > 0 && $order->display == 1) {
      $description = Zend_Registry::get('Zend_Translate')
          ->_('This will be the end of your profile link, for example: <br /> ' .
              '<span id="profile_address">http://%s</span>');
      $description = sprintf($description, $_SERVER['HTTP_HOST']
          . Zend_Controller_Front::getInstance()->getRouter()
          ->assemble(array('id' => 'yourname'), 'user_profile'));

      $this->addElement('Text', 'username', array(
        'label' => 'Profile Address',
        'description' => $formDescription ? $description : '',
        'required' => true,
        'allowEmpty' => false,
        'validators' => array(
          array('NotEmpty', true),
          array('Alnum', true),
          array('StringLength', true, array(4, 64)),
          array('Regex', true, array('/^[a-z][a-z0-9]*$/i')),
          array('Db_NoRecordExists', true, array(Engine_Db_Table::getTablePrefix() . 'users', 'username'))
        ),
        'order'=>$orderIndex,
          //'onblur' => 'var el = this; en4.user.checkUsernameTaken(this.value, function(taken){ el.style.marginBottom = taken * 100 + "px" });'
      ));
      $this->username->getDecorator('Description')->setOptions(array('placement' => 'APPEND', 'escape' => false));
      $this->username->getValidator('NotEmpty')->setMessage('Please enter a valid profile address.', 'isEmpty');
      $this->username->getValidator('Db_NoRecordExists')->setMessage('Someone has already picked this profile address, please use another one.', 'recordFound');
      $this->username->getValidator('Regex')->setMessage('Profile addresses must start with a letter.', 'regexNotMatch');
      $this->username->getValidator('Alnum')->setMessage('Profile addresses must be alphanumeric.', 'notAlnum');

      // Add banned username validator
      $bannedUsernameValidator = new Engine_Validate_Callback(array($this, 'checkBannedUsername'), $this->username);
      $bannedUsernameValidator->setMessage("This profile address is not available, please use another one.");
      $this->username->addValidator($bannedUsernameValidator);
    }

      $order = Engine_Api::_()->getDbTable('enablefields','quicksignup')->getField('timezone');
      $orderIndex = $order->order;
    // Element: timezone
      if($order->display == 1) {
          $this->addElement('Select', 'timezone', array(
              'label' => $formDescription ? 'Timezone' : '',
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
              'order'=>$orderIndex,
          ));
          $this->timezone->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
      }
    // Element: language

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
      $order = Engine_Api::_()->getDbTable('enablefields','quicksignup')->getField('language');
      $orderIndex = $order->order;

    if(count($languageNameList)>1 && $order->display == 1){
      $this->addElement('Select', 'language', array(
        'label' => $formDescription ? 'Language' : '',
        'multiOptions' => $languageNameList,
        'order'=>$orderIndex,
      ));
      $this->language->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
    }
    else{
      $this->addElement('Hidden', 'language', array(
        'value' => current((array)$languageNameList),
        'order' => 9999999
      ));
    }
      $order = Engine_Api::_()->getDbTable('enablefields','quicksignup')->getField('captcha');
      $orderIndex = $order->order;
    // Element: captcha
    if( Engine_Api::_()->getApi('settings', 'core')->core_spam_signup && $order->display == 1) {
      $this->addElement('captcha', 'captcha', Engine_Api::_()->core()->getCaptchaOptions(array(
          'order'=>$orderIndex,
      )));
    }
      $order = Engine_Api::_()->getDbTable('enablefields','quicksignup')->getField('terms');
      $orderIndex = $order->order;
    if( $settings->getSetting('user.signup.terms', 1) == 1 && $order->display == 1) {
      // Element: terms
      $description = Zend_Registry::get('Zend_Translate')->_('I have read and agree to the <a target="_blank" href="%s/help/terms">terms of service</a>.');
      $description = sprintf($description, Zend_Controller_Front::getInstance()->getBaseUrl());

      $this->addElement('Checkbox', 'terms', array(
        'label' => $formDescription ? 'Terms of Service' : '',
        'description' => $description,
        'required' => true,
        'validators' => array(
          'notEmpty',
          array('GreaterThan', false, array(0)),
        ),
        'order'=>$orderIndex,
      ));
      $this->terms->getValidator('GreaterThan')->setMessage('You must agree to the terms of service to continue.', 'notGreaterThan');

      $this->terms->clearDecorators()
          ->addDecorator('ViewHelper')
          ->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::APPEND, 'tag' => 'label', 'class' => 'null', 'escape' => false, 'for' => 'terms'))
          ->addDecorator('DivDivDivWrapper');
    }

    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Create an account',
      'type' => 'submit',
      'ignore' => true,
      'order'=>9999999999999,
    ));

    // Set default action
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'user_signup', true));
  }

  public function checkPasswordConfirm($value, $passwordElement)
  {
    return ( $value == $passwordElement->getValue() );
  }
    public function checkEmailConfirm($value, $emailElement)
    {
        return ( $value == $emailElement->getValue() );
    }

  public function checkInviteCode($value, $emailElement)
  {
    $inviteTable = Engine_Api::_()->getDbtable('invites', 'invite');
    $select = $inviteTable->select()
      ->from($inviteTable->info('name'), 'COUNT(*)')
      ->where('code = ?', $value)
      ;
      
    if( Engine_Api::_()->getApi('settings', 'core')->getSetting('user.signup.checkemail') ) {
      $select->where('recipient LIKE ?', $emailElement->getValue());
    }
    
    return (bool) $select->query()->fetchColumn(0);
  }

  public function checkBannedEmail($value, $emailElement)
  {
    $bannedEmailsTable = Engine_Api::_()->getDbtable('BannedEmails', 'core');
    if ($bannedEmailsTable->isEmailBanned($value)) {
      return false;
    }
    $isValidEmail = true;
    $event = Engine_Hooks_Dispatcher::getInstance()->callEvent('onCheckBannedEmail', $value);
    foreach ((array)$event->getResponses() as $response) {
      if ($response) {
        $isValidEmail = false;
        break;
      }
    }
    return $isValidEmail;
  }

  public function checkBannedUsername($value, $usernameElement)
  {
    $bannedUsernamesTable = Engine_Api::_()->getDbtable('BannedUsernames', 'core');
    return !$bannedUsernamesTable->isUsernameBanned($value);
  }
    public function addEmailElement($attributes = array()) {
        $emailFieldName = $this->getEmailElementFieldName();
        $attributes = array_merge(array(
            'required' => true,
            'allowEmpty' => false,
            'filters' => array(
                'StringTrim',
            ),
            'validators' => array(
                'EmailAddress'
            ),
            // Fancy stuff
            'inputType' => 'email',
            'class' => 'text',
        ), $attributes);

        $this->addElement('Text', $emailFieldName, $attributes);

        if ($emailFieldName !== $this->_orgEmailFieldName) {
            $this->addElement('Hidden', $this->_orgEmailFieldName, array(
                'order' => 702200
            ));

            $this->addElement('Hidden', $this->_orgEmailFieldName . '_field', array(
                'order' => 1000110,
                'value' => base64_encode($emailFieldName)
            ));
        }

        return $this->{$emailFieldName};
    }
    public function isEmailAntispamEnabled() {
        return $this->_emailAntispamEnabled;
    }
    public function getEmailElementFieldName() {
        if ($this->_emailFieldName !== null) {
            return $this->_emailFieldName;
        }
        if (!$this->isEmailAntispamEnabled()) {
            $this->_emailFieldName = $this->_orgEmailFieldName;
        } else if (isset($_POST[$this->_orgEmailFieldName . '_field'])) {
            $this->_emailFieldName = base64_decode($_POST[$this->_orgEmailFieldName . '_field']);
        } else {
            $this->_emailFieldName = Engine_String::str_random(10);
        }
        return $this->_emailFieldName;
    }
}

