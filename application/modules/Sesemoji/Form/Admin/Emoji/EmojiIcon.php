<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EmojiIcon.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemoji_Form_Admin_Emoji_EmojiIcon extends Engine_Form {

  public function init() {
  
    $this->setTitle('Add Emoji Icon')
            ->setDescription('');
            
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
    
    $this->addElement('Text', 'emoji_icon', array(
      'label' => 'Emoji Unicode Ex: 1F600',
      'required' => true,
      'allowEmpty' => false,
      'description' => '',
    ));
    
    if(!$id){
      $re = true;
      $all = false;
    }else{
      $re = false;
      $all = true;
    }
    
    $this->addElement('File', 'file', array(
        'allowEmpty' => $all,
        'required' => $re,
        'label' => 'Emoji Image',
        'description' => 'Upload a image [Note: photos with extension: "jpg, png, jpeg and gif" only.]',
    ));
    $this->file->addValidator('Extension', false, 'jpg,png,jpeg,gif,GIF,PNG,JPG,JPEG');
    
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'onclick' => 'javascript:parent.Smoothbox.close()',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}