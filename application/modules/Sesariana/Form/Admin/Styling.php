<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Form_Admin_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $sesarianaApi = Engine_Api::_()->sesariana();
    $this->setTitle('Manage Color Schemes')
            ->setDescription('Here, you can manage the color schemes of your website.');

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/1.png" alt="" />',
            2 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/2.png" alt="" />',
            3 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/3.png" alt="" />',
            4 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/4.png" alt="" />',
						6 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/5.png" alt="" />',
						7 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/6.png" alt="" />',
						8 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/7.png" alt="" />',
						9 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/8.png" alt="" />',
						10 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/9.png" alt="" />',
            11 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/10.png" alt="" />',
            12 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/11.png" alt="" />',
            13 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/12.png" alt="" />',
						5 => '<img src="./application/modules/Sesariana/externals/images/color-scheme/custom.png" alt="" />',
        ),
        'onclick' => 'changeThemeColor(this.value, "")',
        'escape' => false,
        'value' => $sesarianaApi->getContantValueXML('theme_color'),
    ));
    
    $activatedTheme = $sesarianaApi->getContantValueXML('custom_theme_color');
    
    $customtheme_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('customtheme_id', 0);
    if($customtheme_id) {
      $customtheme_value = $customtheme_id;
    } else {
      $customtheme_value = $sesarianaApi->getContantValueXML('custom_theme_color');
    }
    
    $sestheme = array(
      //5 => 'New Custom',
      1 => 'Theme - 1',
      2 => 'Theme - 2',
      3 => 'Theme - 3',
      4 => 'Theme - 4',
      6 => 'Theme - 5',
      7 => 'Theme - 6',
      8 => 'Theme - 7',
      9 => 'Theme - 8',
      10 => 'Theme - 9',
      11 => 'Theme - 10',
      12 => 'Theme - 11',
      13 => 'Theme - 12'
    );
    
    $getCustomThemes = Engine_Api::_()->getDbTable('customthemes', 'sesariana')->getCustomThemes();
    foreach($getCustomThemes as $getCustomTheme){
      $sestheme[$getCustomTheme['customtheme_id']] = $getCustomTheme['name'];
    }

    $this->addElement('Select', 'custom_theme_color', array(
        'label' => 'Custom Theme Color',
        'multiOptions' => $sestheme,
        'onclick' => 'changeCustomThemeColor(this.value)',
        'escape' => false,
        'value' => $customtheme_value, //$sesarianaApi->getContantValueXML('custom_theme_color'),
    ));

    $this->addElement('dummy', 'custom_themes', array(
      'decorators' => array(array('ViewScript', array(
        'viewScript' => 'application/modules/Sesariana/views/scripts/custom_themes.tpl',
        'class' => 'form element',
        'customtheme_id' => $customtheme_id,
        'activatedTheme' => $activatedTheme,
      )))
    ));
    
    
    $theme_color = $sesarianaApi->getContantValueXML('theme_color');
    if($theme_color == '5') {
    	$sesariana_header_background_color = $settings->getSetting('sesariana.header.background.color');
			$sesariana_menu_logo_font_color = $settings->getSetting('sesariana.menu.logo.font.color');
			$sesariana_mainmenu_background_color = $settings->getSetting('sesariana.mainmenu.background.color');
			$sesariana_mainmenu_links_color = $settings->getSetting('sesariana.mainmenu.links.color');
			$sesariana_mainmenu_links_hover_color = $settings->getSetting('sesariana.mainmenu.links.hover.color');
			$sesariana_minimenu_links_color = $settings->getSetting('sesariana.minimenu.links.color');
			$sesariana_minimenu_links_hover_color = $settings->getSetting('sesariana.minimenu.links.hover.color');
			$sesariana_minimenu_icon_background_color = $settings->getSetting('sesariana.minimenu.icon.background.color');
			$sesariana_minimenu_icon_background_active_color = $settings->getSetting('sesariana.minimenu.icon.background.active.color');
			$sesariana_minimenu_icon_color = $settings->getSetting('sesariana.minimenu.icon.color');
			$sesariana_minimenu_icon_active_color = $settings->getSetting('sesariana.minimenu.icon.active.color');
			$sesariana_header_searchbox_background_color = $settings->getSetting('sesariana.header.searchbox.background.color');
			$sesariana_header_searchbox_text_color = $settings->getSetting('sesariana.header.searchbox.text.color');
			$sesariana_login_popup_header_font_color = $settings->getSetting('sesariana.login.popup.header.font.color');
			$sesariana_footer_background_color = $settings->getSetting('sesariana.footer.background.color');
			$sesariana_footer_heading_color = $settings->getSetting('sesariana.footer.heading.color');
			$sesariana_footer_links_color = $settings->getSetting('sesariana.footer.links.color');
			$sesariana_footer_links_hover_color = $settings->getSetting('sesariana.footer.links.hover.color');
			$sesariana_footer_border_color = $settings->getSetting('sesariana.footer.border.color');
			$sesariana_theme_color = $settings->getSetting('sesariana.theme.color');
			$sesariana_body_background_color = $settings->getSetting('sesariana.body.background.color');
			$sesariana_font_color = $settings->getSetting('sesariana.fontcolor');
			$sesariana_font_color_light = $settings->getSetting('sesariana.font.color.light');
			$sesariana_heading_color = $settings->getSetting('sesariana.heading.color');
			$sesariana_links_color = $settings->getSetting('sesariana.links.color');
			$sesariana_links_hover_color = $settings->getSetting('sesariana.links.hover.color');
			$sesariana_content_header_background_color = $settings->getSetting('sesariana.content.header.background.color');
			$sesariana_content_header_font_color = $settings->getSetting('sesariana.content.header.font.color');
			$sesariana_content_background_color = $settings->getSetting('sesariana.content.background.color');
			$sesariana_content_border_color = $settings->getSetting('sesariana.content.border.color');
			$sesariana_form_label_color = $settings->getSetting('sesariana.form.label.color');
			$sesariana_input_background_color = $settings->getSetting('sesariana.input.background.color');
			$sesariana_input_font_color = $settings->getSetting('sesariana.input.font.color');
			$sesariana_input_border_color = $settings->getSetting('sesariana.input.border.color');
			$sesariana_button_background_color = $settings->getSetting('sesariana.button.backgroundcolor');
			$sesariana_button_background_color_hover = $settings->getSetting('sesariana.button.background.color.hover');
			$sesariana_button_font_color = $settings->getSetting('sesariana.button.font.color');
			$sesariana_button_font_hover_color = $settings->getSetting('sesariana.button.font.hover.color');
			$sesariana_comment_background_color = $settings->getSetting('sesariana.comment.background.color');

    } else {
	    $sesariana_header_background_color = $sesarianaApi->getContantValueXML('sesariana_header_background_color');
			$sesariana_menu_logo_font_color = $sesarianaApi->getContantValueXML('sesariana_menu_logo_font_color');
			$sesariana_mainmenu_background_color = $sesarianaApi->getContantValueXML('sesariana_mainmenu_background_color');
			$sesariana_mainmenu_links_color = $sesarianaApi->getContantValueXML('sesariana_mainmenu_links_color');
			$sesariana_mainmenu_links_hover_color = $sesarianaApi->getContantValueXML('sesariana_mainmenu_links_hover_color');
			$sesariana_minimenu_links_color = $sesarianaApi->getContantValueXML('sesariana_minimenu_links_color');
			$sesariana_minimenu_links_hover_color = $sesarianaApi->getContantValueXML('sesariana_minimenu_links_hover_color');
			$sesariana_minimenu_icon_background_color = $settings->getSetting('sesariana_minimenu_icon_background_color');
			$sesariana_minimenu_icon_background_active_color = $settings->getSetting('sesariana_minimenu_icon_background_active_color');
			$sesariana_minimenu_icon_color = $sesarianaApi->getContantValueXML('sesariana_minimenu_icon_color');
			$sesariana_minimenu_icon_active_color = $sesarianaApi->getContantValueXML('sesariana_minimenu_icon_active_color');
			$sesariana_header_searchbox_background_color = $sesarianaApi->getContantValueXML('sesariana_header_searchbox_background_color');
			$sesariana_header_searchbox_text_color = $sesarianaApi->getContantValueXML('sesariana_header_searchbox_text_color');
			
			$sesariana_toppanel_userinfo_background_color = $settings->getSetting('sesariana_toppanel_userinfo_background_color');
			$sesariana_toppanel_userinfo_font_color = $settings->getSetting('sesariana_toppanel_userinfo_font_color');
			
			$sesariana_login_popup_header_background_color = $settings->getSetting('sesariana_login_popup_header_background_color');
			$sesariana_login_popup_header_font_color = $settings->getSetting('sesariana_login_popup_header_font_color');
			$sesariana_footer_background_color = $sesarianaApi->getContantValueXML('sesariana_footer_background_color');
			$sesariana_footer_heading_color = $sesarianaApi->getContantValueXML('sesariana_footer_heading_color');
			$sesariana_footer_links_color = $sesarianaApi->getContantValueXML('sesariana_footer_links_color');
			$sesariana_footer_links_hover_color = $sesarianaApi->getContantValueXML('sesariana_footer_links_hover_color');
			$sesariana_footer_border_color = $sesarianaApi->getContantValueXML('sesariana_footer_border_color');
			$sesariana_theme_color = $sesarianaApi->getContantValueXML('sesariana_theme_color');
			$sesariana_body_background_color = $sesarianaApi->getContantValueXML('sesariana_body_background_color');
			$sesariana_font_color = $sesarianaApi->getContantValueXML('sesariana_font_color');
			$sesariana_font_color_light = $sesarianaApi->getContantValueXML('sesariana_font_color_light');
			$sesariana_heading_color = $sesarianaApi->getContantValueXML('sesariana_heading_color');
			$sesariana_links_color = $sesarianaApi->getContantValueXML('sesariana_links_color');
			$sesariana_links_hover_color = $sesarianaApi->getContantValueXML('sesariana_links_hover_color');
			$sesariana_content_header_background_color = $sesarianaApi->getContantValueXML('sesariana_content_header_background_color');
			$sesariana_content_header_font_color = $sesarianaApi->getContantValueXML('sesariana_content_header_font_color');
			$sesariana_content_background_color = $sesarianaApi->getContantValueXML('sesariana_content_background_color');
			$sesariana_content_border_color = $sesarianaApi->getContantValueXML('sesariana_content_border_color');
			$sesariana_form_label_color = $sesarianaApi->getContantValueXML('sesariana_form_label_color');
			$sesariana_input_background_color = $sesarianaApi->getContantValueXML('sesariana_input_background_color');
			$sesariana_input_font_color = $sesarianaApi->getContantValueXML('sesariana_input_font_color');
			$sesariana_input_border_color = $sesarianaApi->getContantValueXML('sesariana_input_border_color');
			$sesariana_button_background_color = $sesarianaApi->getContantValueXML('sesariana_button_background_color');
			$sesariana_button_background_color_hover = $sesarianaApi->getContantValueXML('sesariana_button_background_color_hover');
			$sesariana_button_font_color = $sesarianaApi->getContantValueXML('sesariana_button_font_color');
			$sesariana_button_font_hover_color = $sesarianaApi->getContantValueXML('sesariana_button_font_hover_color');
			$sesariana_comment_background_color = $sesarianaApi->getContantValueXML('sesariana_comment_background_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "sesariana_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_header_background_color,
    ));
		
    $this->addElement('Text', "sesariana_menu_logo_font_color", array(
        'label' => 'Menu Logo Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_menu_logo_font_color,
    ));

    $this->addElement('Text', "sesariana_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_mainmenu_background_color,
    ));
		
    $this->addElement('Text', "sesariana_mainmenu_links_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_mainmenu_links_color,
    ));

    $this->addElement('Text', "sesariana_mainmenu_links_hover_color", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_mainmenu_links_hover_color,
    ));

    $this->addElement('Text', "sesariana_minimenu_links_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_minimenu_links_color,
    ));

    $this->addElement('Text', "sesariana_minimenu_links_hover_color", array(
        'label' => 'Mini Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_minimenu_links_hover_color,
    ));
		
    $this->addElement('Text', "sesariana_minimenu_icon_background_color", array(
        'label' => 'Mini Menu Icon Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_minimenu_icon_background_color,
    ));
    $this->addElement('Text', "sesariana_minimenu_icon_background_active_color", array(
        'label' => 'Mini Menu Active Icon Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_minimenu_icon_background_active_color,
    ));
		
    $this->addElement('Text', "sesariana_minimenu_icon_color", array(
        'label' => 'Mini Menu Icon Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_minimenu_icon_color,
    ));
    $this->addElement('Text', "sesariana_minimenu_icon_active_color", array(
        'label' => 'Mini Menu Icon Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_minimenu_icon_active_color,
    ));

    $this->addElement('Text', "sesariana_header_searchbox_background_color", array(
        'label' => 'Header Searchbox Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_header_searchbox_background_color,
    ));

    $this->addElement('Text', "sesariana_header_searchbox_text_color", array(
        'label' => 'Header Searchbox Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_header_searchbox_text_color,
    ));
    
    //Top Panel Color
    $this->addElement('Text', "sesariana_toppanel_userinfo_background_color", array(
        'label' => 'Background Color for User section in Main Menu',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_toppanel_userinfo_background_color,
    ));
    $this->addElement('Text', "sesariana_toppanel_userinfo_font_color", array(
        'label' => 'Font Color for User Section in Main Menu',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_toppanel_userinfo_font_color,
    ));
    //Top Panel Color
    
		//Login Popup Styling
    $this->addElement('Text', "sesariana_login_popup_header_background_color", array(
        'label' => 'Login Popup Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_login_popup_header_background_color,
    ));
    $this->addElement('Text', "sesariana_login_popup_header_font_color", array(
        'label' => 'Login Popup Header Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_login_popup_header_font_color,
    ));

    $this->addDisplayGroup(array('sesariana_header_background_color', 'sesariana_menu_logo_font_color', 'sesariana_mainmenu_background_color', 'sesariana_mainmenu_links_color', 'sesariana_mainmenu_links_hover_color', 'sesariana_minimenu_links_color', 'sesariana_minimenu_links_hover_color', 'sesariana_minimenu_icon_background_color', 'sesariana_minimenu_icon_background_active_color', 'sesariana_minimenu_icon_color', 'sesariana_minimenu_icon_active_color',  'sesariana_header_searchbox_background_color', 'sesariana_header_searchbox_text_color','sesariana_toppanel_userinfo_background_color','sesariana_toppanel_userinfo_font_color', 'sesariana_login_popup_header_background_color', 'sesariana_login_popup_header_font_color'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling
    //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "sesariana_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_footer_background_color,
    ));

