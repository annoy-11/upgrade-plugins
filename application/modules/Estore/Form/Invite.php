<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Invite.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Invite extends Engine_Form {

  public function init() {
    $this
            ->setTitle('Invite Members')
            ->setDescription('Choose the people you want to invite to this store.')
            ->setAttrib('id', 'estore_form_invite');

    $this->addElement('Checkbox', 'all', array(
        'id' => 'selectall',
        'label' => 'Choose All Friends',
        'ignore' => true
    ));

    $this->addElement('MultiCheckbox', 'users', array(
        'label' => 'Members',
        'required' => true,
        'allowEmpty' => 'false',
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Send Invites',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'prependText' => ' or ',
        'onclick' => 'parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
