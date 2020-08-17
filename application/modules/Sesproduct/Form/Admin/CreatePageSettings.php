<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CreatePageSettings.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Form_Admin_CreatePageSettings extends Engine_Form {
  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Product Creation Settings')
            ->setDescription('Here, you can choose the settings which are related to the creation of Products on your website. The settings enabled or disabled will effect Product creation page, and Edit page');

/*
    $this->addElement('Radio', 'sesproduct_category_selection', array(
        'label' => 'Choose Category Before Creating Product"',
        'description' => 'Do you want to show the Category Selection Form as the first step, when user creates a Product. If Yes, then users will be moved to Product Create Form only after selecting the category. If No, then user will be directly moved to Product Create Form.',
        'multiOptions' => array(
            '1' => "YES",
            '0' => "NO",
        ),
        'value' => $settings->getSetting('sesproduct.category.selection', 0),
        'onclick' => 'showCategoryIcon(this.value)',
    ));

    $this->addElement('Radio', 'sesproduct_category_icon', array(
        'label' => 'Category Photo Display',
        'description' => 'Choose from below the which photo of categories do you display with category names. You can upload and esti these photos from the "Categories & Profile Fields" section of this plugin.',
        'multiOptions' => array(
            1 => 'Icon',
            0 => 'Colored Icon',
            2 => 'Thumbnail',
        ),
        'value' => $settings->getSetting('sesproduct.category.icon', 1),
    ));
*/

    $this->addElement('Select', 'sesproduct_redirect_creation', array(
        'label' => 'Redirection After Product Creation',
        'description' => 'Choose from below where you want to redirect users after a Product is successfully created.',
        'multiOptions' => array(
             '0' => 'On Product Profile (View Page)',
            '1' => 'On Product Dashboard',

        ),
        'value' => $settings->getSetting('sesproduct.redirect.creation', 1),
    ));
    $this->addElement('Radio', 'sesproduct_create_accordian', array(
        'label' => 'Create Product Form Type',
        'description' => 'What type of Form you want to show on Create New Product?',
        'multiOptions' => array(
            0 => 'Default SE Form',
            1 => 'Accordion Form'
        ),
        'value' => $settings->getSetting('sesproduct.create.accordian', 1),
    ));
    $this->addElement('Select', 'sesproduct_autoopenpopup', array(
        'label' => 'Auto-Open Advanced Share Popup',
        'description' => 'Do you want the "Advanced Share Popup" to be auto-populated after the Product is created? [Note: This setting will only work if you have placed Advanced Share widget on Product View or Product Dashboard, wherever user is redirected just after Product creation.]',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.autoopenpopup', 1),
    ));

    $this->addElement('Radio', 'sesproduct_enable_productdescription', array(
        'label' => 'Enable Product Description',
        'description' => ' Do you want to enable description of products on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesproduct.enable.productdescription', 1),
        'onclick' => 'showDescriptionOption(this.value)',
    ));


    $this->addElement('Radio', 'sesproduct_description_mandatory', array(
        'label' => 'Make Product Description Mandatory',
        'description' => 'Do you want to make Description field mandatory when users create or edit their Product ?',
        'multiOptions' => array(
            '1' => "Yes",
            '0' => "No",
        ),
        'value' => $settings->getSetting('sesproduct.description.mandatory', 0),
    ));
    $this->addElement('Radio', 'sesproduct_enable_wysiwyg', array(
        'label' => 'Enable WYSIWYG Editor',
        'description' => 'Do you want to enable the WYSIWYG Editor for the product description? If you choose No, then simple text area will be displayed.',
        'multiOptions' => array(
            1 => 'Yes, show WYSIWYG editor',
            0 => 'No, show only Text Area'
        ),
        'value' => $settings->getSetting('sesproduct.enable.wysiwyg', 0),
    ));


    $this->addElement('Radio', 'sesproduct_category_mandatory', array(
        'label' => 'Make Product Categories Mandatory',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesproduct.category.mandatory', 0),
		'description' => 'Do you want to make category field mandatory when users create or edit their products?'
    ));

    $this->addElement('Radio', 'sesproduct_pagetags', array(
        'label' => 'Enable Tags',
        'description' => ' Do you want to enable tags for the Products on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.pagetags', 1),
    ));

    $this->addElement('Radio', 'sesproduct_enable_discount', array(
        'label' => 'Enable Discount',
        'description' => 'Do you want to enable discounts for products on your website? If you choose Yes, then store owners can configure discounts for their products.',
        'multiOptions' => array(
           '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.enable.discount', 1),
    ));


