<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoserver
 * @package    Sesssoserver
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 
class Sesssoserver_Form_Admin_Add extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Add a New Client')
            ->setDescription('Add a new Client site by entering the required information in the form below:');
        $this->addElement('Text', 'url', array(
            'label' => 'Client Site URL',
            'description' => "Enter the URL of the client site. (You will have to install the SSO Client Plugin on the client site.)",
            'required'=>true,
            'allowEmpty'=>false,
        ));

        $this->addElement('Text', 'client_secret', array(
            'label' => 'Client Secret',
            'description' => "Enter Client Secret which you have configured on your client site.",
            'required'=>true,
            'allowEmpty'=>false,
        ));

        $this->addElement('Text', 'client_token', array(
            'label' => 'Client Token',
            'description' => "Enter Client Token which you have configured on your client site.",
            'required'=>true,
            'allowEmpty'=>false,
        ));

		$this->addElement('Dummy', 'dummy', array(
            'content' => '<h2>Map Profile Fields with Client Site</h2>',
        ));
       
    
  }
}
