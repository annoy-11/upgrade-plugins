<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Styling.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_Form_Admin_Styling extends Engine_Form {

  public function init() {
    $einstaclone_adminmenu = Zend_Registry::isRegistered('einstaclone_adminmenu') ? Zend_Registry::get('einstaclone_adminmenu') : null;
    if($einstaclone_adminmenu) {
    $description = "Here, you can manage the color schemes of your website. <br /><div class='tip'><span>Once you switch color schemes or make any changes to the new color schemes you added, please change the mode of your website from Production to Development. This has to be done everytime, and you can switch to production instantly or as soon you are done configuring the color scheme of your website.</span></div>";
    
    // Decorators
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);
    $this->setTitle('Manage Color Schemes')
        ->setDescription($description);

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $api = Engine_Api::_()->einstaclone();
    
    $customThemes = Engine_Api::_()->getDbTable('customthemes', 'einstaclone')->getCustomThemes(array('all' => 1));
    foreach($customThemes as $customTheme) {
      if(in_array($customTheme['theme_id'], array(1,2,3))) {
        $themeOptions[$customTheme['theme_id']] = '<img src="./application/modules/Einstaclone/externals/images/color-scheme/'.$customTheme['theme_id'].'.png" alt="" />';
      } else {
        $themeOptions[$customTheme['theme_id']] = '<img src="./application/modules/Einstaclone/externals/images/color-scheme/custom.png" alt="" /> <span class="custom_theme_name">'. $customTheme->name.'</span>';
      }
    }

    $this->addElement('Radio', 'theme_color', array(
      'label' => 'Color Schemes',
      'multiOptions' => $themeOptions,
      'onclick' => 'changeThemeColor(this.value, "")',
      'escape' => false,
      'value' => $api->getContantValueXML('theme_color'),
    ));

    $this->addElement('dummy', 'custom_themes', array(
      'decorators' => array(array('ViewScript', array(
        'viewScript' => 'application/modules/Einstaclone/views/scripts/custom_themes.tpl',
        'class' => 'form element',
      )))
    ));
    
    $theme_color = $api->getContantValueXML('theme_color');
    if($theme_color == '5') {

      $einstaclone_header_background_color = $settings->getSetting('einstaclone.header.background.color');
      $einstaclone_header_border_color = $settings->getSetting('einstaclone.header.border.color');
      $einstaclone_header_search_background_color = $settings->getSetting('einstaclone.header.search.background.color');
      $einstaclone_header_search_border_color = $settings->getSetting('einstaclone.header.search.border.color');
      $einstaclone_header_search_button_background_color = $settings->getSetting('einstaclone.header.search.button.background.color');
      $einstaclone_header_search_button_font_color = $settings->getSetting('einstaclone.header.search.button.font.color');
      $einstaclone_mainmenu_search_background_color = $settings->getSetting('einstaclone.mainmenu.search.background.color');
      $einstaclone_mainmenu_background_color = $settings->getSetting('einstaclone.mainmenu.background.color');
      $einstaclone_mainmenu_links_color = $settings->getSetting('einstaclone.mainmenu.link.color');
      $einstaclone_mainmenu_links_hover_color = $settings->getSetting('einstaclone.mainmenu.link.hover.color');
      $einstaclone_mainmenu_footer_font_color = $settings->getSetting('einstaclone.mainmenu.footer.font.color');
      $einstaclone_minimenu_links_color = $settings->getSetting('einstaclone.minimenu.link.color');
      $einstaclone_minimenu_link_active_color = $settings->getSetting('einstaclone.minimenu.link.active.color');
      $einstaclone_footer_background_color = $settings->getSetting('einstaclone.footer.background.color');
      $einstaclone_footer_font_color = $settings->getSetting('einstaclone.footer.font.color');
      $einstaclone_footer_links_color = $settings->getSetting('einstaclone.footer.links.color');
      $einstaclone_footer_border_color = $settings->getSetting('einstaclone.footer.border.color');
      $einstaclone_theme_color = $settings->getSetting('einstaclone.theme.color');
      $einstaclone_body_background_color = $settings->getSetting('einstaclone.body.background.color');
      $einstaclone_font_color = $settings->getSetting('einstaclone.font.color');
      $einstaclone_font_color_light = $settings->getSetting('einstaclone.font.color.light');
      $einstaclone_links_color = $settings->getSetting('einstaclone.links.color');
      $einstaclone_links_hover_color = $settings->getSetting('einstaclone.links.hover.color');
      $einstaclone_headline_color = $settings->getSetting('einstaclone.headline.color');
      $einstaclone_border_color = $settings->getSetting('einstaclone.border.color');
      $einstaclone_box_background_color = $settings->getSetting('einstaclone.box.background.color');
      $einstaclone_form_label_color = $settings->getSetting('einstaclone.form.label.color');
      $einstaclone_input_background_color = $settings->getSetting('einstaclone.input.background.color');
      $einstaclone_input_font_color = $settings->getSetting('einstaclone.input.font.color');
      $einstaclone_input_border_color = $settings->getSetting('einstaclone.input.border.colors');
      $einstaclone_button_background_color = $settings->getSetting('einstaclone.button.background.color');
      $einstaclone_button_background_color_hover = $settings->getSetting('einstaclone.button.background.color.hover');
      $einstaclone_button_font_color = $settings->getSetting('einstaclone.button.font.color');
      $einstaclone_button_border_color = $settings->getSetting('einstaclone.button.border.color');
      $einstaclone_comments_background_color = $settings->getSetting('einstaclone.comments.background.color');
    } else {

      $einstaclone_header_background_color = $api->getContantValueXML('einstaclone_header_background_color');
      $einstaclone_header_border_color = $api->getContantValueXML('einstaclone_header_border_color');
      $einstaclone_header_search_background_color = $api->getContantValueXML('einstaclone_header_search_background_color');
      $einstaclone_header_search_border_color = $api->getContantValueXML('einstaclone_header_search_border_color');
      $einstaclone_header_search_button_background_color = $api->getContantValueXML('einstaclone_header_search_button_background_color');
      $einstaclone_header_search_button_font_color = $api->getContantValueXML('einstaclone_header_search_button_font_color');
      $einstaclone_mainmenu_search_background_color = $api->getContantValueXML('einstaclone_mainmenu_search_background_color');
      $einstaclone_mainmenu_background_color = $api->getContantValueXML('einstaclone_mainmenu_background_color');
      $einstaclone_mainmenu_links_color = $api->getContantValueXML('einstaclone_mainmenu_links_color');
      $einstaclone_mainmenu_links_hover_color = $api->getContantValueXML('einstaclone_mainmenu_links_hover_color');
      $einstaclone_mainmenu_footer_font_color = $api->getContantValueXML('einstaclone_mainmenu_footer_font_color');
      $einstaclone_minimenu_links_color = $api->getContantValueXML('einstaclone_minimenu_links_color');
      $einstaclone_minimenu_link_active_color = $api->getContantValueXML('einstaclone_minimenu_link_active_color');
      $einstaclone_footer_background_color = $api->getContantValueXML('einstaclone_footer_background_color');
      $einstaclone_footer_font_color = $api->getContantValueXML('einstaclone_footer_font_color');
      $einstaclone_footer_links_color = $api->getContantValueXML('einstaclone_footer_links_color');
      $einstaclone_footer_border_color = $api->getContantValueXML('einstaclone_footer_border_color');
      $einstaclone_theme_color = $api->getContantValueXML('einstaclone_theme_color');
      $einstaclone_body_background_color = $api->getContantValueXML('einstaclone_body_background_color');
      $einstaclone_font_color = $api->getContantValueXML('einstaclone_font_color');
      $einstaclone_font_color_light = $api->getContantValueXML('einstaclone_font_color_light');
      $einstaclone_links_color = $api->getContantValueXML('einstaclone_links_color');
      $einstaclone_links_hover_color = $api->getContantValueXML('einstaclone_links_hover_color');
      $einstaclone_headline_color = $api->getContantValueXML('einstaclone_headline_color');
      $einstaclone_border_color = $api->getContantValueXML('einstaclone_border_color');
      $einstaclone_box_background_color = $api->getContantValueXML('einstaclone_box_background_color');
      $einstaclone_form_label_color = $api->getContantValueXML('einstaclone_form_label_color');
      $einstaclone_input_background_color = $api->getContantValueXML('einstaclone_input_background_color');
      $einstaclone_input_font_color = $api->getContantValueXML('einstaclone_input_font_color');
      $einstaclone_input_border_color = $api->getContantValueXML('einstaclone_input_border_color');
      $einstaclone_button_background_color = $api->getContantValueXML('einstaclone_button_background_color');
      $einstaclone_button_background_color_hover = $api->getContantValueXML('einstaclone_button_background_color_hover');
      $einstaclone_button_font_color = $api->getContantValueXML('einstaclone_button_font_color');
      $einstaclone_button_border_color = $api->getContantValueXML('einstaclone_button_border_color');
      $einstaclone_comments_background_color = $api->getContantValueXML('einstaclone_comments_background_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "einstaclone_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_header_background_color,
    ));

    $this->addElement('Text', "einstaclone_header_border_color", array(
      'label' => 'Header Border Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $einstaclone_header_border_color,
    ));

    $this->addElement('Text', "einstaclone_header_search_background_color", array(
      'label' => 'Header Search Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $einstaclone_header_search_background_color,
    ));

    $this->addElement('Text', "einstaclone_header_search_border_color", array(
      'label' => 'Header Search Border Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $einstaclone_header_search_border_color,
    ));


    $this->addElement('Text', "einstaclone_header_search_button_background_color", array(
      'label' => 'Header Search Button Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $einstaclone_header_search_button_background_color,
    ));

    $this->addElement('Text', "einstaclone_header_search_button_font_color", array(
      'label' => 'Header Search Button Font Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $einstaclone_header_search_button_font_color,
    ));

    $this->addElement('Text', "einstaclone_mainmenu_search_background_color", array(
      'label' => 'Mini Menu Search Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $einstaclone_mainmenu_search_background_color,
    ));

    $this->addElement('Text', "einstaclone_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_mainmenu_background_color,
    ));

    $this->addElement('Text', "einstaclone_mainmenu_links_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_mainmenu_links_color,
    ));

    $this->addElement('Text', "einstaclone_mainmenu_links_hover_color", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_mainmenu_links_hover_color,
    ));

    $this->addElement('Text', "einstaclone_mainmenu_footer_font_color", array(
        'label' => 'Main Menu Footer Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_mainmenu_footer_font_color,
    ));


    $this->addElement('Text', "einstaclone_minimenu_links_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_minimenu_links_color,
    ));

    $this->addElement('Text', "einstaclone_minimenu_link_active_color", array(
        'label' => 'Mini Menu Link Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_minimenu_link_active_color,
    ));


    $this->addDisplayGroup(array('einstaclone_header_background_color', 'einstaclone_header_border_color', 'einstaclone_header_search_background_color', 'einstaclone_header_search_border_color', 'einstaclone_header_search_button_background_color', 'einstaclone_header_search_button_font_color', 'einstaclone_mainmenu_search_background_color', 'einstaclone_mainmenu_background_color', 'einstaclone_mainmenu_links_color', 'einstaclone_mainmenu_links_hover_color',  'einstaclone_mainmenu_footer_font_color', 'einstaclone_minimenu_links_color', 'einstaclone_minimenu_link_active_color'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling

    //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "einstaclone_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_footer_background_color,
    ));

    $this->addElement('Text', "einstaclone_footer_font_color", array(
        'label' => 'Footer Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_footer_font_color,
    ));

    $this->addElement('Text', "einstaclone_footer_links_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_footer_links_color,
    ));

    $this->addElement('Text', "einstaclone_footer_border_color", array(
        'label' => 'Footer Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_footer_border_color,
    ));
    $this->addDisplayGroup(array('einstaclone_footer_background_color', 'einstaclone_footer_font_color', 'einstaclone_footer_links_color', 'einstaclone_footer_border_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    //End Footer Styling

    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "einstaclone_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_theme_color,
    ));

    $this->addElement('Text', "einstaclone_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_body_background_color,
    ));

    $this->addElement('Text', "einstaclone_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_font_color,
    ));

    $this->addElement('Text', "einstaclone_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_font_color_light,
    ));

    $this->addElement('Text', "einstaclone_links_color", array(
      'label' => 'Link Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $einstaclone_links_color,
    ));

    $this->addElement('Text', "einstaclone_links_hover_color", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_links_hover_color,
    ));

    $this->addElement('Text', "einstaclone_headline_color", array(
        'label' => 'Headline Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_headline_color,
    ));

    $this->addElement('Text', "einstaclone_border_color", array(
        'label' => 'Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_border_color,
    ));
    $this->addElement('Text', "einstaclone_box_background_color", array(
        'label' => 'Box Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_box_background_color,
    ));

    $this->addElement('Text', "einstaclone_form_label_color", array(
        'label' => 'Form Label Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_form_label_color,
    ));

    $this->addElement('Text', "einstaclone_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_input_background_color,
    ));

    $this->addElement('Text', "einstaclone_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_input_font_color,
    ));

    $this->addElement('Text', "einstaclone_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_input_border_color,
    ));

    $this->addElement('Text', "einstaclone_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_button_background_color,
    ));
    $this->addElement('Text', "einstaclone_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_button_background_color_hover,
    ));

    $this->addElement('Text', "einstaclone_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_button_font_color,
    ));
    $this->addElement('Text', "einstaclone_button_border_color", array(
        'label' => 'Button Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $einstaclone_button_border_color,
    ));
    $this->addElement('Text', "einstaclone_comments_background_color", array(
      'label' => 'Comments Background Color',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $einstaclone_comments_background_color,
    ));

    $this->addDisplayGroup(array('einstaclone_theme_color','einstaclone_body_background_color', 'einstaclone_font_color', 'einstaclone_font_color_light', 'einstaclone_links_color', 'einstaclone_links_hover_color','einstaclone_headline_color', 'einstaclone_border_color', 'einstaclone_box_background_color', 'einstaclone_form_label_color', 'einstaclone_input_background_color', 'einstaclone_input_font_color', 'einstaclone_input_border_color', 'einstaclone_button_background_color', 'einstaclone_button_background_color_hover', 'einstaclone_button_font_color', 'einstaclone_button_border_color', 'einstaclone_dashboard_list_background_color_hover', 'einstaclone_dashboard_list_border_color', 'einstaclone_dashboard_font_color', 'einstaclone_dashboard_link_color', 'einstaclone_comments_background_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
    $body_settings_group = $this->getDisplayGroup('body_settings_group');
    $body_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'body_settings_group'))));
    //End Body Styling
    }
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
