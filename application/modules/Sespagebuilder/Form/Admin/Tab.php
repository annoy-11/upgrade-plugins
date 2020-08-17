<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tab.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Tab extends Engine_Form {

  public function init() {

    $tabs_array[] = '';
    $tabs = Engine_Api::_()->getItemTable('sespagebuilder_tab')->getTabs(array('column_name' => array('name', 'tab_id')));
    foreach ($tabs as $tab) {
      $tabs_array[$tab['tab_id']] = $tab['name'];
    }

    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');


    $this->addElement('Select', 'tabName', array(
        'label' => 'Choose content to be shown in this widget.',
        'multiOptions' => $tabs_array,
    ));

    $this->addElement('Radio', 'showViewType', array(
        'label' => 'Choose from below how do you want to display the selected content in this widget.',
        'multiOptions' => array(
            '0' => 'Tab',
            '1' => 'Simple Accordion',
            '2' => 'Fixed Accordion',
        ),
        'value' => '0',
    ));

    $this->addElement('Text', 'height', array(
        'label' => 'Enter the height(in px). [This setting will apply only on Simple and Fixed Accordions].',
    ));
    $this->getElement('height')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Radio', 'customcolor', array(
        'label' => 'Do you want your own custom colors for this widget?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No, I want Theme based colors',
        ),
        'value' => 0,
    ));

    $this->addElement('Text', 'headingBgColor', array(
        'label' => 'Tabs Heading Background Color. [This setting will apply on Tabs only.]',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'descriptionBgColor', array(
        'label' => 'Accordion / tab description background color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'tabBgColor', array(
        'label' => 'Inactive accordion / tab background color',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'tabActiveBgColor', array(
        'label' => 'Active accordion / tab background color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'tabTextBgColor', array(
        'label' => 'Text background color of active  accordion / tab .',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'tabActiveTextColor', array(
        'label' => 'Text color of active accordion / tab.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'tabTextFontSize', array(
        'label' => "Font Size of accordion / tab text.",
        'value' => '14',
    ));

    $this->addElement('Text', 'width', array(
        'label' => "Enter the width of this widget(in pixels).",
        'value' => '100',
    ));
  }

}
