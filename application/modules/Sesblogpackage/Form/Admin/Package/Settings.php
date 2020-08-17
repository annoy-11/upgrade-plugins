<?php

class Sesblogpackage_Form_Admin_Package_Settings extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Package Settings')
      ->setDescription('You can enable disable package from here.')
      ->setAttrib('class', 'global_form_popup')
      ;
     $settings = Engine_Api::_()->getApi('settings', 'core');
		 $this->addElement('Select', 'sesblogpackage_enable_package', array(
          'label' => 'Package',
          'description' => 'Do you want to enable package?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onchange' => 'enable_package(this.value)',
          'value' => $settings->getSetting('sesblogpackage.enable.package', 1),
      ));
		
		$information = array('description'=>'Package Description','featured'=>'Featured','sponsored'=>'Sponsored','verified'=>'Verified','location'=>'Location','modules'=>'Modules','editor'=>'Rich Editor','custom_fields'=>'Custom Fields','blogcount'=>'Blog Count');
		
		/*$this->addElement('MultiCheckbox', 'sesblogpackage_package_info', array(
        'label' => 'Package Information',
        'description' => 'Information show in the package.',
        'multiOptions' => $information,
        'value' => $settings->getSetting('sesblogpackage.package.information', array_keys($information)),
    ));*/
		
		 $this->addElement('Radio', 'sesblogpackage_payment_mod_enable', array(
        'label' => 'Enable Blogs',
        'description' => "How you want to activate Blogs after successful payment." ,
        'multiOptions' => array(
            'all' => 'Enable Package immediately.',
            'some' => 'Enable if user has an existing successful transaction, wait if this is their first.',
						'none' => 'Wait until the gateway signals that the payment has completed successfully.'
        ),
        'value' => $settings->getSetting('sesblogpackage.payment.mod.enable', 'all'),
    ));
		
    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Settings',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

  }
}