<?php


class Sesinviter_Form_Admin_SocialMediaKeys extends Engine_Form {

  public function init() {
  
    $this->setTitle('Manage Social Media Keys')
          ->setDescription('You can enter social media keys here for our plugins. If you do not enter any key then corrosponding option will not display in SocialEngineSolutions Plugins.');
          
    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    //facebook
    $this->addElement('Dummy', 'sesinviter_facebook', array(
        'label' => 'Facebook',
    ));
    $this->addElement('Text', 'sesinviter_facebookclientid', array(
        'label' => 'App ID',
        'description' => '',
        'value' => $settings->getSetting('sesinviter.facebookclientid', ''),
    ));
    $this->addElement('Text', 'sesinviter_facebookclientsecret', array(
        'label' => 'App Secret',
        'description' => '',
        'value' => $settings->getSetting('sesinviter.facebookclientsecret', ''),
    ));
    
    //twitter
    $this->addElement('Dummy', 'sesinviter_twitter', array(
        'label' => 'Twitter',
    ));
    $this->addElement('Text', 'sesinviter_twitterclientid', array(
        'label' => 'API Key',
        'description' => '',
        'value' => $settings->getSetting('sesinviter.twitterclientid', ''),
    ));
    $this->addElement('Text', 'sesinviter_twitterclientsecret', array(
        'label' => 'API Secret',
        'description' => '',
        'value' => $settings->getSetting('sesinviter.twitterclientsecret', ''),
    ));

    //gmail
    $this->addElement('Dummy', 'sesinviter_gmail', array(
        'label' => 'Gmail',
    ));
    $this->addElement('Text', 'sesinviter_gmailclientid', array(
        'label' => 'Client ID',
        'description' => '',
        'value' => $settings->getSetting('sesinviter.gmailclientid', ''),
    ));
    $this->addElement('Text', 'sesinviter_gmailclientsecret', array(
        'label' => 'Client Secret',
        'description' => '',
        'value' => $settings->getSetting('sesinviter.gmailclientsecret', ''),
    ));
    
    //yahoo
    $this->addElement('Dummy', 'sesinviter_yahoo', array(
        'label' => 'Yahoo',
    ));
    $this->addElement('Text', 'sesinviter_yahooconsumerkey', array(
      'label' => 'Client ID',
      'description' => '',
      'value' => $settings->getSetting('sesinviter.yahooconsumerkey', ''),
    ));
    $this->addElement('Text', 'sesinviter_yahooconsumersecret', array(
      'label' => 'Client Secret',
      'description' => '',
      'value' => $settings->getSetting('sesinviter.yahooconsumersecret', ''),
    ));
//     $this->addElement('Text', 'sesinviter_yahooappid', array(
//         'label' => 'App Id',
//         'description' => '',
//         'value' => $settings->getSetting('sesinviter.yahooappid', ''),
//     ));
    
    //hotmail
    $this->addElement('Dummy', 'sesinviter_hotmail', array(
        'label' => 'Hotmail',
    ));
    $this->addElement('Text', 'sesinviter_hotmailclientid', array(
        'label' => 'Application ID',
        'description' => '',
        'value' => $settings->getSetting('sesinviter.hotmailclientid', ''),
    ));
    $this->addElement('Text', 'sesinviter_hotmailclientsecret', array(
        'label' => 'Private Key',
        'description' => '',
        'value' => $settings->getSetting('sesinviter.hotmailclientsecret', ''),
    ));
    
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}