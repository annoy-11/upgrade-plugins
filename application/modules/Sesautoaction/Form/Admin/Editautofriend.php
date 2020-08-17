<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editautofriend.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_Form_Admin_Editautofriend extends Engine_Form {

  public function init() {

        $settings = Engine_Api::_()->getApi('settings', 'core');
        $this
            ->setTitle('Edit Auto Friend Settings')
            ->setDescription('These settings affect all members in your community.');
        $this->setMethod('post');

        $this->addElement('Text', 'title', array(
            'label' => 'Title',
            'description' => 'Enter title for this bot auto action. This is only for identification.',
            'allowEmpty' => false,
            'required' => true,
        ));

        $levelOptions = array();
        foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
            $levelOptions[$level->level_id] = $level->getTitle();
        }
        unset($levelOptions['5']);
        $memberlevels = explode(',', $settings->getSetting('sesautoaction.memberlevels', array()));
        $this->addElement('Multiselect', 'member_levels', array(
            'label' => 'Member Level',
            'description' => 'Choose the member levels. (Ctrl + Click to select multiple member levels.)',
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
