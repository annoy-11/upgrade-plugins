<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Form_Admin_Category_Edit extends Engine_Form
{
  public function init()
  {
    parent::init();
    $this->setTitle('Edit Category');

    // Element: title
    $this->addElement('Text', 'title', array(
      'label' => 'Category Title',
      'required' => true,
      'allowEmpty' => false,
    ));

    $this->addElement('Text', 'title', array(
      'label' => 'Category Title',
      'required' => true,
      'id'=>'tag-name',
      'allowEmpty' => false,
    ));

    $this->addElement('Text', 'slug', array(
        'label' => 'Slug',
        'allowEmpty' => false,
        'id'=>'tag-slug',
        'required' => true,
    ));


    $this->addElement('Text', 'description', array(
      'label' => 'Category Description'
    ));

    $this->addElement('File', 'cat_icon', array(
      'label' => 'Category Icon (The icon will be resized to 48px * 48px)'
    ));

    // View Privacy Setting
    $levelOptions = array();
    //$levelOptions[''] = 'Everyone';
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
        $levelOptions[$level->level_id] = $level->getTitle();
    }
    $this->addElement('Multiselect', 'privacy', array(
        'label' => 'Who can view this category',
        'description' => 'Choose the member levels to which this category will be displayed. (Ctrl + Click to select multiple member levels.)',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions' => $levelOptions,
        'value' => array_keys($levelOptions),
    ));

    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    // Element: cancel
    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onClick'=> 'javascript:parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }
}
