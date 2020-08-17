<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Typography.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessportz_Form_Admin_Typography extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Fonts / Typography Settings')
            ->setDescription('Here, you can configure the font settings in this theme on your website. You can also choose to enable the Google Fonts.');
            
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

    $this->addElement('Select', 'sessportz_googlefonts', array(
      'label' => 'Choose Fonts',
      'description' => 'Choose from below the Fonts which you want to enable in this theme.',
      'multiOptions' => array(
        '0' => 'Web Safe Font Combinations',
        '1' => 'Google Fonts',
      ),
      'onchange' => "usegooglefont(this.value)",
      'value' => $settings->getSetting('sessportz.googlefonts', 0),
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
    );
    
    
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $link = '<a href="http://www.w3schools.com/cssref/css_websafe_fonts.asp" target="_blank">here</a>.';
    $bodyDes = sprintf('You can see the web safe fonts %s',$link);
    $headingDes = sprintf('You can see the web safe fonts %s',$link);
    $mainmenuDes = sprintf('You can see the web safe fonts %s',$link);
    $tabDes = sprintf('You can see the web safe fonts %s',$link);
    
    //Google Font Work
    $link = '<a href="https://www.google.com/fonts" target="_blank">here</a>.';
    $bodygoogleDes = sprintf('You can see the google fonts %s',$link);
    $headinggoogleDes = sprintf('You can see the google fonts %s',$link);
    $mainmenugoogleDes = sprintf('You can see the google fonts %s',$link);
    $tabgoogleDes = sprintf('You can see the google fonts %s',$link);
    
    //Body Settings

    $this->addElement('Select', 'sessportz_body_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_body_fontfamily'),
    ));
    $this->getElement('sessportz_body_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    
    
    $this->addElement('Text', 'sessportz_body_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_body_fontsize'),
    ));
    $this->getElement('sessportz_body_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sessportz_body_fontfamily', 'sessportz_body_fontsize'), 'sessportz_bodygrp', array('disableLoadDefaultDecorators' => true));
    $sessportz_bodygrp = $this->getDisplayGroup('sessportz_bodygrp');
    $sessportz_bodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sessportz_bodygrp'))));
    
   
    //Google Font work
    $this->addElement('Select', 'sessportz_googlebody_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_body_fontfamily'),
    ));
    $this->getElement('sessportz_googlebody_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sessportz_googlebody_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_body_fontsize'),
    ));
    $this->getElement('sessportz_googlebody_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sessportz_googlebody_fontfamily', 'sessportz_googlebody_fontsize'), 'sessportz_googlebodygrp', array('disableLoadDefaultDecorators' => true));
    $sessportz_googlebodygrp = $this->getDisplayGroup('sessportz_googlebodygrp');
    $sessportz_googlebodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sessportz_googlebodygrp'))));
    

    //Heading Settings
    $this->addElement('Select', 'sessportz_heading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_heading_fontfamily'),
    ));
    $this->getElement('sessportz_heading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sessportz_heading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_heading_fontsize'),
    ));
    $this->getElement('sessportz_heading_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sessportz_heading_fontfamily', 'sessportz_heading_fontsize'), 'sessportz_headinggrp', array('disableLoadDefaultDecorators' => true));
    $sessportz_headinggrp = $this->getDisplayGroup('sessportz_headinggrp');
    $sessportz_headinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sessportz_headinggrp'))));
    
    
    //Google Font work
    $this->addElement('Select', 'sessportz_googleheading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_heading_fontfamily'),
    ));
    $this->getElement('sessportz_googleheading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sessportz_googleheading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_heading_fontsize'),
    ));
    $this->getElement('sessportz_googleheading_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sessportz_googleheading_fontfamily', 'sessportz_googleheading_fontsize'), 'sessportz_googleheadinggrp', array('disableLoadDefaultDecorators' => true));
    $sessportz_googleheadinggrp = $this->getDisplayGroup('sessportz_googleheadinggrp');
    $sessportz_googleheadinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sessportz_googleheadinggrp'))));
    
    
    
    //Main Menu Settings
    $this->addElement('Select', 'sessportz_mainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_mainmenu_fontfamily'),
    ));
    $this->getElement('sessportz_mainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
            
    $this->addElement('Text', 'sessportz_mainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_mainmenu_fontsize'),
    ));
    $this->getElement('sessportz_mainmenu_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sessportz_mainmenu_fontfamily', 'sessportz_mainmenu_fontsize'), 'sessportz_mainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sessportz_mainmenugrp = $this->getDisplayGroup('sessportz_mainmenugrp');
    $sessportz_mainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sessportz_mainmenugrp'))));
    
    //Google Font work
    $this->addElement('Select', 'sessportz_googlemainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_mainmenu_fontfamily'),
    ));
    $this->getElement('sessportz_googlemainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sessportz_googlemainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_mainmenu_fontsize'),
    ));
    $this->getElement('sessportz_googlemainmenu_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sessportz_googlemainmenu_fontfamily', 'sessportz_googlemainmenu_fontsize'), 'sessportz_googlemainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sessportz_googlemainmenugrp = $this->getDisplayGroup('sessportz_googlemainmenugrp');
    $sessportz_googlemainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sessportz_googlemainmenugrp'))));
    

    //Tab Settings
    $this->addElement('Select', 'sessportz_tab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_tab_fontfamily'),
    ));
    $this->getElement('sessportz_tab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sessportz_tab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_tab_fontsize'),
    ));
    $this->getElement('sessportz_tab_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sessportz_tab_fontfamily', 'sessportz_tab_fontsize'), 'sessportz_tabgrp', array('disableLoadDefaultDecorators' => true));
    $sessportz_tabgrp = $this->getDisplayGroup('sessportz_tabgrp');
    $sessportz_tabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sessportz_tabgrp'))));
    
    
    //Google Font work
    $this->addElement('Select', 'sessportz_googletab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_tab_fontfamily'),
    ));
    $this->getElement('sessportz_googletab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sessportz_googletab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_tab_fontsize'),
    ));
    $this->getElement('sessportz_googletab_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sessportz_googletab_fontfamily', 'sessportz_googletab_fontsize'), 'sessportz_googletabgrp', array('disableLoadDefaultDecorators' => true));
    $sessportz_googletabgrp = $this->getDisplayGroup('sessportz_googletabgrp');
    $sessportz_googletabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sessportz_googletabgrp'))));

    
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
