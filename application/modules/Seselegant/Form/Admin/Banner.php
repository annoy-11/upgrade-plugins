<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Banner.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seselegant_Form_Admin_Banner extends Engine_Form {

  public function init() {

    $this->setTitle('New Banner');
    $this->setMethod('post');

    $this->addElement('Text', 'banner_name', array(
        'label' => 'Enter the banner name.',
        'allowEmpty' => false,
        'required' => true,
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
