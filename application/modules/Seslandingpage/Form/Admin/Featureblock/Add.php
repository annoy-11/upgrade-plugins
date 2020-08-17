<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslandingpage_Form_Admin_Featureblock_Add extends Engine_Form {

  public function init() {

    $this
        ->setTitle('Add Feature Block Details')
        ->setDescription("Below, you can edit details of feature block.")
        ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
        ->setMethod('post');

    $this->addElement('Text', 'title', array(
      'label' => '*Title',
      'description' => 'Enter the title.',
      'allowEmpty' => false,
      'required' => true,
    ));


    //Feature Block 1
    $this->addElement('Dummy', 'feablo', array(
        'label' => 'Enter below the 4 content block.',
    ));

    for($i=1;$i<=4;$i++) {

      $this->addElement('Text', 'title'.$i, array(
        'label' => '*Title',
        'allowEmpty' => false,
        'required' => true,
      ));

      $this->addElement('Textarea', 'description'.$i, array(
        'label' => 'Description',
      ));

//       $this->addElement('Text', 'url'.$i, array(
//         'label' => 'URL',
//         'allowEmpty' => false,
//         'required' => true,
//       ));
        $this->addElement('Select', "icon_type".$i, array(
            'label' => 'Choose the icon type',
            'allowEmpty' => false,
            'required' => true,
            'multiOptions' => array(
                '0' => 'Image Icon',
                '1' => "Font Icon",
            ),
            'onchange' => 'showIcon(this.value, "'.$i.'")',
            'value' => 0,
        ));

        $this->addElement('Text', 'fonticon'.$i, array(
            'label' => 'Font icon',
            //'allowEmpty' => false,
           // 'required' => true,
        ));

        $this->addElement('File', 'photo'.$i, array(
            'label' => 'Image Icon',
        // 'allowEmpty' => false,
        // 'required' => true,
        ));
        $photo = 'photo'.$i;
        $this->$photo->addValidator('Extension', false, 'jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG');
    }

    // Buttons
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
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
