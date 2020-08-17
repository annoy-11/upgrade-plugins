<?php
class Sesdbslide_Form_Admin_Slideshow_Addslideshow extends Engine_Form
{
  public function init()
  {
    
    $this
      ->setTitle('Create New Slideshow')
      ->setDescription('Fill out the form below to create new slideshow for your website.');

     $this->addElement('Text', 'banner_title', array(
      'label' => 'Banner Title',
      'description' => 'Enter the title for this slideshow.',
     // 'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdbslide_license'),
    ));
		
	

    // Add submit button
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true
    ));
		
		 $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onClick'=> 'javascript:parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
		
  }
}