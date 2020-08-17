<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
  public function init()
  {
    parent::init();
    $settings =Engine_Api::_()->getApi('settings', 'core');
    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("These settings are applied as per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level from below.");

    // Element: view
    $this->addElement('Radio', 'view', array(
      'label' => 'Allow Viewing of Products?',
      'description' => 'Do you want to let members view products? If set to no, some other settings on this page may not apply.',
      'multiOptions' => array(
        2 => 'Yes, allow members to view all products, even private ones.',
        1 => 'Yes, allow members to view their own products.',
        0 => 'No, do not allow products to be viewed.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }

    if( !$this->isPublic() ) {

      // Element: create
	$this->addElement('Hidden', 'create', array(
    //    'label' => 'Allow Creation of Products?',
      //  'description' => 'Do you want to let members create products? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view products, but only want certain levels to be able to create products.',
      /*  'multiOptions' => array(
          1 => 'Yes, allow creation of products.',
          0 => 'No, do not allow products to be created.'
        ), */
        'value' => 1,
		'order' => 24567,
      ));

      // Element: edit
      $this->addElement('Hidden', 'edit', array(
      //  'label' => 'Allow Editing of Products?',
      //  'description' => 'Do you want to let members edit products? If set to no, some other settings on this page may not apply.',
       // 'multiOptions' => array(
       /*   2 => 'Yes, allow members to edit all products.',
          1 => 'Yes, allow members to edit their own products.',
          0 => 'No, do not allow members to edit their products.',
        ), */
        'value' => ( $this->isModerator() ? 2 : 1 ),
		'order' => 24568,
      ));
   //   if( !$this->isModerator() ) {
     //   unset($this->edit->options[2]);
    //  }

      // Element: delete
      $this->addElement('Hidden', 'delete', array(
   /*     'label' => 'Allow Deletion of Products?',
        'description' => 'Do you want to let members delete products? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all products.',
          1 => 'Yes, allow members to delete their own products.',
          0 => 'No, do not allow members to delete their products.',
        ), */
        'value' => ( $this->isModerator() ? 2 : 1 ),
		'order' => 24569,
      ));
      // if( !$this->isModerator() ) {
      // unset($this->delete->options[2]);
      //}

      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Products?',
        'description' => 'Do you want to let members of this level comment on products?',
        'multiOptions' => array(
          2 => 'Yes, allow members to comment on all products, including private ones.',
          1 => 'Yes, allow members to comment on products.',
          0 => 'No, do not allow members to comment on products.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->comment->options[2]);
      }

    // Element: comment
      $this->addElement('MultiCheckbox', 'allowed_types', array(
        'label' => 'Allow Products Types?',
        'description' => 'Choose the product types which members of this level will be able to create in their stores.',
        'multiOptions' => array(
          'simpleProduct' => 'Simple Product',
        //  'groupedProduct' => 'Grouped Product',
			//		'bundledProduct' => 'Bundled Product',
         // 'virtualProduct' => 'Virtual Product',
          'configurableProduct' => 'Configurable/Variable Product',
         // 'downloadableProduct' => 'Downloadable Product',
         // 'externalProduct' =>  'External / Affiliate Product',
        ),
        'value' => array('simpleProduct','configurableProduct'),
      ));



				 // Element: watermark
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
			$banner_options[] = '';
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
				$banner_options['public/admin/' . $base_name] = $base_name;
			}
			$fileLink = $view->baseUrl() . '/admin/files/';
			if (count($banner_options) > 1) {
				$this->addElement('Select', 'watermark', array(
						'label' => 'Add Watermark to Main Photos',
						'description' => 'Choose a photo which you want to be added as watermark on the main photos upload by the members of this level on your website.',
						'multiOptions' => $banner_options,
				));
			} else {
				$description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo for watermark. Photo to be chosen for watermark should be first uploaded from the "Layout" >> "<a href="' . $fileLink . '" target="_blank">File & Media Manager</a>" section.') . "</span></div>";
				//Add Element: Dummy
				$this->addElement('Dummy', 'watermark', array(
						'label' => 'Add Watermark to Main Photos',
						'description' => $description,
				));
				$this->watermark->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
		}

			 // Element: thumb watermark
			if (count($banner_options) > 1) {
				$this->addElement('Select', 'watermarkthumb', array(
						'label' => 'Add Watermark to Thumb Photos',
						'description' => 'Choose a photo which you want to be added as watermark on the thumb photos upload by the members of this level on your website.',
						'multiOptions' => $banner_options,
				));
			} else {
				$description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo for watermark. Photo to be chosen for watermark should be first uploaded from the "Layout" >> "<a href="' . $fileLink . '" target="_blank">File & Media Manager</a>" section.') . "</span></div>";
				//Add Element: Dummy
				$this->addElement('Dummy', 'watermarkthumb', array(
						'label' => 'Add Watermark to Thumb Photos',
						'description' => $description,
				));
				$this->watermarkthumb->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
		}

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
        //product main photo
        if (count($default_photos_main) > 0) {
            $default_photos = array_merge(array('application/modules/Sesproduct/externals/images/nophoto_product_thumb_profile.png'=>''),$default_photos_main);
            $this->addElement('Select', 'default_photo', array(
                'label' => 'Main Default Photo for Products',
                'description' => 'Choose Main default photo for the products on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change product default photo.]',
                'multiOptions' => $default_photos,
                'value' => $settings->getSetting('sesproduct.product.default.photo'),
            ));
        } else {
            $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo in the File & Media Manager for the main photo. Please upload the Photo to be chosen for main photo from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.') . "</span></div>";
            //Add Element: Dummy
            $this->addElement('Dummy', 'default_photo', array(
                'label' => 'Main Default Photo for Products',
                'description' => $description,
            ));
        }
        $this->default_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

        //element for event approve
        $this->addElement('Radio', 'product_approve', array(
            'description' => 'Do you want products created by members of this level to be auto-approved?',
            'label' => 'Auto Approve Products',
            'multiOptions' => array(
                1=>'Yes, auto-approve products.',
                0=>'No, do not auto-approve products.'
            ),
            'value' => 1,
        ));


      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
        'label' => 'Product Privacy',
        'description' => 'Your members can choose from any of the options checked below when they decide who can see their product entries. These options appear on your members\' "Add Entry" and "Edit Entry" pages. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
        'multiOptions' => array(
          'everyone'            => 'Everyone',
          'registered'          => 'All Registered Members',
          'owner_network'       => 'Friends and Networks',
          'owner_member_member' => 'Friends of Friends',
          'owner_member'        => 'Friends Only',
          'owner'               => 'Just Me'
        ),
        'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner','registered'),
      ));

      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
        'label' => 'Product Comment Options',
        'description' => 'Your members can choose from any of the options checked below when they decide who can post comments on their entries. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
        'multiOptions' => array(
          'everyone'            => 'Everyone',
          'registered'          => 'All Registered Members',
          'owner_network'       => 'Friends and Networks',
          'owner_member_member' => 'Friends of Friends',
          'owner_member'        => 'Friends Only',
          'owner'               => 'Just Me'
        ),
        'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner','registered'),
      ));

      // Element: style
      $this->addElement('Radio', 'style', array(
        'label' => 'Allow Custom CSS Styles?',
        'description' => 'If you enable this feature, your members will be able to customize the colors and fonts of their products by altering their CSS styles.',
        'multiOptions' => array(
          1 => 'Yes, enable custom CSS styles.',
          0 => 'No, disable custom CSS styles.',
        ),
        'value' => 1,
      ));

      // Element: auth_html
      $this->addElement('Text', 'auth_html', array(
        'label' => 'HTML in Products?',
        'description' => 'If you want to allow specific HTML tags, you can enter them below (separated by commas). Example: b, img, a, embed, font',
        'value' => 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr'
      ));

      $this->addElement('Radio', 'allow_levels', array(
          'label' => 'Allow to choose "Product View Privacy Based on Member Levels"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Products based on Member Levels on your website? If you choose Yes, then users will be able to choose the visibility of their Pages to members of selected member levels only.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));

      $this->addElement('Radio', 'allow_network', array(
          'label' => 'Allow to choose "Page View Privacy Based on Networks"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Products based on Networks on your website? If you choose Yes, then users will be able to choose the visibility of their Pages to members who have joined selected networks only.',
          'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));

      //Element: auth_playlistadd
      $this->addElement('Radio', 'addwishlist', array(
          'label' => 'Allow Adding Product to Wishlist?',
          'description' => 'Do you want to let members of this level to add products to their wishlists on your website?',
          'multiOptions' => array(
              1 => 'Yes, allow members to add products to their wishlists.',
              0 => 'No, do not allow members to add products to their wishlists.'
          ),
          'value' => 1,
      ));
      //Element: max
      $this->addElement('Text', 'addwishlist_max', array(
          'label' => 'Maximum Allowed Wishlists',
          'description' => 'Enter the maximum number of wishlists a member of this level can create. The field must contain an integer, use zero (0) for unlimited.',
          'validators' => array(
              array('Int', true),
              new Engine_Validate_AtLeast(0),
          ),
          'value'=>0
      ));
      // Element: max
      $this->addElement('Text', 'max', array(
        'label' => 'Maximum Allowed Products?',
        'description' => 'Enter the maximum number of allowed products for the members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
          'value' => '0',
      ));
    }
    $this->addElement('Select', 'productdesign', array(
        'label' => 'Enable Product Profile Views',
        'description' => 'Do you want to enable users to choose views for their Products? (If you choose No, then you can choose a default layout for the Product Profile pages on your website.)',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No',
        ),
        'onchange' => "enableproductdesignview(this.value)",
        'value' => '1',
      ));

      $chooselayout = $settings->getSetting('chooselayout', 'a:4:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";}');
      $chooselayoutVal = unserialize($chooselayout);

    $this->addElement('MultiCheckbox', 'chooselayout', array(
        'label' => 'Choose Product Profile Pages',
        'description' => 'Choose layout for the product profile pages which will be available to users while creating or editing their products.',
        'multiOptions' => array(
          1 => 'Design 1',
          2 => 'Design 2',
          3 => 'Design 3',
          4 => 'Design 4',
        ),
        'value' => array(1,2,3,4),
      ));

    $this->addElement('Radio', 'defaultlayout', array(
        'label' => 'Default Product Profile Page',
        'description' => 'Choose default layout for the product profile pages.',
        'multiOptions' => array(
          1 => 'Design 1',
          2 => 'Design 2',
          3 =>'Design 3',
          4 =>'Design 4',
        ),
        'value' =>1,
      ));

  }
}
