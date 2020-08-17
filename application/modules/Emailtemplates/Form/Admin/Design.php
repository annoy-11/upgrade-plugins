<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Design.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Emailtemplates_Form_Admin_Design extends Engine_Form {

  public function init() {
		
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$templateId = $request->getParam('template_id', null)?$request->getParam('template_id', null):$request->getParam('duplicate', null);
		if($templateId)
		 $template = Engine_Api::_()->getItem('emailtemplates_template', $templateId);
		else
			$template = '';
		
    $settings = Engine_Api::_()->getApi('settings', 'core');
	/*------------------ Title -----------------------------*/
		
		$this->addElement('Text', 'title', array(
			'label' => 'Template Title',
			'allowEmpty' => false,
			'required' => true,
    ));

		$this->addElement('Text', 'mail_background_color', array(
			'label' => 'Mail Background Color',
			'description' => 'Select Email background color which you want to show in background of mail template',
			'allowEmpty' => true,
			'required' => false,
			'class' => 'SEScolor',
    ));
		$this->addElement('Text', 'mail_padding_topbottom', array(
			'label' => 'Mail Padding from Top-Bottom',
			'description' => 'Enter the padding in px',
			'allowEmpty' => true,
			'required' => false,
    ));
		$this->addElement('Text', 'mail_padding_rightleft', array(
			'label' => 'Mail Padding from Left-Right',
			'description' => 'Enter the padding in px',
			'allowEmpty' => true,
			'required' => false,
    ));
	/*------------------ Header -----------------------------*/

		$this->addElement('Dummy', 'dummy1', array(
			'content' => '<h2 style="margin: 0px;" class="section_heading">Header</h2>',
		));
		$this->addElement('hidden', 'is_active', array(
			'value'=>'0',
    ));
    $this->addElement('File', 'header_logo', array(
			'label' => 'Upload Logo',
			'description'=>'Upload logo which you want to show in Email Template\'s header.',
    ));
		$this->header_logo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
		if(!empty($template) && $template->header_logo && Engine_Api::_()->storage()->get($template->header_logo, '')){
			$image = Engine_Api::_()->storage()->get($template->header_logo, '')->getPhotoUrl();
			if($image){
				$this->addElement('Dummy', 'editdummy_1', array(
					'content' => '<img src="'.$image.'" alt="Header Logo" style="max-height:70px;" >',
				));
			}
		}
		
		$this->addElement('Select', 'header_logo_align', array(
			'label' => 'Logo Alignment',
			'description'=>'Choose Alignment of logo. logo alignment center applicable for "Show Email & Phone" setting Selected as "NO" ',
			'allowEmpty' => true,
			'required' => false,
			'multiOptions'=> array(
				'1'=>'Left',
				'2'=>'Center',
				'3'=>'Right',
			),
			'value'=>'1',
    ));
		
		$this->addElement('Radio', 'header_emailphone_show', array(
			'label' => 'Show Email & Phone',
			'description'=>'Do you want to show Email and Phone in Header.',
			'allowEmpty' => true,
			'required' => false,
			'onchange' => 'showemail(this.value)',
			'multiOptions'=> array(
				'1'=>'yes',
				//'2'=>'Center',
				'0'=>'No',
			),
			'value'=>'1',
    ));
		$this->addElement('Radio', 'footer_social_icons_type', array(
			'label' => 'Icons Type',
			'description' => 'Choose the type of Icons which you want to show in this template.',
			'multiOptions' => array(
				'0'=>'Dark icon',
				'1'=> 'Light icon',
			),
			'value' => '0',
    ));
		$this->addElement('Text', 'header_mail', array(
			'label' => 'Email',
			'description'=>'Enter Email Id which you want to show in Email Template\'s header.',
    ));

		$this->addElement('Text', 'header_phone', array(
			'label' => 'Phone Number',
			'description'=>'Enter Phone Number which you want to show in Email Template\'s header.',
    ));
		
		

		$this->addElement('Select', 'header_emailphone_align', array(
			'label' => 'Email & Phone Alignment',
			'description'=>'Choose alignment of Email & Phone Number in Header.',
			'allowEmpty' => true,
			'required' => false,
			'multiOptions'=> array(
				'1' => 'Left',
				'2' => 'Right',
			),
			'value'=>'2',
    ));
		
		$this->addElement('Text', 'header_background_color', array(
			'label' => 'Background Color',
			'description' => 'Choose Background color of Header',
			'class' => 'SEScolor',
    ));
		$this->addElement('Text', 'font_color_textemailphone', array(
			'label' => 'Font color',
			'description'=>'Choose the text font color for Email and phone \'s.',
			'class' => 'SEScolor',
    ));
		

		$this->addElement('Text', 'header_border_Width', array(
			'label' => 'Border Width',
			'description' => 'Enter border width in px.',
			'value' => '1',
    ));

		$this->addElement('Text', 'header_border_color', array(
			'label' => 'Border Color',
			'class' => 'SEScolor',
			'description'=>'Choose border color.',
    ));

		$this->addElement('Select', 'header_border_style', array(
			'label' => 'Border Style',
			'description'=>'Choose border style.',
			'multioptions'=>array(
			'none'=>'none',
			'hidden'=>'hidden',
			'dotted'=>'dotted',
			'dashed'=>'dashed',
			'solid'=>'solid',
			'double'=>'double',
			'groove'=>'groove',
			'ridge'=>'ridge',
			'inset'=>'inset',
			'outset'=>'outset',
			'initial'=>'initial',
			'inherit'=>'inherit',
			),
			'value'=>'solid',
    ));
		$this->addElement('Text', 'header_padding', array(
			'label' => 'Padding',
			'description' => 'Enter Padding in px.',
			'value' => '1',
    ));

		

	/*------------------ Tagline -----------------------------*/

		$this->addElement('Dummy', 'dummy2', array(
			'content' => '<h2 style="margin: 0px;" class="section_tagline">Tagline</h2>',
		));
		$this->addElement('Select', 'tagline_position', array(
			'label' => 'Tagline Position',
			'description'=>'Choose Tagline Position.',
			'allowEmpty' => true,
			'required' => false,
			'multiOptions'=> array(
				'1' => 'Above Header',
				'2' => 'Below Header',
			),
			'value'=>'1',
    ));
		$this->addElement('Text', 'tagline_content', array(
			'label' => 'Tagline Content',
			'description'=>'Enter Content for Tagline.',
			'allowEmpty' => true,
			'required' => false,
    ));
		$this->addElement('Text', 'tagline_font_color', array(
			'label' => 'Tagline Font Color',
			'description'=>'Choose Font color for Tagline.',
			'allowEmpty' => true,
			'required' => false,
			'class' => 'SEScolor',
    ));
		$this->addElement('Text', 'tagline_background_color', array(
			'label' => 'Background Color',
			'description' => 'Choose Background color of Tagline',
			'class' => 'SEScolor',
    ));
		$this->addElement('Text', 'tagline_border_Width', array(
			'label' => 'Border Width',
			'description' => 'Enter Border width in px.',
			'value' => '1',
    ));
		$this->addElement('Text', 'tagline_border_color', array(
			'label' => 'Border Color',
			'class' => 'SEScolor',
			'description'=>'Choose border color.',
    ));
		$this->addElement('Select', 'tagline_border_style', array(
			'label' => 'Border Style',
			'description'=>'Choose Border style.',
			'multioptions'=>array(
			'none'=>'none',
			'hidden'=>'hidden',
			'dotted'=>'dotted',
			'dashed'=>'dashed',
			'solid'=>'solid',
			'double'=>'double',
			'groove'=>'groove',
			'ridge'=>'ridge',
			'inset'=>'inset',
			'outset'=>'outset',
			'initial'=>'initial',
			'inherit'=>'inherit',
			),
			'value'=>'solid',
    ));
		$this->addElement('Select', 'tagline_text_alignment', array(
			'label' => 'Text Alignment',
			'description' => 'Choose Text Alignment.',
			'allowEmpty' => true,
			'required' => false,
			'multiOptions'=> array(
				'1'=>'Left',
				'2'=>'Center',
				'3'=>'Right',
			),
			'value'=>'2',
    ));
		$this->addElement('Text', 'tagline_padding', array(
			'label' => 'Padding',
			'description' => 'Enter Padding in px.',
			'value' => '1',
    ));
		
	/*------------------ Body -----------------------------*/

		$this->addElement('Dummy', 'dummy3', array(
			'content' => '<h2 style="margin: 0px;" class="section_body">Body</h2>',
		));
		$this->addElement('Text', 'body_background_color', array(
			'label' => 'Background Color',
			'description' => 'Choose Background color of Body',
			'class' => 'SEScolor',
    ));
		$this->addElement('Text', 'body_text_color', array(
			'label' => 'Body Text Color',
			'description' => 'Choose text color of Body',
			'value' => '000000',
			'class' => 'SEScolor',
    ));
		$this->addElement('Text', 'body_border_Width', array(
			'label' => 'Border Width',
			'description' => 'Enter Border width in px.',
			'value' => '1',
    ));
		$this->addElement('Text', 'body_border_color', array(
			'label' => 'Border Color',
			'class' => 'SEScolor',
			'description'=>'Choose Border color.',
    ));
		$this->addElement('Select', 'body_border_style', array(
			'label' => 'Border Style',
			'description'=>'Choose Border style.',
			'multioptions'=>array(
			'none'=>'none',
			'hidden'=>'hidden',
			'dotted'=>'dotted',
			'dashed'=>'dashed',
			'solid'=>'solid',
			'double'=>'double',
			'groove'=>'groove',
			'ridge'=>'ridge',
			'inset'=>'inset',
			'outset'=>'outset',
			'initial'=>'initial',
			'inherit'=>'inherit',
			),
			'value'=>'solid',
    ));
		
		$this->addElement('Text', 'body_padding', array(
			'label' => 'Padding',
			'description' => 'Enter Padding in px.',
			'value' => '1',
    ));
		
	/*------------------ Footer -----------------------------*/
		$this->addElement('Dummy', 'dummy4', array(
			'content' => '<h2 style="margin: 0px;" class="section_footer">Footer</h2>',
		));
		$this->addElement('Multiselect', 'footer_social_icons', array(
			'label' => 'Social Icons',
			'description'=>'Choose Social Icons which you want to show in Footer.',
			'multioptions'=>array(
				'Facebbok'=>'Facebbok',
				'Twitter'=>'Twitter',
				'Linkedin'=>'Linkedin',
				'instagram'=>'instagram',
				'Google Plus'=>'Google Plus',
				'Pinterest'=>'Pinterest',
				'Flickr'=>'Flickr',
			),
			'value'=>array('Facebbok','Twitter','Linkedin','instagram','Google Plus','Pinterest','Flickr'),
    ));
		
		
		$this->addElement('Text', 'footer_background_color', array(
			'label' => 'Background Color',
			'description' => 'Choose Background color of Footer',
			'class' => 'SEScolor',
    ));
		$this->addElement('Text', 'footer_border_Width', array(
			'label' => 'Border Width',
			'description' => 'Enter Border width in px.',
			'value' => '1',
    ));
		$this->addElement('Text', 'footer_border_color', array(
			'label' => 'Border Color',
			'class' => 'SEScolor',
			'description'=>'Choose Border color.',
    ));
		$this->addElement('Select', 'footer_border_style', array(
			'label' => 'Border Style',
			'description'=>'Choose Border style.',
			'multioptions'=>array(
			'none'=>'none',
			'hidden'=>'hidden',
			'dotted'=>'dotted',
			'dashed'=>'dashed',
			'solid'=>'solid',
			'double'=>'double',
			'groove'=>'groove',
			'ridge'=>'ridge',
			'inset'=>'inset',
			'outset'=>'outset',
			'initial'=>'initial',
			'inherit'=>'inherit',
			),
			'value'=>'solid',
    ));
		$this->addElement('Select', 'footer_text_alignment', array(
			'label' => 'Text Alignment',
			'description' => 'Choose Text Alignment.',
			'allowEmpty' => true,
			'required' => false,
			'multiOptions'=> array(
				'1'=>'Left',
				'2'=>'Center',
				'3'=>'Right',
			),
			'value'=>'2',
    ));
		
		$this->addElement('Text', 'footer_padding', array(
			'label' => 'Padding',
			'description' => 'Enter Padding in px.',
			'value' => '1',
    ));
		
		$this->addElement('Checkbox', 'activate_thistemplate', array(
			'label' => 'Yes, activate this email template for all outgoing emails.(Note: At any time only one template can be activated. Thus, if you activate this template, then the current activated template will be deactivated.',
			'description' => 'Activate This Template for All Emails.',
			'value' => '0',
			'allowEmpty' => true,
			'required' => false,
    ));
		$this->addElement('Checkbox', 'test_email_check', array(
			'label' => 'Send me a test email.',
			'description' => 'Test Email',
			'allowEmpty' => true,
			'required' => false,
			'onchange'=>'emilinput(this)',
    ));
		$this->addElement('Text', 'test_email', array(
			'label' => 'Email ID for Testing',
			'allowEmpty' => true,
			'required' => false,
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
				'decorators' => array('ViewHelper')
		));
		$this->addDisplayGroup(array('save', 'submit', 'cancel'), 'buttons');
    
  }

}
