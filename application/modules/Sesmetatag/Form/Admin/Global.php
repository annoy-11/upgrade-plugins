<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmetatag
 * @package    Sesmetatag
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2017-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmetatag_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesmetatag_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesmetatag.licensekey'),
    ));
    $this->getElement('sesmetatag_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesmetatag.pluginactivated')) {


      $this->addElement('Select', "sesmetatag_enable_facebookogtitle", array(
          'label' => 'Enable Facebook OG Meta Tags',
          'description' => 'Do you want to enable Facebook Open Graph Meta tags on your website? (If you choose Yes, then the "og" meta tags information will show up when pages from your website are shared on Facebook.)',
          'allowEmpty' => false,
          'required' => true,
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => "No",
          ),
          'value' => $settings->getSetting('sesmetatag.enable.facebookogtitle', 1),
      ));

      $link = '<a href="https://dev.twitter.com/cards/types/summary-large-image" target="_blank">Summary Card with Large Image</a>';

      $description = sprintf('Do you want to enable Twitter Card (%s) meta tags on your website? (If you choose Yes, then the “twitter” meta tags information will show up when pages from your website are shared on Twitter.)',$link);

      $this->addElement('Select', "sesmetatag_enable_twittercard", array(
          'label' => 'Enable Twitter Cards Meta Tags',
          'description' => $description,
          'allowEmpty' => false,
          'required' => true,
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => "No",
          ),
          'value' => $settings->getSetting('sesmetatag.enable.twittercard', 1),
      ));
      $this->getElement('sesmetatag_enable_twittercard')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $this->addElement('Text', "sesmetatag_nonmeta_title", array(
        'label' => 'OG & Twitter Card Meta Title for Non Widgetized Pages',
        'description' => "Enter Facebook Open Graph and Twitter Card meta Title for the non widgetized pages of your website. This title will show up when a non widgetized page from website is shared on Facebook or Twitter.",
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesmetatag.nonmeta.title', Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.title')),
      ));

      $this->addElement('Textarea', "sesmetatag_nonmeta_description", array(
        'label' => 'OG & Twitter Card Meta Description for Non Widgetized Pages',
        'description' => "Enter Facebook Open Graph and Twitter Card meta Description for the non widgetized pages of your website. This description will show up when a non widgetized page from website is shared on Facebook or Twitter.",
        'maxlength' => '300',
        'allowEmpty' => false,
        'required' => true,
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
            new Engine_Filter_StringLength(array('max' => '300')),
            new Engine_Filter_EnableLinks(),
        ),
        'value' => $settings->getSetting('sesmetatag.nonmeta.description', Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.description')),
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
      $this->addElement('Select', 'sesmetatag_nonmeta_photo', array(
          'label' => 'Meta Image for Outside Sharing',
          'description' => 'Choose from below the Meta Image which will be used when content shared from your website to other social networking services does not have any image. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show image.]',
          'multiOptions' => $banner_options,
          'allowEmpty' => false,
          'required' => true,
          'escape' => false,
          'value' => $settings->getSetting('sesmetatag.nonmeta.photo', 'public/admin/social_share.jpg'),
      ));
      $this->sesmetatag_nonmeta_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

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
