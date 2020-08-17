<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ItemCreate.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmenu_Form_Admin_Menu_ItemCreate extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Create Menu Item')
      ->setAttrib('class', 'global_form_popup')
      ;

    $this->addElement('Text', 'label', array(
      'label' => 'Label',
	  'description' => 'Enter the Label for the menu item.',
      'required' => true,
      'allowEmpty' => false,
    ));

    $this->addElement('Text', 'uri', array(
      'label' => 'URL',
	  'description' => 'Enter the URL for the menu on which users get redirected after clicking.',
      'required' => true,
      'allowEmpty' => false,
      'style' => 'width: 300px',
      //'validators' => array(
      //  array('NotEmpty', true),
      //)
    ));

    $this->addElement('Text', 'icon', array(
      'label' => 'Icon / Icon Class (Note: Not all menus support icons.)',
	  'description' => 'Enter the Icon class for the menu.',
      'style' => 'width: 500px',
    ));

    $this->addElement('Checkbox', 'target', array(
      'label' => 'Open in a new window?',
      'checkedValue' => '_blank',
      'uncheckedValue' => '',
    ));

    $this->addElement('Checkbox', 'enabled', array(
      'label' => 'Enabled?',
      'checkedValue' => '1',
      'uncheckedValue' => '0',
      'value' => '1',
    ));
    $levelOptions = array();
    $levelOptions[''] = 'Everyone';
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
        $levelOptions[$level->level_id] = $level->getTitle();
    }
    $this->addElement('Multiselect', 'privacy', array(
        'label' => 'Member Level View Privacy',
        'description' => 'Choose the member levels to which this menu will be displayed. (Press Ctrl + Click to select multiple member levels.)',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions' => $levelOptions,
        'value' => '',
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Create Menu Item',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}
