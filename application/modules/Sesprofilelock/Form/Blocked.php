<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Blocked.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_Form_Blocked extends Fields_Form_Search {

  protected $_fieldType = 'user';
  protected $_item;

  public function setItem(User_Model_User $item) {
    $this->_item = $item;
  }

  public function getItem() {
    if (null === $this->_item) {
      throw new User_Model_Exception('No item set in ' . get_class($this));
    }
    return $this->_item;
  }

  public function init() {

    // Decorators
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);

    $description = Zend_Registry::get('Zend_Translate')->_('Here, you can add a person to your block list to make your profile unviewable to them. If you also want all of your other content to be unviewable to the blocked members, then in the <a target="_blank" href="%s/members/settings/privacy">Privacy Settings</a> section, select appropriate value for "Blocked Members" setting.');
    $description = sprintf($description, Zend_Controller_Front::getInstance()->getBaseUrl());

    $this->setTitle('Block Members')
            ->setDescription($description);

    $user = $this->getItem();

//    $member_levels = array();
//    $public_level = Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel();
//    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $row) {
//      if ($public_level->level_id != $row->level_id) {
//        $member_count = $row->getMembershipCount();
//        if (null !== ($translate = $this->getTranslator())) {
//          $title = $translate->translate($row->title);
//        } else {
//          $title = $row->title;
//        }
//        $member_levels[$row->level_id] = $title;
//      }
//    }
    //$multiOptions = array('' => ' ');
    $profileTypeFields = Engine_Api::_()->fields()->getFieldsObjectsByAlias($this->_fieldType, 'profile_type');
    if (count($profileTypeFields) !== 1 || !isset($profileTypeFields['profile_type']))
      return;
    $profileTypeField = $profileTypeFields['profile_type'];
    $options = $profileTypeField->getOptions();
    foreach ($options as $option) {
      $multiOptions[$option->option_id] = $option->label;
    }

    $sesproflelock_levels = $user->blocked_levels;
    $sesproflelock_levelsvalue = unserialize($sesproflelock_levels);

    $this->addElement('Multiselect', 'blocked_levels', array(
        'label' => 'Profile Types',
        'description' => 'Below, you can choose members belonging to which Profile Types should not be able to view your profile. Hold down the CTRL key to select or de-select specific Networks.',
        'multiOptions' => $multiOptions,
        'value' => $sesproflelock_levelsvalue,
    ));

    // Make Network List
    $table = Engine_Api::_()->getDbtable('networks', 'network');
    $select = $table->select()
            ->from($table->info('name'), array('network_id', 'title'))
            ->order('title');
    $result = $table->fetchAll($select);

    foreach ($result as $value) {
      $networksOptions[$value->network_id] = $value->title;
    }
    $blocked_networks = $user->blocked_networks;
    $sesproflelock_networkvalue = unserialize($blocked_networks);

    if (count($networksOptions) > 0) {
      $this->addElement('Multiselect', 'blocked_networks', array(
          'label' => 'Networks',
          'description' => 'Below, you can choose members belonging to which Networks should not be able to view your profile. Hold down the CTRL key to select or de-select specific Networks.',
          'multiOptions' => $networksOptions,
          'value' => $sesproflelock_networkvalue,
      ));
    }

    // init to
    $this->addElement('Text', 'to', array(
        'label' => 'Members',
        'placeholder' => 'Enter member name.',
        'autocomplete' => 'off'));
    Engine_Form::addDefaultDecorators($this->to);

    // Init to Values
    $this->addElement('Hidden', 'toValues', array(
        //'label' => 'Send To',
        //'required' => true,
        //  'allowEmpty' => false,
        'order' => 3,
        'validators' => array(
            'NotEmpty'
        ),
        'filters' => array(
            'HtmlEntities'
        ),
    ));
    Engine_Form::addDefaultDecorators($this->toValues);

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Settings',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
  }

}