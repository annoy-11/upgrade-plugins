<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesultimateslide
 * @package Sesultimateslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: Createslide.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
class Sesultimateslide_Form_Admin_Createslide extends Authorization_Form_Admin_Level_Abstract {
    public function init() {
		 $url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDczHMCNc0JCmJACM86C7L8yYdF9sTvz1A";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($data,true);
    $googleFontArray = array();
    foreach($results['items'] as $re) {
      $googleFontArray['"'.$re["family"].'"'] = $re['family'];
    }
    $slideId = Zend_Controller_Front::getInstance()->getRequest()->getParam('slide_id', null);
        $this
                ->setTitle('Upload New Slide form')
                ->setDescription("In this section, you can manage the upload new slide and enter various image content like caption, description, buttons, etc.")
                ->setAttrib('id', 'form-create-slide')
                ->setAttrib('name', 'sesultimateslide_create_slide')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('onsubmit', 'return checkValidation();')
                ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
        $this->setMethod('post');
        $this->addElement('Text', 'title', array(
            'label' => 'Slide Title',
            'description' => 'Enter the title for this slide. It will be used for your indicative purpose only.',
            'allowEmpty' => true,
            'required' => true,
        ));
        $this->addElement('Text', 'background_color', array(
            'label' => 'Background Color 1',
            'description' => 'Choose the background color 1 for this slide.',
            'class' => 'SEScolor',
            'allowEmpty' => true,
            'required' => false,
        ));
        $this->addElement('Select', 'enable_gradient', array(
          'label' => 'Enable Gradient',
          'description' => 'Do you want to enable gradient in background of this slide?',
          'allowEmpty' => true,
          'required' => false,
          'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No'
          ),
          'value' => '0',
          'onChange' => 'gradient(this.value);'
        ));
        $this->addElement('Text', 'gradient_background_color', array(
          'label' => 'Background Color 2',
          'description' => 'Choose the background color 2 for this slide. (Note: If you choose this color, then this color will be shown as gradient in this slide with the background color 1 of above setting.)',
          'class' => 'SEScolor',
          'allowEmpty' => true,
          'required' => false,
        ));
        $this->addElement('File', 'image_for_slide', array(
            'label' => 'Large Image for Slide',
            'description' => 'Upload a large image for this slide which will be shown in full background of the slideshow. [Note: photos with extension: “jpg, png and jpeg” will only be supported.]',
            'allowEmpty' => true,
            'required' => false,
        ));
		 if($slideId)
             $slide = Engine_Api::_()->getItem('sesultimateslide_slide', $slideId);
        else
            $slide = '';
		if($slide->large_image_for_slide){
            $backgroundImageSrc = Engine_Api::_()->storage()->get($slide->large_image_for_slide, '')->getPhotoUrl();
            if($backgroundImageSrc){
                $this->addElement('Dummy', 'dummy_5', array(
                       'content' => '<img src="'.$backgroundImageSrc.'" alt="Background_image" height="100" width="100">',
                   ));
            }

			 $this->addElement('Checkbox', 'remove_main_image', array(
				'label' => 'Yes, remove this Image.'
			));
        }
			$reqimg = false;
			$allowimag = true;
        if (!empty($_POST) && $_POST['image_for_slide']) {
            $reqimg = true;
            $allowimag = false;
        }
        if($slide->enable_overlay){
            $overlayReq = true;
            $overlayAllow = false;
        }elseif (!empty($_POST) && $_POST['enable_overlay'] == 1) {
            $overlayReq = true;
            $overlayAllow = false;
        }else{
            $overlayReq = false;
            $overlayAllow = true;
        }
        $this->addElement('Select', 'enable_overlay', array(
            'label' => ' Enable Overlay',
            'description' => 'Do you want to enable overlay on this slide image?',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No'
            ),
            'value' => '0',
            'onChange' => 'overlay(this.value);'
        ));


		$this->addElement('Text', 'slide_overlaycolor', array(
			'label' => 'Slide Overlay Color',
			'description' => 'Choose the overlay color for this slide.',
			'class' => 'SEScolor',
			'allowEmpty' => $overlayAllow,
			'required' => $overlayReq,
		));

		$this->addElement('Text', 'slide_opacity', array(
			'label' => 'Slide Opacity',
			'description' => 'Enter the slide opacity (between 0-1 eg. "0.23").',
            'allowEmpty' => $overlayAllow,
            'required' => $overlayReq,
			'value'=>0.3,
			'validators' => array(
               // array('Float', true),
                array('GreaterThan', true, array(0)),
            )
		));

        $this->addElement('Select', 'enable_double_slide', array(
            'label' => 'Enable Double Slide',
            'description' => 'Do you want to enable images in this slide? If you choose Yes, then you would be able to choose the frame for this image.',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No'
            ),
            'value' => '0',
            'onChange' => 'double_slide(this.value);'
        ));


      $reqframe = false;
      $allowEmptyframe = true;
      if ($_POST['enable_double_slide'] == 1) {
        $reqframe = true;
        $allowEmptyframe = false;
      }
        // IF DOUBLE SLIDE CHECKED
        $this->addElement('Radio', 'dbslide_frame_for_slide', array(
            'label' => 'Frame For Slide',
            'description' => 'Choose from the frame for this slide.[Note: size for Desktop:- width:382px; height:800px , size for laptop:- width:382px; height:800px , For Ipad:- width:179px; height:820px , For Mobile:- width:179px; height:1010px]',
            'allowEmpty' => $allowEmptyframe,
            'required' =>  $reqframe,
            'multiOptions' => array(
                '_dk _dklight' => 'Light Desktop',
                '_dk _dkdark' => 'Dark Desktop',
                '_lp _lplight' => 'Light Laptop',
                '_lp _lpdark' => 'Dark Laptop',
                '_ipad _ipadlight' => 'Light Ipad',
                '_ipad _ipaddark' => 'Dark Ipad',
                '_mb _mblight' => 'Light Mobile',
                '_mb _mbdark' => 'Dark Mobile'
            ),
            'value' => '_lp _lplight',
        ));
     if(!empty($_POST) && $_POST['enable_double_slide'] == 1 && $slide && $slide->dbslide_frame_for_slide){

       $reqframe = false;
       $allowEmptyframe = true;
     }
        $this->addElement('File', 'dbslide_slide_img', array(
            'label' => 'Double Slide Image',
            'description' => 'Upload the double slide image for this slide which will be displayed in the frame selected by you from the above setting.[Note: photos with extension: “jpg, png and jpeg” will only be supported.]',
          'allowEmpty' => $allowEmptyframe,
          'required' =>  $reqframe,
        ));
        if($slide && $slide->dbslide_double_slide_image){
            $ImageSrc = Engine_Api::_()->storage()->get($slide->dbslide_double_slide_image, '')->getPhotoUrl();
            if($ImageSrc){
                $this->addElement('Dummy', 'dummy_6', array(
                       'content' => '<img src="'.$ImageSrc.'" alt="Background_image" height="100" width="100">',
                   ));
            }

			$this->addElement('Checkbox', 'remove_dbslide_image', array(
				'label' => 'Yes, remove this Image.'
			));
        }
        $this->addElement('text', 'dbslide_frame_rotation', array(
            'label' => 'Frame Rotation',
            'description' => 'Choose the rotation degree for the frame in this slide (in Degree - For Example: 20, 30, 40).',
            'allowEmpty' => true,
            'required' => false,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            )
        ));

        $this->addElement('Dummy', 'dummy_1', array(
            'content' => '<h2 style="margin: 0px;">Caption Settings</h2>',
        ));
        // END DOUBLE SLIDE CHECKED
        // Caption settings for this slide.

        $this->addElement('Text', 'fixed_caption_text', array(
            'label' => 'Fixed Caption Text',
            'description' => 'Enter the text for Fixed Caption to be shown in this slide.',
            'allowEmpty' => true,
            'required' => false,
        ));
        $this->addElement('Text', 'fixed_caption_font_color', array(
            'label' => 'Fixed Caption Font Color',
            'description' => 'Choose the font color for the Fixed Caption.',
            'allowEmpty' => true,
            'required' => false,
            'class' => 'SEScolor',
        ));
        $this->addElement('Text', 'fixed_caption_font_size', array(
            'label' => 'Fixed Caption Font Size',
            'description' => 'Choose the font size for the Fixed Caption.',
            'allowEmpty' => true,
            'required' => false,
        ));
        $this->addElement('Select', 'fixed_caption_font_family', array(
            'label' => 'Fixed Caption Font Family',
            'description' => ' Choose the font family for the Fixed Caption.',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => $googleFontArray,
            'value' => Engine_Api::_()->sesultimateslide()->getContantValueXML('sesariana_body_fontfamily'),
        ));
        $this->addElement('Text', 'floating_caption_text', array(
            'label' => 'Floating Caption Text',
            'description' => 'Enter the text for Floating Caption to be shown in this slide.',
            'allowEmpty' => true,
            'required' => false,
        ));
        $this->addElement('Text', 'floating_caption_font_color', array(
            'label' => 'Floating Caption Font Color',
            'description' => 'Choose the font color for the Floating Caption.',
            'allowEmpty' => true,
            'required' => false,
            'class' => 'SEScolor',
        ));
        $this->addElement('Text', 'floating_caption_font_size', array(
            'label' => 'Floating Caption Font Size',
            'description' => 'Choose the font size for the Floating Caption.',
            'allowEmpty' => true,
            'required' => false,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            )
        ));
        $this->addElement('Select', 'floating_caption_font_family', array(
            'label' => 'Floating Caption Font Family',
            'description' => 'Choose the font family for the Floating Caption.',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => $googleFontArray,
            'value' => Engine_Api::_()->sesultimateslide()->getContantValueXML('sesariana_body_fontfamily')
        ));
        $this->addElement('Text', 'description_text', array(
            'label' => 'Description Text',
            'description' => 'Enter the text for Description to be shown in this slide below fixed and floating Captions.',
            'allowEmpty' => true,
            'required' => false,
        ));
        $this->addElement('Text', 'description_font_color', array(
            'label' => 'Description Font Color',
            'description' => 'Choose the font color for the Description.',
            'allowEmpty' => true,
            'required' => false,
            'class' => 'SEScolor',
        ));
        $this->addElement('Text', 'description_font_size', array(
            'label' => 'Description Font Size',
            'description' => 'Choose the font size for the Description.',
            'allowEmpty' => true,
            'required' => false,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            )
        ));
        $this->addElement('Select', 'description_font_family', array(
            'label' => 'Description Font Family',
            'description' => 'Choose the font family for the Description.',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => $googleFontArray,
            'value' => Engine_Api::_()->sesultimateslide()->getContantValueXML('sesariana_body_fontfamily')
        ));
        // CTA BUTTON 1
        $this->addElement('Dummy', 'dummy_2', array(
            'content' => '<h2 style="margin: 0px;">CTA Buttons Settings</h2>',
        ));
        $reqCTA1 = false;
        $allowEmptyCTA1 = true;
        if (!empty($_POST) && $_POST['enable_cta_Button_1']) {
            $reqCTA1 = true;
            $allowEmptyCTA1 = false;
        }
        $this->addElement('Select', 'enable_cta_Button_1', array(
            'label' => 'Enable CTA Button 1',
            'description' => ' Do you want to enable CTA button 1? If Yes, then you will be able to configure the button in settings below.',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No'
            ),
            'value' => '0',
            'onChange' => 'cta_button_one(this.value);'
        ));
        // IF CTA BUTTON IS CHECKED
        $this->addElement('Text', 'cta1_button_label', array(
            'label' => 'CTA Button Label',
            'description' => 'Enter the label text for CTA button 1.',
            'allowEmpty' => $allowEmptyCTA1,
            'required' => $reqCTA1,
        ));
         $this->addElement('text', 'cta1_button_icon', array(
            'label' => 'CTA Button Icon',
            'description' => 'fontawesome Icon Class.',
        ));
        $this->addElement('Text', 'cta1_background_color', array(
            'label' => 'Background Color',
            'description' => 'Choose the background color for the CTA button 1.',
            'class' => 'SEScolor',
            'allowEmpty' => $allowEmptyCTA1,
            'required' => $reqCTA1,
        ));

        $this->addElement('Text', 'cta1_text_color', array(
            'label' => 'Text Color',
            'description' => 'Choose the text color for the CTA button 1.',
            'class' => 'SEScolor',
            'allowEmpty' => $allowEmptyCTA1,
            'required' => $reqCTA1,
        ));
        $this->addElement('Text', 'cta1_mouseover_background_color', array(
            'label' => 'Mouseover Background Color',
            'description' => 'Choose the background color for the CTA button 1 when users mouseover on the button.',
            'class' => 'SEScolor',
            'allowEmpty' => $allowEmptyCTA1,
            'required' => $reqCTA1,
        ));
        $this->addElement('Text', 'cta1_mouseover_text_color', array(
            'label' => 'Mouseover Text Color',
            'description' => 'Choose the text color for the CTA button 1 when users mouseover on the button.',
            'class' => 'SEScolor',
            'allowEmpty' => $allowEmptyCTA1,
            'required' => $reqCTA1,
        ));
        $this->addElement('text', 'cta1_button_url', array(
            'label' => 'Button URL',
            'description' => 'Enter the URL where you want to redirect users after they click on this button.',
            'allowEmpty' => $allowEmptyCTA1,
            'required' => $reqCTA1,
        ));
        $this->addElement('Radio', 'cta1_cta_button_target', array(
            'label' => 'CTA Button Target',
            'description' => 'Do you want to open the link in new window?',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No'
            ),
            'value' => '1',
        ));
        // END CTA BUTTON  CHECKED
        //  CTA BUTTON  2
        $reqCTA2 = false;
        $allowEmptyCTA2 = true;
        if (!empty($_POST) && $_POST['enable_cta_button_2']) {
            $reqCTA2 = true;
            $allowEmptyCTA2 = false;
        }
        $this->addElement('Select', 'enable_cta_button_2', array(
            'label' => 'Enable CTA Button 2',
            'description' => 'Do you want to enable CTA button 2? If Yes, then you will be able to configure the button in settings below.',
            'allowEmpty' => true,
            'required' => false,
            'class' => 'cta2',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No'
            ),
            'value' => '0',
            'onChange' => 'cta_button_two(this.value);'
        ));
        // IF CTA BUTTON 2 is CHECKED
        $this->addElement('Text', 'cta2_cta_button_label', array(
            'label' => 'CTA Button Label',
            'description' => 'Enter the label text for CTA button 2.',
            'allowEmpty' => $allowEmptyCTA2,
            'required' => $reqCTA2,
        ));
         $this->addElement('text', 'cta2_button_icon', array(
            'label' => 'CTA Button Icon',
            'description' => 'fontawesome Icon Class.',
        ));
        $this->addElement('Text', 'cta2_background_color', array(
            'label' => 'Background Color',
            'description' => 'Choose the background color for the CTA button 2.',
            'class' => 'SEScolor',
            'allowEmpty' => $allowEmptyCTA2,
            'required' => $reqCTA2,
        ));
        $this->addElement('Text', 'cta2_text_color', array(
            'label' => 'Text Color',
            'description' => 'Choose the text color for the CTA button 2.',
            'class' => 'SEScolor',
            'allowEmpty' => $allowEmptyCTA2,
            'required' => $reqCTA2,
        ));
        $this->addElement('Text', 'cta2_mouseover_background_color', array(
            'label' => 'Mouseover Background Color',
            'description' => 'Choose the background color for the CTA button 2 when users mouseover on the button.',
            'class' => 'SEScolor',
            'allowEmpty' => $allowEmptyCTA2,
            'required' => $reqCTA2,
        ));
        $this->addElement('Text', 'cta2_mouseover_text_color', array(
            'label' => 'Mouseover Text Color',
            'description' => 'Choose the text color for the CTA button 2 when users mouseover on the button.',
            'class' => 'SEScolor',
            'allowEmpty' => $allowEmptyCTA2,
            'required' => $reqCTA2,
        ));
        $this->addElement('Text', 'cta2_button_url', array(
            'label' => 'Button URL',
            'description' => 'Enter the URL where you want to redirect users after they click on this button.',
            'allowEmpty' => $allowEmptyCTA2,
            'required' => $reqCTA2,
        ));
        $this->addElement('Radio', 'cta2_cta_button_target', array(
            'label' => 'CTA Button Target',
            'description' => 'Do you want to open the link in new window?',
            'allowEmpty' => $allowEmptyCTA2,
            'required' => $reqCTA2,
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No'
            ),
            'value' => '1',
        ));
        $reqvideo = false;
        $allowEmptyvideo = true;
        if (!empty($_POST) && $_POST['enable_watch_video_button']) {
            $reqvideo = true;
            $allowEmptyvideo = false;
        }

        // End CTA BUTTON 2 CHECKED
        // Enable Watch Video Button

		if(!$slide){
			$videoButtonValue = 4;
		}
		else {
			$videoButtonValue = $slide->video_video_url;
		}
        $this->addElement('Select', 'enable_watch_video_button', array(
            'label' => 'Enable Watch Video Button',
            'description' => 'Do you want to enable watch video button on this slide? If Yes, then you will be able to configure the button in settings below. On clicking this button, users will see the video added by you in this setting in popup.',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No'
            ),
            'value' => '0',
            'onChange' => 'video_buton_check(this.value);'
        ));
        // If Watch Video Button is checked
        $this->addElement('Text', 'video_Button_label', array(
            'label' => 'Button Label',
            'description' => 'Enter the label text for watch video button.',
            'allowEmpty' => $allowEmptyvideo,
            'required' => $reqvideo,
        ));
        $this->addElement('Text', 'video_background_color', array(
            'label' => 'Background Color',
            'description' => 'Choose the background color for the watch video button.',
            'class' => 'SEScolor',
            'allowEmpty' => $allowEmptyvideo,
            'required' => $reqvideo,
        ));
        $this->addElement('Text', 'video_text_color', array(
            'label' => 'Text Color',
            'class' => 'SEScolor',
            'description' => 'Choose the text color for the watch video button.',
            'allowEmpty' => $allowEmptyvideo,
            'required' => $reqvideo,
        ));
        $this->addElement('Text', 'video_mouseover_background_color', array(
            'label' => 'Mouseover Background Color',
            'description' => 'Choose the background color for the CTA button 1 when users mouseover on the button.',
            'class' => 'SEScolor',
            'allowEmpty' => $allowEmptyvideo,
            'required' => $reqvideo,
        ));
        $this->addElement('Text', 'video_mouseover_text_color', array(
            'label' => 'Mouseover Text Color',
            'class' => 'SEScolor',
            'description' => 'Choose the text color for the CTA button 1 when users mouseover on the button.',
            'allowEmpty' => $allowEmptyvideo,
            'required' => $reqvideo,
        ));
        $reqvideoupload = false;
        $allowEmptyvideoUpload = true;
        $reqvideouploadurl = false;
        $allowEmptyvideourl = true;
        if (!empty($_POST) && $_POST['video_video_url'] == 4 && $_POST['enable_watch_video_button'] && !$slideId) {
            $reqvideoupload = true;
            $allowEmptyvideoUpload = false;
        } else if (!empty($_POST) && $_POST['enable_watch_video_button'] && $_POST['video_video_url'] != 4) {
            $reqvideouploadurl = true;
            $allowEmptyvideourl = false;
        }
            $this->addElement('Radio', 'video_video_url', array(
                'label' => 'Video Type',
                'description' => 'Choose Video type from the below Options for Video Button.',
                'allowEmpty' => true,
                'required' => false,
                'multiOptions' => array(
                    '1' => 'Youtube',
                    '2' => 'Vimeo',
                    '3' => 'Dailymotion',
                    '4' => 'upload',
                ),
                'value' => '4',
                'onChange' => 'video_buton(this.value);'
            ));
        $this->addElement('File', 'video_upload', array(
            'label' => 'Video URL',
            'description' => 'Upload the video which will be shown in the popup when users click on this button.[Note: Videos with extension “mp4" will only be supported.]',
            'required' => $reqvideoupload,
            'allowEmpty' => $allowEmptyvideoUpload,
        ));
            $this->video_upload->addValidator('Extension', false, 'mp4');
            $this->addElement('textarea', 'video_video_file_url', array(
                'label' => 'Video URL',
                'description' => 'Enter the embed code of the video which will be shown in the popup when users click on this button.',
                'required' => $reqvideouploadurl,
                'allowEmpty' => $allowEmptyvideourl,
            ));
         if(($slide->file_id || $slide->video_video_file_url) && $slide){
            if($slide->video_video_url == 4){
                 $ImageSrc = Engine_Api::_()->storage()->get($slide->file_id, '')->map();
                if($ImageSrc){
                    $this->addElement('Dummy', 'dummy_7', array(
                        'content' => '<iframe src="'.$ImageSrc.'"></iframe>',
                    ));
                }
            }else{
                $ImageSrc = $slide->video_video_file_url;
                if($ImageSrc){
                    $this->addElement('Dummy', 'dummy_7', array(
                        'content' => $ImageSrc,
                    ));
                }
            }
			$this->addElement('Checkbox', 'remove_video', array(
				'label' => 'Yes, remove this Video.'
			));
        }
        $this->addElement('Dummy', 'dummy_3', array(
            'content' => '<h2 style="margin: 0px;">View Privacy Settings</h2>',
        ));
        // View Privacy Setting
        $levelOptions = array();
        $levelOptions[''] = 'Everyone';
        foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
            $levelOptions[$level->level_id] = $level->getTitle();
        }
        $this->addElement('Multiselect', 'member_level_view_privacy', array(
            'label' => 'Member Level View Privacy',
            'description' => 'Choose the member levels to which this slide will be displayed. (Ctrl + Click to select multiple member levels.)',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => $levelOptions,
            'value' => '',
        ));
        $networkTable = Engine_Api::_()->getDbtable('networks', 'network');
        $select = $networkTable->select();
        $network = $networkTable->fetchAll($select);
        $dataNetwork[''] = 'Everyone';
        foreach ($network as $networks) {
            $dataNetwork[$networks->network_id] = $networks->getTitle();
        }
        $this->addElement('Multiselect', 'network_view_privacy', array(
            'label' => 'Network View Privacy',
            'description' => 'Choose the networks to which this slide will be displayed. (Ctrl + Click to select multiple networks.)',
            'multiOptions' => $dataNetwork,
            'value' => '',
        ));
        $this->addElement('Radio', 'show_non_loged_in', array(
            'label' => 'Show to Non-logged in Users',
            'description' => 'Do you want to show this Slide to non-logged in users of your website?',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No'
            ),
            'value' => '1',
        ));
        // Buttons
        $this->addElement('Button', 'save', array(
            'label' => 'Save',
            'type' => 'submit',
            'ignore' => true,
            'decorators' => array('ViewHelper')
        ));
        $this->addElement('Button', 'submit', array(
            'label' => 'Save & Exit',
            'type' => 'submit',
            'ignore' => true,
            'decorators' => array('ViewHelper')
        ));
        $this->addElement('Cancel', 'cancel', array(
            'label' => 'Cancel',
            'link' => true,
            'prependText' => ' or ',
            'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
            'onClick' => 'javascript:parent.Smoothbox.close();',
            'decorators' => array(
                'ViewHelper'
            )
        ));
        $this->addDisplayGroup(array('save', 'submit', 'cancel'), 'buttons');
    }
}
