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
class Courses_Form_Admin_Classroom_Level extends Authorization_Form_Admin_Level_Abstract {
  public function init() {
    parent::init();
    // My stuff
    $this->setTitle('Classroom Member Level Settings')
            ->setDescription('These settings are applied as per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level from below.');
    if (CLASSROOMPACKAGE == 1) {
      $class = 'classpackage';
    } else {
      $class = '';
    }
    // Element: view
    $this->addElement('Radio', 'view', array(
        'label' => 'Allow Viewing of Classroom?',
        'description' => 'Do you want to let users to view Classroom? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
            2 => 'Yes, allow members to view all Classroom, even private ones.',
            1 => 'Yes, allow members to view their own Classroom.',
            0 => 'No, do not allow Classroom to be viewed.',
        ),
        'value' => ($this->isModerator() ? 2 : 1),
    ));
    if (!$this->isModerator()) {
      unset($this->view->options[2]);
    }
    // Element: create
    $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Classroom?',
        'description' => 'Do you want to allow users to create Classrooms? If set to “No”, some other settings on this page may not apply. This is useful when you want certain levels only to be able to create Classroom. If this setting is chosen “Yes” for Public Member level, then when a public users click on "Create New Classroom" option, they will see Authorization Popup to Login or Sign-up on your website.',
        'multiOptions' => array(
            1 => 'Yes, allow creation of Classroom',
            0 => 'No, do not allow to create Classroom.',
        ),
        'value' => 1,
    ));
    if (!$this->isPublic()) {
      // Element: edit
      $this->addElement('Radio', 'edit', array(
          'label' => 'Allow Editing of Classroom',
          'description' => 'Do you want to let members edit Classroom?',
          'multiOptions' => array(
              2 => "Yes, allow members to edit everyone's Classroom.",
              1 => "Yes, allow members to edit their own Classroom.",
              0 => "No, do not allow Classroom to be edited.",
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->edit->options[2]);
      }
      // Element: delete
      $this->addElement('Radio', 'delete', array(
          'label' => 'Allow Deletion of Classroom',
          'description' => 'Do you want to let members delete Classroom?',
          'multiOptions' => array(
              2 => 'Yes, allow members to delete all Classroom.',
              1 => 'Yes, allow members to delete their own Classroom.',
              0 => 'No, do not allow members to delete their Classroom.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->delete->options[2]);
      }
      // Element: comment
      $this->addElement('Radio', 'comment', array(
          'label' => 'Allow Commenting on Classroom?',
          'description' => 'Do you want to let members of this level comment on Classroom? If this setting is chosen Yes for Public Member level, then when a public users click on Like or Comment option, they will see Authorization Popup to Login or Sign-up on your website.',
          'multiOptions' => array(
              2 => 'Yes, allow members to comment on all Classrooms, including private ones.',
              1 => 'Yes, allow members to comment on Classrooms.',
              0 => 'No, do not allow members to comment on Classrooms.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->comment->options[2]);
      }
      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
          'label' => 'Classroom View Privacy',
          'description' => 'Your users can choose any of the options from below, whom they want can see their Classroom. If you do not check any option, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'everyone' => 'Everyone',
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Classroom Admins'
          ),
          'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner'),
      ));
      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
          'label' => 'Classroom Comment Options',
          'description' => 'Your users can choose any of the options from below whom they want can post to their Classroom. If you do not check any options, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Classroom Admins',
              'member' => 'Classroom Members Only',
          ),
          'value' => array('registered','owner_network','owner_member_member','owner_member','owner','member'),
      ));
      $this->addElement('Radio', 'allow_network', array(
          'label' => 'Allow to choose "Classroom View Privacy Based on Networks"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Classrooms based on Networks on your website? If you choose Yes, then users will be able to choose the visibility of their Classrooms to members who have joined selected Networks only.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'allow_mlocation', array(
          'label' => 'Allow to Add Multiple Locations',
          'description' => 'Do you want to allow members of this level to add multiple locations for their  Classrooms? This setting will only work if you have enabled Location from Global Settings of this plugin. If you choose Yes, then members will be able to enter multiple locations from dashboard of their Classrooms.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_claim', array(
          'label' => 'Allow to Claim Classrooms',
          'description' => 'Do you want to allow members of this level to Claim Classrooms on your website? If this setting is chosen Yes for Public Member level, then when a public users click on Claim option, they will see Authorization Popup to Login or Sign-up on your website.',
          'class' => '',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
			$this->addElement('Radio', 'auth_close', array(
          'label' => 'Allow to Manage “Operating Hours” and “Close Classroom”',
          'description' => 'Do you want to allow members of this level to manage Operating Hours for their Classrooms? If you choose yes, then members will be able to enter the Operating hours details from dashboard of their Classrooms. They can also choose to close their Classroom permanently using this feature.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_linkbusines', array(
          'label' => 'Allow to Add Linked Classrooms',
          'description' => 'Do you want to allow members of this level to add Linked Classrooms to their Classrooms on your website? If you choose Yes, then members will be able to add Linked Classrooms from dashboard of their Classrooms.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
//       $this->addElement('Radio', 'auth_crosspost', array(
//           'label' => 'Enable Crossposting in Classrooms',
//           'description' => 'Do you want to enable Crosspost feature for the Classrooms created by members of this level? (If Crossposting is enabled and members have added any Classrooms for Crossposting, then the post added to their Classrooms will be automatically published to all other Classrooms added for crossposting. For crosspost, a request will be sent to owners of Classrooms being added and once owners approve the requests, Crossposting between Classrooms will be enabled.) If you choose Yes, then members will be able to add Classrooms for the Crosspost from dashboard of their Classrooms.',
//           'class' => $class,
//           'multiOptions' => array(
//               1 => 'Yes',
//               0 => 'No',
//           ),
//           'value' => 0,
//       ));
      $this->addElement('Radio', 'auth_contactgp', array(
          'label' => 'Enable Contact Classrooms Members',
          'description' => 'Do you want to enable the "Contact Classrooms Members" functionality for the Classrooms created by the members of this level? If you choose yes, then members will be able to contact their Classroom members from dashboard of their Classroom.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'upload_cover', array(
          'label' => 'Allow to Upload Classroom Cover Photo',
          'description' => 'Do you want to allow members of this member level to upload cover photo for their Classrooms. If set to No, then the default cover photo will get displayed instead which you can choose in settings below.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'upload_mainphoto', array(
          'label' => 'Allow to Upload Classroom Main Photo',
          'description' => 'Do you want to allow members of this member level to upload main photo for their Classroom. If set to No, then the default main photo will get displayed instead which you can choose in settings below.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_bsstyle', array(
          'label' => 'Allow to Choose Classroom Profile Design Views',
          'description' => 'Do you want to enable members of this level to choose designs for their Classroom Profiles? (If you choose No, then you can choose a default layout for the Classroom Profiles on your website. But, if you choose Yes, then you can choose which all designs will be allowed for selection in Classroom dashboards.)',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('MultiCheckbox', 'select_bsstyle', array(
          'label' => 'Select Classroom Profile Designs',
          'description' => 'Select Classroom profile designs which will be available to members while creating or editing their Classrooms.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Template 1',
              2 => 'Template 2',
              3 => 'Template 3',
              4 => 'Template 4',
          ),
          'value' => array(1,2,3,4),
      ));
      // Element: auth_view
      $this->addElement('Radio', 'bs_style_type', array(
          'label' => 'Default Classroom Profile Design',
          'description' => 'Choose the default profile design for Classroom created by members of this member level.',
          'class' => $class,
          'multiOptions' => array(
              '1' => 'Template 1',
              '2' => 'Template 2',
              '3' => 'Template 3',
              '4' => 'Template 4'
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
      //classroom main photo
      if (count($default_photos) > 0) {
        $this->addElement('Select', 'watermark_photo', array(
            'label' => 'Add Watermark to Classroom Main Photos',
            'description' => 'Choose a photo which you want to add as watermark on the main photos of Classroom upload by members of this level on your website. [Note: You can add a new photo from the "File & Media Manager" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'watermark_cphoto', array(
            'label' => 'Add Watermark to Classroom Cover Photos',
            'description' => 'Choose a photo which you want to add as the watermark on the cover photos of  Classroom uploads by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'bsdefaultphoto', array(
            'label' => 'Default Main Photo for Classroom',
            'description' => 'Choose the main default photo for the Classroom created by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'defaultCphoto', array(
            'label' => 'Default Cover Photos for Classroom',
            'description' => 'Choose default cover photo for the Classroom created by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
      } else {
        $description = "<div class='tip'><span>" . 'There are currently no photo in the File & Media Manager. Please upload the Photo to be chosen from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manage</a>" section.' . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'watermark_photo', array(
            'label' => 'Default Watermark Photo for Classroom Main Photo',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'watermark_cphoto', array(
            'label' => 'Default Watermark Photo for Classroom Cover Photo',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'bsdefaultphoto', array(
            'label' => 'Default Main Photo for Classroom',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'defaultCphoto', array(
            'label' => 'Choose default cover photo for Classroom on your website.',
            'description' => $description,
            'class' => $class,
        ));
      }
      $this->watermark_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->watermark_cphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->bsdefaultphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->defaultCphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->addElement('Radio', 'auth_subclass', array(
        'label' => 'Allow to Create Sub Classroom',
        'description' => 'Do you want to allow members of this level to create Sub Classroom in their own Classroom? If you choose Yes, then members will be able to add Classroom from the "Create Sub Classroom" setting in Options Menus on their Classroom. Only 1 level of Sub Classroom can be created in a Classroom.Note: when parent Classroom deleted then sub classroom will also delete.',
        'class' => $class,
        'multiOptions' => array(1 => 'Yes',0 => 'No'),
        'value' => 0,
      ));
      $this->addElement('Radio', 'cls_approve', array(
          'description' => 'Do you want Classrooms created by members of this level to be auto-approved? If you choose No, then you can manually approve Classrooms from Manage Classrooms section of this plugin.',
          'label' => 'Auto Approve Classroom',
          'multiOptions' => array(
              1 => 'Yes, auto-approve Classrooms.',
              0 => 'No, do not auto-approve Classrooms.'
          ),
          'class' => $class,
          'value' => 1,
      ));
      //element for classroom featured
      $this->addElement('Radio', 'bs_featured', array(
          'description' => 'Do you want Classroom created by members of this level to be automatically marked as Featured? If you choose No, then you can manually mark Classroom as Featured from Manage Classroom section of this plugin.',
          'label' => 'Automatically Mark Classroom as Featured.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for classroom sponsored
      $this->addElement('Radio', 'bs_sponsored', array(
          'description' => 'Do you want Classroom created by members of this level to be automatically marked as Sponsored? If you choose No, then you can manually mark Classroom as Sponsored from Manage Classroom section of this plugin.',
          'label' => 'Automatically Mark Classroom as Sponsored.',
          'multiOptions' => array(1 => 'Yes',0 => 'No'),
          'class' => $class,
          'value' => 0,
      ));
      //element for classroom verified
      $this->addElement('Radio', 'bs_verified', array(
          'description' => 'Do you want Classroom created by members of this level to be automatically marked as Verified? If you choose No, then you can manually mark Classroom as Verified from Manage Classroom section of this plugin.',
          'label' => 'Automatically Mark Classroom as Verified',
          'multiOptions' => array(1 => 'Yes',0 => 'No'),
          'class' => $class,
          'value' => 0,
      ));
      //element for classroom verified
      $this->addElement('Radio', 'classroom_hot', array(
          'description' => 'Do you want Classroom created by members of this level to be automatically marked as Verified? If you choose No, then you can manually mark Classroom as Verified from Manage Classroom section of this plugin.',
          'label' => 'Automatically Mark Classroom as Hot',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Classrooms as Hot',
              0 => 'No, do not automatically mark Classrooms as Hot',
          ),
          'class' => $class,
          'value' => 0,
      ));

//       $this->addElement('Radio', 'classroom_new', array(
//           'description' => 'Do you want Classroom created by members of this level to be automatically marked as New? If you choose No, then Classroom will not be marked as New on your website. But, if you choose No, then you can choose the duration until which Classroom will be marked as New on your website.',
//           'label' => 'Automatically Mark Classroom as New',
//           'multiOptions' => array(
//               1 => 'Yes, automatically mark Classrooms as New',
//               0 => 'No, do not automatically mark Classrooms as New',
//           ),
//           'class' => $class,
//           'value' => 0,
//       ));
//       $this->addElement('Text', 'newBsduration', array(
//           'label' => 'Duration for Classrooms Marked as New',
//           'description' => 'Enter the number of days upto which Classroom created by members of this level will be shown as New from their date of creation on your website.',
//           'class' => $class,
//           'validators' => array(
//               array('Int', true),
//               new Engine_Validate_AtLeast(1),
//           ),
//           'value' => 2,
//       ));

      $this->addElement('Radio', 'classroom_seo', array(
			    'label' => 'Enable SEO fields',
          'description' => 'Do you want to enable the "SEO" fields for the Classroom created by members of this level? If you choose Yes, then members will be able to enter the details from the dashboard of their Classroom.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'bs_overview', array(
          'description' => 'Do you want to enable the "Overview" field for the Classroom created by members of this level? If you choose Yes, then members will be able to enter the details from the dashboard of their Classroom.',
          'label' => 'Enable Overview',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));

      $this->addElement('Radio', 'seb_attribution', array(
        'description' => "Do you want to enable 'Post Attribution' for the Classroom owned and managed (Click here to configure Classroom Roles to enable members to become Classroom managers.) by members of this level? If you choose Yes, then posts from activity feed will be posted as the name of Classroom instead of Classroom owners' names. Choosing Yes will also enable you to allow Classroom admins and managers to select default Attribution for Classroom to post as Classroom Name or their Own Name. This Setting will affect on new content only.
        (Note: This feature is dependent on 'Advanced News & Activity Feeds Plugin' and requires the ‘Advanced Activity Feeds’ widget to be placed on the Classroom View page.)",
          'label' => "Enable Post Attribution in Classroom (Post as Classroom Name)",
          'multiOptions' => array(
              1 => 'Yes, if you want posts on Classroom as Classroom Names or User Names.',
              0 => 'No, if you want to post on Classroom as User Names only.',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->getElement('seb_attribution')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $this->addElement('Radio', 'auth_defattribut', array(
          'description' => 'Do you want to allow members of this level to choose default "Post Attribution" for Classroom they own and manage? If you choose Yes, then members will be able to choose the default attribution from dashboard of Classroom If you choose No, then they will not be able to choose the attribution and default attribution will be set to Post as Classroom Name. They will be able to switch the attribution in Status Updates, Likes and Comments if the setting below for switching attribution is enabled.',
          'label' => 'Allow to Choose Post Attribution in Classroom',
          'multiOptions' => array(
              1 => 'Yes, if you want posts on Classroom as Classroom Names or User Names',
              0 => 'No, if you want to post on Classroom as User Names only.',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', "auth_contSwitch", array(
          'label' => 'Allow Post Attribution Switching in Status Updates, Likes & Comments',
          'description' => 'Do you want to allow members to switch between Classroom they own or manage (Click here to configures Classroom Roles to enable members to become Classroom managers.) and their personal account to Post status updates, Like and Comments on Classrooms they own and manage?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->getElement('auth_contSwitch')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $this->addElement('Radio', 'bgphoto', array(
			'label' => 'Enable Background Photo',
          'description' => 'Do you want to enable the "Background Photo" functionality for the Classroom created by members of this member level? If you choose Yes, then members will be able to upload the photo from dashboard of their Classroom.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'bs_contactinfo', array(
			'label' => 'Enable Contact Info',
          'description' => 'Do you want to enable the "Contact Info" functionality for the Classroom created by members of this member level? If you choose Yes, then members will be able to enter the contact details from the dashboard of their Classroom.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'bs_edit_style', array(
			'label' => 'Enable Edit Style',
          'description' => 'Do you want to enable "Edit CSS Style" for the Classroom created by members of this level? If you choose Yes, then members will be able to edit the CSS Style from dashboard of their Classroom.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
       $this->addElement('Radio', 'service', array(
           'label' => 'Enable Classroom Service',
           'description' => 'Do you want to enable Classroom Service for the Classroom created by the members of this level? If yes selected then in Dashboard user will create services.',
           'multiOptions' => array(1 => 'Yes',0 => 'No'),
           'value' => 1,
       ));
      // Element: album
      $this->addElement('Radio', 'album', array(
          'label' => 'Allow Albums Upload in Classroom?',
          'description' => 'Do you want to let members of this level upload albums in Classrooms? If you choose Yes, then members will be able to create and edit albums & upload photos from "Classroom Profile Photo Albums" widget placed on Classroom Profiles.',
          'multiOptions' => array(
              2 => 'Yes, allow members to upload albums on Classroom, including private ones.',
              1 => 'Yes, allow members to upload albums in Classroom.',
              0 => 'No, do not allow members to upload albums in Classroom.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->album->options[2]);
      }
      // Element: auth_photo
      $this->addElement('MultiCheckbox', 'auth_album', array(
          'label' => 'Album Upload Options',
          'description' => 'Your users can choose from any of the options checked below when they decide who can upload albums to their Classrooms. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Classroom Admins',
              'member'=> 'Classroom Members Only',
          ),
          'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner','member'),
      ));
      $this->addElement('Radio', 'auth_announce', array(
          'label' => 'Allow to Manage Announcements',
          'description' => 'Do you want to allow members of this level to manage announcements in their Classrooms on your website? If you choose Yes, then members will be able to create, edit and manage announcements from dashboard of their Classroom.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'bs_allow_roles', array(
          'label' => 'Allow to Manage Classroom Roles',
          'description' => 'Do you want to allow members of this level to manage Roles in their Classroom on your website? If you choose Yes, then members will be able to manage Roles from dashboard of their Classroom.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_insightrpt', array(
          'label' => 'Allow to View Insights & Reports',
          'description' => 'Do you want to allow members of this level to view Insights and Reports of their Classroom on your website? If you choose Yes, then members will be able to view insights and reports from dashboard of their Classroom.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));  
      $this->addElement('Radio', 'auth_addbutton', array(
          'label' => 'Allow to "Call to Action Button" ',
          'description' => 'Do you want to allow members of this level to add a call to action button to their Classroom on your website? If you choose Yes, then members will be able to add the button from their Classroom Profiles. You can enable / disable this option from the "Classroom Profile - Cover Photo, Details & Options" widget from Layout Editor.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Text', 'classroom_count', array(
          'label' => 'Maximum Allowed Classroom',
          'description' => 'Enter the maximum number of allowed Classrooms to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
          ),
          'value' => 10,
      ));
      $this->addElement('Text', 'bs_album_count', array(
          'label' => 'Maximum Allowed Classroom Albums',
          'description' => 'Enter the maximum number of allowed Classroom Albums to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
          ),
          'value' => 10,
      ));


        //commission
       // $this->addElement('Select', 'cls_admincomn', array(
         //   'label' => 'Unit for Commission in Classroom',
           // 'description' => 'Change the unit for admin commission.',
            //'multiOptions' => array(
              //  1 => 'Percentage',
                //0 => 'Fixed'
            //),
            //'allowEmpty' => false,
            //'required' => true,
            //'value' => 1,
        //));
        //$this->addElement('Text', "cls_comission", array(
          //  'label' => 'Commission Value',
            //'description' => "Enter the value for commission according to the unit chosen in above setting. [If you have chosen Percentage, then value should be in the range 1 to 100.]",
            //'allowEmpty' => true,
            //'required' => false,
            //'value' => 0,
        //));
        //$this->addElement('Text', "cls_threshold", array(
          //  'label' => 'Threshold Amount for Releasing Payment',
            //'description' => "Enter the threshold amount which will be required before making the request for releasing payment from admins.",
            //'allowEmpty' => false,
            //'required' => true,
            //'value' => 100,
        //));

    }
    $this->addElement('Radio', 'bs_can_join', array(
        'label' => 'Allow to Join Classrooms ?',
        'description' => 'Do you want to allow members of this level to Join Classrooms on your website? If you choose Yes, then members will see Join button in various widgets and places on your website. If this setting is chosen Yes for Public Member level, then when a public users click on the Join button, they will see Authorization Popup to Login or Sign-up on your website.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));
  }

}
