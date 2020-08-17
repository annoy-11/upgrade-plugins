<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Level.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Admin_Course_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
    parent::init();
    // My stuff
    if (COURSESPACKAGE == 1) {
      $class = 'coursespackage';
    } else {
      $class = '';
    }
    $this->setTitle('Course Member Level Settings')
            ->setDescription('These settings are applied as per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level from below.');
    // Element: view
    $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Courses?',
        'description' => 'Do you want to allow users to create Courses? If set to “No”, some other settings on this Course may not apply. This is useful when you want certain levels only to be able to create Courses. If this setting is chosen “Yes” for Public Member level, then when a public users click on "Create New Course" option, they will see Authorization Popup to Login or Sign-up on your website.',
        'multiOptions' => array(
            1 => 'Yes, allow creation of Courses..',
            0 => 'No, do not allow to create Courses.',
        ),
        'value' => ($this->isModerator() ? 1 : 1),
    ));
    $this->addElement('Radio', 'view', array(
        'label' => 'Allow Viewing of Courses?',
        'description' => 'Do you want to let members view Courses? If set to no, some other settings on this Course may not apply.',
        'multiOptions' => array(
            2 => 'Yes, allow members to view all Courses',
            1 => 'Yes, allow members to view their own Courses.',
            0 => 'No, do not allow Courses to be viewed.',
        ),
        'value' => ($this->isModerator() ? 2 : 1),
    ));
    if (!$this->isModerator()) {
      unset($this->view->options[2]);
    }
    if (!$this->isPublic()) { 
      $this->addElement('Radio', 'edit', array(
          'label' => 'Allow Editing of Courses?',
          'description' => 'Do you want to let members edit Courses?',
          'multiOptions' => array(
              2 => "Yes, allow members to edit everyone's Courses, even private ones.",
              1 => 'Yes, allow members to edit their own Courses.',
              0 => 'No, do not allow Courses to be edited.',
          ),
          'value' => ($this->isModerator() ? 2 : 1),
      ));
      if (!$this->isModerator()) {
          unset($this->edit->options[2]);
      }
      $this->addElement('Radio', 'delete', array(
            'label' => 'Allow Deletion of Courses?',
            'description' => 'Do you want to let members delete Courses?',
            'multiOptions' => array(
                2 => "Yes, allow members to delete everyone's Courses.",
                1 => 'Yes, allow members to delete their own Courses.',
                0 => 'No, do not allow members to delete their Courses.',
            ),
            'value' => ($this->isModerator() ? 2 : 1),
      ));
      if (!$this->isModerator()) {
          unset($this->delete->options[2]);
      }
      $this->addElement('Radio', 'comment', array(
          'label' => 'Allow Commenting on Courses?',
          'description' => 'Do you want to let members of this level comment on Courses?',
          'multiOptions' => array(
              2 => 'Yes, allow members to comment on all Courses, including private ones.',
              1 => 'Yes, allow members to comment on Courses.',
              0 => 'No, do not allow members to comment on Courses.',
          ),
          'value' => ($this->isModerator() ? 2 : 1),
      ));
      if (!$this->isModerator()) {
          unset($this->comment->options[2]);
      }
      $this->addElement('Radio', 'upload_mainphoto', array(
          'label' => 'Allow to Upload Courses Main Photo',
          'description' => 'Do you want to allow members of this member level to upload main photo for their Courses. If set to No, then the default main photo will get displayed instead which you can choose in settings below.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $default_photos = array();
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
          $default_photos['public/admin/' . $base_name] = $base_name;
        }
        $default_photos = array_merge(array(''), $default_photos);
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $fileLink = $view->baseUrl() . '/admin/files/';
        //page main photo
        if (count($default_photos) > 0) {
          $this->addElement('Select', 'watermark', array(
              'label' => 'Add Watermark to Main Photos',
              'description' => 'Choose a photo which you want to be added as the watermark on the main photos uploads by the members of this level on your website.',
              'multiOptions' => $default_photos,
              'class' => $class,
          ));
          $this->addElement('Select', 'watermarkthumb', array(
              'label' => 'Add Watermark to Thumb Photos',
              'description' => 'Choose a photo which you want to be added as the watermark on the thumb photos uploads by the members of this level on your website.',
              'multiOptions' => $default_photos,
              'class' => $class,
          ));
          $this->addElement('Select', 'bsdefaultphoto', array(
              'label' => 'Main Default Photo for Courses',
              'description' => 'Choose Main default photo for the Courses on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: File & Media Manager. Leave the field blank if you do not want to change Course default photo.]',
              'multiOptions' => $default_photos,
              'class' => $class,
          ));
        } else {
          $description = "<div class='tip'><span>" . 'There are currently no photo in the File & Media Manager. Please upload the Photo to be chosen from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manage</a>" section.' . "</span></div>";
          //Add Element: Dummy
          $this->addElement('Dummy', 'watermark', array(
              'label' => 'Default Watermark Photo for Course Main Photo',
              'description' => $description,
              'class' => $class,
          ));
          $this->addElement('Dummy', 'watermarkthumb', array(
              'label' => 'Default Watermark Photo for Course Cover Photo',
              'description' => $description,
              'class' => $class,
          ));
          $this->addElement('Dummy', 'bsdefaultphoto', array(
              'label' => 'Default Main Photo for Course',
              'description' => $description,
              'class' => $class,
          ));
        }
      // Element: create
      $this->addElement('Radio', 'auto_approve', array(
          'label' => 'Auto Approve Courses',
          'description' => 'Do you want Courses created by members of this level to be auto-approved?',
          'multiOptions' => array(
              1 => 'Yes, auto-approve Courses.',
              0 => 'No, do not auto-approve Courses.',
          ),
          'value' => 1,
      ));
      //element for course featured
      $this->addElement('Radio', 'bs_featured', array(
          'description' => 'Do you want Course created by members of this level to be automatically marked as Featured? If you choose No, then you can manually mark Course as Featured from Manage Course section of this plugin.',
          'label' => 'Automatically Mark Course as Featured.',
          'multiOptions' => array(
              1 => 'Yes',0 => 'No'),
          'class' => $class,
          'value' => 0,
      ));
      //element for course sponsored
      $this->addElement('Radio', 'bs_sponsored', array(
          'description' => 'Do you want Course created by members of this level to be automatically marked as Sponsored? If you choose No, then you can manually mark Course as Sponsored from Manage Course section of this plugin.',
          'label' => 'Automatically Mark Course as Sponsored.',
          'multiOptions' => array(1 => 'Yes',0 => 'No'),
          'class' => $class,
          'value' => 0,
      ));
      //element for course verified
      $this->addElement('Radio', 'bs_verified', array(
          'description' => 'Do you want Course created by members of this level to be automatically marked as Verified? If you choose No, then you can manually mark Course as Verified from Manage Course section of this plugin.',
          'label' => 'Automatically Mark Course as Verified',
          'multiOptions' => array(1 => 'Yes',0 => 'No'),
          'class' => $class,
          'value' => 0,
      ));
      //element for course verified
      $this->addElement('Radio', 'course_hot', array(
          'description' => 'Do you want Course created by members of this level to be automatically marked as Verified? If you choose No, then you can manually mark Course as Verified from Manage Course section of this plugin.',
          'label' => 'Automatically Mark Course as Hot',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Courses as Hot',
              0 => 'No, do not automatically mark Courses as Hot',
          ),
          'class' => $class,
          'value' => 0,
      ));
      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
            'label' => 'Course Privacy',
            'description' => 'Your members can choose from any of the options checked below when they decide who can see their Courses. These options appear on your members\' "Add Course" and "Edit Course" courses. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
            'multiOptions' => array(
                'everyone' => 'Everyone',
                'registered' => 'Registered Members',
                'owner_network' => 'Friends and Networks',
                'owner_member_member' => 'Friends of Friends',
                'owner_member' => 'Friends Only',
                'owner' => 'Just Me'
            ),
            'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner'),
      ));
      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
          'label' => 'Course Comment Options',
          'description' => 'Your members can choose from any of the options checked below when they decide who can post comments on their Courses. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'everyone' => 'Everyone',
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Just Me',
          ),
          'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner','member'),
      ));
      $this->addElement('Radio', 'bs_css_style', array(
          'label' => 'Allow Custom CSS Styles?',
          'description' => 'If you enable this feature, your members will be able to customize the colors and fonts of their Courses by altering their CSS styles.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'course_html', array(
          'label' => 'HTML in Courses?',
          'description' => 'If you want to allow specific HTML tags, you can enter them below (separated by commas).
          Example: b, img, a, embed, font, strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr',
            'class' => $class,
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No',
            ),
            'value' => 1,
      ));
      $this->addElement('Radio', 'allow_levels', array(
            'label' => 'Allow to choose "Course View Privacy Based on Member Levels"',
            'description' => 'Do you want to allow the members of this level to choose View privacy of their Courses based on Member Levels on your website? If you choose Yes, then users will be able to choose the visibility of their Courses to members of selected member levels only.',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No',
            ),
            'value' => 0,
      ));
      $this->addElement('Radio', 'allow_network', array(
            'label' => 'Allow to choose "Course View Privacy Based on Networks"',
            'description' => 'Do you want to allow the members of this level to choose View privacy of their Courses based on Networks on your website? If you choose Yes, then users will be able to choose the visibility of their Courses to members who have joined selected networks only.',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No',
            ),
            'value' => 0,
      ));
      $this->addElement('Text', 'course_count', array(
            'label' => 'Maximum Allowed Courses',
            'description' => 'Enter the maximum number of allowed Courses to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
            'class' => $class,
            'validators' => array(
                array('Int', true),
            ),
            'value' => 10,
      ));
      $this->addElement('Text', 'lecture_count', array(
          'label' => 'Maximum Allowed Lectures',
          'description' => 'Enter the maximum number of allowed Lectures to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
          ),
          'value' => 10,
      ));
      $this->addElement('Text', 'test_count', array(
          'label' => 'Maximum Allowed Tests',
          'description' => 'Enter the maximum number of allowed Tests to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
          ),
          'value' => 10,
      ));
      $this->addElement('Radio', 'addwishlist', array(
            'label' => 'Allow Adding Course to Wishlist?',
            'description' => 'Do you want to let members of this level to add Courses to their wishlists on your website?',
            'multiOptions' => array(
                1 => 'Yes, allow members to add Courses to their wishlists.',
                0 => 'No, do not allow members to add Courses to their wishlists',
            ),
            'value' => 1,
      ));
      $this->addElement('Text', 'addwishlist_max', array(
            'label' => 'Maximum Allowed Wishlists',
            'description' => 'Enter the maximum number of wishlists a member of this level can create. The field must contain an integer, use zero (0) for unlimited.',
            'validators' => array(
                array('Int', true),
                new Engine_Validate_AtLeast(0),
            ),
            'value'=>10
      ));
