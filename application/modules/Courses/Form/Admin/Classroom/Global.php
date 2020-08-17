<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Global.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Form_Admin_Classroom_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Classroom Global Settings')
            ->setDescription('These settings controls the Classrooms functionality and also affect all members in your community.');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    if(!$settings->getSetting('eclassroom.changelanding', 0)) {
            $this->addElement('Radio', 'classroom_changelanding', array(
                'label' => 'Set Welcome Page as Landing Page(LP)',
                'description' => 'Do you want to set the Welcome Page of this plugin as Default Landing page of your website? [This is a one time setting, so if you choose ‘Yes’ and save changes, then later you can manually make changes in the Landing page from Layout Editor. Backup page of your current landing page will get created with the name "LP backup from Courses".]',
                'onclick' => 'confirmChangeLandingClassroom(this.value)',
                'multiOptions' => array('1' => 'Yes','0' => 'No'),
                'value' => $settings->getSetting('eclassroom.changelanding', 0),
            ));
    }
    $this->addElement('Radio', 'eclassroom_page_redirect', array(
        'label'=>'Classroom Main Menu Redirection',
        'description' => 'Choose from below where do you want to redirect users when Classroom Menu item is clicked in the Main Navigation Menu Bar.',
        'multiOptions' => array(1 => 'Classroom Home page',2 => 'Classroom Browse page',3 => 'Classroom Category page'),
        'value' => $settings->getSetting('eclassroom.page.redirect', 1),
    ));
    $this->addElement('Text', 'eclassroom_plural_manifest', array(
        'label' => 'Plural Text for "Classrooms" in URL',
        'description' => 'Enter the text which you want to show in place of "Classrooms" in the URLs of this plugin.',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('eclassroom.plural.manifest', 'classrooms'),
    ));
    $this->addElement('Text', 'eclassroom_singular_manifest', array(
        'label' => 'Singular Text for "Classroom" in URL',
        'description' => 'Enter the text which you want to show in place of "Classroom" in the URLs of this plugin.',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('eclassroom.singular.manifest', 'classroom'),
    ));
    $this->addElement('Text', 'eclassroom_text_singular', array(
        'label' => 'Singular Text for "Classroom"',
        'description' => 'Enter the text which you want to show in place of "Classroom" at various places in this plugin like activity feeds, etc.',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('eclassroom.text.singular', 'classroom'),
    ));
    $this->addElement('Text', 'eclassroom_text_plural', array(
        'label' => 'Plural Text for "Classrooms"',
        'description' => 'Enter the text which you want to show in place of "Classrooms" at various places in this plugin like search form, navigation menu, etc.',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('eclassroom.text.plural', 'classrooms'),
    ));
    $this->addElement('Radio', 'eclassroom_watermark_enable', array(
        'label' => 'Add Watermark to Photos',
        'description' => 'Do you want to add watermark to photos (from this plugin) on your website? If you choose Yes, then you can upload watermark image to be added to the photos from the Member Level Settings.',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('eclassroom.watermark.enable', 0),
        'onclick' => 'showClassroomWatermark(this.value);',
    ));
    $this->addElement('Select', 'eclassroom_watermark_position', array(
        'label' => 'Watermark Position',
        'description' => 'Choose the position for the watermark.',
        'multiOptions' => array('middle' => 'Middle','topLeft' => 'Top Left','topRight' => 'Top Right','buttomRight' => 'Bottom Right','bottomLeft' => 'Bottom Left','topMiddle' => 'Top Middle','middleRight'=>'Middle Right','bottomMiddle'=>'Bottom Middle','middleLeft'=>'Middle Left'),
        'value' => $settings->getSetting('eclassroom.watermark.position','middle'),
    ));
    $this->addElement('Text', 'eclassroom_mainheight', array(
        'label' => 'Large Photo Height',
        'description' => 'Enter the maximum height of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Classroom Photo View Page". Also, this setting will apply on new uploaded photos.]',
        'value' => $settings->getSetting('eclassroom.mainheight', 1600),
    ));
    $this->addElement('Text', 'eclassroom_mainwidth', array(
        'label' => 'Large Photo Width',
        'description' => 'Enter the maximum width of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Classroom Photo View Page". Also, this setting will apply on new uploaded photos.]',
        'value' => $settings->getSetting('eclassroom.mainwidth', 1600),
    ));
    $this->addElement('Text', 'eclassroom_normalheight', array(
        'label' => 'Medium Photo Height',
        'description' => 'Enter the maximum height of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]',
        'value' => $settings->getSetting('eclassroom.normalheight',500),
    ));
    $this->addElement('Text', 'eclassroom_normalwidth', array(
        'label' => 'Medium Photo Width',
        'description' => 'Enter the maximum width of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]',
        'value' => $settings->getSetting('eclassroom.normalwidth', 500),
    ));
    $this->addElement('Radio', 'eclassroom_enable_course', array(
            'label' => 'Enable Classroom for Courses',
            'description' => 'Do you want to enable Classroom on your website? If you choose Yes, then users will be able to add create Courses in their Classrooms or if you choose No, then they can directly create Courses on your website.When this setting disabled then directly users create Courses and show Create New Course Icon setting works.',
             'multiOptions' => array('1' => 'Yes','0' => 'No'),
            'value' => $settings->getSetting('eclassroom.enable.course', 1),
    ));
    $this->addElement('Radio', 'eclassroom_nonLogged_details', array(
        'label' => 'Display Contact Details to Non-logged In Users',
        'description' => 'Do you want to display contact details of Classroom to non-logged in users of your website? If you choose No, then non-logged in users will be asked to login when they try to view the contact details of classroom in various widgets and places on your website ?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('eclassroom.nonLogged.details', 1),
    ));
    $this->addElement('Radio', 'eclassroom_enable_location', array(
          'label' => 'Enable Location',
          'description' => 'Do you want to enable location for the Classroom on your website?',
           'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.enable.location', 0),
          'onclick' => 'showClassroomLocation(this.value);',
    ));
    $this->addElement('Radio', "eclassroom_location_isrequired", array(
          'label' => 'Make Classroom Location Mandatory',
          'description' => "Do you want to make Location field mandatory when users create or edit their Classroom?",
           'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.location.isrequired', 1),
    ));
    $this->addElement('Radio', 'eclassroom_search_type', array(
        'label' => 'Proximity Search Unit (Search via Google API)',
        'description' => 'Choose the unit for proximity search of location of Classroom on your website. (Note: This setting will only work when you have enabled location via Google APIs from the Basic Required Plugin. If you have disabled Google APIs, then you will not able to search classrooms based on their proximity.)',
        'multiOptions' => array(1 => 'Miles',0 => 'Kilometres'),
        'value' => $settings->getSetting('eclassroom.search.type', 1),
    ));
    $this->addElement('Radio', 'eclassroom_enable_map_integration', array(
        'label' => 'Enable Get Direction Popup (via Google API)',
        'description' => 'Do you want to open the location in Get Direction popup when users click on the Location of Classroom at various places and widgets? (Note: This setting will only work when you have enabled location via Google APIs from the Basic Required Plugin. If you have disabled Google APIs, then page locations will not be clickable and Get Direction popup will not come.)',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('eclassroom.enable.map.integration', 1),
    ));
    $this->addElement('Radio', "eclassroom_allow_share", array(
        'label' => 'Allow to Share Classrooms',
        'description' => "Do you want to allow users to share Classrooms of your website on social networking sites?",
        'multiOptions' => array(
              '2' => 'Yes, allow sharing on this site and on social networking sites both.',
              '1' => ' Yes, allow sharing on this site and do not allow sharing on other Social sites.',
              '0' => 'No, do not allow sharing of Classrooms.',
         ),
        'value' => $settings->getSetting('eclassroom.allow.share', 1),
    ));
    $this->addElement('Radio', "eclassroom_allow_favourite", array(
        'label' => 'Allow to Favorite Classrooms',
        'description' => "Do you want to allow members to add Classrooms on your website to Favorites?",
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('eclassroom.allow.favourite', 1),
    ));
    $this->addElement('Radio', "eclassroom_allow_follow", array(
        'label' => 'Allow to Follow Classrooms',
        'description' => "Do you want to allow members to Follow Classrooms on your website?",
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('eclassroom.allow.follow', 1),
    ));
    $this->addElement('Radio', "eclassroom_allow_integration", array(
          'label' => 'Integrate Like & Follow Buttons',
          'description' => "Do you want to integrate the Like & Follow buttons of Classrooms such that when a user will Like a Classroom, then user will automatically Follow that Classroom and when user will Follow Classroom, then that Classroom will also be Liked?",
           'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.allow.integration', 1),
    ));
    $this->addElement('Radio', "eclassroom_allowfollow_category", array(
        'label' => 'Allow to Follow Categories',
        'description' => "Do you want to allow members to Follow Categories of Classroom on your website?",
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('eclassroom.allowfollow.category', 1),
    ));
