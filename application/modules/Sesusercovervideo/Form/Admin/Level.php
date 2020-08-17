<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercovervideo
 * @package    Sesusercovervideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php 2016-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesusercovervideo_Form_Admin_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    parent::init();

    $this
      ->setTitle('Member Level Settings')
      ->setDescription('These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.');

    if( !$this->isPublic() ) {

      $this->addElement('Radio', 'viewtype', array(
        'label' => 'Choose Cover Video Design',
        'description' => 'Choose design of cover videos which will be available to users of this member level on their profile pages.',
        'multiOptions' => array(
          1 => 'Design 1',
          2 => 'Design 2',
          4 => 'Design 3',
        ),
        'value' => 1,
      ));

      $this->addElement('Radio', 'create', array(
        'label' => 'Allow to upload Cover Video',
        'description' => 'Do you want to allow the members of this level to upload their cover videos?',
        'value' => 1,
        'multiOptions' => array(
          1 => 'Yes, allow upload cover video.',
          0 => 'No, do not allow upload cover video.'
        ),
        'value' => 1,
      ));

      $this->addElement('Radio', 'userphotoround', array(
          'label' => 'Show Profile Photo in Round Shape',
          'description' => 'Do you want to show the profile photos of the members of this level in round shape? [Note: This setting will work with Design 3 only.]',
          'multiOptions' => array(
              1 => 'Yes',
              2 => 'No'
          ),
          'value' => 1,
      ));

		 $this->addElement(
					'Text',
					'height',
					array(
              'label' => 'Height of Cover Video',
							'description' => 'Enter the height of the cover video (in px).',
							'value' => '400',
					)
			);

			$this->addElement(
        'Radio',
        'tab',
        array(
          'label' => 'Tab Placement',
          'description' => "Choose from below where you want to show the tabs with cover video. [Note: This setting will work with Design 1 and Design 3 only.]",
          'multiOptions' => array(
              'inside' => 'Inside "Cover Video Widget"',
              'outside' => 'Outside "Cover Video Widget"',
          ),
          'value' => 'inside',
        )
			);

    $this->addElement(
    'Radio',
    'showicontype',
        array(
        'label' => "Button Display Style",
        'description' => 'Choose from below styles how you want to show the buttons on cover video for the members of this level.',
        'multiOptions' => array(
            '1' => 'Buttons with Icons only',
            '2' => 'Buttons with Texts and Icons',
        ),
        'value' => '1',
    )
    );

    $this->addElement(
        'Radio',
        'is_fullwidth',
          array(
            'label' => "Show Cover Video in Full Width",
            'description' => 'Do you want to show cover video in full width?',
            'multiOptions' => array(
                '1' => 'Yes',
                '2' => 'No',
            ),
            'value' => '1',
        )
    );

    $multiOptionsArray = array(
        "totalfriends" => "Friend's Count",
        "mutualfriend" => "Mutual Friend's Count",
        "photo" => "User's Profile Photo",
        "dob" => "User's Date Of Birth",
        "addfriend" => "Add Friend & Remove Friend Button",
        "message" => "Send Message Button",
        "viewcount" => "User's View Count",
        "likecount" => "User's Like Count",
        "editinfo" => 'Update Info Button',
        "options" => "Option's Button (Edit My Profile, Add Friend and etc...)",
        "membersince" => "User's Join Date",
        "albumcount" => "User's Album Count",
        "groupcount" => "User's Group Count (This count only show if you have SocialEngine Group Plugin)",
        "eventcount" => "User's Event Count (This count only show if you have SocialEngine Event Plugin)",
        "forumcount" => "User's Forum Count (This count only show if you have SocialEngine Forum Plugin )",
        "musiccount" => "User's Music Count (This count only show if you have SocialEngine Music Plugin)",

    );

    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesvideo')) {
        $multiOptionsArray["videocount"] = "User's Video Count (This count only show if you have SocialEngine Video Plugin or Advanced Videos & Channels Plugin)";
    }

    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmember')) {
        $multiOptionsArray["rating"] = "Rating Stars [Note: This setting is only work when our 'SES - Advanced Members Plugin' is installed.]";
        $multiOptionsArray["location"] = "Users's Location [Note: This setting is only work when our 'SES - Advanced Members Plugin' is installed.]";
        $multiOptionsArray["viplabel"] = "VIP Label [Note: This setting is only work when our 'SES - Advanced Members Plugin' is installed.]";
        $multiOptionsArray["featuredlabel"] = "Featured Label [Note: This setting is only work when our 'SES - Advanced Members Plugin' is installed.]";
        $multiOptionsArray["sponsoredLabel"] = "Sponsored Label [Note: This setting is only work when our 'SES - Advanced Members Plugin' is installed.]";
        $multiOptionsArray["verifiedLabel"] = "Verified Label [Note: This setting is only work when our 'SES - Advanced Members Plugin' is installed.]";
        $multiOptionsArray["recentlyViewedBy"] = "User's who recently viewed the profile owner [Note: This setting is only work when our 'SES - Advanced Members Plugin' is installed.]";
        $multiOptionsArray["likebtn"] = "Like Button [Note: This setting is only work when our 'SES - Advanced Members Plugin' is installed.]";
        $multiOptionsArray["followbtn"] = "Follow Button [Note: This setting is only work when our 'SES - Advanced Members Plugin' is installed.]";
    }

    $this->addElement(
        'MultiCheckbox',
        'option',
        array(
          'label' => 'Show Details',
          'description' => 'Choose from below the details that you want to show in this widget.',
          'multiOptions' => $multiOptionsArray,
        )
      );
    $this->addElement(
        'Radio',
        'show_ver_tip',
          array(
            'label' => "Display Tip on Verification Icon",
            'description' => 'Do you want to display tip on Verification icon? We recommend you to disable the tip if there is no content.',
            'multiOptions' => array(
                '1' => 'Yes',
                '2' => 'No',
            ),
            'value' => '1',
        )
      );

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
				$this->addElement('Select', 'defaultcovephoto', array(
          'label' => 'Choose Default User Cover Photo',
          'description' => 'Choose a default cover photo which you want to show by default for the members of this level.',
          'multiOptions' => $banner_options,
				));
			} else {
				$description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo for default user cover. Photo to be chosen for user cover should be first uploaded from the "Layout" >> "<a href="' . $fileLink . '" target="_blank">File & Media Manager</a>" section.') . "</span></div>";
				$this->addElement('Dummy', 'defaultcovephoto', array(
						'label' => 'Choose Default User Cover Photo',
						'description' => $description,
				));
				$this->defaultcovephoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      }
    }
  }
}
