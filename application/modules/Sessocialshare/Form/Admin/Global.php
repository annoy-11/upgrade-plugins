<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialshare_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sessocialshare_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sessocialshare.licensekey'),
    ));
    $this->getElement('sessocialshare_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sessocialshare.pluginactivated')) {

      $this->addElement('Text', 'sessocialshare_popsharetitle', array(
        'label' => 'Heading in More Popup',
        'description' => 'Enter the heading for the More popup which comes on clicking the more icon in all the widgets of this plugin.',
        'value' => $settings->getSetting('sessocialshare.popsharetitle', 'Share your Content'),
      ));


      $this->addElement('Select', "sessocialshare_captcha", array(
          'label' => 'Enable Captcha in Email',
          'description' => 'Do you want to enable captcha in the Email form when non-logged in users try to share a page via email?',
          'allowEmpty' => false,
          'required' => true,
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => "No",
          ),
          'value' => $settings->getSetting('sessocialshare.captcha', 1),
      ));

    $supportTicket = '<a href="admin/user/settings/facebook" target="_blank">here</a>';

		$sesSite = '<a href="http://support.socialengine.com/php/customer/portal/articles/1796979?b_id=4311" target="_blank">http://support.socialengine.com/php/customer/portal/articles/1796979?b_id=4311</a>';

		$descriptionLicense = sprintf('Enter the Facebook Client ID for enabling sharing from your website to the Facebook Messenger. (You can enter the key which you have created for FB integration from %s or create one using the tutorial here: %s . Make sure the app has publish to Facebook permission.)',$supportTicket,$sesSite);

      $this->addElement('Text', 'core_facebook_appid', array(
          'label' => 'Facebook Client ID for Messenger',
          'description' => $descriptionLicense,
          'value' => $settings->getSetting('core.facebook.appid', ''),
      ));
      $this->getElement('core_facebook_appid')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $this->addElement('Text', "sessocialshare_more_title", array(
        'label' => 'Mouseover Text on More Icon',
        'description' => "Enter the text which will come when users mouseover on the More Icon in all the widgets of this plugin.",
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.more.title', 'More'),
      ));

      $this->addElement('Select', "sessocialshare_enableseshare", array(
        'label' => 'Enable Outside Sharing in SE share',
        'description' => 'Do you want to enable your users to share various content, activity feeds from your website to be shared on outside social network services? If Yes, then users will see the option to share content, activity feeds on other social networking services.',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => "No",
        ),
        'value' => $settings->getSetting('sessocialshare.enableseshare', 1),
      ));

      if(Engine_Api::_()->sesbasic()->isModuleEnable(array('sesmetatag'))) {
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
        $this->addElement('Select', 'sessocialshare_nonmeta_photo', array(
          'label' => 'OG & Twitter Card Meta Image for Non Widgetized Pages',
          'description' => 'Choose from below the Facebook Open Graph and Twitter Card Meta Image for the non widgetized pages of your website. This image will show up when a non widgetized page from website is shared on Facebook or Twitter. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show image.]',
          'multiOptions' => $banner_options,
          'escape' => false,
          'value' => $settings->getSetting('sessocialshare.nonmeta.photo', ''),
        ));
        $this->sessocialshare_nonmeta_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      }

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
