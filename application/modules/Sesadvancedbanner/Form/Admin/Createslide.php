<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesadvancedbanner
 * @package Sesadvancedbanner
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: Createslide.php 2018-07-26 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */

class Sesadvancedbanner_Form_Admin_Createslide extends Engine_Form {

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

    $this
            ->setTitle('Upload New Photo Slide')
            ->setDescription("Below, You can upload new photo slide for the banner slideshow and configure the settings for the slide.")
            ->setAttrib('id', 'form-create-banner')
            ->setAttrib('name', 'Sesadvancedbanner_create_banner')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setAttrib('onsubmit', 'return checkValidation();')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $this->setMethod('post');
    $this->addElement('Text', 'title', array(
        'label' => 'Caption',
        'description' => 'Enter the caption for this photo slide.',
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
        'value' => 54,
    ));
    $this->addElement('Select', 'title_font_family', array(
        'label' => 'Caption Font Family',
        'description' => 'Choose the font family for the Caption.',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions' => $googleFontArray,
    ));

    $this->addElement('Textarea', 'description', array(
        'label' => 'Description',
        'description' => 'Enter the description for this photo slide.',
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
        'value' => 18,
    ));
    $this->addElement('Select', 'description_font_family', array(
        'label' => 'Description Font Family',
        'description' => 'Choose the font family for the Description.',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions' => $googleFontArray,
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
		
		  $this->addElement('Text', 'slide_overlaycolor', array(
        'label' => 'Slide Overlay Color',
        'description' => 'Choose the overlay color for slide.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
		 $this->addElement('Text', 'slide_opacity', array(
        'label' => 'Slide Overlay Opacity',
        'description' => 'Enter the slide opacity (between 0-1 eg. "0.23").',
        'allowEmpty' => true,
        'required' => false,
        'value'=>0.3
    ));
		$petterns = array();
		$petterns['9.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/9.png" alt="" /></span>';
		$petterns['14.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/14.png" alt="" /></span>';
		$petterns['15.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/15.png" alt="" /></span>';
		$petterns['16.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/16.png" alt="" /></span>';
		$petterns['17.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/17.png" alt="" /></span>';
		$petterns['18.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/18.png" alt="" /></span>';
		$petterns['19.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/19.png" alt="" /></span>';
		$petterns['20.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/20.png" alt="" /></span>';
		$petterns['21.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/21.png" alt="" /></span>';
		$petterns['22.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/22.png" alt="" /></span>';
		$petterns['23.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/23.png" alt="" /></span>';
		$petterns['24.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/24.png" alt="" /></span>';
		$petterns['25.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/25.png" alt="" /></span>';
		$petterns['26.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/26.png" alt="" /></span>';
		$petterns['27.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/27.png" alt="" /></span>';
		$petterns['28.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/28.png" alt="" /></span>';
		$petterns['29.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/29.png" alt="" /></span>';
		$petterns['30.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/30.png" alt="" /></span>';
		$petterns['Pattern-1.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/Pattern-1.png" alt="" /></span>';$petterns['Pattern-2.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/Pattern-2.png" alt="" /></span>';$petterns['Pattern-3.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/Pattern-3.png" alt="" /></span>';$petterns['Pattern-4.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/Pattern-4.png" alt="" /></span>';$petterns['Pattern-5.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/Pattern-5.png" alt="" /></span>';$petterns['Pattern-6.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/Pattern-6.png" alt="" /></span>';$petterns['Pattern-7.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/Pattern-7.png" alt="" /></span>';$petterns['Pattern-8.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/Pattern-8.png" alt="" /></span>';$petterns['Pattern-10.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/Pattern-10.png" alt="" /></span>';$petterns['Pattern-11.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/Pattern-11.png" alt="" /></span>';$petterns['Pattern-12.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/Pattern-12.png" alt="" /></span>';$petterns['Pattern-13.png'] = '<span class="pattern_img"><img src="./application/modules/Sesadvancedbanner/externals/images/Pattern-13.png" alt="" /></span>';
		$this->addElement('Radio', 'overlay_pettern', array(
        'label' => 'Overlay Pattern',
        'description' => 'Choose the Pattern for the Overlay.',
        'allowEmpty' => true,
        'required' => false,
				'multiOptions'=>$petterns,
				'escape' => false,
				
    ));
		
		
    /*$this->addElement('Text', 'slide_background_color', array(
        'label' => 'Slide Background Color',
        'description' => 'Choose the color for slide.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
    */
  
   

    $array = array('_left'=>'Left Align','_center'=>'Center Align','_right'=>'Right Align');
    $this->addElement('Select', 'text_description_allignment', array(
        'label' => 'Text/Description Alignment',
        'description' => 'Choose from below the text/description alignment.',
        'multiOptions'=>$array,
        'allowEmpty' => true,
        'required' => false,
        'value'=>'_center'
    ));

    $banner_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('slide_id', 0);
		if($banner_id)
			$banner = Engine_Api::_()->getItem('sesadvancedbanner_slide', $banner_id);
		else
			$banner = '';
    if (!$banner_id) {
      $required = true;
      $allowEmpty = false;
    } else {
      $required = false;
      $allowEmpty = false;
    }

    $this->addElement('File', 'file', array(
        'allowEmpty' => $allowEmpty,
        'required' => $required,
        'label' => 'Choose Photo',
        'description' => 'Choose the photo. [Note: only the photos with extension: “.jpg, .png and .jpeg are allowed.                          Suggested size is 1360 x 500 pixels]',
    ));
    $this->file->addValidator('Extension', false, 'jpg,png,jpeg');
		
		if(!empty($banner) && $banner->file_id){
			$ImageSrc = Engine_Api::_()->storage()->get($banner->file_id, '');
			if($ImageSrc){
				$ImageSrc = $ImageSrc->getPhotoUrl();
				$this->addElement('Dummy', 'imagedummy_1', array(
				 'content' => '<img src="'.$ImageSrc.'" alt="image" height="100" width="100">',
				));
			}
		}

    //extra button code
    $this->addElement('Select', 'extra_button', array(
        'label' => 'Show Additional Button 1',
        'description' => 'Do you want to show an additional button on this photo slide?',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '0',
        'onChange' => 'extra_buton(this.value);'
    ));
		$this->addElement('Text', 'extra_button_text', array(
        'label' => 'Button 1 Text',
        'description' => 'Enter the text for the button.',
        'allowEmpty' => true,
        'required' => false,
        'value' => 'Read More',
    ));

    $this->addElement('Text', 'extra_button_textcolor', array(
        'label' => 'Button 1 Text Color',
        'description' => 'Choose the color for the button.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Text', 'extra_button_textcoloractive', array(
        'label' => 'Button 1 Text Hover Color',
        'description' => 'Choose the color for the button text hover color.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Text', 'extra_button_backgroundcolor', array(
        'label' => 'Button 1 Background Color',
        'description' => 'Choose the color for the button background.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Text', 'extra_button_backgroundactivecolor', array(
        'label' => 'Button 1 Background Hover Color',
        'description' => 'Choose the color for the button background hover color.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Text', 'extra_button_cornerradius', array(
        'label' => 'Button 1 Radius',
        'description' => 'Enter the button radius.',
        'allowEmpty' => true,
        'required' => false,
        'value'=>0
    ));
    $this->addElement('Text', 'extra_button_link', array(
        'label' => 'Link for Button 1',
        'description' => 'Enter a link for the button.',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Select', 'extra_button_linkopen', array(
        'label' => 'Button 1 Link Target',
        'description' => 'Do you want to open button link in new tab?',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '0'
    ));
    //extra button code
    $this->addElement('Select', 'extra_button1', array(
        'label' => 'Show Additional Button 2',
        'description' => 'Do you want to show an additional button on this photo slide?',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '0',
        'onChange' => 'extra_buton1(this.value);'
    ));
		$this->addElement('Text', 'extra_button1_text', array(
        'label' => 'Button 2 Text',
        'description' => 'Enter the text for the button.',
        'allowEmpty' => true,
        'required' => false,
        'value' => 'Read More 1',
    ));

    $this->addElement('Text', 'extra_button1_textcolor', array(
        'label' => 'Button 2 Text Color',
        'description' => 'Choose the color for the button.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Text', 'extra_button1_textcoloractive', array(
        'label' => 'Button 2 Text Hover Color',
        'description' => 'Choose the color for the button text hover color.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Text', 'extra_button1_backgroundcolor', array(
        'label' => 'Button 2 Background Color',
        'description' => 'Choose the color for the button background.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Text', 'extra_button1_backgroundactivecolor', array(
        'label' => 'Button 2 Background Hover Color',
        'description' => 'Choose the color for the button background hover color.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Text', 'extra_button1_cornerradius', array(
        'label' => 'Button 2 Radius',
        'description' => 'Enter the button radius.',
        'allowEmpty' => true,
        'required' => false,
        'value'=>0
    ));
    $this->addElement('Text', 'extra_button1_link', array(
        'label' => 'Link for Button 2',
        'description' => 'Enter a link for the button.',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->addElement('Select', 'extra_button1_linkopen', array(
        'label' => 'Button 2 Link Target',
        'description' => 'Do you want to open button link in new window?',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '0'
    ));
    $this->addElement('Select', 'text_buttons_allignment', array(
        'label' => 'Button Alignment',
        'description' => 'Choose from below the button alignment.',
        'multiOptions'=>$array,
        'allowEmpty' => true,
        'required' => false,
        'value'=>'_center'
    ));
    $this->addElement('Select', 'button_type', array(
        'label' => 'Button Type',
        'description' => 'Select from below the button type in this slide.',
        'multiOptions' => array('1' => 'Fill', '0' => 'Transparent'),
        'value' => '1',
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
