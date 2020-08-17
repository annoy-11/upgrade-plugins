<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddHeading.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslinkedin_Form_Admin_AddHeading extends Engine_Form {

  public function init() {

    $this->setMethod('POST');

    $this->addElement('Text', "name", array(
        'label' => 'Enter heading name.',
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Button', 'button', array(
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Select', 'type', array(
      'label' => 'Choose Type',
      'multiOptions' => array(
        'horizontal' => 'Horizontal',
        'vertical' => 'Vertical',
      ),
      'value' => 'horizontal',
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
