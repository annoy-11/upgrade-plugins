<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Form_Admin_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $sesytubeApi = Engine_Api::_()->sesytube();
    $this->setTitle('Manage Color Schemes')
            ->setDescription('Here, you can manage the color schemes of your website.');

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/1.jpg" alt="" />',
            2 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/2.jpg" alt="" />',
            3 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/3.jpg" alt="" />',
            4 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/4.jpg" alt="" />',
            6 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/5.jpg" alt="" />',
            7 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/6.jpg" alt="" />',
            8 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/7.jpg" alt="" />',
            9 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/8.jpg" alt="" />',
            10 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/9.jpg" alt="" />',
            11 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/10.jpg" alt="" />',
            12 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/11.jpg" alt="" />',
            13 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/12.jpg" alt="" />',
            5 => '<img src="./application/modules/Sesytube/externals/images/color-scheme/custom.jpg" alt="" />',
        ),
        'onclick' => 'changeThemeColor(this.value, "")',
        'escape' => false,
        'value' => $sesytubeApi->getContantValueXML('theme_color'),
    ));

    $activatedTheme = $sesytubeApi->getContantValueXML('custom_theme_color');

    $customtheme_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('customtheme_id', 0);
    if($customtheme_id) {
      $customtheme_value = $customtheme_id;
    } else {
      $customtheme_value = $sesytubeApi->getContantValueXML('custom_theme_color');
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

    $getCustomThemes = Engine_Api::_()->getDbTable('customthemes', 'sesytube')->getCustomThemes();
    foreach($getCustomThemes as $getCustomTheme){
      $sestheme[$getCustomTheme['customtheme_id']] = $getCustomTheme['name'];
    }

    $this->addElement('Select', 'custom_theme_color', array(
        'label' => 'Custom Theme Color',
        'multiOptions' => $sestheme,
        'onclick' => 'changeCustomThemeColor(this.value)',
        'escape' => false,
        'value' => $customtheme_value, //$sesytubeApi->getContantValueXML('custom_theme_color'),
    ));

    $this->addElement('dummy', 'custom_themes', array(
      'decorators' => array(array('ViewScript', array(
        'viewScript' => 'application/modules/Sesytube/views/scripts/custom_themes.tpl',
        'class' => 'form element',
        'customtheme_id' => $customtheme_id,
        'activatedTheme' => $activatedTheme,
      )))
    ));


    $theme_color = $sesytubeApi->getContantValueXML('theme_color');
    if($theme_color == '5') {
    	$sesytube_header_background_color = $settings->getSetting('sesytube.header.background.color');
			$sesytube_menu_logo_font_color = $settings->getSetting('sesytube.menu.logo.font.color');
			$sesytube_mainmenu_background_color = $settings->getSetting('sesytube.mainmenu.background.color');
			$sesytube_mainmenu_background_hover_color = $settings->getSetting('sesytube.mainmenu.background.hover.color');
			$sesytube_topbar_menu_section_border_color = $settings->getSetting('sesytube.topbar.menu.section.border.color');
			$sesytube_mainmenu_links_color = $settings->getSetting('sesytube.mainmenu.links.color');
			$sesytube_mainmenu_links_hover_color = $settings->getSetting('sesytube.mainmenu.links.hover.color');
			$sesytube_minimenu_links_color = $settings->getSetting('sesytube.minimenu.links.color');
			$sesytube_minimenu_links_hover_color = $settings->getSetting('sesytube.minimenu.links.hover.color');
			$sesytube_minimenu_icon_color = $settings->getSetting('sesytube.minimenu.icon.color');
			$sesytube_minimenu_icon_active_color = $settings->getSetting('sesytube.minimenu.icon.active.color');
			$sesytube_header_searchbox_background_color = $settings->getSetting('sesytube.header.searchbox.background.color');
			$sesytube_header_searchbox_text_color = $settings->getSetting('sesytube.header.searchbox.text.color');
			$sesytube_login_popup_header_font_color = $settings->getSetting('sesytube.login.popup.header.font.color');
			$sesytube_theme_color = $settings->getSetting('sesytube.theme.color');
			$sesytube_body_background_color = $settings->getSetting('sesytube.body.background.color');
			$sesytube_font_color = $settings->getSetting('sesytube.fontcolor');
			$sesytube_font_color_light = $settings->getSetting('sesytube.font.color.light');
			$sesytube_heading_color = $settings->getSetting('sesytube.heading.color');
			$sesytube_links_color = $settings->getSetting('sesytube.links.color');
			$sesytube_links_hover_color = $settings->getSetting('sesytube.links.hover.color');
			$sesytube_content_header_font_color = $settings->getSetting('sesytube.content.header.font.color');
			$sesytube_content_background_color = $settings->getSetting('sesytube.content.backgroundcolor');
			$sesytube_content_background_color_hover = $settings->getSetting('sesytube.content.background.color.hover');
			$sesytube_content_border_color = $settings->getSetting('sesytube.content.border.color');
			$sesytube_form_label_color = $settings->getSetting('sesytube.form.label.color');
			$sesytube_input_background_color = $settings->getSetting('sesytube.input.background.color');
			$sesytube_input_font_color = $settings->getSetting('sesytube.input.font.color');
			$sesytube_input_border_color = $settings->getSetting('sesytube.input.border.color');
			$sesytube_button_background_color = $settings->getSetting('sesytube.button.backgroundcolor');
			$sesytube_button_background_color_hover = $settings->getSetting('sesytube.button.background.color.hover');
			$sesytube_button_font_color = $settings->getSetting('sesytube.button.font.color');
			$sesytube_button_font_hover_color = $settings->getSetting('sesytube.button.font.hover.color');
			$sesytube_comment_background_color = $settings->getSetting('sesytube.comment.background.color');
    } else {
	    $sesytube_header_background_color = $sesytubeApi->getContantValueXML('sesytube_header_background_color');
			$sesytube_menu_logo_font_color = $sesytubeApi->getContantValueXML('sesytube_menu_logo_font_color');
			$sesytube_mainmenu_background_color = $sesytubeApi->getContantValueXML('sesytube_mainmenu_background_color');
			$sesytube_mainmenu_links_color = $sesytubeApi->getContantValueXML('sesytube_mainmenu_links_color');
			$sesytube_mainmenu_links_hover_color = $sesytubeApi->getContantValueXML('sesytube_mainmenu_links_hover_color');
			$sesytube_minimenu_links_color = $sesytubeApi->getContantValueXML('sesytube_minimenu_links_color');
			$sesytube_minimenu_links_hover_color = $sesytubeApi->getContantValueXML('sesytube_minimenu_links_hover_color');
			$sesytube_minimenu_icon_color = $sesytubeApi->getContantValueXML('sesytube_minimenu_icon_color');
			$sesytube_minimenu_icon_active_color = $sesytubeApi->getContantValueXML('sesytube_minimenu_icon_active_color');
			$sesytube_header_searchbox_background_color = $sesytubeApi->getContantValueXML('sesytube_header_searchbox_background_color');
			$sesytube_header_searchbox_text_color = $sesytubeApi->getContantValueXML('sesytube_header_searchbox_text_color');
			$sesytube_login_popup_header_background_color = $settings->getSetting('sesytube_login_popup_header_background_color');
			$sesytube_login_popup_header_font_color = $settings->getSetting('sesytube_login_popup_header_font_color');
			$sesytube_theme_color = $sesytubeApi->getContantValueXML('sesytube_theme_color');
			$sesytube_body_background_color = $sesytubeApi->getContantValueXML('sesytube_body_background_color');
			$sesytube_font_color = $sesytubeApi->getContantValueXML('sesytube_font_color');
			$sesytube_font_color_light = $sesytubeApi->getContantValueXML('sesytube_font_color_light');
			$sesytube_heading_color = $sesytubeApi->getContantValueXML('sesytube_heading_color');
			$sesytube_links_color = $sesytubeApi->getContantValueXML('sesytube_links_color');
			$sesytube_links_hover_color = $sesytubeApi->getContantValueXML('sesytube_links_hover_color');
			$sesytube_content_header_font_color = $sesytubeApi->getContantValueXML('sesytube_content_header_font_color');
			$sesytube_content_background_color = $sesytubeApi->getContantValueXML('sesytube_content_background_color');
			$sesytube_content_background_color_hover = $sesytubeApi->getContantValueXML('sesytube_content_background_color_hover');
			$sesytube_content_border_color = $sesytubeApi->getContantValueXML('sesytube_content_border_color');
			$sesytube_form_label_color = $sesytubeApi->getContantValueXML('sesytube_form_label_color');
			$sesytube_input_background_color = $sesytubeApi->getContantValueXML('sesytube_input_background_color');
			$sesytube_input_font_color = $sesytubeApi->getContantValueXML('sesytube_input_font_color');
			$sesytube_input_border_color = $sesytubeApi->getContantValueXML('sesytube_input_border_color');
			$sesytube_button_background_color = $sesytubeApi->getContantValueXML('sesytube_button_background_color');
			$sesytube_button_background_color_hover = $sesytubeApi->getContantValueXML('sesytube_button_background_color_hover');
			$sesytube_button_font_color = $sesytubeApi->getContantValueXML('sesytube_button_font_color');
			$sesytube_button_font_hover_color = $sesytubeApi->getContantValueXML('sesytube_button_font_hover_color');
			$sesytube_comment_background_color = $sesytubeApi->getContantValueXML('sesytube_comment_background_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "sesytube_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_header_background_color,
    ));

    $this->addElement('Text', "sesytube_menu_logo_font_color", array(
        'label' => 'Menu Logo Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_menu_logo_font_color,
    ));

    $this->addElement('Text', "sesytube_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_mainmenu_background_color,
    ));

    $this->addElement('Text', "sesytube_mainmenu_background_hover_color", array(
        'label' => 'Main Menu Background Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => @$sesytube_mainmenu_background_hover_color,
    ));


    $this->addElement('Text', "sesytube_mainmenu_links_color", array(
        'label' => 'Main Menu Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_mainmenu_links_color,
    ));

    $this->addElement('Text', "sesytube_mainmenu_links_hover_color", array(
        'label' => 'Main Menu Font Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_mainmenu_links_hover_color,
    ));

    $this->addElement('Text', "sesytube_topbar_menu_section_border_color", array(
        'label' => 'Main Menu Separator Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => @$sesytube_topbar_menu_section_border_color,
    ));

		$this->addElement('Text', "sesytube_minimenu_links_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_minimenu_links_color,
    ));

    $this->addElement('Text', "sesytube_minimenu_links_hover_color", array(
        'label' => 'Mini Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_minimenu_links_hover_color,
    ));

    $this->addElement('Text', "sesytube_minimenu_icon_color", array(
        'label' => 'Mini Menu Icon Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_minimenu_icon_color,
    ));
    $this->addElement('Text', "sesytube_minimenu_icon_active_color", array(
        'label' => 'Mini Menu Icon Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_minimenu_icon_active_color,
    ));

    $this->addElement('Text', "sesytube_header_searchbox_background_color", array(
        'label' => 'Header Searchbox Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_header_searchbox_background_color,
    ));

    $this->addElement('Text', "sesytube_header_searchbox_text_color", array(
        'label' => 'Header Searchbox Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_header_searchbox_text_color,
    ));


		//Login Popup Styling
    $this->addElement('Text', "sesytube_login_popup_header_background_color", array(
        'label' => 'Login Popup Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_login_popup_header_background_color,
    ));
    $this->addElement('Text', "sesytube_login_popup_header_font_color", array(
        'label' => 'Login Popup Header Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_login_popup_header_font_color,
    ));

    $this->addDisplayGroup(array('sesytube_header_background_color', 'sesytube_menu_logo_font_color', 'sesytube_mainmenu_background_color', 'sesytube_mainmenu_background_hover_color', 'sesytube_mainmenu_links_color', 'sesytube_mainmenu_links_hover_color','sesytube_topbar_menu_section_border_color', 'sesytube_minimenu_links_color', 'sesytube_minimenu_links_hover_color', 'sesytube_minimenu_icon_color', 'sesytube_minimenu_icon_active_color',  'sesytube_header_searchbox_background_color', 'sesytube_header_searchbox_text_color', 'sesytube_login_popup_header_background_color', 'sesytube_login_popup_header_font_color'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling

    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "sesytube_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_theme_color,
    ));


    $this->addElement('Text', "sesytube_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_body_background_color,
    ));

    $this->addElement('Text', "sesytube_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_font_color,
    ));

    $this->addElement('Text', "sesytube_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_font_color_light,
    ));

    $this->addElement('Text', "sesytube_heading_color", array(
        'label' => 'Heading Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_heading_color,
    ));

    $this->addElement('Text', "sesytube_links_color", array(
        'label' => 'Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_links_color,
    ));

    $this->addElement('Text', "sesytube_links_hover_color", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_links_hover_color,
    ));

    $this->addElement('Text', "sesytube_content_header_font_color", array(
        'label' => 'Content Header Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_content_header_font_color,
    ));

    $this->addElement('Text', "sesytube_content_background_color", array(
        'label' => 'Content Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_content_background_color,
    ));

    $this->addElement('Text', "sesytube_content_background_color_hover", array(
        'label' => 'Content Background Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_content_background_color_hover,
    ));

    $this->addElement('Text', "sesytube_content_border_color", array(
        'label' => 'Content Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_content_border_color,
    ));

    $this->addElement('Text', "sesytube_form_label_color", array(
        'label' => 'Form Label Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_form_label_color,
    ));

    $this->addElement('Text', "sesytube_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_input_background_color,
    ));

    $this->addElement('Text', "sesytube_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_input_font_color,
    ));

    $this->addElement('Text', "sesytube_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_input_border_color,
    ));

    $this->addElement('Text', "sesytube_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_button_background_color,
    ));
    $this->addElement('Text', "sesytube_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_button_background_color_hover,
    ));

    $this->addElement('Text', "sesytube_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_button_font_color,
    ));
    $this->addElement('Text', "sesytube_button_font_hover_color", array(
        'label' => 'Button Font Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_button_font_hover_color,
    ));
    $this->addElement('Text', "sesytube_comment_background_color", array(
        'label' => 'Comments Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesytube_comment_background_color,
    ));


    $this->addDisplayGroup(array('sesytube_theme_color','sesytube_body_background_color', 'sesytube_font_color', 'sesytube_font_color_light', 'sesytube_heading_color', 'sesytube_links_color', 'sesytube_links_hover_color', 'sesytube_content_header_font_color', 'sesytube_content_background_color', 'sesytube_content_background_color_hover', 'sesytube_content_border_color', 'sesytube_form_label_color', 'sesytube_input_background_color', 'sesytube_input_font_color', 'sesytube_input_border_color', 'sesytube_button_background_color', 'sesytube_button_background_color_hover', 'sesytube_button_font_color', 'sesytube_button_font_hover_color', 'sesytube_comment_background_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
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
