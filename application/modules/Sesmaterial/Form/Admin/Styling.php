<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmaterial_Form_Admin_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
   $sespectroApi = Engine_Api::_()->sesmaterial();
    $this->setTitle('Manage Color Schemes')
            ->setDescription('These settings affect in this theme only on your site.');

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sesmaterial/externals/images/color-scheme/1.png" alt="" />',
            2 => '<img src="./application/modules/Sesmaterial/externals/images/color-scheme/2.png" alt="" />',
            3 => '<img src="./application/modules/Sesmaterial/externals/images/color-scheme/3.png" alt="" />',
            4 => '<img src="./application/modules/Sesmaterial/externals/images/color-scheme/4.png" alt="" />',
						6 => '<img src="./application/modules/Sesmaterial/externals/images/color-scheme/5.png" alt="" />',
						7 => '<img src="./application/modules/Sesmaterial/externals/images/color-scheme/6.png" alt="" />',
						8 => '<img src="./application/modules/Sesmaterial/externals/images/color-scheme/7.png" alt="" />',
						9 => '<img src="./application/modules/Sesmaterial/externals/images/color-scheme/8.png" alt="" />',
						10 => '<img src="./application/modules/Sesmaterial/externals/images/color-scheme/9.png" alt="" />',

						5 => '<img src="./application/modules/Sesmaterial/externals/images/color-scheme/custom.png" alt="" />',
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
    	$sesmaterial_header_background_color = $settings->getSetting('sesmaterial.header.background.color');
	    $sesmaterial_header_border_color = $settings->getSetting('sesmaterial.header.border.color');
	    $sesmaterial_mainmenu_background_color = $settings->getSetting('sesmaterial.mainmenu.backgroundcolor');
			$sesmaterial_mainmenu_background_color_hover = $settings->getSetting('sesmaterial.mainmenu.background.color.hover');
			$sesmaterial_mainmenu_link_color = $settings->getSetting('sesmaterial.mainmenu.linkcolor');
			$sesmaterial_mainmenu_link_color_hover = $settings->getSetting('sesmaterial.mainmenu.link.color.hover');
			$sesmaterial_mainmenu_border_color = $settings->getSetting('sesmaterial.mainmenu.border.color');
			$sesmaterial_minimenu_link_color = $settings->getSetting('sesmaterial.minimenu.linkcolor');
			$sesmaterial_minimenu_link_color_hover = $settings->getSetting('sesmaterial.minimenu.link.color.hover');
			$sesmaterial_minimenu_border_color = $settings->getSetting('sesmaterial.minimenu.border.color');
			$sesmaterial_header_searchbox_background_color = $settings->getSetting('sesmaterial.header.searchbox.background.color');
			$sesmaterial_header_searchbox_text_color = $settings->getSetting('sesmaterial.header.searchbox.text.color');
			$sesmaterial_header_searchbox_border_color = $settings->getSetting('sesmaterial.header.searchbox.border.color');
			$sesmaterial_minimenu_icon = $settings->getSetting('sesmaterial.minimenu.icon');
			$sesmaterial_footer_background_color = $settings->getSetting('sesmaterial.footer.background.color');
			$sesmaterial_footer_border_color = $settings->getSetting('sesmaterial.footer.border.color');
			$sesmaterial_footer_text_color = $settings->getSetting('sesmaterial.footer.text.color');
			$sesmaterial_footer_link_color = $settings->getSetting('sesmaterial.footer.link.color');
			$sesmaterial_footer_link_hover_color = $settings->getSetting('sesmaterial.footer.link.hover.color');
			$sesmaterial_theme_color = $settings->getSetting('sesmaterial.theme.color');
			$sesmaterial_theme_secondary_color = $settings->getSetting('sesmaterial.theme.secondary.color');
			$sesmaterial_body_background_color = $settings->getSetting('sesmaterial.body.background.color');
			$sesmaterial_font_color = $settings->getSetting('sesmaterial.fontcolor');
			$sesmaterial_font_color_light = $settings->getSetting('sesmaterial.font.color.light');
			$sesmaterial_heading_color = $settings->getSetting('sesmaterial.heading.color');
			$sesmaterial_link_color = $settings->getSetting('sesmaterial.linkcolor');
			$sesmaterial_link_color_hover = $settings->getSetting('sesmaterial.link.color.hover');
			$sesmaterial_content_background_color = $settings->getSetting('sesmaterial.content.background.color');
			$sesmaterial_content_heading_background_color = $settings->getSetting('sesmaterial.content.heading.background.color');
			$sesmaterial_content_border_color = $settings->getSetting('sesmaterial.content.bordercolor');
			$sesmaterial_content_border_color_dark = $settings->getSetting('sesmaterial.content.border.color.dark');
			$sesmaterial_input_background_color = $settings->getSetting('sesmaterial.input.background.color');
			$sesmaterial_input_font_color = $settings->getSetting('sesmaterial.input.font.color');
			$sesmaterial_input_border_color = $settings->getSetting('sesmaterial.input.border.color');
			$sesmaterial_button_background_color = $settings->getSetting('sesmaterial.button.backgroundcolor');
			$sesmaterial_button_background_color_hover = $settings->getSetting('sesmaterial.button.background.color.hover');
			$sesmaterial_button_background_color_active = $settings->getSetting('sesmaterial.button.background.color.active');
			$sesmaterial_button_font_color = $settings->getSetting('sesmaterial.button.font.color');
    } else {
	    $sesmaterial_header_background_color = $sespectroApi->getContantValueXML('sesmaterial_header_background_color');
	    $sesmaterial_header_border_color = $sespectroApi->getContantValueXML('sesmaterial_header_border_color');
	    $sesmaterial_mainmenu_background_color = $sespectroApi->getContantValueXML('sesmaterial_mainmenu_background_color');
			$sesmaterial_mainmenu_background_color_hover = $sespectroApi->getContantValueXML('sesmaterial_mainmenu_background_color_hover');
			$sesmaterial_mainmenu_link_color = $sespectroApi->getContantValueXML('sesmaterial_mainmenu_link_color');
			$sesmaterial_mainmenu_link_color_hover = $sespectroApi->getContantValueXML('sesmaterial_mainmenu_link_color_hover');
			$sesmaterial_mainmenu_border_color = $sespectroApi->getContantValueXML('sesmaterial_mainmenu_border_color');
			$sesmaterial_minimenu_link_color = $sespectroApi->getContantValueXML('sesmaterial_minimenu_link_color');
			$sesmaterial_minimenu_link_color_hover = $sespectroApi->getContantValueXML('sesmaterial_minimenu_link_color_hover');
			$sesmaterial_minimenu_border_color = $sespectroApi->getContantValueXML('sesmaterial_minimenu_border_color');
			$sesmaterial_header_searchbox_background_color = $sespectroApi->getContantValueXML('sesmaterial_header_searchbox_background_color');
			$sesmaterial_header_searchbox_text_color = $sespectroApi->getContantValueXML('sesmaterial_header_searchbox_text_color');
			$sesmaterial_header_searchbox_border_color = $sespectroApi->getContantValueXML('sesmaterial_header_searchbox_border_color');
			$sesmaterial_minimenu_icon = $sespectroApi->getContantValueXML('sesmaterial_minimenu_icon');
			$sesmaterial_footer_background_color = $sespectroApi->getContantValueXML('sesmaterial_footer_background_color');
			$sesmaterial_footer_border_color = $sespectroApi->getContantValueXML('sesmaterial_footer_border_color');
			$sesmaterial_footer_text_color = $sespectroApi->getContantValueXML('sesmaterial_footer_text_color');
			$sesmaterial_footer_link_color = $sespectroApi->getContantValueXML('sesmaterial_footer_link_color');
			$sesmaterial_footer_link_hover_color = $sespectroApi->getContantValueXML('sesmaterial_footer_link_hover_color');
			$sesmaterial_theme_color = $sespectroApi->getContantValueXML('sesmaterial_theme_color');
			$sesmaterial_theme_secondary_color = $sespectroApi->getContantValueXML('sesmaterial_theme_secondary_color');
			$sesmaterial_body_background_color = $sespectroApi->getContantValueXML('sesmaterial_body_background_color');
			$sesmaterial_font_color = $sespectroApi->getContantValueXML('sesmaterial_font_color');
			$sesmaterial_font_color_light = $sespectroApi->getContantValueXML('sesmaterial_font_color_light');
			$sesmaterial_heading_color = $sespectroApi->getContantValueXML('sesmaterial_heading_color');
			$sesmaterial_link_color = $sespectroApi->getContantValueXML('sesmaterial_link_color');
			$sesmaterial_link_color_hover = $sespectroApi->getContantValueXML('sesmaterial_link_color_hover');
			$sesmaterial_content_background_color = $sespectroApi->getContantValueXML('sesmaterial_content_background_color');
			$sesmaterial_content_heading_background_color = $sespectroApi->getContantValueXML('sesmaterial_content_heading_background_color');
			$sesmaterial_content_border_color = $sespectroApi->getContantValueXML('sesmaterial_content_border_color');
			$sesmaterial_content_border_color_dark = $sespectroApi->getContantValueXML('sesmaterial_content_border_color_dark');
			$sesmaterial_input_background_color = $sespectroApi->getContantValueXML('sesmaterial_input_background_color');
			$sesmaterial_input_font_color = $sespectroApi->getContantValueXML('sesmaterial_input_font_color');
			$sesmaterial_input_border_color = $sespectroApi->getContantValueXML('sesmaterial_input_border_color');
			$sesmaterial_button_background_color = $sespectroApi->getContantValueXML('sesmaterial_button_background_color');
			$sesmaterial_button_background_color_hover = $sespectroApi->getContantValueXML('sesmaterial_button_background_color_hover');
			$sesmaterial_button_background_color_active = $sespectroApi->getContantValueXML('sesmaterial_button_background_color_active');
			$sesmaterial_button_font_color = $sespectroApi->getContantValueXML('sesmaterial_button_font_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "sesmaterial_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_header_background_color,
    ));


    $this->addElement('Text', "sesmaterial_header_border_color", array(
        'label' => 'Header Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_header_border_color,
    ));


    $this->addElement('Text', "sesmaterial_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_mainmenu_background_color,
    ));

    $this->addElement('Text', "sesmaterial_mainmenu_background_color_hover", array(
        'label' => 'Main Menu Background Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_mainmenu_background_color_hover,
    ));


    $this->addElement('Text', "sesmaterial_mainmenu_link_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_mainmenu_link_color,
    ));

    $this->addElement('Text', "sesmaterial_mainmenu_link_color_hover", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_mainmenu_link_color_hover,
    ));


    $this->addElement('Text', "sesmaterial_mainmenu_border_color", array(
        'label' => 'Main Menu Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_mainmenu_border_color,
    ));


    $this->addElement('Text', "sesmaterial_minimenu_link_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_minimenu_link_color,
    ));


    $this->addElement('Text', "sesmaterial_minimenu_link_color_hover", array(
        'label' => 'Mini Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_minimenu_link_color_hover,
    ));

    $this->addElement('Text', "sesmaterial_minimenu_border_color", array(
        'label' => 'Mini Menu Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_minimenu_border_color,
    ));

    $this->addElement('Text', "sesmaterial_header_searchbox_background_color", array(
        'label' => 'Header Searchbox Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_header_searchbox_background_color,
    ));

    $this->addElement('Text', "sesmaterial_header_searchbox_text_color", array(
        'label' => 'Header Searchbox Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_header_searchbox_text_color,
    ));

    $this->addElement('Text', "sesmaterial_header_searchbox_border_color", array(
        'label' => 'Header Searchbox Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_header_searchbox_border_color,
    ));


    $this->addElement('Select', "sesmaterial_minimenu_icon", array(
        'label' => 'Mini Menu Icon',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
            'minimenu-icons-gray.png' => 'Gray',
            'minimenu-icons-white.png' => 'White',
            'minimenu-icons-dark.png' => 'Dark',
        ),
        'value' => $sesmaterial_minimenu_icon,
    ));
    $this->addDisplayGroup(array('sesmaterial_header_background_color', 'sesmaterial_header_border_color', 'sesmaterial_mainmenu_background_color', 'sesmaterial_mainmenu_background_color_hover', 'sesmaterial_mainmenu_link_color', 'sesmaterial_mainmenu_link_color_hover', 'sesmaterial_mainmenu_border_color', 'sesmaterial_minimenu_link_color', 'sesmaterial_minimenu_link_color_hover', 'sesmaterial_minimenu_border_color', 'sesmaterial_header_searchbox_background_color', 'sesmaterial_header_searchbox_text_color', 'sesmaterial_header_searchbox_border_color', 'sesmaterial_minimenu_icon'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling
    //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "sesmaterial_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_footer_background_color,
    ));

    $this->addElement('Text', "sesmaterial_footer_border_color", array(
        'label' => 'Footer Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_footer_border_color,
    ));

    $this->addElement('Text', "sesmaterial_footer_text_color", array(
        'label' => 'Footer Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_footer_text_color,
    ));

    $this->addElement('Text', "sesmaterial_footer_link_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_footer_link_color,
    ));

    $this->addElement('Text', "sesmaterial_footer_link_hover_color", array(
        'label' => 'Footer Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_footer_link_hover_color,
    ));
    $this->addDisplayGroup(array('sesmaterial_footer_background_color', 'sesmaterial_footer_border_color', 'sesmaterial_footer_text_color', 'sesmaterial_footer_link_color', 'sesmaterial_footer_link_hover_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    //End Footer Styling
    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "sesmaterial_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_theme_color,
    ));

    $this->addElement('Text', "sesmaterial_theme_secondary_color", array(
        'label' => 'Theme Secondary Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_theme_secondary_color,
    ));


    $this->addElement('Text', "sesmaterial_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_body_background_color,
    ));

    $this->addElement('Text', "sesmaterial_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_font_color,
    ));

    $this->addElement('Text', "sesmaterial_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_font_color_light,
    ));

    $this->addElement('Text', "sesmaterial_heading_color", array(
        'label' => 'Heading Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_heading_color,
    ));

    $this->addElement('Text', "sesmaterial_link_color", array(
        'label' => 'Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_link_color,
    ));

    $this->addElement('Text', "sesmaterial_link_color_hover", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_link_color_hover,
    ));

    $this->addElement('Text', "sesmaterial_content_background_color", array(
        'label' => 'Content Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_content_background_color,
    ));

    $this->addElement('Text', "sesmaterial_content_heading_background_color", array(
        'label' => 'Content Heading Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_content_heading_background_color,
    ));

    $this->addElement('Text', "sesmaterial_content_border_color", array(
        'label' => 'Content Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_content_border_color,
    ));

    $this->addElement('Text', "sesmaterial_content_border_color_dark", array(
        'label' => 'Content Border Color Dark',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_content_border_color_dark,
    ));

    $this->addElement('Text', "sesmaterial_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_input_background_color,
    ));

    $this->addElement('Text', "sesmaterial_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_input_font_color,
    ));

    $this->addElement('Text', "sesmaterial_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_input_border_color,
    ));

    $this->addElement('Text', "sesmaterial_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_button_background_color,
    ));


    $this->addElement('Text', "sesmaterial_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_button_background_color_hover,
    ));


    $this->addElement('Text', "sesmaterial_button_background_color_active", array(
        'label' => 'Button Background Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_button_background_color_active,
    ));

    $this->addElement('Text', "sesmaterial_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesmaterial_button_font_color,
    ));


    $this->addDisplayGroup(array('sesmaterial_theme_color','sesmaterial_theme_secondary_color','sesmaterial_body_background_color', 'sesmaterial_font_color', 'sesmaterial_font_color_light', 'sesmaterial_heading_color', 'sesmaterial_link_color', 'sesmaterial_link_color_hover', 'sesmaterial_content_background_color', 'sesmaterial_content_heading_background_color', 'sesmaterial_content_border_color', 'sesmaterial_content_border_color_dark', 'sesmaterial_input_background_color', 'sesmaterial_input_font_color', 'sesmaterial_input_border_color', 'sesmaterial_button_background_color', 'sesmaterial_button_background_color_hover', 'sesmaterial_button_background_color_active', 'sesmaterial_button_font_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
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
