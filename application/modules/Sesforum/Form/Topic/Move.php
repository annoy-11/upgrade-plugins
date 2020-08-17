<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Move.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Form_Topic_Move extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Move Topic')
      ;

    $this->addElement('Select', 'forum_id', array(
      'label' => 'Forum',
      'allowEmpty' => false,
      'required' => true,
    ));

    // Element: execute
    $this->addElement('Button', 'execute', array(
      'label' => 'Move Topic',
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
