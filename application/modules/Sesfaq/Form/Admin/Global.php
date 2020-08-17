<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesfaq_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesfaq_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesfaq.licensekey'),
    ));
    $this->getElement('sesfaq_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesfaq.pluginactivated')) {

      $this->addElement('Text', 'sesfaq_text_singular', array(
        'label' => 'Singular Text for "FAQ"',
        'description' => 'Enter the text which you want to show in place of "FAQ" at various places in this plugin like activity feeds, etc.',
        'value' => $settings->getSetting('sesfaq.text.singular', 'faq'),
      ));

      $this->addElement('Text', 'sesfaq_text_plural', array(
        'label' => 'Plural Text for "FAQs"',
        'description' => 'Enter the text which you want to show in place of "FAQs" at various places in this plugin like search form, navigation menu, etc.',
        'value' => $settings->getSetting('sesfaq.text.plural', 'faqs'),
      ));

      $this->addElement('Text', 'sesfaq_faqs_manifest', array(
          'label' => 'Plural "faqs" Text in URL',
          'description' => 'Enter the text which you want to show in place of "faqs" in the URLs of this plugin.',
          'value' => $settings->getSetting('sesfaq.faqs.manifest', 'faqs'),
      ));

      $this->addElement('Text', 'sesfaq_faq_manifest', array(
          'label' => 'Singular "faq" Text in URL',
          'description' => 'Enter the text which you want to show in place of "faq" in the URLs of this plugin.',
          'value' => $settings->getSetting('sesfaq.faq.manifest', 'faq'),
      ));

      $this->addElement('Radio', 'sesfaq_menuredirection', array(
          'label' => '"FAQs" Main Menu Redirection',
          'description' => 'Choose from below where do you want to redirect users when FAQs Menu item is clicked in the Main Navigation Menu Bar.',
          'multiOptions' => array(
              3 => 'FAQs Home Page',
              2 => 'FAQs Browse Page',
          ),
          'value' => $settings->getSetting('sesfaq.menuredirection', 3),
      ));

      $this->addElement('Radio', 'sesfaq_link', array(
          'label' => 'Display FAQs Menu Item',
          'description' => 'Choose from below where do you want to display this FAQs menu item link on your website? [If you want to show this link somewhere else instead of Main, Mini or Footer menus, then choose "None of the above." option.]',
          'multiOptions' => array(
              3 => 'In Main Navigation Menu Bar.',
              2 => 'In Mini Navigation Menu Bar.',
              1 => 'In Footer Menu Bar.',
              0 => 'None of the above.',
          ),
          'value' => $settings->getSetting('sesfaq.link', 3),
      ));

      $this->addElement('Radio', 'sesfaq_allowreport', array(
        'label' => 'Allow to Report FAQs',
        'description' => 'Do you want to allow users to report FAQs on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sesfaq.allowreport', 1),
      ));

      $this->addElement('Radio', 'sesfaq_allowshare', array(
        'label' => 'Allow to Share FAQs',
        'description' => 'Do you want to allow users to share FAQs on your website?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No',
        ),
        'value' => $settings->getSetting('sesfaq.allowshare', 1),
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
