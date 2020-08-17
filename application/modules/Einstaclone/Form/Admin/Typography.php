<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Typography.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_Form_Admin_Typography extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Fonts / Typography Settings')
            ->setDescription('Here, you can configure the font settings for the theme on your website. You can also choose to enable the Google Fonts from this section.');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDczHMCNc0JCmJACM86C7L8yYdF9sTvz1A");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($ch);
    curl_close($ch);

    $results = json_decode($data,true);

    $googleFontArray = array();
    foreach($results['items'] as $re) {
      $googleFontArray['"'.$re["family"].'"'] = $re['family'];
    }

    $this->addElement('Select', 'einstaclone_googlefonts', array(
      'label' => 'Choose Fonts',
      'description' => 'Choose from below the Fonts which you want to enable in this theme.',
      'multiOptions' => array(
        '0' => 'Web Safe Font Combinations',
        '1' => 'Google Fonts',
      ),
      'onchange' => "usegooglefont(this.value)",
      'value' => $settings->getSetting('einstaclone.googlefonts', '1'),
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

    $this->addElement('Select', 'einstaclone_body_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_body_fontfamily'),
    ));
    $this->getElement('einstaclone_body_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));



    $this->addElement('Text', 'einstaclone_body_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling. (Enter the size in px.)',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_body_fontsize'),
    ));
    $this->getElement('einstaclone_body_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('einstaclone_body_fontfamily', 'einstaclone_body_fontsize'), 'einstaclone_bodygrp', array('disableLoadDefaultDecorators' => true));
    $einstaclone_bodygrp = $this->getDisplayGroup('einstaclone_bodygrp');
    $einstaclone_bodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'einstaclone_bodygrp'))));


    //Google Font work
    $this->addElement('Select', 'einstaclone_googlebody_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_body_fontfamily'),
    ));
    $this->getElement('einstaclone_googlebody_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'einstaclone_googlebody_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_body_fontsize'),
    ));
    $this->getElement('einstaclone_googlebody_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('einstaclone_googlebody_fontfamily', 'einstaclone_googlebody_fontsize'), 'einstaclone_googlebodygrp', array('disableLoadDefaultDecorators' => true));
    $einstaclone_googlebodygrp = $this->getDisplayGroup('einstaclone_googlebodygrp');
    $einstaclone_googlebodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'einstaclone_googlebodygrp'))));


    //Heading Settings
    $this->addElement('Select', 'einstaclone_heading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_heading_fontfamily'),
    ));
    $this->getElement('einstaclone_heading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'einstaclone_heading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling. (Enter the size in px.)',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_heading_fontsize'),
    ));
    $this->getElement('einstaclone_heading_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('einstaclone_heading_fontfamily', 'einstaclone_heading_fontsize'), 'einstaclone_headinggrp', array('disableLoadDefaultDecorators' => true));
    $einstaclone_headinggrp = $this->getDisplayGroup('einstaclone_headinggrp');
    $einstaclone_headinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'einstaclone_headinggrp'))));


    //Google Font work
    $this->addElement('Select', 'einstaclone_googleheading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_heading_fontfamily'),
    ));
    $this->getElement('einstaclone_googleheading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'einstaclone_googleheading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_heading_fontsize'),
    ));
    $this->getElement('einstaclone_googleheading_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('einstaclone_googleheading_fontfamily', 'einstaclone_googleheading_fontsize'), 'einstaclone_googleheadinggrp', array('disableLoadDefaultDecorators' => true));
    $einstaclone_googleheadinggrp = $this->getDisplayGroup('einstaclone_googleheadinggrp');
    $einstaclone_googleheadinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'einstaclone_googleheadinggrp'))));



    //Main Menu Settings
    $this->addElement('Select', 'einstaclone_mainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_mainmenu_fontfamily'),
    ));
    $this->getElement('einstaclone_mainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));


    $this->addElement('Text', 'einstaclone_mainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling. Enter the size in px.)',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_mainmenu_fontsize'),
    ));
    $this->getElement('einstaclone_mainmenu_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('einstaclone_mainmenu_fontfamily', 'einstaclone_mainmenu_fontsize'), 'einstaclone_mainmenugrp', array('disableLoadDefaultDecorators' => true));
    $einstaclone_mainmenugrp = $this->getDisplayGroup('einstaclone_mainmenugrp');
    $einstaclone_mainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'einstaclone_mainmenugrp'))));

    //Google Font work
    $this->addElement('Select', 'einstaclone_googlemainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_mainmenu_fontfamily'),
    ));
    $this->getElement('einstaclone_googlemainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'einstaclone_googlemainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_mainmenu_fontsize'),
    ));
    $this->getElement('einstaclone_googlemainmenu_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('einstaclone_googlemainmenu_fontfamily', 'einstaclone_googlemainmenu_fontsize'), 'einstaclone_googlemainmenugrp', array('disableLoadDefaultDecorators' => true));
    $einstaclone_googlemainmenugrp = $this->getDisplayGroup('einstaclone_googlemainmenugrp');
    $einstaclone_googlemainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'einstaclone_googlemainmenugrp'))));


    //Tab Settings
    $this->addElement('Select', 'einstaclone_tab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_tab_fontfamily'),
    ));
    $this->getElement('einstaclone_tab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'einstaclone_tab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling. (Enter the size in px.)',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_tab_fontsize'),
    ));
    $this->getElement('einstaclone_tab_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('einstaclone_tab_fontfamily', 'einstaclone_tab_fontsize'), 'einstaclone_tabgrp', array('disableLoadDefaultDecorators' => true));
    $einstaclone_tabgrp = $this->getDisplayGroup('einstaclone_tabgrp');
    $einstaclone_tabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'einstaclone_tabgrp'))));


    //Google Font work
    $this->addElement('Select', 'einstaclone_googletab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_tab_fontfamily'),
    ));
    $this->getElement('einstaclone_googletab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'einstaclone_googletab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_tab_fontsize'),
    ));
    $this->getElement('einstaclone_googletab_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('einstaclone_googletab_fontfamily', 'einstaclone_googletab_fontsize'), 'einstaclone_googletabgrp', array('disableLoadDefaultDecorators' => true));
    $einstaclone_googletabgrp = $this->getDisplayGroup('einstaclone_googletabgrp');
    $einstaclone_googletabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'einstaclone_googletabgrp'))));


    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}
