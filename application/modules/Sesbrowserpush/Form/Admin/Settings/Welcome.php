<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Welcome.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbrowserpush_Form_Admin_Settings_Welcome extends Engine_Form
{
  public function init()
  {
    $this
            ->setTitle('Welcome Push Notification Message')
            ->setDescription('Here, configure the welcome push notification message to be sent to the users after they subscribe the push notifications from your website.');
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->addElement('Radio', "sesbrowserpush_welcomeenable", array(
      'label' => 'Enable Welcome Push Notification',
      'description' => 'Do you want to enable welcome push notification which will be sent to the users after they subscribe the push notifications from your website?',
      'allowEmpty' => false,
      'required' => true,
      'multiOptions'=>array('0'=>'No','1'=>'Yes'),
      'onclick'=>'welcomeSettings(this.value)',
      'value' => $settings->getSetting('sesbrowserpush.welcomeenable','1'),
		));

		$this->addElement('Text', "sesbrowserpush_welcometitle", array(
      'label' => 'Welcome Push Notification Title',
      'description' => 'Enter the title of welcome push notification.',
      'allowEmpty' => false,
      'required' => true,
      'value' => $settings->getSetting('sesbrowserpush.welcometitle',''),
		));

    $this->addElement('Textarea', "sesbrowserpush_welcomedescription", array(
		'label' => 'Welcome Push Notification Message',
		'description' => 'Enter the message of welcome push notification.',
		'allowEmpty' => true,
		'required' => false,
		'value' => $settings->getSetting('sesbrowserpush.welcomedescription',''),
		));

    $this->addElement('Text', "sesbrowserpush_welcomelink", array(
      'label' => 'Redirect URL',
      'description' => 'Enter the URL on which you want to redirect new subscribers when they click on this welcome push notification (Enter full url like: http://www.yourwebsite.com or https://www.yourwebsite.com ).',
      'allowEmpty' => true,
      'required' => false,
      'value' => $settings->getSetting('sesbrowserpush.welcomelink',''),
		));

    $this->addElement('File', 'icon', array(
        'label' => 'Upload Image',
        'description' => 'Choose a photo to be displayed in welcome push notification. Recommended dimension for the image is 100 x 100 pixels.',
        'allowEmpty' => true,
        'required' => false,
        'onchange' => 'showReadImage(this,"cat_icon_preview")',
    ));
    $this->icon->addValidator('Extension', false, 'jpg,png,jpeg,JPEG,PNG,JPG');
    $file = $settings->getSetting('sesbrowserpush.welcomeicon','');
    if ($file) {
        $this->addElement('Image', 'cat_icon_preview', array(
            'src' => $file,
            'width' => 100,
            'height' => 100,
        ));
      $this->addElement('Checkbox', 'remove_icon_icon', array(
          'label' => 'Yes, delete this image.'
      ));
   } else {
          $this->addElement('Image', 'cat_icon_preview', array(
              'width' => 100,
              'height' => 100,
              'disable' => true
          ));
   }

    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true
    ));
  }
}
