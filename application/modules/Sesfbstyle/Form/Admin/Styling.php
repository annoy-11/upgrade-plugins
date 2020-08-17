<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfbstyle_Form_Admin_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $sesfbstyleApi = Engine_Api::_()->sesfbstyle();
    $this->setTitle('Manage Color Schemes')
            ->setDescription('Here, you can manage the color schemes of your website.');

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sesfbstyle/externals/images/color-scheme/1.png" alt="" />',
            2 => '<img src="./application/modules/Sesfbstyle/externals/images/color-scheme/2.png" alt="" />',
            3 => '<img src="./application/modules/Sesfbstyle/externals/images/color-scheme/3.png" alt="" />',
						5 => '<img src="./application/modules/Sesfbstyle/externals/images/color-scheme/custom.png" alt="" />',
        ),
        'onclick' => 'changeThemeColor(this.value, "")',
        'escape' => false,
        'value' => $sesfbstyleApi->getContantValueXML('theme_color'),
    ));
    
    $activatedTheme = $sesfbstyleApi->getContantValueXML('custom_theme_color');
    
    $customtheme_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('customtheme_id', 0);
    if($customtheme_id) {
      $customtheme_value = $customtheme_id;
    } else {
      $customtheme_value = $sesfbstyleApi->getContantValueXML('custom_theme_color');
    }
    
    $sestheme = array(
      //5 => 'New Custom',
      1 => 'Theme - 1',
      2 => 'Theme - 2',
      3 => 'Theme - 3',
    );
    
    $getCustomThemes = Engine_Api::_()->getDbTable('customthemes', 'sesfbstyle')->getCustomThemes();
    foreach($getCustomThemes as $getCustomTheme){
      $sestheme[$getCustomTheme['customtheme_id']] = $getCustomTheme['name'];
    }

    $this->addElement('Select', 'custom_theme_color', array(
        'label' => 'Custom Theme Color',
        'multiOptions' => $sestheme,
        'onclick' => 'changeCustomThemeColor(this.value)',
        'escape' => false,
        'value' => $customtheme_value, //$sesfbstyleApi->getContantValueXML('custom_theme_color'),
    ));

    $this->addElement('dummy', 'custom_themes', array(
      'decorators' => array(array('ViewScript', array(
        'viewScript' => 'application/modules/Sesfbstyle/views/scripts/custom_themes.tpl',
        'class' => 'form element',
        'customtheme_id' => $customtheme_id,
        'activatedTheme' => $activatedTheme,
      )))
    ));
    
    
    $theme_color = $sesfbstyleApi->getContantValueXML('theme_color');
    if($theme_color == '5') {

      $sesfbstyle_header_background_color = $settings->getSetting('sesfbstyle.header.background.color');
      $sesfbstyle_header_border_color = $settings->getSetting('sesfbstyle.header.border.color');
      $sesfbstyle_header_search_background_color = $settings->getSetting('sesfbstyle.header.search.background.color');
      $sesfbstyle_header_search_border_color = $settings->getSetting('sesfbstyle.header.search.border.color');
      $sesfbstyle_header_search_button_background_color = $settings->getSetting('sesfbstyle.header.search.button.background.color');
      $sesfbstyle_header_search_button_font_color = $settings->getSetting('sesfbstyle.header.search.button.font.color');
      $sesfbstyle_header_font_color = $settings->getSetting('sesfbstyle.header.font.color');
      $sesfbstyle_mainmenu_search_background_color = $settings->getSetting('sesfbstyle.mainmenu.search.background.color');
      $sesfbstyle_mainmenu_background_color = $settings->getSetting('sesfbstyle.mainmenu.background.color');
      $sesfbstyle_mainmenu_links_color = $settings->getSetting('sesfbstyle.mainmenu.link.color');
      $sesfbstyle_mainmenu_links_hover_color = $settings->getSetting('sesfbstyle.mainmenu.link.hover.color');
      $sesfbstyle_mainmenu_footer_font_color = $settings->getSetting('sesfbstyle.mainmenu.footer.font.color');
      $sesfbstyle_minimenu_links_color = $settings->getSetting('sesfbstyle.minimenu.link.color');
      $sesfbstyle_minimenu_link_active_color = $settings->getSetting('sesfbstyle.minimenu.link.active.color');
      $sesfbstyle_header_icons_type = $settings->getSetting('sesfbstyle.header.icons.type');
      $sesfbstyle_footer_background_color = $settings->getSetting('sesfbstyle.footer.background.color');      
      $sesfbstyle_footer_font_color = $settings->getSetting('sesfbstyle.footer.font.color');      
      $sesfbstyle_footer_links_color = $settings->getSetting('sesfbstyle.footer.links.color');    
      $sesfbstyle_footer_border_color = $settings->getSetting('sesfbstyle.footer.border.color');   
      $sesfbstyle_theme_color = $settings->getSetting('sesfbstyle.theme.color');   
      $sesfbstyle_body_background_color = $settings->getSetting('sesfbstyle.body.background.color');   
      $sesfbstyle_font_color = $settings->getSetting('sesfbstyle.font.color');   
      $sesfbstyle_font_color_light = $settings->getSetting('sesfbstyle.font.color.light');   
      $sesfbstyle_links_color = $settings->getSetting('sesfbstyle.links.color');   
      $sesfbstyle_links_hover_color = $settings->getSetting('sesfbstyle.links.hover.color');   
      $sesfbstyle_headline_background_color = $settings->getSetting('sesfbstyle.headline.background.color'); 
      $sesfbstyle_headline_color = $settings->getSetting('sesfbstyle.headline.color');   
      $sesfbstyle_border_color = $settings->getSetting('sesfbstyle.border.color');   
      $sesfbstyle_box_background_color = $settings->getSetting('sesfbstyle.box.background.color');   
      $sesfbstyle_form_label_color = $settings->getSetting('sesfbstyle.form.label.color');
      $sesfbstyle_input_background_color = $settings->getSetting('sesfbstyle.input.background.color');
      $sesfbstyle_input_font_color = $settings->getSetting('sesfbstyle.input.font.color');
      $sesfbstyle_input_border_color = $settings->getSetting('sesfbstyle.input.border.colors');
      $sesfbstyle_button_background_color = $settings->getSetting('sesfbstyle.button.background.color');
      $sesfbstyle_button_background_color_hover = $settings->getSetting('sesfbstyle.button.background.color.hover');
      $sesfbstyle_button_font_color = $settings->getSetting('sesfbstyle.button.font.color');
      $sesfbstyle_button_border_color = $settings->getSetting('sesfbstyle.button.border.color');
      $sesfbstyle_dashboard_list_background_color_hover = $settings->getSetting('sesfbstyle.dashboard.list.background.color.hover');
      $sesfbstyle_dashboard_list_border_color = $settings->getSetting('sesfbstyle.dashboard.list.border.color');
      $sesfbstyle_dashboard_font_color = $settings->getSetting('sesfbstyle.dashboard.font.color');
      $sesfbstyle_dashboard_link_color = $settings->getSetting('sesfbstyle.dashboard.link.color');
      $sesfbstyle_comments_background_color = $settings->getSetting('sesfbstyle.comments.background.color');
			$sesfbstyle_lp_header_background_color = $settings->getSetting('sesfbstyle.lp.header.background.color');
			$sesfbstyle_lp_header_border_color = $settings->getSetting('sesfbstyle.lp.header.border.color');
			$sesfbstyle_lp_header_input_background_color = $settings->getSetting('sesfbstyle.lp.header.input.background.color');
			$sesfbstyle_lp_header_input_border_color = $settings->getSetting('sesfbstyle.lp.header.input.border.color');
			$sesfbstyle_lp_header_button_background_color = $settings->getSetting('sesfbstyle.lp.header.button.background.color');
			$sesfbstyle_lp_header_button_font_color = $settings->getSetting('sesfbstyle.lp.header.button.font.color');
			$sesfbstyle_lp_header_button_hover_color = $settings->getSetting('sesfbstyle.lp.header.button.hover.color');
			$sesfbstyle_lp_header_font_color = $settings->getSetting('sesfbstyle.lp.header.font.color');
			$sesfbstyle_lp_header_link_color = $settings->getSetting('sesfbstyle.lp.header.link.color');
			$sesfbstyle_lp_signup_button_color = $settings->getSetting('sesfbstyle.lp.signup.button.color');
			$sesfbstyle_lp_signup_button_border_color = $settings->getSetting('sesfbstyle.lp.signup.button.border.color');
			$sesfbstyle_lp_signup_button_font_color = $settings->getSetting('sesfbstyle.lp.signup.button.font.color');
			$sesfbstyle_lp_signup_button_hover_color = $settings->getSetting('sesfbstyle.lp.signup.button.hover.color');
			$sesfbstyle_lp_signup_button_hover_font_color = $settings->getSetting('sesfbstyle.lp.signup.button.hover.font.color');
      
    } else {
    
      $sesfbstyle_header_background_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_header_background_color');
      $sesfbstyle_header_border_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_header_border_color');
      $sesfbstyle_header_search_background_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_header_search_background_color');
      $sesfbstyle_header_search_border_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_header_search_border_color');
      $sesfbstyle_header_search_button_background_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_header_search_button_background_color');
      $sesfbstyle_header_search_button_font_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_header_search_button_font_color');
      $sesfbstyle_header_font_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_header_font_color');
      $sesfbstyle_mainmenu_search_background_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_mainmenu_search_background_color');
      $sesfbstyle_mainmenu_background_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_mainmenu_background_color');
      $sesfbstyle_mainmenu_links_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_mainmenu_links_color');
      $sesfbstyle_mainmenu_links_hover_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_mainmenu_links_hover_color');
      $sesfbstyle_mainmenu_footer_font_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_mainmenu_footer_font_color');
      $sesfbstyle_minimenu_links_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_minimenu_links_color');
      $sesfbstyle_minimenu_link_active_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_minimenu_link_active_color');
      $sesfbstyle_header_icons_type = $sesfbstyleApi->getContantValueXML('sesfbstyle_header_icons_type');
      $sesfbstyle_footer_background_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_footer_background_color');      
      $sesfbstyle_footer_font_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_footer_font_color');      
      $sesfbstyle_footer_links_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_footer_links_color');    
      $sesfbstyle_footer_border_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_footer_border_color');   
      $sesfbstyle_theme_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_theme_color');   
      $sesfbstyle_body_background_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_body_background_color');   
      $sesfbstyle_font_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_font_color');   
      $sesfbstyle_font_color_light = $sesfbstyleApi->getContantValueXML('sesfbstyle_font_color_light');   
      $sesfbstyle_links_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_links_color');   
      $sesfbstyle_links_hover_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_links_hover_color');   
      $sesfbstyle_headline_background_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_headline_background_color'); 
      $sesfbstyle_headline_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_headline_color');   
      $sesfbstyle_border_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_border_color');   
      $sesfbstyle_box_background_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_box_background_color');   
      $sesfbstyle_form_label_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_form_label_color');
      $sesfbstyle_input_background_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_input_background_color');
      $sesfbstyle_input_font_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_input_font_color');
      $sesfbstyle_input_border_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_input_border_color');
      $sesfbstyle_button_background_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_button_background_color');
      $sesfbstyle_button_background_color_hover = $sesfbstyleApi->getContantValueXML('sesfbstyle_button_background_color_hover');
      $sesfbstyle_button_font_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_button_font_color');
      $sesfbstyle_button_border_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_button_border_color');
      $sesfbstyle_dashboard_list_background_color_hover = $sesfbstyleApi->getContantValueXML('sesfbstyle_dashboard_list_background_color_hover');
      $sesfbstyle_dashboard_list_border_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_dashboard_list_border_color');
      $sesfbstyle_dashboard_font_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_dashboard_font_color');
      $sesfbstyle_dashboard_link_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_dashboard_link_color');
      $sesfbstyle_comments_background_color = $sesfbstyleApi->getContantValueXML('sesfbstyle_comments_background_color');
			$sesfbstyle_lp_header_background_color = $settings->getSetting('sesfbstyle_lp_header_background_color');
			$sesfbstyle_lp_header_border_color = $settings->getSetting('sesfbstyle_lp_header_border_color');
			$sesfbstyle_lp_header_input_background_color = $settings->getSetting('sesfbstyle_lp_header_input_background_color');
			$sesfbstyle_lp_header_input_border_color = $settings->getSetting('sesfbstyle_lp_header_input_border_color');
			$sesfbstyle_lp_header_button_background_color = $settings->getSetting('sesfbstyle_lp_header_button_background_color');
			$sesfbstyle_lp_header_button_hover_color = $settings->getSetting('sesfbstyle_lp_header_button_hover_color');
			$sesfbstyle_lp_header_button_font_color = $settings->getSetting('sesfbstyle_lp_header_button_font_color');
			$sesfbstyle_lp_header_font_color = $settings->getSetting('sesfbstyle_lp_header_font_color');
			$sesfbstyle_lp_header_link_color = $settings->getSetting('sesfbstyle_lp_header_link_color');
			$sesfbstyle_lp_signup_button_color = $settings->getSetting('sesfbstyle_lp_signup_button_color');
			$sesfbstyle_lp_signup_button_border_color = $settings->getSetting('sesfbstyle_lp_signup_button_border_color');
			$sesfbstyle_lp_signup_button_font_color = $settings->getSetting('sesfbstyle_lp_signup_button_font_color');
			$sesfbstyle_lp_signup_button_hover_color = $settings->getSetting('sesfbstyle_lp_signup_button_hover_color');
			$sesfbstyle_lp_signup_button_hover_font_color = $settings->getSetting('sesfbstyle_lp_signup_button_hover_font_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "sesfbstyle_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_header_background_color,
    ));

    $this->addElement('Text', "sesfbstyle_header_border_color", array(
      'label' => 'Header Border Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_header_border_color,
    ));
    
    $this->addElement('Text', "sesfbstyle_header_search_background_color", array(
      'label' => 'Header Search Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_header_search_background_color,
    ));
    
    $this->addElement('Text', "sesfbstyle_header_search_border_color", array(
      'label' => 'Header Search Border Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_header_search_border_color,
    ));
    
    
    $this->addElement('Text', "sesfbstyle_header_search_button_background_color", array(
      'label' => 'Header Search Button Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_header_search_button_background_color,
    ));

    $this->addElement('Text', "sesfbstyle_header_search_button_font_color", array(
      'label' => 'Header Search Button Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_header_search_button_font_color,
    ));

    $this->addElement('Text', "sesfbstyle_header_font_color", array(
      'label' => 'Header Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_header_font_color,
    ));
    
    $this->addElement('Text', "sesfbstyle_mainmenu_search_background_color", array(
      'label' => 'Mini Menu Search Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_mainmenu_search_background_color,
    ));

    $this->addElement('Text', "sesfbstyle_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_mainmenu_background_color,
    ));
		
    $this->addElement('Text', "sesfbstyle_mainmenu_links_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_mainmenu_links_color,
    ));

    $this->addElement('Text', "sesfbstyle_mainmenu_links_hover_color", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_mainmenu_links_hover_color,
    ));
    
    $this->addElement('Text', "sesfbstyle_mainmenu_footer_font_color", array(
        'label' => 'Main Menu Footer Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_mainmenu_footer_font_color,
    ));
    

    $this->addElement('Text', "sesfbstyle_minimenu_links_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_minimenu_links_color,
    ));
    
    $this->addElement('Text', "sesfbstyle_minimenu_link_active_color", array(
        'label' => 'Mini Menu Link Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_minimenu_link_active_color,
    ));
    
    $this->addElement('Select', 'sesfbstyle_header_icons_type', array(
      'label' => 'Mini Menu Icon Type',
      'description' => 'Choose mini menu icon type',
      'multiOptions' => array(
        2 => "Dark Icon",
        3 => "Light Icon",
      ),
      'value' => $sesfbstyle_header_icons_type,
    ));

    $this->addDisplayGroup(array('sesfbstyle_header_background_color', 'sesfbstyle_header_border_color', 'sesfbstyle_header_search_background_color', 'sesfbstyle_header_search_border_color', 'sesfbstyle_header_search_button_background_color', 'sesfbstyle_header_search_button_font_color', 'sesfbstyle_header_font_color', 'sesfbstyle_mainmenu_search_background_color', 'sesfbstyle_mainmenu_background_color', 'sesfbstyle_mainmenu_links_color', 'sesfbstyle_mainmenu_links_hover_color',  'sesfbstyle_mainmenu_footer_font_color', 'sesfbstyle_minimenu_links_color', 'sesfbstyle_minimenu_link_active_color', 'sesfbstyle_header_icons_type'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling
    
    //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "sesfbstyle_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_footer_background_color,
    ));

    $this->addElement('Text', "sesfbstyle_footer_font_color", array(
        'label' => 'Footer Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_footer_font_color,
    ));

    $this->addElement('Text', "sesfbstyle_footer_links_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_footer_links_color,
    ));

    $this->addElement('Text', "sesfbstyle_footer_border_color", array(
        'label' => 'Footer Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_footer_border_color,
    ));
    $this->addDisplayGroup(array('sesfbstyle_footer_background_color', 'sesfbstyle_footer_font_color', 'sesfbstyle_footer_links_color', 'sesfbstyle_footer_border_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    //End Footer Styling
    
    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "sesfbstyle_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_theme_color,
    ));
    
    $this->addElement('Text', "sesfbstyle_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_body_background_color,
    ));

    $this->addElement('Text', "sesfbstyle_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_font_color,
    ));

    $this->addElement('Text', "sesfbstyle_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_font_color_light,
    ));

    $this->addElement('Text', "sesfbstyle_links_color", array(
      'label' => 'Link Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_links_color,
    ));

    $this->addElement('Text', "sesfbstyle_links_hover_color", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_links_hover_color,
    ));
    
    $this->addElement('Text', "sesfbstyle_headline_background_color", array(
        'label' => 'Headline Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_headline_background_color,
    ));
    
    $this->addElement('Text', "sesfbstyle_headline_color", array(
        'label' => 'Headline Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_headline_color,
    ));
    
    $this->addElement('Text', "sesfbstyle_border_color", array(
        'label' => 'Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_border_color,
    ));
    $this->addElement('Text', "sesfbstyle_box_background_color", array(
        'label' => 'Box Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_box_background_color,
    ));
    
    $this->addElement('Text', "sesfbstyle_form_label_color", array(
        'label' => 'Form Label Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_form_label_color,
    ));

    $this->addElement('Text', "sesfbstyle_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_input_background_color,
    ));

    $this->addElement('Text', "sesfbstyle_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_input_font_color,
    ));

    $this->addElement('Text', "sesfbstyle_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_input_border_color,
    ));

    $this->addElement('Text', "sesfbstyle_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_button_background_color,
    ));
    $this->addElement('Text', "sesfbstyle_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_button_background_color_hover,
    ));

    $this->addElement('Text', "sesfbstyle_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_button_font_color,
    ));
    $this->addElement('Text', "sesfbstyle_button_border_color", array(
        'label' => 'Button Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_button_border_color,
    ));

    $this->addElement('Text', "sesfbstyle_dashboard_list_background_color_hover", array(
        'label' => 'Dashboard List Background Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesfbstyle_dashboard_list_background_color_hover,
    ));
    
    $this->addElement('Text', "sesfbstyle_dashboard_list_border_color", array(
      'label' => 'Dashboard List Border Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_dashboard_list_border_color,
    ));
    
    $this->addElement('Text', "sesfbstyle_dashboard_font_color", array(
      'label' => 'Dashboard Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_dashboard_font_color,
    ));
    
    $this->addElement('Text', "sesfbstyle_dashboard_link_color", array(
      'label' => 'Dashboard Link Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_dashboard_link_color,
    ));
    $this->addElement('Text', "sesfbstyle_comments_background_color", array(
      'label' => 'Comments Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_comments_background_color,
    ));
		


    $this->addDisplayGroup(array('sesfbstyle_theme_color','sesfbstyle_body_background_color', 'sesfbstyle_font_color', 'sesfbstyle_font_color_light', 'sesfbstyle_links_color', 'sesfbstyle_links_hover_color','sesfbstyle_headline_background_color', 'sesfbstyle_headline_color', 'sesfbstyle_border_color', 'sesfbstyle_box_background_color', 'sesfbstyle_form_label_color', 'sesfbstyle_input_background_color', 'sesfbstyle_input_font_color', 'sesfbstyle_input_border_color', 'sesfbstyle_button_background_color', 'sesfbstyle_button_background_color_hover', 'sesfbstyle_button_font_color', 'sesfbstyle_button_border_color', 'sesfbstyle_dashboard_list_background_color_hover', 'sesfbstyle_dashboard_list_border_color', 'sesfbstyle_dashboard_font_color', 'sesfbstyle_dashboard_link_color', 'sesfbstyle_comments_background_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
    $body_settings_group = $this->getDisplayGroup('body_settings_group');
    $body_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'body_settings_group'))));
    //End Body Styling


		//Landing Page Styling
		    $this->addElement('Dummy', 'lp_settings', array(
        'label' => 'Landing Page Settings',
    ));
		$this->addElement('Text', "sesfbstyle_lp_header_background_color", array(
      'label' => 'Lp Header Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_header_background_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_header_border_color", array(
      'label' => 'Lp Header Border Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_header_border_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_header_input_background_color", array(
      'label' => 'Lp Header Input Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_header_input_background_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_header_input_border_color", array(
      'label' => 'Lp Header Input Border Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_header_input_border_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_header_button_background_color", array(
      'label' => 'Lp Header Button Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_header_button_background_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_header_button_font_color", array(
      'label' => 'Lp Header button Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_header_button_font_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_header_button_hover_color", array(
      'label' => 'Lp Header button Hover Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_header_button_hover_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_header_font_color", array(
      'label' => 'Lp Header Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_header_font_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_header_link_color", array(
      'label' => 'Lp Header Link Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_header_link_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_signup_button_color", array(
      'label' => 'Lp Header Signup Button Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_signup_button_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_signup_button_border_color", array(
      'label' => 'Lp Header Signup Button Border Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_signup_button_border_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_signup_button_font_color", array(
      'label' => 'Lp Header Signup Button Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_signup_button_font_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_signup_button_hover_color", array(
      'label' => 'Lp Header Signup Button Hover Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_signup_button_hover_color,
    ));
		$this->addElement('Text', "sesfbstyle_lp_signup_button_hover_font_color", array(
      'label' => 'Lp Header Signup Button Hover Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sesfbstyle_lp_signup_button_hover_font_color,
    ));
		
		 $this->addDisplayGroup(array('sesfbstyle_lp_header_background_color','sesfbstyle_lp_header_border_color','sesfbstyle_lp_header_input_background_color','sesfbstyle_lp_header_input_border_color','sesfbstyle_lp_header_button_background_color','sesfbstyle_lp_header_button_font_color', 'sesfbstyle_lp_header_button_hover_color','sesfbstyle_lp_header_button_font_color','sesfbstyle_lp_header_button_hover_color','sesfbstyle_lp_header_font_color','sesfbstyle_lp_header_link_color','sesfbstyle_lp_signup_button_color','sesfbstyle_lp_signup_button_border_color','sesfbstyle_lp_signup_button_font_color','sesfbstyle_lp_signup_button_hover_color','sesfbstyle_lp_signup_button_hover_font_color' ), 'lp_settings_group', array('disableLoadDefaultDecorators' => true));
    $lp_settings_group = $this->getDisplayGroup('lp_settings_group');
    $lp_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'lp_settings_group'))));
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