<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)', $supportTicket, $sesSite);
    
    $this->addElement('Text', "sesgroup_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesgroup.licensekey'),
    ));
    $this->getElement('sesgroup_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.pluginactivated')) {
      if (!$settings->getSetting('sesgroup.changelanding', 0)) {
        $this->addElement('Radio', 'sesgroup_changelanding', array(
            'label' => 'Set Welcome Page as Landing Page',
            'description' => 'Do you want to set the Welcome Page of this plugin as Default Landing page of your website? [This is a one time setting, so if you choose ‘Yes’ and save changes, then later you can manually make changes in the Landing page from Layout Editor. Back up page of your current landing page will get created with the name “LP backup from SES Group Communities”.]',
            'onclick' => 'confirmChangeLandingGroup(this.value)',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => $settings->getSetting('sesgroup.changelanding', 0),
        ));
      }
      $this->addElement('Radio', 'sesgroup_check_welcome', array(
          'label' => 'Welcome Page Visibility',
          'description' => 'Who all users do you want to see this "Welcome Page"?',
          'multiOptions' => array(
              0 => 'Only logged in users',
              1 => 'Only non-logged in users',
              2 => 'Both, logged-in and non-logged in users',
          ),
          'value' => $settings->getSetting('sesgroup.check.welcome', 2),
      ));
      $this->addElement('Radio', 'sesgroup_enable_welcome', array(
          'label' => 'Group Main Menu Redirection',
          'description' => 'Choose from below where do you want to redirect users when Group Menu item is clicked in the Main Navigation Menu Bar.',
          'multiOptions' => array(
              1 => 'Group Welcome Page',
              0 => 'Group Home Page',
              2 => 'Group Browse Page'
          ),
          'value' => $settings->getSetting('sesgroup.enable.welcome', 1),
      ));
      $this->addElement('Text', 'sesgroup_groups_manifest', array(
          'label' => 'Plural Text for "group-communities" in URL',
          'description' => 'Enter the text which you want to show in place of "group-communities" in the URLs of this plugin.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sesgroup.groups.manifest', 'group-communities'),
      ));
      $this->addElement('Text', 'sesgroup_group_manifest', array(
          'label' => 'Singular Text for "group-community " in URL',
          'description' => 'Enter the text which you want to show in place of "group-community" in the URLs of this plugin.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sesgroup.group.manifest', 'group-community'),
      ));
      $this->addElement('Text', 'sesgroup_text_singular', array(
          'label' => 'Singular Text for "Group Community"',
          'description' => 'Enter the text which you want to show in place of "Group" at various places in this plugin like activity feeds, etc.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sesgroup.text.singular', 'group'),
      ));
      $this->addElement('Text', 'sesgroup_text_plural', array(
          'label' => 'Plural Text for "Group Communities"',
          'description' => 'Enter the text which you want to show in place of "Groups" at various places in this plugin like search form, navigation menu, etc.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sesgroup.text.plural', 'groups'),
      ));
      $this->addElement('Radio', 'sesgroup_show_userdetail', array(
          'label' => 'Display Group Owners Name and Photo or Hide Identity',
          'description' => 'Do you want to display Group owners’ name and profile in various widgets and Pages of this plugin? Choosing No for this setting will help you hide the identity of the group owners.',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroup.show.userdetail', 1),
      ));
      $this->addElement('Radio', 'sesgroup_watermark_enable', array(
          'label' => 'Add Watermark to Photos',
          'description' => 'Do you want to add watermark to photos (from this plugin) on your website? If you choose Yes, then you can upload watermark image to be added to the photos from the <a href="' . $view->baseUrl() . "/admin/sesgroup/settings/level" . '">Member Level Settings</a>.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'show_position(this.value)',
          'value' => $settings->getSetting('sesgroup.watermark.enable', 0),
      ));
      $this->addElement('Select', 'sesgroup_position_watermark', array(
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
          'value' => $settings->getSetting('sesgroup.position.watermark', 0),
      ));
      $this->sesgroup_watermark_enable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->addElement('Text', "sesgroup_mainheight", array(
          'label' => 'Large Photo Height',
          'description' => 'Enter the maximum height of the large main photo (in pixels) for Groups. [Note: This photo will be shown in the lightbox and on " Group View". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesgroup.mainheight', 1600),
      ));
      $this->addElement('Text', "sesgroup_mainwidth", array(
          'label' => 'Large Photo Width',
          'description' => 'Enter the maximum width of the large main photo (in pixels) for Groups. [Note: This photo will be shown in the lightbox and on "Group View". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesgroup.mainwidth', 1600),
      ));
      $this->addElement('Text', "sesgroup_normalheight", array(
          'label' => 'Medium Photo Height',
          'description' => "Enter the maximum height of the medium photo (in pixels) for Groups. [Note: This photo will be shown in the various widgets and pages of this plugin. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesgroup.normalheight', 500),
      ));
      $this->addElement('Text', "sesgroup_normalwidth", array(
          'label' => 'Medium Photo Width',
          'description' => "Enter the maximum width of the medium photo (in pixels) for Groups. [Note: This photo will be shown in the various widgets and pages of this plugin. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesgroup.normalwidth', 500),
      ));
      $this->addElement('Radio', "sesgroup_enable_contact_details", array(
          'label' => 'Display Contact Details to Non-logged In Users',
          'description' => "Do you want to display contact details of Groups to non-logged in users of your website? If you choose No, then non-logged in users will be asked to login when they try to view the contact details of group in various widgets and places on your website ?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroup.enable.contact.details', 0),
      ));
      $this->addElement('Radio', "sesgroup_enable_location", array(
          'label' => 'Enable Location',
          'description' => "Do you want to enable location for the Groups on your website? You can choose to “Allow to Add Multiple Locations” in Groups from the Member Level Settings of this plugin.?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroup.enable.location', 1),
      ));
      $this->addElement('Radio', "sesgroup_location_isrequired", array(
          'label' => 'Make Group Location Mandatory',
          'description' => "Do you want to make Location field mandatory when users create or edit their Groups?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroup.location.isrequired', 1),
      ));
      $this->addElement('Radio', 'sesgroup_search_type', array(
          'label' => 'Proximity Search Unit (Search via Google API)',
          'description' => 'Choose the unit for proximity search of location of Groups on your website. (Note: This setting will only work when you have enabled location via Google APIs from the Basic Required Plugin. If you have disabled Google APIs, then you will not able to search groups based on their proximity.)',
          'multiOptions' => array(
              1 => 'Miles',
              0 => 'Kilometres'
          ),
          'value' => $settings->getSetting('sesgroup.search.type', 1),
      ));
      $this->addElement('Radio', 'sesgroup_enable_map_integration', array(
          'label' => 'Enable Get Direction Popup (via Google API)',
          'description' => 'Do you want to open the location in Get Direction popup when users click on the Location of Groups at various places and widgets? (Note: This setting will only work when you have enabled location via Google APIs from the Basic Required Plugin. If you have disabled Google APIs, then page locations will not be clickable and Get Direction popup will not come.)',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sesgroup.enable.map.integration', 1),
      ));
      $this->addElement('Radio', "sesgroup_activityfeed_filter", array(
          'label' => 'Group Feeds Display in Main Feed',
          'description' => "Do you want to display Group feeds to users only from the Groups which they have Liked, Followed, Joined or marked as Favourite? If you want to show feeds from all the Groups to your users, then choose 'No' in this setting.",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroup.activityfeed.filter', 0),
      ));
      $this->addElement('Radio', "sesgroup_allow_share", array(
          'label' => 'Allow to Share Groups',
          'description' => "Do you want to allow users to share Groups of your website inside on your website and outside on other social networking sites?",
          'multiOptions' => array(
              '2' => 'Yes, allow sharing on this site and on social networking sites both.',
              '1' => ' Yes, allow sharing on this site and do not allow sharing on other Social sites.',
              '0' => 'No, do not allow sharing of Groups.',
          ),
          'value' => $settings->getSetting('sesgroup.allow.share', 1),
      ));
      $this->addElement('Radio', "sesgroup_allow_favourite", array(
          'label' => 'Allow to Favorite Groups',
          'description' => "Do you want to allow members to add Groups on your website to Favorites?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroup.allow.favourite', 1),
      ));
      $this->addElement('Radio', "sesgroup_allow_follow", array(
          'label' => 'Allow to Follow Groups',
          'description' => "Do you want to allow members to Follow Groups on your website?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroup.allow.follow', 1),
      ));
      $this->addElement('Radio', "sesgroup_allow_integration", array(
          'label' => 'Integrate Like & Follow Buttons',
          'description' => "Do you want to integrate the Like & Follow buttons of Groups such that when a user will Like a Group, then user will automatically Follow that Group and when user will Follow Group, then that Group will also be Liked?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroup.allow.integration', 0),
      ));
      $this->addElement('Radio', "sesgroup_allowfollow_category", array(
          'label' => 'Allow to Follow Categories',
          'description' => "Do you want to allow members to Follow Categories of Groups on your website?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroup.allowfollow.category', 1),
      ));
      $this->addElement('Radio', "sesgroup_allow_report", array(
          'label' => ' Allow to Report',
          'description' => "Do you want to allow users to Report against Groups on your website?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroup.allow.report', 1),
      ));

      $this->addElement('Radio', "sesgroup_allow_service", array(
        'label' => 'Allow to Group Services',
        'description' => "Do you want to allow members to add Services in to Groups on your website?",
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('sesgroup.allow.service', 1),
      ));

      $this->addElement('Radio', "sesgroup_approve_post", array(
          'label' => 'Allow to Enable / Disable Auto-Approval of Group Posts',
          'description' => "Do you want to allow owners of Groups to enable or disable auto-approval of posts in their Groups? If you choose No, then all posts to the Groups will be auto-approved.",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroup_approve_post', 1),
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
      //no group default photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Sesgroup/externals/images/group-icon.png' => ''), $default_photos_main);
        $this->addElement('Select', 'sesgroup_group_no_photo', array(
            'label' => 'Default Photo for No Group Tip',
            'description' => 'Choose a default photo for No groups tip on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change this default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('sesgroup.group.no.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . 'There are currently no photos in the File & Media Manager. So, photo should be first uploaded from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.' . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'sesgroup_group_no_photo', array(
            'label' => 'Group Default No Group Photo',
            'description' => $description,
        ));
      }
      $this->sesgroup_group_no_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Select', 'sesgroup_taboptions', array(
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
          'value' => $settings->getSetting('sesgroup.taboptions', 6),
      ));

      $this->addElement('Textarea', "sesgroup_receivenewalertemails", array(
        'label' => 'Receive New Group Alerts',
        'description' => 'Enter the comma separated emails in the box below on which you want to receive emails whenever a new Group is created on your website.',
        'value' => $settings->getSetting('sesgroup.receivenewalertemails'),
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
