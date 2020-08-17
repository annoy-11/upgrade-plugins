<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seseventvideo_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
		$sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
		$descriptionLicense = sprintf('Enter the your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);
		$this->addElement('Text', "seseventvideo_licensekey", array(
		'label' => 'Enter License key',
		'description' => $descriptionLicense,
		'allowEmpty' => false,
		'required' => true,
		'value' => $settings->getSetting('seseventvideo.licensekey'),
		));
		$this->getElement('seseventvideo_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('seseventvideo.pluginactivated')) {

      $this->addElement('Text', 'seseventvideo_videos_manifest', array(
          'label' => 'Plural "eventvideos" Text in URL',
          'description' => 'Enter the text which you want to show in place of "eventvideos" in the URLs of this plugin.',
          'value' => $settings->getSetting('seseventvideo.videos.manifest', 'eventvideos'),
      ));
      $this->addElement('Text', 'seseventvideo_video_manifest', array(
          'label' => 'Singular "eventvideo" Text in URL',
          'description' => 'Enter the text which you want to show in place of "eventvideo" in the URLs of this plugin.',
          'value' => $settings->getSetting('seseventvideo.video.manifest', 'eventvideo'),
      ));
      
			$this->addElement('Select', 'seseventvideo_enable_location', array(
        'label' => 'Enable Location',
        'description' => 'Do you want to enable location for event videos on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
				'onchange'=>'proximity(this.value);',
        'value' => $settings->getSetting('seseventvideo.enable.location', 1),
	    ));
			 $this->addElement('Select', 'seseventvideo_search_type', array(
          'label' => 'Proximity Search Unit',
          'description' => 'Choose the unit for proximity search of location of videos on your website.',
          'multiOptions' => array(
              1 => 'Miles',
              0 => 'Kilometres'
          ),
          'value' => $settings->getSetting('seseventvideo.search.type', 1),
      ));
      /* Rating code */
      $this->addElement('Select', 'seseventvideo_video_rating', array(
          'label' => 'Allow Rating on Videos',
          'description' => 'Do you want to allow users to give rating on videos on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onchange' => 'rating_video(this.value)',
          'value' => $settings->getSetting('seseventvideo.video.rating', 1),
      ));
      $this->addElement('Select', 'seseventvideo_ratevideo_own', array(
          'label' => 'Allow Rating on Own Videos',
          'description' => 'Do you want to allow users to give rating on own videos on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('seseventvideo.ratevideo.own', 1),
      ));
      $this->addElement('Select', 'seseventvideo_ratevideo_again', array(
          'label' => 'Allow to Edit Rating on Videos',
          'description' => 'Do you want to allow users to edit their rating on videos on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('seseventvideo.ratevideo.again', 1),
      ));
      $this->addElement('Select', 'seseventvideo_ratevideo_show', array(
          'label' => 'Show Earlier Rating on Videos',
          'description' => 'Do you want to show earlier rating on videos on your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('seseventvideo.ratevideo.show', 1),
      ));
      /* End rating code */

      $this->addElement('Select', 'seseventvideo_enable_watchlater', array(
          'label' => 'Enable "Watch Later" for Videos',
          'description' => 'Do you want to enable watch later for videos on your website. If you choose "Yes" then your site members will be able to save videos to their watch later list.',
          'value' => $settings->getSetting('seseventvideo.enable.watchlater', 1),
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
      ));
      $this->addElement('Select', 'seseventvideo_enable_report', array(
          'label' => 'Allow Report for Videos',
          'description' => 'Do you want to allow users to report videos on your website?'
          . 'report.',
          'value' => $settings->getSetting('seseventvideo.enable.report', 1),
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
      ));
     
      $this->addElement('Select', 'seseventvideo_embeds', array(
          'label' => 'Allow Embedding of Videos',
          'description' => 'Do you want to allow users to embed videos on your website? If you choose "Yes" then your site members embed videos on this site in other pages using an iframe (like YouTube).',
          'value' => $settings->getSetting('seseventvideo.embeds', 1),
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
      ));
      $this->addElement('Select', 'seseventvideo_uploadphoto', array(
          'label' => 'Allow to Choose Main Photo',
          'description' => 'Do you want to allow users to choose main photo for the videos while creating / editing their videos ?',
          'value' => $settings->getSetting('seseventvideo.uploadphoto'),
          'multiOptions' => array(
              '0' => 'No',
              '1' => 'Yes'
          )
      ));
			$this->addElement('Select', 'seseventvideo_direct_video', array(
          'label' => 'Allow to Upload Videos Without FFMPEG',
          'description' => 'Do you want to allow videos to be uploaded directly without converting them from one extension to another. (Note: This setting will only work for mp4 and flv video types. If you have enabled the "HTML5 Video Support" setting from admin panel, then the mp4 videos will be converted into mp4, otherwise mp4 videos will be saved as flv videos.)?',
          'value' => $settings->getSetting('seseventvideo.direct.video'),
          'multiOptions' => array(
              '0' => 'No',
              '1' => 'Yes'
          )
      ));
      $this->addElement('Text', 'seseventvideo_youtube_playlist', array(
          'label' => 'Youtube Playlist Video Limit',
          'description' => 'Enter the number of songs to be imported from Youtube Playlists. [We suggest you to choose less than 25 videos to be imported for a playlist as importing more videos may break the connection from Youtube and abort the process.]',
          'value' => $settings->getSetting('seseventvideo.youtube.playlist', '25'),
      ));
      $description = 'While creating videos on your website, users can choose Youtube Playlist as a source. For this, create an Application Key through the <a href="https://console.developers.google.com" target="_blank">Google Developers Console</a> page. <br>For more information, see: <a href="https://developers.google.com/youtube/v3/getting-started" target="_blank">YouTube Data API</a>.';

      $this->addElement('Text', 'seseventvideo_youtube_apikey', array(
          'label' => 'Youtube Playlist API Key',
          'description' => $description,
          'filters' => array(
              'StringTrim',
          ),
          'value' => $settings->getSetting('seseventvideo.youtube.apikey'),
      ));
      /* $this->addElement('Text', 'seseventvideo_google_key', array(
        'label' => 'Google Api Key for Youtube Video Playlist',
        'description' => '',
        'value' => $settings->getSetting('seseventvideo.google.key', ''),
        )); */
      $this->addElement('Text', 'seseventvideo_ffmpeg_path', array(
          'label' => 'Path to FFMPEG',
          'description' => 'Please enter the full path to your FFMPEG installation. (Environment variables are not present)',
          'value' => $settings->getSetting('seseventvideo.ffmpeg.path', ''),
      ));
      $this->addElement('Checkbox', 'seseventvideo_html5', array(
          'description' => 'HTML5 Video Support',
          'value' => $settings->getSetting('seseventvideo.html5', false),
      ));
      $this->seseventvideo_youtube_apikey->getDecorator('Description')->setOption('escape', false);

      $this->addElement('Text', 'seseventvideo_jobs', array(
          'label' => 'Encoding Jobs',
          'description' => 'How many jobs do you want to allow to run at the same time?',
          'value' => $settings->getSetting('seseventvideo.jobs', 2),
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
          'label' => 'Activate your plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }

}
