<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Compliment.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Form_Admin_Compliment extends Engine_Form {

  public function init() {

    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
    if ($id)
      $compliment = Engine_Api::_()->getItem('sesmember_compliment', $id);

    $this->setTitle("Add Compliment Type")
            //->setDescription('')
            ->setMethod('post')
            ->setAttrib('class', 'global_form_box');

    $this->addElement('Text', 'title', array(
        'label' => 'Title',
        'allowEmpty' => false,
        'required' => true,
    ));
    if (isset($compliment)) {
      $allowed = true;
      $required = false;
    } else {
      $allowed = false;
      $required = true;
    }
    $this->addElement('File', 'file', array(
        'label' => 'Upload Icon',
        'allowEmpty' => $allowed,
        'required' => $required,
        'description' => 'Upload an icon. (The dimensions of the image should be 24x24 px. The currently associated image is shown below this field.)'
    ));
    $this->file->addValidator('Extension', false, 'jpg,jpeg,png,PNG,JPG,JPEG,gif,GIF');

    if (isset($compliment) && $compliment->file_id) {
      $img_path = Engine_Api::_()->storage()->get($compliment->file_id, '')->getPhotoUrl();
      if (strpos($img_path, 'http') === FALSE)
        $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
      else
        $path = $img_path;
      if (isset($path) && !empty($path)) {
        $this->addElement('Image', 'file_preview', array(
            'src' => $path,
            'width' => 50,
            'height' => 50,
        ));
      }
    }
    $this->addElement('Button', 'submit', array(
        'label' => 'Save',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
