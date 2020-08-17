<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Rename.php  2019-01-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfmm_Form_Admin_File_Rename extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Rename File')
      ;
    $this->setAttrib('class', 'global_form_popup');
    $this->addElement('Text', 'name', array(
      'label' => 'Title',
      'allowEmpty' => false,
      'required' => true
    ));

    $this->addElement('Button', 'submit', array(
      'label' => 'Rename',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onClick'=> 'javascript:parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }
}
