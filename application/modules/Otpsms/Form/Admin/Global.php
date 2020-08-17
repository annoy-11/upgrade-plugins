<?php

class Otpsms_Form_Admin_Global extends Engine_Form {
    function get_domain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return false;
    }
  public function init() {
      $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
        ->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "otpsms_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('otpsms.licensekey'),
    ));
    $this->getElement('otpsms_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('otpsms.pluginactivated')) {

    $this->addElement('Text','otpsms_duration',array(
          'label' => 'OTP Code Duration for Expiry',
          'description' => 'Below, enter the duration of OTP code. After the duration entered in the below setting, the OTP code will get expired. [Enter the duration in seconds. For ex: 5 minutes = 300 seconds]',
          'allowEmpty'=>false,
          'required' => true,
          'value' => $settings->getSetting('otpsms.duration',300),
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
          ),
        ));
    $this->addElement('Text','otpsms_code_length',array(
          'label' => 'OTP Code Limit',
          'description' => 'Enter the limit for the OTP code which will be sent from your website to the user\'s mobile phones.',
          'allowEmpty'=>false,
          'required' => true,
          'value' =>$settings->getSetting('otpsms.code.length',6),
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
          ),
        ));
   //get countries
   $countriesArray = Engine_Api::_()->otpsms()->getCountryCodes();
   $countries = array();
   foreach($countriesArray as $key=>$value){
      $countries[$key] = ucwords(strtolower($value["name"])).' (+'.$value['code'].')';
   }

    $this->addElement('Multiselect','otpsms_allowed_countries',array(
      'label' => 'Enable Countries',
      'description' => 'Choose from below the countries belonging to which, phone number verification (OTP) will be enabled on your website.',
      'allowEmpty'=>false,
      'required' => true,
      'value' => $settings->getSetting('otpsms.allowed.countries',''),
      'multiOptions'=>$countries,

    ));
    $this->addElement('Select','otpsms_default_countries',array(
          'label' => 'Default Selected Country',
          'description' => 'Select the country which will come pre-selected while login and signup on your website.',
          'allowEmpty'=>false,
          'required' => true,
          'value' => $settings->getSetting('otpsms.default.countries','US'),
          'multiOptions'=>$countries,
    ));

    $this->addElement('Radio','otpsms_login_options',array(
          'label' => 'Login Security Check',
          'description' => 'Select the check that you want to secure login on your website.',
          'allowEmpty'=>false,
          'required' => true,
          'value'=>$settings->getSetting('otpsms.login.options',0),
          'multiOptions'=>array('0'=>'Default (Only Password)','1'=>'Either with OTP or Password','2'=>'Two Factor Signin Verification (Both OTP & Password)'),
    ));
    $this->addElement('Radio','otpsms_signup_phonenumber',array(
          'label' => 'Display Phone Number During Signup',
          'description' => 'Do you want to display the phone number field while signup on your website? If you choose Yes, then users on your website will see phone number field in the signup form on your site.',
          'allowEmpty'=>false,
          'required' => true,
          'value'=>$settings->getSetting('otpsms.signup.phonenumber',1),
          'multiOptions'=>array('1'=>'Yes',
                          '0'=>'No'
                        ),
    ));

    $this->addElement('Radio','otpsms_choose_phonenumber',array(
          'label' => 'Email or Phone Number Choice',
          'description' => 'Do you want to enable users to choose between email or phone number while signing up on your website? If you choose Yes, then users will be able to choose any one, but if you choose No, then users will see both the options for email and phone number. Also, if users choose to signup using Phone number only, then you can set the default email format which will be created for users account and they can change the same later.',
          'allowEmpty'=>false,
          'required' => true,
          'value'=>$settings->getSetting('otpsms.choose.phonenumber',0),
          'multiOptions'=>array('1'=>'Yes, enable users to choose either email or phone number.',
                          '0'=>'No, show both email & phone number fields.'
                        ),
    ));


    $this->addElement('Radio','otpsms_required_phonenumber',array(
          'label' => 'Make Phone Number Required',
          'description' => 'Do you want the phone number field to be required while signup on your website?',
          'allowEmpty'=>false,
          'required' => true,
          'value'=>$settings->getSetting('otpsms.required.phonenumber',1),
          'multiOptions'=>array('1'=>'Yes',
                          '0'=>'No'
                        ),
    ));

     $this->addElement('Text','otpsms_email_format',array(
          'label' => 'Email Address Default Format',
          'description' => 'Enter the format for the email address which will be created for users who will choose to signup via Phone number and will not enter their email id.',
          'allowEmpty'=>false,
          'required' => true,
          'value' => $settings->getSetting('otpsms.email.format','se[PHONE_NUMBER]@'.$this->get_domain($_SERVER["HTTP_HOST"])),

        ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
	    } else {

      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate your plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }

  }
}
