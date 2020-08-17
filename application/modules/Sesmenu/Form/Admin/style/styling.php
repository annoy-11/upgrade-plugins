<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmenu_Form_Admin_Style_Styling extends Engine_Form
{
  public function init()
  {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Menu Designing')

    ->setAttrib('class', 'global_form_popup')
      ;
	$name = Zend_Controller_Front::getInstance()->getRequest()->getParam('menuName', null);

    $this->addElement('Select', 'sesmenu_menu_style', array(
            'label' => 'Menu Style',
			'description' => 'Choose the style for menus which you want to show in the main navigation menu of your website.',
            'multiOptions' => array('0' => 'Label Only', '1' => 'Icon Only','2' => 'Both'),
            'allowEmpty' => false,
            'required' => false,
            'value' => $settings->getSetting('sesmenu.menu.style'),
    ));
    $this->addElement('Select', 'sesmenu_menu_color', array(
            'label' => 'Menu Color',
			'description' => 'Configure the color for the menus in the main navigation menu of your website.',
			'multiOptions' => array('0' => 'Theme based', '1' => 'Custom'),
            'allowEmpty' => false,
            'required' => false,
			'onchange' => 'StyleSettings(this.value);',
            'value' => $settings->getSetting('sesmenu.menu.color')
    ));
    $this->addElement('Text', 'sesmenu_menu_bgcolor', array(
      'label' => 'Menu Background Color',
      'required' => true,
      'allowEmpty' => false,
      'class' => 'SEScolor',
      'value' => $settings->getSetting('sesmenu.menu.bgcolor')
    ));

    $this->addElement('Text', 'sesmenu_hover_color', array(
      'label' => 'Menu hover color',
      'required' => true,
      'allowEmpty' => false,
      'class' => 'SEScolor',
      'value' => $settings->getSetting('sesmenu.hover.color')
    ));

    $this->addElement('Text', 'sesmenu_font_color', array(
      'label' => 'Menu font color',
      'required' => true,
      'allowEmpty' => false,
      'class' => 'SEScolor',
      'value' => $settings->getSetting('sesmenu.font.color')
    ));

    $this->addElement('Text', 'sesmenu_font_hover_color', array(
      'label' => 'Menu font hover color',
      'required' => true,
      'allowEmpty' => false,
      'class' => 'SEScolor',
      'value' => $settings->getSetting('sesmenu.font.hover.color')
    ));

    $this->addElement('Text', 'sesmenu_content_bgcolor', array(
      'label' => 'Menu content background color',
      'required' => true,
      'allowEmpty' => false,
      'class' => 'SEScolor',
      'value' => $settings->getSetting('sesmenu.content.bgcolor')
    ));
    $this->addElement('Text', 'sesmenu_content_ftcolor', array(
      'label' => 'Menu content font color',
      'required' => true,
      'allowEmpty' => false,
      'class' => 'SEScolor',
      'value' => $settings->getSetting('sesmenu.content.ftcolor')
    ));
    $this->addElement('Text', 'sesmenu_content_highlight_color', array(
      'label' => 'Menu content highlighted color',
      'required' => true,
      'allowEmpty' => false,
      'class' => 'SEScolor',
      'value' => $settings->getSetting('sesmenu.content.highlight.color')
    ));
    $this->addElement('Text', 'sesmenu_content_highlight_ftcolor', array(
      'label' => 'Menu content highlighted font color',
      'required' => true,
      'allowEmpty' => false,
      'class' => 'SEScolor',
      'value' => $settings->getSetting('sesmenu.content.highlight.ftcolor')
    ));
     $this->addDisplayGroup(array('sesmenu_menu_bgcolor','sesmenu_hover_color','sesmenu_font_color', 'sesmenu_font_hover_color','sesmenu_content_bgcolor','sesmenu_content_ftcolor','sesmenu_content_highlight_color','sesmenu_content_highlight_ftcolor'),'costumStyle');

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}
