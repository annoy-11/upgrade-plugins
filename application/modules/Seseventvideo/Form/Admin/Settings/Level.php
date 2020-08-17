<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seseventvideo_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

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
          'description' => 'Do you want to let members to locked videos?',
          'multiOptions' => array(
              1 => 'Yes, allow members to locked videos.',
              0 => 'No, do not allow members to locked videos.',
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
          'description' => 'Do you want to auto-approve the videos uploaded on your website? [If you choose Yes, then you would be able to choose from below setting, from which all source the uploaded videos are to be auto-approve.]',
          'label' => 'Auto-approve Videos',
          'value' => 0,
					'onchange'=>'setVideoType(this.value);',
          'multiOptions' => array(
              1=>'No, do not auto-approve videos',
							0=>'Yes, auto-approve videos'
          )
      ));
		$this->addElement('MultiCheckbox', 'video_approve_type', array(
          'description' => 'Choose from below the video sources from which uplaoded videos will be auto-approved on your website. Videos from the unchecked video sources will not be auto-approve and you can approve them from the "Manage Videos" section of this plugin.',
          'label' => 'Options for Video Sources to be Auto-Approved',
          //'value' => array('youtube','youtubePlaylist','vimeo','dailymotion','url','embedcode','myComputer'),
          'multiOptions' => array(
              'youtube' => 'Youtube',
              'youtubePlaylist' => 'Youtube Playlists',
              'vimeo' => 'Vimeo',
              'dailymotion' => 'Dailymotion',
							'url' => 'From URL (Note: This setting will only work for mp4 and flv video extension types. If you have enabled the "HTML5 Video Support" setting from Global Settings, then the mp4 videos will be directly uploaded, otherwise mp4 videos will not be uploaded and will not work and will require FFMPEG to be converted to .FLV video type first.)',
							'embedcode'=>'From Embed Code (Note: Embed code supported by this plugin is the code which has video in &lt;iframe&gt; or &lt;embed&gt; code. If for any particular site, embed code from these 2 tags does not work for you, please contact our support team from <a href="http://www.socialenginesolutions.com/tickets" target="_blank">here</a>.)',
              'myComputer' => 'My Computer'
          ),
					'escape'=>false
      ));
		$this->addElement('MultiCheckbox', 'video_upload_option', array(
          'description' => 'Choose from below the options using which users can upload videos on your website?',
          'label' => 'Option for Videos to be Uploaded',
          //'value' => array('youtube','youtubePlaylist','vimeo','dailymotion','url','embedcode'),
          'multiOptions' => array(
              'youtube' => 'Youtube [set API key in Global settings to make this setting work.]',
              'youtubePlaylist' => 'Youtube Playlists [set API key  in Global settings to make this setting work.]',
              'vimeo' => 'Vimeo',
              'dailymotion' => 'Dailymotion',
							'url' => 'From URL(if support html5 then mp4 video and if not then flv video upload direct and other need FFMPEG)',
							'embedcode'=>'From Embed Code',
              'myComputer' => 'My Computer'
          )
      ));
    }
  }

}
