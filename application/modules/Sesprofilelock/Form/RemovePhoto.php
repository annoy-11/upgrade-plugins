<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: RemovePhoto.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_Form_RemovePhoto extends Engine_Form {

  public function init() {

    $this->setTitle('Remove Photo')
            ->setDescription('Do you want to remove background images of locked screen?  Doing so will set your photo back to the default background images of locked screen.')
            ->setMethod('POST')
            ->setAction($_SERVER['REQUEST_URI'])
            ->setAttrib('class', 'global_form_popup');
    $this->addElement('Hash', 'token');

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Remove Photo',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onclick' => 'parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $this->getDisplayGroup('buttons');
  }

}
