<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Typography.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestwitterclone_Form_Admin_Typography extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Fonts / Typography Settings')
            ->setDescription('Here, you can configure the font settings for the theme on your website. You can also choose to enable the Google Fonts from this section.');

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

    $this->addElement('Select', 'sestwitterclone_googlefonts', array(
      'label' => 'Choose Fonts',
      'description' => 'Choose from below the Fonts which you want to enable in this theme.',
      'multiOptions' => array(
        '0' => 'Web Safe Font Combinations',
        '1' => 'Google Fonts',
      ),
      'onchange' => "usegooglefont(this.value)",
      'value' => $settings->getSetting('sestwitterclone.googlefonts', '1'),
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

    $this->addElement('Select', 'sestwitterclone_body_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_body_fontfamily'),
    ));
    $this->getElement('sestwitterclone_body_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));



    $this->addElement('Text', 'sestwitterclone_body_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling. (Enter the size in px.)',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_body_fontsize'),
    ));
    $this->getElement('sestwitterclone_body_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sestwitterclone_body_fontfamily', 'sestwitterclone_body_fontsize'), 'sestwitterclone_bodygrp', array('disableLoadDefaultDecorators' => true));
    $sestwitterclone_bodygrp = $this->getDisplayGroup('sestwitterclone_bodygrp');
    $sestwitterclone_bodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sestwitterclone_bodygrp'))));


    //Google Font work
    $this->addElement('Select', 'sestwitterclone_googlebody_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_body_fontfamily'),
    ));
    $this->getElement('sestwitterclone_googlebody_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sestwitterclone_googlebody_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_body_fontsize'),
    ));
    $this->getElement('sestwitterclone_googlebody_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sestwitterclone_googlebody_fontfamily', 'sestwitterclone_googlebody_fontsize'), 'sestwitterclone_googlebodygrp', array('disableLoadDefaultDecorators' => true));
    $sestwitterclone_googlebodygrp = $this->getDisplayGroup('sestwitterclone_googlebodygrp');
    $sestwitterclone_googlebodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sestwitterclone_googlebodygrp'))));


    //Heading Settings
    $this->addElement('Select', 'sestwitterclone_heading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_heading_fontfamily'),
    ));
    $this->getElement('sestwitterclone_heading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sestwitterclone_heading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling. (Enter the size in px.)',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_heading_fontsize'),
    ));
    $this->getElement('sestwitterclone_heading_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sestwitterclone_heading_fontfamily', 'sestwitterclone_heading_fontsize'), 'sestwitterclone_headinggrp', array('disableLoadDefaultDecorators' => true));
    $sestwitterclone_headinggrp = $this->getDisplayGroup('sestwitterclone_headinggrp');
    $sestwitterclone_headinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sestwitterclone_headinggrp'))));


    //Google Font work
    $this->addElement('Select', 'sestwitterclone_googleheading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_heading_fontfamily'),
    ));
    $this->getElement('sestwitterclone_googleheading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sestwitterclone_googleheading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_heading_fontsize'),
    ));
    $this->getElement('sestwitterclone_googleheading_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sestwitterclone_googleheading_fontfamily', 'sestwitterclone_googleheading_fontsize'), 'sestwitterclone_googleheadinggrp', array('disableLoadDefaultDecorators' => true));
    $sestwitterclone_googleheadinggrp = $this->getDisplayGroup('sestwitterclone_googleheadinggrp');
    $sestwitterclone_googleheadinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sestwitterclone_googleheadinggrp'))));



    //Main Menu Settings
    $this->addElement('Select', 'sestwitterclone_mainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_mainmenu_fontfamily'),
    ));
    $this->getElement('sestwitterclone_mainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));


    $this->addElement('Text', 'sestwitterclone_mainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling. Enter the size in px.)',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_mainmenu_fontsize'),
    ));
    $this->getElement('sestwitterclone_mainmenu_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sestwitterclone_mainmenu_fontfamily', 'sestwitterclone_mainmenu_fontsize'), 'sestwitterclone_mainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sestwitterclone_mainmenugrp = $this->getDisplayGroup('sestwitterclone_mainmenugrp');
    $sestwitterclone_mainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sestwitterclone_mainmenugrp'))));

    //Google Font work
    $this->addElement('Select', 'sestwitterclone_googlemainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_mainmenu_fontfamily'),
    ));
    $this->getElement('sestwitterclone_googlemainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sestwitterclone_googlemainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_mainmenu_fontsize'),
    ));
    $this->getElement('sestwitterclone_googlemainmenu_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sestwitterclone_googlemainmenu_fontfamily', 'sestwitterclone_googlemainmenu_fontsize'), 'sestwitterclone_googlemainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sestwitterclone_googlemainmenugrp = $this->getDisplayGroup('sestwitterclone_googlemainmenugrp');
    $sestwitterclone_googlemainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sestwitterclone_googlemainmenugrp'))));


    //Tab Settings
    $this->addElement('Select', 'sestwitterclone_tab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_tab_fontfamily'),
    ));
    $this->getElement('sestwitterclone_tab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sestwitterclone_tab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling. (Enter the size in px.)',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_tab_fontsize'),
    ));
    $this->getElement('sestwitterclone_tab_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sestwitterclone_tab_fontfamily', 'sestwitterclone_tab_fontsize'), 'sestwitterclone_tabgrp', array('disableLoadDefaultDecorators' => true));
    $sestwitterclone_tabgrp = $this->getDisplayGroup('sestwitterclone_tabgrp');
    $sestwitterclone_tabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sestwitterclone_tabgrp'))));


    //Google Font work
    $this->addElement('Select', 'sestwitterclone_googletab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_tab_fontfamily'),
    ));
    $this->getElement('sestwitterclone_googletab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sestwitterclone_googletab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sestwitterclone()->getContantValueXML('sestwitterclone_tab_fontsize'),
    ));
    $this->getElement('sestwitterclone_googletab_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sestwitterclone_googletab_fontfamily', 'sestwitterclone_googletab_fontsize'), 'sestwitterclone_googletabgrp', array('disableLoadDefaultDecorators' => true));
    $sestwitterclone_googletabgrp = $this->getDisplayGroup('sestwitterclone_googletabgrp');
    $sestwitterclone_googletabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sestwitterclone_googletabgrp'))));


    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
