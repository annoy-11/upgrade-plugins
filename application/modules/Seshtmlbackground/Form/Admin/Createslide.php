<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seshtmlbackground
 * @package    Seshtmlbackground
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Createslide.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seshtmlbackground_Form_Admin_Createslide extends Engine_Form {
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
      $googleFontArray[$re["family"]] = $re['family'];
    }
		$slide_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('slide_id', 0);
		if($slide_id)
			$slide = Engine_Api::_()->getItem('seshtmlbackground_slide', $slide_id);
		else
			$slide = '';
		
    $this
            ->setTitle('Upload New Video or Photo')
            ->setDescription("Below, enter the details for the new video or photo.")
            ->setAttrib('id', 'form-create-slide')
            ->setAttrib('name', 'seshtmlbackground_create_slide')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setAttrib('onsubmit', 'return checkValidation();')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    $this->setMethod('post');
    $this->addElement('Text', 'title', array(
        'label' => 'Caption',
        'description' => 'Enter the caption for this video or photo.',
        'allowEmpty' => true,
        'required' => false,
    ));
    
		$this->addElement('Text', 'title_button_color', array(
        'label' => 'Caption Color',
        'description' => 'Choose the color for the caption.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
		$this->addElement('Text', 'title_font_size', array(
        'label' => 'Caption Font Size',
        'description' => 'Enter the Font Size of Caption (in pixels).',
        'allowEmpty' => true,
        'required' => false,
    ));
		$this->addElement('Select', 'title_font_family', array(
        'label' => 'Caption Font Family',
        'description' => 'Choose the font family for the Caption',
				'multiOptions' => $googleFontArray,
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Textarea', 'description', array(
        'label' => 'Description',
        'description' => 'Enter the description for this video or photo.',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Text', 'description_button_color', array(
        'label' => 'Description Color',
        'description' => 'Choose the color for the description.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
		$this->addElement('Text', 'description_font_size', array(
        'label' => 'Description Font Size',
        'description' => 'Enter the Font Size of Description (in pixels).',
        'allowEmpty' => true,
        'required' => false,
    ));
		$this->addElement('Select', 'description_font_family', array(
        'label' => 'Description Font Family',
        'description' => 'Choose the font family for the Description',
				'multiOptions' => $googleFontArray,
        'allowEmpty' => true,
        'required' => false,
    ));
		$this->addElement('Radio', 'overlay_type', array(
        'label' => 'Overlay',
        'description' => 'How do you want to show Overlay (Color or Pattern).',
        'allowEmpty' => true,
        'required' => false,
				'multioptions' => array(
					'1' => 'Overlay',
					'2' => 'Pattern',
				),
				'onchange' => 'backgroundoverlay(this.value)',
				'value' => '1',
    ));
		
		$this->addElement('Text', 'overlay_color', array(
        'label' => 'Slide Overlay Color',
        'description' => 'Choose the color for the Overlay.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
		$this->addElement('Text', 'overlay_opacity', array(
        'label' => 'Overlay Opacity',
        'description' => 'Choose the Opacity for the Overlay.',
        'allowEmpty' => true,
        'required' => false,
				'value'=>0.3,
				'validators' => array(
					array('Float', true),
					array('GreaterThan', true, array(0)),
				)
    ));
		$petterns = array();
		$petterns['9.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/9.png" alt="" /></span>';
		$petterns['14.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/14.png" alt="" /></span>';
		$petterns['15.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/15.png" alt="" /></span>';
		$petterns['16.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/16.png" alt="" /></span>';
		$petterns['17.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/17.png" alt="" /></span>';
		$petterns['18.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/18.png" alt="" /></span>';
		$petterns['19.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/19.png" alt="" /></span>';
		$petterns['20.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/20.png" alt="" /></span>';
		$petterns['21.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/21.png" alt="" /></span>';
		$petterns['22.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/22.png" alt="" /></span>';
		$petterns['23.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/23.png" alt="" /></span>';
		$petterns['24.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/24.png" alt="" /></span>';
		$petterns['25.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/25.png" alt="" /></span>';
		$petterns['26.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/26.png" alt="" /></span>';
		$petterns['27.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/27.png" alt="" /></span>';
		$petterns['28.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/28.png" alt="" /></span>';
		$petterns['29.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/29.png" alt="" /></span>';
		$petterns['30.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/30.png" alt="" /></span>';
		$petterns['Pattern-1.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/Pattern-1.png" alt="" /></span>';$petterns['Pattern-2.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/Pattern-2.png" alt="" /></span>';$petterns['Pattern-3.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/Pattern-3.png" alt="" /></span>';$petterns['Pattern-4.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/Pattern-4.png" alt="" /></span>';$petterns['Pattern-5.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/Pattern-5.png" alt="" /></span>';$petterns['Pattern-6.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/Pattern-6.png" alt="" /></span>';$petterns['Pattern-7.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/Pattern-7.png" alt="" /></span>';$petterns['Pattern-8.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/Pattern-8.png" alt="" /></span>';$petterns['Pattern-10.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/Pattern-10.png" alt="" /></span>';$petterns['Pattern-11.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/Pattern-11.png" alt="" /></span>';$petterns['Pattern-12.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/Pattern-12.png" alt="" /></span>';$petterns['Pattern-13.png'] = '<span class="pattern_img"><img src="./application/modules/Seshtmlbackground/externals/images/Pattern-13.png" alt="" /></span>';
		$this->addElement('Radio', 'overlay_pettern', array(
        'label' => 'Overlay Pattern',
        'description' => 'Choose the Pattern for the Overlay.',
        'allowEmpty' => true,
        'required' => false,
				'multiOptions'=>$petterns,
				'escape' => false,
				
    ));
		$this->addElement('Text', 'youtube_video_link', array(
			'label' => 'Youtube Video for Template 8',
			'description' => 'Enter the youtube video link, which will be displayed in Template 8 of this HTML5 Background. This video will be shown in a small box over the Background image.',
			'allowEmpty' => true,
			'required' => false,
		));
		if(!empty($slide) && $slide->youtube_video_link){
			$this->addElement('Dummy', 'youtubedummy_1', array(
			 'content' =>'<div style="height:auto;width:300px">'.$slide->youtube_video_code.'</div>',
			));
		}
		
    if (!$slide_id) {
      $required = false;
      $allowEmpty = true;
    } else {
      $required = false;
      $allowEmpty = true;
    }
    $this->addElement('File', 'thumb', array(
        'label' => 'Thumbnail',
        'description' => 'Upload a thumbnail image for the video. This thumbnail will be shown in the HTML5 Video Background at user end.',
        'allowEmpty' => $allowEmpty,
        'required' => $required,
    ));
		if(!empty($slide) && $slide->thumb_icon){
			$ImageSrc = Engine_Api::_()->storage()->get($slide->thumb_icon, '');
			if($ImageSrc){
				$ImageSrc = $ImageSrc->getPhotoUrl();
				$this->addElement('Dummy', 'imagedummy_1', array(
				 'content' => '<img src="'.$ImageSrc.'" alt="image" height="100" width="100" style="object-fit:cover;">',
				));
			}
		}
    $this->thumb->addValidator('Extension', false, 'jpg,png,jpeg,gif');
		if(!Engine_Api::_()->getApi('settings', 'core')->seshtmlbackground_ffmpeg_path){
			$onlyMp4 = ',mp4';
			$mp4VideoText = 'currently this plugin support ".mp4" videos only';
		}else{
			$onlyMp4 = '';
			$mp4VideoText = 'This plugin support all videos types';
		}
		
    $this->addElement('File', 'file', array(
        'allowEmpty' => $allowEmpty,
        'required' => $required,
        'label' => 'Upload Video or Photo',
        'description' => 'Upload a video or photo [Note: '.$mp4VideoText.'  and photos with extension: “jpg, png and jpeg] only.]',
    ));
		if(!empty($slide) && $slide->file_id && $slide->file_type){
			if($slide->file_type == 'mp4'){
				$this->addElement('Dummy', 'imagedummy_3', array(
				 'content' => '<video controls width="200" height="200"><source src="'.$slide->getFilePath('file_id').'" type="video/mp4"></video>',
				));
			}else{
				$ImageSrc = Engine_Api::_()->storage()->get($slide->file_id, '');
				if($ImageSrc){
					$ImageSrc = $ImageSrc->getPhotoUrl();
					$this->addElement('Dummy', 'imagedummy_2', array(
					 'content' => '<img src="'.$ImageSrc.'" alt="image" height="120" width="120" style="object-fit:cover;">',
					));
				}
			}
			
		}
    
    //login button code
    $this->addElement('Select', 'login_button', array(
        'label' => 'Show Login Button',
        'description' => 'Do you want to show login button to the non-logged in users in the video or photo?',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '1',
        'onChange' => 'log_button(this.value);'
    ));
    $this->addElement('Text', 'login_button_text', array(
        'label' => 'Login Button Text',
        'description' => 'Enter the text for the login button.',
        'allowEmpty' => true,
        'required' => false,
        'value' => 'Login',
    ));
    $this->addElement('Text', 'login_button_text_color', array(
        'label' => 'Login Button Text Color',
        'description' => 'Choose the color for the login button text.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
				'value'=>'0295FF',
    ));
    $this->addElement('Text', 'login_button_color', array(
        'label' => 'Login Button Color',
        'description' => 'Choose the color for the login button.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
				'value'=>'#ffffff',
    ));
    $this->addElement('Text', 'login_button_mouseover_color', array(
        'label' => 'Login Button Mouse-over Color',
        'description' => 'Choose the color for the login button when users mouse over on it.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
				'value'=>'#eeeeee',
    ));


    //signup button code
    $this->addElement('Select', 'signup_button', array(
        'label' => 'Show Sign Up Button',
        'description' => 'Do you want to show login button to the non-logged in users in the video or photo?',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '1',
        'onChange' => 'sign_button(this.value);'
    ));
		$this->addElement('Text', 'signup_button_text', array(
        'label' => 'Sign Up Button Text',
        'description' => 'Enter the text for the sign up button.',
        'allowEmpty' => true,
        'required' => false,
        'value' => 'Signup',
    ));
    $this->addElement('Text', 'signup_button_text_color', array(
        'label' => 'Sign Up Button Text Color',
        'description' => 'Choose the color for the login button text.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
				'value'=>'#ffffff',
    ));
    $this->addElement('Text', 'signup_button_color', array(
        'label' => 'Sign Up Button Color',
        'description' => 'Choose the color for the sign up button.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
				'value'=>'#0295FF',
    ));
    $this->addElement('Text', 'signup_button_mouseover_color', array(
        'label' => 'Signup Button Mouse-over Color',
        'description' => 'Choose the color for the sign up button when users mouse over on it.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
				'value'=>'#067FDE',
    ));
    $this->addElement('Select', 'show_register_form', array(
        'label' => 'Show Sign Up Form',
        'description' => 'Do you want to show the sign up form in this video or photo? [Note: This Setting will not work in Template 2,3 and 8]',
       
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '0',
        'onChange' => 'register_form(this.value);'
    ));
		$this->addElement('Select', 'show_login_form', array(
        'label' => 'Show Login Form',
        'description' => 'Do you want to show the login form in this video or photo? [Note: This Setting will not work in Template 2,3 and 8]',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '0',
        'onChange' => 'register_form(this.value);'
    ));
    $this->addElement('Select', 'position_register_form', array(
        'label' => 'Sign Up Form Placement',
        'description' => 'Choose the placement of the sign up form [Note: This Setting will not work in Template 2,3,6,7 and 8].',
        'multiOptions' => array('right' => 'Right Side', 'left' => 'Left Side'),
        'value' => 'right',
    ));

    //extra button code
    $this->addElement('Select', 'extra_button', array(
        'label' => 'Show Additional Button',
        'description' => 'Do you want to show an additional button on this video / photo?',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '0',
        'onChange' => 'extra_buton(this.value);'
    ));
		$this->addElement('Text', 'extra_button_text', array(
        'label' => 'Button Text',
        'description' => 'Enter the text for the button.',
        'allowEmpty' => true,
        'required' => false,
        'value' => 'Read More',
    ));
    $this->addElement('Text', 'extra_button_text_color', array(
        'label' => 'Button Text Color',
        'description' => 'Choose the color for the button text.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
				'value'=>'#ffffff',
    ));
    $this->addElement('Text', 'extra_button_color', array(
        'label' => 'Button Color',
        'description' => 'Choose the color for the login button.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
				'value'=>'#F25B3B',
    ));
    $this->addElement('Text', 'extra_button_mouseover_color', array(
        'label' => 'Button Mouse-over Color',
        'description' => 'Choose the color for the button when users mouse over on it.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
				'value'=>'#EA350F',
    ));
    $this->addElement('Text', 'extra_button_link', array(
        'label' => 'Link for Button',
        'description' => 'Enter a link for the button.',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Select', 'extra_button_linkopen', array(
        'label' => 'Button Link Target',
        'description' => 'Do you want to open button link in new tab?',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '0'
    ));
    
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
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
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
