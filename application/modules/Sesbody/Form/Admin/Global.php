<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbody_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
            
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesbody_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesbody.licensekey'),
    ));
    $this->getElement('sesbody_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sesbody.pluginactivated')) {

      $this->addElement('Dummy', 'layout_settings', array(
          'label' => 'Layout Settings',
          'description' => 'Choose from below the settings for the Layout of the theme. These settings will affect all the existing Color Schemes of the theme including the custom color scheme made by you.',
      ));

      $this->addElement('Text', "sesbody_main_width", array(
          'label' => 'Theme Width',
          'allowEmpty' => false,
          'required' => true,
          'value' => Engine_Api::_()->sesbody()->getContantValueXML('sesbody_main_width'),
      ));

      $this->addElement('Text', "sesbody_left_columns_width", array(
          'label' => 'Left Column Width',
          'allowEmpty' => false,
          'required' => true,
          'value' => Engine_Api::_()->sesbody()->getContantValueXML('sesbody_left_columns_width'),
      ));

      $this->addElement('Text', "sesbody_right_columns_width", array(
          'label' => 'Right Column Width',
          'allowEmpty' => false,
          'required' => true,
          'value' => Engine_Api::_()->sesbody()->getContantValueXML('sesbody_right_columns_width'),
      ));

      $this->addDisplayGroup(array('sesbody_main_width', 'sesbody_left_columns_width', 'sesbody_right_columns_width'), 'general_settings_group', array('disableLoadDefaultDecorators' => true));
      $general_settings_group = $this->getDisplayGroup('general_settings_group');
      $general_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'general_settings_group'))));


      $banner_options[] = '';
      $path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
      foreach ($path as $file) {
        if ($file->isDot() || !$file->isFile())
          continue;
        $base_name = basename($file->getFilename());
        if (!($pos = strrpos($base_name, '.')))
          continue;
        $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
        if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
          continue;
        $banner_options['public/admin/' . $base_name] = $base_name;
      }
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $fileLink = $view->baseUrl() . '/admin/files/';
      $this->addElement('Select', 'sesbody_body_background_image', array(
          'label' => 'Body Background Image',
          'description' => 'Choose from below the body background image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
          'multiOptions' => $banner_options,
          'escape' => false,
          'value' => Engine_Api::_()->sesbody()->getContantValueXML('sesbody_body_background_image'),
      ));
      $this->sesbody_body_background_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedheader')) {
      $this->addElement('Radio', 'sesbody_header_design', array(
          'label' => 'Replace Your Theme Header?',
          'description' => 'Do you want to replace the styling of your Theme Header?(This setting will only work with Advanced Header Plugin.)',
          'multiOptions' => array(
              1 => 'Yes',
              2 => 'No'
          ),
          'value' => Engine_Api::_()->sesbody()->getContantValueXML('sesbody_header_design'),
      ));
      }
      if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesfooter')) {
			$this->addElement('Radio', 'sesbody_footer_design', array(
          'label' => 'Replace Your Theme Footer?',
          'description' => 'Do you want to replace the styling of your Theme Footer?(This setting will only work with Advanced Footer Plugin.)',
          'multiOptions' => array(
              1 => 'Yes',
              2 => 'No'
          ),
          'value' => Engine_Api::_()->sesbody()->getContantValueXML('sesbody_footer_design'),
      ));
      }
      $this->addElement('Radio', 'sesbody_user_photo_round', array(
          'label' => 'Show Thumb Icons in Round?',
          'description' => 'Do you want to show the “thumb icons” of members’ photos and images of content from various plugins in round shape?',
          'multiOptions' => array(
              1 => 'Yes',
              2 => 'No'
          ),
          'value' => Engine_Api::_()->sesbody()->getContantValueXML('sesbody_user_photo_round'),
      ));

      $this->addElement('Select', 'sesbody_leftrightheadingdesign', array(
        'label' => 'Left / Right Side Widget Heading Design',
        'description' => 'Choose from below design of Left  / Side Bar Widget Heading.',
        'multiOptions' => array(
            'heading_design_one' => 'Heading Design - 1',
            'heading_design_two' => 'Heading Design - 2',
            'heading_design_three' => 'Heading Design - 3',
            'heading_design_four' => 'Heading Design - 4',
            'heading_design_five' => 'Heading Design - 5',
            'heading_design_six' => 'Heading Design - 6',
            'heading_design_seven' => 'Heading Design - 7',
            'heading_design_eight' => 'Heading Design - 8',
        ),
        'value' => $settings->getSetting('sesbody.leftrightheadingdesign', 'heading_design_one'),
      ));


    $this->addElement('Select', 'sesbody_widget_background_image', array(
          'label' => 'Left/ Right Side Widget background image',
          'description' => 'Select the background image for Left/ Right Side Widget.',
          'multiOptions' => $banner_options,
          'escape' => false,
          'value' => Engine_Api::_()->sesbody()->getContantValueXML('sesbody_widget_background_image'),
      ));
      $this->sesbody_body_background_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Select', 'sesbody_boxradius', array(
          'label' => 'Left / Right Side Widget Box Radius',
          'description' => 'Do you want radius in left / right side widget box?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesbody.boxradius', 0),
      ));

      //Button Stylign Work
      $this->addElement('Text', 'sesbody_buttonradius', array(
        'label' => 'Button Radius',
        'description' => 'Enter Button Radius',
        'value' => $settings->getSetting('sesbody.buttonradius', 0),
      ));


      $this->addElement('Select', 'sesbody_buttonstyling', array(
        'label' => 'Button Styling',
        'description' => 'For Gradients Styling, you can choose the colors from Button Background Gradient Top Color and Button Background Gradient top Hover Color in Color schemes section of this plugin',
        'multiOptions' => array(
          'transparent' => 'Transparent',
          'fill' => 'Fill',
          'gradients' => "Gradients",
        ),
        'value' => $settings->getSetting('sesbody.buttonstyling', 'transparent'),
      ));

      $this->addElement('Select', 'sesbutton_effacts', array(
        'label' => 'Button Effects',
        'description' => 'Choose Button Effects',
        'multiOptions' => array(
          0 => 'Default',
          1 => 'Fade',
          2 => 'Sweep to Right',
          3 => 'Sweep to Top',
          4 => 'Bounce to Right',
          5 => 'Radial Out',
          6 => 'Shutter Out Horizontal',
          7 => 'Bounce In',
          8 => 'Button Shade',
        ),
        'value' => Engine_Api::_()->sesbody()->getContantValueXML('sesbutton_effacts'),
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
