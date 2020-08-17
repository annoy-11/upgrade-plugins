<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Slidephoto.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seselegant_Form_Admin_Slidephoto extends Engine_Form {

  public function init() {

    $this->setTitle('Upload New Slide');

    $this->addElement('Textarea', 'caption', array(
        'label' => 'Enter a caption for this slide.',
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_HtmlSpecialChars(),
        ),
    ));

    $this->addElement('Text', 'image_url', array(
        'label' => 'URL'
    ));

    $this->addElement('File', 'photo', array(
        'label' => 'Choose Slide',
    ));
    $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG');

    $this->addElement('Button', 'submit', array(
        'label' => 'Upload Slide',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'onclick' => 'javascript:parent.Smoothbox.close()',
        'link' => true,
        'prependText' => ' or ',
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }

}
