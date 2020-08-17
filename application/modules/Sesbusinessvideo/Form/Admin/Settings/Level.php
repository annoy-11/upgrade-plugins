<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessvideo_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Videos Member Level Settings')
            ->setDescription('These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.');

    if (!$this->isPublic()) {

      // Element: locked
      $this->addElement('Radio', 'locked', array(
          'label' => 'Allow Viewing of Locked Videos?',
          'description' => 'Do you want to let members view locked videos without entering password?',
          'multiOptions' => array(
              1 => 'Yes, allow members to view locked videos.',
              0 => 'No, do not allow members to view locked videos without password.',
          ),
          'value' => ( $this->isModerator() ? 1 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->locked->options[2]);
      }

			// Element: locked video
      $this->addElement('Radio', 'video_locked', array(
          'label' => 'Allow User to Lock Videos?',
          'description' => 'Do you want to let members to lock videos?',
          'multiOptions' => array(
              1 => 'Yes, allow members to lock videos.',
              0 => 'No, do not allow members to lock videos.',
          ),
          'value' => ( $this->isModerator() ? 1 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->video_locked->options[2]);
      }

      // Element: upload
      $this->addElement('Radio', 'upload', array(
          'label' => 'Allow Video Upload?',
          'description' => 'Do you want to let members to upload their own videos? If set to no, some other settings on this page may not apply.',
          'multiOptions' => array(
              1 => 'Yes, allow video uploads.',
              0 => 'No, do not allow video uploads.',
          ),
          'value' => 1,
      ));

      // Element: rating on videos
      $this->addElement('Radio', 'rating', array(
          'label' => 'Allow Rating on Videos ?',
          'description' => 'Do you want to let members rate Videos?',
          'multiOptions' => array(
              1 => 'Yes, allow rating on videos.',
              0 => 'No, do not allow rating on videos.'
          ),
          'value' => 1,
      ));

      // Element: max
      $this->addElement('Text', 'max', array(
          'label' => 'Maximum Allowed Videos',
          'description' => 'Enter the maximum number of allowed videos. The field must contain an integer, use zero for unlimited.',
          'validators' => array(
              array('Int', true),
              new Engine_Validate_AtLeast(0),
          ),
      ));
      $this->addElement('Select', 'video_approve', array(
          'description' => 'Do you want to auto-approve videos uploaded from all sources on your website? [If you choose No, then you would be able to choose from below setting, from which all sources the uploaded videos are Not to be auto-approves. Choosing Yes, will auto-approve all videos.]',
          'label' => 'Auto-Approve Videos from All Sources',
          'value' => 0,
					'onchange'=>'setVideoType(this.value);',
          'multiOptions' => array(
              1=>'No, do not auto-approve videos',
							0=>'Yes, auto-approve videos'
          )
      ));
		$this->addElement('MultiCheckbox', 'video_approve_type', array(
          'description' => 'Choose from below the video sources from which uplaoded videos will not be auto-approved on your website. Videos from the checked video sources will not be auto-approve and you can manually approve them from the "Manage Videos" section of this plugin.',
          'label' => 'Options for Video Sources Not to be Auto-Approved',
          'multiOptions' => array(
            'iframely' => 'External Site',
            'myComputer' => 'My Computer'
          ),
          'escape'=>false
      ));

		$this->addElement('MultiCheckbox', 'sesvdeo_upld', array(
          'description' => 'Choose from below the options using which users can upload videos on your website?',
          'label' => 'Option for Videos to be Uploaded',
          'multiOptions' => array(
              'iframely' => 'External Site',
              'myComputer' => 'My Computer'
          ),
		  'value' => 'iframely',
      ));
    }
  }

}
