<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercovervideo
 * @package    Sesusercovervideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Icon.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesusercovervideo_Form_UploadVideo extends Engine_Form {

  public function init() {

    $this->setTitle('Upload Cover Video');
    
    $this->addElement('File', 'photo', array(
      'allowEmpty' => false,
      'required' => true,
      'description' => 'Upload an image [Note: For device which do not support Background videos]',
      'accept' => "image/*",
    ));
    
    $onlyMp4 = ',mp4';
    $mp4VideoText = 'Only support ".mp4" videos';
    
    $this->addElement('File', 'file', array(
      'allowEmpty' => false,
      'required' => true,
      'description' => 'Upload a video [Note: '.$mp4VideoText.']',
      'accept'=>"video/*",
      "onchange" =>"ValidateSize(this)",
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Save',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'onclick' => 'javascript:parent.Smoothbox.close()',
        'link' => true,
        //'prependText' => ' or ',
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }
}