<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Addsublink.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslinkedin_Form_Admin_Addsublink extends Engine_Form {

  public function init() {

    $this->setMethod('POST');

    $this->addElement('Text', "name", array(
        'label' => 'Enter link name.',
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Text', "url", array(
        'label' => 'Enter URL for this link for Non Loggined member.',
    ));

    $this->addElement('Select', "nonloginenabled", array(
        'label' => 'Link Enabled for Non Loggined Member',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => "No",
        ),
    ));

    $this->addElement('Select', "nonlogintarget", array(
        'label' => 'Open in New Tab for Non Loggined Members',
        'multiOptions' => array(
            '0' => "No",
            '1' => 'Yes',
        ),
    ));

    $this->addElement('Text', "loginurl", array(
        'label' => 'Enter URL for this link for Loggined member.',
    ));

    $this->addElement('Select', "loginenabled", array(
        'label' => 'Link Enabled for Loggined Member',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => "No",
        ),
    ));

    $this->addElement('Select', "logintarget", array(
        'label' => 'Open in New Tab for Loggined Members',
        'multiOptions' => array(
            '0' => "No",
            '1' => 'Yes',
        ),
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
