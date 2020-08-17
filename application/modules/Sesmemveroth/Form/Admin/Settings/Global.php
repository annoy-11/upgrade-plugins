<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmemveroth_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesmemveroth_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesmemveroth.licensekey'),
    ));
    $this->getElement('sesmemveroth_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesmemveroth.pluginactivated')) {

      $des = sprintf('Do you want to allow members on your website to verify other members on your website?');


      $this->addElement('Radio', 'sesmemveroth_enableverification', array(
        'label' => 'Allow Members to Verify Other Members',
        'description' => $des,
        'multiOptions' => array(
          '2' => 'Yes, allow all members to verify other members. (You can configure the settings from Member Level Settings of this plugin).',
          '1' => 'Yes, allow only Verified members to verify other members. (Only verified members will be able to verify other members on your website. Configure other settings from Member Level Settings of this plugin.)',
          '0' => 'No, do not allow members to verify other members.',
        ),
        'escape' => false,
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmemveroth.enableverification', 2),
      ));
      $this->getElement('sesmemveroth_enableverification')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $files[] = '';
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
        $files['public/admin/' . $base_name] = $base_name;
      }

      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $fileLink = $view->baseUrl() . '/admin/files/';

      $this->addElement('Select', 'sesmemveroth_verifybadge', array(
        'label' => 'Upload Verify Badge Image',
        'description' => 'Choose a photo for the verify badge which will display in “Verified Member Badge & Verify Member Button” widget on your website. [Note: You can add a new photo from the "<a href="' . $fileLink . '" target="_blank">File & Media Manager</a>" section. Leave the field blank if you do not want to change this default photo.]',
        'multiOptions' => $files,
        'escape' => false,
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmemveroth.verifybadge', ''),
      ));
      $this->sesmemveroth_verifybadge->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


      $this->addElement('Radio', 'sesmemveroth_enablecomment', array(
        'label' => 'Enable Members to Add Comments',
        'description' => 'Do you want to enable members on your website to add comments while verifying other members?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'onchange' => 'enablecomment(this.value)',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmemveroth.enablecomment', 1),
      ));

      $this->addElement('Radio', 'sesmemveroth_displaycomment', array(
        'label' => 'Display Comments For Verified Members',
        'description' => 'Do you want to display comments for members which are entered while verifying members on your website? If you choose Yes, then the comments will be displayed with each member who have verified the member - whose verification details are being viewed.',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmemveroth.displaycomment', 1),
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
