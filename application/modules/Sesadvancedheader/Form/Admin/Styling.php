<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesadvancedheader_Form_Admin_Styling extends Engine_Form {

  public function init() {
  
    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $sesadvheaderApi = Engine_Api::_()->sesadvancedheader();
    
    $this->setTitle('Manage Color Schemes')
        ->setDescription('Here, you can manage the color schemes of your website.');
    
    $getActivatedHeader = $settings->getSetting('sesadvancedheaderheader.color',1);
    $customActivatedHeader = $settings->getSetting('sesadvancedheadercustom.header.color',1);
    
    $customheader_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('customheader_id', 0);
    if($customheader_id) {
      $customheader_value = $customheader_id;
    } else if($getActivatedHeader == 5) {
      $customheader_value = $customActivatedHeader;
    } else {
      $customheader_value = $getActivatedHeader;  
    }
    
    if($getActivatedHeader != 5){
      $customActivatedHeader = $getActivatedHeader;  
    }
    
    $sesadvancedheaderheader = Engine_Api::_()->getDbTable('customheaders','sesadvancedheader')->getHeaderKey(array('header_id'=>$customActivatedHeader,'is_custom'=>1));
    if(count($sesadvancedheaderheader))
      $sesadvancedheaderheader = $sesadvancedheaderheader->toArray();
    else
      $sesadvancedheaderheader = array();
      
    $this->addElement('Radio', 'header_color', array(
      'label' => 'Color Schemes',
      'multiOptions' => array(
        1 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/1.png" alt="" />',
        2 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/2.png" alt="" />',
        3 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/3.png" alt="" />',
        4 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/4.png" alt="" />',
        6 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/5.png" alt="" />',
        7 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/6.png" alt="" />',
				8 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/7.png" alt="" />',
				9 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/8.png" alt="" />',
				10 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/9.png" alt="" />',
				11 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/10.png" alt="" />',
				12 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/11.png" alt="" />',
				13 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/12.png" alt="" />',
				14 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/13.png" alt="" />',
				15 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/14.png" alt="" />',
				16 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/15.png" alt="" />',
        5 => '<img src="./application/modules/Sesadvancedheader/externals/images/header-scheme/custom.png" alt="" />',
      ),
      'required'=>true,
      'allowEmpty'=>false,
      'onchange' => 'changeCustomHeaderColor(this.value, "")',
      'escape' => false,
      'value' => $getActivatedHeader,
    ));

    $sesheader = array();
    $getCustomHeaders = Engine_Api::_()->getDbTable('headers', 'sesadvancedheader')->getHeader();
    foreach($getCustomHeaders as $getCustomHeader){
      $sesheader[$getCustomHeader['header_id']] = $getCustomHeader['name'];
    }

    $this->addElement('Select', 'custom_header_color', array(
      'label' => 'Custom Header Color',
      'multiOptions' => $sesheader,
      'required'=>true,
      'allowEmpty'=>false,
      'onChange' => 'changeCustomHeaderColor(this.value)',
      'escape' => false,
      'value' => $customheader_value, //$sesarianaApi->getHeaderKeyValue('custom_header_color'),
    ));

    $this->addElement('dummy', 'custom_headers', array(
      'decorators' => array(array('ViewScript', array(
        'viewScript' => 'application/modules/Sesadvancedheader/views/scripts/custom_headers.tpl',
        'class' => 'form element',
        'customheader_id' => $customheader_id,
        'activatedHeader' => $customActivatedHeader,
      )))
    ));
      
    $sesadvheader_header_background_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_header_background_color',$sesadvancedheaderheader);
    $sesadvheader_font_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_font_color',$sesadvancedheaderheader);
    $sesadvheader_menu_logo_font_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_menu_logo_font_color',$sesadvancedheaderheader);
    $sesadvheader_mainmenu_background_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_mainmenu_background_color',$sesadvancedheaderheader);
    $sesadvheader_mainmenu_links_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_mainmenu_links_color',$sesadvancedheaderheader);
    $sesadvheader_mainmenu_links_hover_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_mainmenu_links_hover_color',$sesadvancedheaderheader);
    $sesadvheader_submenu_background_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_submenu_background_color',$sesadvancedheaderheader);
    $sesadvheader_submenu_link_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_submenu_link_color',$sesadvancedheaderheader);
    $sesadvheader_submenu_link_hover_bg_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_submenu_link_hover_bg_color',$sesadvancedheaderheader);
    $sesadvheader_submenu_link_hover_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_submenu_link_hover_color',$sesadvancedheaderheader);
    $sesadvheader_minimenu_links_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_minimenu_links_color',$sesadvancedheaderheader);
    $sesadvheader_minimenu_links_hover_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_minimenu_links_hover_color',$sesadvancedheaderheader);
    $sesadvheader_minimenu_icon_background_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_minimenu_icon_background_color',$sesadvancedheaderheader);
    $sesadvheader_minimenu_icon_background_active_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_minimenu_icon_background_active_color',$sesadvancedheaderheader);
    $sesadvheader_minimenu_icon_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_minimenu_icon_color',$sesadvancedheaderheader);
    $sesadvheader_minimenu_icon_active_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_minimenu_icon_active_color',$sesadvancedheaderheader);
    $sesadvheader_header_searchbox_background_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_header_searchbox_background_color',$sesadvancedheaderheader);
    $sesadvheader_header_searchbox_text_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_header_searchbox_text_color',$sesadvancedheaderheader);
    $sesadvheader_searchbox_border_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_searchbox_border_color',$sesadvancedheaderheader);
    $sesadvheader_search_btn_background_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_search_btn_background_color',$sesadvancedheaderheader);
    $sesadvheader_search_btn_font_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_search_btn_font_color',$sesadvancedheaderheader);
    $sesadvheader_header_fixed_font_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_header_fixed_font_color',$sesadvancedheaderheader);
    $sesadvheader_scroll_search_btn_background_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_scroll_search_btn_background_color',$sesadvancedheaderheader);
    $sesadvheader_scroll_search_btn_font_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_scroll_search_btn_font_color',$sesadvancedheaderheader);
    $sesadvheader_login_popup_header_background_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_login_popup_header_background_color',$sesadvancedheaderheader);
    $sesadvheader_login_popup_header_font_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_login_popup_header_font_color',$sesadvancedheaderheader);
    $sesadvheader_login_popup_background_color = $sesadvheaderApi->getHeaderKeyValue('sesadvheader_login_popup_background_color',$sesadvancedheaderheader);

    $allowEmpty = true;
    $required = false;
    
    $this->addElement('Text', "sesadvheader_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_header_background_color,
    ));
		
    $this->addElement('Text', "sesadvheader_font_color", array(
        'label' => 'Header Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_font_color,
    ));
    
    $this->addElement('Text', "sesadvheader_menu_logo_font_color", array(
        'label' => 'Menu Logo Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_menu_logo_font_color,
    ));

    $this->addElement('Text', "sesadvheader_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_mainmenu_background_color,
    ));
		
    $this->addElement('Text', "sesadvheader_mainmenu_links_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_mainmenu_links_color,
    ));

    $this->addElement('Text', "sesadvheader_mainmenu_links_hover_color", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_mainmenu_links_hover_color,
    ));

    $this->addElement('Text', "sesadvheader_minimenu_links_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_minimenu_links_color,
    ));
    
    $this->addElement('Text', "sesadvheader_minimenu_links_hover_color", array(
        'label' => 'Mini Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_minimenu_links_hover_color,
    ));
		
    $this->addElement('Text', "sesadvheader_minimenu_icon_background_color", array(
        'label' => 'Mini Menu Icon Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_minimenu_icon_background_color,
    ));
    $this->addElement('Text', "sesadvheader_minimenu_icon_background_active_color", array(
        'label' => 'Mini Menu Active Icon Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_minimenu_icon_background_active_color,
    ));
		
    $this->addElement('Text', "sesadvheader_submenu_background_color", array(
        'label' => 'Sub-Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_submenu_background_color,
    ));
    $this->addElement('Text', "sesadvheader_submenu_link_color", array(
        'label' => 'Sub-Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_submenu_link_color,
    ));
    $this->addElement('Text', "sesadvheader_submenu_link_hover_bg_color", array(
        'label' => 'Sub-Menu Link Hover Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_submenu_link_hover_bg_color,
    ));
    $this->addElement('Text', "sesadvheader_submenu_link_hover_color", array(
        'label' => 'Sub-Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_submenu_link_hover_color,
    ));
    
    $this->addElement('Text', "sesadvheader_minimenu_icon_color", array(
        'label' => 'Mini Menu Icon Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_minimenu_icon_color,
    ));
    $this->addElement('Text', "sesadvheader_minimenu_icon_active_color", array(
        'label' => 'Mini Menu Icon Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_minimenu_icon_active_color,
    ));

    $this->addElement('Text', "sesadvheader_header_searchbox_background_color", array(
        'label' => 'Header Searchbox Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_header_searchbox_background_color,
    ));

    $this->addElement('Text', "sesadvheader_header_searchbox_text_color", array(
        'label' => 'Header Searchbox Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_header_searchbox_text_color,
    ));
    
    //Top Panel Color
    /*$this->addElement('Text', "sesadvheader_toppanel_userinfo_background_color", array(
        'label' => 'Background Color for User section in Main Menu',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_toppanel_userinfo_background_color,
    ));
    $this->addElement('Text', "sesadvheader_toppanel_userinfo_font_color", array(
        'label' => 'Font Color for User Section in Main Menu',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_toppanel_userinfo_font_color,
    ));
    */
    
    
    $this->addElement('Text', "sesadvheader_searchbox_border_color", array(
        'label' => 'Searchbox Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_searchbox_border_color,
    ));
    $this->addElement('Text', "sesadvheader_search_btn_background_color", array(
        'label' => 'Search Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_search_btn_background_color,
    ));
    $this->addElement('Text', "sesadvheader_search_btn_font_color", array(
        'label' => 'Search Button Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_search_btn_font_color,
    ));
		$this->addElement('Text', "sesadvheader_header_fixed_font_color", array(
        'label' => 'Fixed Header font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_header_fixed_font_color,
    ));	    
		$this->addElement('Text', "sesadvheader_scroll_search_btn_background_color", array(
        'label' => 'Fixed Header Search Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_scroll_search_btn_background_color,
    ));
    $this->addElement('Text', "sesadvheader_scroll_search_btn_font_color", array(
        'label' => 'Fixed Header Search Button Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_scroll_search_btn_font_color,
    ));
    
    //Top Panel Color

		//Login Popup Styling
    $this->addElement('Text', "sesadvheader_login_popup_header_background_color", array(
        'label' => 'Login Popup Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_login_popup_header_background_color,
    ));
    $this->addElement('Text', "sesadvheader_login_popup_header_font_color", array(
        'label' => 'Login Popup Header Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_login_popup_header_font_color,
    ));
    $this->addElement('Text', "sesadvheader_login_popup_background_color", array(
        'label' => 'Login Popup Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesadvheader_login_popup_background_color,
    ));

    $this->addDisplayGroup(array('sesadvheader_header_background_color','sesadvheader_font_color', 'sesadvheader_menu_logo_font_color', 'sesadvheader_mainmenu_background_color', 'sesadvheader_mainmenu_links_color', 'sesadvheader_mainmenu_links_hover_color','sesadvheader_submenu_background_color','sesadvheader_submenu_link_color','sesadvheader_submenu_link_hover_bg_color','sesadvheader_submenu_link_hover_color', 'sesadvheader_minimenu_links_color', 'sesadvheader_minimenu_links_hover_color', 'sesadvheader_minimenu_icon_background_color', 'sesadvheader_minimenu_icon_background_active_color', 'sesadvheader_minimenu_icon_color', 'sesadvheader_minimenu_icon_active_color',  'sesadvheader_header_searchbox_background_color', 'sesadvheader_header_searchbox_text_color','sesadvheader_searchbox_border_color','sesadvheader_search_btn_background_color','sesadvheader_search_btn_font_color','sesadvheader_header_fixed_font_color','sesadvheader_scroll_search_btn_background_color','sesadvheader_scroll_search_btn_font_color', 'sesadvheader_login_popup_header_background_color', 'sesadvheader_login_popup_header_font_color','sesadvheader_login_popup_background_color'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group','class'=>'sesadvancedheader_bundle'))));
    
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
