<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprayer_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesprayer_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesprayer.licensekey'),
    ));
    $this->getElement('sesprayer_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sesprayer.pluginactivated')) {

      $this->addElement('Text', 'sesprayer_prayer_singular', array(
        'label' => 'Singular Text for "Prayer"',
        'description' => 'Enter the text which you want to show in place of "Prayer" at various places in this plugin like activity feeds, etc.',
        'value' => $settings->getSetting('sesprayer.prayer.singular', 'prayer'),
      ));

      $this->addElement('Text', 'sesprayer_prayer_plural', array(
        'label' => 'Plural Text for "Prayers"',
        'description' => 'Enter the text which you want to show in place of "Prayers" at various places in this plugin like search form, navigation menu, etc.',
        'value' => $settings->getSetting('sesprayer.prayer.plural', 'prayers'),
      ));

      $this->addElement('Text', 'sesprayer_prayer_manifest', array(
        'label' => 'Singular "prayer" text in URL',
        'description' => 'Enter the text which you want to show in place of "prayer" in the URLs of this plugin.',
        'value' => $settings->getSetting('sesprayer.prayer.manifest', 'prayer'),
      ));

      $this->addElement('Text', 'sesprayer_prayers_manifest', array(
        'label' => 'Plural "prayers" text in URL',
        'description' => 'Enter the text which you want to show in place of "prayers" in the URLs of this plugin.',
        'value' => $settings->getSetting('sesprayer.prayers.manifest', 'prayers'),
      ));

      $this->addElement('Text', 'sesprayer_descriptionlimit', array(
        'label' => 'Prayer Content Character Limit',
        'description' => 'Enter the prayer content character limit for prayers created on your website. Use 0 for unlimited. (This limit will apply while creating and editing new prayers.)',
        'value' => $settings->getSetting('sesprayer.descriptionlimit', 0),
      ));

      $this->addElement('Radio', 'sesprayer_show', array(
        'label' => 'Show Prayers',
        'description' => 'How do you want to show prayer entries when someone clicks the title of the entry from Browse pages, widgets, feeds or other places your website?',
        'multiOptions' => array(
          1 => 'In Popups',
          0 => 'On View Page'
        ),
        'value' => $settings->getSetting('sesprayer.show', 0),
      ));

      $this->addElement('Radio', 'sesprayer_allowshare', array(
        'label' => 'Allow Sharing',
        'description' => 'Do you want to allow members to share prayers posted on your site?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => $settings->getSetting('sesprayer.allowshare', 1),
      ));

      $this->addElement('Radio', 'sesprayer_allowreport', array(
        'label' => 'Allow Reporting',
        'description' => 'Do you want to allow members to Report against prayers posted on your site?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => $settings->getSetting('sesprayer.allowreport', 1),
      ));

      $this->addElement('Radio', 'sesprayer_enablecategory', array(
        'label' => 'Enable Category',
        'description' => 'Do you want to enable categories for the prayers posted on your site?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'onclick' => 'showCat(this.value)',
        'value' => $settings->getSetting('sesprayer.enablecategory', 1),
      ));

      $this->addElement('Radio', 'sesprayer_categoryrequried', array(
        'label' => 'Make Prayer Categories Mandatory',
        'description' => 'Do you want to make category field mandatory when users create or edit their prayers?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => $settings->getSetting('sesprayer.categoryrequried', 0),
      ));

      //default photos
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

      //no prayer default photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Sesprayer/externals/images/prayer-icon.png'=>''),$default_photos_main);
        $this->addElement('Select', 'sesprayer_prayer_no_photo', array(
            'label' => 'Default Photo for No Prayer Tip',
            'description' => 'Choose a default photo for No prayers tip on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change this default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('sesprayer.prayer.no.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo for no photo. Photo to be chosen for no photo should be first uploaded from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. => There are currently no photo in the File & Media Manager for the main photo. Please upload the Photo to be chosen for no photo from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manage</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'sesprayer_prayer_no_photo', array(
            'label' => 'Prayer Default No Prayer Photo',
            'description' => $description,
        ));
      }
      $this->sesprayer_prayer_no_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


      $this->addElement('Textarea', 'sesprayer_iframely_disallow', array(
        'label' => 'Disallow these Sources',
        'description' => 'Enter the domains of the sites (separated by commas) that you do not want to allow for Video'
          . ' Source. Example: example1.com, example2.com. Note: We\'ve integrated Iframely API with this module. By '
          . 'default URLs that return a \'player\' are allowed, such as music based websites like Soundcloud. You can '
          . 'use this setting to control which sites should not be allowed in this section.',
        'filters' => array(
          'StringTrim',
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.iframely.disallow', ''),
      ));
      $this->sesprayer_iframely_disallow->getDecorator('Description')->setOption('escape', false);


      $this->addElement('Radio', 'sesprayer_allowsendprayer', array(
        'label' => 'Allow to Send Prayers?',
        'description' => 'Do you want to allow members to send prayers to another members on your website? If you choose Yes, then members can choose to send prayers to their Friends, Lists or Networks.',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => $settings->getSetting('sesprayer.allowsendprayer', 0),
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
