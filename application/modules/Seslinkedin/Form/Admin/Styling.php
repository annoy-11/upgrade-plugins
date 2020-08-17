<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslinkedin_Form_Admin_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $seslinkedinApi = Engine_Api::_()->seslinkedin();
    $this->setTitle('Manage Color Schemes')
            ->setDescription('Here, you can manage the color schemes of your website.');

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Seslinkedin/externals/images/color-scheme/1.png" alt="" />',
            2 => '<img src="./application/modules/Seslinkedin/externals/images/color-scheme/2.png" alt="" />',
						5 => '<img src="./application/modules/Seslinkedin/externals/images/color-scheme/custom.png" alt="" />',
        ),
        'onclick' => 'changeThemeColor(this.value, "")',
        'escape' => false,
        'value' => $seslinkedinApi->getContantValueXML('theme_color'),
    ));

    $activatedTheme = $seslinkedinApi->getContantValueXML('custom_theme_color');

    $customtheme_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('customtheme_id', 0);
    if($customtheme_id) {
      $customtheme_value = $customtheme_id;
    } else {
      $customtheme_value = $seslinkedinApi->getContantValueXML('custom_theme_color');
    }

    $sestheme = array(
      //5 => 'New Custom',
      1 => 'Theme - 1',
      2 => 'Theme - 2',
    );

    $getCustomThemes = Engine_Api::_()->getDbTable('customthemes', 'seslinkedin')->getCustomThemes();
    foreach($getCustomThemes as $getCustomTheme){
      $sestheme[$getCustomTheme['customtheme_id']] = $getCustomTheme['name'];
    }

    $this->addElement('Select', 'custom_theme_color', array(
        'label' => 'Custom Theme Color',
        'multiOptions' => $sestheme,
        'onclick' => 'changeCustomThemeColor(this.value)',
        'escape' => false,
        'value' => $customtheme_value, //$seslinkedinApi->getContantValueXML('custom_theme_color'),
    ));

    $this->addElement('dummy', 'custom_themes', array(
      'decorators' => array(array('ViewScript', array(
        'viewScript' => 'application/modules/Seslinkedin/views/scripts/custom_themes.tpl',
        'class' => 'form element',
        'customtheme_id' => $customtheme_id,
        'activatedTheme' => $activatedTheme,
      )))
    ));


    $theme_color = $seslinkedinApi->getContantValueXML('theme_color');
    if($theme_color == '5') {

      $seslinkedin_header_background_color = $settings->getSetting('seslinkedin.header.background.color');
      $seslinkedin_header_search_background_color = $settings->getSetting('seslinkedin.header.search.background.color');
      $seslinkedin_header_search_button_font_color = $settings->getSetting('seslinkedin.header.search.button.font.color');
      $seslinkedin_header_font_color = $settings->getSetting('seslinkedin.header.font.color');
      $seslinkedin_mainmenu_search_background_color = $settings->getSetting('seslinkedin.mainmenu.search.background.color');
      $seslinkedin_mainmenu_background_color = $settings->getSetting('seslinkedin.mainmenu.background.color');
      $seslinkedin_mainmenu_links_color = $settings->getSetting('seslinkedin.mainmenu.link.color');
      $seslinkedin_mainmenu_links_hover_color = $settings->getSetting('seslinkedin.mainmenu.link.hover.color');
      $seslinkedin_mainmenu_footer_font_color = $settings->getSetting('seslinkedin.mainmenu.footer.font.color');
      $seslinkedin_minimenu_links_color = $settings->getSetting('seslinkedin.minimenu.link.color');
      $seslinkedin_minimenu_link_active_color = $settings->getSetting('seslinkedin.minimenu.link.active.color');
      $seslinkedin_header_icons_type = $settings->getSetting('seslinkedin.header.icons.type');
      $seslinkedin_footer_background_color = $settings->getSetting('seslinkedin.footer.background.color');
      $seslinkedin_footer_font_color = $settings->getSetting('seslinkedin.footer.font.color');
      $seslinkedin_footer_links_color = $settings->getSetting('seslinkedin.footer.links.color');
      $seslinkedin_footer_border_color = $settings->getSetting('seslinkedin.footer.border.color');
      $seslinkedin_theme_color = $settings->getSetting('seslinkedin.theme.color');
      $seslinkedin_body_background_color = $settings->getSetting('seslinkedin.body.background.color');
      $seslinkedin_font_color = $settings->getSetting('seslinkedin.font.color');
      $seslinkedin_font_color_light = $settings->getSetting('seslinkedin.font.color.light');
      $seslinkedin_links_color = $settings->getSetting('seslinkedin.links.color');
      $seslinkedin_links_hover_color = $settings->getSetting('seslinkedin.links.hover.color');
      $seslinkedin_headline_color = $settings->getSetting('seslinkedin.headline.color');
      $seslinkedin_border_color = $settings->getSetting('seslinkedin.border.color');
      $seslinkedin_box_background_color = $settings->getSetting('seslinkedin.box.background.color');
      $seslinkedin_form_label_color = $settings->getSetting('seslinkedin.form.label.color');
      $seslinkedin_input_background_color = $settings->getSetting('seslinkedin.input.background.color');
      $seslinkedin_input_font_color = $settings->getSetting('seslinkedin.input.font.color');
      $seslinkedin_input_border_color = $settings->getSetting('seslinkedin.input.border.colors');
      $seslinkedin_button_background_color = $settings->getSetting('seslinkedin.button.background.color');
      $seslinkedin_button_background_color_hover = $settings->getSetting('seslinkedin.button.background.color.hover');
      $seslinkedin_button_font_color = $settings->getSetting('seslinkedin.button.font.color');
      $seslinkedin_button_border_color = $settings->getSetting('seslinkedin.button.border.color');
        $seslinkedin_lp_header_background_color = $settings->getSetting('seslinkedin.lp.header.background.color');
        $seslinkedin_lp_header_input_background_color = $settings->getSetting('seslinkedin.lp.header.input.background.color');
        $seslinkedin_lp_header_input_border_color = $settings->getSetting('seslinkedin.lp.header.input.border.color');
        $seslinkedin_lp_header_button_background_color = $settings->getSetting('seslinkedin.lp.header.button.background.color');
        $seslinkedin_lp_header_button_font_color = $settings->getSetting('seslinkedin.lp.header.button.font.color');
        $seslinkedin_lp_header_button_hover_color = $settings->getSetting('seslinkedin.lp.header.button.hover.color');
        $seslinkedin_lp_header_font_color = $settings->getSetting('seslinkedin.lp.header.font.color');
        $seslinkedin_lp_header_link_color = $settings->getSetting('seslinkedin.lp.header.link.color');
        $seslinkedin_lp_signup_button_color = $settings->getSetting('seslinkedin.lp.signup.button.color');
        $seslinkedin_lp_signup_button_border_color = $settings->getSetting('seslinkedin.lp.signup.button.border.color');
        $seslinkedin_lp_signup_button_font_color = $settings->getSetting('seslinkedin.lp.signup.button.font.color');
        $seslinkedin_lp_signup_button_hover_color = $settings->getSetting('seslinkedin.lp.signup.button.hover.color');
        $seslinkedin_lp_signup_button_hover_font_color = $settings->getSetting('seslinkedin.lp.signup.button.hover.font.color');

    } else {

      $seslinkedin_header_background_color = $seslinkedinApi->getContantValueXML('seslinkedin_header_background_color');
      $seslinkedin_header_search_background_color = $seslinkedinApi->getContantValueXML('seslinkedin_header_search_background_color');
      $seslinkedin_header_search_button_font_color = $seslinkedinApi->getContantValueXML('seslinkedin_header_search_button_font_color');
      $seslinkedin_header_font_color = $seslinkedinApi->getContantValueXML('seslinkedin_header_font_color');
      $seslinkedin_mainmenu_search_background_color = $seslinkedinApi->getContantValueXML('seslinkedin_mainmenu_search_background_color');
      $seslinkedin_mainmenu_background_color = $seslinkedinApi->getContantValueXML('seslinkedin_mainmenu_background_color');
      $seslinkedin_mainmenu_links_color = $seslinkedinApi->getContantValueXML('seslinkedin_mainmenu_links_color');
      $seslinkedin_mainmenu_links_hover_color = $seslinkedinApi->getContantValueXML('seslinkedin_mainmenu_links_hover_color');
      $seslinkedin_mainmenu_footer_font_color = $seslinkedinApi->getContantValueXML('seslinkedin_mainmenu_footer_font_color');
      $seslinkedin_minimenu_links_color = $seslinkedinApi->getContantValueXML('seslinkedin_minimenu_links_color');
      $seslinkedin_minimenu_link_active_color = $seslinkedinApi->getContantValueXML('seslinkedin_minimenu_link_active_color');
      $seslinkedin_header_icons_type = $seslinkedinApi->getContantValueXML('seslinkedin_header_icons_type');
      $seslinkedin_footer_background_color = $seslinkedinApi->getContantValueXML('seslinkedin_footer_background_color');
      $seslinkedin_footer_font_color = $seslinkedinApi->getContantValueXML('seslinkedin_footer_font_color');
      $seslinkedin_footer_links_color = $seslinkedinApi->getContantValueXML('seslinkedin_footer_links_color');
      $seslinkedin_footer_border_color = $seslinkedinApi->getContantValueXML('seslinkedin_footer_border_color');
      $seslinkedin_theme_color = $seslinkedinApi->getContantValueXML('seslinkedin_theme_color');
      $seslinkedin_body_background_color = $seslinkedinApi->getContantValueXML('seslinkedin_body_background_color');
      $seslinkedin_font_color = $seslinkedinApi->getContantValueXML('seslinkedin_font_color');
      $seslinkedin_font_color_light = $seslinkedinApi->getContantValueXML('seslinkedin_font_color_light');
      $seslinkedin_links_color = $seslinkedinApi->getContantValueXML('seslinkedin_links_color');
      $seslinkedin_links_hover_color = $seslinkedinApi->getContantValueXML('seslinkedin_links_hover_color');
      $seslinkedin_headline_color = $seslinkedinApi->getContantValueXML('seslinkedin_headline_color');
      $seslinkedin_border_color = $seslinkedinApi->getContantValueXML('seslinkedin_border_color');
      $seslinkedin_box_background_color = $seslinkedinApi->getContantValueXML('seslinkedin_box_background_color');
      $seslinkedin_form_label_color = $seslinkedinApi->getContantValueXML('seslinkedin_form_label_color');
      $seslinkedin_input_background_color = $seslinkedinApi->getContantValueXML('seslinkedin_input_background_color');
      $seslinkedin_input_font_color = $seslinkedinApi->getContantValueXML('seslinkedin_input_font_color');
      $seslinkedin_input_border_color = $seslinkedinApi->getContantValueXML('seslinkedin_input_border_color');
      $seslinkedin_button_background_color = $seslinkedinApi->getContantValueXML('seslinkedin_button_background_color');
      $seslinkedin_button_background_color_hover = $seslinkedinApi->getContantValueXML('seslinkedin_button_background_color_hover');
      $seslinkedin_button_font_color = $seslinkedinApi->getContantValueXML('seslinkedin_button_font_color');
      $seslinkedin_button_border_color = $seslinkedinApi->getContantValueXML('seslinkedin_button_border_color');
      $seslinkedin_lp_header_link_color = $settings->getSetting('seslinkedin_lp_header_link_color');
      $seslinkedin_lp_signup_button_color = $settings->getSetting('seslinkedin_lp_signup_button_color');
      $seslinkedin_lp_signup_button_border_color = $settings->getSetting('seslinkedin_lp_signup_button_border_color');
      $seslinkedin_lp_signup_button_font_color = $settings->getSetting('seslinkedin_lp_signup_button_font_color');
      $seslinkedin_lp_signup_button_hover_color = $settings->getSetting('seslinkedin_lp_signup_button_hover_color');
      $seslinkedin_lp_signup_button_hover_font_color = $settings->getSetting('seslinkedin_lp_signup_button_hover_font_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "seslinkedin_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_header_background_color,
    ));


    $this->addElement('Text', "seslinkedin_header_search_background_color", array(
      'label' => 'Header Search Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $seslinkedin_header_search_background_color,
    ));


    $this->addElement('Text', "seslinkedin_header_search_button_font_color", array(
      'label' => 'Header Search Button Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $seslinkedin_header_search_button_font_color,
    ));

    $this->addElement('Text', "seslinkedin_header_font_color", array(
      'label' => 'Header Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $seslinkedin_header_font_color,
    ));

    $this->addElement('Text', "seslinkedin_mainmenu_search_background_color", array(
      'label' => 'Mini Menu Search Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $seslinkedin_mainmenu_search_background_color,
    ));

    $this->addElement('Text', "seslinkedin_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_mainmenu_background_color,
    ));

    $this->addElement('Text', "seslinkedin_mainmenu_links_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_mainmenu_links_color,
    ));

    $this->addElement('Text', "seslinkedin_mainmenu_links_hover_color", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_mainmenu_links_hover_color,
    ));

    $this->addElement('Text', "seslinkedin_mainmenu_footer_font_color", array(
        'label' => 'Main Menu Footer Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_mainmenu_footer_font_color,
    ));


    $this->addElement('Text', "seslinkedin_minimenu_links_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_minimenu_links_color,
    ));

    $this->addElement('Text', "seslinkedin_minimenu_link_active_color", array(
        'label' => 'Mini Menu Link Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_minimenu_link_active_color,
    ));

    $this->addElement('Select', 'seslinkedin_header_icons_type', array(
      'label' => 'Mini Menu Icon Type',
      'description' => 'Choose mini menu icon type',
      'multiOptions' => array(
        2 => "Dark Icon",
        3 => "Light Icon",
      ),
      'value' => $seslinkedin_header_icons_type,
    ));

    $this->addDisplayGroup(array('seslinkedin_header_background_color', 'seslinkedin_header_border_color', 'seslinkedin_header_search_background_color', 'seslinkedin_header_search_border_color', 'seslinkedin_header_search_button_background_color', 'seslinkedin_header_search_button_font_color', 'seslinkedin_header_font_color', 'seslinkedin_mainmenu_search_background_color', 'seslinkedin_mainmenu_background_color', 'seslinkedin_mainmenu_links_color', 'seslinkedin_mainmenu_links_hover_color',  'seslinkedin_mainmenu_footer_font_color', 'seslinkedin_minimenu_links_color', 'seslinkedin_minimenu_link_active_color', 'seslinkedin_header_icons_type'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling

    //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "seslinkedin_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_footer_background_color,
    ));

    $this->addElement('Text', "seslinkedin_footer_font_color", array(
        'label' => 'Footer Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_footer_font_color,
    ));

    $this->addElement('Text', "seslinkedin_footer_links_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_footer_links_color,
    ));

    $this->addElement('Text', "seslinkedin_footer_border_color", array(
        'label' => 'Footer Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_footer_border_color,
    ));
    $this->addDisplayGroup(array('seslinkedin_footer_background_color', 'seslinkedin_footer_font_color', 'seslinkedin_footer_links_color', 'seslinkedin_footer_border_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    //End Footer Styling

    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "seslinkedin_theme_color", array(
        'label' => 'Body Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_theme_color,
    ));

    $this->addElement('Text', "seslinkedin_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_body_background_color,
    ));

    $this->addElement('Text', "seslinkedin_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_font_color,
    ));

    $this->addElement('Text', "seslinkedin_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_font_color_light,
    ));

    $this->addElement('Text', "seslinkedin_links_color", array(
      'label' => 'Link Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $seslinkedin_links_color,
    ));

    $this->addElement('Text', "seslinkedin_links_hover_color", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_links_hover_color,
    ));

    $this->addElement('Text', "seslinkedin_headline_color", array(
        'label' => 'Headline Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_headline_color,
    ));

    $this->addElement('Text', "seslinkedin_border_color", array(
        'label' => 'Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_border_color,
    ));
    $this->addElement('Text', "seslinkedin_box_background_color", array(
        'label' => 'Box Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_box_background_color,
    ));

    $this->addElement('Text', "seslinkedin_form_label_color", array(
        'label' => 'Form Label Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_form_label_color,
    ));

    $this->addElement('Text', "seslinkedin_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_input_background_color,
    ));

    $this->addElement('Text', "seslinkedin_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_input_font_color,
    ));

    $this->addElement('Text', "seslinkedin_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_input_border_color,
    ));

    $this->addElement('Text', "seslinkedin_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_button_background_color,
    ));
    $this->addElement('Text', "seslinkedin_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_button_background_color_hover,
    ));

    $this->addElement('Text', "seslinkedin_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_button_font_color,
    ));
    $this->addElement('Text', "seslinkedin_button_border_color", array(
        'label' => 'Button Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $seslinkedin_button_border_color,
    ));



    $this->addDisplayGroup(array('seslinkedin_theme_color','seslinkedin_body_background_color', 'seslinkedin_font_color', 'seslinkedin_font_color_light', 'seslinkedin_links_color', 'seslinkedin_links_hover_color','seslinkedin_headline_background_color', 'seslinkedin_headline_color', 'seslinkedin_border_color', 'seslinkedin_box_background_color', 'seslinkedin_form_label_color', 'seslinkedin_input_background_color', 'seslinkedin_input_font_color', 'seslinkedin_input_border_color', 'seslinkedin_button_background_color', 'seslinkedin_button_background_color_hover', 'seslinkedin_button_font_color', 'seslinkedin_button_border_color', 'seslinkedin_dashboard_list_background_color_hover', 'seslinkedin_dashboard_list_border_color', 'seslinkedin_dashboard_font_color', 'seslinkedin_dashboard_link_color', 'seslinkedin_comments_background_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
    $body_settings_group = $this->getDisplayGroup('body_settings_group');
    $body_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'body_settings_group'))));
    //End Body Styling


		//Landing Page Styling
		    $this->addElement('Dummy', 'lp_settings', array(
        'label' => 'Landing Page Settings',
    ));
		$this->addElement('Text', "seslinkedin_lp_header_link_color", array(
      'label' => 'Landing Page Join Now Button Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $seslinkedin_lp_header_link_color,
    ));
		$this->addElement('Text', "seslinkedin_lp_signup_button_color", array(
      'label' => 'Landing Page Header Signin Button Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $seslinkedin_lp_signup_button_color,
    ));
		$this->addElement('Text', "seslinkedin_lp_signup_button_border_color", array(
      'label' => 'Landing Page Header Signin Button Border Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $seslinkedin_lp_signup_button_border_color,
    ));
		$this->addElement('Text', "seslinkedin_lp_signup_button_font_color", array(
      'label' => 'Landing Page Header Signin Button Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $seslinkedin_lp_signup_button_font_color,
    ));
		$this->addElement('Text', "seslinkedin_lp_signup_button_hover_color", array(
      'label' => 'Landing Page Header Signin Button Background Hover Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $seslinkedin_lp_signup_button_hover_color,
    ));
		$this->addElement('Text', "seslinkedin_lp_signup_button_hover_font_color", array(
      'label' => 'Landing Page Header Signin Button Hover Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $seslinkedin_lp_signup_button_hover_font_color,
    ));

		 $this->addDisplayGroup(array('seslinkedin_lp_header_background_color','seslinkedin_lp_header_border_color','seslinkedin_lp_header_input_background_color','seslinkedin_lp_header_input_border_color','seslinkedin_lp_header_button_background_color','seslinkedin_lp_header_button_font_color', 'seslinkedin_lp_header_button_hover_color','seslinkedin_lp_header_button_font_color','seslinkedin_lp_header_button_hover_color','seslinkedin_lp_header_font_color','seslinkedin_lp_header_link_color','seslinkedin_lp_signup_button_color','seslinkedin_lp_signup_button_border_color','seslinkedin_lp_signup_button_font_color','seslinkedin_lp_signup_button_hover_color','seslinkedin_lp_signup_button_hover_font_color' ), 'lp_settings_group', array('disableLoadDefaultDecorators' => true));
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
