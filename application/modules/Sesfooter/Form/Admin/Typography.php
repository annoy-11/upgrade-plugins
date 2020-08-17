<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Typography.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfooter_Form_Admin_Typography extends Engine_Form {

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

    $this->addElement('Select', 'sesfooter_googlefonts', array(
      'label' => 'Choose Fonts',
      'description' => 'Choose from below the Fonts which you want to enable in this theme.',
      'multiOptions' => array(
        '0' => 'Web Safe Font Combinations',
        '1' => 'Google Fonts',
      ),
      'onchange' => "usegooglefont(this.value)",
      'value' => $settings->getSetting('sesfooter.googlefonts', 0),
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

    //Heading Settings
    $this->addElement('Select', 'sesfooter_heading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesfooter()->getContantValueXML('sesfooter_heading_fontfamily'),
    ));
    $this->getElement('sesfooter_heading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesfooter_heading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesfooter()->getContantValueXML('sesfooter_heading_fontsize'),
    ));
    $this->getElement('sesfooter_heading_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesfooter_heading_fontfamily', 'sesfooter_heading_fontsize'), 'sesfooter_headinggrp', array('disableLoadDefaultDecorators' => true));
    $sesfooter_headinggrp = $this->getDisplayGroup('sesfooter_headinggrp');
    $sesfooter_headinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesfooter_headinggrp'))));
    
    
    //Google Font work
    $this->addElement('Select', 'sesfooter_googleheading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesfooter()->getContantValueXML('sesfooter_heading_fontfamily'),
    ));
    $this->getElement('sesfooter_googleheading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sesfooter_googleheading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesfooter()->getContantValueXML('sesfooter_heading_fontsize'),
    ));
    $this->getElement('sesfooter_googleheading_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesfooter_googleheading_fontfamily', 'sesfooter_googleheading_fontsize'), 'sesfooter_googleheadinggrp', array('disableLoadDefaultDecorators' => true));
    $sesfooter_googleheadinggrp = $this->getDisplayGroup('sesfooter_googleheadinggrp');
    $sesfooter_googleheadinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesfooter_googleheadinggrp'))));


    //Text Settings
    $this->addElement('Select', 'sesfooter_text_fontfamily', array(
      'label' => 'Text - Font Family',
      'description' => "Choose font family for the text under Text Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesfooter()->getContantValueXML('sesfooter_text_fontfamily'),
    ));
    $this->getElement('sesfooter_text_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesfooter_text_fontsize', array(
      'label' => 'Text - Font Size',
      'description' => 'Enter the font size for the text under Text Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesfooter()->getContantValueXML('sesfooter_text_fontsize'),
    ));
    $this->getElement('sesfooter_text_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesfooter_text_fontfamily', 'sesfooter_text_fontsize'), 'sesfooter_textgrp', array('disableLoadDefaultDecorators' => true));
    $sesfooter_textgrp = $this->getDisplayGroup('sesfooter_textgrp');
    $sesfooter_textgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesfooter_textgrp'))));
    
    
    //Google Font work
    $this->addElement('Select', 'sesfooter_googletext_fontfamily', array(
      'label' => 'Text - Font Family',
      'description' => "Choose font family for the text under Text Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesfooter()->getContantValueXML('sesfooter_text_fontfamily'),
    ));
    $this->getElement('sesfooter_googletext_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sesfooter_googletext_fontsize', array(
      'label' => 'Text - Font Size',
      'description' => 'Enter the font size for the text under Text Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesfooter()->getContantValueXML('sesfooter_text_fontsize'),
    ));
    $this->getElement('sesfooter_googletext_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesfooter_googletext_fontfamily', 'sesfooter_googletext_fontsize'), 'sesfooter_googletextgrp', array('disableLoadDefaultDecorators' => true));
    $sesfooter_googletextgrp = $this->getDisplayGroup('sesfooter_googletextgrp');
    $sesfooter_googletextgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesfooter_googletextgrp'))));

    
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}