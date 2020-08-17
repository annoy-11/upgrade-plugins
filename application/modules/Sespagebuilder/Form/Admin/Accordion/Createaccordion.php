<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Createaccordion.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Accordion_Createaccordion extends Engine_Form {

  public function init() {

    $this->setTitle('Create New Accordion Menu')->setDescription('Here, create a new Accordion Menu for menu and choose to display it as shortcode or not. If you do not want to display it as shortcode, then you can choose this menu in the widget and place it on desired widgetized page in Layout Editor.');

    $this->addElement('Text', 'title', array(
        'label' => 'Menu Name',
        'description' => 'Enter the name of the menu. This name is for your indication only and will not be shown at user side.',
        'allowEmpty' => false,
        'required' => true,
        'filters' => array(
            new Engine_Filter_Censor(),
            'StripTags',
            new Engine_Filter_StringLength(array('max' => '250'))
        ),
        'autofocus' => 'autofocus',
    ));

    $this->addElement('Radio', 'show_short_code', array(
        'label' => "Use As Short Code",
        'description' => "Do you want to use this as a short code? [Note: If you choose “Yes”, then you will be able to configure various design settings.]",
        'multioptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => 0,
        'onclick' => "showSettings(this.value);",
    ));

    $this->addElement('Text', 'accTabBgColor', array(
        'label' => 'Accordion Tab Background Color',
        'description' => 'Accordion Tab Background Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));
    $this->getElement('accTabBgColor')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'accTabTextColor', array(
        'label' => 'Accordion Tab Text Color',
        'description' => 'Accordion Tab Text Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));
    $this->getElement('accTabTextColor')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'accTabTextFontSize', array(
        'label' => "Accordion Tab Text Font Size",
        'value' => '14'
    ));

    $this->addElement('Text', 'subaccTabBgColor', array(
        'label' => 'Sub Accordion Tab Background Color',
        'description' => 'Sub Accordion Tab Background Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));
    $this->getElement('subaccTabBgColor')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'subaccTabTextColor', array(
        'label' => 'Sub Accordion Tab Text Color',
        'description' => 'Sub Accordion Tab Text Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));
    $this->getElement('subaccTabTextColor')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'subaccTabTextFontSize', array(
        'label' => "Sub Accordion Tab Text Font Size",
        'value' => '14',
    ));

    $this->addElement('Radio', 'show_accordian', array(
        'label' => 'Show Accordion Horizontal or Vertical',
        'multiOptions' => array(
            '0' => 'Horiontal',
            '1' => 'Vertical',
        ),
        'value' => 1,
    ));

    $this->addElement('Radio', 'subaccorImage', array(
        'label' => 'Show Sub Accordion Icon or Bullet',
        'multiOptions' => array(
            '0' => 'Bullet',
            '1' => 'Image Icon (Uploaded from admin area)',
        ),
        'value' => 1,
    ));

    $this->addElement('Radio', 'accorImage', array(
        'label' => 'Show Accordion Icon',
        'multiOptions' => array(
            '0' => 'No',
            '1' => 'Yes',
        ),
        'value' => 1,
    ));

    $this->addElement('Text', 'width', array(
        'label' => "Enter the width of widget(in px).",
        'value' => '100',
    ));

    // Add submit button
    $this->addElement('Button', 'save', array(
        'label' => 'Save',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Save & Exit',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('save', 'submit', 'cancel'), 'buttons');
  }

}
