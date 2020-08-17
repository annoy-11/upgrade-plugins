<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Form_Admin_Global extends Engine_Form
{
  public function init()
  {

    $this
      ->setTitle('Global Settings')
      ->setDescription('These settings affect all members in your community.');

    $settings = Engine_Api::_()->getApi('settings', 'core');

   if ($settings->getSetting('sesproduct.pluginactivated')) {

      $this->addElement('Text', 'sesproduct_text_singular', array(
        'label' => 'Singular Text for "Product"',
        'description' => 'Enter the text which you want to show in place of "Product" at various places in this plugin like activity feeds, etc.',
        'value' => $settings->getSetting('sesproduct.text.singular', 'product'),
      ));

      $this->addElement('Text', 'sesproduct_text_plural', array(
        'label' => 'Plural Text for "Product"',
        'description' => 'Enter the text which you want to show in place of "Products" at various places in this plugin like search form, navigation menu, etc.',
        'value' => $settings->getSetting('sesproduct.text.plural', 'products'),
      ));

      $this->addElement('Text', 'sesproduct_product_manifest', array(
        'label' => 'Singular "product" Text in URL',
        'description' => 'Enter the text which you want to show in place of "product" in the URLs of this plugin.',
        'value' => $settings->getSetting('sesproduct.product.manifest', 'product'),
      ));

      $this->addElement('Text', 'sesproduct_products_manifest', array(
        'label' => 'Plural "products" Text in URL',
        'description' => 'Enter the text which you want to show in place of "products" in the URLs of this plugin.',
        'value' => $settings->getSetting('sesproduct.products.manifest', 'products'),
      ));

      $this->addElement('Radio', 'sesproduct_redirection', array(
        'label' => 'Product Main Menu Redirection',
        'description' => 'Choose from below where do you want to redirect users when Products Menu item is clicked in the Main Navigation Menu Bar.',
        'multiOptions' => array(
          0 => 'Product Home Page',
          1 => 'Product Browse Page',
        ),
        'value' => $settings->getSetting('sesproduct.redirection', 1),
      ));

      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $this->addElement('Radio', 'sesproduct_watermark_enable', array(
          'label' => 'Add Watermark to Photos',
          'description' => 'Do you want to add watermark to photos (from this plugin) on your website? If you choose Yes, then you can upload watermark image to be added to the photos from the <a href="' . $view->baseUrl() . "/admin/sesproduct/level" . '">Member Level Settings</a>.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'show_position(this.value)',
          'value' => $settings->getSetting('sesproduct.watermark.enable', 0),
      ));
      $this->addElement('Select', 'sesproduct_position_watermark', array(
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
          'value' => $settings->getSetting('sesproduct.position.watermark', 0),
      ));
      $this->sesproduct_watermark_enable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Text', "sesproduct_mainheight", array(
          'label' => 'Large Photo Height',
          'description' => 'Enter the maximum height of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Product Photo View Page". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesproduct.mainheight', 1600),
      ));
      $this->addElement('Text', "sesproduct_mainwidth", array(
          'label' => 'Large Photo Width',
          'description' => 'Enter the maximum width of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Product Photo View Page". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesproduct.mainwidth', 1600),
      ));
      $this->addElement('Text', "sesproduct_normalheight", array(
          'label' => 'Medium Photo Height',
          'description' => "Enter the maximum height of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesproduct.normalheight', 500),
      ));
      $this->addElement('Text', "sesproduct_normalwidth", array(
          'label' => 'Medium Photo Width',
          'description' => "Enter the maximum width of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('sesproduct.normalwidth', 500),
      ));

      $this->addElement('Radio', 'sesproduct_enable_location', array(
        'label' => 'Enable Location',
        'description' => 'Do you want to enable location for products on your website?',
        'multiOptions' => array(
          '1' => 'Yes,Enable Location',
          '0' => 'No,Don\'t Enable Location',
        ),
        'onclick' => 'showSearchType(this.value)',
        'value' => $settings->getSetting('sesproduct.enable.location', 1),
      ));

        $this->addElement('Radio', 'sesproduct_location_mandatory', array(
            'label' => 'Make Product Location Mandatory',
            'description' => 'Do you want to make Location field mandatory when users create or edit their Products?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No'
            ),
            'value' => $settings->getSetting('sesproduct.location.mandatory', 1),
        ));

      $this->addElement('Radio', 'sesproduct_search_type', array(
        'label' => 'Proximity Search Unit',
        'description' => 'Choose the unit for proximity search of location of products on your website.',
        'multiOptions' => array(
          1 => 'Miles',
          0 => 'Kilometres'
        ),
        'value' => $settings->getSetting('sesproduct.search.type', 1),
      ));

      $this->addElement('Radio', 'sesproduct_enable_favourite', array(
        'label' => 'Allow to Favourite Products',
        'description' => 'Do you want to allow users to favourite products on your website?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.enable.favourite', 1),
      ));
      $this->addElement('Radio', 'sesproduct_enable_wishlist', array(
        'label' => 'Allow to Add Products to Wishlists',
        'description' => 'Do you want to allow users to add products in their Wishlists on your website?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.enable.wishlist', 1),
      ));

      $this->addElement('Radio', 'sesproduct_enable_report', array(
        'label' => 'Allow to Report Products',
        'description' => 'Do you want to allow users to report products on your website?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.enable.report', 1),
      ));

     $this->addElement('Radio', 'sesproduct_enable_sale', array(
        'label' => 'Display Sale Label',
        'description' => 'Do you want to display SALE label on the products on your website?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.enable.sale', 1),
      ));

      $this->addElement('Radio', 'sesproduct_enable_sharing', array(
        'label' => 'Allow to Share Products',
        'description' => 'Do you want to allow users to share Products of your website inside on your website and outside on other social networking sites?',
        'multiOptions' => array(
          '2' => 'Yes, allow sharing on this site and on social networking sites both.',
          '1' => ' Yes, allow sharing on this site and do not allow sharing on other Social sites.',
          '0' => 'No, do not allow sharing of Stores.',
        ),
        'value' => $settings->getSetting('sesproduct.enable.sharing', 1),
      ));

        $this->addElement('Radio', 'sesproduct_cartdropdown', array(
            'label' => 'Enable Dropdown for Cart',
            'description' => 'Do you want to enable dropdown when someone click cart in the Mini Navigation menu on your website? If you choose No, then users will be redirected to their Cart page.',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No',
            ),
            'value' => $settings->getSetting('sesproduct.cartdropdown', 1),
        ));

        $this->addElement('Select', 'sesproduct_cartviewtype', array(
            'label' => 'Cart View Style',
            'description' => 'Choose from below how do you want to display the cart option in the Mini Navigation Menu of your website.',
            'multiOptions' => array(
                1 => 'Only Text',
                2 => 'Only Icon',
                3 => 'Both Text & Icon',
            ),
            'value' => $settings->getSetting('sesproduct.cartviewtype', 1),
        ));


	 $this->addElement('Radio', 'sesproduct_enablecomparision', array(
            'label' => 'Enable Comparison of Products',
            'description' => 'Do you want to allow users to compare various products on your website?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No',
            ),
            'value' => $settings->getSetting('sesproduct.enablecomparision', 1),
        ));

        $this->addElement('Textarea', 'sesproduct_emailalert', array(
            'label' => 'Email Alert for New Products',
            'description' => 'Below, you can enter the email on which you want to receive the email alert when new product created on your website.',

            'value' => $settings->getSetting('sesproduct.emailalert', ''),
        ));
        $this->addElement('Radio', 'sesproduct_displayips', array(
            'label' => 'Display Buyer\'s IP Address in Orders',
            'description' => 'Do you want to display the IP address of buyer\'s on their orders? If you choose Yes, then the IP from which buyers will make purchase will show in their orders.',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No',
            ),
            'value' => $settings->getSetting('sesproduct.displayips', 1),
        ));
        $this->addElement('Radio', 'sesproduct_specifications', array(
            'label' => 'Show "More Info" in Cart & Checkout',
            'description' => 'Do you want to show "more info" link (which will display the product details on clicking) on manage cart and checkout process pages on your website?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No',
            ),
            'value' => $settings->getSetting('sesproduct.specifications', 1),
        ));
       $this->addElement('Radio', 'sesproduct_payment_mod_enable', array(
           'label' => 'Activate Product Orders',
           'description' => "Do you want to enable orders immediately after payment, before the payment passes the gateways' fraud checks? This may take anywhere from 20 minutes to 4 days, depending on the circumstances and the gateway.",
           'multiOptions' => array(
               'all' => 'Enable Orders immediately.',
               'some' => 'Enable if user has an existing successful transaction, wait if this is their first.',
               'none' => 'Wait until the gateway signals that the payment has completed successfully.'
           ),
           'value' => $settings->getSetting('sesproduct.payment.mod.enable', 'all'),
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
