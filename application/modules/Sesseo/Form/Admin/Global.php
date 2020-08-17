<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesseo_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesseo_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesseo.licensekey'),
    ));
    $this->getElement('sesseo_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesseo.pluginactivated')) {

      $this->addElement('Radio', "sesseo_enable_hreflang", array(
        'label' => 'Enable hreflang',
        'description' => "Do you want to show hreflang url on your website?",
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => "No",
        ),
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesseo.enable.hreflang', 1),
      ));

      $this->addElement('Radio', "sesseo_enable_canonical", array(
        'label' => 'Enable Canonical Tags',
        'description' => "Do you want to enable canonical tags for your website?",
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => "No",
        ),
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesseo.enable.canonical', 1),
      ));

      $this->addElement('Radio', "sesseo_enable_opensearchdes", array(
        'label' => 'Open Search Description',
        'description' => "Do you want to enable open search description for your website?",
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => "No",
        ),
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesseo.enable.opensearchdes', 1),
      ));

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
      $fileLink = $view->baseUrl() . '/admin/files/';
      $this->addElement('Select', 'sesseo_nonmeta_photo', array(
          'label' => 'Meta Image',
          'description' => 'Choose from below the Meta Image which will be used when content shared from your website to other social networking services does not have any image. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show image.]',
          'multiOptions' => $banner_options,
          'allowEmpty' => false,
          'required' => true,
          'escape' => false,
          'value' => $settings->getSetting('sesseo.nonmeta.photo', 'public/admin/social_share.jpg'),
      ));
      $this->sesseo_nonmeta_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

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
