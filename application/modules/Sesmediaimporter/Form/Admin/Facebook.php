<?php

class Sesmediaimporter_Form_Admin_Facebook extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Facebook Integration')
      ->setDescription('SESMEDIAIMPORTER_ADMIN_SETTINGS_FACEBOOK_DESCRIPTION')
      ->setAttrib('enctype', 'multipart/form-data')
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
      ->setMethod("POST");
      ;

    $description = $this->getTranslator()->translate('SESMEDIAIMPORTER_ADMIN_SETTINGS_FACEBOOK_DESCRIPTION');
    $settings = Engine_Api::_()->getApi('settings', 'core');
	if( $settings->getSetting('user.support.links', 0) == 1 ) {
	$moreinfo = $this->getTranslator()->translate( 
        '<br>More Info: <a href="https://www.socialenginesolutions.com/guidelines-social-photo-media-importer-facebook-api-key/
" target="_blank"> KB Article</a>');
	} else {
	$moreinfo = $this->getTranslator()->translate( 
        '');
	}
	$description = vsprintf($description.$moreinfo, array(
      'http://www.facebook.com/developers/apps.php',
    ));
    $this->setDescription($description);


    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);
    
    /*
    $this->addElement('Text', 'key', array(
      'label' => 'Facebook API Key',
      'description' => '',
    ));
    */

    $this->addElement('Text', 'appid', array(
      'label' => 'Facebook App ID',
      'description' => '',
      'filters' => array(
        'StringTrim',
      ),
    ));
    
    $this->addElement('Text', 'secret', array(
      'label' => 'Facebook App Secret',
      'description' => 'This is a 36 character string of letters and numbers ' . 
          'provided by Facebook when you create an Application in your account.',
      'filters' => array(
        'StringTrim',
      ),
    ));



    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
    ));

  }
}
