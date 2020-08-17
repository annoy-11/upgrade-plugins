<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "estore_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('estore.licensekey'),
    ));
    $this->getElement('estore_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.pluginactivated')) {
        if(!$settings->getSetting('estore.changelanding', 0)) {
            $this->addElement('Radio', 'estore_changelanding', array(
                'label' => 'Set Welcome Page as Landing Page',
                'description' => 'Do you want to set the Welcome Page of this plugin as Default Landing page of your website? [This is a one time setting, so if you choose ‘Yes’ and save changes, then later you can manually make changes in the Landing page from Layout Editor. Back up page of your current landing page will get created with the name "LP backup from SES Stores".]',
                'onclick' => 'confirmChangeLandingStore(this.value)',
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
                ),
                'value' => $settings->getSetting('estore.changelanding', 0),
            ));
        }
      $this->addElement('Radio', 'estore_check_welcome', array(
          'label' => 'Welcome Page Visibility',
          'description' => 'Who all users do you want to see this "Welcome Page"?',
          'multiOptions' => array(
              0 => 'Only logged in users',
              1 => 'Only non-logged in users',
              2 => 'Both, logged-in and non-logged in users',
          ),
          'value' => $settings->getSetting('estore.check.welcome', 2),
      ));
      $this->addElement('Radio', 'estore_enable_welcome', array(
          'label' => 'Store Main Menu Redirection',
          'description' => 'Choose from below where do you want to redirect users when Store Menu item is clicked in the Main Navigation Menu Bar.',
          'multiOptions' => array(
              1 => 'Store Welcome Page',
              0 => 'Store Home Page',
              2 => 'Store Browse Page'
          ),
          'value' => $settings->getSetting('estore.enable.welcome', 1),
      ));
      $this->addElement('Text', 'estore_stores_manifest', array(
          'label' => 'Plural Text for "stores" in URL',
          'description' => 'Enter the text which you want to show in place of "stores" in the URLs of this plugin.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('estore.stores.manifest', 'stores'),
      ));
      $this->addElement('Text', 'estore_store_manifest', array(
          'label' => 'Singular Text for "store" in URL',
          'description' => 'Enter the text which you want to show in place of "store" in the URLs of this plugin.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('estore.store.manifest', 'store'),
      ));
      $this->addElement('Text', 'estore_text_singular', array(
          'label' => 'Singular Text for "Store"',
          'description' => 'Enter the text which you want to show in place of "Store" at various places in this plugin like activity feeds, etc.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('estore.text.singular', 'store'),
      ));
      $this->addElement('Text', 'estore_text_plural', array(
          'label' => 'Plural Text for "Stores"',
          'description' => 'Enter the text which you want to show in place of "Stores" at various places in this plugin like search form, navigation menu, etc.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('estore.text.plural', 'stores'),
      ));


        $this->addElement('Radio', 'estore_type', array(
            'label' => 'Store Setup: Marketplace By Sellers or Only Admin Stores',
            'description' => 'How do you want to setup the stores on your website - Marketplace by sellers or Stores by admins only? If you choose Marketplace by sellers, then members on your website can open their stores and sell products on your website and if you choose Stores by admins, then only admins will be able to open stores and sell products. (In both the cases you can anytime configure further settings from Member Level Settings to enable / disable the opening of stores, selling products, etc.)',
            'multiOptions' => array(
                '1' => 'Marketplace by Sellers (Multiple Seller-driven Stores)',
                '0' => 'Stores by Admins Only',
            ),
            'value' => $settings->getSetting('estore.type', 1),
        ));

		$this->addElement('Hidden', 'estore_payment_type', array(
		'value' => 1,
		));

        $this->addElement('MultiCheckbox', 'estore_payment_siteadmin', array(
            'label' => 'Payment Gateways',
            'description' => 'Choose from below the Payment Gateways through which you want to receive payment from buyers for the orders from your website. [You can enable the Paypal payment gateway from <a href="admin/payment/gateway" target="_blank">here</a>.]',
            'multiOptions' => array(
            '1' => 'Payment By Cheque',
			'0' => 'Payment by COD (Cash On Delivery)',
            ),
            'value' => $settings->getSetting('estore.payment.siteadmin', array(1,0)),
        ));
        $this->estore_payment_siteadmin->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

        $checkInfo = "Account Name:
