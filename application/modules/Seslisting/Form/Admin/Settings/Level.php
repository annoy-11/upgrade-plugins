<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
  public function init()
  {
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.");

    // Element: view
    $this->addElement('Radio', 'view', array(
      'label' => 'Allow Viewing of Listings?',
      'description' => 'Do you want to let members view listings? If set to no, some other settings on this page may not apply.',
      'multiOptions' => array(
        2 => 'Yes, allow members to view all listings, even private ones.',
        1 => 'Yes, allow members to view their own listings.',
        0 => 'No, do not allow listings to be viewed.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }

    if( !$this->isPublic() ) {

      // Element: create
      $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Listings?',
        'description' => 'Do you want to let members create listings? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view listings, but only want certain levels to be able to create listings.',
        'multiOptions' => array(
          1 => 'Yes, allow creation of listings.',
          0 => 'No, do not allow listings to be created.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Listings?',
        'description' => 'Do you want to let members edit listings? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to edit all listings.',
          1 => 'Yes, allow members to edit their own listings.',
          0 => 'No, do not allow members to edit their listings.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
        'label' => 'Allow Deletion of Listings?',
        'description' => 'Do you want to let members delete listings? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all listings.',
          1 => 'Yes, allow members to delete their own listings.',
          0 => 'No, do not allow members to delete their listings.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->delete->options[2]);
      }

      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Listings?',
        'description' => 'Do you want to let members of this level comment on listings?',
        'multiOptions' => array(
          2 => 'Yes, allow members to comment on all listings, including private ones.',
          1 => 'Yes, allow members to comment on listings.',
          0 => 'No, do not allow members to comment on listings.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->comment->options[2]);
      }


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
			/* if (count($banner_options) > 1) {
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
		} */

			 // Element: thumb watermark
			/* if (count($banner_options) > 1) {
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
		} */

      //element for event approve
      $this->addElement('Radio', 'listing_approve', array(
        'description' => 'Do you want listings created by members of this level to be auto-approved?',
        'label' => 'Auto Approve Listings',
        'multiOptions' => array(
            1=>'Yes, auto-approve listings.',
            0=>'No, do not auto-approve listings.'
        ),
        'value' => 1,
       ));


      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
        'label' => 'Listing Privacy',
        'description' => 'Your members can choose from any of the options checked below when they decide who can see their listing entries. These options appear on your members\' "Add Entry" and "Edit Entry" pages. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
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
        'label' => 'Listing Comment Options',
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

			// $this->addElement('Radio', 'cotinuereading', array(
   //      'label' => 'Allow to Enable "Continue Reading" Button',
   //      'description' => 'Do you want to allow members to enable "Continue Reading" button for their Listings on your website? If you choose Yes, then a Continue Reading button will be shown on Listing view page to read the full listing.',
   //      'multiOptions' => array(
   //        '1' => 'Yes',
   //        '0' => 'No',
   //      ),
			// 	'onchange' => 'continuereadingbutton(this.value)',
   //      'value' => '1',
   //    ));
			// $this->addElement('Radio', 'cntrdng_dflt', array(
   //      'label' => 'Default "Continue Reading" Button',
   //      'description' => 'Do you want to enable "Continue Reading" button for Listings on your website for the listings created by members of this level?',
   //      'multiOptions' => array(
   //        '1' => 'Yes',
   //        '0' => 'No',
   //      ),
   //      // 'onchange' => 'showHideHeight(this.value)',
   //      'value' => '1',
   //    ));

      // $this->addElement('Text', 'continue_height', array(
      //   'label' => 'Enter Height',
      //   'description' => 'Enter the height after you want to show continue reading button. 0 for unlimited.',
      //   'value' => '0'
      // ));

      // Element: style
      // $this->addElement('Radio', 'style', array(
      //   'label' => 'Allow Custom CSS Styles?',
      //   'description' => 'If you enable this feature, your members will be able to customize the colors and fonts of their listings by altering their CSS styles.',
      //   'multiOptions' => array(
      //     1 => 'Yes, enable custom CSS styles.',
      //     0 => 'No, disable custom CSS styles.',
      //   ),
      //   'value' => 1,
      // ));

      // Element: auth_html
      // $this->addElement('Text', 'auth_html', array(
      //   'label' => 'HTML in Listing Entries?',
      //   'description' => 'If you want to allow specific HTML tags, you can enter them below (separated by commas). Example: b, img, a, embed, font',
      //   'value' => 'script[language|type|src|id],strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr, iframe',
      // ));

      $this->addElement('Radio', 'allow_claim', array(
          'label' => 'Allow Claim in Listings',
          'description' => 'Do you want to let members claim in listings?',
          'multiOptions' => array(
              1 => 'Yes, allow members to claim listings.',
              0 => 'No, do not allow members to claim listings.'
          ),
          'value' => 1,
      ));

      $this->addElement('Radio', 'allow_levels', array(
          'label' => 'Allow to choose "Listing View Privacy Based on Member Levels"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Pages based on Member Levels on your website? If you choose Yes, then users will be able to choose the visibility of their Pages to members of selected member levels only.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));

      $this->addElement('Radio', 'allow_network', array(
          'label' => 'Allow to choose "Page View Privacy Based on Networks"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Pages based on Networks on your website? If you choose Yes, then users will be able to choose the visibility of their Pages to members who have joined selected networks only.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));



      // Element: max
      $this->addElement('Text', 'max', array(
        'label' => 'Maximum Allowed Listing Entries?',
        'description' => 'Enter the maximum number of allowed listing entries. The field must contain an integer between 1 and 999, or 0 for unlimited.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
      ));
    }
  }
}
