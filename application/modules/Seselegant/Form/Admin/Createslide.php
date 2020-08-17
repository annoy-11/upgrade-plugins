<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Createslide.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seselegant_Form_Admin_Createslide extends Engine_Form {

  public function init() {
    $this
            ->setTitle('Upload New Photo')
            ->setDescription("Below, enter the details for the new photo.")
            ->setAttrib('id', 'form-create-banner')
            ->setAttrib('name', 'seselegant_create_banner')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setAttrib('onsubmit', 'return checkValidation();')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
            
    $this->setMethod('post');
    $this->addElement('Text', 'title', array(
        'label' => 'Caption',
        'description' => 'Enter the caption for this photo.',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Text', 'title_button_color', array(
        'label' => 'Caption Color',
        'description' => 'Choose the color for the caption.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Textarea', 'description', array(
        'label' => 'Description',
        'description' => 'Enter the description for this photo.',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Text', 'description_button_color', array(
        'label' => 'Description Color',
        'description' => 'Choose the color for the description.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));

    $banner_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('banner_id', 0);
    if (!$banner_id) {
      $required = false;
      $allowEmpty = true;
    } else {
      $required = false;
      $allowEmpty = true;
    }

    $this->addElement('File', 'file', array(
        'allowEmpty' => $allowEmpty,
        'required' => $required,
        'label' => 'Upload Photo',
        'description' => 'Upload a photo [Note: photos with extension: “jpg, png and jpeg] only.]',
    ));
    //$this->file->addValidator('Extension', false, 'jpg,png,jpeg'.$onlyMp4);

    //extra button code
    $this->addElement('Select', 'extra_button', array(
        'label' => 'Show Additional Button',
        'description' => 'Do you want to show an additional button on this photo?',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '0',
        'onChange' => 'extra_buton(this.value);'
    ));
		$this->addElement('Text', 'extra_button_text', array(
        'label' => 'Button Text',
        'description' => 'Enter the text for the button.',
        'allowEmpty' => true,
        'required' => false,
        'value' => 'Read More',
    ));
    
    $this->addElement('Text', 'extra_button_link', array(
        'label' => 'Link for Button',
        'description' => 'Enter a link for the button.',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Select', 'extra_button_linkopen', array(
        'label' => 'Button Link Target',
        'description' => 'Do you want to open button link in new window?',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '0'
    ));
    
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
