<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Form_Admin_Moderator_Create extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Add Moderator')
      ->setDescription('Search for a member to add as a moderator for this Forum.')
      ->setAttrib('id', 'sesforum_form_admin_moderator_create')
      ->setAttrib('class', 'global_form_popup')
      ;

    $this->addElement('Text', 'username', array(
      'label' => 'Member Name'
    ));

    $this->addElement('Hidden', 'user_id', array(
      'label' => 'User Identity',
      'required' => true,
      'allowEmpty' => false,
    ));

    // Buttons
    $this->addElement('Button', 'execute', array(
      'label' => 'Search',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'onclick' => 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));

    $this->addDisplayGroup(array('execute', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
    //$button_group->addDecorator('DivDivDivWrapper');
  }
}
