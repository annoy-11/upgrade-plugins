<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editheading.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmenu_Form_Admin_Editheading extends Sesmenu_Form_Admin_Addsublink {

  public function init() {
    $this->setMethod('POST');

    $dashboardlink_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('itemlink_id');
    $item = Engine_Api::_()->getItem('sesmenu_itemlinks',$dashboardlink_id);
    $storage = Engine_Api::_()->storage();
    $this->addElement('Text', "name", array(
        'label' => 'Enter category name.',
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Text', "url", array(
        'label' => 'Enter the URL for this link for non-logged in members',
    ));

    $this->addElement('Select', "icon_type", array(
        'label' => 'Choose the icon type',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
            '0' => 'Image Icon',
            '1' => "Font Icon",
        ),
        'onclick' => 'showIcon(this.value)',
        'value' => 0,
    ));

    $this->addElement('Text', "font_icon", array(
        'label' => 'Icon / Icon Class (Ex: fa-home)',
    ));

    $this->addElement('File', 'photo', array(
        'label' => '',
    ));
    if(!empty($item->file_id)){
        $photo = $storage->get($item->file_id, '');
        if($photo) {
        $photo = $photo->map();
        $this->addElement('Dummy','preview_image',array(
            'content'=>"<img src='".$photo."' style='width:100px; height:100px;'>"
        ));
     }
    }
    $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG');
    $levelOptions = array();
    $levelOptions[''] = 'Everyone';
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
        $levelOptions[$level->level_id] = $level->getTitle();
    }
    $this->addElement('Multiselect', 'privacy', array(
        'label' => 'Member Level View Privacy',
        'description' => 'Choose the member levels to which this slide will be displayed. (Ctrl + Click to select multiple member levels.)',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions' => $levelOptions,
        'value' => '',
    ));
    $this->addElement('Button', 'button', array(
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
    $this->addDisplayGroup(array('button', 'cancel'), 'buttons');
  }

}
