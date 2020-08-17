<?php

class Sespagepackage_Form_Admin_Package_Create extends Engine_Form {

  protected $_customFields;

  function getCustomFields($customFields) {
    return $this->_customFields;
  }

  public function setCustomFields($customFields) {
    return $this->_customFields = $customFields;
  }

  public function init() {
    $this
            ->setTitle('Create New Package')
            ->setDescription('Here, you can create a new package for pages on your website. Make sure to enter correct information in this package as it can be deleted until someone has not created any page under this package. Also, once this package is created, only the fields Description, Member Levels, Custom Fields, Highlight & Show in Upgrade, can be edited.');
    // Element: title
    $this->addElement('Text', 'title', array(
        'label' => 'Package Title',
        'required' => true,
        'allowEmpty' => false,
        'filters' => array(
            'StringTrim',
        ),
    ));
    // Element: title
    $this->addElement('Text', 'item_count', array(
        'label' => 'Pages Count',
        'description' => 'Enter the maximum number of Pages a member can create in this package. The field must contain an integer, use zero for unlimited. ',
        'required' => true,
        'allowEmpty' => false,
        'filters' => array(
            'StringTrim',
        ),
        'validators' => array(
            new Engine_Validate_AtLeast(0),
        ),
        'value' => '0',
    ));
    // Element: description
    $this->addElement('Textarea', 'description', array(
        'label' => 'Package Description',
        'description' => 'Enter the description for this package. This will be shown in the listing of packages on your website.',
        'validators' => array(
            array('StringLength', true, array(0, 250)),
        )
    ));
    // Element: level_id
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
      if ($level->type == 'public') {
        continue;
      }
      $multiOptions[$level->getIdentity()] = $level->getTitle();
    }
    $multiOptions = array_merge(array('0' => 'All Levels'), $multiOptions);
    $this->addElement('Multiselect', 'member_level', array(
        'label' => 'Member Level',
        'description' => 'Only the selected member levels will be allowed to view and purchase this package for creating pages on your site.',
        'multiOptions' => $multiOptions,
        'value' => '0'
    ));
    // Element: price
    $this->addElement('Text', 'price', array(
        'label' => 'Price',
        'description' => 'Enter the amount to be charged from users for creating pages under this package. This amount will be charged only once for one-time plans and at each billing cycle for recurring plans. Use ‘0’ to make this package Free.',
        'required' => true,
        'allowEmpty' => false,
        'validators' => array(
            array('Float', true),
            new Engine_Validate_AtLeast(0),
        ),
        'value' => '0.00',
    ));
    // Element: recurrence
    $this->addElement('Duration', 'recurrence', array(
        'label' => 'Billing Cycle',
        'description' => 'How often should members in this package be billed?',
        'required' => true,
        'allowEmpty' => false,
        'value' => array(1, 'month'),
    ));
    // Element: duration
    $this->addElement('Duration', 'duration', array(
        'label' => 'Billing Duration',
        'description' => 'When should this package expire? For one-time package, the package will expire after the period of time set here. For recurring plans, the user will be billed at the above billing cycle for the period of time specified here.',
        'required' => true,
        'allowEmpty' => false,
        'value' => array('0', 'forever'),
    ));
    // renew
    $this->addElement('Select', 'is_renew_link', array(
        'description' => 'Renew Link',
        'label' => 'Want to show reniew link',
        'value' => 0,
        'multiOptions' => array('1' => 'Yes, show reniew link', '0' => 'No, don\'t show renew link'),
        'onchange' => 'showRenewData(this.value);',
    ));
    $this->addElement('Text', 'renew_link_days', array(
        'label' => 'Days before show renew link',
        'description' => 'Show renewal link before how many days before expiry.',
        'required' => true,
        'allowEmpty' => false,
        'validators' => array(
            array('Int', true),
            new Engine_Validate_AtLeast(0),
        ),
        'value' => '0',
    ));

