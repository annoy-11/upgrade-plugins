<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seslisting_Form_Admin_Global extends Engine_Form {

  public function init() {

    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "seslisting_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('seslisting.licensekey'),
    ));
    $this->getElement('seslisting_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('seslisting.pluginactivated')) {

      // if (!$settings->getSetting('seslisting.changelanding', 0)) {
      //   $this->addElement('Radio', 'seslisting_changelanding', array(
      //       'label' => 'Set Welcome Page as Landing Page',
      //       'description' => 'Do you want to set the Default Welcome Page of this plugin as Landing page of your website? [This is a one time setting, so if you choose ‘Yes’ and save changes, then later you can manually make changes in the Landing page from Layout Editor.]',
      //       'multiOptions' => array(
      //           '1' => 'Yes',
      //           '0' => 'No',
      //       ),
      //       'value' => $settings->getSetting('seslisting.changelanding', 0),
      //   ));
      // }

      /* $this->addElement('Radio', 'seslisting_subscription', array(
          'label' => 'Enable Subscription',
          'description' => 'Do you want to allow users to subscribe listing owners? If you choose Yes, then members will get notifications when new listings are posted by members they have subscribed.',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('seslisting.subscription', 0),
      )); */

      $this->addElement('Text', 'seslisting_text_singular', array(
          'label' => 'Singular Text for "Listing"',
          'description' => 'Enter the text which you want to show in place of "Listing" at various places in this plugin like activity feeds, etc.',
          'value' => $settings->getSetting('seslisting.text.singular', 'listing'),
      ));

      $this->addElement('Text', 'seslisting_text_plural', array(
          'label' => 'Plural Text for "Listing"',
          'description' => 'Enter the text which you want to show in place of "Listings" at various places in this plugin like search form, navigation menu, etc.',
          'value' => $settings->getSetting('seslisting.text.plural', 'listings'),
      ));

      $this->addElement('Text', 'seslisting_listing_manifest', array(
          'label' => 'Singular "listing" Text in URL',
          'description' => 'Enter the text which you want to show in place of "listing" in the URLs of this plugin.',
          'value' => $settings->getSetting('seslisting.listing.manifest', 'listing'),
      ));

      $this->addElement('Text', 'seslisting_listings_manifest', array(
          'label' => 'Plural "listings" Text in URL',
          'description' => 'Enter the text which you want to show in place of "listings" in the URLs of this plugin.',
          'value' => $settings->getSetting('seslisting.listings.manifest', 'listings'),
      ));

      // $this->addElement('Radio', 'seslisting_check_welcome', array(
      //     'label' => 'Welcome Page Visibility',
      //     'description' => 'Choose from below the users who will see the Welcome page of this plugin?',
      //     'multiOptions' => array(
      //         0 => 'Only logged in users',
      //         1 => 'Only non-logged in users',
      //         2 => 'Both, logged-in and non-logged in users',
      //     ),
      //     'value' => $settings->getSetting('seslisting.check.welcome', 2),
      // ));

      $this->addElement('Radio', 'seslisting_enable_welcome', array(
          'label' => 'Listing Main Menu Redirection',
          'description' => 'Choose from below where do you want to redirect users when Listings Menu item is clicked in the Main Navigation Menu Bar.',
          'multiOptions' => array(
              // 1 => 'Listing Welcome Page',
              0 => 'Listing Home Page',
              2 => 'Listing Browse Page',
          ),
          'value' => $settings->getSetting('seslisting.enable.welcome', 0),
      ));
      $this->addElement('Radio', 'seslisting_redirect_creation', array(
          'label' => 'Redirection After Listing Creation',
          'description' => 'Choose from below where do you want to redirect users after a listing is successfully created.',
          'multiOptions' => array('1' => 'On Listing Dashboard Page', '0' => 'On Listing Profile Page'),
          'value' => $settings->getSetting('seslisting.redirect.creation', 0),
      ));



      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      /* $this->addElement('Radio', 'seslisting_watermark_enable', array(
          'label' => 'Add Watermark to Photos',
          'description' => 'Do you want to add watermark to photos (from this plugin) on your website? If you choose Yes, then you can upload watermark image to be added to the photos from the <a href="' . $view->baseUrl() . "/admin/seslisting/level" . '">Member Level Settings</a>.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'show_position(this.value)',
          'value' => $settings->getSetting('seslisting.watermark.enable', 0),
      )); */
      /* $this->addElement('Select', 'seslisting_position_watermark', array(
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
          'value' => $settings->getSetting('seslisting.position.watermark', 0),
      ));
      $this->seslisting_watermark_enable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false)); */

      $this->addElement('Text', "seslisting_mainheight", array(
          'label' => 'Large Photo Height',
          'description' => 'Enter the maximum height of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Listing Photo View Page". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('seslisting.mainheight', 1600),
      ));
      $this->addElement('Text', "seslisting_mainwidth", array(
          'label' => 'Large Photo Width',
          'description' => 'Enter the maximum width of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Listing Photo View Page". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('seslisting.mainwidth', 1600),
      ));
      $this->addElement('Text', "seslisting_normalheight", array(
          'label' => 'Medium Photo Height',
          'description' => "Enter the maximum height of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('seslisting.normalheight', 500),
      ));
      $this->addElement('Text', "seslisting_normalwidth", array(
          'label' => 'Medium Photo Width',
          'description' => "Enter the maximum width of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('seslisting.normalwidth', 500),
      ));

      $this->addElement('Radio', "seslisting_other_modulelistings", array(
          'label' => 'Listings Created in Content Visibility',
          'description' => "Choose the visibility of the listings created in a content to only that content (module) or show in Home page, Browse page and other places of this plugin as well? (To enable users to create listings in a content or module, place the widget \"Content Profile Listings\" on the profile page of the desired content.)",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('seslisting.other.modulelistings', 1),
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
      //listing main photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Seslisting/externals/images/nophoto_listing_thumb_profile.png' => ''), $default_photos_main);
        $this->addElement('Select', 'seslisting_default_photo', array(
            'label' => 'Main Default Photo for Listings',
            'description' => 'Choose Main default photo for the listings on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change listing default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('seslisting.listing.default.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo in the File & Media Manager for the main photo. Please upload the Photo to be chosen for main photo from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'seslisting_default_photo', array(
            'label' => 'Main Default Photo for Listings',
            'description' => $description,
        ));
      }
      $this->seslisting_default_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Radio', 'seslisting_enable_location', array(
          'label' => 'Enable Location',
          'description' => 'Do you want to enable location for listings on your website?',
          'multiOptions' => array(
              '1' => 'Yes,Enable Location',
              '0' => 'No,Don\'t Enable Location',
          ),
          'onclick' => 'showSearchType(this.value)',
          'value' => $settings->getSetting('seslisting.enable.location', 1),
      ));

      $this->addElement('Radio', 'seslisting_search_type', array(
          'label' => 'Proximity Search Unit',
          'description' => 'Choose the unit for proximity search of location of listings on your website.',
          'multiOptions' => array(
              1 => 'Miles',
              0 => 'Kilometres'
          ),
          'value' => $settings->getSetting('seslisting.search.type', 1),
      ));

      $this->addElement('Radio', 'seslisting_start_date', array(
          'label' => 'Enable Custom Listing Publish Date',
          'description' => 'Do you want to allow users to choose a custom publish date for their listings. If you choose Yes, then listings on your website will display in activity feeds, various pages and widgets on their publish dates.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => $settings->getSetting('seslisting.start.date', 1),
      ));
			// $this->addElement('Radio', 'seslisting_login_continuereading', array(
   //        'label' => 'Continue Reading Button Redirection for Non-logged in Users',
   //        'description' => 'Do you want to redirect non-logged in users to the login page of your website when they click on "Continue Reading" button on Listing view pages? If you choose No, then users can see Full Listing at the same page.',
   //        'multiOptions' => array(
   //            1 => 'Yes',
   //            0 => 'No',
   //        ),
   //        'value' => $settings->getSetting('seslisting.login.continuereading', 1),
   //    ));

      $this->addElement('Radio', 'seslisting_category_enable', array(
          'label' => 'Make Listing Categories Mandatory',
          'description' => 'Do you want to make category field mandatory when users create or edit their listings?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('seslisting.category.enable', 1),
      ));
      $this->addElement('Radio', 'seslisting_description_mandatory', array(
          'label' => 'Make Listing Description Mandatory',
          'description' => 'Do you want to make description field mandatory when users create or edit their listings?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('seslisting.description.mandatory', 1),
      ));
      $this->addElement('Radio', 'seslisting_photo_mandatory', array(
          'label' => 'Make Listing Main Photo Mandatory',
          'description' => 'Do you want to make main photo field mandatory when users create or edit their listings?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('seslisting.photo.mandatory', 1),
      ));

      $this->addElement('Radio', 'seslisting_enable_sublisting', array(
          'label' => 'Allow to create Sub Listings',
          'description' => 'Do you want to allow users to create sub listings on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('seslisting.enable.sublisting', 1),
      ));

      $this->addElement('Radio', 'seslisting_enable_favourite', array(
          'label' => 'Allow to Favourite Listings',
          'description' => 'Do you want to allow users to favourite listings on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('seslisting.enable.favourite', 1),
      ));

      // $this->addElement('Radio', 'seslisting_enable_bounce', array(
      //     'label' => 'Allow to Bounce Marker for Sponsored Listings',
      //     'description' => 'Do you want to allow maker to bounce for sponsored listings on your website?',
      //     'multiOptions' => array(
      //         '1' => 'Yes',
      //         '0' => 'No',
      //     ),
      //     'value' => $settings->getSetting('seslisting.enable.bounce', 1),
      // ));

      $this->addElement('Radio', 'seslisting_enable_report', array(
          'label' => 'Allow to Report Listings',
          'description' => 'Do you want to allow users to report listings on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('seslisting.enable.report', 1),
      ));

      $this->addElement('Radio', 'seslisting_enable_sharing', array(
          'label' => 'Allow to Share Listings',
          'description' => 'Do you want to allow users to share listings on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('seslisting.enable.sharing', 1),
      ));

      $this->addElement('Radio', 'seslisting_enable_claim', array(
          'label' => 'Allow to Claim Listings',
          'description' => 'Do you want to allow users to claim listings on their website as their listings?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('seslisting.enable.claim', 1),
      ));

      $this->addElement('Select', 'seslisting_taboptions', array(
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
          'value' => $settings->getSetting('seslisting.taboptions', 6),
      ));

//       $this->addElement('Select', 'seslisting_enablelistingdesignview', array(
//           'label' => 'Enable Listing Profile Views',
//           'description' => 'Do you want to enable users to choose views for their Listings? (If you choose No, then you can choose a default layout for the Listing Profile pages on your website.)',
//           'multiOptions' => array(
//               1 => 'Yes',
//               0 => 'No',
//           ),
//           'onchange' => "enablelistingdesignview(this.value)",
//           'value' => $settings->getSetting('seslisting.enablelistingdesignview', 0),
//       ));

//       $chooselayout = $settings->getSetting('seslisting.chooselayout', 'a:4:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";}');
//       $chooselayoutVal = unserialize($chooselayout);
// ;
//       $this->addElement('MultiCheckbox', 'seslisting_chooselayout', array(
//           'label' => 'Choose Listing Profile Pages',
//           'description' => 'Choose layout for the listing profile pages which will be available to users while creating or editing their listings.',
//           'multiOptions' => array(
//               1 => 'Design 1',
//               2 => 'Design 2',
//               3 => 'Design 3',
//               4 => 'Design 4',
//           ),
//           'value' => $chooselayoutVal,
//       ));

      // $this->addElement('Radio', 'seslisting_defaultlayout', array(
      //     'label' => 'Default Listing Profile Page',
      //     'description' => 'Choose default layout for the listing profile pages.',
      //     'multiOptions' => array(
      //         1 => 'Design 1',
      //         2 => 'Design 2',
      //         3 => 'Design 3',
      //         4 => 'Design 4',
      //     ),
      //     'value' => 1,
      // ));

      // // Add submit button
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
