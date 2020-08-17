<?php

class Sesgroupalbum_Form_Admin_Global extends Engine_Form {

  public function init() {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
            
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
		$sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
		$descriptionLicense = sprintf('Enter the your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);
		$this->addElement('Text', "sesgroupalbum_licensekey", array(
		'label' => 'Enter License key',
		'description' => $descriptionLicense,
		'allowEmpty' => false,
		'required' => true,
		'value' => $settings->getSetting('sesgroupalbum.licensekey'),
		));
		$this->getElement('sesgroupalbum_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
		
    //if ($settings->getSetting('sesgroupalbum.pluginactivated')) {
    if (1) {


			$this->addElement('Radio', 'sesgroupalbum_enable_location', array(
        'label' => 'Enable Location in Album/Photo',
        'description' => 'Choose from below where do you want to enable location in Album/Photo.',
        'multiOptions' => array(
            '1' => 'Yes,Enable Location',
            '0' => 'No,Don\'t Enable Location',
        ),
        'value' => $settings->getSetting('sesgroupalbum.enable.location', 1),
    ));
      $this->addElement('Radio', 'sesgroupalbum_search_type', array(
          'label' => 'Proximity Search Unit',
          'description' => 'Choose the unit for proximity search of albums and photos on your website.',
          'multiOptions' => array(
              1 => 'Miles',
              0 => 'Kilometres'
          ),
          'value' => $settings->getSetting('sesgroupalbum.search.type', 1),
      ));

      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $this->addElement('Radio', 'sesgroupalbum_watermark_enable', array(
          'label' => 'Add Watermark to Photos',
          'description' => 'Do you want to add watermark to photos on your website? If you choose Yes, then you can upload watermark image to be added to the photos on your website from the <a href="' . $view->baseUrl() . "/admin/sesgroupalbum/level" . '">Member Level Settings</a>.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'show_position(this.value)',
          'value' => $settings->getSetting('sesgroupalbum.watermark.enable', 0),
      ));
      $this->addElement('Select', 'sesgroupalbum_position_watermark', array(
          'label' => 'Select the position of watermark',
          'description' => '',
          'multiOptions' => array(
              0 => 'Middle ',
              1 => 'Top Left',
              2 => 'Top Right',
              3 => 'Bottom Right',
              4 => 'Bottom Left',
              5 => 'Top Middle',
              6 => 'Middle Right',
              7 => 'Bottom Middle',
              8 => 'Middle Left',
          ),
          'value' => $settings->getSetting('sesgroupalbum.position.watermark', 0),
      ));
      $this->sesgroupalbum_watermark_enable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->addElement('Text', "sesgroupalbum_mainheight", array(
          'label' => 'Large Photo Height',
          'description' => "Enter the maximum height of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on Photo View Page. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesgroupalbum.mainheight', 1600),
      ));
      $this->addElement('Text', "sesgroupalbum_mainwidth", array(
          'label' => 'Large Photo Width',
          'description' => "Enter the maximum width of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on Photo View Page. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesgroupalbum.mainwidth', 1600),
      ));
      $this->addElement('Text', "sesgroupalbum_normalheight", array(
          'label' => 'Medium Photo Height',
          'description' => "Enter the maximum height of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesgroupalbum.normalheight', 500),
      ));
      $this->addElement('Text', "sesgroupalbum_normalwidth", array(
          'label' => 'Medium Photo Width',
          'description' => "Enter the maximum width of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesgroupalbum.normalwidth', 500),
      ));
      $this->addElement('Radio', 'sesgroupalbum_album_rating', array(
          'label' => 'Allow Rating on Albums',
          'description' => 'Do you want to allow users to give ratings on albums on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'rating_album(this.value)',
          'value' => $settings->getSetting('sesgroupalbum.album.rating', 1),
      ));
      $this->addElement('Radio', 'sesgroupalbum_ratealbum_own', array(
          'label' => 'Allow Rating on Own Albums',
          'description' => 'Do you want to allow users to give ratings on own albums on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesgroupalbum.ratealbum.own', 1),
      ));
      $this->addElement('Radio', 'sesgroupalbum_ratealbum_again', array(
          'label' => 'Allow to Edit Rating on Albums',
          'description' => 'Do you want to allow users to edit their ratings on albums on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesgroupalbum.ratealbum.again', 1),
      ));
      $this->addElement('Radio', 'sesgroupalbum_ratealbum_show', array(
          'label' => 'Show Previous Rating on Albums',
          'description' => 'Do you want to show previous ratings on albums on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesgroupalbum.ratealbum.show', 1),
      ));
      $this->addElement('Radio', 'sesgroupalbum_photo_rating', array(
          'label' => 'Allow Rating on Photos',
          'description' => 'Do you want to allow users to give ratings on photos on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'rating_photo(this.value)',
          'value' => $settings->getSetting('sesgroupalbum.photo.rating', 1),
      ));
      $this->addElement('Radio', 'sesgroupalbum_ratephoto_own', array(
          'label' => 'Allow Rating on Own Photos',
          'description' => 'Do you want to allow users to give ratings on own photos on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesgroupalbum.ratephoto.own', 1),
      ));
      $this->addElement('Radio', 'sesgroupalbum_ratephoto_again', array(
          'label' => 'Allow to Edit Rating on Photos',
          'description' => 'Do you want to allow users to edit their ratings on photos on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesgroupalbum.ratephoto.own', 1),
      ));
      $this->addElement('Radio', 'sesgroupalbum_ratephoto_show', array(
          'label' => 'Show Previous Rating on Photos',
          'description' => 'Do you want to show previous ratings on photos on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesgroupalbum.ratephoto.show', 1),
      ));

      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {
      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate your plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }

}
