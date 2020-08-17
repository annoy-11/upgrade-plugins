<?php

class Sesblogpackage_Form_Admin_Package_Create extends Engine_Form
{
	protected $_customFields;
	function getCustomFields($customFields){
		return $this->_customFields;
	}
	public function setCustomFields($customFields){
		return $this->_customFields = $customFields;
	}
  public function init()
  {
    $this
      ->setTitle('Create Package')
      ->setDescription('Please note that payment parameters (Price,Recurrence, Duration, Blogs Count) cannot be edited after creation. If you wish to change these, you will have to create a new package and disable the current one.');

    // Element: title
    $this->addElement('Text', 'title', array(
      'label' => 'Package Title',
      'required' => true,
      'allowEmpty' => false,
      'filters' => array(
        'StringTrim',
      ),
    ));
		
		 // Element: title
    $this->addElement('Text', 'item_count', array(
      'label' => 'Blogs Count',
			'description'=>'Enter the maximum number of Blogs a member can create in this package. The field must contain an integer, use zero for unlimited. ',
      'required' => true,
      'allowEmpty' => false,
      'filters' => array(
        'StringTrim',
      ),
			'validators' => array(
        new Engine_Validate_AtLeast(0),
      ),
      'value' => '0',
    ));
		
    // Element: description
    $this->addElement('Textarea', 'description', array(
      'label' => 'Package Description',
      'validators' => array(
        array('StringLength', true, array(0, 250)),
      )
    ));

    // Element: level_id
    foreach( Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level ) {
			 if( $level->type == 'public' ) {
        continue;
      }
      $multiOptions[$level->getIdentity()] = $level->getTitle();
    }
		$multiOptions = array_merge(array('0'=>'All Levels'),$multiOptions);
    $this->addElement('Multiselect', 'member_level', array(
      'label' => 'Member Level',
      'description' => 'Selected member level allowed to create Blogs in this package',
      'multiOptions' => $multiOptions,
			'value'=>'0'
    ));  
    
    // Element: price
    $this->addElement('Text', 'price', array(
      'label' => 'Price',
      'description' => 'The amount to charge for Blogs creation. This will be charged once for one-time plans, and each billing cycle for recurring plans. Setting this to zero will make this a free plan.',
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
      'description' => 'How often should Blogs in this package be billed?',
      'required' => true,
      'allowEmpty' => false,
      
      'value' => array(1, 'month'),
    ));
    
    
    // Element: duration
    $this->addElement('Duration', 'duration', array(
      'label' => 'Billing Duration',
      'description' => 'When should this package expire? For one-time package, the package will expire after the period of time set here. For recurring plans, the user will be billed at the above billing cycle for the period of time specified here.',
      'required' => true,
      'allowEmpty' => false,
      'value' => array('0', 'forever'),
    ));
    
		// renew
    $this->addElement('Select', 'is_renew_link', array(
        'description' => 'Renew Link',
        'label' => 'Want to show reniew link',
        'value' => 0,
				'multiOptions'=>array('1'=>'Yes, show reniew link','0'=>'No, don\'t show renew link'),
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
		
  	$this->addElement('Checkbox', 'is_featured', array(
					'description'=>'Featured',
	        'label' => 'Do you want to make Blogs created under this package Featured',
	        'value' => 0
	  ));
    $this->addElement('Checkbox', 'is_sponsored', array(
					'description'=>'Sponsored',
	        'label' => 'Do you want to make Blogs created under this package Sponsored',
	        'value' => 0
	  ));
		$this->addElement('Checkbox', 'is_verified', array(
					'description'=>'Verified',
	        'label' => 'Do you want to make Blogs created under this package Verified',
	        'value' => 0
	  ));
		$this->addElement('Checkbox', 'enable_location', array(
					'description'=>'Location',
	        'label' => 'Enable location for the Blogs created under this package',
	        'value' => 0
	  ));
		$this->addElement('Checkbox', 'enable_tinymce', array(
					'description'=>'Rich Editor',
	        'label' => 'Enable rich editor in Blogs descirpiton field',
	        'value' => 0
	  ));
		$module = array('photo'=>'Photos','review'=>'Reviews');
		if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesvideo')){
			$module = array_merge($module,array('video'=>'Videos'));
			$videoEnable = true;
		}
		if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmusic')){
			$module = array_merge($module,array('music'=>'Music'));
			$musicEnable = true;
		}
			
		// Element: enabled
    $this->addElement('MultiCheckbox', 'modules', array(
      'label' => 'Modules',
      'description' => 'Select the module you want to enable for the Blogs created under this package.',
      'multiOptions' => $module,
			'class'=>'moduled-checkbox',
      'value' => '',
    ));
		
		
		// Element: Photo
    $this->addElement('Text', 'photo_count', array(
      'label' => 'Photos Count',
			'description'=>'How many photo want to allow user to upload in one album, write zero for unlimited',
      'required' => true,
      'allowEmpty' => false,
      'validators' => array(
        new Engine_Validate_AtLeast(0),
      ),
      'value' => '0',
    ));
		if(isset($videoEnable)){
		// Element: Videos
			$this->addElement('Text', 'video_count', array(
				'label' => 'Videos Count',
				'description'=>'How many video user allow to upload, write zero for unlimited',
				'required' => true,
				'allowEmpty' => false,
				'validators' => array(
					new Engine_Validate_AtLeast(0),
				),
				'value' => '0',
			));
		}
		if(isset($musicEnable)){
		// Element: Music
			$this->addElement('Text', 'music_count', array(
				'label' => 'Music Count',
				'description'=>'How many music user  allow to upload, write zero for unlimited',
				'required' => true,
				'allowEmpty' => false,
				'validators' => array(
					new Engine_Validate_AtLeast(0),
				),
				'value' => '0',
			));
		}
		
		$this->addElement('Radio', 'custom_fields', array(
					'label'=>'Custom Fields',
	        'description' => 'Do you want to enable Custom Fields for Blogs created under this package Featured',
	        'value' => 0,
					'onclick'=>'customField(this.value)',
					'multiOptions'=> array(
						1 => 'Allow all available custom fields',
						0 => 'No don\'t allow custom fields',
						2 => 'Allow only selected custom fields',
					),
	  ));
		
    $this->addElement('Dummy', 'customfields', array(
        'ignore' => true,
        'decorators' => array(array('ViewScript', array(
                    'viewScript' => '_customFields.tpl',
                    'class' => 'form element',
										'customFields' => $this->_customFields,
            )))
    ));
		
		// Element: highlight
    $this->addElement('Select', 'highlight', array(
      'label' => 'Highlight?',
      'description' => 'Do you want to highlight this package?',
      'multiOptions' => array(
        '1' => 'Yes, want to highlight this package.',
        '0' => 'No, don\'t want to highlight this package.',
      ),
      'value' => 1,
    ));
		
		// Element: highlight
    $this->addElement('Select', 'show_upgrade', array(
      'label' => 'Show In Upgrade?',
      'description' => 'Do you want to show this package when user upgrade the package from blog dashboard?',
      'multiOptions' => array(
        '1' => 'Yes, want to show this package in upgrade section.',
        '0' => 'No, don\'t want to show this package in upgrade section.',
      ),
      'value' => 1,
    ));
		
    // Element: enabled
    $this->addElement('Select', 'enabled', array(
      'label' => 'Enabled?',
      'description' => 'Enable this package',
      'multiOptions' => array(
        '1' => 'Yes, users may select this plan.',
        '0' => 'No, users may not select this plan.',
      ),
      'value' => 1,
    ));

 
    // Element: execute
    $this->addElement('Button', 'execute', array(
      'label' => 'Create Package',
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
      'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
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