<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Autofriend.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_Form_Admin_Autofriend extends Engine_Form {

  public function init() {

        $settings = Engine_Api::_()->getApi('settings', 'core');
        $this
            ->setTitle('Create New Auto Friendship Action')
            ->setDescription('Here, you can add new friendship action your website.');
        $this->setMethod('post');

        $this->addElement('Text', 'title', array(
            'label' => 'Title',
            'description' => 'Enter the title for this auto friendship action to be performed by the bots on your website. (This is only for identification.)',
            'allowEmpty' => false,
            'required' => true,
        ));

        $levelOptions = array();
        foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
            $levelOptions[$level->level_id] = $level->getTitle();
        }
        unset($levelOptions['1']);
        unset($levelOptions['2']);
        unset($levelOptions['3']);
        unset($levelOptions['5']);
        $memberlevels = explode(',', $settings->getSetting('sesautoaction.memberlevels', array()));
        $this->addElement('Multiselect', 'member_levels', array(
            'label' => 'Select Member Levels',
            'description' => 'Select the member levels belonging to which members will become auto friends with bots on your website. (Ctrl + Click to select multiple member levels.)',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => $levelOptions,
            'value' => '',
        ));

        $bots = array();
        foreach (Engine_Api::_()->getDbTable('users', 'sesautoaction')->fetchAll() as $user) {
            $bots[$user->resource_id] = $user->displayname;
        }

        $this->addElement('MultiCheckbox', 'users', array(
            'label' => 'Choose Bots',
            'description' => 'Choose the bots who will perform friendship auto actions on your website. You can add and manage Bots from the "Manage Bots" section of this plugin.',
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
