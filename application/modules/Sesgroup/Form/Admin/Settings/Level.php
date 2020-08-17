<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Member Level Settings')
            ->setDescription('These settings are applied as per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level from below.');
    if (SESGROUPPACKAGE == 1) {
      $class = 'group_package';
    } else {
      $class = '';
    }
    // Element: view
    $this->addElement('Radio', 'view', array(
        'label' => 'Allow Viewing of Groups?',
        'description' => 'Do you want to let users to view Groups? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
            2 => 'Yes, allow members to view all Groups, even private ones.',
            1 => 'Yes, allow members to view their own Groups.',
            0 => 'No, do not allow Groups to be viewed.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if (!$this->isModerator()) {
      unset($this->view->options[2]);
    }

    // Element: create
    $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Groups?',
        'description' => 'Do you want to allow users to create Groups? If set to no, some other settings on this page may not apply. This is useful when you want certain levels only to be able to create Groups. If this setting is chosen Yes for Public Member level, then when a public users click on "Create New Group" option, they will see Authorization Popup to Login or Sign-up on your website.',
        'multiOptions' => array(
            1 => 'Yes, allow creation of Groups.',
            0 => 'No, do not allow Groups to be created.',
        ),
        'value' => 1,
    ));
    if (!$this->isPublic()) {
      // Element: edit
      $this->addElement('Radio', 'edit', array(
          'label' => 'Allow Editing of Groups?',
          'description' => 'Do you want to let members edit Groups?',
          'multiOptions' => array(
              2 => "Yes, allow members to edit everyone's Groups.",
              1 => "Yes, allow  members to edit their own Groups.",
              0 => "No, do not allow Groups to be edited.",
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
          'label' => 'Allow Deletion of Groups?',
          'description' => 'Do you want to let members delete Groups? If set to no, some other settings on this page may not apply.',
          'multiOptions' => array(
              2 => 'Yes, allow members to delete all Groups.',
              1 => 'Yes, allow members to delete their own Groups.',
              0 => 'No, do not allow members to delete their Groups.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->delete->options[2]);
      }

      // Element: comment
      $this->addElement('Radio', 'comment', array(
          'label' => 'Allow Commenting on Groups?',
          'description' => 'Do you want to let members of this level comment on Groups? If this setting is chosen Yes for Public Member level, then when a public users click on Like or Comment option, they will see Authorization Popup to Login or Sign-up on your website.',
          'multiOptions' => array(
              2 => 'Yes, allow members to comment on all Groups, including private ones.',
              1 => 'Yes, allow members to comment on Groups.',
              0 => 'No, do not allow members to comment on Groups.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->comment->options[2]);
      }
      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
          'label' => 'Group View Privacy',
          'description' => 'Your users can choose any of the options from below, whom they want can see their Groups. If you do not check any option, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'everyone' => 'Everyone',
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Group Admins'
          ),
          'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner'),
      ));

      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
          'label' => 'Group Comment Options',
          'description' => 'Your users can choose any of the options from below whom they want can post to their Groups. If you do not check any options, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Group Admins',
              'member' => 'Group Members Only',
          ),
          'value' => array('registered','owner_network','owner_member_member','owner_member','owner','member'),
      ));
      $this->addElement('Radio', 'allow_network', array(
          'label' => 'Allow to choose "Group View Privacy Based on Networks"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Groups based on Networks on your website? If you choose Yes, then users will be able to choose the visibility of their Groups to members who have joined selected networks only.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', "enable_price", array(
          'label' => 'Enable Price',
          'description' => "Do you want to enable Price for the Groups created by members of this level? If you choose Yes, then members will be able to enter price from dashboard of their Groups.",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', "price_mandatory", array(
          'label' => 'Make Group Price Mandatory',
          'description' => "Do you want to make Price field mandatory when users create or edit their Groups?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "can_chooseprice", array(
          'label' => 'Allow Owners to Select Price Type',
          'description' => "Do you want to allow owners of Groups to select the price type for their Groups?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "default_prztype", array(
          'label' => 'Default Price Type',
          'description' => "Choose a Default Price Type for the Groups on your website. This type will be shown with the price of Groups on your website and will be an indicator of whether the Group has the Price or the Starting Price of various products, services, etc of that Group.",
          'multiOptions' => array(
              '1' => 'Show "Price"',
              '2' => 'Show "Starting Price"',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_claim', array(
          'label' => 'Allow to Claim Groups',
          'description' => 'Do you want to allow members of this level to Claim Groups on your website? If this setting is chosen Yes for Public Member level, then when a public users click on Claim option, they will see Authorization Popup to Login or Sign-up on your website.',
          'class' => '',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'allow_mlocation', array(
          'label' => 'Allow to Add Multiple Locations',
          'description' => 'Do you want to allow members of this level to add multiple locations for their Groups? This setting will only work if you have enabled Location from Global Settings of this plugin. If you choose Yes, then members will be able to enter multiple locations from dashboard of their Groups.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_close', array(
          'label' => 'Allow to Manage “Operating Hours” and “Close Group”',
          'description' => 'Do you want to allow members of this level to manage Operating Hours for their Groups? If you choose yes, then members will be able to enter the operating hours details from dashboard of their Groups. They can also choose to Close their Group permanently using this feature.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'auth_linkgroup', array(
          'label' => 'Allow to Add Linked Groups',
          'description' => 'Do you want to allow members of this level to add Linked Groups to their Groups on your website? If you choose Yes, then members will be able to add Linked Groups from dashboard of their Groups.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_crosspost', array(
          'label' => 'Enable Crossposting in Groups',
          'description' => 'Do you want to enable Crosspost feature for the Groups created by members of this level? (If Crossposting is enabled and members have added any Groups for crossposting, then the post added to their Groups will be automatically published to all other Groups added for crossposting. For crosspost, a request will be sent to owners of Groups being added and once owners approve the requests, crossposting between Groups will be enabled.) If you choose Yes, then members will be able to add Groups for crossposting from dashboard of their Groups.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'auth_contactgp', array(
          'label' => 'Enable Contact Group Members',
          'description' => 'Do you want to enable the "Contact Group Members" functionality for the Groups created by the members of this level? If you choose yes, then members will be able to contact their Group members from dashboard of their Groups.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'upload_cover', array(
          'label' => 'Allow to Upload Group Cover Photo',
          'description' => 'Do you want to allow members of this member level to upload cover photo for their Groups. If set to No, then the default cover photo will get displayed instead which you can choose in settings below.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'upload_mainphoto', array(
          'label' => 'Allow to Upload Group Main Photo',
          'description' => 'Do you want to allow members of this member level to upload main photo for their Groups. If set to No, then the default main photo will get displayed instead which you can choose in settings below.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_groupstyle', array(
          'label' => 'Allow to Choose Group Profile Design Views',
          'description' => 'Do you want to enable members of this level to choose designs for their Group Profiles? (If you choose No, then you can choose a default layout for the Group Profiles on your website. But, if you choose Yes, then you can choose which all designs will be allowed for selection in Group dashboards.)',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('MultiCheckbox', 'select_gpstyle', array(
          'label' => 'Select Group Profile Designs',
          'description' => 'Select Group profile designs which will be available to members while creating or editing their Groups.',
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
      $this->addElement('Radio', 'group_style_type', array(
          'label' => 'Default Group Profile Design',
          'description' => 'Choose the default profile design for Groups created by members of this member level.',
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
      //group main photo
      if (count($default_photos) > 0) {
        $this->addElement('Select', 'watermark_photo', array(
            'label' => 'Add Watermark to Group Main Photos',
            'description' => 'Choose a photo which you want to add as watermark on the main photos of Groups upload by members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'watermark_cphoto', array(
            'label' => 'Add Watermark to Group Cover Photos',
            'description' => 'Choose a photo which you want to add as watermark on the cover photos of Groups upload by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'gpdefaultphoto', array(
            'label' => 'Default Main Photo for Groups',
            'description' => 'Choose main default photo for the Groups created by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'defaultCphoto', array(
            'label' => 'Default Cover Photo for Groups',
            'description' => 'Choose default cover photo for the Groups created by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
      } else {
        $description = "<div class='tip'><span>" . 'There are currently no photo in the File & Media Manager. Please upload the Photo to be chosen from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manage</a>" section.' . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'watermark_photo', array(
            'label' => 'Default Watermark Photo for Group Main Photo',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'watermark_cphoto', array(
            'label' => 'Default Watermark Photo for Group Cover Photo',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'gpdefaultphoto', array(
            'label' => 'Default Main Photo for Groups',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'defaultCphoto', array(
            'label' => 'Choose default cover photo for Groups on your website.',
            'description' => $description,
            'class' => $class,
        ));
      }
      $this->gpdefaultphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->defaultCphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->watermark_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->watermark_cphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->addElement('Radio', 'auth_subgroup', array(
          'label' => 'Allow to Create Associated Sub Groups',
          'description' => 'Do you want to allow members of this level to create Associated sub Groups in their own Groups? If you choose Yes, then members will be able to add Associated-Groups from the "Create Associated Sub Group" setting in Options Menus on their Group. Only 1 level of Associated Sub Groups can be created in a Group.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));

      $this->addElement('Radio', 'group_approve', array(
          'description' => 'Do you want Groups created by members of this level to be auto-approved? If you choose No, then you can manually approve Groups from Manage Groups section of this plugin.',
          'label' => 'Auto Approve Groups',
          'multiOptions' => array(
              1 => 'Yes, auto-approve Groups.',
              0 => 'No, do not auto-approve Groups.'
          ),
          'class' => $class,
          'value' => 1,
      ));
      //element for group featured
      $this->addElement('Radio', 'group_featured', array(
          'description' => 'Do you want Groups created by members of this level to be automatically marked as Featured? If you choose No, then you can manually mark Groups as Featured from Manage Groups section of this plugin.',
          'label' => 'Automatically Mark Groups as Featured',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Groups as Featured',
              0 => 'No, do not automatically mark Groups as Featured',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for group sponsored
      $this->addElement('Radio', 'group_sponsored', array(
          'description' => 'Do you want Groups created by members of this level to be automatically marked as Sponsored? If you choose No, then you can manually mark Groups as Sponsored from Manage Groups section of this plugin.',
          'label' => 'Automatically Mark Groups as Sponsored',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Groups as Sponsored',
              0 => 'No, do not automatically mark Groups as Sponsored',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for group verified
      $this->addElement('Radio', 'group_verified', array(
          'description' => 'Do you want Groups created by members of this level to be automatically marked as Verified? If you choose No, then you can manually mark Groups as Verified from Manage Groups section of this plugin.',
          'label' => 'Automatically Mark Groups as Verified',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Groups as Verified',
              0 => 'No, do not automatically mark Groups as Verified',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for group verified
      $this->addElement('Radio', 'group_hot', array(
          'description' => 'Do you want Groups created by members of this level to be automatically marked as Hot? If you choose No, then you can manually mark Groups as Hot from Manage Groups section of this plugin.',
          'label' => 'Automatically Mark Groups as Hot',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Groups as Hot',
              0 => 'No, do not automatically mark Groups as Hot',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Radio', 'group_new', array(
          'description' => 'Do you want Groups created by members of this level to be automatically marked as New? If you choose No, then Groups will not be marked as New on your website. But, if you choose No, then you can choose the duration until which Groups will be marked as New on your website.',
          'label' => 'Automatically Mark Groups as New',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Groups as New',
              0 => 'No, do not automatically mark Groups as New',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Text', 'newGroupduration', array(
          'label' => 'Duration for Groups Marked as New',
          'description' => 'Enter the number of days upto which Groups created by members of this level will be shown as New from their date of creation on your website.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
              new Engine_Validate_AtLeast(1),
          ),
          'value' => 2,
      ));
      $this->addElement('Radio', 'group_seo', array(
          'description' => 'Do you want to enable the "SEO" fields for the Groups created by members of this level? If you choose Yes, then members will be able to enter the details from dashboard of their Groups.',
          'label' => 'Enable SEO Fields',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'group_overview', array(
          'description' => 'Do you want to enable the "Overview" field for the Groups created by members of this level? If you choose Yes, then members will be able to enter the details from dashboard of their Groups.',
          'label' => 'Enable Overview',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));

      $this->addElement('Radio', 'gp_attribution', array(
          'description' => 'Do you want to enable "Post Attribution" for the Groups owned and managed (<a href="admin/sesgroup/settings/group-roles" target="_blank">Click here</a> to configure Group Roles to enable members to become Group managers.) by members of this level? If you choose Yes, then posts from activity feed will be posted as the name of Groups instead of Group owners\' names. Choosing Yes will also enable you to allow Group admins and managers to select default Attribution for Groups to post as Group Name or their Own Name. This Setting will affect on new content only.',
          'label' => 'Enable Post Attribution in Groups (Post as Group Name)',
          'multiOptions' => array(
              1 => 'Yes, if you want posts on Groups as Group Names or User Names.',
              0 => 'No, if you want to posts on Groups as User Names only.',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->getElement('gp_attribution')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $this->addElement('Radio', 'auth_defattribut', array(
          'description' => 'Do you want to allow members of this level to choose default "Post Attribution" for Groups they own and manage? If you choose Yes, then members will be able to choose the default attribution from dashboard of Groups. If you choose No, then they will not be able to choose the attribution and default attribution will be set to Post as Group Name. They will be able to switch the attribution in Status Updates, Likes and Comments if the setting below for switching attribution is enabled.',
          'label' => 'Allow to Choose Post Attribution in Groups',
          'multiOptions' => array(
              1 => 'Yes, allow to choose Default Post Attribution.',
              0 => 'No, post as Group Name only.',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Radio', "auth_contSwitch", array(
          'label' => 'Allow Post Attribution Switching in Status Updates, Likes & Comments',
          'description' => 'Do you want to allow members to switch between Groups they own or manage (<a href="admin/sesgroup/settings/group-roles" target="_blank">Click here</a> to configures Group Roles to enable members to become Group managers.) and their personal account to Post status updates, Like and Comments on Groups they own and manage?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 0,
      ));
      $this->getElement('auth_contSwitch')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
      $this->addElement('Radio', 'defattribut', array(
          'description' => '',
          'label' => 'Default Attribution',
          'multiOptions' => array(
              1 => 'As User',
              0 => 'As Group',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Radio', 'group_bgphoto', array(
          'description' => 'Do you want to enable the "Background Photo" functionality for the Groups created by members of this member level? If you choose Yes, then members will be able to upload the photo from dashboard of their Groups.',
          'label' => 'Enable Background Photo',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'gp_contactinfo', array(
          'description' => 'Do you want to enable the "Contact Info" functionality for the Groups created by members of this member level? If you choose Yes, then members will be able to enter the contact details from dashboard of their Groups.',
          'label' => 'Enable Contact Info',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'gp_edit_style', array(
          'description' => 'Do you want to enable "Edit CSS Style" for the Groups created by members of this level? If you choose Yes, then members will be able to edit the CSS Style from dashboard of their Groups.',
          'label' => 'Enable Edit Style',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));

       $this->addElement('Radio', 'group_service', array(
           'label' => 'Enable Group Service',
           'description' => 'Do you want to enable Group Service for the Groups created by the members of this level?',
           'multiOptions' => array(
               1 => 'Yes',
               0 => 'No',
           ),
           'value' => 1,
       ));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesgroupteam')) {
      // Team enable permission
     $this->addElement('Radio', 'group_team', array(
         'label' => 'Enable Group Team',
         'description' => 'Do you want to enable Group Team for the Groups created by the members of this level?',
         'multiOptions' => array(
             1 => 'Yes',
             0 => 'No',
         ),
         'value' => 1,
     ));
     }
      // Element: album
      $this->addElement('Radio', 'album', array(
          'label' => 'Allow Albums Upload in Groups?',
          'description' => 'Do you want to let members of this level upload albums in Groups? If you choose Yes, then members will be able to create and edit albums & upload photos from "Group Communities - Group Profile Photo Albums" widget placed on Group Profiles.',
          'multiOptions' => array(
              2 => 'Yes, allow members to upload albums on Groups, including private ones.',
              1 => 'Yes, allow members to upload albums in Groups.',
              0 => 'No, do not allow members to upload albums in Groups.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->album->options[2]);
      }
      // Element: auth_photo
      $this->addElement('MultiCheckbox', 'auth_album', array(
          'label' => 'Album Upload Options',
          'description' => 'Your users can choose from any of the options checked below when they decide who can upload albums to their Groups. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Group Admins',
              'member'=> 'Group Members Only',
          ),
          'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner','member'),
      ));

        if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesgrouppoll')){

            // Element: poll
            $this->addElement('Radio', 'poll', array(
                'label' => 'Allow Polls Upload in Groups?',
                'description' => 'Do you want to let members of this level upload polls in Groups?',
                'multiOptions' => array(
                    2 => 'Yes, allow members to upload polls in Groups, including private ones.',
                    1 => 'Yes, allow members to upload polls in Groups.',
                    0 => 'No, do not allow members to upload polls in Groups.',
                ),
                'value' => ( $this->isModerator() ? 2 : 1 ),
            ));
            if (!$this->isModerator()) {
                unset($this->poll->options[2]);
            }
            // Element: auth_photo
            $this->addElement('MultiCheckbox', 'auth_poll', array(
                'label' => 'Poll Upload Options',
                'description' => 'Your users can choose from any of the options checked below when they decide who can upload Polls to their Groups. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
                'multiOptions' => array(
                    'registered' => 'Registered Members',
                    'owner_network' => 'Friends and Networks',
                    'owner_member_member' => 'Friends of Friends',
                    'owner_member' => 'Friends Only',
                    'owner' => 'Page Admins',
                    'member'=> 'Page Members Only',
                ),
                'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner','member'),
            ));
        }
      if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesgroupvideo')) {
        // Element: video
        $this->addElement('Radio', 'video', array(
            'label' => 'Allow Videos Upload in Groups?',
            'description' => 'Do you want to let members of this level upload videos in Groups?',
            'multiOptions' => array(
                2 => 'Yes, allow members to upload videos on Groups, including private ones.',
                1 => 'Yes, allow members to upload videos in Groups.',
                0 => 'No, do not allow members to upload videos in Groups.',
            ),
            'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
          unset($this->video->options[2]);
        }
        // Element: auth_photo
        $this->addElement('MultiCheckbox', 'auth_video', array(
            'label' => 'Video Upload Options',
            'description' => 'Your users can choose from any of the options checked below when they decide who can upload videos to their groups. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
            'multiOptions' => array(
                'everyone' => 'Everyone',
                'registered' => 'Registered Members',
                'owner_network' => 'Friends and Networks',
                'owner_member_member' => 'Friends of Friends',
                'owner_member' => 'Friends Only',
                'owner' => 'Group Admins'
            )
        ));
      }
      
      if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesgroupforum')) {
      
        // Element: forum
        $this->addElement('Radio', 'forum', array(
          'label' => 'Allow Topics Create in Groups?',
          'description' => 'Do you want to let members of this level create topics in Groups?',
          'multiOptions' => array(
            2 => 'Yes, allow members to create topics on Groups, including private ones.',
            1 => 'Yes, allow members to create topics in Groups.',
            0 => 'No, do not allow members to create topics in Groups.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
          unset($this->forum->options[2]);
        }
        
        // Element: auth_forum
        $this->addElement('MultiCheckbox', 'auth_forum', array(
          'label' => 'Topic Create Options',
          'description' => 'Your users can choose from any of the options checked below when they decide who can create topics to their groups. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
            'everyone' => 'Everyone',
            'registered' => 'Registered Members',
            'owner_network' => 'Friends and Networks',
            'owner_member_member' => 'Friends of Friends',
            'owner_member' => 'Friends Only',
            'owner' => 'Group Admins'
          )
        ));
      }
      
      $this->addElement('Radio', 'auth_announce', array(
          'label' => 'Allow to Manage Announcements',
          'description' => 'Do you want to allow members of this level to manage announcements in their Groups on your website? If you choose Yes, then members will be able to create, edit and manage announcements from dashboard of their Groups.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'gp_allow_rules', array(
          'label' => 'Allow to Manage Group Rules',
          'description' => 'Do you want to allow members of this level to manage Rules in their Groups on your website? If you choose Yes, then members will be able to manage Rules from dashboard of their Groups.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'gp_allow_roles', array(
          'label' => 'Allow to Manage Group Roles',
          'description' => 'Do you want to allow members of this level to manage Roles in their Groups on your website? If you choose Yes, then members will be able to manage Roles from dashboard of their Groups.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_changeowner', array(
          'label' => 'Allow to Transfer Ownership',
          'description' => 'Do you want to allow members of this level to transfer ownership of their Groups to other members on your website? If you choose Yes, then members will be able to transfer ownership from dashboard of their Groups.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_insightrpt', array(
          'label' => 'Allow to View Insights & Reports',
          'description' => 'Do you want to allow members of this level to view Insights and Reports of their Groups on your website? If you choose Yes, then members will be able to view insights and reports from dashboard of their Groups.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_addbutton', array(
          'label' => 'Allow to "Add a Button" ?',
          'description' => 'Do you want to allow members of this level to add a call to action button to their Groups on your website? If you choose Yes, then members will be able to add the button from their Group Profiles. You can enable / disable this option from the "Group Profile - Cover Photo, Details & Options" widget from Layout Editor.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Text', 'group_count', array(
          'label' => 'Maximum Allowed Groups',
          'description' => 'Enter the maximum number of allowed Groups to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
          ),
          'value' => 10,
      ));
      $this->addElement('Text', 'gp_album_count', array(
          'label' => 'Maximum Allowed Group Albums',
          'description' => 'Enter the maximum number of allowed Group Albums to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
          ),
          'value' => 10,
      ));
    }
    $this->addElement('Radio', 'group_can_join', array(
        'label' => 'Allow to Join Groups ?',
        'description' => 'Do you want to allow members of this level to Join Groups on your website? If you choose Yes, then members will see Join button in various widgets and places on your website. If this setting is chosen Yes for Public Member level, then when a public users click on Join button, they will see Authorization Popup to Login or Sign-up on your website.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));
  }

}