//     $this->addElement('Radio', "eclassroom_allow_service", array(
//           'label' => 'Allow Classroom to Add Services',
//           'description' => "Do you want to allow Classroom owners to add Services in their Classrooms on your website?.",
//            'multiOptions' => array('1' => 'Yes','0' => 'No'),
//           'value' => $settings->getSetting('eclassroom.allow.service', 1),
//     ));
    $this->addElement('Radio', "eclassroom_allow_like", array(
          'label' => 'Allow to Like Classrooms',
          'description' => "Do you want to allow members to like Classrooms on your website.",
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.allow.like', 1),
    ));
    $this->addElement('Radio', "eclassroom_allow_report", array(
        'label' => 'Allow to Report',
        'description' => "Do you want to allow users to Report against Courses on your website?",
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('eclassroom.allow.report', 1),
    ));
    $this->addElement('Radio', "eclassroom_identity_privacy", array(
          'label' => 'Classroom Feeds Display in Main Feed',
          'description' => "Do you want to display Classroom feeds to users only from the Classrooms which they have Liked, Followed, Joined or marked as Favourite? If you want to show feeds from all the Classrooms to your users, then choose 'No' in this setting.",
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('eclassroom.identity.privacy', 1),
    ));
    $this->addElement('Radio', "eclassroom_approve_post", array(
        'label' => 'Allow to Enable / Disable Auto-Approval of Classroom Posts',
        'description' => "Do you want to allow owners of Classroom to enable or disable auto-approval of posts in their Classroom? If you choose No, then all posts to the Classroom will be auto-approved.",
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('eclassroom.approve.post', 1),
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
      //no Classroom default photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Courses/externals/images/classroom-icon.png' => ''), $default_photos_main);
        $this->addElement('Select', 'eclassroom_class_no_photo', array(
            'label' => 'Default Photo for No Classroom Tip',
            'description' => 'Choose a default photo for No Classroom tip on your website. [Note: You can add a new photo from the "File & Media Manager" section from here:  <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change this default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('eclassroom.class.no.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . 'There are currently no photos in the File & Media Manager. So, photo should be first uploaded from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.' . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'eclassroom_class_no_photo', array(
            'label' => 'Default Photo for No Classroom Tip',
            'description' => $description,
        ));
      }
      $this->eclassroom_class_no_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->addElement('Select', 'eclassroom_taboptions', array(
          'label' => 'Menu Items Count in Main Navigation',
          'description' => 'How many menu items do you want to show in the Main Navigation Menu of this plugin?',
          'multiOptions' => array(0 => 0,1 => 1,2 => 2,3 => 3,4 => 4,5 => 5,6 => 6,7 => 7,8 => 8,9 => 9),
          'value' => $settings->getSetting('eclassroom.taboptions', 9),
      ));
      $this->addElement('Textarea', "eclassroom_receivenewalertemails", array(
        'label' => 'Receive New Classroom Alerts',
        'description' => 'Enter the comma separated emails in the box below on which you want to receive emails whenever a new Classroom is created on your website.',
        'value' => $settings->getSetting('eclassroom.receivenewalertemails'),
      ));
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
  }
}
