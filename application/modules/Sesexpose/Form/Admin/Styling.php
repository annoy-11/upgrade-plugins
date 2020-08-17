<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesexpose_Form_Admin_Styling extends Engine_Form {

  public function init() {
  
  
    $description = $this->getTranslator()->translate('Here, you can configure the color scheme for this theme on your site. Below, there are 9 pre-configured color schemes which you can simply choose and enable on your website.<br>You can also make your own theme by using any existing color scheme or a completely new theme. Making from existing theme will not affect the existing schemes.<br />');

// 	  $moreinfo = $this->getTranslator()->translate('See Google Fonts here: <a href="%1$s" target="_blank">https://fonts.google.com/</a><br />');
//         
//     $moreinfos = $this->getTranslator()->translate('See Web Safe Font Combinations here: <a href="%2$s" target="_blank">https://www.w3schools.com/cssref/css_websafe_fonts.asp</a>');
// 
//     $description = vsprintf($description.$moreinfo.$moreinfos, array('https://fonts.google.com','https://www.w3schools.com/cssref/css_websafe_fonts.asp'));

    // Decorators
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $sesexpApi = Engine_Api::_()->sesexpose();
    $this->setTitle('Manage Color Schemes')
            ->setDescription($description);

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sesexpose/externals/images/color-scheme/1.png" alt="" />',
            2 => '<img src="./application/modules/Sesexpose/externals/images/color-scheme/2.png" alt="" />',
            3 => '<img src="./application/modules/Sesexpose/externals/images/color-scheme/3.png" alt="" />',
            4 => '<img src="./application/modules/Sesexpose/externals/images/color-scheme/4.png" alt="" />',
						6 => '<img src="./application/modules/Sesexpose/externals/images/color-scheme/5.png" alt="" />',
						7 => '<img src="./application/modules/Sesexpose/externals/images/color-scheme/6.png" alt="" />',
						8 => '<img src="./application/modules/Sesexpose/externals/images/color-scheme/7.png" alt="" />',
						9 => '<img src="./application/modules/Sesexpose/externals/images/color-scheme/8.png" alt="" />',
						10 => '<img src="./application/modules/Sesexpose/externals/images/color-scheme/9.png" alt="" />',
            
						5 => '<img src="./application/modules/Sesexpose/externals/images/color-scheme/custom.png" alt="" />',
        ),
        'onclick' => 'changeThemeColor(this.value, "")',
        'escape' => false,
        'value' => $sesexpApi->getContantValueXML('theme_color'),
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
        'value' => $sesexpApi->getContantValueXML('custom_theme_color'),
    ));
    $theme_color = $sesexpApi->getContantValueXML('theme_color');
    if($theme_color == '5') {
    	$exp_header_background_color = $settings->getSetting('exp.header.background.color');
	    $exp_header_border_color = $settings->getSetting('exp.header.border.color');
			$exp_mainmenu_links_color = $settings->getSetting('exp.mainmenu.links.color');
			$exp_mainmenu_links_hover_color = $settings->getSetting('exp.mainmenu.links.hover.color');
			$exp_minimenu_links_color = $settings->getSetting('exp.minimenu.linkscolor');
			$exp_minimenu_links_hover_color = $settings->getSetting('exp.minimenu.links.hover.color');
			$exp_header_searchbox_background_color = $settings->getSetting('exp.header.searchbox.background.color');
			$exp_header_searchbox_text_color = $settings->getSetting('exp.header.searchbox.text.color');
			$exp_header_searchbox_border_color = $settings->getSetting('exp.header.searchbox.border.color');
			$exp_footer_background_color = $settings->getSetting('exp.footer.background.color');
			$exp_footer_border_color = $settings->getSetting('exp.footer.border.color');
			$exp_footer_text_color = $settings->getSetting('exp.footer.text.color');
			$exp_footer_links_color = $settings->getSetting('exp.footer.links.color');
			$exp_footer_links_hover_color = $settings->getSetting('exp.footer.links.hover.color');
			$exp_theme_color = $settings->getSetting('exp.theme.color');
			$exp_body_background_color = $settings->getSetting('exp.body.background.color');
			$exp_font_color = $settings->getSetting('exp.fontcolor');
			$exp_font_color_light = $settings->getSetting('exp.font.color.light');
			$exp_heading_color = $settings->getSetting('exp.heading.color');
			$exp_links_color = $settings->getSetting('exp.links.color');
			$exp_links_hover_color = $settings->getSetting('exp.links.hover.color');
			$exp_content_background_color = $settings->getSetting('exp.content.background.color');
			$exp_content_border_color = $settings->getSetting('exp.content.bordercolor');
			$exp_form_label_color = $settings->getSetting('exp.form.label.color');
			$exp_input_background_color = $settings->getSetting('exp.input.background.color');
			$exp_input_font_color = $settings->getSetting('exp.input.font.color');
			$exp_input_border_color = $settings->getSetting('exp.input.border.color');
			$exp_button_background_color = $settings->getSetting('exp.button.backgroundcolor');
			$exp_button_background_color_hover = $settings->getSetting('exp.button.background.color.hover');
			$exp_button_border_color = $settings->getSetting('exp.button.border.color');
			$exp_button_font_color = $settings->getSetting('exp.button.font.color');
			$exp_button_font_hover_color = $settings->getSetting('exp.button.font.hover.color');
			$exp_comment_background_color = $settings->getSetting('exp.comment.background.color');

    } else {
	    $exp_header_background_color = $sesexpApi->getContantValueXML('exp_header_background_color');
	    $exp_header_border_color = $sesexpApi->getContantValueXML('exp_header_border_color');
			$exp_mainmenu_links_color = $sesexpApi->getContantValueXML('exp_mainmenu_links_color');
			$exp_mainmenu_links_hover_color = $sesexpApi->getContantValueXML('exp_mainmenu_links_hover_color');
			$exp_minimenu_links_color = $sesexpApi->getContantValueXML('exp_minimenu_links_color');
			$exp_minimenu_links_hover_color = $sesexpApi->getContantValueXML('exp_minimenu_links_hover_color');
			$exp_header_searchbox_background_color = $sesexpApi->getContantValueXML('exp_header_searchbox_background_color');
			$exp_header_searchbox_text_color = $sesexpApi->getContantValueXML('exp_header_searchbox_text_color');
			$exp_header_searchbox_border_color = $sesexpApi->getContantValueXML('exp_header_searchbox_border_color');
			$exp_footer_background_color = $sesexpApi->getContantValueXML('exp_footer_background_color');
			$exp_footer_border_color = $sesexpApi->getContantValueXML('exp_footer_border_color');
			$exp_footer_text_color = $sesexpApi->getContantValueXML('exp_footer_text_color');
			$exp_footer_links_color = $sesexpApi->getContantValueXML('exp_footer_links_color');
			$exp_footer_links_hover_color = $sesexpApi->getContantValueXML('exp_footer_links_hover_color');
			$exp_theme_color = $sesexpApi->getContantValueXML('exp_theme_color');
			$exp_body_background_color = $sesexpApi->getContantValueXML('exp_body_background_color');
			$exp_font_color = $sesexpApi->getContantValueXML('exp_font_color');
			$exp_font_color_light = $sesexpApi->getContantValueXML('exp_font_color_light');
			$exp_heading_color = $sesexpApi->getContantValueXML('exp_heading_color');
			$exp_links_color = $sesexpApi->getContantValueXML('exp_links_color');
			$exp_links_hover_color = $sesexpApi->getContantValueXML('exp_links_hover_color');
			$exp_content_background_color = $sesexpApi->getContantValueXML('exp_content_background_color');
			$exp_content_border_color = $sesexpApi->getContantValueXML('exp_content_border_color');
			$exp_form_label_color = $sesexpApi->getContantValueXML('exp_form_label_color');
			$exp_input_background_color = $sesexpApi->getContantValueXML('exp_input_background_color');
			$exp_input_font_color = $sesexpApi->getContantValueXML('exp_input_font_color');
			$exp_input_border_color = $sesexpApi->getContantValueXML('exp_input_border_color');
			$exp_button_background_color = $sesexpApi->getContantValueXML('exp_button_background_color');
			$exp_button_background_color_hover = $sesexpApi->getContantValueXML('exp_button_background_color_hover');
			$exp_button_border_color = $sesexpApi->getContantValueXML('exp_button_border_color');
			$exp_button_font_color = $sesexpApi->getContantValueXML('exp_button_font_color');
			$exp_button_font_hover_color = $sesexpApi->getContantValueXML('exp_button_font_hover_color');
			$exp_comment_background_color = $sesexpApi->getContantValueXML('exp_comment_background_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "exp_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_header_background_color,
    ));

    $this->addElement('Text', "exp_header_border_color", array(
        'label' => 'Header Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_header_border_color,
    ));

    $this->addElement('Text', "exp_mainmenu_links_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_mainmenu_links_color,
    ));

    $this->addElement('Text', "exp_mainmenu_links_hover_color", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_mainmenu_links_hover_color,
    ));


    $this->addElement('Text', "exp_minimenu_links_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_minimenu_links_color,
    ));


    $this->addElement('Text', "exp_minimenu_links_hover_color", array(
        'label' => 'Mini Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_minimenu_links_hover_color,
    ));

    $this->addElement('Text', "exp_header_searchbox_background_color", array(
        'label' => 'Header Searchbox Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_header_searchbox_background_color,
    ));

    $this->addElement('Text', "exp_header_searchbox_text_color", array(
        'label' => 'Header Searchbox Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_header_searchbox_text_color,
    ));
		    $this->addElement('Text', "exp_header_searchbox_border_color", array(
        'label' => 'Header Searchbox Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_header_searchbox_border_color,
    ));

    $this->addDisplayGroup(array('exp_header_background_color', 'exp_header_border_color', 'exp_mainmenu_links_color', 'exp_mainmenu_links_hover_color', 'exp_minimenu_links_color', 'exp_minimenu_links_hover_color', 'exp_header_searchbox_background_color', 'exp_header_searchbox_text_color','exp_header_searchbox_border_color'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling
    //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "exp_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_footer_background_color,
    ));

    $this->addElement('Text', "exp_footer_border_color", array(
        'label' => 'Footer Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_footer_border_color,
    ));

    $this->addElement('Text', "exp_footer_text_color", array(
        'label' => 'Footer Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_footer_text_color,
    ));

    $this->addElement('Text', "exp_footer_links_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_footer_links_color,
    ));

    $this->addElement('Text', "exp_footer_links_hover_color", array(
        'label' => 'Footer Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_footer_links_hover_color,
    ));
    $this->addDisplayGroup(array('exp_footer_background_color', 'exp_footer_border_color', 'exp_footer_text_color', 'exp_footer_links_color', 'exp_footer_links_hover_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    //End Footer Styling
    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "exp_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_theme_color,
    ));
    
    
    $this->addElement('Text', "exp_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_body_background_color,
    ));

    $this->addElement('Text', "exp_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_font_color,
    ));

    $this->addElement('Text', "exp_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_font_color_light,
    ));

    $this->addElement('Text', "exp_heading_color", array(
        'label' => 'Heading Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_heading_color,
    ));

    $this->addElement('Text', "exp_links_color", array(
        'label' => 'Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_links_color,
    ));

    $this->addElement('Text', "exp_links_hover_color", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_links_hover_color,
    ));

    $this->addElement('Text', "exp_content_background_color", array(
        'label' => 'Content Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_content_background_color,
    ));

    $this->addElement('Text', "exp_content_border_color", array(
        'label' => 'Content Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_content_border_color,
    ));

    $this->addElement('Text', "exp_form_label_color", array(
        'label' => 'Form Label Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_form_label_color,
    ));

    $this->addElement('Text', "exp_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_input_background_color,
    ));

    $this->addElement('Text', "exp_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_input_font_color,
    ));

    $this->addElement('Text', "exp_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_input_border_color,
    ));

    $this->addElement('Text', "exp_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_button_background_color,
    ));
    $this->addElement('Text', "exp_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_button_background_color_hover,
    ));
    $this->addElement('Text', "exp_button_border_color", array(
        'label' => 'Button Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_button_border_color,
    ));

    $this->addElement('Text', "exp_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_button_font_color,
    ));
    $this->addElement('Text', "exp_button_font_hover_color", array(
        'label' => 'Button Font Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_button_font_hover_color,
    ));
    $this->addElement('Text', "exp_comment_background_color", array(
        'label' => 'Comments Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $exp_comment_background_color,
    ));

    $this->addDisplayGroup(array('exp_theme_color','exp_body_background_color', 'exp_font_color', 'exp_font_color_light', 'exp_heading_color', 'exp_links_color', 'exp_links_hover_color', 'exp_content_background_color', 'exp_content_border_color', 'exp_form_label_color', 'exp_input_background_color', 'exp_input_font_color', 'exp_input_border_color', 'exp_button_background_color', 'exp_button_background_color_hover', 'exp_button_font_color', 'exp_button_font_hover_color', 'exp_button_border_color', 'exp_comment_background_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
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
