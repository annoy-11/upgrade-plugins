<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesprofilefield_Form_Admin_Manage_Add extends Engine_Form {

  public function init() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type', '');

    $this->setMethod('post');

    $this->addElement('Text', 'name', array(
      'allowEmpty' => false,
      'required' => true,
    ));
    
    if(in_array($type, array('school', 'company', 'authority'))) {
    
      $this->addElement('File', 'photo_id', array(
        'label' => 'Logo',
        'description' => 'Upload an logo for the school. (The recommended dimension is 100x100 px.)'
      ));
      $this->photo_id->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');

      $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
      
      if ($id) {
        if($type == 'school') { 
        $item = Engine_Api::_()->getItem('sesprofilefield_school', $id);
      } else if($type == 'company') {
        $item = Engine_Api::_()->getItem('sesprofilefield_company', $id);
      } else if($type == 'authority') {
        $item = Engine_Api::_()->getItem('sesprofilefield_authority', $id);
      }

        if ($item && $item->photo_id) {
          $img_path = Engine_Api::_()->storage()->get($item->photo_id, '')->getPhotoUrl();
          $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
          if (isset($path) && !empty($path)) {
            $this->addElement('Image', 'photo_id_preview', array(
              'src' => $path,
              'width' => 100,
              'height' => 100,
            ));
          }
          $this->addElement('Checkbox', 'remove_photo_id', array(
            'label' => 'Remove this Logo.'
          ));
        }
      }
    }

    $this->addElement('Button', 'submit', array(
        'label' => 'Add',
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