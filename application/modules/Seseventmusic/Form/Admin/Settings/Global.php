<?php

class Seseventmusic_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
		$sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
		$descriptionLicense = sprintf('Enter the your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);
		$this->addElement('Text', "seseventmusic_licensekey", array(
		'label' => 'Enter License key',
		'description' => $descriptionLicense,
		'allowEmpty' => false,
		'required' => true,
		'value' => $settings->getSetting('seseventmusic.licensekey'),
		));
		$this->getElement('seseventmusic_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('seseventmusic.pluginactivated')) {
      $guidlines = 'How to get SoundCloud Client ID and Client Secret?
        
        1. Login to your SoundCloud Account. Register a new account, if you do not have one.
        2. Now, go to the URL: https://soundcloud.com/you/apps
        3. Click on Register a new application button.
        4. Follow the easy steps by entering the name of your app and your website URL.
        5. Now, copy the Client ID and Client Secret and paste here.';

      $this->addElement('Radio', 'seseventmusic_uploadoption', array(
          'label' => 'Choose Song Source',
          'description' => 'Choose the source of songs from which you want songs to be uploaded on your website.',
          'multiOptions' => array(
              'myComputer' => "My Computer",
              'soundCloud' => 'SoundCloud [enter the "SoundCloud Client Id" and "SoundCloud Client Secret" below.]',
              'both' => 'Both "My Computer" and "SoundCloud"',
          ),
          'escape' => false,
          'onchange' => 'checkUpload(this.value)',
          'value' => $settings->getSetting('seseventmusic.uploadoption', 'myComputer'),
      ));

      $this->addElement('Text', "seseventmusic_scclientid", array(
          'label' => 'SoundCloud Client Id',
          'description' => 'Enter the SoundCloud Client Id. [Note: If you remove this “Id”, then the current songs from SoundCloud will not show Play option.] ' . '<a href="javascript:void(0);" title="' . $guidlines . '"><img onclick="showPopUp();" src="application/modules/Sesbasic/externals/images/icons/question.png" alt="Question" /></a>',
          'value' => $settings->getSetting('seseventmusic.scclientid'),
      ));
      $this->seseventmusic_scclientid->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Text', "seseventmusic_scclientscreatid", array(
          'label' => 'SoundCloud Client Secret',
          'description' => 'Enter the SoundCloud Client Secret Key. [Note: If you remove this “Key”, then the current songs from SoundCloud will not show Play option.] ' . '<a href="javascript:void(0);" title="' . $guidlines . '"><img onclick="showPopUp();" src="application/modules/Sesbasic/externals/images/icons/question.png" alt="Question" /></a>',
          'value' => $settings->getSetting('seseventmusic.scclientscreatid'),
      ));
      $this->seseventmusic_scclientscreatid->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Radio', 'seseventmusic_showplayer', array(
          'label' => 'Choose Music Player',
          'description' => 'Choose the music player which you want to show on your website to play songs?',
          'multiOptions' => array(
              '1' => 'Mini Player',
              '0' => 'Full Width Player',
          ),
          'value' => $settings->getSetting('seseventmusic.showplayer', 0),
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
