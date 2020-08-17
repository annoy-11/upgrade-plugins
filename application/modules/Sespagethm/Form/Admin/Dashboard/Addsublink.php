<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Addsublink.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagethm_Form_Admin_Dashboard_Addsublink extends Engine_Form {

  public function init() {

    $this->setMethod('POST');

    $this->addElement('Text', "name", array(
        'label' => 'Enter link name.',
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Text', "url", array(
        'label' => 'Enter URL for this link.',
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
