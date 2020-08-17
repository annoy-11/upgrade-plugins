<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sespage_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sespage.licensekey'),
    ));
    $this->getElement('sespage_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.pluginactivated')) {
      if (!$settings->getSetting('sespage.changelanding', 0)) {
        $this->addElement('Radio', 'sespage_changelanding', array(
            'label' => 'Set Welcome Page as Landing Page',
            'description' => 'Do you want to set the Welcome Page of this plugin as Default Landing page of your website? [This is a one time setting, so if you choose ‘Yes’ and save changes, then later you can manually make changes in the Landing page from Layout Editor. Back up page of your current landing page will get created with the name “LP backup from SES Page Directories”.]',
            'onclick' => 'confirmChangeLandingPage(this.value)',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => $settings->getSetting('sespage.changelanding', 0),
        ));
      }
      $this->addElement('Radio', 'sespage_check_welcome', array(
          'label' => 'Welcome Page Visibility',
          'description' => 'Who all users do you want to see this "Welcome Page"?',
          'multiOptions' => array(
              0 => 'Only logged in users',
              1 => 'Only non-logged in users',
              2 => 'Both, logged-in and non-logged in users',
          ),
          'value' => $settings->getSetting('sespage.check.welcome', 2),
      ));
      $this->addElement('Radio', 'sespage_enable_welcome', array(
          'label' => 'Page Main Menu Redirection',
          'description' => 'Choose from below where do you want to redirect users when Page Menu item is clicked in the Main Navigation Menu Bar.',
          'multiOptions' => array(
              1 => 'Page Welcome Page',
              0 => 'Page Home Page',
              2 => 'Page Browse Page'
          ),
          'value' => $settings->getSetting('sespage.enable.welcome', 1),
      ));
      $this->addElement('Text', 'sespage_pages_manifest', array(
          'label' => 'Plural Text for "page-directories" in URL',
          'description' => 'Enter the text which you want to show in place of "page-directories" in the URLs of this plugin.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sespage.pages.manifest', 'page-directories'),
      ));
      $this->addElement('Text', 'sespage_page_manifest', array(
          'label' => 'Singular Text for "page-directory" in URL',
          'description' => 'Enter the text which you want to show in place of "page-directory" in the URLs of this plugin.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sespage.page.manifest', 'page-directory'),
      ));
      $this->addElement('Text', 'sespage_text_singular', array(
          'label' => 'Singular Text for "Page Directory"',
          'description' => 'Enter the text which you want to show in place of "Page" at various places in this plugin like activity feeds, etc.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sespage.text.singular', 'page'),
      ));
      $this->addElement('Text', 'sespage_text_plural', array(
          'label' => 'Plural Text for "Page Directories"',
          'description' => 'Enter the text which you want to show in place of "Pages" at various places in this plugin like search form, navigation menu, etc.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sespage.text.plural', 'pages'),
      ));
      $this->addElement('Radio', 'sespage_show_userdetail', array(
          'label' => 'Display Page Owners Name and Photo or Hide Identity',
          'description' => 'Do you want to display Page owners’ name and profile in various widgets and Pages of this plugin? Choosing No for this setting will help you hide the identity of the page owners.',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sespage.show.userdetail', 1),
      ));
      $this->addElement('Radio', 'sespage_watermark_enable', array(
          'label' => 'Add Watermark to Photos',
          'description' => 'Do you want to add watermark to photos (from this plugin) on your website? If you choose Yes, then you can upload watermark image to be added to the photos from the <a href="' . $view->baseUrl() . "/admin/sespage/settings/level" . '">Member Level Settings</a>.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'show_position(this.value)',
          'value' => $settings->getSetting('sespage.watermark.enable', 0),
      ));
      $this->addElement('Select', 'sespage_position_watermark', array(
          'label' => 'Watermark Position',
          'description' => 'Choose the position for the watermark.',
          'multiOptions' => array(
              0 => 'Middle ',
              1 => 'Top Left',
              2 => 'Top Right',
              3 => 'Bottom Right',
              4 => 'Bottom Left',
              5 => 'Top Middle',
              6 => 'Middle Right',
              7 => 'Bottom Middle',
              8 => 'Middle Left',
          ),
          'value' => $settings->getSetting('sespage.position.watermark', 0),
      ));
      $this->sespage_watermark_enable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->addElement('Text', "sespage_mainheight", array(
          'label' => 'Large Photo Height',
          'description' => 'Enter the maximum height of the large main photo (in pixels) for Pages. [Note: This photo will be shown in the lightbox and on " Page View". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sespage.mainheight', 1600),
      ));
      $this->addElement('Text', "sespage_mainwidth", array(
          'label' => 'Large Photo Width',
          'description' => 'Enter the maximum width of the large main photo (in pixels) for Pages. [Note: This photo will be shown in the lightbox and on "Page View". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sespage.mainwidth', 1600),
      ));
      $this->addElement('Text', "sespage_normalheight", array(
          'label' => 'Medium Photo Height',
          'description' => "Enter the maximum height of the medium photo (in pixels) for Pages. [Note: This photo will be shown in the various widgets and pages of this plugin. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sespage.normalheight', 500),
      ));
      $this->addElement('Text', "sespage_normalwidth", array(
          'label' => 'Medium Photo Width',
          'description' => "Enter the maximum width of the medium photo (in pixels) for Pages. [Note: This photo will be shown in the various widgets and pages of this plugin. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sespage.normalwidth', 500),
      ));
      $this->addElement('Radio', "sespage_enable_contact_details", array(
          'label' => 'Display Contact Details to Non-logged In Users',
          'description' => "Do you want to display contact details of Pages to non-logged in users of your website? If you choose No, then non-logged in users will be asked to login when they try to view the contact details of page in various widgets and places on your website ?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sespage.enable.contact.details', 0),
      ));
      $this->addElement('Radio', "sespage_enable_location", array(
          'label' => 'Enable Location',
          'description' => "Do you want to enable location for the Pages on your website? You can choose to “Allow to Add Multiple Locations” in Pages from the Member Level Settings of this plugin.?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sespage.enable.location', 1),
      ));
      $this->addElement('Radio', "sespage_location_isrequired", array(
          'label' => 'Make Page Location Mandatory',
          'description' => "Do you want to make Location field mandatory when users create or edit their Pages?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sespage.location.isrequired', 1),
      ));
      $this->addElement('Radio', 'sespage_search_type', array(
          'label' => 'Proximity Search Unit (Search via Google API)',
          'description' => 'Choose the unit for proximity search of location of Pages on your website. (Note: This setting will only work when you have enabled location via Google APIs from the Basic Required Plugin. If you have disabled Google APIs, then you will not able to search pages based on their proximity.)',
          'multiOptions' => array(
              1 => 'Miles',
              0 => 'Kilometres'
          ),
          'value' => $settings->getSetting('sespage.search.type', 1),
      ));
      $this->addElement('Radio', 'sespage_enable_map_integration', array(
          'label' => 'Enable Get Direction Popup (via Google API)',
          'description' => 'Do you want to open the location in Get Direction popup when users click on the Location of Pages at various places and widgets? (Note: This setting will only work when you have enabled location via Google APIs from the Basic Required Plugin. If you have disabled Google APIs, then page locations will not be clickable and Get Direction popup will not come.)',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sespage.enable.map.integration', 1),
      ));
      $this->addElement('Radio', "sespage_activityfeed_filter", array(
          'label' => 'Page Feeds Display in Main Feed',
          'description' => "Do you want to display Page feeds to users only from the Pages which they have Liked, Followed, Joined or marked as Favourite? If you want to show feeds from all the Pages to your users, then choose 'No' in this setting.",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sespage.activityfeed.filter', 0),
      ));
      $this->addElement('Radio', "sespage_allow_share", array(
          'label' => 'Allow to Share Pages',
          'description' => "Do you want to allow users to share Pages of your website inside on your website and outside on other social networking sites?",
          'multiOptions' => array(
              '2' => 'Yes, allow sharing on this site and on social networking sites both.',
              '1' => ' Yes, allow sharing on this site and do not allow sharing on other Social sites.',
              '0' => 'No, do not allow sharing of Pages.',
          ),
          'value' => $settings->getSetting('sespage.allow.share', 1),
      ));
      $this->addElement('Radio', "sespage_allow_favourite", array(
          'label' => 'Allow to Favorite Pages',
          'description' => "Do you want to allow members to add Pages on your website to Favorites?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sespage.allow.favourite', 1),
      ));
      $this->addElement('Radio', "sespage_allow_follow", array(
          'label' => 'Allow to Follow Pages',
          'description' => "Do you want to allow members to Follow Pages on your website?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sespage.allow.follow', 1),
      ));
      $this->addElement('Radio', "sespage_allow_integration", array(
          'label' => 'Integrate Like & Follow Buttons',
          'description' => "Do you want to integrate the Like & Follow buttons of Pages such that when a user will Like a Page, then user will automatically Follow that Page and when user will Follow Page, then that Page will also be Liked?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sespage.allow.integration', 0),
      ));
      $this->addElement('Radio', "sespage_allowfollow_category", array(
          'label' => 'Allow to Follow Categories',
          'description' => "Do you want to allow members to Follow Categories of Pages on your website?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sespage.allowfollow.category', 1),
      ));
      $this->addElement('Radio', "sespage_allow_report", array(
          'label' => ' Allow to Report',
          'description' => "Do you want to allow users to Report against Pages on your website?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sespage.allow.report', 1),
      ));

      $this->addElement('Radio', "sespage_allow_service", array(
        'label' => 'Allow to Page Services',
        'description' => "Do you want to allow members to add Services in to Pages on your website?",
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('sespage.allow.service', 1),
      ));

      $this->addElement('Radio', "sespage_approve_post", array(
          'label' => 'Allow to Enable / Disable Auto-Approval of Page Posts',
          'description' => "Do you want to allow owners of Pages to enable or disable auto-approval of posts in their Pages? If you choose No, then all posts to the Pages will be auto-approved.",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sespage_approve_post', 1),
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
      //no page default photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Sespage/externals/images/page-icon.png' => ''), $default_photos_main);
        $this->addElement('Select', 'sespage_page_no_photo', array(
            'label' => 'Default Photo for No Page Tip',
            'description' => 'Choose a default photo for No pages tip on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change this default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('sespage.page.no.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . 'There are currently no photos in the File & Media Manager. So, photo should be first uploaded from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.' . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'sespage_page_no_photo', array(
            'label' => 'Page Default No Page Photo',
            'description' => $description,
        ));
      }
      $this->sespage_page_no_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Select', 'sespage_taboptions', array(
          'label' => 'Menu Items Count in Main Navigation',
          'description' => 'How many menu items do you want to show in the Main Navigation Menu of this plugin?',
          'multiOptions' => array(
              0 => 0,
              1 => 1,
              2 => 2,
              3 => 3,
              4 => 4,
              5 => 5,
              6 => 6,
              7 => 7,
              8 => 8,
              9 => 9,
          ),
          'value' => $settings->getSetting('sespage.taboptions', 6),
      ));

      $this->addElement('Textarea', "sespage_receivenewalertemails", array(
        'label' => 'Receive New Page Alerts',
        'description' => 'Enter the comma separated emails in the box below on which you want to receive emails whenever a new Page is created on your website.',
        'value' => $settings->getSetting('sespage.receivenewalertemails'),
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
