<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Typography.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagethm_Form_Admin_Typography extends Engine_Form {

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

    $this->addElement('Select', 'sespagethm_googlefonts', array(
      'label' => 'Choose Fonts',
      'description' => 'Choose from below the Fonts which you want to enable in this theme.',
      'multiOptions' => array(
        '0' => 'Web Safe Font Combinations',
        '1' => 'Google Fonts',
      ),
      'onchange' => "usegooglefont(this.value)",
      'value' => $settings->getSetting('sespagethm.googlefonts', 0),
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

    $this->addElement('Select', 'sespagethm_body_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_body_fontfamily'),
    ));
    $this->getElement('sespagethm_body_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));



    $this->addElement('Text', 'sespagethm_body_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_body_fontsize'),
    ));
    $this->getElement('sespagethm_body_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sespagethm_body_fontfamily', 'sespagethm_body_fontsize'), 'sespagethm_bodygrp', array('disableLoadDefaultDecorators' => true));
    $sespagethm_bodygrp = $this->getDisplayGroup('sespagethm_bodygrp');
    $sespagethm_bodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sespagethm_bodygrp'))));


    //Google Font work
    $this->addElement('Select', 'sespagethm_googlebody_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_body_fontfamily'),
    ));
    $this->getElement('sespagethm_googlebody_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sespagethm_googlebody_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_body_fontsize'),
    ));
    $this->getElement('sespagethm_googlebody_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sespagethm_googlebody_fontfamily', 'sespagethm_googlebody_fontsize'), 'sespagethm_googlebodygrp', array('disableLoadDefaultDecorators' => true));
    $sespagethm_googlebodygrp = $this->getDisplayGroup('sespagethm_googlebodygrp');
    $sespagethm_googlebodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sespagethm_googlebodygrp'))));


    //Heading Settings
    $this->addElement('Select', 'sespagethm_heading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_heading_fontfamily'),
    ));
    $this->getElement('sespagethm_heading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sespagethm_heading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_heading_fontsize'),
    ));
    $this->getElement('sespagethm_heading_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sespagethm_heading_fontfamily', 'sespagethm_heading_fontsize'), 'sespagethm_headinggrp', array('disableLoadDefaultDecorators' => true));
    $sespagethm_headinggrp = $this->getDisplayGroup('sespagethm_headinggrp');
    $sespagethm_headinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sespagethm_headinggrp'))));


    //Google Font work
    $this->addElement('Select', 'sespagethm_googleheading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_heading_fontfamily'),
    ));
    $this->getElement('sespagethm_googleheading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sespagethm_googleheading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_heading_fontsize'),
    ));
    $this->getElement('sespagethm_googleheading_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sespagethm_googleheading_fontfamily', 'sespagethm_googleheading_fontsize'), 'sespagethm_googleheadinggrp', array('disableLoadDefaultDecorators' => true));
    $sespagethm_googleheadinggrp = $this->getDisplayGroup('sespagethm_googleheadinggrp');
    $sespagethm_googleheadinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sespagethm_googleheadinggrp'))));



    //Main Menu Settings
    $this->addElement('Select', 'sespagethm_mainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_mainmenu_fontfamily'),
    ));
    $this->getElement('sespagethm_mainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));


    $this->addElement('Text', 'sespagethm_mainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_mainmenu_fontsize'),
    ));
    $this->getElement('sespagethm_mainmenu_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sespagethm_mainmenu_fontfamily', 'sespagethm_mainmenu_fontsize'), 'sespagethm_mainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sespagethm_mainmenugrp = $this->getDisplayGroup('sespagethm_mainmenugrp');
    $sespagethm_mainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sespagethm_mainmenugrp'))));

    //Google Font work
    $this->addElement('Select', 'sespagethm_googlemainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_mainmenu_fontfamily'),
    ));
    $this->getElement('sespagethm_googlemainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sespagethm_googlemainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_mainmenu_fontsize'),
    ));
    $this->getElement('sespagethm_googlemainmenu_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sespagethm_googlemainmenu_fontfamily', 'sespagethm_googlemainmenu_fontsize'), 'sespagethm_googlemainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sespagethm_googlemainmenugrp = $this->getDisplayGroup('sespagethm_googlemainmenugrp');
    $sespagethm_googlemainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sespagethm_googlemainmenugrp'))));


    //Tab Settings
    $this->addElement('Select', 'sespagethm_tab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_tab_fontfamily'),
    ));
    $this->getElement('sespagethm_tab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sespagethm_tab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_tab_fontsize'),
    ));
    $this->getElement('sespagethm_tab_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sespagethm_tab_fontfamily', 'sespagethm_tab_fontsize'), 'sespagethm_tabgrp', array('disableLoadDefaultDecorators' => true));
    $sespagethm_tabgrp = $this->getDisplayGroup('sespagethm_tabgrp');
    $sespagethm_tabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sespagethm_tabgrp'))));


    //Google Font work
    $this->addElement('Select', 'sespagethm_googletab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_tab_fontfamily'),
    ));
    $this->getElement('sespagethm_googletab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sespagethm_googletab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_tab_fontsize'),
    ));
    $this->getElement('sespagethm_googletab_fontsize')->getDecorator('Description')->setOption('escape',false);

    $this->addDisplayGroup(array('sespagethm_googletab_fontfamily', 'sespagethm_googletab_fontsize'), 'sespagethm_googletabgrp', array('disableLoadDefaultDecorators' => true));
    $sespagethm_googletabgrp = $this->getDisplayGroup('sespagethm_googletabgrp');
    $sespagethm_googletabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sespagethm_googletabgrp'))));


    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
