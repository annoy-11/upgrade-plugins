<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Createbotaction.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_Form_Admin_Createbotaction extends Engine_Form {

  public function init() {

    $this->setTitle('Create New Auto Action to be Performed by Bots')->setAttrib('id', 'form-botauto-action');
    $this->setMethod('post');

    $this->addElement('Text', 'title', array(
        'label' => 'Action Title',
        'description' => 'Enter the title for this auto action to be performed by the bots on your website. (This is only for identification.)',
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Radio', 'actionperform', array(
      'label' => 'Select Users To Get Actions',
      'description' => 'Select users from below options, on whose new content Bots will perform actions on your website. You can choose Bots in the "Choose Bot" setting below.',
      'multiOptions' => array(
        '1' => 'A Specific User',
        '0' => 'Users based on their Member Levels',
      ),
      'onclick' => 'chooseoptions(this.value);',
      'value' => '1',

    ));

    $this->addElement('Text', 'name', array(
        'label' => 'Select Specific User',
        'description' => 'Select the specific user from auto-suggest box below on whose new content bots will perform actions on your website.',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Hidden', 'resource_id', array());

    $levelOptions = array();
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
        $levelOptions[$level->level_id] = $level->getTitle();
    }

    $this->addElement('Multiselect', 'member_levels', array(
        'label' => 'Select Member Levels',
        'description' => 'Select the member levels belonging to which members will get auto actions on their new content by bots. (Ctrl + Click to select multiple member levels.)',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions' => $levelOptions,
        'value' => '',
    ));

    $this->addElement('Select', 'likeaction', array(
      'label' => 'Auto Like',
      'description' => 'Do you want bots to auto Like new content of above selected members?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '1',
    ));

    $this->addElement('Select', 'commentaction', array(
      'label' => 'Auto Comment',
      'description' => 'Do you want bots to auto Comment new content of above selected members? You can add comments which will be randomly posted from the "Manage Comments" section of this plugin.',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

//     $this->addElement('Select', 'friend', array(
//       'label' => 'Auto Friend',
//       'description' => 'Do you want auto friend of selected content?',
//       'multiOptions' => array(
//         '1' => 'Yes',
//         '0' => 'No',
//       ),
//       'value' => '0',
//     ));

    $this->addElement('Select', 'join', array(
      'label' => 'Auto Join',
      'description' => 'Do you want bots to auto Join new content of above selected members?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    $this->addElement('Select', 'favourite', array(
      'label' => 'Auto Favourite',
      'description' => 'Do you want bots to auto Favourite new content of above selected members?',
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

    $this->addElement('Select', 'follow', array(
      'label' => 'Auto Follow',
      'description' => 'Do you want bots to auto Follow new content of above selected members?',
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
        'label' => 'Choose Bots',
        'description' => 'Choose the bots who will perform auto actions on content created by above selected members of your website. You can add and manage Bots from the "Manage Bots" section of this plugin.',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => $bots,
        'value' => '',
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
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}
