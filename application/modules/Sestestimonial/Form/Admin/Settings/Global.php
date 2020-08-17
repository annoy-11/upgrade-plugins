<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestestimonial_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
        ->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sestestimonial_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sestestimonial.licensekey'),
    ));
    $this->getElement('sestestimonial_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sestestimonial.pluginactivated')) {

        $this->addElement('Text', 'sestestimonial_text_singular', array(
            'label' => 'Singular Text for "Testimonial"',
            'description' => 'Enter the text which you want to show in place of "Testimonial" at various places in this plugin like activity feeds, etc.',
            'value' => $settings->getSetting('sestestimonial.text.singular', 'testimonial'),
        ));

        $this->addElement('Text', 'sestestimonial_text_plural', array(
            'label' => 'Plural Text for "Testimonial"',
            'description' => 'Enter the text which you want to show in place of "Testimonials" at various places in this plugin like search form, navigation menu, etc.',
            'value' => $settings->getSetting('sestestimonial.text.plural', 'testimonials'),
        ));

        $this->addElement('Text', 'sestestimonial_testimonial_manifest', array(
            'label' => 'Singular "testimonial" Text in URL',
            'description' => 'Enter the text which you want to show in place of "testimonial" in the URLs of this plugin.',
            'value' => $settings->getSetting('sestestimonial.testimonial.manifest', 'testimonial'),
        ));

        $this->addElement('Text', 'sestestimonial_testimonials_manifest', array(
            'label' => 'Plural "testimonials" Text in URL',
            'description' => 'Enter the text which you want to show in place of "testimonials" in the URLs of this plugin.',
            'value' => $settings->getSetting('sestestimonial.testimonials.manifest', 'testimonials'),
        ));

        $this->addElement('Radio', 'sestestimonial_titleviewpage', array(
            'label' => 'Enable Title',
            'description' => 'Do you want enable title for testimonial?(If you enable this setting, then your users will redirect to the View Page of Testimonial after clicking on the Title)',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'onchange' => 'hideshowtitle(this.value);',
            'value' => $settings->getSetting('sestestimonial.titleviewpage', 1),
        ));

        $this->addElement('Radio', 'sestestimonial_longdes', array(
            'label' => 'Long Description',
            'description' => 'Do you want to show long description?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sestestimonial.longdes', 1),
        ));

        $this->addElement('Radio', 'sestestimonial_designation', array(
            'label' => 'Enable Designation',
            'description' => 'Do you want designation in this plugin?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sestestimonial.designation', 1),
        ));

        $this->addElement('Radio', 'sestestimonial_rating', array(
            'label' => 'Enable Rating',
            'description' => 'Do you want rating in this plugin?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sestestimonial.rating', 1),
        ));

        $this->addElement('Radio', 'sestestimonial_helpful', array(
            'label' => 'Enable Helpful',
            'description' => 'Do you want helpful in this plugin?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sestestimonial.helpful', 1),
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
