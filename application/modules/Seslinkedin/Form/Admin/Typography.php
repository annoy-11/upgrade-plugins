<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Typography.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslinkedin_Form_Admin_Typography extends Engine_Form {

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

    $this->addElement('Select', 'seslinkedin_googlefonts', array(
      'label' => 'Choose Fonts',
      'description' => 'Choose from below the Fonts which you want to enable in this theme.',
      'multiOptions' => array(
        '0' => 'Web Safe Font Combinations',
        '1' => 'Google Fonts',
      ),
      'onchange' => "usegooglefont(this.value)",
      'value' => $settings->getSetting('seslinkedin.googlefonts', 0),
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

    $this->addElement('Select', 'seslinkedin_body_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_body_fontfamily'),
    ));
    $this->getElement('seslinkedin_body_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));



    $this->addElement('Text', 'seslinkedin_body_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling. (Enter the size in px.)',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_body_fontsize'),
    ));
    $this->getElement('seslinkedin_body_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('seslinkedin_body_fontfamily', 'seslinkedin_body_fontsize'), 'seslinkedin_bodygrp', array('disableLoadDefaultDecorators' => true));
    $seslinkedin_bodygrp = $this->getDisplayGroup('seslinkedin_bodygrp');
    $seslinkedin_bodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'seslinkedin_bodygrp'))));


    //Google Font work
    $this->addElement('Select', 'seslinkedin_googlebody_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_body_fontfamily'),
    ));
    $this->getElement('seslinkedin_googlebody_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'seslinkedin_googlebody_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_body_fontsize'),
    ));
    $this->getElement('seslinkedin_googlebody_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('seslinkedin_googlebody_fontfamily', 'seslinkedin_googlebody_fontsize'), 'seslinkedin_googlebodygrp', array('disableLoadDefaultDecorators' => true));
    $seslinkedin_googlebodygrp = $this->getDisplayGroup('seslinkedin_googlebodygrp');
    $seslinkedin_googlebodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'seslinkedin_googlebodygrp'))));


    //Heading Settings
    $this->addElement('Select', 'seslinkedin_heading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_heading_fontfamily'),
    ));
    $this->getElement('seslinkedin_heading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'seslinkedin_heading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling. (Enter the size in px.)',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_heading_fontsize'),
    ));
    $this->getElement('seslinkedin_heading_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('seslinkedin_heading_fontfamily', 'seslinkedin_heading_fontsize'), 'seslinkedin_headinggrp', array('disableLoadDefaultDecorators' => true));
    $seslinkedin_headinggrp = $this->getDisplayGroup('seslinkedin_headinggrp');
    $seslinkedin_headinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'seslinkedin_headinggrp'))));


    //Google Font work
    $this->addElement('Select', 'seslinkedin_googleheading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_heading_fontfamily'),
    ));
    $this->getElement('seslinkedin_googleheading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'seslinkedin_googleheading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_heading_fontsize'),
    ));
    $this->getElement('seslinkedin_googleheading_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('seslinkedin_googleheading_fontfamily', 'seslinkedin_googleheading_fontsize'), 'seslinkedin_googleheadinggrp', array('disableLoadDefaultDecorators' => true));
    $seslinkedin_googleheadinggrp = $this->getDisplayGroup('seslinkedin_googleheadinggrp');
    $seslinkedin_googleheadinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'seslinkedin_googleheadinggrp'))));



    //Main Menu Settings
    $this->addElement('Select', 'seslinkedin_mainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_mainmenu_fontfamily'),
    ));
    $this->getElement('seslinkedin_mainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));


    $this->addElement('Text', 'seslinkedin_mainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling. Enter the size in px.)',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_mainmenu_fontsize'),
    ));
    $this->getElement('seslinkedin_mainmenu_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('seslinkedin_mainmenu_fontfamily', 'seslinkedin_mainmenu_fontsize'), 'seslinkedin_mainmenugrp', array('disableLoadDefaultDecorators' => true));
    $seslinkedin_mainmenugrp = $this->getDisplayGroup('seslinkedin_mainmenugrp');
    $seslinkedin_mainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'seslinkedin_mainmenugrp'))));

    //Google Font work
    $this->addElement('Select', 'seslinkedin_googlemainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_mainmenu_fontfamily'),
    ));
    $this->getElement('seslinkedin_googlemainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'seslinkedin_googlemainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_mainmenu_fontsize'),
    ));
    $this->getElement('seslinkedin_googlemainmenu_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('seslinkedin_googlemainmenu_fontfamily', 'seslinkedin_googlemainmenu_fontsize'), 'seslinkedin_googlemainmenugrp', array('disableLoadDefaultDecorators' => true));
    $seslinkedin_googlemainmenugrp = $this->getDisplayGroup('seslinkedin_googlemainmenugrp');
    $seslinkedin_googlemainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'seslinkedin_googlemainmenugrp'))));


    //Tab Settings
    $this->addElement('Select', 'seslinkedin_tab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_tab_fontfamily'),
    ));
    $this->getElement('seslinkedin_tab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'seslinkedin_tab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling. (Enter the size in px.)',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_tab_fontsize'),
    ));
    $this->getElement('seslinkedin_tab_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('seslinkedin_tab_fontfamily', 'seslinkedin_tab_fontsize'), 'seslinkedin_tabgrp', array('disableLoadDefaultDecorators' => true));
    $seslinkedin_tabgrp = $this->getDisplayGroup('seslinkedin_tabgrp');
    $seslinkedin_tabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'seslinkedin_tabgrp'))));


    //Google Font work
    $this->addElement('Select', 'seslinkedin_googletab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_tab_fontfamily'),
    ));
    $this->getElement('seslinkedin_googletab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'seslinkedin_googletab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_tab_fontsize'),
    ));
    $this->getElement('seslinkedin_googletab_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('seslinkedin_googletab_fontfamily', 'seslinkedin_googletab_fontsize'), 'seslinkedin_googletabgrp', array('disableLoadDefaultDecorators' => true));
    $seslinkedin_googletabgrp = $this->getDisplayGroup('seslinkedin_googletabgrp');
    $seslinkedin_googletabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'seslinkedin_googletabgrp'))));


    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