//     $this->addElement('Text', "sesariana_footer_heading_color", array(
//         'label' => 'Footer Heading Color',
//         'allowEmpty' => false,
//         'required' => true,
//         'class' => 'SEScolor',
//         'value' => $sesariana_footer_heading_color,
//     ));

    $this->addElement('Text', "sesariana_footer_links_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_footer_links_color,
    ));

    $this->addElement('Text', "sesariana_footer_links_hover_color", array(
        'label' => 'Footer Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_footer_links_hover_color,
    ));
    $this->addElement('Text', "sesariana_footer_border_color", array(
        'label' => 'Footer Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_footer_border_color,
    ));
    $this->addDisplayGroup(array('sesariana_footer_background_color', 'sesariana_footer_heading_color', 'sesariana_footer_links_color', 'sesariana_footer_links_hover_color', 'sesariana_footer_border_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    //End Footer Styling
    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "sesariana_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_theme_color,
    ));
    
    
    $this->addElement('Text', "sesariana_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_body_background_color,
    ));

    $this->addElement('Text', "sesariana_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_font_color,
    ));

    $this->addElement('Text', "sesariana_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_font_color_light,
    ));

    $this->addElement('Text', "sesariana_heading_color", array(
        'label' => 'Heading Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_heading_color,
    ));

    $this->addElement('Text', "sesariana_links_color", array(
        'label' => 'Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_links_color,
    ));

    $this->addElement('Text', "sesariana_links_hover_color", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_links_hover_color,
    ));

    $this->addElement('Text', "sesariana_content_header_background_color", array(
        'label' => 'Content Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_content_header_background_color,
    ));
    $this->addElement('Text', "sesariana_content_header_font_color", array(
        'label' => 'Content Header Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_content_header_font_color,
    ));
		
    $this->addElement('Text', "sesariana_content_background_color", array(
        'label' => 'Content Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_content_background_color,
    ));

    $this->addElement('Text', "sesariana_content_border_color", array(
        'label' => 'Content Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_content_border_color,
    ));

    $this->addElement('Text', "sesariana_form_label_color", array(
        'label' => 'Form Label Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_form_label_color,
    ));

    $this->addElement('Text', "sesariana_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_input_background_color,
    ));

    $this->addElement('Text', "sesariana_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_input_font_color,
    ));

    $this->addElement('Text', "sesariana_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_input_border_color,
    ));

    $this->addElement('Text', "sesariana_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_button_background_color,
    ));
    $this->addElement('Text', "sesariana_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_button_background_color_hover,
    ));

    $this->addElement('Text', "sesariana_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_button_font_color,
    ));
    $this->addElement('Text', "sesariana_button_font_hover_color", array(
        'label' => 'Button Font Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_button_font_hover_color,
    ));
    $this->addElement('Text', "sesariana_comment_background_color", array(
        'label' => 'Comments Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesariana_comment_background_color,
    ));


    $this->addDisplayGroup(array('sesariana_theme_color','sesariana_body_background_color', 'sesariana_font_color', 'sesariana_font_color_light', 'sesariana_heading_color', 'sesariana_links_color', 'sesariana_links_hover_color', 'sesariana_content_header_background_color', 'sesariana_content_header_font_color', 'sesariana_content_background_color', 'sesariana_content_border_color', 'sesariana_form_label_color', 'sesariana_input_background_color', 'sesariana_input_font_color', 'sesariana_input_border_color', 'sesariana_button_background_color', 'sesariana_button_background_color_hover', 'sesariana_button_font_color', 'sesariana_button_font_hover_color', 'sesariana_comment_background_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
    $body_settings_group = $this->getDisplayGroup('body_settings_group');
    $body_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'body_settings_group'))));
    //End Body Styling
    
    //Add submit button
    $this->addElement('Button', 'save', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Save as Draft',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addDisplayGroup(array('save', 'submit'), 'buttons');
  }

}
