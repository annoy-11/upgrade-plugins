<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesserverwp
 * @package    Sesserverwp
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php  2019-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesserverwp_Form_Admin_Add extends Engine_Form {

  public function init() {
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
  }
}

?>