Account Number.:
Bank Name:
Branch Address of Bank:
IFSC Code:";
        $this->addElement('Textarea', 'estore_payment_checkinfo', array(
            'label' => 'Bank Details for Cheque',
            'description' => 'Below, enter the details of your bank which will be displayed to buyers for making payment for their orders on your website. Below information will be shown to your buyers on the checkout page when they choose payment by Cheque method.',
            'multiOptions' => $array,
            'value' => $settings->getSetting('estore.payment.checkinfo', $checkInfo),
        ));

		$this->addElement('Radio', 'estore_allow_termncondition', array(
            'label' => 'Allow "Terms & Conditions"',
            'description' => 'Do you want to enable store owners to add "Terms & Conditions" in their stores? ',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => $settings->getSetting('estore_allow_termncondition', 1),
        ));

        $this->addElement('Radio', 'estore_allow_fixedtext', array(
            'label' => 'Custom Text on Checkout Process',
            'description' => 'Do you want to show a custom text in the checkout process on your website?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => $settings->getSetting('estore_allow_fixedtext', 0),
        ));
        $this->addElement('Textarea', 'estore_fixedtext', array(
            'label' => 'Custom Text',
            'description' => 'Enter the custom text that will be displayed in the checkout process.',
            'value' => $settings->getSetting('estore_fixedtext', ''),
        ));
        $this->addElement('Radio', 'estore_minimum_shippingcost', array(
            'label' => 'Allow Minimum Shipping Cost',
            'description' => 'Do you want to allow store owners on your website to choose Minimum Shipping Cost for purchases from their stores?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => $settings->getSetting('estore_minimum_shippingcost', 1),
        ));

      $this->addElement('Radio', 'estore_show_userdetail', array(
          'label' => 'Display Store Owners Name and Photo or Hide Identity',
          'description' => 'Do you want to display Store owners’ name and profile in various widgets and Stores of this plugin? Choosing No for this setting will help you hide the identity of the store owners.',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('estore.show.userdetail', 1),
      ));
      $this->addElement('Radio', 'estore_watermark_enable', array(
          'label' => 'Add Watermark to Photos',
          'description' => 'Do you want to add watermark to photos (from this plugin) on your website? If you choose Yes, then you can upload watermark image to be added to the photos from the <a href="' . $view->baseUrl() . "/admin/estore/level" . '">Member Level Settings</a>.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'show_position(this.value)',
          'value' => $settings->getSetting('estore.watermark.enable', 0),
      ));
      $this->addElement('Select', 'estore_position_watermark', array(
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
          'value' => $settings->getSetting('estore.position.watermark', 0),
      ));
      $this->estore_watermark_enable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      $this->addElement('Text', "estore_mainheight", array(
          'label' => 'Large Photo Height',
          'description' => 'Enter the maximum height of the large main photo (in pixels) for Stores. [Note: This photo will be shown in the lightbox and on " Store View". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estore.mainheight', 1600),
      ));
      $this->addElement('Text', "estore_mainwidth", array(
          'label' => 'Large Photo Width',
          'description' => 'Enter the maximum width of the large main photo (in pixels) for Stores. [Note: This photo will be shown in the lightbox and on "Store View". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estore.mainwidth', 1600),
      ));
      $this->addElement('Text', "estore_normalheight", array(
          'label' => 'Medium Photo Height',
          'description' => "Enter the maximum height of the medium photo (in pixels) for Stores. [Note: This photo will be shown in the various widgets and pages of this plugin. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estore.normalheight', 500),
      ));
      $this->addElement('Text', "estore_normalwidth", array(
          'label' => 'Medium Photo Width',
          'description' => "Enter the maximum width of the medium photo (in pixels) for Stores. [Note: This photo will be shown in the various widgets and pages of this plugin. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estore.normalwidth', 500),
      ));
      $this->addElement('Radio', "estore_enable_contact_details", array(
          'label' => 'Display Contact Details to Non-logged In Users',
          'description' => "Do you want to display contact details of Stores to non-logged in users of your website? If you choose No, then non-logged in users will be asked to login when they try to view the contact details of store in various widgets and places on your website ?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('estore.enable.contact.details', 0),
      ));
      $this->addElement('Radio', "estore_enable_location", array(
          'label' => 'Enable Location',
          'description' => "Do you want to enable location for the Stores on your website? You can choose to “Allow to Add Multiple Locations” in Stores from the Member Level Settings of this plugin.?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('estore.enable.location', 1),
      ));
      $this->addElement('Radio', "estore_location_isrequired", array(
          'label' => 'Make Store Location Mandatory',
          'description' => "Do you want to make Location field mandatory when users create or edit their Stores?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('estore.location.isrequired', 1),
      ));
      $this->addElement('Radio', 'estore_search_type', array(
          'label' => 'Proximity Search Unit (Search via Google API)',
          'description' => 'Choose the unit for proximity search of location of Stores on your website. (Note: This setting will only work when you have enabled location via Google APIs from the Basic Required Plugin. If you have disabled Google APIs, then you will not able to search stores based on their proximity.)',
          'multiOptions' => array(
              1 => 'Miles',
              0 => 'Kilometres'
          ),
          'value' => $settings->getSetting('estore.search.type', 1),
      ));
      $this->addElement('Radio', 'estore_enable_map_integration', array(
          'label' => 'Enable Get Direction Popup (via Google API)',
          'description' => 'Do you want to open the location in Get Direction popup when users click on the Location of Stores at various places and widgets? (Note: This setting will only work when you have enabled location via Google APIs from the Basic Required Plugin. If you have disabled Google APIs, then page locations will not be clickable and Get Direction popup will not come.)',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('estore.enable.map.integration', 1),
      ));

	  $this->addElement('Select', 'estore_weight_matrix', array(
          'label' => 'Default Weight Unit',
          'description' => 'Choose from below the default unit of weight which you want to enable for shipping Method for Products.',
          'multiOptions' => array(
             'lbs' => 'Pound',
             'kg' => 'Kilogram',
             'gm' => 'Gram',
             'oz' => 'Ounce',
         ),
          'value' => $settings->getSetting('estore.weight.matrix', 'lbs'),
      ));

      $this->addElement('Radio', "estore_activityfeed_filter", array(
          'label' => 'Store Feeds Display in Main Feed',
          'description' => "Do you want to display Store feeds to users only from the Stores which they have Liked, Followed, Joined or marked as Favourite? If you want to show feeds from all the Stores to your users, then choose 'No' in this setting.",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('estore.activityfeed.filter', 0),
      ));
      $this->addElement('Radio', "estore_allow_share", array(
          'label' => 'Allow to Share Stores',
          'description' => "Do you want to allow users to share Stores of your website inside on your website and outside on other social networking sites?",
          'multiOptions' => array(
              '2' => 'Yes, allow sharing on this site and on social networking sites both.',
              '1' => ' Yes, allow sharing on this site and do not allow sharing on other Social sites.',
              '0' => 'No, do not allow sharing of Stores.',
          ),
          'value' => $settings->getSetting('estore.allow.share', 1),
      ));
      $this->addElement('Radio', "estore_allow_favourite", array(
          'label' => 'Allow to Favorite Stores',
          'description' => "Do you want to allow members to add Stores on your website to Favorites?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('estore.allow.favourite', 1),
      ));
      $this->addElement('Radio', "estore_allow_follow", array(
          'label' => 'Allow to Follow Stores',
          'description' => "Do you want to allow members to Follow Stores on your website?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('estore.allow.follow', 1),
      ));
      $this->addElement('Radio', "estore_allow_integration", array(
          'label' => 'Integrate Like & Follow Buttons',
          'description' => "Do you want to integrate the Like & Follow buttons of Stores such that when a user will Like a Store, then user will automatically Follow that Store and when user will Follow Store, then that Store will also be Liked?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('estore.allow.integration', 0),
      ));
      $this->addElement('Radio', "estore_allowfollow_category", array(
          'label' => 'Allow to Follow Categories',
          'description' => "Do you want to allow members to Follow Categories of Stores on your website?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('estore.allowfollow.category', 1),
      ));
      $this->addElement('Radio', "estore_allow_report", array(
          'label' => ' Allow to Report',
          'description' => "Do you want to allow users to Report against Stores on your website?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('estore.allow.report', 1),
      ));

      $this->addElement('Radio', "estore_allow_service", array(
        'label' => 'Allow Stores to Add Services',
        'description' => "Do you want to allow store owners to add Services in their Stores on your website?",
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('estore.allow.service', 1),
      ));

      $this->addElement('Radio', "estore_approve_post", array(
          'label' => 'Allow to Enable / Disable Auto-Approval of Store Posts',
          'description' => "Do you want to allow owners of Stores to enable or disable auto-approval of posts in their Stores? If you choose No, then all posts to the Stores will be auto-approved.",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('estore_approve_post', 1),
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
      //no store default photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Estore/externals/images/store-icon.png' => ''), $default_photos_main);
        $this->addElement('Select', 'estore_store_no_photo', array(
            'label' => 'Default Photo for No Store Tip',
            'description' => 'Choose a default photo for No stores tip on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change this default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('estore.store.no.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . 'There are currently no photos in the File & Media Manager. So, photo should be first uploaded from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.' . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'estore_store_no_photo', array(
            'label' => 'Store Default No Store Photo',
            'description' => $description,
        ));
      }
      $this->estore_store_no_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Select', 'estore_taboptions', array(
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
          'value' => $settings->getSetting('estore.taboptions', 6),
      ));

      $this->addElement('Textarea', "estore_receivenewalertemails", array(
        'label' => 'Receive New Store Alerts',
        'description' => 'Enter the comma separated emails in the box below on which you want to receive emails whenever a new Store is created on your website.',
        'value' => $settings->getSetting('estore.receivenewalertemails'),
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
