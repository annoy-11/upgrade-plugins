<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Avatar.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesavatar_Form_Signup_Avatar extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    // Init form
    $this->setTitle('Add Your Photo or Custom Avatar');

    $this
      ->setAttrib('enctype', 'multipart/form-data')
      ->setAttrib('id', 'SignupForm');

    $this->addElement('Image', 'current', array(
      'label' => 'Current Photo',
      'ignore' => true,
      'decorators' => array(array('ViewScript', array(
        'viewScript' => '_formSignupImage.tpl',
        'class'      => 'form element'
      )))
    ));
    Engine_Form::addDefaultDecorators($this->current);

    $this->addElement('File', 'Filedata', array(
      'label' => 'Choose New Photo',
      'multiFile' => 1,
      'validators' => array(
        array('Count', false, 1),
        array('Extension', false, 'jpg,png,gif,jpeg'),
      ),
      'onchange'=>'javascript:uploadSignupPhoto();'
    ));


    $images = Engine_Api::_()->getDbtable('images', 'sesavatar')->getImages(array('enabled' => 1, 'fetchAll' => 1));

    $options = array();
    foreach ($images as $image) {

      $imageItem = Engine_Api::_()->getItem('sesavatar_image', $image->image_id);
      $photo = Engine_Api::_()->storage()->get($image->file_id, '');
      if($photo) {
        $options[$image->file_id] = '<img src="'.$photo->getPhotoUrl().'" alt="" />';
      }
    }

    if( $settings->getSetting('sesavatar.signup.photo', 0) == 1 ) {
      $this->addElement('Radio', 'image_id', array(
        //'label' => 'Choose Avatar',
        'multiOptions' => $options,
        'escape' => false,
        'onclick' => "showAvatarButton();",
      ));
    } else {
      $this->addElement('Radio', 'image_id', array(
        //'label' => 'Choose Avatar',
        'multiOptions' => $options,
        'escape' => false,
      ));
    }

    $this->addElement('Hash', 'token');

    $this->addElement('Hidden', 'coordinates', array(
      'order' => 1
    ));
    $this->addElement('Hidden', 'uploadPhoto', array(
      'order' => 2
    ));
    $this->addElement('Hidden', 'nextStep', array(
      'order' => 3
    ));
    $this->addElement('Hidden', 'skip', array(
     'order' => 4
    ));

    // Element: done
    //if( $settings->getSetting('sesavatar.signup.photo', 0) == 0 ) {
      $this->addElement('Button', 'done', array(
        'label' => 'Save Photo',
        'type' => 'submit',
        'onclick' => 'javascript:finishForm();',
        'decorators' => array(
          'ViewHelper',
        ),
      ));
    //}

    // Element: skip
    //if( $settings->getSetting('sesavatar.signup.photo', 0) == 0 ) {
      $this->addElement('Cancel', 'skip-link', array(
        'label' => 'skip',
        'prependText' => ' or ',
        'link' => true,
        'href' => 'javascript:void(0);',
        'onclick' => 'skipForm(); return false;',
        'decorators' => array(
          'ViewHelper',
        ),
      ));
    //}
  }
}