    $this->addElement('Radio', 'upload_cover', array(
        'label' => 'Allow to Upload Page Cover Photo',
        'description' => 'Do you want to allow the users to upload cover photo for their pages created under this package? If set to No, then the default cover photo will get displayed instead.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));

    $this->addElement('Radio', 'upload_mainphoto', array(
        'label' => 'Allow to Upload Page Main Photo',
        'description' => 'Do you want to allow the users to upload main photo for their pages created under this package? If set to No, then the default main photo will get displayed instead.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));

    $this->addElement('Radio', 'page_choose_style', array(
        'label' => 'Enable Page Profile Designs Selection',
        'description' => 'Do you want to enable users to choose designs for their Page Profiles for pages created under this package? (If you choose No, then you can choose a default layout for the Page Profile pages on your website.)',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));

    $this->addElement('MultiCheckbox', 'page_chooselayout', array(
        'label' => 'Choose Page Profile Design',
        'description' => 'Choose design for the page profile pages which will be available to users while creating or editing their pages.',
        'multiOptions' => array(
            1 => 'Template 1',
            2 => 'Template 2',
            3 => 'Template 3',
            4 => 'Template 4',
        ),
        'value' => array('1', '2', '3', '4'),
    ));

    // Element: auth_view
    $this->addElement('Radio', 'page_style_type', array(
        'label' => 'Default Page Profile Design',
        'description' => 'Choose default design for the page profile page of the pages created under this package.',
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
      $this->addElement('Select', 'pagedefaultphoto', array(
          'label' => 'Default Main Photo for Pages',
          'description' => 'Choose main default photo for the pages of on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change page default photo.]',
          'multiOptions' => $default_photos,
      ));
      $this->addElement('Select', 'defaultCphoto', array(
          'label' => 'Default Cover Photo for Pages',
          'description' => 'Choose default cover photo for the pages of on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change page default photo.]',
          'multiOptions' => $default_photos,
      ));
    } else {
      $description = "<div class='tip'><span>" . 'There are currently no photo in the File & Media Manager. Please upload the Photo to be chosen from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manage</a>" section.' . "</span></div>";
      //Add Element: Dummy
      $this->addElement('Dummy', 'pagedefaultphoto', array(
          'label' => 'Default Main Photo for Pages',
          'description' => $description,
      ));
      $this->addElement('Dummy', 'defaultCphoto', array(
          'label' => 'Choose default cover photo for the pages of on your website.',
          'description' => $description,
      ));
    }
    $this->pagedefaultphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    $this->defaultCphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    $this->addElement('Radio', 'page_approve', array(
        'description' => 'Do you want pages created under this package to be auto-approved?',
        'label' => 'Auto Approve Pages',
        'multiOptions' => array(
            1 => 'Yes, auto-approve pages.',
            0 => 'No, do not auto-approve pages.'
        ),
        'value' => 1,
    ));

    $information = array('featured' => 'Featured', 'sponsored' => 'Sponsored', 'verified' => 'Verified', 'hot' => 'Hot', 'custom_fields' => 'Custom Fields');
    $showinfo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepackage.package.info', array_keys($information));
    if (in_array('featured', $showinfo)) {
      //element for page featured
      $this->addElement('Radio', 'page_featured', array(
          'description' => 'Do you want pages created under this package to be automatically marked as Featured?',
          'label' => 'Automatically Mark Pages as Featured',
          'multiOptions' => array(
              1 => 'Yes, automatically mark pages as Featured',
              0 => 'No, do not automatically mark pages as Featured',
          ),
          'value' => 0,
      ));
    }
    if (in_array('sponsored', $showinfo)) {
      //element for page sponsored
      $this->addElement('Radio', 'page_sponsored', array(
          'description' => '“Do you want pages created under this package to be automatically marked as Sponsored?”',
          'label' => 'Automatically Mark Pages as Sponsored',
          'multiOptions' => array(
              1 => 'Yes, automatically mark pages as Sponsored',
              0 => 'No, do not automatically mark pages as Sponsored',
          ),
          'value' => 0,
      ));
    }
    if (in_array('verified', $showinfo)) {
      //element for page verified
      $this->addElement('Radio', 'page_verified', array(
          'description' => 'Do you want pages created under this package to be automatically marked as Verified?',
          'label' => 'Automatically Mark Pages as Verified',
          'multiOptions' => array(
              1 => 'Yes, automatically mark pages as Verified',
              0 => 'No, do not automatically mark pages as Verified',
          ),
          'value' => 0,
      ));
    }
    if (in_array('hot', $showinfo)) {
      //element for page verified
      $this->addElement('Radio', 'page_hot', array(
          'description' => ' Do you want pages created under this package to be automatically marked as Hot?',
          'label' => 'Automatically Mark Pages as Hot',
          'multiOptions' => array(
              1 => 'Yes, automatically mark pages as Hot',
              0 => 'No, do not automatically mark pages as Hot',
          ),
          'value' => 0,
      ));
    }



    //start
    $this->addElement('Radio', "enable_price", array(
          'label' => 'Enable Price',
          'description' => "Do you want to enable Price for the Pages created by members of this level? If you choose Yes, then members will be able to enter price from dashboard of their Pages.",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "price_mandatory", array(
          'label' => 'Make Page Price Mandatory',
          'description' => "Do you want to make Price field mandatory when users create or edit their Pages?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "can_chooseprice", array(
          'label' => 'Allow Owners to Select Price Type',
          'description' => "Do you want to allow owners of Pages to select the price type for their Pages?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', "default_prztype", array(
          'label' => 'Default Price Type',
          'description' => "Choose a Default Price Type for the Pages on your website. This type will be shown with the price of Pages on your website and will be an indicator of whether the Page has the Price or the Starting Price of various products, services, etc of that Page.",
          'multiOptions' => array(
              '1' => 'Show "Price"',
              '2' => 'Show "Starting Price"',
          ),
          'value' => 1,
      ));

      $this->addElement('Radio', 'page_service', array(
           'label' => 'Enable Page Service',
           'description' => 'Do you want to enable Page Service for the Pages created by the members of this level?',
           'multiOptions' => array(
               1 => 'Yes',
               0 => 'No',
           ),
           'value' => 1,
       ));

       $this->addElement('Radio', 'auth_announce', array(
          'label' => 'Allow to Manage Announcements',
          'description' => 'Do you want to allow members of this level to manage announcements in their Pages on your website? If you choose Yes, then members will be able to create, edit and manage announcements from dashboard of their Pages.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));

      $this->addElement('Radio', 'auth_insightrpt', array(
          'label' => 'Allow to View Insights & Reports',
          'description' => 'Do you want to allow members of this level to view Insights and Reports of their Pages on your website? If you choose Yes, then members will be able to view insights and reports from dashboard of their Pages.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_addbutton', array(
          'label' => 'Allow to "Add a Button" ?',
          'description' => 'Do you want to allow members of this level to add a call to action button to their Pages on your website? If you choose Yes, then members will be able to add the button from their Page Profiles. You can enable / disable this option from the "Page Profile - Cover Photo, Details & Options" widget from Layout Editor.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Radio', 'auth_contactpage', array(
          'label' => 'Enable Contact Page Members',
          'description' => 'Do you want to enable the "Contact Page Members" functionality for the Pages created by the members of this level? If you choose yes, then members will be able to contact their Page members from dashboard of their Pages.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));
      $this->addElement('Radio', 'album', array(
          'label' => 'Allow Albums Upload in Pages?',
          'description' => 'Do you want to let members upload albums in Pages? If you choose Yes, then members will be able to create and edit albums & upload photos from "Page Directories - Page Profile Photo Albums" widget placed on Page Profiles.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
    //end

    //Note Extension Work
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespagenote')) {
      $this->addElement('Radio', 'note', array(
          'label' => 'Allow Notes Create in Pages?',
          'description' => 'Do you want to let members create notes in Pages? If you choose Yes, then members will be able to create and edit notes from "Page Notes Extension - Page Profile Notes" widget placed on Page Profiles.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
    }

    //Offer Extension Work
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespageoffer')) {
      $this->addElement('Radio', 'note', array(
          'label' => 'Allow Offers Create in Pages?',
          'description' => 'Do you want to let members create offers in Pages? If you choose Yes, then members will be able to create and edit offers from "Page Offers Extension - Page Profile Offers" widget placed on Page Profiles.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
    }

    $this->addElement('Radio', 'page_seo', array(
        'description' => 'Do you want to enable the “SEO” fields for the pages created created under this package?',
        'label' => 'Enable SEO Fields',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));
    $this->addElement('Radio', 'page_overview', array(
        'description' => 'Do you want to enable the “Overview” for the pages created under this package?',
        'label' => 'Enable Overview',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));
    $this->addElement('Radio', 'page_bgphoto', array(
        'description' => 'Do you want to enable the “Background Photo” of the pages created under this package?',
        'label' => 'Enable Background Photo',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));
    $this->addElement('Radio', 'page_contactinfo', array(
        'description' => 'Do you want to enable the “Contact Info” for the pages created under this package?',
        'label' => 'Enable Contact Info',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));
    if (in_array('custom_fields', $showinfo)) {
      $this->addElement('Radio', 'custom_fields', array(
          'label' => 'Allow Custom Fields',
          'description' => 'Do you want to allow users to fill custom fields in the pages created under this Package?',
          'value' => 0,
          'onclick' => 'customField(this.value)',
          'multiOptions' => array(
              1 => 'Yes, allow to fill all available custom fields.',
              0 => 'No, do not allow to fill custom fields.',
              2 => 'Yes, allow to fill selected custom fields only.',
          ),
          'value' => 1
      ));
      $this->addElement('Dummy', 'customfields', array(
          'ignore' => true,
          'decorators' => array(array('ViewScript', array(
                      'viewScript' => '_customFields.tpl',
                      'class' => 'form element',
                      'customFields' => $this->_customFields,
                  )))
      ));
    }

    //entry fees setting
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespagejoinfees') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagejoinfees.allow.entryfees', 0)) {
      //commission
      $this->addElement('Select', 'sespage_admin_commission', array(
          'label' => 'Unit for Commission',
          'description' => 'Choose the unit for admin commission which you will get on the page fees.',
          'multiOptions' => array(
              1 => 'Percentage',
              2 => 'Fixed'
          ),
          'allowEmpty' => false,
          'required' => true,
          'value' => 1,
      ));
      $this->addElement('Text', "sespage_commission_value", array(
          'label' => 'Commission Value',
          'description' => "Enter the value for commission according to the unit chosen in above setting. [If you have chosen Percentage, then value should be in range 1 to 100.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => 0,
      ));
      $this->addElement('Text', "sespage_threshold_amount", array(
          'label' => 'Threshold Amount for Releasing Payment',
          'description' => "Enter the threshold amount which will be required before making request for releasing payment from admins. [Note: Threshold Amount is remaining amount which the owner of the page will get after subtracting the admin commission from the total amount received.]",
          'allowEmpty' => false,
          'required' => true,
          'value' => 100,
      ));
    }
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespagejurymember')) {
      $this->addElement('Radio', 'can_add_jury', array(
          'label' => 'Allow to Add Jury Members',
          'description' => 'Do you want to allow page owners of this member level to add Jury Members to their pages? If you choose Yes, then page owners will be able to choose from “Jury Members”, “Site members” or “Both” to vote for entries in their pages or not.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $this->addElement('Text', 'jury_member_count', array(
          'label' => 'Jury Member Count',
          'description' => 'Enter the number of Jury members to be added in the pages created by user of this member level.',
          'class' => $class,
          'validators' => array(
              array('Int', true),
              new Engine_Validate_AtLeast(1),
          ),
          'value' => 2,
      ));
    }

    // Element: highlight
    $this->addElement('Select', 'highlight', array(
        'label' => 'Highlight Package',
        'description' => 'Do you want to highlight this package among all other packages on your website. If you choose yes, then this package will be shown with some highlight effect to users.',
        'multiOptions' => array(
            '1' => 'Yes, want to highlight this package.',
            '0' => 'No, don\'t want to highlight this package.',
        ),
        'value' => 0,
    ));
    // Element: highlight
    $this->addElement('Select', 'show_upgrade', array(
        'label' => 'Show In Upgrade?',
        'description' => 'Do you want to show this package in Upgrade Package section in the dashboard of the pages? This package will show only for the pages which are created under the package of lower price than this package.',
        'multiOptions' => array(
            '1' => 'Yes, want to show this package in upgrade section.',
            '0' => 'No, don\'t want to show this package in upgrade section.',
        ),
        'value' => 0,
    ));
    // Element: enabled
    $this->addElement('Select', 'enabled', array(
        'label' => 'Enabled?',
        'description' => 'Do you want to enable this package? (The existing members that were in that plan would stay in that plan until they pick another plan.)',
        'multiOptions' => array(
            '1' => 'Yes, users may select this plan.',
            '0' => 'No, users may not select this plan.',
        ),
        'value' => 1,
    ));
    // Element: execute
    $this->addElement('Button', 'execute', array(
        'label' => 'Create Package',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
    ));
    // Element: cancel
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'prependText' => ' or ',
        'ignore' => true,
        'link' => true,
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'decorators' => array('ViewHelper'),
    ));
    // DisplayGroup: buttons
    $this->addDisplayGroup(array('execute', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        )
    ));
  }

}
