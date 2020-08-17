<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdiscussion_Form_Admin_Category_Add extends Engine_Form {

  public function init() {

    $category_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
    if ($category_id)
      $category = Engine_Api::_()->getItem('sesdiscussion_category', $category_id);

    $this->setMethod('post');

    $this->addElement('Text', 'category_name', array(
      'label' => 'Name',
      'description' => 'The name is how it appears on your site.',
      'allowEmpty' => false,
      'required' => true,
    ));
    
    $this->addElement('File', 'cat_icon', array(
      'label' => 'Upload Icon',
      'description' => 'Upload an icon. (The Recommended dimensions of the icon: 40px * 40px.]'
    ));
    $this->cat_icon->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');

    if (isset($category) && $category->cat_icon) {
      $img_path = Engine_Api::_()->storage()->get($category->cat_icon, '')->getPhotoUrl();
      if (strpos($img_path, 'http') === FALSE) {
        $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
      } else
        $path = $img_path;
      if (isset($path) && !empty($path)) {
        $this->addElement('Image', 'cat_icon_preview', array(
          'src' => $path,
          'width' => 100,
          'height' => 100,
        ));
      }
      $this->addElement('Checkbox', 'remove_cat_icon', array(
        'label' => 'Yes, delete this category icon.'
      ));
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