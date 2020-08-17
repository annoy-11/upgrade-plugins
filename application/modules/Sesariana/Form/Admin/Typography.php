<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Typography.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Form_Admin_Typography extends Engine_Form {

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

    $this->addElement('Select', 'sesariana_googlefonts', array(
      'label' => 'Choose Fonts',
      'description' => 'Choose from below the Fonts which you want to enable in this theme.',
      'multiOptions' => array(
        '0' => 'Web Safe Font Combinations',
        '1' => 'Google Fonts',
      ),
      'onchange' => "usegooglefont(this.value)",
      'value' => $settings->getSetting('sesariana.googlefonts', 0),
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

    $this->addElement('Select', 'sesariana_body_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_body_fontfamily'),
    ));
    $this->getElement('sesariana_body_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesariana_body_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_body_fontsize'),
    ));
    $this->getElement('sesariana_body_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesariana_body_fontfamily', 'sesariana_body_fontsize'), 'sesariana_bodygrp', array('disableLoadDefaultDecorators' => true));
    $sesariana_bodygrp = $this->getDisplayGroup('sesariana_bodygrp');
    $sesariana_bodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesariana_bodygrp'))));

    //Google Font work
    $this->addElement('Select', 'sesariana_googlebody_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_body_fontfamily'),
    ));
    $this->getElement('sesariana_googlebody_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sesariana_googlebody_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_body_fontsize'),
    ));
    $this->getElement('sesariana_googlebody_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesariana_googlebody_fontfamily', 'sesariana_googlebody_fontsize'), 'sesariana_googlebodygrp', array('disableLoadDefaultDecorators' => true));
    $sesariana_googlebodygrp = $this->getDisplayGroup('sesariana_googlebodygrp');
    $sesariana_googlebodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesariana_googlebodygrp'))));
    

    //Heading Settings
    $this->addElement('Select', 'sesariana_heading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_heading_fontfamily'),
    ));
    $this->getElement('sesariana_heading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesariana_heading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_heading_fontsize'),
    ));
    $this->getElement('sesariana_heading_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesariana_heading_fontfamily', 'sesariana_heading_fontsize'), 'sesariana_headinggrp', array('disableLoadDefaultDecorators' => true));
    $sesariana_headinggrp = $this->getDisplayGroup('sesariana_headinggrp');
    $sesariana_headinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesariana_headinggrp'))));
    
    
    //Google Font work
    $this->addElement('Select', 'sesariana_googleheading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_heading_fontfamily'),
    ));
    $this->getElement('sesariana_googleheading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sesariana_googleheading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_heading_fontsize'),
    ));
    $this->getElement('sesariana_googleheading_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesariana_googleheading_fontfamily', 'sesariana_googleheading_fontsize'), 'sesariana_googleheadinggrp', array('disableLoadDefaultDecorators' => true));
    $sesariana_googleheadinggrp = $this->getDisplayGroup('sesariana_googleheadinggrp');
    $sesariana_googleheadinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesariana_googleheadinggrp'))));

    //Main Menu Settings
    $this->addElement('Select', 'sesariana_mainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_mainmenu_fontfamily'),
    ));
    $this->getElement('sesariana_mainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
            
    $this->addElement('Text', 'sesariana_mainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_mainmenu_fontsize'),
    ));
    $this->getElement('sesariana_mainmenu_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesariana_mainmenu_fontfamily', 'sesariana_mainmenu_fontsize'), 'sesariana_mainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sesariana_mainmenugrp = $this->getDisplayGroup('sesariana_mainmenugrp');
    $sesariana_mainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesariana_mainmenugrp'))));
    
    //Google Font work
    $this->addElement('Select', 'sesariana_googlemainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_mainmenu_fontfamily'),
    ));
    $this->getElement('sesariana_googlemainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sesariana_googlemainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_mainmenu_fontsize'),
    ));
    $this->getElement('sesariana_googlemainmenu_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesariana_googlemainmenu_fontfamily', 'sesariana_googlemainmenu_fontsize'), 'sesariana_googlemainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sesariana_googlemainmenugrp = $this->getDisplayGroup('sesariana_googlemainmenugrp');
    $sesariana_googlemainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesariana_googlemainmenugrp'))));
    

    //Tab Settings
    $this->addElement('Select', 'sesariana_tab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_tab_fontfamily'),
    ));
    $this->getElement('sesariana_tab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesariana_tab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_tab_fontsize'),
    ));
    $this->getElement('sesariana_tab_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesariana_tab_fontfamily', 'sesariana_tab_fontsize'), 'sesariana_tabgrp', array('disableLoadDefaultDecorators' => true));
    $sesariana_tabgrp = $this->getDisplayGroup('sesariana_tabgrp');
    $sesariana_tabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesariana_tabgrp'))));
    
    
    //Google Font work
    $this->addElement('Select', 'sesariana_googletab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_tab_fontfamily'),
    ));
    $this->getElement('sesariana_googletab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sesariana_googletab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_tab_fontsize'),
    ));
    $this->getElement('sesariana_googletab_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesariana_googletab_fontfamily', 'sesariana_googletab_fontsize'), 'sesariana_googletabgrp', array('disableLoadDefaultDecorators' => true));
    $sesariana_googletabgrp = $this->getDisplayGroup('sesariana_googletabgrp');
    $sesariana_googletabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesariana_googletabgrp'))));

    
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}