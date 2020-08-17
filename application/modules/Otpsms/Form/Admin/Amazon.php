<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Amazon.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Otpsms_Form_Admin_Amazon extends Engine_Form
{
  public function init()
  {
    parent::init();
    // My stuff
    $this
      ->setTitle('Integration with Amazon')
      ->setDescription('Fill up the form below to integrate amazon services to enable OTP on your site.');
      
      
      $this->addElement('Text','clientId',array(
          'label'=>'Client Id',
		  'description'=> 'Enter the Client ID below.',
          'required'=>true,
          'allowEmpty'=>false,
        ));
     $this->addElement('Text','clientSecret',array(
          'label'=>'Client Secret',
          'description'=> 'Enter the Client Secret below.',
		  'required'=>true,
          'allowEmpty'=>false,
        ));
    $this->addElement('Radio','enabled',array(
          'label'=>'Enable',
		  'description'=> 'Do you want to enable Amazon Services?',
          'multiOptions'=>array('1'=>'Yes','0'=>'No'),
          'required'=>true,
          'allowEmpty'=>false,
          'value'=>0
        ));
    $this->addElement('Button','submit',array(
          'label'=>'Save Changes',
          'type'=>'submit',
          'ignore'=>true
        ));
    
    
  }
}
