<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessegpay_Form_Admin_Package_Create extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Create Subscription Plan')
      ->setDescription('Please note that payment parameters (Price, ' .
          'Recurrence, Duration, Trial Duration) cannot be edited after ' .
          'creation. If you wish to change these, you will have to create a ' .
          'new plan and disable the current one.')
      ;

    // Element: title
    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'required' => true,
      'allowEmpty' => false,
      'filters' => array(
        'StringTrim',
      ),
    ));

    // Element: description
    $this->addElement('Textarea', 'description', array(
      'label' => 'Description',
      'validators' => array(
        array('StringLength', true, array(0, 250)),
      )
    ));

    // Element: level_id
    $multiOptions = array('' => '');
    foreach( Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level ) {
      if( $level->type == 'public' || $level->type == 'admin' || $level->type == 'moderator' ) {
        continue;
      }
      $multiOptions[$level->getIdentity()] = $level->getTitle();
    }
    $this->addElement('Select', 'level_id', array(
      'label' => 'Member Level',
      //'required' => true,
      //'allowEmpty' => false,
      'description' => 'The member will be placed into this level upon ' .
          'subscribing to this plan. If left empty, the default level at the ' .
          'time a subscription is chosen will be used.',
      'multiOptions' => $multiOptions,
    ));

    /*
    // Element: downgrade_level_id
    $this->addElement('Select', 'downgrade_level_id', array(
      'label' => 'Downgrade Member Level',
      'multiOptions' => $multiOptions,
    ));
    */

    // Element: price
    $currency = Engine_Api::_()->getApi('settings', 'core')->getSetting('payment.currency');

    $this->addElement('Select', 'type', array(
      'label' => 'Subscription Type',
      'multiOptions'=>array(1=>'Recurring',0=>'One time'),
      'value'=>'0'
    ));

    $allowEmpty = count($_POST) && $_POST['type'] == 1 ? false : true;
    $required = count($_POST) && $_POST['type'] == 1 ? true : false;

     $this->addElement('Text', 'price', array(
      'label' => 'Price',
      'description' => 'The amount to charge the member. This will be charged once.Setting this to zero will make this a free plan.',
      'required' => !$required,
      'allowEmpty' => !$allowEmpty,
      'validators' => array(
        new Engine_Validate_AtLeast(0),
      ),
    ));

    $this->addElement('Text', 'initial_price', array(
      'label' => 'Initial Price',
      'description' => 'Initial Price between 2.95 and 100.00',
      'required' => $required,
      'allowEmpty' => $allowEmpty,
      'validators' => array(
        new Engine_Validate_AtLeast(0),
      ),
      'value'=>0,
    ));

    $this->addElement('Text', 'initial_length', array(
      'label' => 'Initial Length',
      'description' => 'Initial Length between 3 days and 30 days',
      'required' => $required,
      'allowEmpty' => $allowEmpty,
      'validators' => array(),
      'value' => 0,
    ));

   $this->addElement('Text', 'recurring_price', array(
      'label' => 'Recurring Price',
      'description' => 'The amount to charge the member. This will be charged ' .
          'once for one-time plans, and each billing cycle for recurring ' .
          'plans. Setting this to zero will make this a free plan. If you create a recurring subscription then price between 19.95 and 49.95',
      'required' => $required,
      'allowEmpty' => $allowEmpty,
      'validators' => array(
        new Engine_Validate_AtLeast(0),
      ),
      'value' => 0,
    ));

    $this->addElement('Text', 'recurring_length', array(
      'label' => 'Recurring Length',
      'description' => 'Recurring Length between 30 days and 60 days',
      'required' => $required,
      'allowEmpty' => $allowEmpty,
      'value' => 0,
    ));

     $this->addElement('Text', 'packagesegpay_id', array(
      'label' => 'Package Id',
      'description' => 'Enter the package id',
      'required' => true,
      'allowEmpty' => false,
      'value' => '',
    ));

    $this->addElement('Text', 'pricepointsegpay_id', array(
      'label' => 'Price Point Id',
      'description' => 'Enter the price point id',
      'required' => true,
      'allowEmpty' => false,
      'value' => '',
    ));


    // Element: enabled
    $this->addElement('Radio', 'enabled', array(
      'label' => 'Enabled?',
      'description' => 'Can members choose this plan? Please note that disabling this plan will <a href="https://en.wikipedia.org/wiki/Grandfather_clause" target="_blank">grandfather</a> in existing plan members until they pick a new plan.',
      'multiOptions' => array(
        '1' => 'Yes, members may select this plan.',
        '0' => 'No, members may not select this plan.',
      ),
      'value' => 1,
    ));
    $this->getElement('enabled')->getDecorator('description')->setOption('escape', false);
    // Element: signup
    $this->addElement('Radio', 'signup', array(
      'label' => 'Show on signup?',
      'description' => 'Can members choose this plan on signup?',
      'multiOptions' => array(
        '1' => 'Yes, show this plan on signup.',
        '0' => 'No, only show this plan after signup.',
      ),
      'value' => 1,
    ));

    // Element: after_signup
    $this->addElement('Radio', 'after_signup', array(
      'label' => 'Show after signup?',
      'description' => 'Can members choose this plan after signup?',
      'multiOptions' => array(
        '1' => 'Yes, show this plan after signup.',
        '0' => 'No.',
      ),
      'value' => 1,
    ));

    // Element: default
    $this->addElement('Radio', 'default', array(
      'label' => 'Default Plan?',
      'description' => 'If choosing a plan on signup is disabled, this plan ' .
          'will be assigned to new members. Selecting this option will ' .
          'switch this setting from the current default plan. Only a ' .
          'free plan may be the default plan.',
      'multiOptions' => array(
        '1' => 'Yes, this plan will be selected by default after signup.',
        '0' => 'No, this is not the default plan.',
      ),
      'value' => 0,
    ));

    // Element: execute
    $this->addElement('Button', 'execute', array(
      'label' => 'Create Plan',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper'),
    ));

    // Element: cancel
    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'prependText' => ' or ',
      'ignore' => true,
      'link' => true,
      'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index', 'package_id' => null)),
      'decorators' => array('ViewHelper'),
    ));

    // DisplayGroup: buttons
    $this->addDisplayGroup(array('execute', 'cancel'), 'buttons', array(
      'decorators' => array(
        'FormElements',
        'DivDivDivWrapper',
      )
    ));
  }
}
