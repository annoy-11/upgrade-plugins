<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdemouser_Form_Admin_Add extends Engine_Form {

  public function init() {

    $this->setTitle('Add New Test User')
            ->setMethod('POST');

    $this->addElement('Text', "name", array(
        //'label' => 'Demo Member',
        'description' => "Start typing the name of the site user to be added as test user in the auto-suggest box below.",
        'allowEmpty' => false,
        'required' => true,
    ));
    $this->addElement('Hidden', 'user_id', array());

    //Add Element: Submit
    $this->addElement('Button', 'button', array(
        'label' => 'Add Test User',
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
