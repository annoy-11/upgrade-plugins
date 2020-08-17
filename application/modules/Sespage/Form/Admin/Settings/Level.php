<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Member Level Settings')
            ->setDescription('These settings are applied as per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level from below.');
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespagepackage') /*&& Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepackage.enable.package', 0)*/) {
      $class = 'page_package';
    } else {
      $class = '';
    }
    // Element: view
    $this->addElement('Radio', 'view', array(
        'label' => 'Allow Viewing of Pages?',
        'description' => 'Do you want to let users to view Pages? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
            2 => 'Yes, allow members to view all Pages, even private ones.',
            1 => 'Yes, allow members to view their own Pages.',
            0 => 'No, do not allow Pages to be viewed.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if (!$this->isModerator()) {
      unset($this->view->options[2]);
    }

    // Element: create
    $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Pages?',
        'description' => 'Do you want to allow users to create Pages? If set to no, some other settings on this page may not apply. This is useful when you want certain levels only to be able to create Pages. If this setting is chosen Yes for Public Member level, then when a public users click on "Create New Page" option, they will see Authorization Popup to Login or Sign-up on your website.',
        'multiOptions' => array(
            1 => 'Yes, allow creation of Pages.',
            0 => 'No, do not allow Pages to be created.',
        ),
        'value' => 1,
    ));
    if (!$this->isPublic()) {
      // Element: edit
      $this->addElement('Radio', 'edit', array(
          'label' => 'Allow Editing of Pages?',
          'description' => 'Do you want to let members edit Pages?',
          'multiOptions' => array(
              2 => "Yes, allow members to edit everyone's Pages.",
              1 => "Yes, allow  members to edit their own Pages.",
              0 => "No, do not allow Pages to be edited.",
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
          'label' => 'Allow Deletion of Pages?',
          'description' => 'Do you want to let members delete Pages? If set to no, some other settings on this page may not apply.',
          'multiOptions' => array(
              2 => 'Yes, allow members to delete all Pages.',
              1 => 'Yes, allow members to delete their own Pages.',
              0 => 'No, do not allow members to delete their Pages.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->delete->options[2]);
      }

      // Element: comment
      $this->addElement('Radio', 'comment', array(
          'label' => 'Allow Commenting on Pages?',
          'description' => 'Do you want to let members of this level comment on Pages? If this setting is chosen Yes for Public Member level, then when a public users click on Like or Comment option, they will see Authorization Popup to Login or Sign-up on your website.',
          'multiOptions' => array(
              2 => 'Yes, allow members to comment on all Pages, including private ones.',
              1 => 'Yes, allow members to comment on Pages.',
              0 => 'No, do not allow members to comment on Pages.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->comment->options[2]);
      }
      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
          'label' => 'Page View Privacy',
          'description' => 'Your users can choose any of the options from below, whom they want can see their Pages. If you do not check any option, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'everyone' => 'Everyone',
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Page Admins'
          ),
          'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner'),
      ));

      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
          'label' => 'Page Comment Options',
          'description' => 'Your users can choose any of the options from below whom they want can post to their Pages. If you do not check any options, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Page Admins',
              'member' => 'Page Members Only',
          ),
          'value' => array('registered','owner_network','owner_member_member','owner_member','owner','member'),
      ));
      $this->addElement('Radio', 'allow_network', array(
          'label' => 'Allow to choose "Page View Privacy Based on Networks"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Pages based on Networks on your website? If you choose Yes, then users will be able to choose the visibility of their Pages to members who have joined selected networks only.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', "enable_price", array(
          'label' => 'Enable Price',
          'description' => "Do you want to enable Price for the Pages created by members of this level? If you choose Yes, then members will be able to enter price from dashboard of their Pages.",
          'class' => $class,
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "price_mandatory", array(
          'label' => 'Make Page Price Mandatory',
          'class' => $class,
          'description' => "Do you want to make Price field mandatory when users create or edit their Pages?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "can_chooseprice", array(
          'label' => 'Allow Owners to Select Price Type',
          'class' => $class,
          'description' => "Do you want to allow owners of Pages to select the price type for their Pages?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "default_prztype", array(
          'label' => 'Default Price Type',
          'class' => $class,
          'description' => "Choose a Default Price Type for the Pages on your website. This type will be shown with the price of Pages on your website and will be an indicator of whether the Page has the Price or the Starting Price of various products, services, etc of that Page.",
          'multiOptions' => array(
              '1' => 'Show "Price"',
              '2' => 'Show "Starting Price"',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_claim', array(
          'label' => 'Allow to Claim Pages',
          'description' => 'Do you want to allow members of this level to Claim Pages on your website? If this setting is chosen Yes for Public Member level, then when a public users click on Claim option, they will see Authorization Popup to Login or Sign-up on your website.',
          'class' => '',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'allow_mlocation', array(
          'label' => 'Allow to Add Multiple Locations',
          'description' => 'Do you want to allow members of this level to add multiple locations for their Pages? This setting will only work if you have enabled Location from Global Settings of this plugin. If you choose Yes, then members will be able to enter multiple locations from dashboard of their Pages.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_close', array(
          'label' => 'Allow to Manage “Operating Hours” and “Close Page”',
          'description' => 'Do you want to allow members of this level to manage Operating Hours for their Pages? If you choose yes, then members will be able to enter the operating hours details from dashboard of their Pages. They can also choose to Close their Page permanently using this feature.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_linkpage', array(
          'label' => 'Allow to Add Linked Pages',
          'description' => 'Do you want to allow members of this level to add Linked Pages to their Pages on your website? If you choose Yes, then members will be able to add Linked Pages from dashboard of their Pages.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_crosspost', array(
          'label' => 'Enable Crossposting in Pages',
          'description' => 'Do you want to enable Crosspost feature for the Pages created by members of this level? (If Crossposting is enabled and members have added any Pages for crossposting, then the post added to their Pages will be automatically published to all other Pages added for crossposting. For crosspost, a request will be sent to owners of Pages being added and once owners approve the requests, crossposting between Pages will be enabled.) If you choose Yes, then members will be able to add Pages for crossposting from dashboard of their Pages.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'auth_contactpage', array(
          'label' => 'Enable Contact Page Members',
          'class' => $class,
          'description' => 'Do you want to enable the "Contact Page Members" functionality for the Pages created by the members of this level? If you choose yes, then members will be able to contact their Page members from dashboard of their Pages.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'upload_cover', array(
          'label' => 'Allow to Upload Page Cover Photo',
          'description' => 'Do you want to allow members of this member level to upload cover photo for their Pages. If set to No, then the default cover photo will get displayed instead which you can choose in settings below.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'upload_mainphoto', array(
          'label' => 'Allow to Upload Page Main Photo',
          'description' => 'Do you want to allow members of this member level to upload main photo for their Pages. If set to No, then the default main photo will get displayed instead which you can choose in settings below.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_pagestyle', array(
          'label' => 'Allow to Choose Page Profile Design Views',
          'description' => 'Do you want to enable members of this level to choose designs for their Page Profiles? (If you choose No, then you can choose a default layout for the Page Profiles on your website. But, if you choose Yes, then you can choose which all designs will be allowed for selection in Page dashboards.)',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('MultiCheckbox', 'select_pagestyle', array(
          'label' => 'Select Page Profile Designs',
          'description' => 'Select Page profile designs which will be available to members while creating or editing their Pages.',
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
      $this->addElement('Radio', 'page_style_type', array(
          'label' => 'Default Page Profile Design',
          'description' => 'Choose the default profile design for Pages created by members of this member level.',
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
      //page main photo
      if (count($default_photos) > 0) {
        $this->addElement('Select', 'watermark_photo', array(
            'label' => 'Add Watermark to Page Main Photos',
            'description' => 'Choose a photo which you want to add as watermark on the main photos of Pages upload by members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'watermark_cphoto', array(
            'label' => 'Add Watermark to Page Cover Photos',
            'description' => 'Choose a photo which you want to add as watermark on the cover photos of Pages upload by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'pagedefaultphoto', array(
            'label' => 'Default Main Photo for Pages',
            'description' => 'Choose main default photo for the Pages created by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'defaultCphoto', array(
            'label' => 'Default Cover Photo for Pages',
            'description' => 'Choose default cover photo for the Pages created by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
      } else {
        $description = "<div class='tip'><span>" . 'There are currently no photo in the File & Media Manager. Please upload the Photo to be chosen from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manage</a>" section.' . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'watermark_photo', array(
            'label' => 'Default Watermark Photo for Page Main Photo',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'watermark_cphoto', array(
            'label' => 'Default Watermark Photo for Page Cover Photo',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'pagedefaultphoto', array(
            'label' => 'Default Main Photo for Pages',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'defaultCphoto', array(
            'label' => 'Choose default cover photo for Pages on your website.',
            'description' => $description,
            'class' => $class,
        ));
      }
      $this->pagedefaultphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->defaultCphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->watermark_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->watermark_cphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->addElement('Radio', 'auth_subpage', array(
          'label' => 'Allow to Create Associated Sub Pages',
          'description' => 'Do you want to allow members of this level to create Associated sub Pages in their own Pages? If you choose Yes, then members will be able to add Associated-Pages from the "Create Associated Sub Page" setting in Options Menus on their Page. Only 1 level of Associated Sub Pages can be created in a Page.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));

      $this->addElement('Radio', 'page_approve', array(
          'description' => 'Do you want Pages created by members of this level to be auto-approved? If you choose No, then you can manually approve Pages from Manage Pages section of this plugin.',
          'label' => 'Auto Approve Pages',
          'multiOptions' => array(
              1 => 'Yes, auto-approve Pages.',
              0 => 'No, do not auto-approve Pages.'
          ),
          'class' => $class,
          'value' => 1,
      ));
      //element for page featured
      $this->addElement('Radio', 'page_featured', array(
          'description' => 'Do you want Pages created by members of this level to be automatically marked as Featured? If you choose No, then you can manually mark Pages as Featured from Manage Pages section of this plugin.',
          'label' => 'Automatically Mark Pages as Featured',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Pages as Featured',
              0 => 'No, do not automatically mark Pages as Featured',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for page sponsored
      $this->addElement('Radio', 'page_sponsored', array(
          'description' => 'Do you want Pages created by members of this level to be automatically marked as Sponsored? If you choose No, then you can manually mark Pages as Sponsored from Manage Pages section of this plugin.',
          'label' => 'Automatically Mark Pages as Sponsored',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Pages as Sponsored',
              0 => 'No, do not automatically mark Pages as Sponsored',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for page verified
      $this->addElement('Radio', 'page_verified', array(
          'description' => 'Do you want Pages created by members of this level to be automatically marked as Verified? If you choose No, then you can manually mark Pages as Verified from Manage Pages section of this plugin.',
          'label' => 'Automatically Mark Pages as Verified',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Pages as Verified',
              0 => 'No, do not automatically mark Pages as Verified',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for page verified
      $this->addElement('Radio', 'page_hot', array(
          'description' => 'Do you want Pages created by members of this level to be automatically marked as Hot? If you choose No, then you can manually mark Pages as Hot from Manage Pages section of this plugin.',
          'label' => 'Automatically Mark Pages as Hot',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Pages as Hot',
              0 => 'No, do not automatically mark Pages as Hot',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Radio', 'page_new', array(
          'description' => 'Do you want Pages created by members of this level to be automatically marked as New? If you choose No, then Pages will not be marked as New on your website. But, if you choose No, then you can choose the duration until which Pages will be marked as New on your website.',
          'label' => 'Automatically Mark Pages as New',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Pages as New',
              0 => 'No, do not automatically mark Pages as New',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Text', 'newPageduration', array(
          'label' => 'Duration for Pages Marked as New',
          'description' => 'Enter the number of days upto which Pages created by members of this level will be shown as New from their date of creation on your website.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
              new Engine_Validate_AtLeast(1),
          ),
          'value' => 2,
      ));
      $this->addElement('Radio', 'page_seo', array(
          'description' => 'Do you want to enable the "SEO" fields for the Pages created by members of this level? If you choose Yes, then members will be able to enter the details from dashboard of their Pages.',
          'label' => 'Enable SEO Fields',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'page_overview', array(
          'description' => 'Do you want to enable the "Overview" field for the Pages created by members of this level? If you choose Yes, then members will be able to enter the details from dashboard of their Pages.',
          'label' => 'Enable Overview',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));


      $this->addElement('Radio', 'page_attribution', array(
          'description' => 'Do you want to enable "Post Attribution" for the Pages owned and managed (<a href="admin/sespage/settings/page-roles" target="_blank">Click here</a> to configure Page Roles to enable members to become Page managers.) by members of this level? If you choose Yes, then posts from activity feed will be posted as the name of Pages instead of Page owners\' names. Choosing Yes will also enable you to allow Page admins and managers to select default Attribution for Pages to post as Page Name or their Own Name. This Setting will affect on new content only.',
          'label' => 'Enable Post Attribution in Pages (Post as Page Name)',
          'multiOptions' => array(
              1 => 'Yes, if you want posts on Pages as Page Names or User Names.',
              0 => 'No, if you want to posts on Pages as User Names only.',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->getElement('page_attribution')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $this->addElement('Radio', 'auth_defattribut', array(
          'description' => 'Do you want to allow members of this level to choose default "Post Attribution" for Pages they own and manage? If you choose Yes, then members will be able to choose the default attribution from dashboard of Pages. If you choose No, then they will not be able to choose the attribution and default attribution will be set to Post as Page Name. They will be able to switch the attribution in Status Updates, Likes and Comments if the setting below for switching attribution is enabled.',
          'label' => 'Allow to Choose Post Attribution in Pages',
          'multiOptions' => array(
              1 => 'Yes, allow to choose Default Post Attribution.',
              0 => 'No, post as Page Name only.',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', "auth_contSwitch", array(
          'label' => 'Allow Post Attribution Switching in Status Updates, Likes & Comments',
          'description' => 'Do you want to allow members to switch between Pages they own or manage (<a href="admin/sespage/settings/page-roles" target="_blank">Click here</a> to configures Page Roles to enable members to become Page managers.) and their personal account to Post status updates, Like and Comments on Pages they own and manage?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->getElement('auth_contSwitch')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
      $this->addElement('Radio', 'defattribut', array(
          'description' => '',
          'label' => 'Default Attribution',
          'multiOptions' => array(
              1 => 'As User',
              0 => 'As Page',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Radio', 'page_bgphoto', array(
          'description' => 'Do you want to enable the "Background Photo" functionality for the Pages created by members of this member level? If you choose Yes, then members will be able to upload the photo from dashboard of their Pages.',
          'label' => 'Enable Background Photo',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'page_contactinfo', array(
          'description' => 'Do you want to enable the "Contact Info" functionality for the Pages created by members of this member level? If you choose Yes, then members will be able to enter the contact details from dashboard of their Pages.',
          'label' => 'Enable Contact Info',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'page_edit_style', array(
          'description' => 'Do you want to enable "Edit CSS Style" for the Pages created by members of this level? If you choose Yes, then members will be able to edit the CSS Style from dashboard of their Pages.',
          'label' => 'Enable Edit Style',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));

       $this->addElement('Radio', 'page_service', array(
           'label' => 'Enable Page Service',
           'class' => $class,
           'description' => 'Do you want to enable Page Service for the Pages created by the members of this level?',
           'multiOptions' => array(
               1 => 'Yes',
               0 => 'No',
           ),
           'value' => 1,
       ));

       if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespageteam')) {
      // Team enable permission
     $this->addElement('Radio', 'page_team', array(
         'label' => 'Enable Page Team',
         'description' => 'Do you want to enable Page Team for the Pages created by the members of this level?',
         'multiOptions' => array(
             1 => 'Yes',
             0 => 'No',
         ),
         'value' => 1,
     ));
     }
      // Element: album
      $this->addElement('Radio', 'album', array(
          'label' => 'Allow Albums Upload in Pages?',
          'description' => 'Do you want to let members of this level upload albums in Pages? If you choose Yes, then members will be able to create and edit albums & upload photos from "Page Directories - Page Profile Photo Albums" widget placed on Page Profiles.',
          'multiOptions' => array(
              2 => 'Yes, allow members to upload albums on Pages, including private ones.',
              1 => 'Yes, allow members to upload albums in Pages.',
              0 => 'No, do not allow members to upload albums in Pages.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->album->options[2]);
      }
      // Element: auth_photo
      $this->addElement('MultiCheckbox', 'auth_album', array(
          'label' => 'Album Upload Options',
          'description' => 'Your users can choose from any of the options checked below when they decide who can upload albums to their Pages. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
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

      if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagepoll')){

        // Element: poll
        $this->addElement('Radio', 'poll', array(
          'label' => 'Allow Polls Upload in Pages?',
          'description' => 'Do you want to let members of this level upload polls in Pages?',
          'multiOptions' => array(
            2 => 'Yes, allow members to upload polls in Pages, including private ones.',
            1 => 'Yes, allow members to upload polls in Pages.',
            0 => 'No, do not allow members to upload polls in Pages.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
          unset($this->poll->options[2]);
        }
        // Element: auth_photo
        $this->addElement('MultiCheckbox', 'auth_poll', array(
          'label' => 'Poll Upload Options',
          'description' => 'Your users can choose from any of the options checked below when they decide who can upload Polls to their Pages. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
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
      if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagevideo')) {
        // Element: video
        $this->addElement('Radio', 'video', array(
            'label' => 'Allow Videos Upload in Pages?',
            'description' => 'Do you want to let members of this level upload videos in Pages?',
            'multiOptions' => array(
                2 => 'Yes, allow members to upload videos on Pages, including private ones.',
                1 => 'Yes, allow members to upload videos in Pages.',
                0 => 'No, do not allow members to upload videos in Pages.',
            ),
            'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
          unset($this->video->options[2]);
        }
        // Element: auth_photo
        $this->addElement('MultiCheckbox', 'auth_video', array(
            'label' => 'Video Upload Options',
            'description' => 'Your users can choose from any of the options checked below when they decide who can upload videos to their pages. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
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

      if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespageoffer')) {
        // Element: Offer
        $this->addElement('Radio', 'offer', array(
            'label' => 'Allow Offers in Pages?',
            'description' => 'Do you want to let members of this level create offers in Pages?',
            'multiOptions' => array(
                2 => 'Yes, allow members to create offers in Pages, including private ones.',
                1 => 'Yes, allow members to create offers in Pages.',
                0 => 'No, do not allow members to create offers in Pages.',
            ),
            'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
          unset($this->note->options[2]);
        }

        // Element: auth_offer
        $this->addElement('MultiCheckbox', 'auth_offer', array(
            'label' => 'Offer Create Options',
            'description' => 'Your users can choose from any of the options checked below when they decide who can create offers to their pages. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
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

      if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagenote')) {
        // Element: Note
        $this->addElement('Radio', 'note', array(
            'label' => 'Allow Notes in Pages?',
            'description' => 'Do you want to let members of this level create notes in Pages?',
            'multiOptions' => array(
                2 => 'Yes, allow members to create notes on Pages, including private ones.',
                1 => 'Yes, allow members to create notes in Pages.',
                0 => 'No, do not allow members to create notes in Pages.',
            ),
            'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
          unset($this->note->options[2]);
        }
        // Element: auth_photo
        $this->addElement('MultiCheckbox', 'auth_note', array(
            'label' => 'Note Create Options',
            'description' => 'Your users can choose from any of the options checked below when they decide who can create notes to their pages. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
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

      $this->addElement('Radio', 'auth_announce', array(
          'label' => 'Allow to Manage Announcements',
          'class' => $class,
          'description' => 'Do you want to allow members of this level to manage announcements in their Pages on your website? If you choose Yes, then members will be able to create, edit and manage announcements from dashboard of their Pages.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'page_allow_roles', array(
          'label' => 'Allow to Manage Page Roles',
          'description' => 'Do you want to allow members of this level to manage Roles in their Pages on your website? If you choose Yes, then members will be able to manage Roles from dashboard of their Pages.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_changeowner', array(
          'label' => 'Allow to Transfer Ownership',
          'description' => 'Do you want to allow members of this level to transfer ownership of their Pages to other members on your website? If you choose Yes, then members will be able to transfer ownership from dashboard of their Pages.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_insightrpt', array(
          'label' => 'Allow to View Insights & Reports',
          'class' => $class,
          'description' => 'Do you want to allow members of this level to view Insights and Reports of their Pages on your website? If you choose Yes, then members will be able to view insights and reports from dashboard of their Pages.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_addbutton', array(
          'label' => 'Allow to "Add a Button" ?',
          'class' => $class,
          'description' => 'Do you want to allow members of this level to add a call to action button to their Pages on your website? If you choose Yes, then members will be able to add the button from their Page Profiles. You can enable / disable this option from the "Page Profile - Cover Photo, Details & Options" widget from Layout Editor.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Text', 'page_count', array(
          'label' => 'Maximum Allowed Pages',
          'description' => 'Enter the maximum number of allowed Pages to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
          ),
          'value' => 10,
      ));
      $this->addElement('Text', 'page_album_count', array(
          'label' => 'Maximum Allowed Page Albums',
          'description' => 'Enter the maximum number of allowed Page Albums to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
          ),
          'value' => 10,
      ));
    }
    $this->addElement('Radio', 'page_can_join', array(
        'label' => 'Allow to Join Pages ?',
        'description' => 'Do you want to allow members of this level to Join Pages on your website? If you choose Yes, then members will see Join button in various widgets and places on your website. If this setting is chosen Yes for Public Member level, then when a public users click on Join button, they will see Authorization Popup to Login or Sign-up on your website.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));
  }

}