//       $this->addElement('Radio', 'lecture_adwlst', array(
//             'label' => 'Allow Adding Lecture to Savelist?',
//             'description' => 'Do you want to let members of this level to add Lectures to their Savelists on your website?',
//             'multiOptions' => array(
//                 1 => 'Yes, allow members to add Lectures to their savelists.',
//                 0 => 'No, do not allow members to add Lectures to their savelists',
//             ),
//             'value' => 0,
//       ));
//       $this->addElement('Text', 'lecture_adwlst_m', array(
//             'label' => 'Maximum Allowed Lecture savelists',
//             'description' => 'Enter the maximum number of savelists a member of this level can create. The field must contain an integer, use zero (0) for unlimited.',
//             'validators' => array(
//                 array('Int', true),
//                 new Engine_Validate_AtLeast(0),
//             ),
//             'value'=>0
//       ));
//       $this->addElement('Radio', 'test_adwlst', array(
//             'label' => 'Allow Adding Test to Savelist?',
//             'description' => 'Do you want to let members of this level to add Tests to their Savelists on your website?',
//             'multiOptions' => array(
//                 1 => 'Yes, allow members to add Tests to their savelists.',
//                 0 => 'No, do not allow members to add Tests to their savelists',
//             ),
//             'value' => 0,
//       ));
//       $this->addElement('Text', 'test_adwlst_m', array(
//             'label' => 'Maximum Allowed Lecture savelists',
//             'description' => 'Enter the maximum number of savelists a member of this level can create. The field must contain an integer, use zero (0) for unlimited.',
//             'validators' => array(
//                 array('Int', true),
//                 new Engine_Validate_AtLeast(0),
//             ),
//             'value'=>0
//       ));

      /* Lecture Settings */
      $this->addElement('Radio', 'lec_create', array(
          'label' => 'Allow to Create Lecture?',
          'description' => 'Do you want to allow users to Create New Lecture? When Yes selected then at user-end Create New Lecture will display and when No selected then no link will display to Create New Lecture.',
          'multiOptions' => array(1 => 'Yes',0 => 'No',
          ),
          'value' =>1,
      ));
      $this->addElement('Radio', 'lec_edit', array(
          'label' => 'Allow to Edit Lecture?',
          'description' => 'Do you want to allow users to edit their Lectures? When Yes selected then “Edit Lecture” tab display after creating Lecture on top of its form and disable when No selected',
          'multiOptions' => array(1 => 'Yes',0 => 'No',
          ),
          'value' =>1,
      ));
      $this->addElement('Radio', 'lec_delete', array(
          'label' => 'Allow to Delete Lecture?',
          'description' => 'Do you want to allow users to delete their Lectures?',
          'multiOptions' => array(1 => 'Yes',0 => 'No',
          ),
          'value' =>1,
      ));

      /* Test Settings */
      $this->addElement('Radio', 'test_create', array(
          'label' => 'Allow to Create Test?',
          'description' => 'Do you want to allow users to create a Test? When Yes selected then at user-end Create Test link will display and when No selected then no link will display to create Test',
          'multiOptions' => array(1 => 'Yes',0 => 'No',
          ),
          'value' =>1,
      ));
      $this->addElement('Radio', 'test_edit', array(
          'label' => 'Allow to Edit Test?',
          'description' => 'Do you want to allow users to edit their Test? When Yes selected then “Edit Test” tab display after creating Test on top of its form and disable when No selected',
          'multiOptions' => array(1 => 'Yes',0 => 'No',
          ),
          'value' =>1,
      ));
      $this->addElement('Select', 'course_admincomn', array(
          'label' => 'Unit for Commission in Course',
          'description' => 'Change the unit for admin commission.',
          'multiOptions' => array(
              1 => 'Percentage',
              0 => 'Fixed'
          ),
          'allowEmpty' => false,
          'required' => true,
          'value' => 1,
      ));
      $this->addElement('Text', "course_comission", array(
          'label' => 'Commission Value',
          'description' => "Enter the value for commission according to the unit chosen in above setting. [If you have chosen Percentage, then value should be in the range 1 to 100.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => 10,
      ));
      $this->addElement('Text', "course_threshold", array(
          'label' => 'Threshold Amount for Releasing Payment',
          'description' => "Enter the threshold amount which will be required before making the request for releasing payment from admins.",
          'allowEmpty' => false,
          'required' => true,
          'value' => 100,
      ));
    }
  }
}
