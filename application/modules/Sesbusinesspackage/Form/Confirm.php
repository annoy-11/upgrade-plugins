<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspackage
 * @package    Sesbusinesspackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Confirm.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinesspackage_Form_Confirm extends Engine_Form {

  public function init() {
		$this
      ->setTitle('Upgrade Package')
      ->setDescription('Do you want to change your Business Package. Once you confirm, you won’t be able to degrade your Package to previous.');
    $this->addElement('Button', 'submit', array(
		   'label' =>'Change Package',
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
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
