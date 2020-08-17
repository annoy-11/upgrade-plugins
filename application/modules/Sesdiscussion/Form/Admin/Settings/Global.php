<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesdiscussion_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesdiscussion.licensekey'),
    ));
    $this->getElement('sesdiscussion_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.pluginactivated')) {

      $this->addElement('Text', 'sesdiscussion_discussion_singular', array(
        'label' => 'Singular Text for "Discussion"',
        'description' => 'Enter the text which you want to show in place of "Discussion" at various places in this plugin like activity feeds, etc.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.discussion.singular', 'discussion'),
      ));

      $this->addElement('Text', 'sesdiscussion_discussion_plural', array(
        'label' => 'Plural Text for "Discussions"',
        'description' => 'Enter the text which you want to show in place of "Discussions" at various places in this plugin like search form, navigation menu, etc.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.discussion.plural', 'discussions'),
      ));

      $this->addElement('Text', 'sesdiscussion_discussion_manifest', array(
        'label' => 'Singular "discussion" text in URL',
        'description' => 'Enter the text which you want to show in place of "discussion" in the URLs of this plugin.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.discussion.manifest', 'discussion'),
      ));

      $this->addElement('Text', 'sesdiscussion_discussions_manifest', array(
        'label' => 'Plural "discussions" text in URL',
        'description' => 'Enter the text which you want to show in place of "discussions" in the URLs of this plugin.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.discussions.manifest', 'discussions'),
      ));

      $this->addElement('MultiCheckbox', 'sesdiscussion_options', array(
        'label' => 'Type of Discussions',
        'description' => 'Choose the type of discussions to be enabled when users post or edit discussions on your website.',
        'multiOptions' => array('topic' => 'Topic', 'photo' => 'Photo', 'video' => 'Video', 'link' => 'Link'),
        'value' => unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.options', 'a:4:{i:0;s:5:"topic";i:1;s:5:"photo";i:2;s:5:"video";i:3;s:4:"link";}')),
      ));

      $this->addElement('Radio', 'sesdiscussion_createform', array(
        'label' => 'Quick Create Pop Up from Main Navigation Menu',
        'description' => "Do you want to open the 'Create New Discussion' Form in popup or in a Page, when users click on the 'Create New Discussion' Link available in the Main Navigation Menu of this plugin?",
        'multiOptions' => array(
          1 => "Yes, open Create Discussion Form in 'popup'",
          0 => "No, open Create Discussion Form in 'page'"
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.createform', 1),
      ));

      $this->addElement('Radio', 'sesdiscussion_editortype', array(
        'label' => 'Editor Type for Discussion Content',
        'description' => "Choose the Editor type for entering the content of discussions on your website.",
        'multiOptions' => array(
          1 => "Rich WYSIWYG Editor",
          0 => "Plain Editor (Text Area)"
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.editortype', 0),
      ));

      $this->addElement('Text', 'sesdiscussion_descriptionlimit', array(
        'label' => 'Discussion Content Character Limit',
        'description' => 'Enter the discussion content character limit for discussions created on your website. Use 0 for unlimited. (This limit will apply while creating and editing new discussions.)',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.descriptionlimit', 0),
      ));

      $this->addElement('Radio', 'sesdiscussion_show', array(
        'label' => 'Show Discussions',
        'description' => 'How do you want to show discussion entries when someone clicks the title of the entry from Browse pages, widgets, feeds or other places your website?',
        'multiOptions' => array(
          1 => 'In Popups',
          0 => 'On View Page'
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.show', 0),
      ));

      $this->addElement('Radio', 'sesdiscussion_allowshare', array(
        'label' => 'Allow Sharing',
        'description' => 'Do you want to allow members to share discussions posted on your site?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowshare', 1),
      ));

      $this->addElement('Radio', 'sesdiscussion_allowreport', array(
        'label' => 'Allow Reporting',
        'description' => 'Do you want to allow members to Report against discussions posted on your site?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowreport', 1),
      ));

      $this->addElement('Radio', 'sesdiscussion_enablecategory', array(
        'label' => 'Enable Category',
        'description' => 'Do you want to enable categories for the discussions posted on your site?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'onclick' => 'showCat(this.value)',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enablecategory', 1),
      ));

      $this->addElement('Radio', 'sesdiscussion_categoryrequried', array(
        'label' => 'Make Discussion Categories Mandatory',
        'description' => 'Do you want to make category field mandatory when users create or edit their discussions?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.categoryrequried', 0),
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

      //no discussion default photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Sesdiscussion/externals/images/discussion-icon.png'=>''),$default_photos_main);
        $this->addElement('Select', 'sesdiscussion_discussion_no_photo', array(
            'label' => 'Default Photo for No Discussion Tip',
            'description' => 'Choose a default photo for No discussions tip on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change this default photo.]',
            'multiOptions' => $default_photos,
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.discussion.no.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo for no photo. Photo to be chosen for no photo should be first uploaded from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. => There are currently no photo in the File & Media Manager for the main photo. Please upload the Photo to be chosen for no photo from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manage</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'sesdiscussion_discussion_no_photo', array(
            'label' => 'Discussion Default No Discussion Photo',
            'description' => $description,
        ));
      }
      $this->sesdiscussion_discussion_no_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


      $this->addElement('Textarea', 'sesdiscussion_iframely_disallow', array(
        'label' => 'Disallow these Sources',
        'description' => 'Enter the domains of the sites (separated by commas) that you do not want to allow for Video'
          . ' Source. Example: example1.com, example2.com. Note: We\'ve integrated Iframely API with this module. By '
          . 'default URLs that return a \'player\' are allowed, such as music based websites like Soundcloud. You can '
          . 'use this setting to control which sites should not be allowed in this section.',
        'filters' => array(
          'StringTrim',
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.iframely.disallow', ''),
      ));
      $this->sesdiscussion_iframely_disallow->getDecorator('Description')->setOption('escape', false);

      $this->addElement('Radio', 'sesdiscussion_allowvoting', array(
        'label' => 'Enable Voting',
        'description' => 'Do you want to enable voting on topics posted using this plugin on your website?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowvoting', 1),
      ));

      $this->addElement('Radio', 'sesdiscussion_automaticallymarkasnew', array(
        'label' => 'Automatically Mark Discussions as New',
        'description' => 'Do you want discussions created on your website to be automatically marked as New?',
        'multiOptions' => array(
          1 => 'Yes, automatically mark discussions as New',
          0 => 'No, do not automatically mark discussions as New'
        ),
        'onchange' => 'showASNEW(this.value)',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.automaticallymarkasnew', 0),
      ));

      $this->addElement('Text', 'sesdiscussion_newdays', array(
        'label' => 'Duration for Discussions Marked as New',
        'description' => 'Enter the number of days upto which Discussions created by members of this level will be shown as New on your website. ["0" will not work for this setting.]',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.newdays', 2),
        'validators' => array(
          array('Int', true),
          array('Between', true, array(1, 999, true)),
          array('GreaterThan', true, array(0)),
        ),
      ));

      $this->addElement('Radio', 'sesdiscussion_enable_favourite', array(
        'label' => 'Allow to Favourite Discussions',
        'description' => 'Do you want to allow users to favourite discussions on your website?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enable.favourite', 1),
      ));

      $this->addElement('Select', 'sesdiscussion_follow_active', array(
          'label' => 'Enable Follow Functionality',
          'description' => 'Do you want to enable follow functionality on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.follow.active', 1),
      ));

      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
      $this->addElement('Hidden','is_license',array('value'=>1));
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
