<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: MenuGeneric.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_MenuGeneric extends Core_Form_Admin_Widget_Standard {

  public function init() {

    parent::init();

    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');

    // Set form attributes
    $this->setTitle('Advanced Generic Menu')
            ->setDescription('Please choose a menu.');

    // Element: name
    $this->addElement('Select', 'menu', array(
        'label' => 'Menu',
    ));

    foreach (Engine_Api::_()->getDbtable('menus', 'core')->fetchAll() as $menu) {
      $this->menu->addMultiOption($menu->name, $menu->title);
    }

    $this->addElement('Radio', 'show_type', array(
        'label' => 'View Type',
        'multiOptions' => array(
            '0' => 'Horizontal',
            '1' => 'Vertical',
        ),
        'value' => 0,
    ));

    $this->addElement('Radio', 'show_menu', array(
        'label' => 'What do you want to show when users mouse-over on Menu Item? This setting will only work, if you choose "Main Navigation Men" to be shown in this widget.',
        'multiOptions' => array(
            '0' => 'Categories',
            '1' => 'Sub Menu',
            '2' => 'Do not show anything',
        ),
        'value' => 0,
    ));

    $this->addElement('Radio', 'show_menu_icon', array(
        'label' => 'Do you want to show arrow icon in navigation dropdown?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => 1,
    ));

    $this->addElement('Text', 'menuname', array(
        'label' => 'Menu Name',
        'description' => 'Enter a desired menu name (default: Explore)',
        'value' => 'Explore',
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Select', 'menucount', array(
        'label' => 'Menu Count',
        'description' => 'How many menu items before dropdown menu occurs?',
        'multiOptions' => array(
            0 => '',
            1 => '1 Item',
            2 => '2 Items',
            3 => '3 Items',
            4 => '4 Items',
            5 => '5 Items',
            6 => '6 Items',
            7 => '7 Items',
            8 => '8 Items',
            9 => '9 Items',
            10 => '10 Items',
            11 => '11 Items',
            12 => '12 Items',
        ),
        'value' => 6,
    ));

    $this->addElement('Radio', 'customcolor', array(
        'label' => 'Do you want your own custom colors for this widget?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No, I want Theme based colors.',
        ),
        'value' => 0,
    ));

    $this->addElement('Text', 'menuBgColor', array(
        'label' => 'Menu Background Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'menuBorderColor', array(
        'label' => 'Menu Border Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'menuTextColor', array(
        'label' => 'Menu Text Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'menuHoverBgColor', array(
        'label' => 'Menu Hover Background Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'menuHoverTextColor', array(
        'label' => 'Menu Hover Text Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'menuTextFontSize', array(
        'label' => "Menu Text Font Size",
        'value' => '14',
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Radio', 'show', array(
        'label' => 'Choose the users who all can view this widget.',
        'multiOptions' => array(
            '0' => 'Only non-logged-in users',
            '1' => 'Only logged-in users',
            '2' => 'Both - non-logged-in and logged-in users',
        ),
        'value' => 2,
    ));
  }

}