/*    $this->addElement('Radio', 'sesproduct_enablesku', array(
        'label' => 'Enable Product SKU',
        'description' => 'Do you want to enable SKU for the products on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.enable.sku', 0),
    ));
*/


    $this->addElement('Radio', 'sesproduct_enable_brand', array(
        'label' => 'Enable Brand Field',
        'description' => 'Do you want to enable the Brand field for products on your website?(If enabled, this field will display on supported product types.) (You can enter the Brands from Manage Brands section of this plugin.)',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.enable.brand', 0),
    ));

    $this->addElement('Radio', 'sesproduct_enable_stockmanagement', array(
        'label' => 'Allow for Products\' Stock Management',
        'description' => 'Do you want to allow store owners to manage stocks of their products on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.enable.stockmanagement', 1),
        'onclick' => 'showStockManagement(this.value);',
    ));

    $this->addElement('Radio', 'sesproduct_outofstock', array(
        'label' => 'Display Out of Stock Products',
        'description' => 'Do you want to allow store owners to choose to display their products when their product goes out of stock?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.outofstock', 1),
    ));

    $this->addElement('Radio', 'sesproduct_backinstock', array(
        'label' => 'Enable to Contact for Back in Stock',
        'description' => 'Do you want to enable store owners to choose to allow users to contact them for the product back in stock?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.backinstock', 1),
    ));

    $this->addElement('Radio', 'sesproduct_minquantity', array(
        'label' => 'Enable Minimum Order Quantity',
        'description' => 'Do you want to enable store owners to choose the Minimum Order Quantity for their products on your website? If you choose No, then minimum order quantity will set to 1 by default for the products.',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.minquantity', 1),
    ));
    $this->addElement('Radio', 'sesproduct_maxquantity', array(
        'label' => 'Maximum Order Quantity',
        'description' => 'Do you want to enable store owners to choose the Maximum Order Quantity for their products on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.maxquantity', 1),
    ));
    $this->addElement('Radio', 'sesproduct_purchasenote', array(
        'label' => 'Enable Purchase Note',
        'description' => 'Do you want to enable store owners to enter Purchase Note for their products on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.purchasenote', 1),
    ));
    $this->addElement('Radio', 'sesproduct_reviews', array(
        'label' => 'Choose to Enable / Disable Reviews',
        'description' => 'Do you want store owners to choose to enable / disable reviews for their products on your website? If you choose No, then reviews will be enabled for all products on your website. (This setting will work only when you have Allowed Reviews from “Reviews & Ratings Settings” section of products in this plugin.)',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.reviews', 1),
    ));
    $this->addElement('Select', 'sesproduct_weight_matrix', array(
        'label' => 'Default Weight Unit',
        'description' => 'Choose from below the default unit of weight which you want to enable for the products on your website.',
        'multiOptions' => array(
            '1' => 'Pound',
            '2' => 'Kilogram',
            '3' => 'Gram',
            '4' => 'Ounce',
        ),
        'value' => $settings->getSetting('sesproduct.weight.matrix', 1),
    ));
    $this->addElement('Radio', 'sesproduct_dimension_matrix', array(
        'label' => 'Default "Dimensions" Matrix',
        'description' => 'Choose the default unit of dimensions for the products on your website.',
        'multiOptions' => array(
            '1' => 'Cm',
            '2' => 'Inch',
            '3' => 'Feet',
            '4' => 'meter (m)',
        ),
        'value' => $settings->getSetting('sesproduct.dimension.matrix', 1),
    ));
    $this->addElement('Radio', 'sesproduct_start_date', array(
        'label' => 'Enable Custom Product Start Date',
        'description' => 'Do you want to allow store owners to choose a custom start date for their products?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.start.date', 1),
    ));
    $this->addElement('Radio', 'sesproduct_end_date', array(
        'label' => 'Enable Custom Product End Date',
        'description' => 'Do you want to allow store owners to choose a custom end date for their products?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.end.date', 1),
    ));
    $this->addElement('Radio', 'sesproduct_search', array(
        'label' => 'Enable "People can search for this Product" Field',
        'description' => 'Do you want to enable “People can search for this Product” field while creating and editing Product on your website?',
         'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.search', 1),
    ));

    $this->addElement('Radio', 'sesproduct_product', array(
        'label' => 'Enable / Disable Products',
        'description' => 'Do you want to allow store owners to choose to enable / disable their products on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.product', ''),
    ));
    $this->addElement('Radio', 'sesproduct_photo_mandatory', array(
        'label' => 'Make Product Main Photo Mandatory',
        'description' => 'Do you want to make Main Photo field mandatory when users create or edit their Products?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.photo.mandatory', 1),
    ));

 /*
    $this->addElement('Radio', 'sesproduct_sku_mandatory', array(
        'label' => 'Make Product SKU Mandatory',
        'description' => 'Do you want to make SKU field mandatory when users create or edit their Products?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.sku.mandatory', 1),
    ));

*/
    $this->addElement('Radio', 'sesproduct_guidline', array(
        'label' => 'Product Creation Guidelines',
        'description' => 'Do you want to provide Store owners with some Guidelines for creating their products? If yes, then the box containing the guidelines will remain static on the top right of the create page when user scroll down the form.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('sesproduct.guidline', 1),
        'onclick' => 'showGuideEditor(this.value)',
    ));

     $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';

    $editorOptions = array(
        'html' => (bool) $allowed_html,
    );
    $editorOptions['plugins'] = array(
        'preview', 'code',
    );
    $this->addElement('TinyMce', 'sesproduct_message_guidelines', array(
        'label' => 'Enter Guidelines',
        'class' => 'tinymce',
        'editorOptions' => $editorOptions,
        'value' => $settings->getSetting('sesproduct.message.guidelines', ''),
    ));

       // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));

    }
}
