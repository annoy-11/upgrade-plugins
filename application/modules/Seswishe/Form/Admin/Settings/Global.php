<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seswishe_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "seswishe_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('seswishe.licensekey'),
    ));
    $this->getElement('seswishe_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
  
		if ($settings->getSetting('seswishe.pluginactivated')) {

      $this->addElement('Text', 'seswishe_wishe_singular', array(
        'label' => 'Singular Text for "Wishe"',
        'description' => 'Enter the text which you want to show in place of "Wishe" at various places in this plugin like activity feeds, etc.',
        'value' => $settings->getSetting('seswishe.wishe.singular', 'wishe'),
      ));

      $this->addElement('Text', 'seswishe_wishe_plural', array(
        'label' => 'Plural Text for "Wishes"',
        'description' => 'Enter the text which you want to show in place of "Wishes" at various places in this plugin like search form, navigation menu, etc.',
        'value' => $settings->getSetting('seswishe.wishe.plural', 'wishes'),
      ));

      $this->addElement('Text', 'seswishe_wishe_manifest', array(
        'label' => 'Singular "wishe" text in URL',
        'description' => 'Enter the text which you want to show in place of "wishe" in the URLs of this plugin.',
        'value' => $settings->getSetting('seswishe.wishe.manifest', 'wishe'),
      ));

      $this->addElement('Text', 'seswishe_wishes_manifest', array(
        'label' => 'Plural "wishes" text in URL',
        'description' => 'Enter the text which you want to show in place of "wishes" in the URLs of this plugin.',
        'value' => $settings->getSetting('seswishe.wishes.manifest', 'wishes'),
      ));

      $this->addElement('Text', 'seswishe_descriptionlimit', array(
        'label' => 'Wishe Content Character Limit',
        'description' => 'Enter the wishe content character limit for wishes created on your website. Use 0 for unlimited. (This limit will apply while creating and editing new wishes.)',
        'value' => $settings->getSetting('seswishe.descriptionlimit', 0),
      ));

      $this->addElement('Radio', 'seswishe_show', array(
        'label' => 'Show Wishes',
        'description' => 'How do you want to show wishe entries when someone clicks the title of the entry from Browse pages, widgets, feeds or other places your website?',
        'multiOptions' => array(
          1 => 'In Popups',
          0 => 'On View Page'
        ),
        'value' => $settings->getSetting('seswishe.show', 0),
      ));

      $this->addElement('Radio', 'seswishe_allowshare', array(
        'label' => 'Allow Sharing',
        'description' => 'Do you want to allow members to share wishes posted on your site?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => $settings->getSetting('seswishe.allowshare', 1),
      ));

      $this->addElement('Radio', 'seswishe_allowreport', array(
        'label' => 'Allow Reporting',
        'description' => 'Do you want to allow members to Report against wishes posted on your site?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => $settings->getSetting('seswishe.allowreport', 1),
      ));

      $this->addElement('Radio', 'seswishe_enablecategory', array(
        'label' => 'Enable Category',
        'description' => 'Do you want to enable categories for the wishes posted on your site?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'onclick' => 'showCat(this.value)',
        'value' => $settings->getSetting('seswishe.enablecategory', 1),
      ));

      $this->addElement('Radio', 'seswishe_categoryrequried', array(
        'label' => 'Make Wishe Categories Mandatory',
        'description' => 'Do you want to make category field mandatory when users create or edit their wishes?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => $settings->getSetting('seswishe.categoryrequried', 0),
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

      //no wishe default photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Seswishe/externals/images/wishe-icon.png'=>''),$default_photos_main);
        $this->addElement('Select', 'seswishe_wishe_no_photo', array(
            'label' => 'Default Photo for No Wishe Tip',
            'description' => 'Choose a default photo for No wishes tip on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change this default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('seswishe.wishe.no.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo for no photo. Photo to be chosen for no photo should be first uploaded from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. => There are currently no photo in the File & Media Manager for the main photo. Please upload the Photo to be chosen for no photo from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manage</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'seswishe_wishe_no_photo', array(
            'label' => 'Wishe Default No Wishe Photo',
            'description' => $description,
        ));
      }
      $this->seswishe_wishe_no_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


      $this->addElement('Textarea', 'seswishe_iframely_disallow', array(
        'label' => 'Disallow these Sources',
        'description' => 'Enter the domains of the sites (separated by commas) that you do not want to allow for Video'
          . ' Source. Example: example1.com, example2.com. Note: We\'ve integrated Iframely API with this module. By '
          . 'default URLs that return a \'player\' are allowed, such as music based websites like Soundcloud. You can '
          . 'use this setting to control which sites should not be allowed in this section.',
        'filters' => array(
          'StringTrim',
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe.iframely.disallow', ''),
      ));
      $this->seswishe_iframely_disallow->getDecorator('Description')->setOption('escape', false);

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
