<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editbotaction.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_Form_Admin_Editbotaction extends Engine_Form {

  public function init() {

    $this->setTitle('Edit Bot Auto Action');
    $this->setMethod('post');

    $this->addElement('Text', 'title', array(
        'label' => 'Title',
        'description' => 'Enter title for this bot auto action. This is only for identification.',
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Radio', 'actionperform', array(
      'label' => 'Choose Option',
      'description' => 'Choose Option',
      'multiOptions' => array(
        '1' => 'Specific User',
        '0' => 'Member Levels',
      ),
      'onclick' => 'chooseoptions(this.value);',
      'value' => '1',
      'disable' => true,
    ));

    $this->addElement('Text', 'name', array(
        'label' => 'Member Name for Specific Action Perform',
        'description' => 'Enter user name.',
        'allowEmpty' => true,
        'required' => false,
        'disable' => true,
    ));
    $this->addElement('Hidden', 'resource_id', array());

    $levelOptions = array();
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
        $levelOptions[$level->level_id] = $level->getTitle();
    }

    $this->addElement('Multiselect', 'member_levels', array(
        'label' => 'Member Level for Specific Action Perform',
        'description' => 'Choose the member levels. (Ctrl + Click to select multiple member levels.)',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions' => $levelOptions,
        'value' => '',
    ));

    $this->addElement('Select', 'likeaction', array(
      'label' => 'Auto Like',
      'description' => 'Do you want auto like selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '1',
    ));

    $this->addElement('Select', 'commentaction', array(
      'label' => 'Auto Comment',
      'description' => 'Do you want auto comment selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    $this->addElement('Select', 'friend', array(
      'label' => 'Auto Friend',
      'description' => 'Do you want auto friend of selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    $this->addElement('Select', 'join', array(
      'label' => 'Auto Join',
      'description' => 'Do you want auto join of selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    $this->addElement('Select', 'favourite', array(
      'label' => 'Auto Favourite',
      'description' => 'Do you want auto favourite of selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    $this->addElement('Select', 'follow', array(
      'label' => 'Auto Follow',
      'description' => 'Do you want auto follow of selected content?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));


    $bots = array();
    foreach (Engine_Api::_()->getDbTable('users', 'sesautoaction')->fetchAll() as $user) {
        $bots[$user->resource_id] = $user->displayname;
    }

    $this->addElement('MultiCheckbox', 'users', array(
        'label' => 'Bot Users',
        'description' => 'Select bot user whcih perform auto action on content.',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => $bots,
        'value' => '',
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}
