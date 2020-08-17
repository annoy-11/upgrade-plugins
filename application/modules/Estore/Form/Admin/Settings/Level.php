<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Member Level Settings')
            ->setDescription('These settings are applied as per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level from below.');
    if (ESTOREPACKAGE == 1) {
      $class = 'store_package';
    } else {
      $class = '';
    }
    // Element: view
    $this->addElement('Radio', 'view', array(
        'label' => 'Allow Viewing of Stores?',
        'description' => 'Do you want to let users to view Stores? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
            2 => 'Yes, allow members to view all Stores, even private ones.',
            1 => 'Yes, allow members to view their own Stores.',
            0 => 'No, do not allow Stores to be viewed.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if (!$this->isModerator()) {
      unset($this->view->options[2]);
    }

    // Element: create
    $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Stores?',
        'description' => 'Do you want to allow users to create Stores? If set to no, some other settings on this page may not apply. This is useful when you want certain levels only to be able to create Stores. If this setting is chosen Yes for Public Member level, then when a public users click on "Create New Store" option, they will see Authorization Popup to Login or Sign-up on your website.',
        'multiOptions' => array(
            1 => 'Yes, allow creation of Stores.',
            0 => 'No, do not allow Stores to be created.',
        ),
        'value' => 1,
    ));

    if (!$this->isPublic()) {


      // Element: edit
      $this->addElement('Radio', 'edit', array(
          'label' => 'Allow Editing of Stores?',
          'description' => 'Do you want to let members edit Stores?',
          'multiOptions' => array(
              2 => "Yes, allow members to edit everyone's Stores.",
              1 => "Yes, allow  members to edit their own Stores.",
              0 => "No, do not allow Stores to be edited.",
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
          'label' => 'Allow Deletion of Stores?',
          'description' => 'Do you want to let members delete Stores? If set to no, some other settings on this page may not apply.',
          'multiOptions' => array(
              2 => 'Yes, allow members to delete all Stores.',
              1 => 'Yes, allow members to delete their own Stores.',
              0 => 'No, do not allow members to delete their Stores.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->delete->options[2]);
      }

      // Element: comment
      $this->addElement('Radio', 'comment', array(
          'label' => 'Allow Commenting on Stores?',
          'description' => 'Do you want to let members of this level comment on Stores? If this setting is chosen Yes for Public Member level, then when a public users click on Like or Comment option, they will see Authorization Popup to Login or Sign-up on your website.',
          'multiOptions' => array(
              2 => 'Yes, allow members to comment on all Stores, including private ones.',
              1 => 'Yes, allow members to comment on Stores.',
              0 => 'No, do not allow members to comment on Stores.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->comment->options[2]);
      }
      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
          'label' => 'Store View Privacy',
          'description' => 'Your users can choose any of the options from below, whom they want can see their Stores. If you do not check any option, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'everyone' => 'Everyone',
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Store Admins'
          ),
          'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner'),
      ));

      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
          'label' => 'Store Comment Options',
          'description' => 'Your users can choose any of the options from below whom they want can post to their Stores. If you do not check any options, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Store Admins',
              'member' => 'Store Members Only',
          ),
          'value' => array('registered','owner_network','owner_member_member','owner_member','owner','member'),
      ));

      $this->addElement('Radio', 'allow_network', array(
          'label' => 'Allow to choose "Store View Privacy Based on Networks"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Stores based on Networks on your website? If you choose Yes, then users will be able to choose the visibility of their Stores to members who have joined selected networks only.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', "enable_price", array(
          'label' => 'Enable Price',
          'description' => "Do you want to enable Price for the Stores created by members of this level? If you choose Yes, then members will be able to enter price from dashboard of their Stores.",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "price_mandatory", array(
          'label' => 'Make Store Price Mandatory',
          'description' => "Do you want to make Price field mandatory when users create or edit their Stores?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "can_chooseprice", array(
          'label' => 'Allow Owners to Select Price Type',
          'description' => "Do you want to allow owners of Stores to select the price type for their Stores?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "default_prztype", array(
          'label' => 'Default Price Type',
          'description' => "Choose a Default Price Type for the Stores on your website. This type will be shown with the price of Stores on your website and will be an indicator of whether the Store has the Price or the Starting Price of various stores, services, etc of that Store.",
          'multiOptions' => array(
              '1' => 'Show "Price"',
              '2' => 'Show "Starting Price"',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_claim', array(
          'label' => 'Allow to Claim Stores',
          'description' => 'Do you want to allow members of this level to Claim Stores on your website? If this setting is chosen Yes for Public Member level, then when a public users click on Claim option, they will see Authorization Popup to Login or Sign-up on your website.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'allow_mlocation', array(
          'label' => 'Allow to Add Multiple Locations',
          'description' => 'Do you want to allow members of this level to add multiple locations for their Stores? This setting will only work if you have enabled Location from Global Settings of this plugin. If you choose Yes, then members will be able to enter multiple locations from dashboard of their Stores.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_close', array(
          'label' => 'Allow to Manage "Operating Hours" and "Close Store"',
          'description' => 'Do you want to allow members of this level to manage Operating Hours for their Stores? If you choose yes, then members will be able to enter the operating hours details from dashboard of their Stores. They can also choose to close their Store permanently using this feature.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_linkbusines', array(
          'label' => 'Allow to Add Linked Stores',
          'description' => 'Do you want to allow members of this level to add Linked Stores to their Stores on your website? If you choose Yes, then members will be able to add Linked Stores from dashboard of their Stores.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_crosspost', array(
          'label' => 'Enable Crossposting in Stores',
          'description' => 'Do you want to enable Crosspost feature for the Stores created by members of this level? (If Crossposting is enabled and members have added any Stores for crossposting, then the post added to their Stores will be automatically published to all other Stores added for crossposting. For crosspost, a request will be sent to owners of Stores being added and once owners approve the requests, crossposting between Stores will be enabled.) If you choose Yes, then members will be able to add Stores for crossposting from dashboard of their Stores.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'auth_contactgp', array(
          'label' => 'Enable Contact Store Members',
          'description' => 'Do you want to enable the "Contact Store Members" functionality for the Stores created by the members of this level? If you choose yes, then members will be able to contact their Store members from dashboard of their Stores.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'upload_cover', array(
          'label' => 'Allow to Upload Store Cover Photo',
          'description' => 'Do you want to allow members of this member level to upload cover photo for their Stores. If set to No, then the default cover photo will get displayed instead which you can choose in settings below.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'upload_mainphoto', array(
          'label' => 'Allow to Upload Store Main Photo',
          'description' => 'Do you want to allow members of this member level to upload main photo for their Stores. If set to No, then the default main photo will get displayed instead which you can choose in settings below.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_bsstyle', array(
          'label' => 'Allow to Choose Store Profile Design Views',
          'description' => 'Do you want to enable members of this level to choose designs for their Store Profiles? (If you choose No, then you can choose a default layout for the Store Profiles on your website. But, if you choose Yes, then you can choose which all designs will be allowed for selection in Store dashboards.)',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('MultiCheckbox', 'select_bsstyle', array(
          'label' => 'Select Store Profile Designs',
          'description' => 'Select Store profile designs which will be available to members while creating or editing their Stores.',
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
          'label' => 'Default Store Profile Design',
          'description' => 'Choose the default profile design for Stores created by members of this member level.',
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
      //store main photo
      if (count($default_photos) > 0) {
        $this->addElement('Select', 'watermark_photo', array(
            'label' => 'Add Watermark to Store Main Photos',
            'description' => 'Choose a photo which you want to add as watermark on the main photos of Stores upload by members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'watermark_cphoto', array(
            'label' => 'Add Watermark to Store Cover Photos',
            'description' => 'Choose a photo which you want to add as watermark on the cover photos of Stores upload by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'bsdefaultphoto', array(
            'label' => 'Default Main Photo for Stores',
            'description' => 'Choose main default photo for the Stores created by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
        $this->addElement('Select', 'defaultCphoto', array(
            'label' => 'Default Cover Photo for Stores',
            'description' => 'Choose default cover photo for the Stores created by the members of this level on your website. [Note: You can add a new photo from the "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. Leave the field blank if you do not want to add default photo.]',
            'multiOptions' => $default_photos,
            'class' => $class,
        ));
      } else {
        $description = "<div class='tip'><span>" . 'There are currently no photo in the File & Media Manager. Please upload the Photo to be chosen from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manage</a>" section.' . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'watermark_photo', array(
            'label' => 'Default Watermark Photo for Store Main Photo',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'watermark_cphoto', array(
            'label' => 'Default Watermark Photo for Store Cover Photo',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'bsdefaultphoto', array(
            'label' => 'Default Main Photo for Stores',
            'description' => $description,
            'class' => $class,
        ));
        $this->addElement('Dummy', 'defaultCphoto', array(
            'label' => 'Choose default cover photo for Stores on your website.',
            'description' => $description,
            'class' => $class,
        ));
      }
      $this->bsdefaultphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->defaultCphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->watermark_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->watermark_cphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->addElement('Radio', 'auth_substore', array(
          'label' => 'Allow to Create Associated Sub Stores',
          'description' => 'Do you want to allow members of this level to create Associated sub Stores in their own Stores? If you choose Yes, then members will be able to add Associated-Stores from the "Create Associated Sub Store" setting in Options Menus on their Store. Only 1 level of Associated Sub Stores can be created in a Store.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));

      $this->addElement('Radio', 'store_approve', array(
          'description' => 'Do you want Stores created by members of this level to be auto-approved? If you choose No, then you can manually approve Stores from Manage Stores section of this plugin.',
          'label' => 'Auto Approve Stores',
          'multiOptions' => array(
              1 => 'Yes, auto-approve Stores.',
              0 => 'No, do not auto-approve Stores.'
          ),
          'class' => $class,
          'value' => 1,
      ));
      //element for store featured
      $this->addElement('Radio', 'bs_featured', array(
          'description' => 'Do you want Stores created by members of this level to be automatically marked as Featured? If you choose No, then you can manually mark Stores as Featured from Manage Stores section of this plugin.',
          'label' => 'Automatically Mark Stores as Featured',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Stores as Featured',
              0 => 'No, do not automatically mark Stores as Featured',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for store sponsored
      $this->addElement('Radio', 'bs_sponsored', array(
          'description' => 'Do you want Stores created by members of this level to be automatically marked as Sponsored? If you choose No, then you can manually mark Stores as Sponsored from Manage Stores section of this plugin.',
          'label' => 'Automatically Mark Stores as Sponsored',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Stores as Sponsored',
              0 => 'No, do not automatically mark Stores as Sponsored',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for store verified
      $this->addElement('Radio', 'bs_verified', array(
          'description' => 'Do you want Stores created by members of this level to be automatically marked as Verified? If you choose No, then you can manually mark Stores as Verified from Manage Stores section of this plugin.',
          'label' => 'Automatically Mark Stores as Verified',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Stores as Verified',
              0 => 'No, do not automatically mark Stores as Verified',
          ),
          'class' => $class,
          'value' => 0,
      ));
      //element for store verified
      $this->addElement('Radio', 'store_hot', array(
          'description' => 'Do you want Stores created by members of this level to be automatically marked as Hot? If you choose No, then you can manually mark Stores as Hot from Manage Stores section of this plugin.',
          'label' => 'Automatically Mark Stores as Hot',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Stores as Hot',
              0 => 'No, do not automatically mark Stores as Hot',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Radio', 'store_new', array(
          'description' => 'Do you want Stores created by members of this level to be automatically marked as New? If you choose No, then Stores will not be marked as New on your website. But, if you choose No, then you can choose the duration until which Stores will be marked as New on your website.',
          'label' => 'Automatically Mark Stores as New',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Stores as New',
              0 => 'No, do not automatically mark Stores as New',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Text', 'newBsduration', array(
          'label' => 'Duration for Stores Marked as New',
          'description' => 'Enter the number of days upto which Stores created by members of this level will be shown as New from their date of creation on your website.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
              new Engine_Validate_AtLeast(1),
          ),
          'value' => 2,
      ));
      $this->addElement('Radio', 'store_seo', array(
          'description' => 'Do you want to enable the "SEO" fields for the Stores created by members of this level? If you choose Yes, then members will be able to enter the details from dashboard of their Stores.',
          'label' => 'Enable SEO Fields',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'bs_overview', array(
          'description' => 'Do you want to enable the "Overview" field for the Stores created by members of this level? If you choose Yes, then members will be able to enter the details from dashboard of their Stores.',
          'label' => 'Enable Overview',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));

      $this->addElement('Radio', 'seb_attribution', array(
          'description' => 'Do you want to enable "Post Attribution" for the Stores owned and managed (<a href="admin/estore/settings/store-roles" target="_blank">Click here</a> to configure Store Roles to enable members to become Store managers.) by members of this level? If you choose Yes, then posts from activity feed will be posted as the name of Stores instead of Store owners\' names. Choosing Yes will also enable you to allow Store admins and managers to select default Attribution for Stores to post as Store Name or their Own Name. This Setting will affect on new content only. (Note: This feature is dependent on "<a href="https://www.socialenginesolutions.com/social-engine/advanced-news-activity-feeds-plugin/" target="_blank">Advanced News & Activity Feeds Plugin</a>" and requires the ‘Advanced Activity Feeds’ widget to be placed on the Store View page.)',
          'label' => 'Enable Post Attribution in Stores (Post as Store Name)',
          'multiOptions' => array(
              1 => 'Yes, if you want posts on Stores as Store Names or User Names.',
              0 => 'No, if you want to posts on Stores as User Names only.',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->getElement('seb_attribution')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $this->addElement('Radio', 'auth_defattribut', array(
          'description' => 'Do you want to allow members of this level to choose default "Post Attribution" for Stores they own and manage? If you choose Yes, then members will be able to choose the default attribution from dashboard of Stores. If you choose No, then they will not be able to choose the attribution and default attribution will be set to Post as Store Name. They will be able to switch the attribution in Status Updates, Likes and Comments if the setting below for switching attribution is enabled.',
          'label' => 'Allow to Choose Post Attribution in Stores',
          'multiOptions' => array(
              1 => 'Yes, allow to choose Default Post Attribution.',
              0 => 'No, post as Store Name only.',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', "auth_contSwitch", array(
          'label' => 'Allow Post Attribution Switching in Status Updates, Likes & Comments',
          'description' => 'Do you want to allow members to switch between Stores they own or manage (<a href="admin/estore/settings/store-roles" target="_blank">Click here</a> to configures Store Roles to enable members to become Store managers.) and their personal account to Post status updates, Like and Comments on Stores they own and manage?',
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
              0 => 'As Store',
          ),
          'class' => $class,
          'value' => 0,
      ));
      $this->addElement('Radio', 'store_bgphoto', array(
          'description' => 'Do you want to enable the "Background Photo" functionality for the Stores created by members of this member level? If you choose Yes, then members will be able to upload the photo from dashboard of their Stores.',
          'label' => 'Enable Background Photo',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'bs_contactinfo', array(
          'description' => 'Do you want to enable the "Contact Info" functionality for the Stores created by members of this member level? If you choose Yes, then members will be able to enter the contact details from dashboard of their Stores.',
          'label' => 'Enable Contact Info',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));
      $this->addElement('Radio', 'bs_edit_style', array(
          'description' => 'Do you want to enable "Edit CSS Style" for the Stores created by members of this level? If you choose Yes, then members will be able to edit the CSS Style from dashboard of their Stores.',
          'label' => 'Enable Edit Style',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'class' => $class,
          'value' => 1,
      ));

       $this->addElement('Radio', 'store_service', array(
           'label' => 'Enable Store Service',
           'description' => 'Do you want to enable Store Service for the Stores created by the members of this level?',
           'multiOptions' => array(
               1 => 'Yes',
               0 => 'No',
           ),
           'value' => 1,
       ));


      // Element: album
      $this->addElement('Radio', 'album', array(
          'label' => 'Allow Albums Upload in Stores?',
          'description' => 'Do you want to let members of this level upload albums in Stores? If you choose Yes, then members will be able to create and edit albums & upload photos from "Store Directories - Store Profile Photo Albums" widget placed on Store Profiles.',
          'multiOptions' => array(
              2 => 'Yes, allow members to upload albums on Stores, including private ones.',
              1 => 'Yes, allow members to upload albums in Stores.',
              0 => 'No, do not allow members to upload albums in Stores.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->album->options[2]);
      }
      // Element: auth_photo
      $this->addElement('MultiCheckbox', 'auth_album', array(
          'label' => 'Album Upload Options',
          'description' => 'Your users can choose from any of the options checked below when they decide who can upload albums to their Stores. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Store Admins',
              'member'=> 'Store Members Only',
          ),
          'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner','member'),
      ));
      if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('estorevideo')) {
        // Element: video
        $this->addElement('Radio', 'video', array(
            'label' => 'Allow Videos Upload in Stores?',
            'description' => 'Do you want to let members of this level upload videos in Stores?',
            'multiOptions' => array(
                2 => 'Yes, allow members to upload videos on Stores, including private ones.',
                1 => 'Yes, allow members to upload videos in Stores.',
                0 => 'No, do not allow members to upload videos in Stores.',
            ),
            'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
          unset($this->video->options[2]);
        }
        // Element: auth_photo
        $this->addElement('MultiCheckbox', 'auth_video', array(
            'label' => 'Video Upload Options',
            'description' => 'Your users can choose from any of the options checked below when they decide who can upload videos to their stores. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
            'multiOptions' => array(
                'everyone' => 'Everyone',
                'registered' => 'Registered Members',
                'owner_network' => 'Friends and Networks',
                'owner_member_member' => 'Friends of Friends',
                'owner_member' => 'Friends Only',
                'owner' => 'Store Admins'
            )
        ));
      }
      $this->addElement('Radio', 'auth_announce', array(
          'label' => 'Allow to Manage Announcements',
          'description' => 'Do you want to allow members of this level to manage announcements in their Stores on your website? If you choose Yes, then members will be able to create, edit and manage announcements from dashboard of their Stores.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'bs_allow_roles', array(
          'label' => 'Allow to Manage Store Roles',
          'description' => 'Do you want to allow members of this level to manage Roles in their Stores on your website? If you choose Yes, then members will be able to manage Roles from dashboard of their Stores.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_changeowner', array(
          'label' => 'Allow to Transfer Ownership',
          'description' => 'Do you want to allow members of this level to transfer ownership of their Stores to other members on your website? If you choose Yes, then members will be able to transfer ownership from dashboard of their Stores.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_insightrpt', array(
          'label' => 'Allow to View Insights & Reports',
          'description' => 'Do you want to allow members of this level to view Insights and Reports of their Stores on your website? If you choose Yes, then members will be able to view insights and reports from dashboard of their Stores.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_addbutton', array(
          'label' => 'Allow to "Add a Button" ?',
          'description' => 'Do you want to allow members of this level to add a call to action button to their Stores on your website? If you choose Yes, then members will be able to add the button from their Store Profiles. You can enable / disable this option from the "Store Profile - Cover Photo, Details & Options" widget from Layout Editor.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Text', 'store_count', array(
          'label' => 'Maximum Allowed Stores',
          'description' => 'Enter the maximum number of allowed Stores to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
          ),
          'value' => 10,
      ));
      $this->addElement('Text', 'bs_album_count', array(
          'label' => 'Maximum Allowed Store Albums',
          'description' => 'Enter the maximum number of allowed Store Albums to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
          ),
          'value' => 10,
      ));


        //commission
        $this->addElement('Select', 'estore_admincomn', array(
            'label' => 'Unit for Commission in Store store sell',
            'description' => 'Choose the unit for admin commission in store store sell.',
            'multiOptions' => array(
                1 => 'Percentage',
                0 => 'Fixed'
            ),
            'allowEmpty' => false,
            'required' => true,
            'value' => 1,
        ));
        $this->addElement('Text', "estore_comission", array(
            'label' => 'Commission Value',
            'description' => "Enter the value for commission according to the unit chosen in above setting. [If you have chosen Percentage, then value should be in range 1 to 100.]",
            'allowEmpty' => true,
            'required' => false,
            'value' => 0,
        ));
        $this->addElement('Text', "estore_threshold", array(
            'label' => 'Threshold Amount for Releasing Payment',
            'description' => "Enter the threshold amount which will be required before making request for releasing payment from admins.",
            'allowEmpty' => false,
            'required' => true,
            'value' => 100,
        ));

    }
    $this->addElement('Radio', 'bs_can_join', array(
        'label' => 'Allow to Join Stores ?',
        'description' => 'Do you want to allow members of this level to Join Stores on your website? If you choose Yes, then members will see Join button in various widgets and places on your website. If this setting is chosen Yes for Public Member level, then when a public users click on Join button, they will see Authorization Popup to Login or Sign-up on your website.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));
  }

}
