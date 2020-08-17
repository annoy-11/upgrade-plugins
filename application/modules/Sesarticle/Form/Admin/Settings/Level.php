<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
  public function init()
  {
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("ARTICLE_FORM_ADMIN_LEVEL_DESCRIPTION");

    // Element: view
    $this->addElement('Radio', 'view', array(
      'label' => 'Allow Viewing of Articles?',
      'description' => 'Do you want to let members view articles? If set to no, some other settings on this page may not apply.',
      'multiOptions' => array(
        2 => 'Yes, allow members to view all articles, even private ones.',
        1 => 'Yes, allow members to view their own articles.',
        0 => 'No, do not allow articles to be viewed.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }

    if( !$this->isPublic() ) {

      // Element: create
      $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Articles?',
        'description' => 'Do you want to let members create articles? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view articles, but only want certain levels to be able to create articles.',
        'multiOptions' => array(
          1 => 'Yes, allow creation of articles.',
          0 => 'No, do not allow articles to be created.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Articles?',
        'description' => 'Do you want to let members edit articles? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to edit all articles.',
          1 => 'Yes, allow members to edit their own articles.',
          0 => 'No, do not allow members to edit their articles.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
        'label' => 'Allow Deletion of Articles?',
        'description' => 'Do you want to let members delete articles? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all articles.',
          1 => 'Yes, allow members to delete their own articles.',
          0 => 'No, do not allow members to delete their articles.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->delete->options[2]);
      }

      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Articles?',
        'description' => 'Do you want to let members of this level comment on articles?',
        'multiOptions' => array(
          2 => 'Yes, allow members to comment on all articles, including private ones.',
          1 => 'Yes, allow members to comment on articles.',
          0 => 'No, do not allow members to comment on articles.',
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

      //element for event approve
      $this->addElement('Radio', 'article_approve', array(
        'description' => 'Do you want articles created by members of this level to be auto-approved?',
        'label' => 'Auto Approve Articles',
        'multiOptions' => array(
            1=>'Yes, auto-approve articles.',
            0=>'No, do not auto-approve articles.'
        ),
        'value' => 1,
       ));


      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
        'label' => 'Article Privacy',
        'description' => 'Your members can choose from any of the options checked below when they decide who can see their article entries. These options appear on your members\' "Add Entry" and "Edit Entry" pages. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
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
        'label' => 'Article Comment Options',
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

			// Element: auth_comment
      $this->addElement('Radio', 'cotinuereading', array(
        'label' => 'Allow to Enable "Continue Reading" Button',
        'description' => 'Do you want to allow members to enable "Continue Reading" button for their Articles on your website? If you choose Yes, then a Continue Reading button will be shown on Article view page to read the full article.',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
				'onchange' => 'continuereadingbutton(this.value)',
        'value' => '1',
      ));
			$this->addElement('Radio', 'cntrdng_dflt', array(
        'label' => 'Default "Continue Reading" Button',
        'description' => 'Do you want to enable "Continue Reading" button for Articles on your website for the articles created by members of this level?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => '1',
      ));

      // Element: style
      $this->addElement('Radio', 'style', array(
        'label' => 'Allow Custom CSS Styles?',
        'description' => 'If you enable this feature, your members will be able to customize the colors and fonts of their articles by altering their CSS styles.',
        'multiOptions' => array(
          1 => 'Yes, enable custom CSS styles.',
          0 => 'No, disable custom CSS styles.',
        ),
        'onchange' => 'showHideHeight(this.value)',
        'value' => 1,
      ));

      $this->addElement('Text', 'continue_height', array(
        'label' => 'Enter Height',
        'description' => 'Enter the height after you want to show continue reading button. 0 for unlimited.',
        'value' => '0'
      ));

      // Element: auth_html
      $this->addElement('Text', 'auth_html', array(
        'label' => 'HTML in Article Entries?',
        'description' => 'If you want to allow specific HTML tags, you can enter them below (separated by commas). Example: b, img, a, embed, font',
        'value' => 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr'
      ));

      $this->addElement('Radio', 'allow_claim', array(
          'label' => 'Allow Claim in Articles',
          'description' => 'Do you want to let members claim in articles?',
          'multiOptions' => array(
              1 => 'Yes, allow members to claim articles.',
              0 => 'No, do not allow members to claim articles.'
          ),
          'value' => 1,
      ));


      $this->addElement('Radio', 'allow_levels', array(
          'label' => 'Allow to choose "Article View Privacy Based on Member Levels"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Articles based on Member Levels on your website? If you choose Yes, then users will be able to choose the visibility of their Articles to members of selected member levels only.',
         // 'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));

      $this->addElement('Radio', 'allow_network', array(
          'label' => 'Allow to choose "Article View Privacy Based on Networks"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Articles based on Networks on your website? If you choose Yes, then users will be able to choose the visibility of their Articles to members who have joined selected networks only.',
         // 'class' => $class,
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 0,
      ));

      // Element: max
      $this->addElement('Text', 'max', array(
        'label' => 'Maximum Allowed Article Entries?',
        'description' => 'Enter the maximum number of allowed article entries. The field must contain an integer between 1 and 999, or 0 for unlimited.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
      ));
    }
  }
}
