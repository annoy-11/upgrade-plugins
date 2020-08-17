<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessportz_Form_Admin_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
   $sespectroApi = Engine_Api::_()->sessportz();
    $this->setTitle('Manage Color Schemes')
            ->setDescription('These settings affect in this theme only on your site.');

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sessportz/externals/images/color-scheme/1.png" alt="" />',
            2 => '<img src="./application/modules/Sessportz/externals/images/color-scheme/2.png" alt="" />',
            3 => '<img src="./application/modules/Sessportz/externals/images/color-scheme/3.png" alt="" />',
            4 => '<img src="./application/modules/Sessportz/externals/images/color-scheme/4.png" alt="" />',
            5 => '<img src="./application/modules/Sessportz/externals/images/color-scheme/custom.png" alt="" />',
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

        ),
        'onclick' => 'changeCustomThemeColor(this.value)',
        'escape' => false,
        'value' => $sespectroApi->getContantValueXML('custom_theme_color'),
    ));
    $theme_color = $sespectroApi->getContantValueXML('theme_color');
    if($theme_color == '5') {
    	$sessportz_header_background_color = $settings->getSetting('sessportz.header.background.color');
	    $sessportz_header_border_color = $settings->getSetting('sessportz.header.border.color');
	    $sessportz_mainmenu_background_color = $settings->getSetting('sessportz.mainmenu.backgroundcolor');
			$sessportz_mainmenu_background_color_hover = $settings->getSetting('sessportz.mainmenu.background.color.hover');
			$sessportz_mainmenu_link_color = $settings->getSetting('sessportz.mainmenu.linkcolor');
			$sessportz_mainmenu_link_color_hover = $settings->getSetting('sessportz.mainmenu.link.color.hover');
			$sessportz_mainmenu_border_color = $settings->getSetting('sessportz.mainmenu.border.color');
			$sessportz_minimenu_link_color = $settings->getSetting('sessportz.minimenu.linkcolor');
			$sessportz_minimenu_link_color_hover = $settings->getSetting('sessportz.minimenu.link.color.hover');
			$sessportz_minimenu_border_color = $settings->getSetting('sessportz.minimenu.border.color');
			$sessportz_header_searchbox_background_color = $settings->getSetting('sessportz.header.searchbox.background.color');
			$sessportz_header_searchbox_text_color = $settings->getSetting('sessportz.header.searchbox.text.color');
			$sessportz_header_searchbox_border_color = $settings->getSetting('sessportz.header.searchbox.border.color');
			$sessportz_minimenu_icon = $settings->getSetting('sessportz.minimenu.icon');
			$sessportz_footer_background_color = $settings->getSetting('sessportz.footer.background.color');
			$sessportz_footer_border_color = $settings->getSetting('sessportz.footer.border.color');
			$sessportz_footer_text_color = $settings->getSetting('sessportz.footer.text.color');
			$sessportz_footer_link_color = $settings->getSetting('sessportz.footer.link.color');
			$sessportz_footer_link_hover_color = $settings->getSetting('sessportz.footer.link.hover.color');
			$sessportz_theme_color = $settings->getSetting('sessportz.theme.color');
			$sessportz_theme_secondary_color = $settings->getSetting('sessportz.theme.secondary.color');
			$sessportz_body_background_color = $settings->getSetting('sessportz.body.background.color');
			$sessportz_font_color = $settings->getSetting('sessportz.fontcolor');
			$sessportz_font_color_light = $settings->getSetting('sessportz.font.color.light');
			$sessportz_heading_color = $settings->getSetting('sessportz.heading.color');
			$sessportz_link_color = $settings->getSetting('sessportz.linkcolor');
			$sessportz_link_color_hover = $settings->getSetting('sessportz.link.color.hover');
			$sessportz_content_background_color = $settings->getSetting('sessportz.content.background.color');
			$sessportz_content_heading_background_color = $settings->getSetting('sessportz.content.heading.background.color');
			$sessportz_content_border_color = $settings->getSetting('sessportz.content.bordercolor');
			$sessportz_content_border_color_dark = $settings->getSetting('sessportz.content.border.color.dark');
			$sessportz_input_background_color = $settings->getSetting('sessportz.input.background.color');
			$sessportz_input_font_color = $settings->getSetting('sessportz.input.font.color');
			$sessportz_input_border_color = $settings->getSetting('sessportz.input.border.color');
			$sessportz_button_background_color = $settings->getSetting('sessportz.button.backgroundcolor');
			$sessportz_button_background_color_hover = $settings->getSetting('sessportz.button.background.color.hover');
			$sessportz_button_background_color_active = $settings->getSetting('sessportz.button.background.color.active');
			$sessportz_button_font_color = $settings->getSetting('sessportz.button.font.color');
    } else {
	    $sessportz_header_background_color = $sespectroApi->getContantValueXML('sessportz_header_background_color');
	    $sessportz_header_border_color = $sespectroApi->getContantValueXML('sessportz_header_border_color');
	    $sessportz_mainmenu_background_color = $sespectroApi->getContantValueXML('sessportz_mainmenu_background_color');
			$sessportz_mainmenu_background_color_hover = $sespectroApi->getContantValueXML('sessportz_mainmenu_background_color_hover');
			$sessportz_mainmenu_link_color = $sespectroApi->getContantValueXML('sessportz_mainmenu_link_color');
			$sessportz_mainmenu_link_color_hover = $sespectroApi->getContantValueXML('sessportz_mainmenu_link_color_hover');
			$sessportz_mainmenu_border_color = $sespectroApi->getContantValueXML('sessportz_mainmenu_border_color');
			$sessportz_minimenu_link_color = $sespectroApi->getContantValueXML('sessportz_minimenu_link_color');
			$sessportz_minimenu_link_color_hover = $sespectroApi->getContantValueXML('sessportz_minimenu_link_color_hover');
			$sessportz_minimenu_border_color = $sespectroApi->getContantValueXML('sessportz_minimenu_border_color');
			$sessportz_header_searchbox_background_color = $sespectroApi->getContantValueXML('sessportz_header_searchbox_background_color');
			$sessportz_header_searchbox_text_color = $sespectroApi->getContantValueXML('sessportz_header_searchbox_text_color');
			$sessportz_header_searchbox_border_color = $sespectroApi->getContantValueXML('sessportz_header_searchbox_border_color');
			$sessportz_minimenu_icon = $sespectroApi->getContantValueXML('sessportz_minimenu_icon');
			$sessportz_footer_background_color = $sespectroApi->getContantValueXML('sessportz_footer_background_color');
			$sessportz_footer_border_color = $sespectroApi->getContantValueXML('sessportz_footer_border_color');
			$sessportz_footer_text_color = $sespectroApi->getContantValueXML('sessportz_footer_text_color');
			$sessportz_footer_link_color = $sespectroApi->getContantValueXML('sessportz_footer_link_color');
			$sessportz_footer_link_hover_color = $sespectroApi->getContantValueXML('sessportz_footer_link_hover_color');
			$sessportz_theme_color = $sespectroApi->getContantValueXML('sessportz_theme_color');
			$sessportz_theme_secondary_color = $sespectroApi->getContantValueXML('sessportz_theme_secondary_color');
			$sessportz_body_background_color = $sespectroApi->getContantValueXML('sessportz_body_background_color');
			$sessportz_font_color = $sespectroApi->getContantValueXML('sessportz_font_color');
			$sessportz_font_color_light = $sespectroApi->getContantValueXML('sessportz_font_color_light');
			$sessportz_heading_color = $sespectroApi->getContantValueXML('sessportz_heading_color');
			$sessportz_link_color = $sespectroApi->getContantValueXML('sessportz_link_color');
			$sessportz_link_color_hover = $sespectroApi->getContantValueXML('sessportz_link_color_hover');
			$sessportz_content_background_color = $sespectroApi->getContantValueXML('sessportz_content_background_color');
			$sessportz_content_heading_background_color = $sespectroApi->getContantValueXML('sessportz_content_heading_background_color');
			$sessportz_content_border_color = $sespectroApi->getContantValueXML('sessportz_content_border_color');
			$sessportz_content_border_color_dark = $sespectroApi->getContantValueXML('sessportz_content_border_color_dark');
			$sessportz_input_background_color = $sespectroApi->getContantValueXML('sessportz_input_background_color');
			$sessportz_input_font_color = $sespectroApi->getContantValueXML('sessportz_input_font_color');
			$sessportz_input_border_color = $sespectroApi->getContantValueXML('sessportz_input_border_color');
			$sessportz_button_background_color = $sespectroApi->getContantValueXML('sessportz_button_background_color');
			$sessportz_button_background_color_hover = $sespectroApi->getContantValueXML('sessportz_button_background_color_hover');
			$sessportz_button_background_color_active = $sespectroApi->getContantValueXML('sessportz_button_background_color_active');
			$sessportz_button_font_color = $sespectroApi->getContantValueXML('sessportz_button_font_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "sessportz_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_header_background_color,
    ));


    $this->addElement('Text', "sessportz_header_border_color", array(
        'label' => 'Header Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_header_border_color,
    ));


    $this->addElement('Text', "sessportz_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_mainmenu_background_color,
    ));

    $this->addElement('Text', "sessportz_mainmenu_background_color_hover", array(
        'label' => 'Main Menu Background Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_mainmenu_background_color_hover,
    ));


    $this->addElement('Text', "sessportz_mainmenu_link_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_mainmenu_link_color,
    ));

    $this->addElement('Text', "sessportz_mainmenu_link_color_hover", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_mainmenu_link_color_hover,
    ));


    $this->addElement('Text', "sessportz_mainmenu_border_color", array(
        'label' => 'Main Menu Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_mainmenu_border_color,
    ));


    $this->addElement('Text', "sessportz_minimenu_link_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_minimenu_link_color,
    ));


    $this->addElement('Text', "sessportz_minimenu_link_color_hover", array(
        'label' => 'Mini Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_minimenu_link_color_hover,
    ));

    $this->addElement('Text', "sessportz_minimenu_border_color", array(
        'label' => 'Mini Menu Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_minimenu_border_color,
    ));

    $this->addElement('Text', "sessportz_header_searchbox_background_color", array(
        'label' => 'Header Searchbox Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_header_searchbox_background_color,
    ));

    $this->addElement('Text', "sessportz_header_searchbox_text_color", array(
        'label' => 'Header Searchbox Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_header_searchbox_text_color,
    ));

    $this->addElement('Text', "sessportz_header_searchbox_border_color", array(
        'label' => 'Header Searchbox Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_header_searchbox_border_color,
    ));


    $this->addElement('Select', "sessportz_minimenu_icon", array(
        'label' => 'Mini Menu Icon',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
            'minimenu-icons-gray.png' => 'Gray',
            'minimenu-icons-white.png' => 'White',
            'minimenu-icons-dark.png' => 'Dark',
        ),
        'value' => $sessportz_minimenu_icon,
    ));
    $this->addDisplayGroup(array('sessportz_header_background_color', 'sessportz_header_border_color', 'sessportz_mainmenu_background_color', 'sessportz_mainmenu_background_color_hover', 'sessportz_mainmenu_link_color', 'sessportz_mainmenu_link_color_hover', 'sessportz_mainmenu_border_color', 'sessportz_minimenu_link_color', 'sessportz_minimenu_link_color_hover', 'sessportz_minimenu_border_color', 'sessportz_header_searchbox_background_color', 'sessportz_header_searchbox_text_color', 'sessportz_header_searchbox_border_color', 'sessportz_minimenu_icon'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling
    //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "sessportz_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_footer_background_color,
    ));

    $this->addElement('Text', "sessportz_footer_border_color", array(
        'label' => 'Footer Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_footer_border_color,
    ));

    $this->addElement('Text', "sessportz_footer_text_color", array(
        'label' => 'Footer Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_footer_text_color,
    ));

    $this->addElement('Text', "sessportz_footer_link_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_footer_link_color,
    ));

    $this->addElement('Text', "sessportz_footer_link_hover_color", array(
        'label' => 'Footer Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_footer_link_hover_color,
    ));
    $this->addDisplayGroup(array('sessportz_footer_background_color', 'sessportz_footer_border_color', 'sessportz_footer_text_color', 'sessportz_footer_link_color', 'sessportz_footer_link_hover_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    //End Footer Styling
    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "sessportz_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_theme_color,
    ));

    $this->addElement('Text', "sessportz_theme_secondary_color", array(
        'label' => 'Theme Secondary Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_theme_secondary_color,
    ));


    $this->addElement('Text', "sessportz_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_body_background_color,
    ));

    $this->addElement('Text', "sessportz_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_font_color,
    ));

    $this->addElement('Text', "sessportz_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_font_color_light,
    ));

    $this->addElement('Text', "sessportz_heading_color", array(
        'label' => 'Heading Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_heading_color,
    ));

    $this->addElement('Text', "sessportz_link_color", array(
        'label' => 'Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_link_color,
    ));

    $this->addElement('Text', "sessportz_link_color_hover", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_link_color_hover,
    ));

    $this->addElement('Text', "sessportz_content_background_color", array(
        'label' => 'Content Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_content_background_color,
    ));

    $this->addElement('Text', "sessportz_content_heading_background_color", array(
        'label' => 'Content Heading Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_content_heading_background_color,
    ));

    $this->addElement('Text', "sessportz_content_border_color", array(
        'label' => 'Content Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_content_border_color,
    ));

    $this->addElement('Text', "sessportz_content_border_color_dark", array(
        'label' => 'Content Border Color Dark',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_content_border_color_dark,
    ));

    $this->addElement('Text', "sessportz_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_input_background_color,
    ));

    $this->addElement('Text', "sessportz_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_input_font_color,
    ));

    $this->addElement('Text', "sessportz_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_input_border_color,
    ));

    $this->addElement('Text', "sessportz_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_button_background_color,
    ));


    $this->addElement('Text', "sessportz_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_button_background_color_hover,
    ));


    $this->addElement('Text', "sessportz_button_background_color_active", array(
        'label' => 'Button Background Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_button_background_color_active,
    ));

    $this->addElement('Text', "sessportz_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sessportz_button_font_color,
    ));


    $this->addDisplayGroup(array('sessportz_theme_color','sessportz_theme_secondary_color','sessportz_body_background_color', 'sessportz_font_color', 'sessportz_font_color_light', 'sessportz_heading_color', 'sessportz_link_color', 'sessportz_link_color_hover', 'sessportz_content_background_color', 'sessportz_content_heading_background_color', 'sessportz_content_border_color', 'sessportz_content_border_color_dark', 'sessportz_input_background_color', 'sessportz_input_font_color', 'sessportz_input_border_color', 'sessportz_button_background_color', 'sessportz_button_background_color_hover', 'sessportz_button_background_color_active', 'sessportz_button_font_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
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
