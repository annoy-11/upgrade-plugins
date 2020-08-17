<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesspectromedia_Form_Admin_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
   $sespectroApi = Engine_Api::_()->sesspectromedia();
    $this->setTitle('Manage Color Schemes')
            ->setDescription('These settings affect in this theme only on your site.');

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sesspectromedia/externals/images/color-scheme/1.png" alt="" />',
            2 => '<img src="./application/modules/Sesspectromedia/externals/images/color-scheme/2.png" alt="" />',
            3 => '<img src="./application/modules/Sesspectromedia/externals/images/color-scheme/3.png" alt="" />',
            4 => '<img src="./application/modules/Sesspectromedia/externals/images/color-scheme/4.png" alt="" />',
						6 => '<img src="./application/modules/Sesspectromedia/externals/images/color-scheme/5.png" alt="" />',
						7 => '<img src="./application/modules/Sesspectromedia/externals/images/color-scheme/6.png" alt="" />',
						8 => '<img src="./application/modules/Sesspectromedia/externals/images/color-scheme/7.png" alt="" />',
						9 => '<img src="./application/modules/Sesspectromedia/externals/images/color-scheme/8.png" alt="" />',
						10 => '<img src="./application/modules/Sesspectromedia/externals/images/color-scheme/9.png" alt="" />',
            
						5 => '<img src="./application/modules/Sesspectromedia/externals/images/color-scheme/custom.png" alt="" />',
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
    	$sm_header_background_color = $settings->getSetting('sm.header.background.color');
	    $sm_header_border_color = $settings->getSetting('sm.header.border.color');
	    $sm_mainmenu_background_color = $settings->getSetting('sm.mainmenu.backgroundcolor');
			$sm_mainmenu_background_color_hover = $settings->getSetting('sm.mainmenu.background.color.hover');
			$sm_mainmenu_link_color = $settings->getSetting('sm.mainmenu.linkcolor');
			$sm_mainmenu_link_color_hover = $settings->getSetting('sm.mainmenu.link.color.hover');
			$sm_mainmenu_border_color = $settings->getSetting('sm.mainmenu.border.color');
			$sm_minimenu_link_color = $settings->getSetting('sm.minimenu.linkcolor');
			$sm_minimenu_link_color_hover = $settings->getSetting('sm.minimenu.link.color.hover');
			$sm_minimenu_border_color = $settings->getSetting('sm.minimenu.border.color');
			$sm_header_searchbox_background_color = $settings->getSetting('sm.header.searchbox.background.color');
			$sm_header_searchbox_text_color = $settings->getSetting('sm.header.searchbox.text.color');
			$sm_header_searchbox_border_color = $settings->getSetting('sm.header.searchbox.border.color');
			$sm_minimenu_icon = $settings->getSetting('sm.minimenu.icon');
			$sm_footer_background_color = $settings->getSetting('sm.footer.background.color');
			$sm_footer_border_color = $settings->getSetting('sm.footer.border.color');
			$sm_footer_text_color = $settings->getSetting('sm.footer.text.color');
			$sm_footer_link_color = $settings->getSetting('sm.footer.link.color');
			$sm_footer_link_hover_color = $settings->getSetting('sm.footer.link.hover.color');
			$sm_theme_color = $settings->getSetting('sm.theme.color');
			$sm_theme_secondary_color = $settings->getSetting('sm.theme.secondary.color');
			$sm_body_background_color = $settings->getSetting('sm.body.background.color');
			$sm_font_color = $settings->getSetting('sm.fontcolor');
			$sm_font_color_light = $settings->getSetting('sm.font.color.light');
			$sm_heading_color = $settings->getSetting('sm.heading.color');
			$sm_link_color = $settings->getSetting('sm.linkcolor');
			$sm_link_color_hover = $settings->getSetting('sm.link.color.hover');
			$sm_content_background_color = $settings->getSetting('sm.content.background.color');
			$sm_content_heading_background_color = $settings->getSetting('sm.content.heading.background.color');
			$sm_content_border_color = $settings->getSetting('sm.content.bordercolor');
			$sm_content_border_color_dark = $settings->getSetting('sm.content.border.color.dark');
			$sm_input_background_color = $settings->getSetting('sm.input.background.color');
			$sm_input_font_color = $settings->getSetting('sm.input.font.color');
			$sm_input_border_color = $settings->getSetting('sm.input.border.color');
			$sm_button_background_color = $settings->getSetting('sm.button.backgroundcolor');
			$sm_button_background_color_hover = $settings->getSetting('sm.button.background.color.hover');
			$sm_button_background_color_active = $settings->getSetting('sm.button.background.color.active');
			$sm_button_font_color = $settings->getSetting('sm.button.font.color');
    } else {
	    $sm_header_background_color = $sespectroApi->getContantValueXML('sm_header_background_color');
	    $sm_header_border_color = $sespectroApi->getContantValueXML('sm_header_border_color');
	    $sm_mainmenu_background_color = $sespectroApi->getContantValueXML('sm_mainmenu_background_color');
			$sm_mainmenu_background_color_hover = $sespectroApi->getContantValueXML('sm_mainmenu_background_color_hover');
			$sm_mainmenu_link_color = $sespectroApi->getContantValueXML('sm_mainmenu_link_color');
			$sm_mainmenu_link_color_hover = $sespectroApi->getContantValueXML('sm_mainmenu_link_color_hover');
			$sm_mainmenu_border_color = $sespectroApi->getContantValueXML('sm_mainmenu_border_color');
			$sm_minimenu_link_color = $sespectroApi->getContantValueXML('sm_minimenu_link_color');
			$sm_minimenu_link_color_hover = $sespectroApi->getContantValueXML('sm_minimenu_link_color_hover');
			$sm_minimenu_border_color = $sespectroApi->getContantValueXML('sm_minimenu_border_color');
			$sm_header_searchbox_background_color = $sespectroApi->getContantValueXML('sm_header_searchbox_background_color');
			$sm_header_searchbox_text_color = $sespectroApi->getContantValueXML('sm_header_searchbox_text_color');
			$sm_header_searchbox_border_color = $sespectroApi->getContantValueXML('sm_header_searchbox_border_color');
			$sm_minimenu_icon = $sespectroApi->getContantValueXML('sm_minimenu_icon');
			$sm_footer_background_color = $sespectroApi->getContantValueXML('sm_footer_background_color');
			$sm_footer_border_color = $sespectroApi->getContantValueXML('sm_footer_border_color');
			$sm_footer_text_color = $sespectroApi->getContantValueXML('sm_footer_text_color');
			$sm_footer_link_color = $sespectroApi->getContantValueXML('sm_footer_link_color');
			$sm_footer_link_hover_color = $sespectroApi->getContantValueXML('sm_footer_link_hover_color');
			$sm_theme_color = $sespectroApi->getContantValueXML('sm_theme_color');
			$sm_theme_secondary_color = $sespectroApi->getContantValueXML('sm_theme_secondary_color');
			$sm_body_background_color = $sespectroApi->getContantValueXML('sm_body_background_color');
			$sm_font_color = $sespectroApi->getContantValueXML('sm_font_color');
			$sm_font_color_light = $sespectroApi->getContantValueXML('sm_font_color_light');
			$sm_heading_color = $sespectroApi->getContantValueXML('sm_heading_color');
			$sm_link_color = $sespectroApi->getContantValueXML('sm_link_color');
			$sm_link_color_hover = $sespectroApi->getContantValueXML('sm_link_color_hover');
			$sm_content_background_color = $sespectroApi->getContantValueXML('sm_content_background_color');
			$sm_content_heading_background_color = $sespectroApi->getContantValueXML('sm_content_heading_background_color');
			$sm_content_border_color = $sespectroApi->getContantValueXML('sm_content_border_color');
			$sm_content_border_color_dark = $sespectroApi->getContantValueXML('sm_content_border_color_dark');
			$sm_input_background_color = $sespectroApi->getContantValueXML('sm_input_background_color');
			$sm_input_font_color = $sespectroApi->getContantValueXML('sm_input_font_color');
			$sm_input_border_color = $sespectroApi->getContantValueXML('sm_input_border_color');
			$sm_button_background_color = $sespectroApi->getContantValueXML('sm_button_background_color');
			$sm_button_background_color_hover = $sespectroApi->getContantValueXML('sm_button_background_color_hover');
			$sm_button_background_color_active = $sespectroApi->getContantValueXML('sm_button_background_color_active');
			$sm_button_font_color = $sespectroApi->getContantValueXML('sm_button_font_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "sm_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_header_background_color,
    ));


    $this->addElement('Text', "sm_header_border_color", array(
        'label' => 'Header Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_header_border_color,
    ));


    $this->addElement('Text', "sm_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_mainmenu_background_color,
    ));

    $this->addElement('Text', "sm_mainmenu_background_color_hover", array(
        'label' => 'Main Menu Background Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_mainmenu_background_color_hover,
    ));


    $this->addElement('Text', "sm_mainmenu_link_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_mainmenu_link_color,
    ));

    $this->addElement('Text', "sm_mainmenu_link_color_hover", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_mainmenu_link_color_hover,
    ));


    $this->addElement('Text', "sm_mainmenu_border_color", array(
        'label' => 'Main Menu Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_mainmenu_border_color,
    ));


    $this->addElement('Text', "sm_minimenu_link_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_minimenu_link_color,
    ));


    $this->addElement('Text', "sm_minimenu_link_color_hover", array(
        'label' => 'Mini Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_minimenu_link_color_hover,
    ));

    $this->addElement('Text', "sm_minimenu_border_color", array(
        'label' => 'Mini Menu Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_minimenu_border_color,
    ));

    $this->addElement('Text', "sm_header_searchbox_background_color", array(
        'label' => 'Header Searchbox Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_header_searchbox_background_color,
    ));

    $this->addElement('Text', "sm_header_searchbox_text_color", array(
        'label' => 'Header Searchbox Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_header_searchbox_text_color,
    ));

    $this->addElement('Text', "sm_header_searchbox_border_color", array(
        'label' => 'Header Searchbox Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_header_searchbox_border_color,
    ));


    $this->addElement('Select', "sm_minimenu_icon", array(
        'label' => 'Mini Menu Icon',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
            'minimenu-icons-gray.png' => 'Gray',
            'minimenu-icons-white.png' => 'White',
            'minimenu-icons-dark.png' => 'Dark',
        ),
        'value' => $sm_minimenu_icon,
    ));
    $this->addDisplayGroup(array('sm_header_background_color', 'sm_header_border_color', 'sm_mainmenu_background_color', 'sm_mainmenu_background_color_hover', 'sm_mainmenu_link_color', 'sm_mainmenu_link_color_hover', 'sm_mainmenu_border_color', 'sm_minimenu_link_color', 'sm_minimenu_link_color_hover', 'sm_minimenu_border_color', 'sm_header_searchbox_background_color', 'sm_header_searchbox_text_color', 'sm_header_searchbox_border_color', 'sm_minimenu_icon'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling
    //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "sm_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_footer_background_color,
    ));

    $this->addElement('Text', "sm_footer_border_color", array(
        'label' => 'Footer Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_footer_border_color,
    ));

    $this->addElement('Text', "sm_footer_text_color", array(
        'label' => 'Footer Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_footer_text_color,
    ));

    $this->addElement('Text', "sm_footer_link_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_footer_link_color,
    ));

    $this->addElement('Text', "sm_footer_link_hover_color", array(
        'label' => 'Footer Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_footer_link_hover_color,
    ));
    $this->addDisplayGroup(array('sm_footer_background_color', 'sm_footer_border_color', 'sm_footer_text_color', 'sm_footer_link_color', 'sm_footer_link_hover_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    //End Footer Styling
    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "sm_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_theme_color,
    ));

    $this->addElement('Text', "sm_theme_secondary_color", array(
        'label' => 'Theme Secondary Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_theme_secondary_color,
    ));
    
    
    $this->addElement('Text', "sm_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_body_background_color,
    ));

    $this->addElement('Text', "sm_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_font_color,
    ));

    $this->addElement('Text', "sm_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_font_color_light,
    ));

    $this->addElement('Text', "sm_heading_color", array(
        'label' => 'Heading Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_heading_color,
    ));

    $this->addElement('Text', "sm_link_color", array(
        'label' => 'Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_link_color,
    ));

    $this->addElement('Text', "sm_link_color_hover", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_link_color_hover,
    ));

    $this->addElement('Text', "sm_content_background_color", array(
        'label' => 'Content Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_content_background_color,
    ));

    $this->addElement('Text', "sm_content_heading_background_color", array(
        'label' => 'Content Heading Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_content_heading_background_color,
    ));

    $this->addElement('Text', "sm_content_border_color", array(
        'label' => 'Content Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_content_border_color,
    ));

    $this->addElement('Text', "sm_content_border_color_dark", array(
        'label' => 'Content Border Color Dark',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_content_border_color_dark,
    ));

    $this->addElement('Text', "sm_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_input_background_color,
    ));

    $this->addElement('Text', "sm_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_input_font_color,
    ));

    $this->addElement('Text', "sm_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_input_border_color,
    ));

    $this->addElement('Text', "sm_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_button_background_color,
    ));


    $this->addElement('Text', "sm_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_button_background_color_hover,
    ));


    $this->addElement('Text', "sm_button_background_color_active", array(
        'label' => 'Button Background Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_button_background_color_active,
    ));

    $this->addElement('Text', "sm_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sm_button_font_color,
    ));


    $this->addDisplayGroup(array('sm_theme_color','sm_theme_secondary_color','sm_body_background_color', 'sm_font_color', 'sm_font_color_light', 'sm_heading_color', 'sm_link_color', 'sm_link_color_hover', 'sm_content_background_color', 'sm_content_heading_background_color', 'sm_content_border_color', 'sm_content_border_color_dark', 'sm_input_background_color', 'sm_input_font_color', 'sm_input_border_color', 'sm_button_background_color', 'sm_button_background_color_hover', 'sm_button_background_color_active', 'sm_button_font_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
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
