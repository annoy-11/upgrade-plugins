<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Templates.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_Form_Admin_Templates extends Engine_Form
{
    public function init() {
        // Change description decorator
        $this->setTitle('SMS Template Settings')
        ->setDescription("In this page below, you can configure the SMS templates which will be sent with the OTP code for various actions and processes from your website. In the SMS settings below, you can use [code], [website_name], [username] and [expirytime] text for OTP code, Website name, Member's Name and Expire time of code respectively.[Note: Your SMS texts must include [code] variable.");

        $this->loadDefaultDecorators();

        $translate = Zend_Registry::get('Zend_Translate');
        // Prepare language list
        $languageList = $translate->getList();
        $localeObject = Zend_Registry::get('Locale');

        $languages = Zend_Locale::getTranslationList('language', $localeObject);
        $territories = Zend_Locale::getTranslationList('territory', $localeObject);

        $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
        if (!in_array($defaultLanguage, $languageList)) {
            if ($defaultLanguage == 'auto' && isset($languageList['en'])) {
                $defaultLanguage = 'en';
            } else {
                $defaultLanguage = null;
            }
        }
        $localeMultiOptions = array();
        foreach ($languageList as $key) {
            $languageName = null;
            if (!empty($languages[$key])) {
                $languageName = $languages[$key];
            } else {
                $tmpLocale = new Zend_Locale($key);
                $region = $tmpLocale->getRegion();
                $language = $tmpLocale->getLanguage();
                if (!empty($languages[$language]) && !empty($territories[$region])) {
                    $languageName = $languages[$language] . ' (' . $territories[$region] . ')';
                }
            }
            if ($languageName) {
                $localeMultiOptions[$key] = $languageName;
            } else {
                $localeMultiOptions[$key] = '';
            }
        }
        $localeMultiOptions = array_merge(array($defaultLanguage => $defaultLanguage
                ), $localeMultiOptions);
        
        // Element: level_id
        $this->addElement('Select', 'language', array(
            'label' => 'Choose Language',
            'multiOptions' => $localeMultiOptions,
            'onchange' => 'changeLanguage(this.value);',
        ));
        
        // for signup
        
        $this->addElement('Textarea', 'signup_template', array(
            'rows' => 1,
            'label' => 'SMS for Signup',
            'description' => 'Enter below the SMS that you want to send with the OTP when users try to signup with phone numbers on your website.',
            'value' => 'Use [code] to verify your registration. This code will get expired in [expirytime].',
        ));        
         
        $this->addElement('Textarea', 'forgot_template', array(
            'rows' => 1,
            'label' => 'SMS for Forget Password',
            'description' => 'Enter below the SMS that you want to send with the OTP when users try to reset their passwords on your website.',
            'value' => 'Use [code] for verification and reset your password. This code will get expired in [expirytime].',
        ));
        $this->addElement('Textarea', 'edit_number_template', array(
            'rows' => 1,
            'label' => 'SMS for Editing Phone Number',
            'description' => 'Enter below the SMS that you want to send with the OTP when users try to edit their phone numbers on your website.',
            'value' => 'Use [code] for verification and editing your phone number. This code will get expired in [expirytime].',
        ));
        $this->addElement('Textarea', 'add_number_template', array(
            'rows' => 1,
            'label' => 'SMS for Adding Phone Number',
            'description' => 'Enter below the SMS that you want to send with the OTP when members try to add their phone numbers on your website.',
            'value' => 'Use [code] for verification and adding your phone number. This code will get expired in [expirytime].',
        ));
         $this->addElement('Textarea', 'login_template', array(
            'rows' => 1,
            'label' => 'SMS for Login',
            'description' => 'Enter below the SMS that you want to send with the OTP when users try to login into your website.',
            'value' => 'Use [code] for verification and login. This code will get expired in [expirytime].',
        ));
        
        
        // Add submit
        $this->addElement('Button', 'submit', array(
            'label' => 'Save Changes',
            'type' => 'submit',
            'ignore' => true,
            'order' => 100000,
        ));      
    }
}