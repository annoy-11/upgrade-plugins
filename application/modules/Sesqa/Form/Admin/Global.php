<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Form_Admin_Global extends Engine_Form {

  public function init() {

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesqa_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesqa.licensekey'),
    ));
    $this->getElement('sesqa_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesqa.pluginactivated')) {

        $this->addElement('Text', 'qanda_singular_text', array(
            'label' => 'Singular Text for "Question"',
            'description' => 'Enter the text which you want to show in place of "Question" at various places in this plugin like activity feeds, etc.',

            'value' => $settings->getSetting('qanda.singular.text', 'question'),
        ));

        $this->addElement('Text', 'qanda_plural_text', array(
            'label' => 'Plural Text for "Questions"',
            'description' => 'Enter the text which you want to show in place of "Questions" at various places in this plugin like search form, navigation menu, etc.',

            'value' => $settings->getSetting('qanda.plural.text', 'questions'),
        ));


        $this->addElement('Text', 'qanda_qanda_manifest', array(
            'label' => 'Singular "Question" text in URL',
            'description' => 'Enter the text which you want to show in place of "Question" in the URLs of this plugin.',

            'value' => $settings->getSetting('qanda.qanda.manifest', 'question'),
        ));

        $this->addElement('Text', 'qanda_qandas_manifest', array(
            'label' => 'Plural "Questions" text in URL',
            'description' => 'Enter the text which you want to show in place of "Questions" in the URLs of this plugin.',

            'value' => $settings->getSetting('qanda.qandas.manifest', 'questions'),
        ));



        $this->addElement('Radio', 'qanda_allow_sharing', array(
            'description' => 'Do you want to allow members to share Questions posted on your site?',
            'label' => 'Allow Sharing',
            'multiOptions'=>array('1'=>'Yes','0'=>'No'),
            'value' => $settings->getSetting('qanda.allow.sharing', '1'),
        ));

        $this->addElement('Radio', 'qanda_allow_reporting', array(
            'description' => 'Do you want to allow members to Report against Questions posted on your site?',
            'label' => 'Allow Reporting',
            'multiOptions'=>array('1'=>'Yes','0'=>'No'),
            'value' => $settings->getSetting('qanda.allow.reporting', '1'),
        ));

        $default_photos_main = array();
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
        $default_photos_main['public/admin/' . $base_name] = $base_name;
        }
            $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $fileLink = $view->baseUrl() . '/admin/files/';

        if (count($default_photos_main) > 0) {
                $default_photos = array_merge(array('application/modules/Sesqa/externals/images/notip.png'=>''),$default_photos_main);
        $this->addElement('Select', 'qanda_notip_image', array(
            'label' => 'Default Photo for No Quote Tip',
            'description' => 'Choose a default photo for No quotes tip on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change this default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('qanda_notip_image'),
        ));
        } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo for  default on your website. Photo to be chosen for default on your website should be first uploaded from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. => There are currently no photo in the File & Media Manager for the  default on your website. Please upload the Photo to be chosen for default on your website from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'qanda_notip_image', array(
            'label' => 'Default Photo for No Quote Tip',
            'description' => $description,
        ));
        }
        $this->qanda_notip_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


        if (count($default_photos_main) > 0) {
                $default_photos = array_merge(array('application/modules/Sesqa/externals/images/default.png'=>''),$default_photos_main);
        $this->addElement('Select', 'qanda_default_image', array(
            'label' => 'Default Photo for Question',
            'description' => 'Choose a default photo for Question on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change this default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('qanda_default_image'),
        ));
        } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo for  default on your website. Photo to be chosen for default on your website should be first uploaded from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. => There are currently no photo in the File & Media Manager for the  default on your website. Please upload the Photo to be chosen for default on your website from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'qanda_default_image', array(
            'label' => 'Default Photo for Question',
            'description' => $description,
        ));
        }
        $this->qanda_default_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


        $this->addElement('Textarea', 'qanda_disallow_domain', array(
            'description' => 'Enter the domains of the sites (separated by commas) that you do not want to allow for Video Source. Example: example1.com, example2.com. Note: We\'ve integrated Iframely API with this module. By default URLs that return a \'player\' are allowed, such as music based websites like Soundcloud. You can use this setting to control which sites should not be allowed in this section.',
            'label' => 'Disallow these Sources',
            'value' => $settings->getSetting('qanda.disallow.domain', ''),
        ));

        $this->addElement('Radio', 'sesqa_canchangevote', array(
            'label' => 'Can user change vote?',
            'description' => '',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => $settings->getSetting('sesqa.canchangevote', 1),
        ));


        $this->addElement('Radio', 'sesqa_enable_location', array(
            'label' => 'Enable Location in Questions',
            'description' => 'Choose from below where do you want to enable location in Questions.',
            'multiOptions' => array(
                '1' => 'Yes,Enable Location',
                '0' => 'No,Don\'t Enable Location',
            ),
            'value' => $settings->getSetting('sesqa.enable.location', 1),
        ));
        $this->addElement('Radio', 'sesqa_location_mandatory', array(
            'label' => 'Location Mandatory',
            'description' => 'Do you want to make location field mandatory.',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => $settings->getSetting('sesqa_location_mandatory', 1),
        ));
        $this->addElement('Select', 'sesqa_search_type', array(
            'label' => 'Proximity Search Unit',
            'description' => 'Choose the unit for proximity search of location of questions on your website.',
            'multiOptions' => array(
                1 => 'Miles',
                0 => 'Kilometres'
            ),
            'value' => $settings->getSetting('sesqa_search_type', 1),
        ));

        $this->addElement('Select', 'sesqa_enable_newLabel', array(
            'label' => 'New Label',
            'description' => 'Do you want to enable New Label in questions?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sesqa_enable_newLabel', 1),
        ));
        $this->addElement('Text', 'sesqa_new_label', array(
            'label' => 'Days for New Label',
            'description' => 'Enter below the number of days till which New label will be assigned to the questions on your website.',
            'value' => $settings->getSetting('sesqa_new_label', '5'),
        ));
        $this->addElement('Radio', "sesqa_allow_favourite", array(
            'label' => 'Allow to Favorite Questions',
            'description' => "Do you want to allow members to add Questions on your website to Favorites?",
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => $settings->getSetting('sesqa.allow.favourite', 1),
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
