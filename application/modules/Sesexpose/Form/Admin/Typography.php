<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Typography.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesexpose_Form_Admin_Typography extends Engine_Form {

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

    $this->addElement('Select', 'sesexpose_googlefonts', array(
      'label' => 'Choose Fonts',
      'description' => 'Choose from below the Fonts which you want to enable in this theme.',
      'multiOptions' => array(
        '0' => 'Web Safe Font Combinations',
        '1' => 'Google Fonts',
      ),
      'onchange' => "usegooglefont(this.value)",
      'value' => $settings->getSetting('sesexpose.googlefonts', 0),
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

    $this->addElement('Select', 'exp_body_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_body_fontfamily'),
    ));
    $this->getElement('exp_body_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    
    
    $this->addElement('Text', 'exp_body_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_body_fontsize'),
    ));
    $this->getElement('exp_body_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('exp_body_fontfamily', 'exp_body_fontsize'), 'exp_bodygrp', array('disableLoadDefaultDecorators' => true));
    $exp_bodygrp = $this->getDisplayGroup('exp_bodygrp');
    $exp_bodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'exp_bodygrp'))));
    
   
    //Google Font work
    $this->addElement('Select', 'exp_googlebody_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_body_fontfamily'),
    ));
    $this->getElement('exp_googlebody_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'exp_googlebody_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_body_fontsize'),
    ));
    $this->getElement('exp_googlebody_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('exp_googlebody_fontfamily', 'exp_googlebody_fontsize'), 'exp_googlebodygrp', array('disableLoadDefaultDecorators' => true));
    $exp_googlebodygrp = $this->getDisplayGroup('exp_googlebodygrp');
    $exp_googlebodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'exp_googlebodygrp'))));
    

    $this->addElement('Select', 'exp_heading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_heading_fontfamily'),
    ));
    $this->getElement('exp_heading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'exp_heading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_heading_fontsize'),
    ));
    $this->getElement('exp_heading_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('exp_heading_fontfamily', 'exp_heading_fontsize'), 'exp_headinggrp', array('disableLoadDefaultDecorators' => true));
    $exp_headinggrp = $this->getDisplayGroup('exp_headinggrp');
    $exp_headinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'exp_headinggrp'))));
    
    
    //Google Font work
    $this->addElement('Select', 'exp_googleheading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_heading_fontfamily'),
    ));
    $this->getElement('exp_googleheading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'exp_googleheading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_heading_fontsize'),
    ));
    $this->getElement('exp_googleheading_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('exp_googleheading_fontfamily', 'exp_googleheading_fontsize'), 'exp_googleheadinggrp', array('disableLoadDefaultDecorators' => true));
    $exp_googleheadinggrp = $this->getDisplayGroup('exp_googleheadinggrp');
    $exp_googleheadinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'exp_googleheadinggrp'))));
    
    

    $this->addElement('Select', 'exp_mainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_mainmenu_fontfamily'),
    ));
    $this->getElement('exp_mainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
            
    $this->addElement('Text', 'exp_mainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_mainmenu_fontsize'),
    ));
    $this->getElement('exp_mainmenu_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('exp_mainmenu_fontfamily', 'exp_mainmenu_fontsize'), 'exp_mainmenugrp', array('disableLoadDefaultDecorators' => true));
    $exp_mainmenugrp = $this->getDisplayGroup('exp_mainmenugrp');
    $exp_mainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'exp_mainmenugrp'))));
    
    //Google Font work
    $this->addElement('Select', 'exp_googlemainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_mainmenu_fontfamily'),
    ));
    $this->getElement('exp_googlemainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'exp_googlemainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_mainmenu_fontsize'),
    ));
    $this->getElement('exp_googlemainmenu_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('exp_googlemainmenu_fontfamily', 'exp_googlemainmenu_fontsize'), 'exp_googlemainmenugrp', array('disableLoadDefaultDecorators' => true));
    $exp_googlemainmenugrp = $this->getDisplayGroup('exp_googlemainmenugrp');
    $exp_googlemainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'exp_googlemainmenugrp'))));
    
    
    $this->addElement('Select', 'exp_tab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_tab_fontfamily'),
    ));
    $this->getElement('exp_tab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'exp_tab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_tab_fontsize'),
    ));
    $this->getElement('exp_tab_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('exp_tab_fontfamily', 'exp_tab_fontsize'), 'exp_tabgrp', array('disableLoadDefaultDecorators' => true));
    $exp_tabgrp = $this->getDisplayGroup('exp_tabgrp');
    $exp_tabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'exp_tabgrp'))));
    
    
    //Google Font work
    $this->addElement('Select', 'exp_googletab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_tab_fontfamily'),
    ));
    $this->getElement('exp_googletab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'exp_googletab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_tab_fontsize'),
    ));
    $this->getElement('exp_googletab_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('exp_googletab_fontfamily', 'exp_googletab_fontsize'), 'exp_googletabgrp', array('disableLoadDefaultDecorators' => true));
    $exp_googletabgrp = $this->getDisplayGroup('exp_googletabgrp');
    $exp_googletabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'exp_googletabgrp'))));

    
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
