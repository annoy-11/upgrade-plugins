<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddEventAdminSpeaker.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seseventspeaker_Form_AddEventAdminSpeaker extends Engine_Form {

  public function init() {

    $this->setMethod('POST');

    $this->addElement('Text', "name", array(
        'label' => 'Enter name of speaker',
        'allowEmpty' => false,
        'required' => true,
    ));
    
    $this->addElement('Hidden', "speaker_id", array(
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