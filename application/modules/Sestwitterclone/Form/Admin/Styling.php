<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestwitterclone_Form_Admin_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $sestwittercloneApi = Engine_Api::_()->sestwitterclone();
    $this->setTitle('Manage Color Schemes')
            ->setDescription('Here, you can manage the color schemes of your website.');

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sestwitterclone/externals/images/color-scheme/1.png" alt="" />',
            2 => '<img src="./application/modules/Sestwitterclone/externals/images/color-scheme/2.png" alt="" />',
            5 => '<img src="./application/modules/Sestwitterclone/externals/images/color-scheme/custom.png" alt="" />',
        ),
        'onclick' => 'changeThemeColor(this.value, "")',
        'escape' => false,
        'value' => $sestwittercloneApi->getContantValueXML('theme_color'),
    ));

    $activatedTheme = $sestwittercloneApi->getContantValueXML('custom_theme_color');

    $customtheme_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('customtheme_id', 0);
    if($customtheme_id) {
      $customtheme_value = $customtheme_id;
    } else {
      $customtheme_value = $sestwittercloneApi->getContantValueXML('custom_theme_color');
    }

    $sestheme = array(
      //5 => 'New Custom',
      1 => 'Theme - 1',
      2 => 'Theme - 2',
    );

    $getCustomThemes = Engine_Api::_()->getDbTable('customthemes', 'sestwitterclone')->getCustomThemes();
    foreach($getCustomThemes as $getCustomTheme){
      $sestheme[$getCustomTheme['customtheme_id']] = $getCustomTheme['name'];
    }

    $this->addElement('Select', 'custom_theme_color', array(
        'label' => 'Custom Theme Color',
        'multiOptions' => $sestheme,
        'onclick' => 'changeCustomThemeColor(this.value)',
        'escape' => false,
        'value' => $customtheme_value, //$sestwittercloneApi->getContantValueXML('custom_theme_color'),
    ));

    $this->addElement('dummy', 'custom_themes', array(
      'decorators' => array(array('ViewScript', array(
        'viewScript' => 'application/modules/Sestwitterclone/views/scripts/custom_themes.tpl',
        'class' => 'form element',
        'customtheme_id' => $customtheme_id,
        'activatedTheme' => $activatedTheme,
      )))
    ));


    $theme_color = $sestwittercloneApi->getContantValueXML('theme_color');
    if($theme_color == '5') {

      $sestwitterclone_header_background_color = $settings->getSetting('sestwitterclone.header.background.color');
      $sestwitterclone_header_border_color = $settings->getSetting('sestwitterclone.header.border.color');
      $sestwitterclone_header_search_background_color = $settings->getSetting('sestwitterclone.header.search.background.color');
      $sestwitterclone_header_search_border_color = $settings->getSetting('sestwitterclone.header.search.border.color');
      $sestwitterclone_header_search_button_background_color = $settings->getSetting('sestwitterclone.header.search.button.background.color');
      $sestwitterclone_header_search_button_font_color = $settings->getSetting('sestwitterclone.header.search.button.font.color');
      $sestwitterclone_mainmenu_search_background_color = $settings->getSetting('sestwitterclone.mainmenu.search.background.color');
      $sestwitterclone_mainmenu_background_color = $settings->getSetting('sestwitterclone.mainmenu.background.color');
      $sestwitterclone_mainmenu_links_color = $settings->getSetting('sestwitterclone.mainmenu.link.color');
      $sestwitterclone_mainmenu_links_hover_color = $settings->getSetting('sestwitterclone.mainmenu.link.hover.color');
      $sestwitterclone_mainmenu_footer_font_color = $settings->getSetting('sestwitterclone.mainmenu.footer.font.color');
      $sestwitterclone_minimenu_links_color = $settings->getSetting('sestwitterclone.minimenu.link.color');
      $sestwitterclone_minimenu_link_active_color = $settings->getSetting('sestwitterclone.minimenu.link.active.color');
      $sestwitterclone_footer_background_color = $settings->getSetting('sestwitterclone.footer.background.color');
      $sestwitterclone_footer_font_color = $settings->getSetting('sestwitterclone.footer.font.color');
      $sestwitterclone_footer_links_color = $settings->getSetting('sestwitterclone.footer.links.color');
      $sestwitterclone_footer_border_color = $settings->getSetting('sestwitterclone.footer.border.color');
      $sestwitterclone_theme_color = $settings->getSetting('sestwitterclone.theme.color');
      $sestwitterclone_body_background_color = $settings->getSetting('sestwitterclone.body.background.color');
      $sestwitterclone_font_color = $settings->getSetting('sestwitterclone.font.color');
      $sestwitterclone_font_color_light = $settings->getSetting('sestwitterclone.font.color.light');
      $sestwitterclone_links_color = $settings->getSetting('sestwitterclone.links.color');
      $sestwitterclone_links_hover_color = $settings->getSetting('sestwitterclone.links.hover.color');
      $sestwitterclone_headline_color = $settings->getSetting('sestwitterclone.headline.color');
      $sestwitterclone_border_color = $settings->getSetting('sestwitterclone.border.color');
      $sestwitterclone_box_background_color = $settings->getSetting('sestwitterclone.box.background.color');
      $sestwitterclone_form_label_color = $settings->getSetting('sestwitterclone.form.label.color');
      $sestwitterclone_input_background_color = $settings->getSetting('sestwitterclone.input.background.color');
      $sestwitterclone_input_font_color = $settings->getSetting('sestwitterclone.input.font.color');
      $sestwitterclone_input_border_color = $settings->getSetting('sestwitterclone.input.border.colors');
      $sestwitterclone_button_background_color = $settings->getSetting('sestwitterclone.button.background.color');
      $sestwitterclone_button_background_color_hover = $settings->getSetting('sestwitterclone.button.background.color.hover');
      $sestwitterclone_button_font_color = $settings->getSetting('sestwitterclone.button.font.color');
      $sestwitterclone_button_border_color = $settings->getSetting('sestwitterclone.button.border.color');
      $sestwitterclone_comments_background_color = $settings->getSetting('sestwitterclone.comments.background.color');
    } else {

      $sestwitterclone_header_background_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_header_background_color');
      $sestwitterclone_header_border_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_header_border_color');
      $sestwitterclone_header_search_background_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_header_search_background_color');
      $sestwitterclone_header_search_border_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_header_search_border_color');
      $sestwitterclone_header_search_button_background_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_header_search_button_background_color');
      $sestwitterclone_header_search_button_font_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_header_search_button_font_color');
      $sestwitterclone_mainmenu_search_background_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_mainmenu_search_background_color');
      $sestwitterclone_mainmenu_background_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_mainmenu_background_color');
      $sestwitterclone_mainmenu_links_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_mainmenu_links_color');
      $sestwitterclone_mainmenu_links_hover_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_mainmenu_links_hover_color');
      $sestwitterclone_mainmenu_footer_font_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_mainmenu_footer_font_color');
      $sestwitterclone_minimenu_links_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_minimenu_links_color');
      $sestwitterclone_minimenu_link_active_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_minimenu_link_active_color');
      $sestwitterclone_footer_background_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_footer_background_color');
      $sestwitterclone_footer_font_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_footer_font_color');
      $sestwitterclone_footer_links_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_footer_links_color');
      $sestwitterclone_footer_border_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_footer_border_color');
      $sestwitterclone_theme_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_theme_color');
      $sestwitterclone_body_background_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_body_background_color');
      $sestwitterclone_font_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_font_color');
      $sestwitterclone_font_color_light = $sestwittercloneApi->getContantValueXML('sestwitterclone_font_color_light');
      $sestwitterclone_links_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_links_color');
      $sestwitterclone_links_hover_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_links_hover_color');
      $sestwitterclone_headline_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_headline_color');
      $sestwitterclone_border_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_border_color');
      $sestwitterclone_box_background_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_box_background_color');
      $sestwitterclone_form_label_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_form_label_color');
      $sestwitterclone_input_background_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_input_background_color');
      $sestwitterclone_input_font_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_input_font_color');
      $sestwitterclone_input_border_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_input_border_color');
      $sestwitterclone_button_background_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_button_background_color');
      $sestwitterclone_button_background_color_hover = $sestwittercloneApi->getContantValueXML('sestwitterclone_button_background_color_hover');
      $sestwitterclone_button_font_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_button_font_color');
      $sestwitterclone_button_border_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_button_border_color');
      $sestwitterclone_comments_background_color = $sestwittercloneApi->getContantValueXML('sestwitterclone_comments_background_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "sestwitterclone_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_header_background_color,
    ));

    $this->addElement('Text', "sestwitterclone_header_border_color", array(
      'label' => 'Header Border Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sestwitterclone_header_border_color,
    ));

    $this->addElement('Text', "sestwitterclone_header_search_background_color", array(
      'label' => 'Header Search Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sestwitterclone_header_search_background_color,
    ));

    $this->addElement('Text', "sestwitterclone_header_search_border_color", array(
      'label' => 'Header Search Border Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sestwitterclone_header_search_border_color,
    ));


    $this->addElement('Text', "sestwitterclone_header_search_button_background_color", array(
      'label' => 'Header Search Button Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sestwitterclone_header_search_button_background_color,
    ));

    $this->addElement('Text', "sestwitterclone_header_search_button_font_color", array(
      'label' => 'Header Search Button Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sestwitterclone_header_search_button_font_color,
    ));

    $this->addElement('Text', "sestwitterclone_mainmenu_search_background_color", array(
      'label' => 'Mini Menu Search Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sestwitterclone_mainmenu_search_background_color,
    ));

    $this->addElement('Text', "sestwitterclone_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_mainmenu_background_color,
    ));

    $this->addElement('Text', "sestwitterclone_mainmenu_links_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_mainmenu_links_color,
    ));

    $this->addElement('Text', "sestwitterclone_mainmenu_links_hover_color", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_mainmenu_links_hover_color,
    ));

    $this->addElement('Text', "sestwitterclone_mainmenu_footer_font_color", array(
        'label' => 'Main Menu Footer Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_mainmenu_footer_font_color,
    ));


    $this->addElement('Text', "sestwitterclone_minimenu_links_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_minimenu_links_color,
    ));

    $this->addElement('Text', "sestwitterclone_minimenu_link_active_color", array(
        'label' => 'Mini Menu Link Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_minimenu_link_active_color,
    ));


    $this->addDisplayGroup(array('sestwitterclone_header_background_color', 'sestwitterclone_header_border_color', 'sestwitterclone_header_search_background_color', 'sestwitterclone_header_search_border_color', 'sestwitterclone_header_search_button_background_color', 'sestwitterclone_header_search_button_font_color', 'sestwitterclone_mainmenu_search_background_color', 'sestwitterclone_mainmenu_background_color', 'sestwitterclone_mainmenu_links_color', 'sestwitterclone_mainmenu_links_hover_color',  'sestwitterclone_mainmenu_footer_font_color', 'sestwitterclone_minimenu_links_color', 'sestwitterclone_minimenu_link_active_color'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling

    //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "sestwitterclone_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_footer_background_color,
    ));

    $this->addElement('Text', "sestwitterclone_footer_font_color", array(
        'label' => 'Footer Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_footer_font_color,
    ));

    $this->addElement('Text', "sestwitterclone_footer_links_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_footer_links_color,
    ));

    $this->addElement('Text', "sestwitterclone_footer_border_color", array(
        'label' => 'Footer Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_footer_border_color,
    ));
    $this->addDisplayGroup(array('sestwitterclone_footer_background_color', 'sestwitterclone_footer_font_color', 'sestwitterclone_footer_links_color', 'sestwitterclone_footer_border_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    //End Footer Styling

    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "sestwitterclone_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_theme_color,
    ));

    $this->addElement('Text', "sestwitterclone_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_body_background_color,
    ));

    $this->addElement('Text', "sestwitterclone_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_font_color,
    ));

    $this->addElement('Text', "sestwitterclone_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_font_color_light,
    ));

    $this->addElement('Text', "sestwitterclone_links_color", array(
      'label' => 'Link Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sestwitterclone_links_color,
    ));

    $this->addElement('Text', "sestwitterclone_links_hover_color", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_links_hover_color,
    ));

    $this->addElement('Text', "sestwitterclone_headline_color", array(
        'label' => 'Headline Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_headline_color,
    ));

    $this->addElement('Text', "sestwitterclone_border_color", array(
        'label' => 'Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_border_color,
    ));
    $this->addElement('Text', "sestwitterclone_box_background_color", array(
        'label' => 'Box Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_box_background_color,
    ));

    $this->addElement('Text', "sestwitterclone_form_label_color", array(
        'label' => 'Form Label Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_form_label_color,
    ));

    $this->addElement('Text', "sestwitterclone_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_input_background_color,
    ));

    $this->addElement('Text', "sestwitterclone_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_input_font_color,
    ));

    $this->addElement('Text', "sestwitterclone_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_input_border_color,
    ));

    $this->addElement('Text', "sestwitterclone_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_button_background_color,
    ));
    $this->addElement('Text', "sestwitterclone_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_button_background_color_hover,
    ));

    $this->addElement('Text', "sestwitterclone_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_button_font_color,
    ));
    $this->addElement('Text', "sestwitterclone_button_border_color", array(
        'label' => 'Button Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sestwitterclone_button_border_color,
    ));
    $this->addElement('Text', "sestwitterclone_comments_background_color", array(
      'label' => 'Comments Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $sestwitterclone_comments_background_color,
    ));



    $this->addDisplayGroup(array('sestwitterclone_theme_color','sestwitterclone_body_background_color', 'sestwitterclone_font_color', 'sestwitterclone_font_color_light', 'sestwitterclone_links_color', 'sestwitterclone_links_hover_color','sestwitterclone_headline_color', 'sestwitterclone_border_color', 'sestwitterclone_box_background_color', 'sestwitterclone_form_label_color', 'sestwitterclone_input_background_color', 'sestwitterclone_input_font_color', 'sestwitterclone_input_border_color', 'sestwitterclone_button_background_color', 'sestwitterclone_button_background_color_hover', 'sestwitterclone_button_font_color', 'sestwitterclone_button_border_color', 'sestwitterclone_dashboard_list_background_color_hover', 'sestwitterclone_dashboard_list_border_color', 'sestwitterclone_dashboard_font_color', 'sestwitterclone_dashboard_link_color', 'sestwitterclone_comments_background_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
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
