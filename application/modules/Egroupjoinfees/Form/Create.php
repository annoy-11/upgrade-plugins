<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @plan    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Egroupjoinfees_Form_Create extends Engine_Form
{
  public function init()
  {
    parent::init();
    $this->setTitle('Entry Fees');
    //$descri = "There seems to be some issue with the payment gateway details of this website. Please contact our site administrators to  proceed with entering the fees for your grroup.";
    //check gateway enable
    $gatewayTable = Engine_Api::_()->getDbtable('gateways', 'payment');
    $gatewaySelect = $gatewayTable->select()
      ->where('enabled = ?', 1);
    $gateways = $gatewayTable->fetchAll($gatewaySelect);
    $enable = false;
    foreach($gateways as $gateway){
      if($gateway->enabled){
        $enable = true;
        break;  
      }
    }
    if(!$enable)
      $description = $this->getTranslator()->translate($descri);
    else
      $description = $this->getTranslator()->translate("Below, enter the Group Joining Fees or Entry Submission Fees, which you want to charge from members who wants to participate in your grroup.");
    $this->setDescription($description);
    // Decorators
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);
    if(!$enable)
      return;
    // Elements
    
//     $defaultCurrency = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmultiplecurrency.defaultcurrency',Engine_Api::_()->getApi('settings', 'core')->getSetting('payment.currency', 'USD'));
// 		//Event Currency
// 		$this->addElement('Select', 'currency', array(
// 		 		'label'=>'Currency',
//         'multiOptions' => array($defaultCurrency=>$defaultCurrency),
//     ));
//     $this->addElement('Text', 'entry_fees', array(
//       'label' => 'Entry Fees',
//       'filters' => array(
//        new Zend_Filter_StringTrim(),
//       ),
//       'value'=>0,
//       'validators' => array(
//             array('Int', true),
//         )
//     ));
    
    $this->addElement('Text', 'title', array(
        'label' => 'Package Title',
        'required' => true,
        'allowEmpty' => false,
        'filters' => array(
            'StringTrim',
        ),
    ));
    // Element: description
    $this->addElement('Textarea', 'description', array(
        'label' => 'Package Description',
        'description' => 'Enter the description for this plan. This will be shown in the listing of plans on your website.',
        'validators' => array(
            array('StringLength', true, array(0, 250)),
        )
    ));
    // Element: level_id
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
      if ($level->type == 'public') {
        continue;
      }
      $multiOptions[$level->getIdentity()] = $level->getTitle();
    }
    $multiOptions = array_merge(array('0' => 'All Levels'), $multiOptions);
    $this->addElement('Multiselect', 'member_level', array(
        'label' => 'Member Level',
        'description' => 'Only the selected member levels will be allowed to view and purchase this plan for creating contests on your site.',
        'multiOptions' => $multiOptions,
        'value' => '0'
    ));
    // Element: price
    $this->addElement('Text', 'price', array(
        'label' => 'Price',
        'description' => 'Enter the amount to be charged from users for creating contests under this plan. This amount will be charged only once for one-time plans and at each billing cycle for recurring plans. Use ‘0’ to make this plan Free.',
        'required' => true,
        'allowEmpty' => false,
        'validators' => array(
            array('Float', true),
            new Engine_Validate_AtLeast(0),
        ),
        'value' => '0.00',
    ));
    // Element: recurrence
    $this->addElement('Duration', 'recurrence', array(
        'label' => 'Billing Cycle',
        'description' => 'How often should members in this plan be billed?',
        'required' => true,
        'allowEmpty' => false,
        'value' => array(1, 'month'),
    ));
    // Element: duration
    $this->addElement('Duration', 'duration', array(
        'label' => 'Billing Duration',
        'description' => 'When should this plan expire? For one-time plan, the plan will expire after the period of time set here. For recurring plans, the user will be billed at the above billing cycle for the period of time specified here.',
        'required' => true,
        'allowEmpty' => false,
        'value' => array('0', 'forever'),
    ));
    // renew
    $this->addElement('Select', 'is_renew_link', array(
        'description' => 'Renew Link',
        'label' => 'Want to show reniew link',
        'value' => 0,
        'multiOptions' => array('1' => 'Yes, show reniew link', '0' => 'No, don\'t show renew link'),
        'onchange' => 'showRenewData(this.value);',
    ));
    $this->addElement('Text', 'renew_link_days', array(
        'label' => 'Days before show renew link',
        'description' => 'Show renewal link before how many days before expiry.',
        'required' => true,
        'allowEmpty' => false,
        'validators' => array(
            array('Int', true),
            new Engine_Validate_AtLeast(0),
        ),
        'value' => '0',
    ));
    $this->addElement('Select', 'enabled', array(
        'label' => 'Enabled?',
        'description' => 'Do you want to enable this plan? (The existing members that were in that plan would stay in that plan until they pick another plan.)',
        'multiOptions' => array(
            '1' => 'Yes, users may select this plan.',
            '0' => 'No, users may not select this plan.',
        ),
        'value' => 1,
    ));
		// Element: execute
    $this->addElement('Button', 'execute', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'decorators' => array('ViewHelper'),
      'order' => 10001,
      'ignore' => true,
    ));
  }
}
