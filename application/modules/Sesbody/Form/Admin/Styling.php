<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbody_Form_Admin_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
   $sespectroApi = Engine_Api::_()->sesbody();
    $this->setTitle('Manage Color Schemes')
            ->setDescription('These settings affect in this theme only on your site.');

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sesbody/externals/images/color-scheme/1.png" alt="" />',
            2 => '<img src="./application/modules/Sesbody/externals/images/color-scheme/2.png" alt="" />',
            3 => '<img src="./application/modules/Sesbody/externals/images/color-scheme/3.png" alt="" />',
            4 => '<img src="./application/modules/Sesbody/externals/images/color-scheme/4.png" alt="" />',
						6 => '<img src="./application/modules/Sesbody/externals/images/color-scheme/5.png" alt="" />',
						7 => '<img src="./application/modules/Sesbody/externals/images/color-scheme/6.png" alt="" />',
						8 => '<img src="./application/modules/Sesbody/externals/images/color-scheme/7.png" alt="" />',
						9 => '<img src="./application/modules/Sesbody/externals/images/color-scheme/8.png" alt="" />',
						10 => '<img src="./application/modules/Sesbody/externals/images/color-scheme/9.png" alt="" />',
            
						5 => '<img src="./application/modules/Sesbody/externals/images/color-scheme/custom.png" alt="" />',
        ),
        'onclick' => 'changeThemeColor(this.value, "")',
        'escape' => false,
        'value' => $sespectroApi->getContantValueXML('theme_color'),
    ));

    $this->addElement('Select', 'custom_theme_color', array(
        'label' => 'Custom Theme Color',
        'multiOptions' => array(
            5 => 'New Custom',
            1 => 'Theme - 1',
            2 => 'Theme - 2',
            3 => 'Theme - 3',
            4 => 'Theme - 4',
						6 => 'Theme - 5',
						7 => 'Theme - 6',
						8 => 'Theme - 7',
						9 => 'Theme - 8',
						10 => 'Theme - 9'
						
        ),
        'onclick' => 'changeCustomThemeColor(this.value)',
        'escape' => false,
        'value' => $sespectroApi->getContantValueXML('custom_theme_color'),
    ));
    $theme_color = $sespectroApi->getContantValueXML('theme_color');
    if($theme_color == '5') {
			$sesbody_header_background_color = $settings->getSetting('sesbody.header.background.color');
			$sesbody_mainmenu_background_color = $settings->getSetting('sesbody.mainmenu.background.color');
			$sesbody_mainmenu_background_color_hover = $settings->getSetting('sesbody.mainmenu.background.color.hover');
			$sesbody_mainmenu_link_color = $settings->getSetting('sesbody.mainmenu.link.color');
			$sesbody_mainmenu_link_color_hover = $settings->getSetting('sesbody.mainmenu.link.color.hover');
			$sesbody_mainmenu_border_color = $settings->getSetting('sesbody.mainmenu.border.color');
			$sesbody_minimenu_link_color = $settings->getSetting('sesbody.minimenu.link.color');
			$sesbody_minimenu_link_hover_color = $settings->getSetting('sesbody.minimenu.link.color.hover');
			$sesbody_header_searchbox_background_color = $settings->getSetting('sesbody.header.searchbox.background.color');
			$sesbody_header_searchbox_text_color = $settings->getSetting('sesbody.header.searchbox.text.color');
			$sesbody_header_searchbox_border_color = $settings->getSetting('sesbody.header.searchbox.border.color');
			$sesbody_theme_color = $settings->getSetting('sesbody.theme.color');
			$sesbody_theme_secondary_color = $settings->getSetting('sesbody.theme.secondary.color');
			$sesbody_body_background_color = $settings->getSetting('sesbody.body.background.color');
			$sesbody_font_color = $settings->getSetting('sesbody.fontcolor');
			$sesbody_font_color_light = $settings->getSetting('sesbody.font.color.light');
			$sesbody_heading_color = $settings->getSetting('sesbody.heading.color');
			$sesbody_link_color = $settings->getSetting('sesbody.linkcolor');
			$sesbody_link_color_hover = $settings->getSetting('sesbody.link.color.hover');
			$sesbody_content_background_color = $settings->getSetting('sesbody.content.background.color');
			$sesbody_content_heading_background_color = $settings->getSetting('sesbody.content.heading.background.color');
			$sesbody_content_border_color = $settings->getSetting('sesbody.content.bordercolor');
			$sesbody_content_border_color_dark = $settings->getSetting('sesbody.content.border.color.dark');
			$sesbody_input_background_color = $settings->getSetting('sesbody.input.background.color');
			$sesbody_input_font_color = $settings->getSetting('sesbody.input.font.color');
			$sesbody_input_border_color = $settings->getSetting('sesbody.input.border.color');
			$sesbody_button_background_color = $settings->getSetting('sesbody.button.backgroundcolor');
			$sesbody_button_background_color_hover = $settings->getSetting('sesbody.button.background.color.hover');
			$sesbody_button_background_color_active = $settings->getSetting('sesbody.button.background.color.active');
			$sesbody_button_font_color = $settings->getSetting('sesbody.button.font.color');
			$sesbody_button_font_hover_color = $settings->getSetting('sesbody.button.font.hover.color');
			$sesbody_button_background_gradient_top_color = $settings->getSetting('sesbody.button.background.gradient.top.color');
			$sesbody_button_background_gradient_top_hover_color = $settings->getSetting('sesbody.button.background.gradient.top.hover.color');
			$sesbody_footer_background_color = $settings->getSetting('sesbody.footer.background.color');
			$sesbody_footer_border_color = $settings->getSetting('sesbody.footer.border.color');
			$sesbody_footer_link_color = $settings->getSetting('sesbody.footer.link.color');
			$sesbody_footer_link_hover_color = $settings->getSetting('sesbody.footer.link.hover.color');
    } else {
			$sesbody_header_background_color = $sespectroApi->getContantValueXML('sesbody.header.background.color');
			$sesbody_mainmenu_background_color = $sespectroApi->getContantValueXML('sesbody.mainmenu.background.color');
			$sesbody_mainmenu_background_color_hover = $sespectroApi->getContantValueXML('sesbody.mainmenu.background.color.hover');
			$sesbody_mainmenu_link_color = $sespectroApi->getContantValueXML('sesbody.mainmenu.link.color');
			$sesbody_mainmenu_link_color_hover = $sespectroApi->getContantValueXML('sesbody.mainmenu.link.color.hover');
			$sesbody_mainmenu_border_color = $sespectroApi->getContantValueXML('sesbody.mainmenu.border.color');
			$sesbody_minimenu_link_color = $sespectroApi->getContantValueXML('sesbody.minimenu.link.color');
			$sesbody_minimenu_link_hover_color = $sespectroApi->getContantValueXML('sesbody.minimenu.link.color.hover');
			$sesbody_header_searchbox_background_color = $sespectroApi->getContantValueXML('sesbody.header.searchbox.background.color');
			$sesbody_header_searchbox_text_color = $sespectroApi->getContantValueXML('sesbody.header.searchbox.text.color');
			$sesbody_header_searchbox_border_color = $sespectroApi->getContantValueXML('sesbody.header.searchbox.border.color');
			$sesbody_theme_color = $sespectroApi->getContantValueXML('sesbody_theme_color');
			$sesbody_theme_secondary_color = $sespectroApi->getContantValueXML('sesbody_theme_secondary_color');
			$sesbody_body_background_color = $sespectroApi->getContantValueXML('sesbody_body_background_color');
			$sesbody_font_color = $sespectroApi->getContantValueXML('sesbody_font_color');
			$sesbody_font_color_light = $sespectroApi->getContantValueXML('sesbody_font_color_light');
			$sesbody_heading_color = $sespectroApi->getContantValueXML('sesbody_heading_color');
			$sesbody_link_color = $sespectroApi->getContantValueXML('sesbody_link_color');
			$sesbody_link_color_hover = $sespectroApi->getContantValueXML('sesbody_link_color_hover');
			$sesbody_content_background_color = $sespectroApi->getContantValueXML('sesbody_content_background_color');
			$sesbody_content_heading_background_color = $sespectroApi->getContantValueXML('sesbody_content_heading_background_color');
			$sesbody_content_border_color = $sespectroApi->getContantValueXML('sesbody_content_border_color');
			$sesbody_content_border_color_dark = $sespectroApi->getContantValueXML('sesbody_content_border_color_dark');
			$sesbody_input_background_color = $sespectroApi->getContantValueXML('sesbody_input_background_color');
			$sesbody_input_font_color = $sespectroApi->getContantValueXML('sesbody_input_font_color');
			$sesbody_input_border_color = $sespectroApi->getContantValueXML('sesbody_input_border_color');
			$sesbody_button_background_color = $sespectroApi->getContantValueXML('sesbody_button_background_color');
			$sesbody_button_background_color_hover = $sespectroApi->getContantValueXML('sesbody_button_background_color_hover');
			$sesbody_button_background_color_active = $sespectroApi->getContantValueXML('sesbody_button_background_color_active');
			$sesbody_button_font_color = $sespectroApi->getContantValueXML('sesbody_button_font_color');
			$sesbody_button_font_hover_color = $sespectroApi->getContantValueXML('sesbody_button_font_hover_color');
			$sesbody_button_background_gradient_top_color = $sespectroApi->getContantValueXML('sesbody_button_background_gradient_top_color');
			$sesbody_button_background_gradient_top_hover_color = $sespectroApi->getContantValueXML('sesbody_button_background_gradient_top_hover_color');
    }
		$sesbody_footer_background_color = $sespectroApi->getContantValueXML('sesbody.footer.background.color');
			$sesbody_footer_border_color = $sespectroApi->getContantValueXML('sesbody.footer.border.color');
			$sesbody_footer_link_color = $sespectroApi->getContantValueXML('sesbody.footer.link.color');
			$sesbody_footer_link_hover_color = $sespectroApi->getContantValueXML('sesbody.footer.link.hover.color');
    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "sesbody_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_header_background_color,
    ));
    $this->addElement('Text', "sesbody_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_mainmenu_background_color,
    ));

    $this->addElement('Text', "sesbody_mainmenu_link_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_mainmenu_link_color,
    ));
 $this->addElement('Text', "sesbody_mainmenu_background_color_hover", array(
        'label' => 'Main Menu Background Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_mainmenu_link_background_color_hover,
    ));
    $this->addElement('Text', "sesbody_mainmenu_link_color_hover", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_mainmenu_link_color_hover,
    ));
    $this->addElement('Text', "sesbody_mainmenu_border_color", array(
        'label' => 'Main Menu Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_mainmenu_border_color,
    ));
    $this->addElement('Text', "sesbody_minimenu_link_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_minimenu_link_color,
    ));

    $this->addElement('Text', "sesbody_minimenu_link_color_hover", array(
        'label' => 'Mini Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_minimenu_link_color_hover,
    ));

    $this->addElement('Text', "sesbody_header_searchbox_background_color", array(
        'label' => 'Header Searchbox Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_header_searchbox_background_color,
    ));

    $this->addElement('Text', "sesbody_header_searchbox_text_color", array(
        'label' => 'Header Searchbox Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_header_searchbox_text_color,
    ));
		$this->addElement('Text', "sesbody_header_searchbox_border_color", array(
        'label' => 'Header Searchbox Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_header_searchbox_border_color,
    ));

    $this->addDisplayGroup(array('sesbody_header_background_color','sesbody_mainmenu_background_color','sesbody_mainmenu_link_color','sesbody_mainmenu_background_color_hover','sesbody_mainmenu_link_color_hover','sesbody_mainmenu_border_color','sesbody_minimenu_link_color','sesbody_minimenu_link_color_hover','sesbody_header_searchbox_background_color','sesbody_header_searchbox_text_color','sesbody_header_searchbox_border_color'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
		
    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "sesbody_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_theme_color,
    ));

    $this->addElement('Text', "sesbody_theme_secondary_color", array(
        'label' => 'Theme Secondary Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_theme_secondary_color,
    ));
    
    
    $this->addElement('Text', "sesbody_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_body_background_color,
    ));

    $this->addElement('Text', "sesbody_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_font_color,
    ));

    $this->addElement('Text', "sesbody_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_font_color_light,
    ));

    $this->addElement('Text', "sesbody_heading_color", array(
        'label' => 'Heading Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_heading_color,
    ));

    $this->addElement('Text', "sesbody_link_color", array(
        'label' => 'Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_link_color,
    ));

    $this->addElement('Text', "sesbody_link_color_hover", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_link_color_hover,
    ));

    $this->addElement('Text', "sesbody_content_background_color", array(
        'label' => 'Content Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_content_background_color,
    ));

    $this->addElement('Text', "sesbody_content_heading_background_color", array(
        'label' => 'Content Heading Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_content_heading_background_color,
    ));

    $this->addElement('Text', "sesbody_content_border_color", array(
        'label' => 'Content Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_content_border_color,
    ));

    $this->addElement('Text', "sesbody_content_border_color_dark", array(
        'label' => 'Content Border Color Dark',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_content_border_color_dark,
    ));

    $this->addElement('Text', "sesbody_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_input_background_color,
    ));

    $this->addElement('Text', "sesbody_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_input_font_color,
    ));

    $this->addElement('Text', "sesbody_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_input_border_color,
    ));

    $this->addDisplayGroup(array('sesbody_theme_color','sesbody_theme_secondary_color','sesbody_body_background_color', 'sesbody_font_color', 'sesbody_font_color_light', 'sesbody_heading_color', 'sesbody_link_color', 'sesbody_link_color_hover', 'sesbody_content_background_color', 'sesbody_content_heading_background_color', 'sesbody_content_border_color', 'sesbody_content_border_color_dark', 'sesbody_input_background_color', 'sesbody_input_font_color', 'sesbody_input_border_color', 'sesbody_button_background_color', 'sesbody_button_background_color_hover', 'sesbody_button_background_color_active', 'sesbody_button_font_color','sesbody_button_font_hover_color','sesbody_button_background_gradient_top_color','sesbody_button_background_gradient_bottom_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
    $body_settings_group = $this->getDisplayGroup('body_settings_group');
    $body_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'body_settings_group'))));
    //End Body Styling
		//Start button Styling
    $this->addElement('Dummy', 'button_settings', array(
        'label' => 'Button Styling Settings',
    ));
		$this->addElement('Text', "sesbody_button_background_color", array(
        'label' => 'Button Background Color & Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_button_background_color,
    ));


    $this->addElement('Text', "sesbody_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_button_background_color_hover,
    ));


    $this->addElement('Text', "sesbody_button_background_color_active", array(
        'label' => 'Button Background Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_button_background_color_active,
    ));

    $this->addElement('Text', "sesbody_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_button_font_color,
    ));
		$this->addElement('Text', "sesbody_button_font_hover_color", array(
        'label' => 'Button Font Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_button_font_hover_color,
    ));
		$this->addElement('Text', "sesbody_button_background_gradient_top_color", array(
        'label' => 'Button Background Gradient Top Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_button_background_gradient_top_color,
    ));
		$this->addElement('Text', "sesbody_button_background_gradient_top_hover_color", array(
        'label' => 'Button Background Gradient top Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_button_background_gradient_top_hover_color,
    ));
		$this->addDisplayGroup(array('sesbody_button_background_color', 'sesbody_button_background_color_hover', 'sesbody_button_background_color_active', 'sesbody_button_font_color','sesbody_button_font_hover_color','sesbody_button_background_gradient_top_color','sesbody_button_background_gradient_top_hover_color'), 'button_settings_group', array('disableLoadDefaultDecorators' => true));
    $button_settings_group = $this->getDisplayGroup('button_settings_group');
    $button_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'button_settings_group'))));
		
   //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "sesbody_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_footer_background_color,
    ));

		$this->addElement('Text', "sesbody_footer_border_color", array(
		 'label' => 'Footer Border Color',
		 'allowEmpty' => false,
		 'required' => true,
		 'class' => 'SEScolor',
		 'value' => $sesbody_footer_border_color,
		));

    $this->addElement('Text', "sesbody_footer_link_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_footer_link_color,
    ));

    $this->addElement('Text', "sesbody_footer_link_hover_color", array(
        'label' => 'Footer Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesbody_footer_link_hover_color,
    ));
		$this->addDisplayGroup(array('sesbody_footer_background_color','sesbody_footer_border_color','sesbody_footer_link_color','sesbody_footer_link_hover_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
		$footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}