<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Member Level Settings')
            ->setDescription('These settings are applied as per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level from below.');
    if (SESBUSINESSPACKAGE == 1) {
      $class = 'business_package';
    } else {
      $class = '';
    }
    // Element: view
    $this->addElement('Radio', 'view', array(
        'label' => 'Allow Viewing of Businesses?',
        'description' => 'Do you want to let users to view Businesses? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
            2 => 'Yes, allow members to view all Businesses, even private ones.',
            1 => 'Yes, allow members to view their own Businesses.',
            0 => 'No, do not allow Businesses to be viewed.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if (!$this->isModerator()) {
      unset($this->view->options[2]);
    }

    // Element: create
    $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Businesses?',
        'description' => 'Do you want to allow users to create Businesses? If set to no, some other settings on this page may not apply. This is useful when you want certain levels only to be able to create Businesses. If this setting is chosen Yes for Public Member level, then when a public users click on "Create New Business" option, they will see Authorization Popup to Login or Sign-up on your website.',
        'multiOptions' => array(
            1 => 'Yes, allow creation of Businesses.',
            0 => 'No, do not allow Businesses to be created.',
        ),
        'value' => 1,
    ));
    if (!$this->isPublic()) {
      // Element: edit
      $this->addElement('Radio', 'edit', array(
          'label' => 'Allow Editing of Businesses?',
          'description' => 'Do you want to let members edit Businesses?',
          'multiOptions' => array(
              2 => "Yes, allow members to edit everyone's Businesses.",
              1 => "Yes, allow  members to edit their own Businesses.",
              0 => "No, do not allow Businesses to be edited.",
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
          'label' => 'Allow Deletion of Businesses?',
          'description' => 'Do you want to let members delete Businesses? If set to no, some other settings on this page may not apply.',
          'multiOptions' => array(
              2 => 'Yes, allow members to delete all Businesses.',
              1 => 'Yes, allow members to delete their own Businesses.',
              0 => 'No, do not allow members to delete their Businesses.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->delete->options[2]);
      }

      // Element: comment
      $this->addElement('Radio', 'comment', array(
          'label' => 'Allow Commenting on Businesses?',
          'description' => 'Do you want to let members of this level comment on Businesses? If this setting is chosen Yes for Public Member level, then when a public users click on Like or Comment option, they will see Authorization Popup to Login or Sign-up on your website.',
          'multiOptions' => array(
              2 => 'Yes, allow members to comment on all Businesses, including private ones.',
              1 => 'Yes, allow members to comment on Businesses.',
              0 => 'No, do not allow members to comment on Businesses.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->comment->options[2]);
      }
      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
          'label' => 'Business View Privacy',
          'description' => 'Your users can choose any of the options from below, whom they want can see their Businesses. If you do not check any option, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'everyone' => 'Everyone',
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Business Admins'
          ),
          'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner'),
      ));

      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
          'label' => 'Business Comment Options',
          'description' => 'Your users can choose any of the options from below whom they want can post to their Businesses. If you do not check any options, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Business Admins',
              'member' => 'Business Members Only',
          ),
          'value' => array('registered','owner_network','owner_member_member','owner_member','owner','member'),
      ));
      $this->addElement('Radio', 'allow_network', array(
          'label' => 'Allow to choose "Business View Privacy Based on Networks"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Businesses based on Networks on your website? If you choose Yes, then users will be able to choose the visibility of their Businesses to members who have joined selected networks only.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', "enable_price", array(
          'label' => 'Enable Price',
          'description' => "Do you want to enable Price for the Businesses created by members of this level? If you choose Yes, then members will be able to enter price from dashboard of their Businesses.",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "price_mandatory", array(
          'label' => 'Make Business Price Mandatory',
          'description' => "Do you want to make Price field mandatory when users create or edit their Businesses?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "can_chooseprice", array(
          'label' => 'Allow Owners to Select Price Type',
          'description' => "Do you want to allow owners of Businesses to select the price type for their Businesses?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "default_prztype", array(
          'label' => 'Default Price Type',
          'description' => "Choose a Default Price Type for the Businesses on your website. This type will be shown with the price of Businesses on your website and will be an indicator of whether the Business has the Price or the Starting Price of various products, services, etc of that Business.",
          'multiOptions' => array(
              '1' => 'Show "Price"',
              '2' => 'Show "Starting Price"',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_claim', array(
          'label' => 'Allow to Claim Businesses',
          'description' => 'Do you want to allow members of this level to Claim Businesses on your website? If this setting is chosen Yes for Public Member level, then when a public users click on Claim option, they will see Authorization Popup to Login or Sign-up on your website.',
          'class' => '',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'allow_mlocation', array(
          'label' => 'Allow to Add Multiple Locations',
          'description' => 'Do you want to allow members of this level to add multiple locations for their Businesses? This setting will only work if you have enabled Location from Global Settings of this plugin. If you choose Yes, then members will be able to enter multiple locations from dashboard of their Businesses.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_close', array(
          'label' => 'Allow to Manage “Operating Hours” and “Close Business”',
          'description' => 'Do you want to allow members of this level to manage Operating Hours for their Businesses? If you choose yes, then members will be able to enter the operating hours details from dashboard of their Businesses. They can also choose to Close their Business permanently using this feature.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_linkbusines', array(
          'label' => 'Allow to Add Linked Businesses',
          'description' => 'Do you want to allow members of this level to add Linked Businesses to their Businesses on your website? If you choose Yes, then members will be able to add Linked Businesses from dashboard of their Businesses.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_crosspost', array(
          'label' => 'Enable Crossposting in Businesses',
          'description' => 'Do you want to enable Crosspost feature for the Businesses created by members of this level? (If Crossposting is enabled and members have added any Businesses for crossposting, then the post added to their Businesses will be automatically published to all other Businesses added for crossposting. For crosspost, a request will be sent to owners of Businesses being added and once owners approve the requests, crossposting between Businesses will be enabled.) If you choose Yes, then members will be able to add Businesses for crossposting from dashboard of their Businesses.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'auth_contactgp', array(
          'label' => 'Enable Contact Business Members',
          'description' => 'Do you want to enable the "Contact Business Members" functionality for the Businesses created by the members of this level? If you choose yes, then members will be able to contact their Business members from dashboard of their Businesses.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'upload_cover', array(
          'label' => 'Allow to Upload Business Cover Photo',
          'description' => 'Do you want to allow members of this member level to upload cover photo for their Businesses. If set to No, then the default cover photo will get displayed instead which you can choose in settings below.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'upload_mainphoto', array(
          'label' => 'Allow to Upload Business Main Photo',
          'description' => 'Do you want to allow members of this member level to upload main photo for their Businesses. If set to No, then the default main photo will get displayed instead which you can choose in settings below.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_bsstyle', array(
          'label' => 'Allow to Choose Business Profile Design Views',
          'description' => 'Do you want to enable members of this level to choose designs for their Business Profiles? (If you choose No, then you can choose a default layout for the Business Profiles on your website. But, if you choose Yes, then you can choose which all designs will be allowed for selection in Business dashboards.)',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('MultiCheckbox', 'select_bsstyle', array(
          'label' => 'Select Business Profile Designs',
          'description' => 'Select Business profile designs which will be available to members while creating or editing their Businesses.',
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
          'label' => 'Default Business Profile Design',
          'description' => 'Choose the default profile design for Businesses created by members of this member level.',
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
      //business main photo
      if (count($default_photos) > 0) {
        $this->addElement('Select', 'watermark_photo', array(
            'label' => 'Add Watermark to Business Main Photos',
            'description' => 'Choose a photo which you want to add as watermark on the main photos of Businesses upload by members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'watermark_cphoto', array(
            'label' => 'Add Watermark to Business Cover Photos',
            'description' => 'Choose a photo which you want to add as watermark on the cover photos of Businesses upload by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'bsdefaultphoto', array(
            'label' => 'Default Main Photo for Businesses',
            'description' => 'Choose main default photo for the Businesses created by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'defaultCphoto', array(
            'label' => 'Default Cover Photo for Businesses',
            'description' => 'Choose default cover photo for the Businesses created by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
      } else {
        $description = "<div class='tip'><span>" . 'There are currently no photo in the File & Media Manager. Please upload the Photo to be chosen from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manage</a>" section.' . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'watermark_photo', array(
            'label' => 'Default Watermark Photo for Business Main Photo',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'watermark_cphoto', array(
            'label' => 'Default Watermark Photo for Business Cover Photo',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'bsdefaultphoto', array(
            'label' => 'Default Main Photo for Businesses',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'defaultCphoto', array(
            'label' => 'Choose default cover photo for Businesses on your website.',
            'description' => $description,
            'class' => $class,
        ));
      }
      $this->bsdefaultphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->defaultCphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->watermark_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->watermark_cphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->addElement('Radio', 'auth_subbusiness', array(
          'label' => 'Allow to Create Associated Sub Businesses',
          'description' => 'Do you want to allow members of this level to create Associated sub Businesses in their own Businesses? If you choose Yes, then members will be able to add Associated-Businesses from the "Create Associated Sub Business" setting in Options Menus on their Business. Only 1 level of Associated Sub Businesses can be created in a Business.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));

      $this->addElement('Radio', 'business_approve', array(
          'description' => 'Do you want Businesses created by members of this level to be auto-approved? If you choose No, then you can manually approve Businesses from Manage Businesses section of this plugin.',
          'label' => 'Auto Approve Businesses',
          'multiOptions' => array(
              1 => 'Yes, auto-approve Businesses.',
              0 => 'No, do not auto-approve Businesses.'
          ),
          'class' => $class,
          'value' => 1,
      ));
      //element for business featured
      $this->addElement('Radio', 'bs_featured', array(
          'description' => 'Do you want Businesses created by members of this level to be automatically marked as Featured? If you choose No, then you can manually mark Businesses as Featured from Manage Businesses section of this plugin.',
          'label' => 'Automatically Mark Businesses as Featured',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Businesses as Featured',
              0 => 'No, do not automatically mark Businesses as Featured',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for business sponsored
      $this->addElement('Radio', 'bs_sponsored', array(
          'description' => 'Do you want Businesses created by members of this level to be automatically marked as Sponsored? If you choose No, then you can manually mark Businesses as Sponsored from Manage Businesses section of this plugin.',
          'label' => 'Automatically Mark Businesses as Sponsored',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Businesses as Sponsored',
              0 => 'No, do not automatically mark Businesses as Sponsored',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for business verified
      $this->addElement('Radio', 'bs_verified', array(
          'description' => 'Do you want Businesses created by members of this level to be automatically marked as Verified? If you choose No, then you can manually mark Businesses as Verified from Manage Businesses section of this plugin.',
          'label' => 'Automatically Mark Businesses as Verified',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Businesses as Verified',
              0 => 'No, do not automatically mark Businesses as Verified',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for business verified
      $this->addElement('Radio', 'business_hot', array(
          'description' => 'Do you want Businesses created by members of this level to be automatically marked as Hot? If you choose No, then you can manually mark Businesses as Hot from Manage Businesses section of this plugin.',
          'label' => 'Automatically Mark Businesses as Hot',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Businesses as Hot',
              0 => 'No, do not automatically mark Businesses as Hot',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Radio', 'business_new', array(
          'description' => 'Do you want Businesses created by members of this level to be automatically marked as New? If you choose No, then Businesses will not be marked as New on your website. But, if you choose No, then you can choose the duration until which Businesses will be marked as New on your website.',
          'label' => 'Automatically Mark Businesses as New',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Businesses as New',
              0 => 'No, do not automatically mark Businesses as New',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Text', 'newBsduration', array(
          'label' => 'Duration for Businesses Marked as New',
          'description' => 'Enter the number of days upto which Businesses created by members of this level will be shown as New from their date of creation on your website.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
              new Engine_Validate_AtLeast(1),
          ),
          'value' => 2,
      ));
      $this->addElement('Radio', 'business_seo', array(
          'description' => 'Do you want to enable the "SEO" fields for the Businesses created by members of this level? If you choose Yes, then members will be able to enter the details from dashboard of their Businesses.',
          'label' => 'Enable SEO Fields',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'bs_overview', array(
          'description' => 'Do you want to enable the "Overview" field for the Businesses created by members of this level? If you choose Yes, then members will be able to enter the details from dashboard of their Businesses.',
          'label' => 'Enable Overview',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));

      $this->addElement('Radio', 'seb_attribution', array(
          'description' => 'Do you want to enable "Post Attribution" for the Businesses owned and managed (<a href="admin/sesbusiness/settings/business-roles" target="_blank">Click here</a> to configure Business Roles to enable members to become Business managers.) by members of this level? If you choose Yes, then posts from activity feed will be posted as the name of Businesses instead of Business owners\' names. Choosing Yes will also enable you to allow Business admins and managers to select default Attribution for Businesses to post as Business Name or their Own Name. This Setting will affect on new content only. (Note: This feature is dependent on "<a href="https://www.socialenginesolutions.com/social-engine/advanced-news-activity-feeds-plugin/" target="_blank">Advanced News & Activity Feeds Plugin</a>" and requires the ‘Advanced Activity Feeds’ widget to be placed on the Business View page.)',
          'label' => 'Enable Post Attribution in Businesses (Post as Business Name)',
          'multiOptions' => array(
              1 => 'Yes, if you want posts on Businesses as Business Names or User Names.',
              0 => 'No, if you want to posts on Businesses as User Names only.',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->getElement('seb_attribution')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $this->addElement('Radio', 'auth_defattribut', array(
          'description' => 'Do you want to allow members of this level to choose default "Post Attribution" for Businesses they own and manage? If you choose Yes, then members will be able to choose the default attribution from dashboard of Businesses. If you choose No, then they will not be able to choose the attribution and default attribution will be set to Post as Business Name. They will be able to switch the attribution in Status Updates, Likes and Comments if the setting below for switching attribution is enabled.',
          'label' => 'Allow to Choose Post Attribution in Businesses',
          'multiOptions' => array(
              1 => 'Yes, allow to choose Default Post Attribution.',
              0 => 'No, post as Business Name only.',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', "auth_contSwitch", array(
          'label' => 'Allow Post Attribution Switching in Status Updates, Likes & Comments',
          'description' => 'Do you want to allow members to switch between Businesses they own or manage (<a href="admin/sesbusiness/settings/business-roles" target="_blank">Click here</a> to configures Business Roles to enable members to become Business managers.) and their personal account to Post status updates, Like and Comments on Businesses they own and manage?',
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
              0 => 'As Business',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Radio', 'business_bgphoto', array(
          'description' => 'Do you want to enable the "Background Photo" functionality for the Businesses created by members of this member level? If you choose Yes, then members will be able to upload the photo from dashboard of their Businesses.',
          'label' => 'Enable Background Photo',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'bs_contactinfo', array(
          'description' => 'Do you want to enable the "Contact Info" functionality for the Businesses created by members of this member level? If you choose Yes, then members will be able to enter the contact details from dashboard of their Businesses.',
          'label' => 'Enable Contact Info',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'bs_edit_style', array(
          'description' => 'Do you want to enable "Edit CSS Style" for the Businesses created by members of this level? If you choose Yes, then members will be able to edit the CSS Style from dashboard of their Businesses.',
          'label' => 'Enable Edit Style',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));

       $this->addElement('Radio', 'business_service', array(
           'label' => 'Enable Business Service',
           'description' => 'Do you want to enable Business Service for the Businesses created by the members of this level?',
           'multiOptions' => array(
               1 => 'Yes',
               0 => 'No',
           ),
           'value' => 1,
       ));

        if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessteam')) {
            // Team enable permission
            $this->addElement('Radio', 'business_team', array(
                'label' => 'Enable Business Team',
                'description' => 'Do you want to enable Business Team for the Businesses created by the members of this level?',
                'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No',
                ),
                'value' => 1,
            ));
        }

      // Element: album
      $this->addElement('Radio', 'album', array(
          'label' => 'Allow Albums Upload in Businesses?',
          'description' => 'Do you want to let members of this level upload albums in Businesses? If you choose Yes, then members will be able to create and edit albums & upload photos from "Business Directories - Business Profile Photo Albums" widget placed on Business Profiles.',
          'multiOptions' => array(
              2 => 'Yes, allow members to upload albums on Businesses, including private ones.',
              1 => 'Yes, allow members to upload albums in Businesses.',
              0 => 'No, do not allow members to upload albums in Businesses.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->album->options[2]);
      }
      // Element: auth_photo
      $this->addElement('MultiCheckbox', 'auth_album', array(
          'label' => 'Album Upload Options',
          'description' => 'Your users can choose from any of the options checked below when they decide who can upload albums to their Businesses. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Business Admins',
              'member'=> 'Business Members Only',
          ),
          'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner','member'),
      ));
  if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinesspoll')){

        // Element: poll
        $this->addElement('Radio', 'poll', array(
          'label' => 'Allow Polls Upload in Businesses?',
          'description' => 'Do you want to let members of this level upload polls in Businesses?',
          'multiOptions' => array(
            2 => 'Yes, allow members to upload polls in Businesses, including private ones.',
            1 => 'Yes, allow members to upload polls in Businesses.',
            0 => 'No, do not allow members to upload polls in Businesses.',
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
      if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessvideo')) {
        // Element: video
        $this->addElement('Radio', 'video', array(
            'label' => 'Allow Videos Upload in Businesses?',
            'description' => 'Do you want to let members of this level upload videos in Businesses?',
            'multiOptions' => array(
                2 => 'Yes, allow members to upload videos on Businesses, including private ones.',
                1 => 'Yes, allow members to upload videos in Businesses.',
                0 => 'No, do not allow members to upload videos in Businesses.',
            ),
            'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
          unset($this->video->options[2]);
        }
        // Element: auth_photo
        $this->addElement('MultiCheckbox', 'auth_video', array(
            'label' => 'Video Upload Options',
            'description' => 'Your users can choose from any of the options checked below when they decide who can upload videos to their businesses. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
            'multiOptions' => array(
                'everyone' => 'Everyone',
                'registered' => 'Registered Members',
                'owner_network' => 'Friends and Networks',
                'owner_member_member' => 'Friends of Friends',
                'owner_member' => 'Friends Only',
                'owner' => 'Business Admins'
            )
        ));
      }
      if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessoffer')) {
        // Element: Offer
        $this->addElement('Radio', 'offer', array(
            'label' => 'Allow Offers in Businesses?',
            'description' => 'Do you want to let members of this level create offers in businesses?',
            'multiOptions' => array(
                2 => 'Yes, allow members to create offers in Businesses, including private ones.',
                1 => 'Yes, allow members to create offers in Businesses.',
                0 => 'No, do not allow members to create offers in Businesses.',
            ),
            'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
          unset($this->note->options[2]);
        }

        // Element: auth_offer
        $this->addElement('MultiCheckbox', 'auth_offer', array(
            'label' => 'Offer Create Options',
            'description' => 'Your users can choose from any of the options checked below when they decide who can create offers to their businesses. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
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
          'description' => 'Do you want to allow members of this level to manage announcements in their Businesses on your website? If you choose Yes, then members will be able to create, edit and manage announcements from dashboard of their Businesses.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'bs_allow_roles', array(
          'label' => 'Allow to Manage Business Roles',
          'description' => 'Do you want to allow members of this level to manage Roles in their Businesses on your website? If you choose Yes, then members will be able to manage Roles from dashboard of their Businesses.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_changeowner', array(
          'label' => 'Allow to Transfer Ownership',
          'description' => 'Do you want to allow members of this level to transfer ownership of their Businesses to other members on your website? If you choose Yes, then members will be able to transfer ownership from dashboard of their Businesses.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_insightrpt', array(
          'label' => 'Allow to View Insights & Reports',
          'description' => 'Do you want to allow members of this level to view Insights and Reports of their Businesses on your website? If you choose Yes, then members will be able to view insights and reports from dashboard of their Businesses.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_addbutton', array(
          'label' => 'Allow to "Add a Button" ?',
          'description' => 'Do you want to allow members of this level to add a call to action button to their Businesses on your website? If you choose Yes, then members will be able to add the button from their Business Profiles. You can enable / disable this option from the "Business Profile - Cover Photo, Details & Options" widget from Layout Editor.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Text', 'business_count', array(
          'label' => 'Maximum Allowed Businesses',
          'description' => 'Enter the maximum number of allowed Businesses to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
          ),
          'value' => 10,
      ));
      $this->addElement('Text', 'bs_album_count', array(
          'label' => 'Maximum Allowed Business Albums',
          'description' => 'Enter the maximum number of allowed Business Albums to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
          ),
          'value' => 10,
      ));
    }
    $this->addElement('Radio', 'bs_can_join', array(
        'label' => 'Allow to Join Businesses ?',
        'description' => 'Do you want to allow members of this level to Join Businesses on your website? If you choose Yes, then members will see Join button in various widgets and places on your website. If this setting is chosen Yes for Public Member level, then when a public users click on Join button, they will see Authorization Popup to Login or Sign-up on your website.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));
  }

}
