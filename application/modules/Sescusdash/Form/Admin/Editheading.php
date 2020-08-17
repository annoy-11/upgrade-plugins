<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescusdash
 * @package    Sescusdash
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editheading.php  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescusdash_Form_Admin_Editheading extends Engine_Form {

  public function init() {

    $this->setMethod('POST');

    $dashboardlink_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('dashboardlink_id');
    $sublink = Zend_Controller_Front::getInstance()->getRequest()->getParam('sublink');

    $this->addElement('Text', "name", array(
        'label' => 'Enter category name.',
        'allowEmpty' => false,
        'required' => true,
    ));

    if(empty($sublink)) {
      $this->addElement('Select', 'type', array(
        'label' => 'Choose Type',
        'multiOptions' => array(
          'horizontal' => 'Horizontal',
          'vertical' => 'Vertical',
        ),
        'value' => 'horizontal',
      ));
    }

    if($sublink) {

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
          //'allowEmpty' => false,
          //'required' => true,
      ));


      $this->addElement('File', 'photo', array(
          'label' => '',
         // 'allowEmpty' => false,
         // 'required' => true,
      ));
      $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG');

        // View Privacy Setting
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

    }

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
