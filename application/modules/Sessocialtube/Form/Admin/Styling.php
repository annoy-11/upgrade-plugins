<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_Form_Admin_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
   $sespectroApi = Engine_Api::_()->sessocialtube();
    $this->setTitle('Manage Color Schemes')
            ->setDescription('These settings affect in this theme only on your site.');

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sessocialtube/externals/images/color-scheme/1.png" alt="" />',
            2 => '<img src="./application/modules/Sessocialtube/externals/images/color-scheme/2.png" alt="" />',
            3 => '<img src="./application/modules/Sessocialtube/externals/images/color-scheme/3.png" alt="" />',
            4 => '<img src="./application/modules/Sessocialtube/externals/images/color-scheme/4.png" alt="" />',
						6 => '<img src="./application/modules/Sessocialtube/externals/images/color-scheme/5.png" alt="" />',
						7 => '<img src="./application/modules/Sessocialtube/externals/images/color-scheme/6.png" alt="" />',
						8 => '<img src="./application/modules/Sessocialtube/externals/images/color-scheme/7.png" alt="" />',
						9 => '<img src="./application/modules/Sessocialtube/externals/images/color-scheme/8.png" alt="" />',
						10 => '<img src="./application/modules/Sessocialtube/externals/images/color-scheme/9.png" alt="" />',
            
						5 => '<img src="./application/modules/Sessocialtube/externals/images/color-scheme/custom.png" alt="" />',
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
    	$socialtube_header_background_color = $settings->getSetting('socialtube.header.background.color');
	    $socialtube_header_border_color = $settings->getSetting('socialtube.header.border.color');
	    $socialtube_mainmenu_background_color = $settings->getSetting('socialtube.mainmenu.backgroundcolor');
			$socialtube_mainmenu_background_color_hover = $settings->getSetting('socialtube.mainmenu.background.color.hover');
			$socialtube_mainmenu_link_color = $settings->getSetting('socialtube.mainmenu.linkcolor');
			$socialtube_mainmenu_link_color_hover = $settings->getSetting('socialtube.mainmenu.link.color.hover');
			$socialtube_mainmenu_border_color = $settings->getSetting('socialtube.mainmenu.border.color');
			$socialtube_minimenu_link_color = $settings->getSetting('socialtube.minimenu.linkcolor');
			$socialtube_minimenu_link_color_hover = $settings->getSetting('socialtube.minimenu.link.color.hover');
			$socialtube_minimenu_border_color = $settings->getSetting('socialtube.minimenu.border.color');
			$socialtube_header_searchbox_background_color = $settings->getSetting('socialtube.header.searchbox.background.color');
			$socialtube_header_searchbox_text_color = $settings->getSetting('socialtube.header.searchbox.text.color');
			$socialtube_header_searchbox_border_color = $settings->getSetting('socialtube.header.searchbox.border.color');
			$socialtube_minimenu_icon = $settings->getSetting('socialtube.minimenu.icon');
			$socialtube_footer_background_color = $settings->getSetting('socialtube.footer.background.color');
			$socialtube_footer_border_color = $settings->getSetting('socialtube.footer.border.color');
			$socialtube_footer_text_color = $settings->getSetting('socialtube.footer.text.color');
			$socialtube_footer_link_color = $settings->getSetting('socialtube.footer.link.color');
			$socialtube_footer_link_hover_color = $settings->getSetting('socialtube.footer.link.hover.color');
			$socialtube_theme_color = $settings->getSetting('socialtube.theme.color');
			$socialtube_theme_secondary_color = $settings->getSetting('socialtube.theme.secondary.color');
			$socialtube_body_background_color = $settings->getSetting('socialtube.body.background.color');
			$socialtube_font_color = $settings->getSetting('socialtube.fontcolor');
			$socialtube_font_color_light = $settings->getSetting('socialtube.font.color.light');
			$socialtube_heading_color = $settings->getSetting('socialtube.heading.color');
			$socialtube_link_color = $settings->getSetting('socialtube.linkcolor');
			$socialtube_link_color_hover = $settings->getSetting('socialtube.link.color.hover');
			$socialtube_content_background_color = $settings->getSetting('socialtube.content.background.color');
			$socialtube_content_heading_background_color = $settings->getSetting('socialtube.content.heading.background.color');
			$socialtube_content_border_color = $settings->getSetting('socialtube.content.bordercolor');
			$socialtube_content_border_color_dark = $settings->getSetting('socialtube.content.border.color.dark');
			$socialtube_input_background_color = $settings->getSetting('socialtube.input.background.color');
			$socialtube_input_font_color = $settings->getSetting('socialtube.input.font.color');
			$socialtube_input_border_color = $settings->getSetting('socialtube.input.border.color');
			$socialtube_button_background_color = $settings->getSetting('socialtube.button.backgroundcolor');
			$socialtube_button_background_color_hover = $settings->getSetting('socialtube.button.background.color.hover');
			$socialtube_button_background_color_active = $settings->getSetting('socialtube.button.background.color.active');
			$socialtube_button_font_color = $settings->getSetting('socialtube.button.font.color');
			$socialtube_popup_heading_color = $settings->getSetting('socialtube.popup.heading.color');
    } else {
	    $socialtube_header_background_color = $sespectroApi->getContantValueXML('socialtube_header_background_color');
	    $socialtube_header_border_color = $sespectroApi->getContantValueXML('socialtube_header_border_color');
	    $socialtube_mainmenu_background_color = $sespectroApi->getContantValueXML('socialtube_mainmenu_background_color');
			$socialtube_mainmenu_background_color_hover = $sespectroApi->getContantValueXML('socialtube_mainmenu_background_color_hover');
			$socialtube_mainmenu_link_color = $sespectroApi->getContantValueXML('socialtube_mainmenu_link_color');
			$socialtube_mainmenu_link_color_hover = $sespectroApi->getContantValueXML('socialtube_mainmenu_link_color_hover');
			$socialtube_mainmenu_border_color = $sespectroApi->getContantValueXML('socialtube_mainmenu_border_color');
			$socialtube_minimenu_link_color = $sespectroApi->getContantValueXML('socialtube_minimenu_link_color');
			$socialtube_minimenu_link_color_hover = $sespectroApi->getContantValueXML('socialtube_minimenu_link_color_hover');
			$socialtube_minimenu_border_color = $sespectroApi->getContantValueXML('socialtube_minimenu_border_color');
			$socialtube_header_searchbox_background_color = $sespectroApi->getContantValueXML('socialtube_header_searchbox_background_color');
			$socialtube_header_searchbox_text_color = $sespectroApi->getContantValueXML('socialtube_header_searchbox_text_color');
			$socialtube_header_searchbox_border_color = $sespectroApi->getContantValueXML('socialtube_header_searchbox_border_color');
			$socialtube_minimenu_icon = $sespectroApi->getContantValueXML('socialtube_minimenu_icon');
			$socialtube_footer_background_color = $sespectroApi->getContantValueXML('socialtube_footer_background_color');
			$socialtube_footer_border_color = $sespectroApi->getContantValueXML('socialtube_footer_border_color');
			$socialtube_footer_text_color = $sespectroApi->getContantValueXML('socialtube_footer_text_color');
			$socialtube_footer_link_color = $sespectroApi->getContantValueXML('socialtube_footer_link_color');
			$socialtube_footer_link_hover_color = $sespectroApi->getContantValueXML('socialtube_footer_link_hover_color');
			$socialtube_theme_color = $sespectroApi->getContantValueXML('socialtube_theme_color');
			$socialtube_theme_secondary_color = $sespectroApi->getContantValueXML('socialtube_theme_secondary_color');
			$socialtube_body_background_color = $sespectroApi->getContantValueXML('socialtube_body_background_color');
			$socialtube_font_color = $sespectroApi->getContantValueXML('socialtube_font_color');
			$socialtube_font_color_light = $sespectroApi->getContantValueXML('socialtube_font_color_light');
			$socialtube_heading_color = $sespectroApi->getContantValueXML('socialtube_heading_color');
			$socialtube_link_color = $sespectroApi->getContantValueXML('socialtube_link_color');
			$socialtube_link_color_hover = $sespectroApi->getContantValueXML('socialtube_link_color_hover');
			$socialtube_content_background_color = $sespectroApi->getContantValueXML('socialtube_content_background_color');
			$socialtube_content_heading_background_color = $sespectroApi->getContantValueXML('socialtube_content_heading_background_color');
			$socialtube_content_border_color = $sespectroApi->getContantValueXML('socialtube_content_border_color');
			$socialtube_content_border_color_dark = $sespectroApi->getContantValueXML('socialtube_content_border_color_dark');
			$socialtube_input_background_color = $sespectroApi->getContantValueXML('socialtube_input_background_color');
			$socialtube_input_font_color = $sespectroApi->getContantValueXML('socialtube_input_font_color');
			$socialtube_input_border_color = $sespectroApi->getContantValueXML('socialtube_input_border_color');
			$socialtube_button_background_color = $sespectroApi->getContantValueXML('socialtube_button_background_color');
			$socialtube_button_background_color_hover = $sespectroApi->getContantValueXML('socialtube_button_background_color_hover');
			$socialtube_button_background_color_active = $sespectroApi->getContantValueXML('socialtube_button_background_color_active');
			$socialtube_button_font_color = $sespectroApi->getContantValueXML('socialtube_button_font_color');
			$socialtube_popup_heading_color = $sespectroApi->getContantValueXML('socialtube_popup_heading_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "socialtube_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_header_background_color,
    ));


    $this->addElement('Text', "socialtube_header_border_color", array(
        'label' => 'Header Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_header_border_color,
    ));


    $this->addElement('Text', "socialtube_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_mainmenu_background_color,
    ));

    $this->addElement('Text', "socialtube_mainmenu_background_color_hover", array(
        'label' => 'Main Menu Background Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_mainmenu_background_color_hover,
    ));


    $this->addElement('Text', "socialtube_mainmenu_link_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_mainmenu_link_color,
    ));

    $this->addElement('Text', "socialtube_mainmenu_link_color_hover", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_mainmenu_link_color_hover,
    ));


    $this->addElement('Text', "socialtube_mainmenu_border_color", array(
        'label' => 'Main Menu Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_mainmenu_border_color,
    ));


    $this->addElement('Text', "socialtube_minimenu_link_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_minimenu_link_color,
    ));


    $this->addElement('Text', "socialtube_minimenu_link_color_hover", array(
        'label' => 'Mini Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_minimenu_link_color_hover,
    ));

    $this->addElement('Text', "socialtube_minimenu_border_color", array(
        'label' => 'Mini Menu Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_minimenu_border_color,
    ));

    $this->addElement('Text', "socialtube_header_searchbox_background_color", array(
        'label' => 'Header Searchbox Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_header_searchbox_background_color,
    ));

    $this->addElement('Text', "socialtube_header_searchbox_text_color", array(
        'label' => 'Header Searchbox Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_header_searchbox_text_color,
    ));

    $this->addElement('Text', "socialtube_header_searchbox_border_color", array(
        'label' => 'Header Searchbox Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_header_searchbox_border_color,
    ));


    $this->addElement('Select', "socialtube_minimenu_icon", array(
        'label' => 'Mini Menu Icon',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
            'minimenu-icons-gray.png' => 'Gray',
            'minimenu-icons-white.png' => 'White',
            'minimenu-icons-dark.png' => 'Dark',
        ),
        'value' => $socialtube_minimenu_icon,
    ));
    $this->addDisplayGroup(array('socialtube_header_background_color', 'socialtube_header_border_color', 'socialtube_mainmenu_background_color', 'socialtube_mainmenu_background_color_hover', 'socialtube_mainmenu_link_color', 'socialtube_mainmenu_link_color_hover', 'socialtube_mainmenu_border_color', 'socialtube_minimenu_link_color', 'socialtube_minimenu_link_color_hover', 'socialtube_minimenu_border_color', 'socialtube_header_searchbox_background_color', 'socialtube_header_searchbox_text_color', 'socialtube_header_searchbox_border_color', 'socialtube_minimenu_icon'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling
    //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "socialtube_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_footer_background_color,
    ));

    $this->addElement('Text', "socialtube_footer_border_color", array(
        'label' => 'Footer Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_footer_border_color,
    ));

    $this->addElement('Text', "socialtube_footer_text_color", array(
        'label' => 'Footer Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_footer_text_color,
    ));

    $this->addElement('Text', "socialtube_footer_link_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_footer_link_color,
    ));

    $this->addElement('Text', "socialtube_footer_link_hover_color", array(
        'label' => 'Footer Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_footer_link_hover_color,
    ));
    $this->addDisplayGroup(array('socialtube_footer_background_color', 'socialtube_footer_border_color', 'socialtube_footer_text_color', 'socialtube_footer_link_color', 'socialtube_footer_link_hover_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    //End Footer Styling
    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "socialtube_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_theme_color,
    ));

    $this->addElement('Text', "socialtube_theme_secondary_color", array(
        'label' => 'Theme Secondary Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_theme_secondary_color,
    ));
    
    
    $this->addElement('Text', "socialtube_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_body_background_color,
    ));

    $this->addElement('Text', "socialtube_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_font_color,
    ));

    $this->addElement('Text', "socialtube_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_font_color_light,
    ));

    $this->addElement('Text', "socialtube_heading_color", array(
        'label' => 'Heading Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_heading_color,
    ));

    $this->addElement('Text', "socialtube_link_color", array(
        'label' => 'Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_link_color,
    ));

    $this->addElement('Text', "socialtube_link_color_hover", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_link_color_hover,
    ));

    $this->addElement('Text', "socialtube_content_background_color", array(
        'label' => 'Content Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_content_background_color,
    ));

    $this->addElement('Text', "socialtube_content_heading_background_color", array(
        'label' => 'Content Heading Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_content_heading_background_color,
    ));

    $this->addElement('Text', "socialtube_content_border_color", array(
        'label' => 'Content Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_content_border_color,
    ));

    $this->addElement('Text', "socialtube_content_border_color_dark", array(
        'label' => 'Content Border Color Dark',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_content_border_color_dark,
    ));

    $this->addElement('Text', "socialtube_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_input_background_color,
    ));

    $this->addElement('Text', "socialtube_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_input_font_color,
    ));

    $this->addElement('Text', "socialtube_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_input_border_color,
    ));

    $this->addElement('Text', "socialtube_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_button_background_color,
    ));


    $this->addElement('Text', "socialtube_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_button_background_color_hover,
    ));


    $this->addElement('Text', "socialtube_button_background_color_active", array(
        'label' => 'Button Background Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_button_background_color_active,
    ));

    $this->addElement('Text', "socialtube_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_button_font_color,
    ));
    
    $this->addElement('Text', "socialtube_popup_heading_color", array(
        'label' => 'Smoothbox Popup Heading Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $socialtube_popup_heading_color,
    ));

    $this->addDisplayGroup(array('socialtube_theme_color','socialtube_theme_secondary_color','socialtube_body_background_color', 'socialtube_font_color', 'socialtube_font_color_light', 'socialtube_heading_color', 'socialtube_link_color', 'socialtube_link_color_hover', 'socialtube_content_background_color', 'socialtube_content_heading_background_color', 'socialtube_content_border_color', 'socialtube_content_border_color_dark', 'socialtube_input_background_color', 'socialtube_input_font_color', 'socialtube_input_border_color', 'socialtube_button_background_color', 'socialtube_button_background_color_hover', 'socialtube_button_background_color_active', 'socialtube_button_font_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
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
