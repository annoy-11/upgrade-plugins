<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Typography.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Form_Admin_Typography extends Engine_Form {

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

    $this->addElement('Select', 'sesytube_googlefonts', array(
      'label' => 'Choose Fonts',
      'description' => 'Choose from below the Fonts which you want to enable in this theme.',
      'multiOptions' => array(
        '0' => 'Web Safe Font Combinations',
        '1' => 'Google Fonts',
      ),
      'onchange' => "usegooglefont(this.value)",
      'value' => $settings->getSetting('sesytube.googlefonts', 0),
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

    $this->addElement('Select', 'sesytube_body_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_body_fontfamily'),
    ));
    $this->getElement('sesytube_body_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesytube_body_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_body_fontsize'),
    ));
    $this->getElement('sesytube_body_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesytube_body_fontfamily', 'sesytube_body_fontsize'), 'sesytube_bodygrp', array('disableLoadDefaultDecorators' => true));
    $sesytube_bodygrp = $this->getDisplayGroup('sesytube_bodygrp');
    $sesytube_bodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesytube_bodygrp'))));

    //Google Font work
    $this->addElement('Select', 'sesytube_googlebody_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_body_fontfamily'),
    ));
    $this->getElement('sesytube_googlebody_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesytube_googlebody_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_body_fontsize'),
    ));
    $this->getElement('sesytube_googlebody_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesytube_googlebody_fontfamily', 'sesytube_googlebody_fontsize'), 'sesytube_googlebodygrp', array('disableLoadDefaultDecorators' => true));
    $sesytube_googlebodygrp = $this->getDisplayGroup('sesytube_googlebodygrp');
    $sesytube_googlebodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesytube_googlebodygrp'))));


    //Heading Settings
    $this->addElement('Select', 'sesytube_heading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_heading_fontfamily'),
    ));
    $this->getElement('sesytube_heading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesytube_heading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_heading_fontsize'),
    ));
    $this->getElement('sesytube_heading_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesytube_heading_fontfamily', 'sesytube_heading_fontsize'), 'sesytube_headinggrp', array('disableLoadDefaultDecorators' => true));
    $sesytube_headinggrp = $this->getDisplayGroup('sesytube_headinggrp');
    $sesytube_headinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesytube_headinggrp'))));


    //Google Font work
    $this->addElement('Select', 'sesytube_googleheading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_heading_fontfamily'),
    ));
    $this->getElement('sesytube_googleheading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesytube_googleheading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_heading_fontsize'),
    ));
    $this->getElement('sesytube_googleheading_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesytube_googleheading_fontfamily', 'sesytube_googleheading_fontsize'), 'sesytube_googleheadinggrp', array('disableLoadDefaultDecorators' => true));
    $sesytube_googleheadinggrp = $this->getDisplayGroup('sesytube_googleheadinggrp');
    $sesytube_googleheadinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesytube_googleheadinggrp'))));

    //Main Menu Settings
    $this->addElement('Select', 'sesytube_mainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_mainmenu_fontfamily'),
    ));
    $this->getElement('sesytube_mainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));


    $this->addElement('Text', 'sesytube_mainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_mainmenu_fontsize'),
    ));
    $this->getElement('sesytube_mainmenu_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesytube_mainmenu_fontfamily', 'sesytube_mainmenu_fontsize'), 'sesytube_mainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sesytube_mainmenugrp = $this->getDisplayGroup('sesytube_mainmenugrp');
    $sesytube_mainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesytube_mainmenugrp'))));

    //Google Font work
    $this->addElement('Select', 'sesytube_googlemainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_mainmenu_fontfamily'),
    ));
    $this->getElement('sesytube_googlemainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesytube_googlemainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_mainmenu_fontsize'),
    ));
    $this->getElement('sesytube_googlemainmenu_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesytube_googlemainmenu_fontfamily', 'sesytube_googlemainmenu_fontsize'), 'sesytube_googlemainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sesytube_googlemainmenugrp = $this->getDisplayGroup('sesytube_googlemainmenugrp');
    $sesytube_googlemainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesytube_googlemainmenugrp'))));


    //Tab Settings
    $this->addElement('Select', 'sesytube_tab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_tab_fontfamily'),
    ));
    $this->getElement('sesytube_tab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesytube_tab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_tab_fontsize'),
    ));
    $this->getElement('sesytube_tab_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesytube_tab_fontfamily', 'sesytube_tab_fontsize'), 'sesytube_tabgrp', array('disableLoadDefaultDecorators' => true));
    $sesytube_tabgrp = $this->getDisplayGroup('sesytube_tabgrp');
    $sesytube_tabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesytube_tabgrp'))));


    //Google Font work
    $this->addElement('Select', 'sesytube_googletab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_tab_fontfamily'),
    ));
    $this->getElement('sesytube_googletab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesytube_googletab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_tab_fontsize'),
    ));
    $this->getElement('sesytube_googletab_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sesytube_googletab_fontfamily', 'sesytube_googletab_fontsize'), 'sesytube_googletabgrp', array('disableLoadDefaultDecorators' => true));
    $sesytube_googletabgrp = $this->getDisplayGroup('sesytube_googletabgrp');
    $sesytube_googletabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesytube_googletabgrp'))));


    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}
