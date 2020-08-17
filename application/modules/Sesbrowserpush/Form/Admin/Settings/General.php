<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: General.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbrowserpush_Form_Admin_Settings_General extends Engine_Form
{
  public function init()
  {

    $description = $this->getTranslator()->translate('These settings affect all members in your community. <br /><br /> <b>Note:</b> Please make sure to place widgets: "SES - Web & Mobile Push Notifications" & "SES - Prompt Display" in the <a href="admin/content?page=1"> Site Header</a> from Layout Editor of your website.');

    // Decorators
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription($description);
            
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesbrowserpush_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesbrowserpush.licensekey'),
    ));
    $this->getElement('sesbrowserpush_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));


    if ($settings->getSetting('sesbrowserpush.pluginactivated')) {

      $this->addElement('Radio', "sesbrowserpush_notificationpush", array(
        'label' => 'Enable Browser Notifications',
        'description' => 'Do you want to enable the website browser notification updates to be sent the subscribers of your website?',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions'=>array(1=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('sesbrowserpush.notificationpush',1),
        'onchange' => 'showHide(this.value);',
      ));

      $this->addElement('Select', "sesbrowserpush_type", array(
        'label' => 'Subscription Prompt Style',
        'description' => 'Choose from below how you want to prompt your users to subscribe to push notifications on your website? (Note: Users will finally subscribe from browser\'s default pop-up, no matter what prompt style you choose. Other styles are for enhancing visibility of the prompt and encouraging visitors for subscription.)',
        'multiOptions'=>array(
            '0' => 'Native Browser Prompt',
            '1' => 'Bell Prompt',
            '2' => 'Basic Popup Prompt',
            '3' => 'Custom HTML Popup Prompt',
        ),
        'onchange' => 'showHideOptions(this.value);',
        'value' => $settings->getSetting('sesbrowserpush.type',0),
      ));

      $this->addElement('Select', "sesbrowserpush_bellalways", array(
        'label' => 'Always Show Bell Icon',
        'description' => 'Do you want to always show the bell icon? If you choose Yes, then if users have subscribed the notifications, then they will be able to un-subscribe from the same. If you choose No, then once users subscribe to the notifications, bell icon will be hidden.',
        'multiOptions'=>array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesbrowserpush.bellalways',1),
      ));

      $this->addElement('Text', "sesbrowserpush_title", array(
        'label' => 'Prompt Title',
        'description' => 'Enter the title for the above chosen prompt style.',
        'value' => $settings->getSetting('sesbrowserpush.title', 'Would you like to receive notifications & stay updated always?'),
      ));
      $this->addElement('Textarea', "sesbrowserpush_descr", array(
        'label' => 'Prompt Description',
        'description' => 'Enter the description for the above chosen prompt style.',
        'value' => $settings->getSetting('sesbrowserpush.descr', 'Notifications can be turned off anytime from your browser settings.'),
      ));

    $this->addElement('Text', 'sesbrowserpush_days', array(
        'label' => 'Browser Prompt Visibility',
        'description' => 'Enter the number of days after which you want the prompt to be visible to users once closed? [Enter "0", if you want it to be visible each time users visit your website.]',
        'value' => $settings->getSetting('sesbrowserpush.days', 5),
    ));

    $this->addElement('Text', "sesbrowserpush_height", array(
        'label' => 'Custom HTML Prompt Height',
        'description' => 'Enter the height of the custom HTML popup prompt.',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesbrowserpush.height', '400'),
    ));

    $this->addElement('Text', "sesbrowserpush_width", array(
        'label' => 'Custom HTML Prompt Width',
        'description' => 'Enter the width of the custom HTML popup prompt.',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesbrowserpush.width', '500'),
    ));

    //New File System Code
    $logo_options = array('' => '');
    $files = Engine_Api::_()->getDbTable('files', 'core')->getFiles(array('fetchAll' => 1, 'extension' => array('gif', 'jpg', 'jpeg', 'png')));
    foreach( $files as $file ) {
      $logo_options[$file->storage_path] = $file->name;
    }
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $fileLink = $view->baseUrl() . '/admin/files/';
    $this->addElement('Select', 'sesbrowserpush_logo', array(
        'label' => 'Choose an Image',
        'description' => 'Choose from below the image that you want to show in the above selected Prompt Style. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
        'multiOptions' => $logo_options,
        'escape' => false,
        'value' => $settings->getSetting('sesbrowserpush.logo', ''),
    ));
    $this->sesbrowserpush_logo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


    $this->addElement('Select', "sesbrowserpush_percontainer", array(
        'label' => 'Display Tour Image & Text',
        'description' => 'Do you want to display the tour image & help text to your website visitors? This tour will help them easily locate the native prompt and will also increase the visibility of it thereby increase more visitors for your website.',
        'multiOptions'=>array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'onchange' => 'showperHide(this.value);',
        'value' => $settings->getSetting('sesbrowserpush.percontainer',1),
    ));

    $web_title = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.site.title', 'My Community');
    $des = 'Always receive notifications to stay updated on new posts & activities on your content and account on '.$web_title.'.';

    $this->addElement('Text', "sesbrowserpush_textpercontai", array(
        'label' => 'Tour Help Text',
        'description' => 'Enter the text for the tour help. You can use this text to let your users know the benefits of subscription in brief.',
        'value' => $settings->getSetting('sesbrowserpush.textpercontai', $des),
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
          'label' => 'Activate Your Plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}
