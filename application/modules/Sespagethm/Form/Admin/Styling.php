<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagethm_Form_Admin_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
   $sespectroApi = Engine_Api::_()->sespagethm();
    $this->setTitle('Manage Color Schemes')
            ->setDescription('These settings affect in this theme only on your site.');

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sespagethm/externals/images/color-scheme/1.png" alt="" />',
            2 => '<img src="./application/modules/Sespagethm/externals/images/color-scheme/2.png" alt="" />',
            3 => '<img src="./application/modules/Sespagethm/externals/images/color-scheme/3.png" alt="" />',
            4 => '<img src="./application/modules/Sespagethm/externals/images/color-scheme/4.png" alt="" />',
						6 => '<img src="./application/modules/Sespagethm/externals/images/color-scheme/5.png" alt="" />',
						7 => '<img src="./application/modules/Sespagethm/externals/images/color-scheme/6.png" alt="" />',
						8 => '<img src="./application/modules/Sespagethm/externals/images/color-scheme/7.png" alt="" />',
						9 => '<img src="./application/modules/Sespagethm/externals/images/color-scheme/8.png" alt="" />',
						10 => '<img src="./application/modules/Sespagethm/externals/images/color-scheme/9.png" alt="" />',

						5 => '<img src="./application/modules/Sespagethm/externals/images/color-scheme/custom.png" alt="" />',
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
    	$sespagethm_header_background_color = $settings->getSetting('sespagethm.header.background.color');
	    $sespagethm_header_border_color = $settings->getSetting('sespagethm.header.border.color');
	    $sespagethm_mainmenu_background_color = $settings->getSetting('sespagethm.mainmenu.backgroundcolor');
			$sespagethm_mainmenu_background_color_hover = $settings->getSetting('sespagethm.mainmenu.background.color.hover');
			$sespagethm_mainmenu_link_color = $settings->getSetting('sespagethm.mainmenu.linkcolor');
			$sespagethm_mainmenu_link_color_hover = $settings->getSetting('sespagethm.mainmenu.link.color.hover');
			$sespagethm_mainmenu_border_color = $settings->getSetting('sespagethm.mainmenu.border.color');
			$sespagethm_minimenu_link_color = $settings->getSetting('sespagethm.minimenu.linkcolor');
			$sespagethm_minimenu_link_color_hover = $settings->getSetting('sespagethm.minimenu.link.color.hover');
			$sespagethm_minimenu_border_color = $settings->getSetting('sespagethm.minimenu.border.color');
			$sespagethm_header_searchbox_background_color = $settings->getSetting('sespagethm.header.searchbox.background.color');
			$sespagethm_header_searchbox_text_color = $settings->getSetting('sespagethm.header.searchbox.text.color');
			$sespagethm_header_searchbox_border_color = $settings->getSetting('sespagethm.header.searchbox.border.color');
			$sespagethm_minimenu_icon = $settings->getSetting('sespagethm.minimenu.icon');
			$sespagethm_footer_background_color = $settings->getSetting('sespagethm.footer.background.color');
			$sespagethm_footer_border_color = $settings->getSetting('sespagethm.footer.border.color');
			$sespagethm_footer_text_color = $settings->getSetting('sespagethm.footer.text.color');
			$sespagethm_footer_link_color = $settings->getSetting('sespagethm.footer.link.color');
			$sespagethm_footer_link_hover_color = $settings->getSetting('sespagethm.footer.link.hover.color');
			$sespagethm_theme_color = $settings->getSetting('sespagethm.theme.color');
			$sespagethm_theme_secondary_color = $settings->getSetting('sespagethm.theme.secondary.color');
			$sespagethm_body_background_color = $settings->getSetting('sespagethm.body.background.color');
			$sespagethm_font_color = $settings->getSetting('sespagethm.fontcolor');
			$sespagethm_font_color_light = $settings->getSetting('sespagethm.font.color.light');
			$sespagethm_heading_color = $settings->getSetting('sespagethm.heading.color');
			$sespagethm_link_color = $settings->getSetting('sespagethm.linkcolor');
			$sespagethm_link_color_hover = $settings->getSetting('sespagethm.link.color.hover');
			$sespagethm_content_background_color = $settings->getSetting('sespagethm.content.background.color');
			$sespagethm_content_heading_background_color = $settings->getSetting('sespagethm.content.heading.background.color');
			$sespagethm_content_border_color = $settings->getSetting('sespagethm.content.bordercolor');
			$sespagethm_content_border_color_dark = $settings->getSetting('sespagethm.content.border.color.dark');
			$sespagethm_input_background_color = $settings->getSetting('sespagethm.input.background.color');
			$sespagethm_input_font_color = $settings->getSetting('sespagethm.input.font.color');
			$sespagethm_input_border_color = $settings->getSetting('sespagethm.input.border.color');
			$sespagethm_button_background_color = $settings->getSetting('sespagethm.button.backgroundcolor');
			$sespagethm_button_background_color_hover = $settings->getSetting('sespagethm.button.background.color.hover');
			$sespagethm_button_background_color_active = $settings->getSetting('sespagethm.button.background.color.active');
			$sespagethm_button_font_color = $settings->getSetting('sespagethm.button.font.color');
    } else {
	    $sespagethm_header_background_color = $sespectroApi->getContantValueXML('sespagethm_header_background_color');
	    $sespagethm_header_border_color = $sespectroApi->getContantValueXML('sespagethm_header_border_color');
	    $sespagethm_mainmenu_background_color = $sespectroApi->getContantValueXML('sespagethm_mainmenu_background_color');
			$sespagethm_mainmenu_background_color_hover = $sespectroApi->getContantValueXML('sespagethm_mainmenu_background_color_hover');
			$sespagethm_mainmenu_link_color = $sespectroApi->getContantValueXML('sespagethm_mainmenu_link_color');
			$sespagethm_mainmenu_link_color_hover = $sespectroApi->getContantValueXML('sespagethm_mainmenu_link_color_hover');
			$sespagethm_mainmenu_border_color = $sespectroApi->getContantValueXML('sespagethm_mainmenu_border_color');
			$sespagethm_minimenu_link_color = $sespectroApi->getContantValueXML('sespagethm_minimenu_link_color');
			$sespagethm_minimenu_link_color_hover = $sespectroApi->getContantValueXML('sespagethm_minimenu_link_color_hover');
			$sespagethm_minimenu_border_color = $sespectroApi->getContantValueXML('sespagethm_minimenu_border_color');
			$sespagethm_header_searchbox_background_color = $sespectroApi->getContantValueXML('sespagethm_header_searchbox_background_color');
			$sespagethm_header_searchbox_text_color = $sespectroApi->getContantValueXML('sespagethm_header_searchbox_text_color');
			$sespagethm_header_searchbox_border_color = $sespectroApi->getContantValueXML('sespagethm_header_searchbox_border_color');
			$sespagethm_minimenu_icon = $sespectroApi->getContantValueXML('sespagethm_minimenu_icon');
			$sespagethm_footer_background_color = $sespectroApi->getContantValueXML('sespagethm_footer_background_color');
			$sespagethm_footer_border_color = $sespectroApi->getContantValueXML('sespagethm_footer_border_color');
			$sespagethm_footer_text_color = $sespectroApi->getContantValueXML('sespagethm_footer_text_color');
			$sespagethm_footer_link_color = $sespectroApi->getContantValueXML('sespagethm_footer_link_color');
			$sespagethm_footer_link_hover_color = $sespectroApi->getContantValueXML('sespagethm_footer_link_hover_color');
			$sespagethm_theme_color = $sespectroApi->getContantValueXML('sespagethm_theme_color');
			$sespagethm_theme_secondary_color = $sespectroApi->getContantValueXML('sespagethm_theme_secondary_color');
			$sespagethm_body_background_color = $sespectroApi->getContantValueXML('sespagethm_body_background_color');
			$sespagethm_font_color = $sespectroApi->getContantValueXML('sespagethm_font_color');
			$sespagethm_font_color_light = $sespectroApi->getContantValueXML('sespagethm_font_color_light');
			$sespagethm_heading_color = $sespectroApi->getContantValueXML('sespagethm_heading_color');
			$sespagethm_link_color = $sespectroApi->getContantValueXML('sespagethm_link_color');
			$sespagethm_link_color_hover = $sespectroApi->getContantValueXML('sespagethm_link_color_hover');
			$sespagethm_content_background_color = $sespectroApi->getContantValueXML('sespagethm_content_background_color');
			$sespagethm_content_heading_background_color = $sespectroApi->getContantValueXML('sespagethm_content_heading_background_color');
			$sespagethm_content_border_color = $sespectroApi->getContantValueXML('sespagethm_content_border_color');
			$sespagethm_content_border_color_dark = $sespectroApi->getContantValueXML('sespagethm_content_border_color_dark');
			$sespagethm_input_background_color = $sespectroApi->getContantValueXML('sespagethm_input_background_color');
			$sespagethm_input_font_color = $sespectroApi->getContantValueXML('sespagethm_input_font_color');
			$sespagethm_input_border_color = $sespectroApi->getContantValueXML('sespagethm_input_border_color');
			$sespagethm_button_background_color = $sespectroApi->getContantValueXML('sespagethm_button_background_color');
			$sespagethm_button_background_color_hover = $sespectroApi->getContantValueXML('sespagethm_button_background_color_hover');
			$sespagethm_button_background_color_active = $sespectroApi->getContantValueXML('sespagethm_button_background_color_active');
			$sespagethm_button_font_color = $sespectroApi->getContantValueXML('sespagethm_button_font_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "sespagethm_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_header_background_color,
    ));


    $this->addElement('Text', "sespagethm_header_border_color", array(
        'label' => 'Header Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_header_border_color,
    ));


    $this->addElement('Text', "sespagethm_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_mainmenu_background_color,
    ));

    $this->addElement('Text', "sespagethm_mainmenu_background_color_hover", array(
        'label' => 'Main Menu Background Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_mainmenu_background_color_hover,
    ));


    $this->addElement('Text', "sespagethm_mainmenu_link_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_mainmenu_link_color,
    ));

    $this->addElement('Text', "sespagethm_mainmenu_link_color_hover", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_mainmenu_link_color_hover,
    ));


    $this->addElement('Text', "sespagethm_mainmenu_border_color", array(
        'label' => 'Main Menu Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_mainmenu_border_color,
    ));


    $this->addElement('Text', "sespagethm_minimenu_link_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_minimenu_link_color,
    ));


    $this->addElement('Text', "sespagethm_minimenu_link_color_hover", array(
        'label' => 'Mini Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_minimenu_link_color_hover,
    ));

    $this->addElement('Text', "sespagethm_minimenu_border_color", array(
        'label' => 'Mini Menu Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_minimenu_border_color,
    ));

    $this->addElement('Text', "sespagethm_header_searchbox_background_color", array(
        'label' => 'Header Searchbox Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_header_searchbox_background_color,
    ));

    $this->addElement('Text', "sespagethm_header_searchbox_text_color", array(
        'label' => 'Header Searchbox Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_header_searchbox_text_color,
    ));

    $this->addElement('Text', "sespagethm_header_searchbox_border_color", array(
        'label' => 'Header Searchbox Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_header_searchbox_border_color,
    ));


    $this->addElement('Select', "sespagethm_minimenu_icon", array(
        'label' => 'Mini Menu Icon',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
            'minimenu-icons-gray.png' => 'Gray',
            'minimenu-icons-white.png' => 'White',
            'minimenu-icons-dark.png' => 'Dark',
        ),
        'value' => $sespagethm_minimenu_icon,
    ));
    $this->addDisplayGroup(array('sespagethm_header_background_color', 'sespagethm_header_border_color', 'sespagethm_mainmenu_background_color', 'sespagethm_mainmenu_background_color_hover', 'sespagethm_mainmenu_link_color', 'sespagethm_mainmenu_link_color_hover', 'sespagethm_mainmenu_border_color', 'sespagethm_minimenu_link_color', 'sespagethm_minimenu_link_color_hover', 'sespagethm_minimenu_border_color', 'sespagethm_header_searchbox_background_color', 'sespagethm_header_searchbox_text_color', 'sespagethm_header_searchbox_border_color', 'sespagethm_minimenu_icon'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling
    //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "sespagethm_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_footer_background_color,
    ));

    $this->addElement('Text', "sespagethm_footer_border_color", array(
        'label' => 'Footer Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_footer_border_color,
    ));

    $this->addElement('Text', "sespagethm_footer_text_color", array(
        'label' => 'Footer Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_footer_text_color,
    ));

    $this->addElement('Text', "sespagethm_footer_link_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_footer_link_color,
    ));

    $this->addElement('Text', "sespagethm_footer_link_hover_color", array(
        'label' => 'Footer Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_footer_link_hover_color,
    ));
    $this->addDisplayGroup(array('sespagethm_footer_background_color', 'sespagethm_footer_border_color', 'sespagethm_footer_text_color', 'sespagethm_footer_link_color', 'sespagethm_footer_link_hover_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    //End Footer Styling
    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "sespagethm_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_theme_color,
    ));

    $this->addElement('Text', "sespagethm_theme_secondary_color", array(
        'label' => 'Theme Secondary Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_theme_secondary_color,
    ));


    $this->addElement('Text', "sespagethm_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_body_background_color,
    ));

    $this->addElement('Text', "sespagethm_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_font_color,
    ));

    $this->addElement('Text', "sespagethm_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_font_color_light,
    ));

    $this->addElement('Text', "sespagethm_heading_color", array(
        'label' => 'Heading Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_heading_color,
    ));

    $this->addElement('Text', "sespagethm_link_color", array(
        'label' => 'Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_link_color,
    ));

    $this->addElement('Text', "sespagethm_link_color_hover", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_link_color_hover,
    ));

    $this->addElement('Text', "sespagethm_content_background_color", array(
        'label' => 'Content Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_content_background_color,
    ));

    $this->addElement('Text', "sespagethm_content_heading_background_color", array(
        'label' => 'Content Heading Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_content_heading_background_color,
    ));

    $this->addElement('Text', "sespagethm_content_border_color", array(
        'label' => 'Content Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_content_border_color,
    ));

    $this->addElement('Text', "sespagethm_content_border_color_dark", array(
        'label' => 'Content Border Color Dark',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_content_border_color_dark,
    ));

    $this->addElement('Text', "sespagethm_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_input_background_color,
    ));

    $this->addElement('Text', "sespagethm_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_input_font_color,
    ));

    $this->addElement('Text', "sespagethm_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_input_border_color,
    ));

    $this->addElement('Text', "sespagethm_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_button_background_color,
    ));


    $this->addElement('Text', "sespagethm_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_button_background_color_hover,
    ));


    $this->addElement('Text', "sespagethm_button_background_color_active", array(
        'label' => 'Button Background Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_button_background_color_active,
    ));

    $this->addElement('Text', "sespagethm_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sespagethm_button_font_color,
    ));


    $this->addDisplayGroup(array('sespagethm_theme_color','sespagethm_theme_secondary_color','sespagethm_body_background_color', 'sespagethm_font_color', 'sespagethm_font_color_light', 'sespagethm_heading_color', 'sespagethm_link_color', 'sespagethm_link_color_hover', 'sespagethm_content_background_color', 'sespagethm_content_heading_background_color', 'sespagethm_content_border_color', 'sespagethm_content_border_color_dark', 'sespagethm_input_background_color', 'sespagethm_input_font_color', 'sespagethm_input_border_color', 'sespagethm_button_background_color', 'sespagethm_button_background_color_hover', 'sespagethm_button_background_color_active', 'sespagethm_button_font_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
    $body_settings_group = $this->getDisplayGroup('body_settings_group');
    $body_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'body_settings_group'))));
    //End Body Styling
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
