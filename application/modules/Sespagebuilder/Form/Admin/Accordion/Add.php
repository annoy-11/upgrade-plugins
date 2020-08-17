<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
  * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Accordion_Add extends Engine_Form {

  public function init() {

    $contentId = Zend_Controller_Front::getInstance()->getRequest()->getParam('content_id', 0);
    $accordion_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
    if ($accordion_id)
      $accordion = Engine_Api::_()->getItem('sespagebuilder_accordions', $accordion_id);

    $this->setMethod('post');

    $this->addElement('Text', 'accordion_name', array(
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Hidden', 'id', array());

    $this->addElement('Text', 'accordion_url', array(
        'label' => 'Menu Item URL',
        'description' => "Enter URL of this menu item. Users will be redirected to this URL when they click on this menu item. If you do not want to redirect your users, then simply leave this field blank.",
    ));

    $this->addElement('File', 'accordion_icon', array(
        'label' => 'Menu Item Icon',
        'description' => 'Upload an icon for this menu item. (Recommended dimensions of the icon are 16x16 px.)',
        'onchange' => "showReadImage(this,'accordion_icon_preview')",
    ));
    $this->accordion_icon->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');

    if (isset($accordion) && $accordion->accordion_icon) {
      $img_path = Engine_Api::_()->storage()->get($accordion->accordion_icon, '')->getPhotoUrl();
      $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
      if (isset($path) && !empty($path)) {
        $this->addElement('Image', 'accordion_icon_preview', array(
            'src' => $path,
            'width' => 100,
            'height' => 100,
        ));
      }
      $this->addElement('Checkbox', 'remove_accordion_icon', array(
          'label' => 'Yes, delete this accordion icon.'
      ));
    } else {
      $this->addElement('Image', 'accordion_icon_preview', array(
          'width' => 16,
          'height' => 16,
          'disable' => true
      ));
    }

    $this->addElement('Button', 'save', array(
        'label' => 'Add',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Save & Exit',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage-accordions', 'content_id' => $contentId)),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('save', 'submit', 'cancel'), 'buttons');
  }

}
