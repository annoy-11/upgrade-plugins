<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Managetab.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Managetab_Container extends Engine_Form {

  public function init() {

    $this->setTitle('Choose the view type Accordion / Tab Container.');

    $this->addElement('Radio', 'container_type', array(
        'label' => 'Show Tab View Type',
        'multiOptions' => array(
            '0' => 'Tab Container',
            '1' => 'Simple Accordion',
            '2' => 'Fixed Accordion',
        ),
        'value' => '0',
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Generate Code',
        'onClick' => 'showCode();',
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'prependText' => ' or ',
        'decorators' => array('ViewHelper'),
        'onClick' => 'javascript:parent.Smoothbox.close();',
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
