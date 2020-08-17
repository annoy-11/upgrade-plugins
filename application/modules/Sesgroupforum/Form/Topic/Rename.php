<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Rename.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Form_Topic_Rename extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Rename Topic')
      ;

    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'allowEmpty' => false,
      'required' => true,
      'validators' => array(
        array('StringLength', true, array(1, 64)),
      ),
      'filters' => array(
       'StripTags',
        new Engine_Filter_Censor(),
      ),
    ));

    // Element: execute
    $this->addElement('Button', 'execute', array(
      'label' => 'Rename Topic',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper'),
      'order' => 20,
    ));

    // Element: cancel
    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onClick' => 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      ),
      'order' => 21,
    ));

    $this->addDisplayGroup(array(
      'execute',
      'cancel'
    ), 'buttons', array(

    ));
  }
}
