<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Typography.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesadvancedheader_Form_Admin_Typography extends Engine_Form {

  public function init() {
  
    $description = $this->getTranslator()->translate('Here, you can configure the font settings in this theme on your website. You can also choose to enable the Google Fonts.<br/>');

	  $moreinfo = $this->getTranslator()->translate('See Google Fonts here: <a href="%1$s" target="_blank">https://fonts.google.com/</a><br />');
        
    $moreinfos = $this->getTranslator()->translate('See Web Safe Font Combinations here: <a href="%2$s" target="_blank">https://www.w3schools.com/cssref/css_websafe_fonts.asp</a>');

    $description = vsprintf($description.$moreinfo.$moreinfos, array('https://fonts.google.com','https://www.w3schools.com/cssref/css_websafe_fonts.asp'));

    // Decorators
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);


    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Fonts / Typography Settings')
            ->setDescription($description);
            
    $url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDczHMCNc0JCmJACM86C7L8yYdF9sTvz1A";
    
    $ch = curl_init();
  
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($ch);
    curl_close($ch);

    $results = json_decode($data,true);
    
    $googleFontArray = array();
    foreach($results['items'] as $re) {
      $googleFontArray['"'.$re["family"].'"'] = $re['family'];
    }

    $this->addElement('Select', 'sesadvancedheader_googlefonts', array(
      'label' => 'Choose Fonts',
      'description' => 'Choose from below the Fonts which you want to enable in this theme.',
      'multiOptions' => array(
        '0' => 'Web Safe Font Combinations',
        '1' => 'Google Fonts',
      ),
      'onchange' => "usegooglefont(this.value)",
      'value' => $settings->getSetting('sesadvancedheader.googlefonts', 0),
    ));
    
    $font_array = array(
      'Georgia, serif' => 'Georgia, serif',
      '"Palatino Linotype", "Book Antiqua", Palatino, serif' => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
      '"Times New Roman", Times, serif' => '"Times New Roman", Times, serif',
      'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
      '"Arial Black", Gadget, sans-serif' => '"Arial Black", Gadget, sans-serif',
      '"Comic Sans MS", cursive, sans-serif' => '"Comic Sans MS", cursive, sans-serif',
      'Impact, Charcoal, sans-serif' => 'Impact, Charcoal, sans-serif',
      '"Lucida Sans Unicode", "Lucida Grande", sans-serif' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
      'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
      '"Trebuchet MS", Helvetica, sans-serif' => '"Trebuchet MS", Helvetica, sans-serif',
      'Verdana, Geneva, sans-serif' => 'Verdana, Geneva, sans-serif',
      '"Courier New", Courier, monospace' => '"Courier New", Courier, monospace',
      '"Lucida Console", Monaco, monospace' => '"Lucida Console", Monaco, monospace',
	  "'Open Sans', sans-serif" => "'Open Sans', sans-serif",
    );

    $this->addElement('Select', 'sesadvheader_mainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesadvancedheader()->getContantValueXML('sesadvheader_mainmenu_fontfamily'),
    ));
    $this->getElement('sesadvheader_mainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sesadvheader_mainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => (isset($_POST['sesadvancedheader_googlefonts']) && !$_POST['sesadvancedheader_googlefonts'])  ? false : true  ,
      'required' => (isset($_POST['sesadvancedheader_googlefonts']) && !$_POST['sesadvancedheader_googlefonts'])  ? true : true ,
      'value' => Engine_Api::_()->sesadvancedheader()->getContantValueXML('sesadvheader_mainmenu_fontsize',0),
    ));
    $this->getElement('sesadvheader_mainmenu_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesadvheader_mainmenu_fontfamily', 'sesadvheader_mainmenu_fontsize'), 'sesadvheader_mainmenugrp', array('disableLoadDefaultDecorators' => true));
    $exp_mainmenugrp = $this->getDisplayGroup('sesadvheader_mainmenugrp');
    $exp_mainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesadvheader_mainmenugrp'))));
    
    //Google Font work
    $this->addElement('Select', 'sesadvheader_googlemainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesadvancedheader()->getContantValueXML('sesadvheader_mainmenu_fontfamily'),
    ));
    $this->getElement('sesadvheader_googlemainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sesadvheader_googlemainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => (isset($_POST['sesadvancedheader_googlefonts']) && $_POST['sesadvancedheader_googlefonts'] == 1)  ? false : true,
      'required' => (isset($_POST['sesadvancedheader_googlefonts']) && $_POST['sesadvancedheader_googlefonts'] == 1)  ? true : false,
      'value' => Engine_Api::_()->sesadvancedheader()->getContantValueXML('sesadvheader_mainmenu_fontsize',0),
    ));
    $this->getElement('sesadvheader_googlemainmenu_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesadvheader_googlemainmenu_fontfamily', 'sesadvheader_googlemainmenu_fontsize'), 'sesadvheader_googlemainmenugrp', array('disableLoadDefaultDecorators' => true));
    $exp_googlemainmenugrp = $this->getDisplayGroup('sesadvheader_googlemainmenugrp');
    $exp_googlemainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesadvheader_googlemainmenugrp'))));
        
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
