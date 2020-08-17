<?php

class Eocsso_Form_Admin_Add extends Engine_Form
{

  public function init()
  {
    $this->setTitle('Add a New Client')
      ->setDescription('Add a new Client site by entering the required information in the form below:');
    $this->addElement('Text', 'url', array(
      'label' => 'Client Site URL',
      'description' => "Enter the URL of the client site. (You will have to install the SSO Client Plugin on the client site.)",
      'required' => true,
      'allowEmpty' => false,
    ));

    $this->addElement('Text', 'client_secret', array(
      'label' => 'Client Secret',
      'description' => "Enter Client Secret which you have configured on your client site.",
      'required' => true,
      'allowEmpty' => false,
    ));

    $this->addElement('Text', 'client_token', array(
      'label' => 'Client Token',
      'description' => "Enter Client Token which you have configured on your client site.",
      'required' => true,
      'allowEmpty' => false,
    ));

    $this->addElement('Text', 'sub_dir', array(
      'label' => 'Sub Directory Path',
      'description' => "Enter subdirectory path for send request to client site.",
      'allowEmpty' => false,
    ));
  }
}
