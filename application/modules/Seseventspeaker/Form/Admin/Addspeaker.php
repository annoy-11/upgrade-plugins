<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Addspeaker.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seseventspeaker_Form_Admin_Addspeaker extends Engine_Form {

  public function init() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    $this->setTitle('Add New Speaker')
            ->setMethod('POST');

    $this->addElement('Text', "name", array(
        'label' => 'Speaker',
        'description' => "Enter the name of speaker to be added as speaker to your website.",
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('File', 'photo_id', array(
        'label' => 'Profile Photo',
        'description' => "Choose a profile photo for the speaker.",
    ));
    $this->photo_id->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');
    
    $speaker_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('speaker_id', null);
    $speaker = Engine_Api::_()->getItem('seseventspeaker_speakers', $speaker_id);
    $photo_id = 0;
    if (isset($speaker->photo_id))
      $photo_id = $speaker->photo_id;
    if ($photo_id && $speaker) {
      $path = Engine_Api::_()->storage()->get($photo_id, '')->getPhotoUrl();
      if (!empty($path)) {
        $this->addElement('Image', 'profile_photo_preview', array(
            'label' => 'Profile Photo Preview',
            'src' => $path,
            'width' => 100,
            'height' => 100,
        ));
      }
    }
    if ($photo_id) {
      $this->addElement('Checkbox', 'remove_profilecover', array(
          'label' => 'Yes, remove profile photo.'
      ));
    }

    $this->addElement('Textarea', "description", array(
        'label' => 'Short Description',
        'description' => "Enter short description about the speaker. [The description should be of 300 characters only.]",
        'maxlength' => '300',
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
            new Engine_Filter_StringLength(array('max' => '300')),
            new Engine_Filter_EnableLinks(),
        ),
    ));

    $this->addElement('Text', "email", array(
        'label' => 'Email',
        'allowEmpty' => false,
        'required' => true,
        'description' => "Enter email address of the speaker.",
    ));

    $this->addElement('Text', "location", array(
        'label' => 'Location',
        'description' => "Enter location of the speaker from the auto-suggest below. [When clicked location will open in Google Map.]",
    ));

    $this->addElement('Text', "phone", array(
        'label' => 'Phone',
        'description' => "Enter phone number of the speaker.",
    ));

    $this->addElement('Text', "website", array(
        'label' => 'Website',
        'description' => "Enter website of the speaker.",
    ));

    $this->addElement('Text', "facebook", array(
        'label' => 'Facebook URL',
        'description' => "Enter URL of the Facebook Profile or Page of the speaker.",
    ));

    $this->addElement('Text', "twitter", array(
        'label' => 'Twitter URL',
        'description' => "Enter URL of the Twitter Profile of the speaker.",
    ));

    $this->addElement('Text', "linkdin", array(
        'label' => 'LinkedIn URL',
        'description' => "Enter URL of the LinkedIn Profile of the speaker.",
    ));

    $this->addElement('Text', "googleplus", array(
        'label' => 'Google Plus URL',
        'description' => "Enter URL of the Google Plus Profile of the speaker.",
    ));

    //Add Element: Submit
    $this->addElement('Button', 'button', array(
        'label' => 'Add',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    // Element: cancel
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'index'), 'admin_default', true),
        'onclick' => '',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('button', 'cancel'), 'buttons');
  }

}
