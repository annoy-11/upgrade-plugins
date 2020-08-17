<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Typography.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmaterial_Form_Admin_Typography extends Engine_Form {

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

    $this->addElement('Select', 'sesmaterial_googlefonts', array(
      'label' => 'Choose Fonts',
      'description' => 'Choose from below the Fonts which you want to enable in this theme.',
      'multiOptions' => array(
        '0' => 'Web Safe Font Combinations',
        '1' => 'Google Fonts',
      ),
      'onchange' => "usegooglefont(this.value)",
      'value' => $settings->getSetting('sesmaterial.googlefonts', 0),
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

    $this->addElement('Select', 'sesmaterial_body_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_body_fontfamily'),
    ));
    $this->getElement('sesmaterial_body_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));



    $this->addElement('Text', 'sesmaterial_body_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_body_fontsize'),
    ));
    $this->getElement('sesmaterial_body_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesmaterial_body_fontfamily', 'sesmaterial_body_fontsize'), 'sesmaterial_bodygrp', array('disableLoadDefaultDecorators' => true));
    $sesmaterial_bodygrp = $this->getDisplayGroup('sesmaterial_bodygrp');
    $sesmaterial_bodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesmaterial_bodygrp'))));


    //Google Font work
    $this->addElement('Select', 'sesmaterial_googlebody_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_body_fontfamily'),
    ));
    $this->getElement('sesmaterial_googlebody_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesmaterial_googlebody_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_body_fontsize'),
    ));
    $this->getElement('sesmaterial_googlebody_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesmaterial_googlebody_fontfamily', 'sesmaterial_googlebody_fontsize'), 'sesmaterial_googlebodygrp', array('disableLoadDefaultDecorators' => true));
    $sesmaterial_googlebodygrp = $this->getDisplayGroup('sesmaterial_googlebodygrp');
    $sesmaterial_googlebodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesmaterial_googlebodygrp'))));


    //Heading Settings
    $this->addElement('Select', 'sesmaterial_heading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_heading_fontfamily'),
    ));
    $this->getElement('sesmaterial_heading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesmaterial_heading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_heading_fontsize'),
    ));
    $this->getElement('sesmaterial_heading_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesmaterial_heading_fontfamily', 'sesmaterial_heading_fontsize'), 'sesmaterial_headinggrp', array('disableLoadDefaultDecorators' => true));
    $sesmaterial_headinggrp = $this->getDisplayGroup('sesmaterial_headinggrp');
    $sesmaterial_headinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesmaterial_headinggrp'))));


    //Google Font work
    $this->addElement('Select', 'sesmaterial_googleheading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_heading_fontfamily'),
    ));
    $this->getElement('sesmaterial_googleheading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesmaterial_googleheading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_heading_fontsize'),
    ));
    $this->getElement('sesmaterial_googleheading_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesmaterial_googleheading_fontfamily', 'sesmaterial_googleheading_fontsize'), 'sesmaterial_googleheadinggrp', array('disableLoadDefaultDecorators' => true));
    $sesmaterial_googleheadinggrp = $this->getDisplayGroup('sesmaterial_googleheadinggrp');
    $sesmaterial_googleheadinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesmaterial_googleheadinggrp'))));



    //Main Menu Settings
    $this->addElement('Select', 'sesmaterial_mainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_mainmenu_fontfamily'),
    ));
    $this->getElement('sesmaterial_mainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));


    $this->addElement('Text', 'sesmaterial_mainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_mainmenu_fontsize'),
    ));
    $this->getElement('sesmaterial_mainmenu_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesmaterial_mainmenu_fontfamily', 'sesmaterial_mainmenu_fontsize'), 'sesmaterial_mainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sesmaterial_mainmenugrp = $this->getDisplayGroup('sesmaterial_mainmenugrp');
    $sesmaterial_mainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesmaterial_mainmenugrp'))));

    //Google Font work
    $this->addElement('Select', 'sesmaterial_googlemainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_mainmenu_fontfamily'),
    ));
    $this->getElement('sesmaterial_googlemainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesmaterial_googlemainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_mainmenu_fontsize'),
    ));
    $this->getElement('sesmaterial_googlemainmenu_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesmaterial_googlemainmenu_fontfamily', 'sesmaterial_googlemainmenu_fontsize'), 'sesmaterial_googlemainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sesmaterial_googlemainmenugrp = $this->getDisplayGroup('sesmaterial_googlemainmenugrp');
    $sesmaterial_googlemainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesmaterial_googlemainmenugrp'))));


    //Tab Settings
    $this->addElement('Select', 'sesmaterial_tab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_tab_fontfamily'),
    ));
    $this->getElement('sesmaterial_tab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesmaterial_tab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_tab_fontsize'),
    ));
    $this->getElement('sesmaterial_tab_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesmaterial_tab_fontfamily', 'sesmaterial_tab_fontsize'), 'sesmaterial_tabgrp', array('disableLoadDefaultDecorators' => true));
    $sesmaterial_tabgrp = $this->getDisplayGroup('sesmaterial_tabgrp');
    $sesmaterial_tabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesmaterial_tabgrp'))));


    //Google Font work
    $this->addElement('Select', 'sesmaterial_googletab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_tab_fontfamily'),
    ));
    $this->getElement('sesmaterial_googletab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesmaterial_googletab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_tab_fontsize'),
    ));
    $this->getElement('sesmaterial_googletab_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesmaterial_googletab_fontfamily', 'sesmaterial_googletab_fontsize'), 'sesmaterial_googletabgrp', array('disableLoadDefaultDecorators' => true));
    $sesmaterial_googletabgrp = $this->getDisplayGroup('sesmaterial_googletabgrp');
    $sesmaterial_googletabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesmaterial_googletabgrp'))));


    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
